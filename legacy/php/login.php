<?php
session_start();
require_once 'conexion.php';

// --- (Opcional) Validación de CSRF ---
// if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
//     http_response_code(403);
//     echo json_encode(['error' => 'Token CSRF inválido']);
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $correo = trim($_POST['correo'] ?? '');
  $password = $_POST['password'] ?? '';

  if (!$correo || !$password) {
    echo "<script>alert('Correo y contraseña requeridos.'); window.history.back();</script>";
    exit;
  }

  // Buscar al usuario por correo
  $stmt = $conn->prepare("SELECT u.usu_id, u.usu_nombre, u.usu_password, u.usu_activo, u.rol_id, r.rol_nombre 
                          FROM usuarios u
                          JOIN rol r ON u.rol_id = r.rol_id
                          WHERE u.usu_correo = ?");
  if (!$stmt) {
    echo "<script>alert('Error de base de datos.'); window.history.back();</script>";
    exit;
  }
  $stmt->bind_param("s", $correo);
  $stmt->execute();
  $resultado = $stmt->get_result();

  if ($resultado && $resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();
    // Verifica contraseña encriptada
    if (!password_verify($password, $usuario['usu_password'])) {
      // Protección contra timing attacks
      usleep(random_int(10000, 100000));
      echo "<script>alert('Contraseña incorrecta.'); window.history.back();</script>";
      $stmt->close();
      $conn->close();
      exit;
    }
    // Verifica si la cuenta está activa
    if (!$usuario['usu_activo']) {
      echo "<script>alert('Tu cuenta aún no está activada.'); window.history.back();</script>";
      $stmt->close();
      $conn->close();
      exit;
    }
    // Iniciar sesión
    $_SESSION['usu_id'] = $usuario['usu_id'];
    $_SESSION['usu_nombre'] = $usuario['usu_nombre'];
    $_SESSION['rol_id'] = $usuario['rol_id'];
    $_SESSION['rol_nombre'] = $usuario['rol_nombre'];
    // Redireccionar por rol
    switch ($usuario['rol_id']) {
      case 1: // Usuario
        header("Location: ../usuario/mi-perfil.php");
        break;
      case 2: // Administrador
        header("Location: ../admin/gestion-usuarios.php");
        break;
      case 3: // Diseñador
        header("Location: ../admin/gestion-inspiracion.php");
        break;
      default:
        header("Location: ../index.php");
    }
    $stmt->close();
    $conn->close();
    exit;
  } else {
    // Protección contra timing attacks
    usleep(random_int(10000, 100000));
    echo "<script>alert('Correo no registrado.'); window.history.back();</script>";
    $stmt->close();
    $conn->close();
    exit;
  }
} else {
  header("Location: ../login.php");
  exit;
}
