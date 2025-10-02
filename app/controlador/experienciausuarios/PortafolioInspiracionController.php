<?php
require_once __DIR__ . '/../../modelo/experienciausuarios/PortafolioInspiracionService.php';

class PortafolioInspiracionController {
    private $service;

    public function __construct() {
        $this->service = new PortafolioInspiracionService();
    }

    // --- CRUD para administrador ---
    public function index() {
        $mensaje = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';

            if ($accion === 'crear') {
                $datos = [
                    "porTitulo" => $_POST['porTitulo'] ?? '',
                    "porDescripcion" => $_POST['porDescripcion'] ?? '',
                    "porImagen" => $_POST['porImagen'] ?? '',
                    "porVideo" => $_POST['porVideo'] ?? '',
                    "porCategoria" => $_POST['porCategoria'] ?? '',
                    "porFecha" => $_POST['porFecha'] ?? '',
                    "usuId" => $_POST['usuId'] ?? null,
                ];
                $resultado = $this->service->crear($datos);
                $mensaje = $resultado['success'] ? "Portafolio creado correctamente." : "Error al crear.";
            }

            if ($accion === 'actualizar') {
                $id = $_POST['id'] ?? null;
                $datos = [
                    "porTitulo" => $_POST['porTitulo'] ?? '',
                    "porDescripcion" => $_POST['porDescripcion'] ?? '',
                    "porImagen" => $_POST['porImagen'] ?? '',
                    "porVideo" => $_POST['porVideo'] ?? '',
                    "porCategoria" => $_POST['porCategoria'] ?? '',
                    "porFecha" => $_POST['porFecha'] ?? '',
                    "usuId" => $_POST['usuId'] ?? null,
                ];
                $resultado = $this->service->actualizar($id, $datos);
                $mensaje = $resultado['success'] ? "Portafolio actualizado." : "Error al actualizar.";
            }

            if ($accion === 'eliminar') {
                $id = $_POST['id'] ?? null;
                $resultado = $this->service->eliminar($id);
                $mensaje = $resultado['success'] ? "Portafolio eliminado." : "Error al eliminar.";
            }
        }

        $inspiraciones = $this->service->listar();
        require __DIR__ . '/../../vista/experienciausuarios/portafolio_inspiracion_index.php';
    }

    
    public function publico() {
        $inspiraciones = $this->service->listar();
        require __DIR__ . '/../../vista/experienciausuarios/portafolio_inspiracion_publico.php';
    }
}
