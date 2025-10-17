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


    $data = array(
        "id_personas"=>$_POST["id_persona"],
        "nombres"=>$_POST["nombres"],
        "apellidos"=>$_POST["apellidos"],
        "tipo_identificacion"=>$_POST["tipo_identificacion"],
        "identificacion"=>$_POST["identificacion"],
        "correo"=>$_POST["correo"],
        "i_correo"=>$_POST["i_correo"],
        "telefono"=>$_POST["telefono"],
        "celular"=>$_POST["celular"],
        "nacimiento"=>$_POST["nacimiento"],
            
    );


    $respuesta['html'] = "Actualizado correctamente la persona \n".ucwords(strtolower($persona->nombres))." ".ucwords(strtolower($persona->apellidos ));
    $respuesta['status'] = 1;
    // se acutualiza la persona
    if ($persona->update_persona($data)){
        
    }
        
}
else {
    $respuesta['html'] = "";
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;

//$lista = new $matriculas();
?>
