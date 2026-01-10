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