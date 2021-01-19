<!DOCTYPE html>

<!-- esta pagina consulta la base de datos con los diferentes elementos que la componen -->
<html>
	
	<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Formulario</title>
	
	</head>

	<body      onload="habilitar();">
		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>	
			<noscript>
  				<p>Bienvenido a Mi Sitio</p>
  	
			</noscript>
	
			<?php	
				//conexion con la base de datos
				$link = 		mysql_connect('localhost', 'imcrea_admin', 'Caracter15');
				mysql_select_db('imcrea_boletines', $link);	
			?>			
			
			<script type="text/javascript" >
		
				function habilitar () {
		
					<!-- la variable x el valor de la caja desplegable actuar como insumo para indexar las acciones que correspondan a dicho item -->
		
				var x = document.getElementById('actuar').value;		
		
				<!-- sentencia que desplega la lista de opciones para  el campo x -->
		 
				switch(x) {
			
					<!-- FORMULARIO  CONSULTAR -->
					case "1":
			
						var y = document.getElementById('opcion').value;
			
						switch(y) {
				
							case "1":	// consultar estudiantes
								document.getElementById("estudiante").style.display='none';
								document.getElementById("id_g").style.display='block'; 		<!-- se oculta este campo -->
								document.getElementById("fecha_fin").style.display='none'; 	<!-- se oculta este campo -->
								document.getElementById("curso").style.display='none'; 		<!-- se oculta este campo -->
								document.getElementById("docente").style.display='none'; 	<!-- se oculta este campo -->
								document.getElementById("nombre").style.display='block'; 	<!-- muestra este campo -->
								document.getElementById("apellido").style.display='block'; 	<!-- muestra este campo -->
								document.getElementById("cargar").style.display='block'; 	<!-- muestra este campo -->
								document.getElementById("ano").style.display='block'; 		<!-- muestra este campo -->
								document.getElementById("grado").style.display='none'; 		<!-- muestra este campo -->
								document.getElementById("ingresar").style.display='none'; 	<!-- se oculta este campo -->
								document.getElementById("cedula").style.display='none'; 		<!-- se oculta este campo -->		
								document.getElementById("area").style.display='none'; 		<!-- se oculta este campo -->
								document.getElementById("correo").style.display='none'; 		<!-- se oculta este campo -->
								document.getElementById("telefono").style.display='none'; 	<!-- se oculta este campo -->
								document.getElementById("fecha").style.display='none';					
								document.getElementById("materia").style.display='none';
								document.getElementById("Logro").style.display='none';
								document.getElementById("id_m").style.display='none';
								document.getElementById("id_a").style.display='none';
								document.getElementById("periodo").style.display='none';
								document.getElementById("generar").style.display='none';
								document.getElementById("generarx").style.display='none';
							break;
					 
							case "2":
				
								document.getElementById("estudiante").style.display='none';
								document.getElementById("id_g").style.display='none';
								document.getElementById("fecha_fin").style.display='none';
								document.getElementById("curso").style.display='none';
								document.getElementById("docente").style.display='none';
								document.getElementById("ingresar").style.display='none';
								document.getElementById("cedula").style.display='none'; 			
								document.getElementById("area").style.display='none';
								document.getElementById("correo").style.display='none';
								document.getElementById("nombre").style.display='block'; 
								document.getElementById("apellido").style.display='block';
								document.getElementById("telefono").style.display='none';
								document.getElementById("fecha").style.display='none';					
								document.getElementById("materia").style.display='none';
								document.getElementById("Logro").style.display='none';
								document.getElementById("id_m").style.display='none';
								document.getElementById("id_a").style.display='none';
								document.getElementById("ano").style.display='none';
								document.getElementById("periodo").style.display='none';
								document.getElementById("grado").style.display='none';
								document.getElementById("generar").style.display='none';
								document.getElementById("generarx").style.display='none';
								document.getElementById("cargar").style.display='block';
					
							break;
				
								<!-- caso en donde consultar las materias existentes -->
				
							case "3":
					
								document.getElementById("estudiante").style.display='none';
								document.getElementById("id_g").style.display='none';
								document.getElementById("fecha_fin").style.display='none';
								document.getElementById("curso").style.display='none';
								document.getElementById("docente").style.display='none';
								document.getElementById("ingresar").style.display='none';
								document.getElementById("cedula").style.display='none'; 			
								document.getElementById("area").style.display='none';
								document.getElementById("correo").style.display='none';
								document.getElementById("nombre").style.display='none'; 
								document.getElementById("apellido").style.display='none';
								document.getElementById("telefono").style.display='none';
								document.getElementById("fecha").style.display='none';					
								document.getElementById("materia").style.display='block';
								document.getElementById("Logro").style.display='none';
								document.getElementById("id_m").style.display='none';
								document.getElementById("id_a").style.display='none';
								document.getElementById("ano").style.display='none';
								document.getElementById("periodo").style.display='none';
								document.getElementById("grado").style.display='none';
								document.getElementById("generar").style.display='none';
								document.getElementById("generarx").style.display='none';
								document.getElementById("cargar").style.display='block';

							break;
								
								<!-- caso  de consultar areas -->
				
							case "4":
					
								document.getElementById("estudiante").style.display='none';
								document.getElementById("id_g").style.display='none';
								document.getElementById("fecha_fin").style.display='none';
								document.getElementById("curso").style.display='none';
								document.getElementById("docente").style.display='none';
								document.getElementById("ingresar").style.display='none';
								document.getElementById("cedula").style.display='none'; 			
								document.getElementById("area").style.display='none';
								document.getElementById("correo").style.display='none';
								document.getElementById("nombre").style.display='none'; 
								document.getElementById("apellido").style.display='none';
								document.getElementById("telefono").style.display='none';
								document.getElementById("fecha").style.display='none';					
								document.getElementById("materia").style.display='none';
								document.getElementById("Logro").style.display='none';
								document.getElementById("id_m").style.display='none';
								document.getElementById("id_a").style.display='none';
								document.getElementById("ano").style.display='none';
								document.getElementById("periodo").style.display='none';
								document.getElementById("grado").style.display='none';
								document.getElementById("generar").style.display='none';
								document.getElementById("generarx").style.display='none';
								document.getElementById("cargar").style.display='block';

							break;
				
							case "5":
					
								document.getElementById("estudiante").style.display='none';
								document.getElementById("id_g").style.display='none';
								document.getElementById("fecha_fin").style.display='none';
								document.getElementById("curso").style.display='none';
								document.getElementById("docente").style.display='none';
								document.getElementById("ingresar").style.display='none';
								document.getElementById("cedula").style.display='none'; 			
								document.getElementById("area").style.display='none';
								document.getElementById("correo").style.display='none';
								document.getElementById("nombre").style.display='none'; 
								document.getElementById("apellido").style.display='none';
								document.getElementById("telefono").style.display='none';
								document.getElementById("fecha").style.display='none';					
								document.getElementById("materia").style.display='none';
								document.getElementById("Logro").style.display='block';
								document.getElementById("id_m").style.display='none';
								document.getElementById("id_a").style.display='none';
								document.getElementById("ano").style.display='none';
								document.getElementById("periodo").style.display='none';
								document.getElementById("grado").style.display='none';
								document.getElementById("generar").style.display='none';
								document.getElementById("generarx").style.display='none';
								document.getElementById("cargar").style.display='block';

							break;

							case "6":	// en este caso se editan los boletines
					
								document.getElementById("estudiante").style.display='none';
								document.getElementById("id_g").style.display='block';
								document.getElementById("fecha_fin").style.display='none';
								document.getElementById("curso").style.display='none';
								document.getElementById("docente").style.display='none';
								document.getElementById("ingresar").style.display='none';
								document.getElementById("cedula").style.display='none'; 			
								document.getElementById("area").style.display='none';
								document.getElementById("correo").style.display='none';
								document.getElementById("nombre").style.display='none'; 
								document.getElementById("apellido").style.display='none';
								document.getElementById("telefono").style.display='none';
								document.getElementById("fecha").style.display='none';					
								document.getElementById("materia").style.display='none';
								document.getElementById("Logro").style.display='none';
								document.getElementById("id_m").style.display='none';
								document.getElementById("id_a").style.display='none';
								document.getElementById("ano").style.display='block';
								document.getElementById("periodo").style.display='block';
								document.getElementById("grado").style.display='none';
								document.getElementById("cargar").style.display='none';
								document.getElementById("generar").style.display='block';
								document.getElementById("generarx").style.display='block';

							break;
				
				
							case "9":
					
								document.getElementById("estudiante").style.display='none';
								document.getElementById("id_g").style.display='block';
								document.getElementById("fecha_fin").style.display='none';
								document.getElementById("curso").style.display='none';
								document.getElementById("docente").style.display='none';
								document.getElementById("ingresar").style.display='none';
								document.getElementById("cedula").style.display='none'; 			
								document.getElementById("area").style.display='none';
								document.getElementById("correo").style.display='none';
								document.getElementById("nombre").style.display='none'; 
								document.getElementById("apellido").style.display='none';
								document.getElementById("telefono").style.display='none';
								document.getElementById("fecha").style.display='none';					
								document.getElementById("materia").style.display='none';
								document.getElementById("Logro").style.display='none';
								document.getElementById("id_m").style.display='none';
								document.getElementById("id_a").style.display='none';
								document.getElementById("ano").style.display='none';
								document.getElementById("periodo").style.display='none';
								document.getElementById("grado").style.display='none';
								document.getElementById("cargar").style.display='block';
								document.getElementById("generar").style.display='none';
								document.getElementById("generarx").style.display='none';

							break;
						}		
				break;

				<!-- FORMULARIO DE ADICCIONAR -->
				case "2":
				
					var y = document.getElementById('opcion').value;
				
				
					switch(y) {
				
						case "1":	// adiccionar estudiantes
					
							document.getElementById("estudiante").style.display='none';
							document.getElementById("id_g").style.display='none';
							document.getElementById("fecha_fin").style.display='none';
							document.getElementById("curso").style.display='none';
							document.getElementById("docente").style.display='none';
							document.getElementById("ingresar").style.display='block';
							document.getElementById("nombre").style.display='block'; 
							document.getElementById("apellido").style.display='block';
							document.getElementById("telefono").style.display='block';
							document.getElementById("fecha").style.display='block';					
							document.getElementById("cedula").style.display='block'; 			
							document.getElementById("area").style.display='none';
							document.getElementById("correo").style.display='block';
							document.getElementById("materia").style.display='none';
							document.getElementById("Logro").style.display='none';
							document.getElementById("id_m").style.display='none';
							document.getElementById("id_a").style.display='none';
							document.getElementById("ano").style.display='none';
							document.getElementById("periodo").style.display='none';
							document.getElementById("grado").style.display='none';
							document.getElementById("generar").style.display='none';
							document.getElementById("generarx").style.display='none';
							document.getElementById("cargar").style.display='none';
					
						break;
				
						case "5":	// adiccionar logros
					
							document.getElementById("estudiante").style.display='none';
							document.getElementById("id_g").style.display='none';
							document.getElementById("fecha_fin").style.display='none';
							document.getElementById("curso").style.display='block';
							document.getElementById("docente").style.display='none';
							document.getElementById("ingresar").style.display='block';
							document.getElementById("nombre").style.display='none'; 
							document.getElementById("apellido").style.display='none';
							document.getElementById("telefono").style.display='none';
							document.getElementById("fecha").style.display='none';					
							document.getElementById("cedula").style.display='none'; 			
							document.getElementById("area").style.display='none';
							document.getElementById("correo").style.display='none';
							document.getElementById("materia").style.display='none';
							document.getElementById("Logro").style.display='block';
							document.getElementById("id_m").style.display='none';
							document.getElementById("id_a").style.display='none';
							document.getElementById("ano").style.display='none';
							document.getElementById("periodo").style.display='none';
							document.getElementById("grado").style.display='none';
							document.getElementById("generar").style.display='none';
							document.getElementById("generarx").style.display='none';
							document.getElementById("cargar").style.display='none';
					
						break;
										
						
						case "8":
					
							document.getElementById("estudiante").style.display='none';
							document.getElementById("id_g").style.display='block';
							document.getElementById("fecha_fin").style.display='block';
							document.getElementById("curso").style.display='block';
							document.getElementById("docente").style.display='block';
							document.getElementById("ingresar").style.display='block';
							document.getElementById("nombre").style.display='none'; 
							document.getElementById("apellido").style.display='none';
							document.getElementById("telefono").style.display='none';
							document.getElementById("fecha").style.display='none';					
							document.getElementById("cedula").style.display='none'; 			
							document.getElementById("area").style.display='none';
							document.getElementById("correo").style.display='none';
							document.getElementById("materia").style.display='none';
							document.getElementById("Logro").style.display='none';
							document.getElementById("id_m").style.display='none';
							document.getElementById("id_a").style.display='none';
							document.getElementById("ano").style.display='block';
							document.getElementById("periodo").style.display='none';
							document.getElementById("grado").style.display='none';
							document.getElementById("generar").style.display='none';
							document.getElementById("generarx").style.display='none';
							document.getElementById("cargar").style.display='none';				
				
						break;
				
						case "9":
					
							document.getElementById("estudiante").style.display='none';
							document.getElementById("id_g").style.display='block';
							document.getElementById("fecha_fin").style.display='none';
							document.getElementById("curso").style.display='block';
							document.getElementById("docente").style.display='none';
							document.getElementById("ingresar").style.display='block';
							document.getElementById("nombre").style.display='none'; 
							document.getElementById("apellido").style.display='none';
							document.getElementById("telefono").style.display='none';
							document.getElementById("fecha").style.display='none';					
							document.getElementById("cedula").style.display='none'; 			
							document.getElementById("area").style.display='none';
							document.getElementById("correo").style.display='none';
							document.getElementById("materia").style.display='none';
							document.getElementById("Logro").style.display='none';
							document.getElementById("id_m").style.display='none';
							document.getElementById("id_a").style.display='none';
							document.getElementById("ano").style.display='none';
							document.getElementById("periodo").style.display='none';
							document.getElementById("grado").style.display='none';
							document.getElementById("generar").style.display='none';
							document.getElementById("generarx").style.display='none';
							document.getElementById("cargar").style.display='none';				
				
						break;
				
						case "11":
				
				
							document.getElementById("estudiante").style.display='block';
							document.getElementById("id_g").style.display='block';
							document.getElementById("fecha_fin").style.display='none';
							document.getElementById("curso").style.display='none';
							document.getElementById("docente").style.display='none';
							document.getElementById("ingresar").style.display='none';
							document.getElementById("nombre").style.display='none'; 
							document.getElementById("apellido").style.display='none';
							document.getElementById("telefono").style.display='none';
							document.getElementById("fecha").style.display='none';					
							document.getElementById("cedula").style.display='none'; 			
							document.getElementById("area").style.display='none';
							document.getElementById("correo").style.display='none';
							document.getElementById("materia").style.display='none';
							document.getElementById("Logro").style.display='none';
							document.getElementById("id_m").style.display='none';
							document.getElementById("id_a").style.display='none';
							document.getElementById("ano").style.display='none';
							document.getElementById("periodo").style.display='none';
							document.getElementById("grado").style.display='none';
							document.getElementById("generar").style.display='none';
							document.getElementById("generarx").style.display='none';
							document.getElementById("cargar").style.display='none';				
				
						break;
				
						}
				break;

					<!-- FORMULARIO DE ELININAR -->						
				case "3":
			
				break;
			
					<!-- FORMULARIO DE EDITAR -->
				case "4":
			
				break;
				}	
				} 
	
			</script><!--  -->
	
			<script language="javascript">
				window.onload = habilitar(); 
			</script>
	
	
		
			<table align= 'center' width = '600' border="0">  <!-- se crea una tabla  -->
				<tr><!-- primera fila de la tabla -->
					<td colspan='4'>
						<h1> FORMULARIO PARA LA GESTION DE CALIFICACIONES</h1>
					</td>
				</tr>
		
				<tr>
					<td colspan='4'>Introduzca el  la acci&oacute;n requerida  del siguiente men&uacute;
					</td>
				</tr>	
					
				<!-- // se incerta un formulario para  adiccionar eliminar o editar  datos -->
				
				<form name = 'datos' id= 'datos' action='' method='post' target='_blank'>
			
					<tr>
						<td><!--  -->
							<select  style=" width:150px"  name='actuar' id='actuar' onchange="habilitar();">
								<option value='1'>Consultar</option>
								<option value='2'>Adiccionar</option>
								<option value='3'>Eliminar</option>
								<option value='4'>Editar</option>
							</select> 
						</td>
		
		
						<td>
							<select   style=" width:150px" name='opcion' id="opcion" onchange="habilitar();">
								<option value='1'>Estudiantes</option>
								<option value='2'>Docentes</option>
								<option value='3'>Materias</option>
								<option value='4'>&Aacute;reas</option>
								<option value='5'>Logros</option>
								<option value='6'>Boletin</option>
								<option value='7'>Matricula Alumnos</option>
								<option value='8'>Matricula Docentes</option>
								<option value='9'>Requisitos Materia</option>
								<option value='10'>Evalucion</option>
								<option value='11'>Nota</option>	<!-- Esta es la opcion permite configurar las notas realizadas -->
							</select>
						</td>
							<!-- botones para cargar formulario -->
						</tr>
						


						
											
						
						<tr align="center" valign="middle" ></tr>
						<tr>	
							<td width = "25%" bgcolor="#1E90FF"  style="height:30px;" >
							<input style="background-color: #1E90FF; width:150px;  border: #000 0px solid" type='submit' value='CARGAR' id="cargar" onclick="this.form.action='seleccion.php';this.form.submit();">
							</td><!-- boton creado para mostrar valores de busqueda --><
							<td width = "25%" bgcolor="#1E80FF"  style="height:30px;" >
							<input  style="background-color: #1E80FF; width:150px; border: #000 0px solid" type='submit' value='TIPO PRIMARIA' id="generar" onclick="this.form.action='generar.php';this.form.submit();">
							</td><!-- genera boletin  de primaria  -->
							<td width = "25%" bgcolor="#1E40FF"  style="height:30px;" >
							<input style="background-color: #1E40FF; width:160px; border: #000 0px solid" type='submit' value='TIPO PREESCOLAR' id="generarx" onclick="this.form.action='generarx.php';this.form.submit();">
							</td><!-- genera voletines con el modelo de preescolar -->
							<td width = "25%" bgcolor="#1E10FF"  style="height:30px;" >
							<input style="background-color: #1E10FF; width:150px;  border: #000 0px solid" type='submit' value='INGRESAR' id="ingresar" onclick="this.form.action='seleccion.php';this.form.submit();">
							</td><!-- se genera el formulario de ingreso -->						
							
						</tr>
						<tr></tr>
					</table>
					
					<table width = "600" align= 'center'>		<!-- segunda parte de la tabla -->			
					
					<tr id="docente" >
						<td  colspan="1" width="25%" >
							Docente: 
						</td>		
						<td colspan="3" width="75%">	
							<select name="docente" >
							<?php
										
								// se genera la consulta a la base de datos  con el fin de obtener los   valores que se han calificado.
								$q1 = "SELECT id,nombres, apellidos FROM docentes";
								// se ejecuta la consulta a la base de datos para obtener un resultado en la variable $q1x
								$q1x = mysql_query($q1, $link) or die('Consulta fallida q1: ' . mysql_error());;
						
								// explora los el arreglo que se obtuvo como resultado de la terminacion de la consulta.
								while($dato1 = mysql_fetch_array($q1x)) {
								// genera una salida por cada aÃ±o registrado en la consulta
								echo "<option value='".$dato1['id']."'>".$dato1['nombres']."  ".$dato1['apellidos']."</option>";						
									}							
							?>
							
							</select>
						</td>
					</tr><!-- se genera un campo   con el cual se ingresa o se busca el nombre del estudiante -->
					
					
						
					<tr id="nombre" > <!--  etiqueta para colocar la caja de texto donde se ubica el nombre -->
						<td  colspan="1" width="25%" >
							Nombre: 
						</td>		
						<td colspan="3" width="75%">	
							<input type="text"  name ='nombres'>
						</td> 
					</tr>
					<tr id="apellido"> <!-- se genera un campo insertar el apellido -->
						<td  colspan="1" width="25%">
							Apellido:
						</td>	
							<td colspan="3"  width="75%">	
								<input type='text' id="apellidos" name ='apellidos'>
							</td>
					</tr>
					
					
					<tr  id="estudiante" >  <!-- Se ingresa  un campo para seleccionar  un estudiante -->
						<td  colspan="1" width="25%" >
							Estudiante : 
						</td>	
							
						<td colspan="3" width="75%">	
							<select id="estudiante" name="estudiante" >
							<?php
										
                                // se genera la consulta a la base de datos  con el fin de obtener los   valores que se han calificado.
                                $q1 = "SELECT nombres, apellidos, id_alumno FROM matricula  INNER JOIN alumnos ON alumnos.id = matricula.id_alumno 
                                			WHERE matricula.grado = 1";
                                // se ejecuta la consulta a la base de datos para obtener un resultado en la variable $q1x
                                $q1x = mysql_query($q1, $link) or die('Consulta fallida q1: ' . mysql_error());;
						
                                		// explora los el arreglo que se obtuvo como resultado de la terminacion de la consulta.
                                		while($dato1 = mysql_fetch_array($q1x)) {
                                    // genera una salida por cada a�o registrado en la consulta
                                    echo "<option value='".$dato1['id_alumno']."'>".$dato1['nombres']." ".$dato1['apellidos']."</option>";						
                                }							
                        ?>
                        </select>
						</td>
					</tr>					
					
					
					<tr id="fecha"> <!-- campo donde se ingresa la fecha  de nacimiento del estudiante -->
						<td colspan="1" width = '25%'>
							Nacimiento:
						</td>	
						<td colspan="3" height="20" width = '75%'>
							<input type='date' min="1950-01-01" max="2050-01-01" id='fechas' name ='fechas'  >
						</td>
					</tr>

					

					
					<tr id="telefono">  <!-- En este campo se ingresa  el  numero telefonico -->
						<td width = '25%' colspan="1">
							Telefono:
						</td>	
						<td colspan="3" width = '75%'>					
							<input type='text'  name ='telefonos'>
						</td>
					</tr>
					
					<tr id="correo">  <!-- en este campo se ingresa el telefono del estudiante -->
						<td colspan="1" width = '25%'>
							Correo:
						</td>			
						<td colspan="3" width = '75%' height="20">					
							<input type='email'   name ='correos'>
						</td>
					</tr><!-- aqui se ingresa el correo electronico del estudiante -->
					<tr id="cedula">
						<td colspan="1" width = '25%'height="20">
							Cedula: 
						</td>			
						<td colspan="3" width = '75%' height="20">					
							<input type='text'  name ='cedulas'>
                        </td>
                    </tr>
						
					<tr id="curso" >  <!-- Se ingresa  un campo para seleccionar  el codigo de la materia -->
						<td  colspan="1" width="25%" >
							Materia : 
						</td>	
							
						<td colspan="3" width="75%">	
							<select name="curso" >
							<?php
										
                                // se genera la consulta a la base de datos  con el fin de obtener los   valores que se han calificado.
                                $q1 = "SELECT id,materia FROM materia";
                                // se ejecuta la consulta a la base de datos para obtener un resultado en la variable $q1x
                                $q1x = mysql_query($q1, $link) or die('Consulta fallida q1: ' . mysql_error());;
						
                                // explora los el arreglo que se obtuvo como resultado de la terminacion de la consulta.
                                while($dato1 = mysql_fetch_array($q1x)) {
                                    // genera una salida por cada aÃ±o registrado en la consulta
                                    echo "<option value='".$dato1['id']."'>".$dato1['materia']."</option>";						
                                }							
                        ?>
                        </select>
						</td>
					</tr>
										
					
					<tr id="area">  <!-- se genera un campo   para la creaciÃ³n   de las materias atendidas por docente -->
						<td colspan="1" width = '25%'height="20">
							Materias:
						</td>			
						<td colspan="3" width = '75%' height="20">						
							<textarea  name ='area'></textarea>
						</td>
					</tr><!-- Materias  dictadas por el docente -->
					<tr id="materia">
						<td colspan="1" width = '25%' height="20">
							Materia:
						</td>		
						<td colspan="3" width = '75%' height="20">
							<input type='text'  name ='materias'>
						</td>
					</tr><!-- materia  -->
					<tr id="id_a">
						<td height="20">
							Id Area:
						</td>
					<td colspan="3" width = '75%' height="20">
						<input type='text'  name ='id_as'>
					</td>
					</tr><!-- se introduccen las areas viastas por cada etudiante -->
					<tr id="Logro">
						<td height="20">Logro:
						</td>			
						<td colspan="2" height="20">
							<textarea rows='4' cols='50' name ='Logros'></textarea>
						</td>
					</tr><!-- se introduce el contenido de cada logro -->
					<tr id="id_m">
						<td height="20">
							Id Materia:
						</td>		
						<td colspan="2" height="20">
							<input type='text'  name ='id_ms'>
						</td>
					</tr>
							
					
					<!-- se crea el codigo PHP para alojar las variables de consulta -->
					<tr id="ano"><td colspan="1">A&ntilde;o:</td>
					<td colspan="3">
					
					<!-- Este es el codigo dispuesto para seleccionar el aÃ±o de ejecucion del producto -->
					<!-- se conecta a la base de datos y recupera los  valores introduccidos en la tabla de calificaciones -->
					
					<select name='year' id='ano' >
					<?php
										
						// se genera la consulta a la base de datos  con el fin de obtener los   valores que se han calificado.
						$q1 = "SELECT DISTINCT year FROM calificaciones";
						// se ejecuta la consulta a la base de datos para obtener un resultado en la variable $q1x
						$q1x = mysql_query($q1, $link) or die('Consulta fallida q1: ' . mysql_error());;
						
						// explora los el arreglo que se obtuvo como resultado de la terminacion de la consulta.
						while($dato1 = mysql_fetch_array($q1x)) {
						// genera una salida por cada aÃ±o registrado en la consulta
						echo "<option value='".$dato1['year']."'>".$dato1['year']."</option>";						
						}							
					?>
					
					</select>
					<!-- final del campo aÃ±o -->
					</td></tr>


					<tr id="periodo">
					<td colspan="1">Peri&oacute;do:
					</td>
					<td colspan="3">
					
					
					<!--  <input type='text' id= 'periodos' name ='periodos'>-->
					
					<select name='periodos' id='periodo' >
					<?php
						$q1 = "SELECT DISTINCT periodo FROM calificaciones";
						// se ejecuta la consulta a la base de datos para obtener un resultado en la variable $q1x
						$q1x = mysql_query($q1, $link) or die('Consulta fallida q1: ' . mysql_error());;
						
						// explora los el arreglo que se obtuvo como resultado de la terminacion de la consulta.
						while($dato1 = mysql_fetch_array($q1x)) {
						// genera una salida por cada aÃ±o registrado en la consulta
						echo "<option value='".$dato1['periodo']."'>".$dato1['periodo']."</option>";						
						}							
					?>
					
					</select>
					</td>
					</tr>
					
					
					<tr id='id_g'>						 <!-- etiqueta que identifica el grado --> 
					<td colspan="1">Grado: </td>	 <!-- devuelve el codigo del grado --> 
					<td colspan="3">
					<!-- cuadro de dialogo -->
					<select name='id_g' id="id_g" >
					<?php
						$q1 = "SELECT id, grado FROM grados";	// obteniendo la informacion 
						$q1x = mysql_query($q1, $link) or die('Consulta fallida q1: ' . mysql_error());;
						
						while($dato1 = mysql_fetch_array($q1x)) {
						echo "<option value='".$dato1['id']."'>".$dato1['grado']."</option>";						
						}							
					?>
					</select>
					
					</td>
					
					</tr>					
					
					
					<tr id='grado'>
					<td colspan="1">Grado: </td>
					<td colspan="3">
					<!-- cuadro de dialogo -->
					<select name='grados' id="grado" >
					<?php
						//conexion con la base de datos
						//$link = 		mysql_connect('localhost', 'imcrea_admin', 'Caracter15');
						//mysql_select_db('imcrea_boletines', $link);					
						
						$q1 = "SELECT DISTINCT grado FROM grados";
						$q1x = mysql_query($q1, $link) or die('Consulta fallida q1: ' . mysql_error());;
						
						while($dato1 = mysql_fetch_array($q1x)) {
						echo "<option value='".$dato1['grado']."'>".$dato1['grado']."</option>";						
						}							
					?>
					</select>
					
					</td>
					<td colspan="2"></td>
					</tr>
					
					<tr id="fecha_fin">  <!-- En este campo se ingresa la fecha de fin del curso -->
						<td colspan="1" width = '25%'>
							Finalizacion :
						</td>	
								
						<td colspan="3" height="20" width = '75%'>
							<input type='date' min="1950-01-01" max="2050-01-01" id='fecha_fin' name ='fecha_fin'  >
						</td>
					</tr>
			
				</form>
			</table>
			
			<?  // en esta seccion se crea un formulario invisible con el fin de guardar el valor del grado obtenido por 
				// jscript  en una variable de PHP
				
			echo "<form action='formulario_boletin.php' method='post' name='fantasma' id='fantasma'>
              <input type=hidden name= 'campo' id= 'campo'></form>";?>
		
		<?	// en esta seccion se introducce un codigo en java scrip  el cual tiene como fin recuperar el  codigo del grado que se encuentra en curso 
			// el codigo del grado se debe recuperar uen una varable de PHP denominada $gr
		
		
		echo "
 			<script type='text/javascript'>
				$(document).ready(function(){
				//cuando detecta un cambio en el objeto select llamado id_g ejecuta la funcion descrita 			
				$('select[name = id_g]').on('change', function () {
				$('select[name = estudiante]').empty();
				var gr = $('select[name = id_g]').val();
				//document.cookie ='gactual='+gr+'; expires=Thu, 2 Aug 2021 20:47:11 UTC; path=/';	
				//alert(gr);
				var frm = document.getElementById('fantasma');		
				frm.campo.value = gr;
				alert(frm.campo.value);
         	frm.submit();	
				";
		
				//$gr =  $_COOKIE["gactual"];
				$gr =  $_POST["campo"];
				//echo $gr;
		?>
		<?
			$q1 = "SELECT nombres, apellidos, id_alumno FROM matricula  INNER JOIN alumnos ON alumnos.id = matricula.id_alumno 
               WHERE matricula.grado =".$gr;
         $q1x = mysql_query($q1, $link) or die('Consulta fallida q1: ' . mysql_error());
         
         while($dato1 = mysql_fetch_array($q1x)) {
                                    // genera una salida por cada aÃ±o registrado en la consulta
         echo	"$('select[name = estudiante]').append(new Option('".$dato1['nombres']." ".$dato1['apellidos']."','".$dato1['id_alumno']."', true, true));"; 
         //"<option value='".$dato1['id_alumno']."'>".$dato1['nombres']." ".$dato1['apellidos']."</option>";						
         }	
         
         
         
		?>	
		<? echo "
			//$('select[name = estudiante]').append(new Option('Foo', 'foo', true, true));
			});		
		});
		
		</script>";		
		?>
    		
		
		
		
		
	</body>
</html>