<?php
// app/controlador/personalizacionproducto/PersonalizacionController.php
// (Vista y servicios se conectan en el siguiente paso)

class PersonalizacionController {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    // GET /personalizar
    public function mostrar() {
        // Placeholder (en Paso C incluimos la vista real)
        echo "<h1>Personalización de Joyas</h1><p>Configurador listo para integrar vista y servicios.</p>";
    }

    // POST /personalizar/guardar
    public function guardar() {
        // Recibir selección básica (mapearemos a val_id en el próximo paso)
        $gema     = $_POST['gema']     ?? null;
        $forma    = $_POST['forma']    ?? null;
        $material = $_POST['material'] ?? null;
        $tamano   = $_POST['tamano']   ?? null;
        $talla    = $_POST['talla']    ?? null;

        // Validaciones mínimas
        $faltantes = [];
        foreach (['gema','forma','material','tamano','talla'] as $k) {
            if (empty($_POST[$k])) $faltantes[] = $k;
        }

        if ($faltantes) {
            http_response_code(422);
            echo "Faltan campos: " . implode(', ', $faltantes);
            return;
        }

        // Próximo paso: usar PersonalizacionService->crear() y ->guardarDetalle()
        // Por ahora confirmamos recepción:
        $resumen = compact('gema','forma','material','tamano','talla');
        echo "Selección recibida (aún sin persistir): " . htmlspecialchars(json_encode($resumen, JSON_UNESCAPED_UNICODE));
    }
}
