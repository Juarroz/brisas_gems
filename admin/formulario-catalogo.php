<?php
// Control de sesión para acceso solo a administradores
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usu_id']) || $_SESSION['rol_id'] != 2) {
    header('Location: ../login.php');
    exit();
}

require_once '../php/conexion.php';
$usu_id = $_SESSION['usu_id'];
$usu_nombre = $_SESSION['usu_nombre'] ?? '';

// Si viene por GET con por_id, es edición, si no, es alta
$editando = false;
$inspiracion = [
    'por_id' => '',
    'por_titulo' => '',
    'por_descripcion' => '',
    'por_imagen' => '',
    'por_video' => '',
    'por_categoria' => ''
];
if (isset($_GET['por_id'])) {
    $editando = true;
    $por_id = intval($_GET['por_id']);
    $stmt = $conn->prepare('SELECT por_id, por_titulo, por_descripcion, por_imagen, por_video, por_categoria FROM portafolio_inspiracion WHERE por_id = ?');
    $stmt->bind_param('i', $por_id);
    $stmt->execute();
    $stmt->bind_result($inspiracion['por_id'], $inspiracion['por_titulo'], $inspiracion['por_descripcion'], $inspiracion['por_imagen'], $inspiracion['por_video'], $inspiracion['por_categoria']);
    $stmt->fetch();
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title><?= $editando ? 'Editar' : 'Agregar' ?> Inspiración</title>
  <link rel="icon" href="../img/icono.png">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/assets/css-global/main.css">
  <link rel="stylesheet" href="../css/gestion-inspiracion.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container py-5">
  <h2 class="mb-4 text-center"><?= $editando ? 'Editar' : 'Agregar' ?> Inspiración</h2>
  <form id="form-inspiracion" class="mx-auto" style="max-width: 500px;" method="post" enctype="multipart/form-data">
    <?php if ($editando): ?>
      <input type="hidden" name="por_id" value="<?= htmlspecialchars($inspiracion['por_id']) ?>">
    <?php endif; ?>
    <div class="mb-3">
      <label for="por_titulo" class="form-label">Título</label>
      <input type="text" class="form-control" id="por_titulo" name="por_titulo" required value="<?= htmlspecialchars($inspiracion['por_titulo']) ?>">
    </div>
    <div class="mb-3">
      <label for="por_descripcion" class="form-label">Descripción</label>
      <textarea class="form-control" id="por_descripcion" name="por_descripcion" rows="3" required><?= htmlspecialchars($inspiracion['por_descripcion']) ?></textarea>
    </div>
    <div class="mb-3">
      <label for="por_imagen" class="form-label">Imagen</label>
      <input type="file" class="form-control" id="por_imagen" name="por_imagen" accept="image/*" <?= $editando ? '' : 'required' ?>>
      <div id="preview-imagen" class="mt-2"></div>
      <?php if ($editando && $inspiracion['por_imagen']): ?>
        <div class="mt-2">
          <img src="../<?= htmlspecialchars($inspiracion['por_imagen']) ?>" alt="Imagen actual" style="max-width:120px;">
          <input type="hidden" name="por_imagen_actual" value="<?= htmlspecialchars($inspiracion['por_imagen']) ?>">
        </div>
      <?php endif; ?>
    </div>
    <div class="mb-3">
      <label for="por_video" class="form-label">URL Video (opcional)</label>
      <input type="text" class="form-control" id="por_video" name="por_video" value="<?= htmlspecialchars($inspiracion['por_video']) ?>">
    </div>
    <div class="mb-3">
      <label for="por_categoria" class="form-label">Categoría</label>
      <input type="text" class="form-control" id="por_categoria" name="por_categoria" required value="<?= htmlspecialchars($inspiracion['por_categoria']) ?>">
    </div>
    <div class="d-grid">
      <button type="submit" class="btn btn-primary"><?= $editando ? 'Guardar Cambios' : 'Agregar Inspiración' ?></button>
    </div>
  </form>
  <div id="alerta-inspiracion" class="mt-3"></div>
</div>
<script>
// Vista previa de imagen antes de subir
const inputImagen = document.getElementById('por_imagen');
const preview = document.getElementById('preview-imagen');
inputImagen.addEventListener('change', function(e) {
  preview.innerHTML = '';
  if (this.files && this.files[0]) {
    const reader = new FileReader();
    reader.onload = function(ev) {
      preview.innerHTML = `<img src='${ev.target.result}' alt='Vista previa' style='max-width:120px; border-radius:8px; box-shadow:0 2px 8px #ccc;'>`;
    };
    reader.readAsDataURL(this.files[0]);
  }
});

document.getElementById('form-inspiracion').addEventListener('submit', function(e) {
  e.preventDefault();
  const form = e.target;
  const data = new FormData(form);
  const url = '<?= $editando ? '../php/inspiracion/editar.php' : '../php/inspiracion/agregar.php' ?>';
  fetch(url, {
    method: 'POST',
    body: data
  })
  .then(r => r.json())
  .then(res => {
    const alerta = document.getElementById('alerta-inspiracion');
    if (res.success) {
      alerta.innerHTML = `<div class='alert alert-success'>${res.message || '¡Guardado correctamente!'}</div>`;
      setTimeout(() => { window.location.href = 'gestion-inspiracion.php'; }, 1200);
    } else {
      alerta.innerHTML = `<div class='alert alert-danger'>${res.error || 'Ocurrió un error.'}</div>`;
    }
  });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
