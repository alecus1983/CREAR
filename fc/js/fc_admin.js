// codigo de persona
let id_persona = 0;
// codigo de alumno
let id_alumno = 0;

// objeto tipo acudiente
let acudiente = {
  id_acudiente: 0,
  id_persona: 0,
  id_hijo: 0,
  fecha: "",
  nombres: "",
  apellidos: "",
  identificacion: "",
  tipo_identificacion: "",
  nacimiento: "",
  correo: "",
  i_correo: "",
  celular: "",
  telefono: ""
};

// objeto tipo padre
let padre = {
  id_padre: 0,
  id_persona: 0,
  id_hijo: 0,
  fecha: "",
  nombres: "",
  apellidos: "",
  identificacion: "",
  tipo_identificacion: "",
  nacimiento: "",
  correo: "",
  i_correo: "",
  celular: "",
  telefono: ""
};

// objeto tipo padre
let madre = {
  id_padre: 0,
  id_persona: 0,
  id_hijo: 0,
  fecha: "",
  nombres: "",
  apellidos: "",
  identificacion: "",
  tipo_identificacion: "",
  nacimiento: "",
  correo: "",
  i_correo: "",
  celular: "",
  telefono: ""
};

// objeto docente
let docente = {
  id_docente: 0,
  id_persona: 0,
  fecha: "",
  nombres: "",
  apellidos: "",
  identificacion: "",
  tipo_identificacion: "",
  nacimiento: "",
  correo: "",
  i_correo: "",
  celular: "",
  telefono: ""
};

// objeto almno
let alumno = {
  id_alumno: 0,
  id_persona: 0,
  id_grado : 0,
  id_jornada : 0,
  year : 0,
  id_curso : 0,
  id_escolaridad : 0,
  fecha: "",
  nombres: "",
  apellidos: "",
  identificacion: "",
  tipo_identificacion: "",
  nacimiento: "",
  correo: "",
  i_correo: "",
  celular: "",
  telefono: "",
  direccion_residencia: "",
  barrio: "",
  estrato: "",
  sisben: "",
  familias_accion: false,
  regimen_salud: false,
  eps: "",
  vive_con: "",
  tipo_victima_conflicto: "",
  municipio_expulsor: "",
  discapacitado: false,
  tipo_discapacidad: "",
  capacidad_excepcional: "",
  etnia: false,
  tipo_etnia: "",
  resguardo_consejo: "",
  antecedentes_patologicos_medicos: "",
  antecedentes_patologicos_quirurgicos: "",
  antecedentes_patologicos_toxicos: "",
  antecedentes_patologicos_psiquiatricos: "",
  antecedentes_patologicos_psicologicos: "",
  antecedentes_patologicos_morbilidad: "",
  ips: "",
  rh: "",
  tipo_sangre: ""
};

// objeto persona
let persona = {
  id_persona: 0,
  nombres: "",
  apellidos: "",
  identificacion: "",
  tipo_identificacion: "",
  nacimiento: "",
  correo: "",
  i_correo: "",
  celular: "",
  telefono: "",
  u_alumno: "",
  u_docentes: "",
  direccion_residencia: "",
  barrio: "",
  estrato: "",
  sisben: "",
  familias_accion: false,
  regimen_salud: false,
  eps: "",
  vive_con: "",
  tipo_victima_conflicto: "",
  municipio_expulsor: "",
  discapacitado: false,
  tipo_discapacidad: "",
  capacidad_excepcional: "",
  etnia: false,
  tipo_etnia: "",
  resguardo_consejo: "",
  antecedentes_patologicos_medicos: "",
  antecedentes_patologicos_quirurgicos: "",
  antecedentes_patologicos_toxicos: "",
  antecedentes_patologicos_psiquiatricos: "",
  antecedentes_patologicos_psicologicos: "",
  antecedentes_patologicos_morbilidad: "",
  ips: "",
  rh: "",
  tipo_sangre: ""
};

// variable de matriculas
let matricula ={
  id : "",
  id_alumno : "",
  id_grado : "",
  id_jornada : "",
  year : "",
  mes : "",
  retiro : "",
  id_curso : ""
};

// codigo de docente
let id_docente = 0;

// funcion que carga las semanas correctas cuando cambia
// el Periodo de calificaciones
// funcion para cargar las materias en el cuadro de dialogo
// de acurdo al grado seleccionado

function load_materias() {
  var id_docente = $("#id_d").val();
  var id_grado = $("#id_g").val();
  var year = $("#years").val();
  // carga las materias dentro del selector de materias
  carga("#id_ms", "materias_grado.php", {
    grados: id_grado,
    id: id_docente,
    year: year
  });

  // coloco el fondo al selector materias
  $('#id_ms').css('background-color', 'lightblue');
  
}

// Estructura  para  editar matriculas
function editar_matriculas(item,dato){

  switch (item){
    // tomo el codigo de la matricula
    // y visualizo los datos principales
    // del estudiante en 
  case 1:
    // solicito el valor de la matricula
    // con el id  proveniente en el valor dato
    matricula = consultar_matricula(dato);
    
    $("#avance").html("");
    $("#tabla").html("");
    // cargo el formulario para un estudiante
    $("#avance").load("formulario_editar_matricula_1.html",
		      function () {
			// si retorno un  numero de matricula dado
			// entonces 
			if (matricula.id){ 
			  // agrego al div #paginas
			  // el  formulario html
			  $("#paginas").append(
			  "<ul>"+
			    "<li>código de la matricula : "+matricula.id+"</li>"+
			    "<li>código del alumno : "+matricula.id_alumno+"</li>"+
			    "</ul>"
			)};
    });
    

    break;
    
    // edito los datos de la residencia
  case 2:
   
    break;
 // Edito los dato academicos
  case 3:

    break;
// edito los datos de afiliaciones
  case 4:

    break;

    // edito los antecedentes patologicos
  case 5:

    break;
   
  }
}


// Estructura de seleccion  para gestionar el formulario de agregra matriculas
// requiere como parametro de entrada el item del formulario

function gestion_matriculas(item) {

  // estructura de seleccion
  switch (item) {

    // 1. INFORMACION DEL ESTUDIANTE

  case 1: // cargo el primer formulario de matricula
    $("#avance").html("");
    $("#tabla").html("");
    $("#avance").load("formulario_matricula_1.html");
    break;

  case 2: // para personas nuevas coloco este formulario
    $("#avance").html("");
    $("#tabla").html("");
    $("#avance").load("formulario_matricula_2.html", function () {
      //	agrega el formulario de personas
      $("#paginas").load("formulario_agregar_persona.html", function () {
	$("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(1)">atras</button>');
	$("#paginas").append('<button type="button" class="btn btn-secondary" onclick="agregar_persona(4,alumno)">agregar</button>');
      });

    });
    break;

  case 3: // para personas antiguas coloco este formulario
    $("#avance").html("");
    $("#tabla").html("");
    // Cargar formulario_matricula_3.html
    $("#avance").load("formulario_matricula_3.html", function () {
      $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(1)">atras</button>');
    });
    break;

    // SELECCIONAR ALUMNO	
  case 4:
    $("#avance").html("");
    $("#tabla").html("");
    $("#avance").load("formulario_matricula_4.html", function () {
      $("#paginas").html("<p>Se ha selecionado la persona <b>"
			 + alumno["nombres"] + " " + alumno["apellidos"]
			 + "</b>, con codigo " + alumno["id_persona"]
			 + ", con identificacion " + alumno["identificacion"] + "</p>");
      $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(1)">atras</button>');
      $("#paginas").append('<button type="button" class="btn btn-dark" onclick="gestion_matriculas(5);">siguiente</button>');

    });
    break;

    // recoleccion de la direccion del alumno
  case 5:
    $("#avance").html("");
    $("#tabla").html("");
    $("#avance").load("formulario_matricula_5.html", function () {

      // obtengo la direccion de la persona
      get_direccion(alumno, 2);


      // se carga  el formulario
      $("#paginas").load("formulario_actualizar_direccion.html", function () {
	// obtengo el valor de la direccion
	$("#ac_direccion").val(alumno["direccion_residencia"]);
	// obtengo el valor del barrio
	$("#ac_barrio").val(alumno["barrio"]);

	switch (alumno["estrato"]) {
	case "1":
	  $("#ac_estrato").val("1");
	  break;

	case "2":
	  $("#ac_estrato").val("2");
	  break;

	case "3":
	  $("#ac_estrato").val("3");
	  break;

	case "4":
	  $("#ac_estrato").val("4");
	  break;

	case "5":
	  $("#ac_estrato").val("5");
	  break;
	}

	// agrego el encabezado del estudiante
	$("#paginas").prepend("<p>Se ha selecionado la persona <b>"
			      + alumno["nombres"] + " "
			      + alumno["apellidos"] + "</b>, con codigo "
			      + alumno["id_persona"] + ", con identificacion "
			      + alumno["identificacion"] + "</p>");
	// agrego los botones 
	$("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(1)">atras</button>');
	$("#paginas").append('<button id="agregar_persona" class="btn btn btn-dark" onclick="update_direccion(2,alumno);">agregar/actualizar</button>');
      });
    });


    break;

    // DATOS ACADEMICOS

  case 6:

    // borro el contenido del div
    $("#avance").html("");
    // borro el contenido del div
    $("#tabla").html("");

    // cargo el formulario 6 de matricula entonces realizo la funcion ...
    $("#avance").load("formulario_matricula_6.html", function () {
      // llamo a la funcion de listar jornadas
      lista_jornadas("#ac_jornada");
      // llamo a la funcion lista escolaridad
      // en el camobo  
      lista_escolaridad("#ac_escolaridad");
      $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(5)">atras</button>');
      $("#paginas").append('<button id="agregar_persona" class="btn btn btn-dark" onclick="update_grado_matricula();">agregar/actualizar</button>');

      
    });

    break;
    
    // AFILIACIONES

  case 7:
    // criterio de inicio
    $("#avance").html("");
    $("#tabla").html("");

    // cargo en el div acance el formulario 7
    $("#avance").load("formulario_matricula_7.html", function () {

      $("#paginas").load("formulario_actualizar_afiliaciones.html", function () {
	$("#paginas").prepend("<p>Se ha selecionado la persona <b>" + alumno["nombres"]
			      + " " + alumno["apellidos"] + "</b>, con codigo " + alumno["id_persona"]
			      + ", con identificacion " + alumno["identificacion"] + "</p>");
	// obtengo los datos de afiliacion en 
	// este formuulario 	
	get_afiliacion(alumno["id_persona"], 2);
      });

    });

    break;

    // datos para actualizar datos patologicos	

  case 8:

    $("#avance").html("");
    $("#tabla").html("");

    // se carga el formulario 8
    $("#avance").load("formulario_matricula_8.html", function () {
      // se carga formulario de antecedentes patologicos
      $("#paginas").load("formulario_actualizar_antecedentes_patologicos.html", function () {
	// se carga los datos del encabezado del estudiante
	$("#paginas").prepend("<p>Se ha selecionado la persona <b>"
			      + alumno["nombres"] + " " + alumno["apellidos"]
			      + "</b>, con codigo " + alumno["id_persona"]
			      + ", con identificacion " + alumno["identificacion"] + "</p>");
	// agrego el boton 
	$("#paginas").append("<button id='agregar_persona' class='btn btn btn-dark' onclick='actualizar_antecedentes_patologicos(alumno);'>agregar/actualizar</button>");
	// cargo los valores en un nuevo formulario
	get_antecedemtes(alumno["id_persona"], 2);
      });

    });


    break;

    // DATOS DEL PADRE
  case 9:
    $("#avance").html("");
    $("#tabla").html("");
    $("#avance").load("formulario_matricula_9.html");

    break;

    // AGREGAR  PADRE

  case 10:
    $("#avance").html("");
    $("#tabla").html("");
    $("#avance").load("formulario_matricula_10.html", function () {
      //	agrega el formulario de personas
      $("#paginas").load("formulario_agregar_persona.html", function () {
	$("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(9)">atras</button>');
	$("#paginas").append('<button type="button" class="btn btn-secondary" onclick="agregar_persona(12,padre)">agregar</button>');
      });

    });
    break;
    
    // PADRE REGISTRADO

  case 11:
    $("#avance").html("");
    $("#tabla").html("");
    // Cargar formulario_matricula_11.html
    $("#avance").load("formulario_matricula_11.html", function () {

      $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(9)">atras</button>');
    });
    break;

    // PADRE SELECCIONADO
  case 12:
    $("#avance").html("");
    $("#tabla").html("");
    //  cargo el formulario 11 de matricula en el campo avance
    $("#avance").load("formulario_matricula_12.html", function () {
      // cargo el contenido dentro la seccion paginas dentro del formulario
      $("#paginas").html("<p>Se ha selecionado la persona <b>"
			 + padre["nombres"] + " " + padre["apellidos"]
			 + "</b>, con codigo " + padre["id_persona"]
			 + ", con identificacion " + padre["identificacion"] + "</p>");
      $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(8)">atras</button>');
      $("#paginas").append('<button type="button" class="btn btn-dark" onclick="gestion_matriculas(13);">siguiente</button>');

    });
    break;

    // DATOS DE LA MADRE
  case 13:
    $("#avance").html("");
    $("#tabla").html("");
    $("#avance").load("formulario_matricula_13.html");
    break;

    // MADRE NUEVA

  case 14:
    $("#avance").html("");
    $("#tabla").html("");

    $("#avance").load("formulario_matricula_14.html", function () {
      //	agrega el formulario de personas
      $("#paginas").load("formulario_agregar_persona.html", function () {
	$("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(13)">atras</button>');
	$("#paginas").append('<button type="button" class="btn btn-secondary" onclick="agregar_persona(16,madre)">agregar</button>');
      });

    });
    break;

    // MADRE REGISTRADA
  case 15:
    $("#avance").html("");
    $("#tabla").html("");
    // Cargar formulario_matricula_15.html
    $("#avance").load("formulario_matricula_15.html", function () {

      $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(13)">atras</button>');
    });
    break;

    // MADRE SELECCIONADA
  case 16:
    $("#avance").html("");
    $("#tabla").html("");
    //  cargo el formulario 16 de matricula en el campo avance
    $("#avance").load("formulario_matricula_16.html", function () {
      // cargo el contenido dentro la seccion paginas dentro del formulario
      $("#paginas").html("<p>Se ha selecionado la persona <b>"
			 + madre["nombres"] + " " + madre["apellidos"]
			 + "</b>, con codigo " + madre["id_persona"]
			 + ", con identificacion " + madre["identificacion"] + "</p>");
      $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(13)">atras</button>');
      $("#paginas").append('<button type="button" class="btn btn-dark" onclick="gestion_matriculas(17);">siguiente</button>');

    });
    break;

    // DATOS DEL ACUDIENTE

  case 17:
    $("#avance").html("");
    $("#tabla").html("");
    $("#avance").load("formulario_matricula_17.html");
    break;

    // AGREGAR ACUDIENTE
  case 18:
    $("#avance").html("");
    $("#tabla").html("");
    $("#avance").load("formulario_matricula_18.html", function () {
      //	agrega el formulario de personas
      $("#paginas").load("formulario_agregar_persona.html", function () {
	$("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(17)">atras</button>');
	$("#paginas").append('<button type="button" class="btn btn-secondary" onclick="agregar_persona(19,acudinte)">agregar</button>');
      });

    });
    break;

    // ACUDIENTE SELECCIONADO

  case 19:
    $("#avance").html("");
    $("#tabla").html("");
    // Cargar formulario_matricula_3.html
    $("#avance").load("formulario_matricula_19.html", function () {

      // cargo el contenido dentro la seccion paginas dentro del formulario
      $("#paginas").html("<p>Se ha selecionado la persona <b>"
			 + acudiente["nombres"] + " " + acudiente["apellidos"]
			 + "</b>, con codigo " + acudiente["id_persona"]
			 + ", con identificacion " + acudiente["identificacion"] + "</p>");
      $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(17)">atras</button>');
      $("#paginas").append('<button type="button" class="btn btn-dark" onclick="gestion_matriculas(20);">siguiente</button>');

    });
    break;
    // resumen de la matricual
  case 20:
    // limpio el formulario
    $("#avance").html("");
    $("#tabla").html("");
    //  cargo el formulario 20 de matricula en el campo avance
    $("#avance").load("formulario_matricula_20.html", function () {
      
      // cargo el contenido dentro la seccion paginas dentro del formulario
      $("#paginas").html("<p>Los datos de la matricula son :</p>");
      // muestro los datos del alumnos
      $("#paginas").append("<p> <i><h3>Datos del alumno</h3></i></p>");
      $("#paginas").append("<p> nombre : <b>"+alumno["nombres"]+" " + alumno["apellidos"]+"</b></p>");
      $("#paginas").append("<p> tipo de identificacion  : <b>"+alumno["tipo_identificacion"]+"</b></p>");
      $("#paginas").append("<p> identificacion : <b>"+alumno["identificacion"]+"</b></p>");
      $("#paginas").append("<p> grado : <b>"+alumno["id_grado"]+"</b></p>");
      $("#paginas").append("<p> jornada : <b>"+alumno["id_jornada"]+"</b></p>");
      $("#paginas").append("<p> curso : <b>"+alumno["id_curso"]+"</b></p>");
      $("#paginas").append("<p> escolaridad : <b>"+alumno["id_escolaridad"]+"</b></p>");
      $("#paginas").append("<p> año : <b>"+alumno["year"]+"</b></p>");
      $("#paginas").append("<p> fecha : <b>"+alumno["fecha"]+"</b></p>");
      $("#paginas").append("<p> nacimiento : <b>"+alumno["nacimiento"]+"</b></p>");
      $("#paginas").append("<p> correo : <b>"+alumno["correo"]+"</b></p>");
      $("#paginas").append("<p> correo institucional : <b>"+alumno["i_correo"]+"</b></p>");
      $("#paginas").append("<p> celular : <b>"+alumno["celular"]+"</b></p>");
      $("#paginas").append("<p> telefono : <b>"+alumno["telefono"]+"</b></p>");
      $("#paginas").append("<p> dirección : <b>"+alumno["direccion_residencia"]+"</b></p>");
      $("#paginas").append("<p> barrio : <b>"+alumno["barrio"]+"</b></p>");
      $("#paginas").append("<p> curso : <b>"+alumno["id_curso"]+"</b></p>");
      $("#paginas").append("<p> estrato : <b>"+alumno["estrato"]+"</b></p>");
      $("#paginas").append("<p> sisben : <b>"+alumno["sisben"]+"</b></p>");
      $("#paginas").append("<p> eps : <b>"+alumno["eps"]+"</b></p>");
      $("#paginas").append("<p> vivie_con : <b>"+alumno["vivie_con"]+"</b></p>");

      // muestro los datos del padre
      $("#paginas").append("<p> <i><h3>Datos del padre :</h3></i></p>");
      $("#paginas").append("<p> nombre : <b>"+padre["nombres"]+" " + padre["apellidos"]+"</b></p>");
      $("#paginas").append("<p> tipo de identificacion  : <b>"+padre["tipo_identificacion"]+"</b></p>");
      $("#paginas").append("<p> identificacion : <b>"+padre["identificacion"]+"</b></p>");
      $("#paginas").append("<p> nacimiento : <b>"+padre["nacimiento"]+"</b></p>");
      $("#paginas").append("<p> correo : <b>"+padre["correo"]+"</b></p>");
      $("#paginas").append("<p> correo institucional : <b>"+padre["i_correo"]+"</b></p>");
      $("#paginas").append("<p> celular : <b>"+padre["celular"]+"</b></p>");
      $("#paginas").append("<p> telefono : <b>"+padre["telefono"]+"</b></p>");

      // muestro los datos de la madre
      $("#paginas").append("<p> <i><h3>Datos de la madre</h3></i></p>");
      $("#paginas").append("<p> nombre : <b>"+madre["nombres"]+" " + madre["apellidos"]+"</b></p>");
      $("#paginas").append("<p> tipo de identificacion  : <b>"+madre["tipo_identificacion"]+"</b></p>");
      $("#paginas").append("<p> identificacion : <b>"+madre["identificacion"]+"</b></p>");
      $("#paginas").append("<p> nacimiento : <b>"+madre["nacimiento"]+"</b></p>");
      $("#paginas").append("<p> correo : <b>"+madre["correo"]+"</b></p>");
      $("#paginas").append("<p> correo institucional : <b>"+madre["i_correo"]+"</b></p>");
      $("#paginas").append("<p> celular : <b>"+madre["celular"]+"</b></p>");
      $("#paginas").append("<p> telefono : <b>"+madre["telefono"]+"</b></p>");
      
      // muestro los botones de aceptar
      $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(17)">atras</button>');
      $("#paginas").append('<button type="button" class="btn btn-outline-success" onclick="gestion_matriculas(21);">finalizar</button>');

    });
    break;

    // DATOS FINALES

  case 21:
    $("#avance").html("");
    $("#tabla").html("");
    $("#avance").load("formulario_matricula_21.html");

    // Muestra la alerta de confirmación usando SweetAlert2
    
    swal({
      title: '¿Estás seguro?',
      text: "¿Está seguro que desea generar la matrícula para el estudiante " + alumno["nombres"] + " " + alumno["apellidos"] + "?",
      icon: 'warning',
      buttons: ["cancelar", "generar"],
    }).then((result) => {
      if (result) { // Si el usuario hace clic en "generar"
        
        // Revisar si el alumno tiene código y asignarle uno si no lo tiene
	verificar_alumno(alumno["id_persona"]);
	
        
        // Realizar la matrícula del alumno	
        // Aquí deberías agregar tu lógica de matrícula
	matricular();

	$("#paginas").html("<p>Se ha completado la matricula del alumno ");
	$("#paginas").append(alumno["nombres"]+" "+alumno["apellidos"] +" </p>");
	
	
        // Actualizar la información del padre
        // Aquí se puede agregar el código para actualizar la información del padre

        // Actualizar la información de la madre
        // Aquí se puede agregar el código para actualizar la información de la madre

        // Actualizar la información del acudiente
        // Aquí se puede agregar el código para actualizar la información del acudiente

        // Confirmar que la información ha sido procesada correctamente
        swal(
          'Agregado!',
          'La información ha sido actualizada correctamente.',
          'success'
        );

        // Cargar el siguiente formulario
        ///$("#avance").load("formulario_matricula_20.html");

      } else { // Si el usuario hace clic en "cancelar"
        swal(
          'Cancelado',
          'No se ha realizado ningún cambio.',
          'error'
        );

        // Llamar a la función que maneja la gestión de matrículas
        gestion_matriculas(19);
      }
    });




    break;


  }


  // consulto si el estudiante es nuevo o antiguo

  // si es nuevo solicito los datos y lo selecciono

  // si es antiguo lo busco y selecciono

  // obtengo el estudiante seleccionado

  // 2. ACTUALIZO INFORMACION PATOLOGICA	

  // actualizo antecedentes patologicos


  // si tiene padre asociado lo actualizo

  // si no tiene padre asociado reviso si es un padre registrado o no registrado

  // si es registrado lo selecciono 

  // si no esta registrado lo registro


}

// funcion que realiza la matricula de un alumno
// requiere el codigo del alumno
// el codigo de la jornad
// el codigo del curso
// y  el año, se asume el mes de ingreso y de retiro

function matricular(){

   $.ajax({
    type: "POST",
    url: "matricular_alumno.php",
    dataType: "json",
    data: alumno,
    // si los datos son correctos entonces ...
    success: function (respuesta) {
      // si la respuesta es positiva
      if (respuesta['status'] == 1) {
	swal('Se matriculo el alumno con exito');
	//$("#calificador").html(respuesta);
      }
    },
    error: function (xhr, status) {
      swal('Disculpe, existió un problema al matricular el alumno');
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

    },
    // si los datos son correctos entonces ...
    success: function (respuesta) {
      // si la respuesta es positiva
      if (respuesta['status'] == 1) {
	//swal('Datos actualizados');
	//$("#calificador").html(respuesta);
	$("#avance").html(respuesta['html']);
      } else {
	if (respuesta['status'] == 21) {
	  swal('Grado', 'Porfavor seleccione un grado', 'error');
	}
	if (respuesta['status'] == 22) {
	  swal('Año', 'Porfavor seleccione un año', 'error');
	}
	if (respuesta['status'] == 23) {
	  swal('Jornada', 'Porfavor seleccione un jornada', 'error');
	}
	if (respuesta['status'] == 24) {
	  swal('Semana', 'Porfavor seleccione una semana', 'error');
	}

      }
    },
    error: function (xhr, status) {
      swal('Disculpe, existió un problema');
      console.log(xhr);
    }
  });

}

// funcion para cargar la lista de  estudiantes en el
// div calificador
function load_lista_estudiantes() {

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
	semana: $("#semana").val(),
	escolaridad: $("#escolaridad").val()
    },
    // si los datos son correctos entonces ...
    success: function (respuesta) {

      $("#calificador").html(respuesta);
      $("#resultado").html("");

    },
    error: function (xhr, status) {
      swal('Disculpe, existió un problema');
      console.log(xhr);
    }
  });

}

// el listado de estudiantes matriculados en un grado
// en un curso y una jornada

function listado_matricula_escolaridad_jornada(){

  $.ajax({
    type: "POST",
    url: "listado_matricula_escolaridad.php",
    dataType: "json",
    data: {
      years: $("#years").val(),
      id_escolaridad :  $("#escolaridad").val(),
      id_jornada : $("#jornada").val()
    },
    // si los datos son correctos entonces ...
    success: function (respuesta) {
      // si la respuesta es positiva
      if (respuesta['status'] == 1) {
	//swal('Datos actualizados');
	
	$("#avance").html(respuesta['html']);
      } else {
	// si la respuesta es erronea 
	if (respuesta['status'] == 22) {
	  swal('Escolaridad', 'Porfavor seleccione una escolaridad', 'error');
	}

      }
    },
    error: function (xhr, status) {
      swal('Disculpe, existió un problema');
      console.log(xhr);
    }
  });
  
}

// el listado de estudiantes matriculados en un grado
// en un curso y una jornada

function listado_matricula_grado(){


  // funcion ajax para importar
  // los datos desde el archivo listado_matricula_grado.php
  $.ajax({
    type: "POST",
    url: "listado_matricula_grado.php",
    dataType: "json",
    data: {
      years: $("#years").val(),
      id_grado : $("#id_g").val(),
      id_curso :  $("#id_c").val(),
      id_jornada : $("#jornada").val()

    },
    // si los datos son correctos entonces ...
    success: function (respuesta) {
      // si la respuesta es positiva
      if (respuesta['status'] == 1) {
	//swal('Datos actualizados');
	//$("#calificador").html(respuesta);
	$("#avance").html(respuesta['html']);
      } else {

	if (respuesta['status'] == 22) {
	  swal('Año', 'Porfavor seleccione un año', 'error');
	}

      }
    },
    error: function (xhr, status) {
      swal('Disculpe, existió un problema');
      console.log(xhr);
    }
  });  
}

// funcion que muestra la lista de estudiantes  matriculados
// durante un año
function listado_estudiantes_matriculados() {

  // se invoca al metodo ajax para solicitar
  // el listado de estudiantes
  $.ajax({
    type: "POST",
    url: "listado_estudiantes_matriculados_ano.php",
    dataType: "json",
    data: {
      years: $("#years").val(),

    },
    // si los datos son correctos entonces ...
    success: function (respuesta) {
      // si la respuesta es positiva
      if (respuesta['status'] == 1) {
	//swal('Datos actualizados');
	//$("#calificador").html(respuesta);
	$("#avance").html(respuesta['html']);
      } else {

	if (respuesta['status'] == 22) {
	  swal('Año', 'Porfavor seleccione un año', 'error');
	}

      }
    },
    error: function (xhr, status) {
      swal('Disculpe, existió un problema');
      console.log(xhr);
    }
  });

}

// funcion que agrega una matricaula docente al listado
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
    },
    // si los datos son correctos entonces ...
    success: function (respuesta) {
      // si la respuesta es positiva
      if (respuesta['status'] == 1) {
	//swal('Datos actualizados');

	swal('Actualizacion', 'Se insertaron los dastos con éxito', 'success');
	matricula_docente();
      } else {
	if (respuesta['status'] == 21) {
	  swal('Grado', 'Porfavor seleccione un grado', 'error');
	}
	if (respuesta['status'] == 22) {
	  swal('Año', 'Porfavor seleccione un año', 'error');
	}
	if (respuesta['status'] == 23) {
	  swal('Jornada', 'Porfavor seleccione un jornada', 'error');
	}
	if (respuesta['status'] == 24) {
	  swal('Semana', 'Porfavor seleccione una semana', 'error');
	}
	if (respuesta['status'] == 25) {
	  swal('Materia', 'Porfavor seleccione una materia', 'error');
	}
	if (respuesta['status'] == 26) {
	  swal('Curso', 'Porfavor seleccione un curso', 'error');
	}
	if (respuesta['status'] == 27) {
	  swal('Docente', 'Porfavor seleccione un docente', 'error');
	}
      }
    },
    error: function (xhr, status) {
      swal('Disculpe, existió un problema');
      console.log(xhr);
    }
  });
}

// elimina la matricula docente
function eliminar_matricula_docente(id) {

  // se invoca al metodo ajax para solicitar
  // el listado de estudiantes
  $.ajax({
    type: "POST",
    url: "del_matricula_docente.php",
    dataType: "json",
    data: {
      id: id
    },
    // si los datos son correctos entonces ...
    success: function (respuesta) {
      // si la respuesta es positiva
      if (respuesta['status'] == 1) {
	//swal('Datos actualizados');
	swal('Actualizacion', 'Se elimino el docente del curso', 'success');
	matricula_docente();
      } else {
	if (respuesta['status'] == 20) {
	  swal('Error', 'Hubo un error al eliminar la matricula docente', 'error');
	}
	if (respuesta['status'] == 21) {
	  swal('Error', 'Hubo un error al eliminar la matricula docente', 'error');
	}
      }
    },
    error: function (xhr, status) {
      swal('Disculpe, existió un problema');
      console.log(xhr);
    }
  });
}

// actualiza el formulario
function actualizar() {
  load_materias();
  load_lista_estudiantes();
}


function boletin() {
  // almaceno el valor del grado
  grado = $("#id_g").val();

  if (grado == -1) {
    // en caso de que no se halla digitado un grado 
    swal("Datos", "Por favor seleccione un grado", "info");
  } else if (grado < 7 || grado > 9) {
    // llama a la funcion generar para generar el boletin
    // que corresponde al modelo de primaria
      //crear_pdf();

      var year = $("#years").val();
      // se almacena la variable periodos con el periodo academico
      // a seleccionar
      var periodos = $('select#periodos').val();
      // la variable grados guarda codigo del grado del estudiante
      var grados = $("#id_g").val();
      // agrego la jornada
      var jornada = $("#jornada").val();
      // describo el curso
      var curso = $("#id_c").val();
      // si no ha seleccionado grado
       if (grados < 0) {
        swal("Favor seleccione un grado");
      } else if (periodos < 0) {
        swal("Favor seleccione un periodo");
      } else {

      // se almacenan todas las variables dentro
      // de la variable parametros
      var parametros = "year=" + year +
      	"&periodos=" +
      	periodos +
      	"&grado=" + grados +
      	"&jornada=" + jornada +
      	"&curso=" + curso;

        console.log("los parametros son : %s", parametros);
      // abro boletin en una nueva ventana
      // llamando para ello al archivo cetificado.php
        window.open("generar_p.php?" + parametros);
      } 
  } else {
      // llama a la funcion generarx la cual genera el boletin tipo preescolar
      obtener_pdf();
  }
}

// funcion que crea un cuadro de notas por cada alumno de un grado para un determinado año
function cuadro() {

  $('#loader').show();
  // esta función permite generar un un boletin en formato pdf
  // se almacena  en la variable año
  // alamcena el año seleccionado ( año lectivo calendario A)
  var year = $("#years").val();
  // se almacena la variable periodos con el periodo academico
  // a seleccionar
  var periodos = $('select#periodos').val(); //
  // la variable grados guarda codigo del grado del estudiante
  var grados = $("#id_g").val();
  // agrego la jornada
  var jornada = $("#jornada").val();
  // describo el curso
  var curso = $("#id_c").val();
  // listado de estudiantes
  // var l = array();

  // si el grado es negativo significa que  no se ha seleccionado ningun atributo
  // en el selector
  if (grados < 0) {
    swal("Favor seleccione un grado");
  }
  // si los periodos son iguales a menos uno es porque no se ha seleccionado ningun
  // atributo en el selector de peridos
  else if (periodos < 0) {
    swal("Favor seleccione un periodo");
  } else {

    // se invoca a funcion que retorna el listado de estudiantes de un grado
    $("#avance").html("");
    // se carga el loader
    $(".loader").show();
    // variable para almacenar las listas
    var l;

    // se consulta cada estudiante
    $.ajax({
      type: "POST",
      async: false,
      dataType: "json",
      url: "listado_estudiantes_json.php",
      data: {
	id_jornada: $("#jornada").val(),
	curso: $("#id_c").val(),
	semana: $("#semana").val(),
	periodo: $("#periodos").val(),
	grado: $("#id_g").val(),
	years: $("#years").val()
      },
      success: function (listado) {
	//si se hizo la consulta arrojo la lista de estudiante
	//console.log(listado.id_alumno);
	//swal("Se ejecuto con exito");
	// por cada alumno ejecuto este codigo
	l = listado.id_alumno;
      }
    });

    //  estructura de repeticion para buscar
    // el cuadro de notas por cada estudiante
    for (var ii = 0; ii < l.length; ii++) {
      // salida por consola
      //console.log('algoritmo para el alumno ' + ii + " codigo " + l[ii]);
      // solicito un cuadro de dialogo para un estudiante
      $.ajax({
	type: "POST",
	async: false,
	url: "cuadro.php",
	data: {
	  years: $("#years").val(),
	  jornada: $("#jornada").val(),
	  periodo: $("#periodos").val(),
	  id_g: $("#id_g").val(),
	  id_curso: $("#id_c").val(),
	  id_alumno: l[ii]
	},

	success: function (cuadro) {
	  $("#avance").append(cuadro);
	},
	error: function (xhr, status) {
	  swal('Disculpe, existió un problema' + status);
	  console.log(xhr);
	}

      });

    }

    // Por cada estudiante se ejecuta la iguiente rutina

    // se llama mediante ajax la
    $('#loader').hide();
  } // fin del else
  $('#loader').hide();
}

function crear_pdf() {
  // esta función permite generar un un boletin en formato pdf
  // se almacena  en la variable año
    // alamcena el año seleccionado ( año lectivo calendario A)
    var a = 1;
  //var year = $("#years").val();
  // se almacena la variable periodos con el periodo academico
  // a seleccionar
  //var periodos = $('select#periodos').val();
  // la variable grados guarda codigo del grado del estudiante
  //var grados = $("#id_g").val();
  // agrego la jornada
  // jornada = $("#jornada").val();
  // describo el curso
  //var curso = $("#id_c").val();
  // si no ha seleccionado grado
  // if (grados < 0) {
  //  swal("Favor seleccione un grado");
  //} else if (periodos < 0) {
  //  swal("Favor seleccione un periodo");
  //} else {

    // se almacenan todas las variables dentro
    // de la variable parametros
    //var parametros = "year=" + year +
//	"&periodos=" +
//	periodos +
//	"&grado=" + grados +
//	"&jornada=" + jornada +
//	"&curso=" + curso;

  //  console.log("los parametros son : %s", parametros);
    // abro boletin en una nueva ventana
    // llamando para ello al archivo cetificado.php
  //  window.open("generar_p.php?" + parametros);
  //} 

}



function obtener_pdf() {
  // esta funcion crea un pdf para preescolar
  // se almacena el año en la variable year
  var year = $("#years").val();
  // se almacena el periodo
  var periodos = $("#periodos").val();
  // y se almacenan las variables grados
  var gradosx = $("#id_g").val();
  var grados = $("#id_g").val();

  // se almacenan todas las variables dentro de la variable parametros
  var parametros = "year=" + year + "&periodos=" + periodos + "&grados=" + gradosx + "&id_gs=" + gradosx + "";
  console.log("los parametros son : %s", parametros);
  window.open("generarx.php?" + parametros);
}

// agrega las jornadas disponibles
function lista_jornadas(id) {

  $.ajax({
    type: "POST",
    async: false,
    url: "lista_jornadas.php",
    data: {
      id: id
    },

    success: function (respuesta) {

      res = JSON.parse(respuesta);

      res.forEach((element) => {
	console.log(element)
	valor = element[0];
	texto = element[1];
	$(id).append("<option value = " + valor + ">" + texto + "</option>");
      });

    },
    error: function (xhr, status) {
      swal('Disculpe, existió un problema' + status);
      console.log(xhr);
    }

  });

}


// agrega las escolaridades disponibles disponibles
// al campo select id
function lista_escolaridad(id) {

  // solicito la lista de escolaridad

  $.ajax({
    type: "POST",
    async: false,
    url: "lista_escolaridad.php",
    data: {
      id: id
    },

    success: function (respuesta) {

      // si se realizo la respuesta
      // almaceno la respuesta en la variable res
      res = JSON.parse(respuesta);

      //  agrego la primera opcion al combo
      $(id).append("<option value = -1>seleccione</option>");

      res.forEach((element) => {
	console.log(element)
	valor = element[0];
	texto = element[1];
	$(id).append("<option value = " + valor + ">" + texto + "</option>");
      });

    },
    error: function (xhr, status) {
      swal('Disculpe, existió un problema' + status);
      console.log(xhr);
    }

  });

}

// Esta funcion verifica si la persona con codigo
// id_persona tiene un codigo de estudiante, si no
// le asigna un codigo
function verificar_alumno(id_personax) {

  $.ajax({
    type: "POST",
    async: false,
    url: "verificar_alumno.php",
    data: {
      id_persona : id_personax
    },
    // si ña respuesta es afirmativa
    success: function (respuesta) {
      // asigno al atributo id_alumno el codigo
      //obtenido
      alumno["id_alumno"] = respuesta;
    },
    // si ocurre un error
    error: function (xhr, status) {
      swal('Disculpe, existió un problema al obtener el codigo del alumno' + status);
      console.log(xhr);
    }
  });
}

// funcion que lista los grados en funcion de un id_escolaridad
// que identifica la escolaridad de los estudiantes y 
function lista_grados(id_escolaridad, id, id_docente) {

  // solicito la lista de escolaridad

  $.ajax({
    type: "POST",
    async: false,
    url: "lista_grados.php",
    data: {
      id_docente: id_docente,
      id_escolaridad: id_escolaridad
    },

    success: function (respuesta) {


      res = JSON.parse(respuesta);

      // si se realizo la respuesta
      // almaceno la respuesta en la variable res
      $(id).find('option').remove();

      $(id).append("<option value = '-1'>Seleccione</option>");
      
      res.forEach((element) => {
	//console.log(element)
	valor = element[0];
	texto = element[1];
	$(id).append("<option value = " + valor + ">" + texto + "</option>");
      });

       $(id).css('background-color', 'lightblue');

    },
    error: function (xhr, status) {
      swal('Disculpe, existió un problema' + status);
      console.log(xhr);
    }
  });
}


// funcion que consulta las matriculas realizadas
// en un determinado grado

function consultar_matriculas(){
    
    // envio los dato por ajax
    // mediante el metodo post
    // en el archivo consulta_matriculas.php

    $.ajax({
    type: "POST",
    async: false,
    url: "consultar_matriculas.php",
    data: {
	id_jornada : $("#jornada").val(),
	id_curso : $("#id_c").val(),
	id_grado : $("#id_g").val(),
	year : $("#years").val()
    },

    success: function (respuesta) {
	$("#avance").html("");
	$("#avance").html(respuesta);
      }
      //res = JSON.parse(respuesta);
    ,
    error: function (xhr, status) {
      swal('Disculpe, existió un problema' + status);
      console.log(xhr);
    }} );
}

// funcion que consulta una matricula realizada

function consultar_matricula(id_matricula){
  // variable que almacena
  // el resultado
  let res = 0;
  
    // envio los dato por ajax
    // mediante el metodo post
    // en el archivo consulta_matricula.php

    $.ajax({
    type: "POST",
    async: false,
    url: "consultar_matricula.php",
    data: {
	id_matricula : id_matricula
    },

    success: function (respuesta) {
      // salida por consola
      // console.log(respuesta);
      // paso los atributos a la variable matricula
      // a un objeto json y lo retorno
     res = JSON.parse(respuesta);
     
      }
    ,
    error: function (xhr, status) {
      swal('Disculpe, existió un problema' + status);
      console.log(xhr);
    }} );
  // restorna la respuesta
   return res;
}
