<?php
class SachController extends Controller {
    private SachModel $model;

    public function __construct() {
        $this->model = new SachModel();
    }

    public function index(): void {
        $this->view('sach/index', ['items' => $this->model->getAll()]);
    }

    public function create(): void {
        $this->view('sach/form');
    }

    public function store(): void {
        $data = [
            'TenSach' => trim($_POST['TenSach'] ?? ''),
            'TacGia' => trim($_POST['TacGia'] ?? ''),
            'TheLoai' => trim($_POST['TheLoai'] ?? ''),
            'NhaXuatBan' => trim($_POST['NhaXuatBan'] ?? ''),
            'NamXuatBan' => trim($_POST['NamXuatBan'] ?? ''),
            'SoLuong' => (int)($_POST['SoLuong'] ?? 0),
        ];

        if ($data['TenSach'] === '' || $data['TacGia'] === '' || $data['TheLoai'] === '') {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin sách.';
            $this->redirect('/sach/create');
        }

        $this->model->create($data);
        $_SESSION['success'] = 'Thêm sách thành công.';
        $this->redirect('/sach');
    }

    public function edit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $item = $this->model->getById($id);
        if (!$item) {
            $_SESSION['error'] = 'Không tìm thấy sách.';
            $this->redirect('/sach');
        }

        $this->view('sach/form', ['item' => $item]);
    }

    public function update(): void {
        $id = (int)($_POST['MaSach'] ?? 0);
        if ($id <= 0) {
            $_SESSION['error'] = 'Mã sách không hợp lệ.';
            $this->redirect('/sach');
        }

        $data = [
            'TenSach' => trim($_POST['TenSach'] ?? ''),
            'TacGia' => trim($_POST['TacGia'] ?? ''),
            'TheLoai' => trim($_POST['TheLoai'] ?? ''),
            'NhaXuatBan' => trim($_POST['NhaXuatBan'] ?? ''),
            'NamXuatBan' => trim($_POST['NamXuatBan'] ?? ''),
            'SoLuong' => (int)($_POST['SoLuong'] ?? 0),
        ];

        if ($data['TenSach'] === '' || $data['TacGia'] === '' || $data['TheLoai'] === '') {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin sách.';
            $this->redirect('/sach/edit?id=' . $id);
        }

        $this->model->update($id, $data);
        $_SESSION['success'] = 'Cập nhật sách thành công.';
        $this->redirect('/sach');
    }

    public function delete(): void {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $this->model->delete($id);
            $_SESSION['success'] = 'Xóa sách thành công.';
        }
        $this->redirect('/sach');
    }
}
