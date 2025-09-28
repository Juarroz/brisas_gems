<?php
// app/modelo/personalizacionproductos/ValorPersonalizacionService.php

class ValorPersonalizacionService {
    private string $apiUrl;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->apiUrl = rtrim(BASE_URL_API, '/') . '/valores';
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

    // GET /api/valores[?opcId=]
    public function listar(?int $opcId = null): array|false {
        $q = [];
        if ($opcId !== null) $q['opcId'] = $opcId; // camelCase según tu API
        $url = $this->buildUrl($q);

        $ctx = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => implode("\r\n", $this->authHeaders()),
                'ignore_errors' => true,
            ]
        ]);
        $resp = @file_get_contents($url, false, $ctx);
        if ($resp === false) return false;
        return json_decode($resp, true);
    }

    // GET /api/valores/{id}
    public function obtener(int $id): array|false {
        $url = $this->apiUrl . '/' . urlencode($id);
        $ctx = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => implode("\r\n", $this->authHeaders()),
                'ignore_errors' => true,
            ]
        ]);
        $resp = @file_get_contents($url, false, $ctx);
        if ($resp === false) return false;
        return json_decode($resp, true);
    }

    // POST /api/valores
    // body: { "opcId": 3, "valNombre":"...", "valImagen": "...", "slug": "..." }
    public function crear(int $opcId, string $valNombre, ?string $valImagen = null, ?string $slug = null): array {
        $payload = ['opcId' => $opcId, 'valNombre' => $valNombre];
        if ($valImagen !== null) $payload['valImagen'] = $valImagen;
        if ($slug !== null)      $payload['slug']      = $slug;

        $json = json_encode($payload, JSON_UNESCAPED_UNICODE);
        $ch = curl_init($this->apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $json,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => array_merge($this->authHeaders(), ['Content-Length: ' . strlen($json)]),
        ]);
        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($err) return ['success'=>false, 'error'=>$err];
        return ($code >= 200 && $code < 300)
            ? ['success'=>true, 'data'=>json_decode($resp, true)]
            : ['success'=>false, 'error'=>"HTTP $code", 'data'=>$resp];
    }

    // PUT /api/valores/{id}
    // body admite: valNombre, valImagen, slug, opcId
    public function actualizar(int $id, array $datos): array {
        $json = json_encode($datos, JSON_UNESCAPED_UNICODE);
        $ch = curl_init($this->apiUrl . '/' . urlencode($id));
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST  => 'PUT',
            CURLOPT_POSTFIELDS     => $json,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => array_merge($this->authHeaders(), ['Content-Length: ' . strlen($json)]),
        ]);
        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($err) return ['success'=>false, 'error'=>$err];
        return ($code >= 200 && $code < 300)
            ? ['success'=>true, 'data'=>json_decode($resp, true)]
            : ['success'=>false, 'error'=>"HTTP $code", 'data'=>$resp];
    }

    // DELETE /api/valores/{id}
    public function eliminar(int $id): array {
        $ch = curl_init($this->apiUrl . '/' . urlencode($id));
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST  => 'DELETE',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $this->authHeaders(),
        ]);
        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($err) return ['success'=>false, 'error'=>$err];
        return ($code >= 200 && $code < 300)
            ? ['success'=>true]
            : ['success'=>false, 'error'=>"HTTP $code", 'data'=>$resp];
    }
}

