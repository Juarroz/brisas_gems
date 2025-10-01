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
      <a href="<?= BASE_URL ?>/">
        <img src="<?= BASE_URL ?>/assets/img/logo/logo.png" alt="Logo Brisas Gems">
      </a>
    </div>

    <!-- Menú izquierdo -->
    <nav class="nav-izquierda">
      <?php
        $pagina = basename($_SERVER['PHP_SELF']);
        if ($rol_id === 2): ?>
        <a href="<?= BASE_URL ?>/admin/gestion-usuarios.php" class="<?= $pagina === 'gestion-usuarios.php' ? 'activo' : '' ?>">GESTIÓN USUARIO</a>
        <a href="<?= BASE_URL ?>/admin/gestion-inspiracion.php" class="<?= $pagina === 'gestion-inspiracion.php' ? 'activo' : '' ?>">GESTIÓN INSPIRACIÓN</a>
        <a href="<?= BASE_URL ?>/admin/gestion-opciones.php" class="<?= $pagina === 'gestion-opciones.php' ? 'activo' : '' ?>">GESTIÓN PERSONALIZACIÓN</a>
        <a href="<?= BASE_URL ?>/admin/gestion-pedidos.php" class="<?= $pagina === 'gestion-pedidos.php' ? 'activo' : '' ?>">GESTIÓN PEDIDOS</a>
      <?php else: ?>
        <a href="<?= BASE_URL ?>/personalizar" class="<?= strpos($_SERVER['REQUEST_URI'], '/personalizar') !== false ? 'activo' : '' ?>">PERSONALIZACIÓN</a>
        <a href="<?= BASE_URL ?>/inspiracion" class="<?= strpos($_SERVER['REQUEST_URI'], '/inspiracion') !== false ? 'activo' : '' ?>">INSPIRACIÓN</a>
      <?php endif; ?>
    </nav>

    <!-- Íconos a la derecha -->
    <div class="menu-derecha">
      <a href="#"><img src="<?= BASE_URL ?>/assets/img/icons/gem.svg" alt="Favoritos" class="icono"></a>
      <a href="#"><img src="<?= BASE_URL ?>/assets/img/icons/bluesky.svg" alt="Carrito" class="icono"></a>

      <div class="perfil-wrapper">
        <?php if ($usu_nombre): ?>
          <div class="avatar" id="icono-usuario">
            <?= strtoupper(substr($usu_nombre, 0, 1)) ?>
          </div>
        <?php else: ?>
          <a href="<?= BASE_URL ?>/login" class="btn-login">Iniciar sesión</a>
        <?php endif; ?>

        <?php if ($rol_id): ?>
        <div class="menu-usuario" id="menu-usuario">
          <p class="px-3 fw-bold"><?= htmlspecialchars($usu_nombre) ?></p>

          <?php if ($rol_id === 1): ?>
            <a href="<?= BASE_URL ?>/usuario/mi-perfil.php">Mi perfil</a>
            <a href="<?= BASE_URL ?>/usuario/mis-pedidos.php">Mis pedidos</a>
          <?php elseif ($rol_id === 2): ?>
            <a href="<?= BASE_URL ?>/admin/gestion-usuarios.php">Gestión usuarios</a>
            <a href="<?= BASE_URL ?>/admin/gestion-inspiracion.php">Gestión inspiración</a>
            <a href="<?= BASE_URL ?>/admin/gestion-opciones.php">Gestión personalización</a>
            <a href="<?= BASE_URL ?>/admin/gestion-pedidos.php">Gestión pedidos</a>
          <?php endif; ?>

          <a href="<?= BASE_URL ?>/php/logout.php">Cerrar sesión</a>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</header>
