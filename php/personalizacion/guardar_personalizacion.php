<?php
session_start();
if (!isset($_SESSION['usu_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autenticado']);
    exit();
}
require_once '../../php/conexion.php';
$usu_id = $_SESSION['usu_id'];
$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !is_array($data['selecciones'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos']);
    exit();
}
$selecciones = $data['selecciones']; // array de val_id
$talla = $data['talla'] ?? null;
// 1. Crear personalización
$stmt = $conn->prepare("INSERT INTO personalizacion (per_fecha, usu_id_cliente) VALUES (CURDATE(), ?)");
$stmt->bind_param('i', $usu_id);
$stmt->execute();
$per_id = $conn->insert_id;
// 2. Insertar detalles
foreach ($selecciones as $val_id) {
    $stmt2 = $conn->prepare("INSERT INTO detalle_personalizacion (per_id, val_id) VALUES (?, ?)");
    $stmt2->bind_param('ii', $per_id, $val_id);
    $stmt2->execute();
}
// 3. Insertar talla si aplica (opcional, según tu modelo)
if ($talla) {
    // Puedes guardar la talla como un valor más o en una tabla aparte
}
// 4. Crear pedido asociado
$stmt3 = $conn->prepare("INSERT INTO pedido (ped_codigo, ped_fecha_creacion, est_id, per_id, usu_id) VALUES (?, CURDATE(), 1, ?, ?)");
$codigo = 'BRG-' . str_pad($per_id, 4, '0', STR_PAD_LEFT);
$stmt3->bind_param('sii', $codigo, $per_id, $usu_id);
$stmt3->execute();
$ped_id = $conn->insert_id;
header('Content-Type: application/json');
echo json_encode(['success' => true, 'pedido_id' => $ped_id, 'codigo' => $codigo]);
