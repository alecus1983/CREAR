<?php
session_start();
require_once("datos.php");

// Array de respuesta por defecto
$respuesta = array('status' => 0, 'msg' => 'Error desconocido');

if (isset($_POST['jornada'])) {
    
    // Instancia de la clase
    $obj = new jornada();
    
    // Recibir variables
    $nombre = trim($_POST['jornada']);
    $id = isset($_POST['id_jornada']) ? $_POST['id_jornada'] : "";

    if ($id == "" || $id == 0) {
        // --- INSERTAR (Nuevo) ---
        $res = $obj->agregar($nombre);
        if ($res) {
            $respuesta['status'] = 1;
            $respuesta['msg'] = "Jornada creada correctamente.";
        } else {
            $respuesta['msg'] = "Error al insertar en la base de datos.";
        }
    } else {
        // --- ACTUALIZAR (Editar) ---
        $res = $obj->actualizar($id, $nombre);
        if ($res) {
            $respuesta['status'] = 1;
            $respuesta['msg'] = "Jornada actualizada correctamente.";
        } else {
            $respuesta['msg'] = "Error al actualizar la base de datos.";
        }
    }
} else {
    $respuesta['msg'] = "No llegaron datos POST validos.";
}

echo json_encode($respuesta);
?>