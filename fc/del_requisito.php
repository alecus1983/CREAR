<?php
// archivo que obtiene los docentes matriculados
// en una materia para un grado/curso/jornada

require_once("datos.php");

//variables de validacion
$valido = true;

//array de respuesta
$respuesta = array();

// validacion de datos
if($_POST["id_g"] >0 ){
    $grado = $_POST["id_g"];
}else {
    $valido = false;
    $respuesta['status'] = 21;
    //$err = $err."<p class='text-danger'>Porfavor seleccione un grado</p>";
}

if($_POST["years"]!== ""){
    $ano = $_POST["years"];//date("Y");
}else {
    $valido = false;
    $respuesta['status'] = 22;
    //$err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
}

if($_POST["id_ms"]!== ""){
    $id_materia = $_POST["id_ms"];//date("Y");
}else {
    $valido = false;
    $respuesta['status'] = 25;
    //$err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
}


// si los datos son validos
if ($valido) {

    $rq = new requisitos();
    if( $rq->del($id_materia, $grado)){
    $respuesta['status'] = "1";    
    }else{
    $respuesta['status'] = "20";        
    }
    $respuesta['html'] = "";
    
}
else {
    $respuesta['html'] = "";
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;

//$lista = new $matriculas();
?>
