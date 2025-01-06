<?php
// Archivo prar realizar la gestion de personas
// permite la busqueda de personas
// permite agregar personas
// asignarle correos

// archivo de datos
require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuesta
$respuesta = array();

$html = "Formulario para la gestión de personas que pertenecen a a la institución: <br><br>";
$html = $html. "<ol style = 'margin : 10px;'>";
$html = $html . "<li><i>Buscar personas</i></li>";
$html = $html . "<li><i>Agregar personas</i></li>";
$html = $html . "<li><i>Borrar personas</i></li>";
$html = $html . "<li><i>Actualizar personas</i></li>";
$html = $html . "</ol>";
$html = $html . "<div class='container container-sm'>";
$html = $html . "<div class='row'>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='nombres' class='form-label'>Nombre</label>";
$html = $html . "<input  class='form-control' id='nombres' aria-describedby='nombres' onkeydown='cambio_datos(\"#tabla\");'>";
$html = $html . "<div id='ayuda_nombre' class='form-text'>digite el nombre o parte del nombre por favor.</div>";
$html = $html . "</div>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='apellidos' class='form-label'>Apellidos</label>";
$html = $html . "<input  class='form-control' id='apellidos' aria-describedby='apellidos' onkeydown='cambio_datos(\"#tabla\");'>";
$html = $html . "<div id='ayuda_apellidos' class='form-text'>digite el nombre o parte de los apellidos por favor.</div>";
$html = $html . "</div>";
$html = $html . "</div>";
$html = $html . "<div class='row'>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='identificacion' class='form-label'>Numero de identificación</label>";
$html = $html . "<input  class='form-control' id='identificacion' aria-describedby='identificacion' type='number' onkeydown='cambio_datos(\"#tabla\");'>";
$html = $html . "<div id='ayuda_identificacion' class='form-text'>digite parte del documento de identicación por favor.</div>";
$html = $html . "</div>";
$html = $html . "<div class='col mx-auto justify-content-md'>";
$html = $html . "<br>";
$html = $html . "<button type='button' class='btn btn-outline-dark' style = 'margin: 5px' onclick='formulario_agregar_persona();'>Agregar persona</button>";
$html = $html . "</div>";

$html = $html . "</div>";
$html = $html . "</div>";
$html = $html . "";
$html = $html . "";

// si los datos son validos
if ($valido) {
    $respuesta['html']=$html;
    $respuesta['status']=1;
}
else {
    $respuesta['html'] = "";
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;

?>
