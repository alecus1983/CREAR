<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_POST['nombre'];
  $correo = $_POST['correo'];
  $mensaje = $_POST['mensaje'];

  // Configura tu dirección de correo electrónico y detalles de SMTP
  $destinatario = 'soporte@imcreativo.edu.co';  // Cambia esto por tu dirección de correo electrónico
  $asunto = 'Nuevo mensaje desde el formulario de contacto';

  // Construye el cuerpo del correo electrónico
  $cuerpo = "De: $nombre\n";
  $cuerpo .= "Correo electrónico: $correo\n";
  $cuerpo .= "Mensaje:\n$mensaje";

  // Envía el correo electrónico
  if (mail($destinatario, $asunto, $cuerpo)) {
    echo 'Correo enviado con éxito.';
    
  } else {
    echo 'Hubo un error al enviar el correo.';
  }
}
?>
