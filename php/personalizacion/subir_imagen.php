<?php
// Subir imagen de valor de personalización (solo admin)
session_start();
if (!isset($_SESSION['usu_id']) || $_SESSION['rol_id'] != 2) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit();
}
if (!isset($_FILES['imagen'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No se envió archivo']);
    exit();
}
$permitidos = ['image/png', 'image/jpeg'];
$maxSize = 2 * 1024 * 1024;
$tipo = $_FILES['imagen']['type'];
$size = $_FILES['imagen']['size'];
if (!in_array($tipo, $permitidos)) {
    echo json_encode(['error' => 'Formato no permitido. Solo PNG y JPG.']);
    exit();
}
if ($size > $maxSize) {
    echo json_encode(['error' => 'La imagen supera el tamaño máximo de 2MB.']);
    exit();
}
$ext = $tipo === 'image/png' ? 'png' : 'jpg';
$nombre = uniqid('valor_') . '.' . $ext;
$ruta = '../../img/personalizacion/catalogo/' . $nombre;
if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
    echo json_encode(['error' => 'Error al guardar la imagen.']);
    exit();
}
echo json_encode(['success' => true, 'ruta' => 'img/personalizacion/catalogo/' . $nombre]);
