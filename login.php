<?php

require_once './vendor/autoload.php';
# identidad del cliente
$clientID = '175382781871-r3lspp42rn333nspuh2m013vhti9iue1.apps.googleusercontent.com';
# contraseña del cliente
$secret = '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t';
# URL de redireccionamiento
$red_url = 'http://localhost/CREAR_Web/index.php';

# Datos del cliente 
$client = new Google_Client();
#s
$cliexnt = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($ClientSecret);
#$client->setRedirectUrl($red_url);


?>
