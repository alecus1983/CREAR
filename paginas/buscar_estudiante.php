<?php
// requiere la clase datos
require ('datos.php');

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];

echo "<br>nombre : <b>".$nombre." ".$apellido."</b><br>";

$persona = new alumnos();

echo $persona->buscar_estudiante($nombre, $apellido);


?>
