<?php 
session_start();
if (isset($_SESSION["usuario"])){
    $usuario =  $_SESSION["usuario"];
} else {
    header("Location:login_boletines.php");
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
	<title>panel</title>
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
	 
	 a{
	     color: black;
	     
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

	 // Funcion en java scrip para ingresar valores en la base de datos
	 // para todas las opciones del menu adiccionar
	 // permite agregar estudiantes, docentes, notas etc ...

	 function deposit() {

             // para ello comienza
             // almacenando el codigo del grado en la variable j
             var j = $("#id_g").val();


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

                     // serializo los campos clase  logro 1
                     var logros1 = $('.logros1').serializeArray();
                     // serializo los campos clase logro 2
                     var logros2 = $('.logros2').serializeArray();
                     // serializo los campos clase logro 3
                     var logros3 = $('.logros3').serializeArray();
                     // serializo los codigos
                     var codigos = $('.codigo').serializeArray();
                     // serializo las  faltas
                     var faltas = $('.faltas').serializeArray();

                     // categorias para el seguimiento semanal

                     // serializo los  campos del criterio A
                     var A = $('.A').serializeArray();
                     // serializo los  campos del criterio B
                     var B = $('.B').serializeArray();
                     // serializo los  campos del criterio C
                     var C = $('.C').serializeArray();
                     // serializo los  campos del criterio D
                     var D = $('.D').serializeArray();
                     // serializo los  campos del criterio E
                     var E = $('.E').serializeArray();
                     // serializo los  campos del criterio F
                     var F = $('.F').serializeArray();
                     // serializo los  campos del criterio G
                     var G = $('.G').serializeArray();
                     // serializo los  campos del criterio H
                     var H = $('.H').serializeArray();
                     // serializo los  campos del criterio I
                     var I = $('.I').serializeArray();
                     // serializo los  campos del criterio J
                     var J = $('.J').serializeArray();
                     // serializo los  campos del criterio L
                     var L = $('.L').serializeArray();


		     // llamo al metodo ajax para el envío de la  información
		     // se emplea en envío por POST
                     $.ajax({
                         type: "POST",
                         url: "notas_semanales.php",
                         data: {
                             year: $("#years").val(),
                             semana: $("#semana").val(),
                             id_gs: $("#id_g").val(),
                             id_ms: $("#id_ms").val(),
                             id_jornada: $("#jornada").val(),
                             id_docente: $("#id_d").val(),
                             corte: $("#corte").val(),
                             periodo: $("#periodos").val(),
                             logro1: JSON.stringify(logros1),
                             logro2: JSON.stringify(logros2),
                             logro3: JSON.stringify(logros3),
                             codigo: JSON.stringify(codigos),
                             faltas: JSON.stringify(faltas),
                             A: JSON.stringify(A),
                             B: JSON.stringify(B),
                             C: JSON.stringify(C),
                             D: JSON.stringify(D),
                             E: JSON.stringify(E),
                             F: JSON.stringify(F),
                             G: JSON.stringify(G),
                             H: JSON.stringify(H),
                             I: JSON.stringify(I),
                             J: JSON.stringify(J),
			     L: JSON.stringify(L)
                         },

                         success: function(data) {
			     // respuesta a la carga de notas
                             //$("#resultado").html("Se ingresaron las notas con exito");
                             //$("#resultado").html(data);
                             console.log(data);

                         },
                         error: function(xhr, status) {
                             swal('Disculpe, existió un problema');
                             console.log(xhr);
                         }
                     });
                 }

             });
	 } // fin de la funsion deposit

	</script>


	<script>

	 // funcion para la carga de los alumnos
	 function est(id_a){
	     swal("Has ingresado el alumno"+id_a);

	     
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
		 url: "listado_estudiantes.php",
		 data: {
                     years: $("#years").val(),
		     id_g: $("#id_g").val(),
		     id_ms: $("#id_ms").val(),
		     id_jornada: $("#jornada").val(),
		     periodo: $("#periodos").val(),
		     curso: $("#id_c").val(),
		     semana: $("#semana").val()
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
		     semana: $("#semana").val()
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
	<div id="content" class="container">
	    <?php $hoy = Date("Y-m-d hh:mm"); ?>
	    <div class="row align-items-center">
		<div class="col"></div>
		<div class="col">
		    <a href="fc.php">
			<svg xmlns="http://www.w3.org/2000/svg" width="5em" height="5em" fill="currentColor" class="bi bi-file-bar-graph" viewBox="0 0 16 16">
			    <path d="M4.5 12a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1zm3 0a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm3 0a.5.5 0 0 1-.5-.5v-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5h-1z"/>
			    <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
			</svg></a>
		</div>
		<div class="col"></div>
	    </div>

	    <div class="row align-items-center">
		<div class="col"></div>
		<div class="col">
		    <a href="fc.php">
			
			Calificaciones</a>
		</div>
		<div class="col"></div>
	    </div>
	    
	    <div class="row align-items-center">
		<div class="col"></div>
		<div class="col">
		    <a href="fc_red.php">	
			<svg xmlns="http://www.w3.org/2000/svg" width="5em" height="5em" fill="currentColor" class="bi bi-file-bar-graph-fill" viewBox="0 0 16 16">
			    <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-2 11.5v-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1z"/>
			</svg>
		    </a>
		</div>
		<div class="col"></div>
	    </div>

	    <div class="row align-items-center">
		<div class="col"></div>
		<div class="col">
		    <a href="fc_red.php">Extra</a>
		</div>
		<div class="col"></div>
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
