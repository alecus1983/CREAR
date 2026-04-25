<?php
session_start();
require_once("datos.php");

// Respuesta por defecto
$respuesta = array('status' => 0, 'msg' => 'Error desconocido');

if (isset($_POST['id'])) {
    
    $id = $_POST['id'];
    
    // Instancia de la clase
    $obj = new jornada();
    
    // Intentar eliminar
    if ($obj->eliminar($id)) {
        $respuesta['status'] = 1;
        $respuesta['msg'] = "La jornada ha sido eliminada correctamente.";
    } else {
        // Esto suele pasar si hay Integridad Referencial (ej: alumnos usando esa jornada)
        $respuesta['msg'] = "No se pudo eliminar. Es posible que existan cursos o alumnos asociados a esta jornada.";
    }

} else {
    $respuesta['msg'] = "No se recibió el identificador de la jornada.";
}

echo json_encode($respuesta);
?>