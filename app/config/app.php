<?php

// app/config/app.php

//  URL del API
if (!defined('BASE_URL_API')) {
    define('BASE_URL_API', 'http://localhost:8080/api');
}

if (!defined('DEBUG_MODE')) {
    define('DEBUG_MODE', true);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// URL pública base del proyecto 
if (!defined('BASE_URL')) {
    define('BASE_URL', '/brisas_gems/public');
}

// Ruta física al proyecto (C:\xampp\htdocs\brisas_gems)
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 2));
}


