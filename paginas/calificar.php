<?php

	// utiliza  el archivo de conexion
	require_once 'conexion.php';
	// se crea la conexion
	$link = conectar();
	// mysqli_query ($link,"SET NAMES 'utf8'");

	//printf("Conjunto de caracteres inicial: %s\n", $link->character_set_name());

	/* cambiar el conjunto de caracteres a utf8 */
	if (!$link->set_charset("utf8")) {
	    printf("Error cargando el conjunto de caracteres utf8: %s\n", $link->error);
	    exit();
	} else {
		    //printf("Conjunto de caracteres actual: %s\n", $link->character_set_name());
	}

	// Pagina transitoria para generar los resultados a actualizar
	// RECUPERO DATOS DE EL FORMULARIO
	// DE ACTUACCION


	// Parametros de entrada
	// grado
	$grado = $_POST["id_gs"];
	// y año
	$ano = date("Y");
	// identificador de materia
	$id_m = $_POST["id_ms"];
	// identificador de un corte
	$corte = $_POST["corte"];
	$periodo = $_POST["periodo"];
	$jornada = $_POST['id_jornada'];

	$bk= "#FFFFFF";// variable de color de fondo de tabla
	$fondo = true;


	// buscando tabla de materias
	$q = "select * from materia where id_materia = ".$id_m;
	$qx	= mysqli_query($link, $q) or die('Consulta fallida tabla materias: ' . mysqli_error($link));
	$m = mysqli_fetch_array($qx); // ejecuto la consulta
	echo "<br> Materia: <b>".$m['materia']."</b>"; // muestro la materia en pantalla


	// buscando tabla grados
	$q = "select * from grados where id_grado = ".$grado;
	$qx	= mysqli_query($link, $q ) or die('Consulta fallida tabla grados: ' . mysqli_error($link));
	$g = mysqli_fetch_array($qx);
	echo "<br> Grado: <b>".$g['grado']."</b>";

	// buscando tabla de jornada
	$q = "select * from jornada where id_jornada = ".$jornada;
	$qx	= mysqli_query($link, $q) or die('Consulta fallida tabla jornada: ' . mysqli_error($link));
	$j = mysqli_fetch_array($qx);
	echo "<br> Jornada: <b>".$j['jornada']."</b>";

	// se establece el periodos
	echo "<br> Periodo: <b>".$periodo."</b>";
	// se toma el valor del corte
	echo "<br> Corte: <b>".$corte."</b><br><br>";

	//////////////////////////////////////////////////////////////
	// A partir de aqui creo un  formulario para el envio  de las notas
	echo "<form name='notas' id='notas'>";
	// dentro del formulario se encuentra una tabla
	echo "<table align= 'center' width = '100%' border='0'>";

	// consulta que  retorna los alumnos  matriculados en un año dentro de un grado
	// para una jornada especifica
	$q1 = "SELECT * FROM alumnos A INNER JOIN matricula M ON A.id_alumno = M.id_alumno
	WHERE M.id_grado = ".$grado." AND M.year = ".$ano." AND M.id_jornada = $jornada ORDER BY A.apellidos";
	// ejecuto la consulta
	$q1x = mysqli_query($link, $q1) or die('Consulta fallida q1: ' . mysql_error());;

	// echo "<tr ><td  colspan='1', width = '60%' ><font style='color: white;' ><b>NOMBRE</b></font></td>";
	// echo "<td colspan='1', width = '20%' ><font size = 3>NOTA</font></td>";
	// echo "<td colspan='1', width = '20%' ><font size = 3>LOGRO</font></td></tr>";

	// si pertenece a los grados de preescolar
	if($grado == 7 || $grado == 8 || $grado == 9 ){
		// creo una fila con los encabezados, que comienzan con el campo nombre
		echo "<tr ><td  colspan='1', width = '40%' ><font style='color: white;' ><b>NOMBRE</b></font></td>";
		// seguido por el campo nota
		echo "<td colspan='1', width = '12%' ><font size = 2>NOTA</font></td>";
		// seguido por el campo logro 1
		echo "<td colspan='1', width = '12%' ><font size = 2>LOGRO</font></td>";
		// seguido por el campo logro 2
		echo "<td colspan='1', width = '12%' ><font size = 2>LOGRO</font></td>";
		// seguido por el campo logro 2
		echo "<td colspan='1', width = '12%' ><font size = 2>LOGRO</font></td>";
		// y terminando con el campo FALTAS
		echo "<td colspan='1', width = '12%' ><font size = 2>FALTAS</font></td></tr>";
	}
	else{
		// Si no pertene a los grados de preescolar
		// se crean  una columna para nombre
		echo "<tr ><td  colspan='1', width = '40%' ><font style='color: white;' ><b>NOMBRE</b></font></td>";
		// una segunda columna para  la nota
		echo "<td colspan='1', width = '20%' ><font size = 3>NOTA</font></td>";
		// una tercera para el logro
		echo "<td colspan='1', width = '20%' ><font size = 3>LOGRO</font></td>";
		// y una última para las faltas
		echo "<td colspan='1', width = '20%' ><font size = 3>FALTAS</font></td></tr>";

	}

	// Se crean los botones para igualar las notas  e igualar los logros
	echo "<tr><td></td>".
		  "<td><input type = 'button' value='=' class='igual' id='igual_nota' onclick='igual_notas();' ></td>".
			"<td><input type = 'button' value='=' class='igual' id='igual_l1' onclick='igual_logro1();'</td>";

			// si el grado es preescolar se adicciona los botones para igualar los
			// logros 2  y 3
	if($grado == 7 || $grado == 8 || $grado == 9 ){

	echo 	"<td><input type = 'button' value='=' class='igual' id='igual_l2' onclick='igual_logro2();'</td>";
	echo			"<td><input type = 'button' value='=' class='igual' id='igual_l3' onclick='igual_logro3();'</td>";

	}
	echo "</tr>";

	// ejecuto la consulta
	$dato1 = mysqli_fetch_array($q1x);
	// se consulta los datos del alumno
		echo "<tr  >";
		echo "<td colspan='1', width = '40%' ><font size = 1>"
		.$dato1['apellidos']." ".$dato1['nombres']."</font></td>";

// consulta de notas para el alumno

		$q2 = "SELECT * FROM calificaciones WHERE".
					"  year = ".$ano.
					" AND periodo = ".$periodo.
					" AND corte = '".$corte."'".
						" AND id_materia = ".$id_m.
					" AND id_alumno = ".$dato1["id_alumno"].
					" AND serie = 0";

				//	echo "<br>consulta : $q2<br><br>";

		// se ejecuta la consulta
		$q2x = mysqli_query($link, $q2) or die('Consulta fallida  de notas: ' . mysqli_error());
		// se extrae el primer dato datos
		$dato2 = mysqli_fetch_array($q2x);
		//


		// -- Datos para el primer estudiante --
		// la serie de datos se caracterizan por tener el mismo atributo
		// name
		// se muestra la nota la primera nota
		echo "<td width = '20%' > <input type='number' step='0.1' max='5' min='0' style='width: 40px;'  id='master_nota' name='nota[]' class='notas'"
					."  onchange='color_celda(\"master_nota\");'  value='".$dato2['nota']."'></td>\n";

		// y se muestra el primer logro
		echo "<td width = '20%' > <input type='text' style='width: 40px;' name='logro1[]' id='master_logro1' class='logros1'"
					."  onchange='color_celda(\"master_logro1\");' value='".$dato2['id_logro']."'>";

		// si pertenece a preescolar
		if ($grado == 7 || $grado == 8 || $grado == 9){

			// consulta para obtener el segundo logro (serie = 1)

			$q3 = "SELECT * FROM calificaciones WHERE".
						"  year = ".$ano.
						" AND periodo = ".$periodo.
						" AND corte = '".$corte."'".
							" AND id_materia = ".$id_m.
						" AND id_alumno = ".$dato1["id_alumno"].
						" AND serie = 1";


						// se ejecuta la consulta
			$q3x = mysqli_query($link, $q3) or die('Consulta fallida  de notas: ' . mysqli_error());
						// se extrae el primer dato datos
			$dato3 = mysqli_fetch_array($q3x);

			// lo muestro
			echo "<td width = '20%' > <input type='text' style='width: 40px;' name='logro2[]' id='master_logro2' class='logros2'"
						." onchange='color_celda(\"master_logro2\");' value='".$dato3['id_logro']."'>";


			// consulta para obtener el tercer logro (serie = 2)

			$q4 = "SELECT * FROM calificaciones WHERE".
						"  year = ".$ano.
						" AND periodo = ".$periodo.
						" AND corte = '".$corte."'".
							" AND id_materia = ".$id_m.
						" AND id_alumno = ".$dato1["id_alumno"].
						" AND serie = 2";
						// se ejecuta la consulta
			$q4x = mysqli_query($link, $q4) or die('Consulta fallida  de notas: ' . mysqli_error());
						// se extrae el primer dato datos
			$dato4 = mysqli_fetch_array($q4x);

			// lo muestroo
			echo "<td width = '20%' > <input type='text' style='width: 40px;' name='logro3[]' id='master_logro3' class='logros3'"
					." onchange='color_celda(\"master_logro3\");' value='".$dato4['id_logro']."'>";

		}
		// ingreso la cantidad de faltas para el primer estudiante
		echo "<td width = '20%' > <input id='master_falta' type='text' style='width: 40px;' name='falta[]'  class='faltas'"
				."  onchange='color_celda(\"master_falta\");'  value='".$dato2['faltas']."'>";

		// se crea un campo oculto con el codigo del peimer alumno
		echo "<input type='hidden' name='codigo[]' class='codigos' value=".$dato1['id_alumno']."></td>";

		// con esto termino la primera la primera fila  del primer alumno



	// contador
	$ii = 1;
	// variable tipo background
	$background = " style='background-color:gray; color:white' ";

	// Exploro los alumnos restantes  mediante un ciclo de repeticion

	while ($dato1 = mysqli_fetch_array($q1x)){
		// genero una fila nueva
		echo "<tr $background>";
		// colocando en la primera celda nombre y apellido
		echo "<td colspan='1', width = '40%' ><font size = 1>"
		.$dato1['apellidos']." ".$dato1['nombres']."</font></td>";

		// consulta de notas para el alumo
		$q2 = "SELECT * FROM calificaciones WHERE".
					"  year = ".$ano.
					" AND periodo = ".$periodo.
					" AND corte = '".$corte."'".
					" AND id_materia = ".$id_m.
					" AND id_alumno = ".$dato1["id_alumno"].
					" AND serie = 0 ";


		// se ejecuta la consulta
		$q2x = mysqli_query($link, $q2) or die('Consulta fallida  de notas: ' . mysql_error());
		// se ejecuta la consulta
		$dato2 = mysqli_fetch_array($q2x);

		// se ingresa la nota del estudiante
		echo "<td width = '20%' >	<input type='number' step='0.1' max='5' min='0' style='width: 40px;'  name='nota[]' class='notas'"
		." id='nota".$dato1['id_alumno']."' onchange='color_celda(\"nota".$dato1['id_alumno']."\");'  value='".$dato2['nota']."'>	</td>";
		// se coloca el el primer logro
		echo "<td width = '20%' > <input type='text' style='width: 40px;' name='logro1[]'  class='logros1'"
					." id='logro1".$dato1['id_alumno']."' onchange='color_celda(\"logro1".$dato1['id_alumno']."\");'  value='".$dato2['id_logro']."'>";


		//  si el grado es de preescolar
		if ($grado == 7 || $grado == 8 || $grado == 9){

			// consulta para obtener el segundo logro (serie = 1)

			$q3 = "SELECT * FROM calificaciones WHERE".
						"  year = ".$ano.
						" AND periodo = ".$periodo.
						" AND corte = '".$corte."'".
							" AND id_materia = ".$id_m.
						" AND id_alumno = ".$dato1["id_alumno"].
						" AND serie = 1";


						// se ejecuta la consulta
			$q3x = mysqli_query($link, $q3) or die('Consulta fallida  de notas: ' . mysqli_error());
						// se extrae el primer dato datos
			$dato3 = mysqli_fetch_array($q3x);

			// incerto el segundo logro
			echo "<td width = '20%' > <input  type='text' style='width: 40px;' name='logro2[]' class='logros2'"
			." id='logro2".$dato1['id_alumno']."' onchange='color_celda(\"logro2".$dato1['id_alumno']."\");'   value='".$dato3['id_logro']."'></td>";
			// genero el siguiete registro


			// consulta para obtener el segundo logro (serie = 1)

			$q3 = "SELECT * FROM calificaciones WHERE".
						"  year = ".$ano.
						" AND periodo = ".$periodo.
						" AND corte = '".$corte."'".
							" AND id_materia = ".$id_m.
						" AND id_alumno = ".$dato1["id_alumno"].
						" AND serie = 2";


						// se ejecuta la consulta
			$q4x = mysqli_query($link, $q4) or die('Consulta fallida  de notas: ' . mysqli_error());
						// se extrae el primer dato datos
			$dato4 = mysqli_fetch_array($q4x);

			// incerto el tercer logro
			echo "<td width = '20%' > <input  type='text' style='width: 40px;' name='logro3[]' class='logros3'"
			." id='logro3".$dato1['id_alumno']."' onchange='color_celda(\"logro3".$dato1['id_alumno']."\");'  value='".$dato4['id_logro']."'></td>";
			// espacio para las faltas
			// echo "<td width = '20%' > <input type='text' style='width: 40px;' name='faltas[]'  class='faltas'"
			// ." value='".$dato2['faltas']."'>";
		}

		// ingreso la cantidad de faltas
		echo "<td width = '20%' > <input type='text' style='width: 40px;' name='faltas[]'  class='faltas'"
				." id='falta".$dato1['id_alumno']."' onchange='color_celda(\"falta".$dato1['id_alumno']."\");'  value='".$dato2['faltas']."'>";

		echo "<input type='hidden' name='codigo[]' class='codigos' value=".$dato1['id_alumno']."></td>";

		echo "</tr>";
	//
	// 	// se crea un campo oculto  con el codigo del alumno
	// 	echo "<input type='hidden' name='codigo[]' class='codigos' value=".$dato1['id_alumno']."></td></tr>";

	// desicion  es una celda par o impar
	if ( $ii%2 ){
		$background ="";

	}

	else{
		$background = " style='background-color:gray; color:white' ";
	}


	$ii ++; // se incrementa el contador

	}// fin del while 1
	echo	"</table>";

	echo "</form>";

	//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
	desconectar($link);
?>
