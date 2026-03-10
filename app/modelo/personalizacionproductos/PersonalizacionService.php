<?php
class PersonalizacionService {
    private string $apiUrl;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        // Ajusta BASE_URL_API a la dirección de tu backend
        $this->apiUrl = rtrim(BASE_URL_API, '/') . '/personalizaciones';
    }

    private function authHeaders(): array {
        $jwt = $_SESSION['jwt'] ?? $_SESSION['access_token'] ?? null;
        $headers = ['Content-Type: application/json'];
        if ($jwt) {
            $headers[] = 'Authorization: Bearer ' . $jwt;
        }
        return $headers;
    }

    /**
     * POST /api/personalizaciones
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
            CURLOPT_HTTPHEADER     => array_merge(
                $this->authHeaders(),
                ['Content-Length: ' . strlen($json)]
            ),
        ]);

        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return ['success' => false, 'error' => $err, 'http_code' => $code];
        }

        return ($code >= 200 && $code < 300)
            ? ['success' => true, 'data' => json_decode($resp, true), 'http_code' => $code]
            : ['success' => false, 'error' => "HTTP $code", 'data' => $resp, 'http_code' => $code];
    }

    /**
     * GET /api/personalizaciones?clienteId=...
     */
    public function listarPorCliente(int $clienteId, ?string $fechaDesde = null, ?string $fechaHasta = null): array|false {
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

    /**
     * GET /api/personalizaciones/{id}
     */
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

    /**
     * GET /api/personalizaciones/{id} → detalle simplificado
     */
    public function obtenerDetalle(int $perId): array|false {
        $url = rtrim(BASE_URL_API, '/') . '/personalizaciones/' . urlencode($perId);
        $ctx = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "Content-Type: application/json\r\n",
                'ignore_errors' => true,
            ]
        ]);

        $resp = @file_get_contents($url, false, $ctx);
        if ($resp === false) return false;

        $data = json_decode($resp, true);
        if (!is_array($data)) return false;

        // Inicializar siempre los 5 campos
        $resumen = [
            'gema'     => '-',
            'forma'    => '-',
            'material' => '-',
            'tamano'   => '-',
            'talla'    => '-',
        ];

        if (!empty($data['detalles']) && is_array($data['detalles'])) {
            foreach ($data['detalles'] as $det) {
                $nombre = strtolower($det['valNombre'] ?? $det['val_nombre'] ?? '');

                // Gema
                if (str_contains($nombre, 'diamante') || str_contains($nombre, 'esmeralda') ||
                    str_contains($nombre, 'rubí') || str_contains($nombre, 'rubi') ||
                    str_contains($nombre, 'zafiro')) {
                    $resumen['gema'] = ucfirst($nombre);
                }
                // Forma
                elseif (str_contains($nombre, 'redonda') || str_contains($nombre, 'ovalada') ||
                        str_contains($nombre, 'cuadrada') || str_contains($nombre, 'corazon')) {
                    $resumen['forma'] = ucfirst($nombre);
                }
                // Material
                elseif (str_contains($nombre, 'oro') || str_contains($nombre, 'platino') ||
                        str_contains($nombre, 'plata')) {
                    $resumen['material'] = ucfirst($nombre);
                }
                // Tamaño
                elseif (str_contains($nombre, 'mm')) {
                    $resumen['tamano'] = $det['valNombre'] ?? $det['val_nombre'] ?? $nombre;
                }
                // Talla
                elseif (str_contains($nombre, 'talla')) {
                    $resumen['talla'] = ucfirst($nombre);
                }
            }
        }

        return $resumen;
    }
}
