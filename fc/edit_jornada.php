<?php
session_start();
require_once("datos.php"); // Asegúrate de que este archivo incluya la clase jornada

$respuesta = array();

if (isset($_POST['id_jornada']) && isset($_POST['nombre_jornada'])) {
    
    $id = $_POST['id_jornada'];
    $nombre = $_POST['nombre_jornada'];

    // Validamos que no estén vacíos
    if (trim($nombre) == "" || trim($id) == "") {
        $respuesta['status'] = 2; // Error de validación
        $respuesta['msg'] = "Los campos no pueden estar vacíos";
    } else {
        $jornada = new jornada();
        
        if ($jornada->actualizar($id, $nombre)) {
            $respuesta['status'] = 1; // Éxito
            $respuesta['msg'] = "Jornada actualizada correctamente";
        } else {
            $respuesta['status'] = 0; // Error en BD
            $respuesta['msg'] = "Error al actualizar en la base de datos";
        }
    }

} else {
    $respuesta['status'] = 3; // Faltan datos
    $respuesta['msg'] = "Faltan datos por enviar";
}

echo json_encode($respuesta);
?>