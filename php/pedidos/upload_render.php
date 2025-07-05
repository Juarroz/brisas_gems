<?php
require_once '../conexion.php';
session_start();

// --- Seguridad: Validar sesión y rol (solo admin o diseñador) ---
if (!isset($_SESSION['rol_id']) || !in_array((int)$_SESSION['rol_id'], [2, 3])) {
    http_response_code(401);
    echo "No autorizado.";
    exit;
}

// --- (Opcional) Validación de CSRF ---
// if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
//     http_response_code(403);
//     echo "Token CSRF inválido.";
//     exit;
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ped_id = intval($_POST['ped_id'] ?? 0);

    if (!$ped_id || !isset($_FILES['render_file'])) {
        echo "Error: Falta el ID del pedido o archivo.";
        exit;
    }

    $archivo = $_FILES['render_file'];
    $permitidos = ['obj', 'stl'];
    $ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $permitidos)) {
        echo "Error: Formato no permitido.";
        exit;
    }

    // Crear carpeta si no existe
    $rutaCarpeta = realpath(__DIR__ . '/../../uploads/renders');
    if (!$rutaCarpeta) {
        $rutaCarpeta = __DIR__ . '/../../uploads/renders/';
        if (!is_dir($rutaCarpeta) && !mkdir($rutaCarpeta, 0755, true)) {
            echo "Error al crear carpeta de destino.";
            exit;
        }
    }

    $nombreFinal = 'render_pedido_' . $ped_id . '_' . time() . '.' . $ext;
    $nombreFinal = preg_replace('/[^a-zA-Z0-9_\.-]/', '', $nombreFinal);
    $rutaFinal = $rutaCarpeta . DIRECTORY_SEPARATOR . $nombreFinal;

    if (move_uploaded_file($archivo['tmp_name'], $rutaFinal)) {
        chmod($rutaFinal, 0644);

        // Guardar en la base de datos (ruta relativa)
        $rutaDB = 'uploads/renders/' . $nombreFinal;
        $stmt = $conn->prepare("UPDATE pedido SET render_url = ? WHERE ped_id = ?");
        if (!$stmt) {
            echo "Error de base de datos: $conn->error";
            exit;
        }
        $stmt->bind_param("si", $rutaDB, $ped_id);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        header("Location: ../../admin/gestion-pedido-detalle.php?ped_id=$ped_id");
        exit;
    } else {
        echo "Error al subir el archivo.";
        exit;
    }
} else {
    echo "Acceso no permitido.";
    exit;
}