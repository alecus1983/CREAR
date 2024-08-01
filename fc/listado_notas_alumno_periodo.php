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
                   

// validacion de datos
if($_POST["id_g"] >0 ){
    $grado = $_POST["id_g"];
}else {
    $valido = false;
    $respuesta['status'] = 21;
}

if($_POST["years"]!== ""){
    $ano = $_POST["years"];
}else {
    $valido = false;
    $respuesta['status'] = 22;
}


if($_POST["id_jornada"]!== ""){
    $id_jornada = $_POST['id_jornada'];
}else {
    $valido = false;
    $respuesta['status'] = 23;
}

// validacion de materia
if($_POST["id_ms"] >0 ){
    $id_materia = $_POST["id_ms"];
}else {
    $valido = false;
    $respuesta['status'] = 25;
}

// si los datos son validos
if ($valido) {

    $gr = new grados();
    $gr->get_nombre($grado);
    $cr = new materia();
    //objeto matricula docnente
    $md = new matricula_docente();
    //crea un nuevo objeto listado (año,grado,jornada,curso)
    $listado  = new listado_estudiantes($ano,$grado,$id_jornada, $id_curso);
    // objeto tipo curso
    $cu = new curso();
    // obtengo las caracteristicas del curso 
    $cu->get_curso_por_id($id_curso);
    // obtengo la caracteristica de la jornada 
    $jo = new jornada();
    //
    $jo->get_jornada_por_id($id_jornada);
    $rq = new requisitos();

    // array de id's de docentes de un curso/grado/jornada
    // $listado = $md->get_lista_por_grado ($grado,$id_jornada, $id_curso, $ano);
    //$listado = $md->get_lista_por_grado ($grado,$id_jornada, $id_curso, $ano);

    $html = "<p>Listado de notas  en el grado <b>".$gr->nombre_g." ".$cu->curso
         ."</b>, jornada <b>".$jo->jornada."</b>, durante el periodo <b>$periodo</b>  del  año lectivo <b>".$ano."</b>, para el estudiante :  </p>";

    
    $html = $html."<div class='row'>";
    $html = $html. " <div class='col-md-12 '>";
    $html = $html. "<div class='row'>";
    $html = $html. "<div class='col-5'>";
    // selector de docentes
    $html = $html. "";
    $html = $html. "<div class='form-floating'>";
    $html = $html. '<select id="id_alumno"  class="form-select">';
    $html = $html.'<option value""></option>';
    foreach($listado->id_alumno as $e){
        // creo nuevo estudiante
        $estudiante = new alumnos($e);
        $html = $html.'<option value="'.$estudiante->id_alumno.'">'.ucwords(strtolower($estudiante->nombres))." ".ucwords(strtolower($estudiante->apellidos))."</option> ";
    }
    $html = $html. "</select>";
    $html = $html. "<label for='id_alumno'>Estuadiante</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";
    $html = $html. "<div class='col-4'>";

    $html = $html. "<div class='form-floating'>";
    // $html = $html. '<select id="id_materia_md"  class="form-select">';
    // $html = $html.'<option value""></option>';
    // $lista_mt = $rq->get_requisitos_grado($grado);

    // foreach($lista_mt as $r){
    //     // obtengo las caracteristicas del requisito 
    //      $rq->get_requisitos_id($r);
    //      // obtengo las caracteristicas de la materia
    //      $cr->get_materia($rq->id_materia);
    //     $html = $html."<option value='".$cr->id_materia."'>".$cr->materia."</option>";
    // }
    
    // $html = $html. "</select>";
    // $html = $html. "<label for='id_materia_mt'>Materia</label>";
    $html = $html. "</div>";
    
    $html = $html. "</div>";
    $html = $html. "<div class='col-2'>";
    $html = $html. '<button type="button" class="btn btn-outline-success" onclick="find_nota_alumno();">Consultar</button>';
    $html = $html. "</div>";
    $html = $html. "</div>";
    // $html = $html. "</tr>";   
    
    // // por cada matricula docente  
    // foreach($listado as $id){
    //     // obtengo los atributos de la matricula 
    //     $md->get_matricula_por_id($id);
    //     // obtengo las caracteristicas del docente 
    //     $d->get_docente_id($md->id_docente);
    //     // obtengo las caracteristicas de la materia
    //     $cr->get_materia($md->id_materia);
    //     $html = $html. "<tr>";
    //     $html = $html. "<td>";
    //     $html = $html. ucwords(strtolower($d->nombres))." ".ucwords(strtolower($d->apellidos));
    //     $html = $html. "</td>";
    //     $html = $html. "<td>";
    //     $html = $html. $cr->materia;
    //     $html = $html. "</td>";
    //     $html = $html. "<td>";
    //     $html = $html. "<button type='button' class='btn btn-warning' onclick='eliminar_matricula_docente(\"$id\");'>eliminar</button>";
    //     $html = $html. "</td>";
    //     $html = $html. "</tr>";          
    // }
    // $html = $html. "</tbody>";
       
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
