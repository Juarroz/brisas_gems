<?php

$correo = readline("Ingrese su correo: ");

$urlUsuarios = "http://localhost:8080/usuarios";
$usuariosJson = @file_get_contents($urlUsuarios);

if ($usuariosJson === FALSE) {
    die("Error al consumir el servicio de usuarios.\n");
}

$usuarios = json_decode($usuariosJson, true);

$usuario = null;
foreach ($usuarios as $u) {
    if ($u['usuCorreo'] == $correo) {
        $usuario = $u;
        break;
    }
}

if (!$usuario) {
    die("Usuario no encontrado.\n");
}

if ($usuario['rol']['rolNombre'] != "administrador") {
    die("Acceso denegado. Solo los administradores pueden consultar pedidos.\n");
}

echo "Bienvenido administrador {$usuario['usuNombre']}.\n";


// Mostrar pedidos en un estado específico

$estadoIngresado = strtolower(readline("Ingrese el estado (pendiente, diseño, tallado, engaste, pulido, finalizado): "));


$urlPedidos = "http://localhost:8080/pedidos";
$pedidosJson = @file_get_contents($urlPedidos);

if ($pedidosJson === FALSE) {
    die("Error al consumir el servicio de pedidos.\n");
}

$pedidos = json_decode($pedidosJson, true);

// Mapear estId a nombre de estado
$estados = [
    1 => "pendiente",
    2 => "diseño",
    3 => "tallado",
    4 => "engaste",
    5 => "pulido",
    6 => "finalizado"
];

// Buscar pedidos en el estado ingresado
$encontrados = [];
foreach ($pedidos as $p) {
    $estadoReal = $estados[$p['estId']] ?? "desconocido";
    if ($estadoIngresado == strtolower($estadoReal)) {
        $encontrados[] = $p;
    }
}

if (empty($encontrados)) {
    echo "No hay pedidos en estado {$estadoIngresado}.\n";
} else {
    echo "Pedidos en estado {$estadoIngresado}:\n";
    foreach ($encontrados as $p) {
        echo "- {$p['pedCodigo']} ({$p['pedComentarios']})\n";
    }
}
?>
