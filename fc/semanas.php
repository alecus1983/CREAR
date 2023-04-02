<?php
// archivo de configuracion  de objetos
require_once("datos.php");

//variables recibidas mediante POST
$valido = true;
$err = "";
// y año

// identificador de materia
$id_m = $_POST["id_ms"];
// identificador de un corte
// $corte = $_POST["corte"];
$periodo = $_POST["periodo"];

//$semana = $_POST["semana"];

$bk= "#FFFFFF";// variable de color de fondo de tabla
$fondo = true;

// validacion de datos
if($_POST["id_gs"] !== ""){
    $grado = $_POST["id_gs"];
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

$listado  = new listado_estudiantes($ano,1,0);

echo "<br>El año matriculado el el ".$listado->year."<br>"; 

echo "Se ha requerido el año $ano, el periodo $periodo, en la jornada $jornada en la materia $id_m";
}
else {
    echo $err;
}
//$lista = new $matriculas();
?>
