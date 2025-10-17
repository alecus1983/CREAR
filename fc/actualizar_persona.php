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
if($_POST["id_persona"] !== ""){
    $id_persona = $_POST["id_persona"]; 
}else {
    $valido = false;
    $respuesta['status'] = 32;    
}


// si los datos son validos
if ($valido) {

    $persona = new personas();
    $persona->id_persona = $id_persona;

    // si hay correo personal
    if ( $_POST["correo"] !== "" ){
        $persona->correo = $_POST["correo"];
        $persona->actualizar_correo_persona();
    }

    // si hay datos de correo institucional
    if ( $_POST["i_correo"] !== "" ){
        $persona->i_correo = $_POST["i_correo"];
        $persona->actualizar_i_correo_persona();
    }

    // si hay datos de telefono
    if ( $_POST["telefono"] !== "" ){
        $persona->telefono = $_POST["telefono"];
        $persona->actualizar_telefono_persona();
    }

    // si hay datos de celular
    if ( $_POST["celular"] !== "" ){
        $persona->celular = $_POST["celular"];
        $persona->actualizar_celular_persona();}

    // si hay nacimiento
    if ( $_POST["nacimiento"] !== "" ){
        $persona->nacimiento = $_POST["nacimiento"];
        $persona->actualizar_nacimiento_persona();
            }
    
    
    $persona->nombres = $_POST["nombres"];
    $persona->apellidos = $_POST["apellidos"];
    $persona->tipo_identificacion = $_POST["tipo_identificacion"];
    $persona->identificacion = $_POST["identificacion"];



    // actualizo los datos de la persona
    $persona->actualizar_nombres_persona();
    $persona->actualizar_identificacion_persona();
    

    $respuesta['html'] = "Actualizado correctamente la persona \n".ucwords(strtolower($persona->nombres))." ".ucwords(strtolower($persona->apellidos ));
    $respuesta['status'] = 1;    
}
else {
    $respuesta['html'] = "";
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;

//$lista = new $matriculas();
?>
