<?php

$usu_id = readline("Ingrese el ID del usuario: ");
$deseaPersonalizacion = readline("¿Desea personalización? (1 = Sí, 0 = No): ");

// --- Consumir API Usuario ---
$urlUsuario = "http://localhost:8080/usuarios/" . $usu_id;
$usuarioJson = @file_get_contents($urlUsuario);

if ($usuarioJson === FALSE) {
    die("Error al consumir el servicio de usuarios.\n");
}

$usuario = json_decode($usuarioJson, true);

// Validar si usuario existe
if (!$usuario) {
    die("Usuario no encontrado.\n");
}

// Verificar si está activo
if (!$usuario['usuActivo']) {
    die("El usuario {$usuario['usuNombre']} no puede realizar pedidos porque está inactivo.\n");
}

// --- Si desea personalización, consultar API ---
if ($deseaPersonalizacion == 1) {
    $urlPers = "http://localhost:8080/personalizacion?usu_id=" . $usu_id;
    $personalizacionesJson = @file_get_contents($urlPers);

    if ($personalizacionesJson === FALSE) {
        die("Error al consumir el servicio de personalizaciones.\n");
    }

    $personalizaciones = json_decode($personalizacionesJson, true);

    if (empty($personalizaciones)) {
        echo "Debe configurar una personalización antes de continuar.\n";
    } else {
        echo "Pedido con personalización válido para el usuario {$usuario['usuNombre']}.\n";
    }
} else {
    echo "Pedido estándar válido para el usuario {$usuario['usuNombre']}.\n";
}
?>