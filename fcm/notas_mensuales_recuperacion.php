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
$R = json_decode($_POST['R'], True);
$L = json_decode($_POST['L'], True);

// array para actualizar notas
// la recuperacion solo actualiza filas ya existentes,
// nunca inserta registros nuevos
$arr_actualizar = [];
// array entrada de los datos que viene del formulario
$arr_entrada = [];
//array de notas de las bases de datos
$arr_db = [];

// capturo los codigos de los estudiantes
$codigos = json_decode($_POST['codigo'], True);

// Agrupar las variables en un solo array donde cada variable es una columna
$datos_agrupados = [];

// si se han ingresado los codigos
if (is_array($codigos)) {

    foreach ($codigos as $index => $c) {
        $datos_agrupados[] = [
            'codigo' => $c['value'] ?? null,
            // nombro las llaves igual que las columnas de la tabla c_{año}
            // para poder cotejarlas directamente contra la base de datos
            'R' . $periodo => $R[$index]['value'] ?? null,
            'l1_p' . $periodo => $L[$index]['value'] ?? null,
        ];
    }
}

// array de etiquetas 
$arr_ponderado = array(1 => "L", 2 => "l1_p" . $periodo);


// creo un objeto  calificaciones
$obj_calificaciones = new Calificaciones();

// se debe establecer si el alumno tiene
// una nota para esta semana
$filas_actualizar = $obj_calificaciones->validacion_masiva($codigos, $id_materia, $ano);

// Extraemos la información completa de la base de datos para comparar
$db_notas = [];

// si array 
if (is_array($filas_actualizar)) {
    foreach ($filas_actualizar as $fila) {
        $db_notas[$fila['id_alumno']] = $fila;
    }
}

// Extraemos solo el campo 'id_alumno' del resultado de la base de datos
$codigos_actualizar = array_keys($db_notas);

// los alumnos que no tienen fila en c_$ano para esta materia
// simplemente se ignoran: la recuperacion no crea registros

// para las semanas normales
foreach ($datos_agrupados as $dato) {

    // si los codigos a actualizar que son los que estan
    // en la base de datos se encuentran dentro de  datos agrupados
    if (in_array($dato['codigo'], $codigos_actualizar)) {
        //  si las materias son diferentes a disciplina

        $fila_db = $db_notas[$dato['codigo']];
        $ha_cambiado = false;
        // campos a revisar
        $campos_revisar = ['R' . $periodo, 'l1_p' . $periodo];

        // en este caso R para la nota de recuperacion o l1_p para el logro
        foreach ($campos_revisar as $letra) {
            // nota
            $nota_enviada = (isset($dato[$letra]) && trim($dato[$letra]) !== '') ? (float) $dato[$letra] : null;
            $nota_db = (isset($fila_db[$letra]) && !is_null($fila_db[$letra])) ? (float) $fila_db[$letra] : null;
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
                'l1_p' . $periodo => $dato['l1_p' . $periodo],
                'R' . $periodo => $dato['R' . $periodo]
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

// retorno el conteo para mostrar en el mensaje del cliente
echo json_encode([
    'actualizadas' => count($arr_actualizar)
]);
