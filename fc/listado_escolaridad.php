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
    // CAMBIO IMPORTANTE: ID único para el nombre
    $html = $html. '<input id="txt_nombre_escolaridad" class="form-control">';
    $html = $html. "<label for='txt_nombre_escolaridad'>Nombre Escolaridad</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";

    $html = $html. "<div class='col-2'>";
    // Llamamos a la función de JS que creamos
    $html = $html. '<button id="btn_accion_escolaridad" type="button" class="btn btn-outline-success" onclick="agregar_escolaridad();">Agregar/Actualizar</button>';
    $html = $html. "</div>";
    
    $html = $html. "<table class='table''>";
    $html = $html. "<thead>";
    //$html = $html. "<th scope='col'>escolaridad</th>";
    $html = $html. "<th scope='col'>nombre</th>";
    // $html = $html. "<th scope='col'>escolaridad</th>";
    $html = $html. "<th scope='col'></th>";
    $html = $html. "</thead>";
    $html = $html. "<tbody>";

    // BUCLE DE LA TABLA
    foreach($l_escolaridad as $obj_escolaridad) {
        
        $id_e = $obj_escolaridad["id_escolaridad"];
        $nom_e = $obj_escolaridad["escolaridad"];

        $html = $html. "<tr>";
        $html = $html. "<td>" . $nom_e . "</td>";
        $html = $html. "<td>";
        
        // BOTON EDITAR: Llama a preparar_edicion_escolaridad pasando ID y Nombre
        $html = $html. "<button type='button' class='btn btn-info btn-sm' style='margin-right:5px;' onclick='preparar_edicion_escolaridad(\"$id_e\", \"$nom_e\");'><i class='fas fa-edit'></i> Editar</button>";
        $html = $html. "<button type='button' class='btn btn-danger btn-sm' onclick='eliminar_escolaridad($id_e);'><i class='fas fa-trash'></i> Eliminar</button>";
        $html = $html. "</td>";
        $html = $html. "</tr>";           
    }
    
           
    // }
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
