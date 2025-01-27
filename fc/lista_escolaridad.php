<?php
// archivo que obtiene los docentes matriculados
// en una materia para un grado/curso/jornada

require_once "datos.php";

//variables de validacion
$valido = true;
$err = "";
//array de respuestals
$respuesta = [];



// creo un nuevo objeto jornada
$e = new escolaridad();
// selecciono una lista de jornadas
$lista = $e->lista();


if (isset($lista)) {
    // encapsulo  la respuesta en modo json
    echo json_encode($lista);
}
?>
