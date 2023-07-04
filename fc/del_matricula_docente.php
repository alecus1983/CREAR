<?php
// archivo que obtiene los docentes matriculados
// en una materia para un grado/curso/jornada

require_once("datos.php");

//variables de validacion
$valido = true;

//array de respuesta
$respuesta = array();

// validacion de datos
if($_POST["id"] >0 ){
    $id = $_POST["id"];
}else {
    $valido = false;
    $respuesta['status'] = 21;
    //$err = $err."<p class='text-danger'>Porfavor seleccione un grado</p>";
}

// si los datos son validos
if ($valido) {

    $md = new matricula_docente();
    if( $md->del($id)){
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
