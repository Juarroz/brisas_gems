<?php

require_once __DIR__ . '/EstadoActualPedido.php';

class EstadoPedidoService {
    private $estadoService;

    public function __construct() {
        $this->estadoService = new EstadoActualPedido();
    }

    public function obtenerEstadosParaSelect() {
        $estados = $this->estadoService->listarEstados();
        
        if (isset($estados['error'])) {
            error_log("ERROR obtenerEstadosParaSelect: " . $estados['error']);
            return "<option value=''>Error al cargar estados</option>";
        }
        
        $options = '<option value="">Seleccionar estado</option>';
        
        foreach ($estados as $estado) {
            $id = $estado['est_id'] ?? '';
            $nombre = $estado['estNombre'] ?? '';
            $descripcion = $estado['estDescripcion'] ?? '';
            $title = $descripcion ? " title='$descripcion'" : "";
            
            $options .= "<option value='$id'$title>$nombre</option>";
        }
        
        return $options;
    }

    public function obtenerNombreEstado($estadoId) {
        if (empty($estadoId)) {
            return 'No asignado';
        }
        
        $estado = $this->estadoService->obtenerEstadoPorId($estadoId);
        
        if (isset($estado['error'])) {
            error_log("ERROR obtenerNombreEstado: " . $estado['error']);
            return 'Error';
        }
        
        return $estado['estNombre'] ?? 'Desconocido';
    }

    public function listarTodosLosEstados() {
        $estados = $this->estadoService->listarEstados();
        
        if (isset($estados['error'])) {
            error_log("ERROR listarTodosLosEstados: " . $estados['error']);
            return [];
        }
        
        return $estados;
    }

    public function obtenerEstado($id) {
        return $this->estadoService->obtenerEstadoPorId($id);
    }

    public function crearEstado($nombre, $descripcion = '') {
        $datos = [
            'estNombre' => $nombre,
            'estDescripcion' => $descripcion
        ];
        
        return $this->estadoService->crearEstado($datos);
    }

    public function actualizarEstado($id, $nombre, $descripcion = '') {
        $datos = [
            'estNombre' => $nombre,
            'estDescripcion' => $descripcion
        ];
        return $this->estadoService->actualizarEstado($id, $datos);
    }

    public function eliminarEstado($id) {
        return $this->estadoService->eliminarEstado($id);
    }
}