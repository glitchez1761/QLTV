<?php
class PhieuMuonSachController extends Controller {
    private PhieuMuonSachModel $model;

    public function __construct() {
        $this->model = new PhieuMuonSachModel();
    }

    public function index(): void {
        $this->view('phieu-muon/index', ['items' => $this->model->getAll()]);
    }

    public function create(): void {
        $this->view('phieu-muon/form', [
            'docGias' => (new DocGiaModel())->getAll(),
            'nhanViens' => (new NhanVienModel())->getAll(),
            'sachs' => (new SachModel())->getAll(),
        ]);
    }

    public function store(): void {
        $data = [
            'MaDocGia' => trim($_POST['MaDocGia'] ?? ''),
            'MaNhanVien' => trim($_POST['MaNhanVien'] ?? ''),
            'MaSach' => trim($_POST['MaSach'] ?? ''),
            'NgayMuon' => trim($_POST['NgayMuon'] ?? ''),
            'HanTra' => trim($_POST['HanTra'] ?? ''),
            'NgayTra' => trim($_POST['NgayTra'] ?? ''),
            'SoLuongMuon' => trim($_POST['SoLuongMuon'] ?? '1'),
            'TrangThai' => trim($_POST['TrangThai'] ?? 'Dang muon'),
        ];

        if ($data['MaDocGia'] === '' || $data['MaNhanVien'] === '' || $data['MaSach'] === '' || $data['NgayMuon'] === '' || $data['HanTra'] === '') {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin phiếu mượn.';
            $this->redirect('/phieu-muon/create');
        }

        $this->model->create($data);
        $_SESSION['success'] = 'Lập phiếu mượn thành công.';
        $this->redirect('/phieu-muon');
    }

    public function edit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $item = $this->model->getById($id);
        if (!$item) {
            $_SESSION['error'] = 'Không tìm thấy phiếu mượn.';
            $this->redirect('/phieu-muon');
        }

        $this->view('phieu-muon/form', [
            'item' => $item,
            'docGias' => (new DocGiaModel())->getAll(),
            'nhanViens' => (new NhanVienModel())->getAll(),
            'sachs' => (new SachModel())->getAll(),
        ]);
    }

    public function update(): void {
        $id = (int)($_POST['MaPhieuMuon'] ?? 0);
        if ($id <= 0) {
            $_SESSION['error'] = 'Mã phiếu mượn không hợp lệ.';
            $this->redirect('/phieu-muon');
        }

        $data = [
            'MaDocGia' => trim($_POST['MaDocGia'] ?? ''),
            'MaNhanVien' => trim($_POST['MaNhanVien'] ?? ''),
            'MaSach' => trim($_POST['MaSach'] ?? ''),
            'NgayMuon' => trim($_POST['NgayMuon'] ?? ''),
            'HanTra' => trim($_POST['HanTra'] ?? ''),
            'NgayTra' => trim($_POST['NgayTra'] ?? ''),
            'SoLuongMuon' => trim($_POST['SoLuongMuon'] ?? '1'),
            'TrangThai' => trim($_POST['TrangThai'] ?? 'Dang muon'),
        ];

        if ($data['MaDocGia'] === '' || $data['MaNhanVien'] === '' || $data['MaSach'] === '' || $data['NgayMuon'] === '' || $data['HanTra'] === '') {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin phiếu mượn.';
            $this->redirect('/phieu-muon/edit?id=' . $id);
        }

        $this->model->update($id, $data);
        $_SESSION['success'] = 'Cập nhật phiếu mượn thành công.';
        $this->redirect('/phieu-muon');
    }

    public function delete(): void {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $this->model->delete($id);
            $_SESSION['success'] = 'Xóa phiếu mượn thành công.';
        }
        $this->redirect('/phieu-muon');
    }
}
