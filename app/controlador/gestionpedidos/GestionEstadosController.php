<?php
require_once __DIR__ . '/../../modelo/gestionpedidos/EstadoPedidoService.php';
require_once __DIR__ . '/../../core/AuthGuard.php';

class GestionEstadosController {
    private $service;

    public function __construct() {
        $this->service = new EstadoPedidoService();
    }

    public function manejarPeticion() {
        requireLogin();
        if (!isset($_SESSION['user_role']) || stripos($_SESSION['user_role'], 'ADMIN') === false) {
            die('Acceso solo para administradores');
        }

        $mensaje = "";
        $accion  = $_POST["accion"] ?? null;

        if ($_SERVER["REQUEST_METHOD"] === "POST" && $accion) {
            try {
                switch ($accion) {
                    case "crear":
                        $nombre = trim($_POST["nombre"] ?? "");
                        $descripcion = trim($_POST["descripcion"] ?? "");
                        if ($nombre === "") {
                            $mensaje = "<div class='alert alert-danger'>El nombre es obligatorio.</div>";
                            break;
                        }
                        $res = $this->service->crearEstado($nombre, $descripcion);
                        $mensaje = $res["success"]
                            ? "<div class='alert alert-success'>Estado creado correctamente.</div>"
                            : "<div class='alert alert-danger'>Error al crear: {$res["error"]}</div>";
                        break;
                    case "actualizar":
                        $id = $_POST["id"] ?? null;
                        $nombre = trim($_POST["nombre"] ?? "");
                        $descripcion = trim($_POST["descripcion"] ?? "");
                        if (!$id || $nombre === "") {
                            $mensaje = "<div class='alert alert-danger'>Faltan datos para actualizar.</div>";
                            break;
                        }
                        $res = $this->service->actualizarEstado($id, $nombre, $descripcion);
                        $mensaje = $res["success"]
                            ? "<div class='alert alert-success'>Estado actualizado.</div>"
                            : "<div class='alert alert-danger'>Error al actualizar: {$res["error"]}</div>";
                        break;
                    case "eliminar":
                        $id = $_POST["id"] ?? null;
                        if (!$id) {
                            $mensaje = "<div class='alert alert-danger'>Falta ID para eliminar.</div>";
                            break;
                        }
                        $res = $this->service->eliminarEstado($id);
                        $mensaje = $res["success"]
                            ? "<div class='alert alert-success'>Estado eliminado.</div>"
                            : "<div class='alert alert-danger'>Error al eliminar: {$res["error"]}</div>";
                        break;
                }
            } catch (Exception $e) {
                error_log('Error en GestionEstadosController: ' . $e->getMessage());
                $mensaje = "<div class='alert alert-danger'>Ocurrió un error inesperado.</div>";
            }
        }

        $estados = $this->service->listarTodosLosEstados();
        require __DIR__ . '/../../vista/gestionpedidos/gestion_estados.php';
    }
}
