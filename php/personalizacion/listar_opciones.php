<?php
// Mostrar errores solo en desarrollo (ajustar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../php/conexion.php';

$opciones = [];
$sql = "SELECT op.opc_id, op.opc_nombre, op.opc_descripcion, op.opc_imagen, vp.val_id, vp.val_nombre, vp.val_imagen
        FROM opcion_personalizacion op
        LEFT JOIN valor_personalizacion vp ON op.opc_id = vp.opc_id
        ORDER BY op.opc_id, vp.val_id";
$res = $conn->query($sql);
if (!$res) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de base de datos: ' . $conn->error]);
    exit();
}
while ($row = $res->fetch_assoc()) {
    $opc_id = $row['opc_id'];
    if (!isset($opciones[$opc_id])) {
        $opciones[$opc_id] = [
            'opc_id' => (int)$row['opc_id'],
            'opc_nombre' => htmlspecialchars($row['opc_nombre']),
            'opc_descripcion' => htmlspecialchars($row['opc_descripcion'] ?? ''),
            'opc_imagen' => $row['opc_imagen'] ? htmlspecialchars($row['opc_imagen']) : null,
            'valores' => []
        ];
    }
    if ($row['val_id']) {
        $opciones[$opc_id]['valores'][] = [
            'id' => $row['val_id'],
            'nombre' => htmlspecialchars($row['val_nombre']),
            'imagen' => $row['val_imagen'] ? htmlspecialchars($row['val_imagen']) : null
        ];
    }
}
$res->close();
$conn->close();
header('Content-Type: application/json');
echo json_encode(array_values($opciones));
