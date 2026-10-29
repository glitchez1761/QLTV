<?php
class Violation {
    private PDO $db;

    public function __construct(?PDO $db = null) {
        $this->db = $db ?? Database::getConnection();
    }

    public function outstanding(string $keyword = ''): array {
        $stmt = $this->db->prepare(
            "SELECT v.*, p.ma_phieu_muon, t.ma_the, d.ho_ten, b.ten_sach, c.ma_tai_lieu
             FROM vi_pham v
             JOIN ct_phieu_muon ct ON ct.loan_detail_id = v.loan_detail_id
             JOIN phieu_muon p ON p.loan_id = ct.loan_id
             JOIN the_doc_gia t ON t.card_id = p.card_id
             JOIN doc_gia d ON d.reader_id = t.reader_id
             JOIN cuon_sach c ON c.copy_id = ct.copy_id
             JOIN dau_sach b ON b.book_id = c.book_id
             WHERE v.trang_thai = 'CHUA_HOAN_TAT'
               AND (? = '' OR d.ho_ten LIKE ? OR t.ma_the LIKE ? OR p.ma_phieu_muon LIKE ?)
             ORDER BY v.ngay_xu_ly DESC"
        );
        $term = '%' . $keyword . '%';
        $stmt->execute([$keyword, $term, $term, $term]);
        return $stmt->fetchAll();
    }

    public function markPaid(int $violationId): bool {
        $stmt = $this->db->prepare(
            "UPDATE vi_pham SET trang_thai = 'DA_XU_LY', trang_thai_thanh_toan = 'DA_THANH_TOAN'
             WHERE violation_id = ? AND trang_thai = 'CHUA_HOAN_TAT'"
        );
        $stmt->execute([$violationId]);
        return $stmt->rowCount() === 1;
    }

    public function reminders(): array {
        return $this->db->query(
            "SELECT r.*, COUNT(c.reminder_detail_id) AS so_dau_sach
             FROM phieu_nhac_nho r LEFT JOIN ct_nhac_nho c ON c.reminder_id = r.reminder_id
             GROUP BY r.reminder_id ORDER BY r.ngay_lap DESC"
        )->fetchAll();
    }
}
