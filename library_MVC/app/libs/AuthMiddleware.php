<?php
class AuthMiddleware {
    public static function checkLoggedIn(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }

    public static function checkRole(array $allowedRoles): void {
        self::checkLoggedIn();
        $userRole = $_SESSION['user']['vai_tro'] ?? '';
        if (!in_array($userRole, $allowedRoles, true)) {
            http_response_code(403);
            die("<h1>403 Forbidden - Bạn không có quyền truy cập vào chức năng này!</h1>");
        }
    }
}