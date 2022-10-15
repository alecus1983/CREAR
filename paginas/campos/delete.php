<?php
require_once 'conexion.php';
//conexion con la base de datos

$link = conectar();	


// se  recupera el nombre por el método POST

//$year = $_GET["year"];

$tabla = $_GET['tabla'];
$codigo = $_GET['id'];

echo "\ntabla : $tabla";
echo "\nid : $codigo";

// se crea el texto de la consulta
$q1 = "DELETE FROM ".$tabla." WHERE id =".$codigo;  
echo "\nconsulta ".$q1."\n";		
//echo $q1;
// se realiza la  consulta en la base de datos
if (mysql_query($q1))
{ echo "\n se borro el registro con exito";
}
else {
   echo "Se preento un error al borrar el registro: ".mysql_error();
}


//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
//desconectar();


   

?>