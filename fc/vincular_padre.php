<?php
/**
 * Script para vincular una persona como padre de un alumno.
 * Se utiliza en el flujo de edición de matrículas.
 */

// Requiere el archivo de datos que incluye las clases necesarias
require_once("datos.php");

// Obtener datos por POST
$id_persona = isset($_POST["id_persona"]) ? $_POST["id_persona"] : null;
$id_hijo = isset($_POST["id_hijo"]) ? $_POST["id_hijo"] : null;
$fecha = date("Y-m-d");

$respuesta = array();

if ($id_persona && $id_hijo) {
    // Instanciar la clase padres 
    // (Asegúrate de que 'padres' hereda de 'imcrea' y usa la DB correcta)
    $padres_obj = new padres();
    
    // Intentar vincular. $id_hijo DEBE ser el id_personas del estudiante.
    $res = $padres_obj->add($id_persona, $id_hijo, $fecha);
    
    if ($res) {
        $respuesta['status'] = 1;
        $respuesta['mensaje'] = "Vinculación exitosa";
        $respuesta['id_vinculo'] = $res;
    } else {
        $respuesta['status'] = 20;
        $respuesta['mensaje'] = "Error al insertar en la base de datos";
    }
} else {
    $respuesta['status'] = 21;
    $respuesta['mensaje'] = "Faltan parámetros obligatorios (id_persona: " . ($id_persona ? 'OK':'Falta') . ", id_hijo: " . ($id_hijo ? 'OK':'Falta') . ")";
}

// Retornar respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
?>
