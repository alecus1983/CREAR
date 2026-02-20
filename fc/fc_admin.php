<?php
session_start();
require_once('datos.php');

if (isset($_SESSION["usuario"])) {
    $usuario =  $_SESSION["usuario"];
    $d = new docentes();
    $d->get_docente_cc($usuario);
    $id = $d->id;
    $admin = $d->admin;

    $ano = date('Y');
    if ($admin == 0) {
	header("Location:board.php");
    }
} else {
    header("Location:board.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">

    <head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>calificaciones</title>
	<link href="css/style.min.css" rel="stylesheet" />
	<link href="css/styles.css" rel="stylesheet" />
	<link href="estilos.css" rel="stylesheet" />
	<script src="js/all.js"></script>
	<link href="../imagenes/escudo.gif" rel="shortcut icon" />

	
	<script src="./js/sweetalert.min.js"></script>
	<script src="./js/jquery-3.5.1.min.js"></script>
	<script src="./js/fc_admin.js"></script>
	<script src="./js/personas.js"></script>
	<script src="./js/grados.js"></script>
	<script src="./js/notas.js"></script>
	<script src="./js/semanas.js"></script>
	<script src="./js/ajax.js"></script>
	<script src="./js/escolaridad.js"></script>
	<script src="./js/jornada.js"></script>
    <script src="./js/materias.js"></script>
    <script src="js/areas.js"></script>
    <script src="js/cursos.js"></script>
	<script src="../boostrap/css/bootstrap.css" type="text/css"></script>
	<script src="../boostrap/css/bootstrap.min.css" type="text/css"></script>
	<link rel="stylesheet" href="estilos.css" type="text/css">

	<style>
	 input[type=number]::-webkit-inner-spin-button,
	 input[type=number]::-webkit-outer-spin-button {
	     -webkit-appearance: none;
	     margin: 0;
	 }

	 input[type=number] {
	     -moz-appearance: textfield;
	 }
	</style>

	<style>
	 .loader {
	     position: absolute;
	     left: 50%;
	     top: 50%;
	     z-index: 1;
	     border: 30px solid #f3f3f3;
	     border-radius: 50%;
	     border-top: 16px solid blue;
	     border-right: 16px solid green;
	     border-bottom: 16px solid red;
	     border-left: 16px solid orange;
	     width: 10rem;
	     height: 10rem;
	     -webkit-animation: spin 2s linear infinite;
	     animation: spin 2s linear infinite;
	 }


	 @-webkit-keyframes spin {
	     0% {
		 -webkit-transform: rotate(0deg);
	     }

	     100% {
		 -webkit-transform: rotate(360deg);
	     }
	 }

	 @keyframes spin {
	     0% {
		 transform: rotate(0deg);
	     }

	     100% {
		 transform: rotate(360deg);
	     }
	 }
	</style>


	<!-- scrip -->
	<script>

	 // CONFIGURACION AJAX
	 jQuery.ajaxSetup({
	     beforeSend: function() {
		 $('#loader-overlay').show();
		 $('#loader').show();
		 $('#tabla').html("");
	     },
	     complete: function() {
		 $('#loader-overlay').hide();
		 $('#loader').hide();
	     }
	 });
	 //////////////////////////////////////////////////////////////////////////////////////////
	 // Este script contiene la funcion para generar las graficas                            //
	 // Esta foncion no recive parametros                                                    //
	 //////////////////////////////////////////////////////////////////////////////////////////


	 function grafica() {
	     // se invoca al metodo ajax para solicitar el los datos del grafico
	     $.ajax({
		 type: "POST",
		 url: "grafica_boletin.php",
		 data: {
		     year: $("#years").val(),
		     id_gs: $("#id_g").val(),
		     id_ms: $("#id_ms").val(),
		     id_jornada: $("#jornada").val(),
		     id_docente: $("#id_docentes").val(),
		     corte: $("#corte").val(),
		     periodo: $("#periodos").val(),
		     opcion: $("#opcion").val()

		 },
		 // si los datos son correctos entonces ...
		 success: function(respuesta) {

		     $("#grafo").html(respuesta);

		 },
		 error: function(xhr, status) {
		     swal('Disculpe, existió un problema');
		     console.log(xhr);
		 }
	     });

	 }

	 // funcion para cargar datos en un selector
	 function carga(a, b, c) {

	     console.log("Valor a: %s", a); // variable que almacena el codigo del campo
	     console.log("Valor b: %s", b); // variable que almacena el nombre del archivo PHP
	     console.log(JSON.stringify(c)); // parametro que se transmite  mediante ajax
	     // $.post(b, c,
	     $.ajax({
		 async: true,
		 method: "POST",
		 url: b,
		 data: c,
		 dataType: "json",
	     }).done(function(dato) {
		 $(a).empty();

		 $(a).append("<option value = -1> Seleccione </option>");
		 $.each(dato, function(index, materia) {
		     $(a).append("<option value =" + index + ">" + materia + "</option>");
		 });
	     });
	 }
	</script>
    </head>

    <body class="sb-nav-fixed">
	<div id="loader-overlay"></div>
	<div class="loader" style="display:none" id="loader"></div>

	<div>
	    <p> El usuario es <?php $usuario  ?>
	</div>

	<div id="content">

	    <?php $hoy = Date("Y-m-d hh:mm"); ?>
	    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
		<!-- Navbar Brand-->
		<a class="navbar-brand ps-3" href="board.php">INICIO</a>
		<!-- Sidebar Toggle-->
		<button class="btn btn-link btn-sm order-1 order-lg-0 ms-auto me-4 me-lg-0"
			       id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
		<a style="color:FFF" href="#"></a>
	      <!-- Navbar grados y cursos-->

		<ul class="navbar-nav" id="nv_grupos">
		    <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" id="gradosDropdown" data-bs-toggle="dropdown" href="#" aria-expanded="false">Grupos</a>
			<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="gradosDropdown"> 
			  <li><a class="dropdown-item" href="#" onclick="gestionar_grados();">Gestionar grado</a></li>
			    <li><a class="dropdown-item" onclick="gestionar_escolaridad();" href="#">Gestionar escolaridad</a></li>
			    <li><a class="dropdown-item" onclick="gestionar_jornada();" href="#">Gestionar jornada</a></li>
         <li><a class="dropdown-item" href="#" onclick="gestion_cursos();">Gestionar curso</a></li>
			</ul>
		    </li> 
		</ul>

	      <!-- Nvar de calificaciones -->

	      <ul class="navbar-nav" id="nv_grupos" >
		<li  class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" id="gradosDropdown" data-bs-toggle="dropdown" href="#" aria-expanded="false">Calificaciones</a>
		  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="gradosDropdown">
		    <li><a class="dropdown-item" href="#" onclick="gestion_semanas()">Gestion semanas</a></li>
		    <li><a class="dropdown-item" href="#">Gestion periodos</a></li>
		  </ul>
		</li>
	      </ul>

		<!-- estructura académica -->

		<ul class="navbar-nav" id="nv_estructura_academica">
		    <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" id="gradosDropdown" data-bs-toggle="dropdown" href="#" aria-expanded="false">Estructura académica</a>
			<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="gradosDropdown"> 
			    <li><a class="dropdown-item" href="#" onclick="gestion_materia_area();">Gestionar materia</a></li>
			    <li><a class="dropdown-item" href="#" onclick="gestion_areas();">Gestionar area</a></li>

			    <li><a class="dropdown-item" href="#" onclick="gestion_taller();">Gestionar  taller</a></li>
			   </ul>
		    </li> 
		</ul>

		<ul class="navbar-nav" id="nv_roles_personas">
		    <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" id="gradosDropdown" data-bs-toggle="dropdown" href="#" aria-expanded="false">Personas y roles</a>
			<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="gradosDropdown"> 
			    <li><a class="dropdown-item" href="#" onclick="gestion_personas();">Gestionar personas</a></li>
			    <li><a class="dropdown-item" href="#" onclick="matricula_docente();">Asignar Clases</a></li>
			    <li><a class="dropdown-item" href="#" onclick="gestion_matriculas(1);">Matricular Alumno</a></li>
			    <li><a class="dropdown-item" href="#" onclick="listado_matricula_escolaridad_jornada();">Editar matricula alumno</a></li>
			</ul>
		    </li> 
		</ul>
		
		<ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
		    <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle"
			   id="navbarDropdown" href="#"
			   role="button" data-bs-toggle="dropdown"
			   aria-expanded="false"><i class="fas fa-user fa-fw"></i>
			    <?php echo ucwords(strtolower($d->nombres)) . " " . ucwords(strtolower($d->apellidos)); ?> </a>
			<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

			    <li><a class="dropdown-item" href="logout.php">Salir</a></li>
			</ul>
		    </li>
		</ul>
	    </nav>


	    <div id="layoutSidenav">
		<div id="layoutSidenav_nav">

		    <!-- barra de navegacion -->
		    <nav class="sb-sidenav accordion sb-sidenav-dark"
				id="sidenavAccordion"
				style="background-color: cadetblue">

			<div class="sb-sidenav-menu">

			    <!-- barra de navegacion -->
			    <div class="nav">

				<!-- menú de datos -->
				<a class="nav-link collapsed" href="#"
				   data-bs-toggle="collapse"
				   data-bs-target="#collapseLayouts1"
				   aria-expanded="false" aria-controls="collapseLayouts1">
				    <div class="sb-nav-link-icon">
					<i class="fas fa-columns"></i>
				    </div>
				    Datos
				    <div class="sb-sidenav-collapse-arrow">
					<i class="fas fa-angle-down"></i>
				    </div>
				</a>

				<!-- contenido de menú de datos -->
				<div class="collapse" id="collapseLayouts1"
				     aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">

				    <nav class="sb-sidenav-menu-nested nav">

					<label for="years">Año</label>
					<input type="number"
					       value="<?php echo date('Y'); ?>"
					       id="years"
					       name="years"
					       min="2015"
					       max="2100" step="1"
					       style="background: transparent;color: darkgreen;border: 0px;"
					<?php if ($admin < 1) { ?>
					    readonly="readonly"
					<?php } ?>
					class="form-control ">

					<input type="hidden" value="<?php echo $id; ?>" id="id_d">

					<label for="periodos">Periodo</label>
					<select id="periodos"
						style="background: transparent;color: darkgreen;border: 0px"
						name="periodos"
						class="form-control" required=""
						onchange="load_semanas();">
					    <option value="-1" selected>seleccione</option>
					    <option value="1">1</option>
					    <option value="2">2</option>
					    <option value="3">3</option>
					    <option value="4">4</option>
					    <option value="5">Recuperacion</option>

					</select>

					<label for="semana">Semana</label>
					<select id="semana"
						class="form-control"
						style="background: transparent;color: darkgreen;border: 0px"
						onchange="$('#semana').css('background-color', 'transparent');">
					    <?php

					    if ($admin) {
					    } else {
						$s = new semana();
						$sem  = $s->get_semana_activa($ano);
						echo "<option value='$sem' selectecd>$sem </option>";
					    }

					    ?>

					</select>

					<label for="jornada">Jornada</label>
					<select id="jornada"
						style="background: transparent;color: darkgreen;border: 0px"
						class="form-control"
						onchange=";">
					    <option value="1">Mañana</option>
					    <option value="2">Tarde</option>
                            </select>

					<label for="escolaridad">Escolaridad</label>
					<select id="escolaridad"
						style="background: transparent;color: darkgreen;border: 0px"
						class="form-control"
						onchange="lista_grados($('#escolaridad').val(),'#id_g', $('#id_d').val());">
					    <option value="-1">Seleccione</option>
					    <option value="1">Preescolar</option>
					    <option value="2">Básica Primaria</option>
					    <option value="3">Básica Secundaria</option>
					    <option value="4">Tecnico</option>
					    <option value="5">Cursos</option>
					</select>

					<input type="hidden" value="<?php echo $id; ?>" id="id_d">

					<label class="Control-label">Grado</label>

					<select id="id_g" name="id_gs"
						class="form-control"
						style="background: transparent;color: darkgreen;border:  10px"
						onchange="actualizar();$('#id_g').css('background-color', 'transparent');">
					</select>

					<label class="Control-label">Curso</label>
					<select id="id_c"
						    style="background: transparent;color: darkgreen;border:0px;"
						    onchange=";"
						    class="form-control">
					    <option value="0">A</opcion>
						<option value="1">B</opcion>
						    <option value="2">C</opcion>
							<option value="3">D</opcion>
					</select>

					<label for="id_ms">Materia</label>
					<select id="id_ms"
						    style="background: transparent;color: darkgreen;border: 0px"
						    name="id_ms" onchange="$('#id_ms').css('background-color', 'transparent')"
						    class="form-control">
					</select>

				    </nav>

				</div>
				<!-- fin de datos -->

				
				<!-- elementos -->
				<a class="nav-link collapsed" href="#"
				   data-bs-toggle="collapse"
				   data-bs-target="#collapseLayouts2"
				   aria-expanded="false" aria-controls="collapseLayouts2">
				    <div class="sb-nav-link-icon">
					<i class="fas fa-columns"></i>
				    </div>
				    Elementos
				    <div class="sb-sidenav-collapse-arrow">
					<i class="fas fa-angle-down"></i>
				    </div>
				</a>

				<div class="collapse" id="collapseLayouts2"
				     aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">

				    <nav class="sb-sidenav-menu-nested nav">
					<a style="margin: 0.5rem;"
					   class="nav-link"
					   href="#" target="_self"
					   onclick="gestion_semanas()">Gestión de Semanas
					</a>
				    </nav>

				    <nav class="sb-sidenav-menu-nested nav">
					<a style="margin: 0.5rem;"
					   class="nav-link"
					   href="#" target="_self"
					   onclick="gestion_personas()">Gestión de Personas
					</a>
				    </nav>

				    <nav class="sb-sidenav-menu-nested nav">
					<a style="margin: 0.5rem;"
					   class="nav-link"
					   href="#" target="_self"
					   onclick="requisitos_grado()">Requisitos de grado
					</a>
				    </nav>

				    <nav class="sb-sidenav-menu-nested nav">
					<a style="margin: 0.5rem;"
					   class="nav-link"
					   href="#" target="_self"
					   onclick="matricula_docente()">Matricula Docente
					</a>
				    </nav>

				    <nav class="sb-sidenav-menu-nested nav">
					<a style="margin: 0.5rem;"
					   class="nav-link"
					   href="#" target="_self"
					   onclick="listado_estudiantes_matriculados();">Listado estudiantes matriculados
					    <span style="margin :auto;" class="badge bg-secondary rounded-pill bg-danger">Nuevo</span>
					</a>
				    </nav>

				    <nav class="sb-sidenav-menu-nested nav">
					<a style="margin: 0.5rem;"
					   class="nav-link"
					   href="#" target="_self"
					   onclick="listado_notas_estudiantes();">Notas por estudiantes
					    <span style="margin :auto;" class="badge bg-secondary rounded-pill bg-danger">Nuevo</span>
					</a>
				    </nav>

				</div>
				<!-- fin de elementos -->
				
				<a class="nav-link collapsed" href="#"
				   data-bs-toggle="collapse"
				   data-bs-target="#collapseLayouts3"
				   aria-expanded="false" aria-controls="collapseLayouts3">
				    <div class="sb-nav-link-icon">
					<i class="fas fa-columns"></i>
				    </div>
				    Procesos
				    <div class="sb-sidenav-collapse-arrow">
					<i class="fas fa-angle-down"></i>
				    </div>
				</a>
				<div class="collapse" id="collapseLayouts3"
				     aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">

				    <nav class="sb-sidenav-menu-nested nav">
					<a style="margin: 0.5rem;"
					   class="nav-link"
					   href="#"
					   href="listado_docentes.php"
					   target="_blank">lista de docentes
					</a>
					<a style="margin: 0.5rem;"
					   class="nav-link"
					   href="#"
					   onclick="avance_semanal();">Avance notas semanales
					</a>

					<a style="margin: 0.5rem;"
					   class="nav-link"
					   onclick="boletin()">Boletin
					    <span style="margin :auto;" class="badge bg-secondary rounded-pill bg-danger">Nuevo <br>preescolar</span>
					</a>

					<a style="margin: 0.5rem;"
					   class="nav-link"
					   onclick="crear_pdf()">Certificado
					    <span style="margin :auto;" class="badge bg-secondary rounded-pill bg-danger">Nuevo</span>
					</a>

					<a style="margin: 0.5rem;"
					   class="nav-link"
					   onclick="cuadro();">Generar cuadro de notas
					</a>

					<a style="margin: 0.5rem;"
					   class="nav-link"
					   href="#" target="_self"
					   onclick="notas_faltantes()">Notas faltantes
					</a>
				    </nav>
				</div>
				
			    </div>
			</div>
			<div>

			</div>
			<div class="sb-sidenav-footer">
			    <div class="small">Registrado como:</div>
			    <?php echo ucwords(strtolower($d->nombres)) . " " . ucwords(strtolower($d->apellidos)); ?>
			</div>
		    </nav>
		</div>


		<div id="layoutSidenav_content">
		    <main>
			<div class="container-fluid px-4">
			    <h1 class="mt-4">FORMULARIO <span id="ano" ><?php echo date('Y'); ?></span></h1> 
			    <ol class="breadcrumb mb-4">
				<li class="breadcrumb-item active">Para la gestistión de la plataforma CREAR</li>
			    </ol>

			    <!--  contenedores dinamicos -->
			    <div id="avance" class="row"></div>
			    <div id="grafica" class="row"></div>
			    <div id="tabla" class="row"></div>


			</div>
		    </main>
		</div>
	    </div>


	</div><!-- fin del contenido -->

	<footer class="py-4 bg-light mt-auto">
	    <div class="container-fluid px-4">
		<div class="d-flex align-items-center justify-content-between small">
		    <div class="text-muted">Copyright &copy; Mundo Creativo 2023</div>
		    <div>
			<a href="#">Politica privacidad</a>
			&middot;
			<a href="#">Terminos &amp; Condiciones</a>
		    </div>
		</div>
	    </div>
	</footer>
	<script src="./js/bootstrap.bundle.min.js"></script>
	<script src="./js/scripts.js"></script>
	<script src="./js/Chart.min.js"></script>
	<script src="./assets/demo/chart-area-demo.js"></script>
	<script src="./assets/demo/chart-bar-demo.js"></script>
	<script src="./js/simple-datatables.min.js" crossorigin="anonymous"></script>
	<script src="./js/datatables-simple-demo.js"></script>
    </body>

</html>
