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
// zona horaria
date_default_timezone_set('UTC');
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
// codigo de escolaridad
$escolaridad = $_POST["escolaridad"];
// grado
$id_grado = $_POST["grado"];
// nombre del grado
$ngrado = $_POST["ngrado"];
// Telefono del inscrito
$telefono = $_POST['telefono'];
//tipo de indentificaion
$tipo_identificacion = $_POST["tipo_identificacion"];
// documento de estudiante
$documento_estudiante = $_POST["documento_estudiante"];
// lugar de expecidicion del documento del estudiante
$lugar_exp_estudiante = $_POST["lugar_exp_estudiante"];
// genero del estudiante ( femenino, masculino )
$genero = $_POST["genero"];
// grupo sanguineo del estudiante
$gruporh = $_POST["gruporh"];
// sisben al que pertenece el estudiante
$nivelsisben = $_POST["nivelsisben"];
// direccion de residencia del estudiante
$direccion_estudiante = $_POST["direccion_estudiante"];
// barrio donde vive el estudiante
$barrio = $_POST["barrio"];
// estrato del estudiante
$estrato = $_POST["estrato"];
// personas con las que vive el estudiante
$vivecon = $_POST["vivecon"];
// nombre del padre
$nombre_padre = $_POST["nombre_padre"];
// apellodo del padre
$apellido_padre = $_POST["apellido_padre"];
// correo electronico del padre
$correo_padre = $_POST["correo_padre"];
// telefono del padre
$telefono_padre = $_POST["telefono_padre"];
// tipo de documento del padre
$tipo_identificacion_padre = $_POST["tipo_identificacion_padre"];
// numero de documento del padre
$documento_padre = $_POST["documento_padre"];
// lugrar de expedicion
$lugar_exp_padre = $_POST["lugar_exp_padre"];
// direccion del padre
$direccion_padre = $_POST["direccion_padre"];
// barrio del padre
$barrio_padre = $_POST["barrio_padre"];

// nombre de la madre
$nombre_madre = $_POST["nombre_madre"];
// apellido del padre
$apellido_madre = $_POST["apellido_madre"];
// correo de la madre debe llevar @
$correo_madre = $_POST["correo_madre"];
// telefono de la madre máximo diez dijitos
$telefono_madre = $_POST["telefono_madre"];
// tipo de documnto CC, CE, RC
$tipo_identificacion_madre = $_POST["tipo_identificacion_madre"];
// documento de la madre
$documento_madre = $_POST["documento_madre"];
// lugar de expedicin del documento de la madre
$lugar_exp_madre = $_POST["lugar_exp_madre"];
// direccion de recidencia de la madre
$direccion_madre = $_POST["direccion_madre"];
// barrio de la madre
$barrio_madre = $_POST["barrio_madre"];

$now = date("m/d/Y g:i a");  
// Datos para realizar la inscripción




// String  para realizar la consulta
$q2 = "INSERT INTO inscritos
(
  nombre_estudiante,
  apellido_estudiante,
  nacimiento,
  ciudad_nacimiento,
  id_escolaridad,
  id_grado,
  telefono,
  tipo_identificacion,
  documento_estudiante,
  lugar_exp_estudiante,
  genero,
  gruporh,
  nivelsisben,
  direccion_estudiante,
  barrio,
  estrato,
  vivecon,

  nombre_padre,
  apellido_padre,
  correo_padre,
  telefono_padre,
  tipo_identificacion_padre,
  documento_padre,
  lugar_exp_padre,
  direccion_padre,
  barrio_padre,

  nombre_madre,
  apellido_madre,
  correo_madre,
  telefono_madre,
  tipo_identificacion_madre,
  documento_madre,
  lugar_exp_madre,
  direccion_madre,
  barrio_madre,
  fecha
)

  VALUES ('".$nombre_estudiante.
    "',  '".$apellido_estudiante.
    "', '".$nacimiento.
    "', '".$ciudad_nacimiento.
    "', '".$escolaridad.
    "', '".$id_grado.
    "', '".$telefono.
    "', '".$tipo_identificacion.
    "', '".$documento_estudiante.
    "', '".$lugar_exp_estudiante.
    "', '".$genero.
    "', '".$gruporh.
    "', '".$nivelsisben.
    "', '".$direccion_estudiante.
    "', '".$barrio.
    "', '".$estrato.
    "', '".$vivecon.

    "', '".$nombre_padre.
    "', '".$apellido_padre.
    "', '".$correo_padre.
    "', '".$telefono_padre.
    "', '".$tipo_identificacion_padre.
    "', '".$documento_padre.
    "', '".$lugar_exp_padre.
    "', '".$direccion_padre.
    "', '".$barrio_padre.

    "', '".$nombre_madre.
    "', '".$apellido_madre.
    "', '".$correo_madre.
    "', '".$telefono_madre.
    "', '".$tipo_identificacion_madre.
    "', '".$documento_madre.
    "', '".$lugar_exp_madre.
    "', '".$direccion_madre.
    "', '".$barrio_madre.
    "', '".$now.
    "' )";

    // muestro la consulta
    echo $q2;

    // se ejecuta la consulta
    $q2x = mysqli_query($link, $q2 ) or die('Consulta fallida  de notas: ' . mysqli_error($link));
    // si la consulta es exitosa

    // obtengo el codigo de la inscripcion

    $q = "SELECT max(id) FROM  inscritos i ";
    // ejecuto la consulta
    $qx = mysqli($link,$q) or die ('no se pudo conectar con la base de datos:'.mysql_error($link));
    // recupero el dato de la consulta como un array
    $dato = mysqli_fetch_array($qx,MYSQLI_NUM);


    // Envio de correo electronico

    $cuerpo = "Se realizó la inscripción número [".$dato[0]."],  del estudiante $nombre_estudiante
    $apellido_estudiante al grado $ngrado, nacido en  en $ciudad_nacimiento
    número de documneto $documento_estudiante, declarando los siguientes
    datos :

    Nombre del estudiante: $nombre_estudiante $apellido_estudiante
    Fecha de nacimiento: $nacimiento en $ciudad_nacimiento
    Dirección: $direccion_estudiante / $barrio
    Estrato: $estrato
    Grupo sanguineo: $gruporh
    Vive con: $vivecon

    INFORMACIÓN DEL PADRE

    Nombre : $nombre_padre $apellido_padre
    Correo : $correo_padre
    Telefono: $telefono_padre
    Número de documento: $documento_padre , $lugar_exp_padre
    Dirección : $direccion_padre \ $barrio_padre

    INFORMACIÓN DE LA MADRE

    Nombre : $nombre_madre $apellido_madre
    Correo : $correo_madre
    Telefono: $telefono_madre
    Número de documento: $documento_madre , $lugar_exp_madre
    Dirección : $direccion_madre \ $barrio_madre
    ";

    echo $cuerpo;

    // //Enable SMTP debugging
    // // 0 = off (for production use)
    // // 1 = client messages
    // // 2 = client and server messages
    // $mail->SMTPDebug = 4;

    $mail = new PHPMailer();

    // Envío del correo de la madre si lo ha ingresado
    if ($correo_madre != ""){

      $mail->SMTPSecure = 'tls';
      $mail->Username = "imcreativo@hotmail.com";
      $mail->Password = "imc3459404801";
      $mail->AddAddress($correo_madre);
      $mail->FromName = "Mundo Creativo";
      $mail->Subject = "INSCRIPCI&Oacute;N Instituto Mundo Creativo";
      $mail->Body = $cuerpo;
      $mail->Host = "smtp.live.com";
      $mail->Port = 587;
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->From = $mail->Username;
      $mail->Send();

    }

    // Se envía el correo del padre
    if ($correo_padre) {
      // code...
      $mail->SMTPSecure = 'tls';
      $mail->Username = "imcreativo@hotmail.com";
      $mail->Password = "imc3459404801";
      $mail->AddAddress($correo_padre);
      $mail->FromName = "Mundo Creativo";
      $mail->Subject = "INSCRIPCI&Oacute;N Instituto Mundo Creativo";
      $mail->Body = $cuerpo;
      $mail->Host = "smtp.live.com";
      $mail->Port = 587;
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->From = $mail->Username;
      $mail->Send();
    }

    // $mail->isSMTP();                                      // Usar SMTP
    // $mail->Host = '';  // Especificar el servidor SMTP reemplazando por el nombre del servidor donde esta alojada su cuenta
    // $mail->SMTPAuth = true;                               // Habilitar autenticacion SMTP
    // $mail->Username = 'alejandr@imcreativo.edu.co';                 // Nombre de usuario SMTP donde debe ir la cuenta de correo a utilizar para el envio
    // $mail->Password = 'Caracter_13';                           // Clave SMTP donde debe ir la clave de la cuenta de correo a utilizar para el envio
    // $mail->SMTPSecure = 'tls';                            // Habilitar encriptacion
    // $mail->Port = 587;                                    // Puerto SMTP
    // $mail->Timeout       =   30;
    // $mail->AuthType = 'LOGIN';
    //
    //
    // // 	//Recipients
    //
    // $mail->setFrom('alejandro@imcreativo.edu.co');     //Direccion de correo remitente (DEBE SER EL MISMO "Username")
    // $mail->addAddress($correo_estudiante);     // Agregar el destinatario
    // $mail->addReplyTo('alejanro@imcreativo.edu.co');     //Direccion de correo para respuestas
    //
    // // 	//Content
    // $mail->isHTML(true);
    // $mail->Subject = 'INSCRIPCION MUNDO CREATIVO';
    // $mail->Body = "hello";
    // $mail->AltBody = 'This is a plain-text message body';
    //
    //
    // // 	//send the message, check for errors
    // if (!$mail->send()) {
    //    echo 'Mailer Error: ' . $mail->ErrorInfo;
    //  } else {
    //    echo 'Message sent!';
    //     //Section 2: IMAP
    //     //Uncomment these to save your message in the 'Sent Mail' folder.
    //     #if (save_mail($mail)) {
    //     #    echo "Message saved!";
    //     #}
    //}

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

    echo "<br>Se ingresaron con exito";
    desconectar($link);


    ?>
