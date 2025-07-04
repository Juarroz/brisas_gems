<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Crear cuenta</title>
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/assets/css-global/main.css">
  
</head>
<body>

  <?php include 'includes/header.php'; ?>

  <!-- ---- -->
  <!-- MAIN -->
  <!-- ---- -->

 <main class="container my-5" style="max-width: 600px;">
  
  <section class="form-section" aria-labelledby="titulo-registro">
    <h2 id="titulo-registro" class="h5 mb-4 text-center">Crear cuenta</h2>

    <form action="./php/autenticacion/registro.php" method="post" aria-label="Formulario de registro">

      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre completo *</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
      </div>

      <div class="mb-3">
        <label for="correo" class="form-label">Correo electrónico *</label>
        <input type="email" class="form-control" id="correo" name="correo" required>
      </div>

      <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono *</label>
        <input type="text" class="form-control" id="telefono" name="telefono" pattern="[0-9]{7,15}" required>
      </div>

      <div class="mb-3">
        <label for="tipdoc_id" class="form-label">Tipo de documento *</label>
        <select class="form-select" id="tipdoc_id" name="tipdoc_id" required>
          <option value="">Selecciona...</option>
          <option value="1">Cédula de ciudadanía</option>
          <option value="2">Cédula de extranjería</option>
          <option value="3">Pasaporte</option>
          <!-- Puedes hacer que estas opciones se carguen dinámicamente -->
        </select>
      </div>

      <div class="mb-3">
        <label for="usu_docnum" class="form-label">Número de documento *</label>
        <input type="text" class="form-control" id="usu_docnum" name="usu_docnum" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Contraseña *</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

      <!-- Puedes ocultar este campo si el rol por defecto es cliente -->
      <input type="hidden" name="rol_id" value="1"> <!-- Por ejemplo, 1 = cliente -->

      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-success">Registrarse</button>
      </div>

      <p class="form-text text-muted mt-3">
        Recibirás un enlace de activación en tu correo electrónico.
      </p>

    </form>
  </section>
</main>

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

<?php include 'includes/footer.php'; ?>
</body>
</html>