<?php
require('../tfpdf/tfpdf.php');
require_once 'datos.php';
// se crean las siguientes variables
// con obtenida a travez del formulario formulario_boletines

///////////////////////////////////////////////////////////////
//                                                           //
//  INFORME DE DISCIPLINA POR JORNADA                        //
//                                                           //
//  Las variables de ingreso son:                            //
//                                                           //
//  -  year : corresponde al año lectivo                     //
//  -  id_perdiodo: codigo del periodo va del 1 al 4         //
//  -  id_grado: codigo del grado , que proviene de la tabla //
//               grados.                                     //
//  -  id_jornada : codigo de la jornada                     //
//  -  id_curso : codigo del curso                           //
//                                                           //
///////////////////////////////////////////////////////////////

$year = $_GET["year"];                // carga el valor  en la variable fecha
$id_periodo = $_GET["periodos"];
$id_grado = $_GET["grado"]; // guarda el codigo del grado  en la variable $gradox
$id_jornada = $_GET["jornada"]; // guarda el dato de la jornada
$id_curso = $_GET["curso"]; // codigo del curso

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
// Add a Unicode font (uses UTF-8)
//$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
//$pdf->SetFont('helvetica','',10);
//$pdf->SetFont('DejaVu','',8);
//creo un nuevo elemento grado
$gr = new grados();
//obtengo las caracteristicas del grado
$gr->get_grado_id($id_grado);
// asignamos el año
$mt = new matricula();

// creo un objeto semana
$g_semana = new semana();

$mt->year = $year;
$mt->grado = $id_grado;
$mt->id_jornada = $id_jornada;
$mt->curso = $id_curso;
//$mt->id_grado = $id_grado;



// creamos un nuevo listado de estudiantes 
$list = $mt->get_matriculas_jornada();

// extraigo la columna de nombres
$list = array_column($list, "id_alumno");

// VARIABLES PARA GUARDAR LOS NOMBRES DE LOS ESTUDIANTES
$nivel = $gr->grado;
// se almacena el grado al que es promovido
// para el   grado actual los estudiantes
// de este grado
$promovido = $gr->promovido; //$datog['promovido'];

// objeto de la clase jornada
$jo = new jornada();
$jo->get_jornada_por_id($id_jornada);

// objeto tipo matricula docente
$md = new matricula_docente();
// creo un objeto tipo calificaciones (necesario para el segundo bucle)
$notax = new calificaciones();
// creo un objeto tipo logro
$lo = new logro();

// ================================================================
// PRE-CARGA OPTIMIZADA — reemplaza miles de queries individuales
// con un conjunto de bulk queries ejecutadas UNA sola vez.
// ================================================================



// -------------------------------------------------------------------
// 1. Cargar áreas y materias del grado UNA SOLA VEZ (fuera del bucle)
// -------------------------------------------------------------------
$area_obj = new area();
$lista_a = $area_obj->get_areas_grado($id_grado);  // [ id_area => [nombre, cantidad] ]

// Construir mapa materia → area y lista plana de ids de materias
// $materias_con_area[$id_materia] = $id_area
$materias_con_area = [];   // id_materia => id_area
$materias_por_area = [];   // id_area => [id_materia => nombre_materia]

$m_obj = new materia();
foreach ($lista_a as $id_area => $area_data) {
    $lista_m = $m_obj->get_materias_por_grado_area($id_grado, $id_area);
    $materias_por_area[$id_area] = $lista_m;
    foreach ($lista_m as $id_materia => $nombre_materia) {
        $materias_con_area[$id_materia] = $id_area;
    }
}

// -------------------------------------------------------------------
// 2. Cargar datos de alumnos en una sola query
// -------------------------------------------------------------------
$alumnos_cache = alumnos::get_alumnos_bulk($list);


// -------------------------------------------------------------------
// 3. Cargar docentes del grado en una sola query
// -------------------------------------------------------------------
$docentes_cache = $md->get_docentes_grado(
    intval($id_grado),
    intval($id_jornada),
    intval($id_curso),
    intval($year)
);

// -------------------------------------------------------------------
// 4. Cargar TODAS las notas y recuperaciones en 2 queries
// -------------------------------------------------------------------
$tab_calificaciones = $notax->get_notas_bulk($list, $materias_con_area, intval($year));
// matriz de tres dimensiones que almacena la calificacion de un 
// alumno  en una materia en durante el periodo academico
$spot = [[]];



// notas semanales de disciplina (id_materia = 20) del periodo actual.
// cada periodo tiene 8 semanas; se grafican las semanas base+1 a base+7
// (ej. periodo 3: D17 - D23) ya que la semana 8 se consigna en D_p{periodo}
// $base_disc = 8 * ($id_periodo - 1);
// $semanas_disc = [];
// for ($s = $base_disc + 1; $s <= $base_disc + 7; $s++) {
//     $semanas_disc["D" . $s] = "Sem " . $s;
// }
// $disciplina_semanas = [];
// foreach ($tab_calificaciones as $ed) {
//     if (intval($ed["id_materia"]) === 20) {
//         foreach ($semanas_disc as $col => $etq) {
//             $disciplina_semanas[$ed["id_alumno"]][$col] = $ed[$col] ?? null;
//         }
//     }
// }






$pdf->AddPage();
$pdf->Ln(5);

foreach ($list as $e) {



    // si esta en el grupo de posiciones



    // $pdf->Ln(3);

    // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

    // encabezado para la tabla resumen
    //

    // $pdf->Ln(3);
    // $pdf->SetFillColor(200, 200, 200);
    // $pdf->SetFont('Arial', 'B', 7);
    // $pdf->Cell(50, 3, 'Area', 1, 0, 'C', true);
    // $pdf->Cell(50, 3, 'Materia', 1, 0, 'C', true);
    // $pdf->Cell(15, 3, 'Periodo 1', 1, 0, 'C', true);
    // $pdf->Cell(15, 3, 'Periodo 2', 1, 0, 'C', true);
    // $pdf->Cell(15, 3, 'Periodo 3', 1, 0, 'C', true);
    // $pdf->Cell(15, 3, 'Periodo 4', 1, 0, 'C', true);
    // $pdf->Cell(20, 3, 'Acumulado', 1, 0, 'C', true);
    // $pdf->Ln(3);

    // numero materias
    $num_m = 0;
    // areas perdidas
    $a_perdidas = 0;
    // materias perdidas
    $materia_perdidas = 0;
    // $lista_a ya está cargada antes del bucle (cache global)


    /////////////////////////////////////////////////////
    //                                                 //
    //    TABLA DE NOTAS                               //
    //                                                 //
    /////////////////////////////////////////////////////


    /*
    //por cada area que debe evaluar el grado muestro ..
    foreach ($lista_a as $id_area => $a) {

        // variables de repeticion de area
        $avg = 0;
        $avg_a = 0;
        // obtengo el area
        $area = $a[0];
        // obtengo la cantidad de materias del area
        $cantidad = $a[1];
        //variables de cada area
        $nota_a = array(); // array que contiene las notas de cada area
        $nota_r = array(); // array que contiene las notas del area con recuperacion
        $materia_a = 0; //contador de materias del area inicia en 1
        $recupero = false;

        // uso el cache de materias pre-cargado
        $lista_m_a = $materias_por_area[$id_area] ?? [];
        // defino el tipo de fuente
        //$pdf->SetFont('Arial', 'B', 7);
        // 
        //$pdf->Cell(50, 3 * $cantidad, enc($area), 1, 0, 'L');
        // obtengo la coordenada en X en la cual termino de imprimirse la caja
        // del area, par a partir de ahí comenzar a escribir las materias
        //$x = $pdf->GetX();


        // array multidimencional de dos niveles
        // para cada estudiante, que define el
        // area y la materia con la recuperacion corregida

        $spot_x = array(array());

        //por cada materia imprimo una fila
        foreach ($lista_m_a as $id_materia => $materia) {
            // Coloca la coordenada en x donde se escribira
            // la siguiente linea
            //$pdf->SetX($x);
            // Se crea los campos para mostrar cada materia
            //$pdf->Cell(50, 3, enc($materia), 1, 0, 'L');

            // en las variables $p1 ... $p2
            // inicializamos los acumuladores
            $p1 = 0; // periodo 1
            $p2 = 0; // periodo 2
            $p3 = 0; // periodo 3
            $p4 = 0; // periodo 4


            // Variables que almacenan la recuperacion  del periodo 
            $r1 = 0; // recuperacion periodo 1
            $r2 = 0; // recuperacion periodo 2
            $r3 = 0; // recuperacion periodo 3
            $r4 = 0; // recuperacion periodo 4



            // OBTENGO LA NOTA DE LOS PERIODOS ALMACENADA EN EL ARRAY
            // spot para las notas y recuperacion para la recuperacion

            // PRIMER PERIODO

            // obtengo la nota del periodo
            $p1 = number_format($spot[$e][$id_area][$id_materia][1] ?? 0, 1, '.', '');

            // si hay cargada una recuperacion para el primer periodo
            if (isset($recuperacion[$e][$id_area][$id_materia][1])) {
                $r1 = number_format($recuperacion[$e][$id_area][$id_materia][1] ?? 0, 1, '.', '');
            }

            // validación de los valores máximos coloco cinco 
            if ($p1 > 5.0) {
                $p1 = number_format(5.0, 1, '.', '');
            }

            // SEGNDO PERIODO

            // obtengo la nota para el segundo periodo
            $p2 = number_format($spot[$e][$id_area][$id_materia][2] ?? 0, 1, '.', '');

            // si hay cargada una recuperacion para el segundo periodo
            if (isset($recuperacion[$e][$id_area][$id_materia][2])) {
                $r2 = number_format($recuperacion[$e][$id_area][$id_materia][2] ?? 0, 1, '.', '');
            }

            // validación de valores máximos
            if ($p2 > 5.0) {
                $p2 = number_format(5.0, 1, '.', '');
            }

            // TERCER PERIODO

            // obtengo la nota del tercer periodo
            $p3 = number_format($spot[$e][$id_area][$id_materia][3] ?? 0, 1, '.', '');
            // si hay una recuperacion cargada para el periodo 3
            if (isset($recuperacion[$e][$id_area][$id_materia][3])) {
                $r3 = number_format($recuperacion[$e][$id_area][$id_materia][3] ?? 0, 1, '.', '');
            }
            // validación de valores máximos
            if ($p3 > 5.0) {
                $p3 = number_format(5.0, 1, '.', '');
            }

            // CUARTO PERIODO

            // obtengo la nota del cuarto periodo
            $p4 = number_format($spot[$e][$id_area][$id_materia][4] ?? 0, 1, '.', '');
            // si hay cargada  una recuperacion para el periodo 4
            if (isset($recuperacion[$e][$id_area][$id_materia][4])) {
                $r4 = number_format($recuperacion[$e][$id_area][$id_materia][4] ?? 0, 1, '.', '');
            }
            // validación de valores máximos
            if ($p4 > 5.0) {
                $p4 = number_format(5.0, 1, '.', '');
            }


            ////////////////////////////////////////////////////////////////////////////
            // RETORNO UN VALOR VACIO EN CASO DE QUE LA NOTA ES CERO                  //
            ////////////////////////////////////////////////////////////////////////////

            if ($p1 == 0.0) {
                $p1 = "";
            }
            if ($p2 == 0.0 || $id_periodo < 2) {
                $p2 = "";
            }
            if ($p3 == 0.0 || $id_periodo < 3) {
                $p3 = "";
            }
            if ($p4 == 0.0 || $id_periodo < 4) {
                $p4 = "";
            }


            if ($r1 == 0.0) {
                $r1 = "";
            }
            if ($r2 == 0.0 || $id_periodo < 2) {
                $r2 = "";
            }
            if ($r3 == 0.0 || $id_periodo < 3) {
                $r3 = "";
            }
            if ($r4 == 0.0 || $id_periodo < 4) {
                $r4 = "";
            }

            ////////////////////////////////////////////////////////////////////////////
            // DECIDE SI IMPRIMIR EL ROJO O EL BLANCO                                 //
            ////////////////////////////////////////////////////////////////////////////

            // PRIMER PERIODO 

            // si hay recuperacion del primer periodo
            if ($r1) {
                // si la recuperacion es menor que 3 y mayorque cero
                if ($r1 < 3 and $r1 > 0.1) {
                    // imprimo en rojo
                    //$pdf->SetFillColor(255, 0, 0);
                } // pintar de rojo
                else {
                    // imprimo en blanco
                    //$pdf->SetFillColor(255, 255, 255);
                }
                // imprimo la recuperacion junto a la nota
                //$pdf->Cell(15, 3, $p1 . " [$r1]", 1, 0, 'C', true); // imprime el primer periodo
            } else {
                // si  no hay recuperacion del primer periodo reviso
                // si la nota es menor que 3 y mayor que uno
                if ($p1 < 3 and $p1 > 0.1) {
                    // imprimo en rojo
                    //$pdf->SetFillColor(255, 0, 0);
                } // pintar de rojo
                else {
                    // imprimo en blanco
                    //$pdf->SetFillColor(255, 255, 255);
                }
                // imprimo solamente la nota
                //$pdf->Cell(15, 3, $p1, 1, 0, 'C', true); // imprime el primer periodo
            }

            ////////////////////////////////////////////////////////////////
            // SEGUNDO PERIODO


            // si hay recuperacion del segundo periodo
            if ($r2) {
                // si la recuperacion es menor que tres y mayor que cero
                if ($r2 < 3 and $r2 > 0.1 and $id_periodo > 1) {
                    // pinto la celda de rojo
                    //$pdf->SetFillColor(255, 0, 0);
                } // pintar de rojo
                else {
                    // pinto la celda de blanco
                    //$pdf->SetFillColor(255, 255, 255);
                }

                // coloca la nota del segundo periodo  a partir del mismo
                if ($id_periodo > 1) {
                    // imprimo la nota y la recupracion del segundo periodo
                    //$pdf->Cell(15, 3, $p2 . " [$r2]", 1, 0, 'C', true);
                } else {
                    // si es el primer periodo dejo la celda en blanco
                    //$pdf->Cell(15, 3, '', 1, 0, 'C', true);
                }
            }
            // si no hay recuperacion del segundo periodo
            else {
                // si la nota es menor que tres y mayor que cero
                if ($p2 < 3 and $p2 > 0.1 and $id_periodo > 1) {
                    // imprimo de rojo
                    //$pdf->SetFillColor(255, 0, 0);
                } // pintar de rojo
                else {
                    // imprimo de blanco
                    //$pdf->SetFillColor(255, 255, 255);
                }

                // coloca la nota del segundo periodo  a partir del mismo
                if ($id_periodo > 1) {
                    //$pdf->Cell(15, 3, $p2, 1, 0, 'C', true);
                } else {
                    //$pdf->Cell(15, 3, '', 1, 0, 'C', true);
                }
            }

            ////////////////////////////////////////////////////////////////
            // TERCER PERIODO 

            // si hay recuperacion del tercer periodo            
            if ($r3) {
                // si la recuperacion es menor que 3 y mayor que cero 
                if ($r3 < 3 and $r3 > 0.1 and $id_periodo > 2) {
                    //$pdf->SetFillColor(255, 0, 0);
                } // pintar de rojo
                else {
                    //$pdf->SetFillColor(255, 255, 255);
                }

                // coloca la nota del tercer periodo  a partir del mismo
                if ($id_periodo > 2) {
                    //$pdf->Cell(15, 3, $p3 . " [$r3]", 1, 0, 'C', true);
                } else {
                    //$pdf->Cell(15, 3, '', 1, 0, 'C', true);
                }
            } else {
                // pinta de rojo  la celda del tercer periodo si la nota es baja
                if ($p3 < 3 and $p3 > 0.1 and $id_periodo > 2) {
                    //$pdf->SetFillColor(255, 0, 0);
                } // pintar de rojo
                else {
                    //$pdf->SetFillColor(255, 255, 255);
                }

                // coloca la nota del tercer periodo  a partir del mismo
                if ($id_periodo > 2) {
                    //$pdf->Cell(15, 3, $p3, 1, 0, 'C', true);
                } else {
                    //$pdf->Cell(15, 3, '', 1, 0, 'C', true);
                }
            }

            ///////////////////////////////////////////////////////////////
            // CUARTO PERIODO

            // si tiene recuperacion del cuarto periodo
            if ($r4) {
                // si la recuperacion es menor que 3 y mayor que cero
                if ($r4 < 3 and $r4 > 0.1 and $id_periodo > 3) {
                    //$pdf->SetFillColor(255, 0, 0);
                } // pintar de rojo
                else {
                    //$pdf->SetFillColor(255, 255, 255);
                }

                // coloca la nota del cuarto  periodo  a partir del mismo
                if ($id_periodo > 3) {
                    //$pdf->Cell(15, 3, $p4 . " [$r4]", 1, 0, 'C', true);
                } else {
                    //$pdf->Cell(15, 3, '', 1, 0, 'C', true);
                }
            } else {
                // pinta de rojo  la celda del tercer periodo si la nota es baja
                if ($p4 < 3 and $p3 > 0.1 and $id_periodo > 3) {
                    //$pdf->SetFillColor(255, 0, 0);
                } // pintar de rojo
                else {
                    //$pdf->SetFillColor(255, 255, 255);
                }

                // coloca la nota del cuarto  periodo  a partir del mismo
                if ($id_periodo > 3) {
                    //$pdf->Cell(15, 3, $p4, 1, 0, 'C', true);
                } else {
                    //$pdf->Cell(15, 3, '', 1, 0, 'C', true);
                }
            }

            ///////////////////////////////////////////////////////////
            // Area de definicion del acumulado de cada materia      //
            ///////////////////////////////////////////////////////////


            // Si el periodo es el primero el acumulado se define de la siguiente manera
            if ($id_periodo == 1) {

                // asigno las notas de los periodos a las variables $p ..
                $p1 = $spot[$e][$id_area][$id_materia][1] ?? 0.0;

                // si tiene una nota de recuperacion cargada del periodo 1
                if (isset($recuperacion[$e][$id_area][$id_materia][1])) {
                    // si la recuperacion es mayor que 0
                    if ($recuperacion[$e][$id_area][$id_materia][1] > 0) {
                        // se remplaza la nota
                        $p1 = $recuperacion[$e][$id_area][$id_materia][1];
                    }
                }

                // calculo el acumulado como la cuarta parte del año
                $ac = ($p1) / 4;
                // lo guardo en el array el acumulado del periodo 
                $spot_x[$id_area][$id_materia] = $ac;
            }

            // si el periodo es el segundo el acumulado se define de la siguiente manera
            elseif ($id_periodo == 2) {

                // asigno las notas de los periodos a las variables $p ..
                $p1 = $spot[$e][$id_area][$id_materia][1] ?? 0.0;
                $p2 = $spot[$e][$id_area][$id_materia][2] ?? 0.0;

                // si tiene una nota cargada del periodo 1
                if (isset($recuperacion[$e][$id_area][$id_materia][1])) {
                    // si la recuperacion es mayor que 0
                    if ($recuperacion[$e][$id_area][$id_materia][1] > 0) {
                        // se remplaza la nota
                        $p1 = $recuperacion[$e][$id_area][$id_materia][1];
                    }
                }

                // si tiene una nota cargada del periodo 2
                if (isset($recuperacion[$e][$id_area][$id_materia][2])) {
                    // si la recuperacion es mayor que 0
                    if ($recuperacion[$e][$id_area][$id_materia][2] > 0) {
                        // se remplaza la nota
                        $p2 = $recuperacion[$e][$id_area][$id_materia][2];
                    }
                }

                // calculo el acumulado para el segundo periodo 
                $ac = ($p1 + $p2) / 4;
                // lo guardo en el array el acumulado del periodo 
                $spot_x[$id_area][$id_materia] = $ac;
            }

            // si el periodo es el tercero el acumulado se define de la siguiente manera
            elseif ($id_periodo == 3) {

                // asigno las notas de los periodos a las variables $p ..
                $p1 = $spot[$e][$id_area][$id_materia][1] ?? 0.0;
                $p2 = $spot[$e][$id_area][$id_materia][2] ?? 0.0;
                $p3 = $spot[$e][$id_area][$id_materia][3] ?? 0.0;


                // si tiene una nota cargada del periodo 1
                if (isset($recuperacion[$e][$id_area][$id_materia][1])) {
                    // si la recuperacion es mayor que 0
                    if ($recuperacion[$e][$id_area][$id_materia][1] > 0) {
                        // se remplaza la nota
                        $p1 = $recuperacion[$e][$id_area][$id_materia][1];
                    }
                }

                // si tiene una nota cargada del periodo 2
                if (isset($recuperacion[$e][$id_area][$id_materia][2])) {
                    // si la recuperacion es mayor que 0
                    if ($recuperacion[$e][$id_area][$id_materia][2] > 0) {
                        // se remplaza la nota
                        $p2 = $recuperacion[$e][$id_area][$id_materia][2];
                    }
                }

                // si tiene una nota cargada del periodo 3
                if (isset($recuperacion[$e][$id_area][$id_materia][3])) {
                    // si la recuperacion es mayor que 0
                    if ($recuperacion[$e][$id_area][$id_materia][3] > 0) {
                        // se remplaza la nota
                        $p3 = $recuperacion[$e][$id_area][$id_materia][3];
                    }
                }


                // calculo el acumulado para el cuarto periodo 
                $ac = ($p1 + $p2 + $p3) / 4;
                // lo guardo en el array el acumulado del periodo 
                $spot_x[$id_area][$id_materia] = $ac;
            }

            // si es el cuarto periodo el acumulado se define de la siguiente manera
            elseif ($id_periodo == 4) {

                // asigno las notas de los periodos a las variables $p ..
                $p1 = $spot[$e][$id_area][$id_materia][1] ?? 0.0;
                $p2 = $spot[$e][$id_area][$id_materia][2] ?? 0.0;
                $p3 = $spot[$e][$id_area][$id_materia][3] ?? 0.0;
                $p4 = $spot[$e][$id_area][$id_materia][4] ?? 0.0;

                // si tiene una nota cargada del periodo 1
                if (isset($recuperacion[$e][$id_area][$id_materia][1])) {
                    // si la recuperacion es mayor que 0
                    if ($recuperacion[$e][$id_area][$id_materia][1] > 0) {
                        // se remplaza la nota
                        $p1 = $recuperacion[$e][$id_area][$id_materia][1];
                    }
                }

                // si tiene una nota cargada del periodo 2
                if (isset($recuperacion[$e][$id_area][$id_materia][2])) {
                    // si la recuperacion es mayor que 0
                    if ($recuperacion[$e][$id_area][$id_materia][2] > 0) {
                        // se remplaza la nota
                        $p2 = $recuperacion[$e][$id_area][$id_materia][2];
                    }
                }

                // si tiene una nota cargada del periodo 3
                if (isset($recuperacion[$e][$id_area][$id_materia][3])) {
                    // si la recuperacion es mayor que 0
                    if ($recuperacion[$e][$id_area][$id_materia][3] > 0) {
                        // se remplaza la nota
                        $p3 = $recuperacion[$e][$id_area][$id_materia][3];
                    }
                }

                // si tiene una nota cargada del periodo 4
                if (isset($recuperacion[$e][$id_area][$id_materia][4])) {
                    // si la recuperacion es mayor que 0
                    if ($recuperacion[$e][$id_area][$id_materia][4] > 0) {
                        // se remplaza la nota
                        $p4 = $recuperacion[$e][$id_area][$id_materia][4];
                    }
                }

                // calculo el acumulado para el cuarto periodo
                $ac = ($p1 + $p2 + $p3 + $p4) / 4;
                // lo guardo en el array el acumulado del periodo 
                $spot_x[$id_area][$id_materia] = $ac;
                //echo "<br> datos para area $id_area y materia $id_materia =".$spot_x[$id_area][$id_materia]. "";
            }


            //$pdf->Cell(20, 3, number_format($ac ?? 0, 1, '.'), 1, 0, 'C', false); // coloca la nota acumulada
            // numero de materia      
            $num_m = $num_m + 1;
            //$pdf->Ln(3);
        } // fin de materias

        // Si se trata del cuarto periodo cacúlo la nota del area en base
        // al acumulado
        if ($id_periodo == 4) {

            $nota_a[$materia_a] = $ac; // gurado la nota acumulada en el vector del area

        } else {
            $nota_a[$materia_a] = $spot[$e][$id_area][$id_materia][$id_periodo] ?? 0.0; // nota  de la materia
        }


        foreach ($spot_x[$id_area] as $id_m => $mat) {
            // calculo una sumatoria
            $avg_a = $mat + $avg_a;
            // incremento las materias perdidas
            // si es menor que tres y diferente
            // de disciplina.
            if ($mat < 2.95 and $id_m !== 20) {
                //echo "<br>materia perdida  con $mat, en la materia $id_m  para el estudiante $e";
                $materia_perdidas++;
            }
        }

        // echo "<br> Cantidad ".count($spot[$e][$id_area]);
        // promedio del area
        if (isset($spot[$e][$id_area])) {
            $avg_a = $avg_a / count($spot[$e][$id_area]);
        } else {
            $avg_a = 0;
        }

        // echo "<br><b>promedio </b> $avg_a";
        // si el promedio del área es menor que tres se incrementa el número de areas perdidas
        if ($avg_a < 3) {
            $a_perdidas++;
        }
        //echo " = ".$avg_a."<br>";

        // se da formato al numero de areas perdidas
        $avg_a = number_format($avg_a ?? 0, 1, '.', ''); // se calcula el promedio del area


    }
*/

    //if ($tab_calificaciones)
    $pdf->Ln(5);

    // titulo del grafico
    $g_titulo = enc("");

    // son las etiquetas en x
    $etiquetas_x = [];

    // ciclo de repeticion for
    // para explorar las siete calificaciones parciales de
    // disciplina y obtener las fechas en que fueron calificadas
    for ($ss = 1; $ss < 9; $ss++) {
        // obtengo los atributos de la semana
        $g_semana->get_semana_ano(8 * ($id_periodo - 1) + $ss, $year);

        // agrego una fila al array
        array_push($etiquetas_x, formatearFecha($g_semana->fin));
    }

    // inicializo el array para guardar las notas de disciplina
    $nota_disciplina = [];
    $disciplina_periodo = 0;

    // Establezco el array de  recuperaciones
    foreach ($tab_calificaciones as $er) {
        // ciclo para recorrer los periodos

        // asigno la nota de recuperacion
        if ($er["id_alumno"] == $e and $er["id_materia"] == 20) {

            // alimento el array de disciplina
            $nota_disciplina[1] = $er["D" . strval(8 * ($id_periodo - 1) + 1)];
            $nota_disciplina[2] = $er["D" . strval(8 * ($id_periodo - 1) + 2)];
            $nota_disciplina[3] = $er["D" . strval(8 * ($id_periodo - 1) + 3)];
            $nota_disciplina[4] = $er["D" . strval(8 * ($id_periodo - 1) + 4)];
            $nota_disciplina[5] = $er["D" . strval(8 * ($id_periodo - 1) + 5)];
            $nota_disciplina[6] = $er["D" . strval(8 * ($id_periodo - 1) + 6)];
            $nota_disciplina[7] = $er["D" . strval(8 * ($id_periodo - 1) + 7)];
            $nota_disciplina[8] = $er["D" . strval(8 * ($id_periodo - 1) + 8)];

            // nota del periodo de disciplina
            $disciplina_periodo = $er["D_p" . strval($id_periodo)];
            break;
        }
    }

    // si la disciplina del perdiodo es menor que tres
    if ($disciplina_periodo < 3.5 and $disciplina_periodo !== 0) {

        // uso el cache de alumnos pre-cargado
        $estudiante = $alumnos_cache[$e] ?? ['nombres' => '', 'apellidos' => ''];

        //ENCABEZADO DE CELDAS	//////////////////////////////
        //usando la libreria FPDF
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
        $pdf->Cell(75, 5, enc(strtoupper($estudiante['nombres'] . " " . $estudiante['apellidos'])), 1, 0, 'C');
        $pdf->Cell(20, 5, enc($nivel), 1, 0, 'C');
        $pdf->Cell(20, 5, enc($jo->jornada), 1, 0, 'C');
        $pdf->Cell(25, 5, $year, 1, 0, 'C');

        if ($disciplina_periodo < 3) {
            // si la disciplina es menor que tres pinta de rojo
            $pdf->SetFillColor(255, 0, 0);
            // con letras blancas
            $pdf->SetTextColor(255, 255, 255);
        } else {
            // lo rellena de amarillo
            $pdf->SetFillColor(255, 200, 0);
            // con letras negras
            $pdf->SetTextColor(0, 0, 0);
        }

        $pdf->Cell(20, 5, number_format($disciplina_periodo ?? 0, 1, '.', ''), 1, 0, 'C', true);

        // linea nueva
        $pdf->Ln();

        // si se tienen las notas de disciplina
        if (isset($nota_disciplina[1])) {
            $g_notas =  [
                $nota_disciplina[1],
                $nota_disciplina[2],
                $nota_disciplina[3],
                $nota_disciplina[4],
                $nota_disciplina[5],
                $nota_disciplina[6],
                $nota_disciplina[7],
                $nota_disciplina[8]
            ];

            $pdf->SetTextColor(0, 0, 0);
            // crea un grafico de linea
            $pdf->GraficoLinea($g_titulo, $etiquetas_x, $g_notas);
            //detalle de cada materia
        }
    }
}




// OBSERVACIONES DEL ESTUDIANTE





$pdf->Output("informe_disciplina_" . $gr->grado . "_" . enc($jo->jornada) . "_" . date('d-m-Y__H_i_s') . ".pdf", "D");
//$pdf->Output("boletin_.pdf");
