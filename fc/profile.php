<?php
// Initialize the session - is required to check the login state.
session_start();
// archivo de configuracion  de objetos
require_once("datos.php");

echo "Inicio <br>";
// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['google_loggedin'])) {
    header('Location: login_boletines_prueba.php');
    exit;
}
// Retrieve session variables
$google_loggedin = $_SESSION['google_loggedin'];
$google_email = $_SESSION['google_email'];
$google_name = $_SESSION['google_name'];
$google_picture = $_SESSION['google_picture'];

// muestro el login


$d = new docentes();
$d->get_docente_email($google_email);

 // si el corero institucional es el guardado
if($d->i_correo == $google_email){
    //Creamos sesion
    //Almacenamos el nombre de usuario
    $_SESSION['usuario'] = $d->cedula;
    // guardo el codigo del docete  en la variable de seccion  id
    $_SESSION['id'] = $d->id;
    echo var_dump($_SESSION);
    // abre el archivo formulario boletin
    header("Location:board.php");
}


?>
