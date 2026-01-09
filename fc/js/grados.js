function requisitos_grado() {

    // se invoca al metodo ajax para solicitar
    // el listado de estudiantes
    $.ajax({
        type: "POST",
        url: "listado_requisitos.php",
        dataType: "json",
        data: {
            years: $("#years").val(),
            id_g: $("#id_g").val(),
            id_ms: $("#id_materia_mt").val(),
            id_curso: $("#id_c").val(),
            periodo: $("#periodos").val(),
            id_jornada: $("#jornada").val(),
            semana: $("#semana").val()
        },
        // si los datos son correctos entonces ...
        success: function(respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {
                //swal('Datos actualizados');
                //$("#calificador").html(respuesta);
                $("#avance").html(respuesta['html']);
            } else {
                if (respuesta['status'] == 20) {
                    swal('Consulta', 'Fallo al intentar ingresar el requisito', 'error');
                }
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
            }
        },
        error: function(xhr, status) {
            swal('Disculpe, existió un problema');
            console.log(xhr);
        }
    });

}

function agregar_requisito() {

    // se invoca al metodo ajax para solicitar
    // el listado de estudiantes
    $.ajax({
        type: "POST",
        url: "add_requisitos.php",
        dataType: "json",
        data: {
            years: $("#years").val(),
            id_g: $("#id_g").val(),
            id_ms: $("#id_materia_mt").val(),
        },
        // si los datos son correctos entonces ...
        success: function(respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {
                swal('Actualizacion', 'Se insertaron los dastos con éxito', 'success');
                requisitos_grado();
            } else {
                if (respuesta['status'] == 20) {
                    swal('Consulta', 'Fallo al intentar ingresar el requisito', 'error');
                }
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
            }
        },
        error: function(xhr, status) {
            swal('Disculpe, existió un problema');
            console.log(xhr);
        }
    });

}


function eliminar_requisitos(id_materia, id_grado) {

    // se invoca al metodo ajax para solicitar
    // el listado de estudiantes
    $.ajax({
        type: "POST",
        url: "del_requisito.php",
        dataType: "json",
        data: {
            years: $("#years").val(),
            id_g: id_grado,
            id_ms: id_materia,
        },
        // si los datos son correctos entonces ...
        success: function(respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {
                swal('Actualizacion', 'Se elimino los requisitos con éxito', 'success');
                requisitos_grado();
            } else {
                if (respuesta['status'] == 20) {
                    swal('Consulta', 'Fallo al intentar ingresar el requisito', 'error');
                }
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
            }
        },
        error: function(xhr, status) {
            swal('Disculpe, existió un problema');
            console.log(xhr);
        }
    });

}

// funcion que obtiene los requisitos del grado 
function eliminar_grado() {

    // se invoca al metodo ajax para solicitar
    // el listado de estudiantes
    $.ajax({
        type: "POST",
        url: "del_requisito.php",
        dataType: "json",
        data: {
            years: $("#years").val(),
            id_g: $("#id_g").val(),
            id_ms: $("#id_ms").val(),


        },
        // si los datos son correctos entonces ...
        success: function(respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {
                swal('Actualizacion', 'Se eliminaron los dastos con éxito', 'success');
                requisitos_grado();
            } else {
                if (respuesta['status'] == 20) {
                    swal('Consulta', 'Fallo al intentar ingresar el requisito', 'error');
                }
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
            }
        },
        error: function(xhr, status) {
            swal('Disculpe, existió un problema');
            console.log(xhr);
        }
    });

}

// Funcion para mostrar los grados creados
function  gestionar_grados(){
    
    // metodo ajax
    $.ajax({
        type: "POST",
        url: "listado_grados.php",
        dataType: "json",
        data: {
            escolaridad: $("#escolaridad").val()
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
                    swal('Escolaridad', 'Porfavor seleccione la escolaridad', 'error');
                }
            }
        },
        error: function (xhr, status) {
            swal('Disculpe, existió un problema');
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


