<?php
// se incluye la clase grados y la conexion
require_once("datos.php"); 

$respuesta = array();
$valido = true;

// Validar que lleguen los datos necesarios
if (!isset($_POST['id_grado']) || empty($_POST['id_grado'])) {
    $valido = false;
    $respuesta['status'] = 20; // Error de ID
}
if (!isset($_POST['codigo']) || empty($_POST['codigo'])) {
    $valido = false;
    $respuesta['status'] = 21; // Error de código
}

if ($valido) {
    $obj_grados = new grados();
    
    // Ejecutar la actualización
    // $_POST['codigo'] corresponde al campo 'grado' en la BD
    // $_POST['nombre'] corresponde al campo 'nombre_g' en la BD
    $resultado = $obj_grados->actualizar_grado(
        $_POST['id_grado'], 
        $_POST['codigo'], 
        $_POST['nombre'],
        $_POST['promovido'],
        $_POST['formato_boletin']
    );

    if ($resultado) {
        $respuesta['status'] = 1; // Éxito
        $respuesta['msg'] = "Grado actualizado correctamente";
    } else {
        $respuesta['status'] = 22; // Error en la consulta SQL
    }
} else {
    if(!isset($respuesta['status'])) $respuesta['status'] = 0;
}

echo json_encode($respuesta);
?>