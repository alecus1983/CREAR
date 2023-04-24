<?php
// archivo de configuracion  de objetos
require_once("datos.php");


//echo "<div class='row'>Listado para la semana : ".$semana."</div>";
// validacion de datos
if($_POST["materia"] >0 ){

    
    // grado
    $grado = $_POST["grado"];
    // materia
    $materia = $_POST['materia'];

    // creo nuevo elemento de logros
    $l = new logro();

    $logros = $l->get_logro($materia);

    foreach  ($id in $logros){
        echo $id."  ".$logros[$id]."<br>  "; 
    }
    
}

?>
