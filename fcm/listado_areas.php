<?php
require_once("datos.php");
$obj = new area();
$ids = $obj->get_all();

$html = '<table class="table table-striped table-hover mt-3 shadow-sm">';
$html .= '<thead class="table-dark"><tr><th>ID</th><th>Nombre del Área</th><th class="text-center">Acciones</th></tr></thead><tbody>';

foreach ($ids as $id) {
    $obj->get_area($id);
    $nombre_escapado = addslashes($obj->area);
    $html .= "<tr>
                <td>{$obj->id_area}</td>
                <td>{$obj->area}</td>
                <td class='text-center'>
                    <button class='btn btn-sm btn-warning' onclick=\"preparar_edicion_area({$obj->id_area}, '{$nombre_escapado}')\">Editar</button>
                    <button class='btn btn-sm btn-danger' onclick='eliminar_area_logica({$obj->id_area})'>Eliminar</button>
                </td>
              </tr>";
}
$html .= '</tbody></table>';
echo json_encode(["status" => 1, "html" => $html]);
