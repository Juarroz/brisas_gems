<?php
require_once __DIR__ . '/../../core/ApiClient.php';

class UsuarioService {
    private $apiClient;

    public function __construct() {
        $this->apiClient = new ApiClient();
    }

    public function crearUsuario(array $userData, ?string $token = null): array {
        $endpoint = '/usuarios';
        return $this->apiClient->request('POST', $endpoint, $userData, $token);
    }

    public function listarUsuarios(string $token, ?bool $activo = true, ?int $rolId = null): ?array {
        $queryParams = [];
        if ($activo !== null) {
            $queryParams['activo'] = $activo ? 'true' : 'false';
        }
        if ($rolId !== null) {
            $queryParams['rolId'] = $rolId;
        }
        
        $endpoint = '/usuarios';
        if (!empty($queryParams)) {
            $endpoint .= '?' . http_build_query($queryParams);
        }
        
        $response = $this->apiClient->request('GET', $endpoint, null, $token);
        if ($response['code'] === 200 && isset($response['body']['content'])) {
            return $response['body']['content'];
        }
        return null;
    }

    public function obtenerUsuarioPorId(int $id, string $token): ?array {
        $endpoint = '/usuarios/' . $id;
        $response = $this->apiClient->request('GET', $endpoint, null, $token);
        if ($response['code'] === 200) {
            return $response['body'];
        }
        return null;
    }

    public function actualizarUsuario(int $id, array $userData, string $token): array {
        $endpoint = '/usuarios/' . $id;
        $updateData = [
            'nombre' => $userData['nombre'] ?? null,
            'correo' => $userData['correo'] ?? null,
            'telefono' => $userData['telefono'] ?? null,
            'rolId' => $userData['rolId'] ?? null
        ];
        return $this->apiClient->request('PUT', $endpoint, $updateData, $token);
    }
    
    public function cambiarEstadoUsuario(int $id, bool $nuevoEstado, string $token): array {
        $endpoint = '/usuarios/' . $id . '/activo?activo=' . ($nuevoEstado ? 'true' : 'false');
        return $this->apiClient->request('PATCH', $endpoint, null, $token);
    }
}