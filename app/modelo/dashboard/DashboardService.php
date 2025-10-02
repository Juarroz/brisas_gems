<?php
require_once __DIR__ . '/../../core/ApiClient.php';
require_once __DIR__ . '/../../modelo/experienciausuarios/ContactoService.php';

class DashboardService {
    private $apiClient;
    private $contactoService;

    public function __construct() {
        $this->apiClient = new ApiClient();
        $this->contactoService = new ContactoService(); // 👈 añadimos el servicio
    }

    // Dashboard de admin
    public function getAdminStats() {
        // 🔎 Traer contactos pendientes desde la API
        $pendientes = $this->contactoService->listarContactos(['estado' => 'pendiente']);
        $totalPendientes = $pendientes ? count($pendientes) : 0;

        // TODO: aquí después puedes conectar con la API de pedidos/usuarios.
        return [
            'pedidosEnDiseño' => 0,
            'pedidosEnTallado' => 2,
            'pedidosEnEngaste' => 1,
            'pedidosEnPulido' => 0,
            'pedidosCancelados' => 0,
            'totalContactosPendientes' => $totalPendientes, // 👈 clave corregida
            'totalUsuariosActivos' => 8,
            'totalUsuariosInactivos' => 1
        ];
    }

    public function getDesignerStats() {
        return [
            'disenosActivos' => 3,
            'rendersPendientes' => 2,
            'comunicacionesPendientes' => 1,
            'pedidosAsignados' => 4
        ];
    }

    public function getUserStats() {
        return [
            'misPedidosActivos' => 2,
            'misPersonalizaciones' => 3,
            'pedidosCompletados' => 1
        ];
    }
}
