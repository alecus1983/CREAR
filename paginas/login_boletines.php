<!DOCTYPE HTML>
<html>

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
    </meta>
    <title>Validacion</title>
    <style type="text/css">
      @import url("../estilos.css");

    </style>
  </head>


  <body>

    <div id="contenedor">
      <!--se coloca el titulo de la aplicacion-->
      <p  ><h1 class="titulo-azul"> FORMULARIO DOCENTES</h1></p>
      <!-- divicion para colocar el logo -->
      <div id="login" class="login">
        <!-- se coloca el  texto idicativo para el usuario -->
        <p >Introduzca su nombre de <em>usuario</em> y <em>contraseña</em> : </p>
        <br>
        <form action="validacion_docentes.php" method="post"
        class="formulario_ingreso">

          <div class="grid-container">
            <div class="grid-item">Usuario</div>
            <div class="grid-item">
            <input type="text"
            name="cedula"
            required="required" class="campo-dato"></input></div>

            <div class="grid-item">Contrase&ntilde;a</div>
            <div class="grid-item">
            <input type="password" name="login" required="required" class="campo-dato"></input></div>
              <div class="grid-item"></div>
            <div style="width:100%; margin-top:10px">
            <input type="submit" value="CARGAR" class="boton-azul">
            </div>
          </div>




        </form>
      </div>
    </body>
    </html>
