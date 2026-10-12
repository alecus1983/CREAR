<?php
// vincular_acudiente_hijo.php
// Verifica si el hijo ya tiene vinculado a ese acudiente en la tabla acudientes.
// Si no tiene acudiente lo inserta con la fecha actual; si tiene otro, lo reemplaza.
// Retorna JSON: status 1 = insertado o reemplazado, status 2 = ya existía, status 0 = error.

require_once("datos.php");

$respuesta = [];
$datos     = $_POST;

$id_acudiente = isset($datos['id_acudiente']) ? intval($datos['id_acudiente']) : 0;
$id_hijo      = isset($datos['id_hijo'])      ? intval($datos['id_hijo'])      : 0;

if ($id_acudiente <= 0 || $id_hijo <= 0) {
    $respuesta['status']  = 0;
    $respuesta['mensaje'] = 'Los IDs de acudiente e hijo son requeridos y deben ser válidos.';
    echo json_encode($respuesta);
    exit;
}

$a = new acudientes();

// Verificar si este hijo ya tiene vinculado al mismo acudiente
if ($a->existe_hijo($id_hijo) && $a->get_id_persona_por_hijo($id_hijo) == $id_acudiente) {
    $respuesta['status']  = 2;
    $respuesta['mensaje'] = 'El vínculo acudiente-hijo ya existe.';
} elseif ($a->existe_hijo($id_hijo) && $a->del_por_hijo($id_hijo) === false) {
    // El hijo tenía otro acudiente y no se pudo retirar para reemplazarlo
    $respuesta['status']  = 0;
    $respuesta['mensaje'] = 'No se pudo reemplazar el acudiente anterior.';
} else {
    // Insertar nuevo vínculo con la fecha actual
    // (si había otro acudiente, ya se retiró y este lo reemplaza)
    $fecha   = date('Y-m-d');
    $nuevoId = $a->add($id_acudiente, $id_hijo, $fecha);

    if ($nuevoId !== false && $nuevoId > 0) {
        $respuesta['status']       = 1;
        $respuesta['mensaje']      = 'Vínculo acudiente-hijo creado correctamente.';
        $respuesta['id_acudientes'] = $nuevoId;
    } else {
        $respuesta['status']  = 0;
        $respuesta['mensaje'] = 'No se pudo insertar el vínculo.';
    }
}

echo json_encode($respuesta);
