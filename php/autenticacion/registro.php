<?php

require_once('C:/xampp/htdocs/brisas_gems/php/conexion.php'); // Conexión a la base de datos

// --- (Opcional) Validación de CSRF ---
// session_start();
// if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
//     http_response_code(403);
//     echo "<script>alert('Token CSRF inválido.'); window.history.back();</script>";
//     exit;
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 1. Capturar y sanitizar datos del formulario
  $nombre     = trim($_POST['nombre'] ?? '');
  $correo     = trim($_POST['correo'] ?? '');
  $telefono   = trim($_POST['telefono'] ?? '');
  $tipdoc_id  = intval($_POST['tipdoc_id'] ?? 0);
  $docnum     = trim($_POST['usu_docnum'] ?? '');
  $password   = $_POST['password'] ?? '';
  $rol_id     = isset($_POST['rol_id']) ? intval($_POST['rol_id']) : 1; // Cliente por defecto

  // Validación básica
  if (!$nombre || !$correo || !$telefono || !$tipdoc_id || !$docnum || !$password) {
    echo "<script>alert('Todos los campos son obligatorios.'); window.history.back();</script>";
    exit;
  }
  if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Correo electrónico inválido.'); window.history.back();</script>";
    exit;
  }
  if (strlen($password) < 6) {
    echo "<script>alert('La contraseña debe tener al menos 6 caracteres.'); window.history.back();</script>";
    exit;
  }
  $password_hash = password_hash($password, PASSWORD_DEFAULT);

  // 2. Validar tipo de documento
  if ($tipdoc_id === 0) {
    echo "<script>alert('Por favor selecciona un tipo de documento válido.'); window.history.back();</script>";
    exit;
  }

  // 3. Verificar que el tipo de documento exista
  $check_doc = $conn->prepare("SELECT tipdoc_id FROM tipo_de_documento WHERE tipdoc_id = ?");
  $check_doc->bind_param("i", $tipdoc_id);
  $check_doc->execute();
  $check_doc->store_result();
  if ($check_doc->num_rows === 0) {
    echo "<script>alert('Tipo de documento no válido.'); window.history.back();</script>";
    $check_doc->close();
    exit;
  }
  $check_doc->close();

  // 4. Verificar si el correo ya está registrado
  $stmt = $conn->prepare("SELECT usu_id FROM usuarios WHERE usu_correo = ?");
  $stmt->bind_param("s", $correo);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows > 0) {
    echo "<script>alert('Este correo ya está registrado.'); window.history.back();</script>";
    $stmt->close();
    exit;
  }
  $stmt->close();

  // 5. Insertar usuario como inactivo
  $stmt = $conn->prepare("INSERT INTO usuarios 
    (usu_nombre, usu_correo, usu_telefono, usu_password, usu_docnum, rol_id, tipdoc_id, usu_activo) 
    VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
  if (!$stmt) {
    echo "<script>alert('Error de base de datos.'); window.history.back();</script>";
    exit;
  }
  $stmt->bind_param("ssssssi", $nombre, $correo, $telefono, $password_hash, $docnum, $rol_id, $tipdoc_id);
  if ($stmt->execute()) {
    $usu_id = $stmt->insert_id;
    // 6. Generar token de activación
    $token = bin2hex(random_bytes(32));
    $fecha_exp = date('Y-m-d H:i:s', strtotime('+1 day'));
    // 7. Guardar el token
    $stmt_token = $conn->prepare("INSERT INTO tokens (token, tipo, fecha_expiracion, usu_id) VALUES (?, 'activacion', ?, ?)");
    $stmt_token->bind_param("ssi", $token, $fecha_exp, $usu_id);
    if ($stmt_token->execute()) {
      $enlace = "http://localhost/brisas_gems/activar.php?token=$token";
      // ✅ Mostrar el enlace en pantalla para pruebas
      echo "<h3>✅ Registro exitoso</h3>";
      echo "<p>Simulación de envío de correo:</p>";
      echo "<p><strong>Enlace de activación:</strong> <a href='$enlace'>$enlace</a></p>";
      echo "<p><a href='../login.html'>Ir al login</a></p>";
    } else {
      echo "<pre>❌ Error al guardar el token: " . $stmt_token->error . "</pre>";
    }
    $stmt_token->close();
  } else {
    echo "<pre>❌ Error al registrar el usuario: " . $stmt->error . "</pre>";
  }
  $stmt->close();
  $conn->close();
} else {
  header("Location: registro.html");
  exit;
}
?>