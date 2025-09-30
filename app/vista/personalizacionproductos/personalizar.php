<?php
// app/vista/personalizacionproductos/personalizar.php

if (!function_exists('e')) { 
  function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); } 
}

// Recibe $CATALOGO dinámico desde el controller
$cat = $CATALOGO ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Personalización de Joya · Brisas Gems</title>
  <link rel="icon" href="<?= BASE_URL ?>/assets/icons/icono.png" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/main.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/header.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/personalizar.css" />
</head>
<body>

<?php include BASE_PATH . '/public/includes/header.php'; ?>

<main class="container my-5">

  <!-- Flash / mensajes -->
  <div class="row">
    <div class="col-12 mb-3">
      <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?= e($_SESSION['flash_message']['type'] ?? 'info') ?>">
          <?= e($_SESSION['flash_message']['text'] ?? '') ?>
        </div>
        <?php unset($_SESSION['flash_message']); ?>
      <?php elseif (!empty($_GET['msg'])): ?>
        <div class="alert alert-danger">
          Ocurrió un problema (<?= e($_GET['msg']) ?>). Intenta de nuevo.
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="row g-4">
    <!-- Columna izquierda: Vista previa -->
    <div class="col-md-6">
      <section>
        <h2 class="h5 seccion-titulo text-center">Vista previa</h2>
        <img id="vista-principal"
             src="<?= BASE_URL ?>/assets/img/personalizacionproductos/placeholder.jpg"
             alt="Vista previa de la joya"
             class="img-fluid mb-3 d-block mx-auto vista-principal">
        <div class="d-flex justify-content-center gap-3">
          <img id="vista-superior" class="miniatura" width="72"
               src="<?= BASE_URL ?>/assets/img/personalizacionproductos/placeholder.jpg"
               alt="Vista Superior" onclick="cambiarVista(this)">
          <img id="vista-frontal" class="miniatura" width="72"
               src="<?= BASE_URL ?>/assets/img/personalizacionproductos/placeholder.jpg"
               alt="Vista Frontal" onclick="cambiarVista(this)">
          <img id="vista-perfil" class="miniatura" width="72"
               src="<?= BASE_URL ?>/assets/img/personalizacionproductos/placeholder.jpg"
               alt="Vista Perfil" onclick="cambiarVista(this)">
        </div>
      </section>
    </div>

    <!-- Columna derecha: Categorías dinámicas -->
    <div class="col-md-6">
      <div class="container-opciones">
        <form method="post" action="<?= BASE_URL ?>/personalizar/guardar" id="form-personalizar">

          <?php foreach ($cat as $slug => $opc): ?>
            <section class="mb-4">
              <h3 class="h5 seccion-titulo"><?= e($opc['nombre']) ?></h3>
              <div class="d-flex flex-wrap gap-2" id="grupo-<?= e($slug) ?>">
                <?php foreach ($opc['valores'] as $i => $v): ?>
                  <button type="button"
                          class="btn-opcion btn-<?= e($slug) ?> <?= $i===0 ? 'active' : '' ?>"
                          data-valor="<?= e($v['slug']) ?>">
                    <?php if (!empty($v['img'])): ?>
                      <img src="<?= BASE_URL ?>/assets/img/personalizacionproductos/opciones/<?= e($slug) ?>/<?= e($v['slug']) ?>.png"
                           alt="<?= e($v['nombre']) ?>" width="40"><br>
                    <?php endif; ?>
                    <?= e($v['nombre']) ?>
                  </button>
                <?php endforeach; ?>
              </div>
            </section>
          <?php endforeach; ?>

          <!-- Hidden inputs dinámicos -->
          <?php foreach ($cat as $slug => $opc): ?>
            <input type="hidden" name="<?= e($slug) ?>" id="f-<?= e($slug) ?>">
          <?php endforeach; ?>

          <div class="text-center contenedor-boton">
            <button type="submit" class="btn btn-primary">Guardar y hablar con un asesor</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<?php include BASE_PATH . '/public/includes/footer.php'; ?>

<script src="<?= BASE_URL ?>/assets/js/personalizar.js"></script>
<script src="<?= BASE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
