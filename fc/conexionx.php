<?php
// esta funcion se encarga de conectar la base de datos con la
// aplicacion PHP

function conectar(){
            // variable que almacena la url del servidor
            $server = "localhost";
            // variable que almacena el nombre usuario
            $usuario = "imcrea_admin";
            // variable que almacena la contrase�a
            $pass = "Caracter15";
            // variable que almacena el nombre de la base de datos
            $BD = "imcrea_data";
            //variable que guarda la conexi�n de la base de datos
            $link = mysqli_connect($server, $usuario, $pass, $BD);
            // si no se realizo la conexion
            if ( !$link ) {
            die( 'No se pudo conectar a la base de datos: ' . mysql_error() );}
           // se selecciona la base de datos
            //mysql_select_db($BD, $link)or die('no se pudo seleccionar la base de datos: ' . mysql_error());;

            //Comprobamos si la conexi�n ha tenido exito
            //if(!$link){
            //   echo 'Ha sucedido un error inexperado en la conexion de la base de datos<br>';
            //} 
            //devolvemos el objeto de conexi�n para usarlo en las consultas
            return $link;
}
    /*Desconectar la conexion a la base de datos*/
    function desconectar($conexion){
            //Cierra la conexi�n y guarda el estado de la operaci�n en una variable
            $close = mysql_close($conexion);
            //Comprobamos si se ha cerrado la conexi�n correctamente
            if(!$close){
               echo 'Ha sucedido un error inexperado en la desconexion de la base de datos<br>';
            }
            //devuelve el estado del cierre de conexi�n
            return $close;
    }


?>
