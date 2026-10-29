<?php
class AuthController
{
    public function login()
    {
        $errorMessage = $_SESSION['login_error'] ?? '';
        unset($_SESSION['login_error']);
        include_once APP_ROOT . '/app/views/auth/login.php';
    }

    public function authenticate()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username === 'admin' && $password === 'admin') {
            $_SESSION['user'] = $username;
            header('Location: ' . BASE_URL . '/public/index.php?controller=home&action=index');
            exit();
        }

        $_SESSION['login_error'] = 'Tên đăng nhập hoặc mật khẩu không đúng.';
        header('Location: ' . BASE_URL . '/public/index.php?controller=auth&action=login');
        exit();
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        header('Location: ' . BASE_URL . '/public/index.php?controller=auth&action=login');
        exit();
    }
}
