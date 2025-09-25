<?php
session_start();
if (!isset($_SESSION['usu_id']) || $_SESSION['rol_id'] != 2) {
    header('Location: ../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Opciones de Personalización</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/assets/css-global/main.css">
    <link rel="stylesheet" href="../css/gestion-inspiracion.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .img-preview { max-width: 80px; max-height: 80px; object-fit: contain; }
    </style>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container py-4">
    <h2 class="mb-4 text-center">Gestión de Opciones de Personalización</h2>
    <div class="mb-3 text-end">
        <button class="btn btn-success" id="btn-agregar-opcion"><i class="bi bi-plus-circle"></i> Agregar opción</button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered align-middle shadow-sm" id="tabla-opciones">
            <thead class="table-light">
                <tr>
                    <th>Nombre de Opción</th>
                    <th>Imagen</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se cargan las opciones dinámicamente -->
            </tbody>
        </table>
    </div>
    <!-- Modal para agregar/editar opción -->
    <div class="modal fade" id="modalOpcion" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="form-opcion" autocomplete="off" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="modalOpcionLabel">Agregar/Editar Opción</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="opcion_id" name="opcion_id">
              <div class="mb-3">
                <label for="nombre_opcion" class="form-label">Nombre de la opción</label>
                <input type="text" class="form-control" id="nombre_opcion" name="nombre_opcion" required maxlength="100">
              </div>
              <div class="mb-3">
                <label for="descripcion_opcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion_opcion" name="descripcion_opcion" maxlength="255" rows="2"></textarea>
              </div>
              <div class="mb-3">
                <label for="imagen_opcion" class="form-label">Imagen (PNG/JPG)</label>
                <input type="file" class="form-control" id="imagen_opcion" name="imagen_opcion" accept="image/png, image/jpeg">
                <div class="mt-2">
                  <img id="preview-imagen-opcion" class="img-preview d-none" src="#" alt="Vista previa">
                </div>
                <div class="invalid-feedback" id="error-imagen-opcion"></div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/gestion-opciones.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const iconoUsuario = document.getElementById('icono-usuario');
  const menuUsuario = document.getElementById('menu-usuario');
  if (iconoUsuario && menuUsuario) {
    iconoUsuario.addEventListener('click', function(e) {
      e.stopPropagation();
      menuUsuario.classList.toggle('activo');
    });
    document.addEventListener('click', function(e) {
      if (!menuUsuario.contains(e.target) && e.target !== iconoUsuario) {
        menuUsuario.classList.remove('activo');
      }
    });
  }
});
</script>
</body>
</html>
