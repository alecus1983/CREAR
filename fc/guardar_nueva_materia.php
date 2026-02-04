<?php
/**
 * Archivo para procesar la creación de una nueva materia vía AJAX
 */
require_once("materias.php"); 

// Se inicializa el objeto de la clase materia
$obj_materia = new materia();

// Se capturan los datos enviados por POST
// 'materia', 'id_area' e 'ih' son las llaves definidas en el objeto data de AJAX
$nombre_materia = isset($_POST['materia']) ? $_POST['materia'] : '';
$id_area        = isset($_POST['id_area']) ? $_POST['id_area'] : 0;
$ih             = isset($_POST['ih']) ? $_POST['ih'] : 0;

$respuesta = array();

// Validación básica: El nombre de la materia no puede estar vacío
if (empty($nombre_materia)) {
    $respuesta['status'] = 0;
    $respuesta['msg'] = "El nombre de la materia es obligatorio.";
} else {
    // Se invoca el método insertar_materia definido anteriormente en la clase materia
    $ejecucion = $obj_materia->insertar_materia($nombre_materia, $id_area, $ih);

    if ($ejecucion) {
        // Status 1 indica éxito para que SweetAlert muestre el mensaje positivo
        $respuesta['status'] = 1;
        $respuesta['msg'] = "La materia ha sido creada con éxito.";
    } else {
        // Siguiendo la lógica de errores del archivo grados.js proporcionado
        $respuesta['status'] = 20; 
        $respuesta['msg'] = "Error de base de datos al intentar guardar la materia.";
    }
}

// Retornamos el resultado en formato JSON para el frontend
echo json_encode($respuesta);
?>
