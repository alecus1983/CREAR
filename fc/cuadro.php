<?php
require_once 'datos.php';
// Variables recibidas mediante método POST
$year = $_POST['years'];
$id_jornada = $_POST['jornada'];
$periodo = $_POST['periodo'];
$id_grado = $_POST['id_g'];
$id_curso = $_POST['id_curso'];
$id_alumno = $_POST['id_alumno'];

//creo un nuevo elemento grado
$gr = new grados();
//obtengo las caracteristicas del grado
$gr->get_grado_id($id_grado);
// creo un objeto tipo calificaciones
$notax = new calificaciones();
// creo un objeto tipo promedio 
$promedio = 0;
// un nuevo objeto tipo area
$a = new area();
// lista de areas
$lista_a = $a->get_areas_grado($id_grado);
// creo un tipo de alumno
$alumno = new alumnos($id_alumno);
// creo un objeto tipo cuadro de notas
$cuadro = new cuadro();

// VARIABLES PARA GUARDAR LOS NOMBRES DE LOS ESTUDIANTES
$nivel = $gr->grado; 

echo "<table class='table table-striped  table-hover'>";
echo "<thead><tr>";
echo "<th>alumno (código)</th><th>area</th><th>materia</th><th>p1</th><th>r1</th><th>p2</th><th>r2</th><th>p3</th><th>r3</th><th>p4</th><th>r4</th>";
echo "</tr></thead><tbody>";

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
        // $id_alumno       --> codigo del estudiante
        // $id_area --> codigo del area
        // $id_materia --> codigo materia
        // codigo del periodo

        //**********************************************************
        $notax->get_nota_periodo($id_alumno,$id_materia,1,$year);
        // guardo la nota en la variable $p1 para mostrar
        // en la tabla
        $p1 =  number_format($notax->nota, 1, '.', '');
        // guardo el valor para calculos estadisticos

        // // para obtener la recuperacion del primer periodo
        $notax->get_recuperacion_periodo($id_alumno, $id_materia,$year,1);
        // si se ha calificado alguna recuperacion
        if ($notax->calificado) {
            // almaceno la recuperacion del primer periodo
            $r1 =  number_format($notax->nota, 1, '.', '');
         }
        // ***********************************************************
     
        // Obtengo la nota del periodo 2
        $notax->get_nota_periodo($id_alumno,$id_materia,2,$year);
        // calculo la nota del periodo
        $p2 = number_format($notax->nota, 1, '.', '');
        // para obtener la recuperacion del segundo  periodo
        $notax->get_recuperacion_periodo($id_alumno, $id_materia,$year,2);
        // si se ha calificado alguna recuperacion
        if ($notax->calificado){
            // almaceno la recuperacion del primer periodo
            $r2 =  number_format($notax->nota, 1, '.', '');
        }

        // **************************************************************
        // obtengo la nota del tercer periodo
        $notax->get_nota_periodo($id_alumno,$id_materia,3,$year);
        // guardo la nota del tercer periodo para mostrarlo
        // en la tabla 
        $p3 = number_format($notax->nota, 1, '.', '');
        // gurdo la nota del tercer periodo para calculos
        // estadisticos
         // para obtener la recuperacion del tercer periodo
        $notax->get_recuperacion_periodo($id_alumno, $id_materia,$year,3);
        // si se ha calificado alguna recuperacion
        if ($notax->calificado) {
            // almaceno la recuperacion del primer periodo
            $r3 =  number_format($notax->nota, 1, '.', '');
            // guardo el valor para calculos estadisticos
        }

        // ****************************************************************
        // obtengo la nota del cuarto  periodo
        $notax->get_nota_periodo($id_alumno,$id_materia,4,$year);
        $p4 = number_format($notax->nota, 1, '.', '');
        // para obtener la recuperacion del cuarto periodo
        $notax->get_recuperacion_periodo($id_alumno, $id_materia,$year,4);
        // si se ha calificado alguna recuperacion
        if ($notax->calificado){
            // almaceno la recuperacion del primer periodo
            $r4 =  number_format($notax->nota, 1, '.', '');
        }
        // ******************************************************************
        echo "<tr><td>" ;
        echo  $alumno->nombres." ".$alumno->apellidos." ($id_alumno) </td><td>".$a[0]."</td><td>$materia</td><td>$p1</td><td>$r1</td><td>$p2</td><td>$r2</td><td>$p3</td><td>$r3</td><td>$p4</td><td>$r4</td>";
        echo "</tr>" ;

        // verifico si hay notas insertadas en el cuadro
        $res = $cuadro->consultar_cuado_por_alumno_ano_periodo($id_alumno, $id_materia, $year,$periodo);
        
        // si hay notas insertadas  actualizo las que hay
        if ($res) {
            // si se actualiza el cuadro
            if ($cuadro->update_cuadro($id_alumno, $p1, $p2, $p3, $p4, $r1, $r2, $r3, $r4, $promedio)){
                // echo "$res --> actualizo el alumno $id_alumno, de la materia  $id_materia \t<br>";                
            }
            // de lo contrario
            else {
                // echo "$res --> no se puedo actualizar el alumno $id_alumno, de la materia  $id_materia \t<br>";                
            }
        } else {
            echo "inserto el alumno $id_alumno, de la materia  $id_materia \t";
            
            //  inserto la funcion en el cuadro de notas
            $cuadro->set_cuadro(
                $id_alumno,
                $id_materia,
                $id_area,
                $id_grado,
                $year,
                $periodo,
                $p1,
                $p2,
                $p3,
                $p4,
                $r1,
                $r2,
                $r3,
                $r4,
                0);

        }
     
        
    } // lista de materias
} // lista de areas

echo "</tbody></table>"



?>