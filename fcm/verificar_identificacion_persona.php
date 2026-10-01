<?php
// verificar_identificacion_persona.php
// Verifica si ya existe una persona con la misma identificación en la tabla personas.
// Retorna un JSON con status (1 = ya existe, 0 = no existe).

require_once("datos.php");

$respuesta = array();

$identificacion = isset($_POST['identificacion']) ? trim($_POST['identificacion']) : '';

if ($identificacion === '') {
    $respuesta['status'] = 0;
    echo json_encode($respuesta);
    exit;
}

$p = new personas();

$respuesta['status'] = $p->existe_identificacion($identificacion) ? 1 : 0;

echo json_encode($respuesta);
