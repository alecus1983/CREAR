<?php
require('../fpdf/fpdf.php');
require_once 'datos.php';
// se crean las siguientes variables
// con obtenida a travez del formulario formulario_boletines

$year = $_GET["year"];				// carga el valor  en la variable fecha
$id_periodo = $_GET["periodos"];
$id_grado = $_GET["grado"]; // guarda el codigo del grado  en la variable $gradox
$id_jornada = $_GET["jornada"]; // guarda el dato de la jornada
$id_curso = $_GET["curso"]; // codigo del curso

// se inserta este fichero para generar el documento en pdf

// define el tipo de codificación para la letra
header("Content-Type: text/html;charset=utf-8");
// CONEXION CON LA BASE DE DATOS
//$link = conectar();

//mysqli_query("SET NAMES 'utf8'");
// Se establece el tipo de cabecera  que tendra el documento
class PDF extends FPDF

{
    //Cabecera de página
    function Header()
    {
        // se incerta el logo de la insticución
        $this->Image('../imagenes/logo_boletin.png',17,12.5,60,25);
        $this->Cell(90,30,"",1);
        $this->SetFont('Arial','',14);
        // Se crea una etiqueta con el logo de la institución
        $this->MultiCell(90,15,"BOLETIN DE CALIFICACIONES \n PERIODO ".$_GET["periodos"],1,'C');
    }

    //Pie de página
    function Footer()
    {
        //Posición: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial','',8);
        //Número de página
        $txt = iconv('UTF-8', 'ISO-8859-1', "Otros servicios: Programas Técnicos , Cursos cortos y Programas tecnológicos");
        $this->Cell(0,5,$txt,0,0,'C');
        $this->Ln(3);
        $txt = iconv('UTF-8', 'ISO-8859-1', "Info: Tel 829 602 8443640, Cel.3166288374, WhatsApp. 3164469532, Email:imcreativo@hotmail.com,  www.imcreativo.edu.co ");
        $this->Cell(0,5,$txt,0,0,'C');
        //$this->Ln(1);
        //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// se crea un nuevo documento de PDF
$pdf=new PDF();
$pdf->SetFont('helvetica','',10);
//creo un nuevo elemento grado
$gr = new grados();
//obtengo las caracteristicas del grado
$gr->get_grado_id($id_grado);
// creamos un nuevo listado de estudiantes 
$list = new lista_estudiantes($year, $id_grado, $id_jornada, $id_curso);
// VARIABLES PARA GUARDAR LOS NOMBRES DE LOS ESTUDIANTES
$nivel = $gr->grado; 
// se almacena el grado al que es promovido
// para el   grado actual los estudiantes
// de este grado
$promovido = $gr->promovido;//$datog['promovido'];

// array multidimencional para almacenar
// las notas en el siguiente orden:
// codigo del estudiante
// codigo de area  
// codigo de materia
// nota (calificacion)  del periodo
$spot = array(array(array(array())));

// array multidimencional para almacenar
// recupraciones en el siguiente orden:
// codigo del estudiante
// codigo de area
// codigo de la materia
// nota (calificaciones) de la recuperacion
$recover = array(array(array()));

//
//	ENCABEZADO DE NOMBRE
//
// CICLO DE REPETICION PARA EXPLORAR LOS ESTUDIANTES
// se exploran los estudiantes para formar el array de notas
// y de recuperaciones.

// array de promedios cuyo indice es el
// codigo del estudiante y   los valores son
// el promedio y la posicion

// objeto de la clase jornada
$jo = new jornada();
// recupero la jornada solicitada
$jo->get_jornada_por_id($id_jornada);
// objeto tipo matricula docente
$md = new matricula_docente();
// creo una nueva matricula docente vacia
$d  = new docentes();
// creo un objeto tipo calificaciones
$notax = new calificaciones();
// creo un objeto tipo logro 
$lo = new logro();
// creo un objeto tipo promedio 
$promedio = array();

// por cada alumno calculos los valores estadisticos
foreach($list->id_alumno  as $e) {

    // un nuevo objeto tipo area
    $a = new area();
    // lista de areas
    $lista_a = $a->get_areas_grado($id_grado);

    // POR CADA AREA QUE DEBE EVALUAR EL GRADO MUESTRO ..
    foreach ($lista_a as  $id_area =>$a) {

        // creamo un nuevo objeto tipo materia
        $m = new  materia();
        // obtiene un listado de materias a ver en  una area de un grado
        $lista_m_a = $m->get_materias_por_grado_area($id_grado, $id_area);

        //LISTA DE MATERIAS DEL AREA
        foreach($lista_m_a as $id_materia => $materia) {
            
            // a partir de aqui comienso a computar las calificaciones
            $notax = new calificaciones();
            // obtengo la nota del periodo
            
            $p1 = 0; // periodo 1
            $p2 = 0; // periodo 2
            $p3 = 0; // periodo 3
            $p4 = 0; // periodo 4

            $r1 = 0; // recuperacion periodo 1
            $r2 = 0; // recuperacion periodo 2
            $r3 = 0; // recuperacion periodo 3
            $r4 = 0; // recuperacion periodo 4
	    
            // esta rutina coloca los colores a las celdas
            // para el primer periodo

            // obtengo la nota del periodo
            // compuesta por cuatro coordenadas
            // $e       --> codigo del estudiante
            // $id_area --> codigo del area
            // $id_materia --> codigo materia
            // codigo del periodo
            
            $notax->get_nota_periodo($e,$id_materia,1,$year);
            // guardo la nota en la variable $p1 para mostrar
            // en la tabla
            $p1 =  number_format($notax->nota, 1, '.', '');
            // guardo el valor para calculos estadisticos
            $spot[$e][$id_area][$id_materia][1] = floatval($p1);

	    
            // //////////////////////////////////////////////////////
            // // para obtener la recuperacion del primer periodo
            $notax->get_recuperacion_periodo($e, $id_materia,$year,1);
            // si se ha calificado alguna recuperacion
            if ($notax->calificado){
                // almaceno la recuperacion del primer periodo
                $r1 =  number_format($notax->nota, 1, '.', '');
                // guardo el valor para calculos estadisticos
                $recover[$e][$id_area][$id_materia][1] = floatval($r1);
                // para obtener la recuperacion del primer periodo
            }

            //echo "<br>la nota de recuperacion es ".$notax->nota." para el estudiante $e , en la materia $id_materia<br><br>";
            //////////////////////////////////////////////////
	    
            // Obtengo la nota del periodo 2
            $notax->get_nota_periodo($e,$id_materia,2,$year);
            // calculo la nota del periodo
            $p2 = number_format($notax->nota, 1, '.', '');
            $spot[$e][$id_area][$id_materia][2] =  floatval($p2);
            /////////////////////////////////////////////////////
            // para obtener la recuperacion del segundo  periodo
            $notax->get_recuperacion_periodo($e, $id_materia,$year,2);
            // si se ha calificado alguna recuperacion
            if ($notax->calificado){
                // almaceno la recuperacion del primer periodo
                $r2 =  number_format($notax->nota, 1, '.', '');
                // guardo el valor para calculos estadisticos
                $recover[$e][$id_area][$id_materia][2] = floatval($r2);
                // para obtener la recuperacion del primer periodo
            }

	    
           
            // obtengo la nota del periodo
            $notax->get_nota_periodo($e,$id_materia,3,$year);
            // guardo la nota del tercer periodo para mostrarlo
            // en la tabla 
            $p3 = number_format($notax->nota, 1, '.', '');
            // gurdo la nota del tercer periodo para calculos
            // estadisticos
            $spot[$e][$id_area][$id_materia][3] =  floatval($p3);
            /////////////////////////////////////////////////////
            // para obtener la recuperacion del tercer periodo
            $notax->get_recuperacion_periodo($e, $id_materia,$year,3);
            // si se ha calificado alguna recuperacion
            if ($notax->calificado){
                // almaceno la recuperacion del primer periodo
                $r3 =  number_format($notax->nota, 1, '.', '');
                // guardo el valor para calculos estadisticos
                $recover[$e][$id_area][$id_materia][3] = floatval($r3);
                // para obtener la recuperacion del primer periodo
            }
	    
            // obtengo la nota del periodo
            $notax->get_nota_periodo($e,$id_materia,4,$year);
            $p4 = number_format($notax->nota, 1, '.', '');
            $spot[$e][$id_area][$id_materia][4] =  floatval($p4);

            /////////////////////////////////////////////////////
            // para obtener la recuperacion del cuarto periodo
            $notax->get_recuperacion_periodo($e, $id_materia,$year,4);
            // si se ha calificado alguna recuperacion
            if ($notax->calificado){
                // almaceno la recuperacion del primer periodo
                $r4 =  number_format($notax->nota, 1, '.', '');
                // guardo el valor para calculos estadisticos
                $recover[$e][$id_area][$id_materia][4] = floatval($r4);
                // para obtener la recuperacion del primer periodo
                
            }
        }
    }

    //var_dump($recover);
    // calcular PROMEDIO general  para el alumno
    $p_a  =0;
    // cantidad de materias
    $c_m = 0;
    // por cada alumno obtengo el vector
    // de materias
    foreach($spot[$e] as $area){
        // por cada area obtengo el vector de materias del area
        foreach($area as $materia){
            // el promedio sumatoria de la materia en
            // los cuatro periodos
            $p_a = $p_a + $materia[$id_periodo];
            $c_m ++;
        }
    }
    //calculo el promedio del estudiante
    //es la sumatoria de los periodos
    //sobre la cantidad de periodos
    $promedio[$e] = $p_a/$c_m;

}

//echo var_dump($promeedio);
// ORDENO EL PROMEDIO
arsort($promedio);
// contador de posicion
$con_p = 1;

// array que guarda las posiciones
$posicion = array();

foreach ($promedio as  $pr => $prom){
    //echo $pr. " -->".$prom."<br>----<br>";
    $posicion[$pr] = $con_p;
    $con_p ++;
    
}

// ESTRUCTURA DE REPETICION PARA CADA ESTUDIANTE
// Esta estructura se repite por cada estudiante
// con el fin de mostrar el boletin impreso

foreach($list->id_alumno  as $e) {

    // creo un nuevo alumno
    $estudiante = new alumnos();

    $estudiante->get_alumno_codigo($e);

    //ENCABEZADO DE CELDAS	//////////////////////////////
    //usando la libreria FPDF
    $pdf->AddPage();
    $pdf->Ln(5);
    $pdf->SetFillColor(172, 172, 172);
    $pdf->SetFont('Arial','B',10,true);
    $pdf->Cell(20,5,iconv('UTF-8', 'ISO-8859-1', 'No'),1,0,'C',true);
    $pdf->Cell(75,5,iconv('UTF-8', 'ISO-8859-1', 'NOMBRE DEL ESTUDIANTE'),1,0,'C',true);
    $pdf->Cell(20,5,iconv('UTF-8', 'ISO-8859-1', 'GRADO'),1,0,'C',true);
    $pdf->Cell(20,5,iconv('UTF-8', 'ISO-8859-1', 'JORNADA'),1,0,'C',true);
    $pdf->Cell(25,5,iconv('UTF-8', 'ISO-8859-1', 'AÑO LECTIVO'),1,0,'C',true);
    $pdf->Cell(20,5,iconv('UTF-8', 'ISO-8859-1', 'PUESTO'),1,0,'C',true);
    $pdf->Ln();
    $pdf->Cell(20,5,iconv('UTF-8', 'ISO-8859-1', $e),1,0,'C');
    $pdf->Cell(75,5, iconv('UTF-8', 'ISO-8859-1', $estudiante->nombres." ".$estudiante->apellidos),1,0,'C');
    $pdf->Cell(20,5,iconv('UTF-8', 'ISO-8859-1', $nivel),1,0,'C');
    $pdf->Cell(20,5,iconv('UTF-8', 'ISO-8859-1', $jo->jornada),1,0,'C');
    $pdf->Cell(25,5,iconv('UTF-8', 'ISO-8859-1', $year),1,0,'C');
    $pdf->SetFillColor(0, 0, 0);
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(20,5,iconv('UTF-8', 'ISO-8859-1', $posicion[$e]),1,0,'C',true);
    $pdf->SetTextColor(0);

    $pdf->Ln(7);

    // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

    // encabezado para la tabla resumen
    //

    $pdf->Ln(3);
    $pdf->SetFillColor(200, 200, 200);
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(50,3,iconv('UTF-8', 'ISO-8859-1', 'Area'),1,0,'C',true);
    $pdf->Cell(50,3,iconv('UTF-8', 'ISO-8859-1', 'Materia'),1,0,'C',true);
    $pdf->Cell(15,3,iconv('UTF-8', 'ISO-8859-1', 'Periodo 1'),1,0,'C',true);
    $pdf->Cell(15,3,iconv('UTF-8', 'ISO-8859-1', 'Periodo 2'),1,0,'C',true);
    $pdf->Cell(15,3,iconv('UTF-8', 'ISO-8859-1', 'Periodo 3'),1,0,'C',true);
    $pdf->Cell(15,3,iconv('UTF-8', 'ISO-8859-1', 'Periodo 4'),1,0,'C',true);
    $pdf->Cell(20,3,iconv('UTF-8', 'ISO-8859-1', 'Acumulado'),1,0,'C',true);
    $pdf->Ln(3);

    // un nuevo objeto tipo area
    $a = new area();
    // numero materias
    $num_m = 0;
    // areas perdidas
    $a_perdidas =0;
    // materias perdidas
    $materia_perdidas =0;


    // obtentengo el listado de areas
    // definiendo cuantas materias tiene cada grado
    $lista_a = $a->get_areas_grado($id_grado);
    $p = Array(Array()); // aaray que almacena las notas de un alumno.
    

    /////////////////////////////////////////////////////
    //                                                 //
    //    TABLA DE NOTAS                               //
    //                                                 //
    /////////////////////////////////////////////////////

    
    
    //por cada area que debe evaluar el grado muestro ..
    foreach ($lista_a as  $id_area =>$a) {

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

        $m = new  materia();
        // obtiene un listado de areas a ver en  un grado
        $lista_m_a = $m->get_materias_por_grado_area($id_grado, $id_area);
        // defino el tipo de fuente
        $pdf->SetFont('Arial','B',7);
        // 
        $pdf->Cell(50,3*$cantidad,iconv('UTF-8', 'ISO-8859-1', $area),1,0,'L');
        // obtengo la coordenada en X en la cual termino de imprimirse la caja
        // del area, par a partir de ahí comenzar a escribir las materias
        $x = $pdf->GetX();

    
        // array multidimencional de dos niveles
        // para cada estudiante, que define el
        // area y la materia con la recuperacion corregida
    
        $spot_x = array(array());

        //por cada materia imprimo una fila
        foreach($lista_m_a as $id_materia => $materia) {
            // Coloca la coordenada en x donde se escribira
            // la siguiente linea
            $pdf->SetX($x);
            // Se crea los campos para mostrar cada materia
            $pdf->Cell(50,3,iconv('UTF-8', 'ISO-8859-1', $materia),1,0,'L');
      
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
            // spot para las notas y recover para la recuperacion

            // PRIMER PERIODO
      
            // obtengo la nota del periodo
            $p1 = number_format( $spot[$e][$id_area][$id_materia][1],1,'.','');

            // si hay cargada una recuperacion para el primer periodo
            if(isset($recover[$e][$id_area][$id_materia][1])) {
                $r1 = number_format( $recover[$e][$id_area][$id_materia][1],1,'.','');
            }

            // validación de los valores máximos coloco cinco 
            if($p1 > 5.0) {$p1 = number_format(5.0,1,'.','');}

            // SEGNDO PERIODO
      
            // obtengo la nota para el segundo periodo
            $p2 = number_format($spot[$e][$id_area][$id_materia][2], 1, '.', '');

            // si hay cargada una recuperacion para el segundo periodo
            if(isset($recover[$e][$id_area][$id_materia][2])){
                $r2 = number_format( $recover[$e][$id_area][$id_materia][2],1,'.','');
            }

            // validación de valores máximos
            if($p2 > 5.0){$p2 = number_format(5.0,1,'.','');}

            // TERCER PERIODO
      
            // obtengo la nota del tercer periodo
            $p3 = number_format($spot[$e][$id_area][$id_materia][3], 1, '.', '');
            // si hay una recuperacion cargada para el periodo 3
            if(isset($recover[$e][$id_area][$id_materia][3])){
                $r3 = number_format( $recover[$e][$id_area][$id_materia][3],1,'.','');
            }
            // validación de valores máximos
            if($p3 > 5.0){$p3 = number_format(5.0,1,'.','');}

            // CUARTO PERIODO
      
            // obtengo la nota del cuarto periodo
            $p4 = number_format($spot[$e][$id_area][$id_materia][4], 1, '.', '');
            // si hay cargada  una recuperacion para el periodo 4
            if(isset($recover[$e][$id_area][$id_materia][4])){
                $r4 = number_format( $recover[$e][$id_area][$id_materia][4],1,'.','');
            }
            // validación de valores máximos
            if($p4 > 5.0){$p4 = number_format(5.0,1,'.','');}
      

            ////////////////////////////////////////////////////////////////////////////
            // RETORNO UN VALOR VACIO EN CASO DE QUE LA NOTA ES CERO                  //
            ////////////////////////////////////////////////////////////////////////////
	    
            if($p1 == 0.0){$p1 = "";}
            if($p2 == 0.0 || $id_periodo < 2){$p2 = "";}
            if($p3 == 0.0 || $id_periodo < 3){$p3 = "";}
            if($p4 == 0.0 || $id_periodo < 4){$p4 = "";}


            if($r1 == 0.0){$r1 = "";}
            if($r2 == 0.0 || $id_periodo < 2){$r2 = "";}
            if($r3 == 0.0 || $id_periodo < 3){$r3 = "";}
            if($r4 == 0.0 || $id_periodo < 4){$r4 = "";}

            ////////////////////////////////////////////////////////////////////////////
            // DECIDE SI IMPRIMIR EL ROJO O EL BLANCO                                 //
            ////////////////////////////////////////////////////////////////////////////

            // PRIMER PERIODO 
      
            // si hay recuperacion del primer periodo
            if ($r1){
                // si la recuperacion es menor que 3 y mayorque cero
                if($r1<3 and $r1>0.1 ) {
                    // imprimo en rojo
                    $pdf->SetFillColor(255, 0, 0);}// pintar de rojo
                else {
                    // imprimo en blanco
                    $pdf->SetFillColor(255, 255, 255);
                }
                // imprimo la recuperacion junto a la nota
                $pdf->Cell(15,3,$p1." [$r1]",1,0,'C',true);// imprime el primer periodo
            }
            else {
                // si  no hay recuperacion del primer periodo reviso
                // si la nota es menor que 3 y mayor que uno
                if($p1<3 and $p1>0.1 ) {
                    // imprimo en rojo
                    $pdf->SetFillColor(255, 0, 0);}// pintar de rojo
                else {
                    // imprimo en blanco
                    $pdf->SetFillColor(255, 255, 255);
                }
                // imprimo solamente la nota
                $pdf->Cell(15,3,$p1,1,0,'C',true);// imprime el primer periodo
            }
	    
            ////////////////////////////////////////////////////////////////
            // SEGUNDO PERIODO

      
            // si hay recuperacion del segundo periodo
            if ($r2){
                // si la recuperacion es menor que tres y mayor que cero
                if($r2<3 and $r2 >0.1 and $id_periodo > 1) {
                    // pinto la celda de rojo
                    $pdf->SetFillColor(255, 0, 0);}// pintar de rojo
                else {
                    // pinto la celda de blanco
                    $pdf->SetFillColor(255, 255, 255);
                }

                // coloca la nota del segundo periodo  a partir del mismo
                if($id_periodo > 1) {
                    // imprimo la nota y la recupracion del segundo periodo
                    $pdf->Cell(15,3,iconv('UTF-8', 'ISO-8859-1', $p2)." [$r2]",1,0,'C',true);}
            
                else {
                    // si es el primer periodo dejo la celda en blanco
                    $pdf->Cell(15,3,'',1,0,'C',true);
                }
            }
            // si no hay recuperacion del segundo periodo
            else {
                // si la nota es menor que tres y mayor que cero
                if($p2<3 and $p2 >0.1 and $id_periodo > 1) {
                    // imprimo de rojo
                    $pdf->SetFillColor(255, 0, 0);}// pintar de rojo
                else {
                    // imprimo de blanco
                    $pdf->SetFillColor(255, 255, 255);}

                // coloca la nota del segundo periodo  a partir del mismo
                if($id_periodo > 1) {
                    $pdf->Cell(15,3,iconv('UTF-8', 'ISO-8859-1', $p2),1,0,'C',true);}
	      
                else {
                    $pdf->Cell(15,3,'',1,0,'C',true);}
            }

            ////////////////////////////////////////////////////////////////
            // TERCER PERIODO 
      
            // si hay recuperacion del tercer periodo            
            if($r3){
                // si la recuperacion es menor que 3 y mayor que cero 
                if($r3<3 and $r3 >0.1  and $id_periodo > 2) {
                    $pdf->SetFillColor(255, 0, 0);}// pintar de rojo
                else {	$pdf->SetFillColor(255, 255, 255);}
            
                // coloca la nota del tercer periodo  a partir del mismo
                if($id_periodo > 2) {
                    $pdf->Cell(15,3,iconv('UTF-8', 'ISO-8859-1', $p3)." [$r3]",1,0,'C',true);}
                else {
                    $pdf->Cell(15,3,'',1,0,'C',true);}

            }
            else {
                // pinta de rojo  la celda del tercer periodo si la nota es baja
                if($p3<3 and $p3 >0.1  and $id_periodo > 2) {
                    $pdf->SetFillColor(255, 0, 0);}// pintar de rojo
                else {	$pdf->SetFillColor(255, 255, 255);}
            
                // coloca la nota del tercer periodo  a partir del mismo
                if($id_periodo > 2) {
                    $pdf->Cell(15,3,iconv('UTF-8', 'ISO-8859-1', $p3),1,0,'C',true);}
                else {
                    $pdf->Cell(15,3,'',1,0,'C',true);}
            }

            ///////////////////////////////////////////////////////////////
            // CUARTO PERIODO
      
            // si tiene recuperacion del cuarto periodo
            if($r4){
                // si la recuperacion es menor que 3 y mayor que cero
                if($r4<3 and $r4>0.1 and $id_periodo > 3) {
                    $pdf->SetFillColor(255, 0, 0);}// pintar de rojo
                else {	$pdf->SetFillColor(255, 255, 255);}
            
                // coloca la nota del cuarto  periodo  a partir del mismo
                if($id_periodo > 3) {
                    $pdf->Cell(15,3,iconv('UTF-8', 'ISO-8859-1', $p4)." [$r4]",1,0,'C',true);}
                else {
                    $pdf->Cell(15,3,'',1,0,'C',true);}
            }
            else {
                // pinta de rojo  la celda del tercer periodo si la nota es baja
                if($p4<3 and $p3>0.1 and $id_periodo > 3) {
                    $pdf->SetFillColor(255, 0, 0);}// pintar de rojo
                else {	$pdf->SetFillColor(255, 255, 255);}
            
                // coloca la nota del cuarto  periodo  a partir del mismo
                if($id_periodo > 3) {
                    $pdf->Cell(15,3,iconv('UTF-8', 'ISO-8859-1', $p4),1,0,'C',true);}
                else {
                    $pdf->Cell(15,3,'',1,0,'C',true);}
            }

            ///////////////////////////////////////////////////////////
            // Area de definicion del acumulado de cada materia      //
            ///////////////////////////////////////////////////////////


            // Si el periodo es el primero el acumulado se define de la siguiente manera
            if ($id_periodo == 1){
	      
                // asigno las notas de los periodos a las variables $p ..
                $p1 = $spot[$e][$id_area][$id_materia][1];

                // si tiene una nota de recuperacion cargada del periodo 1
                if (isset($recover[$e][$id_area][$id_materia][1])){
                    // si la recuperacion es mayor que 0
                    if ($recover[$e][$id_area][$id_materia][1] >0){
                        // se remplaza la nota
                        $p1 = $recover[$e][$id_area][$id_materia][1];		  
                    } 
                }

                // calculo el acumulado como la cuarta parte del año
                $ac = ($p1)/4;
                // lo guardo en el array el acumulado del periodo 
                $spot_x[$id_area][$id_materia] = $ac;
            }

            // si el periodo es el segundo el acumulado se define de la siguiente manera
            elseif ($id_periodo == 2){

                // asigno las notas de los periodos a las variables $p ..
                $p1 = $spot[$e][$id_area][$id_materia][1];
                $p2 = $spot[$e][$id_area][$id_materia][2];
	      
                // si tiene una nota cargada del periodo 1
                if (isset($recover[$e][$id_area][$id_materia][1])){
                    // si la recuperacion es mayor que 0
                    if ($recover[$e][$id_area][$id_materia][1] >0){
                        // se remplaza la nota
                        $p1 = $recover[$e][$id_area][$id_materia][1];		  
                    } 
                }

                // si tiene una nota cargada del periodo 2
                if (isset($recover[$e][$id_area][$id_materia][2])){
                    // si la recuperacion es mayor que 0
                    if ($recover[$e][$id_area][$id_materia][2] >0){
                        // se remplaza la nota
                        $p2 = $recover[$e][$id_area][$id_materia][2];		  
                    } 

                }

                // calculo el acumulado para el segundo periodo 
                $ac = ($p1 + $p2 )/4;
                // lo guardo en el array el acumulado del periodo 
                $spot_x[$id_area][$id_materia] = $ac;
	      
            }

            // si el periodo es el tercero el acumulado se define de la siguiente manera
            elseif ($id_periodo == 3) {

                // asigno las notas de los periodos a las variables $p ..
                $p1 = $spot[$e][$id_area][$id_materia][1];
                $p2 = $spot[$e][$id_area][$id_materia][2];
                $p3 = $spot[$e][$id_area][$id_materia][3];
		  

                // si tiene una nota cargada del periodo 1
                if (isset($recover[$e][$id_area][$id_materia][1])){
                    // si la recuperacion es mayor que 0
                    if ($recover[$e][$id_area][$id_materia][1] >0){
                        // se remplaza la nota
                        $p1 = $recover[$e][$id_area][$id_materia][1];		  
                    } 
                }

                // si tiene una nota cargada del periodo 2
                if (isset($recover[$e][$id_area][$id_materia][2])){
                    // si la recuperacion es mayor que 0
                    if ($recover[$e][$id_area][$id_materia][2] >0){
                        // se remplaza la nota
                        $p2 = $recover[$e][$id_area][$id_materia][2];		  
                    } 

                }

                // si tiene una nota cargada del periodo 3
                if (isset($recover[$e][$id_area][$id_materia][3])){
                    // si la recuperacion es mayor que 0
                    if ($recover[$e][$id_area][$id_materia][3] >0){
                        // se remplaza la nota
                        $p3 = $recover[$e][$id_area][$id_materia][3];		  
                    } 
                }


                // calculo el acumulado para el cuarto periodo 
                $ac = ($p1 + $p2 + $p3)/4;	
                // lo guardo en el array el acumulado del periodo 
                $spot_x[$id_area][$id_materia] = $ac;
            }

            // si es el cuarto periodo el acumulado se define de la siguiente manera
            elseif ($id_periodo == 4) {

                // asigno las notas de los periodos a las variables $p ..
                $p1 = $spot[$e][$id_area][$id_materia][1];
                $p2 = $spot[$e][$id_area][$id_materia][2];
                $p3 = $spot[$e][$id_area][$id_materia][3];
                $p4 = $spot[$e][$id_area][$id_materia][4];		  

                // si tiene una nota cargada del periodo 1
                if (isset($recover[$e][$id_area][$id_materia][1])){
                    // si la recuperacion es mayor que 0
                    if ($recover[$e][$id_area][$id_materia][1] >0){
                        // se remplaza la nota
                        $p1 = $recover[$e][$id_area][$id_materia][1];		  
                    } 
                }

                // si tiene una nota cargada del periodo 2
                if (isset($recover[$e][$id_area][$id_materia][2])){
                    // si la recuperacion es mayor que 0
                    if ($recover[$e][$id_area][$id_materia][2] >0){
                        // se remplaza la nota
                        $p2 = $recover[$e][$id_area][$id_materia][2];		  
                    } 

                }

                // si tiene una nota cargada del periodo 3
                if (isset($recover[$e][$id_area][$id_materia][3])){
                    // si la recuperacion es mayor que 0
                    if ($recover[$e][$id_area][$id_materia][3] >0){
                        // se remplaza la nota
                        $p3 = $recover[$e][$id_area][$id_materia][3];		  
                    } 
                }

                // si tiene una nota cargada del periodo 4
                if (isset($recover[$e][$id_area][$id_materia][4])){
                    // si la recuperacion es mayor que 0
                    if ($recover[$e][$id_area][$id_materia][4] >0){
                        // se remplaza la nota
                        $p4 = $recover[$e][$id_area][$id_materia][4];		  
                    } 
                }

                // calculo el acumulado para el cuarto periodo
                $ac = ($p1 + $p2 + $p3 + $p4)/4;
                // lo guardo en el array el acumulado del periodo 
                $spot_x[$id_area][$id_materia] = $ac;
                //echo "<br> datos para area $id_area y materia $id_materia =".$spot_x[$id_area][$id_materia]. "";
            }

            
            $pdf->Cell(20,3,number_format($ac,1,'.'),1,0,'C',false); // coloca la nota acumulada
            // numero de materia      
            $num_m = $num_m +1;
            $pdf->Ln(3);

            
        } // fin de materias

        // Si se trata del cuarto periodo cacúlo la nota del area en base
        // al acumulado
        if ($id_periodo == 4) {

            $nota_a[$materia_a] = $ac; // gurado la nota acumulada en el vector del area
            
        }
        else{
            $nota_a[$materia_a] = $spot[$e][$id_area][$id_materia][$id_periodo]; // nota  de la mateia
        }

        // ciclo de repeticion para cada area
        // se ejecuta como tantas materias tenga el area
        // echo var_dump($spot_x[$id_area]);
    
        foreach ($spot_x[$id_area] as $id_m => $mat) {
            // calculo una sumatoria
            $avg_a = $mat + $avg_a;
            // incremento las materias perdidas
            // si es menor que tres y diferente
            // de disciplina.
            if($mat < 2.95 and $id_m !== 20){
                //echo "<br>materia perdida  con $mat, en la materia $id_m  para el estudiante $e";
                $materia_perdidas ++;
            }

        }

        // echo "<br> Cantidad ".count($spot[$e][$id_area]);
        // promedio del area        
        $avg_a = $avg_a/count($spot[$e][$id_area]);

        // echo "<br><b>promedio </b> $avg_a";
        // si el promedio del área es menor que tres se incrementa el número de areas perdidas
        if($avg_a < 3){$a_perdidas ++;}
        //echo " = ".$avg_a."<br>";
	
        // se da formato al numero de areas perdidas
        $avg_a =  number_format($avg_a, 1, '.', ''); // se calcula el promedio del area
        
        //$avg_at = number_format($avg_at, 1, '.', '');

        $pdf->SetFillColor(200, 200, 200); // se define el color de fondo
        // $pdf->SetFillColor(200, 200, 200); // se coloca el color gris
        $pdf->Cell(160,3,"Total ".iconv('UTF-8', 'ISO-8859-1', $area),1,0,'L',true);

        $pdf->Cell(20,3,$avg_a,1,0,'C',true);
        $pdf->SetFillColor(255, 255, 255);// se restablece el color blanco
        $pdf->Ln(3);
        
    }

    //fin de areas
 
    $pdf->Cell(50,3,iconv('UTF-8', 'ISO-8859-1', "Promedio: ".number_format($promedio[$e],1,'.')),1,0,'L');
    // si hay notas perdidas
    if($materia_perdidas and $id_periodo == 4){
        $pdf->Cell(50,3,iconv('UTF-8', 'ISO-8859-1', "Materias: ".$num_m.", perdidas : ".$materia_perdidas),1,0,'L');
        $pdf->Cell(80,3,iconv('UTF-8', 'ISO-8859-1', "Areas Perdidas: ".$a_perdidas),1,0,'L');
    } else {
        $pdf->Cell(50,3,iconv('UTF-8', 'ISO-8859-1', "Materias: ".$num_m),1,0,'L');
        $pdf->Cell(80,3,"",1,0,'L');
    }

  
    
    //detalle de cada materia

    $pdf->Ln(5);
    
    $pdf->Cell(180,5,iconv('UTF-8', 'ISO-8859-1', "ESCALA DE VALORACIÓN:"),0,0,'L');
    $pdf->Ln(6);
    $pdf->SetFillColor(0, 200, 0);
    $pdf->Cell(5,5,"",1,0,'L',true);
    $pdf->Cell(40,5,iconv('UTF-8', 'ISO-8859-1', "NIVEL SUPERIOR: 4.8 a 5.0"),0,0,'L');
    $pdf->SetFillColor(0, 204, 255);
    $pdf->Cell(5,5,"",1,0,'L',true);
    $pdf->Cell(40,5,iconv('UTF-8', 'ISO-8859-1', " NIVEL ALTO: 4.1 a 4.7"),0,0,'L');
    

    $pdf->SetFillColor(255, 230, 0);
    $pdf->Cell(5,5,"",1,0,'L',true);
    $pdf->Cell(40,5,iconv('UTF-8', 'ISO-8859-1', "NIVEL BÁSICO: 3.0 a 4.0"),0,0,'L');

    $pdf->SetFillColor(255, 0, 0);
    $pdf->Cell(5,5,"",1,0,'L',true);
    $pdf->Cell(40,5,iconv('UTF-8', 'ISO-8859-1', " NIVEL BAJO: 1.0 a 2.9"),0,0,'L');
    $pdf->Ln(5);

    $pdf->Ln(2);
    $pdf->SetFillColor(180,180,180);
    $pdf->SetFont('Arial','B',12);

    // Si estamos en el cuarto periodo 
    if($id_periodo == 4){ 
        // si la materias perdidas son mas que dos es reprobado
        if($materia_perdidas > 2){
            $pdf->Cell(180,8,"REPROBADO",0,0,'C',true);
        }
        elseif ($materia_perdidas > 0 ) {
      
            $pdf->Cell(180,8,"APLAZADO",0,0,'C',true);
        } else {
            $pdf->SetFillColor(0,143,57);
            $pdf->SetTextColor(255);
            $pdf->Cell(180,8,"APROBADO",0,0,'C',true);
        }
    }

    $pdf->Ln(10);
    $pdf->SetFont('Arial','B',7);
    $pdf->SetTextColor(0);

    // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    //    	FICHA DE DESCRIPCION DE LOGROS
    
    // por cada area que debe evaluar el grado muestro ..
    foreach ($lista_a as  $id_area =>$a) {

        // obtengo el area
        $area = $a[0];
        $logros = "logros";
        
        $pdf->SetFillColor(230, 230, 230);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(180,5,iconv('UTF-8', 'ISO-8859-1', 'Aréa : '.$area),1,0,'L',true);
        $pdf->Ln(5);
        $lista_m_a = $m->get_materias_por_grado_area($id_grado, $id_area);
        // recorro las materias del area
        foreach($lista_m_a as $id_materia => $materia) {
            //obtengo la nota del periodo actual
            $nota = number_format( $spot[$e][$id_area][$id_materia][$id_periodo],1,'.','');
            if($nota > 5.0){$nota = number_format(5.0,1,'.','');}
            $faltas = 0;

            $nota = number_format($nota, 1, '.', '');
            //$pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(50,4,iconv('UTF-8', 'ISO-8859-1', $materia),'L',0,'L');
            $pdf->SetFont('Arial','',7);

            
            // obtengo el id del docente
            $id_docente = $md->get_docente($id_materia, $id_grado, $id_jornada, $id_curso, $year);
            if($id_docente) {
                $d->get_docente_id($id_docente);
                $pdf->Cell(40,4,"Prof:".ucwords(strtolower($d->nombres))." "
                           .ucwords(strtolower($d->apellidos)),0,0,'L');}
            else{
                $pdf->Cell(40,4,"",0,0,'L');}

            //$pdf->Cell(20,4,iconv('UTF-8', 'ISO-8859-1', "Faltas: ".$faltas),0,0,'L');
            $pdf->Cell(20,4,"",0,0,'L');

            // calculo el criterio de desempeño
            if($nota >= 4.8) {
                $valor = "Superior";
                $pdf->SetFillColor(0, 200, 0);
            }
            else {
                if($nota >= 4.1) {
                    $valor = "Alto";
                    $pdf->SetFillColor(0, 204, 255);
                }
                else {
                    if($nota >= 3) {
                        $valor = "Básico";
                        $pdf->SetFillColor(255, 230, 0);
                    }
                    else {
                        $valor = "Bajo";
                        $pdf->SetFillColor(255, 0, 0);
                    }
                }
            }
            
            $pdf->Cell(50,4,iconv('UTF-8', 'ISO-8859-1', "Nivel de desempeño : ").iconv('UTF-8', 'ISO-8859-1', $valor),0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(20,4,iconv('UTF-8', 'ISO-8859-1', "Nota : ".$nota),1,0,'L',true);
            $pdf->Ln(4);
            $pdf->SetFont('Arial','I',8);
            $pdf ->SetTextColor(30,30,30);

            // obtengo el codigo del logro
            $notax->get_logro($e, $id_materia, $year, $id_periodo);
            //valido si ha retornado un logro
            if($notax->calificado){
                // si obtengo el codigo del logro  entonces cargo
                // sus atributos
                $lo->get_logro_id(intval($notax->logro));
                // imprimo el logro
                $pdf->MultiCell(180,4, iconv('UTF-8', 'ISO-8859-1', $lo->logro),'BLR','L',false);}
            else{
                // si no hay logro coloco el espacio
                $pdf->MultiCell(180,4, "",'BLR','L',false);}
        }

        
    }

    $pdf->Ln(15);
    $pdf->Cell(180,5,iconv('UTF-8', 'ISO-8859-1', "Observaciones : "),0,0,'L');

    $pdf->Ln(5);
    $pdf->Cell(180,5,iconv('UTF-8', 'ISO-8859-1', "__________________________________________________________________________________________________"),0,0,'L');
    $pdf->Ln(5);
    $pdf->Cell(180,5,iconv('UTF-8', 'ISO-8859-1', "__________________________________________________________________________________________________"),0,0,'L');
    $pdf->Ln(5);
    $pdf->Cell(180,5,iconv('UTF-8', 'ISO-8859-1', "__________________________________________________________________________________________________"),0,0,'L');
    $pdf->Ln(5);
    $pdf->Cell(180,5,iconv('UTF-8', 'ISO-8859-1', "__________________________________________________________________________________________________"),0,0,'L');
    $pdf->Ln(5);
    $pdf->Cell(180,5,iconv('UTF-8', 'ISO-8859-1', "__________________________________________________________________________________________________"),0,0,'L');



    $pdf->Cell(180,20,'',0,0,'L');
    $pdf->Ln(30);
    $pdf->Cell(180,5,iconv('UTF-8', 'ISO-8859-1', "    ________________________          _________________________"),0,0,'C');
    $pdf->Ln(3);
    $pdf->Cell(180,5,iconv('UTF-8', 'ISO-8859-1', "           Rectora                                       Directora de Grupo"),0,0,'C');
            
}
        
    
    

// OBSERVACIONES DEL ESTUDIANTE





$pdf->Output("boletin_".$gr->grado."_".iconv('UTF-8', 'ISO-8859-1', $jo->jornada)."_".date('d-m-Y__H_i_s').".pdf" , "D");

?>
