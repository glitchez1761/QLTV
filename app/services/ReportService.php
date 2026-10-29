<?php
class ReportService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }

    public function getDashboardStats(): array
    {
        return [
            'reader_count' => (int)$this->db->query('SELECT COUNT(*) FROM doc_gia')->fetchColumn(),
            'book_count' => (int)$this->db->query('SELECT COUNT(*) FROM dau_sach')->fetchColumn(),
            'active_card_count' => (int)$this->db->query("SELECT COUNT(*) FROM the_doc_gia WHERE trang_thai = 'HOAT_DONG'")->fetchColumn(),
            'active_loan_count' => (int)$this->db->query("SELECT COUNT(*) FROM ct_phieu_muon WHERE trang_thai = 'DANG_MUON'")->fetchColumn(),
            'overdue_loan_count' => (int)$this->db->query("SELECT COUNT(*) FROM ct_phieu_muon WHERE trang_thai = 'DANG_MUON' AND han_tra < CURDATE()")->fetchColumn(),
        ];
    }

    public function getLatestLoans(): array
    {
        $stmt = $this->db->query(
            "SELECT p.ma_phieu_muon, d.ho_ten, c.ma_tai_lieu, ct.han_tra, ct.trang_thai
             FROM ct_phieu_muon ct
             JOIN phieu_muon p ON p.loan_id = ct.loan_id
             JOIN the_doc_gia t ON t.card_id = p.card_id
             JOIN doc_gia d ON d.reader_id = t.reader_id
             JOIN cuon_sach c ON c.copy_id = ct.copy_id
             ORDER BY p.loan_id DESC
             LIMIT 10"
        );
        return $stmt->fetchAll();
    }
}
