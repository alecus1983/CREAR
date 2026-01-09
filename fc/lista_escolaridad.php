<?php
// archivo que obtiene en formato json
// la lista de escolaridades de la institucion

require_once "datos.php";

//variables de validacion
$valido = true;
$err = "";
$year = date('Y');


// recibo codigo del docente
$id_docente = $_POST["id_docente"];
//array de respuestals
$respuesta = [];

// creo un nuevo objeto escolaridad vacio
$e = new escolaridad();

// selecciono un listado de escolaridades
$lista = $e->lista();

// si obtengo un listado entonces
 if (isset($lista)) {

     // encapsulo  la respuesta en modo json
     echo json_encode($lista);
 }


?>
