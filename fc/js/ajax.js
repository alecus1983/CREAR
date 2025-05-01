// este archivo contiene el los procesos principales de ajax para la comunicación de
// la pagina principal formulario_boletin.php
// con las funciones de ajax.


// esta funcion interroga a la base de datos para visualizar el contenido de sus tablas
// para lo cual toma el contenido de los selectores "consultar" (opcion) y  "adiccionar" (add)
// como criterios para  selecionar que consulta se va a ejecutar  en la base de datos
// a travez del archivo seleccion.php
// los demás campos se envian  como información para desarrollar las consultas.
 
function consultar(){
    
    if ($("#opcion option:selected").val() == 13) {
        // en caso de que la opcion se generar
	// un grafico de tendencias
        grafica();
	// muestro en pantalla
        console.log("graficando");
        
    }
    // en caso de que no se consulte un grafico
    else
    {
  	// actualiza la tabla con los valrores
  	
  	$('#resultado').load("seleccion.php",
			     { 
				 add: $("#add option:selected").val(), 
				 opcion: $("#opcion option:selected").val(), 
				 i_nombres: $("#i_nombres").val(),
				 apellidos: $("#apellidos").val(),
				 Logros: $("#Logros").val(), 
				 years: $("#years").val().toString(),
				 id_gs: $("#id_gs").val(),
				 grados:$("#grados").val() ,
				 fechas: $("#fechas").val(),
				 cedulas: $("#cedulas").val(),
				 correos : $("#correos").val(),
				 telefonos : $("#telefonos").val(),
				 areas : $("#areas").val(),
				 docentes : $("#docentes").val(),
				 fecha_fins : $("#fecha_fins").val(),
				 cursos:$("#cursos").val(),
				 estudiantes: $("#estudiantes").val(),
				 periodos: $("#periodos").val(),
				 id_ms : $("#id_ms").val(),
				 jornada: $("#jornada").val(),
				 corte: $("#corte").val()
			     },
			     function(){
				 
			     });}
    
}


// Funcion en java scrip para ingresar valores en la base de datos
// para todas las opciones del menu adiccionar
// permite agregar estudiantes, docentes, notas etc ...

function deposit(){

    // para ello comienza 
    // almacenando el codigo del grado en la variable j
    // esto para determinar que cantidad de logros tiene
    // cada estudiante,  si es de prescolar  grados 7, 8 o 9
    // tiene tres logros, de lo contrario tiene  uno
    var j = $("#grados").val();
    
    // se crea un algoritmo para computar los logors
    // la variable  k que cuenta el limite de logros (interaciones)
    // asi :
    // k = 0 --> corresponde a un logro
    // k = 1 --> corresponde a dos logros
    // k = 2 --> corresponde a tres logros
    
    var k = 0;
    
    // comienza con un algoritmo de validación
    // los grados con codigos 7, 8 y 9 tienen tres logros (k = 2) estos corresponden a pre escolar
    
    if (j == 7 || j == 8 || j == 9 ) {
 	k= 2; // asigna tres logros
 	console.log("Se cambio k a : %i", k);
    }
    
    // Si voy ha adiccionar una nota ...
    // si lo que adicciono no es una nota salto este procedimiento
    if ($("#add").val() == 11) {
	// variable que cuenta las iteraciones
	var i = 0;
	
	/// por cada checkbox ejecuta esta funcion
	$('input[type=checkbox]').each(function(){			
	    // si el checkbox esta seteado			
	    if(this.checked == true){
		
		// almaceno el id en la variable id_c el cual es el codigo del logro				
		id_c = this.id;
                // 
		if ( k >= i ) {	
		    
		    switch(i) { // estructura para seleccionar los logros
			
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
		    
		    console.log("El valor de k es: "+k+", el valor de i es :"+i+" y el id: "+id_c);
		    
		}
	    }
			
	});
	
	//  se muestra en consola los valores insertados en los campos logro 1, logro 2 y logro3	
	console.log("Logro 1 : %s",$("#logro_1").val());
	console.log("Logro 2 : %s",$("#logro_2").val());
	console.log("Logro 3 : %s",$("#logro_3").val());
    }
    
    /////////	
    if (confirm("ALERTA!! va a proceder a ingresar un  registro, "+
		"para confirmar de  click en ACEPTAR\n de lo contrario de click en CANCELAR.") ) 
    {
  	/*
  	// funcion para validar los estudiantes
        var validar;
	if ($("#opcion").val() > 0 ) {
  	
  	validar =  check_estudiante ();
  	
  	}
  	else 
  	{ validar = true;}
  	
  	
  	if (validar) {*/
        
        console.log(" add = %i",$("#add").val());
        switch($("#add").val()){
	    
            // caso en el que se adicciona una notaa
        case '11':
            $('#resultado').load("adiccion.php",
				 {
				     logro_1:$("#logro_1").val(),
				     logro_2:$("#logro_2").val(),
				     logro_3:$("#logro_3").val(),
				     nota:$("#notas").val(),
				     id_ds:$("#id_ds").val(),
				     faltas : $("#faltas").val(),
				     years: $("#years").val().toString(),
				     periodos: $("#periodos").val(),
				     grados: $("#grados").val(),
				     id_ms : $("#id_ms").val(),
				     add : $('select#add').val(),
				     estudiantes: $("#estudiantes").val(),
				     id_docentes :$("#id_docentes").val() 
				 },
				 function(){
				     console.log("Se ingresa la nota del alumno : %i", $("#estudiantes").val());
				     console.log("Nota : %i", $("#nota").val());
				     console.log("Faltas : %i", $("#faltas").val());
				 }
				 
				);
            
            $("#calificador").load("calificar.php", {"id_ms": id_m });
            
            break;
            
        case '12':
            
            alert("Se van a regenerar las tablas");
            $('#resultado').load("registros.php",
				 {
				     id_gs : $("#id_gs").val()
				 },
				 function(){
				     console.log("Se solicitan notas del grado : %i", $("#id_gs").val());
				 }
				);
            break;
            // todos los demas casos matricula de alumnos, adiccion de docentes, logros
	    // estudiantes
	    
        default:
            $('#resultado').load("adiccion.php",
				 { 
				     add: $("#add option:selected").val(), 
				     i_nombres: $("#i_nombres").val(),
				     apellidos: $("#apellidos").val(),
				     Logros: $("#Logros").val(), 
				     years: $("#years").val().toString(),
				     id_gs: $("#id_gs").val(),
				     grados:$("#grados").val(),
				     fechas: $("#fechas").val(),
				     cedulas: $("#cedulas").val(),
				     correos : $("#correos").val(),
				     telefonos : $("#telefonos").val(),
				     areas : $("#areas").val(),
				     docentes : $("#docentes").val(),
				     fecha_fins : $("#fecha_fins").val(),
				     cursos:$("#cursos").val(),
				     id_es:$("#id_es").val(),
				     id_ds:$("#id_ds").val(),
				     logro_1:$("#logro_1").val(),
				     logro_2:$("#logro_2").val(),
				     logro_3:$("#logro_3").val(),
				     nota:$("#notas").val(),
				     faltas : $("#faltas").val(),
				     estudiantes: $("#estudiantes").val(),
				     periodos: $("#periodos").val(),
				     id_ms : $("#id_ms").val(),
				     id_docentes : $("#id_docentes").val().toString(),
				     k : k
				 },
				 function(){
				     console.log("Se ingresaron valores varios %s", $("#add").val());
				     //console.log("Faltas : %i", $("#faltas").val());
				 });
            break;
        }
        
        
    }
    // Ingresa si se van a matricular un alumno
    // 
    // 7 -- Matricula alumno 
    // 9 -- Requisito de materia
    
    
    
    
}


function upgrade() {
	
		
	// Este m�todo llama a el archivo actualizar.php, el cual se encarga
        // de ejecutar las consultas de actualizaci�n dentro de la base de datos
        // para ello se basa en los valores de referencia de las variables a trav�s
        // del  m�todo load 
	$("#resultado").load("/campos/actualizar.php", {
		
		id_ds:$("#id_ds").val(), // eta variable guarda el c�digo del docente		
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
		areas:$("areas").val()
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

function actualizar_docente() {
	// Esta es la funcion recarga los valores en los campos de texto  despues que se  cambia el codigo
	
	if ($("#edi").val() == 2 ) {	
	// recupero el idenificador del nombre

	var id_nombre = $("#id_ds").val();

	// recuperando  nombre
	console.log("Abriendo archivo ...");

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
 	
 	}

}


//  esta funcion se utiliza para validar  los nombress

function checkInput(idInput, pattern) {
	
	//alert(idInput); 
	var valor = $(idInput).val();
	//alert(valor);
	if( valor == null || valor.length == 0 || /^\s+$/.test(valor)) {
  	return false;}
  	else { return true;}
  	}


function checknumero(idInput, pattern) {
	
	//alert(idInput); 
	var valor = $(idInput).val();
	//alert(valor);
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
					alert("validacion correca");				
					return true;
					}
					else { 
					alert("telefono incorrecto, debe de ser un valor numerico");
					return false;}
				}
				else { 
				alert("cedula  incorrecta, debe ser un valor numerico");
				return false;}
				}	
				else { 
				alert("email incorrecto, debe tener el simbolo @ y no debe tener caracteres especiales \n ");
				return false;}
		} 
		else { 
		alert("Corrija el apellido: no debe de tener numeros ni caracteres especiales, \ máximo 30 caracteres");
		return false;}
	}
	
	else { 
	alert("Corrija el nombre: no debe de tener numeros ni caracteres especiales, \ máximo 30 caracteres");	
	return false;}
	}
	


function borrar(id, tabla) {
	
	

if (confirm("ALERTA!! va a proceder a borrar, el registro : "+id+" de la tabla :"+tabla+" ACEPTAR\n de lo contrario de click en CANCELAR.") ) 
	{

	$.getJSON("campos/delete.php", {"id": id, "tabla": tabla },
 	function () {
 		alert("se eliminaron  los datos correctamente");
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
    
    var grados = $("#id_gs").val();


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
	
}



function obtener_pdf(){
	// esta funcion crea un pdf para preescolar
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

