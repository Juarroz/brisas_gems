<?php
require_once '../includes/header.php';
require_once '../php/conexion.php';
require_once '../php/admin/PedidoProduccionModel.php';

if (!isset($_SESSION['rol_id']) || !in_array($_SESSION['rol_id'], [2, 3])) {
  header("Location: ../login.php");
  exit;
}

$model = new PedidoProduccionModel($conn);
$pedidos = $model->listarPedidos();
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
  <h2 class="mb-4">Gestión de Producción de Pedidos</h2>
  <table class="table table-bordered table-hover align-middle table-responsive-md" style="background:#fff;">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Código</th>
        <th>Cliente</th>
        <th>Fecha</th>
        <th>Estado</th>
        <th>Progreso</th>
        <th>Render 3D</th>
        <th>Imagen Final</th>
        <th>Comentarios</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($pedidos as $p): ?>
        <tr>
          <td><?= $p['ped_id'] ?></td>
          <td><?= $p['ped_codigo'] ?></td>
          <td><?= $p['usu_nombre'] ?></td>
          <td><?= $p['ped_fecha_creacion'] ?></td>
          <td><span class="badge bg-info text-dark fs-6 px-3 py-2"><?= $p['est_nombre'] ?></span></td>
          <td>
            <?php
              $progreso = 0;
              switch ((int)($p['est_id'] ?? 0)) {
                case 1: $progreso = 30; break;
                case 2: $progreso = 60; break;
                case 3: $progreso = 60; break;
                case 4: $progreso = 80; break;
                case 5: $progreso = 100; break;
                default: $progreso = 10;
              }
            ?>
            <div class="progress" style="height: 18px; min-width:120px;">
              <div class="progress-bar bg-success" role="progressbar" style="width: <?= $progreso ?>%;" aria-valuenow="<?= $progreso ?>" aria-valuemin="0" aria-valuemax="100">
                <?= $progreso ?>%
              </div>
            </div>
          </td>
          <td class="text-center">
            <?php if ($p['render_3d']): ?>
              <a href="<?= $p['render_3d'] ?>" target="_blank" class="btn btn-outline-info btn-sm mb-1" title="Ver render"><i class="bi bi-cube"></i></a>
            <?php endif; ?>
            <button class="btn btn-outline-primary btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modalRender" data-pedid="<?= $p['ped_id'] ?>">Subir/Editar</button>
          </td>
          <td class="text-center">
            <?php if ($p['imagen_final']): ?>
              <a href="<?= $p['imagen_final'] ?>" target="_blank" class="btn btn-outline-success btn-sm mb-1" title="Ver imagen final"><i class="bi bi-camera"></i></a>
            <?php endif; ?>
            <button class="btn btn-outline-primary btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modalImagenFinal" data-pedid="<?= $p['ped_id'] ?>">Subir/Editar</button>
          </td>
          <td style="max-width:180px;">
            <div class="small text-secondary mb-1" style="white-space:pre-line; word-break:break-word;">
              <?= htmlspecialchars($p['ped_comentarios']) ?: '<span class="text-muted">Sin comentarios</span>' ?>
            </div>
            <button class="btn btn-outline-secondary btn-sm mt-1" data-bs-toggle="modal" data-bs-target="#modalComentario" data-pedid="<?= $p['ped_id'] ?>" data-comentario="<?= htmlspecialchars($p['ped_comentarios']) ?>">Editar</button>
          </td>
          <td>
            <button class="btn btn-outline-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modalEstado" data-pedid="<?= $p['ped_id'] ?>">Actualizar Estado</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Modal Render 3D -->
  <div class="modal fade" id="modalRender" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="formRender3D" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title">Subir Render 3D</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="ped_id" id="render_ped_id">
            <input type="file" name="render_file" accept=".obj,.stl" required class="form-control">
            <div class="form-text">Formatos permitidos: .OBJ, .STL</div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Subir</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Imagen Final -->
  <div class="modal fade" id="modalImagenFinal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="formImagenFinal" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title">Subir Imagen Final</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="ped_id" id="img_ped_id">
            <input type="file" name="img_file" accept=".jpg,.jpeg,.png" required class="form-control">
            <div class="form-text">Formatos permitidos: JPG, PNG</div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Subir</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Comentario -->
  <div class="modal fade" id="modalComentario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="formComentario">
          <div class="modal-header">
            <h5 class="modal-title">Agregar/Editar Comentario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="ped_id" id="coment_ped_id">
            <textarea name="comentario" id="comentario_text" class="form-control" rows="4" required></textarea>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Estado -->
  <div class="modal fade" id="modalEstado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="formEstado">
          <div class="modal-header">
            <h5 class="modal-title">Actualizar Estado del Pedido</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="ped_id" id="estado_ped_id">
            <select name="est_id" class="form-select" required>
              <option value="1">Diseño</option>
              <option value="5">Finalizado</option>
              <option value="2">Producción</option>
              <option value="3">Ensamblaje</option>
              <option value="4">Envío</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Asignar el id del pedido a los formularios de los modales
  const modalRender = document.getElementById('modalRender');
  modalRender.addEventListener('show.bs.modal', function (event) {
    const btn = event.relatedTarget;
    document.getElementById('render_ped_id').value = btn.getAttribute('data-pedid');
  });
  const modalImagen = document.getElementById('modalImagenFinal');
  modalImagen.addEventListener('show.bs.modal', function (event) {
    const btn = event.relatedTarget;
    document.getElementById('img_ped_id').value = btn.getAttribute('data-pedid');
  });
  const modalComent = document.getElementById('modalComentario');
  modalComent.addEventListener('show.bs.modal', function (event) {
    const btn = event.relatedTarget;
    document.getElementById('coment_ped_id').value = btn.getAttribute('data-pedid');
    document.getElementById('comentario_text').value = btn.getAttribute('data-comentario') || '';
  });
  const modalEstado = document.getElementById('modalEstado');
  modalEstado.addEventListener('show.bs.modal', function (event) {
    const btn = event.relatedTarget;
    document.getElementById('estado_ped_id').value = btn.getAttribute('data-pedid');
  });

  // Subida de Render 3D
  const formRender = document.getElementById('formRender3D');
  formRender.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(formRender);
    formData.append('accion', 'subir_render');
    fetch('../php/admin/gestion_pedidos_api.php', {
      method: 'POST',
      body: formData
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        alert('Render subido correctamente');
        location.reload();
      } else {
        alert(data.msg || 'Error al subir render');
      }
    });
  });

  // Subida de Imagen Final
  const formImg = document.getElementById('formImagenFinal');
  formImg.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(formImg);
    formData.append('accion', 'subir_imagen_final');
    fetch('../php/admin/gestion_pedidos_api.php', {
      method: 'POST',
      body: formData
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        alert('Imagen final subida correctamente');
        location.reload();
      } else {
        alert(data.msg || 'Error al subir imagen');
      }
    });
  });

  // Guardar comentario
  const formComent = document.getElementById('formComentario');
  formComent.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(formComent);
    formData.append('accion', 'guardar_comentario');
    fetch('../php/admin/gestion_pedidos_api.php', {
      method: 'POST',
      body: formData
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        alert('Comentario guardado');
        location.reload();
      } else {
        alert(data.msg || 'Error al guardar comentario');
      }
    });
  });

  // Actualizar estado
  const formEstado = document.getElementById('formEstado');
  formEstado.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(formEstado);
    formData.append('accion', 'actualizar_estado');
    fetch('../php/admin/gestion_pedidos_api.php', {
      method: 'POST',
      body: formData
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        alert('Estado actualizado');
        location.reload();
      } else {
        alert(data.msg || 'Error al actualizar estado');
      }
    });
  });
</script>
</body>
</html>