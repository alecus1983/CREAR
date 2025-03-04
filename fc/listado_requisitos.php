<?php
// archivo que obtiene los docentes matriculados
// en una materia para un grado/curso/jornada

require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuesta
$respuesta = array();

// curso
$id_curso = $_POST['id_curso'];
// periodos
$periodo = $_POST["periodo"];

// variable booleana que almacena la semana final de cada periodo
$semana_final = false;
// semana intermedia
$semana_intermedia = false;
                   

//echo "<div class='row'>Listado para la semana : ".$semana."</div>";
// validacion de datos
if($_POST["id_g"] >0 ){
    $grado = $_POST["id_g"];
}else {
    $valido = false;
    $respuesta['status'] = 21;
    //$err = $err."<p class='text-danger'>Porfavor seleccione un grado</p>";
}

if($_POST["years"]!== ""){
    $ano = $_POST["years"];//date("Y");
}else {
    $valido = false;
    $respuesta['status'] = 22;
    //$err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
}


if($_POST["id_jornada"]!== ""){
    $id_jornada = $_POST['id_jornada'];
}else {
    $valido = false;
    $respuesta['status'] = 23;
    //$err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
}
// if($_POST["id_ms"] >0){
//     $id_m = $_POST['id_ms'];
// }else {
//     $valido = false;
//     $err = $err."<p class='text-danger'>Porfavor seleccione una materia</p>";
// }
if($_POST["semana"] > 0){
    // filtro la semana
    $semana = $_POST['semana'];
    
    //caracteristicas de las semana final 
    if( $semana == 8 || $semana == 16 || $semana == 24 || $semana == 32){
        // semana final es valida
        $semana_final = true;   
    }

    // semanas para semana intermedia
    if ($semana == 4 || $semana == 12 || $semana == 20 || $semana == 28){
        $semana_intermedia = true;
    }
}else {
    // si no hay semana los datos no son validos
    $valido = false;
    // comunico el error al usuario
    $respuesta['status'] = 24;
    //$err = $err."<p class='text-danger'>Porfavor seleccione una semana</p>";
}

// si los datos son validos
if ($valido) {

    $gr = new grados();
    $gr->get_nombre($grado);
    $cr = new materia();
    //objeto matricula docnente
    $md = new matricula_docente();
    $d = new docentes();
    // array con el total de los docentes
    $total_docente = $d->get_total_docentes();
    // objeto tipo curso
    $cu = new curso();
    // obtengo las caracteristicas del curso 
    $cu->get_curso_por_id($id_curso);
    // obtengo la caracteristica de la jornada 
    $jo = new jornada();
    //
    $jo->get_jornada_por_id($id_jornada);
    $rq = new requisitos();
    $requisitos = $rq->get_requisitos_grado($grado);

    // array de id's de docentes de un curso/grado/jornada
    $listado = $md->get_lista_por_grado ($grado,$id_jornada, $id_curso, $ano);

    $html = "<p>Listado materias requieridas para el grado <b>".$gr->nombre_g
         ."</b>, </p>";

    
    $html = $html."<div class='row'>";
    $html = $html. " <div class='col-md-12 '>";
    $html = $html. "<div class='row'>";
    $html = $html. "<div class='col-7'>";

    $html = $html. "<div class='form-floating'>";
    $html = $html. '<select id="id_materia_mt"  class="form-select">';
    $html = $html."<option value''></option>";
    // array con id de todas las materias
    $lista_mt = $cr->get_all();

    foreach($lista_mt as $mt){
        $cr->get_materia($mt);
        $html = $html."<option value='".$cr->id_materia."'>".$cr->materia."</option>";
        
    }
    
    $html = $html. "</select>";
    $html = $html. "<label for='id_materia_mt'>Materia</label>";
    $html = $html. "</div>";
    
    $html = $html. "</div>";
    $html = $html. "<div class='col-2'>";
    $html = $html. '<button type="button" class="btn btn-outline-success" onclick="agregar_requisito();">Agregar</button>';
    $html = $html. "</div>";
    $html = $html. "</div>";

    $html = $html. "<table class='table''>";
    $html = $html. "<thead>";
    $html = $html. "<th scope='col'>Materia</th>";
    $html = $html. "<th scope='col'>Eliminar</th>";
    $html = $html. "</thead>";
    $html = $html. "<tbody>";
    // por cada matricula docente  
    foreach($requisitos as $r ){
        // obtengo las caracteristicas del requisito 
         $rq->get_requisitos_id($r);
         // obtengo las caracteristicas de la materia
         $cr->get_materia($rq->id_materia);

         $html = $html. "<tr>";
         $html = $html. "<td>";
         $html = $html. $cr->materia;
         $html = $html. "</td>";
         $html = $html. "<td>";
         $html = $html. "<button type='button' class='btn btn-warning' onclick='eliminar_requisitos(\""
               .$rq->id_materia."\",\"".$rq->id_grado."\");'>eliminar</button>";
         $html = $html. "</td>";
         $html = $html. "</tr>";
                
     }
    
    
    $html = $html. "</tbody>";
       
    $html = $html. "</div>";
    $html = $html. "</div>";
    

    $html = $html. "</div>";

    // parte de la respuesta HTML
    $respuesta['html']=$html;
    $respuesta['status']=1;
}
else {
    $respuesta['html'] = "";
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;

//$lista = new $matriculas();
?>
