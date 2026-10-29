<?php
class NhanVienController extends Controller {
    private NhanVienModel $model;

    public function __construct() {
        $this->model = new NhanVienModel();
    }

    public function index(): void {
        $this->view('nhan-vien/index', ['items' => $this->model->getAll()]);
    }

    public function create(): void {
        $this->view('nhan-vien/form');
    }

    public function store(): void {
        $data = [
            'HoTen' => trim($_POST['HoTen'] ?? ''),
            'NgaySinh' => trim($_POST['NgaySinh'] ?? ''),
            'GioiTinh' => trim($_POST['GioiTinh'] ?? ''),
            'SoDienThoai' => trim($_POST['SoDienThoai'] ?? ''),
            'DiaChi' => trim($_POST['DiaChi'] ?? ''),
            'ChucVu' => trim($_POST['ChucVu'] ?? ''),
            'TenDangNhap' => trim($_POST['TenDangNhap'] ?? ''),
            'MatKhau' => trim($_POST['MatKhau'] ?? ''),
        ];

        if ($data['HoTen'] === '' || $data['ChucVu'] === '' || $data['TenDangNhap'] === '' || $data['MatKhau'] === '') {
            $_SESSION['error'] = 'Vui lòng nhập đủ thông tin nhân viên.';
            $this->redirect('/nhan-vien/create');
        }

        $this->model->create($data);
        $_SESSION['success'] = 'Thêm nhân viên thành công.';
        $this->redirect('/nhan-vien');
    }

    public function edit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $item = $this->model->getById($id);
        if (!$item) {
            $_SESSION['error'] = 'Không tìm thấy nhân viên.';
            $this->redirect('/nhan-vien');
        }

        $this->view('nhan-vien/form', ['item' => $item]);
    }

    public function update(): void {
        $id = (int)($_POST['MaNhanVien'] ?? 0);
        if ($id <= 0) {
            $_SESSION['error'] = 'Mã nhân viên không hợp lệ.';
            $this->redirect('/nhan-vien');
        }

        $data = [
            'HoTen' => trim($_POST['HoTen'] ?? ''),
            'NgaySinh' => trim($_POST['NgaySinh'] ?? ''),
            'GioiTinh' => trim($_POST['GioiTinh'] ?? ''),
            'SoDienThoai' => trim($_POST['SoDienThoai'] ?? ''),
            'DiaChi' => trim($_POST['DiaChi'] ?? ''),
            'ChucVu' => trim($_POST['ChucVu'] ?? ''),
            'TenDangNhap' => trim($_POST['TenDangNhap'] ?? ''),
        ];

        if ($data['HoTen'] === '' || $data['ChucVu'] === '' || $data['TenDangNhap'] === '') {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin nhân viên.';
            $this->redirect('/nhan-vien/edit?id=' . $id);
        }

        $this->model->update($id, $data);
        $_SESSION['success'] = 'Cập nhật nhân viên thành công.';
        $this->redirect('/nhan-vien');
    }

    public function delete(): void {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $this->model->delete($id);
            $_SESSION['success'] = 'Xóa nhân viên thành công.';
        }
        $this->redirect('/nhan-vien');
    }
}
