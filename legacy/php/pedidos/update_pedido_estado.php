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
    $nuevo_estado = intval($_POST['est_id'] ?? 0);

    if (!$ped_id || !$nuevo_estado) {
        echo "Error: Datos incompletos.";
        exit;
    }

    $stmt = $conn->prepare("UPDATE pedido SET est_id = ? WHERE ped_id = ?");
    if (!$stmt) {
        echo "Error de base de datos: $conn->error";
        exit;
    }

    $stmt->bind_param("ii", $nuevo_estado, $ped_id);
    $res = $stmt->execute();
    $stmt->close();
    $conn->close();

    if ($res) {
        header("Location: ../../admin/gestion-pedido-detalle.php?ped_id=$ped_id");
        exit;
    } else {
        echo "Error al actualizar el estado del pedido.";
    }
} else {
    echo "Acceso denegado.";
    exit;
}
