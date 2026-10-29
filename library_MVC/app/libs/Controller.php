<?php
class Controller {
    public function model(string $model): object {
        if (!preg_match('/^[A-Z][A-Za-z0-9]*$/', $model)) {
            throw new InvalidArgumentException('Tên model không hợp lệ.');
        }
        $file = __DIR__ . '/../models/' . $model . '.php';
        if (!is_file($file)) {
            throw new RuntimeException("Không tìm thấy model: {$model}");
        }
        require_once $file;
        return new $model(Database::getConnection());
    }

    public function view(string $viewPath, array $data = []): void {
        $file = __DIR__ . '/../views/' . $viewPath . '.php';
        $base = realpath(__DIR__ . '/../views');
        $resolved = realpath($file);
        if ($base === false || $resolved === false || !str_starts_with($resolved, $base . DIRECTORY_SEPARATOR)) {
            throw new RuntimeException("Không tìm thấy view: {$viewPath}");
        }

        extract($data, EXTR_SKIP);
        require __DIR__ . '/../views/layouts/header.php';
        require $resolved;
        require __DIR__ . '/../views/layouts/footer.php';
    }

    protected function redirect(string $path): never {
        if ($path === '' || $path[0] !== '/' || str_starts_with($path, '//')) {
            throw new InvalidArgumentException('Đường dẫn chuyển hướng không hợp lệ.');
        }
        header('Location: ' . BASE_URL . $path, true, 303);
        exit;
    }

    public function json(array $data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
        exit;
    }
}