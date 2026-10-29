<?php
class DashboardController extends Controller {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function index(): void {
        $counts = [
            'sach' => (int)$this->db->query('SELECT COUNT(*) FROM Sach')->fetchColumn(),
            'nhan_vien' => (int)$this->db->query('SELECT COUNT(*) FROM NhanVien')->fetchColumn(),
            'doc_gia' => (int)$this->db->query('SELECT COUNT(*) FROM DocGia')->fetchColumn(),
            'phieu_muon' => (int)$this->db->query('SELECT COUNT(*) FROM PhieuMuonSach')->fetchColumn(),
            'vi_pham' => (int)$this->db->query('SELECT COUNT(*) FROM BienBanViPham')->fetchColumn(),
        ];

        $this->view('dashboard/index', ['counts' => $counts]);
    }
}
