<?php
// requiere definicion de clases
require_once('datos.php');

// se  recupera el nombre por el método POST
$periodo = $_POST["periodo"];
// el año
$year = $_POST['year'];

// creo objeto semanas
$sem = new semana();
// recupero las semanas vigentes del periodo
$l_sem  = $sem->get_lista_semanas_periodo($year,$periodo);
// retorno como un json
echo json_encode($l_sem);
?>
