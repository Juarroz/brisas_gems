<?php
require_once __DIR__ . '/../../core/ApiClient.php';

class AuthService {
    private $apiClient;

    public function __construct() {
        $this->apiClient = new ApiClient();
    }

    /**
     * Intenta autenticar a un usuario contra la API.
     *
     * @param string $email
     * @param string $password
     * @return array|null Retorna los datos del usuario (incluido el token y dashboardUrl) si es exitoso, o null si falla.
     */
    public function login(string $email, string $password): ?array {
        $endpoint = '/auth/login';
        $data = [
            'email' => $email,
            'password' => $password
        ];

        // Usamos nuestro ApiClient para hacer la petición POST
        $response = $this->apiClient->request('POST', $endpoint, $data);

        // Si el código de respuesta es 200 (OK), significa que el login fue exitoso
        if ($response['code'] === 200) {
            return $response['body']; // Devolvemos el cuerpo de la respuesta, que contiene token Y dashboardUrl
        }

        // En cualquier otro caso, el login falló
        return null;
    }
}