<!DOCTYPE HTML>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
</meta>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
  <script src="../JS/a076d05399.js"></script>
  <script src="../JS/jquery-3.5.1.min.js"></script>
  <script src="../JS/typed.min.js"></script>
  <script src="../JS/jquery.waypoints.min.js"></script>
  <script src="../JS/owl.carousel.min.js"></script>
  <script src="../JS/ajax.js"></script>
  <link href="css/style.min.css" rel="stylesheet" />
	<link href="css/styles.css" rel="stylesheet" />
	<script src="js/all.js" ></script>
	<link href="../imagenes/escudo.gif" rel="shortcut icon"/>
	<link rel="stylesheet" href="../CSS/style.css" type="text/css">
  <link rel="stylesheet" href="estilos.css" type="text/css">
  <link href="../imagenes/escudo.gif" rel="shortcut icon"/>
</meta>
<title>Validacion</title>
<style type="text/css">
@import url("../estilos.css");

</style>
</head>


<body>

  <div id="contenedor">
    <div class="sidenav">
      <div class="login-main-text">
      
      <div class="content_logo" style="margin-bottom: 3vw;">
                <span id="imagen_logo" 
                style="width: 60px; 
                       height: 60px;
                       background-size: contain;">
                </span>   
      </div>
        <h2 class="titulo-login">Formulario<br>
        <font style="color:#57e666;">Docentes</font></h2>
        <p><font style="color:#a8a8a8;">Inicie secci&oacute;n para empezar</font></p>
      </div>
    </div>
    <div class="main">
      <div id="login1" class="col-md-6 col-sm-6">
        <div class="login-form">
          <form action="validacion_docentes.php" method="post">
            <div class="form-group">
              <label class="label-login">Usuario</label>
              <input id="cedula" type="text" class="form-control" name="cedula" placeholder="usuario">
            </div>
            <div class="form-group">
              <label class="label-login">Contrase&ntilde;a</label>
              <input name="login" id="login" type="password" name="login" class="form-control" placeholder="clave">
            </div>
            <button type="submit"  class="btn btn-dark"  style="margin-top: 20px;">Login</button>
            <!-- <button type="submit" class="btn btn-secondary">Registrarse</button> -->
          </form>
        </div>
      </div>
    </div>
</div>
</body>
</html>
