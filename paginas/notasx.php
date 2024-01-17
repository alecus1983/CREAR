<?php
	require_once 'conexion.php';
	$link = conectar();



	// Pagina transitoria para generar los resultados a actualizar
	// RECUPERO DATOS DE EL FORMULARIO
	// DE ACTUACCION


	// Parametros de entrada
	// grado
	//$grado = $_POST["id_gs"];
	// y año
	//$ano = date("Y");
	// identificador de materia
	//$id_m = $_POST["id_ms"];
	// identificador de un corte
	//$corte = $_POST["corte"];
	//$periodo = $_POST["periodo"];
	//$notas = json_decode($_POST['nota']);
	//$logros = json_decode($_POST['logro']);
	//$codigos = json_decode($_POST['codigo']);



	//echo var_dump($notas);
	//echo var_dump($logros);
	//echo var_dump($codigos);
	/*
			// consulta que  retorna los alumnos  matriculados en un año dentro de un grado
			// para una jornada especifica
			$q1 = "SELECT * FROM alumnos A INNER JOIN matricula M ON A.id_alumno = M.id_alumno
			WHERE M.id_grado = ".$grado." AND M.year = ".$ano."  ORDER BY A.id_alumno";

			echo $q1;
			//$q1 = "SELECT * FROM logros WHERE  id_materia = ".$id_m." ORDER BY id";
			$q1x = mysql_query($q1, $link) or die('Consulta fallida q1: ' . mysql_error());;

			$tabla = "logros";

			while($dato1 = mysql_fetch_array($q1x)) {
				// consulta de notas para el alumno

				echo "<br>nombre : ".$dato1["nombres"];

			$nota = $_POST["n_".$dato1["id_alumno"]]
				$q2 = "UPDATE calificaciones SET".
				" nota = ".$nota.
				" WHERE id_alumno = ".$dato1["id_alumno"].
				" AND  corte = '".$corte."'".
				" AND id_materia = ".$id_m;

				echo "<br><br>consulta :".$q2;

				// se ejecuta la consulta
				//$q2x = mysql_query($q2, $link) or die('Consulta fallida  de notas: ' . mysql_error());
				// se extraen los datos
				//$dato2 = mysql_fetch_array($q2x);

			*/


		//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
	desconectar($link);

   exit ();
?>
