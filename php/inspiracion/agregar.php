<?php
// Agregar inspiración (solo admin autenticado)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usu_id']) || $_SESSION['rol_id'] != 2) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit();
}
require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['por_titulo'] ?? '');
    $descripcion = trim($_POST['por_descripcion'] ?? '');
    $video = trim($_POST['por_video'] ?? null);
    $categoria = trim($_POST['por_categoria'] ?? '');
    $usu_id = $_SESSION['usu_id'];

    // Manejo de imagen subida
    $imagen = '';
    if (isset($_FILES['por_imagen']) && $_FILES['por_imagen']['error'] === UPLOAD_ERR_OK) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['por_imagen']['tmp_name']);
        finfo_close($finfo);
        $ext = strtolower(pathinfo($_FILES['por_imagen']['name'], PATHINFO_EXTENSION));
        $permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB
        if (!in_array($ext, $permitidos) || strpos($mime, 'image/') !== 0) {
            echo json_encode(['success' => false, 'error' => 'Solo se permiten imágenes JPG, PNG, GIF o WEBP.']);
            exit();
        }
        if ($_FILES['por_imagen']['size'] > $maxSize) {
            echo json_encode(['success' => false, 'error' => 'La imagen supera el tamaño máximo permitido (2MB).']);
            exit();
        }
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
        $stmt = $conn->prepare("INSERT INTO portafolio_inspiracion (por_titulo, por_descripcion, por_imagen, por_video, por_categoria, usu_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssssi', $titulo, $descripcion, $imagen, $video, $categoria, $usu_id);
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
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
