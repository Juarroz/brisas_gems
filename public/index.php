<?php
// public/index.php
require_once __DIR__ . '/../app/config/app.php';
require_once __DIR__ . '/../app/core/Router.php';

// Despachar ruta según URL
$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
