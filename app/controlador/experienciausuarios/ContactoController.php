<?php
require_once __DIR__ . '/../../modelo/experienciausuarios/ContactoService.php';

class ContactoController {
    private $service;

    public function __construct() {
        $this->service = new ContactoService();
    }

    // =========================
    // LISTAR (GET /contacto)
    // =========================
    public function listar() {
        $filtros = [
            "via"    => $_GET["via"]    ?? null,
            "estado" => $_GET["estado"] ?? null
        ];
        $filtros = array_filter($filtros, fn($v) => $v !== null && $v !== "");

        $contactos = $this->service->listarContactos($filtros);

        // mensaje de feedback (si viene de redirección)
        $mensaje = null;
        if (isset($_GET["msg"])) {
            switch ($_GET["msg"]) {
                case "creado":     $mensaje = "<div class='alert alert-success'>Contacto creado correctamente.</div>"; break;
                case "actualizado":$mensaje = "<div class='alert alert-success'>Contacto actualizado.</div>"; break;
                case "eliminado":  $mensaje = "<div class='alert alert-success'>Contacto eliminado.</div>"; break;
                case "error":      $mensaje = "<div class='alert alert-danger'>Ocurrió un error en la operación.</div>"; break;
            }
        }

        require __DIR__ . '/../../vista/experienciausuarios/contacto_index.php';
    }

    // =========================
    // CREAR (POST /contacto/crear)
    // =========================
    public function crear() {
        $nombre   = trim($_POST["nombre"] ?? "");
        $correo   = trim($_POST["correo"] ?? "");
        $telefono = trim($_POST["telefono"] ?? "");
        $mensajeC = trim($_POST["mensaje"] ?? "");
        $via      = $_POST["via"] ?? null;
        $terminos = isset($_POST["terminos"]) && $_POST["terminos"] ? true : false;

        // Validaciones básicas
        if ($nombre === "" || $mensajeC === "" || (!$terminos) || ($correo && !filter_var($correo, FILTER_VALIDATE_EMAIL))) {
            header("Location: /brisas_gems/public/contacto?msg=error");
            exit;
        }

        $payload = [
            "nombre"   => $nombre,
            "correo"   => $correo,
            "telefono" => $telefono,
            "mensaje"  => $mensajeC,
            "via"      => $via ?: null,
            "terminos" => $terminos
        ];

        $res = $this->service->crearContacto($payload);

        if ($res["success"]) {
            header("Location: /brisas_gems/public/contacto?msg=creado");
        } else {
            header("Location: /brisas_gems/public/contacto?msg=error");
        }
        exit;
    }

    // =========================
    // ACTUALIZAR (POST /contacto/update)
    // =========================
    public function actualizar() {
        $id     = $_POST["id"] ?? null;
        $estado = $_POST["estado"] ?? null;
        $notas  = $_POST["notas"] ?? null;

        if (!$id) {
            header("Location: /brisas_gems/public/contacto?msg=error");
            exit;
        }

        $payload = [
            "estado" => $estado,
            "notas"  => $notas
        ];

        $res = $this->service->actualizarContacto($id, $payload);

        if ($res["success"]) {
            header("Location: /brisas_gems/public/contacto?msg=actualizado");
        } else {
            header("Location: /brisas_gems/public/contacto?msg=error");
        }
        exit;
    }

    // =========================
    // ELIMINAR (POST /contacto/delete)
    // =========================
    public function eliminar() {
        $id = $_POST["id"] ?? null;
        if (!$id) {
            header("Location: /brisas_gems/public/contacto?msg=error");
            exit;
        }

        $res = $this->service->eliminarContacto($id);

        if ($res["success"]) {
            header("Location: /brisas_gems/public/contacto?msg=eliminado");
        } else {
            header("Location: /brisas_gems/public/contacto?msg=error");
        }
        exit;
    }
}
