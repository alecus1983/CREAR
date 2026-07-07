<?php
// archivo de configuracion  de objetos
require_once("datos.php");

//variables recibidas mediante POST
$valido = true;
$err = "";

$matriculas = new matricula_docente();
$listado_docentes = $matriculas->listado_docentes(2023);

echo '<table class="table"><thead>';
echo '<tr>';
echo '<th scope="col">Docente</th>';
echo '<th scope="col">Cedula</th>';
echo '<th scope="col">Contraseña</th>';
echo '</tr></thead><tbody>';


foreach ($listado_docentes as $d) {
    echo '<tr>';
    $docente = new docentes();
    $docente->get_docente_id($d);
    echo "<td>" . ucwords(strtolower($docente->nombres)) . " " . ucwords(strtolower($docente->apellidos)) . "</td>";

    echo '<td>' . $docente->cedula . '</td>';

    echo '<td>' . $docente->login . '</td>';
    echo '</tr>';
}

echo "</tbody></table>";


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

//$lista = new $matriculas();
