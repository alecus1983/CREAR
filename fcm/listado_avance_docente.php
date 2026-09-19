<?php

///////////////////////////////////////////////////////////////////////////////
//  Archivo que muestra el listado de los docentes matriculados en un año    //
//  lectivo, para consultar desde ahi el avance de notas de cada uno.        //
//                                                                          //
//  El panel que se entrega tiene un selector de docentes y una tabla con    //
//  los docentes que tienen clases asignadas en matricula_docente. Desde     //
//  cualquiera de los dos se invoca avance_periodo(), que dibuja la matriz   //
//  semana a semana en el contenedor #tabla (notas_docentes_periodo.php).    //
//                                                                          //
//  Parametros de entrada (POST):                                           //
//      years   año lectivo                                                  //
//                                                                          //
//  Respuesta (JSON):                                                       //
//      status = 1   ok, el panel viene en la llave html                    //
//      status = 22  el año no es valido                                    //
//      status = 23  no hay docentes matriculados en el año                 //
///////////////////////////////////////////////////////////////////////////////

header('Content-Type: application/json; charset=utf-8');

require_once("datos.php");

// ---------------------------------------------------------------------------
// Parametros de entrada
// ---------------------------------------------------------------------------

// año lectivo a consultar
$ano = isset($_POST['years']) ? (int) $_POST['years'] : 0;

// array de respuesta
$respuesta = array();

// ---------------------------------------------------------------------------
// Validacion de los parametros
// ---------------------------------------------------------------------------

// valido que el año sea correcto
if ($ano < 2015 || $ano > 2040) {
    $respuesta['status'] = 22;
    $respuesta['html'] = "";
    echo json_encode($respuesta);
    exit;
}

// ---------------------------------------------------------------------------
// Datos
// ---------------------------------------------------------------------------

// objeto matricula docente
$md = new matricula_docente();

// listado de los docentes con clases asignadas en el año
$docentes = $md->get_docentes_year($ano);

// si ningun docente tiene clases asignadas en el año
if (empty($docentes)) {
    $respuesta['status'] = 23;
    $respuesta['html'] = "";
    echo json_encode($respuesta);
    exit;
}

// ---------------------------------------------------------------------------
// Presentacion
// ---------------------------------------------------------------------------

/**
 * Arma el nombre completo del docente con la primera letra en mayuscula.
 *
 * @param array $d Registro del docente.
 * @return string Nombre completo presentable.
 */
function nombre_docente($d)
{
    return ucwords(strtolower($d['nombres'] . " " . $d['apellidos']));
}

// encabezado del panel
$html = "<div class='col-md-12'>";
$html .= "<p>Docentes con clases asignadas durante el año lectivo <b>" . $ano . "</b>: <b>"
    . count($docentes) . "</b></p>";

// fila con el selector de docente y el boton de consulta
$html .= "<div class='row align-items-center mb-3'>";
$html .= "<div class='col-md-6'>";
$html .= "<div class='form-floating'>";
$html .= "<select id='id_docente_av' class='form-select'>";
// la opcion vacia consulta el avance de todos los docentes
$html .= "<option value='0'>Todos los docentes</option>";

// una opcion por cada docente matriculado
foreach ($docentes as $id => $d) {
    $html .= "<option value='" . $id . "'>" . htmlspecialchars(nombre_docente($d)) . "</option>";
}

$html .= "</select>";
$html .= "<label for='id_docente_av'>Docente</label>";
$html .= "</div>";
$html .= "</div>";
$html .= "<div class='col-md-3'>";
$html .= "<button type='button' class='btn btn-outline-success' onclick='avance_periodo();'>Ver avance</button>";
$html .= "</div>";
$html .= "</div>";

// tabla con el detalle de los docentes matriculados
$html .= "<div class='table-responsive'>";
$html .= "<table class='table table-sm table-hover'>";
$html .= "<thead>";
$html .= "<tr>";
$html .= "<th scope='col'>#</th>";
$html .= "<th scope='col'>Identificación</th>";
$html .= "<th scope='col'>Docente</th>";
$html .= "<th scope='col'>Usuario</th>";
$html .= "<th scope='col'>Clases</th>";
$html .= "<th scope='col'>Avance</th>";
$html .= "</tr>";
$html .= "</thead>";
$html .= "<tbody>";

// contador de filas
$fila = 0;

// por cada docente matriculado en el año
foreach ($docentes as $id => $d) {

    $fila++;

    $html .= "<tr>";
    $html .= "<td>" . $fila . "</td>";
    $html .= "<td>" . htmlspecialchars($d['identificacion']) . "</td>";
    $html .= "<td>" . htmlspecialchars(nombre_docente($d)) . "</td>";
    $html .= "<td>" . htmlspecialchars($d['login']) . "</td>";
    $html .= "<td>" . $d['clases'] . "</td>";
    $html .= "<td>";
    // consulta el avance de un solo docente
    $html .= "<button type='button' class='btn btn-sm btn-outline-primary'"
        . " onclick='ver_avance_docente(" . $id . ");'>Ver</button>";
    $html .= "</td>";
    $html .= "</tr>";
}

$html .= "</tbody>";
$html .= "</table>";
$html .= "</div>";
$html .= "</div>";

// ---------------------------------------------------------------------------
// Respuesta
// ---------------------------------------------------------------------------

$respuesta['html'] = $html;
$respuesta['status'] = 1;

echo json_encode($respuesta);
