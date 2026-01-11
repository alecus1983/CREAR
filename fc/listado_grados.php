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

    //creacion de objeto de escolaridad
    $escolaridad = new escolaridad();

    // recuperar la escolaridad
    $escolaridad->get_escolaridad_por_id($id_escolaridad);
    
    // array de grados
    $arr_grados = $obj_grados->get_lista_grado_escolaridad($id_escolaridad);

    // echo var_dump($arr_grados);
    
    $html = "<p>Formulario para la creación de grados  en la escolaridad <b>".$escolaridad->escolaridad."</b> </p>";

    
    $html = $html."<div class='row'>";
    $html = $html. " <div class='col-md-12 '>";
    $html = $html. "<div class='row'>";
    
    $html = $html. "<div class='col-2'>";
    $html = $html. "<div class='form-floating'>";
    $html = $html. '<input id="codigo_grado"  class="form-control">';
    $html = $html. "<label for='codigo_grado'>código del grado</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";

    $html = $html. "<div class='col-2'>";
    $html = $html. "<div class='form-floating'>";
    $html = $html. '<input id="nombre_grado"  class="form-control">';
    $html = $html. "<label for='nombre_grado'>nombre del grado</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";

    $html = $html. "<div class='col-2'>";
    $html = $html. "<div class='form-floating'>";
    $html = $html. '<input id="txt_nuevo_promovido"  class="form-control">';
    $html = $html. "<label for='txt_nuevo_promovido'>promovido</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";



    $html = $html. "<div class='col-2'>";
    $html = $html. "<div class='form-floating'>";
    
    $html = $html. "<select id='formato_boletin'
						style='background: transparent;color: darkgreen;border: 0px'
						name='formato_boletin'
						class='form-control' required=''>
                        <option value ='1'>1 - preescolar</option>
                        <option value ='2'>2 - bachillerato</option>
                    </select>";

    // $html = $html. '<input id="formato_boletin"  class="form-control" data-toggle="tooltip" 
    //                         data-placement="bottom" 
    //                         title="1 para el formato de prescolar,  2 para el formato de bachillerato" >';
    $html = $html. "<label for='formato_boletin'>formato boletin</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";

    $html = $html. "<div class='col-2'>";
    $html = $html. '<button type="button" 
                            id="btn_accion_grado"   
                            class="btn btn-outline-success"
                            
                            onclick="agregar_grado();">
                            Agregar/Actualizar
                            
                    </button>';
    $html = $html. "</div>";
    $html = $html. "</div>";

    $html = $html. "<table class='table''>";
    $html = $html. "<thead>";
    $html = $html. "<th scope='col'>código del grado</th>";
    $html = $html. "<th scope='col'>nombre del grado</th>";
    $html = $html. "<th scope='col'>escolaridad</th>";
    $html = $html. "<th scope='col'>promovido</th>";
    $html = $html. "<th scope='col'>formato boletin</th>";
    $html = $html. "<th scope='col'></th>";
    // $html = $html. "<th scope='col'></th>";
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
        $html = $html. $obj_grados->promovido;
        $html = $html. "</td>";
        $html = $html. "<td>";
        $html = $html. $obj_grados->formato_boletin;
        $html = $html. "</td>";

        
        // ... dentro del loop
        $html = $html. "<td>";      
        // Boton Editar (Pasa los datos actuales como parametros)
        $html = $html. "<button type='button' class='btn btn-info btn-sm' style='margin-right:5px;' 
         onclick='preparar_edicion_grado(".$id_grado.", \"".$obj_grados->grado."\", \"".$obj_grados->nombre_g."\", \"".$obj_grados->promovido."\", \"".$obj_grados->formato_boletin."\")'>
         <i class='fas fa-edit'></i></button>";

        $html = $html. "<button type='button' class='btn btn-warning btn-sm' onclick='del_grado(".$obj_grados->id_grado.");'>eliminar</button>";
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
