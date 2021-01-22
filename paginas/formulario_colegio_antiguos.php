<!DOCTYPE html>
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
        <div class="col-sm-4">
          <!-- <div class="nav nav-pills flex-column" id="v-pills-tab">
          <a class="active" data-toggle="pill" href="#v-pills-home"><button type="button" class="btn btn-outline-primary boton_grado">PRE ESCOLAR</button></a>
          <a data-toggle="pill" href="#v-pills-profile"><button type="button" class="btn btn-outline-secondary boton_grado" >PARVULOS</button></a>
          <a data-toggle="pill" href="#v-pills-messages"><button type="button" class="btn btn-outline-secondary boton_grado">JARDÍN</button></a>
          <a data-toggle="pill" href="#v-pills-settings"><button type="button" class="btn btn-outline-secondary boton_grado">PRE JARDÍN</button></a>
        </div> -->
      </div>

      <div class="col-sm-8">

        <?php
        setlocale(LC_ALL,"es_CO");
        date_default_timezone_set('America/Bogota');
        echo '<br><font color="darkblue">'.strftime("Hoy es %A %e de %B del %Y")."</font>";
        ?>

        <br><br><h2>FORMULARIO DE INSCRIPCIÓN</h2>
        <br>
        <p class="parrafo">En el siguiente formulario usted podrá realizar el trámite de pre matrícula concerniente al siguiente año lectivo.
          Por favor llene los siguientes campos:</p>

          <!-- Formulario -->
          <form id="inscribir_primaria">
            <!-- seccion de estudiantes -->
            <div>
              <h3>
                <font color=#555>Informaci&oacute;n del estudiante</font>
              </h3>
            </div>
            <div id="datos_estudiantes" class="regilla" style="background-color: #fdf7af;padding: 2%; border-radius: 10px;">
              <!-- nombres -->
              <div id="d11" class="text_formulario">
                <label class="parrafo">Nombres</label>
              </div>
              <div id="d12">
                <input id="nombre_estudiante" class="tag_formulario" maxlength="40" required="" type="text"
                placeholder="nombres" />
              </div>
              <!-- Apellidos -->
              <div id="d13" class="text_formulario">
                <label class="parrafo ">Apellidos</label>
              </div>
              <div id="d14">
                <input id="apellido_estudiante" class="tag_formulario" maxlength="40" required="" type="text"
                placeholder="apellidos" />
              </div>

              <!-- Fecha de nacimiento -->
              <div id="d13" class="text_formulario">
                <label class="parrafo ">Fecha de nacimiento</label>
              </div>
              <div id="d14"><input id="nacimiento" class="tag_formulario" type="date" required />
              </div>

              <!-- Ciudad de nacimiento-->
              <div> <label class="parrafo"> Ciudad de nacimiento</label>
              </div>
              <div> <input id="ciudad_nacimiento" type="text" maxlength="30" placeholder="ciudad de nacimiento" required>
              </div>

              <!-- Correo-->
              <div id="d17" class="text_formulario">
                <label class="parrafo">Correo</label>
              </div>
              <div id="d18"><input id="correo_estudiante" class="tag_formulario" required="" type="email"
                placeholder="correo electrónico" />
              </div>

              <!-- telefono -->
              <div id="d19" class="text_formulario">
                <label class="parrafo">Teléfono</label>
              </div>
              <div id="d10"><input id="telefono" class="tag_formulario" maxlength="12" type="tel"
                placeholder="número telefónico" required />
              </div>

              <!-- tipo de indentificacion -->
              <div id="d20" class="text_formulario"> <label>Tipo de indentificación</label>
              </div>
              <div id="d21">
                <select id="tipo_identificacion" required="">
                  <option value="">Seleccione...</option>
                  <option value="CC">cédula de ciudadanía</option>
                  <option value="CE">cédula de extranjería</option>
                  <option value="RC">registro civil</option>
                  <option value="NUIP">NUIP</option>
                </select>
              </div>
              <!-- numero de identificacion-->
              <div id="d22" class="text_formulario">
                <label class="parrafo">Número de documento</label>
              </div>
              <div id="d23"><input id="cedula" class="tag_formulario" maxlength="12" type="text"
                placeholder="número de documento" required />
              </div>

              <!-- lugar de expedicion-->
              <div id="d24"><label>Lugar de expedici&oacute;n</label>
              </div>
              <div id="d25"> <input id="lugar_exp_estudiante" type="text" class="tag_formulario"
                placeholder="lugar de expedición" required></input>
              </div>

              <div id="d26"><label class="parrafo">G&eacute;nero: </label>
              </div>
              <div id="d27"> <select name="genero" id="genero" required>
                <option value="">Seleccione...</option>
                <option value="M">masculino</option>
                <option value="F">femenino</option>
              </select>
            </div>

            <!-- grupo rh -->
            <div id="28" class="text_formulario"> <label class="parrafo"> Grupo RH</label>
            </div>
            <div id="29"> <select name="gruporh" id="gruporh" required>
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
          <div id="30" class="text_formulario"> <label class="parrafo"> Sisben</label>
          </div>
          <div id="31"> <select name="nivelsisben" id="nivelsisben" required>
            <option value="">Seleccione...</option>
            <option value="99">No tiene</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select> </div>

          <!-- Direccion de residencia -->
          <div id="32" class="text_formulario"> <label class="parrafo"> Direcci&oacute;n de residencia:</label>
          </div>
          <div id="33"> <input id="direccion_estudiante" type="text" class="tag_formulario" placeholder="direccion de residencia" required>
          </div>

          <!-- Barrio -->
          <div id="34" class="text_formulario"> <label class="parrafo"> </label> Barrio:
          </div>
          <div id="35"> <input id="barrio" name="barrio" type="text" placeholder="barrio" maxlength="40" required>
          </div>

          <!-- Estrato-->
          <div id="36" class="text_formulario"> <label class="parrafo"> Estrato </label> </div>
          <div id="37"> <select name="estrato" id="estrato" required>
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
        <div id="38" class="text_formulario"> <label class="parrafo"> Vive con : </label>
        </div>
        <div id="39"> <select name="vivecon" id="vivecon">
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


    <div style="margin-top: 50px;">
      <h3>
        <font color="blue">Informaci&oacute;n del padre</font>
      </h3>
    </div>

    <div id="datos_padre" class="regilla"
    style="border: solid 3px blue;padding: 2%;border-radius: 10px; margin-top: 20px;">
    <div id="d40" class="text_formulario">
      <label class="parrafo">Nombres</label>
    </div>
    <div id="d41">
      <input id="nombre_padre" class="tag_formulario" maxlength="40" required="" type="text"
      placeholder="nombres" />
    </div>
    <!-- Apellidos -->
    <div id="d42" class="text_formulario">
      <label class="parrafo ">Apellidos</label>
    </div>
    <div id="d43">
      <input id="apellido_padre" class="tag_formulario" maxlength="40" required="" type="text"
      placeholder="apellidos" />
    </div>


    <!-- Correo-->
    <div id="d44" class="text_formulario">
      <label class="parrafo">Correo</label>
    </div>
    <div id="d45"><input id="correo_padre" class="tag_formulario" required="" type="email"
      placeholder="correo electrónico" />
    </div>

    <!-- telefono -->
    <div id="d46" class="text_formulario">
      <label class="parrafo">Teléfono</label>
    </div>
    <div id="d47"><input id="telefono_padre" class="tag_formulario" maxlength="12" type="tel"
      placeholder="número telefónico" required />
    </div>

    <!-- tipo de indentificacion -->
    <div id="d48" class="text_formulario"> <label>Tipo de indentificación</label>
    </div>
    <div id="d49">

      <select id="tipo_identificacion_padre" required="">
        <option value="">Seleccione...</option>
        <option value="CC">cédula de ciudadanía.</option>
        <option value="CE">cédula de extranjería.</option>
        <option value="RC">registro civil</option>
        <option value="NUIP">NUIP</option>
      </select>
    </div>
    <!-- cedula-->
    <div id="d50" class="text_formulario">
      <label class="parrafo">Numero del documento</label></div>
      <div id="d51"><input id="cedula_padre" class="tag_formulario" maxlength="12" type="text"
        placeholder="número de documento" required />
      </div>

      <!-- lugar de expedicion-->
      <div id="52"><label>Lugar de expedici&oacute;n</label>
      </div>
      <div id="53"> <input id="lugar_exp_padre" type="text" class="tag_formulario" placeholder="lugar de expedición"
        required></input>
      </div>

      <!-- Direccion de residencia -->
      <div id="54" class="text_formulario"> <label class="parrafo"> Direccion de residencia:</label> </div>
      <div id="55"> <input id="direccion_padre" type="text" class="tag_formulario"
        placeholder="direccion de residencia" required>
      </div>

      <!-- Barrio -->
      <div id="56" class="text_formulario"> <label class="parrafo"> </label> Barrio:
      </div>
      <div id="57"> <input id="barrio_padre" name="barrio_padre" type="text" placeholder="barrio" maxlength="40"
        required>
      </div>


    </div>


    <!-- Formulario de la madre -->
    <div style="margin-top: 50px;">
      <h3>
        <font color="tomato"> Informaci&oacute;n de la madre</font>
      </h3>
    </div>
    <div id="d1_inscribir" class="regilla"
    style="border: solid 3px tomato;padding: 2%;border-radius: 10px; margin-top: 20px;">
    <div id="d60" class="text_formulario">
      <label class="parrafo">Nombres</label>
    </div>
    <div id="d61">
      <input id="nombre_madre" class="tag_formulario" maxlength="40" required="" type="text"
      placeholder="nombres" />
    </div>
    <!-- Apellidos -->
    <div id="d62" class="text_formulario">
      <label class="parrafo ">Apellidos</label>
    </div>
    <div id="d63">
      <input id="apellido_madre" class="tag_formulario" maxlength="40" required="" type="text"
      placeholder="apellidos" />
    </div>


    <!-- Correo-->
    <div id="d64" class="text_formulario">
      <label class="parrafo">Correo</label>
    </div>
    <div id="d65"><input id="correo_madre" class="tag_formulario" required="" type="email"
      placeholder="correo electrónico" />
    </div>

    <!-- telefono -->
    <div id="d66" class="text_formulario">
      <label class="parrafo">Teléfono</label>
    </div>
    <div id="d67"><input id="telefono_madre" class="tag_formulario" maxlength="12" type="tel"
      placeholder="número telefónico" required />
    </div>

    <!-- tipo de indentificacion -->
    <div id="d68" class="text_formulario"> <label>Tipo de indentificación</label>
    </div>
    <div id="d69">

      <select id="tipo_identificacion_madre" required="">
        <option value="">Seleccione...</option>
        <option value="CC">Cédula de ciudadania</option>
        <option value="CE">Cédula de extranjer&iacute;a </option>
        <option value="RC">Registro Civil</option>
        <option value="NUIP">NUIP</option>
      </select>
    </div>
    <!-- cedula-->
    <div id="d70" class="text_formulario">
      <label class="parrafo">Numero de documento</label>
    </div>
    <div id="d71"><input id="cedula_madre" class="tag_formulario" maxlength="12" type="text"
      placeholder="número de documento" required />
    </div>

    <!-- lugar de expedicion-->
    <div id="72"><label>Lugar de expedici&oacute;n</label>
    </div>
    <div id="73"> <input id="lugar_exp_madre" type="text" class="tag_formulario"
      placeholder="lugar de expedición" required></input>
    </div>


    <!-- Direccion de residencia -->
    <div id="74" class="text_formulario"> <label class="parrafo"> Direccion de residencia:</label>
    </div>
    <div id="75"> <input id="direccion_madre" type="text" class="tag_formulario"
      placeholder="direccion de residencia" required>
    </div>

    <!-- Barrio -->
    <div id="76" class="text_formulario"> <label class="parrafo"> </label> Barrio:
    </div>
    <div id="77" > <input id="barrio_madre" name="barrio_madre" type="text"
      placeholder="barrio" maxlength="40" required>
    </div>

    <div style="margin-top: 20px;">
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
