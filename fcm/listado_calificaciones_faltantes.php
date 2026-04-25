<?php
// archivo de configuracion  de objetos
require_once("datos.php");

//variables recibidas mediante POSTn
$valido = true;
$err = "";

// jornada
$jornada = $_POST["id_jornada"];
// curso
$curso = 0;//$_POST['curso'];
// //semana
$semana = $_POST["semana"];
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
    $err = $err."<p class='text-danger'>Porfavor seleccione un grado</p>";
}

if($_POST["years"]!== ""){
    $ano = $_POST["years"];//date("Y");
}else {
    $valido = false;
    $err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
}


if($_POST["id_jornada"]!== ""){
    $jornada = $_POST['id_jornada'];
}else {
    $valido = false;
    $err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
}
if($_POST["id_ms"] >0){
    $id_m = $_POST['id_ms'];
}else {
    $valido = false;
    $err = $err."<p class='text-danger'>Porfavor seleccione una materia</p>";
}
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
    $err = $err."<p class='text-danger'>Porfavor seleccione una semana</p>";
}

// si los datos son validos
if ($valido) {

    $gr = new grados();
    $gr->get_nombre($grado);

    $cr = new materia();
    $cr->get_materia($id_m);
    
    //crea un nuevo objeto listado (año,grado,jornada,curso)
    //el cual esta conformado por un array los id de los alumnos
    //que cumplen este criterio
    $mtr  = new matricula();

    $listado =  $mtr->getAlumnosPorGrupo($grado,$curso, $ano,$jornada);
    $ponderado = new ponderado();
    $md = new matricula_docente();
    $d = new docentes();
    $id_docente = $md->get_docente($id_m, $grado, $jornada, $curso, $ano);
    $d->get_docente_id($id_docente);

    echo "<p>Listado de  notas pendientes de <b>"
        .$cr->materia."</b> del grado <b>"
        .$gr->nombre_g."</b> de la semana <b>1</b> a la semana <b>$semana</b>, docente <span class='text-danger'>"
        .ucwords(strtolower($d->nombres))
        ." ".ucwords(strtolower($d->apellidos))."</span></p>";

    // para cada alumno
        foreach($listado as $e) {
            $estudiante = new alumnos($e);
            // creo un nuevo objeto de calificaciones
            $score = new calificaciones();
            // array de notas faltantes
            $faltantes = $score->get_criterio_faltantes($e, $id_m, $semana, $periodo, $ano);
            //echo var_dump($faltantes);
            echo "<div class='row'>";
            echo " <div class='col-md-4 '>";
            echo "<a href='#estadisicas' style='margin-right: 1em; onclick='est($e);'>";
            echo "$e</a>";
            echo "<span class='text-muted'>".ucwords(strtolower($estudiante->nombres))." ".ucwords(strtolower($estudiante->apellidos));
            echo "</span><input type='hidden' name='codigo[]' class='codigo' value=".$estudiante->id_alumno."> </div>" ;
            echo " <div class='col-md-4 '>";

            foreach ($faltantes as $f){

                $ponderado->get_ponderado_por_tipo($f[0]);
                echo "<p >Falta nota del criterio <span class='text-white bg-dark'>".$ponderado->ponderado."</span> en la semana <b>".$f[1]."</b></p>";
            }
            echo "</div>";
            echo "</div>";
        }

    echo "</div>";
}
else {
    echo $err;
}
//$lista = new $matriculas();
?>
