<?php
// ================================
// modelo/sistemausuarios/GestionUsuariosService.php
// ================================
class GestionUsuariosService {
    private $apiUrl = "http://localhost:8080/api/usuarios";

    // ----------- LISTAR -----------
    public function listarUsuarios(array $filtros = []) {
        $url = $this->apiUrl;

        if (!empty($filtros)) {
            $query = array_filter($filtros, fn($v) => $v !== null && $v !== "");
            if (!empty($query)) {
                $url .= '?' . http_build_query($query);
            }
        }

        $respuesta = @file_get_contents($url);
        if ($respuesta === false) return false;

        return json_decode($respuesta, true);
    }

    // ----------- OBTENER POR ID -----------
    public function obtenerUsuario($id) {
        $respuesta = @file_get_contents($this->apiUrl . "/" . urlencode($id));
        if ($respuesta === false) return false;
        return json_decode($respuesta, true);
    }

    // ----------- CREAR -----------
    public function crearUsuario(array $datos) {
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

    // ----------- ACTUALIZAR -----------
    public function actualizarUsuario($id, array $datos) {
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
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return ["success" => false, "error" => $error];
        }
        curl_close($ch);

        return ($http_code >= 200 && $http_code < 300)
            ? ["success" => true, "data" => json_decode($respuesta, true)]
            : ["success" => false, "error" => "HTTP $http_code", "data" => $respuesta];
    }

    // ----------- ELIMINAR -----------
    public function eliminarUsuario($id) {
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
