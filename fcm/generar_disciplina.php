<?php
require('../tfpdf/tfpdf.php');
require_once 'datos.php';
// se crean las siguientes variables
// con obtenida a travez del formulario formulario_boletines

///////////////////////////////////////////////////////////////
//                                                           //
//  INFORME DE DISCIPLINA POR PERIODO                        //
//                                                           //
//  Reporta todos los estudiantes matriculados en el año     //
//  (cualquier grado y jornada) con disciplina menor que 3   //
//  en el periodo, ordenados por grado y jornada.            //
//                                                           //
//  Las variables de ingreso son:                            //
//                                                           //
//  -  year : corresponde al año lectivo                     //
//  -  periodos: codigo del periodo va del 1 al 4            //
//                                                           //
///////////////////////////////////////////////////////////////

$year = intval($_GET["year"]);           // año lectivo
$id_periodo = intval($_GET["periodos"]); // periodo del 1 al 4

// array de los ponderados
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

// se inserta este fichero para generar el documento en pdf

// define el tipo de codificación para la letra
header("Content-Type: text/html;charset=utf-8");
// CONEXION CON LA BASE DE DATOS
//$link = conectar();

//mysqli_query("SET NAMES 'utf8'");
// Se establece el tipo de cabecera  que tendra el documento
class PDF extends tFPDF
{
    //Cabecera de página
    function Header()
    {
        // se incerta el logo de la insticución
        $this->Image('../imagenes/logo_boletin.png', 17, 12.5, 60, 25);
        $this->Cell(90, 30, "", 1);
        $this->SetFont('Arial', '', 14);
        // Se crea una etiqueta con el logo de la institución
        $this->MultiCell(90, 15, "INFORME DE DISCIPLINA \n PERIODO " . $_GET["periodos"], 1, 'C');
    }

    //Pie de página
    function Footer()
    {
        //Posición: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial', '', 8);
        //Número de página
        $txt = enc("Otros servicios: Programas Técnicos , Cursos cortos y Programas tecnológicos");
        $this->Cell(0, 5, $txt, 0, 0, 'C');
        $this->Ln(3);
        $txt = enc("Info:  Cel.3166288374, WhatsApp. 3164469532, Email:administrativo@imcreativo.edu.co,  www.imcreativo.edu.co ");
        $this->Cell(0, 5, $txt, 0, 0, 'C');
        //$this->Ln(1);
        //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    /**
     * Dibuja un grafico de linea con escala de 0 a 5.
     *
     * @param string $titulo    Titulo del grafico.
     * @param array  $etiquetas Etiquetas del eje X (una por punto).
     * @param array  $valores   Valores de cada punto; null o 0 = sin nota (no se dibuja).
     */
    function GraficoLinea($titulo, $etiquetas, $valores)
    {
        // dimensiones del grafico
        $ancho = 180;
        $alto = 20;
        $margen_izq = 8;   // espacio para las etiquetas del eje Y
        $alto_total = $alto + 16; // titulo + etiquetas del eje X

        // si no cabe en la pagina actual se pasa a la siguiente
        if ($this->GetY() + $alto_total > $this->PageBreakTrigger) {
            $this->AddPage();
        }

        // titulo
        $this->SetFont('Arial', 'B', 8);
        $this->Cell($ancho, 5, $titulo, 0, 1, 'L');

        // area de dibujo
        $x0 = $this->GetX() + $margen_izq;
        $y0 = $this->GetY() + 2;
        $w = $ancho - $margen_izq;
        $h = $alto;

        // lineas guia horizontales de 0 a 5
        $this->SetFont('Arial', '', 6);
        $this->SetLineWidth(0.1);
        for ($v = 0; $v <= 5; $v++) {
            $y = $y0 + $h - ($v / 5) * $h;
            $this->SetDrawColor(210, 210, 210);
            $this->Line($x0, $y, $x0 + $w, $y);
            $this->Text($x0 - 4, $y + 1, number_format($v, 1, '.', ''));
        }

        // linea de nota minima aprobatoria (3.0)
        $y3 = $y0 + $h - (3 / 5) * $h;
        $this->SetDrawColor(255, 0, 0);
        $this->Line($x0, $y3, $x0 + $w, $y3);

        // marco del grafico
        $this->SetDrawColor(0, 0, 0);
        $this->Rect($x0, $y0, $w, $h);

        // posicion en X de cada punto
        $n = count($valores);
        $paso = $w / max($n, 1);
        $puntos = array();
        $i = 0;
        foreach ($valores as $k => $val) {
            $px = $x0 + $paso * ($i + 0.5);
            // etiqueta del eje X
            $etq = $etiquetas[$k] ?? '';
            $this->Text($px - $this->GetStringWidth($etq) / 2, $y0 + $h + 4, $etq);
            // solo se grafican las semanas con nota
            if ($val !== null && $val !== '' && floatval($val) > 0) {
                $val = min(floatval($val), 5.0);
                $puntos[] = array($px, $y0 + $h - ($val / 5) * $h, $val);
            }
            $i++;
        }

        // linea que une los puntos
        $this->SetDrawColor(0, 102, 204);
        $this->SetLineWidth(0.5);
        for ($j = 1; $j < count($puntos); $j++) {
            $this->Line($puntos[$j - 1][0], $puntos[$j - 1][1], $puntos[$j][0], $puntos[$j][1]);
        }

        // marcadores y valor de cada punto
        $this->SetFillColor(0, 102, 204);
        $this->SetFont('Arial', 'B', 6);
        foreach ($puntos as $pt) {
            $this->Rect($pt[0] - 0.8, $pt[1] - 0.8, 1.6, 1.6, 'F');
            $txt = number_format($pt[2], 1, '.', '');
            $this->Text($pt[0] - $this->GetStringWidth($txt) / 2, $pt[1] - 1.5, $txt);
        }

        // se restablecen los valores de dibujo
        $this->SetLineWidth(0.2);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFillColor(255, 255, 255);
        $this->SetY($y0 + $h + 6);
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

function formatearFecha($fechaInput)
{
    // 1. Crear el objeto DateTime con la fecha recibida
    $date = new DateTime($fechaInput);

    // 2. Arrays de traducción al español
    $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    $meses = [
        1 => 'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre'
    ];

    // 3. Extraer las partes de la fecha
    $numeroDiaSemana = $date->format('w'); // 0 (domingo) a 6 (sábado)
    $diaMes = $date->format('j');          // 1 a 31
    $numeroMes = $date->format('n');       // 1 a 12
    $año = $date->format('Y');             // Año completo (Ej: 2026)

    // 4. Construir la cadena de texto
    return $diaMes . " de " . $meses[$numeroMes];
}


$pdf = new PDF();

// objeto matricula
$mt = new matricula();
// creo un objeto semana
$g_semana = new semana();
// creo un objeto tipo calificaciones
$notax = new calificaciones();

// -------------------------------------------------------------------
// 1. Todos los alumnos matriculados en el año, en cualquier grado y
//    jornada, ordenados por grado y jornada
// -------------------------------------------------------------------
$matriculados = $mt->get_matriculas_ano_ordenadas($year);
$list = array_column($matriculados, "id_alumno");

// -------------------------------------------------------------------
// 2. Notas de disciplina (materia 20) de todos los alumnos en una query
// -------------------------------------------------------------------
$tab_calificaciones = $notax->get_notas_bulk($list, [20 => 0], $year);

// indexo las notas de disciplina por alumno
$disciplina_alumno = [];
foreach ($tab_calificaciones as $er) {
    $disciplina_alumno[$er["id_alumno"]] = $er;
}

// -------------------------------------------------------------------
// 3. Etiquetas del grafico: fecha de cierre de cada semana del periodo
//    (son las mismas para todos los estudiantes)
// -------------------------------------------------------------------
$g_titulo = enc("");
$etiquetas_x = [];
for ($ss = 1; $ss < 9; $ss++) {
    $num_semana = 8 * ($id_periodo - 1) + $ss;
    $g_semana->get_semana_ano($num_semana, $year);

    // si la semana no tiene fecha registrada se usa el numero de la semana
    if (!empty($g_semana->fin)) {
        array_push($etiquetas_x, formatearFecha($g_semana->fin));
    } else {
        array_push($etiquetas_x, "Semana " . $num_semana);
    }
}

$pdf->AddPage();
$pdf->Ln(5);

// numero de estudiantes reportados
$reportados = 0;
// grupo (grado - jornada) del ultimo estudiante impreso
$grupo_actual = "";

foreach ($matriculados as $m) {

    $e = $m["id_alumno"];

    // si el alumno no tiene registro de disciplina no se reporta
    if (!isset($disciplina_alumno[$e])) {
        continue;
    }
    $er = $disciplina_alumno[$e];

    // notas semanales de disciplina del periodo (D1-D8, D9-D16, ...)
    $nota_disciplina = [];
    for ($ss = 1; $ss < 9; $ss++) {
        $nota_disciplina[$ss] = $er["D" . strval(8 * ($id_periodo - 1) + $ss)] ?? null;
    }

    // nota del periodo de disciplina
    $disciplina_periodo = (float) ($er["D_p" . strval($id_periodo)] ?? 0);

    // si la nota del periodo no esta consignada (ej. D_p4 aun no existe
    // o no se ha recalculado) se usa el promedio de las notas
    // semanales del periodo diferentes de cero
    if ($disciplina_periodo == 0) {
        $notas_validas = array_filter($nota_disciplina, function ($n) {
            return is_numeric($n) && (float) $n != 0;
        });
        if (count($notas_validas) > 0) {
            $disciplina_periodo = round(array_sum($notas_validas) / count($notas_validas), 1);
        }
    }

    // solo se reportan los estudiantes con disciplina menor que tres
    // (sin nota de disciplina no se reporta al estudiante)
    if (!($disciplina_periodo > 0 and $disciplina_periodo < 3)) {
        continue;
    }

    $reportados++;

    // si el bloque del estudiante (tabla + grafico) no cabe en la pagina
    // se pasa a la siguiente
    if ($pdf->GetY() > 297 - 20 - 62) {
        $pdf->AddPage();
        $pdf->Ln(5);
    }

    // titulo de grupo cuando cambia el grado o la jornada
    $grupo = $m["grado"] . " - " . $m["jornada"];
    if ($grupo !== $grupo_actual) {
        $grupo_actual = $grupo;
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(180, 7, enc("Grado " . $m["grado"] . " - Jornada " . $m["jornada"]), 'B', 1, 'L');
        $pdf->Ln(2);
    }

    //ENCABEZADO DE CELDAS	//////////////////////////////
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(172, 172, 172);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(20, 5, 'No', 1, 0, 'C', true);
    $pdf->Cell(75, 5, enc('Nombre del estudiante'), 1, 0, 'C', true);
    $pdf->Cell(20, 5, enc('Grado'), 1, 0, 'C', true);
    $pdf->Cell(20, 5, enc('Jornada'), 1, 0, 'C', true);
    $pdf->Cell(25, 5, enc('Año lectivo'), 1, 0, 'C', true);
    $pdf->Cell(20, 5, enc('Nota'), 1, 0, 'C', true);
    $pdf->Ln();
    $pdf->Cell(20, 5, $e, 1, 0, 'C');
    $pdf->Cell(75, 5, enc(strtoupper($m['nombres'] . " " . $m['apellidos'])), 1, 0, 'C');
    $pdf->Cell(20, 5, enc($m["grado"]), 1, 0, 'C');
    $pdf->Cell(20, 5, enc($m["jornada"]), 1, 0, 'C');
    $pdf->Cell(25, 5, $year, 1, 0, 'C');

    // la nota menor que tres se pinta de rojo con letras blancas
    $pdf->SetFillColor(255, 0, 0);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(20, 5, number_format($disciplina_periodo, 1, '.', ''), 1, 0, 'C', true);

    // linea nueva
    $pdf->Ln();

    // grafico de las notas semanales de disciplina
    $pdf->SetTextColor(0, 0, 0);
    $pdf->GraficoLinea($g_titulo, $etiquetas_x, array_values($nota_disciplina));
}

// si ningun estudiante tiene disciplina menor que tres
if ($reportados == 0) {
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(180, 10, enc("No hay estudiantes con disciplina menor que 3 en el periodo " . $id_periodo . " del año " . $year), 0, 1, 'C');
}

$pdf->Output("informe_disciplina_periodo_" . $id_periodo . "_" . $year . "_" . date('d-m-Y__H_i_s') . ".pdf", "D");
