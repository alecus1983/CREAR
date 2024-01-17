<?php
	session_start();

	//conexion con la base de datos
	require_once 'conexion.php';
	$link = conectar();

	//printf("Conjunto de caracteres inicial: %s\n", $link->character_set_name());

	/* cambiar el conjunto de caracteres a utf8 */
	if (!$link->set_charset("utf8")) {
	    printf("Error cargando el conjunto de caracteres utf8: %s\n", $link->error);
	    exit();
	} else {
		    //printf("Conjunto de caracteres actual: %s\n", $link->character_set_name());
	}


	// se  recupera el nombre por el método POST
	$grado = $_POST["grados"];


	// se  recupera el nombre por el método POST

	$admin = $_SESSION['admin'];
	// se recibe el codigo
	$id = $_POST['id'];
	// el año
	$year = $_POST['year'];

	// array para almacenar el resultado final
	$data = array();

	//echo "admin :".$admin." -".$year;
	if ($admin == 1) {
		// se crea el texto de la consulta
		$q1 = "SELECT M.id_materia, M.materia  FROM requisitos R INNER JOIN materia M ON M.id_materia = R.id_materia
		WHERE R.id_grado = ".$grado;

	}
	else {
		$q1 = "SELECT DISTINCT M.id_materia, M.materia FROM materia M INNER JOIN matricula_docente D ON M.id_materia = D.id_materia  WHERE D.year = '".$year."'
		AND  D.id_docente = ".$id." AND D.id_grado =".$grado;

	}

	//echo "consulta :".$q1;



	// se realiza la  consulta en la base de datos
	$q1x = mysqli_query($link, $q1 ) or die('no se encuentra el nombre: ' . mysql_error());;


	//recupero el arreglo generado en el resultado
	while($dato1 = mysqli_fetch_array($q1x))
	{
		// recupero el nombre
		$id = $dato1["id_materia"];
		$materia = $dato1["materia"];
		// estos valores son los valores a entrar por el método JSON
		// aqui recupero el nombre del alumno
		$data[$id] = $materia;
	}

	echo json_encode($data);

	//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
	desconectar($link);



   exit ();



?>
