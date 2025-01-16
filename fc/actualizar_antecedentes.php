<?php
// Requiere el archivo de datos donde probablemente se define la clase "personas"
require_once("datos.php");

// Inicialización de variables de validación y respuesta
$valido = true;
$respuesta = array();

// Verificar si se ha recibido un "id_persona" en el formulario y si no está vacío
if (isset($_POST["id_persona"]) && !empty($_POST["id_persona"])) {
    // Asigna el valor de "id_persona" desde el formulario
    $id_persona = $_POST["id_persona"];
} else {
    // Si no se ha recibido un "id_persona", se marca como no válido
    $valido = false;
    $respuesta['status'] = 32; // Código de error: "ID de persona no recibido"
}

// Si los datos recibidos son válidos
if ($valido) {
    // Crear una nueva instancia de la clase "personas"
    $persona = new personas();
    
    // Asignar los valores recibidos del formulario a las propiedades del objeto "persona"
    // Cada campo es verificado con "isset" para garantizar que existe en el POST.
    // En caso de no existir, se asigna un valor vacío.
    $persona->id_persona = $id_persona;
    $persona->antecedentes_patologicos_medicos = isset($_POST["antecedentes_patologicos_medicos"]) ? $_POST["antecedentes_patologicos_medicos"] : ''; // Verifica si "antecedentes_medicos" fue enviado
    $persona->antecedentes_patologicos_quirurgicos = isset($_POST["antecedentes_patologicos_quirurgicos"]) ? $_POST["antecedentes_patologicos_quirurgicos"] : ''; // Verifica si "sisben" fue enviado
    $persona->antecedentes_patologicos_toxicos = isset($_POST["antecedentes_patologicos_toxicos"]) ? $_POST["antecedentes_patologicos_toxicos"] : ''; // Verifica si "vive_con" fue enviado
    $persona->antecedentes_patologicos_psiquiatricos = isset($_POST["antecedentes_patologicos_psiquiatricos"]) ? $_POST["antecedentes_patologicos_psiquiatricos"] : ''; // Verifica si "etnia" fue enviado
    $persona->antecedentes_patologicos_psicologicos = isset($_POST["antecedentes_patologicos_psicologicos"]) ? $_POST["antecedentes_patologicos_psicologicos"] : ''; // Verifica si "tipo_etnia" fue enviado
    $persona->antecedentes_patologicos_morbilidad = isset($_POST["antecedentes_patologicos_morbilidad"]) ? $_POST["antecedentes_patologicos_morbilidad"] : ''; // Verifica si "resguardo_consejo" fue enviado
    

    // Intentar actualizar los datos de la persona en la base de datos
    // El método "actualizar_afiliacion()" se llama para actualizar los datos de la persona.
    if ($persona->actualizar_antecedentes()) {
        // Si la actualización es exitosa, se establece el status como 1
        $respuesta['status'] = 1; // Éxito
    } else {
        // Si la actualización falla, se devuelve un error
        $respuesta['status'] = 0; // Falla
        $respuesta['error'] = 'Failed to update person\'s data'; // Mensaje de error
    }
}

// Codifica la respuesta en formato JSON para enviarla al cliente
echo json_encode($respuesta);

?>