<?php
// archivo que inserta las notas obtenidas por un alumno
// durante un periodo academico en la tabla de notas

require_once("datos.php");

//variables de validacion
$valido = true;

//array de respuesta
$respuesta = array();

// periodo
$periodo = $_POST["periodo"];

// validacion de datos

// si tiene el grado seleccionado
if($_POST["id_g"] >0 ){
    $grado = $_POST["id_g"];
}else {
    $valido = false;
    $respuesta['status'] = 21;
    //$err = $err."<p class='text-danger'>Porfavor seleccione un grado</p>";
}

// si tiene el año seleccionado
if($_POST["years"]!== ""){
    $ano = $_POST["years"];//date("Y");
}else {
    $valido = false;
    $respuesta['status'] = 22;
    //$err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
}

// si tiene la materia selecionada
if($_POST["id_ms"]!== ""){
    $id_materia = $_POST["id_ms"];//date("Y");
}else {
    $valido = false;
    $respuesta['status'] = 25;
    //$err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
}

// si tiene la jornada seleccionada
if($_POST["id_jornada"]!== ""){
    $id_jornada = $_POST["id_jornada"];//date("Y");
}else {
    $valido = false;
    $respuesta['status'] = 23;
    //$err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
}

// si tiene el curso selecionado
if($_POST["id_curso"]!== ""){
    $id_curso = $_POST["id_curso"];//date("Y");
}else {
    $valido = false;
    $respuesta['status'] = 26;
}

// si tiene el curso selecionado
if($_POST["id_alumno"]!== ""){
    $id_alumno = $_POST["id_alumno"];
}else {
    $valido = false;
    $respuesta['status'] = 28;
}


$html = "";
// si los datos son validos
if ($valido) {
    
    $html = $html. "<table class='table''>";
    $html = $html. "<thead>";
    $html = $html. "<th scope='col'>Semana</th>";
    $html = $html. "<th scope='col'>Nota</th>";
    $html = $html. "<th scope='col'>Criterio</th>";
    $html = $html. "<th scope='col'>Ponderado</th>";
    $html = $html. "<th scope='col'>Aporte parcial</th>";
    $html = $html. "</thead>";
    $html = $html. "<tbody>";

    // semana inicial del periodo
    $ini = 1+( 8 * ($periodo -1));
    // semana final del periodo
    $fin =8 +( 8 * ($periodo -1));

    $nota_total = 0;
    $ponderado_total = 0;
    
    // ciclo de repeticion para el intervalo de las semanas
    for ($s = $ini ; $s <= $fin ; $s++) {
        $html = $html. "<tr>";
        // crear nuevas calificacion
        $cal = new calificaciones();
        // si el periodo es el primero
        $ponderado = new ponderado();
       
        $criterios = $cal->get_validar_periodo($s);
        //echo var_dump($criterios);

        foreach($criterios as $cr =>$letra) {
            
            // $id_ponderado = $cal->get_id_ponderado_tipo($letra);
            $pd = $ponderado->get_ponderado_por_tipo($letra);
             // obtengo la calificacion
            $cal->get_calificacion_semanal($id_alumno, $id_materia, $s, $ano,  $ponderado->id_ponderado);
            
            $html = $html . "<td>";
            $html = $html . $s;
            $html = $html . "</td>";
            $html = $html . "<td>";
            $html = $html . $cal->nota;        
            $html = $html . "</td>";
            $html = $html . "<td>";
            $html = $html . $ponderado->tipo." -  ".$ponderado->ponderado ;
            $html = $html . "</td>";
            $html = $html . "<td>";
            $html = $html . $ponderado->valor;
            $html = $html . "</td>";
            $html = $html . "<td>";
            $html = $html . $ponderado->valor * $cal->nota * 0.01;
            $html = $html . "</td>";
            $html = $html. "</tr>";

            $nota_total = $nota_total + $ponderado->valor * $cal->nota * 0.01;
            $ponderado_total = $ponderado_total + $ponderado->valor;
        }
    }
    $html = $html. "</tbody>";

    $html = $html." <br><br> nota de periodo <b>".number_format($nota_total,1)."</b>";
    $html = $html." <br><br> suma de ponderado <b>".$ponderado_total." %</b>";
    $respuesta['html']=$html;
    $respuesta['status']=1;
}
else {
    $repuesta['html'] = "";
}

$respuesta_json = json_encode($respuesta);
echo $respuesta_json;

//$lista = new $matriculas();
?>
