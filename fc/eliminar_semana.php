<?php
// archivo que obtiene los docentes matriculados
// en una materia para un grado/curso/jornada

require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuesta
$respuesta = array();





if($_POST["semana"]!== ""){
    $semana = $_POST["semana"];
}else {
    $valido = false;
    $respuesta['status'] = 26;
    
}

// si los datos son validos
if ($valido) {

   
        
        $obj_semana = new semana();
        if ($obj_semana->reset_semana($semana)){
            // parte de la respuesta HTML
            $respuesta['html']="";
            $respuesta['status']=1;
       
        }else {
            $respuesta['html']="";
            $respuesta['status']=20;      
        }
   

}
else {
    $respuesta['html'] = "";
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;

//$lista = new $matriculas();
?>
