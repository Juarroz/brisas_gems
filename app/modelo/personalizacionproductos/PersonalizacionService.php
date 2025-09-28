<?php
// app/modelo/personalizacionproductos/PersonalizacionService.php

class PersonalizacionService {
    private string $apiUrl;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->apiUrl = rtrim(BASE_URL_API, '/') . '/personalizaciones';
    }

    private function authHeaders(): array {
        $jwt = $_SESSION['jwt'] ?? $_SESSION['access_token'] ?? null;
        $headers = ['Content-Type: application/json'];
        if ($jwt) $headers[] = 'Authorization: Bearer ' . $jwt;
        return $headers;
    }

    // POST /api/personalizaciones
    // body: { "usuId": 123|null, "notas": "..." }
    // resp: { "perId": N, ... }
    public function crear(?int $usuId = null, ?string $notas = null): array {
        $payload = [];
        if ($usuId !== null) $payload['usuId'] = $usuId;
        if ($notas !== null) $payload['notas'] = $notas;

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

    // POST /api/personalizaciones/{perId}/detalles
    // body: { "valIds": [idGema, idForma, idMaterial, idTamano, idTalla] }
    public function guardarDetalle(int $perId, array $valIds): array {
        $payload = ['valIds' => array_values($valIds)];
        $json = json_encode($payload, JSON_UNESCAPED_UNICODE);

        $url = $this->apiUrl . '/' . urlencode($perId) . '/detalles';
        $ch = curl_init($url);
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

    // (Opcional) GET /api/personalizaciones?usuId=...
    public function listarPorUsuario(int $usuId): array|false {
        $url = $this->apiUrl . '?' . http_build_query(['usuId' => $usuId]);
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

    // (Opcional) GET /api/personalizaciones/{perId}
    public function obtener(int $perId): array|false {
        $url = $this->apiUrl . '/' . urlencode($perId);
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
}
