<?php
class PortafolioInspiracionService {
    private $apiUrl = "http://localhost:8080/api/portafolio";

    // Listar todo
    public function listar() {
        $respuesta = @file_get_contents($this->apiUrl);
        if ($respuesta === false) return [];
        return json_decode($respuesta, true);
    }

    // Obtener por ID
    public function obtener($id) {
        $respuesta = @file_get_contents($this->apiUrl . "/" . urlencode($id));
        if ($respuesta === false) return null;
        return json_decode($respuesta, true);
    }

    // Crear
    public function crear(array $datos) {
        $data_json = json_encode($datos);
        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_json)
        ]);

        $respuesta = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200 || $http_code === 201) {
            return ["success" => true, "data" => json_decode($respuesta, true)];
        }
        return ["success" => false, "error" => "HTTP $http_code", "data" => $respuesta];
    }

    // Actualizar
    public function actualizar($id, array $datos) {
        $data_json = json_encode($datos);
        $ch = curl_init($this->apiUrl . "/" . urlencode($id));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_json)
        ]);

        $respuesta = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($http_code >= 200 && $http_code < 300)
            ? ["success" => true, "data" => json_decode($respuesta, true)]
            : ["success" => false, "error" => "HTTP $http_code", "data" => $respuesta];
    }

    // Eliminar
    public function eliminar($id) {
        $ch = curl_init($this->apiUrl . "/" . urlencode($id));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $respuesta = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($http_code >= 200 && $http_code < 300)
            ? ["success" => true]
            : ["success" => false, "error" => "HTTP $http_code", "data" => $respuesta];
    }
}
