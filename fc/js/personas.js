//
// Funciones relacionadas con la gestion de personas
//
// gestion_personas -> actualiza los datos de una persona
// cambio_datos-> lista las personas a partir de un criterio de busqueda
// formulario_agregar_persona -> crea un formaulario para agregar una persona
// agregar_persona-> se agrega una persona
// datos_persona -> 
//
///////////////////////////////////////////////////////////////////////

// funcion que llama el formulario de gestionar las
// semas
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

// funcion que muestra listado de personas que  coinciden con los datos

function cambio_datos(repo) {

    // se invoca al metodo ajax para solicitar
    // el listado de personas
    $.ajax({
        type: "POST",
        url: "cambio_datos.php",
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
                //swal('Datos actualizados');
                //$("#calificador").html(respuesta);
                $(repo).html(respuesta['html']);
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


// formulario para agregar personas
function formulario_agregar_persona() {
    //  realizo la consulta en de los datos
    $("#tabla").html("");
    //  cargo el formulario para agregar personas
    $("#tabla").load("formulario_agregar_persona.html", function (response, status, xhr) {
        if (status == "error") {
            console.error("Error al cargar ");
            swal("Error", "Error a cargar pagina ");
        }
        else {
            console.log("Formulario cargado correctamete");
        }
    });

}

// funcion para agregar personas
function agregar_persona(formulario) {

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
                //swal('Datos actualizados');
                swal('Actualizacion', 'Se agrego a la persona correctamente', 'success');

                switch (formulario) {
                    case 1:

                        break;

                    case 2:

                        persona["nombres"] = respuesta["nombres"];
                        persona["apellidos"] = respuesta["apellidos"];
                        persona["identificacion"] = respuesta["idetificacion"];
                        // tomo como persona seleccionada la presona 
                        // retornada
                        seleccionar_persona(respuesta["id_persona"]);
                        // voy al formulario cuatro
                        gestion_matriculas(4)

                        break;
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

// funcion para acutualizar los datos una persona
// require datos_persona.php
// requere actualizar_persona()
function actualizar_persona() {

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


// funcion que solicitar datos de la persona
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

// permite eliminar una persona
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

// funcion que permite seleccionar una persona en 
// el formaulario
function seleccionar_persona(id) {
    //  cargo el los datos de la persona
    persona["id_persona"] = id;
    // los muestro
    swal("seleccion", "Se selecciono la persona " + persona["id_persona"], 'success');
    // voy al formulario 4 de matriculas
    gestion_matriculas(4);
}


// funcion que obtiene los datos de direccion
// el estrato y el barrio
// require el codigo de la persona
// y el codigo del formulario

function get_direccion(id, form) {

    // solicito datos en ajax
    $.ajax({
        type: "POST",
        url: "direccion_persona.php",
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
                        $("#paginas").load("formulario_actualizar_direccion.html", function () {
                            // obtengo el valor de la direccion
                            $("#ac_direccion").val(respuesta["direccion_residencia"]);
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

// actualizar direccion
function update_direccion(form) {

    // tomo el dato
    persona["estrato"] = $("#ac_estrato").val();
    // tomo el dato dle barrio
    persona["barrio"] = $("#ac_barrio").val();
    // tomo el id
    persona["direccion_residencia"] = $("#ac_direccion").val();

    // solicito datos en ajax
    $.ajax({
        type: "POST",
        url: "actualizar_persona_direccion.php",
        dataType: "json",
        data: persona,
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
                        swal("actualizacion dirección","se actualizo con exito la dirección", "success");
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
                        $("#paginas").load("formulario_actualizar_afiliacion.html", function () {
                            // obtengo el valor de la direccion
                            $("#ac_direccion").val(respuesta["direccion_residencia"]);
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