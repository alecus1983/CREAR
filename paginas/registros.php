<?php

session_start();

if(!isset($_SESSION['usuario']))
{
  //Sila secciÃ³n no esta iniciada entonces retorna a la pagina principal
  header('Location:login_boletines.php');

  //termina el programa php
  exit();
}

// se requiere el archivo para la conexion
require_once 'conexion.php';

// se crea una conexion
$link = conectar();

// Parametros de entrada
// grado
$grado = $_POST["id_gs"];
$n_grado = $_POST["n_grado"];
$ano = date("Y");
// fecha final para la entrega de notas
$fecha_f = date('Y-10-30');
// dia de hoy
$hoy = date('Y-m-d');

// grado
echo "Grado :<b>$n_grado</b> <br><br>";


// ciclo for para editar los periodos genera
// una repeticion por cada periodo


for($i= 1; $i <= 5 ; $i++) {

	// acumulador para los registros incertados
	$creados = 0;
	// contador para los registros existentes
	$existente = 0;
	// genero un titulo para el periodo

	echo "<br><b>Registros ingresados para el periodo $i </b>"; // consulta para obtener todas las materias del grado

   $q1 = "SELECT * FROM materia M INNER JOIN requisitos R ON R.id_materia = M.id_materia
   WHERE R.id_grado = ".$grado." ORDER BY M.id_materia";
	// echo "<br> consulta :".$q1;
   // se hace la consulta en la base de datos
   $q1x = mysqli_query( $link, $q1) or die('Consulta materias - requisitos fallida : ' . mysqli_error($link));

   // ciclo de repeticion que recupera el codigo de las materas asignadas a cada grado
   while($materias_grado = mysqli_fetch_array($q1x)) {

   	//  se almacenan las materias de un grado especifico
		$id_m = $materias_grado["id_materia"];

   	echo "<br>materia - <b>".$materias_grado["materia"]."</b>";
   	//CONSULTA LOS ALUMNOS MATRICULADOS EN UN AÑO Y GRADO

   	$q2 = "SELECT * FROM alumnos A INNER JOIN matricula M ON A.id_alumno = M.id_alumno
		WHERE M.id_grado = ".$grado." AND M.year ='".$ano."' ORDER BY A.id_alumno";

   	// ejecuta la consulta en una base de datos
   	$q2x = mysqli_query( $link, $q2) or die('Consulta alumnos matricula fallida: '
   	. mysqli_error($link));


   	// ciclo de repeticion que recupera los alumnos matriculados en un año y grado

   	while($alumnos_grado = mysqli_fetch_array($q2x)) {


   		$id_a = $alumnos_grado["id_alumno"];

   		//echo "codigo alumno $id_a , <br>nombre ".$alumnos_grado["nombres"]." ".$alumnos_grado["apellidos"];

   		// CONSULTA LOS REGISTROS DE CALIFICACIONES EN EL AÑO PERIODO MATERIA Y ALUMNO
   		// PARA EL CORTE A
   		$qa = "SELECT count(id) FROM calificaciones	WHERE year = '".$ano
   		."' AND periodo =".$i
   		." AND corte = 'A' "
   		." AND id_materia =".$id_m
   		." AND id_alumno =".$id_a;

   		// CONSULTA DE LA CANTIDAD DE CALIFICACIONES CREADAS PARA EL CORTE FINAL DEL
   		// PERIODO
   		$qf = "SELECT count(id) FROM calificaciones	WHERE year = '".$ano
   		."' AND periodo =".$i
   		." AND corte = 'F' "
   		." AND id_materia =".$id_m
   		." AND id_alumno =".$id_a;

   		// realiza la consulta en la matrix de calificaiones para el
   		// primer corte

   		$qax = mysqli_query( $link, $qa) or die('Consulta calificaciones fallida : '
   		. mysqli_error($link));

   		// recupera las calificaciones  obtenidas para el alumno en cuestion
   		$data = mysqli_fetch_array($qax);

   		// cuenta cuantas calificacions tiene para el año - periodo - corte - materia
   		// para un alumno especifico
   		$numero_a = $data[0];

	      // realiza la consulta en la matrix de calificaiones
	      // para el corte final
   		$qfx = mysqli_query( $link, $qf) or die('Consulta calificaciones fallida : '
   		. mysqli_error($link));
   		// recupera las calificaciones  obtenidas para el alumno en cuestion

   		// los coloco en la variable corte final
   		$data = mysqli_fetch_array($qfx);
   		// cuenta cuantas calificacions tiene para el año
   		$numero_f = $data[0];

   		//echo "numero de registros para el corte A: $numero_a <br>";
			//echo "numero de registros para el corte final: ".$numero_f." <br>";

			// una vez evaluado si existe registros creados para un año-periodo-corte-materia-alumno
			// especifico  procedo a evaluar si se trata de grado preescolar
			// o se trata de un grado distinto ya que preescolar tiene
			// tres logros para el corte final

   		// Cosulto si el grado  que  se ingreso es preescolar se
   		// insertaran tres logros por cada ALUMNO, MATERIA, GRADO, AÑO

   		if ($grado ==7 || $grado == 8 || $grado == 9)
   		{
   			// si se trata de preescolar evaluo so el numero de registros
   			// es menor que 3 ( con lo cual se deberiarn haber creado los registros)
   			// 0, 1, 2 etc

      		if ($numero_f < 3)
     			{
					// de ser que faltan registros  entonces inicializo
					// mi contador en 0
        			$ii=0;

               // hago un ciclo de repeticion  desde numero_f hasta
               // que el maximo numero de registros sena tres elementos ( de 0 a 2)

         		for ( $ii = $numero_f; $ii<3 ; $ii++){
                  // insrto en la tabla calificaciones un registro con los campos predefinidos
          			$q4 = "INSERT INTO calificaciones (id_alumno, id_docente, id_materia, periodo, corte, year, serie, id_logro,nota, limite, modificado, own,serie)
								VALUES ('$id_a', 0, '$id_m', '$i', 'F' , '$ano',$ii,0 , 0 ,'$fecha_f' ,'$hoy' , 99,0)";
                  // ejecuto la consulta en la base de datos
	            		$q4x = mysqli_query( $link, $q4) or die('Error al insertar calificaciones : '. mysqli_error($link));
            		//echo "consulta:<font color='green'> $q4 </font><br>";
                $creados++;
	            	//echo "<font color='blue'>insertando registro $ii </font><br>";
        			}
      		}
            // si el estudiante tiene una gran cantidad de registros
      		else {
      			$existente ++;
      			//echo "<font color='red'>hay demasiados registros</fonst><br>";
      		}
   		}

   		// si no se trata de un caso de calificaciones de preescolar
   		// si no de los grados superiores
   		else {

   			// evaluo si el numero de notas para el corte A  esta vacio
   			if($numero_a == 0) {

					// creo nuevas calificaciones para el estudiante en la materia espesífica

					// creo la coonsulata para crear las calificaciones
					$q4 = "INSERT INTO calificaciones (id_alumno, id_docente, id_materia, periodo, corte, year, id_logro, nota, limite, modificado, own, serie)
					VALUES ('$id_a', 0, '$id_m',  '$i', 'A', '$ano', 0, 0, '$fecha_f' , '$hoy', 99, 0 )";
            	//echo "<font color='green'>consulta: $q4 </font><br>";
					// ejecuto la consulta en la base de datos
					$q4x = mysqli_query( $link, $q4) or die('Error al insertar calificaciones : '. mysqli_error($link));
					$creados ++;
				}
				else {
         		//echo "<font color='red'>registro lleno para el corte A </font><br>";
					//  si ya esta creada la materia para el alumno espesífico  muestro los resultados
            	$existente ++;
				}

				// evaluo si el numero de notas finales  esta vacio
	  			if($numero_f == 0) {

					// creo nuevas calificaciones para el estudiante en la materia espesífica

					// creo la coonsulata para crear las calificaciones
					$q4 = "INSERT INTO calificaciones (id_alumno, id_docente, id_materia, periodo, corte, year, id_logro, nota, limite, modificado, own, serie)
					VALUES ('$id_a', 0 , '$id_m', '$i', 'F', '$ano', 0, 0 ,'$fecha_f' ,'$hoy', 99, 0)";
            	//echo "<font color='green'>consulta: $q4 </font><br>";
					// ejecuto la consulta en la base de datos
					$q4x = mysqli_query( $link, $q4) or die('Error al insertar calificaciones : '. mysqli_error($link));
					$creados ++;
				}
				else {
         		//echo "<font color='red'>registro lleno para el corte final </font><br>";
					//  si ya esta creada la materia para el alumno espesífico  muestro los resultados
            	$existente ++;
				}
   		}
		}
	}
	// estadisticas de periodo
	echo "<br>Total insertados <font color='green'><b>$creados</b> </font> existente : <font color='red'><b>".$existente."</b> </font><br>";

}

desconectar($link);
?>
