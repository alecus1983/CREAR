$(document).ready(function() {
    // Event listeners for form changes
    $('#years, #periodos, #jornada, #id_g, #id_c').on('change', function() {
        loadMaterias();
    });

    $('#id_ms').on('change', function() {
        // Only load students when a full course is selected
        // We'll use a button click instead for a more explicit flow
    });

    // New button to explicitly load students
    $('#load-students-btn').on('click', function() {
        loadListaEstudiantes();
        $('#grade-entry-section').show();
    });

    // New button to save grades
    $('#save-grades-btn').on('click', function() {
        deposit();
    });

    // Function to load subjects based on selected criteria
    function loadMaterias() {
        const id_docente = $('#id_d').val();
        const id_grado = $('#id_g').val();
        const year = $('#years').val();
        carga('#id_ms', 'materias_grado.php', { grados: id_grado, id: id_docente, year: year });
    }

    // Function to load the list of students
    function loadListaEstudiantes() {
        $.ajax({
            type: 'POST',
            url: 'listado_estudiantes.php',
            data: {
                years: $('#years').val(),
                id_g: $('#id_g').val(),
                id_ms: $('#id_ms').val(),
                id_jornada: $('#jornada').val(),
                periodo: $('#periodos').val(),
                curso: $('#id_c').val(),
                semana: $('#semana').val()
            },
            beforeSend: function() {
                $('#loader').show();
            },
            success: function(respuesta) {
                $('#calificador').html(respuesta);
                $('#loader').hide();
                swal('Éxito', 'Lista de estudiantes cargada correctamente.', 'success');
            },
            error: function(xhr, status) {
                $('#loader').hide();
                swal('Error', 'Disculpe, existió un problema al cargar los estudiantes.', 'error');
                console.log(xhr);
            }
        });
    }

    // Function to save grades (similar to the original deposit function, but with better feedback)
    function deposit() {
        // ... (The validation and AJAX logic from the original deposit() function remains here)
        // ...
        if (valido) {
            $.ajax({
                type: 'POST',
                url: 'notas_semanales.php',
                data: {
                    // ... (Data payload remains the same)
                },
                beforeSend: function() {
                    $('#loader').show();
                },
                success: function(data) {
                    $('#loader').hide();
                    swal('Éxito', 'Se ingresaron las notas correctamente.', 'success');
                },
                error: function(xhr, status) {
                    $('#loader').hide();
                    swal('Error', 'Disculpe, existió un problema al guardar las notas.', 'error');
                    console.log(xhr);
                }
            });
        } else {
            swal('Revisar datos', 'No se ingresaron los datos porque hay notas mayores a 5.', 'error');
        }
    }
});
