<?php
// archivo que obtiene los docentes matriculados
// en una materia para un grado/curso/jornada

require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuesta
$respuesta = array();

if($_POST["escolaridad"]!== ""){
    $id_escolaridad = $_POST["escolaridad"];//date("Y");
}else {
    $valido = false;
    $respuesta['status'] = 21;
    //$err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
}

// si los datos son validos
if ($valido) {

    //objeto grados
    $obj_grados = new grados();

    
    // array de semanas
    $arr_grados = $obj_grados->get_lista_grado_escolaridad($id_escolaridad);

    // echo var_dump($arr_grados);
    
    $html = "<p>Listado de grados para la escolaridad  </p>";

    
    $html = $html."<div class='row'>";
    $html = $html. " <div class='col-md-12 '>";
    $html = $html. "<div class='row'>";

    
    $html = $html. "<div class='col-3'>";
    // selector de docentes
    $html = $html. "";
    $html = $html. "<div class='form-floating'>";
    $html = $html. '<select id="lista_grados"  class="form-select">';
    $html = $html.'<option value""></option>';
    //valor de la semana inicial
    for($ii =1 ; $ii <33; $ii ++){
	// 
       $html = $html."<option value='$ii'>$ii</option>";
    }
    $html = $html. "</select>";
    $html = $html. "<label for='lista_grados'>Grados</label>";
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
    $html = $html. "<th scope='col'>grado</th>";
    $html = $html. "<th scope='col'>nombre_g</th>";
    $html = $html. "<th scope='col'>escolaridad</th>";
    $html = $html. "<th scope='col'></th>";
    $html = $html. "</thead>";
    $html = $html. "<tbody>";

    
    // por cada matricula docente  
    foreach($arr_grados as $id_grado) {
	// obtengo los atributos de la instancia
	// del gado

	// echo "<br>codigo del grado".$id_grado;
        $obj_grados->get_grado_id($id_grado);
        
        $html = $html. "<tr>";
        $html = $html. "<td>";
        $html = $html. $obj_grados->grado;
        $html = $html. "</td>";
        $html = $html. "<td>";
        $html = $html. $obj_grados->nombre_g;
        $html = $html. "</td>";
        $html = $html. "<td>";
        $html = $html. $obj_grados->escolaridad;
        $html = $html. "</td>";
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
}
else {
    $respuesta['html'] = "";
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;

//$lista = new $matriculas();
?>
