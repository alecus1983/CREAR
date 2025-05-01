<?php

// archivo resultante para obtener
// los datos de  una matricula en particular

// requiere archivo de datos
require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuestals
$respuesta = array();

// valida si recibe la informacion del año
if($_POST["id_matricula"]!== ""){
    $id_matricula = $_POST["id_matricula"];
}else {
    $valido = false;
    $respuesta['status'] = 22;
    //$err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
}

// si los datos son validos
if ($valido) {

    //   creo un objeto tipo matricula
    $matricula =  new matricula();

    $matricula->get_matricula_id($id_matricula);

    // Crear un arreglo con los datos
    $respuesta['json'] = array(
        "id" => $matricula->id,
        "id_alumno" => $matricula->id_alumno,
        "id_grado" => $matricula->id_grado,
        "id_jornada" => $matricula->id_jornada,
        "year" => $matricula->year,
        "mes" => $matricula->mes,
        "retiro" => $matricula->retiro,
        "id_curso" => $matricula->id_curso
    );
    
    // encapsulo  la respuesta en modo json
    $respuesta_json = json_encode($respuesta['json']);
    // emito la respuesta
    echo $respuesta_json;
}
    ?>
