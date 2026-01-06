// avance semanal de notas de docentes
function avance_semanal() {

    // se invoca al metodo ajax para solicitar
    // el avance de notas semanales
    $.ajax({
        type: "POST",
        url: "notas_docentes_semanales.php",
        data: {
            years: $("#years").val(),
            periodo: $("#periodos").val(),
            semana: $("#semana").val()
        },
        // si los datos son correctos entonces ...
        success: function(respuesta) {

            // si el reaultado es positivo retorna un
            // documento con el avance
            $("#avance").html(respuesta);

        },
        error: function(xhr, status) {
            swal('Disculpe, existió un problema');
            console.log(xhr);
        }
    });

}

// avance semanal de notas de docentes
function notas_faltantes() {
    // se invoca al metodo ajax para solicitar
    //  el listado de calificaciones faltantes
    $.ajax({
        type: "POST",
        url: "listado_calificaciones_faltantes.php",
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
        success: function(respuesta) {

            //$("#calificador").html(respuesta);
            $("#avance").html(respuesta);

        },
        error: function(xhr, status) {
            swal('Disculpe, existió un problema');
            console.log(xhr);
        }
    });

}


// carga una lista de notas generada para un estudiante
function listado_notas_estudiantes() {

    // se invoca al metodo ajax para solicitar
    // el listado de estudiantes
    $.ajax({
        type: "POST",
        url: "listado_notas_alumno_periodo.php",
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
        success: function(respuesta) {
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
                if (respuesta['status'] == 25) {
                    swal('Materia', 'Porfavor seleccione una mareria', 'error');
                }

            }
        },
        error: function(xhr, status) {
            swal('Disculpe, existió un problema');
            console.log(xhr);
        }
    });

}



// busca las  notas de un alumno 
function find_nota_alumno() {

    // se invoca al metodo ajax para solicitar
    // el listado de estudiantes
    $.ajax({
        type: "POST",
        url: "find_nota_alumno.php",
        dataType: "json",
        data: {
            years: $("#years").val(),
            periodo: $("#periodos").val(),
            semana: $("#semana").val(),
            id_g: $("#id_g").val(),
            id_ms: $("#id_ms").val(),
            id_jornada: $("#jornada").val(),
            id_curso: $("#id_c").val(),
            id_alumno: $("#id_alumno").val()
        },
        // si los datos son correctos entonces ...
        success: function(respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {
                //swal('Datos actualizados');
                //swal('Actualizacion','Se insertaron los dastos con éxito','success');
                $("#tabla").html(respuesta['html']);
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
                if (respuesta['status'] == 28) {
                    swal('Alumno', 'Porfavor seleccione un alumno', 'error');
                }
            }
        },
        error: function(xhr, status) {
            swal('Disculpe, existió un problema');
            console.log(xhr);
        }
    });

}