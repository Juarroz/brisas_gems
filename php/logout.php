<?php
session_start();

// --- Seguridad: Eliminar todas las variables de sesión ---
$_SESSION = array();

// --- Destruir la cookie de sesión si existe ---
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// --- Finalmente destruir la sesión ---
session_destroy();

// --- Redirigir al inicio de forma segura ---
header("Location: ../index.php");
exit;