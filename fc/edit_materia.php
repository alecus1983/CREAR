<?php
// Se incluyen las clases necesarias (asegúrate de que las rutas sean correctas)
require_once("materias.php"); 

// Se inicializa el objeto materia
$obj_materia = new materia();

// Se capturan los datos enviados por AJAX
$id_materia      = isset($_POST['id_materia']) ? $_POST['id_materia'] : null;
$nombre_materia  = isset($_POST['materia']) ? $_POST['materia'] : '';
$id_area         = isset($_POST['id_area']) ? $_POST['id_area'] : 0;
$ih              = isset($_POST['ih']) ? $_POST['ih'] : 0;

$respuesta = array();

// Validación básica de datos
if (empty($id_materia) || empty($nombre_materia)) {
    $respuesta['status'] = 0;
    $respuesta['msg'] = "Faltan datos obligatorios para la actualización.";
} else {
    // Se invoca el método de la clase para actualizar
    $ejecucion = $obj_materia->actualizar_materia($id_materia, $nombre_materia, $id_area, $ih);

    if ($ejecucion) {
        $respuesta['status'] = 1;
        $respuesta['msg'] = "Materia actualizada correctamente.";
    } else {
        $respuesta['status'] = 20; // Siguiendo el patrón de errores de grados.js
        $respuesta['msg'] = "Fallo al intentar actualizar la materia en la base de datos.";
    }
}

// Se retorna la respuesta al método AJAX en formato JSON
echo json_encode($respuesta);
?>
