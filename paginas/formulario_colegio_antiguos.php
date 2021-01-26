<!DOCTYPE html>

<?php
require 'conexion.php';
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario</title>
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
  <link href="../images/sampledata/iconos/escudo.png" rel="shortcut icon" type="image/vnd.microsoft.icon" />

  <script type="text/javascript">

  $(document).on('change', '#vivecon', function(event) {
     var padres = $("#vivecon option:selected").text();

     switch (padres) {
       case "madre":
       $("#madre").css("display" , "block");
       $("#padre").css("display" , "none");
         break;
         case "padre":
         $("#padre").css("display" , "block");
         $("#madre").css("display" , "none");
         break;
       default:
       $("#padre").css("display" , "block");
       $("#madre").css("display" , "block");

     }
});

</script>

</head>

<body>


  <div class="scroll-up-btn">
    <i class="fas fa-angle-up"></i>
  </div>

  <nav class="navbar">
    <div class="max-width">
      <div class="content_logo">
        <span id="imagen_logo" style="width: 60px; height: 60px;background-size: contain;"></span>
        <span class="logo" style="margin-left: 1rem;"><a href="#">MUNDO CREATIVO</a></span>
      </div>

      <ul class="menu" style="margin: 0px;">
        <li><a href="#home" class="menu-btn, b_home">Home</a></li>
        <li><a href="#about" class="menu-btn, b_noticias">Noticias</a></li>
        <li><a href="#services" class="menu-btn,  b_colegio">Colegio</a></li>
        <li><a href="#skills" class="menu-btn,  b_tecnicos">Tecnios</a></li>
        <li><a href="#teams" class="menu-btn, b_docentes">Docentes</a></li>
        <li><a href="#contactos" class="menu-btn ,  b_contact">Contact</a></li>
        <li><a href="#" class="menu-btn,  b_login">Login</a></li>
      </ul>
      <div class="menu-btn">
        <i class="fas fa-bars"></i>
      </div>
    </div>
  </nav>


  <!-- home section start -->
  <section class="home" id="home" style="background: linear-gradient(70deg, #6cc, white);">
    <div class="max-width">
      <div class="home-content">
        <div class="text-1">Institucion Educativa</div>
        <div class="text-2">Mundo Creativo</div>
        <div class="text-3">Somos: <span class="typing"></span></div>
        <a href="#contactos"> <strong> Contactanos! </strong></a>
      </div>
    </div>
  </section>

  <!-- Contenido de la pagina-->
  <section id="contenido">
    <div class="max-width">

      <div class="row">
        <div class="col-xs-0 col-sm-1 col-md-4 col-lg-4">
          <!-- <div class="nav nav-pills flex-column" id="v-pills-tab">
          <a class="active" data-toggle="pill" href="#v-pills-home"><button type="button" class="btn btn-outline-primary boton_grado">PRE ESCOLAR</button></a>
          <a data-toggle="pill" href="#v-pills-profile"><button type="button" class="btn btn-outline-secondary boton_grado" >PARVULOS</button></a>
          <a data-toggle="pill" href="#v-pills-messages"><button type="button" class="btn btn-outline-secondary boton_grado">JARDÍN</button></a>
          <a data-toggle="pill" href="#v-pills-settings"><button type="button" class="btn btn-outline-secondary boton_grado">PRE JARDÍN</button></a>
        </div> -->
      </div>

      <div class="col-sx-12 col-sm-9 col-md-6 col-lg-7">

        <?php
        setlocale(LC_ALL,"es_CO");
        date_default_timezone_set('America/Bogota');
        echo '<br><font color="darkblue">'.strftime("Hoy es %A %e de %B del %Y")."</font>";
        ?>

        <br><br><h2>FORMULARIO DE INSCRIPCIÓN</h2>
        <br>
        <p >En el siguiente formulario usted podrá realizar el trámite de pre matrícula concerniente al siguiente año lectivo.
          Por favor llene los siguientes campos:</p>



          <form id="inscribir_primaria">
            <!-- seccion de estudiantes -->
            <div>
              <h3>
                <font color=#555>Informaci&oacute;n del estudiante</font>
              </h3>
            </div>
            <div id="datos_estudiantes" class="form-group">
              <!-- nombres -->
              <div id="d11" class="form-group">
                <label for="nombre_estudiante">Nombres</label>
                <input id="nombre_estudiante" class="form_estudiante form-control" maxlength="40" required="" type="text"
                placeholder="nombres" />
              </div>
              <!-- Apellidos -->
              <div class="form-group">
                <label for="apellido_estudiante">Apellidos</label>
                <input id="apellido_estudiante" class="form_estudiante form-control" maxlength="40" required="" type="text"
                placeholder="apellidos" />
              </div>

              <!-- Fecha de nacimiento -->
              <div id="d13" class="form-group">
                <label from="nacimento">Fecha de nacimiento</label>
                <input id="nacimiento" class="form_estudiante form-control" type="date" required />
              </div>

              <!-- Ciudad de nacimiento-->
              <div class="form-group">
                <label from="ciudad_nacimiento"> Ciudad de nacimiento</label>
                <input id="ciudad_nacimiento" class="form_estudiante form-control" type="text"
                maxlength="30" placeholder="ciudad de nacimiento" required>
              </div>

              <!-- nivel de escolaridad , preescolar, primaria  .. -->
              <div class="form-group">
                <label from="escolaridad">Escolaridad</label>
                <?php
                //rutina para actualizar los niveles de escolridad
                // en este caso los correspondientes a
                // preescolar , primaria  y Bachillerato
                // conexion con la base de datos
                $link = conectar();
                // script de conexion
                $q = "select * from escolaridad where id_escolaridad < 4";
                // se ejecuta la consulta
                $reg=mysqli_query($link, $q) or ("No se encontro los datos de la tabla de escolaridad:".mysqli_error());

                echo "<select class='form_estudiante form-control' id='escolaridad' onchange='actualizar_grados_escolaridad();' required>";
                echo "<option value=''>Seleccione...</option>";

                while($dato = mysqli_fetch_array($reg))
                {
                  // recupero el nombre
                  $id = $dato["id_escolaridad"];
                  $escolaridad = $dato["escolaridad"];
                  echo "<option value = $id>$escolaridad</option>";
                }
                echo "</select>";
                ?>
              </div>
              <!-- grado del estudiane,  depende de lo que se halla seleccionado
              como nivel de escolaridad-->
              <div class="form-group">
                <label from="grado">Grado</label>
                <select class='form_estudiante form-control' id='grados_escolaridad' required>;
                <option value=''>Seleccione...</option>
                </select>
              </div>



              <!-- telefono -->
              <div id="d19" class="form-group">
                <label from="telefono">Teléfono</label>
                <input id="telefono" class="form_estudiante form-control" maxlength="12" type="tel"
                placeholder="número telefónico" required />
              </div>

              <!-- tipo de indentificacion -->
              <div id="d20" class="form-group"> <label>Tipo de indentificación</label>
                <select class="form_estudiante form-control" id="tipo_identificacion" required="">
                  <option value="">Seleccione...</option>
                  <option value="CC">cédula de ciudadanía</option>
                  <option value="CE">cédula de extranjería</option>
                  <option value="RC">registro civil</option>
                  <option value="NUIP">NUIP</option>
                </select>
              </div>

              <!-- numero de identificacion-->
              <div id="d22" class="form-group">
                <label from="documento_estudiante">Número de documento</label>
                <input id="documento_estudiante" class="form_estudiante form-control" maxlength="12" type="text"
                placeholder="número de documento" required />
              </div>

              <!-- lugar de expedicion-->
              <div id="d24" class="form-group">
                <label from="lugar_exp_estudiante">Lugar de expedici&oacute;n</label>
                <input id="lugar_exp_estudiante" type="text" class="form_estudiante form-control"
                placeholder="lugar de expedición" required></input>
              </div>

              <!-- genero del estudiante -->
              <div id="d26" class="form-group">
                <label from="genero" >G&eacute;nero: </label>
                <select name="genero" id="genero" class="form_estudiante form-control" required>
                  <option value="">Seleccione...</option>
                  <option value="M">masculino</option>
                  <option value="F">femenino</option>
                </select>
              </div>

              <!-- grupo rh -->
              <div id="28" class="form-group"> <label > Grupo RH</label>
                <select name="gruporh" id="gruporh" class="form_estudiante form-control" required>
                  <option value="">Seleccione...</option>
                  <option value="A+">A+</option>
                  <option value="A-">A-</option>
                  <option value="B+">B+</option>
                  <option value="B-">B-</option>
                  <option value="AB+">AB+</option>
                  <option value="AB-">AB-</option>
                  <option value="O+">O+</option>
                  <option value="O-">O-</option>
                </select>
              </div>

              <!-- Sisben -->
              <div id="30" class="form-group">
                <label >Sisben</label>
                <select name="nivelsisben" id="nivelsisben" class="form_estudiante form-control" required>
                  <option value="">Seleccione...</option>
                  <option value="99">No tiene</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                </select>
              </div>

              <!-- Direccion de residencia -->
              <div id="32" class="form-group"> <label > Direcci&oacute;n de residencia:</label>
                <input id="direccion_estudiante" type="text" class="form_estudiante form-control" placeholder="direccion de residencia" required>
              </div>

              <!-- Barrio -->
              <div id="34" class="form-group"> <label from="barrio" > Barrio:</label>
                <input id="barrio" class="form_estudiante form-control" name="barrio" type="text" placeholder="barrio" maxlength="40" required>
              </div>

              <!-- Estrato-->
              <div id="36" class="form-group">
                <label from_"estrato" > Estrato </label>
                <select  name="estrato" class="form_estudiante form-control" id="estrato" required>
                  <option value="">Seleccione...</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                </select>
              </div>

              <!-- Vive con-->
              <div id="38" class="form-group"> <label > Vive con : </label>
              </div>
              <div id="39"> <select name="vivecon" id="vivecon" class="form_estudiante form-control"
                >
                <option value="">Seleccione...</option>
                <option value="padres">ambos padres</option>
                <option value="padre">padre</option>
                <option value="madre">madre</option>
                <option value="abuelos">abuelos</option>
                <option value="hermanos">hermanos</option>
                <option value="tios">tíos</option>
                <option value="otro">otro</option>
              </select>
            </div>
          </div>

          <!-- Formulario del padre -->

          <div id="padre" style="display:none">

          <div style="margin-top: 50px;">
            <h3>
              <font color="blue">Informaci&oacute;n del padre</font>
            </h3>
          </div>

          <div id="datos_padre" class="form-group"
          style="border: solid 3px blue;padding: 2%;border-radius: 10px; margin-top: 20px;">
          <div id="d40" class="form-group">
            <label from="nombre_padre" >Nombres</label>
            <input id="nombre_padre" class="form_padres form-control" maxlength="40" required="" type="text"
            placeholder="nombres" />
          </div>

          <!-- Apellidos -->
          <div id="d42" class="form-group">
            <label from="apellido_padre">Apellidos</label>
            <input id="apellido_padre" class="form_padres form-control" maxlength="40" required="" type="text"
            placeholder="apellidos" />
          </div>


          <!-- Correo-->
          <div id="d44" class="form-group">
            <label from="correo_padre">Correo</label>
            <input id="correo_padre" class="form_padres form-control" required="" type="email"
            placeholder="correo electrónico" />
          </div>

          <!-- telefono -->
          <div id="d46" class="form-group">
            <label from="telefono_padre" >Teléfono</label>

            <input id="telefono_padre" class="form_padres form-control" maxlength="12" type="tel"
            placeholder="número telefónico" required />
          </div>

          <!-- tipo de indentificacion -->
          <div id="d48" class="form-group">
            <label from="tipo_identificacion_padre">Tipo de indentificación</label>
            <select id="tipo_identificacion_padre" class="form_padres form-control" required="">
              <option value="">Seleccione...</option>
              <option value="CC">cédula de ciudadanía.</option>
              <option value="CE">cédula de extranjería.</option>
              <option value="NUIP">NUIP</option>
            </select>
          </div>

          <!-- documento-->
          <div id="d50" class="form-group">
            <label from="documento_padre" >N&uacute;mero del documento</label>
            <input id="documento_padre" class="form_padres form-control" maxlength="12" type="text"
            placeholder="número de documento" required />
          </div>

          <!-- lugar de expedicion-->
          <div id="52" class="form-group">
            <label from="lugar_exp_padre">Lugar de expedici&oacute;n</label>
            <input id="lugar_exp_padre" type="text" class="form_padres form-control"
            placeholder="lugar de expedición" required>
          </input>
        </div>

        <!-- Direccion de residencia -->
        <div id="54" class="form-group">
          <label from="direccion_padre" > Direcci&oacute;n de residencia:</label>
          <input id="direccion_padre" type="text" class="form_padres form-control"
          placeholder="direccion de residencia" required>
        </div>

        <!-- Barrio -->
        <div id="56" class="form-group">
          <label from="barrio_padre">Barrio: </label>
          <input id="barrio_padre" name="barrio_padre" class="form_padres form-control" type="text" placeholder="barrio" maxlength="40"
          required>
        </div>


      </div>
    </div>

      <div id="madre"  style="display:none">
      <!-- Formulario de la madre -->
      <div style="margin-top: 50px;">
        <h3>
          <font color="tomato"> Informaci&oacute;n de la madre</font>
        </h3>
      </div>


      <div id="datos_madre" class="regilla"
      style="border: solid 3px tomato;padding: 2%;border-radius: 10px; margin-top: 20px;">
      <div id="d60" class="form-group">
        <label from="nombre_madre" >Nombres</label>
        <input id="nombre_madre" class="form_padres form-control" maxlength="40" required="" type="text"
        placeholder="nombres" />
      </div>
      <!-- Apellidos -->
      <div id="d62" class="form-group">
        <label from="apellido_madre">Apellidos</label>
        <input id="apellido_madre" class="form_padres form-control" maxlength="40" required="" type="text"
        placeholder="apellidos" />
      </div>


      <!-- Correo-->
      <div id="d64" class="form-group">
        <label from="correo_madre">Correo</label>
        <input id="correo_madre" class="form_padres form-control" required="" type="email"
        placeholder="correo electrónico" />
      </div>

      <!-- telefono -->
      <div id="d66" class="form-group">
        <label from="telefono_madre">Teléfono</label>
        <input id="telefono_madre" class="form_padres form-control" maxlength="12" type="tel"
        placeholder="número telefónico" required />
      </div>

      <!-- tipo de indentificacion -->
      <div id="d68" class="form-group"> <label from="tipo_identificacion_madre">Tipo de indentificación</label>
        <select id="tipo_identificacion_madre" class="form_padres form-control" required="">
          <option value="">Seleccione...</option>
          <option value="CC">Cédula de ciudadania</option>
          <option value="CE">Cédula de extranjer&iacute;a </option>
          <option value="NUIP">NUIP</option>
        </select>
      </div>

      <!-- documento de la madre-->
      <div id="d70" class="form-group">
        <label from="documento_madre">N&uacute;mero de documento</label>
        <input id="documento_madre" class="form_padres form-control" maxlength="12" type="text"
        placeholder="número de documento" required />
      </div>

      <!-- lugar de expedicion-->
      <div id="72" class="form-group">
        <label from="lugar_exp_madre" >Lugar de expedici&oacute;n</label>
        <input id="lugar_exp_madre" type="text" class="form_padres form-control"
        placeholder="lugar de expedición" required></input>
      </div>

      <!-- Direccion de residencia -->
      <div id="74" class="form-group">
        <label form="direccion_madre"> Direccion de residencia:</label>
        <input id="direccion_madre" type="text" class="form_padres form-control"
        placeholder="direccion de residencia" required>
      </div>

      <!-- Barrio -->
      <div id="76" class="form-group"> <label from="barrio_madre">Barrio: </label>
        <input id="barrio_madre" name="barrio_madre" type="text" class="form_padres form-contol"
        placeholder="barrio" maxlength="40" required>
      </div>

    </div>
  </div>
  </form>

  <br>
  <input class="boton_formulario" type="button" value="Inscribir" onclick="enviar_matricula()"/>

</div>

</div>
<!-- fin del codigo-->
</div> <!-- max-width-->
</section>

<!-- footer section start -->
<footer>
  <span>Contenido de <a href="https://www.imcreativo.edu.co/">MundoCreativo</a> | <span
    class="far fa-copyright"></span> 2021</span>
  </footer>

  <script src="../JS/script.js"></script>
</body>

</html>
