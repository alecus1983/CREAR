<?php
session_start(); // permite tener activa la  seccion para un usuario

// archivo de configuracion  de objetos
require_once("datos.php");


// valido el campo de la cedula
if (isset($_POST["cedula"])){
    // recibe ele campo de cedula
    $usuario = $_POST["cedula"];
} else {
    // salida
    exit;
}


// valido el campo login
if (isset($_POST["login"])){
    $password = $_POST["login"];
} else {
    // salida
    exit;
}

$d = new docentes();
$d->get_docente_cc($_POST["cedula"]);


    if($d->login == $password)
    {
        //Creamos sesi�n
        //Almacenamos el nombre de usuario//  en una variable de sesi�n usuario
        $_SESSION['usuario'] = $usuario;
        // guardo el codigo del docete  en la variable de seccion  id
        $_SESSION['id'] = $row['id_docente'];
        // abre el archivo formulario boletin
        header("Location:fc.php");
    }
    else
        // en caso de que la contraseña sea incorrecta
    {
        //echo "<br><br>contraseña incorrecta";

        echo"
   		<script >
        alert('Contraseña Incorrecta');
    			location.href = 'login_boletines.php';
                </script>
                <?";
    }
// funcion que termina la conexion
desconectar($link);
?>