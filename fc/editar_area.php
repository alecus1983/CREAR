<?php
/**
 * Archivo: editar_area.php
 * Función: Actualizar el nombre de un área existente
 * Retorno: JSON { status: 1, msj: "..." }
 */

require_once("datos.php");

// Verificamos que los datos necesarios lleguen por POST
if (isset($_POST['id_area']) && isset($_POST['area'])) {
    
    $id_area = $_POST['id_area'];
    $nombre_nuevo = $_POST['area'];

    // Instanciamos la clase area
    $obj_area = new area();

    // Ejecutamos la actualización
    // Nota: Asegúrate de tener el método actualizar_area en tu clase (ver abajo)
    if ($obj_area->actualizar_area($id_area, $nombre_nuevo)) {
        echo json_encode(array(
            "status" => 1, 
            "msj" => "Área actualizada correctamente"
        ));
    } else {
        echo json_encode(array(
            "status" => 0, 
            "msj" => "Error al intentar actualizar el área"
        ));
    }
} else {
    echo json_encode(array(
        "status" => 0, 
        "msj" => "Datos incompletos"
    ));
}
?>
