<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
// se inserta este fichero para generar el documento en pdf
// correspondiente al boletin de calificaciones del periodo
// asignado.
require('../fpdf/fpdf.php');
//require('../fpdf/html_table.php');
// se requiere este fichero para realizar la conexion con
// el gestor de bases de datos base de datos mysql
require_once 'datos.php';

// se crean las siguientes variables
// con obtenida a travez del formulario formulario_boletines

// Estas son las variables que obtienen de el cliente
// mediante el metodo GET
// el codigo de la matricual
$id_matricula = $_GET["matricula"];

// creo el objeto con una instancia de  matricuala
$obj_matricuala = new matricula($id_matricula);

// obtengo la fecha  de la matricula
$fecha = $obj_matricuala->year;

$periodo = 4;   // carga el periódo del cual se quiere generar el boletín

// datos del grado
$obj_grado = new grados();
// obtengo los valores del grado
$obj_grado->get_grado_id($obj_matricuala->id_grado);

// obtengo los datos de la jornada vacia
$obj_jornada = new jornada();
// cargo los datos para  la instacia jornada
$obj_jornada->get_jornada_por_id($obj_matricuala->id_jornada);
// codigo del periodo evaluado
$id_periodo = 4;
// variable para añadir nota cuantitativa
$valor = 0;

setlocale(LC_ALL, "es_ES");


$nivel = $obj_grado->nombre_g;
// recupero la escolaridad del grado
$escolaridad = $obj_grado->escolaridad;
// se almacena el grado al que es promovido
// para el   grado actual los estudiantes
// de este grado
$promovido = $obj_grado->promovido; //$datog['promovido'];
// creo un objeto tipo calificaciones
$notax = new calificaciones();
// creo un objeto tipo promedio 
$promedio = array();
// un nuevo objeto tipo area
$areaObj = new area();
// creamo un nuevo objeto tipo materia
$materiaObj = new  materia();
// creo el objeto de estudiante
$estudiante = new alumnos($obj_matricuala->id_alumno);

// define el tipo de codificaci�n para la letra
// header("Content-Type: text/html;charset=utf-8");
// CONEXION CON LA BASE DE DATOS

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
        $this->Cell(150, 5, mb_convert_encoding("Resolución de Aprobación No 5216-06-2009 del 19 de Junio de 2009 ", 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(20, 5, "", 0);
        $this->Cell(150, 5, mb_convert_encoding("Preescolar, Educación Básica Ciclo Primaria y Secundaria y Edicación Media ", 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    }

    //Pie de pagina
    function Footer()
    {

        //Posicion: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial', '', 8);
        //Numero de pagina
        $txt = mb_convert_encoding("Otros servicios: Programas Técnicos , Cursos cortos y ", 'ISO-8859-1', 'UTF-8');

        $this->Cell(0, 5, $txt, 0, 0, 'C');
        $this->Ln(3);
        $txt = "Info: Tel 829 602 8443640, Cel.3166288374, WhatsApp. 3164469532, Email:administrativo@imcreativo.edu.co,  www.imcreativo.edu.co ";
        $this->Cell(0, 5, $txt, 0, 0, 'C');
    }
}


// se crea un nuevo documento de PDF
$pdf = new PDF();

// creamos un nuevo listado de estudiantes 
$list = new listado_estudiantes($obj_matricuala->year, $obj_matricuala->id_grado, $obj_matricuala->id_jornada, $obj_matricuala->id_curso);
// codigo del estudiante
$e = $obj_matricuala->id_alumno;

// lista de areas que cursa cursan en un grado
$lista_areas = $areaObj->get_areas_grado($obj_matricuala->id_grado);
$a_perdidas = 0; // contador que identifica el numero de areas perdidas
// arreglo de intensidad horaria
$arr_ih = [];
// cantidad de areas
$num_areas = 0;

// // POR CADA AREA QUE DEBE EVALUAR EL GRADO MUESTRO ..
// foreach ($lista_areas as  $id_area => $datoArea) {

//     //  PROMEDIO general  para el alumno
//     $p_a  = 0;
//     // contador que acumula la intensidad horaria de las materias
//     $ih = 0;
//     // cantidad de materias
//     $c_m = 0;

//     // obtiene un listado de materias a ver en  una area de un grado
//     $lista_materias = $materiaObj->get_materias_por_grado_area($obj_matricuala->id_grado, $id_area);

//     //LISTA DE MATERIAS DEL AREA
//     foreach ($lista_materias as $id_materia => $nombreMateria) {
//         // inicio el acumulador de nota 
//         $nota_p_ac = 0;

//         $materiaObj->get_materia($id_materia);


//         // ciclo de repeticion para los cuatro periodos
//         // de una materia
//         for ($p = 1; $p <= 4; $p++) {

//             // obtengo la nota del periodo
//             // compuesta por cuatro coordenadas
//             // $e       --> codigo del estudiante
//             // $id_area --> codigo del area
//             // $id_materia --> codigo materia
//             // codigo del periodo
//             $notax->get_nota_periodo($e, $id_materia, 1, $obj_matricuala->year);
//             // guardo la nota en la para el periodo $p
//             $nota_p =  number_format(($notax->nota ?? 0), 1, '.', '');

//             // //////////////////////////////////////////////////////
//             // // para obtener la recuperacion del primer periodo
//             $notax->get_recuperacion_periodo($e, $id_materia, $obj_matricuala->year, $p);
//             // si se ha calificado alguna recuperacion
//             if ($notax->calificado) {
//                 // almaceno la recuperacion del primer periodo
//                 $nota_p =  number_format(($notax->nota ?? 0), 1, '.', '');
//                 // guardo el valor para calculos estadisticos
//             }

//             // nota acumulada de los cuatro periodos
//             $nota_p_ac = $nota_p + $nota_p_ac;
//         }

//         // nota  de la materia
//         $nota_m = $nota_p_ac / 4;
//         // acumulado  del area
//         $p_a = $p_a + $nota_m;
//         //incremento la cantidad de materias
//         $c_m++;
//         // aumento la intensidad horaria del area
//         $ih = $ih + $materiaObj->ih;
//     } // fin de materia

//     // promedio de area  del estudiante
//     $promedio[$e][$id_area] = $p_a / $c_m;


//     // defino  si la nota del area es menor que tres
//     // y es un area distinta de disciplina
//     if ($promedio[$e][$id_area] < 3 and $id_area != 20) {

//         $a_perdidas++; // incremento el contador de areas perdidas siempre y cuando no sea disciplina
//     }

//     // guardo la intensidad horaria para esta area
//     $arr_ih[$id_area] = $ih;

//     // si la materia es diferente a  disciplina
//     if ($id_area !== 12){
//         // incremento en contador de areas
//         $num_areas++;
//     }
// } // fin del area


//****

// POR CADA AREA QUE DEBE EVALUAR EL GRADO MUESTRO ..
foreach ($lista_areas as  $id_area => $datoArea) {


    // si la materia es diferente a  disciplina
    if ($id_area !== 12) {

        // PROMEDIO general  para el alumno
        $p_a  = 0;
        // contador que acumula la intensidad horaria de las materias
        $ih = 0;
        // cantidad de materias
        $c_m = 0;

        // obtiene un listado de materias a ver en  una area de un grado
        $lista_materias = $materiaObj->get_materias_por_grado_area($obj_matricuala->id_grado, $id_area);

        //LISTA DE MATERIAS DEL AREA
        foreach ($lista_materias as $id_materia => $nombreMateria) {
            // inicio el acumulador de nota 
            $nota_p_ac = 0;
            // nota del periodo
            $nota_p = 0;
            // obtengo los atributos de la materia
            $materiaObj->get_materia($id_materia);


            // ciclo de repeticion para los cuatro periodos
            // de una materia
            for ($p = 1; $p <= 4; $p++) {

                // obtengo la nota del periodo
                // compuesta por cuatro coordenadas
                // $e       --> codigo del estudiante
                // $id_area --> codigo del area
                // $id_materia --> codigo materia
                // codigo del periodo
                echo " los dastos de consulta son estudiante $e , masteria $id_materia, periodo $p y ano ".$obj_matricuala->year."<br>";
                $notax->get_nota_periodo($e, $id_materia, $p, $obj_matricuala->year);
                // guardo la nota en la para el periodo $p
                $nota_p =  $notax->nota;

                ////////////////////////////////////////////////////////
                // para obtener la recuperacion del primer periodo
                $notax->get_recuperacion_periodo($e, $id_materia, $obj_matricuala->year, $p);
                // si se ha calificado alguna recuperacion
                if ($notax->calificado and $notax->nota > 3) {
                    // almaceno la recuperacion del primer periodo
                    $nota_p =  $notax->nota;
                    // guardo el valor para calculos estadisticos
                    echo "<font color='red'>recuperacion de la materia, nota ".$notax->nota." </font><br>";
                }
                // nota acumulada de los cuatro periodos
                $nota_p_ac = $nota_p + $nota_p_ac;

                echo "nota de materia ".$materiaObj->materia." ".$nota_p." en el periodo $p  <br>";
            }

            // nota  de la materia
            $nota_m = $nota_p_ac / 4;

            
            // acumulado  del area
            $p_a = $p_a + $nota_m;
            //incremento la cantidad de materias
            $c_m++;
            // aumento la intensidad horaria del area
            $ih = $ih + $materiaObj->ih;

            echo "nota del area ".$datoArea[0]." [".$id_area."] acumulado del area ".$p_a."<br><br>";
        } // fin de materia

        // promedio de area  del estudiante
        $promedio[$e][$id_area] = $p_a / $c_m;

        echo " el promedio del area ".$datoArea[0]." es ".$promedio[$e][$id_area]."<br><br>";


        // defino  si la nota del area es menor que tres
        // y es un area distinta de disciplina
        if ($promedio[$e][$id_area] < 3 and $id_area != 20) {

            $a_perdidas++; // incremento el contador de areas perdidas siempre y cuando no sea disciplina
        }

        // guardo la intensidad horaria para esta area
        $arr_ih[$id_area] = $ih;


        // incremento en contador de areas
        $num_areas++;
    } else {
        // atributos de disciplina
        
    }
} // fin del area



//***



///////////////////////////////////////////////////////////////
//                                                           //
//   IMPRESION DE CERTIFICADO                                //
//                                                           //
///////////////////////////////////////////////////////////////


// para cada estudiante imprimo
// un certificado en una pagina nueva

// // agrego una nueva pagina al pdf
$pdf->AddPage();
// realizo un salto de linea de 20 espacios
$pdf->Ln(20);
// defino el tipo de fuente
$pdf->SetFont('Arial', '', 10, false);
// Comienzo a escribir el parrafo alineado a la derecha
$pdf->Write(5, mb_convert_encoding("La suscrita directora del ", 'ISO-8859-1', 'UTF-8'));
$pdf->SetFont('Arial', 'B', 10, false);
$pdf->Write(5, mb_convert_encoding("INSTITUTO MUNDO CREATIVO ", 'ISO-8859-1', 'UTF-8'));
$pdf->SetFont('Arial', '', 10, false);
$pdf->Write(5, mb_convert_encoding(" aprobado según Resolución No: 5216-06-2009 del 19 de junio de 2009 expedida por la Secretaría de Educación Departamental del Cauca, para los niveles de Preescolar, Educación Básica Ciclo Primaria y Secundaria, y Educación Media, establecimiento de naturaleza privada y de carácter   mixto ubicado en Santander de Quilichao, Cauca.", 'ISO-8859-1', 'UTF-8'));

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 10, false);
$pdf->Cell(180, 20, mb_convert_encoding("CERTIFICA QUE:", 'ISO-8859-1', 'UTF-8'), 0, 0, 'C', false);
$pdf->Ln(20);

if ($a_perdidas == 0){
    // Si el estudiante no perdio materias
    // entonces el estudiante es aprobado y
    // promovido al siguiente grado
    
    $pdf->SetFont('Arial', 'B', 10, false);
    $pdf->Write(5, mb_convert_encoding(strtoupper($estudiante->nombres . " " . $estudiante->apellidos), 'ISO-8859-1', 'UTF-8'));
    $pdf->SetFont('Arial', '', 10, false);
    // coloco el resto del contenido
    $pdf->Write(5,mb_convert_encoding(" en calidad de estudiante  curso y aprobó  en éste establecimiento educativo el grado $nivel de $escolaridad durante el periodo lectivo " . $obj_matricuala->year . " obteniendo las siguientes calificaciones: ",  'ISO-8859-1', 'UTF-8'));
}

elseif ($a_perdidas < 3) {

    $pdf->SetFont('Arial', 'B', 10, false);
    $pdf->Write(5, mb_convert_encoding(strtoupper($estudiante->nombres . " " . $estudiante->apellidos), 'ISO-8859-1', 'UTF-8'));
    $pdf->SetFont('Arial', '', 10, false);
    
    // de lo contrario si ha perdido menos de tres ( 1 o 2)  su estado es aplazado
    $pdf->Write(5, mb_convert_encoding(" en calidad de estudiante curso y ",  'ISO-8859-1', 'UTF-8'));
    $pdf->SetFont('Arial', 'B', 10, false);
    $pdf->Write(5, mb_convert_encoding("reprobó ",  'ISO-8859-1', 'UTF-8'));
    $pdf->SetFont('Arial', '', 10, false);
    $pdf->Write(5, mb_convert_encoding(" en calidad de estudiante en este establecimiento educativo  el  grado $nivel  durante el año lectivo " . $obj_matricuala->year . ", siendo aplazado con las siguientes calificaciones: ",  'ISO-8859-1', 'UTF-8'));
}
else{
    
    $pdf->SetFont('Arial', 'B', 10, false);
    $pdf->Write(5, mb_convert_encoding(strtoupper($estudiante->nombres . " " . $estudiante->apellidos), 'ISO-8859-1', 'UTF-8'));
    $pdf->SetFont('Arial', '', 10, false);
    // si por el contrario el estudiante a perdido tres o m�s  entronces es reprobado
    $pdf->Write(5,mb_convert_encoding(" en calidad de estudiante curso y ",  'ISO-8859-1', 'UTF-8'));
    $pdf->SetFont('Arial', 'B', 10, false);
    $pdf->Write(5,mb_convert_encoding(" reprobó ",  'ISO-8859-1', 'UTF-8'));
     $pdf->SetFont('Arial', '', 10, false);
    $pdf->Write(5,mb_convert_encoding(" en calidad de estudiante en este establecimiento educativo  el  grado $nivel  durante el año lectivo " . $obj_matricuala->year . ", con las siguientes calificaciones:  ",  'ISO-8859-1', 'UTF-8'));
}

$pdf->Ln(10); // salto de linea
$pdf->SetFillColor(230, 230, 230);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(80, 10, mb_convert_encoding("ÁREAS FUNDAMENTALES, OPTATIVAS Y ASIGNATURAS", 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
$pdf->Cell(20, 10, "I. H. S.", 1, 0, 'C', true);
$pdf->Cell(80, 5, mb_convert_encoding("VALORACIÓN DE DESEMPEÑO", 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
$pdf->Ln(5);
$pdf->Cell(100, 5, "", 0, 0, 'C', false);
$pdf->Cell(40, 5, "CUANTITATIVA", 1, 0, 'C', true);
$pdf->Cell(40, 5, "CUALITATIVA", 1, 0, 'C', true);
$pdf->Ln(5);

// obtentengo en un array  el listado de areas
// definiendo cuantas materias tiene cada grado
$lista_a = $areaObj->get_areas_grado($obj_matricuala->id_grado);

/////////////////////////////////////////////////////
//                                                 //
//    TABLA DE NOTAS                               //
//                                                 //
/////////////////////////////////////////////////////

//por cada area que debe evaluar el grado muestro 
foreach ($lista_a as  $id_area => $area_dato) {

    if ($id_area !== 12){
    // coloco en una celda el nombre del area
    $pdf->Cell(80, 5, mb_convert_encoding($area_dato[0], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L', false);
    // coloco la intensidad horaria
    $pdf->Cell(20, 5, mb_convert_encoding($arr_ih[$id_area], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', false);
    // coloco en otra celda la calificacion del area
    $pdf->Cell(40, 5, mb_convert_encoding(number_format($promedio[$e][$id_area], 1, '.', ''), 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', false);

    //--------------------------------------------------------------
    // algoritmo para colocar el color y
    // calcular el logro cualitativo de los estudiantes
    //--------------------------------------------------------------

    if ($promedio[$e][$id_area] >= 4.8) {
        $valor = "Superior";
        $pdf->SetFillColor(0, 200, 0);
    } else {
        if ($promedio[$e][$id_area] >= 4.1) {
            $valor = "Alto";
            $pdf->SetFillColor(0, 204, 255);
        } else {
            if ($promedio[$e][$id_area] >= 3) {
                $valor = "Básico";
                $pdf->SetFillColor(255, 230, 0);
            } else {
                $valor = "Bajo";
                $pdf->SetFillColor(255, 0, 0);
            }
        }
    }

    //---------------------------------------------
    // agrego el criterio de desempeño
    $pdf->Cell(40, 5, mb_convert_encoding($valor, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
    $pdf->Ln(5);
    }
} // fin de areas

// coloco en una celda el nombre del area
$pdf->Cell(80, 5, mb_convert_encoding("Convivencia", 'ISO-8859-1', 'UTF-8'), 1, 0, 'L', false);
// el espacio para la intensidad horaria
$pdf->Cell(20, 5, mb_convert_encoding("", 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', false);
// coloco en otra celda la calificacion del area
$pdf->Cell(40, 5, mb_convert_encoding(number_format($promedio[$e][12], 1, '.', ''), 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', false);
//--------------------------------------------------------------
// algoritmo para colocar el color y
// calcular el logro cualitativo de los estudiantes
//--------------------------------------------------------------

if ($promedio[$e][12] >= 4.8) {
    $valor = "Superior";
    $pdf->SetFillColor(0, 200, 0);
} else {
    if ($promedio[$e][12] >= 4.1) {
        $valor = "Alto";
        $pdf->SetFillColor(0, 204, 255);
    } else {
        if ($promedio[$e][12] >= 3) {
            $valor = "Básico";
            $pdf->SetFillColor(255, 230, 0);
        } else {
            $valor = "Bajo";
            $pdf->SetFillColor(255, 0, 0);
        }
    }
}

//---------------------------------------------
// agrego el criterio de desempeño
$pdf->Cell(40, 5, mb_convert_encoding($valor, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
$pdf->Ln(5);

$pdf->SetFillColor(255, 255, 255); // se restablece el color blanco
$pdf->Cell(180, 5,mb_convert_encoding( "Número de áreas :" . $num_areas , 'ISO-8859-1', 'UTF-8'), 1, 0, 'L', true);

setlocale(LC_TIME, 'es_ES.UTF-8', 'esp');
$dia_nombre = strftime("%A");
$dia_num = date("j");
$mes = strftime("%B");
$anio = date("Y");

$pdf->SetFont('Arial', '', 10);
$pdf->Ln(10);
$pdf->Multicell(180, 5, mb_convert_encoding( "Para constancia se expide a solicitud del interesado, en el Municipio de Santander de Quilichao, Cauca, "."el día $dia_nombre $dia_num del mes de $mes de $anio.", 'ISO-8859-1', 'UTF-8'), 0, 'L', false);

$pdf->Ln(30);
$pdf->Cell(180, 5, "_______________________________________________", 0, 0, 'C', false);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(180, 5, "LAURA MARCELA PALACIOS", 0, 0, 'C', false);
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(180, 5, "Rectora", 0, 0, 'C', false);

// cierra dato 1 de los grados
ob_end_clean();
$pdf->Output('I', "certificado_".$obj_grado->grado."_".strtolower($estudiante->nombres) . "_" .strtolower( $estudiante->apellidos)."_$e.pdf");
unset($estudiante);
