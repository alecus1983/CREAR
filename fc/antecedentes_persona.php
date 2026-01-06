<?php
// Archivo para realizar la gestión de personas
// Permite la búsqueda de personas, agregar personas y asignar correos

// Archivo de datos
require_once("datos.php");

// Inicializar variables de respuesta
$respuesta = array();

// Verificar que el ID esté presente en la solicitud POST
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $id = $_POST["id"];
    
    // Validación básica del ID (asegúrate de que sea un número válido si corresponde)
    if (!is_numeric($id)) {
        $respuesta['status'] = 20;
        $respuesta['mensaje'] = "ID inválido. Debe ser un número.";
    } else {
        // Variables de validación
        $valido = true;
        
        // Crear una nueva persona
        $persona = new personas();
        
        // Si los datos son válidos
        if ($valido) {
            try {
                // Obtengo los datos de la persona
                $respuesta = $persona->get_antecedentes($id);
                
                // Verificar si la respuesta contiene los datos esperados
                if ($respuesta) {
                    $respuesta['status'] = 1; // Operación exitosa
                } else {
                    $respuesta['status'] = 21;
                    $respuesta['mensaje'] = "No se encontró la persona con el ID proporcionado.";
                }
            } catch (Exception $e) {
                // En caso de error en la obtención de datos
                $respuesta['status'] = 500;
                $respuesta['mensaje'] = "Error interno en el servidor: " . $e->getMessage();
            }
        } else {
            // Si no es válido
            $respuesta['status'] = 20;
            $respuesta['mensaje'] = "Error en la validación de los datos.";
        }
    }
} else {
    // Si no se ha enviado el ID
    $respuesta['status'] = 20;
    $respuesta['mensaje'] = "ID no proporcionado.";
}

// Convertir la respuesta a formato JSON y devolverla
echo json_encode($respuesta);

?>