<?php
require('../fpdf/fpdf.php');
require_once 'datos.php';
// se crean las siguientes variables
// con obtenida a travez del formulario formulario_boletines

$fecha = $_GET["year"];				// carga el valor  en la variable fecha
$periodo = $_GET["periodos"];
$grado = $_GET["grado"]; // guarda el codigo del grado  en la variable $gradox
$id_jornada = $_GET["jornada"]; // guarda el dato de la jornada
$id_curso = $_GET["curso"]; // codigo del curso

$w_a = 0.5; // peso del corte a
$w_f = 0.5; // peso del corte final

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
        $txt = utf8_decode("Otros servicios: Programas Tecnicos , Cursos cortos y Programas tecnologicos");
        $this->Cell(0,5,$txt,0,0,'C');
        $this->Ln(3);
        $txt = utf8_decode("Info: Tel 829 5741, Cel.3166288374, WhatsApp. 3164469532, Email:imcreativo@hotmail.com,  www.imcreativo.edu.co ");
        $this->Cell(0,5,$txt,0,0,'C');
        //$this->Ln(1);
    	//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// se crea un nuevo documento de PDF
$pdf=new PDF();
// creo un nuevo elemento grado
$gr = new grados();
// obtengo las caracteristicas del grado
$gr->get_grado_id($grado);
// creamos un nuevo listado de estudiantes 
$list = new listado_estudiantes($fecha, $grado, $id_jornada, $id_curso);
// VARIABLES PARA GUARDAR LOS NOMBRES DE LOS ESTUDIANTES
$nivel = $gr->grado; //$datog['grado'];
// se almacena el grado al que es promovido
// para el   grado actual los estudiantes
// de este grado
$promovido = $gr->promovido;//$datog['promovido'];
// array para almacenar en su orden
// codigo del estudiante
// codigo de area  
// codigo de materia
// nota (calificacion)  del periodo
$spot = array(array(array(array())));

//
//	ENCABEZADO DE NOMBRE
//
// CICLO DE REPETICION PARA EXPLORAR LOS ESTUDIANTES
// se exploran los estudiantes para formar el array de notas

//array de promedios cuyo indice es el
// codigo del estudiante y   los valores son
// el promedio y la posicion

$promedio = array();
foreach($list->id_alumno  as $e){

    // un nuevo objeto tipo area
    $a = new area();
    // lista de areas
    $lista_a = $a->get_areas_grado($grado);

    // por cada area que debe evaluar el grado muestro ..
    foreach ($lista_a as  $id_area =>$a) {

        // creamo las nuevas materias
        $m = new  materia();
        // obtiene un listado de areas a ver en  un grado
        $lista_m_a = $m->get_materias_por_grado_area($grado, $id_area);

        //lista de materias del area
         foreach($lista_m_a as $id_materia => $materia) {
            
            // a partir de aqui comienso a computar las calificaciones
             $notax = new calificaciones();
            // obtengo la nota del periodo
            
            $p1 = 0; // periodo 1
            $p2 = 0; // periodo 2
            $p3 = 0; // periodo 3
            $p4 = 0; // periodo 4
            // esta rutina coloca los colores a las celdas
            // para el primer periodo

            // ciclo for que iteratua dentro de los cuatro periodos
           
            // obtengo la nota del periodo
            $notax->get_nota_periodo($e,$id_materia,1,$fecha);
            $p1 =  number_format($notax->nota, 1, '.', '');
            // asignamos la nota a la matriz
            // compuesta por tres coordenadas
            // materia  ---> $id_materia
            // periodo ----> 
            $spot[$e][$id_area][$id_materia][1] = floatval($p1);
            
            // obtengo la nota del periodo
            $notax->get_nota_periodo($e,$id_materia,2,$fecha);
            $p2 = number_format($notax->nota, 1, '.', '');
            $spot[$e][$id_area][$id_materia][2] =  floatval($p2);
            // obtengo la nota del periodo
            $notax->get_nota_periodo($e,$id_materia,3,$fecha);
            $p3 = number_format($notax->nota, 1, '.', '');
            $spot[$e][$id_area][$id_materia][3] =  floatval($p3);
            // obtengo la nota del periodo
            $notax->get_nota_periodo($e,$id_materia,4,$fecha);
            $p4 = number_format($notax->nota, 1, '.', '');
            $spot[$e][$id_area][$id_materia][4] =  floatval($p4);
            
         }
    }

    // calcular promedios  para el alumno
    $p_a  =0;
    // cantidad de materias
    $c_m = 0;
    // por cada area 
    foreach($spot[$e] as $area){
        // por cada materia del area
        foreach($area as $materia){
            // el promedio del area
            $p_a = $p_a + $materia[$periodo];
            $c_m ++;
        }
    }
    //calculo el promedio del estudiante
    $promedio[$e] = $p_a/$c_m;
    //echo "El promedio para $e sumando $p_a para ".count($spot[$e])." materias un promedio de ".$promedio[$e]."<br>";
    
}

//echo var_dump($promeedio);
// ordeno el promedio
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
// echo "<br>Promedio ordenado :";
// echo var_dump($promeedio)."<br>";
// echo var_dump($posicion);

//echo var_dump($spot);

// Estructura de repeticion para cada estudiante
foreach($list->id_alumno  as $e) {

    //echo $e."<br>";
    $estudiante = new alumnos($e);
    //echo ucwords(strtolower($estudiante->nombres))." ".ucwords(strtolower($estudiante->apellidos))."<br>";

    // ENCABEZADO DE CELDAS	//////////////////////////////
    // usando la libreria FPDF
    $pdf->AddPage();
    $pdf->Ln(5);
    $pdf->SetFillColor(172, 172, 172);
    $pdf->SetFont('Arial','B',10,true);
    $pdf->Cell(20,5,utf8_decode('No'),1,0,'C',true);
    $pdf->Cell(75,5,utf8_decode('NOMBRE DEL ESTUDIANTE'),1,0,'C',true);
    $pdf->Cell(20,5,utf8_decode('GRADO'),1,0,'C',true);
    $pdf->Cell(20,5,utf8_decode('JORNADA'),1,0,'C',true);
    $pdf->Cell(25,5,utf8_decode('AÑO LECTIVO'),1,0,'C',true);
    $pdf->Cell(20,5,utf8_decode('PUESTO'),1,0,'C',true);
    $pdf->Ln();
    $pdf->Cell(20,5,utf8_decode($e),1,0,'C');
    $pdf->Cell(75,5,utf8_decode($estudiante->nombres." ".$estudiante->apellidos),1,0,'C');
    $pdf->Cell(20,5,utf8_decode($nivel),1,0,'C');
    $pdf->Cell(20,5,"mañana",1,0,'C');
    $pdf->Cell(25,5,utf8_decode($fecha),1,0,'C');
    $pdf->Cell(20,5,utf8_decode($posicion[$e]),1,0,'C');
    $pdf->Ln(7);

    // // xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

    // // encabezado para la tabla resumen
    // //

    $pdf->Ln(3);
    $pdf->SetFillColor(200, 200, 200);
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(50,3,utf8_decode('Area'),1,0,'C',true);
    $pdf->Cell(50,3,utf8_decode('Materia'),1,0,'C',true);
    $pdf->Cell(15,3,utf8_decode('Periodo 1'),1,0,'C',true);
    $pdf->Cell(15,3,utf8_decode('Periodo 2'),1,0,'C',true);
    $pdf->Cell(15,3,utf8_decode('Periodo 3'),1,0,'C',true);
    $pdf->Cell(15,3,utf8_decode('Periodo 4'),1,0,'C',true);
    $pdf->Cell(20,3,utf8_decode('Acumulado'),1,0,'C',true);
    $pdf->Ln(3);

    // un nuevo objeto tipo area
    $a = new area();

    // obtentengo el listado de areas
    // definiendo cuantas materias tiene cada grado
    $lista_a = $a->get_areas_grado($grado);
    $p = Array(Array()); // aaray que almacena las notas de un alumno.
    

    // por cada area que debe evaluar el grado muestro ..
    foreach ($lista_a as  $id_area =>$a) {

        // variables de repeticion de area
        $avg = 0;
        $avg_a = 0;
        $num_m = 0;
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
        $lista_m_a = $m->get_materias_por_grado_area($grado, $id_area);
        // defino el tipo de fuente
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(50,3*$cantidad,$area,1,0,'L');
        // obtengo la coordenada en X en la cual termino de imprimirse la caja
        // del area, par a partir de ahí comenzar a escribir las materias
        $x = $pdf->GetX();

        //por cada materia imprimo una fila
        foreach($lista_m_a as $id_materia => $materia) {
            //coloca la coordenada en x donde se escribira
            //la siguiente linea
            $pdf->SetX($x);
            // se crea los campos para mostrar cada materia
            $pdf->Cell(50,3,$materia,1,0,'L');
            
            // a partir de aqui comienso a computar las calificaciones
            //$notax = new calificaciones();
            // obtengo la nota del periodo
            // $notax->get_nota_periodo($e,$id_materia,$periodo,$fecha);
            // muestro la nota del periodo


            // A partir de aqui se construyen las consultas para
            // extraer las notas  de cada periodo
            // en las variables $p1 ... $p2
            // inicializamos los acumuladores
            $p1 = 0; // periodo 1
            $p2 = 0; // periodo 2
            $p3 = 0; // periodo 3
            $p4 = 0; // periodo 4
            // esta rutina coloca los colores a las celdas
            // para el primer periodo

            // ciclo for que iteratua dentro de los cuatro periodos
            

            // obtengo la nota del periodo
            //$notax->get_nota_periodo($e,$id_materia,1,$fecha);
            $p1 = number_format( $spot[$e][$id_area][$id_materia][1],1,'.','');//  number_format($notax->nota, 1, '.', '');
            // asignamos la nota a la matriz
            // compuesta por tres coordenadas
            // materia  ---> $id_materia
            // periodo ----> 
            ///$p[$id_materia][1] = floatval($p1);
            // obtengo la nota del periodo
            //$notax->get_nota_periodo($e,$id_materia,2,$fecha);
            $p2 = number_format($spot[$e][$id_area][$id_materia][2], 1, '.', '');
            // //$p[$id_materia][2] =  floatval($p2);
            // // obtengo la nota del periodo
            // //$notax->get_nota_periodo($e,$id_materia,3,$fecha);
            $p3 = number_format($spot[$e][$id_area][$id_materia][3], 1, '.', '');
            // //$p[$id_materia][3] =  floatval($p3);
            // // obtengo la nota del periodo
            $p4 = number_format($spot[$e][$id_area][$id_materia][4], 1, '.', '');
            //$p[$id_materia][4] =  floatval($p4);


            //////////////////////////////////////////////////////////////////////////////
            // retorno un valor vacio en caso de que la nota es cero
            if($p1 == 0.0){$p1 = "";}
            if($p2 == 0.0 || $periodo < 2){$p2 = "";}
            if($p3 == 0.0 || $periodo < 3){$p3 = "";}
            if($p4 == 0.0 || $periodo < 4){$p4 = "";}

            //
            if($p1<3 and $p1>0.1) {
                $pdf->SetFillColor(255, 0, 0);}// pintar de rojo
            else {	$pdf->SetFillColor(255, 255, 255);}
            
            $pdf->Cell(15,3,$p1,1,0,'C',true);// imprime el primer periodo
            
            // pinta de rojo  la celda del segundo periodo si la nota es baja
            if($p2<3 and $p2 >0.1 and $periodo > 1) {
                $pdf->SetFillColor(255, 0, 0);}// pintar de rojo
            else {	$pdf->SetFillColor(255, 255, 255);}

            // coloca la nota del segundo periodo  a partir del mismo
            if($periodo > 1) {
                $pdf->Cell(15,3,utf8_decode($p2),1,0,'C',true);}
            
            else {
                $pdf->Cell(15,3,'',1,0,'C',true);}
            
            // pinta de rojo  la celda del tercer periodo si la nota es baja
            if($p3<3 and $p3 >0.1  and $periodo > 2) {
                $pdf->SetFillColor(255, 0, 0);}// pintar de rojo
            else {	$pdf->SetFillColor(255, 255, 255);}
            
            // coloca la nota del tercer periodo  a partir del mismo
            if($periodo > 2) {
                $pdf->Cell(15,3,utf8_decode($p3),1,0,'C',true);}
            else {
                $pdf->Cell(15,3,'',1,0,'C',true);}
            

            // pinta de rojo  la celda del tercer periodo si la nota es baja
            if($p4<3 and $p3>0.1 and $periodo > 3) {
                $pdf->SetFillColor(255, 0, 0);}// pintar de rojo
            else {	$pdf->SetFillColor(255, 255, 255);}
            
            // coloca la nota del cuarto  periodo  a partir del mismo
            if($periodo > 3) {
                $pdf->Cell(15,3,utf8_decode($p4),1,0,'C',true);}
            else {
                $pdf->Cell(15,3,'',1,0,'C',true);}

            if ($periodo == 1){
                $ac = $spot[$e][$id_area][$id_materia][1]/4;
            }
            elseif ($periodo == 2){
                $ac = ($spot[$e][$id_area][$id_materia][1] + $spot[$e][$id_area][$id_materia][1])/4;
            }
            elseif ($periodo == 3){
                $ac = ($spot[$e][$id_area][$id_materia][1] +
                       $spot[$e][$id_area][$id_materia][2] +
                       $spot[$e][$id_area][$id_materia][3])/4;
            }
            elseif ($periodo == 4){
                $ac = ($spot[$e][$id_area][$id_materia][1] +
                       $spot[$e][$id_area][$id_materia][2] +
                       $spot[$e][$id_area][$id_materia][3] +
                       $spot[$e][$id_area][$id_materia][4])/4;
            }

            
            $pdf->Cell(20,3,number_format($ac,1,'.'),1,0,'C',false); // coloca la nota acumulada
            
            $num_m = $num_m +1;
            $pdf->Ln(3);

            
         } // fin de materias

        // si se trata del cuato periodo caculo la nota del area en base
            // al acumulado
        // if ($periodo == 4){
        //     $nota_a[$materia_a] = $ac; // gurado la nota acumulada en el vector del area
            
        // }
        // else{
        //     $nota_a[$materia_a] = $p[$id_materia][$periodo]; // nota  de la mateia
        // }

        foreach ($spot[$e][$id_area] as $materia){
            //echo $materia[$periodo]." -- ";
            $avg_a = $materia[$periodo] + $avg_a;
        }
        // promedio del area
        
        $avg_a = $avg_a/count($spot[$e][$id_area]);
        //echo " = ".$avg_a."<br>";    

        $avg_a =  number_format($avg_a, 1, '.', ''); // se calcula el promedio del area
        
        // // PROMEDIO RECUPERACIOENES
        // $avg_ar = 0; /// variable que calcula el promedio del area con recuperaciones
        // for ($ii =0;$ii <= $num_m_a;$ii++){
        //     $avg_ar = $nota_r[$ii]+$avg_ar; // se hace una sumatoria de las notas del area con recuperaciones
                
        // }

        // $avg_ar =  number_format($avg_ar / $num_m_a, 1, '.', ''); // se calcula el promedio del area con recuperacion
            
        // // calculo el mayor entre el promedio del area  y el promedio con recuperaciones
        // if($avg_a > $avg_ar){
        //     $avg_at = $avg_a; // el promedio total sera el acumulado
        // }
        // else{
        //     $avg_at = $avg_ar; // el promedio total sera el de las recuperaciones
        // }
        
        // // algoritmo que cuenta las areas perdidas
        // if ($avg_at < 3){
        //     if ($id_a != 12){
        //         $a_perdidas ++;// incremento el contador de areas perdidas siempre y cuando no sea disciplina
        //     }
        // }
        // // si ha recuperado imprimo el dato de la recuperacion
        // // de lo contrario no lo imprimo
        // if ($recupero){
        //     $avg_print = " (".$avg_at.")";
        // }
        // else{
        //     $avg_print = ""; //
        // }
        // $avg_at = number_format($avg_at, 1, '.', '');
        //$pdf->Ln(3); // se genera una nueva linea
        $pdf->SetFillColor(200, 200, 200); // se define el color de fondo
        // $pdf->SetFillColor(200, 200, 200); // se coloca el color gris
        $pdf->Cell(160,3,"Total ".utf8_decode($area),1,0,'L',true);
        $pdf->Cell(20,3,$avg_a.$avg_print,1,0,'C',true);
        $pdf->SetFillColor(255, 255, 255);// se restablece el color blanco
        $pdf->Ln(3);
        
     } // fin de areas

    /// ciclo for para calcular el promedio del area
    // $num_m_a = count($nota_a);// numero de materias por area

    // $avg_a = 0; /// variable que calcula el promedio del area
    // for ($ii =0;$ii <= $num_m_a;$ii++) {
                
    // $avg_a = $nota_a[$ii]+$avg_a; // se hace una sumatoria de las notas del area

    // }

    /// algoritmo que calcula el promedio del periodo
    //  foreach ($spot[$e] as $materia) {
    // //     // code...
    // //     // echo var_dump($materia).'<br><br>';
    //      $avg = $avg + $materia[$periodo];
  
    //  }
    //  $avg = number_format($avg /$num_m, 1, '.', '');


    $pdf->Ln(3);
    $pdf->Cell(50,3,utf8_decode("Promedio: ".number_format($promedio[$e],1,'.')),1,0,'L');
    $pdf->Cell(50,3,utf8_decode("Materias: ".$num_m),1,0,'L');
    $pdf->Cell(80,3,utf8_decode("Areas Perdidas: ".$a_perdidas),1,0,'L');
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // detalle de cada materia

     $pdf->Ln(5);
    $pdf->Cell(180,5,utf8_decode("ESCALA DE VALORACIÓN:"),0,0,'L');
    $pdf->Ln(6);
    $pdf->SetFillColor(0, 200, 0);
    $pdf->Cell(5,5,"",1,0,'L',true);
    $pdf->Cell(40,5,utf8_decode("NIVEL SUPERIOR: 4.8 a 5.0"),0,0,'L');
    $pdf->SetFillColor(0, 204, 255);
    $pdf->Cell(5,5,"",1,0,'L',true);
    $pdf->Cell(40,5,utf8_decode(" NIVEL ALTO: 4.1 a 4.7"),0,0,'L');
    
    //$pdf->Ln(8);
    $pdf->SetFillColor(255, 230, 0);
    $pdf->Cell(5,5,"",1,0,'L',true);
    $pdf->Cell(40,5,utf8_decode("NIVEL BÁSICO: 3.0 a 4.0"),0,0,'L');

    $pdf->SetFillColor(255, 0, 0);
    $pdf->Cell(5,5,"",1,0,'L',true);
    $pdf->Cell(40,5,utf8_decode(" NIVEL BAJO: 1.0 a 2.9"),0,0,'L');
        

//     $pdf->Ln(10);
    
//     foreach ($lista_a as  $id_area =>$a) {
//         // obtengo el area
//         $area = $a[0];
//         //variables de cada area
//         $nota_a = array(); // array que contiene las notas de cada area
        
//         $m = new materia();
//         // obtiene un listado de areas a ver en  un grado
//         $lista_m_a = $m->get_materias_por_grado_area($grado, $id_area);

//         // por cada materia imprimo una fila
//         foreach($lista_m_a as $id_materia => $materia) {




//         }
//     }

   






//     $pdf->Ln(5);
//     // si el grado es diferente de 11
//     if ($grado != 2 && $periodo == 4){
//         $pdf->SetFillColor(255, 238, 170);
//         $pdf->SetFont('Arial','B',9);
        
//         if ($a_perdidas == 0){
//             $pdf->Multicell(180,5,utf8_decode("El estudiante APROBO las competencias necesarias y fue Promovido al grado  ".$promovido),0,'L',true);
//         }
//         elseif ($a_perdidas < 3){
//             $pdf->Multicell(180,5,utf8_decode("El estudiante REPROBO el mínimo de  las competencias necesarias para ser promovido al grado ".
//                                               $promovido." y fue APLAZADO "),0,'L',true);
//         }
//         else{
//             $pdf->Multicell(180,5,utf8_decode("El estudiante REPROBO las competencias necesarias y NO fue Promovido al grado ".$promovido),0,'L',true);
//         }
    //    }


    // OBSERVACIONES DEL ESTUDIANTE

    $pdf->Ln(15);
    $pdf->Cell(180,5,utf8_decode("Observaciones : "),0,0,'L');

    $pdf->Ln(5);
    $pdf->Cell(180,5,utf8_decode("__________________________________________________________________________________________________"),0,0,'L');
    $pdf->Ln(5);
    $pdf->Cell(180,5,utf8_decode("__________________________________________________________________________________________________"),0,0,'L');
    $pdf->Ln(5);
    $pdf->Cell(180,5,utf8_decode("__________________________________________________________________________________________________"),0,0,'L');
    $pdf->Ln(5);
    $pdf->Cell(180,5,utf8_decode("__________________________________________________________________________________________________"),0,0,'L');
    $pdf->Ln(5);
    $pdf->Cell(180,5,utf8_decode("__________________________________________________________________________________________________"),0,0,'L');



    $pdf->Cell(180,20,'',0,0,'L');
    $pdf->Ln(30);
    $pdf->Cell(180,5,utf8_decode("    ________________________          _________________________"),0,0,'C');
    $pdf->Ln(3);
    $pdf->Cell(180,5,utf8_decode("           Rectora                                       Directora de Grupo"),0,0,'C');
}


$pdf->Output();


desconectar($link);

?>
