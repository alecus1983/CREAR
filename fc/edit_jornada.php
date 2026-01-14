<?php
session_start();
require_once("datos.php");

// Array de respuesta inicial
$respuesta = array('status' => 0, 'msg' => 'Error desconocido');

if (isset($_POST['id_jornada']) && isset($_POST['jornada'])) {
    
    // 1. Recibir datos y limpiar espacios
    $id = $_POST['id_jornada'];
    $nombre = trim($_POST['jornada']);
    
    // 2. Validaciones básicas en el servidor
    if (empty($nombre)) {
        $respuesta['msg'] = "El nombre de la jornada no puede estar vacío.";
        echo json_encode($respuesta);
        exit;
    }

    if (empty($id)) {
        $respuesta['msg'] = "No se identificó la jornada a editar.";
        echo json_encode($respuesta);
        exit;
    }

    // 3. Instanciar clase y actualizar
    $obj = new jornada();
    
    if ($obj->actualizar($id, $nombre)) {
        $respuesta['status'] = 1;
        $respuesta['msg'] = "Jornada actualizada correctamente.";
    } else {
        $respuesta['msg'] = "Error al actualizar en la base de datos.";
    }

} else {
    $respuesta['msg'] = "Faltan datos requeridos (ID o Nombre).";
}

echo json_encode($respuesta);
?>