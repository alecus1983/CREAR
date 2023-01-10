<?php
	require_once 'conexion.php';
	//conexion con la base de datos
	
	$link = conectar();	
	

	// se  recupera el nombre por el método POST
	
	//$year = $_GET["year"];


	$data = array();
	
	
	// se crea el texto de la consulta
	$q1 = "SELECT *  FROM docentes 
			";
	//echo $q1;
	// se realiza la  consulta en la base de datos
	$q1x = mysql_query($q1, $link) or die('no se encuentran docentes: ' . mysql_error());; 
	
	
	//recupero el arreglo generado en el resultado	
	while($dato1 = mysql_fetch_array($q1x))
	{
	// recupero el nombre	
	$id = $dato1["id"];
	$nombres = utf8_encode($dato1["nombres"]);
	$apellidos = utf8_encode($dato1["apellidos"]);
	//echo $id."  ".$nombres." ".$apellidos."\n";														
	// estos valores son los valores a entrar por el método JSON
	// aqui recupero el nombre del alumno
	$data[$id] = $nombres."  ".$apellidos;
	}
	
	echo json_encode($data);
	//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
	desconectar();
   
   exit ();
   
   

?>