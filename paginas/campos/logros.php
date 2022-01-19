	<?php
	
	$link = 	mysql_connect('localhost', 'imcrea_admin', 'Caracter15');
	mysql_select_db('imcrea_boletines', $link);	
	
	
	
	// Pagina transitoria para generar los resultados a actualizar
	// RECUPERO DATOS DE EL FORMULARIO 
	// DE ACTUACCION
	
	
	

		$id_logro = $_POST["id_ls"];
		$data = array();
		
		$q1 = "SELECT * FROM logros WHERE  id = ".$id_logro;
		$q1x = mysql_query($q1, $link) or die('Consulta fallida q1: ' . mysql_error());;

		$dato1 = mysql_fetch_array($q1x);
		
		$data['id'] = $dato1['id'];
		$data['logro'] = utf8_encode($dato1['logro']);
		
		//echo "El codigo es :".$data['id'];
		//echo "\nEl el logro  es :".$data['logro'];
		echo json_encode($data);
	
		//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
		mysql_free_result($q1x);

		/*Mysql_close() se usa para cerrar la conexión a la Base de datos y es 
		**necesario hacerlo para no sobrecargar al servidor, bueno en el caso de
		**programar una aplicación que tendrá muchas visitas ;) .*/
		mysql_close();
   
  	 exit ();
   
		
				
	?>