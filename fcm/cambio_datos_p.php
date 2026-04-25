<?php
// archivo que obtiene los docentes matriculados
// en una materia para un grado/curso/jornada

require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuestals

//obtengo los datos por _POST
$respuesta = array();
//obtengo los nombres
$nombres = $_POST["nombres"];
// obtengo los apellidos
$apellidos = $_POST["apellidos"];
// identificacion
$identificacion = $_POST["identificacion"];

// html de respuesta
$html = "";

// si los datos son validos
// creo un nuevo objeto matricula para el año actual
$personas = new personas();
// asigno el atributo nombre
$personas->nombres = $nombres;
// asigno el atributo de apellido
$personas->apellidos = $apellidos;
// asigno la identificacion
$personas->identificacion =  $identificacion;
// obtengo la lista de personas que coinciden con el criterio
$lista = $personas->buscar_persona();
    
// parte de la respuesta HTML
$respuesta['html']=$html;
// retorna el estado
$respuesta['status']=1;
// retorno una lista de estudianes
$respuesta['json']=$lista;

// encapsulo  la respuesta en modo json
$respuesta_json = json_encode($respuesta);
// emito la respuesta
echo $respuesta_json;

?>
