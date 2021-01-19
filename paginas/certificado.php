<?php
// se inserta este fichero para generar el documento en pdf
// correspondiente al boletin de calificaciones del periodo
// asignado.

// requiere que se posea el fiechereo fpdf para generar
require('../fpdf/fpdf.php');
//require('../fpdf/html_table.php');
// se requiere este fichero para realizar la conexion con
// el gestor de bases de datos base de datos mysql
require_once 'conexion.php';

// se crean las siguientes variables
// con obtenida a travez del formulario formulario_boletines

// Estas son las variables que obtienen de el cliente
// mediante el m�todo GET
$fecha = $_GET["year"];			// carga el valor  en la variable fecha
$periodo = 4;   // carga el peri�do del cual se quiere generar el bolet�n
$grado = $_GET["grado"];        // carga el grado  sobre el cual se van a generar
// los boletines
setlocale(LC_ALL,"es_ES");


// define el tipo de codificaci�n para la letra
header("Content-Type: text/html;charset=utf-8");
// CONEXION CON LA BASE DE DATOS
$link = conectar();
// establece la codificacion UTF-8 para el documento
//mysqli_query("SET NAMES 'utf8'");


mysqli_query($link, "SET NAMES 'utf8'");



// Se establece el tipo de cabecera  que tendra el documento
class PDF extends FPDF

{
    //Cabecera de pagina
    function Header()
    {

        // se incerta el logo de la insticuci�n
        $this->Image('../imagenes/escudo_colegio.png',20,12.5,25,30);
        $this->Image('../imagenes/fondo_escudo.png',20,50,165,220);
        $this->Cell(20,15,"",0);
        $this->SetFont('Times','BI',20);
        // Se crea una etiqueta con el logo de la instituci�n
        $this->Cell(150,15,"INSTITUTO MUNDO CREATIVO ",0,0,'C');
        $this->Ln(15);
        $this->SetFont('Times','I',8);
        $this->Cell(20,5,"",0);
        $this->Cell(150,5, utf8_decode("Resolución de Aprobación No 5216-06-2009 del 19 de Junio de 2009 "),0,0,'C');
        $this->Ln(5);
        $this->Cell(20,5,"",0);
        $this->Cell(150,5, utf8_decode("Preescolar, Educación Básica Ciclo Primaria y Secundaria y Edicación Media "),0,0,'C');


    }


    //Pie de pagina
    function Footer()
    {

        //Posici�n: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial','',8);
        //N�mero de p�gina
        $txt = utf8_decode("Otros servicios: Programas Técnicos , Cursos cortos y ")
             .utf8_decode("Programas tecnolígicos (Convenio con Tecnológica")
             .utf8_decode(" Autónoma del Pacífico)");

        $this->Cell(0,5,$txt,0,0,'C');
        $this->Ln(3);
        $txt = "Info: Tel 829 5741, Cel.3166288374, WhatsApp. "
             ."3164469532, Email:imcreativo@hotmail.com, "
             ." www.imcreativo.edu.co ";
        $this->Cell(0,5,$txt,0,0,'C');
    }

}

// se crea un nuevo documento de PDF
$pdf=new PDF();


// consulta para obtener  los datos del grado a evaluar
// pues el documento PDF es relativo a un solo grado en
// particular
$qg = "SELECT * FROM grados WHERE id_grado =".$grado;

// se ejecuta la consulta de los grados
$qgx = mysqli_query($link, $qg) or die('Consulta a tabla  grados  fallida: ' . mysql_error());

// Recupero los datos del grado $grado
$datog = mysqli_fetch_array($qgx);
// Recupero el nombre del grado
$nivel = $datog['grado'];
$nombre_g = $datog['nombre_g'];
$escolaridad = $datog['escolaridad'];
$promovido = $datog['promovido'];

// Esta consulta recupero todas las notas  de un grado realizadas durante un a�o lectivo
// esto es necesario ya que en  boletin se muestran todas las  notas ingresadas
// durante el a�o lectivo para todos los estudiantes de un grado.

$q3 = "SELECT DISTINCT  alumnos.id_alumno, alumnos.nombres, alumnos.apellidos
FROM ((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id_alumno)
INNER JOIN logros ON calificaciones.id_logro = logros.id_logro)
INNER JOIN docentes ON calificaciones.id_docente = docentes.id_docente)
INNER JOIN materia ON calificaciones.id_materia = materia.id_materia)
INNER JOIN matricula ON (calificaciones.id_alumno = matricula.id_alumno AND matricula.id_grado ="
.$grado." AND matricula.year = ".$fecha.")
ORDER BY alumnos.id_alumno";
//WHERE calificaciones.year =".$fecha."
//AND calificaciones.periodo =".$periodo."

// se ejecuta la aconsulta en la base de datos
$q3x = mysqli_query($link, $q3) or die('Consulta fallida q3: ' . mysql_error());

//
//	ENCABEZADO DE NOMBRE
//

// CICLO DE REPETICION PARA EXPLORAR LOS ESTUDIANTES

// Se ejecuta este ciclo de repeticion por cada uno de los elementos de la consulta
//

while($dato2 = mysqli_fetch_array($q3x)) {



    //extrae los datos de la consulta q3x en la variable tipo arrelo dato

    // VARIABLES PARA GUARDAR LOS NOMBRES DE LOS ESTUDIANTES
    $id_n = "".$dato2['id_alumno']."";		// guarda en grado el string del grado  rodeado por comillas simples
    $nombres = $dato2['nombres'];
    $apellidos = $dato2['apellidos'];
    $a_perdidas = 0; // contador que identifica el numero de areas perdidas

    // ENCABEZADO DE CELDAS	//////////////////////////////
    // Aqui se le coloca el los datos correspondientes a cada estudiante
    $pdf->AddPage();
    $pdf->Ln(20);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetFont('Arial','',10,false);
    $pdf->Multicell(180,5,utf8_decode("La suscrita directora del INSTITUTO MUNDO CREATIVO aprobado según Resolución No: 5216-06-2009 del 19 de junio de 2009 expedida por la Secretaría de Educación Departamental del Cauca, para los niveles de Preescolar, Educación Básica Ciclo Primaria y Secundaria, y Educación Media, establecimiento de naturaleza privada y de carácter    mixto ubicado en Santander de Quilichao, Cauca."),0,'C',false);


    $pdf->Ln();
    $pdf->SetFont('Arial','B',12,false);
    $pdf->Cell(180,20,utf8_decode("CERTIFICA QUE:"),0,0,'C');

    // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

    // encabezado para la tabla resumen
    //



    // consula sql que consulta las �reas vistas por
    // cada estudiante, al  realizar la consulta
    // se retorna un array con los c�digos de las
    // �reas vistas por el estudiante de
    // acuerdo al c�digo.

    $q4 = "SELECT  DISTINCT materia.id_area, materia.area"
        ." FROM ((((calificaciones INNER JOIN alumnos "
        ." ON calificaciones.id_alumno = alumnos.id_alumno) "
        ." INNER JOIN logros ON calificaciones.id_logro = logros.id_logro) "
        ." INNER JOIN docentes ON calificaciones.id_docente = docentes.id_docente) "
        ." INNER JOIN materia ON calificaciones.id_materia = materia.id_materia) "
        ." INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno "
        ." AND matricula.id_grado =".$grado
        ." WHERE calificaciones.id_alumno=" .$id_n
        ." AND calificaciones.year =".$fecha
        ." AND calificaciones.periodo =".$periodo
        ." ORDER BY materia.id_area";

    // ejecucion de la consulta para obtener las areas de
    // competencia evaluadas por el estudiante
    // cada cosulta representa el area cursada por
    // el estudiante.
    //$pdf->Ln(5);
    //   $pdf->Cell(80,5,'consulta :'.$q4,10,0,'L',false);
    // $pdf->Multicell(180,5,'consulta :'.$q4,0,'L',false);
    // echo "<br><br>consulta :".$q4;
    $q4x = mysqli_query($link, $q4) or die('Consulta fallida q4: ' . mysql_error());;

    // CICLO DE REPETICION DE AREA

    $avg = 0; // promedio de calificaciones
    $num_m = 0; // cuenta la cantidad de materias cursadas
    $t = 0; //contador de la trabla de �reas
    $tabla = array();// array que contiene las �reas cursadas
    // ejecuta el ciclo de repeticion para  cada una
    // de las �reas cursadas.


    while($dato3 = mysqli_fetch_array($q4x)) {

        
        $area = $dato3['area'];  // recupero el nombre del area
        $id_a = $dato3['id_area']; // recupero en codigo del area

        $nota_a = array(); // array que contiene las notas de cada area
        $nota_r = array(); // array que contiene las notas del area con recuperacion
        $materia_a = 0; //contador de materias del area inicia en 1
        $recupero = false;


        $ih_t = 0; // sumatoria de la intensidad horaria de cada
                   // area
        // ENCABEZADO DE AREA
        /////////////////////////////////////////////
        // consulta para estructurar las materias que pertenecen a cada área

        $q5 = "SELECT  DISTINCT materia.id_materia, materia.materia, materia.ih"
            ." FROM ((((calificaciones INNER JOIN "
            ." alumnos ON calificaciones.id_alumno = alumnos.id_alumno)"
            ." INNER JOIN logros ON calificaciones.id_logro = logros.id_logro) "
            ." INNER JOIN docentes ON calificaciones.id_docente = docentes.id_docente)"
            ." INNER JOIN materia ON calificaciones.id_materia = materia.id_materia) "
            ." INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno"
            ." AND matricula.id_grado =".$grado
            ." WHERE calificaciones.id_alumno=" .$id_n
            ." AND materia.id_area =".$id_a
            ." AND calificaciones.year =".$fecha
            ." AND calificaciones.periodo =".$periodo
            ." ORDER BY materia.id_area, materia.id_materia";

        // ejecucion de la consulta para investigar
        // por las materias relacionadas con el area

        $q5x = mysqli_query($link, $q5)
             or die('Consulta fallida q5: '
                    . mysqli_error());;

        // ciclo de repeticion de materias se repite
        // de acuerdo a cuantas materias tiene cada area

        while($dato4 = mysqli_fetch_array($q5x)) {

            // recupera el id (codigo) de la materia en la variable id_m
            $id_m = $dato4['id_materia'];
            $ih = $dato4['ih'];

            // A partir de aqui se construyen las consultas
            // para  extraer las notas  de cada periodo
            // en las variables $p1 ... $p2
            // inicializamos los acumuladores
            $p1 = 0; // nota del primer periodo
            $p2 = 0; // nota del segundo periodo
            $p3 = 0; // nota del tercer periodo
            $p4 = 0; // nota del cuarto periodo

            // ciclo que se repite desde el periodos i= 1 hasta i=4
            for($i = 1;$i < 5;$i++) {

                // consulta que selecciona una materia especifica para cada uno de los  cuatro periodos

                $q6 =" SELECT  DISTINCT materia.id_materia, materia.materia, "
                    ." calificaciones.nota, docentes.nombres, docentes.apellidos"
                    ." FROM ((((calificaciones INNER JOIN alumnos ON "
                    ." calificaciones.id_alumno = alumnos.id_alumno) "
                    ." INNER JOIN logros ON calificaciones.id_logro = logros.id_logro) "
                    ." INNER JOIN docentes ON calificaciones.id_docente = docentes.id_docente) "
                    ." INNER JOIN materia ON calificaciones.id_materia = materia.id_materia) "
                    ." INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno "
                    ." AND	 matricula.id_grado =".$grado
                    ." WHERE calificaciones.id_alumno=" .$id_n
                    ." AND materia.id_materia =".$id_m
                    ." AND calificaciones.year ='".$fecha
                    ."' AND calificaciones.periodo =".$i
                    ." ORDER BY materia.id_area, materia.id_materia";

                // ejecuto la consulta
                $q6x = mysqli_query($link, $q6) or die('Consulta fallida q6: '
                                                      . mysqli_error());;

                // este ciclo se ejecuta para  cada periodo -
                // materia grado y estudiante
                while($dato5 = mysqli_fetch_array($q6x)) {

                    // recupera el dato de la materia para el periodo i
                    $materia = $dato5['materia'];
                    // recupero la nota de la materia para el periodo i
                    $nota = $dato5['nota'];


                    switch ($i) {
                        // la nota se guarde en $p1, $p2 .. $p4

                    case 1: // si esta en el periodo 1
                        $p1 = $nota;
                        break;
                    case 2: // si esta en el periodo 2
                        $p2 = $nota;
                        break;
                    case 3: // si esta en el periodo 3
                        $p3 = $nota;
                        break;
                    case 4: // si esta en el periodo 4
                        $p4 = $nota;
                        break;
                    }


                }	// fin del ciclo while

            }		// fin del ciclo for de periodo



            // extraigo el promedio de los cuatro periodos
            $ac = ($p1+$p2+$p3+$p4)/4;
            $ac = number_format($ac, 1, '.', '');

            // gurado la nota acumulada en el vector del area
            $nota_a[$materia_a] = $ac;

            /// calcular  si la nota tiene recuperacion

            $qp = "SELECT  *
                  FROM (calificaciones INNER JOIN alumnos"
                ." ON calificaciones.id_alumno = alumnos.id_alumno) "
                ." INNER JOIN materia ON calificaciones.id_materia = materia.id_materia
                  WHERE calificaciones.id_alumno= $id_n
                  AND calificaciones.year = $fecha
                  AND calificaciones.periodo = 5
                  AND calificaciones.nota > 0
                  AND calificaciones.id_materia = $id_m";


            $qpx = mysqli_query($link, $qp)
                 or die('Consulta fallida qp, mostrando las materia recuperada, error: '
                        . mysql_error());;

            // consulta si la nota tiene recuperacion para sacar el promedio con recuperacion
            // y el promedio sin
            $datorm = mysqli_fetch_array($qpx);
            // miro si la nota tiene recuperacion


            if ($datorm["nota"]){
                // se guarda la nota recuperada en el vector de recupracion
                $nota_r[$materia_a] = $datorm["nota"];
                $recupero = true;
            }
            else {
                // se gurara la nota acumulada en el vector de recuperacion
                $nota_r[$materia_a] = $ac;
            }

            $materia_a++; //incremento en contador de materias del area

            $num_m = $num_m +1; // cuenta el numero de materias

            $ih_t = $ih_t + $ih;
        } // cierra dato 4

        /// ciclo for para calcular el promedio del area

        $num_m_a = count($nota_a);// numero de materias por area

        $avg_a = 0; /// variable que calcula el promedio del area

        // ciclo de repeticion para calcular la nota acumulada
        // sin incluir las notas de recuperaciones

        $ii =0;

        while($ii <= ($num_m_a-1) ){
            $avg_a = $nota_a[$ii]+$avg_a; // se hace una sumatoria de las notas del area
            $ii++;
        }

        //for ($ii =0;$ii <= ($num_m_a-1);$ii++){
        //    $avg_a = $nota_a[$ii]+$avg_a; // se hace una sumatoria de las notas del area
        //}

        // se calcula el promedio del area
        $avg_a =  number_format($avg_a / $num_m_a, 1, '.', '');

        // PROMEDIO RECUPERACIOENES
        $avg_ar = 0; /// variable que calcula el promedio del area con recuperaciones

        $ii =0;

        // ciclo de repeticion para calcular la nota acumulada
        // incluillendo las notas de recuperaciones
        while($ii <= ($num_m_a-1) ){
            $avg_ar = $nota_r[$ii]+$avg_ar; // se hace una sumatoria de las notas del area con recuperaciones
            $ii++;
        }

        //for ($ii =0;$ii <= $num_m_a ;$ii++){
        //    $avg_ar = $nota_r[$ii]+$avg_ar; // se hace una sumatoria de las notas del area con recuperaciones
        //}

        $avg_ar =  number_format($avg_ar / $num_m_a, 1, '.', ''); // se calcula el promedio del area con recuperacion

        // calculo el mayor entre el promedio del area  y el promedio con recuperaciones
        if($avg_a > $avg_ar){
            $avg_at = $avg_a; // el promedio total sera el acumulado
        }
        else{
            $avg_at = $avg_ar; // el promedio total sera el de las recuperaciones
        }

        // algoritmo que cuenta las areas perdidas
        if ($avg_at < 3){
            if ($id_a != 20){
                $a_perdidas ++;// incremento el contador de areas perdidas siempre y cuando no sea disciplina
            }
        }
        // si ha recuperado imprimo el dato de la recuperacion
        // de lo contrario no lo imprimo
        if ($recupero){
            $avg_print = " (".$avg_at.")";
        }
        else{
            $avg_print = ""; //
        }


        // formateo el promedio total
        $avg_at = number_format($avg_at, 1, '.', '');


        $tabla[$t][0] = $area;
        $tabla[$t][1] = $ih_t;
        $tabla[$t][2] = $avg_at;

        //$pdf->Ln(5);
        //$pdf->Cell(80,5,'Area :'.$tabla[$t][0],10,0,'L',false);
        //$pdf->Cell(40,5,"CUALITATIVA",1,0,'C',true);


        $t ++ ; // incremento el contador de la tabla �reas



    }  // cierra  ciclo while de dato  3

    $pdf->Ln();
    $pdf->SetFont('Arial','',10,false);

    // si el grado es diferente de 11
    // comienzo a generar el mensaje de apreobado
    if ($grado != 2) {

        $pdf->Ln(5); // se genera una nueva linea

        if ($a_perdidas == 0){
            // Si el estudiante no perdio materias
            // entonces el estudiante es aprobado y
            // promovido al siguiente grado
            //$html = "$nombres $apellidos en calidad de estudiante  curso y aprobó  en éste establecimiento educativo el grado $nombre_g de $escolaridad durante el periodo lectivo $fecha obteniendo las siguientes calificaciones: ";
            //$pdf->WriteHTML($html);
            $pdf->Multicell(180,5,utf8_decode("$nombres $apellidos en calidad de estudiante  curso y aprobó  en éste establecimiento educativo el grado $nombre_g de $escolaridad durante el periodo lectivo $fecha obteniendo las siguientes calificaciones: "),0,'L',false);
        }

        elseif ($a_perdidas < 3) {
            // de lo contrario si ha perdido menos de tres ( 1 o 2)  su estado es aplazado
            $pdf->Multicell(180,5, utf8_decode("$nombres $apellidos en calidad de estudiante curso y reprobó  en este establecimiento educativo  el  grado $nivel  durante el año lectivo $fecha, siendo aplazado con las siguientes calificaciones: "),0,'L',false);
        }
    else{
        // si por el contrario el estudiante a perdido tres o m�s  entronces es reprobado
        $pdf->Multicell(180,5,utf8_decode("$nombres $apellidos en calidad de estudiante curso y reprobó  en este establecimiento educativo  el  grado $nivel  durante el año lectivo $fecha, con las siguientes calificaciones:  "),0,'L',true);
    }


    }

    // se calculan el numero de areas  realizadas
     $num_areas = count($tabla);// numero de materias por area

    $pdf->Ln(5); // salto de linea
    $pdf->SetFillColor(230, 230, 230);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,10,utf8_decode("ÁREAS FUNDAMENTALES, OPTATIVAS Y ASIGNATURAS"),1,0,'C',true);
    $pdf->Cell(20,10,"I. H. S.",1,0,'C',true);
    $pdf->Cell(80,5,utf8_decode("VALORACIÓN DE DESEMPEÑO"),1,0,'C',true);
    $pdf->Ln(5);
    $pdf->Cell(100,5,"",0,0,'C',false);
    $pdf->Cell(40,5,"CUANTITATIVA",1,0,'C',true);
    $pdf->Cell(40,5,"CUALITATIVA",1,0,'C',true);

    // ciclo de repeticion que muestra los datos de la tabla
    // de notas
    $t = 0;
    //$pdf->Ln(5);
    //$pdf->Cell(40,5,"numero de areas :".$num_areas,1,0,'C',true);
    
    while( $t < $num_areas){

        $pdf->Ln(5); // se genera una nueva linea
        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(255, 255, 255); // se define el color de fondo

        $pdf->Cell(80,5,utf8_decode($tabla[$t][0]),1,0,'L',false);
        // se agrega la intensidad horaria
        $pdf->Cell(20,5,$tabla[$t][1],1,0,'C',false);
        // se inserta la nota promedio
        $pdf->Cell(40,5,$tabla[$t][2],1,0,'C',false);

        //------------------------------------------
        // algoritmo para colocar el color y
        // calcular el logro cualitativo de los estu
        // diantes
        if($tabla[$t][2] >= 4.8) {
            $valor = "Superior";
            $pdf->SetFillColor(0, 200, 0);
        }
        else {
            if($tabla[$t][2] >= 4.1) {
                $valor = "Alto";
                $pdf->SetFillColor(0, 204, 255);
            }
            else {
                if($tabla[$t][2] >= 3) {
                    $valor = utf8_decode("Básico");
                    $pdf->SetFillColor(255, 230, 0);
                }
                else {
                    $valor = "Bajo";
                    $pdf->SetFillColor(255, 0, 0);
                }
            }
        }
        //---------------------------------------------
        $pdf->Cell(40,5,$valor,1,0,'C',true);


        $pdf->SetFillColor(255, 255, 255);// se restablece el color blanco

        $t ++;



    }
    $pdf->Ln(5);
    $pdf->Cell(40,5,"numero de areas :".$num_areas,1,0,'C',true);

    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    //$mes = $mes[(date('m')];


    $pdf->SetFont('Arial','',10);
    $pdf->Ln(10);
    $pdf->Multicell(180,5,utf8_decode(strftime("Para constancia se expide a solicitud de la interesada, en el Municipio de Santander de Quilichao, Cauca, el día %A  %e  del mes de %B de %Y.")),0,'L',false);

     $pdf->Ln(30);
     $pdf->Cell(180,5,"_______________________________________________",0,0,'C',false);

     $pdf->Ln(5);
     $pdf->SetFont('Arial','B',10);
     $pdf->Cell(180,5,"ANA POLONIA CARABALI VILLEGAS",0,0,'C',false);
     $pdf->Ln(5);
     $pdf->SetFont('Arial','',10);
     $pdf->Cell(180,5,"Rectora",0,0,'C',false);
}// fin del ciclo while


// cierra dato 1 de los grados

$pdf->Output();

desconectar($link);


?>
