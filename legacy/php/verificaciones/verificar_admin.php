<?php
// Inicia sesión si aún no ha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica que el usuario esté autenticado y tenga rol de administrador (rol_id = 2)
if (!isset($_SESSION['usu_id']) || $_SESSION['rol_id'] != 2) {
    // Redirige al login si no está autorizado
    header("Location: /brisas_gems/login.php");
    exit();
}

// Evita que el navegador muestre contenido en caché si el usuario cerró sesión y le da "Atrás"
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>