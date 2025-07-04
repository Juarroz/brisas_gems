<?php
require_once '../includes/header.php';
require_once '../php/conexion.php';

if (!isset($_SESSION['rol_id']) || !in_array($_SESSION['rol_id'], [2, 3])) {
  header("Location: ../login.php");
  exit;
}

$sql = "SELECT p.ped_id, p.ped_codigo, p.ped_fecha_creacion, u.usu_nombre, e.est_nombre
        FROM pedido p
        JOIN personalizacion per ON p.per_id = per.per_id
        JOIN usuarios u ON per.usu_id_cliente = u.usu_id
        JOIN estado_pedido e ON p.est_id = e.est_id
        ORDER BY p.ped_fecha_creacion DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestión de Pedidos</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/assets/css-global/main.css">
  <link rel="stylesheet" href="../css/mis-pedidos.css">
</head>
<body>

<main class="container my-5">
  <h2 class="mb-4">Lista de Pedidos</h2>
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Código</th>
        <th>Cliente</th>
        <th>Fecha</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($fila = $resultado->fetch_assoc()): ?>
        <tr>
          <td><?= $fila['ped_id'] ?></td>
          <td><?= $fila['ped_codigo'] ?></td>
          <td><?= $fila['usu_nombre'] ?></td>
          <td><?= $fila['ped_fecha_creacion'] ?></td>
          <td><?= $fila['est_nombre'] ?></td>
          <td>
            <a href="gestion-pedido-detalle.php?ped_id=<?= $fila['ped_id'] ?>" class="btn btn-sm btn-primary">
              Ver Detalle
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>