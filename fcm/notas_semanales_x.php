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
        $arr_pond_final = array(1 => "F", 2 => "G", 3 => "I", 4 => "J");
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


$codigos_actualizar = $obj_calificaciones->validacion_masiva($codigos, $id_materia, $ano);
// Extraemos solo el campo 'id_alumno' del resultado de la base de datos
$codigos_actualizar = array_column((array)$codigos_actualizar, 'id_alumno');



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
            $arr_actualizar[] = [
                'id_alumno' => $dato['codigo'],
                'id_materia' => $id_materia,
                'id_docente' => $id_docente,
                "'" . $semana . "E'" => $dato['E'],
                "'" . $semana . "F'" => $dato['F'],
                "'" . $semana . "G'" => $dato['G'],
                "'" . $semana . "I'" => $dato['I'],
                "'" . $semana . "J'" => $dato['J']
            ];
        } elseif (in_array($dato['codigo'], $codigos_agregar)) {
            $arr_insertar[] = [
                'id_alumno' => $dato['codigo'],
                'id_materia' => $id_materia,
                'id_docente' => $id_docente,
                "'" . $semana . "E'" => $dato['E'],
                "'" . $semana . "F'" => $dato['F'],
                "'" . $semana . "G'" => $dato['G'],
                "'" . $semana . "I'" => $dato['I'],
                "'" . $semana . "J'" => $dato['J']
            ];
        }
    }
} elseif ($semana_intermedia) {
    foreach ($datos_agrupados as $dato) {
        if (in_array($dato['codigo'], $codigos_actualizar)) {
            $arr_actualizar[] = [
                'id_alumno' => $dato['codigo'],
                'id_materia' => $id_materia,
                'id_docente' => $id_docente,
                "'" . $semana . "A'" => $dato['A'],
                "'" . $semana . "B'" => $dato['B'],
                "'" . $semana . "C'" => $dato['C'],
                "'" . $semana . "D'" => $dato['D'],
                "'" . $semana . "E'" => $dato['E'],
                "'" . $semana . "F'" => $dato['F'],
                "'" . $semana . "G'" => $dato['G'],
                "'" . $semana . "H'" => $dato['H']
            ];
        } elseif (in_array($dato['codigo'], $codigos_agregar)) {
            $arr_insertar[] = [
                'id_alumno' => $dato['codigo'],
                'id_materia' => $id_materia,
                'id_docente' => $id_docente,
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
} else {
    foreach ($datos_agrupados as $dato) {
        if (in_array($dato['codigo'], $codigos_actualizar)) {
            $arr_actualizar[] = [
                'id_alumno' => $dato['codigo'],
                'id_materia' => $id_materia,
                'id_docente' => $id_docente,
                "'" . $semana . "A'" => $dato['A'],
                "'" . $semana . "B'" => $dato['B'],
                "'" . $semana . "C'" => $dato['C'],
                "'" . $semana . "D'" => $dato['D'],
                "'" . $semana . "E'" => $dato['E'],
                "'" . $semana . "F'" => $dato['F'],
                "'" . $semana . "G'" => $dato['G']
            ];
        } elseif (in_array($dato['codigo'], $codigos_agregar)) {
            $arr_insertar[] = [
                'id_alumno' => $dato['codigo'],
                'id_materia' => $id_materia,
                'id_docente' => $id_docente,
                "'" . $semana . "A'" => $dato['A'],
                "'" . $semana . "B'" => $dato['B'],
                "'" . $semana . "C'" => $dato['C'],
                "'" . $semana . "D'" => $dato['D'],
                "'" . $semana . "E'" => $dato['E'],
                "'" . $semana . "F'" => $dato['F'],
                "'" . $semana . "G'" => $dato['G']
            ];
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




?>