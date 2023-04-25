<?php
// archivo de configuracion  de objetos
require_once("datos.php");

//variables recibidas mediante POSTn
$valido = true;
$err = "";

// jornada
$jornada = $_POST["id_jornada"];
// curso
$curso = $_POST['curso'];
// //semana
$semana = $_POST["semana"];
// periodos
$periodo = $_POST["periodo"];

//echo "<div class='row'>Listado para la semana : ".$semana."</div>";
// validacion de datos
if($_POST["id_g"] >0 ){
    $grado = $_POST["id_g"];
}else {
    $valido = false;
    $err = $err."<p class='text-danger'>Porfavor seleccione un grado</p>";
}

if($_POST["years"]!== ""){
    $ano = $_POST["years"];//date("Y");
}else {
    $valido = false;
    $err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
}


if($_POST["id_jornada"]!== ""){
    $jornada = $_POST['id_jornada'];
}else {
    $valido = false;
    $err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
}
if($_POST["id_ms"] >0){
    $id_m = $_POST['id_ms'];
}else {
    $valido = false;
    $err = $err."<p class='text-danger'>Porfavor seleccione una materia</p>";
}
if($_POST["semana"] > 0){
    $id_semana = $_POST['semana'];
}else {
    $valido = false;
    $err = $err."<p class='text-danger'>Porfavor seleccione una semana</p>";
}

if ($valido) {

    $gr = new grados();
    $gr->get_nombre($grado);

    $cr = new materia();
    $cr->get_materia($id_m);
    //echo "<div class='row'><div class='col-md-12>";
    // saco este mensaje por consola
    echo "<p>Listado de  estudiantes de <b>".$cr->materia."</b> del grado <b>".$gr->n_grado."</b> </p>";
    
    echo "<div class='row'><div class='col-md-8'>";

    //crea un nuevo objeto listado (año,grado,jornada,curso)
    $listado  = new listado_estudiantes($ano,$grado,$jornada, $curso);

    // si se trata de la materia de disciplina entonces
    if ($id_m == 20) {

        // para cada alumno
        foreach($listado->id_alumno as $e) {
            $estudiante = new alumnos($e);
            // creo un nuevo objeto de calificaciones
            $score = new calificaciones(); 
            echo "<div class='row'>";
            echo " <div class='col-md-6 '>";
            echo "<button type='button' class='btn btn-outline-light' style='background-color: lightseagreen' onclick='est($e);'>";
            echo "$e</button>";
            echo "<span class='text-muted'>".ucwords(strtolower($estudiante->nombres))." ".ucwords(strtolower($estudiante->apellidos));
            echo "</span><input type='hidden' name='codigo[]' class='codigo' value=".$estudiante->id_alumno."> </div>" ;

            // calificacion para disciplina
            // criterio 0 para disciplina
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 0 );
            $nota1 = $score->nota;
            echo "<div class='col-md-6' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">nota</span>';
            echo '<input type="number" step="0.1" max="5" min="0"  value="'.$nota1.'"  class="form-control A" placeholder="disciplina" name="A[]" aria-label="disciplina" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

    }
    // si es una materia distinta de disciplina
    else {
        //por cada alumno del listado del curso    
        foreach($listado->id_alumno as $e) {
            $estudiante = new alumnos($e);
            // creo un nuevo objeto de calificaciones
            $score = new calificaciones(); 
            echo "<div class='row'>";
            echo " <div class='col-md-3 '>";
            echo "<button type='button' class='btn btn-outline-light' style='background-color: lightseagreen' onclick='est($e);'>";
            echo "$e</button>";
            echo "<span class='text-muted'>".ucwords(strtolower($estudiante->nombres))." ".ucwords(strtolower($estudiante->apellidos));
            echo "</span><input type='hidden' name='codigo[]' class='codigo' value=".$estudiante->id_alumno."> </div>" ;

            switch ($semana){
            case 8:
                // presentacion personal (E)
		
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 5 );
                $nota1 = $score->nota;
                echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">presentacion personal</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="E[]"  value="'.$nota1.'"  class="form-control E" placeholder="quiz" aria-label="presentacion personal" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';


                // actitud (F)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 6 );
                $nota2 = $score->nota;
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">actitud</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="F[]" value="'.$nota2.'"  class="form-control F" placeholder="actitud" aria-label="actitud" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';
		
                //asistencia (G)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 7 );
                $nota3 = $score->nota;
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">asistencia</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="G[]" value="'.$nota3.'" class="form-control G" placeholder="asistencia" aria-label="asistencia" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';


                //evaluación final (I)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 9 );
                $nota4 = $score->nota;
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">evaluacion final</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="I[]" value="'.$nota4.'" class="form-control I" placeholder="evaluación final" aria-label="evaluacion final" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';

                //auto evaluacion (J)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 10 );
                $nota5 = $score->nota;
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">auto evaluacion</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="J[]" value="'.$nota5.'" class="form-control J" placeholder="auto evaluacion" aria-label="auto evaluacion" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';

                //LOGRO
                $score->get_logro($e, $id_m, $ano, $periodo);
                $logro = $score->logro;
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">logro</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="L[]" value="'.$logro.'" class="form-control L" placeholder="logro" aria-label="auto evaluacion" aria-describedby="basic-addon1">';
                echo '</div>';
                echo '</div>';

		
                break;
                
            case 4:
                //evaluación de proceso (A)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 1 );
                $nota1 = $score->nota;
                echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">evaluacion de proceso</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="A[]" value="'.$nota1.'" class="form-control A" placeholder="evaluación de proceso" aria-label="evaluación de proceso" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';

                // actividad (B)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 2 );
                $nota2 = $score->nota;
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">actitud</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="B[]" value="'.$nota2.'" class="form-control B" placeholder="actividad" aria-label="actividad" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';
                //taller (C)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 3 );
                $nota3 = $score->nota;
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">taller</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="C[]" value="'.$nota3.'"  class="form-control C" placeholder="taller" aria-label="taller" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';
                //tarea (D)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 4);
                $nota4 = $score->nota;
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">tarea</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="D[]" value="'.$nota4.'" class="form-control D" placeholder="tarea" aria-label="tarea" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';


                // presentacion personal (E)
		
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 5 );
                $nota5 = $score->nota;
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">presentacion personal</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="E[]" value="'.$nota5.'" class="form-control E" placeholder="quiz" aria-label="presentacion personal" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';


                // actitud(F)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 6 );
                $nota6 = $score->nota;
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">actitud</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="F[]" value="'.$nota6.'" class="form-control F" placeholder="actitud" aria-label="actitud" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';
		
                //asistencia (G)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 7 );
                $nota7 = $score->nota;
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">asistencia</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="G[]" value="'.$nota7.'" class="form-control G" placeholder="asistencia" aria-label="asistencia" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';

                //quiz (H)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 8 );
                $nota8 = $score->nota;
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">quiz</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="H[]" value="'.$nota8.'" class="form-control H" placeholder="quiz" aria-label="quiz" aria-describedby="basic-addon1">';
                echo '</div>';
                echo '</div>';
                break;

            default:
		
                //evaluación de proceso (A)

                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 1 );
                $nota1 = $score->nota;
                echo "<div class='col-md-9' name=''>";
                echo '<div class="input-group mb-2">';
                echo '<span class="input-group-text" id="addon-wrapping">evaluación de proceso</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="A[]"  value="'.$nota1.'" class="form-control A" placeholder="evaluación de proceso" aria-label="evaluación de proceso" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';

                // actividad (B)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 2 );
                $nota2 = $score->nota;
                //echo "<div class='col-md-2' name=''>";
                echo '<div class="input-group mb-2">';
                echo '<span class="input-group-text" id="addon-wrapping">actividad</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="B[]" value="'.$nota2.'" class="form-control B" placeholder="actividad" aria-label="actividad" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';
                //taller (C)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 3 );
                $nota3 = $score->nota;
                //echo "<div class='col-md-2' name=''>";
                echo '<div class="input-group mb-2">';
                echo '<span class="input-group-text" id="addon-wrapping">taller</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="C[]" value="'.$nota3.'" class="form-control C" placeholder="taller" aria-label="taller" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';
                //tarea (D)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 4 );
                $nota4 = $score->nota;
                //echo "<div class='col-md-2' name=''>";
                echo '<div class="input-group mb-2">';
                echo '<span class="input-group-text" id="addon-wrapping">tarea</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="D[]" value="'.$nota4.'" class="form-control D" placeholder="tarea" aria-label="tarea" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';

                // presentacion personal (E)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 5 );
                $nota5 = $score->nota;

                //echo "<div class='col-md-2' name=''>";
                echo '<div class="input-group mb-2">';
                echo '<span class="input-group-text" id="addon-wrapping">presentación personal</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="E[]" value="'.$nota5.'" class="form-control  E" placeholder="presentacion personal" aria-label="presentacion personal" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';

                // actitud (F)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 6 );
                $nota6 = $score->nota;
                //echo "<div class='col-md-2' name=''>";
                echo '<div class="input-group mb-2">';
                echo '<span class="input-group-text" id="addon-wrapping">actitud</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="F[]" value="'.$nota6.'" class="form-control F" placeholder="actitud" aria-label="actitud" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';
		
                //asistencia (G)
                $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 7 );
                $nota7 = $score->nota;
                //echo "<div class='col-md-2' name=''>";
                echo '<div class="input-group mb-2">';
                echo '<span class="input-group-text" id="addon-wrapping">asistencia</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="G[]" value="'.$nota7.'" class="form-control G" placeholder="asistencia" aria-label="asistencia" aria-describedby="basic-addon1">';
                echo '</div>';
                echo '</div>';
		
            }

            echo  "</div>" ;

        
        }
    
    } // fin de else 
    
    echo "</div>";

    // espacio para logros y  comentarios
    echo "<div id='logros_materia' class='col-md-4'>";
    // contenido

    if($id_m >0 and $semana == 8 ){

	
        // creo nuevo elemento de logros
        $l = new logro();
        
        $logros = $l->get_logros($id_m);

        // inicio de tabla

        echo "<table class='table'>";
        echo "<thead>";
        echo "<th scope='col'>Código</th>";
        echo "<th scope='col'>Logro</th>";
        echo "</thead><tbody clase='table-striped'>";
	
        foreach  ( $logros as  $id => $logro ){
            echo "<tr><td class='fw-bold'>";
            echo $id;
            echo "</td><td clase'lh-sm fw-lighter fst-italic text-reset'>";
            echo $logro;
            echo "</td></tr>";
        }

        echo "</tbody></table>";
	
    }
    
    echo "</div>";

    echo "</div>";
}
else {
    echo $err;
}
//$lista = new $matriculas();
?>
