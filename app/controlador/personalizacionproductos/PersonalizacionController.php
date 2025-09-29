<?php
// app/controlador/personalizacionproductos/PersonalizacionController.php

require_once __DIR__ . '/../../modelo/personalizacionproductos/PersonalizacionService.php';
require_once __DIR__ . '/../../modelo/personalizacionproductos/OpcionPersonalizacionService.php';
require_once __DIR__ . '/../../modelo/personalizacionproductos/ValorPersonalizacionService.php';

class PersonalizacionController {

    private PersonalizacionService $perService;
    private OpcionPersonalizacionService $opcService;
    private ValorPersonalizacionService $valService;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->perService = new PersonalizacionService();
        $this->opcService = new OpcionPersonalizacionService();
        $this->valService = new ValorPersonalizacionService();
    }

    // GET /personalizar
    public function mostrar() {
        require __DIR__ . '/../../vista/personalizacionproductos/personalizar.php';
    }

    // POST /personalizar/guardar
    public function guardar() {
        // 1) Entradas del form
        $gema     = trim($_POST['gema']     ?? '');
        $forma    = trim($_POST['forma']    ?? '');
        $material = trim($_POST['material'] ?? '');
        $tamano   = trim($_POST['tamano']   ?? '');
        $talla    = trim($_POST['talla']    ?? '');

        // Validaciones mínimas
        $faltantes = [];
        foreach (['gema','forma','material','tamano','talla'] as $k) {
            if (empty($_POST[$k])) $faltantes[] = $k;
        }
        if ($faltantes) {
            header('Location: ' . BASE_URL . '/personalizar?msg=error_campos&faltan=' . urlencode(implode(',', $faltantes)));
            exit;
        }

        // 2) Normaliza textos del UI a cómo están guardados en BD
        $seleccionNormalizada = [
            'gema'     => $this->norm($gema),
            'forma'    => $this->norm($forma),
            'material' => $this->norm(str_replace('-', ' ', $material)),
            'tamano'   => $this->norm($tamano) . (str_contains($tamano, 'mm') ? '' : ' mm'),
            'talla'    => str_starts_with($talla, 'talla') ? $this->norm($talla) : 'talla ' . $this->norm($talla),
        ];

        // 3) Mapa opc_id
        $opcIds = $this->resolverOpcionesIds();
        if (!$opcIds) {
            header('Location: ' . BASE_URL . '/personalizar?msg=error_opciones');
            exit;
        }

        // 4) Resolver val_id para cada selección del usuario
        $valIds = $this->resolverValoresIds($opcIds, $seleccionNormalizada);
        if (!$valIds || count($valIds) !== 5) {
            header('Location: ' . BASE_URL . '/personalizar?msg=error_valores');
            exit;
        }

        // 5) Crear personalización (un solo POST según tu API)
        $fecha = date('Y-m-d');
        // tu DTO exige int; si el usuario no está logueado, decide:
        // a) exigir login y redirigir, o b) usar 0 como invitado.
        $usuarioClienteId = isset($_SESSION['usu_id'])
            ? (int)$_SESSION['usu_id']
            : (int)DEFAULT_CLIENTE_ID;

        $creado = $this->perService->crear($fecha, $usuarioClienteId, $valIds);

        // Debug temporal si falla
        if (!($creado['success'] ?? false)) {
            if (defined('DEBUG_MODE') && DEBUG_MODE) {
                echo "<pre style='white-space:pre-wrap'>";
                echo "Fallo al crear personalización (POST /api/personalizaciones)\n\n";
                echo htmlspecialchars(print_r($creado, true));
                echo "\n\nPayload enviado:\n" . htmlspecialchars(print_r([
                    'fecha'                => $fecha,
                    'usuarioClienteId'     => $usuarioClienteId,
                    'valoresSeleccionados' => $valIds,
                ], true));
                echo "\n\nURL: " . htmlspecialchars(rtrim(BASE_URL_API, '/') . '/personalizaciones');
                echo "</pre>";
                exit;
            }
            header('Location: ' . BASE_URL . '/personalizar?msg=error_crear');
            exit;
        }

        // La API responde con {"id": N, ...}
        $perId = $creado['data']['id'] ?? $creado['id'] ?? null;
        if (!$perId) {
            header('Location: ' . BASE_URL . '/personalizar?msg=error_perid');
            exit;
        }

        // 6) OK → redirigir con per_id
        header('Location: ' . BASE_URL . '/contacto-usuario?per_id=' . urlencode($perId));
        exit;

    }

    // -------------------------
    // Helpers privados
    // -------------------------

    private function norm(string $s): string {
        $s = strtolower(trim($s));
        $s = str_replace(['  '], [' '], $s);
        return $s;
    }

    private function resolverOpcionesIds(): ?array {
        $opciones = $this->opcService->listar();
        if ($opciones === false || !is_array($opciones)) return null;

        $targets = ['gema','forma','material','tamano','talla'];
        $map = [];

        foreach ($opciones as $opc) {
            $id   = $opc['opc_id'] ?? $opc['id'] ?? null;
            $name = strtolower((string)(
                $opc['opc_nombre']   // snake
                ?? $opc['opcNombre'] // camel
                ?? $opc['nombre']
                ?? ''
            ));
            $slug = strtolower((string)($opc['slug'] ?? ''));

            if (!$id) continue;

            if ($slug && in_array($slug, $targets, true)) {
                $map[$slug] = (int)$id;
                continue;
            }

            if (str_contains($name, 'gema'))     $map['gema']     = (int)$id;
            if (str_contains($name, 'forma'))    $map['forma']    = (int)$id;
            if (str_contains($name, 'material')) $map['material'] = (int)$id;
            if (str_contains($name, 'tama'))     $map['tamano']   = (int)$id;
            if (str_contains($name, 'talla'))    $map['talla']    = (int)$id;
        }

        foreach ($targets as $t) if (!isset($map[$t])) return null;
        return $map;
    }

    private function resolverValoresIds(array $opcIds, array $seleccion): ?array {
        $orden = ['gema','forma','material','tamano','talla'];
        $result = [];

        foreach ($orden as $slug) {
            $opcId = $opcIds[$slug] ?? null;
            $buscado = $this->norm((string)$seleccion[$slug]);
            if (!$opcId) return null;

            $valores = $this->valService->listar((int)$opcId);
            if ($valores === false || !is_array($valores)) return null;

            $valId = null;
            foreach ($valores as $v) {
                $nombre = $this->norm((string)(
                    $v['val_nombre']   // snake
                    ?? $v['valNombre'] // camel
                    ?? $v['nombre']
                    ?? ''
                ));
                if ($nombre === $buscado ||
                    str_replace(['-',' '], '', $nombre) === str_replace(['-',' '], '', $buscado)) {
                    $valId = (int)($v['val_id'] ?? $v['id']);
                    break;
                }
            }
            if (!$valId) return null;
            $result[] = $valId;
        }
        return $result;
    }
}
