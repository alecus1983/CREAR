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

// Variable global para saber qué grado se está editando
let id_grado_edicion = -1;

/**
 * Función A: Carga los datos de la fila seleccionada en el formulario superior.
 * Debes agregar un botón en tu tabla HTML: onclick="preparar_edicion_grado(id, 'codigo', 'nombre')"
 */
function preparar_edicion_grado(id, codigo, nombre) {
    // Asignamos los valores a los inputs (Asegúrate de corregir los IDs en listado_grados.php)
    // He asumido que cambiarás el primer input a id="codigo_grado" y el segundo a id="nombre_grado"
    $("#codigo_grado").val(codigo);
    $("#nombre_grado").val(nombre);
    
    // Guardamos el ID en la variable global
    id_grado_edicion = id;

    // Cambiamos visualmente el botón de agregar para que indique "Actualizar"
    // Nota: Deberás ponerle un ID al botón de agregar en listado_grados.php, ej: id="btn_accion_grado"
    $("#btn_accion_grado").text("Guardar Cambios");
    $("#btn_accion_grado").removeClass("btn-outline-success").addClass("btn-success");
    $("#btn_accion_grado").attr("onclick", "ejecutar_edicion_grado()");
    
    // Hacemos scroll hacia arriba para ver el formulario
    $('html, body').animate({ scrollTop: 0 }, 'fast');
}

/**
 * Función B: Envía los datos modificados al servidor (AJAX)
 */
function ejecutar_edicion_grado() {
    
    // Validaciones básicas
    let codigo = $("#codigo_grado").val();
    let nombre = $("#nombre_grado").val();

    if (id_grado_edicion == -1) {
        swal('Error', 'No se ha seleccionado un grado para editar', 'error');
        return;
    }
    if (codigo.trim() == "" || nombre.trim() == "") {
        swal('Campos vacíos', 'Por favor complete código y nombre', 'warning');
        return;
    }

    $.ajax({
        type: "POST",
        url: "edit_grado.php", 
        dataType: "json",
        data: {
            id_grado: id_grado_edicion,
            codigo: codigo,
            nombre: nombre
        },
        success: function(respuesta) {
            if (respuesta['status'] == 1) {
                swal('Éxito', 'El grado ha sido actualizado', 'success');
                
                // Limpiar formulario y reiniciar estado
                $("#codigo_grado").val("");
                $("#nombre_grado").val("");
                id_grado_edicion = -1;
                
                // Restaurar botón a estado "Agregar"
                $("#btn_accion_grado").text("Agregar/Actualizar");
                $("#btn_accion_grado").removeClass("btn-success").addClass("btn-outline-success");
                $("#btn_accion_grado").attr("onclick", "actualizar_semana()"); // O la función original que tenías para agregar

                // Recargar la tabla para ver cambios
                gestionar_grados(); 
            } else {
                swal('Error', 'No se pudo actualizar. Código error: ' + respuesta['status'], 'error');
            }
        },
        error: function(xhr, status) {
            swal('Error', 'Fallo de conexión con el servidor', 'error');
            console.log(xhr);
        }
    });
}


