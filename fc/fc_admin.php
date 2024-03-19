<?php
session_start();

require_once('datos.php');
if (isset($_SESSION["usuario"])){
    $usuario =  $_SESSION["usuario"];
    $d = new docentes();
    $d->get_docente_cc($usuario);
    $id = $d->id;
    $admin = $d->admin ;

    $ano = date('Y');
    if($admin == 0){
        header("Location:board.php");
    }

    if (isset($_SESSION["usuario"])){
	$usuario =  $_SESSION["usuario"];

    } else {
	header("Location:board.php");
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
			     id_curso: $("#id_c").val(),
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
		     $("#avance").html(respuesta);

		 },
		 error: function(xhr, status) {
		     swal('Disculpe, existió un problema');
		     console.log(xhr);
		 }
	     });

	 }


	 // avance semanal de notas de docentes
	 function notas_faltantes() {


	     // se invoca al metodo ajax para solicitar
	     // el listado de estudiantes
	     $.ajax({
		 type: "POST",
		 url: "listado_calificaciones_faltantes.php",
		 data: {
                     years: $("#years").val(),
		     periodo: $("#periodos").val(),
		     semana: $("#semana").val(),
		     id_g: $("#id_g").val(),
		     id_ms: $("#id_ms").val(),
		     id_jornada: $("#jornada").val(),
		     id_curso: $("#id_c").val(),
		 } ,
		 // si los datos son correctos entonces ...
		 success: function(respuesta) {

		     //$("#calificador").html(respuesta);
		     $("#avance").html(respuesta);

		 },
		 error: function(xhr, status) {
		     swal('Disculpe, existió un problema');
		     console.log(xhr);
		 }
	     });

	 }


	 <<<<<<< HEAD
	 <<<<<<< HEAD
	 // llamado para agregar certificados
	 function certificado() {

	     // se invoca al metodo ajax para solicitar
	     // el listado de estudiantes
	     $.ajax({
		 type: "POST",
		 url: "certificado.php",
		 data: {
                     years: $("#years").val(),
		     periodo: $("#periodos").val(),
		     semana: $("#semana").val(),
		     id_g: $("#id_g").val(),
		     id_ms: $("#id_ms").val(),
		     id_jornada: $("#jornada").val(),
		     id_curso: $("#id_c").val(),
		 } ,
		 // si los datos son correctos entonces ...
		 success: function(respuesta) {

		     //$("#calificador").html(respuesta);
		     $("#avance").html(respuesta);

		 },
		 error: function(xhr, status) {
		     swal('Disculpe, existió un problema');
		     console.log(xhr);
		 }
	     });

	 }


	 function eliminar_semana(){
	     =======
	 	 function eliminar_semana(){
		     >>>>>>> origin/fc
		     =======
	 		 function eliminar_semana(){
			     >>>>>>> refs/remotes/origin/main


			     // se invoca al metodo ajax para solicitar
			     // el listado de las semanas
			     $.ajax({
				 type: "POST",
				 url: "eliminar_semana.php",
				 dataType: "json",
				 data: {
				     semana:$("#lista_semanas").val()


				 } ,
				 // si los datos son correctos entonces ...
				 success: function(respuesta) {
				     // si la respuesta es positiva
				     if(respuesta['status']==1){
					 //swal('Datos actualizados');
					 //$("#calificador").html(respuesta);
					 //$("#avance").html(respuesta['html']);
					 gestion_semanas();
					 swal("Completado","Se actualizo la semana","success");
				     } else {
					 if(respuesta['status'] == 20){swal('Error','no se pudo actualizar la semana','error');}
					 if(respuesta['status'] == 22){swal('Año','Porfavor seleccione un año','error');}
					 if(respuesta['status'] == 23){swal('Fecha','Porfavor seleccione una fecha de inicio','error');}
					 if(respuesta['status'] == 24){swal('Fecha','Porfavor seleccione una fecha de fin','error');}
					 if(respuesta['status'] == 25){swal('Año','Porfavor seleccione una fecha de inicio menor a la de fin','error');}
					 if(respuesta['status'] == 26){swal('Semana','Porfavor seleccione una semana','error');}
				     }
				 },
				 error: function(xhr, status) {
				     swal('Disculpe, existió un problema');
				     console.log(xhr);
				 }
			     });
			 }
		     // funcion que cambia semanas
		     function actualizar_semana(){


			 // se invoca al metodo ajax para solicitar
			 // el listado de las semanas
			 $.ajax({
			     type: "POST",
			     url: "actualizar_semana.php",
			     dataType: "json",
			     data: {
				 years: $("#years").val(),
				 inicio: $("#inicio").val(),
				 fin: $("#fin").val(),
				 semana:$("#lista_semanas").val()


			     } ,
			     // si los datos son correctos entonces ...
			     success: function(respuesta) {
				 // si la respuesta es positiva
				 if(respuesta['status']==1){
				     //swal('Datos actualizados');
				     //$("#calificador").html(respuesta);
				     //$("#avance").html(respuesta['html']);
				     gestion_semanas();
				     swal("Completado","Se actualizo la semana","success");
				 } else {
				     if(respuesta['status'] == 20){swal('Error','no se pudo actualizar la semana','error');}
				     if(respuesta['status'] == 22){swal('Año','Porfavor seleccione un año','error');}
				     if(respuesta['status'] == 23){swal('Fecha','Porfavor seleccione una fecha de inicio','error');}
				     if(respuesta['status'] == 24){swal('Fecha','Porfavor seleccione una fecha de fin','error');}
				     if(respuesta['status'] == 25){swal('Año','Porfavor seleccione una fecha de inicio menor a la de fin','error');}
				     if(respuesta['status'] == 26){swal('Semana','Porfavor seleccione una semana','error');}
				 }
			     },
			     error: function(xhr, status) {
				 swal('Disculpe, existió un problema');
				 console.log(xhr);
			     }
			 });
		     }

		     // funcion que llama el formulario de gestionar las
		     // semas
		     function gestion_semanas() {

			 // se invoca al metodo ajax para solicitar
			 // el listado de las semanas
			 $.ajax({
			     type: "POST",
			     url: "listado_semanas.php",
			     dataType: "json",
			     data: {
				 years: $("#years").val(),
				 periodo: $("#periodos").val(),
				 semana: $("#semana").val(),
				 id_g: $("#id_g").val(),
				 id_ms: $("#id_ms").val(),
				 id_jornada: $("#jornada").val(),
				 id_curso: $("#id_c").val(),

			     } ,
			     // si los datos son correctos entonces ...
			     success: function(respuesta) {
				 // si la respuesta es positiva
				 if(respuesta['status']==1){
				     //swal('Datos actualizados');
				     //$("#calificador").html(respuesta);
				     $("#avance").html(respuesta['html']);
				 } else {
				     if(respuesta['status'] == 21){swal('Grado','Porfavor seleccione un grado','error');}
				     if(respuesta['status'] == 22){swal('Año','Porfavor seleccione un año','error');}
				     if(respuesta['status'] == 23){swal('Jornada','Porfavor seleccione un jornada','error');}
				     if(respuesta['status'] == 24){swal('Semana','Porfavor seleccione una semana','error');}

				 }
			     },
			     error: function(xhr, status) {
				 swal('Disculpe, existió un problema');
				 console.log(xhr);
			     }
			 });

		     }

		     // muesta el formulario de docentes en un grado
		     function matricula_docente() {

			 // se invoca al metodo ajax para solicitar
			 // el listado de estudiantes
			 $.ajax({
			     type: "POST",
			     url: "listado_matricula_docente.php",
			     dataType: "json",
			     data: {
				 years: $("#years").val(),
				 periodo: $("#periodos").val(),
				 semana: $("#semana").val(),
				 id_g: $("#id_g").val(),
				 id_ms: $("#id_ms").val(),
				 id_jornada: $("#jornada").val(),
				 id_curso: $("#id_c").val(),

			     } ,
			     // si los datos son correctos entonces ...
			     success: function(respuesta) {
				 // si la respuesta es positiva
				 if(respuesta['status']==1){
				     //swal('Datos actualizados');
				     //$("#calificador").html(respuesta);
				     $("#avance").html(respuesta['html']);
				 } else {
				     if(respuesta['status'] == 21){swal('Grado','Porfavor seleccione un grado','error');}
				     if(respuesta['status'] == 22){swal('Año','Porfavor seleccione un año','error');}
				     if(respuesta['status'] == 23){swal('Jornada','Porfavor seleccione un jornada','error');}
				     if(respuesta['status'] == 24){swal('Semana','Porfavor seleccione una semana','error');}

				 }
			     },
			     error: function(xhr, status) {
				 swal('Disculpe, existió un problema');
				 console.log(xhr);
			     }
			 });

		     }


		     function agregar_matricula_docente() {



			 // se invoca al metodo ajax para solicitar
			 // el listado de estudiantes
			 $.ajax({
			     type: "POST",
			     url: "add_matricula_docente.php",
			     dataType: "json",
			     data: {
				 years: $("#years").val(),
				 periodo: $("#periodos").val(),
				 semana: $("#semana").val(),
				 id_g: $("#id_g").val(),
				 id_ms: $("#id_materia_md").val(),
				 id_jornada: $("#jornada").val(),
				 id_curso: $("#id_c").val(),
				 id_docente: $("#id_docente_mt").val()

			     } ,
			     // si los datos son correctos entonces ...
			     success: function(respuesta) {
				 // si la respuesta es positiva
				 if(respuesta['status']==1){
				     //swal('Datos actualizados');
				     swal('Actualizacion','Se insertaron los dastos con éxito','success');
				     matricula_docente();
				 } else {
				     if(respuesta['status'] == 21){swal('Grado','Porfavor seleccione un grado','error');}
				     if(respuesta['status'] == 22){swal('Año','Porfavor seleccione un año','error');}
				     if(respuesta['status'] == 23){swal('Jornada','Porfavor seleccione un jornada','error');}
				     if(respuesta['status'] == 24){swal('Semana','Porfavor seleccione una semana','error');}
				     if(respuesta['status'] == 25){swal('Materia','Porfavor seleccione una materia','error');}
				     if(respuesta['status'] == 26){swal('Curso','Porfavor seleccione un curso','error');}
				     if(respuesta['status'] == 27){swal('Docente','Porfavor seleccione un docente','error');}
				 }
			     },
			     error: function(xhr, status) {
				 swal('Disculpe, existió un problema');
				 console.log(xhr);
			     }
			 });

		     }

		     function eliminar_matricula_docente(id) {



			 // se invoca al metodo ajax para solicitar
			 // el listado de estudiantes
			 $.ajax({
			     type: "POST",
			     url: "del_matricula_docente.php",
			     dataType: "json",
			     data: {
				 id: id

			     } ,
			     // si los datos son correctos entonces ...
			     success: function(respuesta) {
				 // si la respuesta es positiva
				 if(respuesta['status']==1){
				     //swal('Datos actualizados');
				     swal('Actualizacion','Se elimino el docente del curso','success');
				     matricula_docente();
				 } else {
				     if(respuesta['status'] == 20){swal('Error','Hubo un error al eliminar la matricula docente','error');}
				     if(respuesta['status'] == 21){swal('Error','Hubo un error al eliminar la matricula docente','error');}
				 }
			     },
			     error: function(xhr, status) {
				 swal('Disculpe, existió un problema');
				 console.log(xhr);
			     }
			 });

		     }

		     function requisitos_grado() {

			 // se invoca al metodo ajax para solicitar
			 // el listado de estudiantes
			 $.ajax({
			     type: "POST",
			     url: "listado_requisitos.php",
			     dataType: "json",
			     data: {
				 years: $("#years").val(),
				 id_g: $("#id_g").val(),
				 id_ms: $("#id_materia_mt").val(),
				 id_curso: $("#id_c").val(),
				 periodo: $("#periodos").val(),
				 id_jornada: $("#jornada").val(),
				 semana: $("#semana").val()
			     } ,
			     // si los datos son correctos entonces ...
			     success: function(respuesta) {
				 // si la respuesta es positiva
				 if(respuesta['status']==1){
				     //swal('Datos actualizados');
				     //$("#calificador").html(respuesta);
				     $("#avance").html(respuesta['html']);
				 } else {
				     if(respuesta['status'] == 20){swal('Consulta','Fallo al intentar ingresar el requisito','error');}
				     if(respuesta['status'] == 21){swal('Grado','Porfavor seleccione un grado','error');}
				     if(respuesta['status'] == 22){swal('Año','Porfavor seleccione un año','error');}
				     if(respuesta['status'] == 23){swal('Jornada','Porfavor seleccione un jornada','error');}
				     if(respuesta['status'] == 24){swal('Semana','Porfavor seleccione una semana','error');}
				     if(respuesta['status'] == 25){swal('Materia','Porfavor seleccione una materia','error');}
				 }
			     },
			     error: function(xhr, status) {
				 swal('Disculpe, existió un problema');
				 console.log(xhr);
			     }
			 });

		     }

		     function agregar_requisito() {

			 // se invoca al metodo ajax para solicitar
			 // el listado de estudiantes
			 $.ajax({
			     type: "POST",
			     url: "add_requisitos.php",
			     dataType: "json",
			     data: {
				 years: $("#years").val(),
				 id_g: $("#id_g").val(),
				 id_ms: $("#id_materia_mt").val(),
			     } ,
			     // si los datos son correctos entonces ...
			     success: function(respuesta) {
				 // si la respuesta es positiva
				 if(respuesta['status']==1){
				     swal('Actualizacion','Se insertaron los dastos con éxito','success');
				     requisitos_grado();
				 } else {
				     if(respuesta['status'] == 20){swal('Consulta','Fallo al intentar ingresar el requisito','error');}
				     if(respuesta['status'] == 21){swal('Grado','Porfavor seleccione un grado','error');}
				     if(respuesta['status'] == 22){swal('Año','Porfavor seleccione un año','error');}
				     if(respuesta['status'] == 23){swal('Jornada','Porfavor seleccione un jornada','error');}
				     if(respuesta['status'] == 24){swal('Semana','Porfavor seleccione una semana','error');}
				     if(respuesta['status'] == 25){swal('Materia','Porfavor seleccione una materia','error');}
				 }
			     },
			     error: function(xhr, status) {
				 swal('Disculpe, existió un problema');
				 console.log(xhr);
			     }
			 });

		     }


		     function eliminar_requisitos(id_materia,id_grado) {

			 // se invoca al metodo ajax para solicitar
			 // el listado de estudiantes
			 $.ajax({
			     type: "POST",
			     url: "del_requisito.php",
			     dataType: "json",
			     data: {
				 years: $("#years").val(),
				 id_g: id_grado,
				 id_ms: id_materia,
			     } ,
			     // si los datos son correctos entonces ...
			     success: function(respuesta) {
				 // si la respuesta es positiva
				 if(respuesta['status']==1){
				     swal('Actualizacion','Se elimino los requisitos con éxito','success');
				     requisitos_grado();
				 } else {
				     if(respuesta['status'] == 20){swal('Consulta','Fallo al intentar ingresar el requisito','error');}
				     if(respuesta['status'] == 21){swal('Grado','Porfavor seleccione un grado','error');}
				     if(respuesta['status'] == 22){swal('Año','Porfavor seleccione un año','error');}
				     if(respuesta['status'] == 23){swal('Jornada','Porfavor seleccione un jornada','error');}
				     if(respuesta['status'] == 24){swal('Semana','Porfavor seleccione una semana','error');}
				     if(respuesta['status'] == 25){swal('Materia','Porfavor seleccione una materia','error');}
				 }
			     },
			     error: function(xhr, status) {
				 swal('Disculpe, existió un problema');
				 console.log(xhr);
			     }
			 });

		     }

		     // funcion que obtiene los requisitos del grado
		     function eliminar_grado() {

			 // se invoca al metodo ajax para solicitar
			 // el listado de estudiantes
			 $.ajax({
			     type: "POST",
			     url: "del_requisito.php",
			     dataType: "json",
			     data: {
				 years: $("#years").val(),
				 id_g: $("#id_g").val(),
				 id_ms: $("#id_ms").val(),


			     } ,
			     // si los datos son correctos entonces ...
			     success: function(respuesta) {
				 // si la respuesta es positiva
				 if(respuesta['status']==1){
				     swal('Actualizacion','Se eliminaron los dastos con éxito','success');
				     requisitos_grado();
				 } else {
				     if(respuesta['status'] == 20){swal('Consulta','Fallo al intentar ingresar el requisito','error');}
				     if(respuesta['status'] == 21){swal('Grado','Porfavor seleccione un grado','error');}
				     if(respuesta['status'] == 22){swal('Año','Porfavor seleccione un año','error');}
				     if(respuesta['status'] == 23){swal('Jornada','Porfavor seleccione un jornada','error');}
				     if(respuesta['status'] == 24){swal('Semana','Porfavor seleccione una semana','error');}
				     if(respuesta['status'] == 25){swal('Materia','Porfavor seleccione una materia','error');}
				 }
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

		     function boletin() {
			 // almaceno el valor del grado
			 grado = $("#id_g").val();

			 if (grado == -1) {
			     swal("Datos", "Por favor seleccione un grado", "info");
			 } else if (grado < 7 || grado > 9) {
			     // llama a la funcion generar para generar el boletin
			     // que corresponde al modelo de primaria
			     crear_pdf();
			 } else {
			     // llama a la funcion generarx la cual genera el boletin tipo preescolar
			     obtener_pdf();
			 }
		     }

		     function crear_pdf(){
			 // esta función permite generar un un boletin en formato pdf
			 // se almacena  en la variable año
			 // alamcena el año seleccionado ( año lectivo calendario A)
			 var year = $("#years").val();
			 // se almacena la variable periodos con el periodo academico
			 // a seleccionar
			 var periodos = $('select#periodos').val();//
			 // la variable grados guarda codigo del grado del estudiante
			 var grados = $("#id_g").val();
			 // agrego la jornada
			 var jornada = $("#jornada").val();
			 // describo el curso
			 var curso = $("#id_c").val();

			 if (grados <0){
			     swal("Favor seleccione un grado");
			 }
			 else if(periodos <0){
			     swal("Favor seleccione un periodo");
			 }
			 else{

			     // se almacenan todas las variables dentro
			     // de la variable parametros
			     var parametros= "year="+year+
					     "&periodos="+
					     periodos+
					     "&grado="+grados+
					     "&jornada="+jornada+
					     "&curso="+curso;

			     console.log("los parametros son : %s",parametros);
			     // abro boletin en una nueva ventana
			     // llamando para ello al archivo cetificado.php
			     window.open("generar_p.php?"+parametros);
			 }

			 // si la opcion seleccionada es boletines entra aqui
			 //if (opcion == 6)
			 //{
			 //}
			 // de lo contrario mira si la opcion seleccionada es
			 // el certificado
			 //else if (opcion == 16)
			 //{

			 // almacena los parametros para enviar
			 // por el método GET
			 // var parametros= "year="+year+
			 //		 "&grado="+grados;
			 // muestro los parámetos por consola
			 //console.log("los parametros son : %s",parametros);
			 // abro el certificado en una nueva ventana
			 // llamando para ello al archivo cetificado.php
			 //window.open("certificado.php?"+parametros);
			 //}


			 // almacena los parametros para enviar
			 // por el método GET
			 // var parametros= "year="+year+
			 //		 "&grado="+grados;
			 // muestro los parámetos por consola
			 //console.log("los parametros son : %s",parametros);
			 // abro el certificado en una nueva ventana
			 // llamando para ello al archivo cetificado.php
			 //window.open("certificado.php?"+parametros);
			 //}

		     }



		     function obtener_pdf(){
			 // esta funcion crea un pdf para preescolar

			 // se almacena el año en la variable year
			 // se almacena el año en la variable year
			 var year = $("#years").val();
			 // se almacena el periodo
			 var periodos = $("#periodos").val();
			 // y se almacenan las variables grados
			 var gradosx = $("#id_gs").val();
			 var grados = $("#id_gs").val();

			 // se almacenan todas las variables dentro de la variable parametros
			 var parametros= "year="+year+"&periodos="+periodos+"&grados="+gradosx+"&id_gs="+gradosx+"";
			 console.log("los parametros son : %s",parametros);
			 window.open("generarx.php?"+parametros);
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
	    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
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
		    
		    <nav class="sb-sidenav accordion sb-sidenav-dark"
			 id="sidenavAccordion"

			 style="background-color: cadetblue">

			<div class="sb-sidenav-menu">
			    <div class="nav">
				<a class="nav-link collapsed" href="#"
				   data-bs-toggle="collapse"
				   data-bs-target="#collapseLayouts1"
				   aria-expanded="false" aria-controls="collapseLayouts1">

				    <div class="sb-sidenav-menu">
					<div class="nav">
					    <div class="sb-sidenav-menu-heading">Core</div>
					    <a class="nav-link" href="fc.php">
						<div class="sb-nav-link-icon">
						    <i class="fas fa-tachometer-alt"></i></div>
						FORMULARIO
					    </a>
					    <div class="sb-sidenav-menu-heading">DATOS</div>
					    <a class="nav-link collapsed" href="#"
					       data-bs-toggle="collapse"
					       data-bs-target="#collapseLayouts"
					       aria-expanded="false" aria-controls="collapseLayouts">
						<div class="sb-nav-link-icon">
						    <i class="fas fa-columns"></i></div>
						Datos
						<div class="sb-sidenav-collapse-arrow">
						    <i class="fas fa-angle-down"></i></div>
					    </a>

					    <div class="collapse" id="collapseLayouts"

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

						    <label for="jornada">Jornada</label>
						    <select id="jornada"

								style="background: transparent;color: darkgreen;border: 0px"
								class="form-control"
								onchange=";">

							<option value="1">Mañana</option>
							<option value="2">Tarde</option>
						    </select>

						    <label for="periodos">Periodo</label>
						    <select id="periodos"

							    style="background: transparent;color: darkgreen;border: 0px"
							    name="periodos"
							    class="form-control" required=""
								onchange="">

							style="background: transparent;color: darkgreen;border: 0px"
							name="periodos"
							class="form-control" required=""
							onchange="">

							<?php

							if($admin){
							    echo '<option value="1">1</option>
					    <option value="2">2</option>
					    <option value="3">3</option>
					    <option value="4">4</option>
					    <option value="5">Recuperacion</option>';
							}

							else {
							    $s = new semana();
							    $sem  = $s->get_periodo_activo($ano);
							    echo "<option value='$sem' selectecd>$sem </option>";
							}
							?>
						    </select>

						    <label for="semana">Semana</label>
						    <select id="semana"

							    class="form-control"
							    style="background: transparent;color: darkgreen;border: 0px"
							    onchange="load_lista_estudiantes();">

							<?php

							if ($admin) {
							    // opciones
							    $s = new semana();
							    $lista = $s->get_lista_semanas($ano);

							    foreach($lista as $sem) {
								echo "<option value='$sem'>$sem </option>";
							    }
							}

							else
							{
							    $s = new semana();
							    $sem  = $s->get_semana_activa($ano);
							    echo "<option value='$sem' selectecd>$sem </option>";
							}

							?>

						    </select>

						    <label class="Control-label">Grado</label>
						    <select id="id_g" name="id_gs"

								class ="form-control"
								style="background: transparent;color: darkgreen;border:  0px"
								onchange="actualizar();">

							<?php
							// creo un nuevo objeto  matricula docente
							$mt = new matricula_docente();
							// asigno el año a la matricula como el a actual
							$mt->year = date('Y');
							// defino el codigo del docente de la matricula
							$mt->id_docente = $id;
							//actuliza el listado de cursos disponibles
							$mt->get_matricula();
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
							    onchange = ";"
							    class ="form-control">

							<option value="0">A</opcion>
							    <option value="1">B</opcion>
						    </select>

						    <label for="id_ms">Materia</label>
						    <select id="id_ms"
							    style="background: transparent;color: darkgreen;border: 0px"
							    name="id_ms" onchange=""
							    class="form-control">
						    </select>

						</nav>

					    </div>

					</div>

					<a class="nav-link collapsed" href="#"
					   data-bs-toggle="collapse"
					   data-bs-target="#collapseLayouts2"
					   aria-expanded="false" aria-controls="collapseLayouts2">
					    <div class="sb-nav-link-icon">
						<i class="fas fa-columns"></i></div>
					    Elementos
					    <div class="sb-sidenav-collapse-arrow">
						<i class="fas fa-angle-down"></i></div>
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
					</div>

					<a class="nav-link collapsed" href="#"
					   data-bs-toggle="collapse"
					   data-bs-target="#collapseLayouts3"
					   aria-expanded="false" aria-controls="collapseLayouts3">
					    <div class="sb-nav-link-icon">
						<i class="fas fa-columns"></i></div>
					    Procesos
					    <div class="sb-sidenav-collapse-arrow">
						<i class="fas fa-angle-down"></i></div>
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
							  =======

						</a>
						<a style="margin: 0.5rem;"
						   class="nav-link"
						   href="fs.php" target="_self">Gestión de semanas
						</a>
						<a style="margin: 0.5rem;"
						   class="nav-link"
						   href="" target="_self"

						    <a style="margin: 0.5rem;"
						       class="nav-link"

						    </a>

						    <a style="margin: 0.5rem;"
						       class="nav-link"
						       href="#" target="_self"
						       onclick="notas_faltantes()">Notas faltantes
						    </a>
						    <a style="margin: 0.5rem;"
						       class="nav-link"
						       href="#" target="_self"
						       onclick="certificado()">Generar certificado
						    </a>

					    </nav>
					</div>

				    </div>
                            </div>
                            <div>
                            </div>
                        </div>
			
                        <div>
			    <a style="margin: 2rem;"
			       class="nav-link collapsed"
			       href="#"
			       data-bs-toggle="collapse"
			       data-bs-target="#collapsePages"
			       aria-expanded="false"
			       aria-controls="collapsePages"
			       href="listado_docentes.php"
			       target="_blank">lista de docentes
			    </a>
			    <a style="margin: 2rem;"
			       class="nav-link collapsed"
			       href="#"
			       data-bs-toggle="collapse"
			       data-bs-target="#collapsePages"
			       aria-expanded="false"
			       aria-controls="collapsePages"
			       target="#" onclick="avance_semanal();">Avance notas semanales
			    </a>
			    <a style="margin: 2rem;"
			       class="nav-link collapsed"
			       aria-expanded="false"
			       aria-controls="collapsePages"
			       href="fs.php" target="_self">Gestión de semanas
			    </a>
			    <a style="margin: 2rem;"
			       class="nav-link collapsed"
			       aria-expanded="false"
			       aria-controls="collapsePages"
			       href="" target="_self"
			       onclick="crear_pdf()">Boletin
			    </a>
			</div>

			
			<div class="sb-sidenav-footer">
                            <div class="small">Registrado como:</div>
                            <?php echo ucwords(strtolower($d->nombres))." ".ucwords(strtolower($d->apellidos));?>
                        </div>
			
                    </nav>
                </div>


                <div id="layoutSidenav_content">
                    <main>
                        <div class="container-fluid px-4">
                            <h1 class="mt-4">FORMULARIO  <?php echo date('Y'); ?></h1>
                            <ol class="breadcrumb mb-4">

				<li class="breadcrumb-item active">Para la gestistión de la plataforma CREAR</li>
                            </ol>

			    <div id="avance" class="row"></div>

                            <div id="f_semanas" class="row container" style="display:none;">


				<li class="breadcrumb-item active">Para la gestistión de las semanas</li>
                            </ol>

			    <div id="avance" class="row"></div>

                            <div id="f_semanas" class="row container" style="display:none;">


				<div class="col-md-5">
				    <div class="card border-primary border-6">
					<div class="card-header">
					    <i class="fas fa-chart-area me-1"></i>
					    semanas primer periodo
					</div>
					<div class="card-body container">
					    <div class="row align-items-center">

						<div class="col-md-6">
						    <div class="form-group">
							<label for="inicio1"
							       class="form-label text-muted fst-italic">
							    inicio semana 1</label>
							<input type="date" id="inicio1" class="form-control" >
						    </div>
						</div>
						<div class="col-md-6">
						    <div class="form-group ">
							<label for="fin1"
							       class="form-label text-muted fst-italic">
							    fin semana 1
							</label>
							<input type="date" id="fin1" class="form-control" >
						    </div>
						</div>


					    </div>

					    <div class="row align-items-center">

					    </div>

					    <div class="row align-items-center">


						<div class="col-md-6">
						    <div class="form-group">
							<label for="inicio2"
							       class="form-label text-muted fst-italic">
							    inicio semana 2
							</label>
							<input type="date" id="inicio2" class="form-control" >
						    </div>
						</div>
						<div class="col-md-6">
						    <div class="form-group ">
							<label for="fin2"
							       class="form-label text-muted fst-italic">
							    fin semana 2
							</label>
							<input type="date" id="fin2" class="form-control" >
						    </div>
						</div>

					    </div>

					    <div class="row align-items-center">
					    </div>

					    <div class="row align-items-center">

						<div class="col-md-6">
						    <div class="form-group">
							<label for="inicio3"
							       class="form-label text-muted fst-italic">
							    inicio semana 3
							</label>
							<input type="date" id="inicio3" class="form-control" >
						    </div>
						</div>
						<div class="col-md-6">
						    <div class="form-group ">
							<label for="fin3"
							       class="form-label text-muted fst-italic">
							    fin semana 3
							</label>
							<input type="date" id="fin3" class="form-control" >
						    </div>
						</div>

					    </div>

					    <div class="row align-items-center">


					    </div>

					    <div class="row align-items-center">

						<div class="col-md-6">
						    <div class="form-group">
							<label for="inicio4"
							       class="form-label text-muted fst-italic">
							    inicio semana 4
							</label>
							<input type="date" id="inicio4" class="form-control" >
						    </div>
						</div>
						<div class="col-md-6">
						    <div class="form-group ">
							<label for="fin4"
							       class="form-label text-muted fst-italic">
							    fin semana 4
							</label>
							<input type="date" id="fin4" class="form-control" >
						    </div>
						</div>


					    </div>

					    <div class="row align-items-center">


					    </div>

					    <div class="row align-items-center">

						<div class="col-md-6">
						    <div class="form-group">
							<label for="inicio5"
							       class="form-label text-muted fst-italic">
							    inicio semana 5
							</label>
							<input type="date" id="inicio2" class="form-control" >
						    </div>
						</div>
						<div class="col-md-6">
						    <div class="form-group ">
							<label for="fin5"
							       class="form-label text-muted fst-italic">
							    fin semana 5
							</label>
							<input type="date" id="fin5" class="form-control" >
						    </div>
						</div>

					    </div>

					    <div class="row align-items-center">



					    </div>

					    <div class="row align-items-center">

						<div class="col-md-6">
						    <div class="form-group">
							<label for="inicio6"
							       class="form-label text-muted fst-italic">
							    inicio semana 6
							</label>
							<input type="date" id="inicio6" class="form-control" >
						    </div>
						</div>
						<div class="col-md-6">
						    <div class="form-group ">
							<label for="fin6"
							       class="form-label text-muted fst-italic">
							    fin semana 6
							</label>
							<input type="date" id="fin6" class="form-control" >
						    </div>
						</div>
						<<<<<<< HEAD
						<<<<<<< HEAD
						<<<<<<< HEAD
						=======
						>>>>>>> origin/fc
						=======
						>>>>>>> refs/remotes/origin/main

					    </div>

					    <div class="row align-items-center">

						<<<<<<< HEAD
						<<<<<<< HEAD
						=======

					    </div>

					    <div class="row align-items-center">

						>>>>>>> refs/remotes/origin/main
						=======
						>>>>>>> origin/fc
						=======
						>>>>>>> refs/remotes/origin/main
						<div class="col-md-6">
						    <div class="form-group">
							<label for="inicio7"
							       class="form-label text-muted fst-italic">
							    inicio semana 7
							</label>
							<input type="date" id="inicio7" class="form-control" >
						    </div>
						</div>
						<div class="col-md-6">
						    <div class="form-group ">
							<label for="fin7"
							       class="form-label text-muted fst-italic">
							    fin semana 7
							</label>
							<input type="date" id="fin7" class="form-control" >
						    </div>
						</div>
						<<<<<<< HEAD
						<<<<<<< HEAD
						<<<<<<< HEAD
						=======
						>>>>>>> origin/fc
						=======
						>>>>>>> refs/remotes/origin/main

					    </div>

					    <div class="row align-items-center">

						<<<<<<< HEAD
						<<<<<<< HEAD
						=======

					    </div>

					    <div class="row align-items-center">

						>>>>>>> refs/remotes/origin/main
						=======
						>>>>>>> origin/fc
						=======
						>>>>>>> refs/remotes/origin/main
						<div class="col-md-6">
						    <div class="form-group">
							<label for="inicio8"
							       class="form-label text-muted fst-italic">
							    inicio semana 8
							</label>
							<input type="date" id="inicio8" class="form-control" >
						    </div>
						</div>
						<div class="col-md-6">
						    <div class="form-group ">
							<label for="fin2"
							       class="form-label text-muted fst-italic">
							    fin semana 8
							</label>
							<input type="date" id="fin2" class="form-control" >
						    </div>
						</div>

					    </div>

					</div>
				    </div>
				</div>

				<div class="col-md-6">
				    <div class="card border-success">
					<div class="card-header">
					    <i class="fas fa-chart-area me-1"></i>
					    semanas segundo periodo
					</div>
					<div class="card-body container">
					    <div class="row align-items-center">

						<div class="col-md-6">
						    <div class="form-group">
							<label for="inicio9"
							       class="form-label text-muted fst-italic">
							    inicio semana 9
							</label>
							<input type="date" id="inicio9" class="form-control" >
						    </div>
						</div>
						<div class="col-md-6">
						    <div class="form-group ">
							<label for="fin9"
							       class="form-label text-muted fst-italic">
							    fin semana 9
							</label>
							<input type="date" id="fin9" class="form-control" >
						    </div>
						</div>


					    </div>

					    <div class="row align-items-center">



					    </div>

					    <div class="row align-items-center">


						<div class="col-md-6">
						    <div class="form-group">
							<label for="inicio10"
							       class="form-label text-muted fst-italic">
							    inicio semana 10
							</label>
							<input type="date" id="inicio2" class="form-control" >
						    </div>
						</div>
						<div class="col-md-6">
						    <div class="form-group ">
							<label for="fin10"
							       class="form-label text-muted fst-italic">
							    fin semana 10
							</label>
							<input type="date" id="fin10" class="form-control" >
						    </div>
						</div>


					    </div>

					    <div class="row align-items-center">


					    </div>

					    <div class="row align-items-center">

						<div class="col-md-6">
						    <div class="form-group">
							<label for="inicio11"
							       class="form-label text-muted fst-italic">
							    inicio semana 11
							</label>
							<input type="date" id="inicio11" class="form-control" >
						    </div>
						</div>
						<div class="col-md-6">
						    <div class="form-group ">
							<label for="fin11" class="form-label text-muted fst-italic">fin semana 11</label>
							<input type="date" id="fin11" class="form-control" >
						    </div>
						</div>


					    </div>

					    <div class="row align-items-center">

					    </div>

					    <div class="row align-items-center">

						<div class="col-md-6">
						    <div class="form-group">
							<label for="inicio12" class="form-label text-muted fst-italic">inicio semana 12</label>
							<input type="date" id="inicio12" class="form-control" >
						    </div>
						</div>
						<div class="col-md-6">
						    <div class="form-group ">
							<label for="fin12" class="form-label text-muted fst-italic">fin semana 12</label>
							<input type="date" id="fin12" class="form-control" >
						    </div>
						</div>


					    </div>

					    <div class="row align-items-center">


					    </div>

					    <div class="row align-items-center">


						<div class="col-md-6">
						    <div class="form-group">
							<label for="inicio5" class="form-label text-muted fst-italic">inicio semana 13</label>
							<input type="date" id="inicio2" class="form-control" >
						    </div>
						</div>
						<div class="col-md-6">
						    <div class="form-group ">
							<label for="fin13" class="form-label text-muted fst-italic">fin semana 13</label>
							<input type="date" id="fin13" class="form-control" >
						    </div>
						</div>


					    </div>

					    <div class="row align-items-center">


					    </div>

					    <div class="row align-items-center">


						<div class="col-md-6">
						    <div class="form-group">
							<label for="inicio6" class="form-label text-muted fst-italic">inicio semana 14</label>
							<input type="date" id="inicio6" class="form-control" >
						    </div>
						</div>
						<div class="col-md-6">
						    <div class="form-group ">
							<label for="fin14" class="form-label text-muted fst-italic">fin semana 14</label>
							<input type="date" id="fin14" class="form-control" >
						    </div>
						</div>


					    </div>

					    <div class="row align-items-center">


					    </div>

					    <div class="row align-items-center">

						<div class="col-md-6">
						    <div class="form-group">
							<label for="inicio7" class="form-label text-muted fst-italic">inicio semana 15</label>
							<input type="date" id="inicio7" class="form-control" >
						    </div>
						</div>
						<div class="col-md-6">
						    <div class="form-group ">
							<label for="fin15" class="form-label text-muted fst-italic">fin semana 15</label>
							<input type="date" id="fin15" class="form-control" >
						    </div>
						</div>

					    </div>

					    <div class="row align-items-center">

					    </div>

					    <div class="row align-items-center">

						<div class="col-md-6">
						    <div class="form-group">
							<label for="inicio16" class="form-label text-muted fst-italic">inicio semana 16</label>
							<input type="date" id="inicio16" class="form-control" >
						    </div>
						</div>
						<div class="col-md-6">
						    <div class="form-group ">
							<label for="fin16" class="form-label text-muted fst-italic">fin semana 16</label>
							<input type="date" id="fin16" class="form-control" >
						    </div>
						</div>

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
	<script src="./js/bootstrap.bundle.min.js" ></script>
        <script src="./js/scripts.js"></script>
        <script src="./js/Chart.min.js" ></script>
        <script src="./assets/demo/chart-area-demo.js"></script>
        <script src="./assets/demo/chart-bar-demo.js"></script>
        <script src="./js/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="./js/datatables-simple-demo.js"></script>
    </body>
</html>
