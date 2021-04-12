<?php
session_start();
// if(!isset($_SESSION['usuario']))
// {
//   session_destroy();
//   //Sila secciÃ³n no esta iniciada entonces retorna a la pagina principal
//   header('Location:login_boletines.php');
//   //termina el programa php
//   exit();
// }

require_once 'conexion.php';
$link = conectar();



// Se fija el grupo de caracteres en UTF 8

//printf("Conjunto de caracteres inicial: %s\n", $link->character_set_name());

/* cambiar el conjunto de caracteres a utf8 */
if (!$link->set_charset("utf8")) {
    printf("Error cargando el conjunto de caracteres utf8: %s\n", $link->error);
    exit();
} else {
      //printf("Conjunto de caracteres actual: %s\n", $link->character_set_name());
}

// Pagina transitoria para generar los resultados a actualizar
// RECUPERO DATOS DE EL FORMULARIO
// DE ACTUACCION

// recibe parametros por el método POST
$opcion = $_POST["opcion"];
$nombres = $_POST["i_nombres"];
$apellidos = $_POST["apellidos"];
$logros = $_POST["Logros"];
$year = $_POST["years"];

if(isset($_POST["id_g"])){
    $id_g = $_POST["id_g"];
}else{
    // si no hay valor pongo -1
    $id_g = "-1";  
} 

$periodo = $_POST["periodos"];
$estudiante = $_POST["estudiantes"];
$mes = date("m");
$id_m = $_POST["id_ms"];
$bk= "#FFFFFF";// variable de color de fondo de tabla
$fondo = true;



$id_jornada = $_POST["jornada"];
$corte = $_POST["corte"];

if (isset($_SESSION['admin'])){
    $admin = $_SESSION['admin'];



// COMIENZO A GENERAR TABLA

// VERIFICO LA OPCION SELECCIONADA EN LA TABLA PARA INGREASAR
// 1 - CONSULTAR
// 2 - ADICCIONAR
// 3 - ELIMINAR
// 4 - EDITAR
// consulta para recuperar el nombre del grado
$qg = "SELECT * FROM grados  WHERE id_grado = ".$id_g;
//echo $qg."<br>";
$reg = mysqli_query( $link, $qg) or die ("Problemas  encontrar el grado: ".mysqli_error($link));
$grado = mysqli_fetch_array($reg);


// consulta para recuplerar el nombre de la jornada
$qj = "select * from jornada where id_jornada =".$id_jornada;
// mostrar

//echo $qj."<br>";
 $reg = mysqli_query( $link, $qj );// or  die("Problemas  en la tabla jornada:".mysqli_error($link));
$jorn = mysqli_fetch_array($reg,MYSQLI_ASSOC);


// se crea el emcabezado de la tabla
echo "<table class='table table-sm caption-top table-hover'
        data-search='true'
        data-toggle='table'
        style='font-size: 14px;'>";

// mediante las condiciones aqui descritas se hace un cruze entre las opciones para  seleccionar y para adiccionar campos
// y todo de guarda en la variable $opcion

// estructura de seleccio la cual conmuta de acuerdo
//  a la opcion precargada
switch($opcion) {
    // estructura para consultar el listado de estudiantes registrados en la base de datos
case 1:
    $q1 = "SELECT *
				FROM alumnos a
				WHERE a.nombres like '%".$nombres."%'
				AND a.apellidos like '%".$apellidos."%' ORDER BY apellidos";

    // echo $q1;

    $q1x = mysqli_query( $link, $q1) or die('Consulta fallida q1: ' . mysqli_error($link));;
    $tabla = "alumnos";
    echo "<caption>Lista de alumnos</caption>";
    echo "<thead>";
    echo "<tr><th>CODIGO</th>";
    echo "<th>NOMBRE</th>";
    echo "<th>APELLIDOS</th>";

    if($admin) {
        echo "<th>BORRAR</th></tr></thead><tbody>";
    }
    else {
        echo "</tr></thead><tbody>";}

    while($dato1 = mysqli_fetch_array($q1x)) {


        echo "<tr><td>".$dato1['id_alumno']."</td>\n";
        echo "<td>".ucwords(strtolower($dato1['nombres']))."</td>\n";
        echo "<td>".ucwords(strtolower($dato1['apellidos']))."</td>\n";

        if($admin) {
            echo "<td> <a href = '#'  onclick = 'borrar("
                .$dato1['id_alumno'].", \"".$tabla."\");'>Borrar</a></td></tr>\n";
        }
        else {
            echo "</tr>";}

    }

    echo "</tbody>";
    break;

case 2:
    /// se consulta el listado de docentes

    $q1 = "SELECT * FROM docentes WHERE nombres like '%".$nombres."%' AND apellidos like '%".$apellidos."%'";
    $q1x = mysqli_query( $link, $q1) or die('Consulta fallida al obtener el nombre: '. mysqli_error($link));
    $tabla = "docentes";
    echo "<caption>Lista de docentes</caption>";
    echo "<thead>";
    echo "<tr><th>CODIGO</th>";
    echo "<th>NOMBRE</th>";
    echo "<th>APELLIDOS</th>";

    if($admin) {
        echo "<th>BORRAR</th></tr></thead><tbody>";
    }
    else {
        echo "</tr></thead><tbody>";}

    while($dato1 = mysqli_fetch_array($q1x)) {
        echo "<tr><td>".$dato1['id_docente']."</td>\n";
        echo "<td>".ucwords(strtolower($dato1['nombres']))."</td>\n";
        echo "<td>".ucwords(strtolower($dato1['apellidos']))."</td>\n";

        if($admin) {
            echo "<td><a href = '#'  onclick = 'borrar(".$dato1['id_docente'].", \"".$tabla."\");'>Borrar</a></td></tr>\n";
        }
        else {
            echo "</tr>";}
    }
    echo "<tbody>";
    break;


case 3:
    //En esta seccion se muestra el contenido de las materias";

    $q1 = "SELECT * FROM materia";
    $q1x = mysqli_query( $link, $q1)
    or die('Consulta fallida al buscar materias: ' . mysqli_error($link));;

    $tabla = "materia";
    echo "<caption>Lista de materias</caption>";
    echo "<thead>";
    echo "<tr><th>CODIGO</th>";
    echo "<th>MATERIA</th>";
    echo "<th>AREA</th>";
    echo "<th>CODIGO DE AREA</th>";
    echo "<th>INTENSIDAD HORARIA</th></tr></thead><tbody>";

    // Estrucutura de  repeticion para mostrar las materias
    while($dato1 = mysqli_fetch_array($q1x)) {
        echo "<tr><td>".$dato1['id_materia']."</td>\n";
        echo "<td>".$dato1['materia']."</td>\n";
        echo "<td>".$dato1['area']."</td>\n";
        echo "<td>".$dato1['id_area']."</td>\n";
        echo "<td>".$dato1['ih']."</td></tr>\n";

    }
    echo "<tbody>";

    break;


case 4:
    //Estructura que lista las areas a que contienen las materias

    $q1 = "SELECT DISTINCT area , id_area FROM materia";
    $q1x = mysqli_query( $link, $q1) or die('Consulta fallida q1: ' . mysqli_error($link));;

    echo "<caption>Lista de &aacute;reas</caption>";
    echo "<thead>";
    echo "<tr><th>CODIGO</th>";
    echo "<th>AREA</th></tr></thead><tbody>";

    while($dato1 = mysqli_fetch_array($q1x)) {
        echo "<tr><td>".$dato1['id_area']."</td>\n";
        echo "<td>".$dato1['area']."</td></tr>\n";
      }
      echo "<tbody>";
    break;


// en el caso de consultar los logros
case 5:
    // consulta en la tabla de logros
    $q1 = "SELECT * FROM logros WHERE logro like '%".trim($logros)."%'
				AND id_materia = ".$id_m." ORDER BY id_logro";
    $q1x = mysqli_query( $link, $q1) or die('Consulta fallida q1 (adicionar logros ): ' . mysqli_error($link));;


    $tabla = "logros";
    echo "<caption>Tabla de logros</caption>";
    echo "<thead>";
    echo "<tr><th>CODIGO</th>";
    echo "<th>LOGRO</th>";

    if($admin) {
        echo "<th>BORRAR</th></tr></thead><tbody>";
    }
    else {
        echo "</tr></thead><tbody>";}

    while($dato1 = mysqli_fetch_array($q1x)) {
        echo "<tr><td>".$dato1['id_logro']."</td>\n";
        echo "<td>".$dato1['logro']."</td>\n";

        if($admin) {
            echo "<td><a href = '#'  onclick = 'borrar(".$dato1['id_logro'].", \"".$tabla."\");'>Borrar</a></td></tr>\n";
        }
        else {
            echo "</tr>";}

    }

    echo "<tbody>";

    break;
    
case 6: 
    if( $id_g == "-1"){
        echo "<div class='alert alert-danger' role='alert'>Seleccione un grado por favor ...</div>";
    } 
    break;

case 7:

    if( $id_g == "-1"){
        echo "<d iv class='alert alert-danger' role='alert'>Seleccione un grado por favor ...</d>";
    } else {
        
    
    // matriculas de alumnos
    echo "Estudiantes matriculados en el grado <b>"
        .$grado['nombre_g']
        ."</b> en la jornada de la  <b>  "
        .$jorn['jornada']
        ."</b><br><br>";// obtengo el nombre del tgrado


    $q1 = "SELECT M.id i, A.id_alumno, nombres, apellidos, id_grado, year FROM matricula M INNER JOIN alumnos A ON
			A.id_alumno = M.id_alumno WHERE M.year = '".$year."' AND M.id_grado = ".$id_g." AND M.id_jornada = $id_jornada ORDER BY A.apellidos";

    $q1x = mysqli_query( $link, $q1) or die('Consulta fallida q1: ' . mysqli_error($link));;

    $tabla = "matricula";


    echo "<caption>Alumnos matriculados por grado</caption>";
    echo "<thead>";
    echo "<tr><th>CODIGO</th>";
    echo "<th>NOMBRE</th>";
    echo "<th>APELLIDO </th>";

    if($admin) {
        echo "<th>BORRAR</th></tr></thead><tbody>";
    }
    else {
        echo "</tr><tbody>";}


    while($dato1 = mysqli_fetch_array($q1x)) {
        echo "<tr><td>".$dato1['id_alumno']."</td>\n";
        echo "<th>".$dato1['nombres']."</th>\n";
        echo "<th>".$dato1['apellidos']."</th>\n";


        if($admin) {
            echo "<th><a href = '#'  onclick = 'borrar(".$dato1['i'].", \"".$tabla."\");'>Borrar</a></th></tr>\n";
        }
        else {
            echo "</tr>";}

    }

    echo "</tbody>";
    }

    break;




case 8:
    // matriculas de docentes

    // consulta desarrollada para  generar los docentes  matriculados y las materias a las que el corresponden
    $q1 = "SELECT M.id i, D.id_docente, nombres, apellidos, id_grado, year, T.materia FROM (matricula_docente M INNER JOIN docentes D ON
			D.id_docente = M.id_docente) INNER JOIN materia T ON T.id_materia = M.id_materia WHERE M.year = '".$year."' AND M.id_grado = "
        .$id_g." AND M.id_jornada = $id_jornada ORDER BY D.nombres";

    $q1x = mysqli_query( $link, $q1) or die('Consulta fallida q1: ' . mysqli_error($link));;

    $tabla = "matricula_docente";

    echo "<caption>Docentes matriculados</caption>";
    echo "<thead>";
    echo "<tr><th>NOMBRE</th>";
    echo "<th>APELLIDO</th>";
    echo "<th>MATERIA</th>";

    if($admin) {
        echo "<th>BORRAR</th></tr></thead><tbody>";
			}
    else {
        echo "</tr></thead><tbody>";}


    while($dato1 = mysqli_fetch_array($q1x)) {
        echo "<tr><td>".$dato1['nombres']."</td>\n";
        echo "<td>".$dato1['apellidos']."</td>\n";
        echo "<td>".$dato1['materia']."</td>\n";

        if($admin) {
            echo "<td><a href = '#'  onclick = 'borrar("
                .$dato1['i'].", \"".$tabla."\");'>Borrar</a></td></tr>\n";
				}
        else {
            echo "</tr>";}


    }

    echo "</tbody>";

    break;



case 9:
    // Requisitos de la materia

    $q1 = "SELECT R.id, grado, materia FROM ( requisitos R INNER JOIN grados G ON R.id_grado = G.id_grado)
		INNER JOIN  materia M ON M.id_materia = R.id_materia WHERE R.id_grado =".$id_g." ORDER BY R.id_materia" ;

    $q1x = mysqli_query( $link, $q1) or die('Consulta fallida q1: ' . mysqli_error($link));;

    $tabla = "requisitos";

    echo "<caption>Materias requeridas para cada grado</caption>";
    echo "<thead>";
    echo "<tr><th>GRADO</th>";
    echo "<th>MATERIA</th>";

    if($admin) {
		echo "<td>BORRAR</td></tr></thead><tbody>";
    }
    else {
		echo "</tr></thead><tbody>";}


    while($dato1 = mysqli_fetch_array($q1x)) {
        echo "<tr><td>".$dato1['grado']."</td>\n";
        echo "<td>".$dato1['materia']."</td>\n";
        if($admin) {
			echo "<td><a href = '#'  onclick = 'borrar("
                .$dato1['id'].", \"".$tabla."\");'>Borrar</a></td></tr>\n";
        }
        else {
			echo "</tr>";}


    }

    echo "</tbody>";

    break;


case 11:
    // Requisitos de la materia

    $q1 = "SELECT C.id i, L.id_logro, C.nota, L.logro, C.faltas "
        ." FROM ( calificaciones C INNER JOIN logros L ON L.id_logro = C.id_logro) 	WHERE C.year ='"
        .$year."' AND C.periodo =".$periodo." AND id_alumno ="
        .$estudiante." AND C.id_materia =".$id_m." ORDER BY C.id_materia" ;

    $q1x = mysqli_query( $link, $q1) or die('Consulta fallida, no se encontraron logros: ' . mysqli_error($link));;

    $tabla = "calificaciones";

    echo "<caption>Alumnos matriculados por grado</caption>";
    echo "<thead>";
    echo "<tr><td>CODIGO</td>";
    echo "<td>LOGRO</td>";
    echo "<td>NOTA</td>";
    echo "<td>FALTAS</td>";

    if($admin) {
        echo "<td>BORRAR</td></tr>";
    }
    else {
        echo "</tr>";}

    while($dato1 = mysqli_fetch_array($q1x)) {
        echo "<tr><td>"
            .$dato1['id']."</td>\n";
        echo "<td>"
            .$dato1['logro']."</td>\n";
        echo "<td>"
            .$dato1['nota']."</td>\n";
        echo "<td>"
            .$dato1['faltas']."</td>\n";

        if($admin) {
            echo "<td>"
                ."<a href = '#'  onclick = 'borrar("
                .$dato1['i'].", \"".$tabla
                ."\");'>Borrar</a></td></tr>\n";
        }
        else {
            echo "</tr>";}


    }

    echo "</tbody>";

    break;
    
    case 12:
    
    break;
}


echo	"</table>";
} else {
    echo "<div> su secci&oacute;n ha expirado ...</div>";
    $admin = 0;
}

//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
desconectar($link);

exit ();



?>
