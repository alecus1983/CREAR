<?php
// archivo que obtiene los docentes matriculados
// en una materia para un grado/curso/jornada

require_once("datos.php");

//variables de validacion
$valido = true;

//array de respuesta
$respuesta = array();

// validacion de datos
if($_POST["id_personas"] >0 ){
    $id_personas = $_POST["id_personas"];
}else {
    $valido = false;
    $respuesta['status'] = 21;

}



// si los datos son validos
if ($valido) {

    $p = new personas();
    if( $p->deleteById($id_personas)){
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

?>
