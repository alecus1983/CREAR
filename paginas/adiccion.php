<?php
session_start();

require_once 'conexion.php';
$link = conectar();



// Pagina transitoria para generar los resultados a actualizar
// RECUPERO DATOS DE EL FORMULARIO
// DE ACTUACCION



$add = $_POST["add"];
$nombres = strtoupper($_POST["i_nombres"]);
$apellidos = strtoupper($_POST["apellidos"]);
$logros = $_POST["Logros"];
$year = $_POST["years"];
$grados = $_POST["id_g"];
$fecha = $_POST["fechas"];
$cedula = $_POST["cedulas"];
$correo = $_POST["correos"];
$telefono = $_POST["telefonos"];
$area = $_POST["areas"];
$id_g = $_POST["id_g"];
$curso = $_POST["id_ms"];
$periodo = $_POST["periodos"];
$estudiante = $_POST["estudiantes"];
$mes = date("m");
$fecha_fin = $_POST["fecha_fins"];
$id_e = $_POST["id_es"];
$id_d = $_SESSION['code'];
$id_m = $_POST["id_ms"];
$id_jornada = $_POST["id_jornada"];//utf8_encode("Mañana");
$bk= "#FFFFFF";// variable de color de fondo de tabla
$fondo = true;
$nota = $_POST['nota'];
$faltas = $_POST['faltas'];
$id_docente = $id_d;
$docente = $_POST["docentes"];


// COMIENZO A GENERAR TABLA

if ($id_d == ""){

    echo " <p style='color:#FF0000';> Se seccion a expirado </p>,  porfavor inicie nuevamente su seccion";
}
else
{


//recupero el nombre del grados

$q = "select * from grados where id_grado = ".$id_g;
$qx	= mysqli_query($link, $q) or die('Consulta fallida tabla grados: ' . mysql_error());
$tabla_grado = mysqli_fetch_array($qx);

$q = "select * from jornada where id_jornada = ".$id_jornada;
$qx	= mysqli_query($link, $q) or die('Consulta fallida tabla jornada: ' . mysql_error());
$tabla_jornada = mysqli_fetch_array($qx);


// VERIFICO LA OPCION SELECCIONADA EN LA TABLA PARA INGREASAR
// 1 - CONSULTAR
// 2 - ADICCIONAR
// 3 - ELIMINAR
// 4 - EDITAR

echo "<table align= 'center' width = '100%' border='0'>";
//echo "El valor de add es : $add";

switch($add) {
    // estructura para insertar  el listado de estudiantes registrados en la base de datos

case 1:

    $q1 = "INSERT INTO alumnos (nombres, apellidos, cedula, fecha,telefono, correo)
			VALUES ('".$nombres."', '".$apellidos."', '".$cedula."', '".$fecha."', '".$telefono."', '".$correo."')";

    $q1x = mysqli_query($link, $q1) or die('Consulta fallida al insertar tabla alumnos: ' . mysql_error());


    $q1 = "Select MAX(id_alumno) id_alumno From alumnos";
    $q1x = mysqli_query($link, $q1);
    $codigo = mysqli_fetch_array($q1x);


    echo "Se ingreso el alumno :<b>".$nombres." ".$apellidos."</b> <br> Codigo: <b>"
                                    .$codigo['id_alumno']."</b><br> Con documento de identidad No: <b>"
                                    .$cedula."</b><br> telefono : <b>"
                                    .$telefono."</b><br> correo electronico :<b>"
                                    .$correo."</b>";

    break;

case 2:
    $q1 = "INSERT INTO docentes (nombres, apellidos, cedula, fecha,celular, correo, materias)
			VALUES ('".$nombres."', '".$apellidos."', '".$cedula."', '".$fecha."', '".$telefono."', '".$correo."', '".$area."')";

    $q1x = mysqli_query($link, $q1) or die('Consulta fallida al insertar tabla docentes: ' . mysql_error());

    //echo "Se ingreso el docente : ".$nombres." ".$apellidos."\n Cedula : ".$cedula."\n fecha : ".$fecha."\n Telefono: ".$telefono."\n Correo :".$correo;


    $q1 = "Select MAX(id_docente) id_docente From docentes";
    $q1x = mysqli_query($link, $q1);
    $codigo = mysqli_fetch_array($q1x);

    echo "Se ingreso el docente : <b>".$nombres." ".$apellidos
                                      ."</b><br> Codigo: <b>".$codigo['id_docente']
                                      ."</b><br> Con documento de identidad No: <b>".$cedula
                                      ."</b><br> telefono : <b>".$telefono
                                      ."</b><br> correo electronico : <b>".$correo."</b>";

    break;


case 3:


case 4:



case 5: // insertar logro

    $q1 = "INSERT INTO logros (logro, id_materia)
			VALUES ('".$logros."', '".$curso."')";
    $q1x = mysqli_query($link, $q1) or die('Consulta fallida al insertar el logro: ' . mysql_error());


    $q1 = "Select MAX(id_logro) id_logro From logros";
    $q1x = mysqli_query($link, $q1);
    $codigo = mysqli_fetch_array($q1x);

    echo "Se inserto  el logro : <i>".$logros
                                     ." </i> con el codigo : <b>"
                                     .$codigo['id_logro']."</b>";

    break;

    /////////////////////////////////////////////////////////////////////////////////

case 6:


case 7:
    $q1 = "INSERT INTO matricula (id_alumno, id_grado, id_jornada, year, mes)
			VALUES (".$id_e.", ".$id_g.", '".$id_jornada."', '".$year."', ".$mes.")";

    $q1x = mysqli_query($link, $q1) or die('Consulta fallida al insertar tabla matriculas: ' . mysql_error());

    //echo "Se ingreso el docente : ".$nombres." ".$apellidos."\n Cedula : ".$cedula."\n fecha : ".$fecha."\n Telefono: ".$telefono."\n Correo :".$correo;


    $q1 = "Select MAX(id) id From matricula";
    $q1x = mysqli_query($link, $q1);
    $codigo = mysqli_fetch_array($q1x);

    echo "Se inserto la matricula codigo <b>: ".$codigo["id"]."</b><br>";

    $q1 = "SELECT A.id_alumno, nombres, apellidos, id_grado, year FROM matricula M INNER JOIN alumnos A ON
					A.id_alumno = M.id_alumno WHERE M.year = '".$year."' AND M.id_grado = ".$id_g." AND M.id_jornada = $id_jornada ORDER BY A.nombres"  ;


    $q1x = mysqli_query($link, $q1) or die('Consulta matricula fallida: ' . mysql_error());;

    echo "<tr bgcolor = '#01DF01'><td  colspan='1', width = '20%' ><font size = 2>CODIGO</font></td>";
    echo "<td colspan='1', width = '40%' ><font size = 2>NOMBRE</font></td>";
    echo "<td colspan='1', width = '40%' ><font size = 2>APELLIDO </font></td></tr>";

    while($dato1 = mysqli_fetch_array($q1x)) {
        echo "<tr bgcolor = '".$bk."' ><td colspan='1', width = '20%' ><font size = 3>".utf8_encode($dato1['id_alumno'])."</font></td>\n";
        echo "<td colspan='1', width = '40%' ><font size = 3>".utf8_encode($dato1['nombres'])."</font></td>\n";
        echo "<td colspan='1', width = '40%' ><font size = 3>".utf8_encode($dato1['apellidos'])."</font></td></tr>\n";


        if($fondo) { $fondo = false;
            $bk= "#C0C0C0";	}
        else {$fondo = true;
				$bk= "#FFFFFF";}
    }

    //echo "Se ingreso el la matricula  :".$nombres." ".$apellidos."\n Codigo: ".$codigo['id']."\n Con documento de identidad No:".$cedula."\n telefono : ".$telefono."\n correo electronico :".$correo;

    break;

case 8: // en este caso se inserta los estudiantes en matricula docente

    $q1 = "INSERT INTO matricula_docente (id_grado, id_materia , id_docente, year,  id_jornada, mes, fecha)
			VALUES ('".$id_g."', '".$curso."', '".$docente."', '".$year."' , '".$id_jornada."', '".$mes."', '".$fecha_fin."')";

    $q1x = mysqli_query($link, $q1) or die('Consulta fallida al insertar tabla matricula docentes: ' . mysql_error());

    //echo "Codigo del grado ".$id_g." Grado ".$curso." Docente ".$id_d." Años ".$year." mes ".$mes." fecha finalizacion ".$fecha_fin;


    $q1 = "Select MAX(id) id From matricula_docente";
    $q1x = mysqli_query($link, $q1);
    $codigo = mysqli_fetch_array($q1x);

    echo "Se inserto la matricula codigo : <b>".$codigo["id"]."</b>";
    echo "<br> Docentes del grado: <b>".$tabla_grado['nombre_g']."</b>";
    echo "<br> Jornada: <b>".utf8_decode($tabla_jornada['jornada'])."</b>";

    $q1 = "SELECT D.id_docente, nombres, apellidos, materia, year, materia FROM (matricula_docente M INNER JOIN docentes D ON
					M.id_docente = D.id_docente) INNER JOIN materia T ON M.id_materia = T.id_materia WHERE M.year = '"
        .$year."' AND M.id_grado = ".$id_g." AND M.id_jornada = $id_jornada ORDER BY D.nombres"  ;


    $q1x = mysqli_query($link, $q1) or die('Consulta matricula fallida: ' . mysql_error());;

    echo "<tr bgcolor = '#04B404'><td  colspan='1', width = '20%' ><font size = 3>CODIGO</font></td>";
    echo "<td colspan='1', width = '40%' ><font size = 3>NOMBRE</font></td>";
	 echo "<td colspan='1', width = '40%' ><font size = 3>MATERIA </font></td></tr>";

			while($dato1 = mysqli_fetch_array($q1x)) {
                echo "<tr bgcolor = '".$bk."' >".
                     "<td colspan='1', width = '20%' ><font size = 1>"
                     .utf8_encode($dato1['id_docente'])
                     ."</font></td>\n";

                echo "<td colspan='1', width = '40%' ><font size = 1>"
                     .utf8_encode($dato1['nombres'])
                     ." ".utf8_encode($dato1['apellidos'])."</font></td>";

                echo "<td colspan='1', width = '40%' ><font size = 1>"
                     .utf8_encode($dato1['materia'])."</font></td></tr>";


                if($fondo) { $fondo = false;
                    $bk= "#C0C0C0";	}
				else {$fondo = true;
                    $bk= "#FFFFFF";}
			}

         break;


		case 9:
			$q1 = "INSERT INTO requisitos (id_grado, id_materia )
			VALUES ('".$id_g."', '".$curso."')";

			$q1x = mysqli_query($link, $q1) or die('Consulta fallida al insertar tabla matricula docentes: ' . mysql_error());

			echo "Se ingreso el requisito para el grado: ".$id_g." en el curso ".$curso;

			$q1 = "SELECT R.id, grado, materia FROM ( requisitos R INNER JOIN grados G ON R.id_grado = G.id_grado)
			INNER JOIN  materia M ON M.id_materia = R.id_materia WHERE id_grado =".$id_g." ORDER BY id_materia" ;

			$q1x = mysqli_query($link, $q1) or die('Consulta fallida q1: ' . mysql_error());;

			$tabla = "requisitos";
			echo "<tr bgcolor = '#FFA000'><td  colspan='1', width = '10%' ><font size = 3>GRADO</font></td>";
			echo "<td colspan='1', width = '10%' ><font size = 3>MATERIA</font></td>";
			echo "<td colspan='1', width = '10%' ><font size = 3>BORRAR</font size = 3></td></tr>";

			while($dato1 = mysqli_fetch_array($q1x)) {
                echo "<tr bgcolor = '".$bk."' ><td colspan='1', width = '10%' ><font size = 3>".utf8_encode($dato1['grado'])."</font></td>\n";
                echo "<td colspan='1', width = '10%' ><font size = 3>".utf8_encode($dato1['materia'])."</font></td>\n";
                echo "<td colspan='1', width = '10%' ><font color = 'red' size = 3> <a href = '#'  onclick = 'borrar(".$dato1['id'].", \"".$tabla."\");'>Borrar</a></font></td></tr>\n";

                if($fondo) { $fondo = false;
                    $bk= "#C0C0C0";	}
                else {$fondo = true;
				$bk= "#FFFFFF";}

            }
            break;



case 11:

    if ($grados == 7 || $grados == 8 || $grados == 9 )

    {

        // se crea la consulta para el primer logro
        $q = "SELECT  DISTINCT  id  FROM calificaciones_$ano WHERE id_alumno = ".$estudiante." AND id_materia =".$id_m." AND periodo =".$periodo." AND year ='".$year."'";

        $qq = mysqli_query($link, $q) or die('Error al contar registros de  calificaciones_$ano  : ' . mysql_error());


        $ids = mysqli_fetch_array($qq);

        if ($logro_1)
                         {
                             $q = "UPDATE calificaciones_$ano SET id_logro = ".$logro_1.", nota = ".$nota.", id_docente = ".$id_docente.", faltas =".$faltas."
                            WHERE id = $ids[0]";

                             //echo "Consulta: $q";

                             // se ejecuta la consulta para el primer logro
                             $qx = mysqli_query($link, $q) or die('Error al actualizar calificaciones_$ano logro 1 : ' . mysql_error());

                         }

        $ids = mysqli_fetch_array($qq);

        if($logro_2 > 0)
        {
            // se crea la consulta para el segundo logro
            $q = "UPDATE calificaciones_$ano SET id_logro = ".$logro_2.", nota = ".$nota.", id_docente = ".$id_docente.", faltas =".$faltas."
                            WHERE id = $ids[0]";

            //echo "Consulta: $q";
            // se ejecuta la consulta para el logro 2
                            $qx = mysqli_query($link, $q) or die('Error al actualizar calificaciones_$ano logro 2: ' . mysql_error());

        }


        $ids = mysqli_fetch_array($qq);

                        if ($logro_3)
                        {

                            // se crea la consulta para el logro 3
                            $q = "UPDATE calificaciones_$ano SET id_logro = ".$logro_3.", nota = ".$nota.", id_docente = ".$id_docente.", faltas =".$faltas."
                            WHERE id = $ids[0]";

                            //echo "Consulta: $q";

                            //se ejecuta la consulta para el logro 3

                            $qx = mysqli_query($link, $q) or die('Error al actualizar calificaciones_$ano : ' . mysql_error());
                        }

                        echo 'Se actualiza la nota con exito!';

                        // se muestra nuevamente la tabla
                        $q1 = "SELECT C.id i, L.id, C.nota, L.logro, C.faltas FROM ( calificaciones_$ano C INNER JOIN logros L ON L.id = C.id_logro)
                        WHERE C.year ='".$year."' AND C.periodo =".$periodo." AND id_alumno =".$estudiante." AND C.id_materia =".$id_m." ORDER BY C.id_materia" ;

                        $q1x = mysqli_query($link, $q1) or die('Consulta fallida, no se encontraron logros: ' . mysql_error());;

                        $tabla = "calificaciones_$ano";
                        echo "<tr bgcolor = '#F0F000'><td  colspan='1', width = '10%' ><font size = 3>CODIGO</font></td>";
                        echo "<td colspan='1', width = '80%' ><font size = 3>LOGRO</font></td>";
                        echo "<td colspan='1', width = '10%' ><font size = 3>NOTA</font></td>";
                        echo "<td colspan='1', width = '10%' ><font size = 3>FALTAS</font></td>";

                        if($admin) {
                            echo "<td colspan='1', width = '10%' ><font size = 3>BORRAR</font size = 3></td></tr>";
                        }
                        else {
                            echo "</tr>";}

                        while($dato1 = mysqli_fetch_array($q1x)) {
                            echo "<tr bgcolor = '".$bk."' ><td colspan='1', width = '10%' ><font size = 3>".utf8_encode($dato1['id'])."</font></td>\n";
                            echo "<td colspan='1', width = '80%' ><font size = 3>".utf8_encode($dato1['logro'])."</font></td>\n";
                            echo "<td colspan='1', width = '10%' ><font size = 3>".utf8_encode($dato1['nota'])."</font></td>\n";
                            echo "<td colspan='1', width = '10%' ><font size = 3>".utf8_encode($dato1['faltas'])."</font></td>\n";

                            if($admin) {
                                echo "<td colspan='1', width = '10%' ><font color = 'red' size = 3> <a href = '#'  onclick = 'borrar(".$dato1['i'].", \"".$tabla."\");'>Borrar</a></font></td></tr>\n";
                            }
                            else {
                                echo "</tr>";}


                            if($fondo) { $fondo = false;
                                $bk= "#C0C0C0";	}
                            else {$fondo = true;
                                $bk= "#FFFFFF";}
                        }

    }

    else {
        // consulta para actualizar los logros

        // valido los datos
        if ($logro_1 == "" ){
            echo "<p style='color:#FF0000';> Por favor seleccione un logro !";
        }
        else if (!is_numeric($nota) ){
            echo "<p style='color:#FF0000';> Por favor ingrese un valor numerico para la nota !";
        }
        else if(!is_numeric($faltas)){
            echo "<p style='color:#FF0000';> Por favor introduzca un valor entero para las faltas:".$faltas;
        }
        else if($id_m == ""){
            echo "<p style='color:#FF0000';> Por favor seleccione una materia !";
        }
        else if ($periodo == ""){
            echo "<p style='color:#FF0000';> Por favor seleccione un periodo !";
        }
        else
        {

            $q1 = "UPDATE calificaciones_$ano SET id_logro = "
                .$logro_1.
                ", nota = ".$nota.
                ", id_docente = ".$id_docente.
                ", faltas =".$faltas.
                ", modificado = '".date("Y-m-d").
                "' WHERE id_alumno = ".$estudiante.
                " AND id_materia =".$id_m.
                " AND periodo =".$periodo.
                " AND year =".$year;

            //echo $q1;

            //echo $q1;

            $q1x = mysqli_query($link, $q1) or die('Error al actualizar calificaciones_$ano logro 1 en formato primaria : ' . mysql_error());

            echo 'Se actualiza la nota con exito!';

            // se muestra nuevamente la tabla
            $q1 = "SELECT C.id i, L.id, C.nota, L.logro, C.faltas FROM ( calificaciones_$ano C INNER JOIN logros L ON L.id = C.id_logro)
			WHERE C.year ='".$year."' AND C.periodo =".$periodo." AND id_alumno =".$estudiante." AND C.id_materia =".$id_m." ORDER BY C.id_materia" ;

            $q1x = mysqli_query($link, $q1) or die('Consulta fallida, no se encontraron logros: ' . mysql_error());;

            $tabla = "calificaciones_$ano";
            echo "<tr bgcolor = '#F0F000'><td  colspan='1', width = '10%' ><font size = 3>CODIGO</font></td>";
            echo "<td colspan='1', width = '80%' ><font size = 3>LOGRO</font></td>";
            echo "<td colspan='1', width = '10%' ><font size = 3>NOTA</font></td>";
            echo "<td colspan='1', width = '10%' ><font size = 3>FALTAS</font></td>";

            if($admin) {
                echo "<td colspan='1', width = '10%' ><font size = 3>BORRAR</font size = 3></td></tr>";
            }
            else {
                echo "</tr>";}

            while($dato1 = mysqli_fetch_array($q1x)) {
                echo "<tr bgcolor = '".$bk."' ><td colspan='1', width = '10%' ><font size = 3>".utf8_encode($dato1['id'])."</font></td>\n";
                echo "<td colspan='1', width = '80%' ><font size = 3>".utf8_encode($dato1['logro'])."</font></td>\n";
                echo "<td colspan='1', width = '10%' ><font size = 3>".utf8_encode($dato1['nota'])."</font></td>\n";
                echo "<td colspan='1', width = '10%' ><font size = 3>".utf8_encode($dato1['faltas'])."</font></td>\n";

                if($admin) {
                    echo "<td colspan='1', width = '10%' ><font color = 'red' size = 3> <a href = '#'  onclick = 'borrar(".$dato1['i'].", \"".$tabla."\");'>Borrar</a></font></td></tr>\n";
                }
                else {
                    echo "</tr>";}


                if($fondo) { $fondo = false;
                    $bk= "#C0C0C0";	}
                else {$fondo = true;
                    $bk= "#FFFFFF";}
            }
		} // fin del else para las validaciones
    }
    break;

case 12:


                    echo 'Se ingresaron correctamente los datos';

                break;
	}


	echo	"</table>";
}

        desconectar($link);

	?>
