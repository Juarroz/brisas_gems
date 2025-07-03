<?php
include '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usu_id = $_POST['usu_id'];
    $rol_id = $_POST['rol_id'];

    $query = "UPDATE usuarios SET rol_id = ? WHERE usu_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $rol_id, $usu_id);

    if ($stmt->execute()) {
        header("Location: ../vistas/gestion-usuarios.php?mensaje=Rol+actualizado+correctamente");
        exit();
    } else {
        echo "Error al actualizar el rol: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso no permitido.";
}
?>
