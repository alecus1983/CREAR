<?php
// requiere definicion de clases
require_once('datos.php');

// se  recupera el nombre por el método POST
$id_persona = intval($_POST["id_persona"] ?? 0);
// variable que almacena el codigo del alumno
$id_alumno = 0;

// selecciona una nueva persona
$persona = new personas();
// obtener los datos de la persona
$persona->get_persona_por_id($id_persona);

// nuevo objeto u_alumnos
$alumno = new u_alumnos();

// obtiene los datos del alumno a partir del id_persona
$datos_a = $alumno->get_alumno_persona($id_persona);

// Validación correcta: el registro existe si $datos_a es un array con id_alumnos
if (is_array($datos_a) && isset($datos_a['id_alumnos'])) {

    // La persona ya tiene código de alumno: lo devolvemos
    $id_alumno = (int) $datos_a['id_alumnos'];

} else {
    // La persona no tiene código de alumno:
    // add_alumno() calcula MAX+1, inserta en u_alumnos
    // y actualiza la columna u_alumnos en personas.
    $id_alumno = $alumno->add_alumno($id_persona);
}

// ajusto el formato
echo json_encode($id_alumno);
?>
