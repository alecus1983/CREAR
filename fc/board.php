<?php
session_start();
// si obtengo una seccion
if (isset($_SESSION["usuario"])){
    // lo almacen en la variable local
    $usuario =  $_SESSION["usuario"];
} else {
    // de lo contrario lo redirecciono a la pagina de loggin
    header("Login_boletines_prueba.php");
    exit;
}

require_once('datos.php');
// creo un nuevo docente
$d = new docentes();
$d->get_docente_cc($usuario);
$id = $d->id;
$admin = $d->admin;
$ano = date('Y');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>panel</title>
	<link href="css/style.min.css" rel="stylesheet" />
	<link href="css/styles.css" rel="stylesheet" />
	<script src="js/all.js" ></script>
	<link href="../imagenes/escudo.gif" rel="shortcut icon"/>
	<script src="./js/sweetalert.min.js"></script>
	<script src="./js/jquery-3.5.1.min.js"></script>
	 <script src="./js/ajax.js"></script>
	<link rel="stylesheet" href="estilos.css" type="text/css">

	<style>
	 input[type=number]::-webkit-inner-spin-button,
	 input[type=number]::-webkit-outer-spin-button {
             -webkit-appearance: none;
	     margin: 0;
	 }

	 input[type=number] { -moz-appearance:textfield; }

	</style>

	<style>
	 .loader {
	     position: absolute;
	     left: 50%;
	     top: 50%;
	     z-index: 1;
	     border: 30px solid #f3f3f3;
        border-radius: 50%;
	     border-top: 16px solid blue;
	     border-right: 16px solid green;
	     border-bottom: 16px solid red;
	     border-left: 16px solid orange;
	     width: 10rem;
	     height: 10rem;
	     -webkit-animation: spin 2s linear infinite;
	     animation: spin 2s linear infinite;
	 }

	 a{
	     color: black;
	 }
	 @-webkit-keyframes spin {
	     0% { -webkit-transform: rotate(0deg); }
	     100% { -webkit-transform: rotate(360deg); }
	 }

	 @keyframes spin {
	     0% { transform: rotate(0deg); }
	     100% { transform: rotate(360deg); }
	 }
	</style>

    </head>

    <body class="sb-nav-fixed">


	<div class="loader" style="display:none" id="loader"></div>


	<div id="content" class="container">
	    <?php $hoy = Date("Y-m-d hh:mm"); ?>
	    
	    <div class="align-items-center"><h2 class="text-center fs-2">PANEL <b>DOCENTE</b></h2></div>
	    <div class="row align-items-center" style="height:10em;">
		
		<div class="col"></div>
		<div class="col align-items-center">
		    <a href="fc.php" class="d-flex justify-content-center">
			<svg xmlns="http://www.w3.org/2000/svg" width="5em" height="5em" fill="currentColor" class="bi bi-file-bar-graph" viewBox="0 0 16 16">
			    <path d="M4.5 12a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1zm3 0a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm3 0a.5.5 0 0 1-.5-.5v-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5h-1z"/>
			    <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
			</svg>
		    </a>
		    <a href="fc.php" class="d-flex justify-content-center">Calificaciones</a>
		</div>
		
		<div class="col">
		    <a href="fc_admin.php" class="d-flex justify-content-center">
			<svg xmlns="http://www.w3.org/2000/svg" width="5em" height="5em" fill="currentColor" class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
			    <path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2z"/>
			</svg>
		    </a>
		    <a href="fc_admin.php" class="d-flex justify-content-center">Administración</a>
		</div>
		<div class="col"></div>
	    </div>

	  

	    <div class="row align-items-center" style="height:10em;">
		<div class="col"></div>
		<div class="col align-items-center">
		    <a href="fc_red.php" class="d-flex justify-content-center">
			<svg xmlns="http://www.w3.org/2000/svg" width="5em" height="5em" fill="currentColor" class="bi bi-file-bar-graph-fill" viewBox="0 0 16 16">
			    <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-2 11.5v-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1z"/>
			</svg>
		    </a>
		    <a href="fc_red.php" class="d-flex justify-content-center">Extra</a>
		</div>
		
		<div class="col">

		    <a class="d-flex justify-content-center" href="./recuperacion.php">
			<svg xmlns="http://www.w3.org/2000/svg" width="5em" height="5em" fill="currentColor" class="bi bi-recycle" viewBox="0 0 16 16" style="color:darkblue;">
			    <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zm14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5z"/>

			</svg>
		    </a>
		    <a href="./recuperacion.php" class="d-flex justify-content-center">Recuperación</A>

		</div>
		<div class="col"></div>
	    </div>
	    <div class="row align-items-center" style="height:10em;">
		<div class="col"></div>
		<div class="col align-items-center">

		    <a href="../" class="d-flex justify-content-center">
			<img src="../imagenes/escudo.gif" height="70em" >
		    </a>

		    
		  
		</div>
			
		<div class="col">
		</div>
	    </div>
            </div>

        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Mundo Creativo 2023</div>
                    <div>
                        <a href="#">Politica de privacidad</a>
                        &middot;
			<a href="#">Terminos &amp; Condiciones</a>
		    </div>
		</div>
	    </div>
	</footer>
	<script src="./js/bootstrap.bundle.min.js" ></script>
        <script src="./js/scripts.js"></script>
        <script src="./js/Chart.min.js" ></script>
        <script src="./assets/demo/chart-area-demo.js"></script>
        <script src="./assets/demo/chart-bar-demo.js"></script>
        <script src="./js/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="./js/datatables-simple-demo.js"></script>
    </body>
</html>
