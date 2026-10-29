<?php
class DocGiaController extends Controller {
    private DocGiaModel $model;

    public function __construct() {
        $this->model = new DocGiaModel();
    }

    public function index(): void {
        $this->view('doc-gia/index', ['items' => $this->model->getAll()]);
    }

    public function create(): void {
        $this->view('doc-gia/form');
    }

    public function store(): void {
        $data = [
            'HoTen' => trim($_POST['HoTen'] ?? ''),
            'NgaySinh' => trim($_POST['NgaySinh'] ?? ''),
            'GioiTinh' => trim($_POST['GioiTinh'] ?? ''),
            'SoDienThoai' => trim($_POST['SoDienThoai'] ?? ''),
            'DiaChi' => trim($_POST['DiaChi'] ?? ''),
            'Email' => trim($_POST['Email'] ?? ''),
            'NgayCapThe' => trim($_POST['NgayCapThe'] ?? ''),
            'NgayHetHan' => trim($_POST['NgayHetHan'] ?? ''),
            'TrangThaiThe' => trim($_POST['TrangThaiThe'] ?? 'Con han'),
        ];

        if ($data['HoTen'] === '' || $data['NgayCapThe'] === '' || $data['NgayHetHan'] === '') {
            $_SESSION['error'] = 'Vui lòng nhập họ tên và ngày cấp/ ngày hết hạn.';
            $this->redirect('/doc-gia/create');
        }

        $this->model->create($data);
        $_SESSION['success'] = 'Thêm độc giả thành công.';
        $this->redirect('/doc-gia');
    }

    public function edit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $item = $this->model->getById($id);
        if (!$item) {
            $_SESSION['error'] = 'Không tìm thấy độc giả.';
            $this->redirect('/doc-gia');
        }

        $this->view('doc-gia/form', ['item' => $item]);
    }

    public function update(): void {
        $id = (int)($_POST['MaDocGia'] ?? 0);
        if ($id <= 0) {
            $_SESSION['error'] = 'Mã độc giả không hợp lệ.';
            $this->redirect('/doc-gia');
        }

        $data = [
            'HoTen' => trim($_POST['HoTen'] ?? ''),
            'NgaySinh' => trim($_POST['NgaySinh'] ?? ''),
            'GioiTinh' => trim($_POST['GioiTinh'] ?? ''),
            'SoDienThoai' => trim($_POST['SoDienThoai'] ?? ''),
            'DiaChi' => trim($_POST['DiaChi'] ?? ''),
            'Email' => trim($_POST['Email'] ?? ''),
            'NgayCapThe' => trim($_POST['NgayCapThe'] ?? ''),
            'NgayHetHan' => trim($_POST['NgayHetHan'] ?? ''),
            'TrangThaiThe' => trim($_POST['TrangThaiThe'] ?? 'Con han'),
        ];

        if ($data['HoTen'] === '' || $data['NgayCapThe'] === '' || $data['NgayHetHan'] === '') {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin độc giả.';
            $this->redirect('/doc-gia/edit?id=' . $id);
        }

        $this->model->update($id, $data);
        $_SESSION['success'] = 'Cập nhật độc giả thành công.';
        $this->redirect('/doc-gia');
    }

    public function delete(): void {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $this->model->delete($id);
            $_SESSION['success'] = 'Xóa độc giả thành công.';
        }
        $this->redirect('/doc-gia');
    }
}
