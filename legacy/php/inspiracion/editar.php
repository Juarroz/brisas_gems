<?php
// Editar inspiración (solo admin autenticado)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usu_id']) || $_SESSION['rol_id'] != 2) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit();
}
require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['por_id'])) {
    $por_id = intval($_POST['por_id']);
    $titulo = trim($_POST['por_titulo'] ?? '');
    $descripcion = trim($_POST['por_descripcion'] ?? '');
    $video = trim($_POST['por_video'] ?? null);
    $categoria = trim($_POST['por_categoria'] ?? '');

    // Manejo de imagen subida
    $imagen = $_POST['por_imagen_actual'] ?? '';
    if (isset($_FILES['por_imagen']) && $_FILES['por_imagen']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['por_imagen']['name'], PATHINFO_EXTENSION);
        $nombre_archivo = uniqid('inspiracion_') . '.' . $ext;
        $ruta_destino = '../../img/Portafolio/' . $nombre_archivo;
        if (move_uploaded_file($_FILES['por_imagen']['tmp_name'], $ruta_destino)) {
            $imagen = 'img/Portafolio/' . $nombre_archivo;
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al subir la imagen']);
            exit();
        }
    }

    if ($titulo && $imagen && $categoria) {
        $stmt = $conn->prepare("UPDATE portafolio_inspiracion SET por_titulo=?, por_descripcion=?, por_imagen=?, por_video=?, por_categoria=? WHERE por_id=?");
        $stmt->bind_param('sssssi', $titulo, $descripcion, $imagen, $video, $categoria, $por_id);
        $ok = $stmt->execute();
        $stmt->close();
        $conn->close();
        echo json_encode(['success' => $ok]);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Faltan campos obligatorios']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Petición inválida']);
}
