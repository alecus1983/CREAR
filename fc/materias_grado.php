<?php
// inicio de seccion
//session_start();
// requiere definicion de clases
require_once('datos.php');
// codigo del docente

// se  recupera el nombre por el método POST
$grado = $_POST["grados"];
$id = $_POST['id'];
// el año
$year = $_POST['year'];
// creo un nuevo docente
$doc = new docentes();
// recupero sus datos  si existe
$doc->get_docente_id($id);
// obtego las materias desarrolladas en un grado
$doc->get_materias_por_grado($grado,$year);
// lo codifico  en formato json
echo json_encode($doc->materias);
?>
