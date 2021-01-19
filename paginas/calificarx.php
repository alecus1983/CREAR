<?php
	require_once 'conexion.php';	
	$link = conectar();	
	
	
	
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
	
	$bk= "#FFFFFF";// variable de color de fondo de tabla
	$fondo = true;

	echo "<form name='notas' id='notas'>";
	echo "<table align= 'center' width = '100%' border='0'>";
				// consulta que  retorna los alumnos  matriculados en un año dentro de un grado
				// para una jornada especifica					
				$q1 = "SELECT * FROM alumnos A INNER JOIN matricula M ON A.id_alumno = M.id_alumno
				WHERE M.id_grado = ".$grado." AND M.year = ".$ano."  ORDER BY A.id_alumno";					
				
				//echo "consulta :".$q1;
							
				//$q1 = "SELECT * FROM logros WHERE  id_materia = ".$id_m." ORDER BY id";
				$q1x = mysql_query($q1, $link) or die('Consulta fallida q1: ' . mysql_error());;

				$tabla = "logros";				
				echo "<tr ><td  colspan='1', width = '30%' ><font style='color: white;' ><b>NOMBRE</b></font></td>";													
				echo "<td colspan='1', width = '30%' ><font size = 3>APELLIDO</font></td>";
				echo "<td colspan='1', width = '20%' ><font size = 3>NOTA</font></td>";
				echo "<td colspan='1', width = '20%' ><font size = 3>LOGRO</font></td></tr>";
				
				echo "<tr><td></td><td></td>".
				"<td><input type = 'button' value='=' class='igual' id='igual_nota'></td>".
				"<td><input type = 'button' value='=' class='igual' id='igual_logro'></td></tr>";
				
				
				while($dato1 = mysql_fetch_array($q1x)) {
					// consulta de notas para el alumno
					$q2 = "SELECT * FROM calificaciones WHERE".
					"  year = ".$ano.
					" AND periodo = ".$periodo.
					" AND corte = '".$corte."'".
					" AND id_materia = ".$id_m.
					" AND id_alumno = ".$dato1["id_alumno"];
					
					//echo "<br>consulta :".$q2;
					
					// se ejecuta la consulta
					$q2x = mysql_query($q2, $link) or die('Consulta fallida  de notas: ' . mysql_error());
					// se extraen los datos
					$dato2 = mysql_fetch_array($q2x);
						
					echo "<tr  >";
					echo "<td colspan='1', width = '30%' ><font size = 1>"
					.utf8_decode($dato1['nombres'])."</font></td>\n";													
					echo "<td colspan='1', width = '30%' ><font size = 1>"
					.utf8_decode($dato1['apellidos'])."</font></td>\n";
					echo "<td width = '20%' > <input type='text' style='width: 40px;' name = 'n_"
					.$dato1['id_alumno']."' value='".$dato2['nota']."'></td>\n";
					echo "<td width = '20%' > <input type='text' style='width: 40px;' name = 'l_"
					.$dato1['id_alumno']."' value='".$dato2['id_logro']."'></td></tr>\n";
					
																		
				}
					
		
		echo	"</table>";
		echo "<input type='hidden' name='ano' value=$ano>";
		echo "<input type='hidden' name='id_ms' value=$id_m>";
		echo "<input type='hidden' name='corte' value=$corte>";
		echo "<input type='hidden' name='periodo' value=$periodo>";
		echo "<input type='hidden' name='id_gs' value=$grado>";				
	echo "</form>";	
		//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
	desconectar($link);
   
   exit ();
?>