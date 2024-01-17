<?php

///////////////////////////////////////////////////////////////////////////
//  archivo para ingresar las notas  del estudiante en un periodo       //
//////////////////////////////////////////////////////////////////////////

require_once('datos.php');
// Parametros de entrada
// grado
$grado = $_POST["id_gs"];
// y año
$ano = $_POST['year'];
//semana
$semana = $_POST['semana'];
// identificador de materia
$id_materia = $_POST["id_ms"];
// el periodo en el que se va a calificar
$periodo = $_POST["periodo"];
// el codigo del docente
$id_docente = $_POST['id_docente'];
// la jornada del docente
$id_jornada = $_POST["id_jornada"];

// el conjunto de los logros
$logro1 = json_decode($_POST['logro1'], True);
// el conjunto de los logros
$logro2 = json_decode($_POST['logro2'], True);
// el conjunto de los logros
$logro3 = json_decode($_POST['logro3'], True);
// el conjunto de los faltas
$faltas = json_decode($_POST['faltas'], True);
// el conjunto  de los codigos recibidos
$codigos = json_decode($_POST['codigo'], True);

// recupero los logros para el criterio A
$A = json_decode($_POST['A'], True);

// constante para validaciones
$valido = true;
$l= 0;
// variable que guarda la cantidad de registros actualizados
$exito = 0;
// variable que guarda la cantidad de registros sin ingresar
$fracaso = 0;

if($ano > 2015 and $ano < 2040){
    if($semana > 0){
        if($id_materia > 0){
            if($periodo >0){
    


    // por cada elemento en los ponderados tipo A
    // se ejecuta el siguiente ciclo de acurdo a la cantidad
    // de estidoamtes
    for($i=0 ; count($A) >  $i; $i++) {
        //defino el valor de la nota
        // la cual debe ser el 2.5% de la nota total
        // cuyo maximo valor es cinco 2.5% -> 5 = 0.125, por lo cual se
        // multiplica por el factor de (0.125/5) 0.025
        $nota = floatval($A[$i]['value']);
	
        //creo  una instancia de calificacioes
        $cal = new calificaciones();
        // consulto si hay calificaciones
        $cal->get_calificacion_semanal($codigos[$i]['value'],$id_materia,$semana,$ano,1);

        // si esta calificado actualizo la nota
        if($cal->calificado){
            // update
            $cal->update_calificacion_semanal($cal->id,$nota);
        
        }else
        {
            //insert
            $cal->set_calificacion_semanal($codigos[$i]['value'],
                                           $id_materia,
                                           $nota,
                                           $id_docente,
                                           $periodo,
                                           $ano,
                                           1,
                                           $semana);
        } // fin del else
    } // fin del for
            } // fin del if periodos
            else { echo "Por favor indique un periodo valido";}
        } //fin del if materias
        else { echo "Por favor seleccione una materia"; }
    } // fin del if semanas
    else { echo "Por favor seleccione una semana valida"; }
} // fin de if año
else { echo "Por favor seleccione un año valido";}


?>
