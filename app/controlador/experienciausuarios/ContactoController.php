<?php
require_once __DIR__ . '/../../modelo/experienciausuarios/ContactoService.php';

class ContactoController {
    private $service;

    public function __construct() {
        $this->service = new ContactoService();
    }

    public function manejarPeticion() {
        $mensaje = "";
        $accion  = $_POST["accion"] ?? null;

        // POST: crear / actualizar / eliminar 
        if ($_SERVER["REQUEST_METHOD"] === "POST" && $accion) {
            switch ($accion) {
                case "crear":
                    $nombre   = trim($_POST["nombre"] ?? "");
                    $correo   = trim($_POST["correo"] ?? "");
                    $telefono = trim($_POST["telefono"] ?? "");
                    $mensajeC = trim($_POST["mensaje"] ?? "");
                    $via      = $_POST["via"] ?? null; // formulario|whatsapp (opcional)
                    $terminos = isset($_POST["terminos"]) && $_POST["terminos"] ? true : false;

                    // Validaciones 
                    if ($nombre === "" || $mensajeC === "") {
                        $mensaje = "<p style='color:red;'>Nombre y mensaje son obligatorios.</p>";
                        break;
                    }
                    if ($correo !== "" && !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                        $mensaje = "<p style='color:red;'>Correo inválido.</p>";
                        break;
                    }
                    if (!$terminos) {
                        $mensaje = "<p style='color:red;'>Debes aceptar los términos.</p>";
                        break;
                    }
                    if ($via && !in_array($via, ["formulario", "whatsapp"])) {
                        $mensaje = "<p style='color:red;'>Vía inválida.</p>";
                        break;
                    }

                    $payload = [
                        "nombre"   => $nombre,
                        "correo"   => $correo,
                        "telefono" => $telefono,
                        "mensaje"  => $mensajeC,
                        "via"      => $via ?: null, // null = usa default (formulario) en backend
                        "terminos" => $terminos
                    ];
                    $res = $this->service->crearContacto($payload);
                    $mensaje = $res["success"]
                        ? "<p style='color:green;'>Contacto creado correctamente.</p>"
                        : "<p style='color:red;'>Error al crear: {$res["error"]}</p>";
                    break;

                case "actualizar":
                    $id     = $_POST["id"] ?? null;
                    $estado = $_POST["estado"] ?? null; // pendiente|atendido|archivado
                    $notas  = $_POST["notas"] ?? null;

                    if (!$id) {
                        $mensaje = "<p style='color:red;'>Falta ID para actualizar.</p>";
                        break;
                    }
                    if ($estado && !in_array($estado, ["pendiente", "atendido", "archivado"])) {
                        $mensaje = "<p style='color:red;'>Estado inválido.</p>";
                        break;
                    }
                    $payload = [
                        "estado" => $estado,
                        "notas"  => $notas
                    ];
                    $res = $this->service->actualizarContacto($id, $payload);
                    $mensaje = $res["success"]
                        ? "<p style='color:green;'>Contacto actualizado.</p>"
                        : "<p style='color:red;'>Error al actualizar: {$res["error"]}</p>";
                    break;

                case "eliminar":
                    $id = $_POST["id"] ?? null;
                    if (!$id) {
                        $mensaje = "<p style='color:red;'>Falta ID para eliminar.</p>";
                        break;
                    }
                    $res = $this->service->eliminarContacto($id);
                    $mensaje = $res["success"]
                        ? "<p style='color:green;'>Contacto eliminado.</p>"
                        : "<p style='color:red;'>Error al eliminar: {$res["error"]}</p>";
                    break;
            }
        }

        // GET: filtros (via, estado) opcionales 
        $filtros = [
            "via"    => $_GET["via"]    ?? null,
            "estado" => $_GET["estado"] ?? null
        ];
        // Limpia nulls
        $filtros = array_filter($filtros, fn($v) => $v !== null && $v !== "");

        $contactos = $this->service->listarContactos($filtros);

        require __DIR__ . '/../../vista/experienciausuarios/contacto_index.php';
    }
}
