<?php
// archivo que obtiene el listado de docentes matriculados
// en la tabla matricula_docente para el año recibido por POST (years)
// responde en formato json con las llaves status y html

// archivo de configuracion  de objetos
require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuesta
$respuesta = array();

// validacion del año
if (isset($_POST["years"]) && $_POST["years"] !== "" && intval($_POST["years"]) > 0) {
    $ano = intval($_POST["years"]);
} else {
    $valido = false;
    $respuesta['status'] = 22;
}

// si los datos son validos
if ($valido) {

    $matriculas = new matricula_docente();
    // docentes con al menos una matricula en el año
    $listado_docentes = $matriculas->get_docentes_year($ano);

    $html = "<p style ='margin-bottom:1rem'>Listado de docentes matriculados en el año " . $ano . " (" . count($listado_docentes) . " docentes):</p>";
    $html = $html . "<div class='responsive-table'>";
    $html = $html . "<div class='table-header'>";
    $html = $html . "<div class='header-cell'>#</div>";
    $html = $html . "<div class='header-cell'>Nombres</div>";
    $html = $html . "<div class='header-cell'>Apellidos</div>";
    $html = $html . "<div class='header-cell'>D. de identidad</div>";
    $html = $html . "<div class='header-cell'>Clases asignadas</div>";
    $html = $html . "</div>";
    $html = $html . "<div class='table-body'>";

    $i = 1;
    foreach ($listado_docentes as $d) {
        $html = $html . "<div class='table-row'>";
        $html = $html . "<div class='table-cell' data-label='#'>" . $i . "</div>";
        $html = $html . "<div class='table-cell' data-label='Nombres'>" . htmlspecialchars(ucwords(strtolower($d['nombres']))) . "</div>";
        $html = $html . "<div class='table-cell' data-label='Apellidos'>" . htmlspecialchars(ucwords(strtolower($d['apellidos']))) . "</div>";
        $html = $html . "<div class='table-cell' data-label='D. Identidad'>" . htmlspecialchars($d['identificacion']) . "</div>";
        $html = $html . "<div class='table-cell' data-label='Clases'>" . $d['clases'] . "</div>";
        $html = $html . "</div>";
        $i++;
    }

    // si no hay docentes en el año
    if (count($listado_docentes) == 0) {
        $html = $html . "<div class='table-row'><div class='table-cell'>No hay docentes matriculados en el año " . $ano . "</div></div>";
    }

    $html = $html . "</div>";
    $html = $html . "</div>";

    $respuesta['html'] = $html;
    $respuesta['status'] = 1;
} else {
    $respuesta['html'] = "";
}

echo json_encode($respuesta);

// ---------------------------------------------------------------------------
// EJEMPLO DE USO DE LOS MÉTODOS DE calificaciones QUE CONSULTAN c_{$ano}
// ---------------------------------------------------------------------------
//
// Los métodos get_notas_semana_final(), get_notas_semana_intermedia() y
// get_notas_semana_normal() encapsulan las consultas a la tabla c_{$ano}
// y devuelven arrays indexados por id_alumno, listos para usar en la vista.
//
// Parámetros comunes:
//   $ano        → año lectivo (ej. 2023)
//   $id_m       → id de la materia
//   $periodo    → período 1-4
//   $semana     → número de semana
//   $arr_pond   → array de ponderados (letras A-J según tipo de semana)
//   $in_alumnos → string "id1,id2,id3,..." para la cláusula IN
//
// --- Semana final (8, 16, 24, 32) ---
// Retorna: ['logros' => [id_alumno => [l1, l2, l3]], 'notas' => [id_alumno => [campos...]]]
//
//   $cal = new calificaciones();
//   $arr_pond_final = [1 => "F", 2 => "G", 3 => "I", 4 => "J"];
//   $res = $cal->get_notas_semana_final($ano, $id_m, $periodo, $semana, $arr_pond_final, $in_alumnos);
//   $opt_logros = $res['logros'];
//   $opt_notas  = $res['notas'];
//
// --- Semana intermedia (4, 12, 20, 28) ---
// Retorna: [id_alumno => [campos de notas de la semana]]
//
//   $arr_pond_media = [1=>"A", 2=>"B", 3=>"C", 4=>"D", 5=>"E", 6=>"F", 7=>"G", 8=>"H"];
//   $opt_notas = $cal->get_notas_semana_intermedia($ano, $id_m, $periodo, $semana, $arr_pond_media, $in_alumnos);
//
// --- Semana normal ---
// Retorna: [id_alumno => [campos de notas de la semana]]
//
//   $arr_pond_normal = [1=>"A", 2=>"B", 3=>"C", 4=>"D", 5=>"E", 6=>"F", 7=>"G"];
//   $opt_notas = $cal->get_notas_semana_normal($ano, $id_m, $semana, $arr_pond_normal, $in_alumnos);
//
// --- Avance de calificaciones por docente (para panel de docentes) ---
// get_docente_semana()  → cuántas notas ingresó el docente en la semana actual
// max_calificaciones()  → cuántas notas debería tener en total
//
//   $cal = new calificaciones();
//   foreach ($listado_docentes as $id_docente) {
//       $ingresadas = $cal->get_docente_semana($id_docente, $ano, $semana);
//       $esperadas  = $cal->max_calificaciones($id_docente, $ano);
//       $porcentaje = $esperadas > 0 ? round(($ingresadas / $esperadas) * 100, 1) : 0;
//       echo "$id_docente → $ingresadas / $esperadas ($porcentaje%)";
//   }
// ---------------------------------------------------------------------------

