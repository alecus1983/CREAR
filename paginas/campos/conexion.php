<?php
// esta funcion se encarga de conectar la base de datos con la
// aplicacion PHP


function conectar()

{

// Dirección o IP del servidor MySQL
$host = "localhost";
 
// Puerto del servidor MySQL
$puerto = "3306";
 
// Nombre de usuario del servidor MySQL
$usuario = "imcrea_admin";
 
// Contraseña del usuario
$contrasena = "Caracter15";
 
// Nombre de la base de datos
$baseDeDatos ="imcrea_data";

//echo $host." - ".$puerto." - ".$usuario." - ".$contrasena." - ".$baseDeDatos;


    
    if (!($link = mysqli_connect($host, $usuario, $contrasena , $baseDeDatos))) 
    { 
        //echo "Error conectando a la base de datos.<br>"; 
        exit(); 
    }
    else
    {
        //echo "Listo, estamos conectados.<br>";
    }
    if (!mysqli_select_db($link, $baseDeDatos)) 
    { 
        //echo "Error seleccionando la base de datos.<br>"; 
        exit(); 
    }
    else
    {
        //echo "Obtuvimos la base de datos $baseDeDatos sin problema.<br>";
    }
    return $link;
    return 0;
} 


    function desconectar($conexion){
            //Cierra la conexi�n y guarda el estado de la operaci�n en una variable
            $close = mysqli_close($conexion);
            //Comprobamos si se ha cerrado la conexi�n correctamente
            if(!$close){
               echo 'Ha sucedido un error inexperado en la desconexion de la base de datos<br>';
            }
            //devuelve el estado del cierre de conexi�n
            return $close;
    }


?>
