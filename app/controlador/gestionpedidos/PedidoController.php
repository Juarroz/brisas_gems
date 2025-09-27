<?php
require_once __DIR__ . '/../../modelo/gestionpedidos/PedidoService.php';

class PedidoController {
    private $service;

    public function __construct() {
        $this->service = new PedidoService();
    }

    public function manejarPeticion() {
        $mensaje = "";
        $accion  = $_POST["accion"] ?? null;

        if ($_SERVER["REQUEST_METHOD"] === "POST" && $accion) {
            switch ($accion) {
                case "crear":
                    $pedCodigo    = trim($_POST["pedCodigo"] ?? "");
                    $pedComentarios = trim($_POST["pedComentarios"] ?? "");
                    $estId        = $_POST["estId"] ?? null;
                    $perId        = $_POST["perId"] ?? null;
                    $usuId        = $_POST["usuId"] ?? null;

                    if ($pedCodigo === "" || $pedComentarios === "") {
                        $mensaje = "<p style='color:red;'>Código y comentarios son obligatorios.</p>";
                        break;
                    }

                    $payload = [
                        "pedCodigo"    => $pedCodigo,
                        "pedComentarios" => $pedComentarios,
                        "estId"        => (int)$estId,
                        "perId"        => (int)$perId,
                        "usuId"        => (int)$usuId
                    ];

                    $res = $this->service->crearPedido($payload);
                    $mensaje = $res["success"]
                        ? "<p style='color:green;'>Pedido creado correctamente.</p>"
                        : "<p style='color:red;'>Error al crear: {$res["error"]}</p>";
                    break;

                case "actualizar":
                    $id           = $_POST["id"] ?? null;
                    $pedCodigo    = trim($_POST["pedCodigo"] ?? "");
                    $pedComentarios = trim($_POST["pedComentarios"] ?? "");
                    $estId        = $_POST["estId"] ?? null;
                    $perId        = $_POST["perId"] ?? null;
                    $usuId        = $_POST["usuId"] ?? null;

                    if (!$id) {
                        $mensaje = "<p style='color:red;'>Falta ID para actualizar.</p>";
                        break;
                    }

                    $payload = [
                        "pedCodigo"    => $pedCodigo,
                        "pedComentarios" => $pedComentarios,
                        "estId"        => (int)$estId,
                        "perId"        => (int)$perId,
                        "usuId"        => (int)$usuId
                    ];

                    $res = $this->service->actualizarPedido($id, $payload);
                    $mensaje = $res["success"]
                        ? "<p style='color:green;'>Pedido actualizado.</p>"
                        : "<p style='color:red;'>Error al actualizar: {$res["error"]}</p>";
                    break;

                case "eliminar":
                    $id = $_POST["id"] ?? null;
                    if (!$id) {
                        $mensaje = "<p style='color:red;'>Falta ID para eliminar.</p>";
                        break;
                    }

                    $res = $this->service->eliminarPedido($id);
                    $mensaje = $res["success"]
                        ? "<p style='color:green;'>Pedido eliminado.</p>"
                        : "<p style='color:red;'>Error al eliminar: {$res["error"]}</p>";
                    break;
            }
        }

        // Aseguramos que $pedidos siempre sea un array
        $pedidos = $this->service->listarPedidos();
        if (!is_array($pedidos)) {
            $pedidos = [];
        }

        require __DIR__ . '/../../vista/gestionpedidos/pedido_index.php';
    }
}
