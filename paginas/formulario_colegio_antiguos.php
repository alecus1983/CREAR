<!DOCTYPE html>

<?php
require 'conexion.php';
//require "valores.php";
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario</title>
  <script src="../JS/a076d05399.js"></script>
  <!-- <script src="../JS/carga-datos-formulario-matricula-primaria.js"></script> -->
  <script src="../JS/jquery-3.5.1.min.js"></script>
  <script src="../JS/typed.min.js"></script>
  <script src="../JS/jquery.waypoints.min.js"></script>
  <script src="../JS/owl.carousel.min.js"></script>
  <script src="../JS/ajax.js"></script>
  <!-- <script src="../JS/bootstrapValidator.min.js"></script> -->
  <!-- <script src="../JS/es_ES.min.js"></script> -->
  <script src="../JS/validator.min.js"></script>
  <script src="../JS/validator.js"></script>
  <script src="../JS/sweetalert.min.js"></script>

  <!-- <link href="../CSS/template.css" rel="stylesheet" type="text/css" /> -->
  <!-- <link href="../CSS/fa-v4-shims.css" rel="stylesheet" type="text/css" /> -->
  <!-- <link href="../CSS/default.css" rel="stylesheet" type="text/css" /> -->
  <link href="../CSS/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <script src="../JS/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../CSS/style.css" type="text/css">
  <link rel="stylesheet" href="../CSS/estilos.css" type="text/css">
  <!-- <link rel="stylesheet" href="..CSS/bootstrapValidator.min.css"> -->
  <!-- <link href="../images/sampledata/iconos/escudo.png" rel="shortcut icon" type="image/vnd.microsoft.icon" /> -->

  <script type="text/javascript">

  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();

  $(document).on('change', '#vivecon', function(event) {
    var padres = $("#vivecon option:selected").text();

    switch (padres) {
      case "madre":
      $("#madre").css("display" , "block");
      $("#padre").css("display" , "none");
      $(".madre").prop('required',true);
      $(".padre").prop('required',false);

      break;
      case "padre":
      $("#padre").css("display" , "block");
      $("#madre").css("display" , "none");
      $(".madre").prop('required',false);
      $(".padre").prop('required',true);
      break;

      default:
      $("#padre").css("display" , "block");
      $("#madre").css("display" , "block");
      $(".madre").prop('required',true);
      $(".padre").prop('required',true);

    }
  });

  //   function pregunta(){
  //     if (confirm('¿Estas seguro de enviar este formulario?')){
  //        document.forms.inscribir_primaria.submit();
  //     }
  // }

</script>

</head>

<body onload="$('#escolaridad option[value=\'\']').attr('selected',true);">

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
        <div class="col-xs-0 col-sm-1 col-md-3 col-lg-3">
          <!-- -->
        </div>

        <!-- columna de la derecha -->
        <div class="col-sx-12 col-sm-9 col-md-8 col-lg-8">

          <?php
          setlocale(LC_ALL,"es_CO");
          date_default_timezone_set('America/Bogota');
          echo '<br><font color="darkblue">'
          .utf8_encode(strftime("Hoy es %A %e de %B del %Y"))."</font>";
          ?>

          <br><br><h2>FORMULARIO DE INSCRIPCIÓN</h2>
          <br>
          <p >En el siguiente formulario usted podrá realizar el trámite de
            pre matrícula concerniente al siguiente año lectivo.
            Por favor llene los siguientes campos:</p>



            <form id="inscribir_primaria" data-toggle="validator" role="form"
            class="needs-validation"
            action="./inscribir_colegio.php" method="POST" target="_blank" novalidate>
            <!-- seccion de estudiantes -->
            <div>
              <h3>
                <font color=#555>Informaci&oacute;n del estudiante</font>
              </h3>
            </div>

            <span class="font-weight-bold">
              <h4 class="titulo_estudiante">Datos básicos
              </h4>
            </span>
            <hr>

            <div id="datos_estudiantes" >
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <!-- nombres -->
                  <div  class="form-group">
                    <label for="nombre_estudiante" class="control-label">Nombres</label>
                    <input id="nombre_estudiante" name="nombre_estudiante"
                    class="form_estudiante form-control" maxlength="40"  type="text"
                    placeholder="nombres"  required/>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <!-- Apellidos -->
                  <div class="form-group">
                    <label for="apellido_estudiante" class="control-label">Apellidos</label>
                    <input id="apellido_estudiante" name="apellido_estudiante"
                    class="form_estudiante form-control" maxlength="40"  type="text"
                    placeholder="apellidos" required/>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
              </div>


              <div class="form-row">
                <div class="col-md-4">
                  <!-- tipo de indentificacion -->
                  <div class="form-group">
                    <label class="control-label">Tipo de indentificación</label>
                    <select class="form_estudiante form-control" id="tipo_identificacion"
                    name="tipo_identificacion" required>
                    <option value="">Seleccione...</option>
                    <option value="RC">Targeta Identidad</option>
                    <option value="CC">cédula de ciudadanía</option>
                    <option value="CE">cédula de extranjería</option>
                    <option value="RC">registro civil</option>
                    <option value="NUIP">NUIP</option>
                  </select>
                  <div class="help-block with-errors"></div>
                </div>

              </div>
              <div class="col-md-4">
                <!-- numero de identificacion-->
                <div class="form-group">
                  <label from="documento_estudiante" class="control-label">Número de documento</label>
                  <input id="documento_estudiante" name="documento_estudiante"
                  class="form_estudiante form-control"
                  maxlength="12" type="number" min="99999"
                  placeholder="número de documento"  required/>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-4">
                <!-- lugar de expedicion-->
                <div  class="form-group">
                  <label from="lugar_exp_estudiante" class="control-label">
                    Lugar de expedici&oacute;n</label>
                    <input id="lugar_exp_estudiante" name="lugar_exp_estudiante"
                    type="text" class="form_estudiante form-control"
                    placeholder="lugar de expedición" required ></input>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
              </div>


              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <!-- Fecha de nacimiento -->
                  <div  class="form-group">
                    <label from="nacimento" class="control-label">Fecha de nacimiento</label>
                    <input id="nacimiento" name="nacimiento"
                    class="form_estudiante form-control" type="date" min="2000-01-01"  required/>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <!-- Ciudad de nacimiento-->
                  <div class="form-group">
                    <label from="ciudad_nacimiento" class="control-label"> Ciudad de nacimiento</label>
                    <input id="ciudad_nacimiento" name="ciudad_nacimiento"
                    class="form_estudiante form-control" type="text"
                    maxlength="30" placeholder="ciudad de nacimiento" required>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="col-md-6">
                  <!-- Correo-->
                  <div class="form-group">
                    <label from="correo_estudiante" class="control-label">Correo</label>
                    <input id="correo_estudiante" name="correo_estudiante"
                    class="form_estudiante form-control"  type="email"
                    placeholder="correo electrónico"
                    required />
                    <!-- <small id="emailHelp" class="form-text text-muted">
                    For authentication purposes only. We will never share
                    your email with anyone!
                  </small> -->
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6">
                <!-- genero del estudiante -->
                <div  class="form-group">
                  <label from="genero" class="control-label">G&eacute;nero: </label>
                  <select name="genero" id="genero" name="genero"
                  class="form_estudiante form-control" required>
                  <option value="">Seleccione...</option>
                  <option value="M">masculino</option>
                  <option value="F">femenino</option>
                </select>
                <div class="help-block with-errors"></div>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="col-md-6 mb-3">
              <!-- celular -->
              <div class="form-group">
                <label from="celular" class="control-label">N&uacute;mero celular</label>
                <input id="celular" name="celular"
                class="form_estudiante form-control" maxlength="12" type="tel"
                minlength="10"
                placeholder="número celular"  required/>
                <div class="help-block with-errors"></div>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <!-- telefono -->
              <div class="form-group">
                <label from="telefono" class="control-label">Número fijo</label>
                <input id="telefono" name="telefono"
                class="form_estudiante form-control" maxlength="12" type="tel"
                minlength="7"
                placeholder="número telefónico"/>
                <div class="help-block with-errors"></div>
              </div>
            </div>
          </div>

          <span class="font-weight-bold ">
            <h4 class="titulo_estudiante">Nivel educativo
            </h4>
          </span>
          <hr>

          <div class="form-row">
            <div class="col-md-6 mb-3">
              <!-- nivel de escolaridad , preescolar, primaria  .. -->
              <div class="form-group">
                <label from="escolaridad" class="control-label" >Escolaridad</label>
                <?php
                //rutina para actualizar los niveles de escolridad
                // en este caso los correspondientes a
                // preescolar , primaria  y Bachillerato
                // conexion con la base de datos
                $link = conectar();
                // script de conexion
                $q = "select * from escolaridad where id_escolaridad < 4";
                // se ejecuta la consulta
                $reg=mysqli_query($link, $q)
                or ("No se encontro los datos de la tabla de escolaridad:"
                .mysqli_error());

                echo "<select class='form_estudiante form-control' id='escolaridad'
                name='escolaridad'
                onchange='actualizar_grados_escolaridad();' required >";
                echo "<option value='' selected='selected'>Seleccione...</option>";

                while($dato = mysqli_fetch_array($reg))
                {
                  // recupero el nombre
                  $id = $dato["id_escolaridad"];
                  $escolaridad = $dato["escolaridad"];
                  echo "<option value = $id>".utf8_encode($escolaridad)."</option>";
                }
                echo "</select>";
                ?>
                <div class="help-block with-errors"></div>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <!-- grado del estudiane,  depende de lo que se halla seleccionado
              como nivel de escolaridad-->
              <div class="form-group">
                <label from="grado" class="control-label">Grado</label>
                <select class='form_estudiante form-control' id='grados_escolaridad'
                name='grados_escolaridad' required >;
                <option value=''>Seleccione...</option>
                <div class="help-block with-errors"></div>
              </select>
              <div class="help-block with-errors"></div>
            </div>
          </div>
        </div>

        <!-- Jornada -->
        <div class="form-row">
          <div class="col-sm-12 col-md-6">
            <div class="form-group">
              <label for="jornada">Jornada</label>
              <select class="form_estudiante form-control" id="jornada"
              name="jornada" required>
              <option value="">Seleccione...</option>
              <option value="1">Mañana</option>
              <option value="2">Tarde</option>
            </select>
            <div class="help-block with-errors"></div>
          </div>
        </div>

        <!-- Modalidad -->
        <div class="col-md-6">
          <div class="form-group">
            <label for="antiguedad">Modo</label>
            <div class="form-group">
              <div class="form-check form-check-inline">
                <label>
                  <input type="radio" name="modo" value=0 required>
                  Virtual
                </label>
              </div>
              <div class="form-check form-check-inline">
                <label>
                  <input type="radio" name="modo" value=1 required>
                  Precencial
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="antiguedad">Antiguedad</label>
            <div class="form-group">
              <div class="form-check form-check-inline">
                <label>
                  <input type="radio" name="antiguedad" value=0 required>
                  Nuevo
                </label>
              </div>
              <div class="form-check form-check-inline">
                <label>
                  <input type="radio" name="antiguedad" value=1 required>
                  Antiguo
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="antiguedad">Instituci&oacute;n de la que proviene</label>
            <div class="form-group">
              <div class="form-check form-check-inline">
                <label>
                  <input type="radio" id="tipo_institucion" name="tipo_institucion" value=1 required>
                  Publica
                </label>
              </div>
              <div class="form-check form-check-inline">
                <label>
                  <input type="radio" name="tipo_institucion" value=0 required>
                  Privada
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="institucion">Nombre de la instituci&oacute;n</label>
            <input type="text"  class="form_estudiante form-control"
            id="institucion" name="institucion"
            maxlength="24" placeholder="isntitución de procedencia"></input>
          </div>

        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="motivo">Motivo</label>
            <input type="text" class="form-control form_estudiante" id="motivo"
            name="motivo" maxlength="30" placeholder="Motivo retiro">
          </div>
        </div>
      </div>

      <span class="font-weight-bold">
        <h4 class="titulo_estudiante">Antecedentes Patol&oacute;gicos
        </h4>
      </span>
      <hr >

      <div class="form-row">
        <div class="col-md-6 col-sm-12">
          <!-- EPS-->
          <div class="form-group">
            <label from="EPS" class="control-label"> EPS</label>
            <input id="EPS" name="EPS"
            class="form_estudiante form-control" type="text"
            maxlength="20" minlength="3" placeholder="EPS" required>
            <div class="help-block with-errors"></div>
          </div>
        </div>
        <div class="col-md-6 sm-12">

          <!-- grupo rh -->
          <div class="form-group">
            <label class="control-label"> Grupo RH</label>
            <select name="gruporh" id="gruporh" name="gruporh"
            class="form_estudiante form-control" required>
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
          <div class="help-block with-errors"></div>
        </div>
      </div>
    </div>

    <div class="form-row">
      <div class="col-md-6 md-3">
        <!-- Direccion de residencia -->
        <div class="form-group">
          <label class="control-label">Direcci&oacute;n de residencia:</label>
          <input id="direccion_estudiante" name="direccion_estudiante"
          type="text" class="form_estudiante form-control"
          placeholder="direccion de residencia" required>
          <div class="help-block with-errors"></div>
        </div>
      </div>

      <div class="col-md-6">
        <!-- Barrio -->
        <div  class="form-group">
          <label from="barrio" class="control-label"> Barrio:</label>
          <input id="barrio" name="barrio" class="form_estudiante form-control"
          name="barrio" type="text" placeholder="barrio" maxlength="40"
          required>
          <div class="help-block with-errors"></div>
        </div>
      </div>
    </div>

    <span class="font-weight-bold">
      <h4 class="titulo_estudiante">Datos socio econ&oacute;micos
      </h4>
    </span>
    <hr >




        <div class="form-row">
          <div class="col-md-6">
            <!-- Sisben -->
            <div class="form-group">
              <label class="control-label">Sisben</label>
              <select name="nivelsisben" id="nivelsisben" name="nivelsisben"
              class="form_estudiante form-control" required>
              <option value="">Seleccione...</option>
              <option value="99">No tiene</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
            </select>
            <div class="help-block with-errors"></div>
          </div>
        </div>

        <div class="col-md-6">
          <!-- Estrato-->
          <div class="form-group">
            <label from="estrato" class="control-label"> Estrato </label>
            <select  name="estrato" class="form_estudiante form-control"
            id="estrato" name="estrato" required>
            <option value="">Seleccione...</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
          <div class="help-block with-errors"></div>
        </div>
      </div>
    </div>


    <div class="form-row">
      <div class="col-md6">
        <div class="form-group">

          <label class="control-label">
            Etnia :
          </label>

            <select class="form-control form-estudiane" name="etnia">
              <option value="0">Seleccione...</option>
              <option value="1">ACHAGUA</option>
              <option value="2">AFRODESCENDIENTE</option>
              <option value="3">AMBALO</option>
              <option value="4">AMORUA</option>
              <option value="5">ANDOQUE</option>
              <option value="6">ARHUACO</option>
              <option value="7">AWA</option>
              <option value="8">BANIVA</option>
              <option value="9">BARA</option>
              <option value="10">BARASANO</option>
              <option value="11">BARI</option>
              <option value="12">BETOYE (GUAHIBO)</option>
              <option value="13">BORA</option>
              <option value="14">CAMENTSA (KAMSA - KAMENTSA)</option>
              <option value="15">CHIMILAS</option>
              <option value="16">CHIRICOA</option>
              <option value="17">COCAMA</option>
              <option value="18">COCONUCO</option>
              <option value="19">COREGUAJE</option>
              <option value="20">CUBEO</option>
              <option value="21">CUIVA (CUIBA - KUIVA)</option>
              <option value="22">CUNA (TULE)</option>
              <option value="23">CURRIPACO</option>
              <option value="24">DESANO</option>
              <option value="25">EMBERA CHAMI</option>
              <option value="26">EMBERA KATIO</option>
              <option value="27">EMBERASIAPIDARA</option>
              <option value="28">GUAMBIANO (AUTODENOMINACION NA...</option>
              <option value="29">GUANANO (WANANO)</option>
              <option value="30">GUARIQUEMA</option>
              <option value="31">GUAYABERO (AUTODENOMICACION JI...</option>
              <option value="32">HITNU</option>
              <option value="33">INGA</option>
              <option value="34">JURUMI (URTUMI)</option>
              <option value="35">KANKUAMO</option>
              <option value="36">KARAPANA (CARAPANA)</option>
              <option value="37">KARIJONA (CARIJONA)</option>
              <option value="38">KAWIYARI (CABIYARI)</option>
              <option value="39">KICHWA</option>
              <option value="40">KIZGO (QUISGO)</option>
              <option value="41">KOFAN</option>
              <option value="42">KOGUI</option>
              <option value="43">LETUAMA</option>
              <option value="44">MACAGUAJE</option>
              <option value="45">MACAHUA(N)</option>
              <option value="46">MAKUNA</option>
              <option value="47">MAPAYERRY</option>
              <option value="48">MASIWARE (MASIGUARE - MAIBEN)</option>
              <option value="49">MATAPI</option>
              <option value="50">MIRA&#209;A</option>
              <option value="51">MOKANA</option>
              <option value="52">MUINANE</option>
              <option value="53">MUISCA</option>
              <option value="54">MURUI (MURUI - WITO)</option>
              <option value="55">NEGRITUDES</option>
              <option value="56" selected="selected">NO APLICA</option>
              <option value="57">NONUYA</option>
              <option value="58">NUKAK MAKU (SE INCLUYEN HUPHU,...</option>
              <option value="59">OCAINA</option>
              <option value="60">PAEZ (AUTODENOMINACION NASA)</option>
              <option value="61">PALANQUERO</option>
              <option value="62">PASTOS</option>
              <option value="63">PIAPOCO</option>
              <option value="64">PIAROA</option>
              <option value="65">PIJAO (COYAIMAS - NATAGAIMAS)</option>
              <option value="66">PIRATAPUYO</option>
              <option value="67">PISAMIRA</option>
              <option value="68">POLINDARAS</option>
              <option value="69">PUINAVE</option>
              <option value="70">QUILLACINGAS</option>
              <option value="71">RAIZAL</option>
              <option value="72">ROM</option>
              <option value="73">SALIVA (SALIBA)</option>
              <option value="74">SIKUANI (SICUANI)</option>
              <option value="75">SIONA</option>
              <option value="76">SIRIANO</option>
              <option value="77">TAIWANO</option>
              <option value="78">TAMAS (DUJOS DE PANIQUITA)</option>
              <option value="79">TANIMUKA</option>
              <option value="80">TARIANO</option>
              <option value="81">TATUYO</option>
              <option value="82">TIKUNAS</option>
              <option value="83">TOTOR&#211;</option>
              <option value="84">TSIRIPU (TSHIRIPO)</option>
              <option value="85">TUKANO</option>
              <option value="86">TUYUCA</option>
              <option value="87">UITOTOS (HUITOTO - WITOTO)</option>
              <option value="88">U&#180;WA</option>
              <option value="89">WAUNANA (WOUNAAN)</option>
              <option value="90">WAYUU</option>
              <option value="91">WIPIWI</option>
              <option value="92">WIWA</option>
              <option value="93">YAGUA</option>
              <option value="94">YAMALERO</option>
              <option value="95">YANACONA</option>
              <option value="96">YARI</option>
              <option value="97">YARURO</option>
              <option value="98">YAUNA</option>
              <option value="99">YUCUNA</option>
              <option value="100">YUKO</option>
              <option value="101">YURI</option>
              <option value="102">YURUTI (TAPUYA)</option>
              <option value="103">ZENU (SENU)</option>
            </select>
          </div>
        </div>


      </div>


    <div class="from-row">
      <div  class="col-md-12">
        <div class="form-group">
          <label class="control-label">
            Poblaci&oacute;n V&iacute;ctima del Conflicto * : </label>
            <select class="form_estudiante form-control" name="victima">
              <option value="0">Seleccione...</option>
              <option value="1">ABANDONO O DESPOJO DE TIERRAS</option>
              <option value="2">ACTO TERRORISTA /ATENTADOS/ COMBATES/ HOSTIGAMIENTOS</option>
              <option value="3">AMENAZA</option>
              <option value="4">CONFINAMIENTO</option>
              <option value="5">DELITOS CONTRA LA LIBERTAD E INTEGRIDAD SEXUAL EN EL MARCO</option>
              <option value="6">DESAPARICION FORZADA</option>
              <option value="7">DESPLAZAMIENTO FORZADO</option>
              <option value="8">DESVINCULADOS DE GRUPOS ARMADOS</option>
              <option value="9">EN SITUACI&#211;N DE DESPLAZAMIENTO</option>
              <option value="10">HIJOS DE ADULTOS DESMOVILIZADOS</option>
              <option value="11">HOMICIDIO</option>
              <option value="12">LESIONES PERSONALES F&#205;SICAS</option>
              <option value="13">LESIONES PERSONALES PSICOL&#211;GICAS</option>
              <option value="14">MINAS ANTIPERSONALES, MUNICI&#211;N SIN EXPLOTAR</option>
              <option value="15" selected="selected">NO APLICA</option>
              <option value="16">OTROS</option>
              <option value="17">PERDIDA DE BIENES MUEBLES O INMUEBLES</option>
              <option value="18">SECUESTRO</option>
              <option value="19">SIN INFORMACI&#211;N</option>
              <option value="20">TORTURA</option>
              <option value="21">VINCULACI&#211;N DE NI&#209;OS NI&#209;AS ADOLESCENTES A ACTIVIDADES</option>
            </select>
            <div class="help-block with-errors"></div>
          </div>
        </div>
      </div>

    <!-- Vive con-->
    <div class="form-group">
      <label class="control-label"> Vive con : </label>
      <select name="vivecon" id="vivecon" name="vivecon"
      class="form_estudiante form-control" required>
      <option value="" selected="selected">Seleccione...</option>
      <option value="padres">ambos padres</option>
      <option value="padre">padre</option>
      <option value="madre">madre</option>
      <option value="abuelos">abuelos</option>
      <option value="hermanos">hermanos</option>
      <option value="tios">tíos</option>
      <option value="otro">otro</option>
    </select>
    <div class="help-block with-errors"></div>
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
  <div  class="form-group">
    <label from="nombre_padre" class="control-label">Nombres</label>
    <input id="nombre_padre" name="nombre_padre"
    class="form_padres form-control padre" maxlength="40"  type="text"
    placeholder="nombres" />
    <div class="help-block with-errors"></div>
  </div>

  <!-- Apellidos -->
  <div class="form-group">
    <label from="apellido_padre" class="control-label">Apellidos</label>
    <input id="apellido_padre" name="apellido_padre"
    class="form_padres form-control padre" maxlength="40"  type="text"
    placeholder="apellidos" required/>
    <div class="help-block with-errors"></div>
  </div>

  <div class="form-row">
    <div class="col-sm12">
      <!-- Correo-->
      <div class="form-group">
        <label from="correo_padre" class="control-label">Correo</label>
        <input id="correo_padre" name="correo_padre"
        class="form_padres form-control"  type="email"
        placeholder="correo electrónico"
        data-error="correo invalido" />
        <div class="help-block with-errors"></div>
      </div>
    </div>
    <div class="col-sm-6">

    </div>
  </div>

  <!-- telefono -->
  <div class="form-group">
    <label from="telefono_padre" class="control-label">Teléfono</label>
    <input id="telefono_padre" name="telefono_padre"
    class="form_padres form-control padre" maxlength="12" type="tel"
    pattern="[0-9]{10}"
    placeholder="número telefónico"  required/>
    <div class="help-block with-errors"></div>
  </div>

  <!-- tipo de indentificacion -->
  <div class="form-group">
    <label from="tipo_identificacion_padre" class="control-label">Tipo de indentificación</label>
    <select id="tipo_identificacion_padre" name="tipo_identificacion_padre"
    class="form_padres form-control padre" >
    <option value="">Seleccione...</option>
    <option value="CC">cédula de ciudadanía.</option>
    <option value="CE">cédula de extranjería.</option>
    <option value="NUIP">NUIP</option>
  </select>
  <div class="help-block with-errors"></div>
</div>

<!-- documento-->
<div  class="form-group">
  <label from="documento_padre" class="control-label">N&uacute;mero del documento</label>
  <input id="documento_padre" name="documento_padre"
  class="form_padres form-control padre" maxlength="12" type="number"
  min="7"
  placeholder="número de documento"  />
  <div class="help-block with-errors"></div>
</div>

<!-- lugar de expedicion-->
<div class="form-group">
  <label from="lugar_exp_padre" class="control-label">Lugar de expedici&oacute;n</label>
  <input id="lugar_exp_padre" name="lugar_exp_padre" type="text"
  class="form_padres form-control padre"
  placeholder="lugar de expedición" >
</input>
<div class="help-block with-errors"></div>
</div>

<!-- Direccion de residencia -->
<div  class="form-group">
  <label from="direccion_padre" class="control-label"> Direcci&oacute;n de residencia:</label>
  <input id="direccion_padre" name="direccion_padre" type="text"
  class="form_padres form-control"
  placeholder="direccion de residencia" >
  <div class="help-block with-errors"></div>
</div>

<!-- Barrio -->
<div id="56" class="form-group">
  <label from="barrio_padre" class="control-label">Barrio: </label>
  <input id="barrio_padre" name="barrio_padre" class="form_padres form-control"
  type="text" placeholder="barrio" maxlength="40" >
  <div class="help-block with-errors"></div>
</div>

</div>
<!--  fin de seccion del padre -->
</div>


<div id="madre"  style="display:none">
  <!-- Formulario de la madre -->
  <div style="margin-top: 50px;">
    <h3>
      <font color="tomato"> Informaci&oacute;n de la madre</font>
    </h3>
  </div>


  <!-- DATOS DE LA MADRE -->
  <div id="datos_madre" class="regilla"
  style="border: solid 3px tomato;padding: 2%;border-radius: 10px; margin-top: 20px;">
  <div  class="form-group">
    <label from="nombre_madre" class="control-label">Nombres</label>
    <input id="nombre_madre" name="nombre_madre"
    class="form_padres form-control madre" maxlength="40"  type="text"
    placeholder="nombres" />
    <div class="help-block with-errors"></div>
  </div>
  <!-- Apellidos -->
  <div id="d62" class="form-group">
    <label from="apellido_madre" class="control-label">Apellidos</label>
    <input id="apellido_madre" name="apellido_madre"
    class="form_padres form-control madre" maxlength="40"  type="text"
    placeholder="apellidos" />
    <div class="help-block with-errors"></div>
  </div>

  <!-- Correo-->
  <div id="d64" class="form-group">
    <label from="correo_madre" class="control-label">Correo</label>
    <input id="correo_madre" name="correo_madre"
    class="form_padres form-control" data-error="correo invalido"  type="email"
    placeholder="correo electrónico" />
    <div class="help-block with-errors"></div>

  </div>

  <!-- telefono -->
  <div class="form-group">
    <label from="telefono_madre" class="control-label">Teléfono</label>
    <input id="telefono_madre" name="telefono_madre"
    class="form_padres form-control madre" maxlength="12" type="tel"
    pattern="[0-9]{10}"
    placeholder="número telefónico"  />
    <div class="help-block with-errors"></div>

  </div>

  <!-- tipo de indentificacion -->
  <div class="form-group">
    <label from="tipo_identificacion_madre" class="control-label">Tipo de indentificación</label>
    <select id="tipo_identificacion_madre" class="form_padres form-control madre"
    name="tipo_identificacion_madre">
    <option value="">Seleccione...</option>
    <option value="CC">Cédula de ciudadania</option>
    <option value="CE">Cédula de extranjer&iacute;a </option>
    <option value="NUIP">NUIP</option>
    <div class="help-block with-errors"></div>
  </select>
</div>

<!-- documento de la madre-->
<div  class="form-group">
  <label from="documento_madre" class="control-label">N&uacute;mero de documento</label>
  <input id="documento_madre" name="documento_madre"
  class="form_padres form-control madre" maxlength="12"
  type="number" min="99999"
  placeholder="número de documento"  />
  <div class="help-block with-errors"></div>
</div>

<!-- lugar de expedicion-->
<div  class="form-group">
  <label from="lugar_exp_madre" class="control-label">Lugar de expedici&oacute;n</label>
  <input id="lugar_exp_madre" name="lugar_exp_madre" type="text"
  class="form_padres form-control madre"
  placeholder="lugar de expedición" ></input>
  <div class="help-block with-errors"></div>
</div>

<!-- Direccion de residencia -->
<div  class="form-group">
  <label form="direccion_madre" class="control-label"> Direccion de residencia:</label>
  <input id="direccion_madre" name="direccion_madre" type="text"
  class="form_padres form-control"
  placeholder="direccion de residencia" >
  <div class="help-block with-errors"></div>
</div>

<!-- Barrio -->
<div class="form-group">
  <label from="barrio_madre" class="control-label">Barrio: </label>
  <input id="barrio_madre" name="barrio_madre" type="text"
  class="form_padres form-control"
  placeholder="barrio" maxlength="40" >
  <div class="help-block with-errors"></div>
</div>

</div>
<!-- fin de la informacion de la madre -->
</div>

<!-- formulario de salida -->
<div class="form-group row">
  <div class="col-10 offset-2">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="1" id="userAgreement">
      <label class="form-check-label" for="userAgreement">
        Acepto <a href="politicadetratamientodedatos.html" target="_blank">las condiciones de uso</a>
      </label>
    </div>

    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="1" id="newsletter">
      <label class="form-check-label" for="newsletter">
        No quiero recibir notificaciones
      </label>
    </div>
  </div>
</div>

<div class="form-group">
  <br>
  <p id="respuesta"></p>
  <br>
  <input type="submit" class="btn btn-primary" value="Inscribir"/>
</div>
</form>
<!-- fin del formulario -->

<!-- fin del formulario -->

<br>


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
</body >

</html>
