<?php
// archivo de configuracion  de objetos
require_once("datos.php");

//variables recibidas mediante POST
$valido = true;
$err = "";

$matriculas = new matricula_docente();
$matriculas->listado_docentes(2023);

echo '<table class="table"><thead>';
echo '<tr>';  
echo '<th scope="col">Docente</th>';
echo '<th scope="col">Cedula</th>';
echo '<th scope="col">Contraseña</th>';
echo '</tr></thead><tbody>';  
foreach($matriculas->listado_docentes as $d){
    echo '<tr>';  
    $docente = new docentes();
    $docente->get_docente_id($d);
    echo "<td>".ucwords(strtolower($docente->nombres))." ".ucwords(strtolower($docente->apellidos))."</td>";
    
    echo '<td>'.$docente->cedula.'</td>';

    echo '<td>'.$docente->login.'</td>';
    echo '</tr>';  


}

echo "</tbody></table>";


  
//$lista = new $matriculas();
?>
