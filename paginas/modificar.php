<?php
		
	$link = 	mysql_connect('localhost', 'imcrea_admin', 'Caracter15');
	mysql_select_db('imcrea_boletines', $link);	
	
	
	
	// Pagina transitoria para generar los resultados a actualizar
	// RECUPERO DATOS DE EL FORMULARIO 
	// DE ACTUACCION
	
	
	

	$id_m = $_POST["cursos"];
	
	$bk= "#FFFFFF";// variable de color de fondo de tabla
	$fondo = true;

	echo "<table align= 'center' width = '800' border='0'>";
									
				$q1 = "SELECT * FROM logros WHERE  id_materia = ".$id_m." ORDER BY id";
				$q1x = mysql_query($q1, $link) or die('Consulta fallida q1: ' . mysql_error());;

				$tabla = "logros";				
				echo "<tr bgcolor = '#01DF01'><td  colspan='1', width = '10%' ><font size = 3>CODIGO</font></td>";													
				echo "<td colspan='1', width = '80%' ><font size = 3>LOGRO</font></td>";
				echo "<td colspan='1', width = '10%' ><font size = 3>CALIFICAR</font size = 3></td></tr>";
				
				
				while($dato1 = mysql_fetch_array($q1x)) {
				echo "<tr bgcolor = '".$bk."' ><td colspan='1', width = '10%' ><font size = 3>".$dato1['id']."</font></td>\n";													
				echo "<td colspan='1', width = '80%' ><font size = 3>".utf8_encode($dato1['logro'])."</font></td>\n";
				echo "<td colspan='1', width = '10%' > <input type='button' value= '' id = '".$dato1['id']."' onclick = \"alert('".$dato1['id']."');\" ></td></tr>\n";
						if($fondo) { $fondo = false;
							$bk= "#C0C0C0";	}
						else {$fondo = true;
							$bk= "#FFFFFF";}													
				}
								
		
				
	echo	"</table>";	
		
		//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
	mysql_free_result($q1x);
	
	/*Mysql_close() se usa para cerrar la conexión a la Base de datos y es 
	**necesario hacerlo para no sobrecargar al servidor, bueno en el caso de
	**programar una aplicación que tendrá muchas visitas ;) .*/
	mysql_close();
   
   exit ();
?>