<?php
class LoanPackage {
    private PDO $db;

    public function __construct(?PDO $db = null) {
        $this->db = $db ?? Database::getConnection();
    }

    public function activeAll(): array {
        return $this->db->query(
            "SELECT * FROM goi_muon WHERE trang_thai = 'HOAT_DONG' ORDER BY phi_nam"
        )->fetchAll();
    }

    public function findById(int $packageId): ?array {
        $stmt = $this->db->prepare('SELECT * FROM goi_muon WHERE package_id = ?');
        $stmt->execute([$packageId]);
        $package = $stmt->fetch();
        return $package ?: null;
    }

    public function register(int $cardId, int $packageId, string $paymentMethod): int {
        if (!in_array($paymentMethod, ['TIEN_MAT', 'QR', 'VI_DIEN_TU', 'THE_NGAN_HANG'], true)) {
            throw new InvalidArgumentException('Phương thức thanh toán không hợp lệ.');
        }
        $this->db->beginTransaction();
        try {
            $cardStmt = $this->db->prepare(
                "SELECT card_id FROM the_doc_gia
                 WHERE card_id = ? AND trang_thai = 'HOAT_DONG' AND ngay_het_han >= CURDATE()
                 FOR UPDATE"
            );
            $cardStmt->execute([$cardId]);
            if (!$cardStmt->fetch()) {
                throw new RuntimeException('Thẻ độc giả không hoạt động hoặc đã hết hạn.');
            }

            $existingStmt = $this->db->prepare(
                "SELECT registration_id FROM dang_ky_goi_muon
                 WHERE card_id = ? AND trang_thai = 'DANG_HIEU_LUC' AND ngay_het_han >= CURDATE()
                 LIMIT 1 FOR UPDATE"
            );
            $existingStmt->execute([$cardId]);
            if ($existingStmt->fetch()) {
                throw new RuntimeException('Thẻ đang có gói mượn còn hiệu lực.');
            }

            $packageStmt = $this->db->prepare(
                "SELECT * FROM goi_muon WHERE package_id = ? AND trang_thai = 'HOAT_DONG'"
            );
            $packageStmt->execute([$packageId]);
            $package = $packageStmt->fetch();
            if (!$package) {
                throw new RuntimeException('Gói mượn không tồn tại hoặc đã ngừng phục vụ.');
            }

            $insert = $this->db->prepare(
                "INSERT INTO dang_ky_goi_muon
                 (card_id, package_id, ngay_hieu_luc, ngay_het_han, so_tien, hinh_thuc_thanh_toan)
                 VALUES (?, ?, CURDATE(), DATE_ADD(CURDATE(), INTERVAL ? MONTH), ?, ?)"
            );
            $insert->execute([
                $cardId, $packageId, (int)$package['hieu_luc_thang'],
                (float)$package['phi_nam'], $paymentMethod,
            ]);
            $registrationId = (int)$this->db->lastInsertId();
            $this->db->commit();
            return $registrationId;
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }
}
