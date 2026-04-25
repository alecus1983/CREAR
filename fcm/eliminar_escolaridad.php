<?php
// eliminar_escolaridad.php
require_once("datos.php");

$respuesta = array();

// Verificamos que se reciba el ID
if (isset($_POST['id_escolaridad'])) {
    
    $id = $_POST['id_escolaridad'];
    
    // Instanciamos la clase
    $obj_escolaridad = new escolaridad();
    
    // Intentamos eliminar
    if ($obj_escolaridad->eliminar($id)) {
        $respuesta['status'] = 1;
        $respuesta['msg'] = "La escolaridad ha sido eliminada correctamente.";
    } else {
        $respuesta['status'] = 0;
        $respuesta['msg'] = "Error al intentar eliminar el registro. Puede que esté relacionado con otros datos.";
    }
    
} else {
    $respuesta['status'] = 2;
    $respuesta['msg'] = "No se recibió el identificador de la escolaridad.";
}

echo json_encode($respuesta);
?>