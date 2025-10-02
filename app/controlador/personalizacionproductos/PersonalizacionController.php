<?php
// app/controlador/personalizacionproductos/PersonalizacionController.php

require_once __DIR__ . '/../../modelo/personalizacionproductos/PersonalizacionService.php';

class PersonalizacionController {
    private PersonalizacionService $perService;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->perService = new PersonalizacionService();
    }

    // GET /personalizar
    public function mostrar() {
        $CATALOGO = [
            [
                'nombre' => 'Gema',
                'slug'   => 'gema',
                'valores'=> [
                    ['slug'=>'diamante','nombre'=>'Diamante','img'=>'gemas/diamante.png'],
                    ['slug'=>'esmeralda','nombre'=>'Esmeralda','img'=>'gemas/esmeralda.png'],
                    ['slug'=>'rubi','nombre'=>'Rubí','img'=>'gemas/rubi.png'],
                    ['slug'=>'zafiro','nombre'=>'Zafiro','img'=>'gemas/zafiro.png'],
                ]
            ],
            [
                'nombre' => 'Forma de la gema',
                'slug'   => 'forma',
                'valores'=> [
                    ['slug'=>'redonda','nombre'=>'Redonda','img'=>'forma/redonda.png'],
                    ['slug'=>'ovalada','nombre'=>'Ovalada','img'=>'forma/ovalada.png'],
                ]
            ],
            [
                'nombre' => 'Material',
                'slug'   => 'material',
                'valores'=> [
                    ['slug'=>'oro-amarillo','nombre'=>'Oro Amarillo','img'=>'material/oro-amarillo.png'],
                    ['slug'=>'oro-blanco','nombre'=>'Oro Blanco','img'=>'material/oro-blanco.png'],
                    ['slug'=>'oro-rosa','nombre'=>'Oro Rosa','img'=>'material/oro-rosa.png'],
                ]
            ],
            [
                'nombre' => 'Tamaño de la piedra',
                'slug'   => 'tamano',
                'valores'=> [
                    ['slug'=>'7mm','nombre'=>'7 mm','img'=>'tama-piedra-central/7mm.png'],
                    ['slug'=>'8mm','nombre'=>'8 mm','img'=>'tama-piedra-central/8mm.png'],
                ]
            ],
            [
                'nombre' => 'Talla del anillo',
                'slug'   => 'talla',
                'valores'=> [
                    ['slug'=>'talla-4','nombre'=>'Talla 4'],
                    ['slug'=>'talla-4-5','nombre'=>'Talla 4.5'],
                    ['slug'=>'talla-5','nombre'=>'Talla 5'],
                    ['slug'=>'talla-5-5','nombre'=>'Talla 5.5'],
                    ['slug'=>'talla-6','nombre'=>'Talla 6'],
                    ['slug'=>'talla-6-5','nombre'=>'Talla 6.5'],
                    ['slug'=>'talla-7','nombre'=>'Talla 7'],
                    ['slug'=>'talla-7-5','nombre'=>'Talla 7.5'],
                    ['slug'=>'talla-8','nombre'=>'Talla 8'],
                    ['slug'=>'talla-8-5','nombre'=>'Talla 8.5'],
                    ['slug'=>'talla-9','nombre'=>'Talla 9'],
                ]
            ],
        ];

        require __DIR__ . '/../../vista/personalizacionproductos/personalizar.php';
    }

    // POST /personalizar/guardar
    public function guardar() {
        $gema     = $_POST['gema'] ?? '';
        $forma    = $_POST['forma'] ?? '';
        $material = $_POST['material'] ?? '';
        $tamano   = $_POST['tamano'] ?? '';
        $talla    = $_POST['talla'] ?? '';

        if (!$gema || !$forma || !$material || !$tamano || !$talla) {
            header('Location: ' . BASE_URL . '/personalizar?msg=faltan_campos');
            exit;
        }

        // 🔑 Mapeo slugs → IDs de la BD
        $map = [
            // Gemas
            'diamante'  => 5,
            'esmeralda' => 6,
            'zafiro'    => 7,
            'rubi'      => 8,

            // Formas
            'redonda'   => 1,
            'ovalada'   => 2,

            // Materiales
            'oro-amarillo' => 9,
            'oro-blanco'   => 10,
            'oro-rosa'     => 11,

            // Tamaños
            '7mm' => 14,
            '8mm' => 15,

            // Tallas
            'talla-4'   => 16,
            'talla-4-5' => 17,
            'talla-5'   => 18,
            'talla-5-5' => 19,
            'talla-6'   => 20,
            'talla-6-5' => 21,
            'talla-7'   => 22,
            'talla-7-5' => 23,
            'talla-8'   => 24,
            'talla-8-5' => 25,
            'talla-9'   => 26,
        ];

        $valoresSeleccionados = [
            $map[$gema] ?? null,
            $map[$forma] ?? null,
            $map[$material] ?? null,
            $map[$tamano] ?? null,
            $map[$talla] ?? null,
        ];

        if (in_array(null, $valoresSeleccionados, true)) {
            header('Location: ' . BASE_URL . '/personalizar?msg=error_mapeo');
            exit;
        }

        $fecha = date('Y-m-d');
        $usuarioClienteId = $_SESSION['usu_id'] ?? 1;

        $creado = $this->perService->crear($fecha, (int)$usuarioClienteId, $valoresSeleccionados);

        if (!($creado['success'] ?? false)) {
            header('Location: ' . BASE_URL . '/personalizar?msg=error_api');
            exit;
        }

        $perId = $creado['data']['id'] ?? rand(1000,9999);
        header('Location: ' . BASE_URL . '/contacto?per_id=' . urlencode($perId));
        exit;
    }
}

