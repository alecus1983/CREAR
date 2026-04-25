<?php

/**
 * Archivo: listado_materias.php
 * Función: Consultar las materias en la BD y devolver una tabla HTML
 * Retorno: JSON { status: 1, html: "<table>..." }
 */

require_once("datos.php");

// Instanciamos la clase
$obj_materia = new materia();
// creo una instancia de area
$obj_area = new area();
// creo la variable html que se va a desplegar
// despues de la pericion
$html = "";

// obtenengo el listado de areas creadas
$arr_areas = $obj_area->get_all();

// encabezado
$html = "<p>Formulario para la gestión de las materias  en el area seleccionada</p><br>";

$html = $html. "<div class='row'>
                <div class='col-sm-1'> Area</div>
                <div class='col-sm-2' >
                   <select id='filtro_area'
						style='background: transparent;color: darkgreen;border: 1px'
						name='areas'
                        onchange = 'gestion_materia();'
						class='form-select'>
                   <option value='-1'>Seleccione una opcion</option>";

// por cada instancia creada en el array
// $arr_areas ejecuto ...
foreach($arr_areas as $id_area){

    // obtengo el nombre del area
    $obj_area->get_area($id_area);
    // agrego las opciones
    $html = $html."<option value ='$id_area'>".$obj_area->area."</option>";
}
//

$html = $html."</select></div>";
// campo de nombre de la materia
$html = $html. "<div class='col-2'>";
$html = $html. "<div class='form-floating'>";
$html = $html. '<input id="nombre_materia"  class="form-control">';
$html = $html. "<label for='nombre_materia'>nombre de materia</label>";
$html = $html. "</div>";
$html = $html. "</div>";

// columna de intensidad horaria 
$html = $html. "<div class='col-2'>";
$html = $html. "<div class='form-floating'>";
$html = $html. '<input id="ih_materia"  class="form-control" type="number" step="1">';
$html = $html. "<label for='ih_materia'>intensidad horaria</label>";
$html = $html. "</div>";
$html = $html. "</div>";

// codigo del boton
$html = $html. "<div class='col-2'>";
    $html = $html. '<button type="button" 
                            id="btn_accion_materia"   
                            class="btn btn-outline-success"
                            onclick="agregar_materia();">
                            Agregar/Actualizar
                    </button>';
    $html = $html. "</div>";
    $html = $html. "</div>";


// fin de fila
$html = $html."</div>";

echo json_encode(array("status" => 1, "html" => $html));
