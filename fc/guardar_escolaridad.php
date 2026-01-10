<?php
session_start();
// Incluimos la configuración y clases (asegúrate de que datos.php cargue escolaridad.php)
require_once("datos.php");

$respuesta = array();

// Verificamos que lleguen los datos
if (isset($_POST['id_escolaridad']) && isset($_POST['nombre_escolaridad'])) {
    
    $id = $_POST['id_escolaridad'];
    $nombre = trim($_POST['nombre_escolaridad']);

    // Validaciones básicas
    if ($nombre == "") {
        $respuesta['status'] = 2; 
        $respuesta['msg'] = "El nombre de la escolaridad no puede estar vacío.";
    } elseif ($id == "") {
        $respuesta['status'] = 2;
        $respuesta['msg'] = "No se ha identificado el registro a editar.";
    } else {
        // Instanciamos la clase
        $obj_escolaridad = new escolaridad();
        
        // Llamamos al método actualizar
        if ($obj_escolaridad->actualizar($id, $nombre)) {
            $respuesta['status'] = 1;
            $respuesta['msg'] = "Escolaridad actualizada correctamente.";
        } else {
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Error al actualizar en la base de datos.";
        }
    }

} else {
    $respuesta['status'] = 3;
    $respuesta['msg'] = "Faltan datos en la solicitud.";
}

// Devolvemos la respuesta en formato JSON
echo json_encode($respuesta);
?>