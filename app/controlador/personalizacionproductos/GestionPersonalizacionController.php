<?php
// app/controlador/personalizacionproducto/GestionPersonalizacionController.php

class GestionPersonalizacionController {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->restringirRoles(['administrador','diseñador']); // ajusta a tus nombres/ids reales
    }

    private function restringirRoles(array $rolesPermitidos): void {
        // Acepta nombre de rol en sesión; adapta si guardas rol_id
        $rolNombre = $_SESSION['rol_nombre'] ?? null;
        $ok = is_string($rolNombre) && in_array(strtolower($rolNombre), array_map('strtolower', $rolesPermitidos), true);

        // Si usas IDs, puedes mapear aquí:
        // $rolId = $_SESSION['rol_id'] ?? null;
        // $ok = $ok || (is_numeric($rolId) && in_array((int)$rolId, [1,2], true));

        if (!$ok) {
            http_response_code(403);
            die('Acceso denegado: necesitas permisos de ' . implode(' o ', $rolesPermitidos));
        }
    }

    // GET /admin/opciones
    public function listarOpciones() {
        // Próximo paso: OpcionPersonalizacionService->listar()
        echo "<h1>Admin · Opciones</h1><p>Listado pendiente de servicio.</p>";
    }

    // GET /admin/valores
    public function listarValores() {
        // Próximo paso: ValorPersonalizacionService->listar(opc_id?) con filtro
        echo "<h1>Admin · Valores</h1><p>Listado pendiente de servicio.</p>";
    }
}
