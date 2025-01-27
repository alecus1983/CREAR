<?php
// archivo que obtiene los docentes matriculados
// en una materia para un grado/curso/jornada

require_once "datos.php";

//variables de validacion
$valido = true;
$err = "";

// var_dump($_POST);
// se recibe la variable por post
 $id_escolaridad = $_POST["id_escolaridad"];
//array de respuestals
$respuesta = [];



// // creo un nuevo objeto jornada
$e = new grados();
// // selecciono una lista de jornadas
$lista = $e->lista_escolaridad($id_escolaridad);


 if (isset($lista)) {
     // encapsulo  la respuesta en modo json
     echo json_encode($lista);
 }
?>
