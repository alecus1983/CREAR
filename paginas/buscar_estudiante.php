<?php
// requiere la clase datos
require ('datos.php');
// atributos enviados
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$antiguedad = $_POST["antiguedad"];

echo "<br>Nombre : <b>".$nombre." ".$apellido." ";

// si se ingreso la antiguedad
if (isset($antiguedad)){
  // cuando la antiguedad es igual a cero
  // el estudiante es nuevo
  if($antiguedad == 0){
    echo " <font color=green>(nuevo)</font></b> <hr>";
  } elseif ($antiguedad == 1){
      echo " <font color=blue> (antiguo)</font> </b><hr>";
  }
}


$persona = new alumnos(0);
// metodo para la busqueda del estudiante
echo $persona->buscar_estudiante($nombre, $apellido);


?>
