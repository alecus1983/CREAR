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
// Configuración de constantes

// declaración de constantes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

require ('datos.php');

//  archivo para la conexión a la base de datos
date_default_timezone_set('America/Bogota');
//
//  Parametros de entrada recuperados del formulario usando el método POST
//  el valor recuperado corresponde al ide del usuario
//

// //nombre del inscrito
$dato = new inscripcion(0);
//
$dato->nombre_estudiante = $_POST["nombre_estudiante"];
//echo "datos: ".$dato->nombre_estudiante;
//apellidos del iscrito
$dato->apellido_estudiante = $_POST['apellido_estudiante'];
// apellidos del iscrito
$dato->nacimiento = $_POST['nacimiento'];
// ciudad de nacimiento del estudiante
$dato->ciudad_nacimiento = $_POST['ciudad_nacimiento'];
// codigo de escolaridad
$dato->escolaridad = $_POST["escolaridad"];
// grado
$dato->id_grado = $_POST["grados_escolaridad"];
// nombre del grado
//$ngrado = $_POST["ngrado"];
$dato->id_jornada = $_POST["jornada"];
// Antiguedad 1 -> Si, 0 -> No
$dato->antiguedad = $_POST["antiguedad"];
// tipo_institucion privada = 0  publica = 1
$dato->tipo_institucion = $_POST["tipo_institucion"];
// nobre institucion
$dato->institucion = $_POST["institucion"];
// Telefono del inscrito
$dato->telefono = $_POST['telefono'];
// Telefono del inscrito
$dato->celular = $_POST['celular'];
//tipo de indentificaion
$dato->tipo_identificacion = $_POST["tipo_identificacion"];
// documento de estudiante
$dato->documento_estudiante = $_POST["documento_estudiante"];
// lugar de expecidicion del documento del estudiante
$dato->lugar_exp_estudiante = $_POST["lugar_exp_estudiante"];
// genero del estudiante ( femenino, masculino )
$dato->genero = $_POST["genero"];
// grupo sanguineo del estudiante
$dato->gruporh = $_POST["gruporh"];
// EPS del estudiante
$dato->EPS = $_POST["EPS"];
// sisben al que pertenece el estudiante
$dato->nivelsisben = $_POST["nivelsisben"];
// direccion de residencia del estudiante
$dato->direccion_estudiante = $_POST["direccion_estudiante"];
// barrio donde vive el estudiante
$dato->barrio = $_POST["barrio"];
// estrato del estudiante
$dato->estrato = $_POST["estrato"];
// modalidad de estudio presencial o virtual
$dato->modalidad = $_POST["modo"];
// nombre de la institucion donde proviene
$dato->nombre_institucion = $_POST["institucion"];
// tipo de institucion de donde proviene
$dato->tipo_institucion = $_POST["tipo_institucion"];
// motivo de retiro varchar(50)
$dato->motivo = $_POST["motivo"];
// Etnia
$dato->etnia = $_POST["etnia"];
// victima del Conflicto varchar(50)
$dato->victima= $_POST["victima"];
// personas con las que vive el estudiante
$dato->vivecon = $_POST["vivecon"];
// nombre del padre
$dato->nombre_padre = $_POST["nombre_padre"];
// apellodo del padre
$dato->apellido_padre = $_POST["apellido_padre"];
// correo electronico del padre
$dato->correo_padre = $_POST["correo_padre"];
// telefono del padre
$dato->telefono_padre = $_POST["telefono_padre"];
// tipo de documento del padre
$dato->tipo_identificacion_padre = $_POST["tipo_identificacion_padre"];
// numero de documento del padre
$dato->documento_padre = $_POST["documento_padre"];
// lugrar de expedicion
$dato->lugar_exp_padre = $_POST["lugar_exp_padre"];
// direccion del padre
$dato->direccion_padre = $_POST["direccion_padre"];
// barrio del padre
$dato->barrio_padre = $_POST["barrio_padre"];
// nombre de la madre
$dato->nombre_madre = $_POST["nombre_madre"];
// apellido del padre
$dato->apellido_madre = $_POST["apellido_madre"];
// correo de la madre debe llevar @
$dato->correo_madre = $_POST["correo_madre"];
// telefono de la madre máximo diez dijitos
$dato->telefono_madre = $_POST["telefono_madre"];
// tipo de documnto CC, CE, RC
$dato->tipo_identificacion_madre = $_POST["tipo_identificacion_madre"];
// documento de la madre
$dato->documento_madre = $_POST["documento_madre"];
// lugar de expedicin del documento de la madre
$dato->lugar_exp_madre = $_POST["lugar_exp_madre"];
// direccion de recidencia de la madre
// }
// barrio de la madre
$dato->direccion_madre = $_POST["direccion_madre"];
// barrio de la madre
$dato->barrio_madre = $_POST["barrio_madre"];

$now = date("Y-m-d g:i");
//Datos para realizar la inscripción

//estructura que muestra los datos cargasos
$numero2 = count($_POST);
$tags2 = array_keys($_POST); // obtiene los nombres de las varibles
$valores2 = array_values($_POST);// obtiene los valores de las varibles

// crea las variables y les asigna el valor
for($i=0;$i<$numero2;$i++){
  //echo $tags2[$i]." - ".$valores2[$i]."<br>";
  $tags2[$i]=$valores2[$i];
}


// echo "nombre del estudiante : ".$dato->nombre_estudiante;

//Si se ejecuta el registro o insercion en la base de datos del $dato
//y todos su atributo.
if($dato->registro()) {

  // Coloco los valore iniciales para el correo enviado
  $enviado = false;

  // Se crea un elemento grado
  $grado = new grados();
  // // Se obtiene el nombre para un determinado grado
  $ngrado = $grado->get_nombre($_POST['grados_escolaridad']);
  // // se obtiene el maximo valor del id
  $maximo = $dato->maximo();
  //
  // // El cuerpo del correo
  $cuerpo = "<p>Se realiz&oacute; la inscripci&oacute;n n&uacute;mero <b>[".
  $maximo[0]."]</b>,  del estudiante <b><font color='blue'>".
  $dato->nombre_estudiante." "
  .$dato->apellido_estudiante." </font></b> al grado $ngrado, nacido en  en ".
  $dato->ciudad_nacimiento." n&uacute;mero de documneto ".$dato->documento_estudiante
  .", declarando los siguientes
  datos :</p>
  <ul>
  <li>Nombre del estudiante: ".$dato->nombre_estudiante." ". $dato->apellido_estudiante.
  "<li>Fecha de nacimiento: ".$dato->nacimiento ."en". $dato->ciudad_nacimiento.
  "<li>Direcci&oacute;n: ".$dato->direccion_estudiante ."/". $dato->barrio.
  "<li>Estrato: ".$dato->estrato.
  "<li>Grupo sanguineo: ".$dato->gruporh.
  "<li>Vive con: ".$dato->vivecon.
  "</ul>
  <br>
  <b>INFORMACI&Oacute;N DEL PADRE</b>
  <ul>

  <li>Nombre : ".$dato->nombre_padre ." ". $dato->apellido_padre.
  "<li>Correo : ".$dato->correo_padre.
  "<li>Telefono: ".$dato->telefono_padre.
  "<li>N&uacute;mero de documento: ".$dato->documento_padre .", ". $dato->lugar_exp_padre.
  "<li>Direcci&oacute;n : ".$dato->direccion_padre ." ". $dato->barrio_padre.
  "</ul> <br>

  <b>INFORMACI&Oacute;N DE LA MADRE</b>

  <ul>
  <li>Nombre : ".$dato->nombre_madre ." ".$dato->apellido_madre.
  "<li>Correo : ".$dato->correo_madre.
  "<li>Telefono: ".$dato->telefono_madre.
  "<li>Direcci&oacute;n : ".$dato->direccion_madre." \ ".$dato->barrio_madre.
  "<li>N&uacute;mero de documento: ".$dato->documento_madre." , ".$dato->lugar_exp_madre.
  "</ul>
  ";

  $mail = new PHPMailer();
  //Enable SMTP debugging
  // 1 = client messages
  // 0 = off (for production use)
  // 2 = client and server messages
  //$mail->SMTPDebug = 4;



  // Envío del correo de la madre si lo ha ingresado
  if ($dato->correo_madre != ""){
    $mail->SMTPSecure = 'tls';
    $mail->Username = "imcreativo@hotmail.com";
    $mail->Password = "imc3459404801";
    $mail->AddAddress($dato->correo_madre);
    $mail->FromName = "Mundo Creativo";
    $mail->Subject = "INSCRIPCI&Oacute;N Instituto Mundo Creativo";
    $mail->Body = $cuerpo;
    $mail->IsHTML(true);
    $mail->Host = "smtp.live.com";
    $mail->Port = 587;
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->From = $mail->Username;
    $mail->Send();
    $enviado = true;
  }

  // Se envía el correo del padre
  if ($dato->correo_padre) {
    // code...
    $mail->SMTPSecure = 'tls';
    $mail->Username = "imcreativo@hotmail.com";
    $mail->Password = "imc3459404801";
    $mail->AddAddress($dato->correo_padre);
    $mail->FromName = "Mundo Creativo";
    $mail->Subject = utf8_decode("INSCRIPCIÓN Instituto Mundo Creativo [".$maximo[0]."]");
    $mail->Body = $cuerpo;
    $mail->IsHTML(true);
    $mail->Host = "smtp.live.com";
    $mail->Port = 587;
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->From = $mail->Username;
    $mail->Send();
    $enviado = true;
  }

  if ($enviado == true){
      echo "swal(Se ingresaron con exito)";
  }



} else {
  echo "se presento un fallo al ingresar los datos, intentelo m&aacute;s tarde.";
}




?>
