<?php
require_once APP_ROOT . '/app/services/SachService.php';

class SachController
{
    private SachService $service;

    public function __construct()
    {
        $this->service = new SachService();
    }

    public function index()
    {
        $books = $this->service->getAll();
        include APP_ROOT . '/app/views/sach/index.php';
    }

    public function add()
    {
        include APP_ROOT . '/app/views/sach/form.php';
    }

    public function store()
    {
        $this->service->add([
            'MaSach' => $_POST['MaSach'] ?? '',
            'TenSach' => $_POST['TenSach'] ?? '',
            'TacGia' => $_POST['TacGia'] ?? '',
            'NhaXuatBan' => $_POST['NhaXuatBan'] ?? '',
            'SoLuongTon' => $_POST['SoLuongTon'] ?? 0,
        ]);

        header('Location: ' . BASE_URL . '/public/index.php?controller=sach&action=index');
        exit();
    }

    public function edit($id)
    {
        $book = $this->service->getById($id);
        include APP_ROOT . '/app/views/sach/form.php';
    }

    public function update($id)
    {
        $this->service->update($id, [
            'TenSach' => $_POST['TenSach'] ?? '',
            'TacGia' => $_POST['TacGia'] ?? '',
            'NhaXuatBan' => $_POST['NhaXuatBan'] ?? '',
            'SoLuongTon' => $_POST['SoLuongTon'] ?? 0,
        ]);

        header('Location: ' . BASE_URL . '/public/index.php?controller=sach&action=index');
        exit();
    }

    public function delete($id)
    {
        $this->service->delete($id);
        header('Location: ' . BASE_URL . '/public/index.php?controller=sach&action=index');
        exit();
    }
}
