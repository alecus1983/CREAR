<?php
/**
 * Archivo: listado_materias.php
 * Función: Consultar las materias en la BD y devolver una tabla HTML
 * Retorno: JSON { status: 1, html: "<table>..." }
 */

require_once("datos.php");

// Instanciamos la clase
$obj_materia = new materia();
$html = "";

// Verificar si hay un filtro de área (opcional, basado en el JS que te di antes)
$id_area_filtro = isset($_POST['id_area']) ? $_POST['id_area'] : '';

// Construcción de la consulta SQL
$sql = "SELECT * FROM materia";

// Si deseas filtrar por área, descomenta y ajusta esta lógica:
// if ($id_area_filtro != "" && $id_area_filtro != "-1") {
//     $sql .= " WHERE id_area = " . $obj_materia->_db->real_escape_string($id_area_filtro);
// }

$sql .= " ORDER BY materia ASC";

$resultado = $obj_materia->_db->query($sql);

if ($resultado) {
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

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $id      = $row['id_materia'];
            $nombre  = $row['materia'];
            $id_area = $row['id_area'];
            $ih      = $row['ih'];

            // Limpiamos comillas simples en el nombre para no romper el JS en el onclick
            $nombre_escapado = htmlspecialchars($nombre, ENT_QUOTES);

            $html .= '<tr>';
            $html .= '<td class="text-center">' . $id . '</td>';
            $html .= '<td>' . $nombre . '</td>';
            $html .= '<td class="text-center">' . $id_area . '</td>';
            $html .= '<td class="text-center">' . $ih . '</td>';
            
            // Columna de acciones
            $html .= '<td class="text-center">';
            $html .= '<div class="btn-group" role="group">';
            
            // Botón Editar: Llama a preparar_edicion_materia definida en JS
            // Parámetros: id, nombre, id_area, ih
            $html .= '<button type="button" class="btn btn-warning btn-sm" 
                        onclick="preparar_edicion_materia('.$id.', \''.$nombre_escapado.'\', '.$id_area.', '.$ih.')" 
                        title="Editar esta materia">
                        <i class="fa fa-pencil"></i> Editar
                      </button>';
            
            // Botón Eliminar: Llama a del_materia definida en JS
            $html .= '<button type="button" class="btn btn-danger btn-sm ml-1" 
                        onclick="del_materia('.$id.')" 
                        title="Eliminar esta materia">
                        <i class="fa fa-trash"></i> Eliminar
                      </button>';
            
            $html .= '</div>';
            $html .= '</td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr><td colspan="5" class="text-center">No hay materias registradas.</td></tr>';
    }

    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</div>';

    // Respuesta exitosa
    echo json_encode(array("status" => 1, "html" => $html));

} else {
    // Error en la consulta
    echo json_encode(array("status" => 0, "html" => "<p class='text-danger'>Error al cargar los datos.</p>"));
}
?>
