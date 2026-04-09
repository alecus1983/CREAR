<?php
session_start();
require_once('datos.php');

if (isset($_SESSION["usuario"])) {
  $usuario = $_SESSION["usuario"];
  $d = new docentes();
  $d->get_docente_cc($usuario);
  $id = $d->id;
  $admin = $d->admin;

  $ano = date('Y');
  if ($admin == 0) {
    header("Location:board.php");
  }
}
else {
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
    <script src="./js/matricula.js"></script>
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
       beforeSend: function () {
	 $('#loader-overlay').show();
	 $('#loader').show();
	 $('#tabla').html("");
       },
       complete: function () {
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
	 success: function (respuesta) {

	   $("#grafo").html(respuesta);

	 },
	 error: function (xhr, status) {
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
       }).done(function (dato) {
	 $(a).empty();

	 $(a).append("<option value = -1> Seleccione </option>");
	 $.each(dato, function (index, materia) {
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
      <p> El usuario es
	<?php $usuario?>
    </div>

    <div id="content">

      <?php $hoy = Date("Y-m-d hh:mm"); ?>
      <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
	<!-- Navbar Brand-->
	<a class="navbar-brand ps-3" href="board.php">INICIO</a>
	<!-- Sidebar Toggle-->
	<button class="btn btn-link btn-sm order-1 order-lg-0 ms-auto me-4 me-lg-0" id="sidebarToggle" href="#!"><i
														   class="fas fa-bars"></i></button>
	<a style="color:FFF" href="#"></a>
	<!-- Navbar grados y cursos-->

	<ul class="navbar-nav" id="nv_grupos">
	  <li class="nav-item dropdown">
	    <a class="nav-link dropdown-toggle" id="gradosDropdown" data-bs-toggle="dropdown" href="#"
	       aria-expanded="false">Grupos</a>
	    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="gradosDropdown">
	      <li><a class="dropdown-item" href="#" onclick="gestionar_grados();">Gestionar grado</a></li>
	      <li><a class="dropdown-item" onclick="gestionar_escolaridad();" href="#">Gestionar
		escolaridad</a></li>
	      <li><a class="dropdown-item" onclick="gestionar_jornada();" href="#">Gestionar jornada</a></li>
	      <li><a class="dropdown-item" href="#" onclick="gestion_cursos();">Gestionar curso</a></li>
	    </ul>
	  </li>
	</ul>

	<!-- Nvar de calificaciones -->

	<ul class="navbar-nav" id="nv_grupos">
	  <li class="nav-item dropdown">
	    <a class="nav-link dropdown-toggle" id="gradosDropdown" data-bs-toggle="dropdown" href="#"
	       aria-expanded="false">Calificaciones</a>
	    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="gradosDropdown">
	      <li><a class="dropdown-item" href="#" onclick="gestion_semanas()">Gestion semanas</a></li>
	      <li><a class="dropdown-item" href="#">Gestion periodos</a></li>
	    </ul>
	  </li>
	</ul>

	<!-- estructura académica -->

	<ul class="navbar-nav" id="nv_estructura_academica">
	  <li class="nav-item dropdown">
	    <a class="nav-link dropdown-toggle" id="gradosDropdown" data-bs-toggle="dropdown" href="#"
	       aria-expanded="false">Estructura académica</a>
	    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="gradosDropdown">
	      <li><a class="dropdown-item" href="#" onclick="gestion_materia_area();">Gestionar materia</a>
	      </li>
	      <li><a class="dropdown-item" href="#" onclick="gestion_areas();">Gestionar area</a></li>

	      <li><a class="dropdown-item" href="#" onclick="gestion_taller();">Gestionar taller</a></li>
	    </ul>
	  </li>
	</ul>

	<ul class="navbar-nav" id="nv_roles_personas">
	  <li class="nav-item dropdown">
	    <a class="nav-link dropdown-toggle" id="gradosDropdown" data-bs-toggle="dropdown" href="#"
	       aria-expanded="false">Personas y roles</a>
	    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="gradosDropdown">
	      <li><a class="dropdown-item" href="#" onclick="gestion_personas();">Gestionar personas</a></li>
	      <li><a class="dropdown-item" href="#" onclick="matricula_docente();">Asignar Clases</a></li>
	      <li><a class="dropdown-item" href="#" onclick="gestion_matriculas(1);">Matricular Alumno</a>
	      </li>
	      <li><a class="dropdown-item" href="#" onclick="listado_estudiantes_matriculados();">Editar
		matricula alumno</a></li>
	    </ul>
	  </li>
	</ul>

	<ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
	  <li class="nav-item dropdown">
	    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
	       data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i>
	      <?php echo ucwords(strtolower($d->nombres)) . " " . ucwords(strtolower($d->apellidos)); ?>
	    </a>
	    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
	      <li><a class="dropdown-item" href="logout.php">Salir</a></li>
	    </ul>
	  </li>
	</ul>
      </nav>

      

      <!-- barra de navegacion -->
      <nav id="barrabotones"  style="gap: 15px; padding: 10px; background:cadetblue" class="nav navbar">

	    <div class="me-2">
	      <label for="years" class="text-white small mb-1">Año</label>
	      <input type="number" value="<?php echo date('Y'); ?>" id="years" name="years" min="2015"
		     max="2100" step="1"
		     style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 2px 5px;"
	      <?php if ($admin < 1) { ?> readonly="readonly"
	      <?php
	      }?> class="form-control-sm">
	    </div>

	    <input type="hidden" value="<?php echo $id; ?>" id="id_d">

	    <div class="me-2">
	      <label for="periodos" class="text-white small mb-1">Periodo</label>
	      <select id="periodos"
		      style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 2px 5px;"
		      name="periodos" class="form-control-sm" required="" onchange="load_semanas();">
		<option value="-1" style="color: black;" selected>seleccione</option>
		<option value="1" style="color: black;">1</option>
		<option value="2" style="color: black;">2</option>
		<option value="3" style="color: black;">3</option>
		<option value="4" style="color: black;">4</option>
		<option value="5" style="color: black;">Recuperacion</option>
	      </select>
	    </div>

	    <div class="me-2">
	      <label for="semana" class="text-white small mb-1">Semana</label>
	      <select id="semana" class="form-control-sm"
		      style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 2px 5px;"
		      onchange="$('#semana').css('background-color', 'transparent');">
		<?php
		if ($admin) {
		}
		else {
		  $s = new semana();
		  $sem = $s->get_semana_activa($ano);
		  echo "<option style='color: black;' value='$sem' selected>$sem </option>";
		}
		?>
	      </select>
	    </div>

      </nav>
      <nav id="botonoesacademicos"  style="gap: 15px; padding: 10px; background:darkcyan" class="nav navbar">

	    <div class="me-2">
	      <label for="jornada" class="text-white small mb-1">Jornada</label>
	      <select id="jornada"
		      style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 2px 5px;"
		      class="form-control-sm">
		<option value="1" style="color: black;">Mañana</option>
		<option value="2" style="color: black;">Tarde</option>
	      </select>
	    </div>

	    <div class="me-2">
	      <label for="escolaridad" class="text-white small mb-1">Escolaridad</label>
	      <select id="escolaridad"
		      style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 2px 5px;"
		      class="form-control-sm"
		      onchange="lista_grados($('#escolaridad').val(),'#id_g', $('#id_d').val());">
		<option value="-1" style="color: black;">Seleccione</option>
		<option value="1" style="color: black;">Preescolar</option>
		<option value="2" style="color: black;">Básica Primaria</option>
		<option value="3" style="color: black;">Básica Secundaria</option>
		<option value="4" style="color: black;">Tecnico</option>
		<option value="5" style="color: black;">Cursos</option>
	      </select>
	    </div>

	    <div class="me-2">
	      <label class="text-white small mb-1">Grado</label>
	      <select id="id_g" name="id_gs" class="form-control-sm"
		      style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 2px 5px;"
		      onchange="actualizar();$('#id_g').css('background-color', 'transparent');">
	      </select>
	    </div>

	    <div class="me-2">
	      <label class="text-white small mb-1">Curso</label>
	      <select id="id_c"
		      style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 2px 5px;"
		      class="form-control-sm">
		<option value="0" style="color: black;">A</option>
		<option value="1" style="color: black;">B</option>
		<option value="2" style="color: black;">C</option>
		<option value="3" style="color: black;">D</option>
	      </select>
	    </div>

	    <div class="me-2">
	      <label for="id_ms" class="text-white small mb-1">Materia</label>
	      <select id="id_ms"
		      style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 2px 5px;"
		      name="id_ms" onchange="$('#id_ms').css('background-color', 'transparent')"
		      class="form-control-sm">
	      </select>
	    </div>

      </nav>
      
<div id="layoutSidenav">

	<div id="layoutSidenav_content">
	  <main>
	    <div class="container-fluid px-4">
	      <h1 class="mt-4">FORMULARIO <span id="ano">
		<?php echo date('Y'); ?>
	      </span></h1>
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
	<!-- fin de datos -->


	<div " id="collapseLayouts2" aria-labelledby="headingOne"
	     data-bs-parent="#sidenavAccordion">

	  <nav class="sb-sidenav-menu-nested nav d-flex flex-row flex-wrap justify-content-start"
		      style="gap: 10px; padding: 10px; background: rgba(255,255,255,0.1); border-radius: 5px;">
	    <button type="button" class="btn btn-sm btn-info text-white" onclick="gestion_semanas()">Gestión
	      de Semanas</button>
	    <button type="button" class="btn btn-sm btn-info text-white"
		    onclick="gestion_personas()">Gestión de Personas</button>
	    <button type="button" class="btn btn-sm btn-info text-white"
		    onclick="requisitos_grado()">Requisitos de grado</button>
	    <button type="button" class="btn btn-sm btn-info text-white"
		    onclick="matricula_docente()">Matricula Docente</button>
	    <button type="button" class="btn btn-sm btn-info text-white position-relative"
		    onclick="listado_estudiantes_matriculados();">
	      List. est. matriculados
	      <span
		class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
		style="font-size: 0.6rem;">Nuevo</span>
	    </button>
	    <button type="button" class="btn btn-sm btn-info text-white position-relative"
		    onclick="listado_notas_estudiantes();">
	      Notas por estudiantes
	      <span
		class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
		style="font-size: 0.6rem;">Nuevo</span>
	    </button>
	  </nav>
	</div>
	<!-- fin de elementos -->
	
	<div  id="collapseLayouts3" aria-labelledby="headingOne"
	     data-bs-parent="#sidenavAccordion">

	  <nav class="sb-sidenav-menu-nested nav d-flex flex-row flex-wrap justify-content-start"
		      style="gap: 10px; padding: 10px; background: rgba(255,255,255,0.1); border-radius: 5px;">
	    <a class="btn btn-sm btn-success" href="listado_docentes.php" target="_blank">Lista
	      de docentes</a>
	    <button type="button" class="btn btn-sm btn-success" onclick="avance_semanal();">Avance
	      notas</button>

	    <button type="button" class="btn btn-sm btn-success position-relative"
		    onclick="boletin()">Boletin
	      <span
		class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
		style="font-size: 0.5rem; line-height: 1;">Nuevo<br>prees.</span>
	    </button>

	    <button type="button" class="btn btn-sm btn-success position-relative"
		    onclick="crear_pdf()">Certificado
	      <span
		class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
		style="font-size: 0.6rem;">Nuevo</span>
	    </button>

	    <button type="button" class="btn btn-sm btn-success" onclick="cuadro();">Cuadro de
	      notas</button>
	    <button type="button" class="btn btn-sm btn-success" onclick="notas_faltantes()">Notas
	      faltantes</button>
	  </nav>
	</div>
      </div><!-- fin del div del menu de botones -->

      <div class="sb-sidenav-footer">
	<div class="small">Registrado como:</div>
	<?php echo ucwords(strtolower($d->nombres)) . " " . ucwords(strtolower($d->apellidos)); ?>
      </div>
      </nav>

      

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
