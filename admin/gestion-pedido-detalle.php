<?php
require_once '../includes/header.php';
require_once '../php/conexion.php';
if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] != 2) {
  header("Location: ../login.php");
  exit;
}
$ped_id = isset($_GET['ped_id']) ? intval($_GET['ped_id']) : 0;
if (!$ped_id) {
  echo '<div class="alert alert-danger">ID de pedido no válido.</div>';
  exit;
}
$sql = "SELECT p.ped_id, p.ped_codigo, p.ped_fecha_creacion, ep.est_nombre, p.ped_comentarios,
    u.usu_nombre, u.usu_correo,
    (SELECT ren_imagen FROM render_3d WHERE ped_id = p.ped_id LIMIT 1) as render_3d,
    (SELECT fot_imagen_final FROM foto_producto_final WHERE ped_id = p.ped_id LIMIT 1) as imagen_final
FROM pedido p
INNER JOIN estado_pedido ep ON p.est_id = ep.est_id
INNER JOIN usuarios u ON p.usu_id = u.usu_id
WHERE p.ped_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $ped_id);
$stmt->execute();
$res = $stmt->get_result();
$pedido = $res->fetch_assoc();
if (!$pedido) {
  echo '<div class="alert alert-warning">Pedido no encontrado.</div>';
  exit;
}
// Detalles de personalización
$sql_det = "SELECT op.opc_nombre, vp.val_nombre
    FROM pedido pd
    JOIN personalizacion per ON pd.per_id = per.per_id
    JOIN detalle_personalizacion dp ON per.per_id = dp.per_id
    JOIN valor_personalizacion vp ON dp.val_id = vp.val_id
    JOIN opcion_personalizacion op ON vp.opc_id = op.opc_id
    WHERE pd.ped_id = ?";
$stmt_det = $conn->prepare($sql_det);
$stmt_det->bind_param('i', $ped_id);
$stmt_det->execute();
$res_det = $stmt_det->get_result();
$detalles = $res_det->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle del Pedido</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/assets/css-global/main.css">
</head>
<body>
<main class="container my-5">
  <h2>Detalle del Pedido <?= htmlspecialchars($pedido['ped_codigo']) ?></h2>
  <ul class="list-group mb-3">
    <li class="list-group-item"><strong>Cliente:</strong> <?= htmlspecialchars($pedido['usu_nombre']) ?> (<?= htmlspecialchars($pedido['usu_correo']) ?>)</li>
    <li class="list-group-item"><strong>Fecha:</strong> <?= htmlspecialchars($pedido['ped_fecha_creacion']) ?></li>
    <li class="list-group-item"><strong>Estado:</strong> <?= htmlspecialchars($pedido['est_nombre']) ?></li>
    <li class="list-group-item"><strong>Comentarios:</strong> <?= htmlspecialchars($pedido['ped_comentarios'] ?? 'Sin comentarios') ?></li>
  </ul>
  <h4>Personalización</h4>
  <ul class="list-group mb-3">
    <?php foreach ($detalles as $det): ?>
      <li class="list-group-item"><strong><?= htmlspecialchars($det['opc_nombre']) ?>:</strong> <?= htmlspecialchars($det['val_nombre']) ?></li>
    <?php endforeach; ?>
  </ul>
  <h4>Render 3D</h4>
  <?php if ($pedido['render_3d']): ?>
    <model-viewer src="../<?= htmlspecialchars($pedido['render_3d']) ?>" alt="Render 3D" auto-rotate camera-controls ar style="width: 100%; height: 350px;"></model-viewer>
  <?php else: ?>
    <div class="alert alert-warning">Render 3D no disponible aún.</div>
  <?php endif; ?>
  <h4 class="mt-4">Imagen final del producto</h4>
  <?php if ($pedido['imagen_final']): ?>
    <img src="../<?= htmlspecialchars($pedido['imagen_final']) ?>" alt="Imagen final" class="img-fluid rounded">
  <?php else: ?>
    <div class="alert alert-warning">Imagen final no disponible aún.</div>
  <?php endif; ?>
  <a href="gestion-pedidos.php" class="btn btn-secondary mt-4">Volver a la lista</a>
</main>
<script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
