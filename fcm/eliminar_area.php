<?php
require_once("datos.php");

if (isset($_POST['id_area'])) {
    $id_area = $_POST['id_area'];
    $obj_area = new area();

    // VALIDACIÓN PREVIA
    if ($obj_area->tiene_materias($id_area)) {
        echo json_encode(array(
            "status" => 0, 
            "msj" => "No se puede eliminar: Esta área tiene materias vinculadas. Elimine las materias primero."
        ));
        exit; // Detenemos la ejecución
    }

    // Si pasa la validación, procedemos a borrar
    if ($obj_area->eliminar_area($id_area)) {
        echo json_encode(array("status" => 1, "msj" => "Área eliminada"));
    } else {
        echo json_encode(array("status" => 0, "msj" => "Error interno al eliminar"));
    }
}
?>
