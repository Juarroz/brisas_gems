<?php
// Listar inspiraciones del portafolio
require_once '../conexion.php';

$sql = "SELECT por_id, por_titulo, por_descripcion, por_imagen, por_video, por_categoria FROM portafolio_inspiracion ORDER BY por_fecha DESC";
$result = $conn->query($sql);

$inspiraciones = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Sanitizar los datos para evitar problemas de XSS en el frontend
        $row = array_map('htmlspecialchars', $row);
        $inspiraciones[] = $row;
    }
}
header('Content-Type: application/json');
echo json_encode($inspiraciones);
