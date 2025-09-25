<?php
// Eliminar inspiración por ID (solo admin autenticado)
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
    $stmt = $conn->prepare("DELETE FROM portafolio_inspiracion WHERE por_id = ?");
    $stmt->bind_param('i', $por_id);
    $ok = $stmt->execute();
    $stmt->close();
    $conn->close();
    echo json_encode(['success' => $ok]);
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Petición inválida']);
}
