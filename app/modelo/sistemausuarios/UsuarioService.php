<?php

class UsuarioService {
    // URL base de tu API en Spring Boot
    private $apiBaseUrl = "http://localhost:8080";

    /**
     * Intenta autenticar a un usuario contra la API.
     * @param string $email El correo del usuario.
     * @param string $password La contraseña del usuario.
     * @return array Resultado con el estado y el token o un mensaje de error.
     */
    public function login($email, $password) {
        $loginUrl = $this->apiBaseUrl . "/api/auth/login";
        $data = ['email' => $email, 'password' => $password];
        $data_json = json_encode($data);

        $ch = curl_init($loginUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_json)
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200) {
            $responseData = json_decode($response, true);
            return ["success" => true, "token" => $responseData['token']];
        } else {
            return ["success" => false, "error" => "Credenciales incorrectas o usuario inactivo (Código: " . $http_code . ")"];
        }
    }

    /**
     * Obtiene la lista de usuarios desde la API, usando un token JWT para la autorización.
     * @param string $token El token JWT.
     * @return array|false La lista de usuarios o false si hay un error.
     */
    public function obtenerUsuarios($token) {
        $usuariosUrl = $this->apiBaseUrl . "/api/usuarios";

        $ch = curl_init($usuariosUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200) {
            $responseData = json_decode($response, true);
            return $responseData['content']; // Extrae los usuarios de la respuesta paginada
        } else {
            return false; // El token puede ser inválido o haber expirado
        }
    }

    /**
     * Registra un nuevo usuario en la API.
     * @param array $userData Los datos del usuario a registrar.
     * @return array Resultado con el estado de la operación.
     */
    public function registrarUsuario($userData) {
        $registroUrl = $this->apiBaseUrl . "/api/usuarios";
        $data_json = json_encode($userData);

        $ch = curl_init($registroUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_json)
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 201) { // 201 Created es la respuesta correcta
            return ["success" => true];
        } else {
            $errorData = json_decode($response, true);
            $errorMessage = $errorData['message'] ?? "Error desconocido (Código: " . $http_code . ")";
            return ["success" => false, "error" => $errorMessage];
        }
    }
}