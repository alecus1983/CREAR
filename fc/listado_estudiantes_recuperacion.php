<?php

  //////////////////////////////////////////////////
  // listado_estudiantes_recuperacion.php         //
  //                                              //
  // Este archivo contiene el fichero que         //
  // consulta el estado de las recuperaciones     //
  // realizadas por los estudiantes de un grado,  //
  // de  un curso particular, en una jornada,     //
  // en  un periodo determinado, para una materia //
  //                                              //
  // Resibe los datos mediante ajax empleando el  //
  // método POST                                  // 
  //                                              //
  //////////////////////////////////////////////////

  // archivo de configuracion  de objetos
require_once("datos.php");

// vairiables de configuracion
// valirables que almacena si el dato es válido
$valido = true;
// variable que almacena el posible error
$err = "";

//variables recibidas mediante POST

// jornada
$jornada = $_POST["id_jornada"];
// curso
$curso = $_POST['curso'];
// periodos
$periodo = $_POST["periodo"];

                 

//echo "<div class='row'>Listado para la semana : ".$semana."</div>";
// VALIDACION DE DATOS

// validando si tiene un grado asignado
if($_POST["id_g"] >0 ){
  $grado = $_POST["id_g"];
 }else {
  $valido = false;
  $err = $err."<p class='text-danger'>Porfavor seleccione un grado</p>";
 }

// validando si tiene un año asignado
if($_POST["years"]!== ""){
  $ano = $_POST["years"];//date("Y");
 }else {
  $valido = false;
  $err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
 }

// validando si tiene  una jornada
if($_POST["id_jornada"]!== ""){
  $jornada = $_POST['id_jornada'];
 }else {
  $valido = false;
  $err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
 }

// validando si tiene una materia
if($_POST["id_ms"] >0){
  $id_m = $_POST['id_ms'];
 }else {
  $valido = false;
  $err = $err."<p class='text-danger'>Porfavor seleccione una materia</p>";
 }



// SI LOS DATOS SON VALIDOS
if ($valido) {

  //creo un objeto grados
  $gr = new grados();
  // obtengo el nombre del grado
  $gr->get_nombre($grado);
  // creo un objeto materia
  $cr = new materia();
  // obtento el nombre de la mateira
  $cr->get_materia($id_m);
  //echo "<div class='row'><div class='col-md-12>";

  // creo un objeto jornada
  $jo = new jornada();
  // obtengo la jornada en base a su id
  $jo->get_jornada_por_id($jornada);

  
  // saco este mensaje por consola
  echo "<p>Listado de  recuperaciones cargadas para los estudiantes matriculados en  <b>".$cr->materia."</b> del grado <b>".$gr->nombre_g."</b>  de la jornada de la <b>".$jo->jornada."</b> ,durante el periodo <span style='color:red; font-weight:bold;'>".$periodo."</span>.</p>";
    
  echo "<div class='row'><div class='col-md-8'>";

  //crea un nuevo objeto listado (año,grado,jornada,curso)
  $listado  = new listado_estudiantes($ano,$grado,$jornada, $curso);

  // si se trata de la materia de disciplina entonces
  if ($id_m == 20) {

    // para cada alumno
    foreach($listado->id_alumno as $e) {
      $estudiante = new alumnos($e);
      // creo un nuevo objeto de calificaciones
      $score = new calificaciones(); 
      echo "<div class='row'>";
      echo " <div class='col-md-6 '>";
      echo "<a href='#estadisicas' class='codigo' style='margin-right: 1em; onclick='est($e);'>";
	echo "$e</a>";
      echo "<span class='text-muted'>".ucwords(strtolower($estudiante->nombres))." ".ucwords(strtolower($estudiante->apellidos));
      echo "</span><input type='hidden' name='codigo[]' class='codigo' value=".$estudiante->id_alumno."> </div>" ;

      // calificacion para disciplina
      // criterio 0 para disciplina
      $score->get_recuperacion_periodo($e, $id_m,$ano,$periodo);
      $nota1 = $score->nota;
      echo "<div class='col-md-6' name=''>";
      echo '<div class="input-group mb-1">';
      echo '<span class="input-group-text" id="addon-wrapping">nota</span>';
      echo '<input type="number" step="0.1" max="5" min="0"  value="'.$nota1.'"  class="form-control R" placeholder="disciplina" name="A[]" aria-label="disciplina" aria-describedby="basic-addon1">';
      echo '</div>'; // fin de div del grupo
      // si se trata de la semana final

	//LOGRO
	$score->get_logro($e, $id_m, $ano, $periodo);
	$logro = $score->logro;
	//echo "<div class='col-md-1' name=''>";
	echo '<div class="input-group mb-1">';
	echo '<span class="input-group-text" id="addon-wrapping">logro</span>';
	echo '<input type="number" step="0.1" max="5" min="0" name="L[]" value="'.$logro.'" class="form-control L" placeholder="logro" aria-label="auto evaluacion" aria-describedby="basic-addon1">';
	echo '</div>';

      echo '</div>';// fin de la columna
      echo '</div>';// fin de la fila
    }
  }
  
  // si es una materia distinta de disciplina
  else {
    //por cada alumno del listado del curso    
    foreach($listado->id_alumno as $e) {
      // creo un nuevo estudiante
      $estudiante = new alumnos($e);
      // creo un nuevo objeto de calificaciones
      $score = new calificaciones(); 
      echo "<div class='row'>";
      echo " <div class='col-md-3 '>";
      echo "<a href='#estadisicas' class='codigo' style=' margin-right: 1em;' onclick='est($e);'>";
      echo "$e</a>";
      echo "<span class='text-muted'>".ucwords(strtolower($estudiante->nombres))." ".ucwords(strtolower($estudiante->apellidos));
      echo "</span><input type='hidden' name='codigo[]' class='codigo' value=".$estudiante->id_alumno."> </div>" ;

      // semanas finales
      if (1) {
            
	// Nota de recuperación
	$score->get_recuperacion_periodo($e, $id_m, $ano,$periodo);
	$nota1 = $score->nota;
	// coloco un numero vacio  si la nota es igual a cero
	if ($nota1 == 0){
	  $nota1 = "";
	}
	echo "<div class='col-md-1' name=''>";
	echo '<div class="input-group mb-1">';
	echo '<span class="input-group-text" id="addon-wrapping">nota</span>';
	echo '<input type="number" step="0.1" max="5" min="0" name="R[]"  value="'.$nota1.'"  class="form-control R" placeholder="nota" aria-label="recuperacion" aria-describedby="basic-addon1">';
	echo '</div>';
	//echo '</div>';



	//LOGRO
	$score->get_logro($e, $id_m, $ano, $periodo);
	// se obtiene el logro
	$logro = $score->logro;
	//echo "<div class='col-md-1' name=''>";
	echo '<div class="input-group mb-1">';
	echo '<span class="input-group-text" id="addon-wrapping">logro</span>';
	echo '<input type="number" step="0.1" max="5" min="0" name="L[]" value="'.$logro.'" class="form-control L" placeholder="logro" aria-label="logro" aria-describedby="basic-addon1">';
	echo '</div>';
	echo '</div>';	
      }
     
      echo  "</div>" ;

        
    } //fin de estructura por cada alumno
    
  } // fin de else 
    
  echo "</div>";

  // espacio para logros y  comentarios
  echo "<div id='logros_materia' class='col-md-4'>";
  // contenido

  if(1) {

	
    // creo nuevo elemento de logros
    $l = new logro();
        
    $logros = $l->get_logros($id_m);

    // inicio de tabla

    echo "<table class='table'>";
    echo "<thead>";
    echo "<th scope='col'>Código</th>";
    echo "<th scope='col'>Logro</th>";
    echo "</thead><tbody clase='table-striped'>";
	
    foreach  ( $logros as  $id => $logro ){
      echo "<tr><td class='fw-bold'>";
      echo $id;
      echo "</td><td clase'lh-sm fw-lighter fst-italic text-reset'>";
      echo $logro;
      echo "</td></tr>";
    }

    echo "</tbody></table>";
	
  }
    
  echo "</div>";

  echo "</div>";
 }
 else {
   echo $err;
 }
//$lista = new $matriculas();
?>
