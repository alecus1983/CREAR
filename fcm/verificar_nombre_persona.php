<?php
// verificar_nombre_persona.php
// Verifica si ya existe una persona con nombre y/o apellido similar en la base de datos.
// Retorna un JSON con status (1 = hay similares, 0 = no hay) y la lista de coincidencias.

require_once("datos.php");

$respuesta = array();
$datos     = $_POST;

$nombres   = isset($datos['nombres'])   ? trim($datos['nombres'])   : '';
$apellidos = isset($datos['apellidos']) ? trim($datos['apellidos']) : '';

if ($nombres === '' || $apellidos === '') {
    $respuesta['status']   = 0;
    $respuesta['encontrados'] = [];
    echo json_encode($respuesta);
    exit;
}

$p = new personas();
$encontrados = $p->buscar_nombre_similar($nombres, $apellidos);

if (count($encontrados) > 0) {
    $respuesta['status']      = 1;        // Existen personas similares
    $respuesta['encontrados'] = $encontrados;
} else {
    $respuesta['status']      = 0;        // No hay similares
    $respuesta['encontrados'] = [];
}

echo json_encode($respuesta);
