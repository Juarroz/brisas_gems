<?php
include '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibimos los datos del formulario
    $nombre = $_POST['usu_nombre'];
    $correo = $_POST['usu_correo']; // Este campo ahora está bien escrito
    $telefono = $_POST['usu_telefono'];
    $tipdoc_id = $_POST['tipdoc_id'];
    $docnum = $_POST['usu_docnum'];
    $password = password_hash($_POST['usu_password'], PASSWORD_DEFAULT);
    $rol_id = $_POST['rol_id'];
    $activo = $_POST['usu_activo'];

    // Validar si el correo ya existe (opcional pero recomendado)
    $verificar = $conn->prepare("SELECT usu_id FROM usuarios WHERE usu_correo = ?");
    $verificar->bind_param("s", $correo);
    $verificar->execute();
    $verificar->store_result();

    if ($verificar->num_rows > 0) {
        echo "Ya existe un usuario con ese correo.";
    } else {
        // Preparamos la consulta
        $query = "INSERT INTO usuarios (usu_nombre, usu_correo, usu_telefono, tipdoc_id, usu_docnum, usu_password, rol_id, usu_activo)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssii", $nombre, $correo, $telefono, $tipdoc_id, $docnum, $password, $rol_id, $activo);
    
        if ($stmt->execute()) {
            header("Location: ../../admin/gestion-usuarios.php?mensaje=Usuario+agregado+correctamente");
            exit();
        } else {
            echo "Error al agregar el usuario: " . $conn->error;
        }
    
        $stmt->close();
    }

    $verificar->close();
    $conn->close();
} else {
    echo "Acceso no permitido.";
}