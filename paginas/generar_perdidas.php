<?php
require('../fpdf/fpdf.php');
require_once 'conexion.php';
// se crean las siguientes variables
// con obtenida a travez del formulario formulario_boletines

$fecha = 2018;//$_GET["year"];				// carga el valor  en la variable fecha
$periodo = 4;//$_GET["periodos"];
$grado = $_GET["grado"]; // guarda el codigo del grado  en la variable $gradox

$w_a = 0.5; // peso del corte a
$w_f = 0.5; // peso del corte final

// se inserta este fichero para generar el documento en pdf

// define el tipo de codificación para la letra
header("Content-Type: text/html;charset=utf-8");
// CONEXION CON LA BASE DE DATOS
$link = conectar();

mysqli_query("SET NAMES 'utf8'");


// Se establece el tipo de cabecera  que tendra el documento
class PDF extends FPDF

{
    //Cabecera de págin

}

// se crea un nuevo documento de PDF
$pdf=new PDF();


// ciclo de repeticion para los grados

for ($gr = 1; $gr < 7; $gr ++) {

    // asigno el codigo al grado
    $grado = $gr;


    // este guarda el string para la creacion del greado
    $qg = "SELECT * FROM grados WHERE id_grado =".$grado;
    // se crea la consulta
    $qgx = mysqli_query($link, $qg) or die('Consulta fallida q3: ' . mysql_error());
    // se ejecuta la consulta
    $datog = mysqli_fetch_array($qgx);  //extrae los datos de la consulta q3x en la variable tipo arrelo dato
    // VARIABLES PARA GUARDAR LOS NOMBRES DE LOS ESTUDIANTES
    $nivel = $datog['grado'];
    // se almacena el grado al que es promovido
    // para el   grado actual los estudiantes
    // de este grado
    $promovido = $datog['promovido'];


    // almaceno el string de la consulta que
    // almacena ten lista todos los alumnos
    // que poseen calificaciones para
    // el año   y el perdiodo seleccionado
    $q3 = "SELECT DISTINCT  alumnos.id_alumno,
alumnos.nombres, alumnos.apellidos
FROM ((((calificaciones INNER JOIN alumnos ON
  calificaciones.id_alumno = alumnos.id_alumno)
INNER JOIN logros ON calificaciones.id_logro = logros.id_logro)
INNER JOIN docentes ON calificaciones.id_docente = docentes.id_docente)
INNER JOIN materia ON calificaciones.id_materia = materia.id_materia)
INNER JOIN matricula ON (calificaciones.id_alumno = matricula.id_alumno AND matricula.id_grado =".$grado." AND matricula.year = ".$fecha.")
WHERE calificaciones.year =".$fecha."
AND calificaciones.periodo =".$periodo;
    // se crea la consulta
    $q3x = mysqli_query($link, $q3) or die('Consulta fallida q3: ' . mysql_error());;

    //
    //	ENCABEZADO DE NOMBRE
    //
    // CICLO DE REPETICION PARA EXPLORAR LOS ESTUDIANTES


    /// se recupera cada valor de la consultas
    // para lo cual queda almacenado un array en legal
    // variable $dato2
    while($dato2 = mysqli_fetch_array($q3x)) { //extrae los datos de la consulta q3x en la variable tipo arrelo dato

        $p = Array(Array(Array())); // aaray que almacena las notas de un alumno.
        $f = Array(Array(Array())); // array que almacena las faltas
        // VARIABLES PARA GUARDAR LOS NOMBRES DE LOS ESTUDIANTES
        // se recupera el código del alumno
        // en la posicion id_alumno del array asociativo
        $id_n = "".$dato2['id_alumno']."";		// guarda en grado el string del grado  rodeado por comillas simples
        // recupero el codigo del alumno
        $nombres = $dato2['nombres'];
        // estables co los apellidos del alumno
        $apellidos = $dato2['apellidos'];
        // pongo a 0 las materas perdidas
        $a_perdidas = 0; // contador que identifica el numero de areas perdidas


        // ENCABEZADO DE CELDAS	//////////////////////////////
        // usando la libreria FPDF
        //$pdf->AddPage();
        
        // estructura  que filtra el área de notificación con fin de estructurar
        // la tabla de  contenidos

        $q4 = "SELECT  DISTINCT materia.id_area, materia.area
    FROM ((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id_alumno)
    INNER JOIN logros ON calificaciones.id_logro = logros.id_logro)
    INNER JOIN docentes ON calificaciones.id_docente = docentes.id_docente)
    INNER JOIN materia ON calificaciones.id_materia = materia.id_materia)
    INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno
    AND matricula.id_grado =".$grado."
    WHERE calificaciones.id_alumno=" .$id_n."
    AND calificaciones.year =".$fecha."
    AND calificaciones.periodo =".$periodo."
    ORDER BY materia.id_area";

        // ejecucion de la consulta para obtener las areas de competencia evaluadas por el estudiante

        $q4x = mysqli_query($link, $q4) or die('Consulta de seleccion de areas fallida q4: ' . mysql_error());;

        // CICLO DE REPETICION DE AREA
        // variables de repeticion de area
        $avg = 0;
        $num_m = 0;

        // se repite este ciclo para cada area
        while($dato3 = mysqli_fetch_array($q4x)) {
            // recupereo el codigo del area que se esta tratando
            $area = $dato3['area'];
            // recupero el codigo del area que se esta tratando
            $id_a = $dato3['id_area'];

            $nota_a = array(); // array que contiene las notas de cada area
            $nota_r = array(); // array que contiene las notas del area con recuperacion
            $materia_a = 0; //contador de materias del area inicia en 1
            $recupero = false;

            // ENCABEZADO DE AREA
            /////////////////////////////////////////////
            // consulta para estructurar las materias que pertenecen a cada área

            $q5 = "SELECT  DISTINCT materia.id_materia, materia.materia
        FROM ((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id_alumno)
        INNER JOIN logros ON calificaciones.id_logro = logros.id_logro)
        INNER JOIN docentes ON calificaciones.id_docente = docentes.id_docente)
        INNER JOIN materia ON calificaciones.id_materia = materia.id_materia)
        INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno
        AND matricula.id_grado =".$grado."
        WHERE calificaciones.id_alumno=" .$id_n. "
        AND materia.id_area =".$id_a."
        AND calificaciones.year =".$fecha."
        AND calificaciones.periodo =".$periodo."
        ORDER BY materia.id_area, materia.id_materia"
                ;
            // ejecucion de la consulta para investigar  por las materias relacionadas con el area
            $q5x = mysqli_query($link, $q5) or die('Consulta fallida q5: ' . mysql_error());;

            // ciclo de repeticion de materias se repite  de acuerdo a cuantas materias tiene cada area
            while($dato4 = mysqli_fetch_array($q5x)) {
                // la materia en cuestion
                $id_m = $dato4['id_materia']; // identificador de materia
                // se crea un array


                // A partir de aqui se construyen las consultas para
                // extraer las notas  de cada periodo
                // en las variables $p1 ... $p2
                // inicializamos los acumuladores
                $p1 = 0; // periodo 1
                $p2 = 0; // periodo 2
                $p3 = 0; // periodo 3
                $p4 = 0; // periodo 4

                // ciclo for que iteratua dentro de los cuatro periodos
                for($i = 1;$i < 5;$i++) {
                    // consulta que selecciona una materia especifica
                    // para cuatro periodos
                    $q6 = "SELECT  DISTINCT materia.id_materia,
                materia.materia,
                calificaciones.nota,
                docentes.nombres,
                docentes.apellidos,
                calificaciones.corte,
                calificaciones.faltas
                FROM ((((calificaciones INNER JOIN alumnos ON
                  calificaciones.id_alumno = alumnos.id_alumno)
                INNER JOIN logros ON calificaciones.id_logro = logros.id_logro)
                INNER JOIN docentes ON calificaciones.id_docente = docentes.id_docente)
                INNER JOIN materia ON calificaciones.id_materia = materia.id_materia)
                INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno
                AND	 matricula.id_grado =".$grado."
                WHERE calificaciones.id_alumno=" .$id_n. "
                AND materia.id_materia =".$id_m."
                AND calificaciones.year ='".$fecha."'
                AND calificaciones.periodo =".$i."
                ORDER BY materia.id_area, materia.id_materia";

                    // se crea la consulta  para la materia del
                    // alumno  en un grado especifico
                    $q6x = mysqli_query($link, $q6)
                         or die('Consulta fallida q6: ' . mysql_error());;

                    // se ejecuta la consulta para
                    // extraer la
                    while($dato5 = mysqli_fetch_array($q6x)) {

                        $materia = $dato5['materia'];// recupera el dato de la materia para el periodo i
                        $nota = $dato5['nota'];// recupero la nota de la materia para el periodo i
                        $corte = $dato5['corte']; // recupero en corte de la calificacion
                        $faltas= $dato5['faltas']; // recupero las faltas almacenads para el corte
                        // estructura de seleccion para decodificar
                        // el corte en la variable $c
                        // echo "<br>Datos para la materia $materia con nota $nota en el corte $corte <br><br>";
                        switch ($corte) {
                        case 'A':
                            $c = 1;// code...
                            break;

                        case 'F':
                            $c = 0;
                            break;

                        default:
                            $c = 0;// code...
                            break;
                        }

                        // asignamos la nota a la matriz
                        // compuesta por tres coordenadas
                        // materia  ---> $id_m
                        // periodo ----> $i
                        // corte ------> $c
                        // de modo que todas las notas del estudiante
                        // se cargan en este vector
                        $p[$id_m][$i][$c] = $nota;
                        // igualmente se almacenan las faltas
                        $f[$id_m][$i][$c] = $faltas;
                        // echo "<br>Asi va P (valor de c --> $c): <br><br>";
                        // print_r($p);
                    }	// fin del ciclo while

                } // fin del for

                // calcula la nota promedio
                //$avg = $avg + $p[$id_m][$periodo][0]*$w_f+$p[$id_m][$periodo][1]*$w_a;	// sumatoria de notas
                // nota acumulada segun el peso

                //$ac = $p[$id_m][1][0];
                // echo "<br>Matriz <br><br>:";
                // print_r($p);
                // eta matriz establece el acumulado de  las notas
                // durante los cuatro periosdos
                $ac = (($p[$id_m][1][0]*$w_f)+($p[$id_m][1][1]*$w_a)
                       +($p[$id_m][2][0]*$w_f)+($p[$id_m][2][1]*$w_a)
                       +($p[$id_m][3][0]*$w_f)+($p[$id_m][3][1]*$w_a)
                       +($p[$id_m][4][0]*$w_f)+($p[$id_m][4][1]*$w_a))/4;
                // calculo del acumulado de notas

                // si se trata del cuato periodo caculo la nota del area en base
                // al acumulado
                if ($periodo == 4){
                    $nota_a[$materia_a] = $ac; // gurado la nota acumulada en el vector del area

                }
                else{
                    $nota_a[$materia_a] = $p[$id_m][$periodo][0]*$w_f+$p[$id_m][$periodo][1]*$w_a; // nota  de la mateia
                }


                /// calcular  si la nota tiene recuperacion

                $qp = "SELECT  *
                  FROM (calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id_alumno)
                  INNER JOIN materia ON calificaciones.id_materia = materia.id_materia
                  WHERE calificaciones.id_alumno= $id_n
                  AND calificaciones.year = $fecha
                  AND calificaciones.periodo = 5
                  AND calificaciones.nota > 0
                  AND calificaciones.id_materia = $id_m";


                $qpx = mysqli_query($link, $qp) or die('Consulta fallida qp, mostrando las materia recuperada, error: ' . mysql_error());;

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

                $p1 = number_format(($p[$id_m][1][0]*$w_f)+($p[$id_m][1][1]*$w_a), 1, '.', '');
                $p2 = number_format(($p[$id_m][2][0]*$w_f)+($p[$id_m][2][1]*$w_a), 1, '.', '');
                $p3 = number_format(($p[$id_m][3][0]*$w_f)+($p[$id_m][3][1]*$w_a), 1, '.', '');
                $p4 = number_format(($p[$id_m][4][0]*$w_f)+($p[$id_m][4][1]*$w_a), 1, '.', '');
                $ac = number_format($ac, 1, '.', '');

                if($p1 == 0.0){$p1 = "";}
                if($p2 == 0.0){$p2 = "";}
                if($p3 == 0.0){$p3 = "";}
                if($p4 == 0.0){$p4 = "";}

                $pdf->SetFont('Arial','B',8);
                //$pdf->Ln(3);
                //$pdf->Cell(50,3,utf8_decode($area),1,0,'L');
                //$pdf->Cell(50,3,utf8_decode($materia),1,0,'L');

                // esta rutina coloca los colores a las celdas
                // para el primer periodo


                if($p1<3 and $p1>0.1) {
                    //$pdf->SetFillColor(255, 0, 0); // pintar de rojo
                }
                else {
                    //    $pdf->SetFillColor(255, 255, 255);
                }

                //$pdf->Cell(15,3,$p1,1,0,'C',true);// imprime el primer periodo

                // pinta de rojo  la celda del segundo periodo si la nota es baja
                if($p2<3 and $p2 >0.1 and $periodo > 1) {
                    //$pdf->SetFillColor(255, 0, 0);
                }// pintar de rojo
                else {
                    //$pdf->SetFillColor(255, 255, 255);
                }

                // coloca la nota del segundo periodo  a partir del mismo
                if($periodo > 1) {
                    //$pdf->Cell(15,3,utf8_decode($p2),1,0,'C',true);
                }

                else {
                    //$pdf->Cell(15,3,'',1,0,'C',true);
                }

                // pinta de rojo  la celda del tercer periodo si la nota es baja
                if($p3<3 and $p3 >0.1  and $periodo > 2) {
                    //$pdf->SetFillColor(255, 0, 0);
                }// pintar de rojo
                else {	$pdf->SetFillColor(255, 255, 255);}

                // coloca la nota del tercer periodo  a partir del mismo
                if($periodo > 2) {
                    //$pdf->Cell(15,3,utf8_decode($p3),1,0,'C',true);
                }
                else {
                    //$pdf->Cell(15,3,'',1,0,'C',true);
                }


                // pinta de rojo  la celda del tercer periodo si la nota es baja
                if($p4<3 and $p3>0.1 and $periodo > 3) {
                    //$pdf->SetFillColor(255, 0, 0);
                }// pintar de rojo
                else {
                    //$pdf->SetFillColor(255, 255, 255);
                }

                // coloca la nota del cuarto  periodo  a partir del mismo
                if($periodo > 3) {
                    //$pdf->Cell(15,3,utf8_decode($p4),1,0,'C',true);
                }
                else {
                    //$pdf->Cell(15,3,'',1,0,'C',true);
                }

                    //$pdf->Cell(20,3,utf8_decode($ac),1,0,'C',false); // coloca la nota acumulada

                $num_m = $num_m +1;


            } // final del dato4

            /// ciclo for para calcular el promedio del area

            $num_m_a = count($nota_a);// numero de materias por area

            $avg_a = 0; /// variable que calcula el promedio del area
            for ($ii =0;$ii <= $num_m_a;$ii++){

                $avg_a = $nota_a[$ii]+$avg_a; // se hace una sumatoria de las notas del area

            }

            $avg_a =  number_format($avg_a / $num_m_a, 1, '.', ''); // se calcula el promedio del area

            // PROMEDIO RECUPERACIOENES
            $avg_ar = 0; /// variable que calcula el promedio del area con recuperaciones
            for ($ii =0;$ii <= $num_m_a;$ii++){
                $avg_ar = $nota_r[$ii]+$avg_ar; // se hace una sumatoria de las notas del area con recuperaciones

            }

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
            $avg_at = number_format($avg_at, 1, '.', '');
            

            /////////////////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////
                
            if ($avg_a < 3.0)

            {


                $pdf->Ln(12);
                $pdf->SetFillColor(172, 172, 172);
                $pdf->SetFont('Arial','B',8,true);
                $pdf->Cell(20,3,utf8_decode('No'),1,0,'C',true);
                $pdf->Cell(80,3,utf8_decode('NOMBRE DEL ESTUDIANTE'),1,0,'C',true);
                $pdf->Cell(25,3,utf8_decode('GRADO'),1,0,'C',true);
                //$pdf->Cell(25,5,utf8_decode('JORNADA'),1,0,'C',true);
                $pdf->Cell(30,3,utf8_decode('AÑO LECTIVO'),1,0,'C',true);
                $pdf->Ln();
                $pdf->Cell(20,3,utf8_decode($dato2['id_alumno']),1,0,'C');
                $pdf->Cell(80,3,utf8_decode($nombres." ".$apellidos),1,0,'C');
                $pdf->Cell(25,3,utf8_decode($nivel),1,0,'C');
                $pdf->Cell(30,3,utf8_decode($fecha),1,0,'C');
                $pdf->Ln();

                // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

                // encabezado para la tabla resumen
                //

                $pdf->Ln(3);
                $pdf->SetFillColor(200, 200, 200);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(50,3,utf8_decode('Aréa'),1,0,'C',true);
                $pdf->Cell(50,3,utf8_decode('Materia'),1,0,'C',true);
                $pdf->Cell(15,3,utf8_decode('Periodo 1'),1,0,'C',true);
                $pdf->Cell(15,3,utf8_decode('Periodo 2'),1,0,'C',true);
                $pdf->Cell(15,3,utf8_decode('Periodo 3'),1,0,'C',true);
                $pdf->Cell(15,3,utf8_decode('Periodo 4'),1,0,'C',true);
                $pdf->Cell(20,3,utf8_decode('Acumulado'),1,0,'C',true);


                // ejecucion de la consulta para investigar  por las materias relacionadas con el area
                $q5x = mysqli_query($link, $q5) or die('Consulta fallida q5: ' . mysql_error());;

                // ciclo de repeticion de materias se repite  de acuerdo a cuantas materias tiene cada area
                while($dato4 = mysqli_fetch_array($q5x)) {
                    // la materia en cuestion
                    $id_m = $dato4['id_materia']; // identificador de materia
                    // se crea un array


                    // A partir de aqui se construyen las consultas para
                    // extraer las notas  de cada periodo
                    // en las variables $p1 ... $p2
                    // inicializamos los acumuladores
                    $p1 = 0; // periodo 1
                    $p2 = 0; // periodo 2
                    $p3 = 0; // periodo 3
                    $p4 = 0; // periodo 4

                    // ciclo for que iteratua dentro de los cuatro periodos
                    for($i = 1;$i < 5;$i++) {
                        // consulta que selecciona una materia especifica
                        // para cuatro periodos
                        $q6 = "SELECT  DISTINCT materia.id_materia,
                materia.materia,
                calificaciones.nota,
                docentes.nombres,
                docentes.apellidos,
                calificaciones.corte,
                calificaciones.faltas
                FROM ((((calificaciones INNER JOIN alumnos ON
                  calificaciones.id_alumno = alumnos.id_alumno)
                INNER JOIN logros ON calificaciones.id_logro = logros.id_logro)
                INNER JOIN docentes ON calificaciones.id_docente = docentes.id_docente)
                INNER JOIN materia ON calificaciones.id_materia = materia.id_materia)
                INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno
                AND	 matricula.id_grado =".$grado."
                WHERE calificaciones.id_alumno=" .$id_n. "
                AND materia.id_materia =".$id_m."
                AND calificaciones.year ='".$fecha."'
                AND calificaciones.periodo =".$i."
                ORDER BY materia.id_area, materia.id_materia";

                        // se crea la consulta  para la materia del
                        // alumno  en un grado especifico
                        $q6x = mysqli_query($link, $q6)
                             or die('Consulta fallida q6: ' . mysql_error());;

                        // se ejecuta la consulta para
                        // extraer la
                        while($dato5 = mysqli_fetch_array($q6x)) {

                            $materia = $dato5['materia'];// recupera el dato de la materia para el periodo i
                            $nota = $dato5['nota'];// recupero la nota de la materia para el periodo i
                            $corte = $dato5['corte']; // recupero en corte de la calificacion
                            $faltas= $dato5['faltas']; // recupero las faltas almacenads para el corte
                            // estructura de seleccion para decodificar
                            // el corte en la variable $c
                            // echo "<br>Datos para la materia $materia con nota $nota en el corte $corte <br><br>";
                            switch ($corte) {
                            case 'A':
                                $c = 1;// code...
                                break;

                            case 'F':
                                $c = 0;
                                break;

                            default:
                                $c = 0;// code...
                                break;
                            }

                            // asignamos la nota a la matriz
                            // compuesta por tres coordenadas
                            // materia  ---> $id_m
                            // periodo ----> $i
                            // corte ------> $c
                            // de modo que todas las notas del estudiante
                            // se cargan en este vector
                            $p[$id_m][$i][$c] = $nota;
                            // igualmente se almacenan las faltas
                            $f[$id_m][$i][$c] = $faltas;
                            // echo "<br>Asi va P (valor de c --> $c): <br><br>";
                            // print_r($p);
                        }	// fin del ciclo while

                    } // fin del for

                    // calcula la nota promedio
                    //$avg = $avg + $p[$id_m][$periodo][0]*$w_f+$p[$id_m][$periodo][1]*$w_a;	// sumatoria de notas
                    // nota acumulada segun el peso

                    //$ac = $p[$id_m][1][0];
                    // echo "<br>Matriz <br><br>:";
                    // print_r($p);
                    // eta matriz establece el acumulado de  las notas
                    // durante los cuatro periosdos
                    $ac = (($p[$id_m][1][0]*$w_f)+($p[$id_m][1][1]*$w_a)
                           +($p[$id_m][2][0]*$w_f)+($p[$id_m][2][1]*$w_a)
                           +($p[$id_m][3][0]*$w_f)+($p[$id_m][3][1]*$w_a)
                           +($p[$id_m][4][0]*$w_f)+($p[$id_m][4][1]*$w_a))/4;
                    // calculo del acumulado de notas

                    // si se trata del cuato periodo caculo la nota del area en base
                    // al acumulado
                    if ($periodo == 4){
                        $nota_a[$materia_a] = $ac; // gurado la nota acumulada en el vector del area

                    }
                    else{
                        $nota_a[$materia_a] = $p[$id_m][$periodo][0]*$w_f+$p[$id_m][$periodo][1]*$w_a; // nota  de la mateia
                    }


                    /// calcular  si la nota tiene recuperacion

                    $qp = "SELECT  *
                  FROM (calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id_alumno)
                  INNER JOIN materia ON calificaciones.id_materia = materia.id_materia
                  WHERE calificaciones.id_alumno= $id_n
                  AND calificaciones.year = $fecha
                  AND calificaciones.periodo = 5
                  AND calificaciones.nota > 0
                  AND calificaciones.id_materia = $id_m";


                    $qpx = mysqli_query($link, $qp) or die('Consulta fallida qp, mostrando las materia recuperada, error: ' . mysql_error());;

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

                    $p1 = number_format(($p[$id_m][1][0]*$w_f)+($p[$id_m][1][1]*$w_a), 1, '.', '');
                    $p2 = number_format(($p[$id_m][2][0]*$w_f)+($p[$id_m][2][1]*$w_a), 1, '.', '');
                    $p3 = number_format(($p[$id_m][3][0]*$w_f)+($p[$id_m][3][1]*$w_a), 1, '.', '');
                    $p4 = number_format(($p[$id_m][4][0]*$w_f)+($p[$id_m][4][1]*$w_a), 1, '.', '');
                    $ac = number_format($ac, 1, '.', '');

                    if($p1 == 0.0){$p1 = "";}
                    if($p2 == 0.0){$p2 = "";}
                    if($p3 == 0.0){$p3 = "";}
                    if($p4 == 0.0){$p4 = "";}

                    $pdf->SetFont('Arial','B',8);
                    $pdf->Ln(3);
                    $pdf->Cell(50,3,utf8_decode($area),1,0,'L');
                    $pdf->Cell(50,3,utf8_decode($materia),1,0,'L');
                    // esta rutina coloca los colores a las celdas
                    // para el primer periodo

                    if($p1<3 and $p1>0.1) {
                        $pdf->SetFillColor(255, 0, 0); // pintar de rojo
                    }
                    else {
                        $pdf->SetFillColor(255, 255, 255);
                    }

                    $pdf->Cell(15,3,$p1,1,0,'C',true);// imprime el primer periodo

                    // pinta de rojo  la celda del segundo periodo si la nota es baja
                    if($p2<3 and $p2 >0.1 and $periodo > 1) {
                        $pdf->SetFillColor(255, 0, 0);
                    }// pintar de rojo
                    else {
                        $pdf->SetFillColor(255, 255, 255);
                    }

                    // coloca la nota del segundo periodo  a partir del mismo
                    if($periodo > 1) {
                        $pdf->Cell(15,3,utf8_decode($p2),1,0,'C',true);
                    }

                    else {
                        $pdf->Cell(15,3,'',1,0,'C',true);
                    }

                    // pinta de rojo  la celda del tercer periodo si la nota es baja
                    if($p3<3 and $p3 >0.1  and $periodo > 2) {
                        $pdf->SetFillColor(255, 0, 0);
                    }// pintar de rojo
                    else {	$pdf->SetFillColor(255, 255, 255);}

                    // coloca la nota del tercer periodo  a partir del mismo
                    if($periodo > 2) {
                        $pdf->Cell(15,3,utf8_decode($p3),1,0,'C',true);
                    }
                    else {
                        $pdf->Cell(15,3,'',1,0,'C',true);
                    }

                    // pinta de rojo  la celda del tercer periodo si la nota es baja
                    if($p4<3 and $p3>0.1 and $periodo > 3) {
                        $pdf->SetFillColor(255, 0, 0);
                    }// pintar de rojo
                    else {
                        $pdf->SetFillColor(255, 255, 255);
                    }

                    // coloca la nota del cuarto  periodo  a partir del mismo
                    if($periodo > 3) {
                        $pdf->Cell(15,3,utf8_decode($p4),1,0,'C',true);
                    }
                    else {
                        $pdf->Cell(15,3,'',1,0,'C',true);
                    }

                    $num_m = $num_m +1;


                }

                /// ciclo for para calcular el promedio del area

                $num_m_a = count($nota_a);// numero de materias por area
                
                $avg_a = 0; /// variable que calcula el promedio del area
                for ($ii =0;$ii <= $num_m_a;$ii++){
                    
                $avg_a = $nota_a[$ii]+$avg_a; // se hace una sumatoria de las notas del area
                
                }

                $avg_a =  number_format($avg_a / $num_m_a, 1, '.', ''); // se calcula el promedio del area
                
                // PROMEDIO RECUPERACIOENES
                $avg_ar = 0; /// variable que calcula el promedio del area con recuperaciones
                for ($ii =0;$ii <= $num_m_a;$ii++){
                    $avg_ar = $nota_r[$ii]+$avg_ar; // se hace una sumatoria de las notas del area con recuperaciones
                
                }

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
                $avg_at = number_format($avg_at, 1, '.', '');
            
                $pdf->Ln(3); // se genera una nueva linea
                $pdf->SetFillColor(200, 200, 200); // se define el color de fondo
                $pdf->SetFillColor(200, 200, 200); // se coloca el color gris
                $pdf->Cell(160,3,"Total ".utf8_decode($area),1,0,'L',true);
                $pdf->Cell(20,3,$avg_a,1,0,'C',true);
                //$pdf->Cell(20,3,$avg_a.$avg_print,1,0,'C',true);
                $pdf->SetFillColor(255, 255, 255);// se restablece el color blanco
                
            } // fin de perdiras
        } // fin de area





    }

}

$pdf->Output();


desconectar($link);

?>
