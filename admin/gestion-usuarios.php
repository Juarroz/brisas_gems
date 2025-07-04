<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema interactivo de Brisas Gems para la personalización de joyas en línea">
    <meta name="author" content="Johan Bocanegra">
    <link rel="icon" href="../img/icono.png">
    <title>Gestion De Usuarios Y Roles 1</title>
  <!-- Estilos globales primero -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/assets/css-global/main.css">
  <link rel="stylesheet" href="../css/mis-pedidos.css">
  </head>
<body>

<?php include '../includes/header.php'; ?>

<main class="container my-5 Contenido">

  <!-- Título principal -->
  <h1 class="mb-4 text-center">Gestión de Usuarios y Roles</h1>

  <!-- Botón para agregar usuario -->
  <div class="d-flex justify-content-end mb-3">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregar">
      <i class="bi bi-person-plus"></i> Agregar Usuario
    </button>
  </div>

  <!-- Tabla de usuarios -->
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Teléfono</th>
          <th>Documento</th>
          <th>Rol</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="tabla-usuarios">
        <?php include '../php/usuarios/listar_usuarios.php'; ?>
      </tbody>
    </table>
  </div>

</main>

<!-- Modal: Agregar Usuario -->
<div class="modal fade" id="modalAgregar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="/brisas_gems/php/usuarios/agregar_usuario.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar nuevo usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body row g-3">
        
        <div class="col-md-6">
          <label class="form-label">Nombre completo</label>
          <input type="text" class="form-control" name="usu_nombre" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Correo electrónico</label>
          <input type="email" class="form-control" name="usu_correo" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Teléfono</label>
          <input type="tel" class="form-control" name="usu_telefono">
        </div>

        <div class="col-md-6">
          <label class="form-label">Tipo de documento</label>
          <select class="form-select" name="tipdoc_id" required>
            <option value="">Seleccione...</option>
            <option value="1">Cédula de ciudadanía</option>
            <option value="2">Cédula de extranjería</option>
            <option value="3">Pasaporte</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label">Número de documento</label>
          <input type="text" class="form-control" name="usu_docnum" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Contraseña</label>
          <input type="password" class="form-control" name="usu_password" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Rol</label>
          <select class="form-select" name="rol_id" required>
            <option value="">Seleccione...</option>
            <option value="1">Cliente</option>
            <option value="2">Diseñador</option>
            <option value="3">Administrador</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label">Estado</label>
          <select class="form-select" name="usu_activo" required>
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
          </select>
        </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar usuario</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Editar Rol -->
<div class="modal fade" id="modalEditarRol" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="../php/usuarios/actualizar_rol.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Rol de <span id="nombre-usuario-rol"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="usu_id" id="editar-usu-id">
        <div class="mb-3">
          <label class="form-label">Nuevo Rol</label>
          <select class="form-select" name="rol_id" required>
            <option value="">Seleccione un rol</option>
            <option value="1">Cliente</option>
            <option value="2">Administrador</option>
            <option value="3">Diseñador</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>


      </script>
    <!-- Script para el menú de usuario -->
  <script>
  const iconoUsuario = document.getElementById('icono-usuario');
  const menuUsuario = document.getElementById('menu-usuario');

  iconoUsuario.addEventListener('click', () => {
    menuUsuario.classList.toggle('activo');
  });

  // Cierra el menú al hacer clic fuera
  document.addEventListener('click', (e) => {
    if (!iconoUsuario.contains(e.target) && !menuUsuario.contains(e.target)) {
      menuUsuario.classList.remove('activo');
    }
  });
</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>


<script>
  document.addEventListener('DOMContentLoaded', () => {
    const botonesEditarRol = document.querySelectorAll('.btn-editar-rol');

    botonesEditarRol.forEach(boton => {
      boton.addEventListener('click', () => {
        const userId = boton.getAttribute('data-user-id');
        const userName = boton.getAttribute('data-user-name');
        const rolId = boton.getAttribute('data-user-role-id');

        document.getElementById('editar-usu-id').value = userId;
        document.getElementById('nombre-usuario-rol').textContent = userName;

        const selectRol = document.querySelector('#modalEditarRol select[name="rol_id"]');
        selectRol.value = rolId;
      });
    });
  });
</script>

<?php include '../includes/footer.php'; ?>
</body>
</html>