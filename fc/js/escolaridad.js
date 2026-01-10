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
	valor = element[0];
	texto = element[1];
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

/**
 * Pone los datos de la fila seleccionada en el formulario para editar.
 * @param {int} id - El ID de la escolaridad
 * @param {string} nombre - El nombre actual de la escolaridad
 */
function preparar_edicion_escolaridad(id, nombre) {
    // Asignamos los valores a los inputs (Asegúrate de actualizar los IDs en tu HTML, ver punto 4)
    $("#txt_id_escolaridad").val(id);
    $("#txt_nombre_escolaridad").val(nombre);
    
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
    var id = $("#txt_id_escolaridad").val();
    var nombre = $("#txt_nombre_escolaridad").val();

    // Validamos
    if (nombre.trim() === "") {
        swal("Atención", "El nombre es obligatorio", "warning");
        return;
    }
    if (id.trim() === "") {
        swal("Atención", "Seleccione un registro de la lista para editar", "warning");
        return;
    }

    // Petición AJAX
    $.ajax({
        type: "POST",
        url: "guardar_escolaridad.php", // El archivo que creamos en el paso 2
        dataType: "json",
        data: {
            id_escolaridad: id,
            nombre_escolaridad: nombre
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
