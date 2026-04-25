// Variable global para controlar la edición
let id_area_edicion = -1;

// 1. Carga el encabezado (input de texto y botón)
function gestion_areas() {
    $.ajax({
        type: "POST",
        url: "formulario_areas.php",
        dataType: "json",
        success: function (res) {
            if (res.status == 1) {
                $("#avance").html(res.html); // Coloca el input arriba
		// limpio los segmentos restantes del
		// formulario dinamico
		$("#grafica").html("");
		$("#tabla").html("");
                listar_tabla_areas();        // Carga la tabla abajo
            }
        }
    });
}

// 2. Carga la tabla de áreas
function listar_tabla_areas() {
    $.ajax({
        type: "POST",
        url: "listado_areas.php",
        dataType: "json",
        success: function (res) {
            if (res.status == 1) {
                $("#tabla").html(res.html);
            }
        }
    });
}

// 3. Guardar (Nuevo o Editar)
function guardar_area() {
    let nombre_area = $("#txt_nombre_area").val();
    
    if (nombre_area === "") {
        swal("Atención", "Escriba el nombre del área", "warning");
        return;
    }

    let url_final = (id_area_edicion === -1) ? "agregar_area.php" : "editar_area.php";
    let datos = { area: nombre_area };
    if (id_area_edicion !== -1) datos.id_area = id_area_edicion;

    $.ajax({
        type: "POST",
        url: url_final,
        data: datos,
        dataType: "json",
        success: function (res) {
            if (res.status == 1) {
                swal("Éxito", res.msj, "success");
                resetear_form_area();
                listar_tabla_areas();
            }
        }
    });
}

// 4. Preparar Edición
function preparar_edicion_area(id, nombre) {
    id_area_edicion = id;
    $("#txt_nombre_area").val(nombre);
    $("#btn_accion_area").text("Actualizar Área").removeClass("btn-outline-primary").addClass("btn-warning");
}

// 5. Eliminar
function eliminar_area_logica(id) {
    swal({
        title: "¿Eliminar esta área?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "eliminar_area.php",
                data: { id_area: id },
                dataType: "json",
		
                success: function (res) {
		    if (res.status == 1) {
			swal("Borrado", res.msj, "success");
			listar_tabla_areas();
		    } else {
			// Aquí se mostrará el mensaje: "No se puede eliminar: Esta área tiene materias..."
			swal("Operación no permitida", res.msj, "error");
		    }
		}
            });
        }
    });
}

function resetear_form_area() {
    $("#txt_nombre_area").val("");
    id_area_edicion = -1;
    $("#btn_accion_area").text("Agregar Área").removeClass("btn-warning").addClass("btn-outline-primary");
}
