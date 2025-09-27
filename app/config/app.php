<?php
// Configuración global
define('BASE_URL_API', 'http://localhost:8080/api'); // ajusta a tu API real
define('DEBUG_MODE', true);

// Iniciar sesión para manejar JWT
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
