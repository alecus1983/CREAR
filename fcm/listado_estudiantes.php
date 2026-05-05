<?php
// archivo de configuracion  de objetos
require_once("datos.php");

//variables recibidas mediante POSTn
$valido = true;
$err = "";

// jornada
$id_jornada = $_POST["id_jornada"];
// curso
$id_curso = $_POST['curso'];
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
    $id_jornada = $_POST['id_jornada'];
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

// validacion de periodo
    if($_POST['periodo'] > 0){
        $periodo = $_POST['periodo'];
    } else {
        $valido = false;
        // comunico el error al usuario
        $err = $err."<p class='text-danger'>Porfavor seleccione un periodo</p>";
        
    }

// si los datos son validos
if ($valido) {

    $jo = new jornada();
    $jo->get_jornada_por_id($id_jornada);
    $cu = new curso();
    $cu->get_curso_por_id($id_curso);
    $gr = new grados();
    $gr->get_nombre($grado);

    $cr = new materia();
    $cr->get_materia($id_m);
    //echo "<div class='row'><div class='col-md-12>";
    // saco este mensaje por consola
    echo "<p>Listado de  estudiantes  del grado <b>".$gr->nombre_g."  ".$cu->curso."</b>, en la jornada ".$jo->jornada.", en la semana $semana  en la materia : <b>".$cr->materia."</b></p>";
    
    echo "<div class='row'><div class='col-md-8'>";

  
    //crea un nuevo objeto listado (año,grado,jornada,curso)
    $listado  = new clases($ano,$grado,$id_jornada, $id_curso);

    // [OPTIMIZATION BLOCK START]
    $opt_nombres = [];
    $opt_notas = [];
    $opt_logros = [];

    if (!empty($listado->id_alumno)) {
        if (!class_exists('DbHelper_Listado')) {
            class DbHelper_Listado extends imcrea {
                public function getDb() { return $this->_db; }
            }
        }
        $dbHelper = new DbHelper_Listado();
        $db = $dbHelper->getDb();
        $in_alumnos = implode(',', $listado->id_alumno);

        // Pre-cargar nombres y apellidos
        $q_nombres = "SELECT a.id_alumnos, p.nombres, p.apellidos 
                      FROM u_alumnos a
                      INNER JOIN personas p ON a.id_personas = p.id_personas
                      WHERE a.id_alumnos IN ($in_alumnos)";
        $res_nombres = $db->query($q_nombres);
        if ($res_nombres) {
            while ($row = $res_nombres->fetch_assoc()) {
                $opt_nombres[$row['id_alumnos']] = [
                    'nombres' => $row['nombres'],
                    'apellidos' => $row['apellidos']
                ];
            }
        }

        // Pre-cargar calificaciones
        $q_notas = "SELECT id_alumno, id_ponderado, nota FROM calificaciones_{$ano}
                    WHERE year = $ano AND id_materia = $id_m AND id_semana = $semana AND id_alumno IN ($in_alumnos)";
        $res_notas = $db->query($q_notas);
        if ($res_notas) {
            while ($row = $res_notas->fetch_assoc()) {
                $opt_notas[$row['id_alumno']][$row['id_ponderado']] = $row['nota'];
            }
        }

        // Pre-cargar logros si es la semana final
        if ($semana_final) {
            $q_logros = "SELECT id_alumno, id_logro FROM calificaciones_{$ano}
                         WHERE year = $ano AND id_materia = $id_m AND periodo = $periodo AND id_logro > 0 AND id_alumno IN ($in_alumnos)";
            $res_logros = $db->query($q_logros);
            if ($res_logros) {
                while ($row = $res_logros->fetch_assoc()) {
                    $opt_logros[$row['id_alumno']] = $row['id_logro'];
                }
            }
        }
    }
    // [OPTIMIZATION BLOCK END]

    // si se trata de la materia de disciplina entonces
    if ($id_m == 20) {

        // para cada alumno
        foreach($listado->id_alumno as $e) {
            $e_nombre = isset($opt_nombres[$e]) ? $opt_nombres[$e]["nombres"] : "";
            $e_apellido = isset($opt_nombres[$e]) ? $opt_nombres[$e]["apellidos"] : "";
            // no instanciamos objetos en el bucle para mejorar rendimiento 
            echo "<div class='row'>";
            echo " <div class='col-md-6 '>";
            echo "<a href='#estadisicas' style='margin-right: 1em; onclick='est($e);'>";
            echo "$e</a>";
            echo "<span class='text-muted'>".ucwords(strtolower($e_nombre))." ".ucwords(strtolower($e_apellido));
            echo "</span><input type='hidden' name='codigo[]' class='codigo' value=".$e."> </div>" ;

            // calificacion para disciplina
            // criterio 0 para disciplina
            $nota = isset($opt_notas[$e][0]) ? $opt_notas[$e][0] : 0;
            if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}
            echo "<div class='col-md-6' name=''>";
            echo '<div class="input-group mb-1">';
            echo '<span class="input-group-text" id="addon-wrapping">nota</span>';
            echo '<input type="number" step="0.1" max="5" min="0"  value="'.$nota.'"  class="form-control A" placeholder="disciplina" name="A[]" aria-label="disciplina" aria-describedby="basic-addon1">';
            echo '</div>'; // fin de div del grupo
            // si se trata de la semana final
            if ($semana_final) {

                //LOGRO
                $logro = isset($opt_logros[$e]) ? $opt_logros[$e] : "";
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">logro</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="L[]" value="'.$logro.'" class="form-control L" placeholder="logro" aria-label="auto evaluacion" aria-describedby="basic-addon1">';
                echo '</div>';
            }
            echo '</div>';// fin de la columna
            echo '</div>';// fin de la fila

            
        }

    }
    // si es una materia distinta de disciplina
    else {
        //por cada alumno del listado del curso    
        foreach($listado->id_alumno as $e) {
            $e_nombre = isset($opt_nombres[$e]) ? $opt_nombres[$e]["nombres"] : "";
            $e_apellido = isset($opt_nombres[$e]) ? $opt_nombres[$e]["apellidos"] : "";
            // no instanciamos objetos en el bucle para mejorar rendimiento 
            echo "<div class='row'>";
            echo " <div class='col-md-3 '>";
            echo "<a href='#estadisicas' style=' margin-right: 1em;' onclick='est($e);'>";
            echo "$e</a>";
            echo "<span class='text-muted'>".ucwords(strtolower($e_nombre))." ".ucwords(strtolower($e_apellido));
            echo "</span><input type='hidden' name='codigo[]' class='codigo' value=".$e."> </div>" ;

            // semanas finales
            if ($semana_final) {
            
                // presentacion personal (E)
                $nota = isset($opt_notas[$e][5]) ? $opt_notas[$e][5] : 0;
                // coloco un numero vacio  si la nota es igual a cero
                if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}
                echo "<div class='col-md-6' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">presentacion personal</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="E[]"  value="'.$nota.'"  class="form-control E" placeholder="quiz" aria-label="presentacion personal" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';


                // actitud (F)
                $nota = isset($opt_notas[$e][6]) ? $opt_notas[$e][6] : 0;
                // coloco un numero vacio  si la nota es igual a cero
                if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}

                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">actitud</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="F[]" value="'.$nota.'"  class="form-control F" placeholder="actitud" aria-label="actitud" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';
		
                //asistencia (G)
                $nota = isset($opt_notas[$e][7]) ? $opt_notas[$e][7] : 0;
                // coloco un numero vacio  si la nota es igual a cero
                if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}

                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">asistencia</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="G[]" value="'.$nota.'" class="form-control G" placeholder="asistencia" aria-label="asistencia" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';


                //evaluación final (I)
                $nota = isset($opt_notas[$e][9]) ? $opt_notas[$e][9] : 0;
                // coloco un numero vacio  si la nota es igual a cero
                if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}

                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">evaluacion final</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="I[]" value="'.$nota.'" class="form-control I" placeholder="evaluación final" aria-label="evaluacion final" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';

                //auto evaluacion (J)
                $nota = isset($opt_notas[$e][10]) ? $opt_notas[$e][10] : 0;
                // coloco un numero vacio  si la nota es igual a cero
                if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}

                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">auto evaluacion</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="J[]" value="'.$nota.'" class="form-control J" placeholder="auto evaluacion" aria-label="auto evaluacion" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';

                //LOGRO
                $logro = isset($opt_logros[$e]) ? $opt_logros[$e] : "";
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">logro</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="L[]" value="'.$logro.'" class="form-control L" placeholder="logro" aria-label="auto evaluacion" aria-describedby="basic-addon1">';
                echo '</div>';
                echo '</div>';

		
            }
            // si la semana es la del corte intermedio ...
            // la semana donde se realiza la evaluacion intermedia
            elseif ($semana_intermedia) {
                    
                //evaluación de proceso (A)
                $nota = isset($opt_notas[$e][1]) ? $opt_notas[$e][1] : 0;
                                // coloco un numero vacio  si la nota es igual a cero
                if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}

                echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">evaluacion de proceso</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="A[]" value="'.$nota.'" class="form-control A" placeholder="evaluación de proceso" aria-label="evaluación de proceso" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';

                // actividad (B)
                $nota = isset($opt_notas[$e][2]) ? $opt_notas[$e][2] : 0;
                 if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">actividad</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="B[]" value="'.$nota.'" class="form-control B" placeholder="actividad" aria-label="actividad" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';
                //taller (C)
                $nota = isset($opt_notas[$e][3]) ? $opt_notas[$e][3] : 0;
                 if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">taller</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="C[]" value="'.$nota.'"  class="form-control C" placeholder="taller" aria-label="taller" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';
                //tarea (D)
                $nota = isset($opt_notas[$e][4]) ? $opt_notas[$e][4] : 0;
                 if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">tarea</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="D[]" value="'.$nota.'" class="form-control D" placeholder="tarea" aria-label="tarea" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';


                // presentacion personal (E)
		
                $nota = isset($opt_notas[$e][5]) ? $opt_notas[$e][5] : 0;
                 if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">presentacion personal</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="E[]" value="'.$nota.'" class="form-control E" placeholder="quiz" aria-label="presentacion personal" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';


                // actitud(F)
                $nota = isset($opt_notas[$e][6]) ? $opt_notas[$e][6] : 0;
                 if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">actitud</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="F[]" value="'.$nota.'" class="form-control F" placeholder="actitud" aria-label="actitud" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';
		
                //asistencia (G)
                $nota = isset($opt_notas[$e][7]) ? $opt_notas[$e][7] : 0;
                 if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">asistencia</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="G[]" value="'.$nota.'" class="form-control G" placeholder="asistencia" aria-label="asistencia" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';

                //quiz (H)
                $nota = isset($opt_notas[$e][8]) ? $opt_notas[$e][8] : 0;
                 if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}
                //echo "<div class='col-md-1' name=''>";
                echo '<div class="input-group mb-1">';
                echo '<span class="input-group-text" id="addon-wrapping">quiz</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="H[]" value="'.$nota.'" class="form-control H" placeholder="quiz" aria-label="quiz" aria-describedby="basic-addon1">';
                echo '</div>';
                echo '</div>';
            }

            else {
		
                //evaluación de proceso (A)

                $nota = isset($opt_notas[$e][1]) ? $opt_notas[$e][1] : 0;
                 if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}
                echo "<div class='col-md-9' name=''>";
                echo '<div class="input-group mb-2">';
                echo '<span class="input-group-text" id="addon-wrapping">evaluación de proceso</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="A[]"  value="'.$nota.'" class="form-control A" placeholder="evaluación de proceso" aria-label="evaluación de proceso" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';

                // actividad (B)
                $nota = isset($opt_notas[$e][2]) ? $opt_notas[$e][2] : 0;
                 if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}
                //echo "<div class='col-md-2' name=''>";
                echo '<div class="input-group mb-2">';
                echo '<span class="input-group-text" id="addon-wrapping">actividad</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="B[]" value="'.$nota.'" class="form-control B" placeholder="actividad" aria-label="actividad" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';
                //taller (C)
                $nota = isset($opt_notas[$e][3]) ? $opt_notas[$e][3] : 0;
                 if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}
                //echo "<div class='col-md-2' name=''>";
                echo '<div class="input-group mb-2">';
                echo '<span class="input-group-text" id="addon-wrapping">taller</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="C[]" value="'.$nota.'" class="form-control C" placeholder="taller" aria-label="taller" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';
                //tarea (D)
                $nota = isset($opt_notas[$e][4]) ? $opt_notas[$e][4] : 0;
                 if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}
                //echo "<div class='col-md-2' name=''>";
                echo '<div class="input-group mb-2">';
                echo '<span class="input-group-text" id="addon-wrapping">tarea</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="D[]" value="'.$nota.'" class="form-control D" placeholder="tarea" aria-label="tarea" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';

                // presentacion personal (E)
                $nota = isset($opt_notas[$e][5]) ? $opt_notas[$e][5] : 0;
                 if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}

                //echo "<div class='col-md-2' name=''>";
                echo '<div class="input-group mb-2">';
                echo '<span class="input-group-text" id="addon-wrapping">presentación personal</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="E[]" value="'.$nota.'" class="form-control  E" placeholder="presentacion personal" aria-label="presentacion personal" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';

                // actitud (F)
                $nota = isset($opt_notas[$e][6]) ? $opt_notas[$e][6] : 0;
                 if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}
                //echo "<div class='col-md-2' name=''>";
                echo '<div class="input-group mb-2">';
                echo '<span class="input-group-text" id="addon-wrapping">actitud</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="F[]" value="'.$nota.'" class="form-control F" placeholder="actitud" aria-label="actitud" aria-describedby="basic-addon1">';
                echo '</div>';
                //echo '</div>';
		
                //asistencia (G)
                $nota = isset($opt_notas[$e][7]) ? $opt_notas[$e][7] : 0;
                 if ($nota == 0){
                    $nota = "";
                } else
            {$nota = number_format($nota,1);}
                //echo "<div class='col-md-2' name=''>";
                echo '<div class="input-group mb-2">';
                echo '<span class="input-group-text" id="addon-wrapping">asistencia</span>';
                echo '<input type="number" step="0.1" max="5" min="0" name="G[]" value="'.$nota.'" class="form-control G" placeholder="asistencia" aria-label="asistencia" aria-describedby="basic-addon1">';
                echo '</div>';
                echo '</div>';
		
            }

            // cierre de div class row 
            echo  "</div>" ;

            // unset($estudiante);
            // unset($score);
                    
        } //fin de estructura por cada alumno
    
    } // fin de else 
    
    echo "</div>";

    // espacio para logros y  comentarios
    echo "<div id='logros_materia' class='col-md-4'>";
    // contenido

    if($semana_final ) {

	
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
