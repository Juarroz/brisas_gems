<?php
require_once __DIR__ . '/../../modelo/experienciausuarios/ContactoService.php';

class ContactoController {
    private ContactoService $service;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->service = new ContactoService();
    }

    // =========================
    // GET /contacto → mostrar formulario
    // =========================
    public function mostrar() {
        // mensajes de feedback por query string
        $mensaje = null;
        if (isset($_GET["msg"])) {
            switch ($_GET["msg"]) {
                case "creado": $mensaje = "<div class='alert alert-success'>Tu mensaje fue enviado correctamente.</div>"; break;
                case "error":  $mensaje = "<div class='alert alert-danger'>Ocurrió un error. Verifica los datos.</div>"; break;
            }
        }

        require __DIR__ . '/../../vista/experienciausuarios/contacto.php';
    }

    // =========================
    // POST /contacto → enviar formulario
    // =========================
    public function crear() {
        $nombre   = trim($_POST["nombre"]   ?? "");
        $correo   = trim($_POST["correo"]   ?? "");
        $telefono = trim($_POST["telefono"] ?? "");
        $mensajeC = trim($_POST["mensaje"]  ?? "");
        $via      = $_POST["via"] ?? "formulario"; // siempre formulario por defecto
        $terminos = isset($_POST["terminos"]) && $_POST["terminos"] ? true : false;
        $perId    = $_POST["per_id"] ?? null; // 👈 vínculo con personalización (opcional)

        // Validaciones básicas
        if ($nombre === "" || $mensajeC === "" || !$terminos || ($correo && !filter_var($correo, FILTER_VALIDATE_EMAIL))) {
            header("Location: " . BASE_URL . "/contacto?msg=error");
            exit;
        }

        // Payload para API
        $payload = [
            "nombre"   => $nombre,
            "correo"   => $correo,
            "telefono" => $telefono,
            "mensaje"  => $mensajeC,
            "via"      => $via,
            "terminos" => $terminos,
            "perId"    => $perId ? (int)$perId : null
        ];

        $res = $this->service->crearContacto($payload);

        if ($res["success"]) {
            header("Location: " . BASE_URL . "/contacto?msg=creado");
        } else {
            header("Location: " . BASE_URL . "/contacto?msg=error");
        }
        exit;
    }
}
