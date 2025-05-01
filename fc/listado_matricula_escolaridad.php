<?php
// archivo que obtiene los estudiantes matriculados
// en una jornada y una escolaridad

require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuesta
$respuesta = array();

$html = "";

// validacion de datos
if($_POST['years']>0 ){
    // recibo el año
    $year = $_POST['years'];
}else {
    $valido = false;
    $respuesta['status'] = 21;
}

// si se ha seleccionado el curso
if($_POST["id_escolaridad"]>0){
    // codigo del curso
    $id_escolaridad = $_POST["id_escolaridad"];
}else {
    $valido = false;
    $respuesta['status'] = 22;
}

//  valido la jornada
if($_POST["id_jornada"]!== ""){
    $id_jornada = $_POST['id_jornada'];
}else {
    $valido = false;
    $respuesta['status'] = 23;
}

// si los datos son validos
if ($valido) {
    
    // creo un objeto clase grado
    $gr = new grados();
    // obtengo el listado de grados de una escolaridad
    $lista_g = $gr->lista_escolaridad($id_escolaridad);
    
    // se crea elemento jornada 
    $jo = new jornada();
    // recupero los atributos de la jornada
    $jo->get_jornada_por_id($id_jornada);

    // lista de grados de una escolaridad dada
    foreach($lista_g as $r){

        // creo un objeto tipo matricula
        $mt = new matricula();
        // se obtiene array  de estudiantes matriculados en
        // un año , grado y jornada
        $alumnos = $mt->get_matriculas_grado_jornada($year,$r[0],$id_jornada);
        
        // genero un objeto tipo grados
        $g = new grados();
        // busco los datos de cada grado
        $g->get_grado_id($r[0]);

        // agrego datos del grado para ser mostrado

         $html = $html. "<table class='table''>";
         $html = $html."<caption>";
         $html = $html."Listado de estudiantes del grado  <b>".$g->nombre_g."</b>, jornada ".$jo->jornada;
         $html = $html."</caption>";         
         $html = $html. "<thead>";
         $html = $html. "<th scope='col'>Curso</th>";
         $html = $html. "<th scope='col'>C&oacute;digo estudiante</th>";
         $html = $html. "<th scope='col'>C&oacute;digo matricula</th>";
         $html = $html. "<th scope='col'>Nombre</th>";
         $html = $html. "<th scope='col'>Apellido</th>";
         $html = $html. "<th scope='col'>Actualizar</th>";
         $html = $html. "<th scope='col'>Eliminar</th>";
         $html = $html. "</thead>";
         $html = $html. "<tbody>";

         // estructura de repeticion por cada alumno
         foreach($alumnos as $a){
             //echo var_dump($a);
             $id_curso = $a['id_curso'];
             // codigo del alumno 
             $id_alumno = $a['id_alumno'];
             // codigo de la matricula
             $id_matricula = $a['id'];
             
             // recupero los datos de la persona
             $al = new alumnos($id_alumno);
             
             $html = $html. "<tr>";
             $html = $html. "<td>";
             $html = $html. "".$id_curso;
             $html = $html. "</td>";
             $html = $html. "<td>";
             $html = $html. "".$id_alumno;
             $html = $html. "</td>";
             $html = $html. "<td>";
             $html = $html. "<i>".$id_matricula."</i>";
             $html = $html. "</td>";
             $html = $html. "<td>";
             $html = $html. "".ucwords(strtolower($al->nombres));
             $html = $html. "</td>";
             $html = $html. "<td>";
             $html = $html. "".ucwords(strtolower($al->apellidos));
             $html = $html. "</td>";
             $html = $html. "<td>";
             $html = $html. "<button type='button' class='btn btn-outline-success' onclick='editar_matriculas(1,\"$id_matricula\");'>Editar</button>";
             $html = $html. "</td>";
             $html = $html. "<td>";
             $html = $html. "<button type='button' class='btn btn-warning' onclick='eliminar_matricula_(\"$id_matricula\");'>eliminar</button>";
             $html = $html. "</td>";
             $html = $html. "</tr>";
             $html = $html. "</tbody>";    
         }
         
     }
 
    // parte de la respuesta HTML
    $respuesta['html']=$html;
    $respuesta['status']=1;
}
else {
    $respuesta['html'] = "";
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;

?>
