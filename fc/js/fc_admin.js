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

// objeto personax
let personax = {
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

/**
 * Valida un conjunto de campos de formulario.
 * @param {Array} fields - Un array de objetos, donde cada objeto representa un campo a validar.
 * Ej: [{id: 'ac_jornada', name: 'Jornada', type: 'select'}]
 * @returns {boolean} - Devuelve true si todos los campos son válidos, de lo contrario, false.
 */
function validarFormulario(fields) {
    for (const field of fields) {
        const element = $(`#${field.id}`);
        let isValid = true;

        if (!element.length) {
            console.error(`Elemento no encontrado: #${field.id}`);
            continue;
        }

        const value = element.val();

        switch (field.type) {
            case 'select':
                if (value === null || value === "-1" || value === "") {
                    isValid = false;
                }
                break;
            case 'text':
                if (value.trim() === "") {
                    isValid = false;
                }
                break;
            // Puedes agregar más tipos de validación (email, number, etc.)
        }

        if (!isValid) {
            swal('Campo Requerido', `Por favor, complete el campo: ${field.name}`, 'warning');
            element.css('border-color', 'red'); // Resaltar el campo inválido
            return false;
        } else {
            element.css('border-color', ''); // Restablecer el borde si es válido
        }
    }
    return true;
}


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

    // se envian datos al servidor
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
		// coloco la respuesta en el div
		// avance
		$("#avance").html(respuesta['html']);
		// coloco el año  de acuerdo al criterio  seleccionado
		$("#ano").html($("#years").val());
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


    // Validaciones
    if ($("#periodos").val() == "-1") {
        swal("Atención", "Por favor, seleccione un periodo.", "warning");
        $('#periodos').css('background-color', 'lightcoral'); // Resaltar el campo
        return; // Detiene la ejecución
    }
    if ($("#id_g").val() == "-1" || $("#id_g").val() == null) {
        swal("Atención", "Por favor, seleccione un grado.", "warning");
        $('#id_g').css('background-color', 'lightcoral'); // Resaltar el campo
        return; // Detiene la ejecución
    }

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



