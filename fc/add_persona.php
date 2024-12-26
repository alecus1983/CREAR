<?php
// archivo que obtiene los docentes matriculados
// en una materia para un grado/curso/jornada

require_once("datos.php");

//variables de validacion
$valido = true;

//array de respuesta
$respuesta = array();


// validacion de datos


// validacion de nombres
if($_POST["nombres"] !== "" ){
    $nombres = $_POST["nombres"];
}else {
    $valido = false;
    $respuesta['status'] = 21;
}
// validacion de los apellidos
if($_POST["apellidos"]!== ""){
    $apellidos = $_POST["apellidos"];
}else {
    $valido = false;
    $respuesta['status'] = 22;
}

// seleccion de tipo de identificacion
if($_POST["tipo_identificacion"]!== ""){
    $tipo_identificacion = $_POST["tipo_identificacion"];
}else {
    $valido = false;
    $respuesta['status'] = 23;
}
// valido si tiene identificacion
if($_POST["identificacion"]!== ""){
    $identificacion = $_POST["identificacion"];
}else {
    $valido = false;
    $respuesta['status'] = 24;
}

if($_POST["nacimiento"]!== ""){
    $nacimiento = $_POST["nacimiento"];
}else {
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
    $p->correo = $_POST["correo"];
    $p->i_correo = $_POST["i_correo"];
    $p->celular = $_POST["celular"];
    $p->telefono = $_POST["telefono"];
    $p->nacimiento = $_POST["nacimiento"];

    // agrego la persona
    if( $p->add()){
    $respuesta['status'] = "1";    
    }else{
    $respuesta['status'] = "20";        
    }
    $respuesta['html'] = "";
    
}
else {
    $respuesta['html'] = "";
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;

//$lista = new $matriculas();
?>
