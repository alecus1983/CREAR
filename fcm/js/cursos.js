let id_curso_edicion = -1;

// 1. Carga el formulario (input y botón) en #avance
function gestion_cursos() {
    $.ajax({
        type: "POST",
        url: "formulario_cursos.php",
        dataType: "json",
        success: function (res) {
            if (res.status == 1) {
                $("#avance").html(res.html);
                listar_tabla_cursos(); // Carga la tabla automáticamente
            }
        }
    });
}

// 2. Lista los cursos en #tabla
function listar_tabla_cursos() {
    $.ajax({
        type: "POST",
        url: "listado_cursos.php",
        dataType: "json",
        success: function (res) {
            if (res.status == 1) {
                $("#tabla").html(res.html);
            }
        }
    });
}

// 3. Guardar (Agregar o Editar)
function guardar_curso() {
    let nombre_curso = $("#txt_nombre_curso").val();
    let estado = $("#chk_activo_curso").is(':checked') ? 1 : 0;

    if (nombre_curso === "") {
        swal("Atención", "Escriba el nombre del curso", "warning");
        return;
    }

    let url_final = (id_curso_edicion === -1) ? "agregar_curso.php" : "editar_curso.php";
    let datos = { curso: nombre_curso, activo: estado };
    if (id_curso_edicion !== -1) datos.id_curso = id_curso_edicion;

    $.ajax({
        type: "POST",
        url: url_final,
        data: datos,
        dataType: "json",
        success: function (res) {
            if (res.status == 1) {
                swal("Éxito", res.msj, "success");
                resetear_form_curso();
                listar_tabla_cursos();
            }
        }
    });
}

// 4. Preparar Edición
function preparar_edicion_curso(id, nombre, activo) {
    id_curso_edicion = id;
    $("#txt_nombre_curso").val(nombre);
    $("#chk_activo_curso").prop('checked', activo == 1);
    $("#btn_accion_curso").text("Actualizar Curso").removeClass("btn-outline-primary").addClass("btn-warning");
}

// 5. Eliminar
function eliminar_curso_logica(id) {
    swal({
        title: "¿Eliminar este curso?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "eliminar_curso.php",
                data: { id_curso: id },
                dataType: "json",
                success: function (res) {
                    if (res.status == 1) {
                        swal("Borrado", "Curso eliminado correctamente", "success");
                        listar_tabla_cursos();
                    }
                }
            });
        }
    });
}

function resetear_form_curso() {
    $("#txt_nombre_curso").val("");
    $("#chk_activo_curso").prop('checked', true);
    id_curso_edicion = -1;
    $("#btn_accion_curso").text("Agregar Curso").removeClass("btn-warning").addClass("btn-outline-primary");
}
