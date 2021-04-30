<?php

	///////////////////////////////////////////////////////////////////////////
	//  archivo para ingresar las notas  del estudiante en un periodo       //
	//////////////////////////////////////////////////////////////////////////

	// requiere el archivo de conexion
	require_once 'conexion.php';
	// conexion a la base de datos
	$link = conectar();

	// Parametros de entrada
	// grado
	$grado = $_POST["id_gs"];
	// y año
	$ano = $_POST['year'];
	// identificador de materia
	$id_materia = $_POST["id_ms"];
	// identificador de un corte
	$corte = $_POST["corte"];
	// el periodo en el que se va a calificar
	$periodo = $_POST["periodo"];
	// el codigo del docente
	$id_docente = $_POST['id_docente'];
	// la jornada del docente
	$id_jornada = $_POST["id_jornada"];

	// el conjunto de las notas recibidas
	$notas = json_decode($_POST['nota'], True);
	// el conjunto de los logros
	$logro1 = json_decode($_POST['logro1'], True);
	// el conjunto de los logros
	$logro2 = json_decode($_POST['logro2'], True);
	// el conjunto de los logros
	$logro3 = json_decode($_POST['logro3'], True);
	// el conjunto de los faltas
	$faltas = json_decode($_POST['faltas'], True);
	// el conjunto  de los codigos recibidos
	$codigos = json_decode($_POST['codigo'], True);

//var_dump($notas);

	//echo "<br>periodo :".$periodo;
	//echo "<br>corte :".$corte;
	//echo "<br>año :".$ano;
	//echo "<br>id_materia :".$id_materia;
	//echo "<br>id_docente :".$id_docente;
	//echo "<br> notas :".$notas[0]['value'];
	//echo "<br> logros :".$logro1[0]['value'];
	//echo "<br> codigo :".$codigos[0]['value'];

	$l= 0;
	// variable que guarda la cantidad de registros actualizados
	$exito = 0;
	// variable que guarda la cantidad de registros sin ingresar
	$fracaso = 0;



   foreach ($notas as $r) {
		// string de consulta para actualizacion
		// de las $notas el tama;o de las notas es
		// proporcional a la cantidad de estudiantes

   $q2 = "UPDATE calificaciones SET".
				" nota = ".$notas[$l]['value'].
				", id_logro = ".$logro1[$l]['value'].
				", faltas = ".$faltas[$l]['value'].
				", id_docente = ".$id_docente.
				" WHERE id_alumno = ".$codigos[$l]['value'].
				" AND  corte = '".$corte."'".
				" AND id_materia = ".$id_materia.
				" AND year = ".$ano.
				" AND periodo = ".$periodo.
				" AND serie = 0";

				// echo "<br><br>consulta 0 :".$q2;
				$l++;
// se ejecuta la consulta
	$q2x = mysqli_query($link, $q2 ) or die('Consulta fallida  de notas: ' . mysqli_error($link));
	// si la consulta es exitosa
	if($q2x) {
		$exito++;
		//echo "<br> Consulta relizada con exito<br>";
  }
	else {
		$fracaso++;
	}


  }

	// los logros 2


	// si el grado es preescolar se adicciona los botones para igualar los
	// logros 2  y 3
if($grado == 7 || $grado == 8 || $grado == 9 ){


		$l= 0;

	foreach ($logro2 as $r) {
	 // string de consulta para actualizacion
	 // de las $notas el tama;o de las notas es
	 // proporcional a la cantidad de estudiantes

	$q2 = "UPDATE calificaciones SET".
			 " nota = ".$notas[$l]['value'].
			 ", id_logro = ".$logro2[$l]['value'].
			 ", faltas = ".$faltas[$l]['value'].
			 ", id_docente = ".$id_docente.
			 " WHERE id_alumno = ".$codigos[$l]['value'].
			 " AND  corte = '".$corte."'".
			 " AND id_materia = ".$id_materia.
			 " AND year = ".$ano.
			 " AND periodo = ".$periodo.
			 " AND serie = 1";

			  echo "<br><br>consulta 1 :".$q2;
			 $l++;
// se ejecuta la consulta
 $q2x = mysqli_query($link, $q2 ) or die('Consulta fallida  de notas prescolar: ' . mysqli_error($link));
 // si la consulta es exitosa
 if($q2x) {
	 $exito++;
	 //echo "<br> Consulta relizada con exito<br>";
 }
 else {
	 $fracaso++;
 }


} // fin de for logro 2


 // los logros 3
		$l= 0;

 foreach ($logro3 as $r) {
	// string de consulta para actualizacion
	// de las $notas el tama;o de las notas es
	// proporcional a la cantidad de estudiantes

 $q2 = "UPDATE calificaciones SET".
			" nota = ".$notas[$l]['value'].
			", id_logro = ".$logro3[$l]['value'].
			", faltas = ".$faltas[$l]['value'].
			", id_docente = ".$id_docente.
			" WHERE id_alumno = ".$codigos[$l]['value'].
			" AND  corte = '".$corte."'".
			" AND id_materia = ".$id_materia.
			" AND year = ".$ano.
			" AND periodo = ".$periodo.
			" AND serie = 2";

			// echo "<br><br>consulta 2 :".$q2;
			$l++;
// se ejecuta la consulta
$q2x = mysqli_query($link, $q2 ) or die('Consulta fallida  de notas 2: ' . mysqli_error($link));
// si la consulta es exitos


if($q2x) {
	$exito++;
	//echo "<br> Consulta relizada con exito<br>";
}
else {
	$fracaso++;
}


} // fin de for logro 3

} // fin de if grados preescolar


	echo "<br>Se ingresaron con exito <font color='green'>  <b>".$exito
	."</b></font> notas, <font color='red'><b>".$fracaso."</b></font> errores";
	desconectar($link);


?>
