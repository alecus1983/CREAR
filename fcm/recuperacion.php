<?php
session_start();
if (isset($_SESSION["usuario"])){
    $usuario =  $_SESSION["usuario"];
} else {
    header("Location:login_boletines_recuperacion.php");
    exit;
}

require_once('datos.php');

$d = new docentes();
$d->get_docente_cc($usuario);
$id = $d->id;
$admin = $d->admin ;
$ano = date('Y');
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
	<script src="js/all.js" ></script>
	<link href="../imagenes/escudo.gif" rel="shortcut icon"/>
	<script src="./js/sweetalert.min.js"></script>
	<script src="./js/jquery-3.5.1.min.js"></scrip>
	 <script src="./js/ajax.js"></script>
	<link rel="stylesheet" href="estilos.css" type="text/css">

	<style>
	 input[type=number]::-webkit-inner-spin-button,
	 input[type=number]::-webkit-outer-spin-button {
             -webkit-appearance: none;
	     margin: 0;
	 }

	 input[type=number] { -moz-appearance:textfield; }

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
	     0% { -webkit-transform: rotate(0deg); }
	     100% { -webkit-transform: rotate(360deg); }
	 }

	 @keyframes spin {
	     0% { transform: rotate(0deg); }
	     100% { transform: rotate(360deg); }
	 }
	</style>


	<script type="text/javascript">

	 
	 /////////////////////////////////////////////////////////////////////////
	 //                                                                     //
	 // Funcion en java scrip para ingresar valores en la base de datos     //
	 // para todas las opciones                                             //
	 // permite agregar estudiantes, docentes, notas etc ...                //
	 //                                                                     //
	 /////////////////////////////////////////////////////////////////////////

	 function deposit() {

             // para ello comienza
             // almacenando el codigo del grado en la variable j
             var j = $("#id_g").val();

	     // Mensaje flotante de confirmación
	     
             swal({
                 title: 'INSERTAR NOTAS',
                 text: "Esta seguro que quiere insertar las notas!",
                 icon: 'warning',
                 buttons: true,
                 buttons: ["cancelar", "insertar"],
             }).then((value) => {
                 if (value) {

                     // creo un array a partir de los
                     // elementos pertenecientes a  una misma clase

                     // serializo los codigos
                     var codigos = $('.codigo').serializeArray();

                     // categorias para el seguimiento

                     // serializo los  campos del criterio R
                     var R = $('.R').serializeArray();
                     
                     // serializo los  campos del criterio L
                     var L = $('.L').serializeArray();
		     var valido = true;
		     // valido los datos antes de enviarlos

		     $('.R').each( function (a){

			 if($(this)[0].value > 5){
			     valido = false;
			 }
		     } )

		     // Si los datos son validos

		     if(valido){
			 // llamo al metodo ajax para el envío de la  información
			 // se emplea en envío por POST
			 
			 $.ajax({
			   type: "POST",
			       dataType: "json",
			       url: "notas_r.php",
			       data: {
			     year: $("#years").val(),
				 id_gs: $("#id_g").val(),
				 id_ms: $("#id_ms").val(),
				 id_jornada: $("#jornada").val(),
				 id_docente: $("#id_d").val(),
				 corte: $("#corte").val(),
				 periodo: $("#periodos").val(),
				 codigo: JSON.stringify(codigos),
				 R: JSON.stringify(R),
				 L: JSON.stringify(L)
                             },

                             success: function(respuesta) {
				 // respuesta a la carga de notas
				 //$("#resultado").html("Se ingresaron las notas con exito");
				 //$("#resultado").html(data);
				 console.log(respuesta);
				 swal(respuesta['html']);
				 if (respuesta['status']==1){

				     swal('Bien',respuesta['html'],'success');
				     
				 } else {

				     if(respuesta['status']==20){swal('Error',respuesta['html'],'error');}
				 }

                             },
                             error: function(xhr, status) {
				 swal('Disculpe, existió un problema');
				 console.log(xhr);
                             }
			 });
		     } // fin de valido
		     else {
			 swal("Revise los datos","No se ingresaron los datos \t porque tiene notas mayores que 5","error");
		     }
                 }

             });
	 } // fin de la funsion deposit

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
		     year : $("#years").val(),
		     periodo: $("#periodos").val()

		 } ,
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
             //event.preventDefault();


	 }

	 // funsion que carga las semanas correctas cuando cambia
	 // el Periodo de calificaciones
	 // funcion para cargar las materias en el cuadro de dialogo
	 // de acurdo al grado seleccionado

	 function load_materias(){
             var id_docente = $("#id_d").val();
             var id_grado = $("#id_g").val();
             var year = $("#years").val();
             carga("#id_ms", "materias_grado.php",{grados:id_grado,id: id_docente, year:year});
	 }

	 // funcion para cargar la lista de  estudiantes en el
	 // div calificador
	 function load_lista_estudiantes(){

	     // se invoca al metodo ajax para solicitar
	     // el listado de estudiantes
	     $.ajax({
		 type: "POST",
		 url: "listado_estudiantes_recuperacion.php",
		 data: {
                     years: $("#years").val(),
		     id_g: $("#id_g").val(),
		     id_ms: $("#id_ms").val(),
		     id_jornada: $("#jornada").val(),
		     periodo: $("#periodos").val(),
		     curso: $("#id_c").val(),
		 } ,
		 // si los datos son correctos entonces ...
		 success: function(respuesta) {

		     $("#calificador").html(respuesta);
		     $("#resultado").html("");

		 },
		 error: function(xhr, status) {
		     swal('Disculpe, existió un problema');
		     console.log(xhr);
		 }
	     });

	 }

	 // funcion para la carga de logros
	 function load_logros () {

	     $.ajax({
		 type: "POST",
		 url: "logros.php",
		 data: {
		     grado: $("#id_g").val(),
		     materia: $("#id_ms").val(),
		 } ,
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

	 // avance semanal de notas de docentes
	 function avance_semanal() {


	     // se invoca al metodo ajax para solicitar
	     // el listado de estudiantes
	     $.ajax({
		 type: "POST",
		 url: "notas_docentes_semanales.php",
		 data: {
                     years: $("#years").val(),
		     periodo: $("#periodos").val(),
		 } ,
		 // si los datos son correctos entonces ...
		 success: function(respuesta) {

		     //$("#calificador").html(respuesta);
		     $("#resultado").html(respuesta);

		 },
		 error: function(xhr, status) {
		     swal('Disculpe, existió un problema');
		     console.log(xhr);
		 }
	     });


	 }

	 // actualiza el formulario
	 function actualizar(){
	     load_materias();
	     load_lista_estudiantes();
	 }

	</script>

	<!-- scrip -->
	<script>
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
	 function carga ( a ,b,c ) {

	     console.log("Valor a: %s",a); 	// variable que almacena el codigo del campo
	     console.log("Valor b: %s",b);	// variable que almacena el nombre del archivo PHP
	     console.log(JSON.stringify(c));	// parametro que se transmite  mediante ajax

	     // $.post(b, c,
	     $.ajax({
		 async: true,
		 method: "POST",
		 url : b,
		 data: c,
		 dataType:"json",

	     }).done(  function (dato) {
		 $(a).empty();

		 $(a).append("<option value = -1> Seleccione </option>");
		 $.each(dato, function(index, materia) {
		     $(a).append("<option value ="+ index+">" + materia + "</option>");

		 });
	     });

	 }


	 jQuery.ajaxSetup({
             beforeSend: function() {
		 $('#loader').show();
             },
	     complete: function(){
		 $('#loader').hide();
	     }
	 });

	</script>
    </head>

    <body class="sb-nav-fixed">

	<div class="loader" style="display:none" id="loader"></div>
	<div id="content">
	    <?php $hoy = Date("Y-m-d hh:mm"); ?>
	    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
		<!-- Navbar Brand-->
		<a class="navbar-brand ps-3" href="board.php">INICIO</a>
		<!-- Sidebar Toggle-->
		<button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0"
			id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
		<a style="color:FFF" href="#"></a>
		<!-- Navbar-->
		<ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
		    <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle"
			   id="navbarDropdown" href="#"
			   role="button" data-bs-toggle="dropdown"
			   aria-expanded="false"><i class="fas fa-user fa-fw"></i>
			    <?php echo ucwords(strtolower($d->nombres))." ".ucwords(strtolower($d->apellidos));?> </a>
			<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

			    <li><a class="dropdown-item" href="logout.php">Salir</a></li>
			</ul>
		    </li>
		</ul>
	    </nav>
	    <div id="layoutSidenav">
		<div id="layoutSidenav_nav">
		    <nav class="sb-sidenav bg-light" id="sidenavAccordion">

			<div class="nav" style="padding:1rem;">

			    <div id="collapseLayouts"
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
				    <?php if ($admin !== 1) { ?>
					
				    <?php } ?>

                        class="form-control ">

				    <input type="hidden" value="<?php echo $id; ?>" id="id_d">

				    <label for="jornada">Jornada</label>
				    <select id="jornada"
						style="background: transparent;color: darkgreen;border: 0px"
						class="form-control"
						onchange="actualizar();">
					<option value="1">Mañana</option>
					<option value="2">Tarde</option>
				    </select>

				    <label for="periodos"> Periodo</label>
				    <select id="periodos"
						style="background: transparent;color: darkgreen;border: 0px"
						name="periodos"
						class="form-control" required=""
							     onchange="load_lista_estudiantes();load_materias();">
					<?php

					if($admin){
					    echo '<option value="1">1</option>
					    <option value="2">2</option>
					    <option value="3">3</option>
					    <option value="4">4</option>';
					}

					else {
					    $s = new semana();
					    $sem  = $s->get_periodo_activo($ano);
					    echo "<option value='$sem' selectecd>$sem </option>";
					}
					?>
				    </select>


				    <label class="Control-label">Grado</label>
				   	<select id="id_g" name="id_gs"
						    class ="form-control"
						    style="background: transparent;color: darkgreen;border:  0px"
						    onchange="actualizar()">
					    <?php
					    // creo un nuevo objeto  matricula docente
					    $mt = new matricula_docente();
					    // asigno el año a la matricula como el a actual
					    $mt->year = date('Y');
					    // defino el codigo del docente de la matricula
					    $mt->id_docente = $id;
					    //actuliza el listado de cursos disponibles
					    $mt->get_matricula(2);
					    // conviere el dato en un json
					    //echo json_encode($mt->listado);
					    $lista = $mt->listado;
					    echo '<option value="-1">seleccione</option>';
					    foreach ($lista as $key => $value) {
					    	echo '<option value="'.$key.'">'.$value.'</option>';
					    }
					    ?>
				    </select>

				    <label class="Control-label">Curso</label>
				    <select id="id_c"
					    style="background: transparent;color: darkgreen;border:0px;"
					    onchange = "load_lista_estudiantes();"
					    class ="form-control">
					<option value="0">A</opcion>
					    <option value="1">B</opcion>
				    </select>

				    <label for="id_ms">Materia</label>
				    <select id="id_ms"
					    style="background: transparent;color: darkgreen;border: 0px"
					    name="id_ms" onchange="load_lista_estudiantes();"
					    class="form-control">
				    </select>

				</nav>
			    </div>
                        </div>
                </div>
                <div>
		    <?php
                    if($admin){
                        //echo '<a style="margin: 2rem;" class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages" href="listado_docentes.php" target="_blank">lista de docentes</a>';
                        //echo '<a style="margin: 2rem;" class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages" target="#" onclick="avance_semanal();">Avance notas semanales</a>';
                        //echo '<a style="margin: 2rem;" class="nav-link collapsed" aria-expanded="false" aria-controls="collapsePages" href="fs.php" target="_self">Gestión de semanas</a>';

                    }
		    ?>
		</div>
		<div class="sb-sidenav-footer">
                    <div class="small">Registrado(a) como:</div>
                    <?php echo ucwords(strtolower($d->nombres))." ".ucwords(strtolower($d->apellidos));?>
                </div>
                    </nav>
            </div>


            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">FORMULARIO RECUPERACIONES <?php echo date('Y'); ?></h1>
                        <ol class="breadcrumb mb-4">
			    <li class="breadcrumb-item active">Para  la gestión de recuperaciones</li>
                        </ol>

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
					    <button type="button"
						    style="margin: 20px auto auto; display: block;"
						    class="btn btn-outline-success"
						    value="INGRESAR"
						    id="ingresar" onclick="deposit();">
						Ingresar
					    </button>

					</div>
				    </div>
				</div>
			    </div>
			</div>
                    </div>
            </div>
                </main>
        </div>
        </div>
        </div>

        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Mundo Creativo 2023</div>
                    <div>
                        <a href="#">Politica de privacidad</a>
                        &middot;
			<a href="#">Terminos &amp; Condiciones</a>
		    </div>
		</div>
	    </div>
	</footer>
	<script src="./js/bootstrap.bundle.min.js" ></script>
        <script src="./js/scripts.js"></script>
        <script src="./js/Chart.min.js" ></script>
        <script src="./assets/demo/chart-area-demo.js"></script>
        <script src="./assets/demo/chart-bar-demo.js"></script>
        <script src="./js/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="./js/datatables-simple-demo.js"></script>
    </body>
</html>
