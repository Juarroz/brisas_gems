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

// Verficar el estado actual de un pedido

$ped_id = readline("Ingrese el ID del pedido: ");


$urlPedidos = "http://localhost:8080/pedidos";
$pedidosJson = @file_get_contents($urlPedidos);

if ($pedidosJson === FALSE) {
    die("Error al consumir el servicio de pedidos.\n");
}

$pedidos = json_decode($pedidosJson, true);


$pedido = null;
foreach ($pedidos as $p) {
    if ($p['ped_id'] == $ped_id) {
        $pedido = $p;
        break;
    }
}

if (!$pedido) {
    die("Pedido no encontrado.\n");
}

// Mapear estId a nombre de estado
$estados = [
    1 => "pendiente por validacion",
    2 => "diseño",
    3 => "tallado",
    4 => "engaste",
    5 => "pulido",
    6 => "finalizado"
];

$estado = $estados[$pedido['estId']] ?? "desconocido";


if ($pedido['estId'] == 6) {
    echo "El pedido {$pedido['pedCodigo']} ya puede ser entregado (estado: {$estado}).\n";
} else {
    echo "El pedido {$pedido['pedCodigo']} aún no puede entregarse, está en estado: {$estado}.\n";
}
?>
