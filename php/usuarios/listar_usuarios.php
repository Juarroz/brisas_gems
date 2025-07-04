<?php
include __DIR__ . '/../conexion.php';

$query = "SELECT u.usu_id, u.usu_nombre, u.usu_correo, u.usu_telefono, u.usu_docnum, u.usu_activo,
                 r.rol_id, r.rol_nombre, t.tipdoc_nombre
          FROM usuarios u
          INNER JOIN rol r ON u.rol_id = r.rol_id
          INNER JOIN tipo_de_documento t ON u.tipdoc_id = t.tipdoc_id";

$result = $conn->query($query);
$contador = 1;

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $estadoTexto = $row['usu_activo'] ? 'Activo' : 'Inactivo';
        $btnEstado = $row['usu_activo'] ? 'btn-danger' : 'btn-success';
        $textoEstado = $row['usu_activo'] ? 'Desactivar' : 'Activar';

        echo "<tr>
            <td>{$contador}</td>
            <td>{$row['usu_nombre']}</td>
            <td>{$row['usu_correo']}</td>
            <td>{$row['usu_telefono']}</td>
            <td>{$row['tipdoc_nombre']} - {$row['usu_docnum']}</td>
            <td>{$row['rol_nombre']}</td>
            <td>{$estadoTexto}</td>
            <td>
                <button class='btn btn-sm btn-primary btn-editar-rol'
                        data-bs-toggle='modal' data-bs-target='#modalEditarRol'
                        data-user-id='{$row['usu_id']}'
                        data-user-name=\"{$row['usu_nombre']}\"
                        data-user-role-id='{$row['rol_id']}'>
                    Editar Rol
                </button>
                <a href='../php/usuarios/cambiar_estado.php?id={$row['usu_id']}&estado={$row['usu_activo']}' class='btn btn-sm {$btnEstado}'>
                    {$textoEstado}
                </a>
            </td>
        </tr>";
        $contador++;
    }
} else {
    echo "<tr><td colspan='8' class='text-center'>No hay usuarios registrados.</td></tr>";
}

$conn->close();
?>