<?php
// Archivo prar realizar la gestion de personas
// permite la busqueda de personas
// permite agregar personas
// asignarle correos

// archivo de datos
require_once("datos.php");
// obtencion de id
$id = $_POST["id"];
//variables de validacion
$valido = true;

$err = "";
//array de respuesta
$respuesta = array();

// creo nueva persona
$persona = new personas();

// si los datos son validos
if ($valido) {

    // obtengo los datos de la persona
    $respuesta = $persona->get_direccion( $id);
    // agrego el estado de la peticion
    $respuesta['status']=1;
}
else {
    $respuesta['status'] = 20;
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;

?>
