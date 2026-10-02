<?php
// verificar_matricula_duplicada.php
// Verifica si el alumno ya tiene una matrícula con el mismo id_grado, id_curso y year
// en la tabla matricula.
// Retorna un JSON con status (1 = ya existe, 0 = no existe) y el id de la matrícula encontrada.

require_once("datos.php");

$respuesta = array('status' => 0);

$id_alumno    = intval($_POST['id_alumno'] ?? 0);
$id_persona   = intval($_POST['id_persona'] ?? 0);
$id_grado     = intval($_POST['id_grado'] ?? 0);
$id_curso     = trim($_POST['id_curso'] ?? '');
$year         = trim($_POST['year'] ?? '');
// matrícula a excluir (cuando se está editando una matrícula existente)
$id_matricula = intval($_POST['id_matricula'] ?? 0);

if ($id_grado <= 0 || $id_curso === '' || $year === '') {
    echo json_encode($respuesta);
    exit;
}

// si no se tiene el codigo del alumno se busca a partir de la persona
// (sin crearlo: si no existe, la persona nunca ha sido matriculada)
if ($id_alumno <= 0 && $id_persona > 0) {
    $u = new u_alumnos();
    $datos_a = $u->get_alumno_persona($id_persona);
    if (is_array($datos_a) && isset($datos_a['id_alumnos'])) {
        $id_alumno = (int) $datos_a['id_alumnos'];
    }
}

if ($id_alumno <= 0) {
    echo json_encode($respuesta);
    exit;
}

$m = new matricula();
$id_encontrado = $m->existe_matricula_alumno($id_alumno,  $year);

if ($id_encontrado > 0) {
    $respuesta['status'] = 1;
    $respuesta['id_matricula'] = $id_encontrado;
}

echo json_encode($respuesta);
