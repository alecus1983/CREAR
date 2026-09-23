
// funcion que muestra el listado de recuperaciones

function load_lista_recuperacion() {
    console.log('cargando recuperaiones');
    $.ajax({
        type: 'POST',
        url: 'listado_estudiantes_recuperacion.php',
        data: {
            years: $('#years').val(),
            id_g: $('#id_g').val(),
            id_ms: $('#id_ms').val(),
            id_jornada: $('#jornada').val(),
            periodo: $('#periodos').val(),
            curso: $('#id_c').val(),
            semana: $('#semana').val()
        },
        beforeSend: function () {
            $('#loader').show();
        },
        success: function (respuesta) {
            $('#calificador').html(respuesta);
            $('#loader').hide();
            //swal('Éxito', 'Lista de estudiantes cargada correctamente.', 'success');
        },
        error: function (xhr, status) {
            $('#loader').hide();
            swal('Error', 'Disculpe, existió un problema al cargar los estudiantes.', 'error');
            console.log(xhr);
        }
    });

}