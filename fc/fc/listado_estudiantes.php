<?php
// archivo de configuracion  de objetos
require_once("datos.php");

//variables recibidas mediante POST
$valido = true;
$err = "";

// // identificador de materia
// $id_m = $_POST["id_ms"];
// // identificador de un corte
// $periodo = $_POST["periodo"];
// // obtengo el año
// $ano = $_POST["years"];
// //obtengo el grado
// $grado = $_POST["id_g"];
// //obtengo la jormada
// $jornada = $_POST["id_jornada"];
// //semana
 $semana = $_POST["semana"];

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
    echo "<p>Listado de  estudiantes de <b>".$cr->materia."</b> del grado <b>".$gr->n_grado."</b> </p>";
    
    //echo "</div>";
    //echo"</div>";
    //crea un nuevo objeto listado
    $listado  = new listado_estudiantes($ano,$grado,0);

    foreach($listado->id_alumno as $e) {
        $estudiante = new alumnos($e);
        // creo un nuevo objeto de calificaciones
        $score = new calificaciones(); 
        echo "<div class='row'> <div class='col-md-3 text-muted'><label class='text-primary'>$e</label>  ".ucwords(strtolower($estudiante->nombres))." ".ucwords(strtolower($estudiante->apellidos));
        echo "<input type='hidden' name='codigo[]' class='codigo' value=".$estudiante->id_alumno."> </div>" ;

        switch ($semana){
        case 8:
            // presentacion personal (E)
            
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 5 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">E</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="E[]"  value="'.$nota.'"  class="form-control E" placeholder="quiz" aria-label="presentacion personal" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';


            // actitud (F)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 6 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">F</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="F[]" value="'.$nota.'"  class="form-control F" placeholder="actitud" aria-label="actitud" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            
            //asistencia (G)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 7 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">G</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="G[]" value="'.$nota.'" class="form-control G" placeholder="asistencia" aria-label="asistencia" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';


            //evaluación final (I)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 9 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">I</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="I[]" value="'.$nota.'" class="form-control I" placeholder="evaluación final" aria-label="evaluacion final" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';

            //auto evaluacion (J)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 10 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">J</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="J[]" value="'.$nota.'" class="form-control J" placeholder="auto evaluacion" aria-label="auto evaluacion" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';

            
            break;
                                    
        case 4:
            //evaluación de proceso (A)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 1 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">A</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="A[]" value="'.$nota.'" class="form-control A" placeholder="evaluación de proceso" aria-label="evaluación de proceso" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';

            // actividad (B)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 2 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">B</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="B[]" value="'.$nota.'" class="form-control B" placeholder="actividad" aria-label="actividad" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            //taller (C)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 3 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">C</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="C[]" value="'.$nota.'"  class="form-control C" placeholder="taller" aria-label="taller" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            //tarea (D)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 4);
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">D</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="D[]" value="'.$nota.'" class="form-control D" placeholder="tarea" aria-label="tarea" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';


            // presentacion personal (E)
            
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 5 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">E</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="E[]" value="'.$nota.'" class="form-control E" placeholder="quiz" aria-label="presentacion personal" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';


            // actitud(F)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 6 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">F</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="F[]" value="'.$nota.'" class="form-control F" placeholder="actitud" aria-label="actitud" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            
            //asistencia (G)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 7 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">G</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="G[]" value="'.$nota.'" class="form-control G" placeholder="asistencia" aria-label="asistencia" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';

            //quiz (H)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 8 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">H</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="H[]" value="'.$nota.'" class="form-control H" placeholder="quiz" aria-label="quiz" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            break;

        default:
            
            //evaluación de proceso (A)

            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 1 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">A</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="A[]"  value="'.$nota.'" class="form-control A" placeholder="evaluación de proceso" aria-label="evaluación de proceso" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';

            // actividad (B)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 2 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">B</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="B[]" value="'.$nota.'" class="form-control B" placeholder="actividad" aria-label="actividad" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            //taller (C)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 3 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">C</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="C[]" value="'.$nota.'" class="form-control C" placeholder="taller" aria-label="taller" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            //tarea (D)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 4 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">D</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="D[]" value="'.$nota.'" class="form-control D" placeholder="tarea" aria-label="tarea" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';

            // presentacion personal (E)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 5 );
            $nota = $score->nota;

            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">E</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="E[]" value="'.$nota.'" class="form-control  E" placeholder="presentacion personal" aria-label="presentacion personal" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';

            // actitud (F)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 6 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">F</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="F[]" value="'.$nota.'" class="form-control F" placeholder="actitud" aria-label="actitud" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            
            //asistencia (G)
            $score->get_calificacion_semanal($e, $id_m,$id_semana, $ano, 7 );
            $nota = $score->nota;
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">G</span>';
            echo '<input type="number" step="0.1" max="5" min="0" name="G[]" value="'.$nota.'" class="form-control G" placeholder="asistencia" aria-label="asistencia" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            
        }

        echo  "</div>" ;

        
        }
}
else {
    echo $err;
}
//$lista = new $matriculas();
?>