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