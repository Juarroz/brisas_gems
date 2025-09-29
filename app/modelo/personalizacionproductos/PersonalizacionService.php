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

    /**
     * POST /api/personalizaciones
     * Body:
     * {
     *   "fecha": "YYYY-MM-DD",
     *   "usuarioClienteId": 123,
     *   "valoresSeleccionados": [idGema, idForma, idMaterial, idTamano, idTalla]
     * }
     * Respuesta: { "id": N, ... }
     */
    public function crear(string $fecha, int $usuarioClienteId, array $valoresSeleccionados): array {
        $payload = [
            'fecha'                => $fecha,
            'usuarioClienteId'     => $usuarioClienteId,
            'valoresSeleccionados' => array_values($valoresSeleccionados),
        ];

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

        if ($err) return ['success'=>false, 'error'=>$err, 'http_code'=>$code];
        return ($code >= 200 && $code < 300)
            ? ['success'=>true, 'data'=>json_decode($resp, true), 'http_code'=>$code]
            : ['success'=>false, 'error'=>"HTTP $code", 'data'=>$resp, 'http_code'=>$code];
    }

    // (Opcional) GET /api/personalizaciones?clienteId=...
    public function listarPorCliente(int $clienteId, ?string $fechaDesde=null, ?string $fechaHasta=null): array|false {
        $q = ['clienteId' => $clienteId];
        if ($fechaDesde) $q['fechaDesde'] = $fechaDesde;
        if ($fechaHasta) $q['fechaHasta'] = $fechaHasta;

        $url = $this->apiUrl . '?' . http_build_query($q);
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

    // (Opcional) GET /api/personalizaciones/{id}
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
}
