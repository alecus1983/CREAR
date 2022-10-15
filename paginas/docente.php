<?php
	//echo "Cargando ...";
	//conexion con la base de datos
	require_once 'conexion.php';
	$link = 	conectar();


	// se  recupera el nombre por el método POST
	$nombre = $_POST["nombres"];


	$data = array();


	// se crea el texto de la consulta
	$q1 = "SELECT * FROM docentes WHERE id_docente =".$nombre;

	// se realiza la  consulta en la base de datos
	$q1x = mysqli_query($link, $q1 );// or die('no se encuentra el nombre: ' . mysqli_error());;

	//recupero el arreglo generado en el resultado
	$dato1 = mysqli_fetch_array($q1x);
	// recupero el nombre

	// estos valores son los valores a entrar por el método JSON
	// aqui recupero el nombre del alumno
	$data['nombres'] = $dato1["nombres"];
	// aqui se recupera el apellido
	$data['apellidos'] = $dato1["apellidos"];
	// aqui se recupera la fecha de nacimiento
	$data['fecha'] = $dato1["fecha"];
	// aqui se recupera el telefono de la casa
	$data['telefono'] = $dato1["celular"];
	// aqui se recupra el correo del estudiante
	$data['correo'] = $dato1["correo"];
	// aqui se recupera el documento de identidad
	$data['cedula'] = $dato1["cedula"];
	$data['areas'] = utf8_encode($dato1["materias"]);
	echo json_encode($data);

        desconectar($link);
   exit ();



?>
