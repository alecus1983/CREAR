<?php
// Archivo para obtener datos de persona a partir de id_alumno
require_once("datos.php");

// obtencion de id_alumno de la peticion POST
$id_alumno = isset($_POST["id_alumno"]) ? $_POST["id_alumno"] : null;
$respuesta = array();

if ($id_alumno && is_numeric($id_alumno)) {
    // creo nueva instancia de personas
    $persona = new personas();
    // obtengo los datos de la persona por id_alumno usando el metodo creado
    $datos = $persona->get_persona_por_id_alumno($id_alumno);

    if ($datos) {
        $respuesta = $datos;
        $respuesta['status'] = 1;
    } else {
        $respuesta['status'] = 20; // No se encontro la persona o el alumno
    }
} else {
    $respuesta['status'] = 21; // ID de alumno no valido o ausente
}

// Retorno la respuesta en formato JSON
echo json_encode($respuesta);
?>
