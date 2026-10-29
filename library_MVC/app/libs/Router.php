<?php
class Router {
    private array $routes = [];

    public function get(string $path, string $handler, array $roles = []): void {
        $this->routes['GET'][$path] = ['handler' => $handler, 'roles' => $roles];
    }

    public function post(string $path, string $handler, array $roles = []): void {
        $this->routes['POST'][$path] = ['handler' => $handler, 'roles' => $roles];
    }

    public function dispatch(string $url): void {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $url = parse_url($url, PHP_URL_PATH) ?: '/';
        $url = '/' . trim($url, '/');
        if ($url === '//') {
            $url = '/';
        }

        if (isset($this->routes[$method][$url])) {
            $route = $this->routes[$method][$url];
            if (!empty($route['roles'])) {
                AuthMiddleware::checkRole($route['roles']);
            }
            [$controllerName, $action] = explode('@', $route['handler']);
            require_once __DIR__ . '/../controllers/' . $controllerName . '.php';
            $controller = new $controllerName();
            $controller->$action();
            return;
        }

        http_response_code(404);
        echo '<!doctype html><html lang="vi"><meta charset="utf-8"><title>Không tìm thấy</title>';
        echo '<main><h1>404 - Đường dẫn không tồn tại</h1><a href="' . htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') . '">Về trang chủ</a></main></html>';
    }
}