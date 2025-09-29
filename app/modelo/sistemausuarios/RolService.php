<?php
require_once __DIR__ . '/../../core/ApiClient.php';

class RolService {
    private $apiClient;

    public function __construct() {
        $this->apiClient = new ApiClient();
    }

    /**
     * Obtiene la lista de todos los roles desde la API.
     *
     * @param string $token El token JWT para autenticar la petición.
     * @return array|null La lista de roles o null si falla.
     */
    public function listarRoles(string $token): ?array {
        $endpoint = '/roles';
        $response = $this->apiClient->request('GET', $endpoint, null, $token);

        if ($response['code'] === 200) {
            return $response['body'];
        }
        return null;
    }
}