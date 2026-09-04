<?php
// desvincular_padre_hijo.php
// Elimina el vínculo padre-hijo de la tabla `padres`
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

$p = new padres();

// Verificar si existe el vínculo antes de intentar borrarlo
if (!$p->existe_hijo($id_hijo)) {
    $respuesta['status']  = 2;
    $respuesta['mensaje'] = 'No existe ningún vínculo padre-hijo para este alumno.';
    echo json_encode($respuesta);
    exit;
}

$filas = $p->del_por_hijo($id_hijo);

if ($filas !== false && $filas > 0) {
    $respuesta['status']       = 1;
    $respuesta['mensaje']      = 'Vínculo padre-hijo eliminado correctamente.';
    $respuesta['filas_afect']  = $filas;
} else {
    $respuesta['status']  = 0;
    $respuesta['mensaje'] = 'No se pudo eliminar el vínculo padre-hijo.';
}

echo json_encode($respuesta);
