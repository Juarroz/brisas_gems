<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sistema interactivo de Brisas Gems para la personalización de joyas en línea">
  <meta name="author" content="Johan Bocanegra">
  <link rel="icon" href="./img/icono.png">
  <title>Seguimiento de Pedido | Brisas Gems</title>
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/assets/css-global/main.css">
  <link rel="stylesheet" href="./css/inspiracion.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<!-- CONTENIDO PRINCIPAL -->

<div class="main-content">
  <div class="portafolio">
    <h3><strong>CREACIONES DESTACADAS</strong></h3>
    <div id="contenedor-inspiraciones">
      <?php
      require_once 'php/conexion.php';
      $sql = "SELECT por_id, por_titulo, por_descripcion, por_imagen, por_video, por_categoria FROM portafolio_inspiracion ORDER BY por_fecha DESC";
      $result = $conn->query($sql);
      if ($result && $result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
          $titulo = htmlspecialchars($row['por_titulo']);
          $descripcion = htmlspecialchars($row['por_descripcion']);
          $imagen = htmlspecialchars($row['por_imagen']);
          $categoria = htmlspecialchars($row['por_categoria']);
      ?>
      <div class="carta">
        <div class="card-body cara frente">
          <div class="card-img-container">
            <img src="<?= $imagen ?>" alt="Joyería" loading="lazy">
          </div>
          <h5 class="card-title"><strong><?= $titulo ?></strong></h5>
          <p class="card-text"><?= $descripcion ?></p>
        </div>
        <div class="card-body cara atras">
          <h5 class="card-title"><strong>Detalles del Diseño</strong></h5>
          <ul class="list-unstyled">
            <li>○ Categoría: <?= $categoria ?></li>
            <!-- Puedes agregar aquí más detalles si los agregas en la base de datos -->
          </ul>
        </div>
      </div>
      <?php endwhile; else: ?>
        <p class="text-center">No hay inspiraciones registradas aún.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
  // Script para menú usuario (evita conflicto si se incluye varias veces)
  document.addEventListener('DOMContentLoaded', function() {
    const iconoUsuario = document.getElementById('icono-usuario');
    const menuUsuario = document.getElementById('menu-usuario');
    if (iconoUsuario && menuUsuario) {
      iconoUsuario.addEventListener('click', (e) => {
        e.stopPropagation();
        menuUsuario.classList.toggle('activo');
      });
      document.addEventListener('click', (e) => {
        if (!iconoUsuario.contains(e.target) && !menuUsuario.contains(e.target)) {
          menuUsuario.classList.remove('activo');
        }
      });
    }
  });
</script>
</body>
</html>