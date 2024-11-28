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
// obtengo los datos de la persona
$persona->get_persona_por_id($id);

$html = "";
$html = $html . "<div class='container container-sm actualizar_personas'>";
$html = $html . "<div class='row'>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='nombres' class='form-label'>Nombre</label>";
$html = $html . "<input  value = '".$persona->nombres."' class='form-control' id='nombres' aria-describedby='nombres' >";
$html = $html . "<div id='ayuda_nombre' class='form-text'>actualize el  nombre por favor.</div>";
$html = $html . "</div>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='apellidos' class='form-label'>Apellidos</label>";
$html = $html . "<input  value = '".$persona->apellidos."'class='form-control' id='apellidos' aria-describedby='apellidos' onkeydown='cambio_datos();'>";
$html = $html . "<div id='ayuda_apellidos' class='form-text'>digite el nombre o parte de los apellidos por favor.</div>";
$html = $html . "</div>";
$html = $html . "</div>";

$html = $html . "<div class='row'>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='nombres' class='form-label'>tipo de identificación</label>";
$html = $html . "<input  value = '".$persona->tipo_identificacion."' class='form-control' id='tipo_identificaicon' aria-describedby='tipo_identificacion' >";
$html = $html . "<div id='ayuda_nombre' class='form-text'>actualize el  tipo de identificación.</div>";
$html = $html . "</div>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='apellidos' class='form-label'>identificacion</label>";
$html = $html . "<input  value = '".$persona->identicacion."'class='form-control' id='apellidos' aria-describedby='apellidos' onkeydown='cambio_datos();'>";
$html = $html . "<div id='ayuda_apellidos' class='form-text'>digite el nombre o parte de los apellidos por favor.</div>";
$html = $html . "</div>";
$html = $html . "</div>";


$html = $html . "<div class='row'>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='nombres' class='form-label'>correo personal</label>";
$html = $html . "<input  value = '".$persona->correo."' class='form-control' id='nombres' aria-describedby='correo' >";
$html = $html . "<div id='ayuda_nombre' class='form-text'>actualize el  nombre por favor.</div>";
$html = $html . "</div>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='apellidos' class='form-label'>correo  institucional</label>";
$html = $html . "<input  value = '".$persona->i_correo."'class='form-control' id='apellidos' aria-describedby='apellidos' onkeydown='cambio_datos();'>";
$html = $html . "<div id='ayuda_apellidos' class='form-text'>digite el nombre o parte de los apellidos por favor.</div>";
$html = $html . "</div>";
$html = $html . "</div>";

$html = $html . "<div class='row'>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='nombres' class='form-label'>número de celular</label>";
$html = $html . "<input  value = '".$persona->celular."' class='form-control' id='celular' aria-describedby='celular' >";
$html = $html . "<div id='ayuda_nombre' class='form-text'>actualize su celular favor.</div>";
$html = $html . "</div>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='apellidos' class='form-label'>número telefono fijo</label>";
$html = $html . "<input  value = '".$persona->telefono."'class='form-control' id='telefono' aria-describedby='telefono' >";
$html = $html . "<div id='ayuda_apellidos' class='form-text'>actulize su telefono por favor.</div>";
$html = $html . "</div>";
$html = $html . "</div>";


$html = $html . "<div class='row'>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='nacimiento' class='form-label'>fecha de nacimiento</label>";
$html = $html . "<input  class='form-control' id='nacimiento' aria-describedby='nacimiento' type='number' >";
$html = $html . "<div id='ayuda_nacimiento' class='form-text'>seleccione la fecha de nacimiento  por favor.</div>";
$html = $html . "</div>";
$html = $html . "<div class='col mx-auto justify-content-md'>";
$html = $html . "<br>";
$html = $html . "<button type='button' class='btn btn-outline-dark' style = 'margin: 5px'>actualizar </button>";
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
