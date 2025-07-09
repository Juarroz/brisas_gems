<?php
class PedidoProduccionModel {
    private $conn;
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function listarPedidos() {
        $sql = "SELECT p.ped_id, p.ped_codigo, p.ped_fecha_creacion, u.usu_nombre, e.est_nombre, p.ped_comentarios,
                        (SELECT ren_imagen FROM render_3d WHERE ped_id = p.ped_id LIMIT 1) AS render_3d,
                        (SELECT fot_imagen_final FROM foto_producto_final WHERE ped_id = p.ped_id LIMIT 1) AS imagen_final
                FROM pedido p
                JOIN personalizacion per ON p.per_id = per.per_id
                JOIN usuarios u ON per.usu_id_cliente = u.usu_id
                JOIN estado_pedido e ON p.est_id = e.est_id
                ORDER BY p.ped_fecha_creacion DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function guardarRender3D($ped_id, $ruta) {
        $stmt = $this->conn->prepare("INSERT INTO render_3d (ren_imagen, ped_id, ren_fecha_aprobacion) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE ren_imagen=VALUES(ren_imagen), ren_fecha_aprobacion=NOW()");
        $stmt->bind_param("si", $ruta, $ped_id);
        return $stmt->execute();
    }

    public function guardarImagenFinal($ped_id, $ruta) {
        $stmt = $this->conn->prepare("INSERT INTO foto_producto_final (fot_imagen_final, ped_id, fot_fecha_subida) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE fot_imagen_final=VALUES(fot_imagen_final), fot_fecha_subida=NOW()");
        $stmt->bind_param("si", $ruta, $ped_id);
        return $stmt->execute();
    }

    public function guardarComentario($ped_id, $comentario) {
        $stmt = $this->conn->prepare("UPDATE pedido SET ped_comentarios=? WHERE ped_id=?");
        $stmt->bind_param("si", $comentario, $ped_id);
        return $stmt->execute();
    }

    public function actualizarEstado($ped_id, $est_id) {
        $stmt = $this->conn->prepare("UPDATE pedido SET est_id=? WHERE ped_id=?");
        $stmt->bind_param("ii", $est_id, $ped_id);
        return $stmt->execute();
    }
}
