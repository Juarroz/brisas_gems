<?php
require_once __DIR__ . '/../../core/ApiClient.php';

class DashboardService {
    private $apiClient;

    public function __construct() {
        $this->apiClient = new ApiClient();
    }

    // ✅ NUEVO MÉTODO AGREGADO - Para el dashboard de admin
    public function getAdminStats() {
        // Datos de ejemplo para admin (puedes conectar con API después)
        return [
            'pedidosEnDiseño' => 0,
            'pedidosEnTallado' => 2,
            'pedidosEnEngaste' => 1,
            'pedidosEnPulido' => 0,
            'pedidosCancelados' => 0,
            'totalContactos' => 5,
            'totalUsuariosActivos' => 8,
            'totalUsuariosInactivos' => 1
        ];
    }

    public function getDesignerStats() {
        // Datos de ejemplo para diseñador
        return [
            'disenosActivos' => 3,
            'rendersPendientes' => 2,
            'comunicacionesPendientes' => 1,
            'pedidosAsignados' => 4
        ];
    }

    public function getUserStats() {
        // Datos de ejemplo para usuario
        return [
            'misPedidosActivos' => 2,
            'misPersonalizaciones' => 3,
            'pedidosCompletados' => 1
        ];
    }
}