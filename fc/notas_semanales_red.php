<?php

///////////////////////////////////////////////////////////////////////////
//  archivo para ingresar las notas  del estudiante en una semana        //
///////////////////////////////////////////////////////////////////////////

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


// Valido si me encuentro en un año valido
if($ano > 2015 and $ano < 2050) {
    // valido si tengo una semana seleccionada
    if($semana > 0){
        // valido si tengo una materia seleccionada
        if($id_materia > 0){
            // valido si tengo un periodo seleccionado
            if($periodo >0){
                if(intval($id_materia) !== 20) {
                
                    // si resivo algun valor en los logros tipo A (Evaluacion de proceso)
                    if(isset($_POST['A'])){ 
                        // recupero los logros para el criterio A
                        $A = json_decode($_POST['A'], True);
    
                        ///////////////////////////////////////////////////////////////////////////

                        // por cada elemento en los ponderados tipo A
                        // se ejecuta el siguiente ciclo de acurdo a la cantidad
                        // de estidoamtes
                        for($i=0 ; count($A) >  $i; $i++) {
                            //recupero el valor de la nota
                            $nota = floatval($A[$i]['value']);
	
                            //creo  una instancia de calificacioes
                            $cal = new calificaciones();
                            // consulto si hay calificaciones
                            $cal->get_calificacion_semanal($codigos[$i]['value'],$id_materia,$semana,$ano,1);

                            // si esta calificado actualizo la nota
                            // solo si tiene un valor de cero
                            if($cal->calificado){
                                // update

                                // si la nota es cero
                                if (floatval($cal->nota) == 0){
                                    $cal->update_calificacion_semanal($cal->id,$nota);}
                                else {
                                    // texto a salir  por consola
                                    //echo " y a exise una nota para el estudiante $cal->id_alumno el la materia $cal->id_materia \n";
                                }
        
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
                        }
                    }

                    if(isset($_POST['B'])){ 
                        // recupero los logros para el criterio B
                        $B = json_decode($_POST['B'], True);
                        //////////////////////////////////////////////////////////////////////////
                
                        // por cada elemento en los ponderados tipo B
                        // se ejecuta el siguiente ciclo de acurdo a la cantidad
                        // de estidoamtes
                        for($i=0 ; count($B) >  $i; $i++) {
                            //recupero el valor de la nota
                            $nota = floatval($B[$i]['value']);
	
                            //creo  una instancia de calificacioes
                            $cal = new calificaciones();
                            // consulto si hay calificaciones
                            $cal->get_calificacion_semanal($codigos[$i]['value'],$id_materia,$semana,$ano,2);

                            // si esta calificado actualizo la nota
                            if($cal->calificado){
                                // update
                                // si la nota es cero
                                if (floatval($cal->nota) == 0){
                                    $cal->update_calificacion_semanal($cal->id,$nota);}
                                else {
                                    // texto a salir  por consola
                                    //echo " y a exise una nota para el estudiante $cal->id_alumno el la materia $cal->id_materia \n";
                                }
        
                            }else
                            {
                                //insert
                                $cal->set_calificacion_semanal($codigos[$i]['value'],
                                                               $id_materia,
                                                               $nota,
                                                               $id_docente,
                                                               $periodo,
                                                               $ano,
                                                               2,
                                                               $semana);
                            } // fin del else
                    

                        }
                    }


                    if(isset($_POST['C'])){ 
                        // recupero los logros para el criterio C
                        $C = json_decode($_POST['C'], True);

                        ////////////////////////////////////////////////////////////////////////////////////
                
                        // por cada elemento en los ponderados tipo C
                        // se ejecuta el siguiente ciclo de acurdo a la cantidad
                        // de estidoamtes
                        for($i=0 ; count($C) >  $i; $i++) {
                            //recupero el valor de la nota
                            $nota = floatval($C[$i]['value']);
	
                            //creo  una instancia de calificacioes
                            $cal = new calificaciones();
                            // consulto si hay calificaciones
                            $cal->get_calificacion_semanal($codigos[$i]['value'],$id_materia,$semana,$ano,3);

                            // si esta calificado actualizo la nota
                            if($cal->calificado){
                                // update
                                // si la nota es cero
                                if (floatval($cal->nota) == 0){
                                    $cal->update_calificacion_semanal($cal->id,$nota);}
                                else {
                                    // texto a salir  por consola
                                    //echo " y a exise una nota para el estudiante $cal->id_alumno el la materia $cal->id_materia \n";
                                }
        
                            }else
                            {
                                //insert
                                $cal->set_calificacion_semanal($codigos[$i]['value'],
                                                               $id_materia,
                                                               $nota,
                                                               $id_docente,
                                                               $periodo,
                                                               $ano,
                                                               3,
                                                               $semana);
                            } // fin del else

                
                        } // fin del for
                    }



                    if(isset($_POST['D'])){ 
                        // recupero los logros para el criterio D
                        $D = json_decode($_POST['D'], True);
                        ////////////////////////////////////////////////////////////////////////////////////

                        // por cada elemento en los ponderados tipo D
                        // se ejecuta el siguiente ciclo de acurdo a la cantidad
                        // de estidoamtes
                        for($i=0 ; count($D) >  $i; $i++) {
                            //recupero el valor de la nota
                            $nota = floatval($D[$i]['value']);
	
                            //creo  una instancia de calificacioes
                            $cal = new calificaciones();
                            // consulto si hay calificaciones
                            $cal->get_calificacion_semanal($codigos[$i]['value'],$id_materia,$semana,$ano,4);

                            // si esta calificado actualizo la nota
                            if($cal->calificado){
                                // update
                                // si la nota es cero
                                if (floatval($cal->nota) == 0){
                                    $cal->update_calificacion_semanal($cal->id,$nota);}
                                else {
                                    // texto a salir  por consola
                                    //echo " y a exise una nota para el estudiante $cal->id_alumno el la materia $cal->id_materia \n";
                                }
        
                            }else
                            {
                                //insert
                                $cal->set_calificacion_semanal($codigos[$i]['value'],
                                                               $id_materia,
                                                               $nota,
                                                               $id_docente,
                                                               $periodo,
                                                               $ano,
                                                               4,
                                                               $semana);
                            } // fin del else

                
                        } // fin del for
                    }


                    if(isset($_POST['E'])){ 
                        // recupero los logros para el criterio E
                        $E = json_decode($_POST['E'], True);
                        ////////////////////////////////////////////////////////////////////////////////////

                        // por cada elemento en los ponderados tipo E
                        // se ejecuta el siguiente ciclo de acurdo a la cantidad
                        // de estidoamtes
                        for($i=0 ; count($E) >  $i; $i++) {
                            //recupero el valor de la nota
                            $nota = floatval($E[$i]['value']);
	
                            //creo  una instancia de calificacioes
                            $cal = new calificaciones();
                            // consulto si hay calificaciones
                            $cal->get_calificacion_semanal($codigos[$i]['value'],$id_materia,$semana,$ano,5);

                            // si esta calificado actualizo la nota
                            if($cal->calificado){
                                // update
                                // si la nota es cero
                                if (floatval($cal->nota) == 0){
                                    $cal->update_calificacion_semanal($cal->id,$nota);}
                                else {
                                    // texto a salir  por consola
                                    //echo " y a exise una nota para el estudiante $cal->id_alumno el la materia $cal->id_materia \n";
                                }
        
                            }else
                            {
                                //insert
                                $cal->set_calificacion_semanal($codigos[$i]['value'],
                                                               $id_materia,
                                                               $nota,
                                                               $id_docente,
                                                               $periodo,
                                                               $ano,
                                                               5,
                                                               $semana);
                            } // fin del else

                
                        } // fin del for

                    }


                    if(isset($_POST['F'])){ 
                        // recupero los logros para el criterio F
                        $F = json_decode($_POST['F'], True);
                        ////////////////////////////////////////////////////////////////////////////////////

                        // por cada elemento en los ponderados tipo F
                        // se ejecuta el siguiente ciclo de acurdo a la cantidad
                        // de estidoamtes
                        for($i=0 ; count($F) >  $i; $i++) {
                            //recupero el valor de la nota
                            $nota = floatval($F[$i]['value']);
	
                            //creo  una instancia de calificacioes
                            $cal = new calificaciones();
                            // consulto si hay calificaciones
                            $cal->get_calificacion_semanal($codigos[$i]['value'],$id_materia,$semana,$ano,6);

                            // si esta calificado actualizo la nota
                            if($cal->calificado){
                                // update
                                // si la nota es cero
                                if (floatval($cal->nota) == 0){
                                    $cal->update_calificacion_semanal($cal->id,$nota);}
                                else {
                                    // texto a salir  por consola
                                    //echo " y a exise una nota para el estudiante $cal->id_alumno el la materia $cal->id_materia \n";
                                }
        
                            }else
                            {
                                //insert
                                $cal->set_calificacion_semanal($codigos[$i]['value'],
                                                               $id_materia,
                                                               $nota,
                                                               $id_docente,
                                                               $periodo,
                                                               $ano,
                                                               6,
                                                               $semana);
                            } // fin del else

                
                        } // fin del for

                    }

                    if(isset($_POST['G'])){ 
                        // recupero los logros para el criterio G
                        $G = json_decode($_POST['G'], True);

                        ////////////////////////////////////////////////////////////////////////////////////

                        // por cada elemento en los ponderados tipo G
                        // se ejecuta el siguiente ciclo de acurdo a la cantidad
                        // de estidoamtes
                        for($i=0 ; count($G) >  $i; $i++) {
                            //recupero el valor de la nota
                            $nota = floatval($G[$i]['value']);
	
                            //creo  una instancia de calificacioes
                            $cal = new calificaciones();
                            // consulto si hay calificaciones
                            $cal->get_calificacion_semanal($codigos[$i]['value'],$id_materia,$semana,$ano,7);

                            // si esta calificado actualizo la nota
                            if($cal->calificado){
                                // update
                                // si la nota es cero
                                if (floatval($cal->nota) == 0){
                                    $cal->update_calificacion_semanal($cal->id,$nota);}
                                else {
                                    // texto a salir  por consola
                                    //echo " y a exise una nota para el estudiante $cal->id_alumno el la materia $cal->id_materia \n";
                                }
        
                            }else
                            {
                                //insert
                                $cal->set_calificacion_semanal($codigos[$i]['value'],
                                                               $id_materia,
                                                               $nota,
                                                               $id_docente,
                                                               $periodo,
                                                               $ano,
                                                               7,
                                                               $semana);
                            } // fin del else

                
                        } // fin del for

                    }

                    if(isset($_POST['H'])){ 
                        // recupero los logros para el criterio H
                        $H = json_decode($_POST['H'], True);


                        ////////////////////////////////////////////////////////////////////////////////////

                        // por cada elemento en los ponderados tipo H
                        // se ejecuta el siguiente ciclo de acurdo a la cantidad
                        // de estidoamtes
                        for($i=0 ; count($H) >  $i; $i++) {
                            //recupero el valor de la nota
                            $nota = floatval($H[$i]['value']);
	
                            //creo  una instancia de calificacioes
                            $cal = new calificaciones();
                            // consulto si hay calificaciones
                            $cal->get_calificacion_semanal($codigos[$i]['value'],$id_materia,$semana,$ano,8);

                            // si esta calificado actualizo la nota
                            if($cal->calificado){
                                // update
                                // si la nota es cero
                                if (floatval($cal->nota) == 0){
                                    $cal->update_calificacion_semanal($cal->id,$nota);}
                                else {
                                    // texto a salir  por consola
                                    //echo " y a exise una nota para el estudiante $cal->id_alumno el la materia $cal->id_materia \n";
                                }
        
                            }else
                            {
                                //insert
                                $cal->set_calificacion_semanal($codigos[$i]['value'],
                                                               $id_materia,
                                                               $nota,
                                                               $id_docente,
                                                               $periodo,
                                                               $ano,
                                                               8,
                                                               $semana);
                            } // fin del else

                
                        } // fin del for
                
                    }

                    if(isset($_POST['I'])){ 
                        // recupero los logros para el criterio I
                        $I = json_decode($_POST['I'], True);

                        ////////////////////////////////////////////////////////////////////////////////////

                        // por cada elemento en los ponderados tipo I
                        // se ejecuta el siguiente ciclo de acurdo a la cantidad
                        // de estidoamtes
                        for($i=0 ; count($I) >  $i; $i++) {
                            //recupero el valor de la nota
                            $nota = floatval($I[$i]['value']);
	
                            //creo  una instancia de calificacioes
                            $cal = new calificaciones();
                            // consulto si hay calificaciones
                            $cal->get_calificacion_semanal($codigos[$i]['value'],$id_materia,$semana,$ano,9);

                            // si esta calificado actualizo la nota
                            if($cal->calificado){
                                // update
                                // si la nota es cero
                                if (floatval($cal->nota) == 0){
                                    $cal->update_calificacion_semanal($cal->id,$nota);}
                                else {
                                    // texto a salir  por consola
                                    //echo " y a exise una nota para el estudiante $cal->id_alumno el la materia $cal->id_materia \n";
                                }
        
                            }else
                            {
                                //insert
                                $cal->set_calificacion_semanal($codigos[$i]['value'],
                                                               $id_materia,
                                                               $nota,
                                                               $id_docente,
                                                               $periodo,
                                                               $ano,
                                                               9,
                                                               $semana);
                            } // fin del else

                
                        } // fin del for

                    }


                    if(isset($_POST['J'])) { 
                        // recupero los logros para el criterio J
                        $J = json_decode($_POST['J'], True);
                        ////////////////////////////////////////////////////////////////////////////////////

                        // por cada elemento en los ponderados tipo J
                        // se ejecuta el siguiente ciclo de acurdo a la cantidad
                        // de estidoamtes
                        for($i=0 ; count($J) >  $i; $i++) {
                            //recupero el valor de la nota
                            $nota = floatval($J[$i]['value']);
	
                            //creo  una instancia de calificacioes
                            $cal = new calificaciones();
                            // consulto si hay calificaciones
                            $cal->get_calificacion_semanal($codigos[$i]['value'],$id_materia,$semana,$ano,10);

                            // si esta calificado actualizo la nota
                            if($cal->calificado){
                                // update
                                // si la nota es cero
                                if (floatval($cal->nota) == 0){
                                    $cal->update_calificacion_semanal($cal->id,$nota);}
                                else {
                                    // texto a salir  por consola
                                    //echo " y a exise una nota para el estudiante $cal->id_alumno el la materia $cal->id_materia \n";
                                }
        
                            }else
                            {
                                //insert
                                $cal->set_calificacion_semanal($codigos[$i]['value'],
                                                               $id_materia,
                                                               $nota,
                                                               $id_docente,
                                                               $periodo,
                                                               $ano,
                                                               10,
                                                               $semana);
                            } // fin del else

                
                        } // fin del for

                    }

                    //////////////////////////////////////////////////////////////////////////////


                    if(isset($_POST['L'])) { 
                        // recupero los logros para el criterio J
                        $L = json_decode($_POST['L'], True);
                        ////////////////////////////////////////////////////////////////////////////////////

                        // por cada elemento en los ponderados tipo J
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
                                $cal->update_logro($cal->id,$logro);
        
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

                    }
                } // fin de materia = 20
                // cuando se trata de disciplina
                else {
                    // si resivo algun valor en los logros tipo A (En este caso disciplina)
                    if(isset($_POST['A'])){ 
                        // recupero los logros para el criterio A
                        $A = json_decode($_POST['A'], True);
    
                        ///////////////////////////////////////////////////////////////////////////

                        // por cada elemento en los ponderados tipo A
                        // se ejecuta el siguiente ciclo de acurdo a la cantidad
                        // de estidoamtes
                        for($i=0 ; count($A) >  $i; $i++) {
                            //recupero el valor de la nota
                            $nota = floatval($A[$i]['value']);
	
                            //creo  una instancia de calificacioes
                            $cal = new calificaciones();
                            // consulto si hay calificaciones
                            $cal->get_calificacion_semanal($codigos[$i]['value'],$id_materia,$semana,$ano,0);

                            // si esta calificado actualizo la nota
                            // solo si tiene un valor de cero
                            if($cal->calificado){
                                // update

                                // si la nota es cero
                                if (floatval($cal->nota) == 0){
                                    $cal->update_calificacion_semanal($cal->id,$nota);}
                                else {
                                    // texto a salir  por consola
                                    //echo " y a exise una nota para el estudiante $cal->id_alumno el la materia $cal->id_materia \n";
                                }
        
                            }else
                            {
                                //insert
                                $cal->set_calificacion_semanal($codigos[$i]['value'],
                                                               $id_materia,
                                                               $nota,
                                                               $id_docente,
                                                               $periodo,
                                                               $ano,
                                                               0,
                                                               $semana);
                            } // fin del else
                        }
                    }

                }
            } // fin del if periodos

            
            else { echo "Por favor indique un periodo valido";}
        } //fin del if materias
        else { echo "Por favor seleccione una materia"; }
    } // fin del if semanas
    else { echo "Por favor seleccione una semana valida"; }
} // fin de if año
else { echo "Por favor seleccione un año valido";}


?>
