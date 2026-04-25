<?php
// agregar_escolaridad.php
require_once("datos.php");

$respuesta = array();

// Validamos que llegue el dato
if (isset($_POST['nombre_escolaridad']) && trim($_POST['nombre_escolaridad']) !== "") {
    
    $nombre = trim($_POST['nombre_escolaridad']);
    
    $obj_escolaridad = new escolaridad();
    
    // Intentamos crear el registro
    if ($obj_escolaridad->crear($nombre)) {
        $respuesta['status'] = 1;
        $respuesta['msg'] = "Escolaridad agregada exitosamente.";
    } else {
        $respuesta['status'] = 0;
        $respuesta['msg'] = "Error al intentar guardar en la base de datos.";
    }
    
} else {
    $respuesta['status'] = 2;
    $respuesta['msg'] = "Por favor ingrese un nombre para la escolaridad.";
}

echo json_encode($respuesta);
?>