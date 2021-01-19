<?php

///////////////////////////////////////////////////////////////////////////
//  archivo para ingresar realizar las inscripciones de lsos estudiantes  //
//  dentro de la base de datos, estos ingresan a la página principal      //
//  y envian la información mediante un formulario usando en método POST  //
//  de PHP                                                                //
//////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////
// Requiere el archivo de conexion           //
// con base de datos php                     //
///////////////////////////////////////////////


// declaración de constantes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
// archivos requeridos para iniciar
//require 'Exception.php';
// //require 'PHPMailer.php';
// //require 'SMTP.php';
// // archivo para la conexión a la base de datos
require_once 'conexion.php';
// //conexion a la base de datos
$link = conectar();
//
//
//
// // Parametros de entrada recuperados del formulario usando el método POST
// // el valor recuperado corresponde al ide del usuario
//
//nombre del inscrito
$nombre_estudiante = $_POST["nombre_estudiante"];
// apellidos del iscrito
$apellido_estudiante = $_POST['apellido_estudiante'];
// apellidos del iscrito
$nacimiento = $_POST['nacimiento'];
// ciudad de nacimiento del estudiante
$ciudad_nacimiento = $_POST['ciudad_nacimiento'];
// correo del estudiante
$correo_estudiante = $_POST['correo_estudiante'];
// Telefono del inscrito
$telefono = $_POST['telefono'];
// Tipo de identificacion del estudiante
$tipo_identificacion = $_POST['tipo_identificacion'];
// numero del documento
$cedula = $_POST["cedula"];
// Lugar de expedición del documento del estudiante
$lugar_exp_estudiante = $_POST['lugar_exp_estudiante'];
// genero del inscrito
$genero = $_POST['genero'];
// grupo sanguinio del estudiante
$gruporh = $_POST['gruporh'];
// nivel de sisben del estudiante
$nivelsisben = $_POST['nivelsisben'];
// direccion del estudiante
$direccion_estudiante = $_POST['direccion_estudiante'];
// barrio del estudiante
$barrio = $_POST['barrio'];
// estrato del barrio donde vive el estudiante
$estrato = $_POST['estrato'];
// presonas de la familia con la que vive
$vivecon = $_POST['vivecon'];
// nombre del padre
$nombre_padre = $_POST['apellido_padre'];


/**
* This example shows settings to use when sending via Google's Gmail servers.
* This uses traditional id & password authentication - look at the gmail_xoauth.phps
* example to see how to use XOAUTH2.
* The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
*/


//Create a new PHPMailer instance
$mail = new PHPMailer(true);

// To load the French version
$mail->setLanguage('es', '/PHPMailer/language');

//echo "Inscripcion del estudiante : ".$nombre_estudiante;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

// //Enable SMTP debugging
// // 0 = off (for production use)
// // 1 = client messages
// // 2 = client and server messages
// $mail->SMTPDebug = 4;


// $mail->isSMTP();                                      // Usar SMTP
// 	 $mail->Host = '';  // Especificar el servidor SMTP reemplazando por el nombre del servidor donde esta alojada su cuenta
// 	 $mail->SMTPAuth = true;                               // Habilitar autenticacion SMTP
// 	 $mail->Username = 'alejandr@imcreativo.edu.co';                 // Nombre de usuario SMTP donde debe ir la cuenta de correo a utilizar para el envio
// 	 $mail->Password = 'Caracter_13';                           // Clave SMTP donde debe ir la clave de la cuenta de correo a utilizar para el envio
// 	 $mail->SMTPSecure = 'tls';                            // Habilitar encriptacion
// 	 $mail->Port = 587;                                    // Puerto SMTP
// 	 $mail->Timeout       =   30;
// 	 $mail->AuthType = 'LOGIN';


// 	//Recipients

// 	$mail->setFrom('alejandro@imcreativo.edu.co');     //Direccion de correo remitente (DEBE SER EL MISMO "Username")
// 	$mail->addAddress($correo);     // Agregar el destinatario
// 	$mail->addReplyTo('alejanro@imcreativo.edu.co');     //Direccion de correo para respuestas

// 	//Content
// 	$mail->isHTML(true);
// 	$mail->Subject = 'INSCRIPCION MUNDO CREATIVO';
// 	$mail->AltBody = 'This is a plain-text message body';


// 	//send the message, check for errors
// if (!$mail->send()) {
//     echo 'Mailer Error: ' . $mail->ErrorInfo;
// } else {
//     echo 'Message sent!';
//     //Section 2: IMAP
//     //Uncomment these to save your message in the 'Sent Mail' folder.
//     #if (save_mail($mail)) {
//     #    echo "Message saved!";
//     #}
// }

// //Section 2: IMAP
// //IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
// //Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
// //You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
// //be useful if you are trying to get this working on a non-Gmail IMAP server.
// function save_mail($mail)
// {
//     //You can change 'Sent Mail' to any other folder or tag
//     $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

//     //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
//     $imapStream = imap_open($path, $mail->Username, $mail->Password);

//     $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
//     imap_close($imapStream);

//     return $result;
// }

// 		//echo "<br>Se ingresaron con exito";
// 		desconectar($link);


?>
