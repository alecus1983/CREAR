<?php
	session_start();

	//conexion con la base de datos
require_once 'conexion.php';
$link = conectar();
//var_dump($_SESSION);

	// se  recupera el nombre por el método POST

	//printf("Conjunto de caracteres inicial: %s\n", $link->character_set_name());

	/* cambiar el conjunto de caracteres a utf8 */
	if (!$link->set_charset("utf8")) {
	    printf("Error cargando el conjunto de caracteres utf8: %s\n", $link->error);
	    exit();
	} else {
		    //printf("Conjunto de caracteres actual: %s\n", $link->character_set_name());
	}

$admin = $_SESSION['admin'];
$id = $_SESSION['code'];
$year = date('Y');

	$data = array();

	if ($admin) {
		// se crea el texto de la consulta
		$q1 = "SELECT * FROM grados ORDER BY grado";
		//echo "conulta ".$q1;
	}
    else {
		$q1 = "SELECT DISTINCT G.id_grado, G.grado FROM grados G INNER JOIN matricula_docente D ON G.id_grado = D.id_grado  WHERE D.year = '"
            .$year."' AND  D.id_docente = ".$id;
						//echo "conulta docentes ".$q1;
    }


// se realiza la  consulta en la base de datos
$q1x = mysqli_query( $link, $q1) or die('no se encuentra el grado: ' . mysqli_error());;


	//recupero el arreglo generado en el resultado
	while($dato1 = mysqli_fetch_array($q1x))
	{
	// recupero el nombre
	$id = $dato1["id_grado"];
	$grado = $dato1["grado"];
	//echo "<br><br>Id = $id , grado $grado";

	// estos valores son los valores a entrar por el método JSON
	// aqui recupero el nombre del alumno
	$data[$id] = $grado;
}

	//var_dump($data);
	echo json_encode($data);

	//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
	desconectar($link);
   exit ();



?>
