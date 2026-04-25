<?php
require_once("datos.php");
$obj = new curso();
$ids = $obj->get_all(); // Ahora usamos el método de la clase

$html = '<table class="table table-striped table-hover mt-3 shadow-sm">';
$html .= '<thead class="table-dark"><tr><th>ID</th><th>Curso</th><th>Activo</th><th class="text-center">Acciones</th></tr></thead><tbody>';

foreach ($ids as $id) {
    $obj->get_curso_por_id($id);
    $estado = ($obj->activo == 1) ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-secondary">Inactivo</span>';
    $html .= "<tr>
                <td>{$obj->id_curso}</td>
                <td>{$obj->curso}</td>
                <td>{$estado}</td>
                <td class='text-center'>
                    <button class='btn btn-sm btn-warning' onclick=\"preparar_edicion_curso({$obj->id_curso}, '{$obj->curso}', {$obj->activo})\">Editar</button>
                    <button class='btn btn-sm btn-danger' onclick='eliminar_curso_logica({$obj->id_curso})'>Eliminar</button>
                </td>
              </tr>";
}
$html .= '</tbody></table>';
echo json_encode(["status" => 1, "html" => $html]);
