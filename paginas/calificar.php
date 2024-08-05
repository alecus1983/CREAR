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
	$ano = $_POST["years"];//date("Y");
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
	echo "<table class='table table-hover'>";

	// consulta que  retorna los alumnos  matriculados en un año dentro de un grado
	// para una jornada especifica
	$q1 = "SELECT * FROM alumnos A INNER JOIN matricula M ON A.id_alumno = M.id_alumno
	WHERE M.id_grado = ".$grado." AND M.year = ".$ano." AND M.id_jornada = $jornada ORDER BY A.apellidos";
	// ejecuto la consulta
	$q1x = mysqli_query($link, $q1) or die('Consulta fallida q1: ' . mysqli_error($link));;


	// si pertenece a los grados de preescolar
	if($grado == 7 || $grado == 8 || $grado == 9 ){
		// creo una fila con los encabezados, que comienzan con el campo nombre
		echo "<tr ><td><b>NOMBRE</b></td>";
		// seguido por el campo nota
		echo "<td>NOTA</td>";
		// seguido por el campo logro 1
		echo "<td>LOGRO</td>";
		// seguido por el campo logro 2
		echo "<td>LOGRO</td>";
		// seguido por el campo logro 2
		echo "<td>LOGRO</td>";
		// y terminando con el campo FALTAS
		echo "<td>FALTAS</td></tr>";
	}
	else{
		// Si no pertene a los grados de preescolar
		// se crean  una columna para nombre
		echo "<tr><td><b>NOMBRE</b></td>";
		// una segunda columna para  la nota
		echo "<td>NOTA</td>";
		// una tercera para el logro
		echo "<td>LOGRO</td>";
		// y una última para las faltas
		echo "<td>FALTAS</td></tr>";

	}

	// Se crean los botones para igualar las notas  e igualar los logros
	echo "<tr><td></td>".
		  "<td><button type = 'button' value='=' class='igual btn btn-outline-primary' id='igual_nota' style='width: 60px;' onclick='igual_notas();' >=</button></td>".
			"<td><button type = 'button' value='=' class='igual btn btn-outline-primary' id='igual_l1' style='width: 60px;' onclick='igual_logro1();'>=</button></td>";

			// si el grado es preescolar se adicciona los botones para igualar los
			// logros 2  y 3
	if($grado == 7 || $grado == 8 || $grado == 9 ){

	echo 	"<td><button type = 'button' value='=' class='igua btn btn-outline-primary' id='igual_l2' onclick='igual_logro2();'>=</button></td>";
	echo	"<td><button type = 'button' value='=' class='igual btn btn-outline-primary' id='igual_l3' onclick='igual_logro3();'>=</button></td>";

	}
	echo "</tr>";

	// ejecuto la consulta
	$dato1 = mysqli_fetch_array($q1x);
	// se consulta los datos del alumno
		echo "<tr >";
		echo "<td>"
		.ucwords(strtolower($dato1['apellidos']))." ".ucwords(strtolower($dato1['nombres']))."</td>";

// consulta de notas para el alumno

		$q2 = "SELECT * FROM calificaciones_$ano WHERE".
					"  year = ".$ano.
					" AND periodo = ".$periodo.
					" AND corte = '".$corte."'".
						" AND id_materia = ".$id_m.
					" AND id_alumno = ".$dato1["id_alumno"].
					" AND serie = 0";

		// se ejecuta la consulta
		$q2x = mysqli_query($link, $q2) or die('Consulta fallida  de notas: ' . mysqli_error($link));
		// se extrae el primer dato datos
		$dato2 = mysqli_fetch_array($q2x);
		//
		// si la nota que carga no es nula ...
		if (isset($dato2['nota'])){
			$nota = $dato2['nota'];
		}
		// si es nula
		else {
			$nota = 0;
		}

		// si la nota que carga no es nula ...
		if (isset($dato2['id_logro'])){
			$id_logro = $dato2['id_logro'];
		}
		// si es nula
		else {
			$id_logro = 0;
		}

		// si la nota que carga no es nula ...
		if (isset($dato2['faltas'])){
			$faltas2 = $dato2['faltas'];
		}
		// si es nula
		else {
			$faltas2 = 0;
		}

		// -- Datos para el primer estudiante --
		// la serie de datos se caracterizan por tener el mismo atributo
		// name
		// se muestra la nota la primera nota
		echo "<td> <input type='number' step='0.1' max='5' min='0' style='width: 60px;'  id='master_nota' name='nota[]' class='notas form-control'
		data-bs-toggle='tooltip' data-bs-placement='top' title='use , como separador decimal'"
					."  onchange='color_celda(\"master_nota\");'  value='$nota'></td>\n";

		// y se muestra el primer logro
		echo "<td> <input type='text' style='width: 60px;' name='logro1[]' id='master_logro1' class='logros1 form-control'"
					."  onchange='color_celda(\"master_logro1\");' value='$id_logro'>";

		// si pertenece a preescolar
		if ($grado == 7 || $grado == 8 || $grado == 9){

			// consulta para obtener el segundo logro (serie = 1)

			$q3 = "SELECT * FROM calificaciones_$ano WHERE".
						"  year = ".$ano.
						" AND periodo = ".$periodo.
						" AND corte = '".$corte."'".
							" AND id_materia = ".$id_m.
						" AND id_alumno = ".$dato1["id_alumno"].
						" AND serie = 1";


						// se ejecuta la consulta
			$q3x = mysqli_query($link, $q3) or die('Consulta fallida  de notas: ' . mysqli_error($link));
						// se extrae el primer dato datos
			$dato3 = mysqli_fetch_array($q3x);

			$id_logro3 = 0;
			if(isset($dato3['id_logro'])){
				$id_logro3 = $dato3['id_logro'];
			}

			// lo muestro
			echo "<td> <input type='text' style='width: 60px;' name='logro2[]' id='master_logro2' class='logros2'"
						." onchange='color_celda(\"master_logro2\");' value='$id_logro3'>";


			// consulta para obtener el tercer logro (serie = 2)

			$q4 = "SELECT * FROM calificaciones_$ano WHERE".
						"  year = ".$ano.
						" AND periodo = ".$periodo.
						" AND corte = '".$corte."'".
							" AND id_materia = ".$id_m.
						" AND id_alumno = ".$dato1["id_alumno"].
						" AND serie = 2";
						// se ejecuta la consulta
			$q4x = mysqli_query($link, $q4) or die('Consulta fallida  de notas: ' . mysqli_error($link));
						// se extrae el primer dato datos
			$dato4 = mysqli_fetch_array($q4x);

			// si la nota que carga no es nula ...
			if (isset($dato4['nota'])){
				$nota4 = $dato4['nota'];
			}
			// si es nula
			else {
				$nota4 = 0;
			}

			// si la nota que carga no es nula ...
			if (isset($dato4['id_logro'])){
				$id_logro4 = $dato4['id_logro'];
			}
			// si es nula
			else {
				$id_logro4 = 0;
			}

			$faltas4  = 0;
			// si la nota que carga no es nula ...
			if (isset($dato4['faltas'])){
				$faltas4 = $dato4['faltas'];
			}
			// si es nula
			else {
				$faltas4 = 0;
			}

			// lo muestroo
			echo "<td> <input type='text' style='width: 60px;' name='logro3[]' id='master_logro3' class='logros3'"
					." onchange='color_celda(\"master_logro3\");' value='$id_logro4'>";

		}
		// ingreso la cantidad de faltas para el primer estudiante
		echo "<td> <input id='master_falta' type='text' style='width: 60px;' name='falta[]'  class='faltas'"
				."  onchange='color_celda(\"master_falta\");'  value=$faltas2>";

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
		echo "<tr>";
		// colocando en la primera celda nombre y apellido
		echo "<td>"
		.ucwords(strtolower($dato1['apellidos']))." ".ucwords(strtolower($dato1['nombres']))."</td>";

		// consulta de notas para el alumo
		$q2 = "SELECT * FROM calificaciones_$ano WHERE".
					"  year = ".$ano.
					" AND periodo = ".$periodo.
					" AND corte = '".$corte."'".
					" AND id_materia = ".$id_m.
					" AND id_alumno = ".$dato1["id_alumno"].
					" AND serie = 0 ";


		// se ejecuta la consulta
		$q2x = mysqli_query($link, $q2) or die('Consulta fallida  de notas: ' . mysqli_error($link));
		// se ejecuta la consulta
		$dato2 = mysqli_fetch_array($q2x);

		// si la nota que carga no es nula ...
		if (isset($dato2['nota'])){
			$nota2 = $dato2['nota'];
		}
		// si es nula
		else {
			$nota2 = 0;
		}

		// si la nota que carga no es nula ...
		if (isset($dato2['id_logro'])){
			$id_logro2 = $dato2['id_logro'];
		}
		// si es nula
		else {
			$id_logro2 = 0;
		}

		// si la nota que carga no es nula ...
		if (isset($dato2['faltas'])){
			$faltas2 = $dato2['faltas'];
		}
		// si es nula
		else {
			$faltas2 = 0;
		}

		// se ingresa la nota del estudiante
		echo "<td>	<input type='number' step='0.1' max='5' min='0' style='width: 60px;'  name='nota[]' class='notas'
		data-bs-toggle='tooltip' data-bs-placement='top' title='use , como separador decimal'"
		." id='nota".$dato1['id_alumno']."' onchange='color_celda(\"nota".$dato1['id_alumno']."\");'  value='$nota2'>	</td>";
		// se coloca el el primer logro
		echo "<td> <input type='text' style='width: 60px;' name='logro1[]'  class='logros1'"
					." id='logro1".$dato1['id_alumno']."' onchange='color_celda(\"logro1".$dato1['id_alumno']."\");'  value='$id_logro2'>";


		//  si el grado es de preescolar
		if ($grado == 7 || $grado == 8 || $grado == 9){

			// consulta para obtener el segundo logro (serie = 1)

			$q3 = "SELECT * FROM calificaciones_$ano WHERE".
						"  year = ".$ano.
						" AND periodo = ".$periodo.
						" AND corte = '".$corte."'".
							" AND id_materia = ".$id_m.
						" AND id_alumno = ".$dato1["id_alumno"].
						" AND serie = 1";


						// se ejecuta la consulta
			$q3x = mysqli_query($link, $q3) or die('Consulta fallida  de notas: ' . mysqli_error($link));
						// se extrae el primer dato datos
			$dato3 = mysqli_fetch_array($q3x);

			$id_logro3 = 0;
			if(isset($dato3['id_logro'])){
				$id_logro3 = $dato3['id_logro'];
			}

			// incerto el segundo logro
			echo "<td> <input  type='text' style='width: 60px;' name='logro2[]' class='logros2'"
			." id='logro2".$dato1['id_alumno']."' onchange='color_celda(\"logro2".$dato1['id_alumno']."\");'   value='$id_logro3'></td>";
			// genero el siguiete registro


			// consulta para obtener el segundo logro (serie = 1)

			$q3 = "SELECT * FROM calificaciones_$ano WHERE".
						"  year = ".$ano.
						" AND periodo = ".$periodo.
						" AND corte = '".$corte."'".
							" AND id_materia = ".$id_m.
						" AND id_alumno = ".$dato1["id_alumno"].
						" AND serie = 2";


						// se ejecuta la consulta
			$q4x = mysqli_query($link, $q4) or die('Consulta fallida  de notas: ' . mysqli_error($link));
						// se extrae el primer dato datos
			$dato4 = mysqli_fetch_array($q4x);

			$id_logro4 = 0;
			if(isset($dato4['id_logro'])){
				$id_logro4 = $dato4['id_logro'];
			}

			// incerto el tercer logro
			echo "<td> <input  type='text' style='width: 60px;' name='logro3[]' class='logros3'"
			." id='logro3".$dato1['id_alumno']."' onchange='color_celda(\"logro3".$dato1['id_alumno']."\");'  value='$id_logro4'></td>";
			// espacio para las faltas
			// echo "<td> <input type='text' style='width: 60px;' name='faltas[]'  class='faltas'"
			// ." value='".$dato2['faltas']."'>";
		}

		// ingreso la cantidad de faltas
		echo "<td> <input type='text' style='width: 60px;' name='faltas[]'  class='faltas'"
				." id='falta".$dato1['id_alumno']."' onchange='color_celda(\"falta".$dato1['id_alumno']."\");'  value='$faltas2'>";

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
