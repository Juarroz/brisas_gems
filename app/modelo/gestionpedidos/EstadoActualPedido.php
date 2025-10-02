<?php

require_once __DIR__ . '/../../core/ApiClient.php';

class EstadoActualPedido {
    private $apiUrl = "http://localhost:8080/api/estados-pedido";

    public function listarEstados() {
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'ignore_errors' => true
            ]
        ]);
        
        $respuesta = @file_get_contents($this->apiUrl, false, $context);
        
        if ($respuesta === false) {
            error_log("ERROR EstadoActualPedido: No se pudo conectar al backend - " . $this->apiUrl);
            return ["error" => "No se pudo conectar al servidor de estados"];
        }
        
        // Verificar código HTTP
        if (isset($http_response_header[0])) {
            preg_match('/HTTP\/[0-9\.]+\s+([0-9]+)/', $http_response_header[0], $matches);
            $httpCode = $matches[1] ?? 500;
            
            if ($httpCode != 200) {
                error_log("ERROR EstadoActualPedido: HTTP $httpCode - " . $this->apiUrl);
                return ["error" => "Error del servidor: HTTP $httpCode"];
            }
        }
        
        $data = json_decode($respuesta, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("ERROR EstadoActualPedido: JSON inválido - " . json_last_error_msg());
            return ["error" => "Respuesta inválida del servidor"];
        }
        
        return $data;
    }

    public function obtenerEstadoPorId($id) {
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'ignore_errors' => true
            ]
        ]);
        
        $respuesta = @file_get_contents($this->apiUrl . "/" . urlencode($id), false, $context);
        
        if ($respuesta === false) {
            error_log("ERROR EstadoActualPedido: No se pudo obtener estado $id");
            return ["error" => "No se pudo obtener el estado"];
        }
        
        $data = json_decode($respuesta, true);
        return $data;
    }

    public function obtenerEstadoPorNombre($nombre) {
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'ignore_errors' => true
            ]
        ]);
        
        $respuesta = @file_get_contents($this->apiUrl . "/nombre/" . urlencode($nombre), false, $context);
        
        if ($respuesta === false) {
            error_log("ERROR EstadoActualPedido: No se pudo obtener estado por nombre: $nombre");
            return ["error" => "No se pudo obtener el estado por nombre"];
        }
        
        $data = json_decode($respuesta, true);
        return $data;
    }

    public function crearEstado($datos) {
        $data_json = json_encode($datos);

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_json)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $respuesta = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            error_log("ERROR EstadoActualPedido crear: " . $error);
            return ["success" => false, "error" => $error];
        }

        curl_close($ch);

        if ($http_code === 201) {
            return ["success" => true, "data" => json_decode($respuesta, true)];
        }
        
        error_log("ERROR EstadoActualPedido crear: HTTP $http_code - " . $respuesta);
        return ["success" => false, "error" => "HTTP $http_code", "data" => $respuesta];
    }

    public function actualizarEstado($id, $datos) {
        $data_json = json_encode($datos);
        $ch = curl_init($this->apiUrl . '/' . urlencode($id));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_json)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $respuesta = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            error_log("ERROR EstadoActualPedido actualizar: " . $error);
            return ["success" => false, "error" => $error];
        }
        curl_close($ch);
        if ($http_code === 200) {
            return ["success" => true, "data" => json_decode($respuesta, true)];
        }
        error_log("ERROR EstadoActualPedido actualizar: HTTP $http_code - " . $respuesta);
        return ["success" => false, "error" => "HTTP $http_code", "data" => $respuesta];
    }

    public function eliminarEstado($id) {
        $ch = curl_init($this->apiUrl . '/' . urlencode($id));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $respuesta = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            error_log("ERROR EstadoActualPedido eliminar: " . $error);
            return ["success" => false, "error" => $error];
        }
        curl_close($ch);
        if ($http_code === 204) {
            return ["success" => true];
        }
        error_log("ERROR EstadoActualPedido eliminar: HTTP $http_code - " . $respuesta);
        return ["success" => false, "error" => "HTTP $http_code", "data" => $respuesta];
    }
}