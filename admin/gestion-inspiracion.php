<?php
// Control de sesión para acceso solo a administradores
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usu_id']) || $_SESSION['rol_id'] != 2) {
    header('Location: ../login.php');
    exit();
}

// Cargar datos del usuario autenticado
require_once '../php/conexion.php';
$usu_id = $_SESSION['usu_id'];
$usu_nombre = $_SESSION['usu_nombre'] ?? '';

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Gestión de Inspiración</title>
  <link rel="icon" href="../img/icono.png">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/assets/css-global/main.css">
  <link rel="stylesheet" href="../css/gestion-inspiracion.css">
  <meta charset="UTF-8">
  <meta name="author" content="Natalia Cueca">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta name="description" content="Brisas Gems permite personalizar joyas en línea con visualización en tiempo real, catálogo inteligente, seguimiento de pedidos y contacto directo con el equipo de diseño.">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container py-5">
  <!-- Botón Agregar Diseño -->
  <div class="text-center mb-4">
    <a href="formulario-catalogo.php" class="btn btn-primary btn-lg boton-agregar">
      <i class="bi bi-plus-circle"></i> Agregar Diseño
    </a>
  </div>

  <!-- Cards de catálogo -->
  <div class="row">
    <!-- Las cards se cargarán dinámicamente con JS -->
  </div>
</div>

<footer class="footer-joyeria">
  <div class="contenedor-footer">
    <div class="columna-footer">
      <h4>Brisas Gems</h4>
      <p>🟢 Joyería fina y personalizada con los más altos estándares de calidad.</p>
      <div class="redes-sociales">
        <a href="#" target="_blank" rel="noopener" aria-label="Facebook Brisas Gems">
          <img src="../img/icono-whatsApp.png" alt="Facebook Brisas Gems">
        </a>
        <a href="#" target="_blank" rel="noopener" aria-label="Instagram Brisas Gems">
          <img src="../img/icono instagram.png" alt="Instagram Brisas Gems">
        </a>
        <a href="#" target="_blank" rel="noopener" aria-label="WhatsApp Brisas Gems">
          <img src="../img/icono-facebook.png" alt="WhatsApp Brisas Gems">
        </a>
      </div>
    </div>
    <div class="columna-footer">
      <h4>Contacto</h4>
      <p><span class="icono-footer">🟢</span> Av Jiménez #5-43, Emerald Trade Center, Bogotá</p>
      <p><span class="icono-footer">🟢</span> +57 6017654312</p>
      <p><span class="icono-footer">🟢</span> info@brisasgem.com</p>
    </div>
    <div class="columna-footer">
      <h4>Enlaces</h4>
      <nav aria-label="Enlaces rápidos">
        <ul class="enlaces-footer">
          <li><a href="./Gestionar-U-R.html">Gestión de Usuarios y Roles</a></li>
          <li><a href="#">Mi Perfil</a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="derechos-footer">
    <p>© 2025 Brisas Gems - Todos los derechos reservados</p>
    <p>Desarrollado por SENA CEET - Ficha 2996176 ADSO</p>
  </div>
</footer>
<script src="../js/gestion-inspiracion.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
  const iconoUsuario = document.getElementById('icono-usuario');
  const menuUsuario = document.getElementById('menu-usuario');
  if (iconoUsuario && menuUsuario) {
    iconoUsuario.addEventListener('click', () => {
      menuUsuario.classList.toggle('activo');
    });
    document.addEventListener('click', (e) => {
      if (!iconoUsuario.contains(e.target) && !menuUsuario.contains(e.target)) {
        menuUsuario.classList.remove('activo');
      }
    });
  }
</script>
</body>
</html>
