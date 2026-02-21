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
                // coloco la respuesta en el div avance
                $("#avance").html(respuesta['html']);
		// limpio los segmentos restantes del
		// formulario dinamico
		$("#grafica").html("");
		$("#tabla").html("");
            } else {
                if (respuesta['status'] == 21) {
                    swal('Escolaridad', 'Porfavor seleccione una escolaridad del menú que se encuentra a la izquierda,  dentro de DATOS.', 'error');
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
 * Debes agregar un botón en tu tabla HTML: onclick="preparar_edicion_grado(id, 'codigo', 'nombre','promovido', 'formato_boletin')"
 */
function preparar_edicion_grado(id, codigo, nombre,promovido, formato_boletin) {
    // Asignamos los valores a los inputs (Asegúrate de corregir los IDs en listado_grados.php)
    // He asumido que cambiarás el primer input a id="codigo_grado" y el segundo a id="nombre_grado"
    $("#codigo_grado").val(codigo);
    $("#nombre_grado").val(nombre);
    $("#txt_nuevo_promovido").val(promovido);
    $("#formato_boletin").val(formato_boletin);
    
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
    let promovido = $("#txt_nuevo_promovido").val();
    let formato_boletin = $("#formato_boletin").val();

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
            nombre: nombre,
            promovido:promovido,
            formato_boletin: formato_boletin
        },
        success: function(respuesta) {
            if (respuesta['status'] == 1) {
                swal('Éxito', 'El grado ha sido actualizado', 'success');
                
                // Limpiar formulario y reiniciar estado
                $("#codigo_grado").val("");
                $("#nombre_grado").val("");
                $("txt_nuevo_promovido").val("");
               $("formato_boletin").val("");
               
               
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

// Función para agregar un nuevo grado
function agregar_grado() {
    
    // Obtenemos los valores del formulario
    // Nota: Asegúrate de que estos IDs existan en tu archivo listado_grados.php
    var codigo = $("#codigo_grado").val(); 
    var nombre = $("#nombre_grado").val();
    var promovido = $("#txt_nuevo_promovido").val(); 
    
    // Tomamos la escolaridad seleccionada en el menú lateral o formulario
    var id_escolaridad = $("#escolaridad").val(); 
    var nombre_escolaridad = $("#escolaridad option:selected").text();
    
    // Opcional: Input para formato boletin, si no existe enviamos 1 por defecto
    var formato = $("#txt_formato_boletin").length ? $("#txt_formato_boletin").val() : 1;

    // Validaciones
    if (id_escolaridad == "-1" || id_escolaridad == null) {
        swal('Atención', 'Por favor seleccione una escolaridad antes de agregar un grado', 'warning');
        return;
    }
    
    if (codigo.trim() == "" || nombre.trim() == "") {
        swal('Campos Vacíos', 'El código y el nombre del grado son obligatorios', 'error');
        return;
    }

    // Petición AJAX
    $.ajax({
        type: "POST",
        url: "guardar_nuevo_grado.php", // El archivo PHP creado en el paso 2
        dataType: "json",
        data: {
            grado: codigo,
            nombre_g: nombre,
            promovido: promovido,
            id_escolaridad: id_escolaridad,
            escolaridad: nombre_escolaridad,
            formato_boletin: formato
        },
        success: function(respuesta) {
            if (respuesta.status == 1) {
                swal('Éxito', respuesta.msg, 'success');
                
                // Limpiamos los campos
                $("#txt_nuevo_codigo").val("");
                $("#txt_nuevo_nombre").val("");
                $("#txt_nuevo_promovido").val("");
                
                // Recargamos la tabla de grados para ver el nuevo registro
                gestionar_grados();
            } else {
                swal('Error', respuesta.msg, 'error');
            }
        },
        error: function(xhr, status) {
            swal('Error', 'Hubo un problema de conexión', 'error');
            console.log(xhr);
        }
    });
}

// Función para eliminar un grado con confirmación
function del_grado(id_grado) {
    
    // Usamos SweetAlert para confirmar la acción
    swal({
        title: "¿Está seguro?",
        text: "Una vez eliminado, no podrá recuperar este grado. ¿Desea continuar?",
        icon: "warning",
        buttons: ["Cancelar", "Sí, eliminar"],
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            // Si el usuario confirma, procedemos con AJAX
            $.ajax({
                type: "POST",
                url: "eliminar_grado.php",
                dataType: "json",
                data: {
                    id_grado: id_grado
                },
                success: function(respuesta) {
                    if (respuesta.status == 1) {
                        swal("Eliminado!", respuesta.msg, "success");
                        // Recargamos la tabla para ver los cambios
                        gestionar_grados(); 
                        
                        // Si estabas editando ese grado, limpiamos el formulario
                        if (typeof id_grado_edicion !== 'undefined' && id_grado_edicion == id_grado) {
                            $("#codigo_grado").val("");
                            $("#nombre_grado").val("");
                            $("#txt_nuevo_promovido").val("");
                            $("#formato_boletin").val("");
                            id_grado_edicion = -1;
                            $("#btn_accion_grado").text("Agregar/Actualizar");
                            $("#btn_accion_grado").removeClass("btn-success").addClass("btn-outline-success");
                        }

                    } else {
                        swal("Error", respuesta.msg, "error");
                    }
                },
                error: function(xhr, status) {
                    swal("Error de conexión", "No se pudo comunicar con el servidor.", "error");
                    console.log(xhr);
                }
            });
        } else {
            // Usuario canceló
            swal("Operación cancelada", "El grado está a salvo :)", "info");
        }
    });
}


