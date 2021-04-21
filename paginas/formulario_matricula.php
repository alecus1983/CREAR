<?php session_start();
//validamos si se ha hecho o no el inicio de sesion correctamente
//si no se ha hecho la sesion nos regresarÃ¡ a login.php
if(!isset($_SESSION['usuario']))
{
  //Sila secciÃ³n no esta iniciada entonces retorna a la pagina principal
  header('Location:login_matriculas.php');
  //termina el programa php
  exit();
}

include_once 'conexion.php';


?>

<!-- se define el tipo de documento ht como HTML 5 -->
<!-- esta pagina consulta la base de datos con los diferentes elementos que la componen -->

<!DOCTYPE html>
<!-- se establece la cabecera del documento -->

<html>
<!-- se definen las etiquetas del encabezado -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Matriculas
  </title>
  <!-- en este codigo se definen los archivos de javascrip que se adjuntaran -->

  <script type="text/javascript" src="lib/jquery.js"></script>
  <script type="text/javascript" src="ajax.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="../JS/jquery-3.5.1.min.js"></script>
  <script src="../JS/sweetalert.min.js"></script>
  <script src="../JS/ajax.js"></script>
  <script src="../JS/bootstrap.min.js"></script>
  <script src="../JS/datatables.min.js"></script>

  <script src="../JS/bootstrap-table.min.js" type="text/javascript"></script>
  <link href="../CSS/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/template.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/fa-v4-shims.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/default.css" rel="stylesheet" type="text/css" />


  <link href="../CSS/jquery-3.3.1.slim.min.js" rel="stylesheet" type="text/css"/>
  <link href="../CSS/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/all.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="../CSS/style.css" type="text/css">
  <link rel="stylesheet" href="../CSS/estilos.css" type="text/css">


  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


  <script>

  // habilita el codigo dependiento la antiguedad del estudiante
  function habilitar_codigo(){

    var antiguedad = $("#antiguedad").val();
    // si el estudiante es nuevo
    if (antiguedad == 0){
      // se deshabilita el ingreso del codigo
      $("#codigo").prop('disabled', true);
    }else {
      // si es antiguo se habilita el codigo
      $("#codigo").prop('disabled', false);
    }

  }


  // Esta funcion carga los datos de la tabla
  // que son generados en json por el archivo
  // obtener_inscripciones.php

  function ajaxRequest(params) {

    // data you may need
    console.log(params.data);
    // llamada mediante ajax
    $.ajax({
      type: "POST",
      url: "obtener_inscripciones.php",

      // You are expected to receive the generated JSON (json_encode($data))
      dataType: "json",
      success: function (data) {
        params.success({
          // By default, Bootstrap table wants a "rows" property with the data
          "rows": data,
          // You must provide the total item ; here let's say it is for array length
          "total": data.length
        })
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });
  }
</script>
<!-- <script src="js/sweetalert.min.js"></script> -->

<!-- este scrip adicciona el cÃ³digo para crear el objeto XMLHTTPRequest de AJAX -->
</head>

<body class="max-width" >

  <!-- se establece la conexiÃ³n con la base de datos -->
  <div id="=usuario" class="encabezado_formulario">
    <?php

    //conexion con la base de datos
    $link = conectar();
    //
    $usuario = $_SESSION['usuario'];
    // se almacena una variable tipo consulta
    $reg=mysqli_query( $link, "select * from docentes where cedula ='".$usuario."'" );
    // or
    // die("Problemas  encontrar el usuario:".mysqli_error());


    //Validamos si el nombre del administrador existe en la base de datos o es correcto
    $row = mysqli_fetch_array($reg);
    // se almacena el cÃ³digo del docente en la variable $id_docente
    $id_docente = $row['id_docente'];
    // se almacena el nombre del usuario
    $nombre = $row['nombres'];
    // se almacena el apellido del usuario
    $apellido = $row['apellidos'];
    // se almacna en esta variable booleana que me indica si es administrador o no
    $admin = $row['admin'];
    // almacena el estado  de la variable $admin en la variable de secciÃ³n
    $_SESSION['admin'] = $admin;
    // almacena el cÃ³digo del docente  en la variable de secciÃ³n
    $_SESSION['code'] = $id_docente;

    //muestra el nombre del usuario en pantalla
    if (!$admin){
      // si no es un administrador
      header('Location:login_matriculas.php');
    }
    echo	"Cliente : ".$nombre." ".$apellido." codigo (".$_SESSION['code'].")<br>";
    ?>

  </div>

  <?php
  // trazo las condiciones iniciales para el formulario
  //  almaceno la fecha actual en la variable $hoy
  $hoy = Date("Y-m-d hh:mm");

  ?>

  <script type="text/javascript">

  function valor(valor){

    $("#inscripcion").val(valor);
    // alert(valor);

    $.ajax({
      type: "POST",
      url: "mostrar_inscritos.php",
      data: {"codigo" : valor},
      dataType: "json",
      success: function (data) {
        // alert(data.nombre_estudiante);
        // asignacion de variables que retornan del servidor
        $("#nombre_estudiante").val(data.nombre_estudiante);
        $("#apellido_estudiante").val(data.apellido_estudiante);
        $("#tipo_identificacion").val(data.tipo_identificacion).change();
        $("#documento_estudiante").val(data.documento_estudiante);
        $("#lugar_exp_estudiante").val(data.lugar_exp_estudiante);
        $("#nacimiento").val(data.nacimiento);
        $("#ciudad_nacimiento").val(data.ciudad_nacimiento);
        $("#correo_estudiante").val(data.correo_estudiante);
        $("#genero").val(data.genero).change();
        $("#celular").val(data.celular);
        $("#telefono").val(data.telefono);


        $("#escolaridad").val(data.id_escolaridad).change();
        $("#grados_escolaridad").val(data.id_grado).change();
        $("#jornada").val(data.id_jornada).change();
        $("#modo").val(data.modalidad).change();
        $("#tipo_institucion").val(data.tipo_institucion).change();
        $("#institucion").val(data.institucion);
        $("#motivo").val(data.motivo);

        // Antecedentes patologicos
        $("#EPS").val(data.EPS);
        $("#gruporh").val(data.gruporh);
        $("#direccion_estudiante").val(data.documento_estudiante);
        $("#barrio").val(data.barrio);

        // Datos socieconomicos
        $("#nivelsisben").val(data.nivelsisben);
        $("#estrato").val(data.estrato);
        $("#etnia").val(data.etnia).change();
        $("#victima").val(data.victima_conflicto).change();
        $("#vivecon").val(data.vivecon).change();

        // datos del padre
        $("#nombre_padre").val(data.nombre_padre);
        $("#apellido_padre").val(data.apellido_padre);
        $("#correo_padre").val(data.correo_padre);
        $("#telefono_padre").val(data.telefono_padre);
        $("#tipo_identificacion_padre").val(data.tipo_identificacion_padre).change();
        $("#documento_padre").val(data.documento_padre);
        $("#lugar_exp_padre").val(data.lugar_exp_padre);
        $("#direccion_padre").val(data.direccion_padre);
        $("#barrio_padre").val(data.barrio_padre);

        // datos de la madre
        $("#nombre_madre").val(data.nombre_madre);
        $("#apellido_madre").val(data.apellido_madre);
        $("#correo_madre").val(data.correo_madre);
        $("#telefono_madre").val(data.telefono_madre);
        $("#tipo_identificacion_madre").val(data.tipo_identificacion_madre).change();
        $("#documento_madre").val(data.documento_madre);
        $("#lugar_exp_madre").val(data.lugar_exp_madre);
        $("#direccion_madre").val(data.direccion_madre);
        $("#barrio_madre").val(data.barrio_madre);
        // habilita  el campo codigo
        habilitar_codigo();

      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });
    // busca un estudiante
    //buscar_ajax();
    $("#lista").html("");

  }

  // busca estudiantes por nombre
  function buscar_ajax(){
    // nombre del estudiante
    var nombre = $("#nombre_estudiante").val();
    // apellido estudiante
    var apellido = $("#apellido_estudiante").val();
    // antiguedad 0 nuevo, 1 antiguo
    var antiguedad = $("#antiguedad").val();

    // busqueda en ajax
    $.ajax({
      type: 'POST',
      url: 'buscar_estudiante.php',
      data: {"nombre": nombre, "apellido": apellido, "antiguedad": antiguedad},
      success: function(respuesta) {
        //Copiamos el resultado en #mostrar
        $('#lista').html(respuesta);
      }
    }).done(function(respuesta){
      console.log(respuesta);
    });
  }

  ///////////////////////////////////////////////////////////////
  // esta funcion tiene como objetivo realizar                 //
  // la carga de los combos dinamicos y recibe tres atributos  //
  // los cuales son :                                          //
  //                                                           //
  // a - nombre del combo                                      //
  // b - nombre del archivo php que carga el combo             //
  // c - conjunto de parametros en formato JSON                //
  ///////////////////////////////////////////////////////////////

  function carga ( a ,b,c ) {

    console.log("Valor a: %s",a); 	// variable que almacena el codigo del campo
    console.log("Valor b: %s",b);	// variable que almacena el nombre del archivo PHP
    console.log(JSON.stringify(c));	// parametro que se transmite  mediante ajax
    $.post("campos/"+b, c,
    function (dato) {
      $(a).empty();
      $(a).append("<option value = -1> Seleccione </option>");
      $.each(dato, function(index, materia) {
        $(a).append("<option value ="+ index+">" + materia + "</option>");
      });
    }, 'json');
  }

  // funcion que carga los datos de la tabla de inscripciones
  // a la tabla de matriculas
  function matricular(){

    // nombre del estudiante
    var nombre = $("#nombre_estudiante").val();
    // nombre del estudiante
    var apellido = $("#apellido_estudiante").val();
    // antiguedad
    var antiguedad = $("#antiguedad").val();
    // codigo
    var codigo = $("#codigo").val();
    // identificador del grado
    var id_grado = $("#grados_escolaridad").val();
    // identificador de la jornada
    var id_jornada = $("#jornada").val();

    // validaciones
    if (nombre.length < 2){
      swal("Error", "Favor introduzca un nombre","error");
    }
    else if (apellido.length <2) {
      swal("Error", "Favor introduzca un apellido","error");
    }
    else if (id_grado == ""){
      swal("Error", "Favor introduzca un grado","error");
    }
    else if (id_jornada == ""){
      swal("Error", "Favor introduzca una jornada","error");
    }
    // en caso de que sea positivo hay dos procedimientos, uno para datos_estudiantes
    // nuevos y otro para estudiantes antiguos
    // Nuevo 0
    // Antiguo 1
    else if (antiguedad == 1) {
      if( codigo.length < 1 ){
        swal("Error", "Favor introduzca un código","error");
      } else {
        // Cuando el estudiante es antiguo
        // objeto ajax
        $.ajax({
          type: 'POST',
          url: 'matricular_colegio.php',
          data: {
            "codigo" : codigo,
            "inscripcion": $("#inscripcion").val(),
            "antiguedad": antiguedad
          }
        }).done(function(respuesta){
          swal("Resultado","Matriculando estudiante antiguo","success");
        });
      }
    }
    else  {
      $.ajax({
        type: 'POST',
        url: 'matricular_colegio.php',
        data: {
          "codigo" : codigo,
          "inscripcion": $("#inscripcion").val(),
          "antiguedad": antiguedad
        }
      }).done(function(respuesta){
        swal("Resultado","Matriculando estudiante nuevo","success");
      });

    }
  }



  // filtro en nuevo
  function filtro_nuevo(){
    var table = $('#tabla-inscritos');
    table.bootstrapTable('filterBy', {
      estado: "i"});
    }

    // filtro para la matricula
    function filtro_matriculados(){
      var table = $('#tabla-inscritos');
      table.bootstrapTable('filterBy', {
        estado: "m"});
      }

      </script>

      <section id="inscricion"
      class="max-width"
      style="margin-top:20px;
      ">


      <h2>FORMULARIO DE INSCRIPCI&Oacute;N</h2>
      <p>En este formulaio encontraras un listado con las inscripciones ingresadas
        en el formulario,  las cuales se identifican con el codigo de inscrici&oacute;n
        . Para comletar la matricuala pulse click sobre en codigo de la inscripci&oacute;n
        y complete el formulario de matr&iacute;cula que aparece. </p>

        <div id="toolbar">
          <button id="button" class="btn btn-warning" onclick="filtro_nuevo();">Nuevos</button>
          <button id="button"  class="btn btn-success" onclick="filtro_matriculados();">Matriculados</button>
        </div>

        <table
        id="tabla-inscritos"
        data-toggle="table"
        data-height="460"
        data-pagination="true"
        data-ajax="ajaxRequest"
        data-search="true"
        data-search-highlight="true"

        >
        <thead class="thead-light">
          <tr>
            <th data-field="id"  data-switchable="true">id</th>
            <!-- <th data-field="estado">estado</th> -->
            <th data-field="estudiante" data-search-highlight-formatter="customSearchFormatter" data-sortable="true" data-sort-name="estudiante" data-sort-order="desc" data-title-tooltip="Nombre comleto del estudiante">Estudiante</th>
            <th data-field="edad" data-search-highlight-formatter="customSearchFormatter" data-sortable="true">edad</th>
            <th data-field="documento" data-search-highlight-formatter="customSearchFormatter" data-sortable="true">documento</th>
            <th data-field="genero" data-search-highlight-formatter="customSearchFormatter" data-sortable="true">genero</th>
            <th data-field="grado" data-search-highlight-formatter="customSearchFormatter" data-sortable="true" data-title-tooltip="grado al que se inscribió el estuadiante">grado</th>
            <th data-field="fecha" data-search-highlight-formatter="customSearchFormatter" data-sortable="true" data-title-tooltip="fecha de inscripcion">fecha</th>
            <th data-field="vivecon">vive con</th>
            <!-- <th data-field="estado">estado</th> -->
          </tr>
        </thead>
      </table>
    </section>


    <section id="relacionados" style="margin: 0px;padding: 0px;">

      <div id="lista_relacionados"
      class="max-width shadow-sm p-3 mb-5 bg-white rounded"
      style="background-color: #fff;
      margin: 50px;
      border-radius: 10px;
      padding-bottom: 10px;
      border: 2px solid gold;">
      <div id="lista" style="padding-top:10px; padding-bottom: 30px;"></div>
      <div style="display:grid">
        <button style="margin-left: auto; width: 100px;" type="button"
      class="btn btn-outline-dark" onclick="buscar_ajax();" >Buscar</button>
    </div>
    </div>
    </section>

    <section id="matriculas"
    class="max-width shadow-sm p-3 mb-5 bg-white rounded"
    style="background-color: #fff;
    margin: 50px;
    border-radius: 10px;
    padding-bottom: 40px;
    border: 2px solid #007bff;">
    <input type="hidden" id="inscripcion" value=""></input>
    <br><br>

    <h2 style="color: aqua;font-weight: bold;">Formulario de Matricula</h2>
    <hr>

    <!-- -->
    <div id="datos_estudiantes" >
      <div class="form-row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="codigo">C&oacute;digo del estudiante</label>
            <input type="number"  class="form-control" id="codigo" placeholder="codigo">
            <div class="help-block with-errors"></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="antiguedad">Antiguedad</label>
            <select class='form_estudiante form-control' id="antiguedad"
            name='antiguedad' onchange="habilitar_codigo();" required >
            <option value="0">Nuevo</option>
            <option value="1">Antiguo</option>
          </select>
        </div>
      </div>
    </div>


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
          <label from="ciudad_nacimiento" class="control-label">Ciudad de nacimiento</label>
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
      placeholder="número telefónico"  required/>
      <div class="help-block with-errors"></div>
    </div>
  </div>
</div>

<span class="font-weight-bold ">
  <h4 style="font-weight: bold;">Nivel educativo
  </h4>
</span>
<hr>

<div class="form-row">
  <div class="col-md-6 mb-3">
    <!-- nivel de escolaridad , preescolar, primaria  .. -->

    <!-- grado del estudiane,  depende de lo que se halla seleccionado
    como nivel de escolaridad-->
    <div class="form-group">
      <label from="grado" class="control-label">Grado</label>
      <select class='form_estudiante form-control' id='grados_escolaridad'
      name='grados_escolaridad' required >;
      <option value=''>Seleccione...</option>
      <option value='10' >primero</option>
      <option value='11' >Segindo</option>
      <option value='12' >Tercero</option>
      <option value='13' >Cuarto</option>
      <option value='14' >Quinto</option>
      <div class="help-block with-errors"></div>
    </select>
    <div class="help-block with-errors"></div>
  </div>
</div>



<div class="col-md-6 mb-3">
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
</div>


<div class="form-row">
  <div class="col-sm-12 col-md-6">
    <div class="form-group">
      <label for="modo">Modo</label>
      <div class="form-group">
        <select class='form_estudiante form-control' id='modo'
        name='name' required >
        <option value="0">Virtual</option>
        <option value="1">Presencial</option>
      </select>
    </div>
  </div>
</div>

<!-- Modalidad -->
<div class="col-md-6">

</div>
</div>

<div class="form-row">


  <div class="col-md-6">
    <div class="form-group">
      <label for="tipo_institucion">Instituci&oacute;n de la que proviene</label>
      <select class='form_estudiante form-control' id='tipo_institucion'
      name='tipo_institucion' required >
      <option value=1>Publica</option>
      <option value=0>Privada</option>
    </select>
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
  <h4 style="font-weight: bold;">Antecedentes Patol&oacute;gicos
  </h4>
</span>
<hr >

<div class="form-row">
  <div class="col-md-6 col-sm-12">
    <!-- EPS-->
    <div class="form-group">
      <label from="EPS" class="control-label">EPS</label>
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
      <label from="barrio" class="control-label">Barrio:</label>
      <input id="barrio" name="barrio" class="form_estudiante form-control"
      name="barrio" type="text" placeholder="barrio" maxlength="40"
      required>
      <div class="help-block with-errors"></div>
    </div>
  </div>
</div>

<span class="font-weight-bold">
  <h4 style="font-weight: bold;">Datos socio econ&oacute;micos
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

      <select class="form-control form-estudiane" id="etnia" name="etnia">
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
        <select class="form_estudiante form-control" name="victima" id="victima" >
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

<div id="padre">
  <div style="margin-top: 50px;">
    <h4>
      Informaci&oacute;n del padre
    </h4>
  </div>

  <div id="datos_padre">
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


    <!-- Correo-->
    <div class="form-group">
      <label from="correo_padre" class="control-label">Correo</label>
      <input id="correo_padre" name="correo_padre"
      class="form_padres form-control"  type="email"
      placeholder="correo electrónico"
      data-error="correo invalido" />
      <div class="help-block with-errors"></div>
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
<div class="form-group">
  <label from="barrio_padre" class="control-label">Barrio: </label>
  <input id="barrio_padre" name="barrio_padre" class="form_padres form-control"
  type="text" placeholder="barrio" maxlength="40" >
  <div class="help-block with-errors"></div>
</div>

</div>
<!--  fin de seccion del padre -->
</div>


<div id="madre">
  <!-- Formulario de la madre -->
  <div style="margin-top: 50px;">
    <h4>
      Informaci&oacute;n de la madre
    </h4>
  </div>


  <!-- DATOS DE LA MADRE -->
  <div id="datos_madre">
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
<div id="botones" style="display:flex">
<button type="button" style="margin: auto;width: 140px;" class="btn btn-dark" onclick="matricular();">matricular</button>
<!-- <button type="button" style="margin: auto;width: 140px;" class="btn btn-light" onclick="desmatricular();">desmatricular</button> -->
</div>
<!-- -->

</section>
<script>
window.customSearchFormatter = function(value, searchText) {
  return value.toString().replace(new RegExp('(' + searchText + ')', 'gim'), '<span style="background-color: pink;border: 1px solid red;border-radius:90px;padding:4px">$1</span>')
}
</script>

</body>
</html>
