<?php
session_start();
require_once("datos.php"); // Asegúrate de que esto cargue la clase grados

$respuesta = array();

// Validamos que lleguen los datos mínimos necesarios
if (isset($_POST['grado']) && isset($_POST['nombre_g']) && isset($_POST['id_escolaridad'])) {
    
    $grado_codigo = $_POST['grado'];
    $nombre_g = $_POST['nombre_g'];
    $promovido = isset($_POST['promovido']) ? $_POST['promovido'] : "No asignado";
    $id_escolaridad = $_POST['id_escolaridad'];
    $escolaridad_nombre = $_POST['escolaridad']; // Nombre de la escolaridad (ej: Primaria)
    
    // Valor por defecto para formato_boletin si no se envía (ej: 1)
    $formato_boletin = isset($_POST['formato_boletin']) ? $_POST['formato_boletin'] : 1; 

    // Validaciones básicas
    if (trim($grado_codigo) == "" || trim($nombre_g) == "") {
        $respuesta['status'] = 2;
        $respuesta['msg'] = "El código y el nombre del grado son obligatorios.";
    } else {
        $obj_grado = new grados();
        
        // Llamamos al método registro actualizado
        if ($obj_grado->registro($grado_codigo, $nombre_g, $escolaridad_nombre, $promovido, $id_escolaridad, $formato_boletin)) {
            $respuesta['status'] = 1;
            $respuesta['msg'] = "Grado agregado correctamente.";
        } else {
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Error al insertar en la base de datos.";
        }
    }

} else {
    $respuesta['status'] = 3;
    $respuesta['msg'] = "Faltan datos obligatorios.";
}

echo json_encode($respuesta);
?>