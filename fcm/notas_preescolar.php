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
$L1 = json_decode($_POST['logro1'], True);
$L2 = json_decode($_POST['logro2'], True);
$L3 = json_decode($_POST['logro3'], True);
$N = json_decode($_POST['N'], True);

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
            'L1' => $L1[$index]['value'] ?? null,
            'L2' => $L2[$index]['value'] ?? null,
            'L3' => $L3[$index]['value'] ?? null,
            'N' => $N[$index]['value'] ?? null
        ];
    }
}
// variable booleana que almacena la semana final de cada periodo
$semana_final = false;
// semana intermedia
$semana_intermedia = false;



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

foreach ($datos_agrupados as $dato) {
    // Verificar si el alumno ya tiene registro y debe ser actualizado
    if (in_array($dato['codigo'], $codigos_actualizar)) {


        $fila_db = $db_notas[$dato['codigo']];
        $ha_cambiado = false;
        // son los campos a revisar del formulario de entrada
        //$campos_revisar = ['R' . strval($periodo), 'l1_p' . strval($periodo), 'l2_p' . strval($periodo), 'l3_p' . strval($periodo)];

        // campos a revisar del formulario de entrada
        $campos_revisar = ['N', 'L1', 'L2', 'L3' ];

        // relacion entre las letras y los datos de la tabla
        $letra_columna = array('N'=>'R' . strval($periodo),
                               'L1' => 'l1_p' . strval($periodo),
                               'L2'=>  'l2_p' . strval($periodo),
                               'L3' =>  'l3_p' . strval($periodo));


        foreach ($campos_revisar as $letra) {
            // recupero el valor de la columna de la tabla
            // de calificaciones
            $columna = $letra_columna[$letra];

            // filtro la nota enviada
            $nota_enviada = (isset($dato[$letra]) && trim($dato[$letra]) !== '') ? (float) $dato[$letra] : null;

            // nota consignada en la base de datos
            $nota_db = (isset($fila_db[$columna]) && !is_null($fila_db[$columna])) ? (float) $fila_db[$columna] : null;

            // comparacion de notas
            if ($nota_enviada !== $nota_db) {
                $ha_cambiado = true;
                break;
            }
        }

        // si ha cambiado el valor
        if ($ha_cambiado) {
            $arr_actualizar[] = [
                'id_alumno' => $dato['codigo'],
                'id_materia' => $id_materia,
                'docente' => $id_docente,
                "'R" . $periodo . "'" => $dato['N'],
                "'l1_p" . $periodo . "'" => $dato['L1'],
                "'l2_p" . $periodo . "'" => $dato['L2'],
                "'l3_p" . $periodo . "'" => $dato['L3']
            ];
        }

    } elseif (in_array($dato['codigo'], $codigos_agregar)) {
        $arr_insertar[] = [
            'id_alumno' => $dato['codigo'],
            'id_materia' => $id_materia,
            'docente' => $id_docente,
            "'R" . $periodo . "'" => $dato['N'],
            "'l1_p" . $periodo . "'" => $dato['L1'],
            "'l2_p" . $periodo . "'" => $dato['L2'],
            "'l3_p" . $periodo . "'" => $dato['L3']
        ];

    }
}


// si se trata de la semana intermedia



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
