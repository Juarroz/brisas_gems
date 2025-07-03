<?php
include '../conexion.php'; // Asegúrate que este archivo conecta a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibimos los datos del formulario
    $nombre = $_POST['usu_nombre'];
    $email = $_POST['usu_email'];
    $telefono = $_POST['usu_telefono'];
    $tipdoc_id = $_POST['tipdoc_id'];
    $docnum = $_POST['usu_docnum'];
    $password = password_hash($_POST['usu_password'], PASSWORD_DEFAULT); // Encriptamos la contraseña 💪
    $rol_id = $_POST['rol_id'];
    $activo = $_POST['usu_activo'];

    // Preparamos la consulta
    $query = "INSERT INTO usuarios (usu_nombre, usu_email, usu_telefono, tipdoc_id, usu_docnum, usu_password, rol_id, usu_activo)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssii", $nombre, $email, $telefono, $tipdoc_id, $docnum, $password, $rol_id, $activo);

    if ($stmt->execute()) {
        header("Location: ../vistas/gestion-usuarios.php?mensaje=Usuario+agregado+correctamente");
        exit();
    } else {
        echo "Error al agregar el usuario: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso no permitido.";
}
?>
