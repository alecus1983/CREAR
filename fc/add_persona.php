<?php
// archivo que obtiene los docentes matriculados
// en una materia para un grado/curso/jornada

require_once("datos.php");

//variables de validacion
$valido = true;

//array de respuesta
$respuesta = array();
// almaceno los datos recividos por post
$datos = $_POST;


// validacion de nombres
if ($datos["nombres"] !== "" and isset($datos["nombres"])) {
    $nombres = $datos["nombres"];
} else {
    $valido = false;
    $respuesta['status'] = 21;
}
// validacion de los apellidos
if ($datos["apellidos"] !== "" and isset($datos["apellidos"])) {
    $apellidos = $datos["apellidos"];
} else {
    $valido = false;
    $respuesta['status'] = 22;
}

// seleccion de tipo de identificacion
if ($datos["tipo_identificacion"] !== "") {
    $tipo_identificacion = $datos["tipo_identificacion"];
} else {
    $valido = false;
    $respuesta['status'] = 23;
}
// valido si tiene identificacion
if ($datos["identificacion"] !== "") {
    $identificacion = $datos["identificacion"];
} else {
    $valido = false;
    $respuesta['status'] = 24;
}

if ($datos["nacimiento"] !== "") {
    $nacimiento = $datos["nacimiento"];
} else {
    $valido = false;
    $respuesta['status'] = 25;
}



// si los datos son validos
if ($valido) {

    $p = new personas();

    // se agrega las caracteristicas
    $p->nombres = $nombres;
    $p->apellidos = $apellidos;
    $p->tipo_identificacion = $tipo_identificacion;
    $p->identificacion = $identificacion;
    $p->correo = $datos["correo"];
    $p->i_correo = $datos["i_correo"];
    $p->celular = $datos["celular"];
    $p->telefono = $datos["telefono"];
    $p->nacimiento = $datos["nacimiento"];

    // agrego la persona
    if ($p->add()) {
        $respuesta['status'] = "1";
        // los valores insertados
        $respuesta['id_persona'] = $p->id_persona;
        $respuesta['nombres'] = $nombres;
        $respuesta['apellidos'] = $apellidos;
        $respuesta['identificacion'] = $identificacion;
        $respuesta['tipo_identificacion'] = $tipo_identificacion;
        $respuesta['correo'] = $datos["correo"];
        $respuesta['i_correo'] = $datos["i_correo"];

        
    } else {
        $respuesta['status'] = "20";
    }
    $respuesta['html'] = "";
} else {
    $respuesta['html'] = "";
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;
