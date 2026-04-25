<?php
// archivo que obtiene los docentes matriculados
// en una materia para un grado/curso/jornada

require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuesta
$respuesta = array();

if($_POST["years"]!== ""){
    $year = $_POST["years"];//date("Y");
}else {
    $valido = false;
    $respuesta['status'] = 22;
    
}

if($_POST["inicio"]!== ""){
    $f_inicio = $_POST["inicio"];//date("Y");
}else {
    $valido = false;
    $respuesta['status'] = 23;
    
}

if($_POST["fin"]!== ""){
    $f_fin = $_POST["fin"];
}else {
    $valido = false;
    $respuesta['status'] = 24;
    
}

if($_POST["semana"]!== ""){
    $semana = $_POST["semana"];
}else {
    $valido = false;
    $respuesta['status'] = 26;
    
}

// si los datos son validos
if ($valido) {

    $inicio = new Datetime($f_inicio);
    $fin = new DateTime($f_fin);
    //si el inicio es menor que el fin
    if($inicio < $fin ){
        
        
        $obj_semana = new semana();
        if ($obj_semana->set_semana($semana,$year,$f_inicio,$f_fin)){
            // parte de la respuesta HTML
            $respuesta['html']="";
            $respuesta['status']=1;
        }else{
            // parte de la respuesta HTML
        $respuesta['html']="";
        $respuesta['status']=20;
        }
        


        // parte de la respuesta HTML
        $respuesta['html']="";
        $respuesta['status']=1;
        
    }
    // sino envío el errror
    else {
        $respuesta['status'] = 25;
        $respuesta['html'] = "";
    }

}
else {
    $respuesta['html'] = "";
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;

//$lista = new $matriculas();
?>
