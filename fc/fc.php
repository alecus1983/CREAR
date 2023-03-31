<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>formulario de calificaciones</title>
        <link href="css/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="js/all.js" ></script>
	<link href="../imagenes/escudo.gif" rel="shortcut icon"/>
	<script src="./js/sweetalert.min.js"></script>
	<script src="./js/jquery-3.5.1.min.js"></scrip>
	    <script type="text/javascript">
	     /////////////////////////////////////////////////////////////////////////////////////////////////////////
	     //                                                                                                                                                                                                         //
	     // esta funcion interroga a la base de datos para visualizar el contenido de sus tablas                                                    //
	     // para lo cual toma el contenido de los selectores "consultar" (opcion) y  "adiccionar" (add)                                       //
	     // como criterios para  selecionar que consulta se va a ejecutar  en la base de datos                  //
	     // a travez del archivo seleccion.php                                                                  //
	     // los demás campos se envian  como información para desarrollar las consultas.                        //
	     //                                                                                                     //
	     /////////////////////////////////////////////////////////////////////////////////////////////////////////

	     function consultar() {

		 // En caso que la opcion selecionada mediante el combo #option sea la 13, que corresponde
		 // a los registros por grado entoncies

		 if ($("#opcion option:selected").val() > 12) {
		     // en caso de que la opcion se generar
		     // un grafico de tendencias
		     $("#resultado_con").html();
		     grafica();

		     // muestro en pantalla
		     console.log("graficando");

		 }
		 // en caso de que no se consulte un grafico
		 else {
		     // actualiza la tabla con los valrores
		     // se llama al archivo seleccion.php el cual retorna
		     // una tabla en formato html

		     $('#resultado_con').load("seleccion.php", {

			 opcion: $("#opcion option:selected").val(),
			 i_nombres: $("#i_nombres_con").val(),
			 apellidos: $("#apellidos_con").val(),
			 Logros: $("#Logros_con").val(),
			 years: $("#years").val().toString(),
			 id_g: $("#id_g option:selected").val(),
			 estudiantes: $("#estudiantes").val(),
			 periodos: $("#periodos option:selected").val(),
			 id_ms: $("#id_ms_con").val(),
			 jornada: $("#jornada option:selected").val(),
			 corte: $("#corte option:selected").val()

		     },
					      function() {

		     });
		 }

	     }

	     // funcion que actualiza el listado de los nombres de los estudiantes
	     // o de los docentes

	     function campo_nombre() {

		 // se carga  en el combo  resultado_con la lista de los estudiantes
		 // coincidentes con los criterios de busqueda.

		 $('#resultado_con').load("seleccion.php", {
		     opcion: $("#opcion option:selected").val(),
		     i_nombres: $("#i_nombres_con").val(),
		     apellidos: $("#apellidos_con").val(),
		     Logros: $("#Logros_con").val(),
		     years: $("#years").val().toString(),
		     id_g: $("#id_g option:selected").val(),
		     estudiantes: $("#estudiantes").val(),
		     periodos: $("#periodos option:selected").val(),
		     id_ms: $("#id_ms_con").val(),
		     jornada: $("#jornada option:selected").val(),
		     corte: $("#corte option:selected").val()

		 },
					  function() {

		 });
	     }

	     // funcion encargada de validar los campos a ingresar a la base de datos
	     // esta relacionada con el formulario de  adiccionar

	     function validar_add() {
		 // se toman las variables del formulario
		 var nombre = $("#i_nombres").val(); // variable nombre en el formulario
		 var apellido = $("#apellidos").val(); // variable apellidos en el formulario
		 var fecha = $("#fechas").val(); // variable fechas en el formulario
		 var telefono = $("#telefonos").val(); // variable telefonos en el formulario
		 var correo = $("#correos").val(); // variable correos en el formulario
		 var cedula = $("#cedulas").val(); // variable cedula en el formulario
		 var add = $("#add").val(); //  selector de adiccionar en el formulario
		 var ano = $("#years").val(); // variable año en el formulario
		 var jornada = $("select#jornada").val(); // variable jormana en el formulario
		 var periodo = $("select#periodos").val(); // variable periodo en el formulario
		 var corte = $("select#corte").val(); // variable corte en el formulario
		 var grado = $("select#id_g").val(); // variable gradp en el formulario
		 var docente = $("select#docentes").val(); //
		 var materia = $("select#id_ms").val(); //

		 var validar = true;
		 $("#resultado").html("");

		 if (add == 1 || add == 2) {
		     // validando nombre
		     if (nombre == "") {
			 $("#i_nombres").css("border-color", "red");
			 validar = false;
		     }
		     //en otro caso, el mensaje no se muestra
		     else {
			 $("#i_nombres").css("border-color", "grey");
		     }
		     // validando apellido
		     if (apellido == "") {
			 $("#apellidos").css("border-color", "red");
			 validar = false;
		     }
		     //en otro caso, el mensaje no se muestra
		     else {
			 $("#apellidos").css("border-color", "grey");
		     }
		     // validar fecha
		     if (fecha == "") {
			 $("#fechas").css("border-color", "red");
			 validar = false;
		     }
		     //en otro caso, el mensaje no se muestra
		     else {
			 $("#fechas").css("border-color", "grey");
		     }
		     // telefono
		     if (telefono == "" || isNaN(telefono)) {
			 $("#telefonos").css("border-color", "red");
			 validar = false;
		     }
		     //en otro caso, el mensaje no se muestra
		     else {
			 $("#telefonos").css("border-color", "grey");
		     }
		     // validar correo
		     if (correo == "") {
			 $("#correos").css("border-color", "red");
			 validar = false;
		     }
		     //en otro caso, el mensaje no se muestra
		     else {
			 $("#correos").css("border-color", "grey");
		     }

		     // validar cedula
		     if (cedula == "" || isNaN(cedula)) {
			 $("#cedulas").css("border-color", "red");
			 validar = false;
		     }
		     //en otro caso, el mensaje no se muestra
		     else {
			 $("#cedulas").css("border-color", "grey");
		     }
		 }
		 // en caso de que las opciones sean
		 else if (add == 7 || add == 9) {
		     // datos de la jornada
		     if (jornada == -1) {
			 $("#resultado").append("<p style='color:red;'>Favor seleccione una jornada <p>");
			 validar = false;
		     }
		     // datos del periodo
		     if (periodo == -1) {
			 $("#resultado").append("<p style='color:red;'>Favor seleccione un periodo <p>");
			 validar = false;
		     }
		     // datos de corte
		     if (corte == -1) {
			 $("#resultado").append("<p style='color:red;'>Favor seleccione un corte <p>");
			 validar = false;
		     }
		     // datos de grado
		     if (grado == -1) {
			 $("#resultado").append("<p style='color:red;'>Favor seleccione un grado <p>");
			 validar = false;
		     }
		 } else if (add == 8) {
		     // datos de la jornada
		     if (jornada == -1) {
			 $("#resultado").append("<p style='color:red;'>Favor seleccione una jornada <p>");
			 validar = false;
		     }

		     // datos de grado
		     if (grado == -1) {
			 $("#resultado").append("<p style='color:red;'>Favor seleccione un grado <p>");
			 validar = false;
		     }
		     // datos de grado
		     if (materia == -1) {
			 $("#resultado").append("<p style='color:red;'>Favor seleccione una materia <p>");
			 validar = false;
		     }

		     // datos de grado
		     if (docente == -1) {
			 $("#resultado").append("<p style='color:red;'>Favor seleccione un docente <p>");
			 validar = false;
		     }
		 }
		 return validar;
	     }

	     // Funcion en java scrip para ingresar valores en la base de datos
	     // para todas las opciones del menu adiccionar
	     // permite agregar estudiantes, docentes, notas etc ...

	     function deposit() {

		 // para ello comienza
		 // almacenando el codigo del grado en la variable j
		 var j = $("#id_g").val();

		 // se crea un algoritmo para computar los logors
		 // la variable  k que cuenta el limite de logros (interaciones)
		 // asi :
		 // k = 0 --> corresponde a un logro
		 // k = 1 --> corresponde a dos logros
		 // k = 2 --> corresponde a tres logros

		 var k = 0;

		 // comienza con un algoritmo de validación
		 // los grados con codigos 7, 8 y 9 tienen tres logros (k = 2) estos corresponden a pre escolar

		 if (j == 7 || j == 8 || j == 9) {
		     k = 2; // asigna tres logros
		     console.log("Se cambio k a : %i", k);
		 }

		 // Si voy ha adiccionar una nota ...
		 // si lo que adicciono no es una nota salto este procedimiento
		 if ($("#add").val() == 11)  {
		     // variable que cuenta las iteraciones
		     var i = 0;

		     /// por cada checkbox ejecuta esta funcion
		     $('input[type=checkbox]').each(function() {
			 // si el checkbox esta seteado
			 if (this.checked == true) {

			     // almaceno el id en la variable id_c el cual es el codigo del logro
			     id_c = this.id;
			     //
			     if (k >= i) {

				 switch (i) { // estructura para seleccionar los logros

				     case 0:
					 $("#logro_1").val(id_c);
					 $("#logro_2").val("");
					 $("#logro_3").val("");
					 break

				     case 1:
					 $("#logro_2").val(id_c);
					 $("#logro_3").val("");
					 break

				     case 2:
					 $("#logro_3").val(id_c);
					 break
				 }

				 i++;

				 console.log("El valor de k es: " + k + ", el valor de i es :" + i + " y el id: " + id_c);

			     }
			 }

		     });

		     //  se muestra en consola los valores insertados en los campos logro 1, logro 2 y logro3
		     console.log("Logro 1 : %s", $("#logro_1").val());
		     console.log("Logro 2 : %s", $("#logro_2").val());
		     console.log("Logro 3 : %s", $("#logro_3").val());

		 }



		 /// variable que representa cada item del menu aderir

		 var datos = validar_add();
		 if (datos) {


		     // en esta seccion se incertan los registros
		     // dentro de la base de datos , enviados a traves de
		     // ajax

		     console.log(" add = %i", $("#add").val());
		     switch ($("#add").val()) {
			     // caso de agregar notras
			 case '11':

			     swal({
				 title: 'INSERTAR NOTAS',
				 text: "Esta seguro que quiere insertar las notas!",
				 icon: 'warning',
				 buttons: true,
				 buttons: ["cancelar", "insertar"],
			     }).then((value) => {
				 if (value) {

				     // creo tes array a partir de una secuencia
				     // de campos identificados cada uno por una clase
				     var notas = $('.notas').serializeArray();
				     // serializo los campos clase  logro 1
				     var logros1 = $('.logros1').serializeArray();
				     // serializo los campos clase logro 2
				     var logros2 = $('.logros2').serializeArray();
				     // serializo los campos clase logro 3
				     var logros3 = $('.logros3').serializeArray();
				     // serializo los codigos
				     var codigos = $('.codigos').serializeArray();
				     // serializo las  faltas
				     var faltas = $('.faltas').serializeArray();

				     $.ajax({
					 type: "POST",
					 url: "notas.php",
					 data: {
					     year: $("#years").val(),
					     id_gs: $("#id_g").val(),
					     id_ms: $("#id_ms").val(),
					     id_jornada: $("#jornada").val(),
					     id_docente: $("#id_docentes").val(),
					     corte: $("#corte").val(),
					     periodo: $("#periodos").val(),
					     nota: JSON.stringify(notas),
					     logro1: JSON.stringify(logros1),
					     logro2: JSON.stringify(logros2),
					     logro3: JSON.stringify(logros3),
					     codigo: JSON.stringify(codigos),
					     faltas: JSON.stringify(faltas)
					 },

					 success: function(data) {
					     //$("#resultado").html("Se ingresaron las notas con exito");
					     $("#resultado").html(data);

					 },
					 error: function(xhr, status) {
					     swal('Disculpe, existió un problema');
					     console.log(xhr);
					 }
				     });

				 } else {
				     swal({
					 title: 'Accion cancelada',
					 icon: 'error',
				     });
				 }
			     } // si se retorna el boton insertar
			     );

			     break;

			 case '12':

			     if (validar_grado()) {
				 // mensaje de aceptacion
				 swal({
				     title: 'Agregar Registros',
				     text: "se van a agregar registros para el grado " + $("#id_g option:selected").text(),
				     icon: 'warning',
				     buttons: true,
				     buttons: ["cancelar", "insertar"],
				 }).then((value) => {
				     if (value) {
					 // carga los registros  el la ventana de resultados
					 $('#resultado').load("registros.php", {
					     id_gs: $("#id_g").val(),
					     n_grado: $("#id_g option:selected").text()
					 }

					 );
				     }
				 });
			     }

			     break;

			 default:

			     swal({
				 title: 'CONFIRMAR',
				 text: "Para confirmar la accion presione aceptar, de lo contrario presione cancelar",
				 icon: 'warning',
				 buttons: true,
				 buttons: ["cancelar", "insertar"],
			     }).then((value) => {
				 if (value) {

				     $.ajax({
					 url: 'adiccion.php',
					 type: 'POST',
					 dataType: 'html',
					 data: {
					     add: $("#add option:selected").val(),
					     i_nombres: $("#i_nombres").val(),
					     apellidos: $("#apellidos").val(),
					     Logros: $("#Logros").val(),
					     years: $("#years").val().toString(),
					     id_g: $("#id_g").val(),
					     fechas: $("#fechas").val(),
					     cedulas: $("#cedulas").val(),
					     correos: $("#correos").val(),
					     telefonos: $("#telefonos").val(),
					     areas: $("#areas").val(),
					     fecha_fins: $("#fecha_fins").val(),
					     id_es: $("#id_es").val(),
					     logro_1: $("#logro_1").val(),
					     logro_2: $("#logro_2").val(),
					     logro_3: $("#logro_3").val(),
					     faltas: $("#faltas").val(),
					     estudiantes: $("#estudiantes").val(),
					     periodos: $("#periodos").val(),
					     id_ms: $("#id_ms").val(),
					     id_jornada: $("#jornada").val(),
					     docentes: $("#docentes").val()
					 },
					 beforeSend: function() {
					     console.log("enviando datos .. para adiccionar");
					 },

					 success: function(result) {
					     // en caso de que la funcion tenga exito
					     $('#resultado').html(result);
					     // ejecuto la funcion para la cual  actualiza el formato de seleccion
					     //consultar();
					 },
					 error: function(xhr, status) {
					     swal('Disculpe, existió un problema');
					 },
					 complete: function(xhr, status) {
					     swal('Petición realizada');
					 }
				     });

				 }
			     });
			     break;
		     }
		 } /// fin de la confirmacion de los datos
		 else {
		     $("#resultado").append("Los datos ingresados son incorrectos, verifique el formulario");
		 }


		 // fin de funcion

	     } // fin de la funsion deposit

	     // funcion para llamar boletines
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

	     // funcion que permite validar el campo grado retorna true si tiene
	     // un valor valido
	     function validar_grado() {
		 var grado = $("#id_g").val();
		 // si el grado es -1 es porque no se ha seleccionado
		 if (grado == "-1") {
		     swal("Datos", "Por favor seleccione un grado", "error");
		     return false;
		 } else {
		     return true;
		 }
	     }

	     // funcion que permite validar el campo grado retorna true si tiene
	     // un valor valido
	     function validar_periodo() {
		 var grado = $("#periodos").val();
		 // si el grado es -1 es porque no se ha seleccionado
		 if (grado == "-1") {
		     swal("Datos", "Por favor seleccione un periodo", "error");
		     return false;
		 } else {
		     return true;
		 }
	     }

	     function borrar(id, tabla) {

		 swal({
		     title: 'CONFIRMAR',
		     text: "Va a eliminar un registro de la tabla " + tabla + " con codigo " + id,
		     icon: 'warning',
		     buttons: true,
		     buttons: ["cancelar", "insertar"],
		 }).then((value) => {
		     if (value) {

			 $.getJSON("delete.php", {
			     "id": id,
			     "tabla": tabla
			 },
				   function() {
				       swal("se eliminaron  los datos correctamente");
			 });
			 consultar();
		     }
		 });
	     }
	    </script>


	<script>
	 // funsion que carga las semanas correctas cuando cambia
	 // el Periodo de calificaciones

	 function load_semanas(){

	     // alert('Any fool can use a computer');
	     // se invoca al metodo ajax para solicitar el los datos del grafico
	     $.ajax({
		 type: "POST",
		 url: "semanas.php",
		 data: {
		     years: $("#years").val(),
		     id_gs: $("#id_g").val(),
		     id_ms: $("#id_ms").val(),
		     id_jornada: $("#jornada").val(),
		     periodo: $("#periodos").val()
		 } ,
		 // si los datos son correctos entonces ...
		 success: function(respuesta) {

		     $("#calificador").html(respuesta);

		 },
		 error: function(xhr, status) {
		     swal('Disculpe, existió un problema');
		     console.log(xhr);
		 }
	     });

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
	</script>
    </head>

    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">INICIO</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                FORMULARIO
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Layouts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">FORMULARIO</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Para  la gestión de calificaciones</li>
                        </ol>
			<div class="row">
			    <div class="col-xl-2">
				<div class="card mb-2">
                                    <div class="card-header">
					<i class="fas fa-chart-area me-1"></i>
					datos
                                    </div>
                                    <div class="card-body">
					<div class="row">
					    <div class="col-md-12">
						<div class="form-floating sm-3 md-2">
						    <input type="number" value=""
							   id="years" name="years" min="2015"
							   max="2100" step="1"
							   required="required"
							   class="form-control ">
						    <label for="years">Año</label>
						</div>
					    </div>
					</div>


					<div class="row">
					    <div class="col-md-12 form-floating">
			    			<select id="periodos" name="periodos"   class="form-control" required="" onchange="load_semanas();">
						    <option value="-1">Seleccione </option>
						    <option value="1">1</option>
						    <option value="2">2</option>
						    <option value="3">3</option>
						    <option value="4">4</option>
						    <option value="5">Recuperacion
						    </option>
						</select>
						<label for="periodos"> Periodo</label>
					    </div>
					</div>

					<div class="row">
					    <div class="col-md-12 form-floating">
						<select id="semana"
							class="form-control">
						    <option value="1">1</option>
						    <option value="2">2</option>
						    <option value="3">3</option>
						    <option value="4">4</option>
						    <option value="5">5</option>
						    <option value="6">6</option>
						    <option value="7">7</option>
						    <option value="8">8</option>
						</select>
						<label for="semana">Semana</label>
					    </div>
					</div>

					<div class="row">
					    <div class="col-md-12 form-floating">
						<select id="jornada" class="form-control">
						    <option value="1">Mañana</option>
						    <option value="2">Tarde</option>
						</select>
						<label for="jornada">Jornada</label>
					    </div>
					</div>
					

					<div class="row">
					    <div class="col-md-12 form-floating">
						<select id="id_g" name="id_gs"
							    class ="form-control">
						</select>
						<label class="Control-label">Grado</label>
					    </div>
					</div>

					<div class="row">
					    <div class="col-md-12 form-floating">
						<select id="id_c"  class ="form-control">
						    <option value="0">A</opcion>
						    <option value="1">B</opcion>
						</select>
						<label class="Control-label">Curso</label>
					    </div>
					</div>

					<div class="row">
					    <div class="col-md-12 form-floating">
						<select id="id_ms" name="id_ms"
							class="form-control">
						</select>
						<label for="id_ms">Materia</label>
					    </div>

					</div>

					<div class="row">
					    <button type="button"
						    style="margin: 20px auto auto;
							  display: block;"
						    class="btn btn-outline-success"
						    value="ACTUALIZAR"
						    id="ingresar"
						    onclick="deposit();">
						Ingresar
					    </button>
					</div>
				    </div>
				</div>
			    </div>

			    <div class="col-xl-10">
				<div class="card mb-2">
                                    <div class="card-header">
					<i class="fas fa-chart-area me-1"></i>
					notas
                                    </div>
                                    <div class="card-body">
					<div class="row">
					    <div id="calificador" class="col-md-12">
						<!-- formulario de notas> -->

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
			<div class="row">
			    <div class="col-xl-6">
				<div class="card mb-4">
				    <div class="card-header">
					<i class="fas fa-chart-area me-1"></i>
					Area Chart Example
				    </div>
				    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
				</div>
			    </div>
			    <div class="col-xl-6">
				<div class="card mb-4">
				    <div class="card-header">
					<i class="fas fa-chart-bar me-1"></i>
					Bar Chart Example
				    </div>
				    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
				</div>
			    </div>
			</div>
			<div class="card mb-4">
			    <div class="card-header">
				<i class="fas fa-table me-1"></i>
				DataTable Example
			    </div>
			    <div class="card-body">
				<table id="datatablesSimple">
				    <thead>
					<tr>
					    <th>Name</th>
					    <th>Position</th>
					    <th>Office</th>
					    <th>Age</th>
					    <th>Start date</th>
					    <th>Salary</th>
					</tr>
				    </thead>
				    <tfoot>
					<tr>
					    <th>Name</th>
					    <th>Position</th>
					    <th>Office</th>
					    <th>Age</th>
					    <th>Start date</th>
					    <th>Salary</th>
					</tr>
				    </tfoot>
				    <tbody>
					<tr>
					    <td>Tiger Nixon</td>
					    <td>System Architect</td>
					    <td>Edinburgh</td>
					    <td>61</td>
					    <td>2011/04/25</td>
					    <td>$320,800</td>
					</tr>
					<tr>
					    <td>Garrett Winters</td>
					    <td>Accountant</td>
					    <td>Tokyo</td>
					    <td>63</td>
					    <td>2011/07/25</td>
					    <td>$170,750</td>
					</tr>
					<tr>
					    <td>Ashton Cox</td>
					    <td>Junior Technical Author</td>
					    <td>San Francisco</td>
					    <td>66</td>
					    <td>2009/01/12</td>
					    <td>$86,000</td>
					</tr>
					<tr>
					    <td>Cedric Kelly</td>
					    <td>Senior Javascript Developer</td>
					    <td>Edinburgh</td>
					    <td>22</td>
					    <td>2012/03/29</td>
					    <td>$433,060</td>
					</tr>
					<tr>
					    <td>Airi Satou</td>
					    <td>Accountant</td>
					    <td>Tokyo</td>
					    <td>33</td>
					    <td>2008/11/28</td>
					    <td>$162,700</td>
					</tr>
					<tr>
					    <td>Brielle Williamson</td>
					    <td>Integration Specialist</td>
					    <td>New York</td>
					    <td>61</td>
					    <td>2012/12/02</td>
					    <td>$372,000</td>
					</tr>
					<tr>
					    <td>Herrod Chandler</td>
					    <td>Sales Assistant</td>
					    <td>San Francisco</td>
					    <td>59</td>
					    <td>2012/08/06</td>
					    <td>$137,500</td>
					</tr>
					<tr>
					    <td>Rhona Davidson</td>
					    <td>Integration Specialist</td>
					    <td>Tokyo</td>
					    <td>55</td>
					    <td>2010/10/14</td>
					    <td>$327,900</td>
					</tr>
					<tr>
					    <td>Colleen Hurst</td>
					    <td>Javascript Developer</td>
					    <td>San Francisco</td>
					    <td>39</td>
					    <td>2009/09/15</td>
					    <td>$205,500</td>
					</tr>
					<tr>
					    <td>Sonya Frost</td>
					    <td>Software Engineer</td>
					    <td>Edinburgh</td>
					    <td>23</td>
					    <td>2008/12/13</td>
					    <td>$103,600</td>
					</tr>
					<tr>
					    <td>Jena Gaines</td>
					    <td>Office Manager</td>
					    <td>London</td>
					    <td>30</td>
					    <td>2008/12/19</td>
					    <td>$90,560</td>
					</tr>
					<tr>
					    <td>Quinn Flynn</td>
					    <td>Support Lead</td>
					    <td>Edinburgh</td>
					    <td>22</td>
					    <td>2013/03/03</td>
					    <td>$342,000</td>
					</tr>
					<tr>
					    <td>Charde Marshall</td>
					    <td>Regional Director</td>
					    <td>San Francisco</td>
					    <td>36</td>
					    <td>2008/10/16</td>
					    <td>$470,600</td>
					</tr>
					<tr>
					    <td>Haley Kennedy</td>
					    <td>Senior Marketing Designer</td>
					    <td>London</td>
					    <td>43</td>
					    <td>2012/12/18</td>
					    <td>$313,500</td>
					</tr>
					<tr>
					    <td>Tatyana Fitzpatrick</td>
					    <td>Regional Director</td>
					    <td>London</td>
					    <td>19</td>
					    <td>2010/03/17</td>
					    <td>$385,750</td>
					</tr>
					<tr>
					    <td>Michael Silva</td>
					    <td>Marketing Designer</td>
					    <td>London</td>
					    <td>66</td>
					    <td>2012/11/27</td>
					    <td>$198,500</td>
					</tr>
					<tr>
					    <td>Paul Byrd</td>
					    <td>Chief Financial Officer (CFO)</td>
					    <td>New York</td>
					    <td>64</td>
					    <td>2010/06/09</td>
					    <td>$725,000</td>
					</tr>
					<tr>
					    <td>Gloria Little</td>
					    <td>Systems Administrator</td>
					    <td>New York</td>
					    <td>59</td>
					    <td>2009/04/10</td>
					    <td>$237,500</td>
					</tr>
					<tr>
					    <td>Bradley Greer</td>
					    <td>Software Engineer</td>
					    <td>London</td>
					    <td>41</td>
					    <td>2012/10/13</td>
					    <td>$132,000</td>
					</tr>
					<tr>
					    <td>Dai Rios</td>
					    <td>Personnel Lead</td>
					    <td>Edinburgh</td>
					    <td>35</td>
					    <td>2012/09/26</td>
					    <td>$217,500</td>
					</tr>
					<tr>
					    <td>Jenette Caldwell</td>
					    <td>Development Lead</td>
					    <td>New York</td>
					    <td>30</td>
					    <td>2011/09/03</td>
					    <td>$345,000</td>
					</tr>
					<tr>
					    <td>Yuri Berry</td>
					    <td>Chief Marketing Officer (CMO)</td>
					    <td>New York</td>
					    <td>40</td>
					    <td>2009/06/25</td>
					    <td>$675,000</td>
					</tr>
					<tr>
					    <td>Caesar Vance</td>
					    <td>Pre-Sales Support</td>
					    <td>New York</td>
					    <td>21</td>
					    <td>2011/12/12</td>
					    <td>$106,450</td>
					</tr>
					<tr>
					    <td>Doris Wilder</td>
					    <td>Sales Assistant</td>
					    <td>Sidney</td>
					    <td>23</td>
					    <td>2010/09/20</td>
					    <td>$85,600</td>
					</tr>
					<tr>
					    <td>Angelica Ramos</td>
					    <td>Chief Executive Officer (CEO)</td>
					    <td>London</td>
					    <td>47</td>
					    <td>2009/10/09</td>
					    <td>$1,200,000</td>
					</tr>
					<tr>
					    <td>Gavin Joyce</td>
					    <td>Developer</td>
					    <td>Edinburgh</td>
					    <td>42</td>
					    <td>2010/12/22</td>
					    <td>$92,575</td>
					</tr>
					<tr>
					    <td>Jennifer Chang</td>
					    <td>Regional Director</td>
					    <td>Singapore</td>
					    <td>28</td>
					    <td>2010/11/14</td>
					    <td>$357,650</td>
					</tr>
					<tr>
					    <td>Brenden Wagner</td>
					    <td>Software Engineer</td>
					    <td>San Francisco</td>
					    <td>28</td>
					    <td>2011/06/07</td>
					    <td>$206,850</td>
					</tr>
					<tr>
					    <td>Fiona Green</td>
					    <td>Chief Operating Officer (COO)</td>
					    <td>San Francisco</td>
					    <td>48</td>
					    <td>2010/03/11</td>
					    <td>$850,000</td>
					</tr>
					<tr>
					    <td>Shou Itou</td>
					    <td>Regional Marketing</td>
					    <td>Tokyo</td>
					    <td>20</td>
					    <td>2011/08/14</td>
					    <td>$163,000</td>
					</tr>
					<tr>
					    <td>Michelle House</td>
					    <td>Integration Specialist</td>
					    <td>Sidney</td>
					    <td>37</td>
					    <td>2011/06/02</td>
					    <td>$95,400</td>
					</tr>
					<tr>
					    <td>Suki Burks</td>
					    <td>Developer</td>
					    <td>London</td>
					    <td>53</td>
					    <td>2009/10/22</td>
					    <td>$114,500</td>
					</tr>
					<tr>
					    <td>Prescott Bartlett</td>
					    <td>Technical Author</td>
					    <td>London</td>
					    <td>27</td>
					    <td>2011/05/07</td>
					    <td>$145,000</td>
					</tr>
					<tr>
					    <td>Gavin Cortez</td>
					    <td>Team Leader</td>
					    <td>San Francisco</td>
					    <td>22</td>
					    <td>2008/10/26</td>
					    <td>$235,500</td>
					</tr>
					<tr>
					    <td>Martena Mccray</td>
					    <td>Post-Sales support</td>
					    <td>Edinburgh</td>
					    <td>46</td>
					    <td>2011/03/09</td>
					    <td>$324,050</td>
					</tr>
					<tr>
					    <td>Unity Butler</td>
					    <td>Marketing Designer</td>
					    <td>San Francisco</td>
					    <td>47</td>
					    <td>2009/12/09</td>
					    <td>$85,675</td>
					</tr>
					<tr>
					    <td>Howard Hatfield</td>
					    <td>Office Manager</td>
					    <td>San Francisco</td>
					    <td>51</td>
					    <td>2008/12/16</td>
					    <td>$164,500</td>
					</tr>
					<tr>
					    <td>Hope Fuentes</td>
					    <td>Secretary</td>
					    <td>San Francisco</td>
					    <td>41</td>
					    <td>2010/02/12</td>
					    <td>$109,850</td>
					</tr>
					<tr>
					    <td>Vivian Harrell</td>
					    <td>Financial Controller</td>
					    <td>San Francisco</td>
					    <td>62</td>
					    <td>2009/02/14</td>
					    <td>$452,500</td>
					</tr>
					<tr>
					    <td>Timothy Mooney</td>
					    <td>Office Manager</td>
					    <td>London</td>
					    <td>37</td>
					    <td>2008/12/11</td>
					    <td>$136,200</td>
					</tr>
					<tr>
					    <td>Jackson Bradshaw</td>
					    <td>Director</td>
					    <td>New York</td>
					    <td>65</td>
					    <td>2008/09/26</td>
					    <td>$645,750</td>
					</tr>
					<tr>
					    <td>Olivia Liang</td>
					    <td>Support Engineer</td>
					    <td>Singapore</td>
					    <td>64</td>
					    <td>2011/02/03</td>
					    <td>$234,500</td>
					</tr>
					<tr>
					    <td>Bruno Nash</td>
					    <td>Software Engineer</td>
					    <td>London</td>
					    <td>38</td>
					    <td>2011/05/03</td>
					    <td>$163,500</td>
					</tr>
					<tr>
					    <td>Sakura Yamamoto</td>
					    <td>Support Engineer</td>
					    <td>Tokyo</td>
					    <td>37</td>
					    <td>2009/08/19</td>
					    <td>$139,575</td>
					</tr>
					<tr>
					    <td>Thor Walton</td>
					    <td>Developer</td>
					    <td>New York</td>
					    <td>61</td>
					    <td>2013/08/11</td>
					    <td>$98,540</td>
					</tr>
					<tr>
					    <td>Finn Camacho</td>
					    <td>Support Engineer</td>
					    <td>San Francisco</td>
					    <td>47</td>
					    <td>2009/07/07</td>
					    <td>$87,500</td>
					</tr>
					<tr>
					    <td>Serge Baldwin</td>
					    <td>Data Coordinator</td>
					    <td>Singapore</td>
					    <td>64</td>
					    <td>2012/04/09</td>
					    <td>$138,575</td>
					</tr>
					<tr>
					    <td>Zenaida Frank</td>
					    <td>Software Engineer</td>
					    <td>New York</td>
					    <td>63</td>
					    <td>2010/01/04</td>
					    <td>$125,250</td>
					</tr>
					<tr>
					    <td>Zorita Serrano</td>
					    <td>Software Engineer</td>
					    <td>San Francisco</td>
					    <td>56</td>
					    <td>2012/06/01</td>
					    <td>$115,000</td>
					</tr>
					<tr>
					    <td>Jennifer Acosta</td>
					    <td>Junior Javascript Developer</td>
					    <td>Edinburgh</td>
					    <td>43</td>
					    <td>2013/02/01</td>
					    <td>$75,650</td>
					</tr>
					<tr>
					    <td>Cara Stevens</td>
					    <td>Sales Assistant</td>
					    <td>New York</td>
					    <td>46</td>
					    <td>2011/12/06</td>
					    <td>$145,600</td>
					</tr>
					<tr>
					    <td>Hermione Butler</td>
					    <td>Regional Director</td>
					    <td>London</td>
					    <td>47</td>
					    <td>2011/03/21</td>
					    <td>$356,250</td>
					</tr>
					<tr>
					    <td>Lael Greer</td>
					    <td>Systems Administrator</td>
					    <td>London</td>
					    <td>21</td>
					    <td>2009/02/27</td>
					    <td>$103,500</td>
					</tr>
					<tr>
					    <td>Jonas Alexander</td>
					    <td>Developer</td>
					    <td>San Francisco</td>
					    <td>30</td>
					    <td>2010/07/14</td>
					    <td>$86,500</td>
					</tr>
					<tr>
					    <td>Shad Decker</td>
					    <td>Regional Director</td>
					    <td>Edinburgh</td>
					    <td>51</td>
					    <td>2008/11/13</td>
					    <td>$183,000</td>
					</tr>
					<tr>
					    <td>Michael Bruce</td>
					    <td>Javascript Developer</td>
					    <td>Singapore</td>
					    <td>29</td>
					    <td>2011/06/27</td>
					    <td>$183,000</td>
					</tr>
					<tr>
					    <td>Donna Snider</td>
					    <td>Customer Support</td>
					    <td>New York</td>
					    <td>27</td>
					    <td>2011/01/25</td>
					    <td>$112,000</td>
					</tr>
				    </tbody>
				</table>
			    </div>
			</div>
		    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
	    </div>
	</div>
	<script src="./js/bootstrap.bundle.min.js" ></script>
	<script src="./js/scripts.js"></script>
	<script src="./js/Chart.min.js" ></script>
	<script src="./assets/demo/chart-area-demo.js"></script>
	<script src="./assets/demo/chart-bar-demo.js"></script>
	<script src="./js/simple-datatables.min.js" crossorigin="anonymous"></script>
	<script src="./js/datatables-simple-demo.js"></script>
    </body>
</html>
