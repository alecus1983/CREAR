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
	$year = '2022';//$_POST['year'];
	// creo un nuevo docente
	$doc = new docentes();
	// recupero sus datos  si existe
	$doc->get_docente_id($id);
	// 
	$doc->get_materias_por_grado($grado,$year);

	echo json_encode($doc->materias);



?>
