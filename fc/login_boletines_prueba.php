<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </meta>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script src="../JS/a076d05399.js"></script>
    <script src="../JS/jquery-3.5.1.min.js"></script>
    <script src="../JS/typed.min.js"></script>
    <script src="../JS/jquery.waypoints.min.js"></script>
    <script src="../JS/owl.carousel.min.js"></script>
    <script src="../JS/ajax.js"></script>
   
    <link href="css/styles.css" rel="stylesheet" />
    <script src="js/all.js"></script>
    <link href="../imagenes/escudo.gif" rel="shortcut icon" />
   
    <link href="../imagenes/escudo.gif" rel="shortcut icon" />
    </meta>
    <title>Validacion</title>
   
    <link rel="stylesheet" href="../assets/css/login.css">
</head>


<body>

    <!-- <div id="contenedor">
        <div class="sidenav">
            <div class="login-main-text">

                <div class="content_logo" style="margin-bottom: 3vw;">
                    <span id="imagen_logo" style="width: 60px; 
                       height: 60px;
                       background-size: contain;">
                    </span>
                </div>
                <h2 class="titulo-login">Formulario<br>
                    <font style="color:#57e666;">Docentes</font>
                </h2>
                <p>
                    <font style="color:#a8a8a8;">Inicie secci&oacute;n para empezar</font>
                </p>
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
                        <button type="submit" class="btn btn-dark" style="margin-top: 20px;">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
 -->




        <!----------------------- Main Container -------------------------->

        <div class="container d-flex justify-content-center align-items-center min-vh-100">

            <!----------------------- Login Container -------------------------->

            <div class="row border rounded-5 p-3 bg-white shadow box-area">

                <!--------------------------- Left Box ----------------------------->

                <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
                    <div class="featured-image mb-3">
                        <img src="../assets/img/login/1.png" class="img-fluid" style="width: 250px;">
                    </div>
                    <br>
                    <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Verificación</p>
                   
                </div>

                <!-------------------- ------ Right Box ---------------------------->

                <div class="col-md-6 right-box">
                    <div class="row align-items-center">
                        <div class="header-text mb-4">
                            <h2>Docente <strong>#CREAR</strong></h2>
                            <p>Inicia Seccion para acceder a la <br> plataforma de calificaciones.</p>
                        </div>

                        <form  action="validacion_docentes.php" method="post">

                            <div class="input-group mb-3">
                                <input  id="cedula" type="text" " name="cedula" placeholder="usuario" class="form-control form-control-lg bg-light fs-6" required>
                            </div>
                            <div class="input-group mb-1">
                                <input name="login" id="login" type="password" name="login"  placeholder="clave"  class="form-control form-control-lg bg-light fs-6" required>
                            </div>
                            <div class="input-group mb-5 d-flex justify-content-between">


                            </div>
                            <div style="margin-top: 20px;" class="input-group mb-3">
                                <button class="btn btn-lg btn-primary w-100 fs-6">Iniciar Seccion</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>



</body>

</html>