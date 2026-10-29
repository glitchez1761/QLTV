<?php
class LibraryCard {
    private PDO $db;

    public function __construct(?PDO $db = null) {
        $this->db = $db ?? Database::getConnection();
    }

    public function findById(int $cardId): ?array {
        $stmt = $this->db->prepare(
            'SELECT t.*, d.ho_ten, d.ngay_sinh, d.doi_tuong_mien_phi, d.so_dien_thoai
             FROM the_doc_gia t JOIN doc_gia d ON d.reader_id = t.reader_id
             WHERE t.card_id = ?'
        );
        $stmt->execute([$cardId]);
        $card = $stmt->fetch();
        return $card ?: null;
    }

    public function findByNumber(string $cardNumber): ?array {
        $stmt = $this->db->prepare('SELECT * FROM the_doc_gia WHERE ma_the = ? LIMIT 1');
        $stmt->execute([$cardNumber]);
        $card = $stmt->fetch();
        return $card ?: null;
    }

    public function all(string $keyword = ''): array {
        $stmt = $this->db->prepare(
            'SELECT t.*, d.ho_ten, d.so_dien_thoai
             FROM the_doc_gia t JOIN doc_gia d ON d.reader_id = t.reader_id
             WHERE (? = \'\' OR t.ma_the LIKE ? OR d.ho_ten LIKE ? OR d.so_dien_thoai LIKE ?)
             ORDER BY t.card_id DESC'
        );
        $term = '%' . $keyword . '%';
        $stmt->execute([$keyword, $term, $term, $term]);
        return $stmt->fetchAll();
    }

    public function forAccount(int $accountId): array {
        $stmt = $this->db->prepare(
            'SELECT t.*, d.ho_ten FROM the_doc_gia t
             JOIN doc_gia d ON d.reader_id = t.reader_id
             WHERE d.account_id = ? ORDER BY t.card_id DESC'
        );
        $stmt->execute([$accountId]);
        return $stmt->fetchAll();
    }

    public function cancel(int $cardId, string $reason, int $staffId): bool {
        $stmt = $this->db->prepare(
            "UPDATE the_doc_gia
             SET trang_thai = 'BI_HUY', ngay_huy = NOW(), ly_do_huy = ?, huy_boi_staff_id = ?
             WHERE card_id = ? AND trang_thai <> 'BI_HUY'"
        );
        $stmt->execute([$reason, $staffId, $cardId]);
        return $stmt->rowCount() === 1;
    }
}
