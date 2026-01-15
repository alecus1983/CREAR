<?php
/**
 * Archivo para procesar la eliminación de una materia vía AJAX
 */
require_once("materias.php"); 

// Se inicializa el objeto de la clase materia
$obj_materia = new materia();

// Se captura el ID enviado por el método POST desde el archivo JS
$id_materia = isset($_POST['id_materia']) ? $_POST['id_materia'] : null;

$respuesta = array();

// Validación: Verificamos que se haya recibido un ID válido
if (empty($id_materia)) {
    $respuesta['status'] = 0;
    $respuesta['msg'] = "No se proporcionó un ID de materia válido.";
} else {
    // Se invoca el método eliminar_materia definido en la clase materia
    // Este método ejecuta la sentencia: DELETE FROM materia WHERE id_materia = $id
    $ejecucion = $obj_materia->eliminar_materia($id_materia);

    if ($ejecucion) {
        // Status 1 indica éxito para que el JS dispare el swal de confirmación
        $respuesta['status'] = 1;
        $respuesta['msg'] = "La materia ha sido eliminada exitosamente.";
    } else {
        // Status 20 suele representar un error de ejecución en la base de datos según tu código
        $respuesta['status'] = 20;
        $respuesta['msg'] = "Error: No se pudo eliminar la materia. Es posible que tenga registros asociados.";
    }
}

// Retornamos la respuesta codificada en JSON para el frontend
echo json_encode($respuesta);
?>
