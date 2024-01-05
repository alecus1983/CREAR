<?php 
//requiere los objetos
require('datos_pagos.php');

$nino = new matricula(2);
echo "prueba<br>";
echo "Codigo del alumno".$nino->id_alumno;
echo "<br>El codigo del grado es  :".$nino->id_grado

?>
