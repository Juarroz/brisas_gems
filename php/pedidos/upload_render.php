<?php
require_once '../conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ped_id = $_POST['ped_id'] ?? null;

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
    $rutaCarpeta = "../../uploads/renders/";
    if (!file_exists($rutaCarpeta)) {
        mkdir($rutaCarpeta, 0777, true);
    }

    $nombreFinal = "render_pedido_" . $ped_id . "_" . time() . "." . $ext;
    $rutaFinal = $rutaCarpeta . $nombreFinal;

    if (move_uploaded_file($archivo['tmp_name'], $rutaFinal)) {
        // Guardar en la base de datos (ruta relativa)
        $rutaDB = "uploads/renders/" . $nombreFinal;

        $stmt = $conn->prepare("UPDATE pedido SET render_url = ? WHERE ped_id = ?");
        $stmt->bind_param("si", $rutaDB, $ped_id);
        $stmt->execute();
        $stmt->close();

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