<?php
class Loan {
    private PDO $db;

    public function __construct(?PDO $db = null) {
        $this->db = $db ?? Database::getConnection();
    }

    public function activeLoans(string $keyword = ''): array {
        $stmt = $this->db->prepare(
            "SELECT ct.loan_detail_id, ct.han_tra, ct.so_lan_gia_han, ct.trang_thai AS item_status,
                    p.loan_id, p.ma_phieu_muon, p.ngay_muon, t.ma_the, d.ho_ten,
                    c.ma_tai_lieu, b.ten_sach
             FROM ct_phieu_muon ct
             JOIN phieu_muon p ON p.loan_id = ct.loan_id
             JOIN the_doc_gia t ON t.card_id = p.card_id
             JOIN doc_gia d ON d.reader_id = t.reader_id
             JOIN cuon_sach c ON c.copy_id = ct.copy_id
             JOIN dau_sach b ON b.book_id = c.book_id
             WHERE ct.trang_thai = 'DANG_MUON'
               AND (? = '' OR d.ho_ten LIKE ? OR t.ma_the LIKE ? OR c.ma_tai_lieu LIKE ? OR p.ma_phieu_muon LIKE ?)
             ORDER BY ct.han_tra"
        );
        $term = '%' . $keyword . '%';
        $stmt->execute([$keyword, $term, $term, $term, $term]);
        return $stmt->fetchAll();
    }

    public function findDetails(int $loanId): array {
        $stmt = $this->db->prepare(
            'SELECT ct.*, c.ma_tai_lieu, b.ten_sach, b.tac_gia
             FROM ct_phieu_muon ct
             JOIN cuon_sach c ON c.copy_id = ct.copy_id
             JOIN dau_sach b ON b.book_id = c.book_id
             WHERE ct.loan_id = ? ORDER BY ct.loan_detail_id'
        );
        $stmt->execute([$loanId]);
        return $stmt->fetchAll();
    }

    public function findById(int $loanId): ?array {
        $stmt = $this->db->prepare(
            'SELECT p.*, t.ma_the, d.ho_ten
             FROM phieu_muon p JOIN the_doc_gia t ON t.card_id = p.card_id
             JOIN doc_gia d ON d.reader_id = t.reader_id WHERE p.loan_id = ?'
        );
        $stmt->execute([$loanId]);
        $loan = $stmt->fetch();
        return $loan ?: null;
    }
}
