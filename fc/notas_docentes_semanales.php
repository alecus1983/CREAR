<?php

///////////////////////////////////////////////////////////////////////////
//  archivo para ingresar las notas  del estudiante en una semana        //
///////////////////////////////////////////////////////////////////////////

require_once('datos.php');
// Parametros de entrada
$ano = '2023';
$semana = 8;

if($ano > 2015 and $ano < 2040) {

    $matriculas = new matricula_docente();
    $matriculas->listado_docentes(2023);

    foreach($matriculas->listado_docentes as $d){

        $docente = new docentes();
        $docente->get_docente_id($d);   

        // genero una instancia de calificacioes
        $calificacion = new calificaciones();
    
    // cantidad de calificaciones si se tiene  una nota
    // por estudiante 
    $max_semanal = $calificacion->max_calificaciones($docente->id,$ano);
    

    $sem = new semana();
    $sem->year = $ano;
    $sem->semana = $semana;
    $sem->get_semana_ano($semana, $ano);
    
    // todtal que debe reportar el docente en una semana
    $total = $sem->notas_por_alumno * $max_semanal;
    
    //echo "la cantidad de notas es $total";
    $s =  $calificacion->get_docente_semana($docente->id, $semana);
    // el porcentajae correcto es
    $porcentaje = (100*$s)/$total;
    // resultado
    echo "<p>El docente $docente->id ha cargado el $porcentaje, ingreso $s calificaciones de $total requeridas </p><br>";
    }
    
} // fin de if año
else { echo "Por favor seleccione un año valido";}


?>
