<?php

// inserta librerias de clases
require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuesta
$respuesta = array();



    //creacion de objeto de escolaridad
    $jornada = new jornada();

    // recuperar la escolaridad
    $l_jornada = $jornada->lista();
    
    
    // echo var_dump($arr_grados);
    
    $html = "<p>Formulario para la creación de jornadas </p>";

    
    $html = $html."<div class='row'>";
    $html = $html. " <div class='col-md-12 '>";
    $html = $html. "<div class='row'>";
    
    $html = $html. "<div class='col-2'>";
    $html = $html. "<div class='form-floating'>";
    $html = $html. '<input id="nombre_jornada"  class="form-control">';
    $html = $html. "<label for='nombre_jornada'>código de la jornada</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";

    $html = $html. "<div class='col-2'>";
    $html = $html. "<div class='form-floating'>";
    $html = $html. '<input id="nombre_jornada"  class="form-control">';
    $html = $html. "<label for='nombre_jornada'>nombre de la jornada</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";

    $html = $html. "<div class='col-2'>";
    $html = $html. '<button type="button" class="btn btn-outline-success" onclick="actualizar_jornada();">Agregar/Actualizar</button>';
    $html = $html. "</div>";
    $html = $html. "</div>";

    $html = $html. "<table class='table''>";
    $html = $html. "<thead>";
    $html = $html. "<th scope='col'>codigo ornada</th>";
    $html = $html. "<th scope='col'>nombre</th>";
    // $html = $html. "<th scope='col'>escolaridad</th>";
    $html = $html. "<th scope='col'></th>";
    $html = $html. "</thead>";
    $html = $html. "<tbody>";

    
    // por cada matricula docente  
    foreach($l_jornada as $obj_jornada) {
	

        
        $html = $html. "<tr>";
        $html = $html. "<td>";
        $html = $html. $obj_jornada[0];
        $html = $html. "</td>";
        $html = $html. "<td>";
        $html = $html. $obj_jornada[1];
        $html = $html. "</td>";
        //$html = $html. "<td>";
        //$html = $html. $obj_grados->escolaridad;
        //$html = $html. "</td>";
        $html = $html. "<td>";
        $html = $html. "<button type='button' class='btn btn-warning' onclick='eliminar_jornada();'>eliminar</button>";
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


$respuesta_json = json_encode($respuesta);
echo $respuesta_json;

//$lista = new $matriculas();
?>
