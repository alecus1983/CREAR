<?php
// archivo para insertar notas

require_once('datos.php');

// Parametros de entrada — se castean a int para evitar valores corruptos
// (p.ej. "20264" en lugar de "2026") que rompen el nombre de la tabla.
$ano = intval($_POST['year']);
$periodo = intval($_POST['periodo']);
$semana = intval($_POST['semana']);
$id_materia = intval($_POST['id_ms']);

$id_docente = intval($_POST['id_docente']);
$id_gs = intval($_POST['id_gs']);
$id_jornada = intval($_POST['id_jornada']);

// datos de entrada del formulario
$A = json_decode($_POST['A'], True);
$B = json_decode($_POST['B'], True);
$C = json_decode($_POST['C'], True);
$D = json_decode($_POST['D'], True);
$E = json_decode($_POST['E'], True);
$F = json_decode($_POST['F'], True);
$G = json_decode($_POST['G'], True);
$H = json_decode($_POST['H'], True);
$I = json_decode($_POST['I'], True);
$J = json_decode($_POST['J'], True);
$L = json_decode($_POST['L'], True);

// array para insertar notas
$arr_insertar = [];
// array para actualizar notas
$arr_actualizar = [];
// array entrada de los datos que viene del formulario
$arr_entrada = [];
//array de notas de las bases de datos
$arr_db = [];

// capturo los codigos de los estudiantes
$codigos = json_decode($_POST['codigo'], True);

// variable booleana que almacena la semana final de cada periodo
$semana_final = false;
// semana intermedia
$semana_intermedia = false;

// si la semana es mayor a 0
// es decir si se selecciono una semana
if ($_POST["semana"] > 0) {
    // filtro la semana
    $semana = $_POST['semana'];

    //caracteristicas de las semana final 
    if ($semana == 8 || $semana == 16 || $semana == 24 || $semana == 32) {
        // semana final es valida
        $semana_final = true;
    }

    // semanas para semana intermedia
    if ($semana == 4 || $semana == 12 || $semana == 20 || $semana == 28) {
        $semana_intermedia = true;
    }
}

$obj_calificaciones = new Calificaciones();

// CICLO DE REPETICION POR ESTUDIANTES

// determinar  si un estudiante con una materia tiene algun registro en la 
// tabla c_$ano  a partir  de los codigos de los estudiantes almacenados
// en el array $codigos
for ($i = 0; count($codigos) > $i; $i++) {
    // si el estudiante tiene calificaciones
    if ($obj_calificaciones->get_calificacion_alumno_materia($codigos[$i]['value'], $id_materia, $ano)) {

        // si es semana final
        if ($semana_final) {
            // si el estudiante tiene calificaciones
            // se agregan al array de entrada
            $arr_actualizar[] = [
                'id_alumno' => $codigos[$i]['value'],
                'id_materia' => $id_materia,
                'id_docente' => $id_docente,
                "'" . $semana . "E'" => $E[$i]['value'],
                "'" . $semana . "F'" => $F[$i]['value'],
                "'" . $semana . "G'" => $G[$i]['value'],
                "'" . $semana . "I'" => $I[$i]['value'],
                "'" . $semana . "J'" => $J[$i]['value']
            ];
        } elseif ($semana_intermedia) {
            // si el estudiante tiene calificaciones
            // se agregan al array de entrada
            $arr_actualizar[] = [
                'id_alumno' => $codigos[$i]['value'],
                'id_materia' => $id_materia,
                'id_docente' => $id_docente,
                "'" . $semana . "A'" => $A[$i]['value'],
                "'" . $semana . "B'" => $B[$i]['value'],
                "'" . $semana . "C'" => $C[$i]['value'],
                "'" . $semana . "D'" => $D[$i]['value'],
                "'" . $semana . "E'" => $E[$i]['value'],
                "'" . $semana . "F'" => $F[$i]['value'],
                "'" . $semana . "G'" => $G[$i]['value'],
                "'" . $semana . "H'" => $H[$i]['value']
            ];
        } else {
            // si el estudiante tiene calificaciones
            // se agregan al array de entrada
            $arr_actualizar[] = [
                'id_alumno' => $codigos[$i]['value'],
                'id_materia' => $id_materia,
                'id_docente' => $id_docente,
                "'" . $semana . "A'" => $A[$i]['value'],
                "'" . $semana . "B'" => $B[$i]['value'],
                "'" . $semana . "C'" => $C[$i]['value'],
                "'" . $semana . "D'" => $D[$i]['value'],
                "'" . $semana . "E'" => $E[$i]['value'],
                "'" . $semana . "F'" => $F[$i]['value'],
                "'" . $semana . "G'" => $G[$i]['value']
            ];
        }
    } else {
        // si el estudiante no tiene calificaciones
        // se agregan al array de insertar $arr_insertar
        
        $arr_insertar[] = [
            'id_alumno' => $codigos[$i]['value'],
            'id_materia' => $id_materia,
            'id_docente' => $id_docente,
            "'" . $semana . "A'" => $A[$i]['value'],
            "'" . $semana . "B'" => $B[$i]['value'],
            "'" . $semana . "C'" => $C[$i]['value'],
            "'" . $semana . "D'" => $D[$i]['value'],
            "'" . $semana . "E'" => $E[$i]['value'],
            "'" . $semana . "F'" => $F[$i]['value'],
            "'" . $semana . "G'" => $G[$i]['value'],
            "'" . $semana . "H'" => $H[$i]['value'],
            "'" . $semana . "I'" => $I[$i]['value'],
            "'" . $semana . "J'" => $J[$i]['value']
        ];
    }
}


// 1. Iniciamos la conexión una sola vez
$cal = new calificaciones();

//$faltas = json_decode($_POST['faltas'], True);

// Validaciones iniciales
if ($ano > 2015 && $semana > 0 && $id_materia > 0) {

    // valores 
    $valores = [];
    // calificaciones obtenidas
    $arr_db = $cal->get_calificacion_semanal_bulk($id_a, $id_m, $id_s, $y, $id_p);

    // por cada elemento en el array de entrada 
    foreach ($arr_entrada as $e => $entrada) {


        // realizao la comparacion de notas
        $encontrado = false;

        // por cada elemento en la base de datos
        // de una materia
        foreach ($arr_db as $d => $db) {
            // si se cumplen estos criteros
            // alumno, materia, ponderado, semana, periodo
            if (
                $db['id_alumno'] == $entrada['id_alumno']
                && $db['id_materia'] == $entrada['id_materia']
                && $db['id_ponderado'] == $entrada['id_ponderado']
                && $db['id_semana'] == $entrada['semana']
                && $db['periodo'] == $entrada['periodo']
            ) {

                // si encuento el dato 
                $encontrado = true;


                // si la nota es diferente a la de la base de datos
                if ((float) $db['nota'] != (float) $entrada['nota'] or (int) $db['id_logro'] != (int) $entrada['id_logro']) {
                    // actualizo la nota
                    $arr_actualizar[] = [
                        'id' => $db['id'],
                        'id_alumno' => $entrada['id_alumno'],
                        'id_materia' => $entrada['id_materia'],
                        'id_docente' => $entrada['id_docente'],
                        'semana' => $entrada['semana'],
                        'periodo' => $entrada['periodo'],
                        'ano' => $entrada['ano'],
                        'nota' => $entrada['nota'],
                        'id_ponderado' => $entrada['id_ponderado'],
                        'id_logro' => $entrada['id_logro']
                    ];
                }
                break;
            }
        }

        if (!$encontrado) {
            // inserto la nota preparando el array notas
            $arr_insertar[] = [
                'id_alumno' => $entrada['id_alumno'],
                'id_materia' => $entrada['id_materia'],
                'id_docente' => $entrada['id_docente'],
                'semana' => $entrada['semana'],
                'periodo' => $entrada['periodo'],
                'ano' => $entrada['ano'],
                'nota' => $entrada['nota'],
                'id_ponderado' => $entrada['id_ponderado'],
                'id_logro' => $entrada['id_logro']
            ];
        }


        // if ($id_materia == 20) {

        //     // condiciones iniciales del valor encontrado
        //     $encontrado = false;

        //     foreach ($arr_db as $d => $db) {
        //         if ($db['id_alumno'] == $entrada['id_alumno'] && $db['id_materia'] == $entrada['id_materia'] && $db['id_semana'] == $entrada['semana'] && $db['periodo'] == $entrada['periodo']) {
        //             $encontrado = true;
        //             if ($db['nota'] != $entrada['nota'] || $db['id_logro'] != $entrada['id_logro']) {
        //                 $arr_actualizar[] = [
        //                     'id' => $db['id'],
        //                     'id_alumno' => $entrada['id_alumno'],
        //                     'id_materia' => $entrada['id_materia'],
        //                     'id_docente' => $entrada['id_docente'],
        //                     'semana' => $entrada['semana'],
        //                     'periodo' => $entrada['periodo'],
        //                     'ano' => $entrada['ano'],
        //                     'nota' => $entrada['nota'],
        //                     'id_ponderado' => 20,
        //                     'id_logro' => $entrada['id_logro'],
        //                 ];
        //             }
        //             break;
        //         }
        //     }

        //     if (!$encontrado) {
        //         $arr_insertar[] = [
        //             'id_alumno' => $entrada['id_alumno'],
        //             'id_materia' => $entrada['id_materia'],
        //             'id_docente' => $entrada['id_docente'],
        //             'semana' => $entrada['semana'],
        //             'periodo' => $entrada['periodo'],
        //             'ano' => $entrada['ano'],
        //             'nota' => $entrada['nota'],
        //             'id_ponderado' => 20,
        //             'id_logro' => $entrada['id_logro'],
        //         ];
        //     }
        // } 
        // // si se cumplen estos criteros
        //         // alumno, materia, ponderado, semana, periodo
        // elseif ($db['id_alumno'] == $entrada['id_alumno'] && $db['id_materia'] == $entrada['id_materia'] && $db['id_ponderado'] == $entrada['id_ponderado'] && $db['id_semana'] == $entrada['semana'] && $db['periodo'] == $entrada['periodo']) {

        //             // si encuento el dato 
        //             $encontrado = true;



        //             // si la nota es diferente a la de la base de datos
        //             if ($db['nota'] != $entrada['nota']) {
        //                 // actualizo la nota
        //                 $arr_actualizar[] = [
        //                     'id' => $db['id'],
        //                     'id_alumno' => $entrada['id_alumno'],
        //                     'id_materia' => $entrada['id_materia'],
        //                     'id_docente' => $entrada['id_docente'],
        //                     'semana' => $entrada['semana'],
        //                     'periodo' => $entrada['periodo'],
        //                     'ano' => $entrada['ano'],
        //                     'nota' => $entrada['nota'],
        //                     'id_ponderado' => $entrada['id_ponderado'],
        //                     'id_logro' => 'NULL',
        //                 ];
        //             }
        //             break;
        //         }
        //     }

        //     if (!$encontrado) {
        //         // inserto la nota preparando el array notas
        //         $arr_insertar[] = [
        //             'id_alumno' => $entrada['id_alumno'],
        //             'id_materia' => $entrada['id_materia'],
        //             'id_docente' => $entrada['id_docente'],
        //             'semana' => $entrada['semana'],
        //             'periodo' => $entrada['periodo'],
        //             'ano' => $entrada['ano'],
        //             'nota' => $entrada['nota'],
        //             'id_ponderado' => $entrada['id_ponderado'],
        //             'id_logro' => 'NULL',
        //         ];
        //     }
        // }

        // else {

        //     //en caso de que se trate del logro de la materia
        //     // realizao la comparacion de notas
        //     $encontrado = false;

        //     // por cada elemento en la base de datos
        //     foreach ($arr_db as $d => $db) {
        //         // si se cumplen estos criteros
        //         // alumno, materia, ponderado, semana, periodo
        //         if ($db['id_alumno'] == $entrada['id_alumno'] && $db['id_materia'] == $entrada['id_materia'] && $db['periodo'] == $entrada['periodo'] && is_null($db['id_ponderado'])) {

        //             // si encuento el dato 
        //             $encontrado = true;



        //             // si la nota es diferente a la de la base de datos
        //             if ($db['id_logro'] != $entrada['id_logro']) {
        //                 // actualizo la nota
        //                 $arr_actualizar[] = [
        //                     'id' => $db['id'],
        //                     'id_alumno' => $entrada['id_alumno'],
        //                     'id_materia' => $entrada['id_materia'],
        //                     'id_docente' => $entrada['id_docente'],
        //                     'semana' => '',
        //                     'periodo' => $entrada['periodo'],
        //                     'ano' => $entrada['ano'],
        //                     'nota' => '',
        //                     'id_ponderado' => '',
        //                     'id_logro' => $entrada['id_logro'],
        //                 ];
        //             }
        //             break;
        //         }
        //     }

        //     if (!$encontrado) {
        //         // inserto la nota preparando el array notas
        //         $arr_insertar[] = [
        //             'id_alumno' => $entrada['id_alumno'],
        //             'id_materia' => $entrada['id_materia'],
        //             'id_docente' => $entrada['id_docente'],
        //             'semana' => $entrada['semana'],
        //             'periodo' => $entrada['periodo'],
        //             'ano' => $entrada['ano'],
        //             'nota' => $entrada['nota'],
        //             'id_ponderado' => '',
        //             'id_logro' => $entrada['id_logro'],
        //         ];
        //     }
        // }


    }

    if (count($arr_actualizar) > 0) {
        $cal->actualizarNotasMasivas($arr_actualizar, $ano);
    }

    if (count($arr_insertar) > 0) {
        $cal->insertarNotasMasivas($arr_insertar, $ano);
    }

    // retorno los conteos para mostrar en el mensaje del cliente
    echo json_encode([
        'actualizadas' => count($arr_actualizar),
        'insertadas' => count($arr_insertar)
    ]);
}
