<?php
require_once("datos.php");
$html = "
<div class='col-12 p-3 bg-white shadow-sm rounded border mb-3'>
    <h5>Gestión de Áreas Académicas</h5>
    <div class='row'>
        <div class='col-md-9'>
            <div class='form-floating'>
                <input type='text' id='txt_nombre_area' class='form-control' placeholder='Nombre del Área'>
                <label>Nombre del Área</label>
            </div>
        </div>
        <div class='col-md-3'>
            <button type='button' id='btn_accion_area' onclick='guardar_area()' class='btn btn-outline-primary w-100 h-100'>
                Agregar Área
            </button>
        </div>
    </div>
</div>";
echo json_encode(["status" => 1, "html" => $html]);
