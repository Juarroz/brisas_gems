<?php

class ApiClient {
    private $baseUrl;

    public function __construct() {
        // Ajusta la URL base de tu API de Spring Boot
        $this->baseUrl = 'http://localhost:8080/api';
    }

    /**
     * Realiza una petición a la API.
     *
     * @param string $method Método HTTP (GET, POST, PUT, DELETE, etc.).
     * @param string $endpoint El endpoint de la API (ej: /auth/login).
     * @param array|null $data Datos para enviar en el cuerpo de la petición.
     * @param string|null $token El token JWT para autenticación.
     * @return array Un array con 'code' (código HTTP) y 'body' (cuerpo de la respuesta decodificado).
     */
    public function request(string $method, string $endpoint, ?array $data = null, ?string $token = null): array {
        $url = $this->baseUrl . $endpoint;
        $ch = curl_init();

        // Configuración de cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        $headers = ['Content-Type: application/json'];
        if ($token) {
            $headers[] = 'Authorization: Bearer ' . $token;
        }

        if ($data) {
            $jsonData = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            $headers[] = 'Content-Length: ' . strlen($jsonData);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $responseBody = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            // Si hay un error de cURL (ej: no se puede conectar al servidor)
            $error_msg = curl_error($ch);
            curl_close($ch);
            // Puedes manejar este error de forma más elegante, por ahora lo lanzamos
            throw new Exception("Error de cURL: " . $error_msg);
        }

        curl_close($ch);

        return [
            'code' => $responseCode,
            'body' => json_decode($responseBody, true)
        ];
    }
}