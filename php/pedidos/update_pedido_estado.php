<?php
require_once '../conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ped_id = $_POST['ped_id'] ?? null;
    $nuevo_estado = $_POST['est_id'] ?? null;

    if (!$ped_id || !$nuevo_estado) {
        echo "Error: Datos incompletos.";
        exit;
    }

    $stmt = $conn->prepare("UPDATE pedido SET est_id = ? WHERE ped_id = ?");
    $stmt->bind_param("ii", $nuevo_estado, $ped_id);

    if ($stmt->execute()) {
        header("Location: ../../admin/gestion-pedido-detalle.php?ped_id=$ped_id");
        exit;
    } else {
        echo "Error al actualizar el estado del pedido.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso denegado.";
    exit;
}
