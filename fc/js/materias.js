// Variable global para edición
let id_materia_edicion = -1;

// 0. obtener la lista de areas 
function gestion_materia_area() {
    $.ajax({
        type: "POST",
        url: "listado_materias_area.php",
        dataType: "json",
        data: {
            // Puedes pasar filtros si es necesario, ej: id_area
            id_area: $("#filtro_area").val() 
        },
        success: function (respuesta) {
            if (respuesta['status'] == 1) {
		//agrego el resultado al div avance
                $("#avance").html(respuesta['html']);
            } else {
                swal('Error', 'No se pudieron cargar las materias', 'error');
            }
        },
        error: function (xhr) {
            swal('Error', 'Error de conexión al cargar materias');
        }
    });
}


// 1. Listar materias en el contenedor principal
function gestion_materia() {

    let datos = {
        id_area: $("#filtro_area").val()
    };
    
    $.ajax({
        type: "POST",
        url: "listado_materias.php",
        dataType: "json",
        data:  datos,
        success: function (respuesta) {
            if (respuesta['status'] == 1) {
		//agrego el resultado al div avance
                $("#avance").html(respuesta['html']);
		// limpio los segmentos restantes del
		// formulario dinamico
		$("#grafica").html("");
		$("#tabla").html("");
            } else {
                swal('Error', 'No se pudieron cargar las materias', 'error');
            }
        },
        error: function (xhr) {
            swal('Error', 'Error de conexión al cargar materias');
        }
    });
}

// 2. Cargar datos en el formulario para editar
function preparar_edicion_materia(id, nombre, id_area, ih) {
    $("#nombre_materia").val(nombre);
    $("#id_area_materia").val(id_area);
    $("#ih_materia").val(ih);
    
    id_materia_edicion = id;

    // Cambiar el botón a modo edición
    $("#btn_accion_materia").text("Actualizar Materia");
    $("#btn_accion_materia").removeClass("btn-outline-primary").addClass("btn-warning");
    $("#btn_accion_materia").attr("onclick", "ejecutar_edicion_materia()");
    $('html, body').animate({ scrollTop: 0 }, 'fast');
}

// 3. Ejecutar la actualización (Update)
function ejecutar_edicion_materia() {
    let datos = {
        id_materia: id_materia_edicion,
        materia: $("#nombre_materia").val(),
        id_area: $("#filtro_area").val(),
        ih: $("#ih_materia").val()
    };

    if (datos.materia.trim() == "") {
        swal('Atención', 'El nombre de la materia es obligatorio', 'warning');
        return;
    }

    $.ajax({
        type: "POST",
        url: "edit_materia.php",
        dataType: "json",
        data: datos,
        success: function(res) {
            if (res.status == 1) {
                swal('Éxito', 'Materia actualizada', 'success');
                resetear_formulario_materia();
                gestion_materia();
            }
        }
    });
}

// 4. Guardar nueva materia (Insert)
function agregar_materia() {
    let datos = {
        materia: $("#nombre_materia").val(),
        id_area: $("#filtro_area").val(),
        ih: $("#ih_materia").val()
    };

    $.ajax({
        type: "POST",
        url: "guardar_nueva_materia.php",
        dataType: "json",
        data: datos,
        success: function(res) {
            if (res.status == 1) {
                swal('Creado', 'Materia registrada con éxito', 'success');
                resetear_formulario_materia();
                gestion_materia();
            }
        }
    });
}

// 5. Eliminar materia
function del_materia(id_materia) {
    swal({
        title: "¿Eliminar materia?",
        text: "Confirme que desea borrar esta asignatura",
        icon: "warning",
        buttons: ["Cancelar", "Eliminar"],
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "eliminar_materia.php",
                dataType: "json",
                data: { id_materia: id_materia },
                success: function(res) {
                    if (res.status == 1) {
                        swal("Eliminado", "La materia ha sido borrada", "success");
                        gestion_materia();
                    }
                }
            });
        }
    });
}

// 6. Función auxiliar para limpiar interfaz
function resetear_formulario_materia() {
    $("#nombre_materia").val("");
    $("#ih_materia").val("");
    id_materia_edicion = -1;
    $("#btn_accion_materia").text("Agregar Materia");
    $("#btn_accion_materia").removeClass("btn-warning").addClass("btn-outline-primary");
    $("#btn_accion_materia").attr("onclick", "agregar_materia()");
}

// 7. Funcion para cargar la tabla de materias
function materias_area(){

    let datos = {
        area: $("#areas").val()
    };

    // metodo ajax para obtener los datos
    $.ajax({
        type: "POST",
        url: "listado_materias_area.php",
        dataType: "json",
        data: datos,
        success: function(res) {
            if (respuesta['status'] == 1) {
		//agrego el resultado al div avance
                $("#tabla").html(respuesta['html']);
            } else {
                swal('Error', 'No se pudieron cargar las materias', 'error');
            }
        }
    });

    

    
}
