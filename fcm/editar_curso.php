<?php
/**
 * Archivo: editar_curso.php
 * Función: Actualizar nombre y estado de un curso existente
 */

require_once("datos.php");

if (isset($_POST['id_curso']) && isset($_POST['curso']) && isset($_POST['activo'])) {
    
    $id = $_POST['id_curso'];
    $nombre = $_POST['curso'];
    $activo = $_POST['activo'];

    $obj = new curso();

    if ($obj->actualizar_curso($id, $nombre, $activo)) {
        echo json_encode(array(
            "status" => 1, 
            "msj" => "Curso actualizado correctamente."
        ));
    } else {
        echo json_encode(array(
            "status" => 0, 
            "msj" => "Error al actualizar el curso."
        ));
    }
} else {
    echo json_encode(array("status" => 0, "msj" => "Faltan parámetros para la edición."));
}
?>
