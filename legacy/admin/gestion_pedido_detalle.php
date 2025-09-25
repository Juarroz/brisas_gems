<?php
require_once '../php/conexion.php';
session_start();

// Validar acceso y rol (opcional según seguridad)
if (!isset($_SESSION['rol_id']) || !in_array($_SESSION['rol_id'], [2, 3])) {
    header('Location: ../index.php');
    exit;
}

$ped_id = $_GET['ped_id'] ?? null;
if (!$ped_id) {
    echo "ID de pedido no proporcionado.";
    exit;
}

// Obtener datos del pedido
$stmt = $conn->prepare("SELECT p.*, e.est_nombre 
                        FROM pedido p 
                        JOIN estado_pedido e ON p.est_id = e.est_id 
                        WHERE p.ped_id = ?");
$stmt->bind_param("i", $ped_id);
$stmt->execute();
$pedido = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Obtener estados posibles
$estados = $conn->query("SELECT * FROM estado_pedido")->fetch_all(MYSQLI_ASSOC);

// Obtener historial de pedidos activos
$historial = $conn->query("SELECT p.ped_id, p.ped_codigo, p.ped_fecha_creacion, e.est_nombre
                           FROM pedido p 
                           JOIN estado_pedido e ON p.est_id = e.est_id 
                           WHERE p.est_id < 5
                           ORDER BY p.ped_fecha_creacion DESC")->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle del Pedido</title>
  <link rel="stylesheet" href="../css/assets/css-global/main.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container my-5">

  <h1 class="mb-4">Detalle del Pedido: <?= htmlspecialchars($pedido['ped_codigo']) ?></h1>

  <!-- Subir Render -->
  <section class="mb-5">
    <h2 class="h5">1. Subir diseño 3D renderizado</h2>
    <form action="../php/upload_render.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="ped_id" value="<?= $ped_id ?>">
      <div class="mb-3">
        <input type="file" class="form-control" name="render_file" accept=".obj,.stl" required>
      </div>
      <button class="btn btn-primary" type="submit">Subir Render</button>
    </form>
    <?php if (!empty($pedido['render_url'])): ?>
      <div class="mt-3">
        <model-viewer src="../<?= $pedido['render_url'] ?>" camera-controls style="width:100%;height:400px;"></model-viewer>
      </div>
    <?php endif; ?>
  </section>

  <!-- Subir Imagen Final -->
  <section class="mb-5">
    <h2 class="h5">2. Subir imagen del producto terminado</h2>
    <form action="../php/upload_final_photo.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="ped_id" value="<?= $ped_id ?>">
      <div class="mb-3">
        <input type="file" class="form-control" name="photo_file" accept=".jpg,.jpeg,.png" required>
      </div>
      <button class="btn btn-primary" type="submit">Subir Imagen Final</button>
    </form>
    <?php if (!empty($pedido['foto_final_url'])): ?>
      <div class="mt-3">
        <img src="../<?= $pedido['foto_final_url'] ?>" class="img-fluid" alt="Foto producto final">
      </div>
    <?php endif; ?>
  </section>

  <!-- Comentarios -->
  <section class="mb-5">
    <h2 class="h5">3. Comentarios y notas</h2>
    <form action="../php/update_pedido_comments.php" method="post">
      <input type="hidden" name="ped_id" value="<?= $ped_id ?>">
      <textarea class="form-control" name="comentario" rows="4" required><?= htmlspecialchars($pedido['ped_comentarios'] ?? '') ?></textarea>
      <button class="btn btn-secondary mt-2" type="submit">Guardar comentario</button>
    </form>
  </section>

  <!-- Estado -->
  <section class="mb-5">
    <h2 class="h5">4. Estado del pedido</h2>
    <form action="../php/update_pedido_status.php" method="post">
      <input type="hidden" name="ped_id" value="<?= $ped_id ?>">
      <div class="row g-2">
        <div class="col-md-6">
          <select name="est_id" class="form-select" required>
            <?php foreach ($estados as $e): ?>
              <option value="<?= $e['est_id'] ?>" <?= $pedido['est_id'] == $e['est_id'] ? 'selected' : '' ?>>
                <?= $e['est_nombre'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2">
          <button class="btn btn-success" type="submit">Actualizar</button>
        </div>
      </div>
    </form>
    <div class="progress mt-3" style="height: 20px;">
      <div class="progress-bar" role="progressbar" style="width: <?= $pedido['est_id'] * 20 ?>%">
        <?= $pedido['est_id'] * 20 ?>%
      </div>
    </div>
  </section>

  <!-- Historial -->
  <section>
    <h2 class="h5">5. Historial de pedidos</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Código</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($historial as $h): ?>
          <tr>
            <td><?= htmlspecialchars($h['ped_codigo']) ?></td>
            <td><?= $h['ped_fecha_creacion'] ?></td>
            <td><?= $h['est_nombre'] ?></td>
            <td>
              <a href="gestion-pedido-detalle.php?ped_id=<?= $h['ped_id'] ?>" class="btn btn-sm btn-outline-primary">Ver</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>

</div>

<?php include '../includes/footer.php'; ?>
<script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
</body>
</html>