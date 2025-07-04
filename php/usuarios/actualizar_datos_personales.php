<?php
// Incluye la conexión a la base de datos (misma lógica que otros módulos)
include __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibe los datos del formulario
    $usu_id = isset($_POST['usu_id']) ? intval($_POST['usu_id']) : null;
    $nombre = isset($_POST['usu_nombre']) ? trim($_POST['usu_nombre']) : '';
    $correo = isset($_POST['usu_correo']) ? trim($_POST['usu_correo']) : '';
    $telefono = isset($_POST['usu_telefono']) ? trim($_POST['usu_telefono']) : '';

    // Validación básica
    if ($usu_id && $nombre && $correo) {
        // Verifica si el correo ya existe para otro usuario
        $verificar = $conn->prepare("SELECT usu_id FROM usuarios WHERE usu_correo = ? AND usu_id != ?");
        $verificar->bind_param("si", $correo, $usu_id);
        $verificar->execute();
        $verificar->store_result();

        if ($verificar->num_rows > 0) {
            // Correo ya en uso
            header("Location: ../../usuario/mi-perfil.php?error=correo");
            exit();
        }
        $verificar->close();

        // Actualiza los datos personales
        $query = "UPDATE usuarios SET usu_nombre = ?, usu_correo = ?, usu_telefono = ? WHERE usu_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $nombre, $correo, $telefono, $usu_id);

        if ($stmt->execute()) {
            // Éxito
            header("Location: ../../usuario/mi-perfil.php?exito=1");
            exit();
        } else {
            // Error en la actualización
            header("Location: ../../usuario/mi-perfil.php?error=bd");
            exit();
        }
        $stmt->close();
    } else {
        // Faltan datos
        header("Location: ../../usuario/mi-perfil.php?error=datos");
        exit();
    }
    $conn->close();
} else {
    echo "Acceso no permitido.";
}
?>
