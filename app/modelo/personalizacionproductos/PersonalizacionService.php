<?php
// app/modelo/personalizacionproducto/PersonalizacionService.php

class PersonalizacionService {
    private string $apiUrl;
    private string $apiDetalleUrl;

    public function __construct() {
        $base = rtrim(BASE_URL_API, '/');
        $this->apiUrl       = $base . '/personalizacion';
        $this->apiDetalleUrl= $base . '/personalizacion/detalle';
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    private function authHeaders(): array {
        $jwt = $_SESSION['jwt'] ?? $_SESSION['access_token'] ?? null;
        $headers = ['Content-Type: application/json'];
        if ($jwt) $headers[] = 'Authorization: Bearer ' . $jwt;
        return $headers;
    }

    // POST /personalizacion
    // { usu_id?, notas? } → { per_id, ... }
    public function crear(?int $usuarioId = null, ?string $notas = null): array {
        $payload = [];
        if ($usuarioId !== null) $payload['usu_id'] = $usuarioId;
        if ($notas !== null)     $payload['notas']  = $notas;

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

    // POST /personalizacion/detalle
    // { per_id, val_ids: [val_gema, val_forma, val_material, val_tamano, val_talla] }
    public function guardarDetalle(int $perId, array $valIds): array {
        $payload = ['per_id' => $perId, 'val_ids' => array_values($valIds)];

        $data_json = json_encode($payload, JSON_UNESCAPED_UNICODE);
        $ch = curl_init($this->apiDetalleUrl);
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

    // GET /personalizacion?usu_id=
    public function listarPorUsuario(int $usuarioId): array|false {
        $url = $this->apiUrl . '?' . http_build_query(['usu_id' => $usuarioId]);
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

    // (Opcional) GET /personalizacion/{per_id}
    public function obtener(int $perId): array|false {
        $url = $this->apiUrl . '/' . urlencode($perId);
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
}
