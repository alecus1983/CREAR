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
      //asigno al alumno los datos guardados en persona x
      alumno = personax;
     //  borro el avance
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
      
      // Se reemplaza el botón original por uno que primero valida
      $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(5)">atras</button>');
      $("#paginas").append('<button id="btn-siguiente-6" class="btn btn btn-dark">Siguiente</button>');

      $("#btn-siguiente-6").on('click', function() {
          const camposAValidar = [
              {id: 'ac_jornada', name: 'Jornada', type: 'select'},
              {id: 'ac_escolaridad', name: 'Escolaridad', type: 'select'},
              {id: 'ac_grado', name: 'Grado', type: 'select'},
              {id: 'ac_curso', name: 'Curso', type: 'select'}
          ];

          if (validarFormulario(camposAValidar)) {
              // Si la validación es exitosa, se actualizan los datos y se procede al siguiente paso
              update_grado_matricula(); // Asumo que esta función actualiza el objeto 'alumno'
              gestion_matriculas(7); // Ir al siguiente paso
          }
      });
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


// funcion para editar matricula
// id es el  codigo del alumno
// item es el item del formulario al que ingreso
function editar_matricula(id, item){

    // inicia el formulario
    
  // estructura de seleccion
  switch (item) {

    // 1. INFORMACION DEL ESTUDIANTE

  case 31: // cargo el primer formulario de matricula
    $("#avance").html("");
    $("#tabla").html("");
      $("#avance").load("formulario_editar_matricula_1.html");


      // consulto la matricula
      r = consultar_matricula(id);
      // seleciono la persona
      get_persona(r["id_alumno"], alumno);
      // obtengo la direccion de la persona
      get_direccion(alumno);


      // se carga  el formulario
      $("#form_edit").load("formulario_actualizar_direccion.html", function () {
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
	$("#form_edit").prepend("<p>Se ha selecionado la persona <b>"
			      + alumno["nombres"] + " "
			      + alumno["apellidos"] + "</b>, con codigo "
			      + alumno["id_persona"] + ", con identificacion "
			      + alumno["identificacion"] + "</p>");
	// agrego los botones 
	$("#form_edit").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(1)">atras</button>');
	$("#form_edit").append('<button id="agregar_persona" class="btn btn btn-dark" onclick="update_direccion(2,alumno);">agregar/actualizar</button>');
      });
      break;
  }
    
    
}
