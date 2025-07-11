<?php
session_start();
if (!isset($_SESSION['usu_id']) || $_SESSION['rol_id'] != 2) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit();
}
require_once '../php/conexion.php';
$sql = "SELECT p.ped_id, p.ped_codigo, p.ped_fecha_creacion, ep.est_nombre, p.ped_comentarios,
    u.usu_nombre, u.usu_correo,
    (SELECT ren_imagen FROM render_3d WHERE ped_id = p.ped_id LIMIT 1) as render_3d,
    (SELECT fot_imagen_final FROM foto_producto_final WHERE ped_id = p.ped_id LIMIT 1) as imagen_final
FROM pedido p
INNER JOIN estado_pedido ep ON p.est_id = ep.est_id
INNER JOIN usuarios u ON p.usu_id = u.usu_id
ORDER BY p.ped_fecha_creacion DESC";
$result = $conn->query($sql);
$pedidos = [];
while ($row = $result->fetch_assoc()) {
    $row['detalles'] = [];
    $sql_det = "SELECT op.opc_nombre, vp.val_nombre
        FROM pedido pd
        JOIN personalizacion per ON pd.per_id = per.per_id
        JOIN detalle_personalizacion dp ON per.per_id = dp.per_id
        JOIN valor_personalizacion vp ON dp.val_id = vp.val_id
        JOIN opcion_personalizacion op ON vp.opc_id = op.opc_id
        WHERE pd.ped_id = ?";
    $stmt_det = $conn->prepare($sql_det);
    $stmt_det->bind_param('i', $row['ped_id']);
    $stmt_det->execute();
    $res_det = $stmt_det->get_result();
    while ($det = $res_det->fetch_assoc()) {
        $row['detalles'][] = $det;
    }
    $pedidos[] = $row;
}
header('Content-Type: application/json');
echo json_encode($pedidos);
