<?php
// requiere definicion de clases
require_once('datos.php');

// Garantizar respuesta JSON desde el inicio (antes de cualquier posible output)
header('Content-Type: application/json');

// Sanitizar y validar los parámetros POST
$id_alumno  = intval($_POST['id_alumno']  ?? 0);
$id_grado   = intval($_POST['id_grado']   ?? 0);
$id_curso   = intval($_POST['id_curso']   ?? 0);
$id_jornada = intval($_POST['id_jornada'] ?? 0);
$year_post  = intval($_POST['year']       ?? 0);
// El año lectivo viene del selector #years; si es inválido usamos el año actual
$year       = ($year_post >= 2000 && $year_post <= 2100) ? $year_post : intval(date('Y'));

// Validar que los valores requeridos sean positivos
if ($id_alumno <= 0 || $id_grado <= 0 || $id_curso < 0 || $id_jornada <= 0) {
    echo json_encode([
        'status'  => 0,
        'message' => 'Datos insuficientes para realizar la matrícula (id_alumno=' . $id_alumno
            . ', id_grado=' . $id_grado . ', id_curso=' . $id_curso
            . ', id_jornada=' . $id_jornada . ')'
    ]);
    exit;
}

// fecha actual
$mes             = date('m');
$fecha_matricula = date('Y-m-d');

// creo objeto matricula
$mt = new matricula();

// asigno atributos (intval ya aplicado arriba)
$mt->id_alumno  = $id_alumno;
$mt->id_grado   = $id_grado;
$mt->id_jornada = $id_jornada;
$mt->mes        = $mes;
$mt->retiro     = 11;
$mt->id_curso   = $id_curso;
$mt->year       = $year;  // año lectivo seleccionado por el usuario

// ejecuto la matricula
if ($mt->set_matricula()) {
    // $mt->id fue asignado internamente por set_matricula() tras el INSERT
    echo json_encode([
        'status'       => 1,
        'id_matricula' => $mt->id,
        'fecha'        => $fecha_matricula
    ]);
} else {
    echo json_encode([
        'status'  => 0,
        'message' => 'Error al insertar la matrícula'
    ]);
}
