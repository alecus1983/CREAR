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
    $respuesta['status'] = 20;   
    $respuesta['mensaje']="Error al obtener los datos de la persona"; 
}

$estrato = $_POST["estrato"];
$barrio = $_POST["barrio"];
$direccion_residencia = $_POST["direccion_residencia"];
// zona: 1 = urbana, 2 = rural
$zona = $_POST["zona"] ?? "";
// equipo tecnologico para la comunicacion virtual: 1 = celular, 2 = tablet, 3 = computador
$equipo_tecnologico = $_POST["equipo_tecnologico"] ?? "";


// si los datos son validos
if ($valido) {

    $persona = new personas();

    // agrego datos a travéz de los atributos
    $persona->estrato = $estrato ;
    $persona->barrio = $barrio;
    $persona->id_persona = $id_persona;
    $persona->direccion_residencia = $direccion_residencia;
    $persona->zona = $zona;
    $persona->equipo_tecnologico = $equipo_tecnologico;
    
    //metodo para actualizar la persona
    if($persona->actualizar_direccion_residencia()){

        $respuesta['status'] = 1;    
        $respuesta['barrio'] = $barrio;
        $respuesta['estrato'] = $estrato;
        $respuesta['direccion_residencia'] = $direccion_residencia;
        $respuesta['zona'] = $zona;
        $respuesta['equipo_tecnologico'] = $equipo_tecnologico;

    }
    

}
else {
    $respuesta['html'] = "";
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;


?>
