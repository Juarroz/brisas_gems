<?php
class Router {
    private $routes;

    public function __construct() {
        $this->routes = require __DIR__ . '/../config/routes.php';
    }

    public function dispatch($uri, $method) {
        $path = parse_url($uri, PHP_URL_PATH);

        // Quitar prefijo del proyecto (/brisas_gems/public)
        $baseDir = '/brisas_gems/public';
        if (strpos($path, $baseDir) === 0) {
            $path = substr($path, strlen($baseDir));
        }

        // Normalizar path
        $path = rtrim($path, '/');
        if ($path === '') {
            $path = '/';
        }

        // Clave de búsqueda en routes.php
        $key = strtoupper($method) . ' ' . $path;

        if (isset($this->routes[$key])) {
            list($controller, $action) = explode('@', $this->routes[$key]);

            // Controlador con subcarpeta
            $controllerFile = __DIR__ . '/../controlador/' . $controller . '.php';

            if (file_exists($controllerFile)) {
                require_once $controllerFile;

                // Nombre de clase = archivo sin extensión
                $className = basename($controller); // ej: "ContactoController"

                if (class_exists($className)) {
                    $instance = new $className();

                    if (method_exists($instance, $action)) {
                        return $instance->$action();
                    } else {
                        http_response_code(500);
                        echo "Método <b>$action</b> no existe en $className.";
                    }
                } else {
                    http_response_code(500);
                    echo "Clase <b>$className</b> no encontrada en $controllerFile.";
                }
            } else {
                http_response_code(404);
                echo "Controlador no encontrado: $controllerFile";
            }
        } else {
            http_response_code(404);
            echo "Ruta no encontrada: $key";
        }
    }
}
