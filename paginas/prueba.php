<?php
	
    require_once 'conexion.php';
    
    $link = conectarDB();
    // Pagina transitoria para generar los resultados a actualizar
    // Con las notas de los estudiantes
	
	
	
	// recupero por el método POST las variables para realizar la consulta
        $year = 2016;//$_POST["year"];
        $periodo = 1;//$_POST["periodo"];
        $grado = 5;//$_POST["grado"];
	$id_e = 52;//$_POST["id_e"];
	
        
	$bk= "#FFFFFF";// variable de color de fondo de tabla
	$fondo = true;

        // genero el inicio de la tabla
	echo "<table align= 'center' width = '800' border='0'>";
        
        // cargo en $q1 el texto de la consulta a realizar en mysql
									
        $q1 = "SELECT  A.nombres, A.apellidos,  M.materia , C.nota, C.periodo , C.year 
                
        FROM 

        ((((calificaciones  C INNER JOIN alumnos  A ON C.id_alumno = A.id)

        INNER JOIN logros ON C.id_logro = logros.id)

        INNER JOIN docentes ON C.id_docente = docentes.id) 

        INNER JOIN materia  M ON C.id_materia = M.id) 

        INNER JOIN matricula ON C.id_alumno = matricula.id_alumno 

        WHERE (
            C.id_alumno = ".$id_e."
            AND C.year = ".$year."
            AND C.periodo = ".$periodo.")";
            
        // realizo la consulta a la base de datos si falla me muestra el error
        $q1x = mysql_query($q1, $link) or die('Consulta fallida q1: ' . mysql_error());;

	$tabla = "logros";				
	echo "<tr bgcolor = '#01DF01'><td  colspan='1', width = '20%' ><font size = 3>Nombre</font></td>";													
	echo "<td colspan='1', width = '20%' ><font size = 3>Apellido</font></td>";
        echo "<td colspan='1', width = '30%' ><font size = 3>Materia</font></td>";
        echo "<td colspan='1', width = '10%' ><font size = 3>Nota</font></td>";
        echo "<td colspan='1', width = '10%' ><font size = 3>Periodo</font></td>";
	echo "<td colspan='1', width = '10%' ><font size = 3>A&ntilde;o</font ></td></tr>";
				
				
	while($dato = mysql_fetch_array($q1x)) {
            echo "<tr bgcolor = '".$bk."' ><td colspan='1', width = '20%' ><font size = 3>".$dato['nombres']."</font></td>\n";													
            echo "<td colspan='1', width = '20%' ><font size = 3>".utf8_encode($dato['apellidos'])."</font></td>\n";
            echo "<td colspan='1', width = '30%' ><font size = 3>".utf8_encode($dato['materia'])."</font></td>\n";
            echo "<td colspan='1', width = '10%' ><font size = 3>".utf8_encode($dato['nota'])."</font></td>\n";
            echo "<td colspan='1', width = '10%' ><font size = 3>".utf8_encode($dato['periodo'])."</font></td>\n";
            echo "<td colspan='1', width = '10%' > <font size = 3>".utf8_encode($dato['year'])."</font></td></tr>\n";
            if($fondo) { $fondo = false;
                $bk= "#C0C0C0";	}
            else {$fondo = true;
		$bk= "#FFFFFF";}													
        }
								
		
		
		
	echo	"</table>";	
		
		//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
	
	
	/*Mysql_close() se usa para cerrar la conexi�n a la Base de datos y es 
	**necesario hacerlo para no sobrecargar al servidor, bueno en el caso de
	**programar una aplicaci�n que tendr� muchas visitas ;) .*/
	//mysql_close();
   
   exit ();
?>