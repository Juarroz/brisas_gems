<?php

require_once __DIR__ . '/../../core/ApiClient.php';

class PedidoService {
    private $apiUrl = "http://localhost:8080/api/pedidos";

    public function listarPedidos() {
        // ✅ OBTENER TOKEN JWT DE LA SESIÓN PARA AUTENTICACIÓN
        session_start();
        $token = $_SESSION['jwt_token'] ?? null;
        
        $contextOptions = [
            'http' => [
                'timeout' => 10,
                'ignore_errors' => true,
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36\r\n"
            ]
        ];
        
        // ✅ AGREGAR TOKEN SI EXISTE
        if ($token) {
            $contextOptions['http']['header'] .= "Authorization: Bearer $token\r\n";
        }
        
        $context = stream_context_create($contextOptions);
        $respuesta = @file_get_contents($this->apiUrl, false, $context);
        
        if ($respuesta === false) {
            $error = error_get_last();
            error_log("ERROR PedidoService - Conexión fallida: " . ($error['message'] ?? 'Desconocido'));
            return ["error" => "No se pudo conectar al servidor backend. Verifique que esté ejecutándose."];
        }
        
        // Verificar el código de respuesta HTTP
        $httpCode = $this->getHttpCode($http_response_header);
        
        if ($httpCode != 200) {
            error_log("ERROR PedidoService: HTTP $httpCode - URL: " . $this->apiUrl);
            
            $mensajesError = [
                401 => "No autenticado. Inicie sesión.",
                403 => "Acceso denegado. No tiene permisos de administrador.",
                404 => "Endpoint no encontrado.",
                500 => "Error interno del servidor backend.", 
                503 => "Servicio no disponible."
            ];
            
            $mensajeError = $mensajesError[$httpCode] ?? "Error HTTP $httpCode";
            
            // ✅ INTENTAR OBTENER MENSAJE DE ERROR DEL BACKEND
            $respuestaData = json_decode($respuesta, true);
            if (isset($respuestaData['message'])) {
                $mensajeError .= " - " . $respuestaData['message'];
            }
            
            return ["error" => $mensajeError];
        }
        
        $data = json_decode($respuesta, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("ERROR PedidoService: JSON inválido - " . json_last_error_msg());
            return ["error" => "Respuesta inválida del servidor: " . json_last_error_msg()];
        }

        // ✅ CORRECCIÓN CRÍTICA MEJORADA: Normalizar campos inconsistentes
        if (is_array($data)) {
            foreach ($data as &$pedido) {
                // ✅ CORREGIR TODOS LOS POSIBLES NOMBRES DE CAMPOS INCORRECTOS
                $correccionesCampos = [
                    'usufd' => 'usuId',
                    'usu_id_empleado' => 'usuId', 
                    'usuIdEmpleado' => 'usuId',
                    'est_id' => 'estId',
                    'per_id' => 'perId',
                    'ped_id' => 'ped_id' // mantener igual
                ];
                
                foreach ($correccionesCampos as $campoIncorrecto => $campoCorrecto) {
                    if (isset($pedido[$campoIncorrecto]) && !isset($pedido[$campoCorrecto])) {
                        $pedido[$campoCorrecto] = $pedido[$campoIncorrecto];
                        unset($pedido[$campoIncorrecto]);
                    }
                }
                
                // ✅ ASEGURAR QUE TODOS LOS CAMPOS ESPERADOS EXISTAN
                $camposEsperados = [
                    'ped_id', 'pedCodigo', 'pedFechaCreacion', 'pedComentarios', 
                    'estId', 'perId', 'usuId'
                ];
                
                foreach ($camposEsperados as $campo) {
                    if (!isset($pedido[$campo])) {
                        $pedido[$campo] = null;
                    }
                }
                
                // ✅ FORMATEAR FECHA PARA MEJOR LEGIBILIDAD
                if (!empty($pedido['pedFechaCreacion'])) {
                    $pedido['fechaFormateada'] = $this->formatearFecha($pedido['pedFechaCreacion']);
                }
            }
        }
        
        return $data;
    }

    // Método auxiliar para obtener código HTTP
    private function getHttpCode($headers) {
        if (!is_array($headers) || empty($headers[0])) {
            return 0;
        }
        
        preg_match('/HTTP\/[0-9\.]+\s+([0-9]+)/', $headers[0], $matches);
        return $matches[1] ?? 0;
    }
    
    // ✅ NUEVO MÉTODO: Formatear fecha para mejor visualización
    private function formatearFecha($fechaISO) {
        try {
            $fecha = new DateTime($fechaISO);
            return $fecha->format('d/m/Y H:i');
        } catch (Exception $e) {
            return $fechaISO;
        }
    }

    public function obtenerPedido($id) {
        if (empty($id)) {
            return ["error" => "ID de pedido requerido"];
        }
        
        // ✅ OBTENER TOKEN JWT
        session_start();
        $token = $_SESSION['jwt_token'] ?? null;
        
        $contextOptions = [
            'http' => [
                'timeout' => 10,
                'ignore_errors' => true
            ]
        ];
        
        if ($token) {
            $contextOptions['http']['header'] = "Authorization: Bearer $token\r\n";
        }
        
        $context = stream_context_create($contextOptions);
        $respuesta = @file_get_contents($this->apiUrl . "/" . urlencode($id), false, $context);
        
        if ($respuesta === false) {
            error_log("ERROR PedidoService: No se pudo obtener pedido $id");
            return ["error" => "No se pudo obtener el pedido. Verifique la conexión."];
        }
        
        $httpCode = $this->getHttpCode($http_response_header);
        
        if ($httpCode != 200) {
            $mensajeError = $httpCode == 404 ? "Pedido no encontrado" : "Error HTTP $httpCode";
            return ["error" => $mensajeError];
        }
        
        $data = json_decode($respuesta, true);
        
        // ✅ APLICAR CORRECCIONES A PEDIDO INDIVIDUAL
        if (isset($data['usufd']) && !isset($data['usuId'])) {
            $data['usuId'] = $data['usufd'];
            unset($data['usufd']);
        }
        
        // ✅ FORMATEAR FECHA
        if (!empty($data['pedFechaCreacion'])) {
            $data['fechaFormateada'] = $this->formatearFecha($data['pedFechaCreacion']);
        }
        
        return $data;
    }

    public function crearPedido(array $datos) {
        // ✅ VALIDACIÓN MEJORADA DE DATOS
        if (empty($datos['pedCodigo']) || empty($datos['pedComentarios'])) {
            return ["success" => false, "error" => "Código y comentarios son obligatorios"];
        }

        // ✅ OBTENER TOKEN JWT
        session_start();
        $token = $_SESSION['jwt_token'] ?? null;
        
        $data_json = json_encode($datos);
        
        $headers = [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_json)
        ];
        
        // ✅ AGREGAR TOKEN SI EXISTE
        if ($token) {
            $headers[] = "Authorization: Bearer $token";
        }

        $ch = curl_init($this->apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data_json,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $respuesta = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            error_log("ERROR PedidoService crear: " . $curlError);
            return ["success" => false, "error" => "Error de conexión: " . $curlError];
        }

        if ($http_code === 200 || $http_code === 201) {
            $data = json_decode($respuesta, true);
            
            // ✅ APLICAR CORRECCIÓN AL PEDIDO CREADO
            if (isset($data['usufd']) && !isset($data['usuId'])) {
                $data['usuId'] = $data['usufd'];
                unset($data['usufd']);
            }
            
            // ✅ FORMATEAR FECHA
            if (!empty($data['pedFechaCreacion'])) {
                $data['fechaFormateada'] = $this->formatearFecha($data['pedFechaCreacion']);
            }
            
            return ["success" => true, "data" => $data];
        }
        
        // ✅ MANEJO MEJORADO DE ERRORES HTTP
        $mensajeError = "Error HTTP $http_code";
        $respuestaData = json_decode($respuesta, true);
        if (isset($respuestaData['message'])) {
            $mensajeError .= " - " . $respuestaData['message'];
        }
        
        error_log("ERROR PedidoService crear: $mensajeError - Respuesta: " . $respuesta);
        return ["success" => false, "error" => $mensajeError, "http_code" => $http_code];
    }

    public function actualizarPedido($id, array $datos) {
        if (empty($id)) {
            return ["success" => false, "error" => "ID de pedido requerido"];
        }

        // ✅ OBTENER TOKEN JWT
        session_start();
        $token = $_SESSION['jwt_token'] ?? null;
        
        $data_json = json_encode($datos);
        
        $headers = [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_json)
        ];
        
        if ($token) {
            $headers[] = "Authorization: Bearer $token";
        }

        $ch = curl_init($this->apiUrl . "/" . urlencode($id));
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => $data_json,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $respuesta = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            error_log("ERROR PedidoService actualizar: " . $curlError);
            return ["success" => false, "error" => "Error de conexión: " . $curlError];
        }

        if ($http_code >= 200 && $http_code < 300) {
            $data = json_decode($respuesta, true);
            
            // ✅ APLICAR CORRECCIÓN AL PEDIDO ACTUALIZADO
            if (isset($data['usufd']) && !isset($data['usuId'])) {
                $data['usuId'] = $data['usufd'];
                unset($data['usufd']);
            }
            
            // ✅ FORMATEAR FECHA
            if (!empty($data['pedFechaCreacion'])) {
                $data['fechaFormateada'] = $this->formatearFecha($data['pedFechaCreacion']);
            }
            
            return ["success" => true, "data" => $data];
        }
        
        $mensajeError = "Error HTTP $http_code";
        $respuestaData = json_decode($respuesta, true);
        if (isset($respuestaData['message'])) {
            $mensajeError .= " - " . $respuestaData['message'];
        }
        
        error_log("ERROR PedidoService actualizar: $mensajeError");
        return ["success" => false, "error" => $mensajeError, "http_code" => $http_code];
    }

    public function eliminarPedido($id) {
        if (empty($id)) {
            return ["success" => false, "error" => "ID de pedido requerido"];
        }

        // ✅ OBTENER TOKEN JWT
        session_start();
        $token = $_SESSION['jwt_token'] ?? null;
        
        $headers = [];
        if ($token) {
            $headers[] = "Authorization: Bearer $token";
        }

        $ch = curl_init($this->apiUrl . "/" . urlencode($id));
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $respuesta = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            error_log("ERROR PedidoService eliminar: " . $curlError);
            return ["success" => false, "error" => "Error de conexión: " . $curlError];
        }
        
        if ($http_code >= 200 && $http_code < 300) {
            return ["success" => true, "message" => "Pedido eliminado correctamente"];
        }
        
        $mensajeError = "Error HTTP $http_code";
        $respuestaData = json_decode($respuesta, true);
        if (isset($respuestaData['message'])) {
            $mensajeError .= " - " . $respuestaData['message'];
        }
        
        error_log("ERROR PedidoService eliminar: $mensajeError");
        return ["success" => false, "error" => $mensajeError, "http_code" => $http_code];
    }
    
    // ✅ NUEVO MÉTODO: Verificar estado del servidor
    public function verificarEstadoServidor() {
        $context = stream_context_create([
            'http' => [
                'timeout' => 5,
                'ignore_errors' => true
            ]
        ]);
        
        $respuesta = @file_get_contents($this->apiUrl, false, $context);
        
        if ($respuesta === false) {
            return ["estado" => "desconectado", "mensaje" => "No se puede conectar al servidor backend"];
        }
        
        $httpCode = $this->getHttpCode($http_response_header);
        
        if ($httpCode == 200) {
            return ["estado" => "conectado", "mensaje" => "Servidor backend funcionando correctamente"];
        } else {
            return ["estado" => "error", "mensaje" => "Servidor responde con error HTTP $httpCode"];
        }
    }
}