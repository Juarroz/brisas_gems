<?php
require_once __DIR__ . '/../../modelo/experienciausuarios/ContactoService.php';

class GestionContactosController {
    private ContactoService $service;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        //$this->restringirRoles(['administrador', 'diseñador', 'admin']); // ajusta según tus roles
        $this->service = new ContactoService();
    }

    private function restringirRoles(array $rolesPermitidos): void {
        $rolNombre = $_SESSION['rol_nombre'] ?? null;
        $ok = is_string($rolNombre) && in_array(strtolower($rolNombre), array_map('strtolower', $rolesPermitidos), true);
        if (!$ok) {
            http_response_code(403);
            die('Acceso denegado: necesitas permisos de ' . implode(' o ', $rolesPermitidos));
        }
    }

    // =========================
    // GET /admin/contactos → listar
    // =========================
    public function listar() {
        $filtros = [
            "via"    => $_GET["via"]    ?? null,
            "estado" => $_GET["estado"] ?? null
        ];
        $filtros = array_filter($filtros, fn($v) => $v !== null && $v !== "");

        $contactos = $this->service->listarContactos($filtros);
        if ($contactos === false) $contactos = [];

        // feedback
        $mensaje = null;
        if (isset($_GET["msg"])) {
            switch ($_GET["msg"]) {
                case "actualizado": $mensaje = "<div class='alert alert-success'>Contacto actualizado.</div>"; break;
                case "eliminado":   $mensaje = "<div class='alert alert-success'>Contacto eliminado.</div>"; break;
                case "error":       $mensaje = "<div class='alert alert-danger'>Ocurrió un error.</div>"; break;
            }
        }

        require __DIR__ . '/../../vista/experienciausuarios/contacto_admin.php';
    }

    // =========================
    // POST /admin/contactos/update
    // =========================
    public function actualizar() {
        $id     = $_POST["id"] ?? null;
        $estado = $_POST["estado"] ?? null;
        $notas  = $_POST["notas"] ?? null;

        if (!$id) {
            header("Location: " . BASE_URL . "/admin/contactos?msg=error");
            exit;
        }

        $estado = strtolower(trim($_POST["estado"] ?? ""));

        // 🚀 Ajuste: mandar todos los campos que el backend espera
        $payload = [
            "estado"        => $estado, 
            "notas"         => $notas,
            "usuarioIdAdmin"=> $_SESSION["usu_id"] ?? null, // el admin que atiende
            "via"           => "formulario" // fijo por ahora, o cámbialo según el contacto
        ];

        $res = $this->service->actualizarContacto($id, $payload);

        if ($res["success"]) {
            header("Location: " . BASE_URL . "/admin/contactos?msg=actualizado");
        } else {
            echo "<pre>";
            print_r($res);
            echo "</pre>";
            exit;
        }
    }


    // =========================
    // POST /admin/contactos/delete
    // =========================
    public function eliminar() {
        $id = $_POST["id"] ?? null;
        if (!$id) {
            header("Location: " . BASE_URL . "/admin/contactos?msg=error");
            exit;
        }

        $res = $this->service->eliminarContacto($id);

        if ($res["success"]) {
            header("Location: " . BASE_URL . "/admin/contactos?msg=eliminado");
        } else {
            header("Location: " . BASE_URL . "/admin/contactos?msg=error");
        }
        exit;
    }
}
