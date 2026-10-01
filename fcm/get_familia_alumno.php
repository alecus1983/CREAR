<?php
// get_familia_alumno.php
// Obtiene los datos del padre, la madre y el acudiente vinculados a un alumno
// (tablas padres, madres y acudientes, columna id_hijo = id_persona del alumno).
// Retorna JSON: status 1 y los objetos padre, madre y acudiente (null si no hay vínculo).

require_once("datos.php");

$respuesta = array();

$id_hijo = intval($_POST['id_persona'] ?? 0);

if ($id_hijo <= 0) {
    $respuesta['status'] = 0;
    $respuesta['mensaje'] = 'El id_persona del alumno es requerido.';
    echo json_encode($respuesta);
    exit;
}

/**
 * Retorna los datos de la persona vinculada, o null si no existe.
 */
function datos_vinculo($id_personas)
{
    if ($id_personas <= 0) {
        return null;
    }

    $p = new personas();
    $a = $p->get_persona_por_id($id_personas);

    if (!$a) {
        return null;
    }

    return array(
        'id_persona' => $a['id_personas'],
        'nombres' => $a['nombres'],
        'apellidos' => $a['apellidos'],
        'identificacion' => $a['identificacion'],
        'tipo_identificacion' => $a['tipo_identificacion'],
        'nacimiento' => $a['nacimiento'],
        'correo' => $a['correo'],
        'i_correo' => $a['i_correo'],
        'celular' => $a['celular'],
        'telefono' => $a['telefono']
    );
}

$respuesta['padre'] = datos_vinculo((new padres())->get_id_persona_por_hijo($id_hijo));
$respuesta['madre'] = datos_vinculo((new madres())->get_id_persona_por_hijo($id_hijo));
$respuesta['acudiente'] = datos_vinculo((new acudientes())->get_id_persona_por_hijo($id_hijo));
$respuesta['status'] = 1;

echo json_encode($respuesta);
