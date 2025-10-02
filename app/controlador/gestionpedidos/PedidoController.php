<?php
require_once __DIR__ . '/../../modelo/gestionpedidos/PedidoService.php';
require_once __DIR__ . '/../../modelo/gestionpedidos/EstadoPedidoService.php';

class PedidoController {
    private $service;
    private $estadoService;

    public function __construct() {
        $this->service = new PedidoService();
        $this->estadoService = new EstadoPedidoService();
    }

    // ✅ MÉTODO PARA LA RUTA /pedidos
    public function listPedidos() {
        $this->manejarPeticion();
    }

    // ✅ MÉTODO PARA LA RUTA /pedido
    public function index() {
        $this->manejarPeticion();
    }

    // ✅ MÉTODO PARA CREAR PEDIDOS
    public function crear() {
        $this->manejarPeticion();
    }

    // ✅ MÉTODO PARA DETALLES DE PEDIDO
    public function showPedidoDetails() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /pedidos');
            exit;
        }

        $pedido = $this->service->obtenerPedido($id);
        if (!$pedido) {
            echo "Pedido no encontrado";
            return;
        }

        // Aquí cargarías una vista de detalles específica
        echo "<h1>Detalles del Pedido</h1>";
        echo "<pre>" . print_r($pedido, true) . "</pre>";
    }

    // ✅ MÉTODO PARA ACTUALIZAR ESTADO
    public function handleUpdateStatus() {
        $id = $_POST['id'] ?? null;
        $nuevoEstado = $_POST['estado'] ?? null;

        if (!$id || !$nuevoEstado) {
            echo "Datos incompletos";
            return;
        }

        // Lógica para actualizar estado
        $resultado = $this->service->actualizarPedido($id, ['estId' => $nuevoEstado]);
        
        if ($resultado['success']) {
            header('Location: /pedidos?mensaje=Estado actualizado');
        } else {
            header('Location: /pedidos?error=Error al actualizar estado');
        }
    }

    public function manejarPeticion() {
        // Validación automática: solo administradores pueden acceder (flexible)
        require_once __DIR__ . '/../../core/AuthGuard.php';
        requireLogin();
        if (!isset($_SESSION['user_role']) || stripos($_SESSION['user_role'], 'ADMIN') === false) {
            die('Acceso solo para administradores');
        }
        
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
                        $mensaje = "<div class='alert alert-danger'>Código y comentarios son obligatorios.</div>";
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
                        ? "<div class='alert alert-success'>Pedido creado correctamente.</div>"
                        : "<div class='alert alert-danger'>Error al crear: {$res["error"]}</div>";
                    break;

                case "actualizar":
                    $id           = $_POST["id"] ?? null;
                    $pedCodigo    = trim($_POST["pedCodigo"] ?? "");
                    $pedComentarios = trim($_POST["pedComentarios"] ?? "");
                    $estId        = $_POST["estId"] ?? null;
                    $perId        = $_POST["perId"] ?? null;
                    $usuId        = $_POST["usuId"] ?? null;

                    if (!$id) {
                        $mensaje = "<div class='alert alert-danger'>Falta ID para actualizar.</div>";
                        break;
                    }

                    $payload = [
                        "pedCodigo"    => $pedCodigo,
                        "pedComentarios" => $pedComentarios,
                        "estId"        => (int)$estId,
                        "perId"        => (int)$perId,
                        "usuId"        => (int)$usuId
                    ];

                    try {
                        $res = $this->service->actualizarPedido($id, $payload);
                        if ($res["success"]) {
                            $mensaje = "<div class='alert alert-success'>Pedido actualizado.</div>";
                        } else {
                            error_log("Error al actualizar pedido ID $id: " . ($res["error"] ?? 'Error desconocido'));
                            $mensaje = "<div class='alert alert-danger'>Error al actualizar: " . htmlspecialchars($res["error"] ?? 'Error desconocido') . "</div>";
                        }
                    } catch (Exception $e) {
                        error_log("Excepción al actualizar pedido ID $id: " . $e->getMessage());
                        $mensaje = "<div class='alert alert-danger'>Error inesperado al actualizar el pedido.</div>";
                    }
                    break;

                case "eliminar":
                    $id = $_POST["id"] ?? null;
                    if (!$id) {
                        $mensaje = "<div class='alert alert-danger'>Falta ID para eliminar.</div>";
                        break;
                    }
                    try {
                        $res = $this->service->eliminarPedido($id);
                        if ($res["success"]) {
                            $mensaje = "<div class='alert alert-success'>Pedido eliminado.</div>";
                        } else {
                            error_log("Error al eliminar pedido ID $id: " . ($res["error"] ?? 'Error desconocido'));
                            $mensaje = "<div class='alert alert-danger'>Error al eliminar: " . htmlspecialchars($res["error"] ?? 'Error desconocido') . "</div>";
                        }
                    } catch (Exception $e) {
                        error_log("Excepción al eliminar pedido ID $id: " . $e->getMessage());
                        $mensaje = "<div class='alert alert-danger'>Error inesperado al eliminar el pedido.</div>";
                    }
                    break;
            }
        }

        // Manejar mensajes de URL
        if (isset($_GET['mensaje'])) {
            $mensaje = "<div class='alert alert-success'>" . htmlspecialchars($_GET['mensaje']) . "</div>";
        }
        if (isset($_GET['error'])) {
            $mensaje = "<div class='alert alert-danger'>" . htmlspecialchars($_GET['error']) . "</div>";
        }

        // Aseguramos que $pedidos siempre sea un array
        $pedidos = $this->service->listarPedidos();
        if (!is_array($pedidos)) {
            $pedidos = [];
        }

        require __DIR__ . '/../../vista/gestionpedidos/pedido_index.php';
    }
}