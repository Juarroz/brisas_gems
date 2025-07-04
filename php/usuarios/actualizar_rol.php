<?php
include __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usu_id = isset($_POST['usu_id']) ? intval($_POST['usu_id']) : null;
    $rol_id = isset($_POST['rol_id']) ? intval($_POST['rol_id']) : null;

    if ($usu_id && $rol_id) {
        $query = "UPDATE usuarios SET rol_id = ? WHERE usu_id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ii", $rol_id, $usu_id);
            if ($stmt->execute()) {
                header("Location: ../../admin/gestion-usuarios.php?mensaje=Rol+actualizado+correctamente");
                exit();
            } else {
                echo "❌ Error al ejecutar la actualización: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "❌ Error al preparar la consulta: " . $conn->error;
        }
    } else {
        echo "❗️ Faltan datos necesarios.";
    }

    $conn->close();
} else {
    echo "Acceso no permitido.";
}