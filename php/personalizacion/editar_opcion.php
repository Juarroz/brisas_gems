<?php
// Mostrar errores solo en desarrollo (ajustar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// --- Seguridad: Validar sesión y rol ---
session_start();
if (!isset($_SESSION['usu_id']) || (int)$_SESSION['rol_id'] !== 2) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

require_once '../../php/conexion.php';

// --- (Opcional) Validación de CSRF ---
// if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
//     http_response_code(403);
//     echo json_encode(['error' => 'Token CSRF inválido']);
//     exit();
// }

// --- Validación y sanitización de entrada ---
$opc_id = intval($_POST['opcion_id'] ?? 0);
$nombre = trim($_POST['nombre_opcion'] ?? '');
$descripcion = trim($_POST['descripcion_opcion'] ?? '');
if (!$opc_id || !$nombre || mb_strlen($nombre) > 100) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos o nombre demasiado largo']);
    exit();
}
if (mb_strlen($descripcion) > 255) {
    http_response_code(400);
    echo json_encode(['error' => 'Descripción demasiado larga (máx 255)']);
    exit();
}

// --- Procesar imagen si se envía ---
$imagen_ruta = null;
if (isset($_FILES['imagen_opcion']) && $_FILES['imagen_opcion']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['imagen_opcion']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['error' => 'Error al subir la imagen. Código: ' . $_FILES['imagen_opcion']['error']]);
        exit();
    }
    $permitidos = ['image/png' => 'png', 'image/jpeg' => 'jpg'];
    $tipo = $_FILES['imagen_opcion']['type'];
    $size = $_FILES['imagen_opcion']['size'];
    $maxSize = 2 * 1024 * 1024;
    if (!isset($permitidos[$tipo])) {
        http_response_code(400);
        echo json_encode(['error' => 'Formato no permitido. Solo PNG y JPG.']);
        exit();
    }
    if ($size > $maxSize) {
        http_response_code(400);
        echo json_encode(['error' => 'La imagen supera el tamaño máximo de 2MB.']);
        exit();
    }
    // --- Seguridad: Validar y crear directorio destino ---
    $dir_destino = realpath(__DIR__ . '/../../img/personalizacion/catalogo');
    if (!$dir_destino) {
        $dir_destino = __DIR__ . '/../../img/personalizacion/catalogo';
        if (!is_dir($dir_destino) && !mkdir($dir_destino, 0755, true)) {
            http_response_code(500);
            echo json_encode(['error' => 'No se pudo crear el directorio de imágenes.']);
            exit();
        }
    }
    // --- Seguridad: Nombre de archivo único y sin caracteres peligrosos ---
    $ext = $permitidos[$tipo];
    $nombre_archivo = uniqid('opcion_', true) . '.' . $ext;
    $nombre_archivo = preg_replace('/[^a-zA-Z0-9_\.-]/', '', $nombre_archivo);
    $ruta = $dir_destino . DIRECTORY_SEPARATOR . $nombre_archivo;
    if (!move_uploaded_file($_FILES['imagen_opcion']['tmp_name'], $ruta)) {
        http_response_code(500);
        $php_err = error_get_last();
        $file_error = $_FILES['imagen_opcion']['error'];
        echo json_encode([
            'error' => 'Error al guardar la imagen. PHP: ' . ($php_err['message'] ?? 'Sin mensaje') . ' | Código error: ' . $file_error
        ]);
        exit();
    }
    chmod($ruta, 0644);
    $imagen_ruta = 'img/personalizacion/catalogo/' . $nombre_archivo;
}

// --- Actualizar en base de datos con prepared statements ---
if ($imagen_ruta) {
    $stmt = $conn->prepare("UPDATE opcion_personalizacion SET opc_nombre=?, opc_descripcion=?, opc_imagen=? WHERE opc_id=?");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Error de base de datos: ' . $conn->error]);
        exit();
    }
    $stmt->bind_param('sssi', $nombre, $descripcion, $imagen_ruta, $opc_id);
} else {
    $stmt = $conn->prepare("UPDATE opcion_personalizacion SET opc_nombre=?, opc_descripcion=? WHERE opc_id=?");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Error de base de datos: ' . $conn->error]);
        exit();
    }
    $stmt->bind_param('ssi', $nombre, $descripcion, $opc_id);
}
$res = $stmt->execute();
$stmt->close();
$conn->close();
if ($res) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error al actualizar opción']);
}
