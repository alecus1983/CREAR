<?php
// requiere definicion de clases
require_once('datos.php');
// variables de alumno
$id_alumno = $_POST['id_alumno'];
$id_grado = $_POST['id_grado'];
$id_curso = $_POST['id_curso'];
$id_jornada = $_POST["id_jornada"];
// cambiar  para ser ingresado en la interfaz
$mes = date("m");
$year = date("Y");

// creo objeto matricula
$mt = new matricula();

// asigno atributos
$mt->id_alumno = $id_alumno;
$mt->id_grado = $id_grado;
$mt->id_jornada = $id_jornada;
$mt->mes =$mes;
$mt->retiro = 11;
$mt->id_curso =$id_curso;
$mt->year =$year;

// ejecuto la matricula
if ($mt->set_matricula()) {
    // si se ejecuta la matricula
    echo "1";
} else {
    // si no se ejecuta la matricula
    echo 0;
}

?>
