<?php
/**
 * Archivo: listado_materias.php
 * Función: Consultar las materias en la BD y devolver una tabla HTML
 * Retorno: JSON { status: 1, html: "<table>..." }
 */

require_once("datos.php");


// Instanciamos la clase
$obj_materia = new materia();
// instancio las areas
$obj_area= new area();
// creo la variable de salida tipo texto
// para el documento en formato html a exportar
$html = "";

// Verificar si hay un filtro de área (opcional, basado en el JS que te di antes)
$id_area = isset($_POST['id_area']) ? $_POST['id_area'] : '';

// si el area es valida
if ($id_area !== '') {
    
    //obtengo un array con las materias
    //y los identificadores de materuas
    $arr_materias =   $obj_materia->get_materias_area($id_area);


    // Iniciamos la construcción de la tabla HTML
    $html .= '<div class="table-responsive">';
    $html .= '<table class="table table-bordered table-striped table-hover">';
    $html .= '<thead class="thead-dark">';
    $html .= '<tr>';
    $html .= '<th scope="col" class="text-center">ID</th>';
    $html .= '<th scope="col">Materia</th>';
    $html .= '<th scope="col" class="text-center">ID Área</th>';
    $html .= '<th scope="col" class="text-center">I.H. (Horas)</th>';
    $html .= '<th scope="col" class="text-center">Acciones</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    // por cada materia del area
    foreach($arr_materias as $id_materia => $materia){

            //recupero el objeto materia y sus atributos
            $obj_materia->get_materia($id_materia);
            $html .= '<tr>';
            $html .= '<td class="text-center">' . $id_materia . '</td>';
            $html .= '<td>' . $obj_materia->materia . '</td>';
            $html .= '<td class="text-center">' . $obj_materia->id_area . '</td>';
            $html .= '<td class="text-center">' . $obj_materia->ih . '</td>';
            
            // Columna de acciones
            $html .= '<td class="text-center">';
            $html .= '<div class="btn-group" role="group">';
            
            // Botón Editar: Llama a preparar_edicion_materia definida en JS
            // Parámetros: id, nombre, id_area, ih
            $html .= '<button type="button" class="btn btn-warning btn-sm" 
                        onclick="preparar_edicion_materia('.$id_materia.', \''.$obj_materia->materia.'\', '.$obj_materia->id_area.', '.$obj_materia->ih.')" 
                        title="Editar esta materia">
                        <i class="fa fa-pencil"></i> Editar
                      </button>';
            
            // Botón Eliminar: Llama a del_materia definida en JS
            $html .= '<button type="button" class="btn btn-danger btn-sm ml-1" 
                        onclick="del_materia('.$id_materia.')" 
                        title="Eliminar esta materia">
                        <i class="fa fa-trash"></i> Eliminar
                      </button>';
            
            $html .= '</div>';
            $html .= '</td>';
            $html .= '</tr>';
        
    }
    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</div>';

    // Respuesta exitosa
    echo json_encode(array("status" => 1, "html" => $html));

} else {
    // Error en la consulta
    echo json_encode(array("status" => 20, "html" => ""));
}
    
?>
