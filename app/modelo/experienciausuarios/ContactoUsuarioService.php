<?php

class ContactoUsuarioService {
    
    private $apiUrl = "http://localhost:8080/api/contactos";

    // Solo crear contacto
    public function crearContacto(array $datos) {
        $data_json = json_encode($datos);

        $process = curl_init($this->apiUrl);
        curl_setopt($process, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($process, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($process, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_json)
        ]);

        $respuesta = curl_exec($process);
        $http_code = curl_getinfo($process, CURLINFO_HTTP_CODE);

        if (curl_errno($process)) {
            $error = curl_error($process);
            curl_close($process);
            return ["success" => false, "error" => $error];
        }

        curl_close($process);

        if ($http_code === 200 || $http_code === 201) {
            return ["success" => true, "data" => json_decode($respuesta, true)];
        }
        return ["success" => false, "error" => "HTTP $http_code", "data" => $respuesta];
    }
}
