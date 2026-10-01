<?php
// guardar_familia_alumno.php
// Guarda el padre, la madre y el acudiente de un alumno al editar la matrícula
// (tablas padres, madres y acudientes, columna id_hijo = id_persona del alumno).
//
// Por cada rol, si se recibe un id_persona > 0 distinto al vinculado actualmente,
// se reemplaza el vínculo (se elimina el anterior y se inserta el nuevo).
// Si se recibe 0 o el mismo id, el vínculo no se modifica.
//
// Retorna JSON: status 1 = todo correcto, status 0 = error (con mensaje),
// y por cada rol el resultado: "sin_cambios", "actualizado" o "error".

require_once("datos.php");

$respuesta = array();

$id_hijo = intval($_POST['id_hijo'] ?? 0);

if ($id_hijo <= 0) {
    $respuesta['status'] = 0;
    $respuesta['mensaje'] = 'El id_persona del alumno es requerido.';
    echo json_encode($respuesta);
    exit;
}

/**
 * Reemplaza el vínculo del hijo en la tabla del objeto $vinculo si cambió la persona.
 *
 * @param padres|madres|acudientes $vinculo
 * @return string "sin_cambios", "actualizado" o "error"
 */
function reemplazar_vinculo($vinculo, int $id_persona, int $id_hijo): string
{
    if ($id_persona <= 0 || $id_persona == $id_hijo) {
        return "sin_cambios";
    }

    if ($vinculo->get_id_persona_por_hijo($id_hijo) == $id_persona) {
        return "sin_cambios";
    }

    if ($vinculo->del_por_hijo($id_hijo) === false) {
        return "error";
    }

    $nuevo_id = $vinculo->add($id_persona, $id_hijo, date('Y-m-d'));

    return ($nuevo_id !== false && $nuevo_id > 0) ? "actualizado" : "error";
}

$respuesta['padre'] = reemplazar_vinculo(new padres(), intval($_POST['id_padre'] ?? 0), $id_hijo);
$respuesta['madre'] = reemplazar_vinculo(new madres(), intval($_POST['id_madre'] ?? 0), $id_hijo);
$respuesta['acudiente'] = reemplazar_vinculo(new acudientes(), intval($_POST['id_acudiente'] ?? 0), $id_hijo);

$errores = array_keys(array_filter(
    array('padre' => $respuesta['padre'], 'madre' => $respuesta['madre'], 'acudiente' => $respuesta['acudiente']),
    function ($r) { return $r === "error"; }
));

if (count($errores) > 0) {
    $respuesta['status'] = 0;
    $respuesta['mensaje'] = 'No se pudo guardar: ' . implode(', ', $errores);
} else {
    $respuesta['status'] = 1;
}

echo json_encode($respuesta);
