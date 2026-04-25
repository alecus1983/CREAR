<?php
// archivo que obtiene los docentes matriculados
// en una materia para un grado/curso/jornada

require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuestals
$respuesta = array();



// creo un nuevo objeto jornada
$j = new jornada();
// selecciono una lista de jornadas
$lista = $j->lista();


if (isset($lista)) {
    // encapsulo  la respuesta en modo json
    echo json_encode($lista);
}
?>