<?php
// Mostrar errores solo en desarrollo (ajustar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// --- Seguridad: Validar sesión y rol ---
session_start();
if (!isset($_SESSION['usu_id']) || (int)$_SESSION['rol_id'] !== 2) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

require_once '../../php/conexion.php';

// --- (Opcional) Validación de CSRF ---
// if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
//     http_response_code(403);
//     echo json_encode(['error' => 'Token CSRF inválido']);
//     exit();
// }

// --- Validación y sanitización de entrada ---
$opc_id = intval($_POST['opcion'] ?? 0);
$nombre = trim($_POST['nombre'] ?? '');
$imagen = trim($_POST['imagen'] ?? ''); // Ruta de imagen subida previamente
$descripcion = trim($_POST['descripcion'] ?? '');
if (!$opc_id || !$nombre || mb_strlen($nombre) > 100) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos o nombre demasiado largo']);
    exit();
}
if (mb_strlen($descripcion) > 255) {
    http_response_code(400);
    echo json_encode(['error' => 'Descripción demasiado larga (máx 255)']);
    exit();
}

// --- Insertar en base de datos con prepared statements ---
$stmt = $conn->prepare("INSERT INTO valor_personalizacion (val_nombre, val_imagen, val_descripcion, opc_id) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de base de datos: ' . $conn->error]);
    exit();
}
$stmt->bind_param('sssi', $nombre, $imagen, $descripcion, $opc_id);
$res = $stmt->execute();
$stmt->close();
$conn->close();
if ($res) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar valor']);
}
