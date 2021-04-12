<?php

	//conexion con la base de datos

	require_once 'conexion.php';
	$link = conectar();


	// se  recupera el nombre por el método POST

	//$year = $_GET["year"];


	$data = array();


	// se crea el texto de la consulta
	$q1 = "SELECT *  FROM docentes ORDER BY apellidos";
	//echo $q1;
	// se realiza la  consulta en la base de datos
	$q1x = $link->query($q1);//mysqli_query($link, $q1 ) or die('no se encuentran docentes: ' . mysqli_error($link));;


	//recupero el arreglo generado en el resultado
	while($dato1 = $q1x->fetch_array(MYSQLI_ASSOC))
	{
	// recupero el nombre
	$id = $dato1["id_docente"];
	$nombres = utf8_encode($dato1["nombres"]);
	$apellidos = utf8_encode($dato1["apellidos"]);
	//echo $id."  ".$nombres." ".$apellidos."\n";
	// estos valores son los valores a entrar por el método JSON
	// aqui recupero el nombre del alumno
	$data[$id] = $nombres."  ".$apellidos;
	}

	echo json_encode($data);
	desconectar($link);

   exit ();



?>
