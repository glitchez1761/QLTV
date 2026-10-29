<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/libs/Database.php';
require_once __DIR__ . '/app/libs/AuthMiddleware.php';
require_once __DIR__ . '/app/libs/Controller.php';
require_once __DIR__ . '/app/libs/Router.php';

// Require new CRUD controllers
require_once __DIR__ . '/app/controllers/SachController.php';
require_once __DIR__ . '/app/controllers/NhanVienController.php';
require_once __DIR__ . '/app/controllers/DocGiaController.php';
require_once __DIR__ . '/app/controllers/PhieuMuonSachController.php';
require_once __DIR__ . '/app/controllers/BienBanViPhamController.php';

$router = new Router();

$router->get('/', 'HomeController@index');

// Tài khoản
$router->get('/auth/login', 'AuthController@login');
$router->post('/auth/handleLogin', 'AuthController@handleLogin');
$router->get('/auth/register', 'AuthController@register');
$router->post('/auth/handleRegister', 'AuthController@handleRegister');
$router->get('/auth/firstChangePassword', 'AuthController@firstChangePassword');
$router->post('/auth/handleFirstChangePassword', 'AuthController@handleFirstChangePassword');
$router->get('/auth/logout', 'AuthController@logout');
$router->get('/auth/profile', 'AuthController@profile', ['DOC_GIA', 'NHAN_VIEN', 'QUAN_LY']);

// CRUD - Sách
$router->get('/sach', 'SachController@index');
$router->get('/sach/create', 'SachController@create');
$router->post('/sach/store', 'SachController@store');
$router->get('/sach/edit', 'SachController@edit');
$router->post('/sach/update', 'SachController@update');
$router->post('/sach/delete', 'SachController@delete');

// CRUD - Nhân viên
$router->get('/nhan-vien', 'NhanVienController@index');
$router->get('/nhan-vien/create', 'NhanVienController@create');
$router->post('/nhan-vien/store', 'NhanVienController@store');
$router->get('/nhan-vien/edit', 'NhanVienController@edit');
$router->post('/nhan-vien/update', 'NhanVienController@update');
$router->post('/nhan-vien/delete', 'NhanVienController@delete');

// CRUD - Độc giả
$router->get('/doc-gia', 'DocGiaController@index');
$router->get('/doc-gia/create', 'DocGiaController@create');
$router->post('/doc-gia/store', 'DocGiaController@store');
$router->get('/doc-gia/edit', 'DocGiaController@edit');
$router->post('/doc-gia/update', 'DocGiaController@update');
$router->post('/doc-gia/delete', 'DocGiaController@delete');

// CRUD - Phiếu mượn sách
$router->get('/phieu-muon', 'PhieuMuonSachController@index');
$router->get('/phieu-muon/create', 'PhieuMuonSachController@create');
$router->post('/phieu-muon/store', 'PhieuMuonSachController@store');
$router->get('/phieu-muon/edit', 'PhieuMuonSachController@edit');
$router->post('/phieu-muon/update', 'PhieuMuonSachController@update');
$router->post('/phieu-muon/delete', 'PhieuMuonSachController@delete');

// CRUD - Biên bản vi phạm
$router->get('/vi-pham', 'BienBanViPhamController@index');
$router->get('/vi-pham/create', 'BienBanViPhamController@create');
$router->post('/vi-pham/store', 'BienBanViPhamController@store');
$router->get('/vi-pham/edit', 'BienBanViPhamController@edit');
$router->post('/vi-pham/update', 'BienBanViPhamController@update');
$router->post('/vi-pham/delete', 'BienBanViPhamController@delete');

// Mượn sách
$router->get('/loan/create', 'LoanController@create', ['NHAN_VIEN', 'QUAN_LY']);
$router->post('/loan/store', 'LoanController@store', ['NHAN_VIEN', 'QUAN_LY']);
$router->post('/loan/renew', 'LoanController@renew', ['NHAN_VIEN', 'QUAN_LY']);
$router->get('/loans', 'LoanController@index', ['NHAN_VIEN', 'QUAN_LY']);
$router->get('/loan/detail', 'LoanController@detail', ['NHAN_VIEN', 'QUAN_LY']);
$router->get('/packages', 'LoanController@packages');
$router->post('/packages/register', 'LoanController@registerPackage', ['DOC_GIA']);

// Trả sách & Vi phạm
$router->get('/return', 'ReturnController@index', ['NHAN_VIEN', 'QUAN_LY']);
$router->get('/return/check', 'ReturnController@checkCondition', ['NHAN_VIEN', 'QUAN_LY']);
$router->post('/return/process', 'ReturnController@processReturn', ['NHAN_VIEN', 'QUAN_LY']);
$router->get('/violations', 'ReturnController@violations', ['NHAN_VIEN', 'QUAN_LY']);
$router->get('/violations/detail', 'ReturnController@violationDetail', ['NHAN_VIEN', 'QUAN_LY']);
$router->post('/violations/pay', 'ReturnController@payViolation', ['NHAN_VIEN', 'QUAN_LY']);
$router->get('/reminders', 'ReturnController@reminders', ['NHAN_VIEN', 'QUAN_LY']);
$router->post('/reminders/scan', 'ReturnController@autoScanReminders', ['NHAN_VIEN', 'QUAN_LY']);

// Thẻ & Tra cứu
$router->get('/books/search', 'CardController@searchBooks');
$router->get('/cards', 'CardController@cardList', ['NHAN_VIEN', 'QUAN_LY']);
$router->get('/cards/renew', 'CardController@renewForm', ['NHAN_VIEN', 'QUAN_LY']);
$router->post('/cards/renew', 'CardController@renewCard', ['NHAN_VIEN', 'QUAN_LY']);
$router->post('/cards/cancel', 'CardController@cancelCard', ['NHAN_VIEN', 'QUAN_LY']);

// Kho, Nhân sự & Báo cáo
$router->get('/admin/books', 'AdminController@booksIndex', ['QUAN_LY']);
$router->get('/admin/books/create', 'AdminController@bookCreate', ['QUAN_LY']);
$router->get('/admin/books/edit', 'AdminController@bookEdit', ['QUAN_LY']);
$router->post('/admin/books/save', 'AdminController@bookSave', ['QUAN_LY']);
$router->get('/admin/books/inventory', 'AdminController@bookInventory', ['QUAN_LY']);
$router->post('/admin/books/copies/add', 'AdminController@addBookCopy', ['QUAN_LY']);
$router->get('/admin/staff', 'AdminController@staffIndex', ['QUAN_LY']);
$router->get('/admin/staff/create', 'AdminController@staffCreate', ['QUAN_LY']);
$router->post('/admin/staff/store', 'AdminController@staffStore', ['QUAN_LY']);
$router->get('/admin/reports', 'AdminController@reportIndex', ['QUAN_LY']);
$router->post('/admin/reports/generate', 'AdminController@reportGenerate', ['QUAN_LY']);
$router->get('/admin/reports/view', 'AdminController@reportView', ['QUAN_LY']);

$url = $_GET['url'] ?? '/';
try {
    $router->dispatch($url);
} catch (Throwable $e) {
    error_log($e->__toString());
    http_response_code(500);
    echo '<!doctype html><html lang="vi"><meta charset="utf-8"><title>Lỗi hệ thống</title>';
    echo '<main><h1>Không thể xử lý yêu cầu</h1><p>Đã xảy ra lỗi hệ thống. Vui lòng thử lại hoặc liên hệ quản trị viên.</p></main></html>';
}
