<?php
require_once __DIR__ . '/../../modelo/experienciausuarios/ContactoUsuarioService.php';

class ContactoUsuarioController {
    private $service;

    public function __construct() {
        $this->service = new ContactoUsuarioService();
    }

    public function guardar() {
        $mensaje = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre   = trim($_POST["nombre"] ?? "");
            $correo   = trim($_POST["correo"] ?? "");
            $telefono = trim($_POST["telefono"] ?? "");
            $mensajeC = trim($_POST["mensaje"] ?? "");
            $via      = $_POST["via"] ?? "formulario"; // siempre formulario por defecto
            $terminos = isset($_POST["terminos"]) && $_POST["terminos"] ? true : false;

            // Validaciones mínimas
            if ($nombre === "" || $mensajeC === "") {
                $mensaje = "<p style='color:red;'>Nombre y mensaje son obligatorios.</p>";
            } elseif ($correo !== "" && !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $mensaje = "<p style='color:red;'>Correo inválido.</p>";
            } elseif (!$terminos) {
                $mensaje = "<p style='color:red;'>Debes aceptar los términos.</p>";
            } else {
                $payload = [
                    "nombre"   => $nombre,
                    "correo"   => $correo,
                    "telefono" => $telefono,
                    "mensaje"  => $mensajeC,
                    "via"      => $via,
                    "terminos" => $terminos
                ];

                $res = $this->service->crearContacto($payload);
                $mensaje = $res["success"]
                    ? "<p style='color:green;'>Tu mensaje fue enviado correctamente.</p>"
                    : "<p style='color:red;'>Error al enviar: {$res["error"]}</p>";
            }
        }

        // Aquí puedes redirigir a una vista simple de confirmación
        require __DIR__ . '/../../vista/experienciausuarios/contacto_usuario_index.php';
    }
}
