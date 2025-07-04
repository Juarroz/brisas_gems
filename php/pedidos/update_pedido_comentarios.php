<?php
require_once '../conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ped_id = $_POST['ped_id'] ?? null;
    $comentario = trim($_POST['comentario'] ?? '');

    if (!$ped_id || $comentario === '') {
        echo "Error: Datos incompletos.";
        exit;
    }

    $stmt = $conn->prepare("UPDATE pedido SET ped_comentarios = ? WHERE ped_id = ?");
    $stmt->bind_param("si", $comentario, $ped_id);

    if ($stmt->execute()) {
        header("Location: ../../admin/gestion-pedido-detalle.php?ped_id=$ped_id");
        exit;
    } else {
        echo "Error al guardar el comentario.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso no permitido.";
    exit;
}
