<?php

/**
 * Verifica si existe un token de sesión. Si no, redirige al login y termina el script.
 */
function requireLogin() {
    // Inicia o reanuda la sesión para poder leer la variable $_SESSION
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Si la variable 'jwt_token' no está definida en la sesión, el usuario no está logueado.
    if (!isset($_SESSION['jwt_token'])) {
        // Redirigimos al formulario de login
        header('Location: index.php?module=seguridad&action=showLogin');
        // Detenemos la ejecución del script para que no se muestre nada de la página protegida
        exit();
    }
}