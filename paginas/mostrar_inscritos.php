<?php
// requiere la clase datos
require ('datos.php');

$codigo = $_POST["codigo"];
// $codigo = 97;
// creo un objeto tipo inscripcion
$d = new inscripcion(0);
// obtengo los Datos
$data = $d->get_all($codigo);
echo json_encode($data);
//var_dump($d->get_all($codigo));
?>
