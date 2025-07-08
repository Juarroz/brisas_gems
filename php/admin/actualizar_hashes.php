<?php
// Archivo: actualizar_hashes.php

require_once '../conexion.php';

// Paso 1: obtener todos los usuarios y sus contraseñas actuales
$sql = "SELECT usu_id, usu_password FROM usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $actualizados = 0;

    while ($row = $result->fetch_assoc()) {
        $id = $row['usu_id'];
        $contrasenaPlano = $row['usu_password'];

        // Evita volver a hashear si ya está hasheado
        if (password_get_info($contrasenaPlano)['algo'] !== 0) {
            continue; // ya está hasheada, saltar
        }

        // Aplicar password_hash
        $hashSeguro = password_hash($contrasenaPlano, PASSWORD_DEFAULT);

        // Actualizar en la base de datos
        $stmt = $conn->prepare("UPDATE usuarios SET usu_password = ? WHERE usu_id = ?");
        $stmt->bind_param("si", $hashSeguro, $id);
        $stmt->execute();
        $stmt->close();

        $actualizados++;
    }

    echo "✅ Se actualizaron correctamente $actualizados contraseñas.";
} else {
    echo "⚠️ No se encontraron usuarios.";
}

$conn->close();
?>
