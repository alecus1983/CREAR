<?php

require_once 'conexion.php';
$link = conectar();
//var_dump($_SESSION);

// se  recupera el nombre por el método POST

/* cambiar el conjunto de caracteres a utf8 */
if (!$link->set_charset("utf8")) {
	printf("Error cargando el conjunto de caracteres utf8: %s\n", $link->error);
	exit();
} else {
	//printf("Conjunto de caracteres actual: %s\n", $link->character_set_name());
}

$escolaridad = $_POST["escolaridad"];

if ($escolaridad !== ""){

	$q1 = "select * from grados where id_escolaridad = $escolaridad";

	// se realiza la  consulta en la base de datos
	$q1x = mysqli_query( $link, $q1) or die('no se encuentra el grado: '. mysqli_error());;

	// array vacio
	$data = array();
	//recupero el arreglo generado en el resultado
	while($dato1 = mysqli_fetch_array($q1x))
	{
		// recupero el nombre
		$id = $dato1["id_grado"];
		$grado = $dato1["nombre_g"];
		// estos valores son los valores a entrar por el método JSON
		// aqui recupero el nombre del alumno
		$data[$id] = $grado;
	}

	//var_dump($data);
	echo json_encode($data);
}
//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
desconectar($link);
// exit ();



?>
