<?php
	// se inserta este fichero para generar el documento en pdf
	require('../fpdf/fpdf.php');
        require_once 'conexion.php';
	// se crean las siguientes variables
	// con obtenida a travez del formulario formulario_boletines
	
	$fecha = $_GET["year"];				// carga el valor  en la variable fecha
	$periodo = $_GET["periodos"];
	$grado = $_GET["id_gs"];
	
	
	
	// define el tipo de codificación para la letra
	header("Content-Type: text/html;charset=utf-8");
	// CONEXION CON LA BASE DE DATOS
	$link_pdf = conectar();
	mysql_query("SET NAMES 'utf8'");

	
	// Se establece el tipo de cabecera  que tendra el documento
	class PDF extends FPDF

	{
   	//Cabecera de página
   	function Header()
   	{
            
            // se incerta el logo de la insticución
            $this->Image('../imagenes/logo_colegio.png',20,15,70,16);
            $this->Cell(90,30,"",1);
            $this->SetFont('Arial','',16); 
            // Se crea una etiqueta con el logo de la institución
            $this->MultiCell(90,15,utf8_decode("BOLETIN DE CALIFICACIONES \n PERIODO ".$_GET["periodos"]),1,'C');
			
   	}
   	
   	  
   	//Pie de pagina
   	function Footer()
   	{
           
    	//Posición: a 1,5 cm del final
    	$this->SetY(-15);
    	//Arial italic 8
    	$this->SetFont('Arial','',8);
    	//Número de página
		$txt = utf8_decode("Otros servicios: Programas Tecnicos , Cursos cortos y Programas tecnologicos (Convenio con Tecnologica Autonoma del Pacífico)");
    	$this->Cell(0,5,$txt,0,0,'C');
    	$this->Ln(3);
   		$txt = utf8_decode("Info: Tel 829 5741, Cel.3166288374, WhatsApp. 3164469532, Email:imcreativo@hotmail.com,  www.imcreativo.edu.co ");
    	$this->Cell(0,5,$txt,0,0,'C');
		//$this->Ln(1);	    
    	//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
                
   	}
   
   
		  
   
	}
	
	// se crea un nuevo documento de PDF
	$pdf=new PDF();
	
	
	
	$qg = "SELECT * FROM grados WHERE id =".$grado;
	
	$qgx = mysql_query($qg, $link_pdf) or die('Consulta fallida qg: ' . mysql_error());
	
        // Recupero los datos del grado $grado
	$datog = mysql_fetch_array($qgx);
        // Recupero el nombre del grado
        $nivel = $datog['grado'];
        
        
	
						
		$q3 = "SELECT DISTINCT  alumnos.id, alumnos.nombres, alumnos.apellidos  
		FROM ((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id) 
		INNER JOIN logros ON calificaciones.id_logro = logros.id) 
		INNER JOIN docentes ON calificaciones.id_docente = docentes.id) 
		INNER JOIN materia ON calificaciones.id_materia = materia.id) 
		INNER JOIN matricula ON (calificaciones.id_alumno = matricula.id_alumno AND matricula.grado =".$grado." AND matricula.year = ".$fecha.")
		
		ORDER BY alumnos.id"; 
                //WHERE calificaciones.year =".$fecha."
		//AND calificaciones.periodo =".$periodo."
		$q3x = mysql_query($q3, $link_pdf) or die('Consulta fallida q3: ' . mysql_error());
               
		//
		//	ENCABEZADO DE NOMBRE
		//
				
		// CICLO DE REPETICION PARA EXPLORAR LOS ESTUDIANTES
			
	 
		while($dato2 = mysql_fetch_array($q3x)) { //extrae los datos de la consulta q3x en la variable tipo arrelo dato
		
							
			// VARIABLES PARA GUARDAR LOS NOMBRES DE LOS ESTUDIANTES
				
			$id_n = "".$dato2['id']."";		// guarda en grado el string del grado  rodeado por comillas simples
			$nombres = $dato2['nombres'];
			$apellidos = $dato2['apellidos'];
		
		
			// ENCABEZADO DE CELDAS	//////////////////////////////
		
			$pdf->AddPage();
			$pdf->Ln(5);
			$pdf->SetFillColor(172, 172, 172);
			$pdf->SetFont('Arial','B',10,true);
			$pdf->Cell(20,5,utf8_decode('No'),1,0,'C',true);
			$pdf->Cell(80,5,utf8_decode('NOMBRE DEL ESTUDIANTE'),1,0,'C',true);
			$pdf->Cell(25,5,utf8_decode('GRADO'),1,0,'C',true);
			$pdf->Cell(25,5,utf8_decode('JORNADA'),1,0,'C',true);
			$pdf->Cell(30,5,utf8_decode('AÑO LECTIVO'),1,0,'C',true);
			$pdf->Ln();
			$pdf->Cell(20,5,utf8_decode($dato2['id']),1,0,'C');
			$pdf->Cell(80,5,utf8_decode($nombres." ".$apellidos),1,0,'C');
			$pdf->Cell(25,5,utf8_decode($nivel),1,0,'C');
			$pdf->Cell(25,5,utf8_decode('Mañana'),1,0,'C');
			$pdf->Cell(30,5,utf8_decode($fecha),1,0,'C');
			$pdf->Ln(7);
		
			// xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
		
			// encabezado para la tabla resumen
			// 
			$pdf->Ln(3);
			$pdf->SetFillColor(230, 230, 230);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(50,5,utf8_decode('Aréa'),1,0,'C',true);
			$pdf->Cell(50,5,utf8_decode('Materia'),1,0,'C',true);
			$pdf->Cell(15,5,utf8_decode('Periodo 1'),1,0,'C',true);
			$pdf->Cell(15,5,utf8_decode('Periodo 2'),1,0,'C',true);
			$pdf->Cell(15,5,utf8_decode('Periodo 3'),1,0,'C',true);
			$pdf->Cell(15,5,utf8_decode('Periodo 4'),1,0,'C',true);
			$pdf->Cell(20,5,utf8_decode('Acumulado'),1,0,'C',true);
			
			
			// estructura  que filtra el área de notificación con fin de estructurar 
			// la tabla de  contenidos 
		
			$q4 = "SELECT  DISTINCT materia.id_a, materia.area
				FROM ((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id) 
				INNER JOIN logros ON calificaciones.id_logro = logros.id) 
				INNER JOIN docentes ON calificaciones.id_docente = docentes.id) 
				INNER JOIN materia ON calificaciones.id_materia = materia.id) 
				INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno 
				AND matricula.grado =".$grado."
				WHERE calificaciones.id_alumno=" .$id_n."
				AND calificaciones.year =".$fecha."
				AND calificaciones.periodo =".$periodo."
				ORDER BY materia.id_a";
			
			
			
			
			// ejecucion de la consulta para obtener las areas de competencia evaluadas por el estudiante
		
			$q4x = mysql_query($q4, $link_pdf) or die('Consulta fallida q4: ' . mysql_error());;
		
			// CICLO DE REPETICION DE AREA
		
			$avg = 0;		
			$num_m = 0;
		
		
			while($dato3 = mysql_fetch_array($q4x)) {
		
				$area = $dato3['area'];
				$id_a = $dato3['id_a'];
			
				// ENCABEZADO DE AREA
				/////////////////////////////////////////////
				// consulta para estructurar las materias que pertenecen a cada área
			
				$q5 = "SELECT  DISTINCT materia.id, materia.materia
				FROM ((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id) 
				INNER JOIN logros ON calificaciones.id_logro = logros.id) 
				INNER JOIN docentes ON calificaciones.id_docente = docentes.id) 
				INNER JOIN materia ON calificaciones.id_materia = materia.id) 
				INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno 
				AND matricula.grado =".$grado."
				WHERE calificaciones.id_alumno=" .$id_n. "
				AND materia.id_a =".$id_a."
				AND calificaciones.year =".$fecha."
				AND calificaciones.periodo =".$periodo."
				ORDER BY materia.id_a, materia.id"
				;
				// ejecucion de la consulta para investigar  por las materias relacionadas con el area
					
				$q5x = mysql_query($q5, $link_pdf) or die('Consulta fallida q5: ' . mysql_error());;
			
				// ciclo de repeticion de materias se repite  de acuerdo a cuantas materias tiene cada area		
			
			
				
				while($dato4 = mysql_fetch_array($q5x)) {
				
					// recupera el id de la materia en la variable id_m
					
					$id_m = $dato4['id'];
				
				
					// A partir de aqui se construyen las consultas para  extraer las notas  de cada periodo
					// en las variables $p1 ... $p2
					// inicializamos los acumuladores
					$p1 = 0;
					$p2 = 0;
					$p3 = 0;
					$p4 = 0;
					
					for($i = 1;$i < 5;$i++) {
						
						// consulta que selecciona una materia especifica para cuatro periodos
							
						$q6 = "SELECT  DISTINCT materia.id, materia.materia, calificaciones.nota, docentes.nombres, docentes.apellidos
						FROM ((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id) 
						INNER JOIN logros ON calificaciones.id_logro = logros.id) 
						INNER JOIN docentes ON calificaciones.id_docente = docentes.id) 
						INNER JOIN materia ON calificaciones.id_materia = materia.id) 
						INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno 
						AND	 matricula.grado =".$grado."
						WHERE calificaciones.id_alumno=" .$id_n. "
						AND materia.id =".$id_m."
						AND calificaciones.year ='".$fecha."'
						AND calificaciones.periodo =".$i."
						ORDER BY materia.id_a, materia.id";
						//AND calificaciones.periodo =".$periodo
						//;
						
						$q6x = mysql_query($q6, $link_pdf) or die('Consulta fallida q6: ' . mysql_error());;
					
			
						while($dato5 = mysql_fetch_array($q6x)) {
							
							$materia = $dato5['materia'];// recupera el dato de la materia para el periodo i
							$nota = $dato5['nota'];// recupero la nota de la materia para el periodo i
						
						
						
							switch ($i) {	// la nota se guarde en $p1, $p2 .. $p4
						
								case 1: // si esta en el periodo 1
									$p1 = $nota;
								break;
								case 2: // si esta en el periodo 2
									$p2 = $nota;
								break;
								case 3: // si esta en el periodo 3
									$p3 = $nota;
								break;
								case 4: // si esta en el periodo 4
									$p4 = $nota;
								break;
								}
						
						
							if($periodo == $i) {	// si periodo  es el actual
							
								switch ($periodo) {	// lo almaceno en $p
						
									case 1:
										$p = $p1;
										break;
									case 2:
										$p = $p2;
										break;
									case 3:
										$p = $p3;
										break;
									case 4:
										$p = $p4;
										break;
								}	// fin del cilco switch
						
						
							}		// fin del ciclo if
										
							
							
						
												
						}	// fin del ciclo while
						
				}		// fin del ciclo for de periodo	
						$avg = $avg + $p;	// sumatoria de notas
						
						$ac = ($p1+$p2+$p3+$p4)/4;
						$p1 = number_format($p1, 1, '.', '');
						$p2 = number_format($p2, 1, '.', '');
						$p3 = number_format($p3, 1, '.', '');
						$p4 = number_format($p4, 1, '.', '');
						$ac = number_format($ac, 1, '.', '');
						
						if($p1 == 0.0){$p1 = "";}
						if($p2 == 0.0){$p2 = "";}
						if($p3 == 0.0){$p3 = "";}
						if($p4 == 0.0){$p4 = "";}
						
						$pdf->SetFont('Arial','B',9);
						$pdf->Ln(5);
						$pdf->Cell(50,5,utf8_decode($area),1,0,'L');
						$pdf->Cell(50,5,utf8_decode($materia),1,0,'L');
						
						// esta rutina coloca los colores a las celdas
						// para el primer periodo
						
							
						if($p1<3 and $p1>0.1) {
							$pdf->SetFillColor(255, 0, 0);}// pintar de rojo
						else {	$pdf->SetFillColor(255, 255, 255);}
							
						$pdf->Cell(15,5,utf8_decode($p1),1,0,'C',true);// imprime el primer periodo
						
						// pinta de rojo  la celda del segundo periodo si la nota es baja
						if($p2<3 and $p2 >0.1 and $periodo > 1) {
							$pdf->SetFillColor(255, 0, 0);}// pintar de rojo
						else {	$pdf->SetFillColor(255, 255, 255);}
						
						// coloca la nota del segundo periodo  a partir del mismo
						if($periodo > 1) {						
						$pdf->Cell(15,5,utf8_decode($p2),1,0,'C',true);}
												
						else {
						$pdf->Cell(15,5,'',1,0,'C',true);}
						
						// pinta de rojo  la celda del tercer periodo si la nota es baja
						if($p3<3 and $p3 >0.1  and $periodo > 2) {
							$pdf->SetFillColor(255, 0, 0);}// pintar de rojo
						else {	$pdf->SetFillColor(255, 255, 255);}

						// coloca la nota del tercer periodo  a partir del mismo
						if($periodo > 2) {						
						$pdf->Cell(15,5,utf8_decode($p3),1,0,'C',true);}
						else {
						$pdf->Cell(15,5,'',1,0,'C',true);}
						
						
						// pinta de rojo  la celda del tercer periodo si la nota es baja
						if($p4<3 and $p3>0.1 and $periodo > 3) {
							$pdf->SetFillColor(255, 0, 0);}// pintar de rojo
						else {	$pdf->SetFillColor(255, 255, 255);}
						
						// coloca la nota del cuarto  periodo  a partir del mismo
						if($periodo > 3) {						
						$pdf->Cell(15,5,utf8_decode($p4),1,0,'C',true);}
						else {
						$pdf->Cell(15,5,'',1,0,'C',true);}
						
						$pdf->Cell(20,5,utf8_decode($ac),1,0,'C',false);
						
						$num_m = $num_m +1;
					} // cierra dato 4
					
				
				
			} 			// cierra  ciclo while de dato  3
			
			
			$avg = number_format($avg /$num_m, 1, '.', '');
			
					
			$pdf->Ln(5);
			$pdf->Cell(50,5,utf8_decode("Promedio: ".$avg),1,0,'L');
			$pdf->Cell(50,5,utf8_decode("Materias: ".$num_m),1,0,'L');
			$pdf->Ln(9);
		
		
		
		
		//  xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx		
		//		FICHA DE DESCRIPCION DE LOGROS
		//////////////////////////////////////////////////////
		/// CONSULTA POR AREA ///////////////////////////////
			
	 	$q7 = "SELECT  DISTINCT materia.id_a, materia.area
				FROM ((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id) 
				INNER JOIN logros ON calificaciones.id_logro = logros.id) 
				INNER JOIN docentes ON calificaciones.id_docente = docentes.id) 
				INNER JOIN materia ON calificaciones.id_materia = materia.id) 
				INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno 
				AND matricula.grado =".$grado."
				WHERE calificaciones.id_alumno=" .$id_n."
				AND calificaciones.year =".$fecha."
				AND calificaciones.periodo =".$periodo."
				ORDER BY materia.id_a, materia.id"
				;
				
		$q7x = mysql_query($q7, $link_pdf) or die('Consulta fallida q7: ' . mysql_error());;
		/// CICLO DE REPETICION DE AREA
		
			
		
		while($dato7 = mysql_fetch_array($q7x)) {
		
			$area = $dato7['area'];
			$id_a = $dato7['id_a'];
			
			// ENCABEZADO DE AREA
			/////////////////////////////////////////////
						
			//$pdf->Ln(4);
			$pdf->SetFillColor(230, 230, 230);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(180,4,utf8_decode('Aréa : '.$area),1,0,'L',true);
			$pdf->Ln(4);
			
			$q8 = "SELECT  DISTINCT materia.id, materia.materia
			FROM ((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id) 
			INNER JOIN logros ON calificaciones.id_logro = logros.id) 
			INNER JOIN docentes ON calificaciones.id_docente = docentes.id) 
			INNER JOIN materia ON calificaciones.id_materia = materia.id) 
			INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno 
			AND matricula.grado =".$grado."
			WHERE calificaciones.id_alumno=" .$id_n. "
			AND materia.id_a =".$id_a."
			AND calificaciones.year =".$fecha."
			AND calificaciones.periodo =".$periodo."
			ORDER BY materia.id_a, materia.id"
			;
					
			$q8x = mysql_query($q8, $link_pdf) or die('Consulta fallida q8: ' . mysql_error());;
			
						
				
			while($dato8 = mysql_fetch_array($q8x)) {
					
				$id_m = $dato8['id'];
				// En esta consulta se generan consulta alrededor  de materias 
				// para los encabezado  de las materias
				// 
				
				$q9 = "SELECT  DISTINCT materia.id, materia.materia, calificaciones.nota, docentes.nombres, docentes.apellidos, calificaciones.faltas
				FROM ((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id) 
				INNER JOIN logros ON calificaciones.id_logro = logros.id) 
				INNER JOIN docentes ON calificaciones.id_docente = docentes.id) 
				INNER JOIN materia ON calificaciones.id_materia = materia.id) 
				INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno 
				AND	 matricula.grado =".$grado."
				WHERE (calificaciones.id_alumno=" .$id_n. "
				AND calificaciones.year =".$fecha."
				AND calificaciones.periodo =".$periodo."
				AND materia.id =".$id_m.						
				")	ORDER BY materia.id_a, materia.id";
						
				$q9x = mysql_query($q9, $link_pdf) or die('Consulta fallida q9: ' . mysql_error());;
					
									
					
					while($dato9 = mysql_fetch_array($q9x)) {
							
						$materia = $dato9['materia'];
						$nota = $dato9['nota'];
						$faltas =$dato9['faltas'];
						
						if($nota > 4.6) {$valor = "Superior";}	
							else {
							if($nota > 4.0) {$valor = "Alto";}
								else {
									if($nota > 2.9) {$valor = "Básico";}
										else {$valor = "Bajo";
										}
								}
							}	

							$nota = number_format($nota, 1, '.', '');
							//$pdf->Ln(4);
							$pdf->SetFont('Arial','B',10);
							$pdf->Cell(50,4,utf8_decode($materia),1,0,'L');
							$pdf->SetFont('Arial','B',9);
							$pdf->Cell(40,4,utf8_decode("Prof:".$dato9['nombres']." ".$dato9['apellidos']),1,0,'L');
							$pdf->Cell(20,4,utf8_decode("Faltas: ".$faltas),1,0,'L');
							$pdf->Cell(20,4,utf8_decode("Nota : ".$nota),1,0,'L');
							$pdf->Cell(50,4,utf8_decode("Nivel de desempeño : ".$valor),1,0,'L');
							
							
							// CONSULTA PARA ESTABLECER LOS LOGROS  MOSTRADOS EN PANTALLA
							
							// se filtran los logros de un  año determinado,  de un grado determinado, de un area determinada,  de una materia determinada
							// y de un alumno en particular
							
							$q10 = "SELECT  logros.logro
							FROM ((((calificaciones INNER JOIN alumnos ON calificaciones.id_alumno = alumnos.id) 
							INNER JOIN logros ON calificaciones.id_logro = logros.id) 
							INNER JOIN docentes ON calificaciones.id_docente = docentes.id) 
							INNER JOIN materia ON calificaciones.id_materia = materia.id) 
							INNER JOIN matricula ON calificaciones.id_alumno = matricula.id_alumno 
							WHERE (matricula.grado =".$grado."
							AND calificaciones.id_alumno=".$id_n."
							AND materia.id =".$id_m."
							AND calificaciones.year =".$fecha."
							AND calificaciones.periodo =".$periodo.")";
						
					
					
							$q10x = mysql_query($q10, $link_pdf) or die('Consulta fallida q10: ' . mysql_error());;
					
					
							$logros = "";
							while($dato10 = mysql_fetch_array($q10x)) {
								
								
								$logros = $logros.$dato10['logro']."\n";
																						
							}	
							$pdf->SetFont('Arial','',10);
							$pdf->Ln(4);
							$pdf->MultiCell(180,4, utf8_decode($logros),1,'L',false);
							
					}		
					
				}	// fin del ciclo de  materias
			
			
				
					
			} // fin del ciclo de repeticion para las areas
			
		
			// OBSERVACIONES DEL ESTUDIANTE			
			
			$pdf->Ln(15);
			$pdf->Cell(180,5,utf8_decode("Observaciones : "),0,0,'L');

			$pdf->Ln(5);
			$pdf->Cell(180,5,utf8_decode("__________________________________________________________________________________________________"),0,0,'L');
			$pdf->Ln(5);
			$pdf->Cell(180,5,utf8_decode("__________________________________________________________________________________________________"),0,0,'L');
			$pdf->Ln(5);
			$pdf->Cell(180,5,utf8_decode("__________________________________________________________________________________________________"),0,0,'L');
			$pdf->Ln(5);
			$pdf->Cell(180,5,utf8_decode("__________________________________________________________________________________________________"),0,0,'L');
			$pdf->Ln(5);
			$pdf->Cell(180,5,utf8_decode("__________________________________________________________________________________________________"),0,0,'L');
			
			$pdf->Ln(15);
			$pdf->Cell(180,5,utf8_decode("ESCALA DE VALORACIÓN:"),0,0,'L');
			$pdf->Ln(5);
			$pdf->Cell(180,5,utf8_decode("NIVEL SUPERIOR: 4.8 a 5.0\tNIVEL ALTO: 4.1 a 4.7"),0,0,'L');
			$pdf->Ln(5);
			$pdf->Cell(180,5,utf8_decode("NIVEL B�?SICO: 3.0 a 4.0\tNIVEL BAJO: 1.0 a 2.9"),0,0,'L');         

			$pdf->Cell(180,20,'',0,0,'L');
			$pdf->Ln(30);
			$pdf->Cell(180,5,utf8_decode("    ________________________          _________________________"),0,0,'C');
			$pdf->Ln(3);
			$pdf->Cell(180,5,utf8_decode("           Rectora                                       Directora de Grupo"),0,0,'C');
			
			}
			
		//} // cierra dato 1 de los grados
		
		
		
$pdf->Output();

desconectar($link_pdf);


?> 