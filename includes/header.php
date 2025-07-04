<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$rol_id = $_SESSION['rol_id'] ?? null;
$usu_nombre = $_SESSION['usu_nombre'] ?? null;
?>

<header class="encabezado">
  <div class="contenedor-header">
    <!-- Logo centrado -->
    <div class="logo-centro">
      <a href="/brisas_gems/index.php">
        <img src="/brisas_gems/img/logo.png" alt="Logo Brisas Gems">
      </a>
    </div>
    <!-- Menú izquierdo -->
    <nav class="nav-izquierda">
      <?php
        $pagina = basename($_SERVER['PHP_SELF']);
        if ($rol_id === 2): ?>
        <a href="/brisas_gems/admin/gestion-usuarios.php" class="<?= $pagina === 'gestion-usuarios.php' ? 'activo' : '' ?>">GESTIÓN USUARIO</a>
        <a href="/brisas_gems/admin/gestion-inspiracion.php" class="<?= $pagina === 'gestion-inspiracion.php' ? 'activo' : '' ?>">GESTIÓN INSPIRACIÓN</a>
        <a href="/brisas_gems/admin/gestion-opciones.php" class="<?= $pagina === 'gestion-opciones.php' ? 'activo' : '' ?>">GESTIÓN PERSONALIZACIÓN</a>
        <a href="/brisas_gems/admin/gestion-pedidos.php" class="<?= $pagina === 'gestion-pedidos.php' ? 'activo' : '' ?>">GESTIÓN PEDIDOS</a>
      <?php else: ?>
        <a href="/brisas_gems/personalizar.php" class="<?= $pagina === 'personalizar.php' ? 'activo' : '' ?>">PERSONALIZACION</a>
        <a href="/brisas_gems/inspiracion.php" class="<?= $pagina === 'inspiracion.php' ? 'activo' : '' ?>">INSPIRACION</a>
      <?php endif; ?>
    </nav>
    <!-- Íconos a la derecha -->
    <div class="menu-derecha">
      <a href="#"><img src="/brisas_gems/img/gem.svg" alt="Favoritos" class="icono"></a>
      <a href="#"><img src="/brisas_gems/img/bluesky.svg" alt="Carrito" class="icono"></a>
      <div class="perfil-wrapper">
        <img src="/brisas_gems/img/person.svg" alt="Perfil" class="icono" id="icono-usuario">
        <div class="menu-usuario" id="menu-usuario">
          <?php if ($rol_id === 1): ?>
            <p class="px-3 fw-bold"><?= htmlspecialchars($usu_nombre) ?></p>
            <a href="/brisas_gems/usuario/mi-perfil.php">Mi perfil</a>
            <a href="/brisas_gems/usuario/mis-pedidos.php">Mis pedidos</a>
            <a href="/brisas_gems/php/logout.php">Cerrar sesión</a>
          <?php elseif ($rol_id === 2): ?>
            <p class="px-3 fw-bold"><?= htmlspecialchars($usu_nombre) ?></p>
            <a href="/brisas_gems/admin/gestion-usuarios.php">Gestión usuarios</a>
            <a href="/brisas_gems/admin/gestion-inspiracion.php">Gestión inspiración</a>
            <a href="/brisas_gems/admin/gestion-opciones.php">Gestión personalización</a>
            <a href="/brisas_gems/admin/gestion-pedidos.php">Gestión pedidos</a>
            <a href="/brisas_gems/php/logout.php">Cerrar sesión</a>
          <?php else: ?>
            <a href="/brisas_gems/login.php">Iniciar sesión</a>
            <a href="/brisas_gems/registro.php">Registrarse</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</header>