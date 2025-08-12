<?php
// Initialize the session
session_start();
 //Vaciar sesión
 $_SESSION = array();
// Destroy the session
session_destroy();
// Redirect to the login page
header('Location: login_boletines.php');
exit;
?>
