<?php
	
	ob_end_clean(); 
	ini_set('display_errors', 'on');
	error_reporting(E_ALL | E_STRICT);	
	
	include('generar_cabezera.php');
	include ("conexion.php");	// archivo de conexión con la base de datos
	$link = conectar();			//  se conecta con la base de datos
	$fecha = '2015';				// carga el valor  en la variable fecha
	$periodo = 1;
	
	
	$pdf = new PDF();
 	$pdf->AddPage();
 	$pdf->AliasNbPages();
	$pdf->SetFont('Arial','',12);
	//Aquí escribimos lo que deseamos mostrar...
	
 	
	/*  PARA DISEÑAR LA CONSULTA SE REQUIERE RELIZAR LOS SIGUENTES AGRUPAMIENTOS
		
		AÑO
		PERIODO
		GRADO
		ESTUDIANTE
		AREA
		MATERIA
		PROFESOR
	
	
	*/
	
	// ESTA CONSULTA AGRUPA POR GRADOS
	
		///////////////////////////////////////////////////////
		
		
		
		
		////////////////////////////////////////////////////////
	
	
	
		
	$q1 = "SELECT DISTINCT matricula.grado FROM 
			((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id) 
			INNER JOIN logros ON calificaciones.id_logro = logros.id) 
			INNER JOIN docentes ON calificaciones.id_docente = docentes.id) 
			INNER JOIN materia ON calificaciones.id_materia = materia.id) 
			INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno";
	
			/*
			alumnos, calificaciones, materia,logros, matricula 
			WHERE alumnos.id = calificaciones.id_alumno 
			and materia.id = calificaciones.id_materia 
			and logros.id = calificaciones.id_logro 
			and matricula.id_alumno = calificaciones.id_alumno"; 
	 		*/
			
	// ejecución de la consulta para los grados seleccionados
			
	$q1x = mysql_query($q1, $link) or die('Consulta fallida q1: ' . mysql_error());;		
	
	// crea una fila dentro de la tabla
	

		
		while($dato1 = mysql_fetch_array($q1x)) { //extrae los datos de la consulta q1x en la variable tipo arrelo dato
		
				
			// SE ALMACENA EL GRADO EN LA VARAIABLE $grado
			
			$grado = "'".$dato1['grado']."'";		// guarda en grado el string del grado  rodeado por comillas simples
			$nivel = "".$dato1['grado']."";
			
			// DENTRO DEL GRADO SE REALIZA LA CONSULTA PARA  DETERMINAR LOS ESTUDIANTES DEL GRADO
			// 			
						
			$q3 = "SELECT DISTINCT  alumnos.id, alumnos.nombres, alumnos.apellidos  
			FROM ((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id) 
			INNER JOIN logros ON calificaciones.id_logro = logros.id) 
			INNER JOIN docentes ON calificaciones.id_docente = docentes.id) 
			INNER JOIN materia ON calificaciones.id_materia = materia.id) 
			INNER JOIN matricula ON (calificaciones.id_alumno = matricula.id_alumno AND matricula.grado = '10-A')
			"; 
			
			
			/*
			alumnos, calificaciones, materia,logros, matricula 
			WHERE alumnos.id = calificaciones.id_alumno 
			and materia.id = calificaciones.id_materia 
			and logros.id = calificaciones.id_logro 
			and matricula.id_alumno = calificaciones.id_alumno
			and matricula.grado = ".$grado;
			*/
			
			// se ejecuta la consulta para determinar  los estudiantes del grado en cuestion
			
			
			$q3x = mysql_query($q3, $link) or die('Consulta fallida q3: ' . mysql_error());;		
			
			
			//
			//	ENCABEZADO DE NOMBRE
			//
			
			// CICLO DE REPETICION PARA EXPLORAR LOS ESTUDIANTES
			
			
			while($dato2 = mysql_fetch_array($q3x)) { //extrae los datos de la consulta q3x en la variable tipo arrelo dato
		
							
				// VARIABLES PARA GUARDAR LOS NOMBRES DE LOS ESTUDIANTES
				
				$id_n = "".$dato2['id']."";		// guarda en grado el string del grado  rodeado por comillas simples
				$nombres = $dato2['nombres'];
				$apellidos = $dato2['apellidos'];
				
				
				/*
				
				// EMCABEZADO CON NOMBRE
				
				echo "<tr><td colspan='2', width = '40'>
						<table width = '800', align='center', border ='1', bordercolor = '#000000'
						 cellpadding = '1', cellspacing = '0'><tr>
						<td width = '40', align = 'center', bgcolor = '#9999AA',  > No. </td>
						<td width = '360', align = 'center', bgcolor = '#999999', border ='1' > NOMBRE DEL ESTUDIANTE </td>
						<td width = '100', align = 'center', bgcolor = '#999999', border ='1'> GRADO </td>
						<td width = '180', align = 'center', bgcolor = '#999999', border ='1'> JORNADA </td>
						<td width = '120', align = 'center', bgcolor = '#999999', border ='1'> A&NtildeO LECTIVO </td></tr>
						";
						
				
				echo "<tr>
						<td width = '40', align = 'center', bgcolor = '#FFFFFF' > No. </td>
						<td width = '360', align = 'center', bgcolor = '#FFFFFF' >" .$apellidos." ".$nombres." </td>
						<td width = '100', align = 'center', bgcolor = '#FFFFFF'> ".$nivel." </td>
						<td width = '180', align = 'center', bgcolor = '#FFFFFF'> Ma&ntildeana </td>
						<td width = '120', align = 'center', bgcolor = '#FFFFFF'> 2012 </td>
						</tr></table>
						</td></tr>";
						
				echo	"<tr><td height='4', colspan='2'>&nbsp;</td> </tr>\n";
				
				// TABLA DE NOTAS
				
				echo	"<tr><td colspan='2', width = '40'>
						<table width = '800' align='center',  border ='1', cellpadding = '1', cellspacing = '0' ><tr>
						<td width = '20%', align = 'center' > <font size = 2>AREA </font></td>
						<td width = '20%', align = 'center' > <font size = 2>ASIGNATURA</font> </td>
						<td width = '10%', align = 'center' > <font size = 2>I.H. </font></td>
						<td width = '10%', align = 'center'> <font size = 1>PERIODO 1 </font></td>
						<td width = '10%', align = 'center'> <font size = 1>PERIODO 2 </font></td>
						<td width = '10%', align = 'center'> <font size = 1>PERIODO 3 </font></td>
						<td width = '10%', align = 'center'> <font size = 1>PERIODO 4 </font></td>
						<td width = '10%', align = 'center'> <font size = 1>DEFINITIVA </font></td></td></tr>
						";
						
				
				echo	"<tr>
						<td width = '40', align = 'center', bgcolor = '#FFFFFF' >  </td>
						<td width = '360', align = 'center', bgcolor = '#FFFFFF' > </td>
						<td width = '100', align = 'center', bgcolor = '#FFFFFF'> </td>
						<td width = '180', align = 'center', bgcolor = '#FFFFFF'> </td>
						<td width = '120', align = 'center', bgcolor = '#FFFFFF'>  </td>
						</tr></table>
						</td></tr>";
								
				//
				// 	ESTRUCTURA PARA DETERMINAR ASIGNATURAS
				//
				
				*/
				
				
				///////////////////////////////////////////
								
				///////////////////////////////////////////////////////////////

				$pdf->Cell(40,10,'¡Hola, Mundo!',1);
				$pdf->Cell(40,10,'¡Hola, Mundo!',1);
				
				$q4 = "SELECT  DISTINCT materia.id_a, materia.area
				FROM ((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id) 
				INNER JOIN logros ON calificaciones.id_logro = logros.id) 
				INNER JOIN docentes ON calificaciones.id_docente = docentes.id) 
				INNER JOIN materia ON calificaciones.id_materia = materia.id) 
				INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno 
				AND matricula.grado =".$grado."
				WHERE calificaciones.id_alumno=" .$id_n
				;
								
				
									
				// consulta para   mostrar areas por materia
				$q4x = mysql_query($q4, $link) or die('Consulta fallida q3: ' . mysql_error());;
				
				
				// ciclo de repeticion  para la muestra las materias por cada alumno
				
				//echo "<tr><td colspan='2' >&nbsp;</td> </tr>\n";	//
				
				while($dato3 = mysql_fetch_array($q4x)) {
		
					$area = $dato3['area'];
					$id_a = $dato3['id_a'];
					// Encabezado de area
					
					/*			
					echo "<tr><td colspan='2', width = '40'>
							<table width = '800', align='center', border ='1', bordercolor = '#000000'
						 	cellpadding = '1', cellspacing = '0'>";
					echo "<tr><td  colspan='4', width = '40'>".$area."</td></tr>";
					*/				
								
					$q5 = "SELECT  DISTINCT materia.id, materia.materia
					FROM ((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id) 
					INNER JOIN logros ON calificaciones.id_logro = logros.id) 
					INNER JOIN docentes ON calificaciones.id_docente = docentes.id) 
					INNER JOIN materia ON calificaciones.id_materia = materia.id) 
					INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno 
					AND matricula.grado =".$grado."
					WHERE calificaciones.id_alumno=" .$id_n. "
					AND materia.id_a =".$id_a
					;
					
					$q5x = mysql_query($q5, $link) or die('Consulta fallida q3: ' . mysql_error());;
					
					while($dato4 = mysql_fetch_array($q5x)) {
					
						$id_m = $dato4['id'];
						
						$q6 = "SELECT  DISTINCT materia.id, materia.materia, calificaciones.nota, docentes.nombres, docentes.apellidos
						FROM ((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id) 
						INNER JOIN logros ON calificaciones.id_logro = logros.id) 
						INNER JOIN docentes ON calificaciones.id_docente = docentes.id) 
						INNER JOIN materia ON calificaciones.id_materia = materia.id) 
						INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno 
						AND	 matricula.grado =".$grado."
						WHERE (calificaciones.id_alumno=" .$id_n. "
						AND materia.id_a =".$id_a."
						AND materia.id =".$id_m.						
						")";
						
						$q6x = mysql_query($q6, $link) or die('Consulta fallida q3: ' . mysql_error());;
					
						while($dato5 = mysql_fetch_array($q6x)) {
							
							$materia = $dato5['materia'];
							$nota = $dato5['nota'];
							
							if($nota > 4.7) {$valor = "Superior";}	
							else {
								if($nota > 4.0) {$valor = "Alto";}
								else {
									if($nota > 2.9) {$valor = "B&aacute;sico";}
									else {$valor = "Bajo";}}}
									
							/*
							echo "<tr><td td colspan='1', width = '1%'><font size = 2>".$materia."</font></font></td>";	//se escribe el nombre de la materia
							echo "<td colspan='1', width = '5%'><font size = 2> Nota: <b>".$nota."</b></td>";							
							echo "<td colspan='1', width = '10%'><font size = 2> Nivel de desempe&ntilde;o: <b>".$valor."</b></font></td>";
							echo "<td colspan='1', width = '20%'><font size = 2> Docente: ".$dato5['nombres']." ".$dato5['apellidos']."</font></td></tr>\n";
							//echo "<tr><td colspan='2' >&nbsp;</td> </tr>\n";	
							*/							
							//
							
					
							$q7 = "SELECT  logros.logro
							FROM ((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id) 
							INNER JOIN logros ON calificaciones.id_logro = logros.id) 
							INNER JOIN docentes ON calificaciones.id_docente = docentes.id) 
							INNER JOIN materia ON calificaciones.id_materia = materia.id) 
							INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno 
							AND	 matricula.grado =".$grado."
							WHERE (calificaciones.id_alumno=" .$id_n. "
							AND materia.id_a =".$id_a."
							AND materia.id =".$id_m.						
							")";
						
					
					
							$q7x = mysql_query($q7, $link) or die('Consulta fallida q3: ' . mysql_error());;
					
					
					
							while($dato6 = mysql_fetch_array($q7x)) {
						
								
								//echo "<tr><td colspan='4', width = '100%' ><font size = 2>".$dato6['logro']."</font></td></tr>\n";
						
						
							}	
							
							
					}		
	
				}
			
			//echo "</td></tr></table>";			
				
			}
				/*
				
				echo "<tr><td colspan='2', width = '100%', height=4>&nbsp;</td> </tr>\n";
				echo 	"<tr><td colspan='2', width = '100%'>0BSERVARCIONES</td></tr>"; 				
				echo 	"<tr><td colspan='2', width = '100%', align='center' >_________________________________________________________________________________________</td></tr>";
				echo 	"<tr><td colspan='2', width = '100%',  align='center' >_________________________________________________________________________________________</td></tr>";
				echo 	"<tr><td colspan='2', width = '100%', align='center' >_________________________________________________________________________________________</td></tr>";
				echo 	"<tr><td colspan='2', width = '100%', align='center' >_________________________________________________________________________________________</td></tr>";
				echo "<tr><td colspan='2', width = '100%', height=8>&nbsp;</td> </tr>\n";
				echo "<tr><td colspan='2', width = '100%', height=8>&nbsp;</td> </tr>\n";
				echo 	"<tr><td  width = '50%', align='center'>_________________________</td><td colspan='2', width = '50%', align='center' >_________________________</td></td>";
				echo 	"<tr><td  width = '50%', align='center' >Docente</td><td colspan='2', width = '50%', align='center' >Director</td></tr>";
				echo "<tr><td colspan='2', width = '100%', height=8>&nbsp;</td> </tr>\n";
				*/
			}
			
		}
			
	unset($q1);
	unset($q2);
	unset($q3);
	unset($q4);
	unset($q5);
	unset($q6);
	unset($q7);
	unset($xq1);
	unset($xq2);
	unset($xq3);
	unset($xq4);
	unset($xq5);
	unset($xq6);
	unset($xq7);
	unset($grado);
	unset($periodo);
	unset($nota);
	unset($valor);
	unset($dato1);
	unset($dato2);
	unset($dato3);
	unset($dato4);
	unset($dato5);
	unset($dato6);
	unset($dato7);
	unset($id_n);
	unset($id_m);
	unset($nombres);
	unset($apellidos);

$pdf->Output();
	?>
	



