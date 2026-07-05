<?php

///////////////////////////////////////////////////////////////////////////
//  archivo para ingresar las notas  del estudiante en una semana        //
///////////////////////////////////////////////////////////////////////////

header('Content-Type: application/json; charset=utf-8');

require_once('datos.php');
// Parametros de entrada
$ano = isset($_POST['years']) ? (int) $_POST['years'] : 0;
$periodo = isset($_POST['periodo']) ? (int) $_POST['periodo'] : 0;
$semana_post = isset($_POST['semana']) ? (int) $_POST['semana'] : 0;

// array de respuesta
$respuesta = array();

$valido = true;
$err = 0;

// valido que la semana sea correcta
if ($semana_post < 1 or $semana_post > 32) {
    $valido = false;
    $respuesta['status'] = 20;
} else {
    $valido = true;
    $semana = $semana_post;

    // valido que el periodo sea correcto
    if ($periodo < 1 or $periodo > 3) {
        $valido = false;
        $respuesta['status'] = 21;
    } else {
        $valido = true;

        if ($ano > 2015 and $ano < 2040) {
            $valido = true;
        } else {
            $valido = false;
            $respuesta['status'] = 22;
        }
    }
}


if ($valido) {

    $html = "<h2>Avance semana $semana del $ano</h2>";

    $matriculas = new matricula_docente();
    $listado_docentes = $matriculas->listado_docentes($ano);

    $html = $html . "<div class='container'>";

    foreach ($listado_docentes as $d) {

        $html = $html . "<div class='row'>";
        $docente = new docentes();
        $docente->get_docente_id($d);

        // genero una instancia de calificacioes
        $calificacion = new calificaciones();

        // cantidad de calificaciones si se tiene  una nota
        // por estudiante 
        $max_semanal = $calificacion->max_calificaciones($docente->id, $ano);


        $sem = new semana();
        $sem->year = $ano;
        $sem->semana = $semana;
        $sem->get_semana_ano($semana, $ano);

        // total que debe reportar el docente en una semana
        $total = $sem->notas_por_alumno * $max_semanal;

        //echo "la cantidad de notas es $total";
        // obtengo la calificacion que un docente ha generado en la semana
        $s = $calificacion->get_docente_semana($docente->id, $ano, $semana);

        // límite para que ningún docente obtenga más del 100% de avance semanal
        if ($s > $total) {
            $s = $total;
        }

        // el porcentaje correcto es (evitar división por cero)
        $porcentaje = $total > 0 ? number_format((100 * $s) / $total, 2) : "0.00";
        // resultado

        $html = $html . "<div class='col-md-3'>";
        $html = $html . '<div style="display: flex ; margin-bottom: 1rem"><b>' . ucwords(strtolower($docente->nombres)) . " " . ucwords(strtolower($docente->apellidos)) . " </b></div>";
        $html = $html . "</div>"; // Cierra col-md-3

        $html = $html . "<div class='col-md-9'>";
        $html = $html . '<div class="progress col-md-8 col-5" style="display: flex ; margin-left: 1rem;">  <div class="progress-bar" role="progressbar" style="width: ';
        $html = $html . $porcentaje;
        $html = $html . '%;" aria-valuenow="';
        $html = $html . $porcentaje;
        $html = $html . '" aria-valuemin="0" aria-valuemax="100">';
        $html = $html . $porcentaje;
        $html = $html . '%</div></div>'; // cierra progress-bar y progress class
        $html = $html . "</div>"; // cierra col-md-9

        $html = $html . "</div>"; // cierra row
    }
    $html = $html . "</div>";

    // cargo la respuesta
    $respuesta['html'] = $html;
    $respuesta['status'] = 1;

    echo json_encode($respuesta);
} // fin de if año
else {
    // retorno el error en formato json 
    echo json_encode($respuesta);
}


?>