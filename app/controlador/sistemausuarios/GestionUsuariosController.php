<?php
// ================================
// controlador/sistemausuarios/GestionUsuariosController.php
// ================================
require_once __DIR__ . '/../../modelo/sistemausuarios/GestionUsuariosService.php';

class GestionUsuariosController {
    private $service;

    public function __construct() {
        $this->service = new GestionUsuariosService();
    }

    public function manejarPeticion() {
        $mensaje = "";
        $accion  = $_POST["accion"] ?? null;

        // ---------- POST: crear / actualizar / eliminar ----------
        if ($_SERVER["REQUEST_METHOD"] === "POST" && $accion) {
            switch ($accion) {
                case "crear":
                    $nombre   = trim($_POST["nombre"] ?? "");
                    $correo   = trim($_POST["correo"] ?? "");
                    $telefono = trim($_POST["telefono"] ?? "");
                    $password = trim($_POST["password"] ?? "");
                    $docnum   = trim($_POST["docnum"] ?? "");
                    $rolId    = $_POST["rolId"] ?? null;
                    $tipdocId = $_POST["tipdocId"] ?? null;
                    $activo   = isset($_POST["activo"]) && $_POST["activo"] ? true : false;
                    $origen   = $_POST["origen"] ?? "formulario";

                    if ($nombre === "" || $correo === "" || $password === "" || !$rolId) {
                        $mensaje = "<p style='color:red;'>Nombre, correo, password y rol son obligatorios.</p>";
                        break;
                    }

                    $payload = [
                        "nombre"   => $nombre,
                        "correo"   => $correo,
                        "telefono" => $telefono,
                        "password" => $password,
                        "docnum"   => $docnum,
                        "rolId"    => (int)$rolId,
                        "tipdocId" => $tipdocId ? (int)$tipdocId : null,
                        "activo"   => $activo,
                        "origen"   => $origen
                    ];

                    $res = $this->service->crearUsuario($payload);
                    $mensaje = $res["success"]
                        ? "<p style='color:green;'>Usuario creado correctamente.</p>"
                        : "<p style='color:red;'>Error al crear: {$res["error"]}</p>";
                    break;

                case "actualizar":
                    $id       = $_POST["id"] ?? null;
                    $rolId    = $_POST["rolId"] ?? null;
                    $activo   = isset($_POST["activo"]) && $_POST["activo"] ? true : false;

                    if (!$id) {
                        $mensaje = "<p style='color:red;'>Falta ID para actualizar.</p>";
                        break;
                    }

                    $payload = [
                        "rolId"  => $rolId ? (int)$rolId : null,
                        "activo" => $activo
                    ];

                    $res = $this->service->actualizarUsuario($id, $payload);
                    $mensaje = $res["success"]
                        ? "<p style='color:green;'>Usuario actualizado.</p>"
                        : "<p style='color:red;'>Error al actualizar: {$res["error"]}</p>";
                    break;

                case "eliminar":
                    $id = $_POST["id"] ?? null;
                    if (!$id) {
                        $mensaje = "<p style='color:red;'>Falta ID para eliminar.</p>";
                        break;
                    }
                    $res = $this->service->eliminarUsuario($id);
                    $mensaje = $res["success"]
                        ? "<p style='color:green;'>Usuario eliminado.</p>"
                        : "<p style='color:red;'>Error al eliminar: {$res["error"]}</p>";
                    break;
            }
        }

        // ---------- GET: filtros (rolId, activo) opcionales ----------
        $filtros = [
            "rolId" => $_GET["rolId"] ?? null,
            "activo" => $_GET["activo"] ?? null
        ];
        $filtros = array_filter($filtros, fn($v) => $v !== null && $v !== "");

        $usuarios = $this->service->listarUsuarios($filtros);

        require __DIR__ . '/../../vista/sistemausuarios/gestion_usuarios.php';
    }
}
