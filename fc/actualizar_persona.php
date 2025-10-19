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
    // se crea una nueva persona
    $persona = new personas();
    // asigno el atributo al objeto
    $persona->id_persona = $_POST["id_persona"];

    // se incetan los datos de la persona
    $data = array(
        "nombres"=>$_POST["nombres"],
        "apellidos"=>$_POST["apellidos"],
        "tipo_identificacion"=>$_POST["tipo_identificacion"],
        "identificacion"=>$_POST["identificacion"],
        "correo"=>$_POST["correo"],
        "i_correo"=>$_POST["i_correo"],
        "telefono"=>$_POST["telefono"],
        "celular"=>$_POST["celular"],
        "nacimiento"=>$_POST["nacimiento"]            
    );

    // se acutualiza la persona
    if ($persona->update_persona($data)){
	// se agrega la respuesta
	$respuesta['html'] = "Actualizado correctamente la persona \n".ucwords(strtolower($_POST["nombres"]))." ".ucwords(strtolower($_POST["apellidos"]));
	$respuesta['status'] = 1;   
    }
}
else {
    $respuesta['html'] = "no se puedo actualizar la persona";
    $respuesta['status'] = 2;
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;

?>
