<?php
session_start();
//conexion con la base de datos
require_once 'conexion.php';
//setlocale(LC_ALL,"es_ES");
header("Content-Type: text/html;charset=utf-8");
$link = conectar();


//printf("Conjunto de caracteres inicial: %s\n", $link->character_set_name());

/* cambiar el conjunto de caracteres a utf8 */
if (!$link->set_charset("utf8")) {
    printf("Error cargando el conjunto de caracteres utf8: %s\n", $link->error);
    exit();
}

// se  recupera el nombre por el método POST
// $admin = $_SESSION['admin'];
// $id = $_POST['id'];
// $year = date('Y');
// dato recibido de escolaridad
$escolaridad = $_POST["escolaridad"];

// array vacio
$data = array();

// se crea el texto de la consulta
$q1 = "SELECT * FROM grados WHERE id_escolaridad = $escolaridad";

// se realiza la  consulta en la base de datos
$q1x = mysqli_query( $link, $q1) or die('no se encuentra el nombre: ' . mysqli_error());;


//recupero el arreglo generado en el resultado
while($dato1 = mysqli_fetch_array($q1x))
{
    // recupero el nombre
    $id = $dato1["id_grado"];
    //$materia = utf8_decode($dato1["materia"]);
    $materia = $dato1["grado"];
    //$materia = html_entity_decode($materia, ENT_QUOTES | ENT_HTML401, "UTF-8");
    //echo "materia :".$materia." - codificacion ". mb_detect_encoding($materia). "<br>";
    // estos valores son los valores a entrar por el método JSON
    // aqui recupero el nombre del alumno
    $data[$id] = $materia;
}

//print_r($data);
echo   json_encode($data);
//mysqli_free_result($q1x);
//mysqli_free_result($q1);

desconectar($link);


?>
