<?php
class HomeController extends Controller {
    public function index(): void {
        $stmt = Database::getConnection()->query('SELECT COUNT(*) FROM dau_sach');
        $this->view('home/index', ['bookCount' => (int)$stmt->fetchColumn()]);
    }
}
