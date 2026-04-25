<?php
// archivo que obtiene los docentes matriculados
// en una materia para un grado/curso/jornada

require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuesta
$respuesta = array();

// validacion de datos
if($_POST['years']>0 ){
    // recibo el año
    $year = $_POST['years'];
}else {
    $valido = false;
    $respuesta['status'] = 21;
}

// si se ha seleccionado el curso
if($_POST["id_curso"]!== ""){
    // codigo del curso
    $id_curso = $_POST["id_curso"];
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

    // array de id's de docentes de un curso/grado/jornada
    $listado = $md->get_lista_por_grado ($grado,$id_jornada, $id_curso, $ano);

    $html = "<p>Listado de docentes matricuados en el grado <b>".$gr->nombre_g." ".$cu->curso
         ."</b>, jornada <b>".$jo->jornada."</b>, durante el año lectivo <b>".$ano."</b>  </p>";

    
    $html = $html."<div class='row'>";
    $html = $html. " <div class='col-md-12 '>";
    $html = $html. "<div class='row'>";
    $html = $html. "<div class='col-5'>";
    // selector de docentes
    $html = $html. "";
    $html = $html. "<div class='form-floating'>";
    $html = $html. '<select id="id_docente_mt"  class="form-select">';
    $html = $html.'<option value""></option>';
    foreach($total_docente as $td){
        $d->get_docente_id($td);

        $html = $html.'<option value="'.$d->id.'">'.ucwords(strtolower($d->nombres))." ".ucwords(strtolower($d->apellidos))."</option> ";
    }
    
    $html = $html. "</select>";
    $html = $html. "<label for='id_docente_mt'>Docente</label>";
    $html = $html. "</div>";
    $html = $html. "</div>";
    $html = $html. "<div class='col-4'>";

    $html = $html. "<div class='form-floating'>";
    $html = $html. '<select id="id_materia_md"  class="form-select">';
    $html = $html.'<option value""></option>';
    $lista_mt = $rq->get_requisitos_grado($grado);

    foreach($lista_mt as $r){
        // obtengo las caracteristicas del requisito 
         $rq->get_requisitos_id($r);
         // obtengo las caracteristicas de la materia
         $cr->get_materia($rq->id_materia);
        $html = $html."<option value='".$cr->id_materia."'>".$cr->materia."</option>";
    }
    
    $html = $html. "</select>";
    $html = $html. "<label for='id_materia_mt'>Materia</label>";
    $html = $html. "</div>";
    
    $html = $html. "</div>";
    $html = $html. "<div class='col-2'>";
    $html = $html. '<button type="button" class="btn btn-outline-success" onclick="agregar_matricula_docente();">Agregar</button>';
    $html = $html. "</div>";
    $html = $html. "</div>";

    $html = $html. "<table class='table''>";
    $html = $html. "<thead>";
    $html = $html. "<th scope='col'>Docente</th>";
    $html = $html. "<th scope='col'>Materia</th>";
    $html = $html. "<th scope='col'>Eliminar</th>";
    $html = $html. "</thead>";
    $html = $html. "<tbody>";
    // por cada matricula docente  
    foreach($listado as $id){
        // obtengo los atributos de la matricula 
        $md->get_matricula_por_id($id);
        // obtengo las caracteristicas del docente 
        $d->get_docente_id($md->id_docente);
        // obtengo las caracteristicas de la materia
        $cr->get_materia($md->id_materia);
        $html = $html. "<tr>";
        $html = $html. "<td>";
        $html = $html. ucwords(strtolower($d->nombres))." ".ucwords(strtolower($d->apellidos));
        $html = $html. "</td>";
        $html = $html. "<td>";
        $html = $html. $cr->materia;
        $html = $html. "</td>";
        $html = $html. "<td>";
        $html = $html. "<button type='button' class='btn btn-warning' onclick='eliminar_matricula_docente(\"$id\");'>eliminar</button>";
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
