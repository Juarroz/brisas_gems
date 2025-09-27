<?php

class ContactoService {
    
    private $apiUrl = "http://localhost:8080/api/contactos";

    // listar
    public function listarContactos(array $filtros = []) {
        $url = $this->apiUrl;

        if (!empty($filtros)) {
            // agregar fechaDesde/Hasta luego
            $permitidos = ['via', 'estado'];
            $query = array_intersect_key($filtros, array_flip($permitidos));
            if (!empty($query)) {
                $url .= '?' . http_build_query($query);
            }
        }

        $respuesta = @file_get_contents($url);
        if ($respuesta === false) return false;

        return json_decode($respuesta, true);
    }

    // listar por id
    public function obtenerContacto($id) {
        $respuesta = @file_get_contents($this->apiUrl . "/" . urlencode($id));
        if ($respuesta === false) return false;

        return json_decode($respuesta, true);
    }

    // crear
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

    // actualizar
    public function actualizarContacto($id, array $datos) {
        $data_json = json_encode($datos);

        $ch = curl_init($this->apiUrl . "/" . urlencode($id));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length' => strlen($data_json)
        ]);

        $respuesta = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return ["success" => false, "error" => $error];
        }

        curl_close($ch);

        if ($http_code >= 200 && $http_code < 300) {
            return ["success" => true, "data" => json_decode($respuesta, true)];
        }
        return ["success" => false, "error" => "HTTP $http_code", "data" => $respuesta];
    }

    
    public function eliminarContacto($id) {
        $ch = curl_init($this->apiUrl . "/" . urlencode($id));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $respuesta = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return ["success" => false, "error" => $error];
        }

        curl_close($ch);
        return ($http_code >= 200 && $http_code < 300)
            ? ["success" => true]
            : ["success" => false, "error" => "HTTP $http_code", "data" => $respuesta];
    }
}
