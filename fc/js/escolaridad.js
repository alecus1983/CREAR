// agrega las escolaridades disponibles disponibles
// al campo select id
function lista_escolaridad(id) {

  // solicito la lista de escolaridad

  $.ajax({
    type: "POST",
    async: false,
    url: "lista_escolaridad.php",
    data: {
      id: id
    },

    success: function (respuesta) {

      // si se realizo la respuesta
      // almaceno la respuesta en la variable res
      res = JSON.parse(respuesta);

      //  agrego la primera opcion al combo
      $(id).append("<option value = -1>seleccione</option>");

      res.forEach((element) => {
	console.log(element)
	valor = element["id_escolaridad"];
	texto = element["escolaridad"];
	  $(id).append("<option value = " + valor + ">" + texto + "</option>");
      });

    },
    error: function (xhr, status) {
      swal('Disculpe, existió un problema' + status);
      console.log(xhr);
    }

  });

}


// Funcion para mostrar los grados creados
function  gestionar_escolaridad(){
    
    // metodo ajax
    $.ajax({
        type: "POST",
        url: "listado_escolaridad.php",
        dataType: "json",
        data: {
            
        },
        // si los datos son correctos entonces ...
        success: function (respuesta) {
            // si la respuesta es positiva
            if (respuesta['status'] == 1) {
                //coloco el contenido en el div avance
                $("#avance").html(respuesta['html']);
		// limpio los segmentos restantes del
		// formulario dinamico
		$("#grafica").html("");
		$("#tabla").html("");

		
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


let id_escolaridad_etitar = -1;
/**
 * Pone los datos de la fila seleccionada en el formulario para editar.
 * @param {int} id - El ID de la escolaridad
 * @param {string} nombre - El nombre actual de la escolaridad
 */
function preparar_edicion_escolaridad(id, nombre) {
    // Asignamos los valores a los inputs (Asegúrate de actualizar los IDs en tu HTML, ver punto 4)
    //$("#txt_id_escolaridad").val(id);
    $("#txt_nombre_escolaridad").val(nombre);

    id_escolaridad_etitar = id;

    // cambio el texto del boton accion_escolaridad
    $("#btn_accion_escolaridad").text("Guardar cambios");
    $("#btn_accion_escolaridad").attr("onclick", "actualizar_escolaridad();");
    
    // Cambiamos el color o hacemos focus para indicar que se está editando
    $("#txt_nombre_escolaridad").focus();
    
    // Opcional: Desplazarse hacia arriba si el formulario está lejos
    $('html, body').animate({
        scrollTop: $("#txt_nombre_escolaridad").offset().top - 100
    }, 500);
}

/**
 * Envía los datos modificados al servidor para actualizar.
 */
function actualizar_escolaridad() {
    // Obtenemos los valores
    var nombre = $("#txt_nombre_escolaridad").val();

    // Validamos
    if (nombre.trim() === "") {
        swal("Atención", "El nombre es obligatorio", "warning");
        return;
    }
     if (id_escolaridad_etitar.trim() === "") {
         swal("Atención", "Seleccione un registro de la lista para editar", "warning");
         return;
     }

    // Petición AJAX
    $.ajax({
        type: "POST",
        url: "guardar_escolaridad.php", // El archivo que creamos en el paso 2
        dataType: "json",
        data: {
            //id_escolaridad: id,
            nombre_escolaridad: nombre,
            id_escolaridad : id_escolaridad_etitar
        },
        success: function (respuesta) {
            if (respuesta.status == 1) {
                swal("Éxito", respuesta.msg, "success");
                
                // Recargamos la lista para ver los cambios
                gestionar_escolaridad(); 
            } else {
                swal("Error", respuesta.msg, "error");
            }
        },
        error: function (xhr, status) {
            swal("Error", "Problema de conexión con el servidor", "error");
            console.log(xhr);
        }
    });
}

// Función para agregar una nueva escolaridad
function agregar_escolaridad() {
    
    // Obtenemos el valor del input del formulario
    var nombre = $("#txt_nombre_escolaridad").val();
    
    // Validación básica
    if (nombre.trim() === "") {
        swal("Campo Vacío", "Por favor escriba el nombre de la escolaridad antes de agregar.", "warning");
        $("#txt_nombre_escolaridad").focus();
        return;
    }

    // Petición AJAX
    $.ajax({
        type: "POST",
        url: "agregar_escolaridad.php", // El archivo PHP creado en el paso 2
        dataType: "json",
        data: {
            nombre_escolaridad: nombre
        },
        success: function(respuesta) {
            if (respuesta.status == 1) {
                swal("Éxito", respuesta.msg, "success");
                
                // Limpiamos el campo
                $("#txt_nombre_escolaridad").val("");
                
                // Recargamos la tabla para ver el nuevo registro
                gestionar_escolaridad();
                
            } else {
                swal("Error", respuesta.msg, "error");
            }
        },
        error: function(xhr, status) {
            swal("Error de conexión", "No se pudo comunicar con el servidor.", "error");
            console.log(xhr);
        }
    });
}

// Función para eliminar una escolaridad
function eliminar_escolaridad(id_escolaridad) {

    // Solicitamos confirmación al usuario
    swal({
        title: "¿Está seguro?",
        text: "Una vez eliminada, no podrá recuperar esta escolaridad. ¿Desea continuar?",
        icon: "warning",
        buttons: ["Cancelar", "Sí, eliminar"],
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            // Si el usuario confirma, enviamos la petición AJAX
            $.ajax({
                type: "POST",
                url: "eliminar_escolaridad.php", // El archivo creado en el paso 2
                dataType: "json",
                data: {
                    id_escolaridad: id_escolaridad
                },
                success: function(respuesta) {
                    if (respuesta.status == 1) {
                        swal("¡Eliminado!", respuesta.msg, "success");
                        
                        // Si estábamos editando justo el que borramos, limpiamos el formulario
                        if (typeof id_escolaridad_etitar !== 'undefined' && id_escolaridad_etitar == id_escolaridad) {
                            $("#txt_nombre_escolaridad").val("");
                            id_escolaridad_etitar = -1;
                            $("#btn_accion_escolaridad").text("Agregar");
                            $("#btn_accion_escolaridad").attr("onclick", "agregar_escolaridad();");
                        }

                        // Recargamos la lista
                        gestionar_escolaridad();
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
            // El usuario canceló la acción
            swal("Cancelado", "El registro está a salvo.", "info");
        }
    });
}
