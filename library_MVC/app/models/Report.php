<?php
class Report {
    private PDO $db;

    public function __construct(?PDO $db = null) {
        $this->db = $db ?? Database::getConnection();
    }

    public function save(string $type, string $from, string $to, int $newCards, ?int $staffId, array $revenue): int {
        $stmt = $this->db->prepare(
            'INSERT INTO bao_cao_thong_ke
             (staff_id, loai_bao_cao, tu_ngay, den_ngay, so_the_moi,
              doanh_thu_the, doanh_thu_goi, doanh_thu_vi_pham)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $staffId, $type, $from, $to, $newCards,
            $revenue['card_fee'] ?? 0, $revenue['package_fee'] ?? 0, $revenue['fine_fee'] ?? 0,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function saveBookDetails(int $reportId, array $rows): void {
        $stmt = $this->db->prepare(
            'INSERT INTO ct_bao_cao_sach (report_id, book_id, so_luot_muon) VALUES (?, ?, ?)'
        );
        foreach ($rows as $row) {
            $stmt->execute([$reportId, (int)$row['book_id'], (int)$row['borrow_count']]);
        }
    }

    public function findById(int $reportId): ?array {
        $stmt = $this->db->prepare('SELECT * FROM bao_cao_thong_ke WHERE report_id = ?');
        $stmt->execute([$reportId]);
        $report = $stmt->fetch();
        return $report ?: null;
    }

    public function history(): array {
        return $this->db->query(
            'SELECT r.*, n.ho_ten AS staff_name
             FROM bao_cao_thong_ke r LEFT JOIN nhan_vien n ON n.staff_id = r.staff_id
             ORDER BY r.ngay_tao DESC LIMIT 100'
        )->fetchAll();
    }
}
