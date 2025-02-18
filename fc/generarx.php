<?php
        // se inserta este fichero para generar el documento en pdf

	require('../fpdf/fpdf.php');
        require_once 'conexion.php';
	// se crean las siguientes variables
	// con obtenida a travez del formulario formulario_boletines

	$fecha = $_GET["year"];				// carga el valor  en la variable fecha
	$periodo = $_GET["periodos"];
	$gradox = $_GET["id_gs"]; // guarda el codigo del grado  en la variable $gradox

	//echo "fecha : $fecha <br>";

	// define el tipo de codificación para la letra
	header("Content-Type: text/html;charset=utf-8");
	// CONEXION CON LA BASE DE DATOS

	$link = conectar();


	//mysqli_query($link, "SET NAMES 'utf8'");


	// Se establece el tipo de cabecera  que tendra el documento
	class PDF extends FPDF

	{
   	//Cabecera de página
   	function Header()
   	{
			// se incerta el logo de la insticución
       	$this->Image('../imagenes/logo_boletin.png',17,12.5,60,25);
			$this->Cell(90,30,"",1);
			$this->SetFont('Arial','',16);
			// Se crea una etiqueta con el logo de la institución
			$this->MultiCell(90,15,utf8_decode("BOLETIN DE CALIFICACIONES \n PERIODO ".$_GET["periodos"]),1,'C');

   	}



   	//Pie de página
   	function Footer()
   	{
    	//Posición: a 1,5 cm del final
    	$this->SetY(-15);
    	//Arial italic 8
    	$this->SetFont('Arial','',8);
    	//Número de página
			$txt = utf8_decode("Otros servicios: Programas Técnicos , Cursos cortos y Programas tecnológicos (Convenio con Tecnológica Autónoma del Pacífico)");
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


	$grado = $gradox;

	$qg = "SELECT * FROM grados WHERE id_grado =".$gradox;

	$qgx = mysqli_query($link, $qg) or die('Consulta fallida grados (qg): ' . mysqli_error($link));

	while($datog = mysqli_fetch_array($qgx)) { //extrae los datos de la consulta q3x en la variable tipo arrelo dato


			// VARIABLES PARA GUARDAR LOS NOMBRES DE LOS ESTUDIANTES

			$nivel = $datog['grado'];

	}


		$q3 = "SELECT DISTINCT  alumnos.id_alumno, alumnos.nombres, alumnos.apellidos
		FROM ((((calificaciones_$fecha INNER JOIN alumnos ON calificaciones_$fecha.id_alumno = alumnos.id_alumno)
		INNER JOIN logros ON calificaciones_$fecha.id_logro = logros.id_logro)
		INNER JOIN docentes ON calificaciones_$fecha.id_docente = docentes.id_docente)
		INNER JOIN materia ON calificaciones_$fecha.id_materia = materia.id_materia)
		INNER JOIN matricula ON (calificaciones_$fecha.id_alumno = matricula.id_alumno AND matricula.id_grado = $gradox AND matricula.year = $fecha )
		WHERE calificaciones_$fecha.year = $fecha
		AND calificaciones_$fecha.periodo = $periodo";
		//
		// echo "consulta nombres :".$q3." <br>";

		$q3x = mysqli_query($link, $q3) or die('Consulta fallida alumnos (q3): ' . mysqli_error($link));;

		//
		//	ENCABEZADO DE NOMBRE
		//

		// CICLO DE REPETICION PARA EXPLORAR LOS ESTUDIANTES


		while($dato2 = mysqli_fetch_array($q3x)) { //extrae los datos de la consulta q3x en la variable tipo arrelo dato


			// VARIABLES PARA GUARDAR LOS NOMBRES DE LOS ESTUDIANTES

			$id_n = "".$dato2['id_alumno']."";		// guarda en grado el string del grado  rodeado por comillas simples
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
			$pdf->Cell(20,5,utf8_decode($dato2['id_alumno']),1,0,'C');
			$pdf->Cell(80,5,utf8_decode($nombres." ".$apellidos),1,0,'C');
			$pdf->Cell(25,5,$nivel,1,0,'C');
			$pdf->Cell(25,5,utf8_decode('Mañana'),1,0,'C');
			$pdf->Cell(30,5,utf8_decode($fecha),1,0,'C');
			$pdf->Ln(15);

			// CONSULTA PARA DETERMINAR LA CANTIDAD DE MATERIAS VISTAS POR LOS ESTUDIANTES
			//

			$q5 = "SELECT  DISTINCT materia.id_materia, materia.materia
			FROM ((((calificaciones_$fecha INNER JOIN alumnos ON calificaciones_$fecha.id_alumno = alumnos.id_alumno)
			INNER JOIN logros ON calificaciones_$fecha.id_logro = logros.id_logro)
			INNER JOIN docentes ON calificaciones_$fecha.id_docente = docentes.id_docente)
			INNER JOIN materia ON calificaciones_$fecha.id_materia = materia.id_materia)
			INNER JOIN matricula ON calificaciones_$fecha.id_alumno = matricula.id_alumno
			AND matricula.id_grado =".$gradox."
			WHERE calificaciones_$fecha.id_alumno=" .$id_n. "
			AND calificaciones_$fecha.year =".$fecha."
			AND calificaciones_$fecha.periodo =".$periodo.
			" ORDER BY materia.materia"
			;

			//echo $q5;

			$q5x = mysqli_query($link, $q5 ) or die('Consulta fallida q3: ' . mysqli_error($link));;

			$nota = 	"";

			while($dato4 = mysqli_fetch_array($q5x)) {

				$id_m = $dato4['id_materia'];

				$q6 = "SELECT  DISTINCT materia.logo,materia.id_materia, materia.materia, calificaciones_$fecha.nota, docentes.nombres, docentes.apellidos, calificaciones_$fecha.faltas
				FROM ((((calificaciones_$fecha INNER JOIN alumnos ON calificaciones_$fecha.id_alumno = alumnos.id_alumno)
				INNER JOIN logros ON calificaciones_$fecha.id_logro = logros.id_logro)
				INNER JOIN docentes ON calificaciones_$fecha.id_docente = docentes.id_docente)
				INNER JOIN materia ON calificaciones_$fecha.id_materia = materia.id_materia)
				INNER JOIN matricula ON calificaciones_$fecha.id_alumno = matricula.id_alumno
				AND	 matricula.id_grado =".$gradox."
				WHERE (calificaciones_$fecha.id_alumno=" .$id_n. "
				AND calificaciones_$fecha.year =".$fecha."
				AND calificaciones_$fecha.periodo =".$periodo."
				AND materia.id_materia =".$id_m.
				")";

				//echo  $q6;

				$q6x = mysqli_query($link, $q6) or die('Consulta fallida q6: ' . mysqli_error($link));;



					while($dato5 = mysqli_fetch_array($q6x)) {

						$materia = $dato5['materia'];
						$faltas =$dato5['faltas'];
						$logo =$dato5['logo'];

						

							$pdf->SetFont('Arial','B',12);
							$pdf->Cell(70,7,$materia,1,0,'L');
							$pdf->Cell(60,7,utf8_decode("Prof:".$dato5['nombres']." ".$dato5['apellidos']),1,0,'L');
							$pdf->Cell(50,7,utf8_decode("Faltas: ".$faltas),1,0,'L');
							$pdf->Ln(7);

							$q7 = "SELECT  logros.logro, calificaciones_$fecha.nota
							FROM ((((calificaciones_$fecha INNER JOIN alumnos ON calificaciones_$fecha.id_alumno = alumnos.id_alumno)
							INNER JOIN logros ON calificaciones_$fecha.id_logro = logros.id_logro)
							INNER JOIN docentes ON calificaciones_$fecha.id_docente = docentes.id_docente)
							INNER JOIN materia ON calificaciones_$fecha.id_materia = materia.id_materia)
							INNER JOIN matricula ON calificaciones_$fecha.id_alumno = matricula.id_alumno
							AND	 matricula.id_grado =".$gradox."
							WHERE (calificaciones_$fecha.id_alumno=" .$id_n."
							AND materia.id_materia =".$id_m."
							AND calificaciones_$fecha.year =".$fecha."
							AND calificaciones_$fecha.periodo =".$periodo."
							)";

							

							$q7x = mysqli_query($link, $q7) or die('Consulta fallida q3: ' . mysqli_error($link));;


								$x1=$pdf->GetX();
								$y1=$pdf->GetY();
								// Crea un cuadro de texto para la dimension indicada
								$pdf->Cell(70,45,"",1,0,'L');
								
								if ($logo != "") { 
								// se crea una imagen para la dimencin indicada
								$pdf->Image('../imagenes/'.$logo,$x1+2,$y1+2,66,41);
								}

								// variable para incertar texto en el multicell
								$texto = "";
								$x2=$pdf->GetX();
								$y2=$pdf->GetY();
								$pdf->Cell(110,45,"",1,0,'L');
								$pdf->SetXY($x2,$y2);

							while($dato6 = mysqli_fetch_array($q7x)) {

								$texto = $texto."ID:  ".$dato6['logro']."\n";


								if($id_m == '20') {
								$nota = 	$dato6['nota'];

								}
							}
							$pdf->SetFont('Arial','',9);
							$pdf->MultiCell(110,6, $texto,0,'L',false);
							$pdf->SetXY($x2,$y2);
							$pdf->Ln(45);

					}

				}
				
				$pdf->SetFont('Arial','B',12,true);
				$pdf->Cell(70,10,utf8_decode('Valoración del Comportamiento'),1,0,'L');
				
				$pdf->Cell(110,10,$nota,1,0,'C');



			//}


			// OBSERVACIONES DEL ESTUDIANTE

			$pdf->Ln(15);
			$pdf->Cell(180,5,utf8_decode("Observaciones : "),0,0,'L');

			$pdf->Ln(5);
			$pdf->Cell(180,5,utf8_decode("__________________________________________________________________________"),0,0,'L');
			$pdf->Ln(5);
			$pdf->Cell(180,5,utf8_decode("__________________________________________________________________________"),0,0,'L');
			$pdf->Ln(5);
			$pdf->Cell(180,5,utf8_decode("__________________________________________________________________________"),0,0,'L');
			$pdf->Ln(5);
			$pdf->Cell(180,5,utf8_decode("__________________________________________________________________________"),0,0,'L');
			$pdf->Ln(5);
			$pdf->Cell(180,5,utf8_decode("__________________________________________________________________________"),0,0,'L');
			$pdf->Cell(180,20,'',0,0,'L');
			$pdf->Ln(25);
			$pdf->Cell(180,5,utf8_decode("    ________________________          _________________________"),0,0,'C');
			$pdf->Ln(5);
			$pdf->Cell(180,5,utf8_decode("           Rectora                                       Directora de Grupo"),0,0,'C');

			}

		//} // cierra dato 1 de los grados



$pdf->Output();

desconectar($link);


?>
