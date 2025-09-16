<?php
// archivo que obtiene en formato json
// la lista de grados de una escolaridad dada

require_once "datos.php";

//variables de validacion
$valido = true;
$err = "";
$year = date('Y');

// se recibe la variable por post
 $id_escolaridad = $_POST["id_escolaridad"];
// recibo codigo del docente
$id_docente = $_POST["id_docente"];
//array de respuestals
$respuesta = [];

// creo un nuevo objeto matricula docente
// vacio
$e = new matricula_docente();

// selecciono un listado de grados
// que un docente $id tiene matriculados
// en una escolaridad $id_escolaridad
$lista = $e->lista_escolaridad($id_escolaridad, $id_docente, $year);

// si obtengo un listado entonces
 if (isset($lista)) {
     // encapsulo  la respuesta en modo json
     echo json_encode($lista);
 }
?>
