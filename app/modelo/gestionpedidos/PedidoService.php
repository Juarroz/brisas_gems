<?php

class PedidoService {
    private $apiUrl = "http://localhost:8080/api/pedidos";

    public function listarPedidos() {
        $respuesta = @file_get_contents($this->apiUrl);
        if ($respuesta === false) return [];
        return json_decode($respuesta, true);
    }

    public function obtenerPedido($id) {
        $respuesta = @file_get_contents($this->apiUrl . "/" . urlencode($id));
        if ($respuesta === false) return false;
        return json_decode($respuesta, true);
    }

    public function crearPedido(array $datos) {
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

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return ["success" => false, "error" => $error];
        }

        curl_close($ch);

        if ($http_code === 200 || $http_code === 201) {
            return ["success" => true, "data" => json_decode($respuesta, true)];
        }
        return ["success" => false, "error" => "HTTP $http_code", "data" => $respuesta];
    }

    public function actualizarPedido($id, array $datos) {
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

    public function eliminarPedido($id) {
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
