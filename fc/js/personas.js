/////////////////////////////////////////////////////////////////////////////////////////////
//
// Funciones relacionadas con la gestion de personas
//
// cambio_datos-> lista las personas a partir de un criterio de busqueda (select)
//                consulta el archivo cambio_datos.php
//                usa el método buscar_persona($nombres, $apellidos, $identificacion)
//                el cual retorna un array con un listado de 4 x n  donde n es esl número de personas
//
// datos_persona -> funcion que retorna los datos de una persona y los coloca en el div #tabla (select)
//                  consulta el archivo datos_persona.php
//                  usa en método get_persona_por_id($id),
//                  el cual retorna todos los elementos de una fila de la tabla perssonas
//                  como atributos del objeto
//
// get_persona -> funcion que solicita los datos de una persona y la coloca en el div #tabla (select)
//                consulta el archivo get_persona.php
//                  usa en método get_persona_por_id($id),
//                  el cual retorna todos los elementos de una fila de la tabla perssonas
//                  como atributos del objeto
//
// get_afiliaciones(id, form) -> get_afiliaciones (select)
//                               consulta el archivo afiliacion_persona.php
//                               usa el método get_afiliacion($id_persna)
//                               el cual retorna un array con los datos relativos  los datos de afiacion de la
//                               persona.
// 
// get_antecedemtes(id, form) -> obtengo los datos del acudite (select)
//                               consulta el archivo antecedentes_persona.php
//
// seleccionar_persona(id, pesronax, fom) -> obtengo los datos de  una persona en el objeto personas
//                                          consulta el archivo 
//
// get_afiliacion(id,form) -> obtengo los datos de afiliacion de una perosona y los coloco en el formulario (select)
//                            consulta el archivo afiliacion_persona.php
//
// get_direccion(personax,form)-> obtengo los datos de la direccion de la persona y los coloco en  el formulario (select)
//                                consulta el archivo get_direccion.php
//
// agregar_persona-> se agrega una persona a  la base de datos (insert)
//                   consulta el archivo add_persona.php
//
// actualizar_persona-> funcion que actualiza los datos de una persona en la base de datos (update)
//                      consulta el archivo actualizar_persona.php
//
// actualizar_afiliaciones(personax) -> actualizo los datos de afilicion de personas en la base de datos (update)
//                                      consulta el archivo actualizar_afiliaciones.php
//
// actualizar_antecedentes_patologicos(personax) -> actualizo los datos de antedentes patologicos de los  estudiantes. (update)
//                                                  consulta el archivo actualizar_antecedentes.php
//
// cp_acudiente(personax) -> funcion que copia los datos del acudiente
//
// gestion_personas -> actualiza los datos de una persona (update)
//                     consulta el archivo gestion_personas.php
//
// update_grado_matricula -> actualizo el grado a los estudiantes en el objeto alumnos (update)
//                           consulta el archivo update_grado_matricula.php
//
// update_direccion(form,personas) -> actualizo los datos de direccion (update)
//                                    consulta el archivo actualizar_persona_direccion.php
//
// eliminar_persona -> funcion que elimina a una persona de la base de datos (delete)
//                     consulta el archivo del_persona.php
//                     
//
// formulario_agregar_persona -> crea un formaulario para agregar una persona
//
/////////////////////////////////////////////////////////////////////////////////////////////

// funcion que llama el formulario de gestionar las
// personas ,  usa el archivo gestion_peresonas.php
// no recive parametros y responde en html
// en el campo #avance

function gestion_personas() {

    // se invoca al metodo ajax para solicitar
    // el listado de las semanas
    $.ajax({
        type: "POST",
        url: "gestion_personas.php",
        dataType: "json",
        data: {
            years: $("#years").val(),
            periodo: $("#periodos").val(),
            semana: $("#semana").val(),
            id_g: $("#id_g").val(),
            id_ms: $("#id_ms").val(),
            id_jornada: $("#jornada").val(),
            id_curso: $("#id_c").val()
        },
      
        // si los datos son correctos entonces ...
        success: function (respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {
              // coloco la respuesta en html
	      // en el div avance
                $("#avance").html(respuesta['html']);
            } else {
	      // si no se ha seleccionado el  grado
              if (respuesta['status'] == 21) {
                    swal('Grado', 'Porfavor seleccione un grado', 'error');
              }

	      // si no se ha especificado el año
                if (respuesta['status'] == 22) {
                    swal('Año', 'Porfavor seleccione un año', 'error');
                }

	      // si no se ha especificado la jornada
                if (respuesta['status'] == 23) {
                    swal('Jornada', 'Porfavor seleccione un jornada', 'error');
                }
	      // si no se ha especificado la semana
                if (respuesta['status'] == 24) {
                    swal('Semana', 'Porfavor seleccione una semana', 'error');
                }

            }
        },
      // si huvo  un error
        error: function (xhr, status) {
            swal('Disculpe, existió un problema');
            console.log(xhr);
        }
    });

}


// funcion que muestra listado de personas que  coinciden con los datos
// los parametros de entrada:
// repo:  es el div en que se colocara la respuesta en formato html
// retorna un html con la tabla de personas

function cambio_datos_p(repo) {

    // se invoca al metodo ajax para solicitar
    // el listado de personas
    $.ajax({
        type: "POST",
        url: "cambio_datos_p.php",
        dataType: "json",
        data: {
            nombres: $("#nombres").val(),
            apellidos: $("#apellidos").val(),
            identificacion: $("#identificacion").val()
        },
        // si los datos son correctos entonces ...
      success: function (respuesta) {
	
            // si la respuesta es positiva
        if (respuesta['status'] == 1) {

                // coloco la respuesta en el campo repo
                $(repo).html( "<table class='table' id='lista_e'>"+
			      "<thead>"+
			      // emcabezado de la tabla
			      "<th scope='col'>Nombres</th>"+
			      "<th scope='col'>Apellidos</th>"+
			      "<th scope='col'>D. de identidad</th>"+
			      "<th scope='col'>Actualizar</th>"+
			      "<th scope='col'>Eliminar</th>"+
			      "</thead>"+
			      "<tbody>");

	  
	  respuesta['json'].forEach(  id => {
	    // se agrega fila a la tabla
	    $('#lista_e').append( "<tr><td>" + id[0] + "</td><td>" + id[1] + "</td><td>" + id[2] + "</td><td><button type='button' class='btn btn-info' onclick='datos_persona(\"" + id[3] + "\");'>actualizar</button></td><td><button type='button' class='btn btn-warning' onclick='eliminar_persona(\"" + id[3] + "\");'>eliminar</button></td></tr>");
	    
	 });

	  // agrego el  final de la tabla
	  $(repo).append( "</tbody>"+
			  "</div>"+
			  "</div>"+
			  "</div>");
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



// funcion que muestra listado de personas que  coinciden con los datos
// los parametros de entrada:
// repo:  es el div en que se colocara la respuesta en formato html
// presonax : id de la  persona que se va a consultar 
// form : codigo del formulario de donde se hace la cosulta
// retorna un html con la tabla de personas

function cambio_datos(repo, personax, form) {

    // se invoca al metodo ajax para solicitar
    // el listado de personas
    $.ajax({
        type: "POST",
        url: "cambio_datos.php",
        dataType: "json",
        data: {
            nombres: $("#nombres").val(),
            apellidos: $("#apellidos").val(),
            identificacion: $("#identificacion").val(),
            personax: personax,
            form: form
        },
        // si los datos son correctos entonces ...
      success: function (respuesta) {
	
            // si la respuesta es positiva
        if (respuesta['status'] == 1) {

                // coloco la respuesta en el campo repo
                $(repo).html( "<table class='table' id='lista_e'>"+
			      "<thead>"+
			      // emcabezado de la tabla
			      "<th scope='col'>Nombres</th>"+
			      "<th scope='col'>Apellidos</th>"+
			      "<th scope='col'>D. de identidad</th>"+
			      "<th scope='col'>Actualizar</th>"+
			      "<th scope='col'>Selecionar</th>"+
			      "<th scope='col'>Eliminar</th>"+
			      "</thead>"+
			      "<tbody>");

	  
	  respuesta['json'].forEach(  id => {
	    // se agrega fila a la tabla
	    $('#lista_e').append( "<tr><td>" + id[0] + "</td><td>" + id[1] + "</td><td>" + id[2] + "</td><td><button type='button' class='btn btn-info' onclick='datos_persona(\"" + id[3] + "\");'>actualizar</button></td><td><button type='button' class='btn btn-success' onclick='seleccionar_persona(" + id[3] + ",  personax, "+form+");'>seleccionar</button></td><td><button type='button' class='btn btn-warning' onclick='eliminar_persona(\"" + id[3] + "\");'>eliminar</button></td></tr>");
	    
	 });

	  // agrego el  final de la tabla
	  $(repo).append( "</tbody>"+
			  "</div>"+
			  "</div>"+
			  "</div>");
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


//  se carga el formulario para agregar personas
// en el div #tabla
function formulario_agregar_persona() {
  
    // borro el div llamado #tabla
    $("#tabla").html("");
    //  cargo el formulario agregar personas en el div #tabla
    // al finalizar ejecuto la funcion
    $("#tabla").load("formulario_agregar_persona.html", function (response, status, xhr) {
	if (status == "error") {
            console.error("Error al cargar");
	} else {
            console.log("Cargado. Longitud del contenido: " + response.length);
            // Forzamos visibilidad
            $("#tabla").show(); 
            console.log("Contenido actual de #tabla: ", $("#tabla").html());
	}
    });

    // cambio el atributo visual del boton
    $("#agregar_persona").removeClass("btn btn-outline-dark").addClass("btn btn-dark");

    // asigno una funcion
    $("#agregar_persona").attr("onclick", "agregar_persona()");
    
}

// funcion para agregar personas
// los parametros de entrada son 

// formulario : indica el formulario de destino
// personax : inica la persona  a agregar como un objeto

function agregar_persona(formulario, personax) {

    
    // Si el formulario no es válido, detenemos la ejecución con 'return'.
    if (!validarFormularioPersona()) {
        // Opcional: Mostrar una alerta general
        swal('Formulario Incompleto', 'Por favor, corrija los campos marcados en rojo.', 'warning');
        return; 
    }

    // almaceno los datos en el json
    // a partir de los campos del formulario
    let persona = {}; // Es buena práctica declarar el objeto

    // almaceno los datos en el json
    // a partir de los campos del formulario
    persona.nombres = $("#ad_nombres").val();
    persona.apellidos = $("#ad_apellidos").val();
    persona.tipo_identificacion = $("#ad_tipo_identificacion").val();
    persona.identificacion = $("#ad_identificacion").val();
    persona.correo = $("#ad_correo").val();
    persona.i_correo = $("#ad_i_correo").val();
    persona.celular = $("#ad_celular").val();
    persona.telefono = $("#ad_telefono").val();
    persona.nacimiento = $("#ad_nacimiento").val();

    // envio datos 
    $.ajax({
        type: "POST",
        url: "add_persona.php",
        dataType: "json",
        data: persona,
        // si los datos son correctos entonces ...
        success: function (respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {
                // si se agrego la persona correctamente
                swal('Actualizacion', 'Se agrego a la persona correctamente', 'success');

		// valido si esta definido la persona x
		// esto es para el formulario de matricula
		if(typeof personax === 'undefined'){
		    console.log("EmpName no está definido");
		} else {
                    // almaceno en la variable seleccionada
                    personax["nombres"] = respuesta["nombres"];
                    personax["apellidos"] = respuesta["apellidos"];
                    personax["identificacion"] = respuesta["idetificacion"];
                    // tomo como persona seleccionada la presona 
                    // retornada
                    seleccionar_persona(respuesta["id_persona"], personax, 4);
                    // voy al formulario indicado
                    gestion_matriculas(formulario);
		}


            } else {
                if (respuesta['status'] == 21) {
                    swal('Error', 'Falata el nombre de la persona', 'error');
                }
                if (respuesta['status'] == 22) {
                    swal('Error', 'Falta a los apellidos', 'error');
                }

                if (respuesta['status'] == 23) {
                    swal('Error', 'Falta el tipo de identificacion', 'error');
                }
                if (respuesta['status'] == 24) {
                    swal('Error', 'Falta el numro de identificacion', 'error');
                }

                if (respuesta['status'] == 25) {
                    swal('Error', 'Falta de nacimiento', 'error');
                }

            }
        },
        error: function (xhr, status) {
            swal('Disculpe, existió un problema');
            console.log(xhr);
        }
    });

}

// funcion que toma los datos ingresados
// en el formaulario de actualizacion de
// personas y lo envia mendinte ajax
function actualizar_persona() {

    valida_actualizar_persona();

    // invoco el metodo ajax
    // para solicitar los datos del servidor

    $.ajax({
        type: "POST",
        url: "actualizar_persona.php",
        dataType: "json",
        data: {
            id_persona: $("#ac_id_persona").val(),
            nombres: $("#ac_nombres").val(),
            apellidos: $("#ac_apellidos").val(),
            tipo_identificacion: $("#ac_tipo_identificacion").val(),
            identificacion: $("#ac_identificacion").val(),
            correo: $("#ac_correo").val(),
            i_correo: $("#ac_i_correo").val(),
            celular: $("#ac_celular").val(),
            telefono: $("#ac_telefono").val(),
            nacimiento: $("#ac_nacimiento").val()
        },
        // si los datos son correctos entonces ...
        success: function (respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {
                //swal('Datos actualizados');
                //$("#calificador").html(respuesta);
                //$("#avance").html(respuesta['html']);
                //gestion_semanas();
                swal("Completado", respuesta["html"], "success");
            } else {
                if (respuesta['status'] == 20) {
                    swal('Error', 'no se pudo actualizar la semana', 'error');
                }
                if (respuesta['status'] == 22) {
                    swal('Año', 'Porfavor seleccione un año', 'error');
                }
                if (respuesta['status'] == 23) {
                    swal('Fecha', 'Porfavor seleccione una fecha de inicio', 'error');
                }
                if (respuesta['status'] == 24) {
                    swal('Fecha', 'Porfavor seleccione una fecha de fin', 'error');
                }
                if (respuesta['status'] == 25) {
                    swal('Año', 'Porfavor seleccione una fecha de inicio menor a la de fin', 'error');
                }
                if (respuesta['status'] == 26) {
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


/**
 * Función para validar el formulario de actualización de persona del lado del cliente.
 * Muestra errores visuales y devuelve true si es válido, o false si no lo es.
 */
function valida_actualizar_persona() {
    // 1. Limpiar errores previos para una nueva validación.
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    let esValido = true;
    let errores = {};

    // 2. Recolectar y validar cada campo.
    const nombres = $('#ac_nombres').val().trim();
    if (nombres === '') {
        errores.nombres = 'El nombre es obligatorio.';
    }

    const apellidos = $('#ac_apellidos').val().trim();
    if (apellidos === '') {
        errores.apellidos = 'Los apellidos son obligatorios.';
    }

    const tipo_identificacion = $('#ac_tipo_identificacion').val();
    if (!tipo_identificacion || tipo_identificacion === '0') { // Suponiendo que el valor por defecto sea 0 o nulo
        errores.tipo_identificacion = 'Debe seleccionar un tipo de identificación.';
    }

    const identificacion = $('#ac_identificacion').val().trim();
    if (identificacion === '') {
        errores.identificacion = 'El número de identificación es obligatorio.';
    }

    const correo = $('#ac_correo').val().trim();
    // Expresión regular simple para validar el formato de un email.
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (correo === '') {
        errores.correo = 'El correo electrónico es obligatorio.';
    } else if (!emailRegex.test(correo)) {
        errores.correo = 'El formato del correo electrónico no es válido.';
    }

    const i_correo = $('#ac_i_correo').val().trim();
    // El correo institucional es opcional, pero si se escribe, debe ser válido.
    if (i_correo !== '' && !emailRegex.test(i_correo)) {
        errores.i_correo = 'El formato del correo institucional no es válido.';
    }

    const celular = $('#ac_celular').val().trim();
    // El celular es opcional, pero si se escribe, debe contener solo números.
    const soloNumerosRegex = /^[0-9]+$/;
    if (celular !== '' && !soloNumerosRegex.test(celular)) {
        errores.celular = 'El número de celular solo debe contener dígitos.';
    }
    
    const nacimiento = $('#ac_nacimiento').val();
    if (nacimiento === '') {
        errores.nacimiento = 'La fecha de nacimiento es obligatoria.';
    } else if (new Date(nacimiento) > new Date()) {
        errores.nacimiento = 'La fecha de nacimiento no puede ser en el futuro.';
    }


    // 3. Comprobar si se encontraron errores.
    if (Object.keys(errores).length > 0) {
        esValido = false;
        // Si hay errores, mostrarlos debajo de los campos correspondientes.
        $.each(errores, function(campo, mensaje) {
            const input = $('#ac_' + campo);
            input.addClass('is-invalid'); // Añade un borde rojo (estilo de Bootstrap).
            // Añade el mensaje de error debajo del input.
            input.after('<div class="invalid-feedback">' + mensaje + '</div>');
        });
    }

    return esValido;
}


// Función para actualizar los datos de una persona
// con relación a sus afiliaciones a distintas entidades
// 
function actualizar_afiliaciones(personax) {
    // Se precargan los atributos del formulario
    personax.sisben = $("#ac_sisben").val();
    personax.vive_con = $("#ac_vive_con").val();
    personax.etnia = $("#ac_etnia")[0].checked ? true : false;
    personax.tipo_etnia = $("#ac_tipo_etnia").val();
    personax.resguardo_consejo = $("#ac_resguardo_consejo").val();
    personax.familias_accion = $("#ac_familias_accion")[0].checked ? true : false;
    personax.tipo_victima_conflicto = $("#ac_tipo_victima_conflicto")[0].checked ? true : false;
    personax.municipio_expulsor = $("#ac_municipio_expulsor").val();
    // si esta chequeado la opcion de discapacitad
    personax.discapacitado = $("#ac_discapacitado")[0].checked ? true : false;
    personax.tipo_discapacidad = $("#ac_tipo_discapacidad").val();
    personax.capacidad_excepcional = $("#ac_capacidad_excepcional").val();
    personax.regimen_salud = $("#ac_regimen_salud")[0].checked ? true : false;
    personax.eps = $("#ac_eps").val();
    personax.ips = $("#ac_ips").val();
    personax.tipo_sangre = $("#ac_tipo_sangre").val();
    personax.rh = $("#ac_rh").val();

    // Validación de datos antes de enviar (puedes agregar más validaciones)
    if (!personax.sisben) {
        swal('Error', 'Por favor, seleccione un valor para SISBEN.', 'error');
        return;
    }

    // Solicitar datos al servidor mediante AJAX
    $.ajax({
        type: "POST",
        url: "actualizar_afiliaciones.php",
        dataType: "json",
        data: personax,
        success: function (respuesta) {
            // Mapa de errores
            const errorMap = {
                20: 'No se pudo actualizar la semana.',
                22: 'Por favor seleccione un año.',
                23: 'Por favor seleccione una fecha de inicio.',
                24: 'Por favor seleccione una fecha de fin.',
                25: 'La fecha de inicio debe ser menor que la de fin.',
                26: 'Por favor seleccione una semana.'
            };

            // Si la respuesta es positiva
            if (respuesta['status'] == 1) {
                swal("Completado", "Se completó el registro", "success");
                // voy a la seccion 6 del formulario matricula
                gestion_matriculas(8);
            } else if (errorMap[respuesta['status']]) {
                // Si el código de error existe en el mapa
                swal('Error', errorMap[respuesta['status']], 'error');


            } else {
                swal('Error', 'Se produjo un error inesperado', 'error');
            }
        },
        error: function (xhr, status, error) {
            swal('Disculpe, existió un problema');
            console.log("Error AJAX:", status, error);
        }
    });
}

// funcion  que borra el contenido del div #tabla
function borrar_tabla(){
    // borro el contenido del div tabla
    $("#tabla").html("");
}



// Función para actualizar los datos de una persona con relación a sus afiliaciones
function actualizar_antecedentes_patologicos(personax) {
    // Se precargan los atributos del formulario

    personax.antecedentes_patologicos_medicos = $("#ac_medicos").val();
    personax.antecedentes_patologicos_quirurgicos = $("#ac_quirurgicos").val();
    personax.antecedentes_patologicos_toxicos = $("#ac_toxicos").val();
    personax.antecedentes_patologicos_psiquiatricos = $("#ac_psiquiatricos").val();
    personax.antecedentes_patologicos_psicologicos = $("#ac_psicologicos").val();
    personax.antecedentes_patologicos_morbilidad = $("#ac_morbilidad").val();



    // Solicitar datos al servidor mediante AJAX
    $.ajax({
        type: "POST",
        url: "actualizar_antecedentes.php",
        dataType: "json",
        data: personax,
        success: function (respuesta) {
            // Mapa de errores
            const errorMap = {
                20: 'No se pudo actualizar la semana.',
                22: 'Por favor seleccione un año.',
                23: 'Por favor seleccione una fecha de inicio.',
                24: 'Por favor seleccione una fecha de fin.',
                25: 'La fecha de inicio debe ser menor que la de fin.',
                26: 'Por favor seleccione una semana.'
            };

            // Si la respuesta es positiva
            if (respuesta['status'] == 1) {
                swal("Completado", "Se completó el registro", "success");
                // voy a la seccion 8 del formulario matricula
                gestion_matriculas(9);
            } else if (errorMap[respuesta['status']]) {
                // Si el código de error existe en el mapa
                swal('Error', errorMap[respuesta['status']], 'error');


            } else {
                swal('Error', 'Se produjo un error inesperado', 'error');
            }
        },
        error: function (xhr, status, error) {
            swal('Disculpe, existió un problema');
            console.log("Error AJAX:", status, error);
        }
    });
}


// funcion que solicitar datos de la persona
// y los coloca en el el div #tabla
// requiere como entrada el codigo de la persona

function datos_persona(id) {
    //  realizo la consulta en de los datos
    $.ajax({
        type: "POST",
        url: "datos_persona.php",
        dataType: "json",
        data: {
            id: id
        },
        // si los datos son correctos entonces ...
        success: function (respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {
		//coloco la respuesta en el div tabla
                $("#tabla").html(respuesta['html']);
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


// funcion que solicitar datos de la persona
// y los coloca en el el div #tabla
// requiere como entrada el codigo de la persona

function get_persona(id, personax) {
    //  realizo la consulta en de los datos
    $.ajax({
        type: "POST",
        url: "get_persona.php",
        dataType: "json",
        data: {
            id: id
        },
        // si los datos son correctos entonces ...
        success: function (respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {
                personax["nombres"] = respuesta["nombres"];
                personax["apellidos"] = respuesta["apellidos"];
                personax["identificacion"] = respuesta["identificacion"];
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

// permite eliminar una persona
// recibe como entrada el id_persona
function eliminar_persona(id_personas) {

    swal({
        title: "Esta seguro?",
        text: "Una vez eliminado no podra obtener los datos de la persona!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                // se invoca al metodo ajax para solicitar
                // el listado de estudiantes
                $.ajax({
                    type: "POST",
                    url: "del_persona.php",
                    dataType: "json",
                    data: {
                        id_personas: id_personas,
                    },
                    // si los datos son correctos entonces ...
                    success: function (respuesta) {
                        // si la respuesta es positiva
                        if (respuesta['status'] == 1) {
                            swal('Persona', 'Se elimino la persona con  éxito', 'success');

                        } else {
                            if (respuesta['status'] == 20) {
                                swal('Consulta', 'Fallo al intentar eliminar la persona', 'error');
                            }
                            if (respuesta['status'] == 21) {
                                swal('Persona', 'Por favor seleccione una persona', 'error');
                            }

                        }
                    },
                    error: function (xhr, status) {
                        swal('Disculpe, existió un problema');
                        console.log(xhr);
                    }
                }); // fin de ajax
            }
            else {
                swal("Se conserva la persona");
            }
        });
}

// funcion que permite obtener los datos de una persona
// de acuerdo a su id y colocarlo el objeto personas
// y finalmente saltar al item form del formulaio de matricula
function seleccionar_persona(id, personax, form) {
    //  cargo el los datos de la persona
    personax["id_persona"] = id;
    // obtengo los datos de la persona en el json persona
    get_persona(id, personax);
    // los muestro
    swal("seleccion", "Se selecciono la persona " + personax["id_persona"], 'success');
    // voy al formulario 4 de matriculas
    gestion_matriculas(form);
}


// solicito los datos para el formaulario de afiliacion

function get_afiliacion(id, form) {
    // Solicito datos por AJAX
    $.ajax({
        type: "POST",
        url: "afiliacion_persona.php",
        dataType: "json",
        data: { id: id },
        success: function (respuesta) {
            if (respuesta['status'] == 1) {
                // Validamos según el formulario
                if (form === 2) {

                    // Asignar SISBEN
                    let sisben = respuesta["sisben"] || "N";
                    $("#ac_sisben").val(sisben);

                    // Asignar con quién vive
                    let viveCon = respuesta["vive_con"] || "N";
                    $("#ac_vive_con").val(viveCon);

                    // Propiedad `checked` para etnia
                    respuesta["etnia"] === 1 ? $("#ac_etnia").prop("checked", true) : $("#ac_etnia").prop("checked", false);

                    // Asignar el tipo de etnia
                    let tipoetnia = respuesta["tipo_etnia"] || "otro";
                    $("#ac_tipo_etnia").val(tipoetnia);
                    // asignar resguardo o consejo comunitario
                    $("#ac_resguardo_consejo").val(respuesta["resguardo_consejo"]);

                    // Propiedad `checked` para familias en accion
                    respuesta["familias_accion"] === 1 ? $("#ac_familias_accion").prop("checked", true) : $("#ac_familias_accion").prop("checked", false);

                    // Propiedad `checked` para victima del conflicto
                    if (respuesta["tipo_victima_conflicto"] == 1) { $("#ac_tipo_victima_conflicto").prop("checked", true) }

                    else { $("#ac_tipo_victima_conflicto").prop("checked", false) };

                    // asignar municipio_expulsor	
                    $("#ac_municipio_expulsor").val(respuesta["municipio_expulsor"]);

                    // Propiedad `checked` para discapacitado
                    respuesta["discapacitado"] === 1 ? $("#ac_discapacitado").prop("checked", true) : $("#ac_discapacitado").prop("checked", false);

                    // asignar tipo_discapacidad		
                    $("#ac_tipo_discapacidad").val(respuesta["tipo_discapacidad"]);

                    // asignar tipo_discapacidad		
                    $("#ac_capacidad_excepcional").val(respuesta["capacidad_excepcional"]);

                    // Propiedad `checked` para regimen_salud
                    respuesta["regimen_salud"] === 1 ? $("#ac_regimen_salud").prop("checked", true) : $("#ac_regimen_salud").prop("checked", false);

                    // asignar eps		
                    $("#ac_eps").val(respuesta["eps"]);

                    // asignar ips		
                    $("#ac_ips").val(respuesta["ips"]);

                    // Asignar con el tipo de sangre
                    let tiposangre = respuesta["tipo_sangre"] || "O";
                    $("#ac_tipo_sangre").val(tiposangre);

                    // Asignar con el tipo de sangre
                    let rh = respuesta["rh"] || "+";
                    $("#ac_rh").val(rh);



                }

            } else {
                // Manejo de errores según el código de estado
                let mensaje = "Hubo un error desconocido.";
                if (respuesta['status'] == 20) {
                    mensaje = "Hubo un error al eliminar la matrícula docente.";
                } else if (respuesta['status'] == 21) {
                    mensaje = "Hubo un error al actualizar la información.";
                }
                swal('Error', mensaje, 'error');
            }
        },
        error: function (xhr, status) {
            swal('Disculpe, existió un problema');
            console.log(xhr);
        }
    });
}


// funcion que obtiene los datos de direccion
// el estrato y el barrio
// require el codigo de la persona
// y el codigo del formulario

function get_direccion(personax, form) {

    // solicito datos en ajax
    $.ajax({
        type: "POST",
        url: "direccion_persona.php",
        dataType: "json",
        data: {
            id: personax["id_persona"]
        },
        // si los datos son correctos entonces ...
        success: function (respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {

                // retorno la direccion de la persona
                personax["direccion_residencia"] = respuesta["direccion_residencia"];
                personax["estrato"] = respuesta["estrato"];
                personax["barrio"] = respuesta["barrio"];
                return 1;

            } else {
                if (respuesta['status'] == 20) {
                    swal('Error', 'Hubo un error al eliminar la matricula docente', 'error');
                }
                if (respuesta['status'] == 21) {
                    swal('Error', 'Hubo un error al eliminar la matricula docente', 'error');
                }

                //  retorno cero
                return 0;
            }
        },
        error: function (xhr, status) {
            swal('Disculpe, existió un problema');
            console.log(xhr);
        }
    });

}


// funcion actualizar grado

function update_grado_matricula() {

    // se actualiza el grado el la variable alumno
    alumno.id_escolaridad = $("#ac_escolaridad").val();
    // actualizo el codigo del grado
    alumno.id_grado = $("#ac_grado").val();
    // actualizo el codigo del curso
    alumno.id_curso = $("#ac_curso").val();
    // se actualiza la jornada
    alumno.id_jornada =  $("#ac_jornada").val();

    // salida por consola
    console.log("los datos del alumono son " + alumno.id_escolaridad + " codigo del grado " + alumno.id_grado + " codigo del curso" + alumno.id_curso);

    /*
    // si el boton de grado no ha sido digitado
    if ($("#ac_grado").val() !== null) {

        // muestro confirmacion
        //swal("actualizacion grado", "se actualizo con exito el grado", "success");
        // voy a la seccion 7 del formulario matricula
        gestion_matriculas(7);
    }
    else {
        swal("actualizacion  grado", "Por favor seleccione un grado", "error");
	}
	*/
}

// actualizar direccion
// presronax  : es el id_persona
// form : es el codigo del formulario donde se actuliza la direccion
function update_direccion(form, personax) {

    // tomo el dato
    personax["estrato"] = $("#ac_estrato").val();
    // tomo el dato dle barrio
    personax["barrio"] = $("#ac_barrio").val();
    // tomo el id
    personax["direccion_residencia"] = $("#ac_direccion").val();

    // solicito datos en ajax
    $.ajax({
        type: "POST",
        url: "actualizar_persona_direccion.php",
        dataType: "json",
        data: personax,
        // si los datos son correctos entonces ...
        success: function (respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {

                // salta de acuerdo al formulario
                switch (form) {

                    case 2:
                        // se carga  el formulario
                        $("#ac_direccion").val(respuesta['direccion_residencia']);
                        $("#ac_barrio").val(respuesta['barrio']);

                        switch (respuesta["estrato"]) {
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

                        // muestro confirmacion
                        swal("actualizacion dirección", "se actualizo con exito la dirección", "success");
                        // voy a la seccion 6 del formulario matricula
                        gestion_matriculas(6);

                        break;
                }
            }

            else {
                if (respuesta['status'] == 20) {
                    swal('Error', 'Hubo un error al eliminar la matricula docente', 'error');
                }
                if (respuesta['status'] == 21) {
                    swal('Error', 'Hubo un error al eliminar la matricula docente', 'error');
                }
            }
        }
        ,
        error: function (xhr, status) {
            swal('Disculpe, existió un problema');
            console.log(xhr);
        }
    });


}


// funcion que obtiene los datos de afiliacions
// sisben : ""
//	familias_accion : false
//	regimen_salud : false
//  eps: ""
//	vive_con : ""
//	tipo_victima_conflicto : ""
//	municipio_expulsor : ""
//	discapacitado: false
//	tipo_discapacidad : ""
//	capacidad_excepcional : ""
//	etnia : false 
//	tipo_etnia : ""
//	resguardo_consejo : ""
// require el codigo de la persona
// y el codigo del formulario

function get_afiliaciones(id, form) {

    // solicito datos en ajax
    $.ajax({
        type: "POST",
        url: "afiliacion_persona.php",
        dataType: "json",
        data: {
            id: id
        },
        // si los datos son correctos entonces ...
        success: function (respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {

                // salta de acuerdo al formulario
                switch (form) {

                    case 2:
                        // se carga  el formulario
                        $("#paginas").load("formulario_actualizar_antecedentes.html", function () {
                            // obtengo el valor de los antecedentes medicos
                            $("#ac_medicos").val(respuesta["antecedents_patologicos_medicos"]);
                            // obtengo el valor del barrio
                            $("#ac_barrio").val(respuesta["barrio"]);
                            switch (respuesta["estrato"]) {
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
                        });
                        break;
                }
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

// funcion que obtiene los datos de antecedentes


function get_antecedemtes(id, form) {

    // solicito datos en ajax
    $.ajax({
        type: "POST",
        url: "antecedentes_persona.php",
        dataType: "json",
        data: {
            id: id
        },
        // si los datos son correctos entonces ...
        success: function (respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {

                // salta de acuerdo al formulario
                switch (form) {

                    case 2:
                        // se carga  el formulario
                        $("#paginas").load("formulario_actualizar_antecedentes.html", function () {
                            // obtengo el valor de los antecedentes medicos
                            $("#ac_medicos").val(respuesta["antecedents_patologicos_medicos"]);
                            // obtengo el valor de los antecedentes quirurgicos
                            $("#ac_quirurgicos").val(respuesta["antecedentes_patologicos_quirurgicos"]);
                            // obtengo el valor de los antecedentes quirurgicos
                            $("#ac_toxicos").val(respuesta["antecedentes_patologicos_toxicos"]);
                            // obtengo el valor de los antecedentes quirurgicos
                            $("#ac_psiquiatricos").val(respuesta["antecedentes_patologicos_psiquiatricos"]);
                            // obtengo el valor de los antecedentes quirurgicos
                            $("#ac_psicologicos").val(respuesta["antecedentes_patologicos_psicologicos"]);
                            // obtengo el valor de los antecedentes quirurgicos
                            $("#ac_morbilidad").val(respuesta["antecendentes_patologicos_morbilidad"]);

                        });

                        break;
                }

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

// funcion para copiar los datos de un acudinte
function cp_acudiente(personax) {
    // tomo los datos del padre
    acudiente = personax;


    // va la pagina 19 de gestion matriculas
    gestion_matriculas(19);

}

// funcion que permite conocer el codigo
// de una persona en funcion
// del codigo del estudiante

function get_id_persona_con_id_alumno(){

  
  
}


/**
 * Función para mostrar un error en un campo específico del formulario.
 * @param {string} campoId - El ID del input que tiene el error.
 * @param {string} mensaje - El mensaje de error a mostrar.
 */
function mostrarError(campoId, mensaje) {
    // Agrega la clase 'is-invalid' de Bootstrap para resaltar el campo en rojo
    $("#" + campoId).addClass('is-invalid');
    // Muestra el mensaje de error en el div de ayuda correspondiente
    $("#ayuda_" + campoId.substring(3)).text(mensaje).addClass('text-danger');
}

/**
 * Función para limpiar los errores de un campo específico.
 * @param {string} campoId - El ID del input a limpiar.
 */
function limpiarError(campoId) {
    $("#" + campoId).removeClass('is-invalid');
    // Restaura el texto de ayuda original si es necesario
    $("#ayuda_" + campoId.substring(3)).removeClass('text-danger');
}


/**
 * Función principal que valida todos los campos del formulario antes de enviar.
 * @returns {boolean} - Devuelve true si el formulario es válido, false en caso contrario.
 */
function validarFormularioPersona() {
    let esValido = true;

    // Limpiar errores previos antes de volver a validar
    $('.form-control').each(function() {
        limpiarError($(this).attr('id'));
    });

    // 1. Validación de Nombres (ad_nombres)
    const nombres = $("#ad_nombres").val().trim();
    if (nombres === "") {
        mostrarError('ad_nombres', 'El nombre es obligatorio.');
        esValido = false;
    } else if (nombres.length < 3) {
        mostrarError('ad_nombres', 'El nombre debe tener al menos 3 caracteres.');
        esValido = false;
    }

    // 2. Validación de Apellidos (ad_apellidos)
    const apellidos = $("#ad_apellidos").val().trim();
    if (apellidos === "") {
        mostrarError('ad_apellidos', 'El apellido es obligatorio.');
        esValido = false;
    } else if (apellidos.length < 3) {
        mostrarError('ad_apellidos', 'El apellido debe tener al menos 3 caracteres.');
        esValido = false;
    }

    // 3. Validación de Identificación (ad_identificacion)
    const identificacion = $("#ad_identificacion").val().trim();
    if (identificacion === "") {
        mostrarError('ad_identificacion', 'El número de identificación es obligatorio.');
        esValido = false;
    } else if (!/^\d+$/.test(identificacion)) { // Expresión regular para verificar si son solo números
        mostrarError('ad_identificacion', 'La identificación solo debe contener números.');
        esValido = false;
    }
    
    // 4. Validación de Correo Personal (ad_correo) - Opcional pero si se escribe, debe ser válido
    const correo = $("#ad_correo").val().trim();
    const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (correo !== "" && !regexCorreo.test(correo)) {
        mostrarError('ad_correo', 'El formato del correo no es válido.');
        esValido = false;
    }

    // 5. Validación de Correo Institucional (ad_i_correo) - Opcional
    const iCorreo = $("#ad_i_correo").val().trim();
    if (iCorreo !== "" && !regexCorreo.test(iCorreo)) {
        mostrarError('ad_i_correo', 'El formato del correo institucional no es válido.');
        esValido = false;
    }
    
    // 6. Validación de Celular (ad_celular)
    const celular = $("#ad_celular").val().trim();
    if (celular === "") {
        mostrarError('ad_celular', 'El número de celular es obligatorio.');
        esValido = false;
    } else if (!/^\d{10}$/.test(celular)) { // Valida que sean exactamente 10 dígitos numéricos
        mostrarError('ad_celular', 'El celular debe contener 10 dígitos numéricos.');
        esValido = false;
    }

    // 7. Validación de Teléfono Fijo (ad_telefono) - Opcional
    const telefono = $("#ad_telefono").val().trim();
    if (telefono !== "" && !/^\d+$/.test(telefono)) {
        mostrarError('ad_telefono', 'El teléfono fijo solo debe contener números.');
        esValido = false;
    }
    
    // 8. Validación de Fecha de Nacimiento (ad_nacimiento)
    const nacimiento = $("#ad_nacimiento").val();
    if (nacimiento === "") {
        mostrarError('ad_nacimiento', 'La fecha de nacimiento es obligatoria.');
        esValido = false;
    } else {
        const fechaNacimiento = new Date(nacimiento);
        const fechaMinima = new Date('1920-01-01');
        const fechaActual = new Date();
        if (fechaNacimiento < fechaMinima || fechaNacimiento > fechaActual) {
            mostrarError('ad_nacimiento', 'La fecha de nacimiento no es válida.');
            esValido = false;
        }
    }

    return esValido;
}
