<?php
// app/modelo/personalizacionproducto/ValorPersonalizacionService.php

class ValorPersonalizacionService {
    private string $apiUrl;

    public function __construct() {
        $base = rtrim(BASE_URL_API, '/');
        $this->apiUrl = $base . '/personalizacion/valores';
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    private function authHeaders(): array {
        $jwt = $_SESSION['jwt'] ?? $_SESSION['access_token'] ?? null;
        $headers = ['Content-Type: application/json'];
        if ($jwt) $headers[] = 'Authorization: Bearer ' . $jwt;
        return $headers;
    }

    private function buildUrl(array $query = []): string {
        if (empty($query)) return $this->apiUrl;
        return $this->apiUrl . '?' . http_build_query($query);
    }

    // GET /personalizacion/valores[?opc_id=]
    public function listar(?int $opcId = null): array|false {
        $q = [];
        if ($opcId !== null) $q['opc_id'] = $opcId;

        $url = $this->buildUrl($q);
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => implode("\r\n", $this->authHeaders())
            ]
        ]);
        $respuesta = @file_get_contents($url, false, $context);
        if ($respuesta === false) return false;
        return json_decode($respuesta, true);
    }

    // GET /personalizacion/valores/{id}
    public function obtener(int $id): array|false {
        $url = $this->apiUrl . '/' . urlencode($id);
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => implode("\r\n", $this->authHeaders())
            ]
        ]);
        $respuesta = @file_get_contents($url, false, $context);
        if ($respuesta === false) return false;
        return json_decode($respuesta, true);
    }

    // POST /personalizacion/valores
    public function crear(int $opcId, string $nombre, ?string $imagenUrl = null, ?string $slug = null): array {
        $payload = ['opc_id' => $opcId, 'val_nombre' => $nombre];
        if ($imagenUrl !== null) $payload['val_imagen'] = $imagenUrl;
        if ($slug !== null)      $payload['slug'] = $slug;

        $data_json = json_encode($payload, JSON_UNESCAPED_UNICODE);
        $ch = curl_init($this->apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $data_json,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => array_merge($this->authHeaders(), ['Content-Length: ' . strlen($data_json)]),
        ]);
        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) { $err = curl_error($ch); curl_close($ch); return ['success'=>false,'error'=>$err]; }
        curl_close($ch);

        return ($code >= 200 && $code < 300)
            ? ['success'=>true, 'data'=>json_decode($resp, true)]
            : ['success'=>false, 'error'=>"HTTP $code", 'data'=>$resp];
    }

    // PUT /personalizacion/valores/{id}
    public function actualizar(int $id, array $datos): array {
        // $datos puede incluir: val_nombre, val_imagen, slug, opc_id (si permites mover de opción)
        $data_json = json_encode($datos, JSON_UNESCAPED_UNICODE);
        $ch = curl_init($this->apiUrl . '/' . urlencode($id));
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST  => 'PUT',
            CURLOPT_POSTFIELDS     => $data_json,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => array_merge($this->authHeaders(), ['Content-Length: ' . strlen($data_json)]),
        ]);
        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) { $err = curl_error($ch); curl_close($ch); return ['success'=>false,'error'=>$err]; }
        curl_close($ch);

        return ($code >= 200 && $code < 300)
            ? ['success'=>true, 'data'=>json_decode($resp, true)]
            : ['success'=>false, 'error'=>"HTTP $code", 'data'=>$resp];
    }

    // DELETE /personalizacion/valores/{id}
    public function eliminar(int $id): array {
        $ch = curl_init($this->apiUrl . '/' . urlencode($id));
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST  => 'DELETE',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $this->authHeaders(),
        ]);
        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) { $err = curl_error($ch); curl_close($ch); return ['success'=>false,'error'=>$err]; }
        curl_close($ch);

        return ($code >= 200 && $code < 300)
            ? ['success'=>true]
            : ['success'=>false,'error'=>"HTTP $code",'data'=>$resp];
    }
}
