<?php
// app/controlador/personalizacionproductos/GestionPersonalizacionController.php

require_once __DIR__ . '/../../modelo/personalizacionproductos/OpcionPersonalizacionService.php';
require_once __DIR__ . '/../../modelo/personalizacionproductos/ValorPersonalizacionService.php';

class GestionPersonalizacionController {

    private OpcionPersonalizacionService $opcService;
    private ValorPersonalizacionService $valService;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->restringirRoles(['administrador','diseñador']); // ajusta a tus roles reales
        $this->opcService = new OpcionPersonalizacionService();
        $this->valService = new ValorPersonalizacionService();
    }

    private function restringirRoles(array $rolesPermitidos): void {
        $rolNombre = $_SESSION['rol_nombre'] ?? null;
        $ok = is_string($rolNombre) && in_array(strtolower($rolNombre), array_map('strtolower', $rolesPermitidos), true);
        if (!$ok) {
            http_response_code(403);
            die('Acceso denegado: necesitas permisos de ' . implode(' o ', $rolesPermitidos));
        }
    }

    public function listarOpciones() {
    $opciones = $this->opcService->listar();
    if ($opciones === false) $opciones = [];

    // feedback por query string
    $mensaje = null;
    if (isset($_GET["msg"])) {
        switch ($_GET["msg"]) {
            case "creado":     $mensaje = "<div class='alert alert-success'>Opción creada.</div>"; break;
            case "actualizado":$mensaje = "<div class='alert alert-success'>Opción actualizada.</div>"; break;
            case "eliminado":  $mensaje = "<div class='alert alert-success'>Opción eliminada.</div>"; break;
            case "error":      $mensaje = "<div class='alert alert-danger'>Ocurrió un error.</div>"; break;
        }
    }

    require __DIR__ . '/../../vista/personalizacionproductos/opciones_admin.php';
}

    public function listarValores() {
    $opcId    = isset($_GET['opc_id']) ? (int)$_GET['opc_id'] : null;
    $valores  = $this->valService->listar($opcId);
    if ($valores === false) $valores = [];

    // Para el filtro
    $opciones = $this->opcService->listar();
    if ($opciones === false) $opciones = [];

    $mensaje = null;
    if (isset($_GET["msg"])) {
        switch ($_GET["msg"]) {
            case "creado":     $mensaje = "<div class='alert alert-success'>Valor creado.</div>"; break;
            case "actualizado":$mensaje = "<div class='alert alert-success'>Valor actualizado.</div>"; break;
            case "eliminado":  $mensaje = "<div class='alert alert-success'>Valor eliminado.</div>"; break;
            case "error":      $mensaje = "<div class='alert alert-danger'>Ocurrió un error.</div>"; break;
        }
    }

    require __DIR__ . '/../../vista/personalizacionproductos/valores_admin.php';
}

}
