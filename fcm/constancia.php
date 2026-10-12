<?php
ob_start();
// se inserta este fichero para generar el documento en pdf
// correspondiente a la constancia de matricula de un alumno
require('../fpdf/fpdf.php');
// se requiere este fichero para realizar la conexion con
// el gestor de bases de datos base de datos mysql
require_once 'datos.php';

///////////////////////////////////////////////////////////////
//                                                           //
//  ARCHIVO PARA GENERAR LA CONSTANCIA DE MATRICULA          //
//                                                           //
//  Las variables de ingreso son:                            //
//                                                           //
//  -  id_alumno : codigo del alumno (u_alumnos.id_alumnos)  //
//  -  year : año lectivo de la matricula (opcional), si no  //
//            se envia se toma la matricula mas reciente     //
//                                                           //
///////////////////////////////////////////////////////////////

$id_alumno = isset($_GET["id_alumno"]) ? (int) $_GET["id_alumno"] : 0;
$year = isset($_GET["year"]) ? (int) $_GET["year"] : 0;

if ($id_alumno === 0) {
    die("Error: Se requiere el código del alumno para generar la constancia.");
}

// creo el objeto con una instancia de matricula
$obj_matricula = new matricula();
// busco la matricula del alumno, la del año indicado
// o la mas reciente si no se indico el año
if ($year > 0) {
    $id_matricula = $obj_matricula->existe_matricula_alumno($id_alumno, $year);
} else {
    $id_matricula = $obj_matricula->get_ultima_matricula_alumno($id_alumno);
}

if ($id_matricula === 0) {
    die("Error: El alumno no tiene una matrícula registrada" . ($year > 0 ? " para el año $year." : "."));
}

// obtengo los datos de la matricula
$obj_matricula->get_matricula_id($id_matricula);

// obtengo los datos de la jornada
$obj_jornada = new jornada();
$obj_jornada->get_jornada_por_id($obj_matricula->id_jornada);

// creo el objeto de estudiante, el id_alumno de la matricula
// equivale a u_alumnos.id_alumnos que apunta a la tabla personas
$estudiante = new alumnos();
$estudiante->get_alumno_codigo($obj_matricula->id_alumno);

// registro la emision de la constancia y obtengo su numero
$obj_constancia = new constancias();
$num_constancia = $obj_constancia->registrar($obj_matricula->id_alumno, $obj_matricula->year);

if ($num_constancia === 0) {
    die("Error: No se pudo registrar la constancia.");
}

// Convierte texto UTF-8 a ISO-8859-1 para FPDF.
function enc($s)
{
    return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', (string) $s) ?: (string) $s;
}

// Da formato a una fecha YYYY-MM-DD como "31 de agosto de 2026"
function formatearFecha($fechaInput)
{
    $meses = [
        1 => 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio',
        'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
    ];
    $date = new DateTime($fechaInput);
    return $date->format('j') . " de " . $meses[(int) $date->format('n')] . " de " . $date->format('Y');
}

// Se establece el tipo de cabecera  que tendra el documento
class PDF extends FPDF
{
    //Cabecera de página
    function Header()
    {
        // se incerta el logo de la insticución
        $this->Image('../imagenes/logo_boletin.png', 17, 12.5, 60, 25);
        $this->Cell(90, 30, "", 1);
        $this->SetFont('Arial', 'B', 14);
        // Se crea una etiqueta con el titulo del documento
        $this->MultiCell(90, 10, enc("CONSTANCIA \n DE MATRÍCULA \n No. " . $GLOBALS["num_constancia"]), 1, 'C');
    }

    //Pie de página
    function Footer()
    {
        //Posición: a 1,5 cm del final
        $this->SetY(-15);
        //Arial 8
        $this->SetFont('Arial', '', 8);
        $txt = enc("Otros servicios: Programas Técnicos , Cursos cortos y Programas tecnológicos");
        $this->Cell(0, 5, $txt, 0, 0, 'C');
        $this->Ln(3);
        $txt = enc("Info:  Cel.3166288374, WhatsApp. 3164469532, Email:administrativo@imcreativo.edu.co,  www.imcreativo.edu.co ");
        $this->Cell(0, 5, $txt, 0, 0, 'C');
    }
}

// nombre completo del estudiante
$nombre_completo = mb_strtoupper(trim($estudiante->nombres . " " . $estudiante->apellidos), 'UTF-8');

// la fecha de la matricula solo se incluye si esta registrada
$tiene_fecha = !empty($obj_matricula->fecha) && $obj_matricula->fecha !== '0000-00-00';

// se crea un nuevo documento de PDF
$pdf = new PDF();
$pdf->SetMargins(15, 10, 15);
$pdf->AddPage();

$pdf->Ln(20);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, enc("EL INSTITUTO MUNDO CREATIVO"), 0, 1, 'C');
$pdf->Ln(4);
$pdf->Cell(0, 8, enc("HACE CONSTAR QUE:"), 0, 1, 'C');
$pdf->Ln(10);

// texto de la constancia
$texto = "El(la) estudiante " . $nombre_completo;
if (!empty($estudiante->identificacion)) {
    $texto .= ", con documento de identidad No. " . $estudiante->identificacion;
}
$texto .= ", se encuentra matriculado(a) en esta institución para el año lectivo " . $obj_matricula->year;
if (!empty($obj_matricula->grado)) {
    $texto .= ", en el grado " . $obj_matricula->grado;
}
if (!empty($obj_jornada->jornada)) {
    $texto .= ", jornada " . $obj_jornada->jornada;
}
$texto .= ".";

$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 8, enc($texto), 0, 'J');
$pdf->Ln(8);

// datos de la matricula
$datos = array(
    "Constancia No." => $num_constancia,
    "Código del estudiante" => $obj_matricula->id_alumno,
    "Nombre completo" => $nombre_completo,
    "Número de matrícula" => $obj_matricula->id,
    "Año lectivo" => $obj_matricula->year
);
if ($tiene_fecha) {
    $datos["Fecha de la matrícula"] = formatearFecha($obj_matricula->fecha);
}

foreach ($datos as $etiqueta => $valor) {
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(60, 8, enc($etiqueta), 1);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(120, 8, enc($valor), 1, 1);
}

$pdf->Ln(12);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 8, enc("La presente constancia se expide a solicitud del interesado el " . formatearFecha($obj_constancia->fecha) . "."), 0, 'J');

// firma
$pdf->Ln(30);
$pdf->Cell(0, 6, "_______________________________", 0, 1, 'C');
$pdf->Cell(0, 6, enc("Secretaría Académica"), 0, 1, 'C');

ob_end_clean();
$pdf->Output('I', 'constancia_matricula_' . $obj_matricula->id_alumno . '.pdf');
