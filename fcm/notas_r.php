<?php

///////////////////////////////////////////////////////////////////////////
// notas_r.php                                                           //
//                                                                       //
// archivo para ingresar las notas  de recuperacion de los estudiantes   //
// recibe las variables por método POST, las cuales son:                 //
//                                                                       //
// $grado     --> grado de los estudiantes                               //
// $ano       --> año lectivo                                            //
// id_materia --> código de la materia                                   //
// $periodo   --> código del periodo                                     //
///////////////////////////////////////////////////////////////////////////

require_once('datos.php');
// Parametros de entrada
// grado
$grado = $_POST["id_gs"];
// y año
$ano = $_POST['year'];
// identificador de materia
$id_materia = $_POST["id_ms"];
// el periodo en el que se va a calificar
$periodo = $_POST["periodo"];
// el codigo del docente
$id_docente = $_POST["id_docente"];
// la jornada del docente
$id_jornada = $_POST["id_jornada"];

// el conjunto  de los codigos recibidos
$codigos = json_decode($_POST['codigo'], True);
// array que almacena las respuestas
$respuesta = array();
// predefino el valor de la respuesta con clave 'status'
$respuesta['status'] = 0;
// predefino el valor de la respuesta con clave 'html'
$respuesta['html'] = "";

// VALIDACIONES

// Valido si me encuentro en un año valido
if($ano > 2015 and $ano < 2050) {
    // valido si tengo una materia seleccionada
    if($id_materia > 0) {
        // valido si tengo un periodo seleccionado
        if($periodo >0) {

	      
            // si la materia  es diferentes a DICSIPLINA
	      
            if(intval($id_materia) == 20) {
		  
                ///////////////////////////////////
                // RECUPERACION DE DISCIPLINA    //
                ///////////////////////////////////

                if(isset($_POST['R'])) { 
                    // recupero los logros para el criterio J
                    $R = json_decode($_POST['R'], True);
                    ////////////////////////////////////////////////////////////////////////////////////

                    // por cada elemento en los ponderados tipo R
                    // se ejecuta el siguiente ciclo de acurdo a la cantidad
                    // de estidoamtes
			
                    for($i=0 ; count($R) > $i; $i++) {
                        //recupero el valor de la nota
                        $nota = floatval($R[$i]['value']);
	
                        //creo  una instancia de calificacioes
                        $cal = new calificaciones();
                        // consulto si hay calificaciones
                        $cal->get_recuperacion_periodo($codigos[$i]['value'],$id_materia,$ano,$periodo);

                        // si ya hay una nota de recuperación
                        // actualizo la nota de recuperación
			    
                        if($cal->calificado) { 
                            // actulizo la nota con la nota enviada
                            $cal->update_recuperacion($cal->id, $nota, $ano, );
                        }

                        // si no hay nota entonces  creo una
			    
                        else {
                            $cal->set_recuperacion($codigos[$i]['value'],
                                                   $id_materia,
                                                   $nota,
                                                   $id_docente,
                                                   $periodo,
                                                   $ano,
                            );

                        }
                    } // fin del for
                }

		  
                ////////////////////////////////////////////////////////////////////////////////
                // reuperación del logro de disciplina                                                      //
                ////////////////////////////////////////////////////////////////////////////////

                if(isset($_POST['L'])) { 
                    // recupero los logros para el criterio L
                    $L = json_decode($_POST['L'], True);
                    //////////////////////////////////////////////////////////////////////////////
		    
                    // por cada elemento en los ponderados tipo L
                    // se ejecuta el siguiente ciclo de acurdo a la cantidad
                    // de estidoamtes
                    for($i=0 ; count($L) >  $i; $i++) {
                        //recupero el valor de la nota
                        $logro = floatval($L[$i]['value']);
		      
                        //creo  una instancia de calificacioes
                        $cal = new calificaciones();
                        // consulto si hay calificaciones
                        $cal->get_logro($codigos[$i]['value'],$id_materia,$ano, $periodo);

                        // si esta calificado actualizo la nota
                        if($cal->calificado){
                            // update
                            $cal->update_logro($cal->id,$logro, $ano);
			
                        }else
                        {
                            //insert
                            $cal->set_logro($codigos[$i]['value'],
                                            $id_materia,
                                            $logro,
                                            $id_docente,
                                            $periodo,
                                            $ano
                            );
                        } // fin del else
                    } // fin del for
                } // fin de logros
            } // fin de disciplina

            //fin de materia distinta de disciplina
            else {

                /////////////////////////////////////////////
                // si esta setieada la variable R          //
                /////////////////////////////////////////////

                if(isset($_POST['R'])) {
		    
                    // recupero los logros para el criterio J
                    $R = json_decode($_POST['R'], True);
                    ////////////////////////////////////////////////////////////////////

                    $incertadas = 0;
                    $actualizadas = 0;
                    // por cada elemento en los ponderados tipo R
                    // se ejecuta el siguiente ciclo de acurdo a la cantidad
                    // de estidoamtes
		    
                    for($i=0 ; count($R) >  $i; $i++) {
                        //recupero el valor de la nota
                        $nota = floatval($R[$i]['value']);
                       
                        //creo  una instancia de calificacioes
                        $cal = new calificaciones();
                        // consulto si hay calificaciones
                        $cal->get_recuperacion_periodo ($codigos[$i]['value'],$id_materia,$ano,$periodo);
		      
                        // si ya hay una nota de recuperación
                        // actualizo la nota de recuperación
                        //echo "<br>procesasndo la recuperacion ...".$cal->calificado."   -";
                        if($cal->calificado == true) {
                            //echo "<br>procesasndo la recuperacion si ...".$cal->calificado."   -";
                            // actulizo la nota con la nota enviada
                            $cal->update_recuperacion($cal->id, $nota, $ano);
                            //echo "<br>recuperacion si ...".$cal->calificado."   ".$actualizadas;
                            $actualizadas ++;
                        }
		      
                        // si no hay nota entonces  creo una
                        else {
			
                            $cal->set_recuperacion($codigos[$i]['value'],
                                                   $id_materia,
                                                   $nota,
                                                   $id_docente,
                                                   $periodo,
                                                   $ano,
                            );
                            $incertadas ++;
                        }

                        //echo "actualizadas = $actualizadas ...";
                    } // fin del for

                    //echo "ACTUALIZADAS = $actualizadas ...".count($R);
		    
                    if (($incertadas + $actualizadas) == count($R) ) {
                        //echo "IGUALES ...";
                        // se incerto con éxito
                        $respuesta['status'] = 1;
                        // si no se incertaron filas
                        if($incertadas == 0){
                            // todas son actualizadas
                            $respuesta['html'] = "Se actualizaron $actualizadas estudiantes";
			
                        }
                        elseif ($actualizadas == 0){
                            $respuesta['html'] = "Se incertaron $incertadas estudiantes";
                        }
                        else {
                            $respuesta['html'] = "Se actualizaron $actualizadas y se incertaron $incertadas";
                        }

                        //echo "actulizadas : $actualizadas,  insertadas : $incertadas";
                    }
                } // fin de recuperacion

                if(isset($_POST['L'])) { 
                    // recupero los logros para el criterio L
                    $L = json_decode($_POST['L'], True);
                    //////////////////////////////////////////////////////////////////////////////
		    
                    // por cada elemento en los ponderados tipo L
                    // se ejecuta el siguiente ciclo de acurdo a la cantidad
                    // de estidoamtes
                    for($i=0 ; count($L) >  $i; $i++) {
                        //recupero el valor de la nota
                        $logro = floatval($L[$i]['value']);
		      
                        //creo  una instancia de calificacioes
                        $cal = new calificaciones();
                        // consulto si hay calificaciones
                        $cal->get_logro($codigos[$i]['value'],$id_materia,$ano, $periodo);

                        // si esta calificado actualizo la nota
                        if($cal->calificado){
                            // update
                            $cal->update_logro($cal->id,$logro, $ano);
			
                        }else
                        {
                            //insert
                            $cal->set_logro($codigos[$i]['value'],
                                            $id_materia,
                                            $logro,
                                            $id_docente,
                                            $periodo,
                                            $ano
                            );
                        } // fin del else
                    } // fin del for
                } // fin de logros
                
            } // fin de otra materia
        } // fin del if periodos
        else {
            $respuesta['html']=  "Por favor seleccione un periodo valido";
            // se produjo un error
            $respuesta['status'] = 20;
        }
    } //fin del if materias
    else {
        $respuesta['html']=  "Por favor seleccione una materia valida";
        // se produjo un error
        $respuesta['status'] = 20;
	}
} // fin de if año
else {
    $respuesta['html']=  "Por favor seleccione un año valido";
    // se produjo un error
    $respuesta['status'] = 20;
}


$respuesta_json = json_encode($respuesta);
echo $respuesta_json;

?>
