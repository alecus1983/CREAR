<?php
// vincular_madre_hijo.php
// Verifica si ya existe un vínculo madre-hijo en la tabla madres.
// Si no existe, lo inserta con la fecha actual.
// Retorna JSON: status 1 = insertado, status 2 = ya existía, status 0 = error.

require_once("datos.php");

$respuesta = [];
$datos     = $_POST;

$id_madre = isset($datos['id_madre']) ? intval($datos['id_madre']) : 0;
$id_hijo  = isset($datos['id_hijo'])  ? intval($datos['id_hijo'])  : 0;

if ($id_madre <= 0 || $id_hijo <= 0) {
    $respuesta['status']  = 0;
    $respuesta['mensaje'] = 'Los IDs de madre e hijo son requeridos y deben ser válidos.';
    echo json_encode($respuesta);
    exit;
}

$m = new madres();

// Verificar si ya existe el vínculo para este hijo
if ($m->existe_hijo($id_hijo)) {
    $respuesta['status']  = 2;
    $respuesta['mensaje'] = 'El vínculo madre-hijo ya existe.';
} else {
    // Insertar nuevo vínculo con la fecha actual
    $fecha   = date('Y-m-d');
    $nuevoId = $m->add($id_madre, $id_hijo, $fecha);

    if ($nuevoId !== false && $nuevoId > 0) {
        $respuesta['status']    = 1;
        $respuesta['mensaje']   = 'Vínculo madre-hijo creado correctamente.';
        $respuesta['id_madres'] = $nuevoId;
    } else {
        $respuesta['status']  = 0;
        $respuesta['mensaje'] = 'No se pudo insertar el vínculo.';
    }
}

echo json_encode($respuesta);
