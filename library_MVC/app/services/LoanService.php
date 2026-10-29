<?php
// app/services/LoanService.php
class LoanService {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function borrowBooks(string $cardCode, array $copyCodes, int $staffId): array {
        $copyCodes = array_values(array_filter(array_map('trim', $copyCodes)));
        if ($cardCode === '' || $copyCodes === [] || $staffId < 1) {
            return ['status' => false, 'message' => 'Vui lòng nhập mã thẻ, ít nhất một mã tài liệu và nhân viên hợp lệ.'];
        }
        if (count(array_unique(array_map('strtolower', $copyCodes))) !== count($copyCodes)) {
            return ['status' => false, 'message' => 'Danh sách mã tài liệu có mã bị trùng.'];
        }
        $this->db->beginTransaction();
        try {
            // 1. Kiểm tra thẻ & độc giả
            $stmt = $this->db->prepare("SELECT card_id, trang_thai, ngay_het_han FROM the_doc_gia WHERE ma_the = ? FOR UPDATE");
            $stmt->execute([$cardCode]);
            $card = $stmt->fetch();

            if (!$card || $card['trang_thai'] !== 'HOAT_DONG' || $card['ngay_het_han'] < date('Y-m-d')) {
                throw new Exception("Thẻ độc giả không hợp lệ hoặc đã hết hạn");
            }

            // 2. Kiểm tra gói mượn còn hạn
            $pkgStmt = $this->db->prepare("
                SELECT d.registration_id, g.so_tai_lieu_toi_da, g.tong_gia_tri_toi_da,
                       g.thoi_han_muon_ngay
                FROM dang_ky_goi_muon d
                JOIN goi_muon g ON d.package_id = g.package_id
                WHERE d.card_id = ? AND d.trang_thai = 'DANG_HIEU_LUC' AND d.ngay_het_han >= CURDATE()
                ORDER BY d.registration_id DESC LIMIT 1
            ");
            $pkgStmt->execute([$card['card_id']]);
            $package = $pkgStmt->fetch();

            if (!$package) {
                throw new Exception("Độc giả chưa đăng ký gói mượn hoặc gói đã hết hiệu lực");
            }

            $activeStmt = $this->db->prepare(
                "SELECT COUNT(*) AS item_count, COALESCE(SUM(b.gia_nhap), 0) AS total_value
                 FROM ct_phieu_muon ct
                 JOIN phieu_muon p ON p.loan_id = ct.loan_id
                 JOIN cuon_sach c ON c.copy_id = ct.copy_id
                 JOIN dau_sach b ON b.book_id = c.book_id
                 WHERE p.card_id = ? AND ct.trang_thai = 'DANG_MUON'"
            );
            $activeStmt->execute([$card['card_id']]);
            $activeLoans = $activeStmt->fetch();
            if ((int)$activeLoans['item_count'] + count($copyCodes) > (int)$package['so_tai_lieu_toi_da']) {
                throw new Exception("Vượt quá số sách tối đa được mượn của gói (" . $package['so_tai_lieu_toi_da'] . " cuốn)");
            }

            $copies = [];
            $totalBookPrice = 0.0;
            foreach ($copyCodes as $code) {
                $cStmt = $this->db->prepare("
                    SELECT c.copy_id, c.trang_thai, d.gia_nhap, d.ten_sach 
                    FROM cuon_sach c 
                    JOIN dau_sach d ON c.book_id = d.book_id 
                    WHERE c.ma_tai_lieu = ? FOR UPDATE
                ");
                $cStmt->execute([$code]);
                $copy = $cStmt->fetch();

                if (!$copy || $copy['trang_thai'] !== 'CON_TRONG_KHO') {
                    throw new Exception("Sách '{$code}' không có sẵn trong kho để mượn");
                }
                $copies[] = $copy;
                $totalBookPrice += (float)$copy['gia_nhap'];
            }

            if ((float)$activeLoans['total_value'] + $totalBookPrice > (float)$package['tong_gia_tri_toi_da']) {
                throw new Exception("Tổng giá trị sách (" . number_format($totalBookPrice) . "đ) vượt quá hạn mức gói");
            }

            // 4. Lưu phiếu mượn
            $loanCode = 'PM' . date('YmdHis') . rand(10, 99);
            $loanStmt = $this->db->prepare("
                INSERT INTO phieu_muon (ma_phieu_muon, card_id, package_registration_id, staff_id, tong_so_tai_lieu, tong_gia_tri_tai_lieu, trang_thai) 
                VALUES (?, ?, ?, ?, ?, ?, 'DANG_MUON')
            ");
            $loanStmt->execute([$loanCode, $card['card_id'], $package['registration_id'], $staffId, count($copies), $totalBookPrice]);
            $loanId = $this->db->lastInsertId();

            // 5. Lưu chi tiết phiếu mượn & cập nhật trạng thái cuốn sách
            $borrowDays = max(1, (int)$package['thoi_han_muon_ngay']);
            $dueDate = date('Y-m-d', strtotime('+' . $borrowDays . ' days'));
            $itemStmt = $this->db->prepare("INSERT INTO ct_phieu_muon (loan_id, copy_id, han_tra, trang_thai) VALUES (?, ?, ?, 'DANG_MUON')");
            $updCopy = $this->db->prepare("UPDATE cuon_sach SET trang_thai = 'DANG_DUOC_MUON' WHERE copy_id = ?");

            foreach ($copies as $c) {
                $itemStmt->execute([$loanId, $c['copy_id'], $dueDate]);
                $updCopy->execute([$c['copy_id']]);
            }

            $this->db->commit();
            return ['status' => true, 'message' => "Lập phiếu mượn thành công. Mã: {$loanCode}"];
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function renewLoan(int $loanDetailId, int $staffId): array {
        if ($loanDetailId < 1 || $staffId < 1) {
            return ['status' => false, 'message' => 'Thông tin gia hạn không hợp lệ.'];
        }
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare(
                "SELECT ct.han_tra, ct.so_lan_gia_han, g.thoi_han_muon_ngay
                 FROM ct_phieu_muon ct
                 JOIN phieu_muon p ON p.loan_id = ct.loan_id
                 JOIN dang_ky_goi_muon r ON r.registration_id = p.package_registration_id
                 JOIN goi_muon g ON g.package_id = r.package_id
                 WHERE ct.loan_detail_id = ? AND ct.trang_thai = 'DANG_MUON'
                 FOR UPDATE"
            );
            $stmt->execute([$loanDetailId]);
            $item = $stmt->fetch();
            if (!$item) {
                throw new RuntimeException('Không tìm thấy tài liệu đang mượn để gia hạn.');
            }
            if ((int)$item['so_lan_gia_han'] >= 1) {
                throw new RuntimeException('Mỗi tài liệu chỉ được gia hạn một lần.');
            }
            if ($item['han_tra'] < date('Y-m-d')) {
                throw new RuntimeException('Tài liệu đã quá hạn, không thể gia hạn.');
            }
            $renewalDays = max(1, (int)$item['thoi_han_muon_ngay']);
            $newDueDate = date('Y-m-d', strtotime($item['han_tra'] . ' +' . $renewalDays . ' days'));
            $history = $this->db->prepare(
                'INSERT INTO lich_su_gia_han_muon (loan_detail_id, staff_id, han_tra_cu, han_tra_moi)
                 VALUES (?, ?, ?, ?)'
            );
            $history->execute([$loanDetailId, $staffId, $item['han_tra'], $newDueDate]);
            $update = $this->db->prepare(
                'UPDATE ct_phieu_muon SET han_tra = ?, so_lan_gia_han = so_lan_gia_han + 1
                 WHERE loan_detail_id = ?'
            );
            $update->execute([$newDueDate, $loanDetailId]);
            $this->db->commit();
            return ['status' => true, 'message' => 'Gia hạn thành công đến ngày ' . $newDueDate . '.'];
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}