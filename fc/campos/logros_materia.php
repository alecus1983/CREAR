	<?php

	$link = 	mysql_connect('localhost', 'imcrea_admin', 'Caracter15');
	mysql_select_db('imcrea_boletines', $link);


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




		$id_logro = $_POST["cursos"];
		$q1 = "SELECT * FROM logros WHERE  id = ".$id_logro;
		$q1x = mysql_query($q1, $link) or die('Consulta fallida q1: ' . mysql_error());;

		$dato1 = mysql_fetch_array($q1x);

		$data['id'] = $dato1['id'];
		$data['logro'] = $dato1['logro'];

		echo json_encode($data);

		//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
		mysql_free_result($q1x);

	/*Mysql_close() se usa para cerrar la conexión a la Base de datos y es
	**necesario hacerlo para no sobrecargar al servidor, bueno en el caso de
	**programar una aplicación que tendrá muchas visitas ;) .*/
		mysql_close();

  	 exit ();



	?>
