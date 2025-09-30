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
        $opciones = $this->opcService->listar();
        if ($opciones === false || !is_array($opciones)) $opciones = [];

        $catalogo = [];

        foreach ($opciones as $opc) {
            $opcId   = (int)($opc['opc_id'] ?? $opc['id'] ?? 0);
            $opcName = (string)($opc['opc_nombre'] ?? $opc['nombre'] ?? '');
            if (!$opcId || !$opcName) continue;

            // Crear slug para carpetas y data-atributos
            $slug = $this->slug($opcName);

            $valores = $this->valService->listar($opcId);
            $vals = [];
            if ($valores && is_array($valores)) {
                foreach ($valores as $v) {
                    $valId   = (int)($v['val_id'] ?? $v['id'] ?? 0);
                    $valName = (string)($v['val_nombre'] ?? $v['nombre'] ?? '');
                    if (!$valId || !$valName) continue;

                    $valSlug = $this->slug($valName);

                    $vals[] = [
                        'id'     => $valId,
                        'nombre' => $valName,
                        'slug'   => $valSlug
                    ];
                }
            }

            $catalogo[] = [
                'opc_id' => $opcId,
                'nombre' => $opcName,
                'slug'   => $slug,
                'valores'=> $vals
            ];
        }

        $CATALOGO = $catalogo;
        require __DIR__ . '/../../vista/personalizacionproductos/personalizar.php';
    }


    // POST /personalizar/guardar
    public function guardar() {
        $gema     = trim($_POST['gema']     ?? '');
        $forma    = trim($_POST['forma']    ?? '');
        $material = trim($_POST['material'] ?? '');
        $tamano   = trim($_POST['tamano']   ?? '');
        $talla    = trim($_POST['talla']    ?? '');

        $faltantes = [];
        foreach (['gema','forma','material','tamano','talla'] as $k) {
            if (empty($_POST[$k])) $faltantes[] = $k;
        }
        if ($faltantes) {
            header('Location: ' . BASE_URL . '/personalizar?msg=error_campos&faltan=' . urlencode(implode(',', $faltantes)));
            exit;
        }

        $seleccionNormalizada = [
            'gema'     => $this->norm($gema),
            'forma'    => $this->norm($forma),
            'material' => $this->norm(str_replace('-', ' ', $material)),
            'tamano'   => $this->norm($tamano) . (str_contains($tamano, 'mm') ? '' : ' mm'),
            'talla'    => str_starts_with($talla, 'talla') ? $this->norm($talla) : 'talla ' . $this->norm($talla),
        ];

        $opcIds = $this->resolverOpcionesIds();
        if (!$opcIds) {
            header('Location: ' . BASE_URL . '/personalizar?msg=error_opciones');
            exit;
        }

        $valIds = $this->resolverValoresIds($opcIds, $seleccionNormalizada);
        if (!$valIds || count($valIds) !== 5) {
            if (defined('DEBUG_MODE') && DEBUG_MODE) {
                echo "<pre>";
                echo "⛔ No se pudieron resolver los 5 val_id\n\n";
                print_r($seleccionNormalizada);
                print_r($opcIds);
                print_r($valIds);
                echo "</pre>";
                exit;
            }
            header('Location: ' . BASE_URL . '/personalizar?msg=error_valores');
            exit;
        }

        $fecha = date('Y-m-d');
        $usuarioClienteId = $_SESSION['usu_id'] ?? DEFAULT_CLIENTE_ID;

        $creado = $this->perService->crear($fecha, (int)$usuarioClienteId, $valIds);

        if (!($creado['success'] ?? false)) {
            header('Location: ' . BASE_URL . '/personalizar?msg=error_crear');
            exit;
        }

        $perId = $creado['data']['id'] ?? $creado['id'] ?? null;
        if (!$perId) {
            header('Location: ' . BASE_URL . '/personalizar?msg=error_perid');
            exit;
        }

        header('Location: ' . BASE_URL . '/contacto?per_id=' . urlencode($perId));
        exit;
    }

    // -------------------------
    // Helpers privados
    // -------------------------

    private function norm(string $s): string {
        $s = mb_strtolower(trim($s), 'UTF-8');
        $sinAcentos = iconv('UTF-8', 'ASCII//TRANSLIT', $s);
        if ($sinAcentos !== false) $s = $sinAcentos;
        $s = str_replace(['_','-'], ' ', $s);
        $s = preg_replace('/\s+/', ' ', $s);
        return trim($s);
    }

    private function slug(string $s): string {
        $s = mb_strtolower(trim($s), 'UTF-8');
        $sinAcentos = iconv('UTF-8', 'ASCII//TRANSLIT', $s);
        if ($sinAcentos !== false) $s = $sinAcentos;
        $s = preg_replace('/[^a-z0-9\s\-\.]/', '', $s);
        $s = str_replace([' ', '_'], '-', $s);
        $s = preg_replace('/-+/', '-', $s);
        return trim($s, '-');
    }

    private function resolverOpcionesIds(): ?array {
        $opciones = $this->opcService->listar();
        if ($opciones === false || !is_array($opciones)) return null;

        $targets = ['gema','forma','material','tamano','talla'];
        $map = [];

        foreach ($opciones as $opc) {
            $id   = $opc['opc_id'] ?? $opc['id'] ?? null;
            $name = strtolower((string)(
                $opc['opc_nombre'] ?? $opc['opcNombre'] ?? $opc['nombre'] ?? ''
            ));
            if (!$id) continue;

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
                    $v['val_nombre'] ?? $v['valNombre'] ?? $v['nombre'] ?? ''
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
