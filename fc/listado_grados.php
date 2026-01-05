<?php


require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuesta
$respuesta = array();

if($_POST["escolaridad"]!== "" and $_POST["escolaridad"]!== "-1" and isset($_POST["escolaridad"])) {
    $id_escolaridad = $_POST["escolaridad"];
}else {
    // si no esta ingresada la escolaridad devuelve el error 21
    $valido = false;
    $respuesta['status'] = 21;
    
}

// si los datos son validos
if ($valido) {

    //objeto grados
    $obj_grados = new grados();

    
    // array de semanas
    $arr_grados = $obj_grados->get_lista_grado_escolaridad($id_escolaridad);

    // echo var_dump($arr_grados);
    
    $html = "<p>Formulario para la creación de grados  </p>";

    
    $html = $html."<div class='row'>";
    $html = $html. " <div class='col-md-12 '>";
    $html = $html. "<div class='row'>";

    
    $html = $html. "<div class='col-3'>";
    // selector de docentes
    $html = $html. "";
    $html = $html. "<div class='form-floating'>";
    $html = $html. '<select id="lista_escolaridades"  class="form-select">';
    $html = $html.'<option value""></option>';

    // creo objeto de escolaridad
    $escolaridad = new escolaridad();

    // obtengo un array con las escolaridades disponibles
    $arr_escolaridad = $escolaridad->lista();

    //echo var_dump($arr_escolaridad);
    
    //obtener todas las escolaridades disponibles en el sistema
    foreach($arr_escolaridad as $ii) {

	//echo var_dump($ii['id_escolaridad']);
	// coloco una opcion con la escolaridad 
	//$html = $html."<option value='".$arr_escolaridad[$ii]."'>$ii</option>";
    }
    
    $html = $html. "</select>";
    $html = $html. "<label for='lista_escolaridad'>Escolaridades</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";


    $html = $html. "<div class='col-2'>";
    $html = $html. "<div class='form-floating'>";
    $html = $html. '<input id="nombre_grado"  class="form-control">';
    $html = $html. "<label for='nombre_grado'>nombre del grado</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";

    // $html = $html. "<div class='col-2'>";
    // $html = $html. "<div class='form-floating'>";
    // $html = $html. '<input type="date" id="fin"  class="form-control">';
    // $html = $html. "<label for='fin'>Fin</label>";
    // $html = $html. "</div>";
    // $html = $html. "</div>";

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
