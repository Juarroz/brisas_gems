<?php
class PedidoModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function obtenerPedidosPorUsuario($usuarioId) {
        $sql = "SELECT p.ped_id, p.ped_codigo, p.ped_fecha_creacion, e.est_id, e.est_nombre, p.ped_comentarios, r.ren_imagen AS render_3d, f.fot_imagen_final AS imagen_final
                FROM pedido p
                JOIN estado_pedido e ON p.est_id = e.est_id
                LEFT JOIN render_3d r ON p.ped_id = r.ped_id
                LEFT JOIN foto_producto_final f ON p.ped_id = f.ped_id
                WHERE p.usu_id = ?
                ORDER BY p.ped_fecha_creacion DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerDetallesPedido($pedidoId) {
        $sql = "SELECT dp.det_id, vp.val_nombre, op.opc_nombre
                FROM detalle_personalizacion dp
                JOIN valor_personalizacion vp ON dp.val_id = vp.val_id
                JOIN opcion_personalizacion op ON vp.opc_id = op.opc_id
                WHERE dp.per_id = (SELECT per_id FROM pedido WHERE ped_id = ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $pedidoId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
