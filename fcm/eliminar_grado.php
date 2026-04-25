<?php
// eliminar_grado.php
require_once("datos.php");

$respuesta = array();
$valido = true;

// Validar que se reciba el ID
if (isset($_POST['id_grado']) && !empty($_POST['id_grado'])) {
    $id_grado = $_POST['id_grado'];
} else {
    $valido = false;
    $respuesta['status'] = 2; // Código de error por falta de datos
    $respuesta['msg'] = "No se recibió el identificador del grado.";
}

if ($valido) {
    $obj_grados = new grados();
    
    // Intentar eliminar
    if ($obj_grados->eliminar_grado_id($id_grado)) {
        $respuesta['status'] = 1; // Éxito
        $respuesta['msg'] = "Grado eliminado correctamente.";
    } else {
        $respuesta['status'] = 0; // Error de BD
        $respuesta['msg'] = "Error al intentar borrar en la base de datos.";
    }
}

echo json_encode($respuesta);
?>