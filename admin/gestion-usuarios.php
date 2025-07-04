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
 <!-- ------ -->
<!-- HEADER -->
<!-- ------ -->
<header class="encabezado">
  <div class="contenedor-header">

    <!-- Logo centrado -->
    <div class="logo-centro">
        <img src="../img/logo.png" alt="Logo Brisas Gems">
      </a>
    </div>

    <!-- Menú izquierdo -->
    <nav class="nav-izquierda">
      <a href="./gestion-usuarios.php">GESTIÓN USUARIO</a>
      <a href="./gestion-inspiracion.html">GESTIÓN INSPIRACIÓN</a>
      <a href="./gestion-opciones.html">GESTIÓN PERSONALIZACIÓN</a>
      <a href="./gestion-pedidos.html">GESTIÓN PEDIDOS</a>
    </nav>


    <!-- Íconos a la derecha -->
    <div class="menu-derecha">
      <div class="perfil-wrapper">
        <img src="../img/person.svg" alt="Perfil" class="icono" id="icono-usuario">
        <div class="menu-usuario" id="menu-usuario">
          <a href="#">Mi Perfil</a>
          <a href="../index.html">Cerrar Sesion</a>
        </div>
      </div>
    </div>
  </div>
</header>

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

  <footer class="footer-joyeria">
    <div class="contenedor-footer">
      
      <div class="columna-footer">
        <h4>Brisas Gems</h4>
        <p>🟢 Joyería fina y personalizada con los más altos estándares de calidad.</p>
        <div class="redes-sociales">
          <a href="#" target="_blank" rel="noopener" aria-label="Facebook Brisas Gems">
            <img src="../img/icono-whatsApp.png" alt="Facebook Brisas Gems">
          </a>
          <a href="#" target="_blank" rel="noopener" aria-label="Instagram Brisas Gems">
            <img src="../img/icono instagram.png" alt="Instagram Brisas Gems">
          </a>
          <a href="#" target="_blank" rel="noopener" aria-label="WhatsApp Brisas Gems">
            <img src="../img/icono-facebook.png" alt="WhatsApp Brisas Gems">
          </a>
        </div>
      </div>
  
      <div class="columna-footer">
        <h4>Contacto</h4>
        <p><span class="icono-footer">🟢</span> Av Jiménez #5-43, Emerald Trade Center, Bogotá</p>
        <p><span class="icono-footer">🟢</span> +57 6017654312</p>
        <p><span class="icono-footer">🟢</span> info@brisasgem.com</p>
      </div>
  
      <div class="columna-footer">
        <h4>Enlaces</h4>
        <nav aria-label="Enlaces rápidos">
          <ul class="enlaces-footer">
            <li><a href="./Gestionar-U-R.html">Gestión de Usuarios y Roles</a></li>
            <li><a href="#"> My Perfil</a></li>
          </ul>
        </nav>
      </div>
  
    </div>
  
    <div class="derechos-footer">
      <p>© 2025 Brisas Gems - Todos los derechos reservados</p>
      <p>Desarrollado por SENA CEET - Ficha 2996176 ADSO</p>
    </div>
  </footer>

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


</body>
</html>