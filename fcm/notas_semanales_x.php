<?php
// archivo para insertar notas

require_once('datos.php');

// Parametros de entrada — se castean a int para evitar valores corruptos
// (p.ej. "20264" en lugar de "2026") que rompen el nombre de la tabla.
$ano = intval($_POST['year']);
$periodo = intval($_POST['periodo']);
$semana = intval($_POST['semana']);
$id_materia = intval($_POST['id_ms']);
$id_curso = intval($_POST['id_curso']);
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
// estas se actualizan cuando no
// existe un registro para el  alumno en esa
// materia
$arr_insertar = [];
// array para actualizar notas
// se actualiza si existe un registro para ese alumno
// en esa materia
$arr_actualizar = [];
// array entrada de los datos que viene del formulario
$arr_entrada = [];
//array de notas de las bases de datos
$arr_db = [];

//codigos a agregar
$codigos_agregar = [];

// capturo los codigos de los estudiantes
$codigos = json_decode($_POST['codigo'], True);

// Agrupar las variables en un solo array donde cada variable es una columna
$datos_agrupados = [];
if (is_array($codigos)) {
    foreach ($codigos as $index => $c) {
        $datos_agrupados[] = [
            'codigo' => $c['value'] ?? null,
            'A' => $A[$index]['value'] ?? null,
            'B' => $B[$index]['value'] ?? null,
            'C' => $C[$index]['value'] ?? null,
            'D' => $D[$index]['value'] ?? null,
            'E' => $E[$index]['value'] ?? null,
            'F' => $F[$index]['value'] ?? null,
            'G' => $G[$index]['value'] ?? null,
            'H' => $H[$index]['value'] ?? null,
            'I' => $I[$index]['value'] ?? null,
            'J' => $J[$index]['value'] ?? null,
            'L' => $L[$index]['value'] ?? null,
        ];
    }
}
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
        // ponderados de la semana final
        $arr_pond_final = array(1 => "E", 2 => "F", 3 => "G", 4 => "I", 5 => "J");
    }

    // semanas para semana intermedia
    elseif ($semana == 4 || $semana == 12 || $semana == 20 || $semana == 28) {
        $semana_intermedia = true;
        // ponderados de la semana intermedia
        $arr_pond_media = array(1 => "A", 2 => "B", 3 => "C", 4 => "D", 5 => "E", 6 => "F", 7 => "G", 8 => "H");
    } else {
        // ponderados de las semanas normales
        $arr_pond_normal = array(1 => "A", 2 => "B", 3 => "C", 4 => "D", 5 => "E", 6 => "F", 7 => "G");
    }
}


// creo un objeto  calificacionesx
$obj_calificaciones = new Calificaciones();

// se debe establecer si el alumno tiene
// una nota para esta semana


$filas_actualizar = $obj_calificaciones->validacion_masiva($codigos, $id_materia, $ano);

// Extraemos la información completa de la base de datos para comparar
$db_notas = [];
if (is_array($filas_actualizar)) {
    foreach ($filas_actualizar as $fila) {
        $db_notas[$fila['id_alumno']] = $fila;
    }
}

// Extraemos solo el campo 'id_alumno' del resultado de la base de datos
$codigos_actualizar = array_keys($db_notas);



// determino todos los estudiantes
// que hay que agregar, los cuales
// no se encuentran encuentan en
// arr_actualizar pero si en codigos

// Extraemos solo los IDs de los estudiantes enviados
$todos_los_codigos = array_column($codigos, 'value');

// Los códigos a agregar son la diferencia entre todos los códigos y los que ya existen
$codigos_agregar = array_values(array_diff($todos_los_codigos, $codigos_actualizar));

// si es semana final
if ($semana_final) {
    foreach ($datos_agrupados as $dato) {
        // Verificar si el alumno ya tiene registro y debe ser actualizado
        if (in_array($dato['codigo'], $codigos_actualizar)) {

            if ($id_materia !== 20) {
                $fila_db = $db_notas[$dato['codigo']];
                $ha_cambiado = false;

                $campos_revisar = ($id_materia !== 20) ? ['E', 'F', 'G', 'I', 'J', 'L'] : [strval($periodo)];

                foreach ($campos_revisar as $letra) {

                    
                    $columna = ($letra == 'L') ? 'l1_p'.$periodo : $semana.$letra;
                    $nota_enviada = (isset($dato[$letra]) && trim($dato[$letra]) !== '') ? (float) $dato[$letra] : null;
                    $nota_db = (isset($fila_db[$columna]) && !is_null($fila_db[$columna])) ? (float) $fila_db[$columna] : null;
                    
                    if ($nota_enviada !== $nota_db) {
                        $ha_cambiado = true;
                        break;
                    }
                }

                if ($ha_cambiado) {
                    $arr_actualizar[] = [
                        'id_alumno' => $dato['codigo'],
                        'id_materia' => $id_materia,
                        'docente' => $id_docente,
                        "'" . $semana . "E'" => $dato['E'],
                        "'" . $semana . "F'" => $dato['F'],
                        "'" . $semana . "G'" => $dato['G'],
                        "'" . $semana . "I'" => $dato['I'],
                        "'" . $semana . "J'" => $dato['J'],
                        "'l1_p" . $periodo . "'" => $dato['L']
                    ];
                }
            } else {
                // para actualizar disciplina en la semana final
                // en caso de actualiza la disciplina
                $fila_db = $db_notas[$dato['codigo']];
                $ha_cambiado = false;
                $campos_revisar = ['A'];
                // construyo los campos de la disciplina de la semana
                // los cuales comienzan con la letra D, seguido por el numero de la semana

                // columna de nota en la base de datos
                $columna_nota = "D_p" . $periodo;
                // columna de  logros en la base de datos
                $columna_logro = "l1_p" . strval($periodo);

                // nota enviada desde el formulario
                $nota_enviada = (isset($dato['A']) && trim($dato['A']) !== '') ? (float) $dato['A'] : null;
                // logro enviado desde el formulario
                $logro_enviado = (isset($dato['L']) && trim($dato['L']) !== '') ? (float) $dato['L'] : null;
                // nota desde la base de datos
                $nota_db = (isset($fila_db[$columna_nota]) && !is_null($fila_db[$columna_nota])) ? (float) $fila_db[$columna_nota] : null;
                // logro consignado en la base de datos
                $logro_db = (isset($fila_db[$columna_logro]) && !is_null($fila_db[$columna_logro])) ? (float) $fila_db[$columna_logro] : null;

                // validando las notas
                if ($nota_enviada !== $nota_db || $logro_enviado !== $logro_db) {
                    $ha_cambiado = true;
                }


                // si la nota de disciplina en la semana intermedia ha cambiado 
                if ($ha_cambiado) {
                    $arr_actualizar[] = [
                        'id_alumno' => $dato['codigo'],
                        'id_materia' => $id_materia,
                        'docente' => $id_docente,
                        "'D_p" . strval($periodo) . "'" => $dato['A'],
                        "l1_p" . strval($periodo) => $dato['L']
                    ];
                }
            }
        } elseif (in_array($dato['codigo'], $codigos_agregar)) {
            // si es de cualquier materia distinta de disciplina
            if ($id_materia !== 20) {
                $arr_insertar[] = [
                    'id_alumno' => $dato['codigo'],
                    'id_materia' => $id_materia,
                    'docente' => $id_docente,
                    "'" . $semana . "E'" => $dato['E'],
                    "'" . $semana . "F'" => $dato['F'],
                    "'" . $semana . "G'" => $dato['G'],
                    "'" . $semana . "I'" => $dato['I'],
                    "'" . $semana . "J'" => $dato['J'],
                    "'l1_p" . $periodo . "'" => $dato['L']
                ];
            } else {
                // si agrego disciplina en la semana final

                $arr_insertar[] = [
                    'id_alumno' => $dato['codigo'],
                    'id_materia' => $id_materia,
                    'docente' => $id_docente,
                    "D_p" . strval($periodo) => $dato['A'],
                    "l1_p" . strval($periodo) => $dato['L']
                ];
            }
        }
    }
}

// si se trata de la semana intermedia
elseif ($semana_intermedia) {

    // por cada dato proveniente de la pagina
    foreach ($datos_agrupados as $dato) {

        // si los  codigos   a actualizar estan entre los que provienen
        // de la base de datos.
        if (in_array($dato['codigo'], $codigos_actualizar)) {
            // si la materia no es disciplina  entonces ejecuta 
            // el siguiente flujo de instrucciones
            if ($id_materia !== 20) {
                $fila_db = $db_notas[$dato['codigo']];
                $ha_cambiado = false;
                $campos_revisar = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                foreach ($campos_revisar as $letra) {
                    $columna = $semana . $letra;
                    $nota_enviada = (isset($dato[$letra]) && trim($dato[$letra]) !== '') ? (float) $dato[$letra] : null;
                    $nota_db = (isset($fila_db[$columna]) && !is_null($fila_db[$columna])) ? (float) $fila_db[$columna] : null;
                    if ($nota_enviada !== $nota_db) {
                        $ha_cambiado = true;
                        break;
                    }
                }
                // si ha cambiado la nota de la materia se agrega al array de actualizar
                if ($ha_cambiado) {
                    $arr_actualizar[] = [
                        'id_alumno' => $dato['codigo'],
                        'id_materia' => $id_materia,
                        'docente' => $id_docente,
                        "'" . $semana . "A'" => $dato['A'],
                        "'" . $semana . "B'" => $dato['B'],
                        "'" . $semana . "C'" => $dato['C'],
                        "'" . $semana . "D'" => $dato['D'],
                        "'" . $semana . "E'" => $dato['E'],
                        "'" . $semana . "F'" => $dato['F'],
                        "'" . $semana . "G'" => $dato['G'],
                        "'" . $semana . "H'" => $dato['H']
                    ];
                }
            }
            // en cso de disciplina en la semana intermedia
            else {
                // en caso de actualiza la disciplina
                $fila_db = $db_notas[$dato['codigo']];
                $ha_cambiado = false;
                $campos_revisar = ['A'];
                // construyo los campos de la disciplina de la semana
                // los cuales comienzan con la letra D, seguido por el numero de la semana
                foreach ($campos_revisar as $letra) {
                    $columna = "D" . $semana;
                    $nota_enviada = (isset($dato[$letra]) && trim($dato[$letra]) !== '') ? (float) $dato[$letra] : null;
                    $nota_db = (isset($fila_db[$columna]) && !is_null($fila_db[$columna])) ? (float) $fila_db[$columna] : null;
                    if ($nota_enviada !== $nota_db) {
                        $ha_cambiado = true;
                        break;
                    }
                }

                // si la nota de disciplina en la semana intermedia ha cambiado 
                if ($ha_cambiado) {
                    $arr_actualizar[] = [
                        'id_alumno' => $dato['codigo'],
                        'id_materia' => $id_materia,
                        'docente' => $id_docente,
                        "'D" . $semana . "'" => $dato['A']
                    ];
                }
            }
        }

        // si no se encuentra registro para este alumno y hay que agregar la nota para
        // la semana intermedia.
        elseif (in_array($dato['codigo'], $codigos_agregar)) {
            // si la materia  es cualquiera diferente a disciplina
            if ($id_materia !== 20) {
                $arr_insertar[] = [
                    'id_alumno' => $dato['codigo'],
                    'id_materia' => $id_materia,
                    'docente' => $id_docente,
                    "'" . $semana . "A'" => $dato['A'],
                    "'" . $semana . "B'" => $dato['B'],
                    "'" . $semana . "C'" => $dato['C'],
                    "'" . $semana . "D'" => $dato['D'],
                    "'" . $semana . "E'" => $dato['E'],
                    "'" . $semana . "F'" => $dato['F'],
                    "'" . $semana . "G'" => $dato['G'],
                    "'" . $semana . "H'" => $dato['H']
                ];
            } else {

                // si la materia es disciplina agrego este
                // registro
                $arr_insertar[] = [
                    'id_alumno' => $dato['codigo'],
                    'id_materia' => $id_materia,
                    'docente' => $id_docente,
                    "'D" . $semana . "'" => $dato['A']
                ];
            }
        }
    }
} else {

    // para las semanas normales 
    foreach ($datos_agrupados as $dato) {

        // si los codigos a actualizar que son los que estan
        // en la base de datos se encuentran dentro de  datos agrupados
        if (in_array($dato['codigo'], $codigos_actualizar)) {
            //  si las materias son diferentes a disciplina
            if ($id_materia !== 20) {
                $fila_db = $db_notas[$dato['codigo']];
                $ha_cambiado = false;
                $campos_revisar = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
                foreach ($campos_revisar as $letra) {
                    $columna = $semana . $letra;
                    $nota_enviada = (isset($dato[$letra]) && trim($dato[$letra]) !== '') ? (float) $dato[$letra] : null;
                    $nota_db = (isset($fila_db[$columna]) && !is_null($fila_db[$columna])) ? (float) $fila_db[$columna] : null;
                    if ($nota_enviada !== $nota_db) {
                        $ha_cambiado = true;
                        break;
                    }
                }

                if ($ha_cambiado) {
                    $arr_actualizar[] = [
                        'id_alumno' => $dato['codigo'],
                        'id_materia' => $id_materia,
                        'docente' => $id_docente,
                        "'" . $semana . "A'" => $dato['A'],
                        "'" . $semana . "B'" => $dato['B'],
                        "'" . $semana . "C'" => $dato['C'],
                        "'" . $semana . "D'" => $dato['D'],
                        "'" . $semana . "E'" => $dato['E'],
                        "'" . $semana . "F'" => $dato['F'],
                        "'" . $semana . "G'" => $dato['G']
                    ];
                }
            } else {
                // en caso de actualiza la disciplina
                $fila_db = $db_notas[$dato['codigo']];
                $ha_cambiado = false;
                $campos_revisar = ['A'];

                foreach ($campos_revisar as $letra) {
                    $columna = "D" . $semana;
                    $nota_enviada = (isset($dato[$letra]) && trim($dato[$letra]) !== '') ? (float) $dato[$letra] : null;
                    $nota_db = (isset($fila_db[$columna]) && !is_null($fila_db[$columna])) ? (float) $fila_db[$columna] : null;
                    if ($nota_enviada !== $nota_db) {
                        $ha_cambiado = true;
                        break;
                    }
                }

                if ($ha_cambiado) {
                    $arr_actualizar[] = [
                        'id_alumno' => $dato['codigo'],
                        'id_materia' => $id_materia,
                        'docente' => $id_docente,
                        "'D" . $semana . "'" => $dato['A']
                    ];
                }
            }
        }

        // si hay registros nuevos que requieren ser agregados
        elseif (in_array($dato['codigo'], $codigos_agregar)) {
            if ($id_materia !== 20) {
                // si la materia no es disciplina agrego 
                // este registro
                $arr_insertar[] = [
                    'id_alumno' => $dato['codigo'],
                    'id_materia' => $id_materia,
                    'docente' => $id_docente,
                    "'" . $semana . "A'" => $dato['A'],
                    "'" . $semana . "B'" => $dato['B'],
                    "'" . $semana . "C'" => $dato['C'],
                    "'" . $semana . "D'" => $dato['D'],
                    "'" . $semana . "E'" => $dato['E'],
                    "'" . $semana . "F'" => $dato['F'],
                    "'" . $semana . "G'" => $dato['G']

                ];
            } else {
                // si la materia es disciplina agrego este
                // registro
                $arr_insertar[] = [
                    'id_alumno' => $dato['codigo'],
                    'id_materia' => $id_materia,
                    'docente' => $id_docente,
                    "'" . $semana . "A'" => $dato['A']
                ];
            }
        }
    }
}



// CICLO DE REPETICION POR ESTUDIANTES

// determinar  si un estudiante con una materia tiene algun registro en la 
// tabla c_$ano  a partir  de los codigos de los estudiantes almacenados
// en el array $codigos

if (count($arr_actualizar) > 0) {
    // metodo para actualiza notas masivas
    //tomando en cuenta el array de notas masivas
    $obj_calificaciones->actualizarNotasMasivas($arr_actualizar, $ano);
}

if (count($arr_insertar) > 0) {
    $obj_calificaciones->insertarNotasMasivas($arr_insertar, $ano);
}

// retorno los conteos para mostrar en el mensaje del cliente
echo json_encode([
    'actualizadas' => count($arr_actualizar),
    'insertadas' => count($arr_insertar)
]);
