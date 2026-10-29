<?php
require_once APP_ROOT . '/app/services/LoanService.php';

class LoanController
{
    private LoanService $service;

    public function __construct()
    {
        $this->service = new LoanService();
    }

    public function index()
    {
        $keyword = trim($_GET['keyword'] ?? '');
        $loans = $this->service->getAll($keyword);
        include APP_ROOT . '/app/views/loan/index.php';
    }

    public function create()
    {
        $packages = $this->service->getPackages();
        include APP_ROOT . '/app/views/loan/create_loan.php';
    }

    public function store()
    {
        $cardCode = trim($_POST['card_code'] ?? '');
        $copyCodes = $_POST['copy_codes'] ?? [];

        $result = $this->service->borrowBooks($cardCode, $copyCodes, 1);

        $_SESSION[$result['status'] ? 'success' : 'error'] = $result['message'];
        header('Location: ' . BASE_URL . '/public/index.php?controller=loan&action=index');
        exit();
    }

    public function renew($id)
    {
        $result = $this->service->renewLoan((int)$id, 1);
        $_SESSION[$result['status'] ? 'success' : 'error'] = $result['message'];
        header('Location: ' . BASE_URL . '/public/index.php?controller=loan&action=index');
        exit();
    }
}
