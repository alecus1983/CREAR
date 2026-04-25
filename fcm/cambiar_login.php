<?php

require_once("datos.php");

// listado de docentes
$lista = new docentes();

$docentes = $lista->get_total_docentes();
//muestro en pantalla//
//echo var_dump($docentes);

// creamos los elementos docentes
$docente = new docentes();
echo '<table>';
// ciclo de repeticion
foreach($docentes as $id_docente){

   
    // obtengo los datos del docente
    $docente->get_docente_id($id_docente);

    if ($docente->login !== ''){
        // elementos
        echo '<tr><td>'.$id_docente
            .'</td><td>'.$docente->nombres
            .'</td><td>'.$docente->login
            .'</td><td>'.password_hash($docente->login, PASSWORD_DEFAULT)
            .'</td></tr>';
    }
}
echo '</table>';


?>
