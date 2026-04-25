<?php
/**
 * Archivo: agregar_curso.php
 * Función: Insertar un nuevo curso en la base de datos
 */

require_once("datos.php");

if (isset($_POST['curso']) && isset($_POST['activo'])) {
    
    $nombre = $_POST['curso'];
    $activo = $_POST['activo']; // Llega como 0 o 1 desde el JS

    $obj = new curso();

    if ($obj->insertar_curso($nombre, $activo)) {
        echo json_encode(array(
            "status" => 1, 
            "msj" => "Curso '$nombre' creado exitosamente."
        ));
    } else {
        echo json_encode(array(
            "status" => 0, 
            "msj" => "Error al insertar en la base de datos."
        ));
    }
} else {
    echo json_encode(array("status" => 0, "msj" => "Datos incompletos."));
}
?>
