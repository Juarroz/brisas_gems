<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Recuperar contraseña</title>
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/assets/css-global/main.css">
</head>
<body>

  <body>

<?php include 'includes/header.php'; ?>


  <!-- ---- -->
  <!-- MAIN -->
  <!-- ---- --> 

  <main class="container my-5" style="max-width: 600px; margin-top: 500px;">
    <section class="form-section" aria-labelledby="titulo-recuperar">
      <h2 id="titulo-recuperar" class="h5 mb-4 text-center">Recuperar contraseña</h2>

      <form action="php/autenticacion/recuperar.php" method="post" aria-label="Formulario de recuperación">
        <div class="mb-3">
          <label for="correo" class="form-label">Correo electrónico *</label>
          <input type="email" class="form-control" id="correo" name="correo" required>
        </div>

        <p class="form-text text-muted">
          Te enviaremos un enlace para restablecer tu contraseña si el correo está registrado.
        </p>

        <div class="d-grid mt-4">
          <button type="submit" class="btn btn-success">Enviar enlace</button>
        </div>
      </form>

      <p class="text-center mt-4">
        ¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>
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