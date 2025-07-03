<?php
$nombreUsuario = $_SESSION['usu_nombre'] ?? null;
?>

<header class="encabezado">
  <div class="contenedor-header">
    <!-- Menú izquierdo -->
    <nav class="nav-izquierda">
      <a href="personalizar.php">PERSONALIZACION</a>
      <a href="inspiracion.php">INSPIRACION</a>
    </nav>

    <!-- Logo centrado -->
    <div class="logo-centro">
      <a href="index.php">
        <img src="./img/logo.png" alt="Logo Brisas Gems">
      </a>
    </div>

    <!-- Íconos a la derecha -->
    <div class="menu-derecha">
      <div class="perfil-wrapper">
        <img src="./img/person.svg" alt="Perfil" class="icono" id="icono-usuario">
        <div class="menu-usuario" id="menu-usuario">
          <?php if ($nombreUsuario): ?>
            <span class="px-2">Hola, <?= htmlspecialchars($nombreUsuario) ?></span>
            <a href="./usuario/mi-perfil.html">Mi perfil</a>
            <a href="./usuario/mis-pedidos.html">Mis pedidos</a>
            <a href="php/logout.php">Cerrar sesión</a>
          <?php else: ?>
            <a href="login.html">Iniciar sesión</a>
            <a href="registro.html">Registrarse</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</header>