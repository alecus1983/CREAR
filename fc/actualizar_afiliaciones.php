<?php
//
// Actualiza las afiliaciones de una persona a la seguridad social
//
// Parámetros de entrada:
// id_persona: ID de la persona cuya afiliación se actualiza
// sisben: indica si tiene sisben
// vivie_con: indica si vive con ambos padres o uno de los dos


// Requiere el archivo de datos que incluye la definición de la clase "personas"
require_once("datos.php");

// Inicialización de variables de validación y respuesta de la API
$valido = true;
$respuesta = array();

// Validar la recepción de "id_persona" desde el formulario
if (isset($_POST["id_persona"]) && !empty($_POST["id_persona"])) {
    $id_persona = $_POST["id_persona"]; // Asigna ID de persona
} else {
    $valido = false; // Marca como no válido si falta el ID
    $respuesta['status'] = 32; // Error: "ID de persona no recibido"
}

// Procesar la actualización si los datos son válidos
if ($valido) {
    $persona = new personas(); // Crear instancia de la clase "personas"
    
    // Asignar valores del formulario a las propiedades del objeto
    // Se utilizan valores vacíos por defecto si el campo no está presente
    $persona->id_persona = $id_persona;
    $persona->sisben = $_POST["sisben"] ?? ''; // Afiliación al SISBEN
    $persona->vive_con = $_POST["vive_con"] ?? ''; // Situación de convivencia
    $persona->etnia = $_POST["etnia"] ?? ''; // Etnia de la persona
    $persona->tipo_etnia = $_POST["tipo_etnia"] ?? ''; // Tipo de etnia
    $persona->resguardo_consejo = $_POST["resguardo_consejo"] ?? ''; // Resguardo por consejo
    $persona->familias_accion = $_POST["familias_accion"] ?? ''; // Programas de familias en acción
    $persona->tipo_victima_conflicto = $_POST["tipo_victima_conflicto"] ?? ''; // Tipo de víctima del conflicto
    $persona->municipio_expulsor = $_POST["municipio_expulsor"] ?? ''; // Municipio de expulsión
    $persona->discapacitado = $_POST["discapacitado"] ?? ''; // Indica si es discapacitado
    $persona->tipo_discapacidad = $_POST["tipo_discapacidad"] ?? ''; // Tipo de discapacidad
    $persona->capacidad_excepcional = $_POST["capacidad_excepcional"] ?? ''; // Indica capacidad excepcional
    $persona->regimen_salud = $_POST["regimen_salud"] ?? ''; // Régimen de salud al que pertenece
    $persona->eps = $_POST["eps"] ?? ''; // Entidad Promotora de Salud
    $persona->ips = $_POST["ips"] ?? ''; // Institución Prestadora de Salud
    $persona->tipo_sangre = $_POST["tipo_sangre"] ?? ''; // Tipo de sangre
    $persona->rh = $_POST["rh"] ?? ''; // Factor RH

    // Actualizar los datos de la persona en la base de datos
    if ($persona->actualizar_afiliacion()) {
        $respuesta['status'] = 1; // Éxito en la actualización
    } else {
        $respuesta['status'] = 0; // Error en la actualización
        $respuesta['error'] = 'Failed to update person\'s data'; // Mensaje de error
    }
}

// Devolver la respuesta en formato JSON
echo json_encode($respuesta);

?>
