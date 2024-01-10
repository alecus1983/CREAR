<?php

$numero = 1;
$numero = $numero *2;
echo "El numero correcto es : $numero";
echo  "<br>La direccion del servidor es : ".$_SERVER['SERVER_ADDR'];
echo "<br>El nombre del servidor : ".$_SERVER['SERVER_NAME'];
echo "<br>Metodo : ".$_SERVER['REQUEST_METHOD'];
echo "<br>Cabecera :".$_SERVER['HTTP_HOST'];
echo "<br>Usuario :".$_SERVER['PHP_AUTH_USER'];

?>
