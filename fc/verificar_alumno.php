<?php
// requiere definicion de clases
require_once('datos.php');

// se  recupera el nombre por el método POST
$id_persona = $_POST["id_persona"];
// variable que almacena el codigo del alumno 
$id_alumno = 0;

// selecciona una nueva persona 
$persona = new personas();
// obtener los datos de la persona
$persona->get_persona_por_id($id_persona);
// nuevo objeto alumnos
$alumno = new u_alumnos();

// obtiene los datos del alumno 
$datos_a = $alumno->get_alumno_persona($id_persona);
// si el aluno esta registrado 
if (isset($datos_a)){

    // en caso de  una persona que es un alumno
    // retorna el codigo de alumno
    // codigo del alumno
    $id_alumno = $datos_a["id_alumnos"];
    
} else {
    // si no tiene codigo de alumno se le
    // asigna  un codigo de alumno
    //echo "no se registran datos ";
    $id_alumno = $alumno->add_alumno($id_persona);
}
// ajusto el formato
echo json_encode($id_alumno);
?>
