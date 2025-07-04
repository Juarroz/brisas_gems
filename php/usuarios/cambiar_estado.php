<?php
include __DIR__ . '/../conexion.php';

if (isset($_GET['id']) && isset($_GET['estado'])) {
    $usu_id = $_GET['id'];
    $nuevo_estado = $_GET['estado'] == 1 ? 0 : 1; // Si está activo (1), lo pasamos a inactivo (0) y viceversa

    $query = "UPDATE usuarios SET usu_activo = ? WHERE usu_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $nuevo_estado, $usu_id);

    if ($stmt->execute()) {
        header("Location: ../../admin/gestion-usuarios.php?mensaje=Estado+cambiado+correctamente");
        exit();
    } else {
        echo "Error al cambiar el estado: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Parámetros incompletos.";
}
?>
