<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

///////////////////////////////////////////////////////////////
//                                                           //
//  ARCHIVO PARA GENERAR EL CERTIFICADO DE CALIFICACIONES    //
//                                                           //
//  Las notas se calculan igual que en generar_p.php         //
//  tomando el periodo como el cuarto periodo, es decir,     //
//  la nota de cada materia es el acumulado de los cuatro    //
//  periodos y en el certificado solo se muestran las        //
//  calificaciones de las areas.                             //
//                                                           //
//  Variables de ingreso (GET), una de dos opciones:         //
//                                                           //
//  -  matricula : codigo de la matricula de un estudiante   //
//                                                           //
//  o bien para todo un grupo:                               //
//                                                           //
//  -  year : año lectivo                                    //
//  -  grado : codigo del grado                              //
//  -  jornada : codigo de la jornada                        //
//  -  curso : codigo del curso                              //
//                                                           //
///////////////////////////////////////////////////////////////

// se inserta este fichero para generar el documento en pdf
require('../fpdf/fpdf.php');
// se requiere este fichero para realizar la conexion con
// el gestor de bases de datos base de datos mysql
require_once 'datos.php';

// el codigo de la matricula
$id_matricula = isset($_GET["matricula"]) ? (int) $_GET["matricula"] : 0;

// el certificado se computa como el cuarto periodo
$id_periodo = 4;

// array de los ponderados (igual que en generar_p.php)
$arr_ponderados = array(
    "A" => 2.5,
    "B" => 1.7,
    "C" => 1.7,
    "D" => 1.7,
    "E" => 1,
    "F" => 1,
    "G" => 1,
    "H" => 8,
    "I" => 9.5,
    "J" => 5.3
);

// columnas que se califican en cada una de las 8 semanas del periodo
$columnas_semana = array(
    1 => array("A", "B", "C", "D", "E", "F", "G"),
    2 => array("A", "B", "C", "D", "E", "F", "G"),
    3 => array("A", "B", "C", "D", "E", "F", "G"),
    4 => array("A", "B", "C", "D", "E", "F", "G", "H"),
    5 => array("B", "C", "D", "E", "F", "G"),
    6 => array("A", "B", "C", "D", "E", "F", "G"),
    7 => array("A", "B", "C", "D", "E", "F", "G"),
    8 => array("E", "F", "G", "I", "J")
);

function floor_decimals($numero, $precision = 1)
{
    $factor = pow(10, $precision);
    return floor($numero * $factor) / $factor;
}

// lista de matriculas a certificar
// [ id_alumno => id_matricula ]
$lista_matriculas = array();

if ($id_matricula > 0) {
    // certificado de un solo estudiante
    $obj_matricula = new matricula();
    $obj_matricula->get_matricula_id($id_matricula);

    if (empty($obj_matricula->id_alumno)) {
        die("Error: No se encontró la matrícula solicitada.");
    }

    $year = (int) $obj_matricula->year;
    $id_grado = (int) $obj_matricula->id_grado;
    $id_jornada = (int) $obj_matricula->id_jornada;
    $lista_matriculas[$obj_matricula->id_alumno] = $obj_matricula->id;
} elseif (isset($_GET["year"], $_GET["grado"], $_GET["jornada"], $_GET["curso"])) {
    // certificados de todo el grupo
    $year = (int) $_GET["year"];
    $id_grado = (int) $_GET["grado"];
    $id_jornada = (int) $_GET["jornada"];
    $id_curso = (int) $_GET["curso"];

    $mt = new matricula();
    $mt->year = $year;
    $mt->id_grado = $id_grado;
    $mt->id_jornada = $id_jornada;
    $mt->id_curso = $id_curso;

    foreach ($mt->get_matriculas_grado_jornada() as $m) {
        $lista_matriculas[$m["id_alumno"]] = $m["id"];
    }

    if (empty($lista_matriculas)) {
        die("Error: No hay estudiantes matriculados en el grupo seleccionado.");
    }
} else {
    die("Error: Se requiere de una matrícula o de un grupo para generar el certificado.");
}

// listado de estudiantes
$list = array_keys($lista_matriculas);

// datos del grado
$obj_grado = new grados();
$obj_grado->get_grado_id($id_grado);
// nombre del grado
$nivel = $obj_grado->nombre_g;
// recupero la escolaridad del grado
$escolaridad = $obj_grado->escolaridad;

// -------------------------------------------------------------------
// 1. Cargar áreas y materias del grado una sola vez
// -------------------------------------------------------------------
$areaObj = new area();
$lista_a = $areaObj->get_areas_grado($id_grado);  // [ id_area => [nombre, cantidad] ]

$materiaObj = new materia();
$materias_con_area = [];   // id_materia => id_area
$materias_por_area = [];   // id_area => [id_materia => nombre_materia]
// intensidad horaria de cada area
$arr_ih = [];

foreach ($lista_a as $id_area => $area_data) {
    $lista_m = $materiaObj->get_materias_por_grado_area($id_grado, $id_area);
    $materias_por_area[$id_area] = $lista_m;
    $arr_ih[$id_area] = 0;
    foreach ($lista_m as $id_materia => $nombre_materia) {
        $materias_con_area[$id_materia] = $id_area;
        // aumento la intensidad horaria del area
        $materiaObj->get_materia($id_materia);
        $arr_ih[$id_area] += (int) $materiaObj->ih;
    }
}

// -------------------------------------------------------------------
// 2. Cargar todas las notas y recuperaciones en una sola consulta
// -------------------------------------------------------------------
$notax = new calificaciones();
$tab_calificaciones = $notax->get_notas_bulk($list, $materias_con_area, $year);

// nota de cada estudiante por materia y periodo (con recuperacion)
// $notas[id_alumno][id_area][id_materia][periodo]
$notas = [];

foreach ($tab_calificaciones as $em) {
    $id_materia = intval($em["id_materia"]);
    $id_area = $materias_con_area[$id_materia] ?? null;
    if ($id_area === null) {
        continue;
    }

    for ($p = 1; $p <= 4; $p++) {

        if ($id_materia === 20) {
            // la materia disciplina tiene una sola nota
            // por periodo almacenada en las columnas D_p1 ... D_p4
            $nota = floatval($em["D_p" . $p] ?? 0);
        } else {
            // se calcula la cantidad base a sumar a la semana
            // del periodo 1 para desplazarla a los otros periodos
            $base = 8 * ($p - 1);
            $nota = 0;
            foreach ($columnas_semana as $semana => $columnas) {
                foreach ($columnas as $col) {
                    $nota += floatval($em[strval($base + $semana) . $col] ?? 0) * $arr_ponderados[$col];
                }
            }
            $nota = $nota / 100;
        }

        // si tiene una recuperacion mayor que cero se remplaza la nota
        $rec = floatval($em["R" . $p] ?? 0);
        if ($rec > 0) {
            $nota = $rec;
        }

        $notas[$em["id_alumno"]][$id_area][$id_materia][$p] = $nota;
    }
}

/**
 * Retorna la valoracion cualitativa de una nota y define
 * el color de fondo de la celda en el pdf.
 */
function valoracion($pdf, $nota)
{
    if ($nota >= 4.8) {
        $pdf->SetFillColor(0, 200, 0);
        return "Superior";
    } elseif ($nota >= 4.1) {
        $pdf->SetFillColor(0, 204, 255);
        return "Alto";
    } elseif ($nota >= 3) {
        $pdf->SetFillColor(255, 230, 0);
        return "Básico";
    }
    $pdf->SetFillColor(255, 0, 0);
    return "Bajo";
}

/**
 * Convierte un string UTF-8 a ISO-8859-1 para FPDF.
 */
function enc($s)
{
    return mb_convert_encoding($s, 'ISO-8859-1', 'UTF-8');
}

// Se establece el tipo de cabecera  que tendra el documento
class PDF extends FPDF
{
    //Cabecera de pagina
    function Header()
    {
        // se incerta el logo de la insticucion
        $this->Image('../imagenes/escudo_colegio.png', 20, 12.5, 25, 30);
        $this->Image('../imagenes/fondo_escudo.png', 20, 50, 165, 220);
        $this->Cell(20, 15, "", 0);
        $this->SetFont('Times', 'BI', 20);
        // Se crea una etiqueta con el logo de la institucion
        $this->Cell(150, 15, "INSTITUTO MUNDO CREATIVO ", 0, 0, 'C');
        $this->Ln(15);
        $this->SetFont('Times', 'I', 8);
        $this->Cell(20, 5, "", 0);
        $this->Cell(150, 5, enc("Resolución de Aprobación No 5216-06-2009 del 19 de Junio de 2009 "), 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(20, 5, "", 0);
        $this->Cell(150, 5, enc("Preescolar, Educación Básica Ciclo Primaria y Secundaria y Edicación Media "), 0, 0, 'C');
    }

    //Pie de pagina
    function Footer()
    {
        //Posicion: a 1,5 cm del final
        $this->SetY(-15);
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 5, enc("Otros servicios: Programas Técnicos , Cursos cortos y "), 0, 0, 'C');
        $this->Ln(3);
        $txt = "Info: Tel 829 602 8443640, Cel.3166288374, WhatsApp. 3164469532, Email:administrativo@imcreativo.edu.co,  www.imcreativo.edu.co ";
        $this->Cell(0, 5, $txt, 0, 0, 'C');
    }
}

// fecha de expedicion en español
$dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
$meses = [1 => 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
$dia_nombre = $dias[(int) date("w")];
$dia_num = date("j");
$mes = $meses[(int) date("n")];
$anio = date("Y");

// se crea un nuevo documento de PDF
$pdf = new PDF();

$estudiante = new alumnos();

///////////////////////////////////////////////////////////////
//                                                           //
//   IMPRESION DE CERTIFICADOS                               //
//                                                           //
///////////////////////////////////////////////////////////////

// para cada estudiante imprimo un certificado en una pagina nueva
foreach ($list as $e) {

    $estudiante->get_alumno_codigo($e);

    // promedio de cada area para el estudiante
    $promedio = [];
    // areas perdidas (nota del area inferior a 3, sin contar convivencia)
    $a_perdidas = 0;
    // cantidad de areas
    $num_areas = 0;

    foreach ($lista_a as $id_area => $area_data) {
        // acumulado del area
        $p_a = 0;
        // cantidad de materias del area
        $c_m = 0;

        foreach ($materias_por_area[$id_area] as $id_materia => $nombre_materia) {
            // acumulado de la materia en el cuarto periodo:
            // promedio de los cuatro periodos
            $ac = 0;
            for ($p = 1; $p <= 4; $p++) {
                $ac += $notas[$e][$id_area][$id_materia][$p] ?? 0;
            }
            $ac = $ac / 4;

            $p_a += $ac;
            $c_m++;
        }

        // promedio de area del estudiante
        $promedio[$id_area] = $c_m > 0 ? $p_a / $c_m : 0;

        // el area se pierde si su nota es inferior a tres
        if ($promedio[$id_area] < 3 and $id_area !== 12) {
            $a_perdidas++;
        }

        // si el area es diferente de convivencia
        if ($id_area !== 12) {
            $num_areas++;
        }
    }

    // agrego una nueva pagina al pdf
    $pdf->AddPage();
    $pdf->Ln(20);
    $pdf->SetFont('Arial', '', 10, false);
    $pdf->Write(5, enc("La suscrita directora del "));
    $pdf->SetFont('Arial', 'B', 10, false);
    $pdf->Write(5, enc("INSTITUTO MUNDO CREATIVO "));
    $pdf->SetFont('Arial', '', 10, false);
    $pdf->Write(5, enc(" aprobado según Resolución No: 5216-06-2009 del 19 de junio de 2009 expedida por la Secretaría de Educación Departamental del Cauca, para los niveles de Preescolar, Educación Básica Ciclo Primaria y Secundaria, y Educación Media, establecimiento de naturaleza privada y de carácter   mixto ubicado en Santander de Quilichao, Cauca."));

    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10, false);
    $pdf->Cell(180, 20, enc("CERTIFICA QUE:"), 0, 0, 'C', false);
    $pdf->Ln(20);

    $pdf->SetFont('Arial', 'B', 10, false);
    $pdf->Write(5, enc(mb_strtoupper($estudiante->nombres . " " . $estudiante->apellidos)));
    $pdf->SetFont('Arial', '', 10, false);

    // mismo criterio que generar_p.php:
    // 0 areas perdidas aprobó, 1 o 2 aplazado, 3 o mas reprobó
    if ($a_perdidas == 0) {
        // el estudiante es aprobado y promovido al siguiente grado
        $pdf->Write(5, enc(" en calidad de estudiante  curso y aprobó  en éste establecimiento educativo el grado $nivel de $escolaridad durante el periodo lectivo " . $year . " obteniendo las siguientes calificaciones: "));
    } elseif ($a_perdidas < 3) {
        // si ha perdido una o dos areas su estado es aplazado
        $pdf->Write(5, enc(" en calidad de estudiante curso y "));
        $pdf->SetFont('Arial', 'B', 10, false);
        $pdf->Write(5, enc(" está aplazado "));
        $pdf->SetFont('Arial', '', 10, false);
        $pdf->Write(5, enc(" en este establecimiento educativo  el  grado $nivel  durante el año lectivo " . $year . ", siendo aplazado con las siguientes calificaciones: "));
    } else {
        // si ha perdido tres o mas areas es reprobado
        $pdf->Write(5, enc(" en calidad de estudiante curso y "));
        $pdf->SetFont('Arial', 'B', 10, false);
        $pdf->Write(5, enc(" reprobó "));
        $pdf->SetFont('Arial', '', 10, false);
        $pdf->Write(5, enc(" en este establecimiento educativo  el  grado $nivel  durante el año lectivo " . $year . ", con las siguientes calificaciones:  "));
    }

    $pdf->Ln(10);
    $pdf->SetFillColor(230, 230, 230);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(80, 10, enc("ÁREAS FUNDAMENTALES, OPTATIVAS Y ASIGNATURAS"), 1, 0, 'C', true);
    $pdf->Cell(20, 10, "I. H. S.", 1, 0, 'C', true);
    $pdf->Cell(80, 5, enc("VALORACIÓN DE DESEMPEÑO"), 1, 0, 'C', true);
    $pdf->Ln(5);
    $pdf->Cell(100, 5, "", 0, 0, 'C', false);
    $pdf->Cell(40, 5, "CUANTITATIVA", 1, 0, 'C', true);
    $pdf->Cell(40, 5, "CUALITATIVA", 1, 0, 'C', true);
    $pdf->Ln(5);


    /////////////////////////////////////////////////////
    //                                                 //
    //    TABLA DE NOTAS (solo areas)                  //
    //                                                 //
    /////////////////////////////////////////////////////

    foreach ($lista_a as $id_area => $area_dato) {
        if ($id_area !== 12) {
            $pdf->Cell(80, 5, enc($area_dato[0]), 1, 0, 'L', false);
            $pdf->Cell(20, 5, $arr_ih[$id_area], 1, 0, 'C', false);

            $abajo = floor_decimals($promedio[$id_area], 1);

            $pdf->Cell(40, 5, number_format($abajo, 1, '.', ''), 1, 0, 'C', false);
            $valor = valoracion($pdf, $promedio[$id_area]);
            $pdf->Cell(40, 5, enc($valor), 1, 0, 'C', true);
            $pdf->Ln(5);
        }
    }

    // convivencia (area 12)
    if (isset($promedio[12])) {
        $pdf->Cell(80, 5, enc("Convivencia"), 1, 0, 'L', false);
        $pdf->Cell(20, 5, "", 1, 0, 'C', false);
        $pdf->Cell(40, 5, number_format($promedio[12], 1, '.', ''), 1, 0, 'C', false);
        $valor = valoracion($pdf, $promedio[12]);
        $pdf->Cell(40, 5, enc($valor), 1, 0, 'C', true);
        $pdf->Ln(5);
    }

    $pdf->SetFillColor(255, 255, 255); // se restablece el color blanco
    $pdf->Cell(180, 5, enc("Número de áreas perdidas :" . $a_perdidas .  " de " . $num_areas), 1, 0, 'L', true);

    $pdf->SetFont('Arial', '', 10);
    $pdf->Ln(10);
    $pdf->Multicell(180, 5, enc("Para constancia se expide a solicitud del interesado, en el Municipio de Santander de Quilichao, Cauca, " . "el día $dia_nombre $dia_num del mes de $mes de $anio."), 0, 'L', false);

    $pdf->Ln(30);
    $pdf->Cell(180, 5, "_______________________________________________", 0, 0, 'C', false);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(180, 5, "LAURA MARCELA PALACIOS", 0, 0, 'C', false);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(180, 5, "Rectora", 0, 0, 'C', false);
}

// nombre del archivo
if (count($list) === 1) {
    $nombre = "certificado_" . $obj_grado->grado . "_" . strtolower($estudiante->nombres) . "_" . strtolower($estudiante->apellidos) . "_" . $list[0] . ".pdf";
} else {
    $nombre = "certificados_" . $obj_grado->grado . "_" . $year . ".pdf";
}

ob_end_clean();
$pdf->Output('I', $nombre);
