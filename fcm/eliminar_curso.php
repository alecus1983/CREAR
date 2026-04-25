<?php
require_once("datos.php");

if (isset($_POST['id_curso'])) {
    
    $id = $_POST['id_curso'];
    $obj = new curso();

    // 1. Validamos si hay alumnos inscritos en este curso
    if ($obj->tiene_matriculas($id)) {
        echo json_encode(array(
            "status" => 0, 
            "msj" => "Acción denegada: El curso tiene alumnos matriculados asociados. Debe trasladar o retirar a los alumnos antes de eliminar el curso."
        ));
        exit; // Detenemos el proceso aquí
    }

    // 2. Si no tiene alumnos, procedemos a eliminar
    if ($obj->eliminar_curso($id)) {
        echo json_encode(array(
            "status" => 1, 
            "msj" => "Curso eliminado correctamente."
        ));
    } else {
        echo json_encode(array(
            "status" => 0, 
            "msj" => "Error interno al intentar eliminar el curso."
        ));
    }
} else {
    echo json_encode(array("status" => 0, "msj" => "ID de curso no válido."));
}
?>
