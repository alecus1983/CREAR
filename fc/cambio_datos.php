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
$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$identificacion = $_POST["identificacion"];
//$personax = $_POST["personax"];
//$form = $_POST["form"];

$html = "";
// si los datos son validos
// creo un nuevo objeto matricula para el año actual
// $mt =     new matriculas_year($ano);
$personas = new personas();
// asigno el atributo nombre
$personas->nombres = $nombres;
// asigno el atributo de apellido
$personas->apellidos = $apellidos;
// asigno la identificacion
$personas->identificacion =  $identificacion;
// obtengo la lista de personas que coinciden con el criterio
$lista = $personas->buscar_persona();


// inicio de la tabla
/*
// div que crea una fila bootrap
$html = $html."<div class='row'>";
// fila de todo el ancho 
$html = $html. " <div class='col-md-12 '>";
//  apertura de fila y columna de ancho de cinco
$html = $html. "<div class='row'>";
$html = $html. "<div class='col-5'>";
$html = $html. "</div>";
$html = $html. "</div>";

    
// inicio la creacion de la tabla
$html = $html. "<table class='table''>";
$html = $html. "<thead>";
// emcabezado de la tabla
// $html = $html. "<th scope='col'>Codigo</th>";
$html = $html. "<th scope='col'>Nombres</th>";
$html = $html. "<th scope='col'>Apellidos</th>";
$html = $html. "<th scope='col'>D. de identidad</th>";
// $html = $html. "<th scope='col'>Correo</th>";
// $html = $html. "<th scope='col'>Telefono</th>";
 $html = $html. "<th scope='col'>Actualizar</th>";
 $html = $html. "<th scope='col'>Selecionar</th>";
 $html = $html. "<th scope='col'>Eliminar</th>";
$html = $html. "</thead>";
$html = $html. "<tbody>";
    
// por cada estudiante 
foreach  ( $lista as $id ) {
    // //creo una matricula
    // $matricula =  new matricula($id);
    // // creo un nuevo alumno
    // $alumno = new alumnos($matricula->id_alumno);
    // var_dump($id);
    // var_dump($id);
         $html = $html."<tr>";
         $html = $html."<td>";
         $html = $html." ".$id[0];
         $html = $html."</td>";
         $html = $html."<td>";
         $html = $html." ".$id[1];
         $html = $html."</td>";
         $html = $html."<td>";
         $html = $html." ".$id[2];
         $html = $html."</td>";
         $html = $html. "<td>";
        $html = $html. "<button type='button' class='btn btn-info' onclick='datos_persona(\"$id[3]\");'>actualizar</button>";
        $html = $html. "</td>";
        $html = $html. "<td>";
        $html = $html. "<button type='button' class='btn btn-success' onclick='seleccionar_persona(\"$id[3]\",$personax, $form);'>seleccioar</button>";
        $html = $html. "</td>";
        $html = $html. "<td>";
        $html = $html. "<button type='button' class='btn btn-warning' onclick='eliminar_persona(\"$id[3]\");'>eliminar</button>";
        $html = $html. "</td>";
         $html = $html."</tr>";
         
 }

$html = $html. "</tbody>";
$html = $html. "</div>";
$html = $html. "</div>";
$html = $html. "</div>";

// fin de la tabla
*/
    
// parte de la respuesta HTML
$respuesta['html']=$html;
$respuesta['status']=1;
$respuesta['json']=$lista;

// encapsulo  la respuesta en modo json
$respuesta_json = json_encode($respuesta);
// emito la respuesta
echo $respuesta_json;

//$lista = new $matriculas();
?>
