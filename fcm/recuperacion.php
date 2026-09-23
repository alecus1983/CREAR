<?php
session_start();
if (isset($_SESSION["identificacion"])) {
	$usuario = $_SESSION["identificacion"];
} else {
	header("Location:login_boletines_x.php");
	exit;
}

require_once('datos.php');

$d = new docentes();
$d->get_docente_cc($usuario);
$id = $d->id;
$admin = $d->admin;
$ano = date('Y');
$periodo = 0;
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
	<script src="js/grados.js"></script>
	<script src="js/recuperacion.js"></script>
	<script src="js/all.js"></script>
	<link href="../imagenes/escudo.gif" rel="shortcut icon" />
	<script src="./js/sweetalert.min.js"></script>
	<script src="./js/jquery-3.5.1.min.js">
		< script src = "./js/ajax.js" >
	</script>
	<link rel="stylesheet" href="estilos.css" type="text/css">

	<style>
		input[type=number]::-webkit-inner-spin-button,
		input[type=number]::-webkit-outer-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}

		input[type=number] {
			appearance: textfield;
		}
	</style>

	<style>
		#loader-overlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(255, 255, 255, 0.6);
			backdrop-filter: blur(4px);
			-webkit-backdrop-filter: blur(4px);
			z-index: 9999;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.modern-loader {
			border: 4px solid rgba(0, 0, 0, 0.1);
			border-left-color: #0d6efd;
			border-radius: 50%;
			width: 4rem;
			height: 4rem;
			animation: spin 1s linear infinite;
		}

		@keyframes spin {
			0% {
				transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
			}
		}

		.sidenav-select {
			background-color: rgba(255, 255, 255, 0.05) !important;
			color: #fff !important;
			border: 1px solid rgba(255, 255, 255, 0.1) !important;
			border-radius: 0.4rem;
			padding: 0.4rem 0.75rem;
			margin-bottom: 1rem;
			transition: all 0.3s ease;
			appearance: auto !important;
			-moz-appearance: auto !important;
			-webkit-appearance: auto !important;
		}

		.sidenav-select:focus {
			background-color: rgba(255, 255, 255, 0.1) !important;
			border-color: #4DB6AC !important;
			outline: none;
			box-shadow: 0 0 0 0.2rem rgba(77, 182, 172, 0.25);
		}

		.sidenav-select option {
			color: #000;
		}

		.sidenav-label {
			color: #adb5bd;
			font-size: 0.8rem;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			margin-bottom: 0.3rem;
			display: block;
		}

		.modern-floating-btn {
			position: fixed;
			bottom: 30px;
			right: 30px;
			border-radius: 50px;
			padding: 12px 24px;
			font-size: 1.1rem;
			font-weight: 600;
			box-shadow: 0 4px 15px rgba(5, 59, 14, 0.4);
			z-index: 1000;
			display: flex;
			align-items: center;
			gap: 10px;
			transition: transform 0.2s, box-shadow 0.2s;
		}

		.modern-floating-btn:hover {
			transform: translateY(-3px);
			box-shadow: 0 6px 20px rgba(13, 110, 253, 0.6);
		}
	</style>

	<style>
		/* ===================================================================
		   Responsive del sidenav (#sidenavAccordion)
		   Repone las reglas base de la plantilla SB Admin que faltan en
		   css/styles.css y adapta el ancho por punto de quiebre.
		   =================================================================== */
		:root {
			--sidenav-ancho: 250px;
			--topnav-alto: 56px;
		}

		#layoutSidenav {
			display: flex;
		}

		#layoutSidenav #layoutSidenav_nav {
			flex-basis: var(--sidenav-ancho);
			flex-shrink: 0;
			transform: translateX(calc(-1 * var(--sidenav-ancho)));
		}

		#layoutSidenav #layoutSidenav_content {
			position: relative;
			flex-direction: column;
			justify-content: space-between;
			min-width: 0;
			flex-grow: 1;
			min-height: calc(100vh - var(--topnav-alto));
		}

		.sb-nav-fixed #layoutSidenav #layoutSidenav_nav {
			width: var(--sidenav-ancho);
			/* dvh evita que la barra del navegador móvil corte el panel */
			height: 100dvh;
		}

		/* El sidenav es un formulario largo: siempre debe poder desplazarse */
		.sb-nav-fixed #layoutSidenav #layoutSidenav_nav .sb-sidenav {
			padding: var(--topnav-alto) 1rem 1.5rem;
			overflow-y: auto;
			overscroll-behavior: contain;
			-webkit-overflow-scrolling: touch;
		}

		/* --- Móvil / tablet: el sidenav se superpone, no empuja al contenido --- */
		@media (max-width: 991.98px) {
			.sb-nav-fixed #layoutSidenav #layoutSidenav_content {
				padding-left: 0;
			}

			.sb-sidenav-toggled #layoutSidenav #layoutSidenav_nav {
				transform: translateX(0);
			}

			/* El velo tapa el contenido y sirve para cerrar tocando fuera */
			.sb-sidenav-toggled #layoutSidenav #layoutSidenav_content:before {
				cursor: pointer;
			}

			/* Controles más cómodos al tacto y sin zoom en iOS */
			#sidenavAccordion .sidenav-select {
				min-height: 44px;
				font-size: 16px;
			}

			/* El brand de 225px fijos ahogaba la barra superior en móvil */
			.sb-topnav .navbar-brand {
				width: auto;
				padding-left: 0.5rem !important;
				font-size: 1rem;
			}

			#sidebarToggle {
				margin-right: 0.5rem !important;
			}

			/* El nombre del docente desbordaba la barra en pantallas chicas */
			#navbarDropdown {
				display: inline-block;
				max-width: 45vw;
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: nowrap;
				vertical-align: middle;
			}
		}

		/* En pantallas muy estrechas el panel ocupa casi todo el ancho */
		@media (max-width: 575.98px) {
			:root {
				--sidenav-ancho: 85vw;
			}
		}

		/* --- Escritorio: el sidenav queda fijo y desplaza el contenido --- */
		@media (min-width: 992px) {
			#layoutSidenav #layoutSidenav_nav {
				transform: translateX(0);
			}

			.sb-nav-fixed #layoutSidenav #layoutSidenav_content {
				padding-left: var(--sidenav-ancho);
				transition: padding-left 0.15s ease-in-out;
			}

			/* Plegado manual con el botón de la barra superior */
			.sb-sidenav-toggled #layoutSidenav #layoutSidenav_nav {
				transform: translateX(calc(-1 * var(--sidenav-ancho)));
			}

			.sb-sidenav-toggled #layoutSidenav #layoutSidenav_content {
				padding-left: 0;
			}
		}

		/* Etiquetas y campos del sidenav (las clases no tenían estilos) */
		#sidenavAccordion .sidenav-label {
			display: block;
			margin: 0.75rem 0 0.25rem;
			font-size: 0.8rem;
			font-weight: 600;
			text-transform: uppercase;
			letter-spacing: 0.02em;
			color: rgba(255, 255, 255, 0.7);
		}

		#sidenavAccordion .sidenav-select {
			width: 100%;
			max-width: 100%;
		}

		/* Pantallas bajas (móvil en horizontal): compacta el formulario */
		@media (max-height: 520px) {
			#sidenavAccordion .sidenav-label {
				margin: 0.4rem 0 0.15rem;
				font-size: 0.72rem;
			}

			#sidenavAccordion .sidenav-select {
				min-height: 36px;
				padding-top: 0.15rem;
				padding-bottom: 0.15rem;
			}
		}
	</style>


	<script type="text/javascript">
		// Funcion en java scrip para ingresar valores en la base de datos
		// para el formulario de recuperaciones
		// permite agregar estudiantes, docentes, notas etc ...

		function set_recuperacion() {

			// para ello comienza
			// almacenando el codigo del grado en la variable j
			var j = $("#id_g").val();
			var esc = $("#escolaridad").val();
			var periodo = $('#periodos').val();




			swal({
				title: 'INSERTAR NOTAS RECUPERACION',
				text: "Esta seguro que quiere insertar las notas!",
				icon: 'warning',
				buttons: true,
				buttons: ["cancelar", "insertar"],

			}).then((value) => {
				if (value) {

					// creo un array a partir de los
					// elementos pertenecientes a  una misma clase

					// serializo los campos del logro, que se generan
					// con el atributo name="l1_p{periodo}[]"
					var logros = $('[name="l1_p' + periodo + '[]"]').serializeArray();
					// se colocan las notas, generadas con name="R{periodo}[]"
					var notas = $('[name="R' + periodo + '[]"]').serializeArray();
					// serializo los codigos de los alumnos, en el mismo orden
					// en que se generaron las notas y los logros
					var codigos = $('.codigo').serializeArray();


					// si los datos son validos
					if (1) {
						// llamo al metodo ajax para el envío de la  información
						// se emplea en envío por POST
						$.ajax({
							type: "POST",
							url: "notas_mensuales_recuperacion.php",
							data: {
								year: $("#years").val(),
								semana: $("#semana").val(),
								id_gs: $("#id_g").val(),
								id_curso: $("#id_c").val(),
								id_ms: $("#id_ms").val(),
								id_jornada: $("#jornada").val(),
								id_docente: $("#id_docente").val(),
								corte: $("#corte").val(),
								periodo: periodo,
								codigo: JSON.stringify(codigos),
								L: JSON.stringify(logros),
								R: JSON.stringify(notas)
							},

							success: function(data) {
								// respuesta a la carga de notas

								// si hay notas actualizadas
								if (data.actualizadas > 0) {
									swal("Succes", "cantidad de actualizadas " + data["actualizadas"]);
								}
								console.log(data);


							},
							error: function(xhr, status) {
								swal('Disculpe, existió un problema');
								console.log(xhr);
							}
						});
					} // fin de valido
					else {
						swal("Revise los datos", "No se ingresaron los datos \t porque tiene notas mayores que 5", "error");
					}
				}

			});

		} // fin de la funsion set_recuperacion
	</script>


	<script>
		// funcion para la carga de los alumnos
		function est(id_a) {
			//swal("Has ingresado el alumno"+id_a);


			$.ajax({
				type: "POST",
				url: "rendiminento_alumno_periodo.php",
				data: {
					id_alumno: id_a,
					materia: $("#id_ms").val(),
					year: $("#years").val(),
					periodo: $("#periodos").val()
				},
				// si los datos son correctos entonces ...
				success: function(respuesta) {

					$("#estadisicas").html(respuesta);
					//$("#resultado").html("");

				},
				error: function(xhr, status) {
					swal('Disculpe, existió un problema al cargar los logros');
					console.log(xhr);
				}
			});


			$("#estadisticas").focus();
		}

		//fucion de carga incial
		function load_semanas() {

			//  variable periodo
			var periodo = $("#periodos").val();
			// variable año
			var year = $("#years").val();

			// carga en un selector  de semanas
			carga("#semana", "load_semanas.php", {
				periodo: periodo,
				year: year
			});
		}

		// funsion que carga las semanas correctas cuando cambia
		// el Periodo de calificaciones
		// funcion para cargar las materias en el cuadro de dialogo
		// de acurdo al grado seleccionado

		function load_materias() {
			var id_docente = $("#id_docente").val();
			var id_grado = $("#id_g").val();
			var year = $("#years").val();
			carga("#id_ms", "materias_grado.php", {
				grados: id_grado,
				id: id_docente,
				year: year
			});
		}

		l

		// funcion para la carga de logros
		function load_logros() {

			$.ajax({
				type: "POST",
				url: "logros.php",
				data: {
					grado: $("#id_g").val(),
					materia: $("#id_ms").val(),
				},
				// si los datos son correctos entonces ...
				success: function(respuesta) {

					$("#logros_materia").html(respuesta);
					//$("#resultado").html("");

				},
				error: function(xhr, status) {
					swal('Disculpe, existió un problema al cargar los logros');
					console.log(xhr);
				}
			});
		}

		//     // avance semanal de notas de docentes
		//     function avance_semanal() {


		//         // se invoca al metodo ajax para solicitar
		//         // el listado de estudiantes
		//         $.ajax({
		//             type: "POST",
		//             url: "notas_docentes_semanales.php",
		//             data: {
		//                 years: $("#years").val(),
		//                 periodo: $("#periodos").val(),
		//                 semana: $("#semana").val()
		//             },
		//             // si los datos son correctos entonces ...
		//             success: function (respuesta) {

		//                 //$("#calificador").html(respuesta);
		//                 $("#resultado").html(respuesta);

		//             },
		//             error: function (xhr, status) {
		//                 swal('Disculpe, existió un problema');
		//                 console.log(xhr);
		//             }
		//         });


		// }

		// actualiza el formulario
		function actualizar() {
			load_materias();
			load_lista_recuperacion();
		}
	</script>

	<!-- scrip -->
	<script>
		/////////////////////////////////////////////////////////////////////////////////////////////
		// Este script contiene la funcion para generar las graficas   //
		// Esta foncion no recive parametros                                    //
		////////////////////////////////////////////////////////////////////////////////////////////

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

				$(a).append("<option value= -1> Seleccione </option>");
				$.each(dato, function(index, materia) {
					$(a).append("<option value =" + index + ">" + materia + "</option>");

				});
			});

		}


		jQuery.ajaxSetup({
			beforeSend: function() {
				$('#loader-overlay').css('display', 'flex');
			},
			complete: function() {
				$('#loader-overlay').hide();
			}
		});
	</script>
</head>

<body class="sb-nav-fixed">
	<div id="loader-overlay" style="display:none">
		<div class="modern-loader"></div>
	</div>
	<div id="content">
		<?php $hoy = Date("Y-m-d hh:mm"); ?>
		<nav class="sb-topnav navbar navbar-expand navbar-dark " style="background: darkslategrey;">
			<!-- Navbar Brand-->
			<img src="../images/escudo.png" alt="" width="30" height="30" class="d-inline-block align-text-top">
			<a class="navbar-brand ps-3" href="board.php">INICIO</a>
			<!-- Sidebar Toggle-->
			<button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 icono_calificacion" id="sidebarToggle"
				type="button" aria-controls="sidenavAccordion" aria-expanded="false"
				aria-label="Mostrar u ocultar el panel de filtros"><i class="fas fa-bars"></i></button>
			<a style="color:FFF" href="#"></a>
			<!-- Navbar-->
			<ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle icono_calificacion" id="navbarDropdown" href="#" role="button"
						data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i>
						<?php echo ucwords(strtolower($d->nombres)) . " " . ucwords(strtolower($d->apellidos)); ?> </a>
					<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

						<li><a class="dropdown-item" href="logout.php">Salir</a></li>
					</ul>
				</li>
			</ul>
		</nav>
		<div id="layoutSidenav">
			<div id="layoutSidenav_nav">
				<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion"
					aria-label="Filtros de calificaciones" style="background: darkslategrey;">


					<label for="years" class="sidenav-label">Año</label>
					<input type="number" value="<?php echo date('Y'); ?>" id="years" name="years" min="2015" max="2100"
						step="1" class="form-control sidenav-select" <?php if ($admin == 0) { ?> readonly="readonly" <?php } ?>>
					<input type="hidden" value="<?php echo $id; ?>" id="id_docente">


					<label for="periodos" class="sidenav-label"> Periodo</label>
					<select id="periodos" name="periodos" class="form-control sidenav-select" required=""
						onchange="load_semanas();">
						<?php

						if ($admin) {
							// si es administrador puede seleccionar cualquier periodo

							echo '<option value="-1" selected>seleccione</option>
                                    <option value="1">1</option>
			        				<option value="2">2</option>
				       				<option value="3">3</option>
				       				<option value="4">4</option>
				       				<option value="5">Recuperacion</option>';
						} else {
							// se crea un objeto semana 
							$s = new semana();
							// obtengo el periodo activo para este año
							// en la fecha actual
							$periodo = $s->get_periodo_activo($ano);
							// lo muestro en pantalla
							echo "<option value='$periodo' selectecd>$periodo </option>";
						}
						?>


					</select>

					<?php
					if ($periodo == 0 and $admin == 0) {
						echo "<script type='text/javascript'>";
						echo "swal({ title: '¡Error!',   text: 'No hay periodo cargado',   icon: 'error'});";
						echo "</script>";
					}
					?>

					<label for="semana" class="sidenav-label">Semana</label>
					<select id="semana" class="form-control sidenav-select" onchange="load_lista_recuperacion();">

						<?php
						if ($admin) {
						} else {
							$s = new semana();
							$sem = $s->get_semana_activa($ano);
							echo "<option value='$sem' selectecd>$sem </option>";
						}
						?>
					</select>

					<label for="jornada" class="sidenav-label">Jornada</label>
					<select id="jornada" class="form-control sidenav-select" onchange="actualizar();">
						<option value="1">Mañana</option>
						<option value="2">Tarde</option>
					</select>


					<label for="escolaridad" class="sidenav-label small me-2 mb-0">Escolaridad</label>
					<select id="escolaridad" class="form-control sidenav-select"
						onchange="lista_grados($('#escolaridad').val(),'#id_g', $('#id_docente').val());">
						<option value="-1">Seleccione</option>
						<option value="1">Preescolar</option>
						<option value="2">Básica Primaria</option>
						<option value="3">Básica Secundaria</option>
						<option value="4">Tecnico</option>
						<option value="5">Cursos</option>
					</select>

					<label class="sidenav-label Control-label">Grado</label>
					<select id="id_g" name="id_gs" class="form-control sidenav-select" onchange="actualizar();">

						<?php
						// creo un nuevo objeto  matricula docente
						$mt = new matricula_docente();
						// asigno el año a la matricula como el a actual
						$mt->year = date('Y');
						// defino el codigo del docente de la matricula
						$mt->id_docente = $id;
						//actuliza el listado de grados disponibles
						$lista = $mt->get_matricula(2);
						// conviere el dato en un json

						echo '<option value="-1">seleccione</option>';

						foreach ($lista as $key => $value) {

							echo '<option value="' . $key . '">' . $value . '</option>';
						}
						?>
					</select>

					<label class="sidenav-label Control-label">Curso</label>
					<select id="id_c" class="form-control sidenav-select" onchange="load_lista_recuperacion();">
						<option value="0">A</option>
						<option value="1">B</option>
					</select>

					<label for="id_ms" class="sidenav-label">Materia</label>
					<select id="id_ms" name="id_ms" class="form-control sidenav-select"
						onchange="load_lista_recuperacion();">
					</select>

					<div>
						<?php
						if ($admin) {
							//echo '<a style="margin: 2rem;" class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages" href="listado_docentes.php" target="_blank">lista de docentes</a>';
							//echo '<a style="margin: 2rem;" class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages" target="#" onclick="avance_semanal();">Avance notas semanales</a>';
							//echo '<a style="margin: 2rem;" class="nav-link collapsed" aria-expanded="false" aria-controls="collapsePages" href="fs.php" target="_self">Gestión de semanas</a>';

						}
						?>
					</div>

				</nav>
			</div>

			<div id="layoutSidenav_content">
				<main>
					<div class="container-fluid px-4">
						<h1 class="mt-4">FORMULARIO <?php echo date('Y'); ?></h1>
						<ol class="breadcrumb mb-4">
							<li class="breadcrumb-item active">Para la gestión de recuperaciones</li>
						</ol>


						<div class="row">
							<div class="col-md-12">
								<div class="card ">
									<div class="card-header">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
											fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16">
											<path
												d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5v12h-2V2h2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z" />
										</svg>
										estadísticas
									</div>
									<div id="estadisicas" class="card-body">

									</div>
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="card ">
									<div class="card-header">
										<i class="fas fa-chart-area me-1"></i>
										notas
									</div>
									<div class="card-body">

										<div class="row">
											<div class="col-md-12" id="resultado">

											</div>
										</div>
										<div class="row">
											<div class="row">

												<div id="calificador" class="col-md-12">
													<!-- formulario de notas> -->
												</div>
											</div>
											<div class="row">
												<button type="button" class="btn" value="INGRESAR" id="ingresar"
													onclick="set_recuperacion();">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
														fill="currentColor" class="bi bi-floppy2" viewBox="0 0 16 16">
														<path
															d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v3.5A1.5 1.5 0 0 1 11.5 6h-7A1.5 1.5 0 0 1 3 4.5V1H1.5a.5.5 0 0 0-.5.5m9.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z" />
													</svg> Guardar Notas
												</button>

												<button type="button" style="margin: 20px auto auto; display: block;"
													class="boton-flotante" value="INGRESAR" id="ingresar"
													onclick="set_recuperacion();">
													<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
														fill="currentColor" class="bi bi-floppy2" viewBox="0 0 16 16">
														<path
															d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v3.5A1.5 1.5 0 0 1 11.5 6h-7A1.5 1.5 0 0 1 3 4.5V1H1.5a.5.5 0 0 0-.5.5m9.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z" />
													</svg>
												</button>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</main>

				<footer class="py-4 bg-light mt-auto">
					<div class="container-fluid px-4">
						<div class="d-flex align-items-center justify-content-between small">
							<div class="text-muted">Copyright &copy; Mundo Creativo 2026, Registrado como
								<?php echo ucwords(strtolower($d->nombres)) . " " . ucwords(strtolower($d->apellidos)); ?>
							</div>
							<div>
								<a href="#">Politica de privacidad</a>
								&middot;
								<a href="#">Terminos &amp; Condiciones</a>
							</div>
						</div>
					</div>
				</footer>
			</div><!-- /#layoutSidenav_content -->
		</div><!-- /#layoutSidenav -->
	</div><!-- /#content -->

	<script src="./js/bootstrap.bundle.min.js"></script>
	<script src="./js/scripts.js"></script>
	<script>
		// Comportamiento responsive del sidenav (#sidenavAccordion).
		// scripts.js solo conmuta la clase sb-sidenav-toggled; aquí se agrega
		// el cierre al tocar fuera y el reinicio al cambiar de punto de quiebre.
		(function() {
			var escritorio = window.matchMedia('(min-width: 992px)');
			var cuerpo = document.body;
			var boton = document.getElementById('sidebarToggle');
			var contenido = document.getElementById('layoutSidenav_content');
			var sidenav = document.getElementById('sidenavAccordion');

			function abierto() {
				// En escritorio el sidenav se ve por defecto; la clase lo oculta.
				// En móvil es al contrario.
				return escritorio.matches ?
					!cuerpo.classList.contains('sb-sidenav-toggled') :
					cuerpo.classList.contains('sb-sidenav-toggled');
			}

			function sincronizarAria() {
				if (boton) {
					boton.setAttribute('aria-expanded', abierto() ? 'true' : 'false');
				}
			}

			function cerrarEnMovil() {
				if (!escritorio.matches && cuerpo.classList.contains('sb-sidenav-toggled')) {
					cuerpo.classList.remove('sb-sidenav-toggled');
					localStorage.setItem('sb|sidebar-toggle', 'false');
					sincronizarAria();
				}
			}

			if (boton) {
				boton.addEventListener('click', sincronizarAria);
			}

			// Tocar el velo oscuro (o el contenido) cierra el panel en móvil.
			if (contenido) {
				contenido.addEventListener('click', cerrarEnMovil);
			}

			// Escape cierra el panel en móvil.
			document.addEventListener('keydown', function(e) {
				if (e.key === 'Escape') {
					cerrarEnMovil();
				}
			});

			// Al elegir un filtro en móvil, se cierra para dejar ver el resultado.
			if (sidenav) {
				sidenav.addEventListener('change', function(e) {
					if (e.target.tagName === 'SELECT') {
						cerrarEnMovil();
					}
				});
			}

			// Evita que el estado plegado de escritorio se herede en móvil.
			var cambio = function() {
				cuerpo.classList.remove('sb-sidenav-toggled');
				localStorage.setItem('sb|sidebar-toggle', 'false');
				sincronizarAria();
			};
			if (escritorio.addEventListener) {
				escritorio.addEventListener('change', cambio);
			} else {
				escritorio.addListener(cambio);
			}

			sincronizarAria();
		})();
	</script>
	<script src="./js/Chart.min.js"></script>
	<script src="./assets/demo/chart-area-demo.js"></script>
	<script src="./assets/demo/chart-bar-demo.js"></script>
	<script src="./js/simple-datatables.min.js" crossorigin="anonymous"></script>
	<script src="./js/datatables-simple-demo.js"></script>
</body>

</html>