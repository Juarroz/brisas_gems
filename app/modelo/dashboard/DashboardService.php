<?php
require_once __DIR__ . '/../../core/ApiClient.php';

class DashboardService {
    private $apiClient;

    public function __construct() {
        $this->apiClient = new ApiClient();
    }

    public function contarUsuariosActivos(string $token): int {
        $endpoint = '/usuarios/count?activo=true';
        $response = $this->apiClient->request('GET', $endpoint, null, $token);
        return ($response['code'] === 200) ? (int)$response['body'] : 0;
    }

    public function contarUsuariosInactivos(string $token): int {
        $endpoint = '/usuarios/count?activo=false';
        $response = $this->apiClient->request('GET', $endpoint, null, $token);
        return ($response['code'] === 200) ? (int)$response['body'] : 0;
    }

    public function contarContactosNuevos(string $token): int {
        $endpoint = '/contactos/count?estado=pendiente';
        $response = $this->apiClient->request('GET', $endpoint, null, $token);
        return ($response['code'] === 200) ? (int)$response['body'] : 0;
    }

    public function contarPedidosPorEstado(string $estado, string $token): int {
        $endpoint = '/pedidos/count?estado=' . urlencode($estado);
        $response = $this->apiClient->request('GET', $endpoint, null, $token);
        return ($response['code'] === 200) ? (int)$response['body'] : 0;
    }
}