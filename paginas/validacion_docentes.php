<?php

session_start(); // permite tener activa la  seccion para un usuario

require_once 'conexion.php'; // requiere el archivo conexion.php

/*caturamos nuestros datos que fueron enviados desde el formulario mediante el metodo POST
**y los almacenamos en variables.*/

$link = conectar();
// recibe ele campo de cedula
$usuario = $_POST["cedula"];
//echo $usuario."<br>";
// recibe la contraseña
$password = $_POST["login"];

//echo $password;
$query = "select * from docentes where cedula ='".$usuario."'";

//echo "<br>".$query;
// se realiza una consulta
$registro = mysqli_query ($link, $query) or
         die("Problemas  encontrar el usuario:".mysqli_error());


/* array asociativo */
$row = $registro->fetch_array(MYSQLI_ASSOC);
//printf ("%s (%s)\n", $row["login"], $row["id_docente"]);

    if($row["login"] == $password)
    {
        //Creamos sesi�n
        //Almacenamos el nombre de usuario//  en una variable de sesi�n usuario
        $_SESSION['usuario'] = $usuario;
        // guardo el codigo del docete  en la variable de seccion  id
        $_SESSION['id'] = $row['id_docente'];
        // abre el archivo formulario boletin
        header("Location:formulario_boletin.php");
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
