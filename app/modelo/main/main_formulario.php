<?php
include 'funciones_contacto.php';

echo "=== Menú Contacto Formulario ===\n";
echo "1. Crear contacto\n";
echo "2. Listar contactos\n";
echo "3. Obtener contacto por ID\n";
echo "4. Actualizar contacto\n";
echo "5. Eliminar contacto\n";

$opcion = readline("Seleccione una opción: ");

switch ($opcion) {
    case 1:
        $nombre   = readline("Nombre: ");
        $correo   = readline("Correo: ");
        $telefono = readline("Teléfono: ");
        $mensaje  = readline("Mensaje: ");

        $datos = [
            "nombre"   => $nombre,
            "correo"   => $correo,
            "telefono" => $telefono,
            "mensaje"  => $mensaje,
            "terminos" => true
        ];

        $resultado = crearContacto($datos);
        echo $resultado;
        break;

    case 2:
        $resultado = listarContactos();
        echo $resultado;
        break;

    case 3:
        $id = readline("ID del contacto: ");
        $resultado = obtenerContacto($id);
        echo $resultado;
        break;

    case 4:
        $id     = readline("ID del contacto a actualizar: ");
        $notas  = readline("Notas: ");
        $estado = readline("Nuevo estado (ej. pendiente, atendido): ");

        $datos = [
            "notas"  => $notas,
            "estado" => $estado
        ];

        $resultado = actualizarContacto($id, $datos);
        echo $resultado;
        break;

    case 5:
        $id = readline("ID del contacto a eliminar: ");
        $resultado = eliminarContacto($id);
        echo $resultado;
        break;

    default:
        echo "Opción no válida\n";
}
?>
