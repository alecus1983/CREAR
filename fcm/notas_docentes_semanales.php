<?php

///////////////////////////////////////////////////////////////////////////
//  archivo para ingresar las notas  del estudiante en una semana        //
///////////////////////////////////////////////////////////////////////////

require_once('datos.php');
// Parametros de entrada
$ano = $_POST['years'];
$periodo = $_POST['periodo'];
$semana = $_POST['semana'];

if ($ano > 2015 and $ano < 2040) {

    echo "<h2>Avance semana $semana del $ano</h2>";

    $matriculas = new matricula_docente();
    $matriculas->listado_docentes($ano);

    echo "<div class='container'>";

    foreach ($matriculas->listado_docentes as $d) {

        echo "<div class='row'>";
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

        echo "<div class='col-md-3'>";
        echo '<div style="display: flex ; margin-bottom: 1rem"><b>' . ucwords(strtolower($docente->nombres)) . " " . ucwords(strtolower($docente->apellidos)) . " </b></div>";
        echo "</div>"; // Cierra col-md-3

        echo "<div class='col-md-9'>";
        echo '<div class="progress col-md-8 col-5" style="display: flex ; margin-left: 1rem;">  <div class="progress-bar" role="progressbar" style="width: ';
        echo $porcentaje;
        echo '%;" aria-valuenow="';
        echo $porcentaje;
        echo '" aria-valuemin="0" aria-valuemax="100">';
        echo $porcentaje;
        echo '%</div></div>'; // cierra progress-bar y progress class
        echo "</div>"; // cierra col-md-9

        echo "</div>"; // cierra row
    }
    echo "</div>";

} // fin de if año
else {
    echo "Por favor seleccione un año valido";
}


?>