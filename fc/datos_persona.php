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

if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
        $respuesta['status'] = 0;
        $respuesta['html'] = "<div class='alert alert-danger'>Error: ID de persona no válido.</div>";
        echo json_encode($respuesta);
        return;
    }

// creo nueva persona
$persona = new personas();
// obtengo los datos de la persona
$a = $persona->get_persona_por_id($id);

$html = "";
$html = $html . "<div class='container container-sm actualizar_personas'>";
$html = $html . "<div class='row'>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='nombres' class='form-label'>Nombre</label>";
$html = $html . "<input  value = '".$persona->nombres."' class='form-control' id='ac_nombres' aria-describedby='nombres' >";
$html = $html . "<input  type='hidden' id='ac_id_persona' value='".$persona->id_persona."'>";
$html = $html . "<div id='ayuda_nombre' class='form-text'>actualize el  nombre por favor.</div>";
$html = $html . "</div>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='apellidos' class='form-label'>Apellidos</label>";
$html = $html . "<input  value = '".$persona->apellidos."'class='form-control' id='ac_apellidos' aria-describedby='apellidos' >";
$html = $html . "<div id='ayuda_apellidos' class='form-text'>digite el apellido o parte del mismo por favor.</div>";
$html = $html . "</div>";
$html = $html . "</div>";



$html = $html . "<div class='row'>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='ac_tipo_identificacion' class='form-label'>tipo de identificación</label>";
$html = $html . "<select class='form-control' id='ac_tipo_identificacion'>";

// si la persona tiene un tipo de identificacion 1
if ($persona->tipo_identificacion == 1){
    // si es tipo 1
    $html = $html . "<option value = '1' selected>targeta de identidad</option>";
} else
{
    // si no es tipo 1
    $html = $html . "<option value = '1'>targeta de identidad</option>";
}
// si la persona tiene un tipo de identificacion 2
if ($persona->tipo_identificacion == 2){
    // si es tipo 2
    $html = $html . "<option value = '2' selected>cedula de ciudadania</option>";
} else {
    $html = $html . "<option value = '2'>cedula de ciudadania</option>";
}

// si la persona tiene un tipo de identificacion 3
if ($persona->tipo_identificacion == 3){
    // si es tipo 3
    $html = $html . "<option value = '3' selected>cedula de extranjeria</option>";
} else
{
    $html = $html . "<option value = '3'>cedula de extranjeria</option>";    
}

// si la persona tiene un tipo de identificacion 4
if ($persona->tipo_identificacion == 4){
    // si es tipo 4
    $html = $html . "<option value = '4' selected>visa</option>";
} else
{
    $html = $html . "<option value = '4'>visa</option>";    
}

// si la persona tiene un tipo de identificacion 5
if ($persona->tipo_identificacion == 5){
    // si es tipo 5
    $html = $html . "<option value = '5' selected>permiso de proteccion temporal</option>";
} else
{
    $html = $html . "<option value = '5'>permiso de proteccion temporal</option>";
}


$html = $html . "<option value = '6'>permiso especial de permanencia</option>";
$html = $html . "</select>";

//$html = $html . "<input  value = '".$persona->tipo_identificacion."' class='form-control' id='tipo_identificaicon' aria-describedby='tipo_identificacion' >";
$html = $html . "<div id='ayuda_nombre' class='form-text'>actualize el  tipo de identificación.</div>";
$html = $html . "</div>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='ac_identificacion' class='form-label'>identificacion</label>";
$html = $html . "<input  value = '".$persona->identificacion."'class='form-control' id='ac_identificacion' aria-describedby='identificacion' >";
$html = $html . "<div id='ayuda_identificacion' class='form-text'>digite la identificacion por favor.</div>";
$html = $html . "</div>";
$html = $html . "</div>";


$html = $html . "<div class='row'>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='ac_correo' class='form-label'>correo personal</label>";
$html = $html . "<input  value = '".$persona->correo."' class='form-control' id='ac_correo' aria-describedby='correo' type='email'>";
$html = $html . "<div id='ayuda_correo' class='form-text'>actualize el  correo por favor.</div>";
$html = $html . "</div>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='ac_i_correo' class='form-label'>correo  institucional</label>";
$html = $html . "<input  value = '".$persona->i_correo."'class='form-control' id='ac_i_correo' aria-describedby='i_correo' type='email' >";
$html = $html . "<div id='ayuda_i_correo' class='form-text'>digite el correo institucional por favor.</div>";
$html = $html . "</div>";
$html = $html . "</div>";

$html = $html . "<div class='row'>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='ac_celular' class='form-label'>número de celular</label>";
$html = $html . "<input  value = '".$persona->celular."' class='form-control' id='ac_celular' aria-describedby='celular' >";
$html = $html . "<div id='ayuda_celular' class='form-text'>actualize su celular favor.</div>";
$html = $html . "</div>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='ac_telefono' class='form-label'>número telefono fijo</label>";
$html = $html . "<input  value = '".$persona->telefono."'class='form-control' id='ac_telefono' aria-describedby='telefono' >";
$html = $html . "<div id='ayuda_telefono' class='form-text'>actulize su telefono por favor.</div>";
$html = $html . "</div>";
$html = $html . "</div>";


$html = $html . "<div class='row'>";
$html = $html . "<div class='col'>";
$html = $html . "<label for='ac_nacimiento' class='form-label'>fecha de nacimiento</label>";
$html = $html . "<input  class='form-control' id='ac_nacimiento' aria-describedby='nacimiento' type='date' min='1920-01-01' value='".$persona->nacimiento."' >";
$html = $html . "<div id='ayuda_nacimiento' class='form-text'>seleccione la fecha de nacimiento  por favor.</div>";
$html = $html . "</div>";
$html = $html . "<div class='col mx-auto justify-content-md'>";
$html = $html . "<br>";
$html = $html . "<button type='button' id='actualizar_persona' class='btn btn-outline-dark' style = 'margin: 5px' onclick='actualizar_persona();'>actualizar </button>";
$html = $html . "<button type='button' id='actualizar_persona_cancelar' class='btn btn-outline-danger' style = 'margin: 5px' onclick=';'>cancelar </button>";
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
