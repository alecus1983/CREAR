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

function cambio_datos() {

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
                $("#tabla").html(respuesta['html']);
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
function agregar_persona() {

    // envio datos 
    $.ajax({
        type: "POST",
        url: "add_persona.php",
        dataType: "json",
        data: {
            nombres: $("#ad_nombres").val(),
            apellidos: $("#ad_apellidos").val(),
            tipo_identificacion: $("#ad_tipo_identificacion").val(),
            identificacion: $("#ad_identificacion").val(),
            correo: $("#ad_correo").val(),
            i_correo: $("#ad_i_correo").val(),
            celular: $("#ad_celular").val(),
            telefono: $("#ad_telefono").val(),
            nacimiento: $("#ad_nacimiento").val()
        },
        // si los datos son correctos entonces ...
        success: function (respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {
                //swal('Datos actualizados');
                swal('Actualizacion', 'Se agrego a la persona correctamente', 'success');
                matricula_docente();
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
