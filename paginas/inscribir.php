<?php

///////////////////////////////////////////////////////////////////////////
//  archivo para ingresar las notas  del estudiante en un periodo       //
//////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////
// Requiere el archivo de conexion           //
// con base de datos php                     //
///////////////////////////////////////////////

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

//require_once 'conexion.php';
//conexion a la base de datos
$link = conectar();



// Parametros de entrada
// nombre del inscrito
$nombres = $_POST["nombres"];
// apellidos del iscrito
$apellidos = $_POST['apellidos'];
// apellidos del iscrito
$nacimiento = $_POST['nacimiento'];
// correo del inscrito
$cedula = $_POST["cedula"];
// telefono del inscrito
$telefono = $_POST["telefono"];
// correo del inscrito
$correo = $_POST["correo"];
// identificador de un corte
$id_escolaridad = $_POST["escolaridad"];
// el periodo en el que se va a calificar
$id_programa = $_POST["programa"];;//
// el codigo del docente
$otro = $_POST['otro'];
// la materia asignada
$id_materia = $_POST["curso"];
// fecha actual
$now = date("Y-m-d");
//
//
//echo "nombre: $nombres, apellido: $apellidos, correo: $correo";
$enviado = false;


// consulta para optener el  programa
$q = "Select * from grados where id_grado = ".$id_programa;
// Se ejecuta la consulta
$qx = mysqli_query($link, $q ) or die('Consulta a tabla grado: ' . mysqli_error($link));
// obtengo el primer registro de la consulta
$d = mysqli_fetch_array($qx);
// gurdo la escolaridad en la variable escolaridad
$programa = $d['nombre_g']; // Tecnico ,  cursos, primaria

//echo "<br> programa : $programa";

// consulta para optener la escolaridad
$q = "Select * from escolaridad where id_escolaridad = $id_escolaridad";
// Se ejecuta la consulta
$qx = mysqli_query($link, $q ) or die('Consulta a tabla escolaridad: ' . mysqli_error($link));
// obtengo el primer registro de la consulta
$d = mysqli_fetch_array($qx);
// gurdo la escolaridad en la variable escolaridad
$escolaridad = $d['escolaridad']; // Tecnico ,  cursos, primaria

//echo "<br> escolaridad : $escolaridad";

if ($id_materia != -1){
	// consulta para optener la escolaridad
	$q = "Select * from materia where id_materia = $id_materia";
	// Se ejecuta la consulta
	$qx = mysqli_query($link, $q ) or die('Consulta a tabla escolaridad: ' . mysqli_error($link));
	// obtengo el primer registro de la consulta
	$d = mysqli_fetch_array($qx);
	// gurdo la escolaridad en la variable escolaridad
	$materia = $d['materia']; // Tecnico ,  cursos, primaria
}

//echo "<br> materia : $materia";


// nuevo objeto mail
	$mail = new PHPMailer(true);
// se intenta hacer la rutina
try {

	// //$mail->SMTPDebug = 4;
	// $mail->isSMTP();                                      // Usar SMTP
	// $mail->Host = 'smtp-mail.outlook.com'; // Especificar el servidor SMTP reemplazando por el nombre del servidor donde esta alojada su cuenta
	// $mail->SMTPAuth = true;                               // Habilitar autenticacion SMTP
	// $mail->Username = 'imcreativo@hotmail.com';                 // Nombre de usuario SMTP donde debe ir la cuenta de correo a utilizar para el envio
	// $mail->Password = 'imc3459404801';                           // Clave SMTP donde debe ir la clave de la cuenta de correo a utilizar para el envio
	// $mail->SMTPSecure = 'tls';                            // Habilitar encriptacion
	// $mail->Port = 587;                                    // Puerto SMTP
	// $mail->Timeout       =   30;
	// $mail->AuthType = 'LOGIN';



	$mail->isSMTP();                                      // Usar SMTP
	 $mail->Host = 'imcreativo.edu.co';  // Especificar el servidor SMTP reemplazando por el nombre del servidor donde esta alojada su cuenta
	 $mail->SMTPAuth = true;                               // Habilitar autenticacion SMTP
	 $mail->Username = 'secretaria@imcreativo.edu.co';                 // Nombre de usuario SMTP donde debe ir la cuenta de correo a utilizar para el envio
	 $mail->Password = 'imc3459404801';                           // Clave SMTP donde debe ir la clave de la cuenta de correo a utilizar para el envio
	 $mail->SMTPSecure = 'ssl';                            // Habilitar encriptacion
	 $mail->Port = 465;                                    // Puerto SMTP
	 $mail->Timeout  =   30;
	 $mail->AuthType = 'LOGIN';


	//Recipients

	$mail->setFrom('secretaria@imcreativo.edu.co');     //Direccion de correo remitente (DEBE SER EL MISMO "Username")
	$mail->addAddress($correo);     // Agregar el destinatario
	$mail->addReplyTo('secretaria@imcreativo.edu.co');     //Direccion de correo para respuestas

	//Content
	$mail->isHTML(true);
	$mail->Subject = 'INSCRIPCIÓN MUNDO CREATIVO';

// 	//$mail->SMTPDebug = 4;                               // Habilitar el debug
// 	$mail->SMTPOptions = array(
// 		'ssl' => array(
// 				'verify_peer' => false,
// 				'verify_peer_name' => false,
// 				'allow_self_signed' => true
// 		)
// );
	// a contincuación se desarrollara el curpo del Correo
	// para lo cual  este curpo esta determinado  por el tipo de
	// escolaridad

	if ($id_escolaridad == 4){
		// en caso de que se trate de
		// programas tecnicos
			$cuerpo = "<html>
		<head>
			<title>INSCRIPCI&Oacute;N</title>
		</head>
		<body>
		Hola ".utf8_encode($nombres).",  hemos realizado tu inscripci&oacute;n al programa T&eacute;cnico en </b>"
		.utf8_encode($programa)."</b>, en poco tiempo te estaremos contactando, gracias por su inscripci&oacute;n.".
		"</body></html>";

	} else if ($id_escolaridad == 5){

		// en caso de que se trate de los cursos cortos

		$cuerpo = "<html>
		<head>
			<title>INSCRIPCI&Oacute;N</title>
		</head>
		<body>
		Hola ".utf8_encode($nombres).",  hemos realizado tu inscripci&oacute;n al Curso "
		." <b>".utf8_encode($materia)."</b> en poco tiempo te estaremos contactando.";
		"</body></html>";

	}

	//echo "<br>mensaje".$cuerpo;

	$mail->Body    = $cuerpo;


	$mail->send();
	//echo 'El mensaje ha sido enviado';
	$enviado = true;
} catch (Exception $e) {
	//echo 'El mensaje no pudo ser enviado. Error: ', $mail->ErrorInfo;
	$enviado = false;
}

if ($enviado == true){
	echo "<br><span style='color: green;'>Su inscripci&oacute;n ha sido realizada con &eacute;xito, favor verificar en su correo electronico (<b> $correo </b> ) para m&aacute;s informaci&oacute;n</span";
}else {
	echo 'El mensaje no pudo ser enviado. Error: ', $mail->ErrorInfo;
}



// Si  el codigo  de la materia tiene un valor
// mayor que cero  entonces asigna cero
if ($id_materia < 1){
	$id_materia = 0;

}

// String  para realizar la consulta
$q2 = "INSERT INTO inscritos (nombre, apellido, cedula, telefono, correo,
	id_escolaridad, id_programa,  id_materia,  nacimiento, fecha)
	VALUES ('".$nombres."',  '".$apellidos."', '".$cedula."', '".$telefono."', '".$correo."',
	$id_escolaridad, $id_programa, $id_materia, '".$nacimiento."', '".$now."' )";

		// muestro la consulta
		//echo $q2;

		// se ejecuta la consulta
		$q2x = mysqli_query($link, $q2 ) or die('Consulta fallida  de notas: ' . mysqli_error($link));
		// si la consulta es exitosa

		//echo "<br>Se ingresaron con exito";
		desconectar($link);

		?>
