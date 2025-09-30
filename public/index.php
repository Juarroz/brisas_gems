<?php
// Iniciar la sesión al principio de la aplicación
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cargar archivos del núcleo
require_once __DIR__ . '/../app/config/app.php';
require_once __DIR__ . '/../app/core/Router.php';

// 1. Cargar el array con todas las definiciones de rutas
$routes = require_once __DIR__ . '/../app/config/routes.php';

// 2. Crear una instancia del Router, pasándole las rutas que acabamos de cargar
$router = new Router($routes);

// 3. Pedirle al router que maneje la petición actual del navegador
$router->handleRequest();