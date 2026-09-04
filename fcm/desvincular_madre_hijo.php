<?php
// desvincular_madre_hijo.php
// Elimina el vínculo madre-hijo de la tabla `madres`
// filtrando por id_hijo (= alumno.id_persona).
// Retorna JSON: status 1 = eliminado, status 2 = no existía, status 0 = error.

require_once("datos.php");

$respuesta = [];
$datos     = $_POST;

$id_hijo = isset($datos['id_hijo']) ? intval($datos['id_hijo']) : 0;

if ($id_hijo <= 0) {
    $respuesta['status']  = 0;
    $respuesta['mensaje'] = 'El id_hijo es requerido y debe ser válido.';
    echo json_encode($respuesta);
    exit;
}

$m = new madres();

// Verificar si existe el vínculo antes de intentar borrarlo
if (!$m->existe_hijo($id_hijo)) {
    $respuesta['status']  = 2;
    $respuesta['mensaje'] = 'No existe ningún vínculo madre-hijo para este alumno.';
    echo json_encode($respuesta);
    exit;
}

$filas = $m->del_por_hijo($id_hijo);

if ($filas !== false && $filas > 0) {
    $respuesta['status']       = 1;
    $respuesta['mensaje']      = 'Vínculo madre-hijo eliminado correctamente.';
    $respuesta['filas_afect']  = $filas;
} else {
    $respuesta['status']  = 0;
    $respuesta['mensaje'] = 'No se pudo eliminar el vínculo madre-hijo.';
}

echo json_encode($respuesta);
