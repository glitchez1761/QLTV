<?php
session_start();

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/SachController.php';
require_once __DIR__ . '/../app/controllers/DocGiaController.php';
require_once __DIR__ . '/../app/controllers/LoanController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';

$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';
$id = $_GET['id'] ?? null;

$publicControllers = ['auth'];
if (!isset($_SESSION['user']) && !in_array($controller, $publicControllers, true)) {
    header('Location: ' . BASE_URL . '/public/index.php?controller=auth&action=login');
    exit();
}

switch ($controller) {
    case 'auth':
        $auth = new AuthController();
        switch ($action) {
            case 'login':
                $auth->login();
                break;
            case 'authenticate':
                $auth->authenticate();
                break;
            case 'logout':
                $auth->logout();
                break;
            default:
                $auth->login();
                break;
        }
        break;

    case 'home':
        (new HomeController())->index();
        break;

    case 'sach':
        $sach = new SachController();
        switch ($action) {
            case 'index':
                $sach->index();
                break;
            case 'add':
                $sach->add();
                break;
            case 'store':
                $sach->store();
                break;
            case 'edit':
                $sach->edit($id);
                break;
            case 'update':
                $sach->update($id);
                break;
            case 'delete':
                $sach->delete($id);
                break;
            default:
                $sach->index();
                break;
        }
        break;

    case 'docgia':
        $docgia = new DocGiaController();
        switch ($action) {
            case 'index':
                $docgia->index();
                break;
            case 'add':
                $docgia->add();
                break;
            case 'store':
                $docgia->store();
                break;
            case 'edit':
                $docgia->edit($id);
                break;
            case 'update':
                $docgia->update($id);
                break;
            case 'delete':
                $docgia->delete($id);
                break;
            default:
                $docgia->index();
                break;
        }
        break;

    case 'loan':
        $loan = new LoanController();
        switch ($action) {
            case 'index':
                $loan->index();
                break;
            case 'create':
                $loan->create();
                break;
            case 'store':
                $loan->store();
                break;
            case 'renew':
                $loan->renew($id);
                break;
            default:
                $loan->index();
                break;
        }
        break;

    case 'admin':
        $admin = new AdminController();
        switch ($action) {
            case 'dashboard':
                $admin->dashboard();
                break;
            case 'reports':
                $admin->reports();
                break;
            default:
                $admin->dashboard();
                break;
        }
        break;

    default:
        (new HomeController())->index();
        break;
}
