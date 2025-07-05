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
$val_id = intval($_POST['val_id'] ?? 0);
if (!$val_id) {
    http_response_code(400);
    echo json_encode(['error' => 'ID inválido']);
    exit();
}

// --- Eliminar valor con prepared statement ---
$stmt = $conn->prepare("DELETE FROM valor_personalizacion WHERE val_id = ?");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de base de datos: ' . $conn->error]);
    exit();
}
$stmt->bind_param('i', $val_id);
$res = $stmt->execute();
$stmt->close();
$conn->close();
if ($res) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error al eliminar valor']);
}
