<!DOCTYPE HTML>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
</meta>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
  <script src="../JS/a076d05399.js"></script>
  <script src="../JS/carga-datos-formulario-matricula-primaria.js"></script>
  <script src="../JS/jquery-3.5.1.min.js"></script>
  <script src="../JS/typed.min.js"></script>
  <script src="../JS/jquery.waypoints.min.js"></script>
  <script src="../JS/owl.carousel.min.js"></script>
  <script src="../JS/ajax.js"></script>
  <link href="../CSS/template.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/fa-v4-shims.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/default.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <script src="../JS/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../CSS/style.css" type="text/css">
  <link rel="stylesheet" href="../CSS/estilos.css" type="text/css">
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
        <h2>Formulario<br>
        <font style="color:#57e666;">Docentes</font></h2>
        <p><font style="color:#a8a8a8;">Inicie secci&oacute;n para empezar</font></p>
      </div>
    </div>
    <div class="main">
      <div class="col-md-6 col-sm-6">
        <div class="login-form">
          <form action="validacion_docentes.php" method="post">
            <div class="form-group">
              <label>Usuario</label>
              <input type="text" class="form-control" name="cedula" placeholder="usuario">
            </div>
            <div class="form-group">
              <label>Contrase&ntilde;a</label>
              <input name="login" id="login" type="password" name="login" class="form-control" placeholder="clave">
            </div>
            <button type="submit" class="btn btn-black" style="margin-top: 20px;">Login</button>
            <!-- <button type="submit" class="btn btn-secondary">Registrarse</button> -->
          </form>
        </div>
      </div>
    </div>
</div>
</body>
</html>
