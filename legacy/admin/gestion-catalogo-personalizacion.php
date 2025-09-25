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
    <title>Gestión de Catálogo de Personalización</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/gestion-inspiracion.css">
    <link rel="stylesheet" href="../css/assets/css-global/global.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .img-preview { max-width: 80px; max-height: 80px; object-fit: contain; }
    </style>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container py-4">
    <h2 class="mb-4 text-center">Gestión de Catálogo de Personalización</h2>
    <div class="mb-3 text-end">
        <button class="btn btn-success" id="btn-agregar-valor"><i class="bi bi-plus-circle"></i> Agregar valor</button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered align-middle shadow-sm" id="tabla-catalogo">
            <thead class="table-light">
                <tr>
                    <th>Opción</th>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se cargan los valores dinámicamente -->
            </tbody>
        </table>
    </div>
    <!-- Modal para agregar/editar valor -->
    <div class="modal fade" id="modalValor" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="form-valor" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
              <h5 class="modal-title" id="modalValorLabel">Agregar/Editar Valor</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="valor_id" name="valor_id">
              <div class="mb-3">
                <label for="opcion" class="form-label">Opción</label>
                <select class="form-select" id="opcion" name="opcion" required></select>
              </div>
              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="100">
              </div>
              <div class="mb-3">
                <label for="imagen" class="form-label">Imagen (PNG/JPG, máx 2MB)</label>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/png, image/jpeg">
                <img id="img-preview" class="img-preview mt-2" style="display:none;" alt="Vista previa" />
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
<script src="../js/gestion-catalogo-personalizacion.js"></script>
</body>
</html>
