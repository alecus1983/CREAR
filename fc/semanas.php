<?php
// archivo de configuracion  de objetos
require_once("datos.php");

//variables recibidas mediante POST
$grado = $_POST["id_gs"];
// y año
$ano = $_POST["years"];//date("Y");
// identificador de materia
$id_m = $_POST["id_ms"];
// identificador de un corte
// $corte = $_POST["corte"];
$periodo = $_POST["periodo"];
$jornada = $_POST['id_jornada'];
//$semana = $_POST["semana"];

$bk= "#FFFFFF";// variable de color de fondo de tabla
$fondo = true;

echo "Se ha requerido el año $ano, el periodo $periodo, en la jornada $jornada en la materia $id_m";

//$lista = new $matriculas();
?>
