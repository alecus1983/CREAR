<?php
require_once("datos.php");
$nombre = $_POST['area'];
$obj = new area();
// Pasamos null como segundo parámetro ya que la BD genera el ID automáticamente
if($obj->insertar_area($nombre)) {
    echo json_encode(["status" => 1, "msj" => "Área guardada con éxito"]);
}
