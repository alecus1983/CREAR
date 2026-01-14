// Funcion para mostrar jornadas
function  gestionar_jornada(){
    
    // metodo ajax
    $.ajax({
        type: "POST",
        url: "listado_jornada.php",
        dataType: "json",
        data: {
            
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

// Función para enviar los datos al servidor (AJAX)
function guardar_jornada() {
    var id = $("#txt_id_jornada").val(); // Ojo: he cambiado el ID para diferenciarlo
    var nombre = $("#txt_nombre_jornada").val();

    if (nombre.trim() === "") {
        swal("Atención", "El nombre de la jornada es obligatorio", "warning");
        return;
    }

    $.ajax({
        type: "POST",
        url: "edit_jornada.php",
        dataType: "json",
        data: {
            id_jornada: id,
            nombre_jornada: nombre
        },
        success: function (respuesta) {
            if (respuesta.status == 1) {
                swal("Éxito", respuesta.msg, "success");
                // Recargamos la lista para ver los cambios
                gestionar_jornada(); 
            } else {
                swal("Error", respuesta.msg, "error");
            }
        },
        error: function (xhr, status) {
            swal("Error", "Hubo un problema de conexión", "error");
            console.log(xhr);
        }
    });
}

// Función que toma los datos de la fila seleccionada y los pone en los inputs
function preparar_edicion(id, nombre) {
    $("#txt_id_jornada").val(id);
    $("#txt_nombre_jornada").val(nombre);
    // Cambiamos el color para indicar que se está editando
    $("#txt_nombre_jornada").css("background-color", "#e8f0fe");
    $("#txt_nombre_jornada").focus();
}

// --- 1. Declarar la variable global para controlar el estado ---
let id_jornada_actual = 0; 

/**
 * Función para agregar o actualizar una jornada
 */
function agregar_jornada() {
    // 2. Usar la variable global en lugar del input hidden
    var id = id_jornada_actual; 
    var nombre = $("#txt_nombre_jornada").val();

    // Validación básica
    if (nombre.trim() === "") {
        swal("Campo Requerido", "Por favor escriba el nombre de la jornada", "warning");
        $("#txt_nombre_jornada").css('border-color', 'red');
        return;
    }

    // Petición AJAX
    $.ajax({
        type: "POST",
        url: "add_jornada.php",
        dataType: "json",
        data: {
            id_jornada: id, // Enviamos el valor de la variable JS
            jornada: nombre
        },
        success: function(respuesta) {
            if (respuesta.status == 1) {
                swal('¡Excelente!', respuesta.msg, 'success');
                
                // --- 3. IMPORTANTE: Resetear la variable y el formulario ---
                id_jornada_actual = 0; // Volvemos a 0 para que la próxima vez sea una inserción
                $("#txt_nombre_jornada").val("");
                $("#txt_nombre_jornada").css("background-color", "white"); // Quitar color de edición

                // Recargar la tabla
                gestionar_jornada();
            } else {
                swal('Error', respuesta.msg, 'error');
            }
        },
        error: function(xhr, status) {
            swal('Error de conexión', 'No se pudo procesar la solicitud', 'error');
            console.log(xhr);
        }
    });
}

/**
 * Función para cargar los datos en los inputs para editar
 */
function preparar_edicion(id, nombre) {
    // --- 4. Asignar el ID que viene de la tabla a nuestra variable JS ---
    id_jornada_actual = id;
    
    $("#txt_nombre_jornada").val(nombre);
    
    // Efecto visual
    $("#txt_nombre_jornada").focus();
    $("#txt_nombre_jornada").css("background-color", "#e8f0fe");

    // Cambiamos visualmente el botón de agregar para que indique "Actualizar"
   
    $("#btn_accion_jornada").text("Guardar Cambios");
    $("#btn_accion_jornada").removeClass("btn-outline-success").addClass("btn-success");
    $("#btn_accion_jornada").attr("onclick", "ejecutar_edicion_jornada()");
    
    // Hacemos scroll hacia arriba para ver el formulario
    $('html, body').animate({ scrollTop: 0 }, 'fast');
}


/**
 * Función B: Envía los datos modificados al servidor (AJAX)
 */
function ejecutar_edicion_jornada() {
    
    // 1. Obtener datos
    let jornada = $("#txt_nombre_jornada").val();
    // USAR LA VARIABLE GLOBAL DE JORNADA
    let id = id_jornada_actual; 

    // 2. Validaciones corregidas
    if (id == 0 || id == null) {
        swal('Error', 'No se ha seleccionado una jornada para editar', 'error');
        return;
    }
    if (jornada.trim() == "" ) {
        swal('Campos vacíos', 'Por favor complete el nombre de la jornada', 'warning');
        return;
    }

    $.ajax({
        type: "POST",
        url: "edit_jornada.php", 
        dataType: "json",
        data: {
            id_jornada: id, // <--- IMPORTANTE: Enviar el ID
            jornada: jornada
        },
        success: function(respuesta) {
            if (respuesta['status'] == 1) {
                swal('Éxito', respuesta.msg, 'success'); // Usar mensaje del servidor
                
                // Limpiar formulario
                $("#txt_nombre_jornada").val("");
                $("#txt_nombre_jornada").css("background-color", "white");
               
                // Reiniciar variable global
                id_jornada_actual = 0;
                
                // Restaurar botón a estado "Agregar"
                $("#btn_accion_jornada").text("Agregar / Actualizar");
                $("#btn_accion_jornada").removeClass("btn-success").addClass("btn-outline-success");
                
                // IMPORTANTE: Volver a apuntar a la función de agregar lógica
                // Nota: Tu código tenía 'agregar_jornada()' arriba, asegúrate de que esa es la que quieres usar.
                $("#btn_accion_jornada").attr("onclick", "agregar_jornada()"); 

                // Recargar la tabla correcta
                gestionar_jornada(); // <--- Corregido (antes decía gestionar_grados)
            } else {
                swal('Error', respuesta.msg, 'error');
            }
        },
        error: function(xhr, status) {
            swal('Error', 'Fallo de conexión con el servidor', 'error');
            console.log(xhr);
        }
    });
}

function eliminar_jornada(id) {
    // 1. Solicitamos confirmación al usuario
    swal({
        title: "¿Estás seguro?",
        text: "Una vez eliminada, no podrás recuperar esta jornada. Asegúrate de que no haya alumnos matriculados en ella.",
        icon: "warning",
        buttons: ["Cancelar", "Eliminar"],
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            // 2. Si confirma, hacemos la petición AJAX
            $.ajax({
                type: "POST",
                url: "del_jornada.php",
                dataType: "json",
                data: {
                    id: id
                },
                success: function(respuesta) {
                    if (respuesta.status == 1) {
                        swal("¡Eliminado!", respuesta.msg, "success");
                        // 3. Recargamos la tabla
                        gestionar_jornada();
                    } else {
                        swal("Error", respuesta.msg, "error");
                    }
                },
                error: function(xhr, status) {
                    swal("Error", "No se pudo conectar con el servidor", "error");
                    console.log(xhr);
                }
            });
        }
    });
}