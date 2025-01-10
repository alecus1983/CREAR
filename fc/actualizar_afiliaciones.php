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
    $persona->sisben = isset($_POST["sisben"]) ? $_POST["sisben"] : ''; // Verifica si "sisben" fue enviado
    $persona->vive_con = isset($_POST["vive_con"]) ? $_POST["vive_con"] : ''; // Verifica si "vive_con" fue enviado
    $persona->etnia = isset($_POST["etnia"]) ? $_POST["etnia"] : ''; // Verifica si "etnia" fue enviado
    $persona->tipo_etnia = isset($_POST["tipo_etnia"]) ? $_POST["tipo_etnia"] : ''; // Verifica si "tipo_etnia" fue enviado
    $persona->resguardo_consejo = isset($_POST["resguardo_consejo"]) ? $_POST["resguardo_consejo"] : ''; // Verifica si "resguardo_consejo" fue enviado
    $persona->familias_accion = isset($_POST["familias_accion"]) ? $_POST["familias_accion"] : ''; // Verifica si "familias_accion" fue enviado
    $persona->tipo_victima_conflicto = isset($_POST["tipo_victima_conflicto"]) ? $_POST["tipo_victima_conflicto"] : ''; // Verifica si "tipo_victima_conflicto" fue enviado
    $persona->municipio_expulsor = isset($_POST["municipio_expulsor"]) ? $_POST["municipio_expulsor"] : ''; // Verifica si "municipio_expulsor" fue enviado (corrige el nombre del campo de "municipio_expulsonr")
    $persona->discapacitado = isset($_POST["discapacitado"]) ? $_POST["discapacitado"] : ''; // Verifica si "discapacitado" fue enviado
    $persona->tipo_discapacidad = isset($_POST["tipo_discapacidad"]) ? $_POST["tipo_discapacidad"] : ''; // Verifica si "tipo_discapacidad" fue enviado
    $persona->capacidad_excepcional = isset($_POST["capacidad_excepcional"]) ? $_POST["capacidad_excepcional"] : ''; // Verifica si "capacidad_excepcional" fue enviado
    $persona->regimen_salud = isset($_POST["regimen_salud"]) ? $_POST["regimen_salud"] : ''; // Verifica si "regimen_salud" fue enviado
    $persona->eps = isset($_POST["eps"]) ? $_POST["eps"] : ''; // Verifica si "eps" fue enviado
    $persona->ips = isset($_POST["ips"]) ? $_POST["ips"] : ''; // Verifica si "ips" fue enviado
    $persona->tipo_sangre = isset($_POST["tipo_sangre"]) ? $_POST["tipo_sangre"] : ''; // Verifica si "tipo_sangre" fue enviado
    $persona->rh = isset($_POST["rh"]) ? $_POST["rh"] : ''; // Verifica si "tipo_sangre" fue enviado

    // Intentar actualizar los datos de la persona en la base de datos
    // El método "actualizar_afiliacion()" se llama para actualizar los datos de la persona.
    if ($persona->actualizar_afiliacion()) {
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