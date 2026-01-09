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
