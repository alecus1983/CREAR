<?php
// vincular_padre_hijo.php
// Verifica si ya existe un vínculo padre-hijo en la tabla padres.
// Si no existe, lo inserta con la fecha actual.
// Retorna JSON: status 1 = insertado, status 2 = ya existía, status 0 = error.

require_once("datos.php");

$respuesta = [];
$datos     = $_POST;

$id_padre = isset($datos['id_padre']) ? intval($datos['id_padre']) : 0;
$id_hijo  = isset($datos['id_hijo'])  ? intval($datos['id_hijo'])  : 0;

if ($id_padre <= 0 || $id_hijo <= 0) {
    $respuesta['status']  = 0;
    $respuesta['mensaje'] = 'Los IDs de padre e hijo son requeridos y deben ser válidos.';
    echo json_encode($respuesta);
    exit;
}

$p = new padres();

// Verificar si ya existe el vínculo para este hijo
if ($p->existe_hijo($id_hijo)) {
    $respuesta['status']  = 2;
    $respuesta['mensaje'] = 'El vínculo padre-hijo ya existe.';
} else {
    // Insertar nuevo vínculo con la fecha actual
    $fecha   = date('Y-m-d');
    $nuevoId = $p->add($id_padre, $id_hijo, $fecha);

    if ($nuevoId !== false && $nuevoId > 0) {
        $respuesta['status']    = 1;
        $respuesta['mensaje']   = 'Vínculo padre-hijo creado correctamente.';
        $respuesta['id_padres'] = $nuevoId;
    } else {
        $respuesta['status']  = 0;
        $respuesta['mensaje'] = 'No se pudo insertar el vínculo.';
    }
}

echo json_encode($respuesta);
