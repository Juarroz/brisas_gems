<?php
class Router {
    private $routes;

    public function __construct() {
        $this->routes = require __DIR__ . '/../config/routes.php';
    }

    public function dispatch($uri, $method) {
        $path = parse_url($uri, PHP_URL_PATH);
        $key = strtoupper($method) . ' ' . rtrim($path, '/');
        if ($key === 'GET') $key = 'GET /'; // excepción raíz

        if (isset($this->routes[$key])) {
            list($controller, $action) = explode('@', $this->routes[$key]);
            $controllerFile = __DIR__ . '/../controllers/' . $controller . '.php';

            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $instance = new $controller();
                if (method_exists($instance, $action)) {
                    return $instance->$action();
                }
            }
        }

        http_response_code(404);
        echo "Ruta no encontrada: $key";
    }
}
