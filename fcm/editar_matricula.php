<?php
/**
 * @file editar_matricula.php
 * @brief Manejador para actualizar una matrícula existente mediante AJAX.
 */

require_once('datos.php');

// Validar que se reciban los datos necesarios por POST
if (isset($_POST['id_matricula']) && isset($_POST['id_alumno'])) {

    $id_matricula = $_POST['id_matricula'];
    $id_alumno = $_POST['id_alumno'];
    $id_grado = $_POST['id_grado'];
    $id_curso = $_POST['id_curso'];
    $id_jornada = $_POST["id_jornada"];

    // El año y mes pueden venir por POST o tomarse del sistema
    $year = isset($_POST['year']) ? $_POST['year'] : date("Y");
    $mes = date("m");

    // Instanciar la clase matricula
    $mt = new matricula();

    // Asignar los atributos para la actualización
    $mt->id = $id_matricula;
    $mt->id_alumno = $id_alumno;
    $mt->id_grado = $id_grado;
    $mt->id_jornada = $id_jornada;
    $mt->id_curso = $id_curso;
    $mt->year = $year;
    $mt->mes = $mes;
    $mt->retiro = 11; // Valor por defecto según matricular_alumno.php

    // Ejecutar la actualización
    if ($mt->update_matricula()) {
        // Retornar 1 para indicar éxito (consistente con matricular_alumno.php)
        echo json_encode(['status' => 1, 'message' => 'Matrícula actualizada con éxito']);
    }
    else {
        // Retornar 0 o error
        echo json_encode(['status' => 0, 'message' => 'Error al actualizar la matrícula']);
    }
}
else {
    echo json_encode(['status' => 0, 'message' => 'Datos insuficientes']);
}
?>