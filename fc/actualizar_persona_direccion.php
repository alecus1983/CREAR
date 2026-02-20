<?php
// archivo que obtiene los docentes matriculados
// en una materia para un grado/curso/jornada

require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuesta
$respuesta = array();

// si resibo un codigo de persona
if($_POST["id_persona"]!== "") {
    $id_persona = $_POST["id_persona"]; 
}else {
    $valido = false;
    $respuesta['status'] = 32;    
}

$estrato = $_POST["estrato"];
$barrio = $_POST["barrio"];
$direccion_residencia = $_POST["direccion_residencia"];


// si los datos son validos
if ($valido) {

    $persona = new personas();

    // agrego datos a travéz de los atributos
    $persona->estrato = $estrato ;
    $persona->barrio = $barrio;
    $persona->id_persona = $id_persona;
    $persona->direccion_residencia = $direccion_residencia;
    
    //metodo para actualizar la persona
    if($persona->actualizar_direccion_residencia()){

        $respuesta['status'] = 1;    
        $respuesta['barrio'] = $barrio;
        $respuesta['estrato'] = $estrato;
        $respuesta['direccion_residencia'] = $direccion_residencia;

    }
    

}
else {
    $respuesta['html'] = "";
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;


?>
