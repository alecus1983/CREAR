// funcion que consulta una matricula realizada

function consultar_matricula(id_matricula) {
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
      id_matricula: id_matricula
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
    }
  });
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
          $("#paginas").append('<div style="padding-top: 10px;" class="d-flex justify-content-end mb-3 gap-2" ><button type="button" class="btn btn-black" onclick="gestion_matriculas(1)">atras</button><button type="button" class="btn btn-dark" onclick="agregar_persona(4,alumno,1)">agregar</button></div>');
        });

      });
      break;

    case 3: // para personas antiguas coloco este formulario
      $("#avance").html("");
      $("#tabla").html("");
      // Cargar formulario_matricula_3.html
      $("#avance").load("formulario_matricula_3.html", function () {
        $("#paginas").append('<div style="padding-top: 10px;" class="d-flex justify-content-end mb-3 gap-2" ><button type="button" class="btn btn-black" onclick="gestion_matriculas(1)">atras</button></div>');
        //$("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(1)">atras</button>');
      });
      break;

    // SELECCIONAR ALUMNO	
    case 4:
      // Verificamos de forma segura que la data exista antes de cargar visualmente la página
      if (!alumno || !alumno["id_persona"]) {
        swal('Atención', 'No se ha cargado ningún alumno. Por favor selecciona uno.', 'warning');
        return; // Detenemos la carga si no hay alumno seleccionado.
      }

      // Verificamos de forma segura que la data exista antes de cargar visualmente la página
      if (!alumno["identificacion"]) {
        swal('Atención', 'El alumno no tiene identificación, por favor actualice el documento de identidad.', 'warning');

        return; // Detenemos la carga si no hay alumno seleccionado.
      }

      //  borro el avance
      $("#avance").html("");
      $("#tabla").html("");

      // Aseguramos que se mantenga el loader encendido mientras carga el HTML para evitar destellos
      $("#loader-overlay").show();
      $("#avance").load("formulario_matricula_4.html", function (response, status) {
        $("#loader-overlay").hide();
        if (status === "error") {
          swal('Error', 'Hubo un problema cargando el módulo', 'error');
          return;
        }

        $("#paginas").html("<p>Se ha selecionado la persona <b>"
          + alumno["nombres"] + " " + alumno["apellidos"]
          + "</b>, con codigo " + alumno["id_persona"]
          + ", con identificacion " + alumno["identificacion"] + "</p>");
        $("#paginas").append('<div style="padding-top: 10px;" class="d-flex justify-content-end mb-3 gap-2" ><button type="button" class="btn btn-black" onclick="gestion_matriculas(1)">atras</button><button type="button" class="btn btn-dark" onclick="gestion_matriculas(5);">siguiente</button></div>');
      });
      break;

    // recoleccion de la direccion del alumno
    case 5:
      $("#avance").html("");
      $("#tabla").html("");
      $("#avance").load("formulario_matricula_5.html", function () {

        // obtengo la direccion de la persona
        get_direccion(alumno, 2);

        // cargo el formulario y populo los campos de forma SINCRONA
        $("#paginas").load("formulario_actualizar_direccion.html", function () {

          // Una sola llamada síncrona: asigna dirección, barrio y estrato
          // sin ningún setTimeout que pueda llegar tarde.
          if (typeof poblarFormularioDireccion === 'function') {
            poblarFormularioDireccion(
              alumno["direccion_residencia"],
              alumno["barrio"],
              alumno["estrato"]
            );
          } else {
            // Fallback seguro si el script del formulario aún no cargó
            $("#ac_direccion").val(alumno["direccion_residencia"] || "");
            $("#ac_barrio").val(alumno["barrio"] || "");
            $("#ac_estrato").val(String(alumno["estrato"] || "3"));
          }

          // encabezado del estudiante
          $("#paginas").prepend("<p>Se ha seleccionado la persona <b>"
            + alumno["nombres"] + " "
            + alumno["apellidos"] + "</b>, código: "
            + alumno["id_persona"] + " — identificación: "
            + alumno["identificacion"] + "</p>");

          $("#paginas").append('<div style="padding-top: 10px;" class="d-flex justify-content-end mb-3 gap-2" ><button type="button" class="btn btn-black" onclick="gestion_matriculas(1)">atras</button><button type="button" class="btn btn-dark" onclick="update_direccion(2,alumno,1);">siguiente</button></div>');
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

        // agrego botones  atras y siguiente
        $("#paginas").append('<div style="padding-top: 10px;" class="d-flex justify-content-end mb-3 gap-2" ><button type="button" class="btn btn-black" onclick="gestion_matriculas(5)">atras</button><button type="button" class="btn btn-dark" id="btn-siguiente-6">siguiente</button></div>');

        $("#btn-siguiente-6").on('click', function () {
          const camposAValidar = [
            { id: 'ac_jornada', name: 'Jornada', type: 'select' },
            { id: 'ac_escolaridad', name: 'Escolaridad', type: 'select' },
            { id: 'ac_grado', name: 'Grado', type: 'select' },
            { id: 'ac_curso', name: 'Curso', type: 'select' }
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
          $("#paginas").prepend("<p>Datos de afiliacion del alumno <b>" + alumno["nombres"]
            + " " + alumno["apellidos"] + "</b>, con codigo " + alumno["id_persona"]
            + ", con identificacion " + alumno["identificacion"] + "</p>");
          // obtengo los datos de afiliacion en 
          // este formuulario 	
          get_afiliacion(alumno["id_persona"], 2);

          $("#paginas").append('<div style="padding-top: 10px;" class="d-flex justify-content-end mb-3 gap-2" ><button type="button" class="btn btn-black" onclick="gestion_matriculas(6)">atras</button><button type="button" class="btn btn-dark" id="btn-siguiente-7">siguiente</button></div>');

          $("#btn-siguiente-7").on('click', function () {
            const camposAValidar = [
              { id: 'ac_eps', name: 'EPS', type: 'select' },
              { id: 'ac_ips', name: 'IPS', type: 'select' },
              { id: 'ac_tipo_sangre', name: 'Tipo de sangre', type: 'select' },
              { id: 'ac_sisben', name: 'Sisben', type: 'select' }
            ];

            if (validarFormulario(camposAValidar)) {
              // Si la validación es exitosa, se actualizan los datos y se procede al siguiente paso
              update_afiliaciones(1); // Asumo que esta función actualiza el objeto 'alumno'
              gestion_matriculas(8); // Ir al siguiente paso
            }
          });
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
          // boton de agregar antecedentes
          $("#paginas").append('<div style="padding-top: 10px;" class="d-flex justify-content-end mb-3 gap-2" ><button type="button" class="btn btn-black" onclick="gestion_matriculas(7)">atras</button><button type="button" class="btn btn-dark" id="btn-siguiente-8" onclick="actualizar_antecedentes_patologicos(alumno,1);">siguiente</button></div>');

          // cargo los valores en un nuevo formulario
          get_antecedentes(alumno["id_persona"], 2);


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
      // borro el contenido del div
      $("#avance").html("");
      // borro el contenido de la tala
      $("#tabla").html("");
      // cargo el formulario 10
      $("#avance").load("formulario_matricula_10.html", function () {
        //agrega el formulario de personas
        $("#paginas").load("formulario_agregar_persona.html",
          function () {
            $("#paginas").append(
              '<div style="padding-top: 10px;" class="d-flex justify-content-end mb-3 gap-2" ><button type="button" class="btn btn-black" onclick="gestion_matriculas(9)">atras</button><button type="button" class="btn btn-dark" onclick="agregar_persona(12,padre,1)">agregar</button></div>');


            //          $("#paginas").prepend('<div class="d-flex justify-content-end mb-3 gap-2"><button type="button" class="btn btn-secondary" onclick="gestion_matriculas(9)">atras</button><button type="button" class="btn btn-secondary" onclick="agregar_persona(12,padre,1)">agregar</button></div>');
          });

      });
      break;

    // PADRE REGISTRADO

    case 11:
      $("#avance").html("");
      $("#tabla").html("");
      // Cargar formulario_matricula_11.html
      $("#avance").load("formulario_matricula_11.html", function () {

        // $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(9)">atras</button>');
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

        $("#paginas").append('<div style="padding-top: 10px;" class="d-flex justify-content-end mb-3 gap-2" ><button type="button" class="btn btn-black" onclick="gestion_matriculas(8)">atras</button><button type="button" class="btn btn-dark" onclick="gestion_matriculas(13);">agregar</button></div>');
        //$("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(13);">atras</button>');
        //$("#paginas").append('<button type="button" class="btn btn-dark" onclick="gestion_matriculas(13);">siguiente</button>');

      });
      break;

    // DATOS DE LA MADRE
    case 13:
      $("#avance").html("");
      $("#tabla").html("");

      // Verificar si ya existe el vínculo padre-hijo en la tabla padres.
      // Si no existe, lo inserta antes de avanzar al formulario de la madre.
      $.ajax({
        type: "POST",
        url: "vincular_padre_hijo.php",
        dataType: "json",
        data: {
          id_padre: padre["id_persona"],
          id_hijo: alumno["id_persona"]
        },
        success: function (respuesta) {
          if (respuesta["status"] == 1) {
            // Vínculo creado exitosamente → avanzar al formulario de la madre
            console.log("Vínculo padre-hijo creado (id_padres: " + respuesta["id_padres"] + ")");
            $("#avance").load("formulario_matricula_13.html");
          } else if (respuesta["status"] == 2) {
            // El vínculo ya existía → avanzar normalmente
            console.log("Vínculo padre-hijo ya existía.");
            $("#avance").load("formulario_matricula_13.html");
          } else {
            // Error al crear el vínculo
            swal("Error", "No se pudo registrar el vínculo padre-hijo: " + (respuesta["mensaje"] || ""), "error");
          }
        },
        error: function (xhr) {
          console.error("Error AJAX vincular_padre_hijo:", xhr);
          swal("Error", "Ocurrió un problema al registrar el vínculo padre-hijo.", "error");
        }
      });
      break;


    // MADRE NUEVA

    case 14:
      $("#avance").html("");
      $("#tabla").html("");

      $("#avance").load("formulario_matricula_14.html", function () {
        //	agrega el formulario de personas
        $("#paginas").load("formulario_agregar_persona.html", function () {

          $("#paginas").append('<div style="padding-top: 10px;" class="d-flex justify-content-end mb-3 gap-2" ><button type="button" class="btn btn-black" onclick="gestion_matriculas(13)">atras</button><button type="button" class="btn btn-dark" onclick="agregar_persona(16,madre,1)">agregar</button></div>');

          //$("#paginas").prepend('<div class="d-flex justify-content-end mb-3 gap-2"><button type="button" class="btn btn-secondary" onclick="gestion_matriculas(13)">atras</button><button type="button" class="btn btn-secondary" onclick="agregar_persona(16,madre,1)">agregar</button></div>');
        });

      });
      break;

    // MADRE REGISTRADA
    case 15:
      $("#avance").html("");
      $("#tabla").html("");
      // Cargar formulario_matricula_15.html
      $("#avance").load("formulario_matricula_15.html", function () {

        //$("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(13)">atras</button>');
      });
      break;

    // MADRE SELECCIONADA
    case 16:
      $("#avance").html("");
      $("#tabla").html("");
      //  cargo el formulario 16 de matricula en el campo avance
      $("#avance").load("formulario_matricula_16.html", function () {
        // cargo el contenido dentro la seccion paginas dentro del formulario
        $("#paginas").html("<p>Se ha selecionado la madre <b>"
          + madre["nombres"] + " " + madre["apellidos"]
          + "</b>, con codigo " + madre["id_persona"]
          + ", con identificacion " + madre["identificacion"] + "</p>");

        $("#paginas").append('<div style="padding-top: 10px;" class="d-flex justify-content-end mb-3 gap-2" ><button type="button" class="btn btn-black" onclick="gestion_matriculas(13)">atras</button><button type="button" class="btn btn-dark" onclick="gestion_matriculas(17);">agregar</button></div>');

        //$("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(13)">atras</button>');
        //$("#paginas").append('<button type="button" class="btn btn-dark" onclick="gestion_matriculas(17);">siguiente</button>');

      });
      break;

    // DATOS DEL ACUDIENTE
    case 17:
      $("#avance").html("");
      $("#tabla").html("");

      // Verificar/insertar vínculo madre-hijo en tabla madres.
      $.ajax({
        type: "POST",
        url: "vincular_madre_hijo.php",
        dataType: "json",
        data: {
          id_madre: madre["id_persona"],
          id_hijo: alumno["id_persona"]
        },
        success: function (respMadre) {
          if (respMadre["status"] == 1) {
            console.log("Vínculo madre-hijo creado (id_madres: " + respMadre["id_madres"] + ")");
          } else if (respMadre["status"] == 2) {
            console.log("Vínculo madre-hijo ya existía.");
          } else {
            swal("Error", "No se pudo registrar el vínculo madre-hijo: " + (respMadre["mensaje"] || ""), "error");
            return;
          }
          // Avanzar al formulario del acudiente
          $("#avance").load("formulario_matricula_17.html");
        },
        error: function (xhr) {
          console.error("Error AJAX vincular_madre_hijo:", xhr);
          swal("Error", "Ocurrió un problema al registrar el vínculo madre-hijo.", "error");
        }
      });
      break;

    // AGREGAR ACUDIENTE
    case 18:
      $("#avance").html("");
      $("#tabla").html("");
      $("#avance").load("formulario_matricula_18.html", function () {
        //	agrega el formulario de personas
        $("#paginas").load("formulario_agregar_persona.html", function () {

          $("#paginas").append('<div style="padding-top: 10px;" class="d-flex justify-content-end mb-3 gap-2" ><button type="button" class="btn btn-black" onclick="gestion_matriculas(17)">atras</button><button type="button" class="btn btn-dark" onclick="agregar_persona(19,acudiente,1)">agregar</button></div>');

        });

      });
      break;

    // ACUDIENTE SELECCIONADO
    case 19:
      $("#avance").html("");
      $("#tabla").html("");

      // PASO 2: Vincular madre como acudiente (si no existe ya)
      $.ajax({
        type: "POST",
        url: "vincular_acudiente_hijo.php",
        dataType: "json",
        data: {
          id_acudiente: acudinte["id_persona"],
          id_hijo: alumno["id_persona"]
        },
        success: function (respAcud) {
          if (respAcud["status"] == 1) {
            console.log("Vínculo acudiente-hijo creado (id_acudientes: " + respAcud["id_acudientes"] + ")");
          } else if (respAcud["status"] == 2) {
            console.log("Vínculo acudiente-hijo ya existía.");
          } else {
            console.warn("No se pudo registrar la madre como acudiente: " + (respAcud["mensaje"] || ""));
          }
          // Avanzar siempre al formulario del acudiente
          $("#avance").load("formulario_matricula_20.html");
        },
        error: function (xhr) {
          console.error("Error AJAX vincular_acudiente_hijo (case 17):", xhr);
          // Avanzar de todas formas
          $("#avance").load("formulario_matricula_20.html");
        }
      });

      // Cargar formulario_matricula_19.html
      $("#avance").load("formulario_matricula_19.html", function () {

        // cargo el contenido dentro la seccion paginas dentro del formulario
        $("#paginas").html("<p>Se ha selecionado la persona <b>"
          + acudiente["nombres"] + " " + acudiente["apellidos"]
          + "</b>, con codigo " + acudiente["id_persona"]
          + ", con identificacion " + acudiente["identificacion"] + "</p>");

        $("#paginas").append('<div style="padding-top: 10px;" class="d-flex justify-content-end mb-3 gap-2" ><button type="button" class="btn btn-black" onclick="gestion_matriculas(17)">atras</button><button type="button" class="btn btn-dark" onclick="gestion_matriculas(20);">agregar</button></div>');

      });
      break;

    // RESUMEN DE LA MATRICULA
    case 20:
      $("#avance").html("");
      $("#tabla").html("");

      // Verificar/insertar el vínculo acudiente-hijo en tabla acudientes
      $.ajax({
        type: "POST",
        url: "vincular_acudiente_hijo.php",
        dataType: "json",
        data: {
          id_acudiente: acudiente["id_persona"],
          id_hijo: alumno["id_persona"]
        },
        success: function (respAcud) {
          if (respAcud["status"] == 1) {
            console.log("Vínculo acudiente-hijo creado (id_acudientes: " + respAcud["id_acudientes"] + ")");
          } else if (respAcud["status"] == 2) {
            console.log("Vínculo acudiente-hijo ya existía.");
          } else {
            console.warn("No se pudo registrar el acudiente-hijo: " + (respAcud["mensaje"] || ""));
          }
          cargar_resumen_matricula();
        },
        error: function (xhr) {
          console.error("Error AJAX vincular_acudiente_hijo (case 20):", xhr);
          cargar_resumen_matricula();
        }
      });

      function cargar_resumen_matricula() {
        $("#avance").load("formulario_matricula_20.html", function () {

          $("#paginas").html("<p>Los datos de la matricula son :</p>");
          $("#paginas").append("<p> <i><h3>Datos del alumno</h3></i></p>");
          $("#paginas").append("<p> nombre : <b>" + alumno["nombres"] + " " + alumno["apellidos"] + "</b></p>");
          $("#paginas").append("<p> tipo de identificacion  : <b>" + alumno["tipo_identificacion"] + "</b></p>");
          $("#paginas").append("<p> identificacion : <b>" + alumno["identificacion"] + "</b></p>");
          $("#paginas").append("<p> grado : <b>" + alumno["id_grado"] + "</b></p>");
          $("#paginas").append("<p> jornada : <b>" + alumno["id_jornada"] + "</b></p>");
          $("#paginas").append("<p> curso : <b>" + alumno["id_curso"] + "</b></p>");
          $("#paginas").append("<p> escolaridad : <b>" + alumno["id_escolaridad"] + "</b></p>");
          $("#paginas").append("<p> año : <b>" + alumno["year"] + "</b></p>");
          $("#paginas").append("<p> fecha : <b>" + alumno["fecha"] + "</b></p>");
          $("#paginas").append("<p> nacimiento : <b>" + alumno["nacimiento"] + "</b></p>");
          $("#paginas").append("<p> correo : <b>" + alumno["correo"] + "</b></p>");
          $("#paginas").append("<p> correo institucional : <b>" + alumno["i_correo"] + "</b></p>");
          $("#paginas").append("<p> celular : <b>" + alumno["celular"] + "</b></p>");
          $("#paginas").append("<p> telefono : <b>" + alumno["telefono"] + "</b></p>");
          $("#paginas").append("<p> dirección : <b>" + alumno["direccion_residencia"] + "</b></p>");
          $("#paginas").append("<p> barrio : <b>" + alumno["barrio"] + "</b></p>");
          $("#paginas").append("<p> estrato : <b>" + alumno["estrato"] + "</b></p>");
          $("#paginas").append("<p> sisben : <b>" + alumno["sisben"] + "</b></p>");
          $("#paginas").append("<p> eps : <b>" + alumno["eps"] + "</b></p>");
          $("#paginas").append("<p> vive_con : <b>" + alumno["vive_con"] + "</b></p>");

          $("#paginas").append("<p> <i><h3>Datos del padre :</h3></i></p>");
          $("#paginas").append("<p> nombre : <b>" + padre["nombres"] + " " + padre["apellidos"] + "</b></p>");
          $("#paginas").append("<p> identificacion : <b>" + padre["identificacion"] + "</b></p>");
          $("#paginas").append("<p> nacimiento : <b>" + padre["nacimiento"] + "</b></p>");
          $("#paginas").append("<p> correo : <b>" + padre["correo"] + "</b></p>");
          $("#paginas").append("<p> celular : <b>" + padre["celular"] + "</b></p>");

          $("#paginas").append("<p> <i><h3>Datos de la madre</h3></i></p>");
          $("#paginas").append("<p> nombre : <b>" + madre["nombres"] + " " + madre["apellidos"] + "</b></p>");
          $("#paginas").append("<p> identificacion : <b>" + madre["identificacion"] + "</b></p>");
          $("#paginas").append("<p> nacimiento : <b>" + madre["nacimiento"] + "</b></p>");
          $("#paginas").append("<p> correo : <b>" + madre["correo"] + "</b></p>");
          $("#paginas").append("<p> celular : <b>" + madre["celular"] + "</b></p>");

          $("#paginas").append("<p> <i><h3>Datos del acudiente</h3></i></p>");
          $("#paginas").append("<p> nombre : <b>" + acudiente["nombres"] + " " + acudiente["apellidos"] + "</b></p>");
          $("#paginas").append("<p> identificacion : <b>" + acudiente["identificacion"] + "</b></p>");

          $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(17)">atras</button>');
          $("#paginas").append('<button type="button" class="btn btn-outline-success" onclick="gestion_matriculas(21);">finalizar</button>');

        }); // fin del load formulario_matricula_20.html
      }     // fin de cargar_resumen_matricula()
      break;

    // DATOS FINALES
    case 21:
      $("#avance").html("");
      $("#tabla").html("");
      $("#avance").load("formulario_matricula_21.html");

      swal({
        title: '¿Estás seguro?',
        text: "¿Está seguro que desea generar la matrícula para el estudiante " + alumno["nombres"] + " " + alumno["apellidos"] + "?",
        icon: 'warning',
        buttons: ["cancelar", "generar"],
      }).then((result) => {
        if (result) {

          // si el alumno no tiene un id_alumno entonces 
          // establece el codigo de alumno
          verificar_alumno(alumno["id_persona"]);

          matricular(function (id_matricula) {
            alumno['ultima_matricula_id'] = id_matricula;
            imprimir_matricula(id_matricula);
          });

          $("#paginas").html("<p>Se ha completado la matrícula del alumno ");
          $("#paginas").append("<b>" + alumno["nombres"] + " " + alumno["apellidos"] + "</b></p>");

          $("#paginas").append(
            '<div style="padding-top: 10px;" class="d-flex justify-content-end mb-3 gap-2">' +
            '<button type="button" class="btn btn-dark" onclick="gestion_matriculas(1)">Nueva Matrícula</button>' +
            '<button type="button" class="btn btn-outline-success" ' +
            'onclick="imprimir_matricula(alumno[\'ultima_matricula_id\'])">' +
            'Ver PDF Matrícula' +
            '</button>' +
            '</div>'
          );

        } else {
          swal('Cancelado', 'No se ha realizado ningún cambio.', 'error');
          gestion_matriculas(19);
        }
      });
      break;

  } // fin del switch






  function cargar_resumen_matricula() {
    //  cargo el formulario 20 de matricula en el campo avance
    $("#avance").load("formulario_matricula_20.html", function () {

      // cargo el contenido dentro la seccion paginas dentro del formulario
      $("#paginas").html("<p>Los datos de la matricula son :</p>");
      // muestro los datos del alumnos
      $("#paginas").append("<p> <i><h3>Datos del alumno</h3></i></p>");
      $("#paginas").append("<p> nombre : <b>" + alumno["nombres"] + " " + alumno["apellidos"] + "</b></p>");
      $("#paginas").append("<p> tipo de identificacion  : <b>" + alumno["tipo_identificacion"] + "</b></p>");


      $("#paginas").append("<table>");
      $("#paginas").append("<thead>");
      $("#paginas").append("<tr>");
      $("#paginas").append("<th>");
      $("#paginas").append("Campo");
      $("#paginas").append("</th>");
      $("#paginas").append("<th>");
      $("#paginas").append("Valor");
      $("#paginas").append("</th>");
      $("#paginas").append("</tr>");
      $("#paginas").append("</thead>");

      $("#paginas").append("<tbody>");
      $("#paginas").append("<tr><td>");
      $("#paginas").append("identificacion ");
      $("#paginas").append(alumno["identificacion"]);
      $("#paginas").append("</td></tr>");

      $("#paginas").append("<p> grado : <b>" + alumno["id_grado"] + "</b></p>");
      $("#paginas").append("<p> jornada : <b>" + alumno["id_jornada"] + "</b></p>");
      $("#paginas").append("<p> curso : <b>" + alumno["id_curso"] + "</b></p>");
      $("#paginas").append("<p> escolaridad : <b>" + alumno["id_escolaridad"] + "</b></p>");
      $("#paginas").append("<p> año : <b>" + alumno["year"] + "</b></p>");
      $("#paginas").append("<p> fecha : <b>" + alumno["fecha"] + "</b></p>");
      $("#paginas").append("<p> nacimiento : <b>" + alumno["nacimiento"] + "</b></p>");
      $("#paginas").append("<p> correo : <b>" + alumno["correo"] + "</b></p>");
      $("#paginas").append("<p> correo institucional : <b>" + alumno["i_correo"] + "</b></p>");
      $("#paginas").append("<p> celular : <b>" + alumno["celular"] + "</b></p>");
      $("#paginas").append("<p> telefono : <b>" + alumno["telefono"] + "</b></p>");
      $("#paginas").append("<p> dirección : <b>" + alumno["direccion_residencia"] + "</b></p>");
      $("#paginas").append("<p> barrio : <b>" + alumno["barrio"] + "</b></p>");
      $("#paginas").append("<p> curso : <b>" + alumno["id_curso"] + "</b></p>");
      $("#paginas").append("<p> estrato : <b>" + alumno["estrato"] + "</b></p>");
      $("#paginas").append("<p> sisben : <b>" + alumno["sisben"] + "</b></p>");
      $("#paginas").append("<p> eps : <b>" + alumno["eps"] + "</b></p>");
      $("#paginas").append("<p> vivie_con : <b>" + alumno["vivie_con"] + "</b></p>");

      // muestro los datos del padre
      $("#paginas").append("<p> <i><h3>Datos del padre :</h3></i></p>");
      $("#paginas").append("<p> nombre : <b>" + padre["nombres"] + " " + padre["apellidos"] + "</b></p>");
      $("#paginas").append("<p> tipo de identificacion  : <b>" + padre["tipo_identificacion"] + "</b></p>");
      $("#paginas").append("<p> identificacion : <b>" + padre["identificacion"] + "</b></p>");
      $("#paginas").append("<p> nacimiento : <b>" + padre["nacimiento"] + "</b></p>");
      $("#paginas").append("<p> correo : <b>" + padre["correo"] + "</b></p>");
      $("#paginas").append("<p> correo institucional : <b>" + padre["i_correo"] + "</b></p>");
      $("#paginas").append("<p> celular : <b>" + padre["celular"] + "</b></p>");
      $("#paginas").append("<p> telefono : <b>" + padre["telefono"] + "</b></p>");

      // muestro los datos de la madre
      $("#paginas").append("<p> <i><h3>Datos de la madre</h3></i></p>");
      $("#paginas").append("<p> nombre : <b>" + madre["nombres"] + " " + madre["apellidos"] + "</b></p>");
      $("#paginas").append("<p> tipo de identificacion  : <b>" + madre["tipo_identificacion"] + "</b></p>");
      $("#paginas").append("<p> identificacion : <b>" + madre["identificacion"] + "</b></p>");
      $("#paginas").append("<p> nacimiento : <b>" + madre["nacimiento"] + "</b></p>");
      $("#paginas").append("<p> correo : <b>" + madre["correo"] + "</b></p>");
      $("#paginas").append("<p> correo institucional : <b>" + madre["i_correo"] + "</b></p>");
      $("#paginas").append("<p> celular : <b>" + madre["celular"] + "</b></p>");
      $("#paginas").append("<p> telefono : <b>" + madre["telefono"] + "</b></p>");
      $("#paginas").append("</td>");
      $("#paginas").append("</tr>");
      $("#paginas").append("</tbody>");
      $("#paginas").append("</table>");
      // muestro los botones de aceptar
      $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="gestion_matriculas(17)">atras</button>');
      $("#paginas").append('<button type="button" class="btn btn-outline-success" onclick="gestion_matriculas(21);">finalizar</button>');

    }); // fin del load formulario_matricula_20.html
  }   // fin de cargar_resumen_matricula()
  // break;


  // DATOS FINALES

  //   case 21:
  // $("#avance").html("");
  // $("#tabla").html("");
  // $("#avance").load("formulario_matricula_21.html");

  // // Muestra la alerta de confirmación usando SweetAlert2

  // swal({
  //   title: '¿Estás seguro?',
  //   text: "¿Está seguro que desea generar la matrícula para el estudiante " + alumno["nombres"] + " " + alumno["apellidos"] + "?",
  //   icon: 'warning',
  //   buttons: ["cancelar", "generar"],
  // }).then((result) => {
  //   if (result) { // Si el usuario hace clic en "generar"

  //     // Revisar si el alumno tiene código y asignarle uno si no lo tiene
  //     verificar_alumno(alumno["id_persona"]);


  //     // Realizar la matrícula del alumno y, al completarse,
  //     // guardar el id y fecha en el objeto alumno, luego abrir el PDF.
  //     matricular(function (id_matricula, fecha) {
  //       // Guardar en el objeto global para que el botón 'Ver PDF' pueda accederlos
  //       alumno['ultima_matricula_id'] = id_matricula;
  //       alumno['ultima_matricula_fecha'] = fecha;
  //       // Abrir el PDF automáticamente
  //       imprimir_matricula(id_matricula, fecha);
  //     });



  //     $("#paginas").html("<p>Se ha completado la matrícula del alumno ");
  //     $("#paginas").append("<b>" + alumno["nombres"] + " " + alumno["apellidos"] + "</b></p>");

  //     // Botones de acción post-matrícula
  //     $("#paginas").append(
  //       '<div style="padding-top: 10px;" class="d-flex justify-content-end mb-3 gap-2">' +
  //       '<button type="button" class="btn btn-dark" onclick="gestion_matriculas(1)">Nueva Matrícula</button>' +
  //       '<button type="button" class="btn btn-outline-success" ' +
  //       'onclick="imprimir_matricula(alumno[\'ultima_matricula_id\'], alumno[\'ultima_matricula_fecha\'])">' +
  //       'Ver PDF Matrícula' +
  //       '</button>' +
  //       '</div>'
  //     );

  //     // Cargar el siguiente formulario
  //     ///$("#avance").load("formulario_matricula_20.html");

  //   } else { // Si el usuario hace clic en "cancelar"
  //     swal(
  //       'Cancelado',
  //       'No se ha realizado ningún cambio.',
  //       'error'
  //     );

  //     // Llamar a la función que maneja la gestión de matrículas
  //     gestion_matriculas(19);
  //   }
  // });




  // break;


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





// funcion para editar matricula
// id es el  codigo del alumno
// item es el item del formulario al que ingreso
function flujo_editar_matricula(id_matricula, item) {

  // consulto la matricula
  r = consultar_matricula(id_matricula);
  // seleciono la persona
  get_persona_alumno(r["id_alumno"], alumno);
  // obtengo la direccion de la persona
  get_direccion(alumno);
  // asigno el codigo al alumno
  alumno["id_alumno"] = r["id_alumno"];
  // asigno el codigo de la matricula
  alumno["id_matricula"] = r["id"];

  // inicia el formulario

  // estructura de seleccion
  // de acuerdo al item se carga un formulario

  switch (item) {

    // 1. ACTUALIZAR DIRECCION

    case 31:

      // borro el contenido de los divs
      $("#avance").html("");
      $("#tabla").html("");
      // cargo el formulario inicial de edicion de la matricula
      $("#avance").load("formulario_editar_matricula_1.html", function () {


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


          // agrego los botones 
          $("#paginas").append('<button id="editar_direccion" class="btn btn btn-dark" >agregar/actualizar</button>');
          $("#editar_direccion").on("click", function () {
            // 1. Definir los campos a validar
            const camposAValidar = [
              { id: 'ac_direccion', name: 'Dirección', type: 'text' },
              { id: 'ac_barrio', name: 'Barrio', type: 'text' },
              { id: 'ac_estrato', name: 'Estrato', type: 'select' }

            ];

            // 2. Ejecutar la validación
            if (validarFormulario(camposAValidar)) {
              // Si la validación es exitosa, se actualizan los datos y se procede al siguiente paso
              update_direccion(2, alumno, 2); // actualiza la direccion dentro de las matriculas
              flujo_editar_matricula(alumno['id_matricula'], 32); // Ir al siguiente paso
            }
          });
          // agrego el encabezado del estudiante
          $("#paginas").prepend("<p>Se esta editando la matrícula <b>" + id_matricula +
            "</b> de la persona <b>" +
            alumno["nombres"] + " " +
            alumno["apellidos"] + "</b>, con codigo de alumno " +
            alumno["id_alumno"] + ", con identificacion " +
            alumno["identificacion"] + "</p>");

        });


      });
      break;

    // DATOS ACADEMICOS

    case 32:
      // borro el contenido del div
      $("#avance").html("");
      // borro el contenido del div
      $("#tabla").html("");

      // cargo el formulario 6 de matricula entonces realizo la funcion ...
      $("#avance").load("formulario_editar_matricula_2.html", function () {
        // llamo a la funcion de listar jornadas
        lista_jornadas("#ac_jornada");
        // llamo a la funcion lista escolaridad
        // en el camobo  
        lista_escolaridad("#ac_escolaridad");

        lista_grados(r["id_escolaridad"], "#ac_grado", $("#id_docente").val());

        // Selecciono los valores de la matricula
        $("#ac_escolaridad").val(r["id_escolaridad"]);
        $("#ac_jornada").val(r["id_jornada"]);
        $("#ac_grado").val(r["id_grado"]);
        $("#ac_curso").val(r["id_curso"]);


        // Se reemplaza el botón original por uno que primero valida
        $("#paginas").append('<button type="button" class="btn btn-secondary">atras</button>');
        $("#paginas").append('<button id="32-siguiente" class="btn btn btn-dark" >Siguiente</button>');

        $("#32-siguiente").on('click', function () {
          const camposAValidar = [
            { id: 'ac_jornada', name: 'Jornada', type: 'select' },
            { id: 'ac_escolaridad', name: 'Escolaridad', type: 'select' },
            { id: 'ac_grado', name: 'Grado', type: 'select' },
            { id: 'ac_curso', name: 'Curso', type: 'select' }
          ];

          if (validarFormulario(camposAValidar)) {
            // Si la validación es exitosa, se actualizan los datos y se procede al siguiente paso
            update_grado_matricula(); // actualiza el grado dentro de las matriculas
            flujo_editar_matricula(alumno["id_matricula"], 33); // Ir al siguiente paso
          }
        });
      });
      break;

    case 33:

      // ACTUALIZAR AFILIACIONES

      // criterio de inicio
      $("#avance").html("");
      $("#tabla").html("");

      // cargo en el div acance el formulario 7
      $("#avance").load("formulario_editar_matricula_3.html", function () {
        $("#paginas").load("formulario_actualizar_afiliaciones.html", function () {
          $("#paginas").prepend("<p>Se ha selecionado la persona <b>" + alumno["nombres"]
            + " " + alumno["apellidos"] + "</b>, con codigo " + alumno["id_persona"]
            + ", con identificacion " + alumno["identificacion"] + "</p>");
          // obtengo los datos de afiliacion en 
          // este formuulario 	
          get_afiliacion(alumno["id_persona"], 2);

          $("#paginas").append("<button id='33-siguiente' class='btn btn btn-dark' >Siguiente</button>");
          $("#paginas").append("<button id='33-atras' class='btn btn btn-secondary' >Atras</button>");

          $("#33-atras").on('click', function () {
            flujo_editar_matricula(alumno["id_matricula"], 32);
          });
          $("#33-siguiente").on('click', function () {
            const camposAValidar = [
              { id: 'ac_eps', name: 'EPS', type: 'select' },
              { id: 'ac_ips', name: 'IPS', type: 'select' },
              { id: 'ac_tipo_sangre', name: 'Tipo de sangre', type: 'select' }
            ];

            if (validarFormulario(camposAValidar)) {
              // Si la validación es exitosa, se actualizan los datos.
              // El paso 34 se cargará automáticamente al finalizar la petición AJAX.
              update_afiliaciones(2);
            }
          });
        });
      });

      break;

    case 34:

      // ACTUALIZAR ANTECEDENTES PATOLOGICOS

      // criterio de inicio
      $("#avance").html("");
      $("#tabla").html("");

      // cargo en el div acance el formulario 7
      $("#avance").load("formulario_editar_matricula_4.html", function () {

        $("#paginas").load("formulario_actualizar_antecedentes_patologicos.html", function () {
          $("#paginas").append("<button id='actualizar_antecedentes_patologicos' class='btn btn btn-dark' onclick='actualizar_antecedentes_patologicos(alumno, 2);'>agregar/actualizar</button>");
          $("#paginas").append("<button type='button' class='btn btn-secondary' onclick='flujo_editar_matricula(alumno['id_matricula'], 33)'>atras</button>");
          // cargo los valores en un nuevo formulario
          get_antecedentes(alumno["id_persona"], 2);
        });

        $("#paginas").prepend("<p>Modificando antecedentes patologicos de <b>" + alumno["nombres"]
          + " " + alumno["apellidos"] + "</b>, con codigo " + alumno["id_persona"]
          + ", con identificacion " + alumno["identificacion"] + "</p>");

      });

      break;

    // DATOS DEL PADRE
    case 35:
      $("#avance").html("");
      $("#tabla").html("");
      $("#avance").load("formulario_editar_matricula_5.html");

      break;

    // AGREGAR  PADRE

    case 36:
      $("#avance").html("");
      $("#tabla").html("");
      $("#avance").load("formulario_editar_matricula_6.html", function () {
        //	agrega el formulario de personas
        $("#paginas").load("formulario_agregar_persona.html", function () {
          $("#paginas").prepend('<div class="d-flex justify-content-end mb-3 gap-2"><button type="button" class="btn btn-secondary" onclick="flujo_editar_matricula(alumno[\'id_matricula\'],35)">atras</button><button type="button" class="btn btn-secondary" onclick="agregar_persona(38,padre,2)">agregar</button></div>');
        });
      });
      break;

    // PADRE REGISTRADO

    case 37:
      $("#avance").html("");
      $("#tabla").html("");
      // Cargar formulario_matricula_11.html
      $("#avance").load("formulario_editar_matricula_7.html", function () {
        $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="flujo_editar_matricula(alumno[\'id_matricula\'],35)">atras</button>');
      });
      break;

    // PADRE SELECCIONADO
    case 38:
      $("#avance").html("");
      $("#tabla").html("");
      //  cargo el formulario 11 de matricula en el campo avance
      $("#avance").load("formulario_editar_matricula_8.html", function () {
        // cargo el contenido dentro la seccion paginas dentro del formulario
        $("#paginas").html("<p>Se ha selecionado la persona <b>"
          + padre["nombres"] + " " + padre["apellidos"]
          + "</b>, con codigo " + padre["id_persona"]
          + ", con identificacion " + padre["identificacion"] + "</p>");
        $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="flujo_editar_matricula(alumno[\'id_matricula\'],35)">atras</button>');
        $("#paginas").append('<button type="button" class="btn btn-dark" onclick="flujo_editar_matricula(alumno[\'id_matricula\'],39);">siguiente</button>');

      });
      break;

    // DATOS DE LA MADRE
    case 39:
      $("#avance").html("");
      $("#tabla").html("");
      $("#avance").load("formulario_editar_matricula_9.html");
      break;

    // MADRE NUEVA

    case 40:
      $("#avance").html("");
      $("#tabla").html("");

      $("#avance").load("formulario_editar_matricula_10.html", function () {
        //	agrega el formulario de personas
        $("#paginas").load("formulario_agregar_persona.html", function () {
          $("#paginas").prepend('<div class="d-flex justify-content-end mb-3 gap-2"><button type="button" class="btn btn-secondary" onclick="flujo_editar_matricula(alumno[id_matricula],39)">atras</button><button type="button" class="btn btn-secondary" onclick="agregar_persona(42,madre,2)">agregar</button></div>');
        });

      });
      break;

    // MADRE REGISTRADA
    case 41:
      $("#avance").html("");
      $("#tabla").html("");
      // Cargar formulario_matricula_15.html
      $("#avance").load("formulario_editar_matricula_11.html", function () {

        $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="flujo_editar_matricula(alumno[id_matricula],39)  ">atras</button>');
      });
      break;

    // MADRE SELECCIONADA
    case 42:
      $("#avance").html("");
      $("#tabla").html("");
      //  cargo el formulario 16 de matricula en el campo avance
      $("#avance").load("formulario_editar_matricula_12.html", function () {
        // cargo el contenido dentro la seccion paginas dentro del formulario
        $("#paginas").html("<p>Se ha selecionado la persona <b>"
          + madre["nombres"] + " " + madre["apellidos"]
          + "</b>, con codigo " + madre["id_persona"]
          + ", con identificacion " + madre["identificacion"] + "</p>");
        $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="flujo_editar_matricula(alumno[\'id_matricula\'],39)">atras</button>');
        $("#paginas").append('<button type="button" class="btn btn-dark" onclick="flujo_editar_matricula(alumno[\'id_matricula\'],43);">siguiente</button>');

      });
      break;

    // DATOS DEL ACUDIENTE

    case 43:
      $("#avance").html("");
      $("#tabla").html("");
      $("#avance").load("formulario_editar_matricula_13.html");
      break;

    // AGREGAR ACUDIENTE
    case 44:
      $("#avance").html("");
      $("#tabla").html("");
      $("#avance").load("formulario_editar_matricula_14.html", function () {
        //	agrega el formulario de personas
        $("#paginas").load("formulario_agregar_persona.html", function () {
          $("#paginas").prepend('<div class="d-flex justify-content-end mb-3 gap-2"><button type="button" class="btn btn-secondary" onclick="flujo_editar_matricula(alumno[\'id_matricula\'],42)">atras</button><button type="button" class="btn btn-secondary" onclick="agregar_persona(45,acudinte,2)">agregar</button></div>');
        });
      });
      break;

    // ACUDIENTE REGISTRADO
    case 45:
      $("#avance").html("");
      $("#tabla").html("");
      // Cargar formulario_editar_matricula_15.html
      $("#avance").load("formulario_editar_matricula_15.html", function () {
        //  se cargan los botones
        $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="flujo_editar_matricula(alumno[\'id_matricula\'],42)">atras</button>');
        $("#paginas").append('<button type="button" class="btn btn-dark" onclick="flujo_editar_matricula(alumno[\'id_matricula\'],45);">siguiente</button>');

      });
      break;

    // ACUDIENTE SELECCIONADO

    case 46:
      $("#avance").html("");
      $("#tabla").html("");
      // Cargar formulario_matricula_3.html
      $("#avance").load("formulario_editar_matricula_16.html", function () {

        // cargo el contenido dentro la seccion paginas dentro del formulario
        $("#paginas").html("<p>Se ha selecionado la persona <b>"
          + acudiente["nombres"] + " " + acudiente["apellidos"]
          + "</b>, con codigo " + acudiente["id_persona"]
          + ", con identificacion " + acudiente["identificacion"] + "</p>");
        $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="flujo_editar_matricula(alumno[\'id_matricula\'],42)">atras</button>');
        $("#paginas").append('<button type="button" class="btn btn-dark" onclick="flujo_editar_matricula(alumno[\'id_matricula\'],47);">siguiente</button>');

      });
      break;
    // resumen de la matricual

    // resumen de la matricual
    case 47:
      // limpio el formulario
      $("#avance").html("");
      $("#tabla").html("");
      //  cargo el formulario 20 de matricula en el campo avance
      $("#avance").load("formulario_editar_matricula_17.html", function () {

        // cargo el contenido dentro la seccion paginas dentro del formulario
        $("#paginas").html("<p>Los datos de la matricula son :</p>");
        // muestro los datos del alumnos
        $("#paginas").append("<p> <i><h3>Datos del alumno</h3></i></p>");
        $("#paginas").append("<p> nombre : <b>" + alumno["nombres"] + " " + alumno["apellidos"] + "</b></p>");
        $("#paginas").append("<p> tipo de identificacion  : <b>" + alumno["tipo_identificacion"] + "</b></p>");
        $("#paginas").append("<p> identificacion : <b>" + alumno["identificacion"] + "</b></p>");
        $("#paginas").append("<p> grado : <b>" + alumno["id_grado"] + "</b></p>");
        $("#paginas").append("<p> jornada : <b>" + alumno["id_jornada"] + "</b></p>");
        $("#paginas").append("<p> curso : <b>" + alumno["id_curso"] + "</b></p>");
        $("#paginas").append("<p> escolaridad : <b>" + alumno["id_escolaridad"] + "</b></p>");
        $("#paginas").append("<p> año : <b>" + alumno["year"] + "</b></p>");
        $("#paginas").append("<p> fecha : <b>" + alumno["fecha"] + "</b></p>");
        $("#paginas").append("<p> nacimiento : <b>" + alumno["nacimiento"] + "</b></p>");
        $("#paginas").append("<p> correo : <b>" + alumno["correo"] + "</b></p>");
        $("#paginas").append("<p> correo institucional : <b>" + alumno["i_correo"] + "</b></p>");
        $("#paginas").append("<p> celular : <b>" + alumno["celular"] + "</b></p>");
        $("#paginas").append("<p> telefono : <b>" + alumno["telefono"] + "</b></p>");
        $("#paginas").append("<p> dirección : <b>" + alumno["direccion_residencia"] + "</b></p>");
        $("#paginas").append("<p> barrio : <b>" + alumno["barrio"] + "</b></p>");
        $("#paginas").append("<p> curso : <b>" + alumno["id_curso"] + "</b></p>");
        $("#paginas").append("<p> estrato : <b>" + alumno["estrato"] + "</b></p>");
        $("#paginas").append("<p> sisben : <b>" + alumno["sisben"] + "</b></p>");
        $("#paginas").append("<p> eps : <b>" + alumno["eps"] + "</b></p>");
        $("#paginas").append("<p> vivie_con : <b>" + alumno["vivie_con"] + "</b></p>");

        // muestro los datos del padre
        $("#paginas").append("<p> <i><h3>Datos del padre :</h3></i></p>");
        $("#paginas").append("<p> nombre : <b>" + padre["nombres"] + " " + padre["apellidos"] + "</b></p>");
        $("#paginas").append("<p> tipo de identificacion  : <b>" + padre["tipo_identificacion"] + "</b></p>");
        $("#paginas").append("<p> identificacion : <b>" + padre["identificacion"] + "</b></p>");
        $("#paginas").append("<p> nacimiento : <b>" + padre["nacimiento"] + "</b></p>");
        $("#paginas").append("<p> correo : <b>" + padre["correo"] + "</b></p>");
        $("#paginas").append("<p> correo institucional : <b>" + padre["i_correo"] + "</b></p>");
        $("#paginas").append("<p> celular : <b>" + padre["celular"] + "</b></p>");
        $("#paginas").append("<p> telefono : <b>" + padre["telefono"] + "</b></p>");

        // muestro los datos de la madre
        $("#paginas").append("<p> <i><h3>Datos de la madre</h3></i></p>");
        $("#paginas").append("<p> nombre : <b>" + madre["nombres"] + " " + madre["apellidos"] + "</b></p>");
        $("#paginas").append("<p> tipo de identificacion  : <b>" + madre["tipo_identificacion"] + "</b></p>");
        $("#paginas").append("<p> identificacion : <b>" + madre["identificacion"] + "</b></p>");
        $("#paginas").append("<p> nacimiento : <b>" + madre["nacimiento"] + "</b></p>");
        $("#paginas").append("<p> correo : <b>" + madre["correo"] + "</b></p>");
        $("#paginas").append("<p> correo institucional : <b>" + madre["i_correo"] + "</b></p>");
        $("#paginas").append("<p> celular : <b>" + madre["celular"] + "</b></p>");
        $("#paginas").append("<p> telefono : <b>" + madre["telefono"] + "</b></p>");

        // muestro los botones de aceptar
        $("#paginas").append('<button type="button" class="btn btn-secondary" onclick="flujo_editar_matricula(alumno[\`id_matricula\`],42)">atras</button>');
        $("#paginas").append('<button type="button" class="btn btn-outline-success" onclick="flujo_editar_matricula(alumno[\`id_matricula\`],48);">finalizar</button>');

      });
      break;


    case 48:
      $("#avance").html("");
      $("#tabla").html("");
      $("#avance").load("formulario_editar_matricula_18.html");

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


          // Realizar la edición de la matrícula del alumno	
          editar_matricula();

          $("#paginas").html("<p>Se ha completado la matricula del alumno ");
          $("#paginas").append(alumno["nombres"] + " " + alumno["apellidos"] + " </p>");


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
          flujo_editar_matricula(alumno["id_matricula"], 46);
        }
      });




      break;


  }
}

/**
 * Puente para actualizar las afiliaciones del alumno global.
 * @param {number} ea - 1 para flujo normal (gestion_matriculas), 2 para edición (editar_matricula).
 */
function update_afiliaciones(ea) {
  actualizar_afiliaciones(alumno, ea);
}

/**
 * imprimir_matricula()
 * Genera e imprime en PDF el comprobante de matrícula del alumno.
 *
 * Recibe como parámetros opcionales el id de matrícula y la fecha
 * obtenidos de la respuesta del servidor al llamar a matricular().
 * Los datos de alumno, padre y madre provienen de los objetos globales
 * `alumno`, `padre` y `madre` definidos en fc_admin.js.
 *
 * @param {number} [id_matricula] - ID de la matrícula en la tabla matricula.
 */
function imprimir_matricula(id_matricula) {
  // Construir los parámetros de la URL para el generador de PDF
  const params = new URLSearchParams({
    id_matricula: id_matricula || 0
  });

  // Abre el PDF en una nueva pestaña del navegador
  window.open('imprimir_matricula.php?' + params.toString(), '_blank');
}
