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

    // INPUT ID (Lo hacemos readonly porque es la llave primaria)
    $html = $html. "<div class='col-2'>";
    $html = $html. "<div class='form-floating'>";
    // CAMBIO AQUI: ID único 'txt_id_jornada'
    $html = $html. '<input id="txt_id_jornada" class="form-control" readonly>'; 
    $html = $html. "<label for='txt_id_jornada'>Código</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";
    
    

    $html = $html. "<div class='col-2'>";
    $html = $html. "<div class='form-floating'>";
    $html = $html. '<input id="txt_nombre_jornada" class="form-control">'; 
    $html = $html. "<label for='txt_nombre_jornada'>Nombre Jornada</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";

      // BOTÓN GUARDAR
    $html = $html. "<div class='col-2'>";
    // CAMBIO AQUI: Llamamos a guardar_jornada()
    $html = $html. '<button type="button" class="btn btn-outline-success" onclick="guardar_jornada();">Guardar / Actualizar</button>';
    $html = $html. "</div>";
    $html = $html. "</div>";

    
    $html = $html. "<table class='table'>";
    $html = $html. "<thead>";
    $html = $html. "<th scope='col'>Código</th>";
    $html = $html. "<th scope='col'>Nombre</th>";
    $html = $html. "<th scope='col'>Acciones</th>"; // Columna acciones
    $html = $html. "</thead>";
    $html = $html. "<tbody>";

   

    foreach($l_jornada as $obj_jornada) {
        $id_j = $obj_jornada[0];
        $nom_j = $obj_jornada[1];

        $html = $html. "<tr>";
        $html = $html. "<td>" . $id_j . "</td>";
        $html = $html. "<td>" . $nom_j . "</td>";
        $html = $html. "<td>";
        
        // BOTÓN EDITAR: Llama a preparar_edicion pasando los datos
        $html = $html. "<button type='button' class='btn btn-info btn-sm' style='margin-right:5px' onclick='preparar_edicion(\"$id_j\", \"$nom_j\");'><i class='fas fa-edit'></i> Editar</button>";
        
        $html = $html. "<button type='button' class='btn btn-danger btn-sm' onclick='eliminar_jornada($id_j);'><i class='fas fa-trash'></i> Eliminar</button>";
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
