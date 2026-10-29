<?php
class BienBanViPhamController extends Controller {
    private BienBanViPhamModel $model;

    public function __construct() {
        $this->model = new BienBanViPhamModel();
    }

    public function index(): void {
        $this->view('vi-pham/index', ['items' => $this->model->getAll()]);
    }

    public function create(): void {
        $this->view('vi-pham/form', [
            'phieuMuons' => (new PhieuMuonSachModel())->getAll(),
            'nhanViens' => (new NhanVienModel())->getAll(),
        ]);
    }

    public function store(): void {
        $data = [
            'MaPhieuMuon' => trim($_POST['MaPhieuMuon'] ?? ''),
            'MaNhanVien' => trim($_POST['MaNhanVien'] ?? ''),
            'NgayLap' => trim($_POST['NgayLap'] ?? ''),
            'LoaiViPham' => trim($_POST['LoaiViPham'] ?? ''),
            'MoTa' => trim($_POST['MoTa'] ?? ''),
            'TienPhat' => trim($_POST['TienPhat'] ?? '0'),
            'TrangThai' => trim($_POST['TrangThai'] ?? 'Chua xu ly'),
        ];

        if ($data['MaPhieuMuon'] === '' || $data['MaNhanVien'] === '' || $data['NgayLap'] === '' || $data['LoaiViPham'] === '') {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin biên bản vi phạm.';
            $this->redirect('/vi-pham/create');
        }

        $this->model->create($data);
        $_SESSION['success'] = 'Lập biên bản vi phạm thành công.';
        $this->redirect('/vi-pham');
    }

    public function edit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $item = $this->model->getById($id);
        if (!$item) {
            $_SESSION['error'] = 'Không tìm thấy biên bản vi phạm.';
            $this->redirect('/vi-pham');
        }

        $this->view('vi-pham/form', [
            'item' => $item,
            'phieuMuons' => (new PhieuMuonSachModel())->getAll(),
            'nhanViens' => (new NhanVienModel())->getAll(),
        ]);
    }

    public function update(): void {
        $id = (int)($_POST['MaBienBan'] ?? 0);
        if ($id <= 0) {
            $_SESSION['error'] = 'Mã biên bản không hợp lệ.';
            $this->redirect('/vi-pham');
        }

        $data = [
            'MaPhieuMuon' => trim($_POST['MaPhieuMuon'] ?? ''),
            'MaNhanVien' => trim($_POST['MaNhanVien'] ?? ''),
            'NgayLap' => trim($_POST['NgayLap'] ?? ''),
            'LoaiViPham' => trim($_POST['LoaiViPham'] ?? ''),
            'MoTa' => trim($_POST['MoTa'] ?? ''),
            'TienPhat' => trim($_POST['TienPhat'] ?? '0'),
            'TrangThai' => trim($_POST['TrangThai'] ?? 'Chua xu ly'),
        ];

        if ($data['MaPhieuMuon'] === '' || $data['MaNhanVien'] === '' || $data['NgayLap'] === '' || $data['LoaiViPham'] === '') {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin biên bản vi phạm.';
            $this->redirect('/vi-pham/edit?id=' . $id);
        }

        $this->model->update($id, $data);
        $_SESSION['success'] = 'Cập nhật biên bản vi phạm thành công.';
        $this->redirect('/vi-pham');
    }

    public function delete(): void {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $this->model->delete($id);
            $_SESSION['success'] = 'Xóa biên bản vi phạm thành công.';
        }
        $this->redirect('/vi-pham');
    }
}
