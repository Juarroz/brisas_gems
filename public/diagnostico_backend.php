<?php
// brisas_gems/public/diagnostico_backend.php
echo "<!DOCTYPE html>
<html>
<head>
    <title>Diagnóstico Backend</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        pre { background: #f5f5f5; padding: 10px; border-left: 4px solid #007bff; }
    </style>
</head>
<body>
    <h1>🔍 Diagnóstico de Conexión Backend</h1>";

// URLs a probar
$urls = [
    'Pedidos' => 'http://localhost:8080/api/pedidos',
    'Estados Pedido' => 'http://localhost:8080/api/estados-pedido',
    'Health Check' => 'http://localhost:8080/actuator/health',
    'Autenticación' => 'http://localhost:8080/api/auth/login'
];

foreach ($urls as $nombre => $url) {
    echo "<h3>🧪 Probando: $nombre</h3>";
    echo "URL: <a href='$url' target='_blank'>$url</a><br>";
    
    // Configurar contexto con timeout
    $context = stream_context_create([
        'http' => [
            'timeout' => 10,
            'ignore_errors' => true,
            'method' => 'GET'
        ]
    ]);
    
    // Intentar conexión
    $contenido = @file_get_contents($url, false, $context);
    
    // Obtener información de la respuesta
    $httpCode = 0;
    if (isset($http_response_header[0])) {
        preg_match('/HTTP\/[0-9\.]+\s+([0-9]+)/', $http_response_header[0], $matches);
        $httpCode = $matches[1] ?? 0;
    }
    
    if ($contenido === false) {
        $error = error_get_last();
        echo "<span class='error'>❌ ERROR DE CONEXIÓN:</span> " . ($error['message'] ?? 'Desconocido') . "<br>";
        echo "<span class='warning'>💡 Posible solución: Verifica que el backend Spring Boot esté ejecutándose en el puerto 8080</span><br>";
    } else {
        // Analizar código HTTP
        if ($httpCode == 200) {
            echo "<span class='success'>✅ CONEXIÓN EXITOSA (HTTP $httpCode)</span><br>";
        } elseif ($httpCode == 403) {
            echo "<span class='error'>❌ ACCESO PROHIBIDO (HTTP $httpCode)</span><br>";
            echo "<span class='warning'>💡 Problema de CORS o autenticación. Actualiza SecurityConfig.java</span><br>";
        } elseif ($httpCode == 404) {
            echo "<span class='warning'>⚠️ ENDPOINT NO ENCONTRADO (HTTP $httpCode)</span><br>";
        } else {
            echo "<span class='warning'>⚠️ RESPUESTA INESPERADA (HTTP $httpCode)</span><br>";
        }
        
        // Mostrar respuesta (limitada)
        echo "<strong>Respuesta:</strong><br>";
        echo "<pre>" . htmlspecialchars(substr($contenido, 0, 1000)) . "</pre>";
    }
    echo "<hr>";
}

// Probar con cURL como alternativa
echo "<h3>🔧 Probando con cURL (alternativa)</h3>";
$ch = curl_init('http://localhost:8080/api/pedidos');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_USERAGENT => 'Diagnostico-Backend/1.0'
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

echo "cURL HTTP Code: <strong>$httpCode</strong><br>";
echo "cURL Error: " . ($curlError ?: '<span class="success">Ninguno</span>') . "<br>";
if ($response) {
    echo "cURL Response: <pre>" . htmlspecialchars(substr($response, 0, 500)) . "</pre>";
}

echo "<h3>🎯 Resumen del Problema</h3>";
echo "<p>El error <strong>HTTP 403</strong> indica que el backend Spring Boot está:</p>";
echo "<ul>
        <li>✅ Ejecutándose correctamente</li>
        <li>❌ Rechazando la conexión por seguridad</li>
        <li>💡 <strong>Solución:</strong> Configurar CORS y permisos en SecurityConfig.java</li>
    </ul>";

echo "<h3>🚀 Próximos Pasos</h3>";
echo "<ol>
        <li>Actualizar SecurityConfig.java con la configuración CORS</li>
        <li>Reiniciar el backend Spring Boot</li>
        <li>Probar nuevamente la aplicación</li>
    </ol>";

echo "</body></html>";