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
    require __DIR__ . '/../../vista/personalizacionproducto/personalizar.php';
    }

    // POST /personalizar/guardar
    public function guardar() {
        // 1) Entradas del form (desde tu vista)
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
        //    - material: "oro-blanco" -> "oro blanco"
        //    - tamaño: "6" -> "6 mm"
        //    - talla: "5.5" -> "talla 5.5"
        $seleccionNormalizada = [
            'gema'     => $this->norm($gema),
            'forma'    => $this->norm($forma),
            'material' => $this->norm(str_replace('-', ' ', $material)),
            'tamano'   => $this->norm($tamano) . (str_contains($tamano, 'mm') ? '' : ' mm'),
            'talla'    => str_starts_with($talla, 'talla') ? $this->norm($talla) : 'talla ' . $this->norm($talla),
        ];

        // 3) Mapa opc_id (gema, forma, material, tamano, talla)
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

        // 5) Crear personalización + guardar detalle
        $usuId = $_SESSION['usu_id'] ?? null; // null si invitado
        $creado = $this->perService->crear($usuId, 'Selección desde configurador');
        if (!($creado['success'] ?? false)) {
            header('Location: ' . BASE_URL . '/personalizar?msg=error_crear');
            exit;
        }
        $perId = $creado['data']['per_id'] ?? null;
        if (!$perId) {
            header('Location: ' . BASE_URL . '/personalizar?msg=error_perid');
            exit;
        }

        $detalle = $this->perService->guardarDetalle($perId, $valIds);
        if (!($detalle['success'] ?? false)) {
            header('Location: ' . BASE_URL . '/personalizar?msg=error_detalle');
            exit;
        }

        // 6) OK → redirigir con per_id (luego mostramos link de WhatsApp en la vista)
        header('Location: ' . BASE_URL . '/personalizar?msg=creado&per_id=' . urlencode($perId));
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

    /**
     * Trae opciones y devuelve slug lógico => opc_id
     * DDL/INSERT definen 5 opciones: gema, forma, material, tamaño, talla (nombres “humanos”) :contentReference[oaicite:0]{index=0} :contentReference[oaicite:1]{index=1}
     */
    private function resolverOpcionesIds(): ?array {
        $opciones = $this->opcService->listar();
        if ($opciones === false || !is_array($opciones)) return null;

        $targets = ['gema','forma','material','tamano','talla'];
        $map = [];

        foreach ($opciones as $opc) {
            $id   = $opc['opc_id']     ?? $opc['id'] ?? null;
            $name = strtolower((string)($opc['opc_nombre'] ?? $opc['nombre'] ?? ''));
            $slug = strtolower((string)($opc['slug'] ?? ''));

            if (!$id) continue;

            if ($slug && in_array($slug, $targets, true)) {
                $map[$slug] = (int)$id;
                continue;
            }

            // fallback por nombre en español de tus inserts
            if (str_contains($name, 'gema'))     $map['gema']     = (int)$id;
            if (str_contains($name, 'forma'))    $map['forma']    = (int)$id;
            if (str_contains($name, 'material')) $map['material'] = (int)$id;
            if (str_contains($name, 'tama'))     $map['tamano']   = (int)$id;
            if (str_contains($name, 'talla'))    $map['talla']    = (int)$id;
        }

        foreach ($targets as $t) if (!isset($map[$t])) return null;
        return $map;
    }

    /**
     * Para cada opción (opc_id), busca el valor cuyo val_nombre coincida con la selección normalizada.
     * En BD tienes ejemplos: materiales "oro blanco / oro amarillo / plata / platino" y tamaños "6 mm / 7 mm" etc. :contentReference[oaicite:2]{index=2}
     * Devuelve [val_gema, val_forma, val_material, val_tamano, val_talla]
     */
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
                $nombre = $this->norm((string)($v['val_nombre'] ?? $v['nombre'] ?? ''));
                // igual exacto o “sin espacios/guiones”
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
