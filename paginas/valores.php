<?php
// Este archivo contiene los metodos para recuperar valores puntuales de las
// tablas de las bases de datos

require 'conexion.php';
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
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
date_default_timezone_set('America/Bogota');


 ?>
