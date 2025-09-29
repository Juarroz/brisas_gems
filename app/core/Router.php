<?php
// app/core/Router.php
class Router {
    protected $routes = [];

    public function __construct($routes) {
        $this->routes = $routes;
    }

    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $path = parse_url($uri, PHP_URL_PATH);

        // --- LÓGICA MEJORADA PARA CALCULAR LA RUTA BASE DINÁMICAMENTE ---
        $scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        // Si el script está en la carpeta public, la quitamos para obtener la base del proyecto
        if (basename($scriptName) === 'public') {
            $basePath = dirname($scriptName);
        } else {
            $basePath = $scriptName;
        }
        // Normalizamos para evitar barras duplicadas
        $basePath = rtrim($basePath, '/');

        if (strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }
        
        // Si el path está vacío después de quitar la base, es la raíz '/'
        if (empty($path)) {
            $path = '/';
        }
        // --- FIN DE LA LÓGICA MEJORADA ---

        foreach ($this->routes as $route => $handler) {
            list($routeMethod, $routePath) = explode(' ', $route, 2);

            // Convertir ruta con placeholders (ej: /usuarios/{id}) a una expresión regular
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_]+)', $routePath);
            $pattern = '#^' . $pattern . '$#';

            if ($method === $routeMethod && preg_match($pattern, $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                list($controllerName, $action) = explode('@', $handler);
                $this->callAction($controllerName, $action, $params);
                return;
            }
        }

        http_response_code(404);
        echo "Error 404: Ruta no encontrada para la petición '{$method} {$path}'.";
    }

    protected function callAction($controllerName, $action, $params = []) {
        $pathParts = explode('/', $controllerName);
        $className = array_pop($pathParts);
        $subFolder = implode('/', $pathParts);

        $controllerFile = __DIR__ . '/../controlador/' . $subFolder . '/' . $className . '.php';

        if (!file_exists($controllerFile)) {
            die("Error: Controlador no encontrado: {$controllerFile}");
        }

        require_once $controllerFile;
        
        if (!class_exists($className)) {
            die("Error: Clase no encontrada: {$className}");
        }

        $controller = new $className();

        if (!method_exists($controller, $action)) {
            die("Error: Método no encontrado: {$action} en la clase {$className}");
        }

        // Llamar al método del controlador, pasando los parámetros de la URL
        call_user_func_array([$controller, $action], $params);
    }
}