<?php

///////////////////////////////////////////////////////////////////////////////
//  Archivo que muestra, en una matriz semana a semana, el avance de las     //
//  calificaciones registradas por los docentes en un periodo academico.     //
//                                                                           //
//  Reemplaza a notas_docentes_semanales.php y se adapta al nuevo modelo de   //
//  la tabla de calificaciones: de calificaciones_{year} (un registro por    //
//  nota) a c_{year} (un registro por alumno/materia con una columna por     //
//  cada nota, nombrada  <numero de semana><letra del ponderado> ).          //
//                                                                           //
//  Las clases asignadas a cada docente se leen de matricula_docente.        //
//                                                                           //
//  Periodos:  P1 -> semanas  1 a  8     P2 -> semanas  9 a 16               //
//             P3 -> semanas 17 a 24     P4 -> semanas 25 a 32               //
//                                                                           //
//  Parametros de entrada (POST):                                            //
//      years       año lectivo                                              //
//      periodo     periodo academico (1 a 4)                                //
//      id_docente  opcional, filtra las clases de un solo docente           //
//                                                                           //
//  Respuesta (JSON):                                                        //
//      status = 1   ok, la matriz viene en la llave html                    //
//      status = 21  el periodo no es valido                                 //
//      status = 22  el año no es valido                                     //
//      status = 23  el docente no tiene clases asignadas en el año          //
//      status = 24  no existe la tabla de calificaciones del año            //
///////////////////////////////////////////////////////////////////////////////

header('Content-Type: application/json; charset=utf-8');

require_once('datos.php');

// ---------------------------------------------------------------------------
// Parametros de entrada
// ---------------------------------------------------------------------------

// año lectivo (sufijo de la tabla c_{year})
$ano = isset($_POST['years']) ? (int) $_POST['years'] : 0;
// periodo academico (1 a 4)
$periodo = isset($_POST['periodo']) ? (int) $_POST['periodo'] : 0;
// docente a filtrar, 0 (o ausente) muestra todos los docentes
$id_docente = isset($_POST['id_docente']) ? (int) $_POST['id_docente'] : 0;

// array de respuesta
$respuesta = array();

// ---------------------------------------------------------------------------
// Validacion de los parametros
// ---------------------------------------------------------------------------

// valido que el periodo sea correcto (el año lectivo tiene cuatro periodos)
if ($periodo < 1 || $periodo > 4) {
    $respuesta['status'] = 21;
    echo json_encode($respuesta);
    exit;
}

// valido que el año sea correcto
if ($ano < 2015 || $ano > 2040) {
    $respuesta['status'] = 22;
    echo json_encode($respuesta);
    exit;
}

// genero una instancia de calificaciones
$calificacion = new calificaciones();

// valido que exista la tabla de calificaciones del año
if (empty($calificacion->get_columnas_c($ano))) {
    $respuesta['status'] = 24;
    echo json_encode($respuesta);
    exit;
}

// ---------------------------------------------------------------------------
// Datos del periodo
// ---------------------------------------------------------------------------

// semanas que componen el periodo: el primero va de la 1 a la 8,
// el segundo de la 9 a la 16 y asi hasta el cuarto periodo
$semana_inicial = (($periodo - 1) * 8) + 1;
$semana_final = $semana_inicial + 7;
$semanas = range($semana_inicial, $semana_final);

// avance de cada clase asignada en matricula_docente
$clases = $calificacion->get_avance_periodo($ano, $periodo, $id_docente);

// si el docente indicado no tiene clases asignadas en el año
if ($id_docente > 0 && empty($clases)) {
    $respuesta['status'] = 23;
    echo json_encode($respuesta);
    exit;
}

// ordeno las clases por docente, grado y materia
usort($clases, function ($a, $b) {
    $cmp = strcasecmp($a['docente'], $b['docente']);
    if ($cmp !== 0) {
        return $cmp;
    }
    $cmp = strcasecmp($a['grado'], $b['grado']);
    if ($cmp !== 0) {
        return $cmp;
    }
    return strcasecmp($a['materia'], $b['materia']);
});

// agrupo las clases por docente conservando el orden
$por_docente = array();
foreach ($clases as $c) {
    $por_docente[$c['id_docente']]['docente'] = $c['docente'];
    $por_docente[$c['id_docente']]['clases'][] = $c;
}

// fechas de cada semana del periodo, para el encabezado de la matriz
$sem = new semana();
$fechas = $sem->get_fechas_semanas($ano, $semana_inicial, $semana_final);

// ---------------------------------------------------------------------------
// Funciones de presentacion
// ---------------------------------------------------------------------------

/**
 * Retorna la clase css del semaforo de acuerdo al avance.
 *
 * @param float $porcentaje Avance de 0 a 100.
 * @return string Nombre de la clase css.
 */
function color_avance($porcentaje)
{
    if ($porcentaje >= 100) {
        return 'mp-full';
    }
    if ($porcentaje >= 70) {
        return 'mp-alto';
    }
    if ($porcentaje > 0) {
        return 'mp-medio';
    }
    return 'mp-cero';
}

/**
 * Dibuja la celda de una semana con el avance de las calificaciones.
 *
 * @param int    $registradas Notas efectivamente consignadas.
 * @param int    $esperadas   Notas que se deben consignar.
 * @param string $extra       Clases css adicionales de la celda.
 * @return string Celda html.
 */
function celda_avance($registradas, $esperadas, $extra = '')
{
    // la semana no se evalua en esta clase
    if ($esperadas <= 0) {
        return '<td class="mp-na ' . $extra . '" title="No se evalua en esta semana">&mdash;</td>';
    }

    // limito el avance al 100% para que ninguna clase lo supere
    if ($registradas > $esperadas) {
        $registradas = $esperadas;
    }

    // el porcentaje de avance de la semana
    $porcentaje = (100 * $registradas) / $esperadas;

    return '<td class="mp-celda ' . color_avance($porcentaje) . ' ' . $extra . '"'
        . ' title="' . $registradas . ' de ' . $esperadas . ' notas">'
        . number_format($porcentaje, 0) . '%'
        . '<span class="mp-detalle">' . $registradas . '/' . $esperadas . '</span>'
        . '</td>';
}

// ---------------------------------------------------------------------------
// Construccion de la matriz
// ---------------------------------------------------------------------------

// estilos propios de la matriz, independientes del tema de la pagina
$html = '<style>
.mp-wrap{overflow-x:auto;}
.mp-tabla{width:100%;border-collapse:collapse;font-size:.78rem;}
.mp-tabla th,.mp-tabla td{border:1px solid #dee2e6;padding:.25rem .4rem;text-align:center;vertical-align:middle;}
.mp-tabla thead th{background:#f1f3f5;position:sticky;top:0;z-index:2;white-space:nowrap;}
.mp-tabla th.mp-izq,.mp-tabla td.mp-izq{text-align:left;white-space:nowrap;}
.mp-tabla tr.mp-resumen td{background:#e9ecef;font-weight:600;}
.mp-celda{font-weight:600;}
.mp-detalle{display:block;font-size:.62rem;font-weight:400;opacity:.75;}
.mp-full{background:#198754;color:#fff;}
.mp-alto{background:#a3cfbb;color:#0f5132;}
.mp-medio{background:#ffe69c;color:#664d03;}
.mp-cero{background:#f8d7da;color:#842029;}
.mp-na{background:#f8f9fa;color:#adb5bd;}
.mp-periodo{border-left:2px solid #adb5bd;}
.mp-leyenda{font-size:.72rem;margin:.5rem 0;}
.mp-leyenda span{display:inline-block;padding:.1rem .45rem;margin-right:.35rem;border-radius:.2rem;}
</style>';

$html .= '<h4>Avance de calificaciones &middot; Periodo ' . $periodo
    . ' (semanas ' . $semana_inicial . ' a ' . $semana_final . ') &middot; ' . $ano . '</h4>';

$html .= '<div class="mp-leyenda">'
    . '<span class="mp-full">100%</span>'
    . '<span class="mp-alto">70% o mas</span>'
    . '<span class="mp-medio">parcial</span>'
    . '<span class="mp-cero">sin notas</span>'
    . '<span class="mp-na">no se evalua</span>'
    . '</div>';

// encabezado de la matriz: una columna por cada semana del periodo
$html .= '<div class="mp-wrap"><table class="mp-tabla"><thead><tr>';
$html .= '<th class="mp-izq">Docente</th>';
$html .= '<th class="mp-izq">Clase</th>';
$html .= '<th>Est.</th>';

foreach ($semanas as $s) {
    $titulo = !is_null($fechas[$s]['inicio'])
        ? 'Del ' . $fechas[$s]['inicio'] . ' al ' . $fechas[$s]['fin']
        : 'Semana sin fechas definidas';
    $html .= '<th title="' . $titulo . '">S' . $s . '</th>';
}

$html .= '<th class="mp-periodo">Periodo</th></tr></thead><tbody>';

// acumuladores de la fila de totales
$tot_general = array();
foreach ($semanas as $s) {
    $tot_general[$s] = array('r' => 0, 'e' => 0);
}
$tot_general_periodo = array('r' => 0, 'e' => 0);

// si no hay clases asignadas en el año
if (empty($por_docente)) {
    $html .= '<tr><td class="mp-izq" colspan="' . (count($semanas) + 4) . '">'
        . 'No hay clases registradas en matricula_docente para ' . $ano . '.</td></tr>';
}

foreach ($por_docente as $d) {

    // acumuladores del docente
    $tot_doc = array();
    foreach ($semanas as $s) {
        $tot_doc[$s] = array('r' => 0, 'e' => 0);
    }
    $tot_doc_periodo = array('r' => 0, 'e' => 0);

    // filas de detalle de las clases del docente, se arman primero para poder
    // mostrar el resumen del docente por encima de ellas
    $filas = '';

    foreach ($d['clases'] as $c) {

        $filas .= '<tr>';
        $filas .= '<td class="mp-izq"></td>';
        $filas .= '<td class="mp-izq">'
            . htmlspecialchars($c['grado'] . '-' . $c['curso'] . ' ' . $c['jornada'], ENT_QUOTES, 'UTF-8')
            . ' &middot; ' . htmlspecialchars($c['materia'], ENT_QUOTES, 'UTF-8')
            . '</td>';
        $filas .= '<td>' . $c['alumnos'] . '</td>';

        // avance de la clase en todo el periodo
        $clase_r = 0;
        $clase_e = 0;

        foreach ($semanas as $s) {

            // notas que el docente debe consignar en la semana
            $esperadas = $c['alumnos'] * $c['esperado_alumno'][$s];
            // notas efectivamente consignadas en la semana
            $registradas = $c['semanas'][$s];

            $filas .= celda_avance($registradas, $esperadas);

            // acumulo los totales sin superar lo esperado
            $sumar = $registradas > $esperadas ? $esperadas : $registradas;

            $clase_r += $sumar;
            $clase_e += $esperadas;

            $tot_doc[$s]['r'] += $sumar;
            $tot_doc[$s]['e'] += $esperadas;
            $tot_general[$s]['r'] += $sumar;
            $tot_general[$s]['e'] += $esperadas;
        }

        // total del periodo para la clase
        $filas .= celda_avance($clase_r, $clase_e, 'mp-periodo');
        $filas .= '</tr>';

        $tot_doc_periodo['r'] += $clase_r;
        $tot_doc_periodo['e'] += $clase_e;
    }

    $tot_general_periodo['r'] += $tot_doc_periodo['r'];
    $tot_general_periodo['e'] += $tot_doc_periodo['e'];

    // fila resumen del docente
    $html .= '<tr class="mp-resumen">';
    $html .= '<td class="mp-izq">' . htmlspecialchars(ucwords(strtolower($d['docente'])), ENT_QUOTES, 'UTF-8') . '</td>';
    $html .= '<td class="mp-izq">' . count($d['clases']) . ' clase(s)</td>';
    $html .= '<td></td>';
    foreach ($semanas as $s) {
        $html .= celda_avance($tot_doc[$s]['r'], $tot_doc[$s]['e']);
    }
    $html .= celda_avance($tot_doc_periodo['r'], $tot_doc_periodo['e'], 'mp-periodo');
    $html .= '</tr>';

    // detalle de las clases del docente
    $html .= $filas;
}

// fila de totales de la institucion
if (!empty($por_docente)) {
    $html .= '<tr class="mp-resumen">';
    $html .= '<td class="mp-izq">TOTAL</td>';
    $html .= '<td class="mp-izq">' . count($clases) . ' clase(s)</td>';
    $html .= '<td></td>';
    foreach ($semanas as $s) {
        $html .= celda_avance($tot_general[$s]['r'], $tot_general[$s]['e']);
    }
    $html .= celda_avance($tot_general_periodo['r'], $tot_general_periodo['e'], 'mp-periodo');
    $html .= '</tr>';
}

$html .= '</tbody></table></div>';

// ---------------------------------------------------------------------------
// Respuesta
// ---------------------------------------------------------------------------

// cargo la respuesta
$respuesta['html'] = $html;
$respuesta['status'] = 1;

// retorno la matriz en formato json
echo json_encode($respuesta);
