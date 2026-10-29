<?php
require_once APP_ROOT . '/app/services/DocGiaService.php';

class DocGiaController
{
    private DocGiaService $service;

    public function __construct()
    {
        $this->service = new DocGiaService();
    }

    public function index()
    {
        $readers = $this->service->getAll();
        include APP_ROOT . '/app/views/doc-gia/index.php';
    }

    public function add()
    {
        include APP_ROOT . '/app/views/doc-gia/form.php';
    }

    public function store()
    {
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

        if ($data['HoTen'] === '') {
            $_SESSION['error'] = 'Vui lòng nhập họ tên độc giả.';
            header('Location: ' . BASE_URL . '/public/index.php?controller=docgia&action=add');
            exit();
        }

        $this->service->add($data);
        header('Location: ' . BASE_URL . '/public/index.php?controller=docgia&action=index');
        exit();
    }

    public function edit($id)
    {
        $reader = $this->service->getById($id);
        include APP_ROOT . '/app/views/doc-gia/form.php';
    }

    public function update($id)
    {
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

        $this->service->update($id, $data);
        header('Location: ' . BASE_URL . '/public/index.php?controller=docgia&action=index');
        exit();
    }

    public function delete($id)
    {
        $this->service->delete($id);
        header('Location: ' . BASE_URL . '/public/index.php?controller=docgia&action=index');
        exit();
    }
}
