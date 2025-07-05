<?php
// Mostrar errores solo en desarrollo (ajustar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../php/conexion.php';

$opciones = [];
$valores = [];
// Consulta para obtener las opciones de personalización
$sql = "SELECT op.opc_id, op.opc_nombre FROM opcion_personalizacion op ORDER BY op.opc_id";
$res = $conn->query($sql);
if (!$res) {
    // Manejo de errores en caso de fallo en la consulta
    http_response_code(500);
    echo json_encode(['error' => 'Error de base de datos: ' . $conn->error]);
    exit();
}
while ($row = $res->fetch_assoc()) {
    $opciones[] = [
        'opc_id' => (int)$row['opc_id'],
        'opc_nombre' => htmlspecialchars($row['opc_nombre'])
    ];
}
$res->close();
// Consulta para obtener los valores de personalización junto con sus opciones
$sql2 = "SELECT vp.val_id, vp.val_nombre, vp.val_imagen, vp.val_descripcion, vp.opc_id, op.opc_nombre FROM valor_personalizacion vp INNER JOIN opcion_personalizacion op ON vp.opc_id = op.opc_id ORDER BY vp.val_id";
$res2 = $conn->query($sql2);
if (!$res2) {
    // Manejo de errores en caso de fallo en la consulta
    http_response_code(500);
    echo json_encode(['error' => 'Error de base de datos: ' . $conn->error]);
    exit();
}
while ($row = $res2->fetch_assoc()) {
    $valores[] = [
        'val_id' => (int)$row['val_id'],
        'val_nombre' => htmlspecialchars($row['val_nombre']),
        'val_imagen' => htmlspecialchars($row['val_imagen']),
        'val_descripcion' => htmlspecialchars($row['val_descripcion']),
        'opc_id' => (int)$row['opc_id'],
        'opc_nombre' => htmlspecialchars($row['opc_nombre'])
    ];
}
$res2->close();
$conn->close();
// Envío de la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode(['opciones' => $opciones, 'valores' => $valores]);
