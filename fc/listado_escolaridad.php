<?php

// inserta librerias de clases
require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuesta
$respuesta = array();

// si los datos son validos


    //objeto grados
    $obj_grados = new grados();

    //creacion de objeto de escolaridad
    $escolaridad = new escolaridad();

    // recuperar la escolaridad
    $l_escolaridad = $escolaridad->lista();
    
    
    // echo var_dump($arr_grados);
    
    $html = "<p>Formulario para la creación de  niveles de escolaridad </p>";

    
    $html = $html."<div class='row'>";
    $html = $html. " <div class='col-md-12 '>";
    $html = $html. "<div class='row'>";
    
    $html = $html. "<div class='col-2'>";
    $html = $html. "<div class='form-floating'>";
    $html = $html. '<input id="nombre_grado"  class="form-control">';
    $html = $html. "<label for='nombre_grado'>código de la escolaridad</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";

    $html = $html. "<div class='col-2'>";
    $html = $html. "<div class='form-floating'>";
    $html = $html. '<input id="nombre_escolaridad"  class="form-control">';
    $html = $html. "<label for='nombre_escolaridad'>nombre de la escolaridad</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";

    $html = $html. "<div class='col-2'>";
    $html = $html. '<button type="button" class="btn btn-outline-success" onclick="actualizar_escolaridad();">Agregar/Actualizar</button>';
    $html = $html. "</div>";
    $html = $html. "</div>";

    $html = $html. "<table class='table''>";
    $html = $html. "<thead>";
    $html = $html. "<th scope='col'>escolaridad</th>";
    $html = $html. "<th scope='col'>nombre</th>";
    // $html = $html. "<th scope='col'>escolaridad</th>";
    $html = $html. "<th scope='col'></th>";
    $html = $html. "</thead>";
    $html = $html. "<tbody>";

    
    // por cada matricula docente  
    foreach($l_escolaridad as $obj_escolaridad) {
	

        
        $html = $html. "<tr>";
        $html = $html. "<td>";
        $html = $html. $obj_escolaridad["id_escolaridad"];
        $html = $html. "</td>";
        $html = $html. "<td>";
        $html = $html. $obj_escolaridad["escolaridad"];
        $html = $html. "</td>";
        //$html = $html. "<td>";
        //$html = $html. $obj_grados->escolaridad;
        //$html = $html. "</td>";
        $html = $html. "<td>";
        $html = $html. "<button type='button' class='btn btn-warning' onclick='eliminar_semana();'>eliminar</button>";
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
