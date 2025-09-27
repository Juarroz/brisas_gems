<?php
require_once 'config/url.php';

$url = $URL_OPCIONES_PERSONALIZACION;

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("Error al consumir el servicio web.");
}

$opcionpers = json_decode($consumo);

 foreach ($opcionpers as $opcionper) {
    echo "ID: " . $opcionper->opc_id . "\n";
    echo "Nombre Opción: " . $opcionper->opcNombre . "\n";
    echo "-------------------------\n";
}

//POST

$respuesta = readline ("¿Desea agregar una nueva opción? (s) para si y (n) para no: ");
 
if ($respuesta === 's') {
    $nuevaopcion = readline("Ingrese el nombre de la nueva opción: ");

    $datos = array(
        'opcNombre' => $nuevaopcion
    );

    $datos_json = json_encode($datos);

    $proceso = curl_init($url);

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $datos_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($proceso, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($datos_json))
    );


    $respuestapet = curl_exec($proceso);

    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if(curl_errno($proceso)) {
        die('Error en la petición: ' . curl_error($proceso));
    }

    curl_close($proceso);

    if($http_code == 200) {
        echo "Opcion agregada exitosamente.\n";
    } else {
        echo "Error al agregar la opcion. Código de respuesta HTTP: " . $http_code . "\n";
    }
}   


//put
$respuesta = readline("¿Desea actualizar una opción? (s) para sí y (n) para no: ");

if ($respuesta === 's') {
    $id = readline("Ingrese el ID de la opción a actualizar: ");
    $nuevoNombre = readline("Ingrese el nuevo nombre de la opción: ");

    $datos = array(
        'opcNombre' => $nuevoNombre
    );

    $datos_json = json_encode($datos);

    $proceso = curl_init($url . "/" . $id);

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $datos_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($proceso, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($datos_json))
    );

    $respuestapet = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if (curl_errno($proceso)) {
        die('Error en la petición: ' . curl_error($proceso));
    }

    curl_close($proceso);

    if ($http_code == 200) {
        echo "Opción actualizada exitosamente.\n";
    } else {
        echo "Error al actualizar la opción. Código de respuesta HTTP: " . $http_code . "\n";
    }
}

//delete

$respuesta = readline("¿Desea eliminar una opción? (s) para sí y (n) para no: ");

if ($respuesta === 's') {
    $id = readline("Ingrese el ID de la opción a eliminar: ");

    $proceso = curl_init($url . "/" . $id);

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);

    $respuestapet = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if (curl_errno($proceso)) {
        die('Error en la petición: ' . curl_error($proceso));
    }

    curl_close($proceso);

    if ($http_code == 200) {
        echo "Opción eliminada exitosamente.\n";
    } else {
        echo "Error al eliminar la opción. Código de respuesta HTTP: " . $http_code . "\n";
    }
}



?>