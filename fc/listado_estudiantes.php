<?php
// archivo de configuracion  de objetos
require_once("datos.php");

//variables recibidas mediante POST
$valido = true;
$err = "";

// identificador de materia
$id_m = $_POST["id_ms"];
// identificador de un corte
// $corte = $_POST["corte"];
$periodo = $_POST["periodo"];
// obtengo el año
$ano = $_POST["years"];
//obtengo el grado
$grado = $_POST["id_g"];
//obtengo la jormada
$jornada = $_POST["id_jornada"];
$semana = $_POST["semana"];

echo "<div class='row'>Listado para la semana : ".$semana."</div>";
// validacion de datos
if($_POST["id_g"] !== ""){
    $grado = $_POST["id_g"];
}else {
    $valido = false;
    $err = $err."<p>Porfavor seleccione un grado</p>";
}

if($_POST["years"]!== ""){
    $ano = $_POST["years"];//date("Y");
}else {
    $valido = false;
    $err = $err."<p>Porfavor seleccione un año</p>";
}


if($_POST["id_jornada"]!== ""){
    $jornada = $_POST['id_jornada'];
}else {
    $valido = false;
    $err = $err."<p>Porfavor seleccione un año</p>";
}

if ($valido){
    //crea un nuevo objeto listado
    $listado  = new listado_estudiantes($ano,$grado,0);

    foreach($listado->id_alumno as $e) {
        $estudiante = new alumnos($e);
        echo "<div class='row'> <div class='col-md-3 text-muted'>".ucwords(strtolower($estudiante->nombres))." ".ucwords(strtolower($estudiante->apellidos))." </div>" ;

        switch ($semana){
        case 8:
            // presentacion personal

            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">E</span>';
            echo '<input type="text" class="form-control" placeholder="quiz" aria-label="presentacion personal" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';


            // actitud
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">F</span>';
            echo '<input type="text" class="form-control" placeholder="actitud" aria-label="actitud" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            
            //asistencia
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">G</span>';
            echo '<input type="text" class="form-control" placeholder="asistencia" aria-label="asistencia" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';


            //evaluación final
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">I</span>';
            echo '<input type="text" class="form-control" placeholder="evaluación final" aria-label="evaluacion final" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';

            //auto evaluacion
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">J</span>';
            echo '<input type="text" class="form-control" placeholder="auto evaluacion" aria-label="auto evaluacion" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';

            
            break;
                                    
        case 4:
            //evaluación de proceso
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">A</span>';
            echo '<input type="text" class="form-control" placeholder="evaluación de proceso" aria-label="evaluación de proceso" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';

            // actividad
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">B</span>';
            echo '<input type="text" class="form-control" placeholder="actividad" aria-label="actividad" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            //taller
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">C</span>';
            echo '<input type="text" class="form-control" placeholder="taller" aria-label="taller" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            //tarea
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">D</span>';
            echo '<input type="text" class="form-control" placeholder="tarea" aria-label="tarea" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';

            // presentacion personal

            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">E</span>';
            echo '<input type="text" class="form-control" placeholder="presentacion personal" aria-label="presentacion personal" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';

            // presentacion personal

            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">E</span>';
            echo '<input type="text" class="form-control" placeholder="quiz" aria-label="presentacion personal" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';


            // actitud
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">F</span>';
            echo '<input type="text" class="form-control" placeholder="actitud" aria-label="actitud" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            
            //asistencia
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">G</span>';
            echo '<input type="text" class="form-control" placeholder="asistencia" aria-label="asistencia" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';

            //quiz
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">H</span>';
            echo '<input type="text" class="form-control" placeholder="quiz" aria-label="quiz" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            break;

        default:
            //evaluación de proceso
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">A</span>';
            echo '<input type="text" class="form-control" placeholder="evaluación de proceso" aria-label="evaluación de proceso" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';

            // actividad
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">B</span>';
            echo '<input type="text" class="form-control" placeholder="actividad" aria-label="actividad" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            //taller
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">C</span>';
            echo '<input type="text" class="form-control" placeholder="taller" aria-label="taller" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            //tarea
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">D</span>';
            echo '<input type="text" class="form-control" placeholder="tarea" aria-label="tarea" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';

            // presentacion personal

            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">E</span>';
            echo '<input type="text" class="form-control" placeholder="presentacion personal" aria-label="presentacion personal" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';

            // actitud
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">F</span>';
            echo '<input type="text" class="form-control" placeholder="actitud" aria-label="actitud" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            
            //asistencia
            echo "<div class='col-md-1' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">G</span>';
            echo '<input type="text" class="form-control" placeholder="asistencia" aria-label="asistencia" aria-describedby="basic-addon1">';
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
