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

$opciones = [];
$sql = "SELECT opc_id, opc_nombre, opc_descripcion, opc_imagen FROM opcion_personalizacion ORDER BY opc_id";
$res = $conn->query($sql);
if (!$res) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de base de datos: ' . $conn->error]);
    exit();
}
while ($row = $res->fetch_assoc()) {
    $opciones[] = [
        'opc_id' => (int)$row['opc_id'],
        'opc_nombre' => htmlspecialchars($row['opc_nombre']),
        'opc_descripcion' => htmlspecialchars($row['opc_descripcion'] ?? ''),
        'opc_imagen' => $row['opc_imagen'] ? htmlspecialchars($row['opc_imagen']) : null
    ];
}
$res->close();
$conn->close();
header('Content-Type: application/json');
echo json_encode(['opciones' => $opciones]);
