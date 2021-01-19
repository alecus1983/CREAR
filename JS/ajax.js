// este archivo contiene el los procesos principales de ajax para la comunicación de
// la pagina principal formulario_boletin.php
// con las funciones de ajax.


// esta funcion interroga a la base de datos para visualizar el contenido de sus tablas
// para lo cual toma el contenido de los selectores "consultar" (opcion) y  "adiccionar" (add)
// como criterios para  selecionar que consulta se va a ejecutar  en la base de datos
// a travez del archivo seleccion.php
// los demás campos se envian  como información para desarrollar las consultas.




function upgrade() {

    var parametros = {id_ds:$("#id_ds").val(), // eta variable guarda el c�digo del docente
		      id_es:$("#id_es").val(), // esta variable guarda el c�digo del estudiante
		      id_ls: $("#id_ls").val(), //
		      Logros: $("#Logros").val(),
		      edi : $("#edi option:selected").val(),
		      i_nombres: $("#i_nombres").val(),
		      apellidos: $("#apellidos").val(),
		      cedulas: $("#cedulas").val(),
		      fechas: $("#fechas").val(),
		      telefonos : $("#telefonos").val(),
		      correos : $("#correos").val(),
		      areas:$("areas").val(),
		      fecha_fins : $("#fecha_fins").val(),
		      periodos: $("#periodos").val()};

    // Este m�todo llama a el archivo actualizar.php, el cual se encarga
    // de ejecutar las consultas de actualizaci�n dentro de la base de datos
    // para ello se basa en los valores de referencia de las variables a trav�s
    // del  m�todo load
    $("#resultado").load("actualizar.php", parametros );

    // actualizo los valores en base de datos
    // segun corresponda en la opcion del menu editar

    $.ajax({parametros,
            url:   'actualizar.php',
            type:  'post',
	          async: 'false',
	          beforeSend: function () {
		            $("#resultado").html("Procesando, espere por favor...");
            },
            success:  function (response) {
		            $("#resultado").html(response);
            }
	   });


    // el plazo que resta para la entrega de boletines
    //$("#fecha_entrega").load("plazo.php");

    var entrega ="";
	  var hoy = "";
	  var periodo="";
	  var corte="";

	  // actualizo la fecha actual  y sus parametros asociados
	  $.ajax({
	  url: 'plazo.php',
    type:  'post',
	  async: 'false',
	  dataType: "json",
	  error: function( jqXHR, textStatus, errorThrown ) {
	  if (jqXHR.status === 0) {

	  swal('Not connect: Verify Network.');

          } else if (jqXHR.status == 404) {

	  swal('Requested page not found [404]');

          } else if (jqXHR.status == 500) {

	  swal('Internal Server Error [500].');

          } else if (textStatus === 'parsererror') {

	  swal('Requested JSON parse failed.');

          } else if (textStatus === 'timeout') {

	  swal('Time out error.');

          } else if (textStatus === 'abort') {

	  swal('Ajax request aborted.');

          } else {

	  swal('Uncaught Error: ' + jqXHR.responseText);

          }
          // Otro manejador error
	  },
          beforeSend: function () {
	  $("#resultado").html("Actualizando fecha, espere por favor...");
          },
          success:  function (response) {
	  //swal("Se actualizo con exito la fecha");
	  var cadena = response;

	  $("#fecha_entrega").html(
	  "Periodo : "+cadena.periodo+
	  "  Corte : "+cadena.corte+
	  "  "+cadena.texto
	  );


	  entrega = cadena.entrega;
	  hoy = cadena.hoy;
	  periodo = cadena.periodo;
	  corte = cadena.corte;



	  // $("#fecha_entrega").html(
	  //	"<br> Cadena" +cadena.texto+
	  //    "<br> Entrega: "+cadena.entrega+
	  //    "<br> Hoy : "+cadena.hoy+
	  //    "<br> periodo : "+cadena.periodo+
	  //    "<br> corte : "+cadena.corte
	  //);


          }
	  });
}


function actualizar_logro() {
    // Esta es la funcion recarga los valores en los campos de texto  despues que se  cambia el codigo


    if ($('#edi').val() == 5)

    {
	// recupero el idenificador del nombre

	id_l = $("#id_ls").val();

	console.log("El codigo del logro es: %s", id_l);
	// recuperando  nombres  y apellidos de los estudiantes

	$.post("campos/logros.php", {"id_ls": id_l},
 	       function (dato)
 	       {
 		   $("#Logros").val(dato.logro); // Agrego el nombre al campo nombre
 		   console.log("retorna %s", dato.logro);
 		   console.log(JSON.stringify(dato));
 	       }, 'json');

    }

}


function actualizar_nombre() {
    // Esta es la funcion recarga los valores en los campos de texto  despues que se  cambia el codigo
    if ($('#add').val() == 7)
    {	// convierte al los campos i_nombres y apellidos como solo lectura
	$("#i_nombres").attr("readonly",true);
	$("#apellidos").attr("readonly",true);
    }

    // ingreso  a este estado solo si  estoy editando  el nombre o
    //
    if ($('#add').val() == 7 || $('#edi').val() == 1)

    {
	// recupero el idenificador del nombre

	id_nombre = $("#id_es").val();

	console.log("El codigo del estudiante es: %s", id_nombre);
	// recuperando  nombres  y apellidos de los estudiantes

        // http://imcreativo.edu.co/paginas/nombre.php

        $.post("nombre.php", {"nombres": id_nombre},
 	       function (dato)
 	       {
 		   $("#i_nombres").val(dato.nombres); // Agrego el nombre al campo nombre
 		   $("#apellidos").val(dato.apellidos); // Agrego apellidos cuando cambio el codigo
 		   $("#telefonos").val(dato.telefono);
 		   $("#correos").val(dato.correo);
 		   $("#fechas").val(dato.fecha);
 		   $("#cedulas").val(dato.cedula);
 	       }, 'json');

    }

}

function actualizar_docente(id_nombre) {
    // Esta es la funcion recarga los valores en los campos de texto  despues que se  cambia el codigo

    // if ($("#edi").val() == 2 ) {
	// recupero el idenificador del nombre

	//var id_nombre = $_SESSION['code'];//$("#id_ds").val();

	// recuperando  nombre
	console.log("actualizando  los docentes ...");

	$.post("docente.php", {"nombres": id_nombre},
 	       function (dato) {
 		   $("#i_nombres").val(dato.nombres);
 		   $("#apellidos").val(dato.apellidos);
 		   $("#telefonos").val(dato.telefono);
 		   $("#correos").val(dato.correo);
 		   $("#fechas").val(dato.fecha);
 		   $("#cedulas").val(dato.cedula);
 		   $("#areas").val(dato.areas);
 	       }, 'json');

    // }

}


//  esta funcion se utiliza para validar  los nombress

function checkInput(idInput, pattern) {

	//swal(idInput);
	var valor = $(idInput).val();
	//swal(valor);
	if( valor == null || valor.length == 0 || /^\s+$/.test(valor)) {
  	return false;}
  	else { return true;}
  	}


function checknumero(idInput, pattern) {

	//swal(idInput);
	var valor = $(idInput).val();
	//swal(valor);
	if(isNaN(valor) ) {
  	return false;}
  	else { return true;}
  	}

//  esta funcion se utiliza para validar  los nombress

function checkemail(idInput, pattern) {

	var valor = $(idInput).val();

	if(!(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/.test(valor)) ) {
  	return false;}
  	else { return true;}

}

// Esta funcion se utiliza para validar el tamaño de la caja de area de texo

function checkTextarea(idText) {
	return $(idText).val().length > 12 ? true : false;
}


function check_estudiante () { // funcion que valida a los estudiantes


	var v_nombres = checkInput("#i_nombres"); // comprueba  el estado de la variable nombre
	var v_apellidos = checkInput("#apellidos");
	var v_email = checkemail("#correos");
	var v_cedula = checknumero ("#cedulas");
	var v_telefono = checknumero ("#telefonos");

	if (v_nombres)
	{
		if (v_apellidos)
		{
			if (v_email)
				{
				if (v_cedula)
				{
					if (v_telefono) {
					swal("validacion correca");
					return true;
					}
					else {
					swal("telefono incorrecto, debe de ser un valor numerico");
					return false;}
				}
				else {
				swal("cedula  incorrecta, debe ser un valor numerico");
				return false;}
				}
				else {
				swal("email incorrecto, debe tener el simbolo @ y no debe tener caracteres especiales \n ");
				return false;}
		}
		else {
		swal("Corrija el apellido: no debe de tener numeros ni caracteres especiales, \ máximo 30 caracteres");
		return false;}
	}

	else {
	swal("Corrija el nombre: no debe de tener numeros ni caracteres especiales, \ máximo 30 caracteres");
	return false;}
	}



function borrar(id, tabla) {



if (confirm("ALERTA!! va a proceder a borrar, el registro : "+id+" de la tabla :"+tabla+" ACEPTAR\n de lo contrario de click en CANCELAR.") )
	{

	$.getJSON("delete.php", {"id": id, "tabla": tabla },
 	function () {
 		swal("se eliminaron  los datos correctamente");
 	});
	consultar();
}
}


function crear_pdf(){
    // esta función permite generar un un boletin en formato pdf
    // se almacena  en la variable año

    // se almacena la variable que inica la opcion seleccionada
    // para validar puede ser boletin (6) o certificado (16)
    // obteniendolo por medio jquery  del selector #opcion
    var opcion =  $('select#opcion').val();//

    // alamcena el año seleccionado ( año lectivo calendario A)
    var year = $("#years").val();
    // se almacena la variable periodos con el periodo academico
    // a seleccionar
    var periodos = $('select#periodos').val();//

    // la variable grados guarda codigo del grado del estudiante

    var grados = $("#id_g").val();


    // si la opcion seleccionada es boletines entra aqui
    if (opcion == 6)
    {

			// se almacenan todas las variables dentro
			// de la variable parametros
			var parametros= "year="+year+
	    	"&periodos="+
	    	periodos+
	    	"&grado="+grados;

				console.log("los parametros son : %s",parametros);
				// abro boletin en una nueva ventana
				// llamando para ello al archivo cetificado.php
				window.open("generar_p.php?"+parametros);
				window.open("generar_p_borrador.php?"+parametros);
    	}
    	// de lo contrario mira si la opcion seleccionada es
    	// el certificado
    	else if (opcion == 16)
    	{
				// almacena los parametros para enviar
				// por el método GET
				var parametros= "year="+year+
	    	"&grado="+grados;
				// muestro los parámetos por consola
				console.log("los parametros son : %s",parametros);
				// abro el certificado en una nueva ventana
				// llamando para ello al archivo cetificado.php
				window.open("certificado.php?"+parametros);
    	}

}// fin de crear pdf



function obtener_pdf(){
	// esta funcion crea un pdf para preescolar
	// se almacena el año en la variable year
	var year = $("#years").val();
	// se almacena el periodo
	var periodos = $("#periodos").val();
	// y se almacenan las variables grados
	var gradosx = $("#id_g").val();
	var grados = $("#id_g").val();

	// se almacenan todas las variables dentro de la variable parametros
	var parametros= "year="+year+"&periodos="+periodos+"&grados="+gradosx+"&id_gs="+gradosx+"";
	console.log("los parametros son : %s",parametros);
	window.open("generarx.php?"+parametros);
	window.open("generarx_borrador.php?"+parametros);
}
