<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sistema interactivo de Brisas Gems para la personalización de joyas en línea">
  <meta name="author" content="Johan Bocanegra">
  <link rel="icon" href="../img/icono.png">
  <title>Seguimiento de Pedido | Brisas Gems</title>
<!-- Estilos globales primero -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<link rel="stylesheet" href="../css/assets/css-global/main.css">
<link rel="stylesheet" href="../css/mi-perfil.css">
</head>
<body>

<?php include '../includes/header.php'; ?>


<?php
// Cargar datos del usuario autenticado desde sesión (mejor práctica)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usu_id'])) {
    header('Location: ../login.php');
    exit();
}

// Conexión a la base de datos
require_once '../php/conexion.php';

$usu_id = $_SESSION['usu_id'];
$sql = "SELECT usu_nombre, usu_correo, usu_telefono FROM usuarios WHERE usu_id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $usu_id);
$stmt->execute();
$stmt->bind_result($usu_nombre, $usu_correo, $usu_telefono);
$stmt->fetch();
$stmt->close();
$conn->close();

// Objeto para compatibilidad con el frontend
$usuario = (object) [
    'usu_id' => $usu_id,
    'usu_nombre' => $usu_nombre,
    'usu_correo' => $usu_correo,
    'usu_telefono' => $usu_telefono
];
?>

      <main class="container my-5">
        <section id="actualizar-datos-personales" class="mx-auto" style="max-width: 400px;">
          <h2 class="mb-4">Actualizar mis datos personales</h2>
      
          <!-- Mensajes de alerta -->
          <?php
          // Mostrar alertas según los parámetros en la URL
          if (isset($_GET['exito'])) {
              echo '<div class="alert alert-success" role="alert">¡Datos actualizados correctamente!</div>';
          } elseif (isset($_GET['error'])) {
              $msg = '';
              switch ($_GET['error']) {
                  case 'correo':
                      $msg = 'El correo ingresado ya está en uso por otro usuario.';
                      break;
                  case 'bd':
                      $msg = 'Ocurrió un error al actualizar los datos. Intenta nuevamente.';
                      break;
                  case 'datos':
                      $msg = 'Por favor, completa todos los campos obligatorios.';
                      break;
                  default:
                      $msg = 'Ocurrió un error inesperado.';
              }
              echo '<div class="alert alert-danger" role="alert">' . $msg . '</div>';
          }
          ?>
          <div id="alert-placeholder"></div>
      
          <!-- Formulario: método POST al endpoint encargado -->
          <form id="form-actualizar-datos" action="../php/usuarios/actualizar_datos_personales.php" method="POST" novalidate autocomplete="off">
            <!-- Campo oculto con el ID del usuario autenticado -->
            <input type="hidden" name="usu_id" value="<?= $usuario->usu_id ?>">
      
            <!-- Nombre completo -->
            <div class="mb-3">
              <label for="usu_nombre" class="form-label">Nombre completo</label>
              <input
                type="text"
                class="form-control"
                id="usu_nombre"
                name="usu_nombre"
                required
                value="<?= htmlspecialchars($usuario->usu_nombre) ?>"
              >
              <div class="invalid-feedback">
                Por favor, ingresa tu nombre completo.
              </div>
            </div>
      
            <!-- Correo electrónico -->
            <div class="mb-3">
              <label for="usu_correo" class="form-label">Correo electrónico</label>
              <input
                type="email"
                class="form-control"
                id="usu_correo"
                name="usu_correo"
                required
                value="<?= htmlspecialchars($usuario->usu_correo) ?>"
              >
              <div class="invalid-feedback">
                Ingresa un correo válido que no esté en uso.
              </div>
            </div>
      
            <!-- Teléfono -->
            <div class="mb-3">
              <label for="usu_telefono" class="form-label">Número de teléfono</label>
              <input
                type="tel"
                class="form-control"
                id="usu_telefono"
                name="usu_telefono"
                pattern="^[0-9\-\+\s\(\)]{7,20}$"
                value="<?= htmlspecialchars($usuario->usu_telefono) ?>"
              >
              <div class="invalid-feedback">
                Ingresa un número de teléfono válido.
              </div>
            </div>
      
            <!-- Botón de envío -->
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">
                Guardar cambios
              </button>
            </div>
          </form>
        </section>
      </main>

  
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
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

<?php include '../includes/footer.php'; ?>
</body>
</html>