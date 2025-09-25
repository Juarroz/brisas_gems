<?php
// Archivo: actualizar_hashes.php

require_once '../conexion.php'; // Asegúrate que esta ruta sea válida
echo "🧪 Script iniciado<br>";

// Paso 1: obtener todos los usuarios y sus contraseñas actuales
$sql = "SELECT usu_id, usu_password FROM usuarios";
$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("❌ Error en la consulta: " . $conn->error);
}

echo "🔎 Usuarios encontrados: " . $result->num_rows . "<br>";

if ($result->num_rows > 0) {
    $actualizados = 0;

    while ($row = $result->fetch_assoc()) {
        $id = $row['usu_id'];
        $contrasenaPlano = $row['usu_password'];

        echo "🧪 Usuario ID $id → contraseña actual: $contrasenaPlano<br>";

        // ⚠️ Forzar rehash de todas las contraseñas (dato de prueba controlado)
        $hashSeguro = password_hash($contrasenaPlano, PASSWORD_DEFAULT);
        if (!$hashSeguro) {
            echo "❌ Error al hashear contraseña para usuario ID $id<br>";
            continue;
        }

        // Preparar y ejecutar la actualización
        $stmt = $conn->prepare("UPDATE usuarios SET usu_password = ? WHERE usu_id = ?");
        if (!$stmt) {
            echo "❌ Error al preparar la consulta para usuario ID $id: " . $conn->error . "<br>";
            continue;
        }

        $stmt->bind_param("si", $hashSeguro, $id);
        if ($stmt->execute()) {
            echo "✅ Contraseña actualizada para usuario ID $id<br>";
            $actualizados++;
        } else {
            echo "❌ Error al ejecutar UPDATE para usuario ID $id: " . $stmt->error . "<br>";
        }

        $stmt->close();
    }

    echo "<br>🔒 Total de contraseñas actualizadas: $actualizados<br>";
} else {
    echo "⚠️ No se encontraron usuarios.<br>";
}

$conn->close();
?>