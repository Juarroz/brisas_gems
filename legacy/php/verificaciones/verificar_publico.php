<?php
// Inicia sesión si aún no ha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si ya hay sesión iniciada, redirige a la página principal
if (isset($_SESSION['usu_id'])) {
    header("Location: /brisas_gems/index.php");
    exit();
}

// No es necesario bloquear caché aquí, porque el usuario no debería haber iniciado sesión
?>