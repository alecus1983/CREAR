<?php
// ============================================================
//  BOLETIN DE CALIFICACIONES  -  FORMATO PREESCOLAR
//  (grados con formato_boletin = 1 : Parvulos, Jardin, Transición)
//
//  Version adaptada del esquema procedimental (consultas directas
//  con mysqli sobre calificaciones_{year}) al esquema de objetos
//  definido en datos.php y a la tabla de notas c_{year}.
//
//  En el nuevo esquema las notas de preescolar se guardan asi:
//     R{periodo}     -> nota de la dimension en el periodo
//     l1_p{periodo}  -> primer logro  (id de la tabla logros)
//     l2_p{periodo}  -> segundo logro (id de la tabla logros)
//     l3_p{periodo}  -> tercer logro  (id de la tabla logros)
//     D_p{periodo}   -> valoracion del comportamiento (materia 20)
// ============================================================

require('../tfpdf/tfpdf.php');
require_once 'datos.php';

// parametros que envia js/ajax.js -> obtener_pdf()
// se castean a entero para no corromper el nombre de la tabla c_{year}
$year = intval($_GET["year"]);
$id_periodo = intval($_GET["periodos"]);
$id_grado = intval($_GET["id_gs"]);

// define el tipo de codificación para la letra
header("Content-Type: text/html;charset=utf-8");

// Se establece el tipo de cabecera  que tendra el documento
class PDF extends tFPDF
{
    //Cabecera de página
    function Header()
    {
        // se incerta el logo de la insticución
        $this->Image('../imagenes/logo_boletin.png', 17, 12.5, 60, 25);
        $this->Cell(90, 30, "", 1);
        $this->SetFont('Arial', '', 16);
        // Se crea una etiqueta con el logo de la institución
        $this->MultiCell(90, 15, enc("BOLETIN DE CALIFICACIONES \n PERIODO " . intval($_GET["periodos"])), 1, 'C');
    }

    //Pie de página
    function Footer()
    {
        //Posición: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial', '', 8);
        //Número de página
        $txt = enc("Otros servicios: Programas Técnicos , Cursos cortos y Programas tecnológicos (Convenio con Tecnológica Autónoma del Pacífico)");
        $this->Cell(0, 5, $txt, 0, 0, 'C');
        $this->Ln(3);
        $txt = enc("Info: Tel 829 5741, Cel.3166288374, WhatsApp. 3164469532, Email:imcreativo@hotmail.com,  www.imcreativo.edu.co ");
        $this->Cell(0, 5, $txt, 0, 0, 'C');
    }
}

/**
 * Convierte un string UTF-8 a ISO-8859-1 para que FPDF muestre
 * correctamente tildes, ñ y demás caracteres especiales.
 * Los caracteres sin equivalente en Latin-1 se transliteran (//TRANSLIT).
 */
function enc(string $s): string
{
    return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $s) ?: $s;
}

// se crea un nuevo documento de PDF
$pdf = new PDF();

// ------------------------------------------------------------
// 1. Datos del grado
// ------------------------------------------------------------

// creo un nuevo elemento grado
$gr = new grados();
// obtengo las caracteristicas del grado
$gr->get_grado_id($id_grado);
// nombre corto del grado (Parvulos, Jardin, Transición ...)
$nivel = $gr->grado;

// ------------------------------------------------------------
// 2. Listado de estudiantes matriculados en el grado
//    Este boletin solo recibe año, periodo y grado, por lo que
//    se filtran las matriculas del año por el grado solicitado
//    (cada matricula trae su jornada y curso).
// ------------------------------------------------------------

$mt = new matricula();

// matriculas del grado en el año lectivo
$matriculas = array();
foreach ($mt->get_matricula_ano($year) as $m) {
    if (intval($m['id_grado']) === $id_grado) {
        array_push($matriculas, $m);
    }
}

// si el grado no tiene estudiantes matriculados no hay boletin que generar
if (count($matriculas) == 0) {
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Ln(15);
    $pdf->Cell(180, 10, enc("No hay estudiantes matriculados en " . $nivel . " para el año " . $year), 0, 0, 'C');
    $pdf->Output();
    exit;
}

// listado plano con los codigos de los estudiantes
$list = array_column($matriculas, 'id_alumno');
// cadena de codigos para las consultas masivas ( IN (...) )
$in_alumnos = implode(',', array_map('intval', $list));

// ------------------------------------------------------------
// 3. Datos de los estudiantes en una sola consulta
// ------------------------------------------------------------
$alumnos_cache = alumnos::get_alumnos_bulk($list);

// ------------------------------------------------------------
// 4. Materias (dimensiones) que cursa el grado
// ------------------------------------------------------------

// areas a las que pertenecen las materias del grado
$area_obj = new area();
$lista_a = $area_obj->get_areas_grado($id_grado);

// objeto materia para recuperar nombre y logo de cada dimension
$m_obj = new materia();

// $materias[$id_materia] = ['materia' => nombre, 'logo' => imagen]
$materias = array();

foreach ($lista_a as $id_area => $a) {
    foreach ($m_obj->get_materias_por_grado_area($id_grado, $id_area) as $id_m => $nombre_m) {
        // cargo los atributos de la materia (necesito el logo)
        $m_obj->get_materia($id_m);
        $materias[$id_m] = array(
            'materia' => $m_obj->materia,
            'logo' => $m_obj->logo
        );
    }
}

// se ordenan por nombre de materia, como en la version anterior
uasort($materias, function ($x, $y) {
    return strcmp($x['materia'], $y['materia']);
});

// ------------------------------------------------------------
// 5. Docentes asignados al grado (uno por materia)
//    Se cachean por jornada/curso porque un mismo grado puede
//    tener estudiantes en jornadas distintas.
// ------------------------------------------------------------

$md = new matricula_docente();
// $docentes_cache["jornada-curso"][$id_materia] = ['nombres'=>..,'apellidos'=>..]
$docentes_cache = array();
// $jornadas_cache[$id_jornada] = nombre de la jornada
$jornadas_cache = array();

$jo = new jornada();

foreach ($matriculas as $m) {

    $id_jornada = intval($m['id_jornada']);
    $id_curso = intval($m['id_curso']);
    $clave = $id_jornada . "-" . $id_curso;

    // docentes del grupo
    if (!array_key_exists($clave, $docentes_cache)) {
        $docentes_cache[$clave] = $md->get_docentes_grado($id_grado, $id_jornada, $id_curso, $year);
    }

    // nombre de la jornada
    if (!array_key_exists($id_jornada, $jornadas_cache)) {
        $jo->get_jornada_por_id($id_jornada);
        $jornadas_cache[$id_jornada] = $jo->jornada;
    }
}

// ------------------------------------------------------------
// 6. Notas y logros del periodo, una consulta por materia
// ------------------------------------------------------------

$cl = new calificaciones();
$lo = new logro();

// columnas de preescolar que se leen de c_{year}
$arr_pond_preescolar = array(1 => "R", 2 => "l1_p", 3 => "l2_p", 4 => "l3_p");

// la valoracion del comportamiento (materia 20 - Disciplina) se guarda en
// la columna D_p{periodo}; la tabla no tiene columna D_p4, de modo que en
// el cuarto periodo se toma la nota consignada en R4.
$col_disciplina = ($id_periodo < 4) ? "D_p" . $id_periodo : "R" . $id_periodo;
$arr_pond_disciplina = ($id_periodo < 4)
    ? array(1 => "R", 2 => "l1_p", 3 => "l2_p", 4 => "l3_p", 5 => "D_p")
    : $arr_pond_preescolar;

// $notas_cache[$id_materia][$id_alumno] = fila con las columnas del periodo
$notas_cache = array();
// $logros_cache[$id_materia][$id_logro] = texto del logro
$logros_cache = array();

foreach ($materias as $id_m => $info_m) {

    // la disciplina requiere ademas la columna D_p{periodo}
    $pond = ($id_m == 20) ? $arr_pond_disciplina : $arr_pond_preescolar;

    $notas_cache[$id_m] = $cl->get_notas_preescolar($year, $id_m, $id_periodo, $pond, $in_alumnos);
    // texto de todos los logros definidos para la materia
    $logros_cache[$id_m] = $lo->get_logros($id_m);
}

// ------------------------------------------------------------
// 7. ESTRUCTURA DE REPETICION POR CADA ESTUDIANTE
// ------------------------------------------------------------

foreach ($matriculas as $m) {

    // codigo del estudiante
    $e = intval($m['id_alumno']);
    // datos del estudiante tomados del cache
    $estudiante = $alumnos_cache[$e] ?? array('nombres' => '', 'apellidos' => '');
    // docentes del grupo al que pertenece el estudiante
    $docentes = $docentes_cache[intval($m['id_jornada']) . "-" . intval($m['id_curso'])] ?? array();
    // nombre de la jornada
    $nombre_jornada = $jornadas_cache[intval($m['id_jornada'])] ?? "";

    // ENCABEZADO DE CELDAS	//////////////////////////////

    $pdf->AddPage();
    $pdf->Ln(5);
    $pdf->SetFillColor(172, 172, 172);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 5, enc('No'), 1, 0, 'C', true);
    $pdf->Cell(80, 5, enc('NOMBRE DEL ESTUDIANTE'), 1, 0, 'C', true);
    $pdf->Cell(25, 5, enc('GRADO'), 1, 0, 'C', true);
    $pdf->Cell(25, 5, enc('JORNADA'), 1, 0, 'C', true);
    $pdf->Cell(30, 5, enc('AÑO LECTIVO'), 1, 0, 'C', true);
    $pdf->Ln();
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(20, 5, $e, 1, 0, 'C');
    $pdf->Cell(80, 5, enc(strtoupper($estudiante['nombres'] . " " . $estudiante['apellidos'])), 1, 0, 'C');
    $pdf->Cell(25, 5, enc($nivel), 1, 0, 'C');
    $pdf->Cell(25, 5, enc($nombre_jornada), 1, 0, 'C');
    $pdf->Cell(30, 5, $year, 1, 0, 'C');
    $pdf->Ln(15);

    // POR CADA DIMENSION QUE CURSA EL ESTUDIANTE

    foreach ($materias as $id_m => $info_m) {

        // la disciplina se imprime aparte, al final del boletin
        if ($id_m == 20) {
            continue;
        }

        // fila de notas del estudiante en la materia
        $fila = $notas_cache[$id_m][$e] ?? array();

        // nota de la dimension en el periodo
        $nota_m = $fila["R" . $id_periodo] ?? null;
        $nota_m = is_null($nota_m) ? "--" : number_format($nota_m, 1);

        // docente que dicta la dimension
        $docente = $docentes[$id_m] ?? array('nombres' => '', 'apellidos' => '');

        // logo de la dimension
        $logo = $info_m['logo'];

        // encabezado de la dimension
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(70, 7, enc($info_m['materia']), 1, 0, 'L');
        $pdf->Cell(60, 7, enc("Prof: " . $docente['nombres'] . " " . $docente['apellidos']), 1, 0, 'L');
        $pdf->Cell(50, 7, enc("Nota: " . $nota_m), 1, 0, 'L');
        $pdf->Ln(7);

        // posicion del cuadro de la imagen
        $x1 = $pdf->GetX();
        $y1 = $pdf->GetY();
        // Crea un cuadro de texto para la dimension indicada
        $pdf->Cell(70, 45, "", 1, 0, 'L');

        if ($logo != "" && file_exists('../imagenes/' . $logo)) {
            // se crea una imagen para la dimension indicada
            $pdf->Image('../imagenes/' . $logo, $x1 + 2, $y1 + 2, 66, 41);
        }

        // cuadro donde se listan los logros del periodo
        $x2 = $pdf->GetX();
        $y2 = $pdf->GetY();
        $pdf->Cell(110, 45, "", 1, 0, 'L');
        $pdf->SetXY($x2, $y2);

        // variable para incertar texto en el multicell
        $texto = "";

        // los tres logros del periodo: l1_p{p}, l2_p{p}, l3_p{p}
        for ($l = 1; $l <= 3; $l++) {

            // id del logro consignado para el estudiante
            $id_logro = $fila["l" . $l . "_p" . $id_periodo] ?? null;

            // si tiene logro asignado recupero su descripcion
            if (!is_null($id_logro) && intval($id_logro) > 0) {
                $descripcion = $logros_cache[$id_m][intval($id_logro)] ?? "";
                if ($descripcion != "") {
                    $texto = $texto . "- " . $descripcion . "\n";
                }
            }
        }

        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(110, 6, enc($texto), 0, 'L', false);
        $pdf->SetXY($x2, $y2);
        $pdf->Ln(45);
    }

    // VALORACION DEL COMPORTAMIENTO (materia 20 - Disciplina)

    $nota_d = $notas_cache[20][$e][$col_disciplina] ?? null;
    $nota_d = is_null($nota_d) ? "" : number_format($nota_d, 1);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(70, 10, enc('Valoración del Comportamiento'), 1, 0, 'L');
    $pdf->Cell(110, 10, $nota_d, 1, 0, 'C');

    // OBSERVACIONES DEL ESTUDIANTE

    $pdf->Ln(15);
    $pdf->Cell(180, 5, enc("Observaciones : "), 0, 0, 'L');

    $pdf->Ln(5);
    $pdf->Cell(180, 5, enc("__________________________________________________________________________"), 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(180, 5, enc("__________________________________________________________________________"), 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(180, 5, enc("__________________________________________________________________________"), 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(180, 5, enc("__________________________________________________________________________"), 0, 0, 'L');
    $pdf->Ln(5);
    $pdf->Cell(180, 5, enc("__________________________________________________________________________"), 0, 0, 'L');
    $pdf->Cell(180, 20, '', 0, 0, 'L');
    $pdf->Ln(25);
    $pdf->Cell(180, 5, enc("    ________________________          _________________________"), 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->Cell(180, 5, enc("           Rectora                                       Directora de Grupo"), 0, 0, 'C');
}

// se envia el documento al navegador
$pdf->Output();
