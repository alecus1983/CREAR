<?php
// archivo que obtiene en formato json
// la lista de grados de una escolaridad dada

require_once "datos.php";

//variables de validacion
$valido = true;
$err = "";
$year = date('Y');


// recibo codigo del docente
$id_docente = $_POST["id_docente"];
//array de respuestals
$respuesta = [];

// creo un nuevo objeto matricula docente
// vacio
$e = new matricula_docente();

// valido  el campo escolarida
if($_POST["id_escolaridad"]!== ""){
    // se recibe la variable por post
 $id_escolaridad = $_POST["id_escolaridad"];}
else {
    // si no esta ingresada la escolaridad devuelve el error 21
    $valido = false;
    $respuesta['status'] = 21;
}

if ($valido){

// selecciono un listado de grados
// que un docente $id tiene matriculados
// en una escolaridad $id_escolaridad
$lista = $e->lista_escolaridad($id_escolaridad, $id_docente, $year);

// si obtengo un listado entonces
 if (isset($lista)) {

    //$respuesta['status'] = 1;
    //$respuesta['html'] = $lista;
     // encapsulo  la respuesta en modo json
     echo json_encode($lista);
 }

}
else {
    $respuesta['html'] = "";
    $respuesta_json = json_encode($respuesta);
echo $respuesta_json;}




?>
