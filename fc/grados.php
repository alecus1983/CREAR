<?php
// inicio de seccion
session_start();
// requiere definicion de clases
require_once('datos.php');
// codigo del docente
$id = 67;

// creo un nuevo objeto  matricula docente
$mt = new matricula_docente();
// asigno el año a la matricula como el a actual
$mt->year = date('Y')-1;
// defino el codigo del docente de la matricula
$mt->id_docente = $id;
//actuliza el listado de cursos disponibles
$mt->get_matricula();
// conviere el dato en un json
//echo json_encode($mt->listado);
$lista = $mt->listado;

foreach ($lista as $key => $value) {
	echo '<option value="'.$key.'">'.$value.'</option>';
}

//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
// desconectar($link);
exit ();


?>
