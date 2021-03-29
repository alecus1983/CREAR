<?php
session_start();
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
$id_g = $_POST["id_g"];
$periodo = $_POST["periodos"];
$estudiante = $_POST["estudiantes"];
$mes = date("m");
//$id_e = $_POST["id_es"];
//$id_d = $_POST["id_ds"];
$id_m = $_POST["id_ms"];
//$materia = $_POST[""];
$bk= "#FFFFFF";// variable de color de fondo de tabla
$fondo = true;
$admin = $_SESSION['admin'];
$id_jornada = $_POST["jornada"];
$corte = $_POST["corte"];


// COMIENZO A GENERAR TABLA



// VERIFICO LA OPCION SELECCIONADA EN LA TABLA PARA INGREASAR
// 1 - CONSULTAR
// 2 - ADICCIONAR
// 3 - ELIMINAR
// 4 - EDITAR
// consulta para recuperar el nombre del grado
$qg = "SELECT * FROM grados  WHERE id_grado = ".$id_g;
//echo $qg."<br>";
$reg = mysqli_query( $link, $qg) or die ("Problemas  encontrar el grado: ".mysql_error());
$grado = mysqli_fetch_array($reg);


// consulta para recuplerar el nombre de la jornada
$qj = "select * from jornada where id_jornada =".$id_jornada;
// mostrar


//echo $qj."<br>";
 $reg = mysqli_query( $link, $qj );// or  die("Problemas  en la tabla jornada:".mysql_error());
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

    $q1x = mysqli_query( $link, $q1) or die('Consulta fallida q1: ' . mysql_error());;
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
    $q1x = mysqli_query( $link, $q1) or die('Consulta fallida q1: ' . mysql_error());;
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
    or die('Consulta fallida al buscar materias: ' . mysqli_error());;

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
    $q1x = mysqli_query( $link, $q1) or die('Consulta fallida q1: ' . mysql_error());;

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
    $q1x = mysqli_query( $link, $q1) or die('Consulta fallida q1 (adicionar logros ): ' . mysqli_error());;


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

case 7:

    // matriculas de alumnos
    echo "Estudiantes matriculados en el grado <b>"
        .$grado['nombre_g']
        ."</b> en la jornada de la  <b>  "
        .$jorn['jornada']
        ."</b><br><br>";// obtengo el nombre del tgrado


    $q1 = "SELECT M.id i, A.id_alumno, nombres, apellidos, id_grado, year FROM matricula M INNER JOIN alumnos A ON
			A.id_alumno = M.id_alumno WHERE M.year = '".$year."' AND M.id_grado = ".$id_g." AND M.id_jornada = $id_jornada ORDER BY A.apellidos";

    $q1x = mysqli_query( $link, $q1) or die('Consulta fallida q1: ' . mysql_error());;

    $tabla = "matricula";



    echo "<tr bgcolor = '#FFB000'><td  colspan='1', width = '20%' ><font size = 2>CODIGO</font></td>";
    echo "<td colspan='1', width = '40%' ><font size = 2>NOMBRE</font></td>";
    echo "<td colspan='1', width = '40%' ><font size = 2>APELLIDO </font></td>";

    if($admin) {
        echo "<td colspan='1', width = '10%' ><font size = 2>BORRAR</font size = 2></td></tr>";
    }
    else {
        echo "</tr>";}


    while($dato1 = mysqli_fetch_array($q1x)) {
        echo "<tr bgcolor = '".$bk."' ><td colspan='1', width = '20%' ><font size = 2>".$dato1['id_alumno']."</font></td>\n";
        echo "<td colspan='1', width = '40%' ><font size = 2>".$dato1['nombres']."</font></td>\n";
        echo "<td colspan='1', width = '40%' ><font size = 2>".$dato1['apellidos']."</font></td>\n";


        if($admin) {
            echo "<td colspan='1', width = '10%' ><font color = 'red' size = 2> <a href = '#'  onclick = 'borrar(".$dato1['i'].", \"".$tabla."\");'>Borrar</a></font></td></tr>\n";
        }
        else {
            echo "</tr>";}


        if($fondo) { $fondo = false;
            $bk= "#C0C0C0";	}
        else {$fondo = true;
            $bk= "#FFFFFF";}
    }

    break;




case 8:
    // matriculas de docentes

    // consulta desarrollada para  generar los docentes  matriculados y las materias a las que el corresponden
    $q1 = "SELECT M.id i, D.id_docente, nombres, apellidos, id_grado, year, T.materia FROM (matricula_docente M INNER JOIN docentes D ON
			D.id_docente = M.id_docente) INNER JOIN materia T ON T.id_materia = M.id_materia WHERE M.year = '".$year."' AND M.id_grado = "
        .$id_g." AND M.id_jornada = $id_jornada ORDER BY D.nombres";

    $q1x = mysqli_query( $link, $q1) or die('Consulta fallida q1: ' . mysql_error());;

    $tabla = "matricula_docente";

    echo "<tr bgcolor = '#FFB000'><td  colspan='1', width = '20%' ><font size = 2>NOMBRE</font></td>";
    echo "<td colspan='1', width = '40%' ><font size = 2>APELLIDO</font></td>";
    echo "<td colspan='1', width = '40%' ><font size = 2>MATERIA</font></td>";

    if($admin) {
        echo "<td colspan='1', width = '10%' ><font size = 2>BORRAR</font size = 2></td></tr>";
			}
    else {
        echo "</tr>";}


    while($dato1 = mysqli_fetch_array($q1x)) {
        echo "<tr bgcolor = '".$bk."' ><td colspan='1', width = '20%' ><font size = 2>".$dato1['nombres']."</font></td>\n";
        echo "<td colspan='1', width = '40%' ><font size = 2>".$dato1['apellidos']."</font></td>\n";
        echo "<td colspan='1', width = '40%' ><font size = 2>".$dato1['materia']."</font></td>\n";

        if($admin) {
            echo "<td colspan='1', width = '10%' ><font color = 'red' size = 2> <a href = '#'  onclick = 'borrar("
                .$dato1['i'].", \"".$tabla."\");'>Borrar</a></font></td></tr>\n";
				}
        else {
            echo "</tr>";}


        if($fondo) { $fondo = false;
            $bk= "#C0C0C0";	}
        else {$fondo = true;
            $bk= "#FFFFFF";}
    }

    break;



case 9:
    // Requisitos de la materia

    $q1 = "SELECT R.id, grado, materia FROM ( requisitos R INNER JOIN grados G ON R.id_grado = G.id_grado)
		INNER JOIN  materia M ON M.id_materia = R.id_materia WHERE R.id_grado =".$id_g." ORDER BY R.id_materia" ;

    $q1x = mysqli_query( $link, $q1) or die('Consulta fallida q1: ' . mysql_error());;

    $tabla = "requisitos";
    echo "<tr bgcolor = '#FFA000'><td  colspan='1', width = '10%' ><font size = 2>GRADO</font></td>";
    echo "<td colspan='1', width = '10%' ><font size = 2>MATERIA</font></td>";

    if($admin) {
		echo "<td colspan='1', width = '10%' ><font size = 2>BORRAR</font size = 2></td></tr>";
    }
    else {
		echo "</tr>";}


    while($dato1 = mysqli_fetch_array($q1x)) {
        echo "<tr bgcolor = '".$bk."' ><td colspan='1', width = '10%' ><font size = 2>"
                              .$dato1['grado']."</font></td>\n";
        echo "<td colspan='1', width = '10%' ><font size = 2>".$dato1['materia']."</font></td>\n";
        if($admin) {
			echo "<td colspan='1', width = '10%' ><font color = 'red' size = 2> <a href = '#'  onclick = 'borrar("
                .$dato1['id'].", \"".$tabla."\");'>Borrar</a></font></td></tr>\n";
        }
        else {
			echo "</tr>";}


        if($fondo) { $fondo = false;
            $bk= "#C0C0C0";	}
        else {$fondo = true;
            $bk= "#FFFFFF";}

    }

    break;


case 11:
    // Requisitos de la materia

    $q1 = "SELECT C.id i, L.id_logro, C.nota, L.logro, C.faltas "
        ." FROM ( calificaciones C INNER JOIN logros L ON L.id_logro = C.id_logro) 	WHERE C.year ='"
        .$year."' AND C.periodo =".$periodo." AND id_alumno ="
        .$estudiante." AND C.id_materia =".$id_m." ORDER BY C.id_materia" ;

    $q1x = mysqli_query( $link, $q1) or die('Consulta fallida, no se encontraron logros: ' . mysql_error());;

    $tabla = "calificaciones";
    echo "<tr bgcolor = '#F0F000'><td  colspan='1', width = '10%' ><font size = 2>CODIGO</font></td>";
    echo "<td colspan='1', width = '80%' ><font size = 2>LOGRO</font></td>";
    echo "<td colspan='1', width = '10%' ><font size = 2>NOTA</font></td>";
    echo "<td colspan='1', width = '10%' ><font size = 2>FALTAS</font></td>";

    if($admin) {
        echo "<td colspan='1', width = '10%' ><font size = 2>BORRAR</font size = 2></td></tr>";
    }
    else {
        echo "</tr>";}

    while($dato1 = mysqli_fetch_array($q1x)) {
        echo "<tr bgcolor = '"
            .$bk."' ><td colspan='1', width = '10%' ><font size = 2>"
            .$dato1['id']."</font></td>\n";
        echo "<td colspan='1', width = '80%' ><font size = 2>"
            .$dato1['logro']."</font></td>\n";
        echo "<td colspan='1', width = '10%' ><font size = 2>"
            .$dato1['nota']."</font></td>\n";
        echo "<td colspan='1', width = '10%' ><font size = 2>"
            .$dato1['faltas']."</font></td>\n";

        if($admin) {
            echo "<td colspan='1', width = '10%' ><font color = 'red' size = 3> "
                ."<a href = '#'  onclick = 'borrar("
                .$dato1['i'].", \"".$tabla
                ."\");'>Borrar</a></font></td></tr>\n";
        }
        else {
            echo "</tr>";}


        if($fondo) { $fondo = false;
            $bk= "#C0C0C0";	}
        else {$fondo = true;
					$bk= "#FFFFFF";}
    }
    break;
}


echo	"</table>";


//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
desconectar($link);

exit ();



?>
