<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/assets/css-global/main.css">
</head>
<body>

  <?php include 'includes/header.php'; ?>

  <!-- ---- -->
  <!-- MAIN -->
  <!-- ---- -->

  <main class="container my-5" style="max-width: 500px;">
  <!-- Sección de Inicio de Sesión -->
  <section class="form-section mb-5" aria-labelledby="titulo-login">
    <h2 id="titulo-login" class="h5 mb-4 text-center">Iniciar Sesión</h2>
    <form action="php/login.php" method="post" aria-label="Formulario de inicio de sesión">
      <div class="mb-3">
        <label for="login-correo" class="form-label">Correo electrónico *</label>
        <input type="email" class="form-control" id="login-correo" name="correo" required>
      </div>

      <div class="mb-3">
        <label for="login-password" class="form-label">Contraseña *</label>
        <input type="password" class="form-control" id="login-password" name="password" required>
      </div>

      <div class="mb-3 d-grid">
        <button type="submit" class="btn btn-success">Iniciar Sesión</button>
      </div>

      <div class="mt-3 text-end">
        <a href="recuperar.php" class="text-decoration-none">¿Olvidaste tu contraseña?</a>
      </div>
    </form>

    <p class="mt-4 text-center">
      ¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a>
    </p>
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
