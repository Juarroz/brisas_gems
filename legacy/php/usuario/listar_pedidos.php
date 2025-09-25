<?php
require_once '../conexion.php';
require_once 'PedidoModel.php';

session_start();

if (!isset($_SESSION['usu_id'])) {
    echo json_encode([]);
    exit;
}

$usuarioId = $_SESSION['usu_id'];
$model = new PedidoModel($conn);

$pedidos = $model->obtenerPedidosPorUsuario($usuarioId);

foreach ($pedidos as &$pedido) {
    $pedido['detalles'] = $model->obtenerDetallesPedido($pedido['ped_id']);
}

header('Content-Type: application/json');
echo json_encode($pedidos);
