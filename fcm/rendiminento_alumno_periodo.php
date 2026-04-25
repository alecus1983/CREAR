<?php

require_once ("datos.php");

$id_alumno = $_POST["id_alumno"];
$id_materia = $_POST["materia"];
$year = $_POST["year"];
$id_periodo = $_POST["periodo"];

 $estudiante = new alumnos($id_alumno);
 $cr = new materia();
$cr->get_materia($id_materia);

echo "<p>Datos estadisticos  del estudiante  ";
echo "<span class='text-muted'>".ucwords(strtolower($estudiante->nombres))." ".ucwords(strtolower($estudiante->apellidos))."<span>";
echo "en la materia <b>".$cr->materia."</b> en el periodo  <b>".$id_periodo."</b> </p>";

// creo un objeto de la clase clificaicones
$cal = new calificaciones();
// llamo al metodos
$rendimiento = $cal->get_rendimiento_alummno_periodo($id_alumno,$id_materia,$year,$id_periodo);
//print_r($rendimiento);

echo '<table>';
echo '<thead><th>Ponderado</th><th>requeridas</th><th>realizadas</th></thead>';
echo '<tbody>';


//explora el array
foreach ($rendimiento as $k => $red ){
    echo '<tr>';
    echo '<td>'.$red['ponderado'] . ' </td>';
    echo '<td>'.$red['por_periodo'] . ' </td>';
    echo '<td>'.$red['cantidad'] . ' </td>';
    echo '</tr>';
}

echo  '</tbody></table>';

?>
