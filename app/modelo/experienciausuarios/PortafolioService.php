<?php

$url = "http://localhost:8080/portafolio";

$consumo = file_get_contents($url);

if ($consumo === FALSE) {
    die("no se puede consumir el servicio");
}

$portafolio = json_decode($consumo);

if ($portafolio === null) {
    die("no se pudo codificar");
}

echo "--- Nuestro portafolio ---\n"; 

foreach ($portafolio as $portafoli) {
    echo $portafoli->porTitulo . "\n";
}

?>