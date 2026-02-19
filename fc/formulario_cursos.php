<?php
require_once("datos.php");
$html = "
<div class='col-12 p-3 bg-white shadow-sm rounded border mb-3'>
    <h5>Gestión de Cursos</h5>
    <div class='row g-2'>
        <div class='col-md-7'>
            <div class='form-floating'>
                <input type='text' id='txt_nombre_curso' class='form-control' placeholder='Nombre del Curso'>
                <label>Nombre del Curso (Ej: 10-01)</label>
            </div>
        </div>
        <div class='col-md-2 d-flex align-items-center justify-content-center'>
            <div class='form-check form-switch'>
                <input class='form-check-input' type='checkbox' id='chk_activo_curso' checked>
                <label class='form-check-label'>Activo</label>
            </div>
        </div>
        <div class='col-md-3'>
            <button type='button' id='btn_accion_curso' onclick='guardar_curso()' class='btn btn-outline-primary w-100 h-100'>
                Agregar Curso
            </button>
        </div>
    </div>
</div>";
echo json_encode(["status" => 1, "html" => $html]);
