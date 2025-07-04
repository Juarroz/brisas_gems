<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Restablecer contraseña</title>
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/assets/css-global/main.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

  
  <main class="container my-5" style="max-width: 500px;">
    <section class="form-section" aria-labelledby="titulo-restablecer">
      <h2 id="titulo-restablecer" class="h5 mb-4 text-center">Restablecer Contraseña</h2>

      <form action="php/autenticacion/restablecer.php" method="post">
        <input type="hidden" name="token" id="token">

        <div class="mb-3">
          <label for="nueva-password" class="form-label">Nueva contraseña *</label>
          <input type="password" class="form-control" id="nueva-password" name="password" required>
        </div>

        <div class="mb-3">
          <label for="confirmar-password" class="form-label">Confirmar contraseña *</label>
          <input type="password" class="form-control" id="confirmar-password" name="confirm_password" required>
        </div>

        <div class="d-grid mt-4">
          <button type="submit" class="btn btn-success">Restablecer</button>
        </div>
      </form>
    </section>
  </main>

  
  <script>
    // Extraer el token de la URL
    const params = new URLSearchParams(window.location.search);
    const token = params.get("token");
    document.getElementById("token").value = token;

    if (!token) {
      alert("Token inválido o expirado.");
      window.location.href = "login.php";
    }
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

<?php include 'includes/footer.php'; ?>
</body>
</html>
