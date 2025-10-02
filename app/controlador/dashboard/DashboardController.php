<?php
require_once __DIR__ . '/../../modelo/dashboard/DashboardService.php';

class DashboardController {
    private $dashboardService;

    public function __construct() {
        $this->dashboardService = new DashboardService();
    }

    public function showDashboard() {
        if (session_status() == PHP_SESSION_NONE) { 
            session_start(); 
        }

        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['jwt_token'])) {
            header('Location: ' . BASE_URL . '/login');
            exit();
        }

        // Obtener el rol del usuario para mostrar el dashboard correcto
        $userRole = $_SESSION['user_role'] ?? 'ROLE_USUARIO';
        
        // Redirigir al dashboard específico según el rol
        switch ($userRole) {
            case 'ROLE_ADMINISTRADOR':
                $this->showAdminDashboard();
                break;
            case 'ROLE_DISEÑADOR':
                $this->showDesignerDashboard();
                break;
            case 'ROLE_USUARIO':
                $this->showUserDashboard();
                break;
            default:
                $this->showUserDashboard();
        }
    }

    private function showAdminDashboard() {
    // Traer estadísticas reales desde el servicio
    $data = $this->dashboardService->getAdminStats();

    // Pasar $data a la vista
    require __DIR__ . '/../../vista/dashboard/dashboard.php';
    }

    private function showDesignerDashboard() {
        // Cargar datos específicos para diseñador
        $data = $this->dashboardService->getDesignerStats();
        // ✅ RUTA CORREGIDA
        require_once __DIR__ . '/../../vista/dashboard/designer_dashboard.php';
    }

    private function showUserDashboard() {
        // Cargar datos específicos para usuario
        $data = $this->dashboardService->getUserStats();
        // ✅ RUTA CORREGIDA
        require_once __DIR__ . '/../../vista/dashboard/user_dashboard.php';
    }
}