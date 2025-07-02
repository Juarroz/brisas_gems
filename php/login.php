<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $correo = trim($_POST['correo']);
  $password = $_POST['password'];

  // Buscar al usuario por correo
  $stmt = $conn->prepare("SELECT u.usu_id, u.usu_nombre, u.usu_password, u.usu_activo, u.rol_id, r.rol_nombre 
                          FROM usuarios u
                          JOIN rol r ON u.rol_id = r.rol_id
                          WHERE u.usu_correo = ?");
  $stmt->bind_param("s", $correo);
  $stmt->execute();
  $resultado = $stmt->get_result();

  if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    // Verifica contraseña
    if (!password_verify($password, $usuario['usu_password'])) {
      echo "<script>alert('Contraseña incorrecta.'); window.history.back();</script>";
      exit;
    }

    // Verifica si la cuenta está activa
    if (!$usuario['usu_activo']) {
      echo "<script>alert('Tu cuenta aún no está activada.'); window.history.back();</script>";
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
        header("Location: ../usuario/mi-perfil.html");
        break;
      case 2: // Administrador
        header("Location: ../admin/gestion-usuarios-1.html");
        break;
      case 3: // Diseñador
        header("Location: ../admin/gestion-inspiracion.html");
        break;
      default:
        header("Location: ../index.html");
    }
    exit;

  } else {
    echo "<script>alert('Correo no registrado.'); window.history.back();</script>";
  }

  $stmt->close();
  $conn->close();
} else {
  header("Location: ../login.html");
  exit;
}
