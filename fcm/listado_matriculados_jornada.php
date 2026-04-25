<?php

// 
// Archivo que obtiene los estudiantes matriculados
//

// archivo con definición de las clases
require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuesta
$respuesta = array();



// variable booleana que almacena la semana final de cada periodo
$semana_final = false;
// semana intermedia
$semana_intermedia = false;
                   



if($_POST["years"]!== ""){
    $year = $_POST["years"];//date("Y");
}else {
    $valido = false;
    $respuesta['status'] = 22;
    //$err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
}



// si los datos son validos
if ($valido) {

//objeto de semana
    $obj_semana = new semana();
        // array de semanas
    $arr_semana = $obj_semana->get_lista_semanas($year);

    $html = "<p>Listado de semanas activas para el año  <b>$year</p>";

    
    $html = $html."<div class='row'>";
    $html = $html. " <div class='col-md-12 '>";
    $html = $html. "<div class='row'>";

    
    $html = $html. "<div class='col-3'>";
    // selector de docentes
    $html = $html. "";
    $html = $html. "<div class='form-floating'>";
    $html = $html. '<select id="lista_semanas"  class="form-select">';
    $html = $html.'<option value""></option>';
    //valor de la semana inicial
    for($ii =1 ; $ii <33; $ii ++){
       $html = $html."<option value='$ii'>$ii</option>";
    }
    $html = $html. "</select>";
    $html = $html. "<label for='lista_semanas'>Semana</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";


    $html = $html. "<div class='col-2'>";
    $html = $html. "<div class='form-floating'>";
    $html = $html. '<input type="date" id="inicio"  class="form-control">';
    $html = $html. "<label for='inicio'>Inicio</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";

    $html = $html. "<div class='col-2'>";
    $html = $html. "<div class='form-floating'>";
    $html = $html. '<input type="date" id="fin"  class="form-control">';
    $html = $html. "<label for='fin'>Fin</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";


    $html = $html. "<div class='col-2'>";
    $html = $html. '<button type="button" class="btn btn-outline-success" onclick="actualizar_semana();">Agregar/Actualizar</button>';
    $html = $html. "</div>";
    $html = $html. "</div>";

    $html = $html. "<table class='table''>";
    $html = $html. "<thead>";
    $html = $html. "<th scope='col'>Semana</th>";
    $html = $html. "<th scope='col'>Inico</th>";
    $html = $html. "<th scope='col'>Fin</th>";
    $html = $html. "<th scope='col'></th>";
    $html = $html. "</thead>";
    $html = $html. "<tbody>";
    // por cada matricula docente  
    foreach($arr_semana as $semana){

        $obj_semana->get_semana_ano($semana, $year);
        
        
        $html = $html. "<tr>";
        $html = $html. "<td>";
        $html = $html. $obj_semana->semana;
        $html = $html. "</td>";
        $html = $html. "<td>";
        $html = $html. $obj_semana->inicio;
        $html = $html. "</td>";
        $html = $html. "<td>";
        $html = $html. $obj_semana->fin;
        $html = $html. "</td>";
        $html = $html. "<td>";
        $html = $html. "<button type='button' class='btn btn-warning' onclick='eliminar_semana(\"$semana\");'>eliminar</button>";
        $html = $html. "</td>";
        $html = $html. "</tr>";
                
    }
    
    
    $html = $html. "</tbody>";
       
    $html = $html. "</div>";
    $html = $html. "</div>";
    

    $html = $html. "</div>";

    // parte de la respuesta HTML
    $respuesta['html']=$html;
    $respuesta['status']=1;
}
else {
    $respuesta['html'] = "";
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;

//$lista = new $matriculas();
?>
