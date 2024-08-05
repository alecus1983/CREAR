<?php
        
require_once 'conexion.php';
$link = conectar();
	
	
	
// Pagina transitoria para generar los resultados a actualizar
// RECUPERO DATOS DE EL FORMULARIO 
// DE ACTUACCION
	
	
	
$edi = $_POST["edi"];
$nombres = $_POST["i_nombres"];
$apellidos = $_POST["apellidos"];	
$logros = $_POST["Logros"];
//$year = $_POST["years"];
//$grados = $_POST["grados"];
$fecha = $_POST["fechas"];
$cedula = $_POST["cedulas"];
$correo = $_POST["correos"];
$telefono = $_POST["telefonos"];
//$area = $_POST["areas"];
//$id_g = $_POST["id_gs"];
$id_l = $_POST["id_ls"];
//$curso = $_POST["cursos"];
//$docente = $_POST["docentes"];  
$periodo = $_POST["periodos"];
//$estudiante = $_POST["estudiantes"];
$mes = date("m");
$fecha_fin = $_POST["fecha_fins"];
$id_e = $_POST["id_es"];
$id_d = $_POST["id_ds"];
//$id_m = $_POST["id_ms"];
//$materia = $_POST[""];
$jornada = utf8_encode("Mañana");
$bk= "#FFFFFF";// variable de color de fondo de tabla
$fondo = true;
//$logro_1 = $_POST['logro_1'];
//$logro_2 = $_POST['logro_2'];
$logro_3 = $_POST['logro_3'];
//$nota = $_POST['nota'];
//$faltas = $_POST['faltas'];
//$id_docente = $_POST['id_docentes'];
	
	
//echo "Cargando ...".$edi;
	
// COMIENZO A GENERAR TABLA
	
	

// VERIFICO LA OPCION SELECCIONADA EN LA TABLA PARA INGREASAR 
// 1 - CONSULTAR
// 2 - ADICCIONAR
// 3 - ELIMINAR
// 4 - EDITAR
	
	 
	
switch($edi) {
    // estructura para insertar  el listado de estudiantes registrados en la base de datos									
    //echo "Se ingreso el alumno ".$nombres." ".$apellidos."\nCon documento de identidad No:"
    //.$cedula."\telefono : ".$telefono."\ correo electronico :".$correo

    // En el caso de que se deseen editar los datos de los estudiantes
case 1:
		
    $q1 = "UPDATE alumnos SET nombres = '".utf8_encode($nombres)."', apellidos = '"
        .utf8_encode($apellidos)."', cedula = '".$cedula."', fecha = '".$fecha
        ."',telefono = '".$telefono."', correo = '".$correo."' WHERE id_alumno = ".$id_e;
			
    //echo $q1;											
    $q1x = mysqli_query($link, $q1) or die('Consulta fallida al insertar tabla alumnos: ' . mysql_error());
														
			
			
    echo "Se actualizo el alumno <b>:".$nombres." ".$apellidos."</b><br> Codigo: <b>".$id_e
                                      ."</b><br> Con documento de identidad No:<b>".$cedula
                                      ."</b><br> telefono : <b>".$telefono
                                      ."</b><br> correo electronico : <b>".$correo."</b>";
														
														
    break;


    // En caso de que se deseen editar los datos de los docentes
case 2:
    $q1 = "UPDATE docentes SET nombres = '".utf8_encode($nombres)."', apellidos = '"
        .utf8_encode($apellidos)."', cedula = '".$cedula."', fecha = '".$fecha."',celular = '".$telefono."'
			, correo = '".$correo."', materias = '".utf8_encode($area)."'	WHERE id_docente = ".$id_d;
														
    $q1x = mysqli_query($link, $q1)  ;
			
    // sentencia de desicion la cual indica si la consulta de actualizacion se realizo con exito
    if($q1x) {
        // mensaje que se muestra en pantalla en formato html
        echo "Se ingreso el docente :".$nombres." ".$apellidos."\n Codigo: ".$id_d
                                      ."\n Con documento de identidad No:".$cedula
                                      ."\n telefono : ".$telefono."\n correo electronico :"
                                      .$correo." Areas : ".utf8_decode($area);
    }
    else {
        // mensaje que se muestra en pantalla en formato html
        echo "No se pudo actualizar el docente, consulte con el administrador del sistema : ". mysql_error();
    }
    break;
											
								
											
    // en caso de editar  un logro											
case 5: // insertar logro
    // string de la consulta
    $q1 = "UPDATE logros SET logro = '".utf8_encode($logros)."' WHERE id_logro = ".$id_l; 
			
			
    // se ejecuta la consulta
    $q1x = mysqli_query($link, $q1)  or die('Consulta fallida al insertar el logro: ' . mysql_error());

    // se verifica si la consulta de actualizacion fue exitosa
    if($q1x){
        echo "Se actualizo  el logro : ".$id_l;
    }
			
    break;

case 12:


    if ($periodo <1){
        echo "<p style='color:#FF0000'> Por favor seleccione un periodo en el menu superior</p>";}
    elseif ($fecha_fin == ""){
        echo "<p style='color:#FF0000'>Por favor introduzca una fecha</p>";}
    else{
        // si los datos son validos ejecuto la consulta de
        // actualizacion
        $q1 = "UPDATE limite   SET periodo =  $periodo, fecha = '".$fecha_fin."'";
        //echo "Consulta :".$q1."<br>";
        // se ejecuta la consulta
    
        $q1x = mysqli_query($link, $q1)
             or die('Consulta fallida al insertar fecha: ' . mysql_error());
    }
    // se verifica si la consulta de actualizacion fue exitosa
    if($q1x){
        echo "Se actualizo  la fecha: ".$fecha_fin.",  para el periodo :".$periodo;
    }
			
    
    break;
											
    /////////////////////////////////////////////////////////////////////////////////
											
		
    /*
      case 11:
      //
      $q1 = "UPDATE calificaciones_$ano SET id_logro = ".$logro_1.", nota = ".$nota.", id_docente = ".$id_docente.", faltas =".$faltas."
      WHERE id_alumno = ".$estudiante." AND id_materia =".$id_m." AND periodo =".$periodo." AND year =".$year;
														
      //echo $q1;
			
      $q1x = mysql_query($q1, $link) or die('Error al actualizar calificaciones_$ano : ' . mysql_error());
			
      break;			
		
		
      case 12:
			
      $q1 = "UPDATE calificaciones_$ano SET id_logro = ".$logro_1.", nota = ".$nota.", id_docente = ".$id_docente.", faltas =".$faltas."
      WHERE id_alumno = ".$estudiante." AND id_materia =".$id_m." AND periodo =".$periodo." AND year =".$year;
														
      //echo $q1;
			
      $q1x = mysql_query($q1, $link) or die('Error al actualizar calificaciones_$ano : ' . mysql_error());
			
      break;*/
}
					
						
	
 	
//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
desconectar($link);
   
exit ();
 		
?>
