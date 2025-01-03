//fucion de carga incial
function load_semanas() {
    //  variable periodo
    var periodo = $("#periodos").val();
    // variable año
    var year = $("#years").val();

    // carga en un selector  de semanas
    carga("#semana", "load_semanas.php", {
        periodo: periodo,
        year: year
    });
}


// funcion para eliminar  semanas de las vijentes para
// el presente año

function eliminar_semana() {
    // se invoca al metodo ajax para solicitar
    // el listado de las semanas
    $.ajax({
        type: "POST",
        url: "eliminar_semana.php",
        dataType: "json",
        data: {
            semana: $("#lista_semanas").val()
        },
        // si los datos son correctos entonces ...
        success: function (respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {
                gestion_semanas();
                swal("Completado", "Se actualizo la semana", "success");
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


// funcion que cambia semanas
function actualizar_semana() {
    // se invoca al metodo ajax para solicitar
    // el listado de las semanas
    $.ajax({
        type: "POST",
        url: "actualizar_semana.php",
        dataType: "json",
        data: {
            years: $("#years").val(),
            inicio: $("#inicio").val(),
            fin: $("#fin").val(),
            semana: $("#lista_semanas").val()
        },
        // si los datos son correctos entonces ...
        success: function (respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {
                //swal('Datos actualizados');
                //$("#calificador").html(respuesta);
                //$("#avance").html(respuesta['html']);
                gestion_semanas();
                swal("Completado", "Se actualizo la semana", "success");
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

// funcion que llama el formulario de gestionar las
// semas
function gestion_semanas() {

    // se invoca al metodo ajax para solicitar
    // el listado de las semanas
    $.ajax({
        type: "POST",
        url: "listado_semanas.php",
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




