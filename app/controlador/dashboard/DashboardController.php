<?php
require_once __DIR__ . '/../../modelo/dashboard/DashboardService.php';
require_once __DIR__ . '/../../core/AuthGuard.php';

class DashboardController {
    private $dashboardService;

    public function __construct() {
        $this->dashboardService = new DashboardService();
    }

    public function showDashboard() {
        requireLogin();
        $token = $_SESSION['jwt_token'];

        // Obtenemos todas las estadísticas llamando al servicio
        $totalUsuariosActivos = $this->dashboardService->contarUsuariosActivos($token);
        $totalUsuariosInactivos = $this->dashboardService->contarUsuariosInactivos($token);
        $totalContactos = $this->dashboardService->contarContactosNuevos($token);
        
        $pedidosEnDiseño = $this->dashboardService->contarPedidosPorEstado('diseño', $token);
        $pedidosEnTallado = $this->dashboardService->contarPedidosPorEstado('tallado', $token);
        $pedidosEnEngaste = $this->dashboardService->contarPedidosPorEstado('engaste', $token);
        $pedidosEnPulido = $this->dashboardService->contarPedidosPorEstado('pulido', $token);
        $pedidosCancelados = $this->dashboardService->contarPedidosPorEstado('cancelado', $token);

        // --- RUTA CORREGIDA Y FINAL ---
        // Se asegura de cargar la vista desde la ubicación correcta.
        require_once __DIR__ . '/../../vista/dashboard/dashboard.php';
    }
}