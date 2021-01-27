<?php session_start();
//validamos si se ha hecho o no el inicio de sesion correctamente
//si no se ha hecho la sesion nos regresarÃ¡ a login.php

include_once 'conexion.php';

if(!isset($_SESSION['usuario']))
{
  //Sila secciÃ³n no esta iniciada entonces retorna a la pagina principal
  header('Location:login_matriculas.php');

  //termina el programa php
  exit();
}
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
  <script type="text/javascript" src="mostrar.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <!-- amCharts javascript sources -->
  <script src="../amcharts/amcharts.js" type="text/javascript"></script>
  <script src="../amcharts/serial.js" type="text/javascript"></script>
  <script src="../JS/a076d05399.js"></script>
  <script src="../JS/carga-datos-formulario-matricula-primaria.js"></script>
  <script src="../JS/jquery-3.5.1.min.js"></script>
  <script src="../JS/typed.min.js"></script>
  <script src="../JS/jquery.waypoints.min.js"></script>
  <script src="../JS/ajax.js"></script>
  <script src="../JS/bootstrap.min.js"></script>
  <script src="../JS/propper.min.js"  type="text/javascript"></script>
  <script src="../JS/datatables.min.js" type="text/javascript"></script>
  <script src="../JS/bootstrap-table.min.js" type="text/javascript"></script>

  <link href="../CSS/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/template.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/fa-v4-shims.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/default.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/datatables.min.js" rel="stylesheet" type="text/css"/>
  <link href="../CSS/jquery-3.3.1.slim.min.js" rel="stylesheet" type="text/css"/>
  <link href="../CSS/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/all.css" rel="stylesheet" type="text/css" />



</script>
<link rel="stylesheet" href="../CSS/style.css" type="text/css">
<link rel="stylesheet" href="../CSS/estilos.css" type="text/css">


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- <script src="js/sweetalert.min.js"></script> -->

<!-- este scrip adicciona el cÃ³digo para crear el objeto XMLHTTPRequest de AJAX -->
</head>

<body onload="ocultar_todo();">

  <!-- se establece la conexiÃ³n con la base de datos -->
  <div id="=usuario" class="encabezado_formulario">
    <?php

    //conexion con la base de datos
    $link = conectar();
    //
    $usuario = $_SESSION['usuario'];
    // se almacena una variable tipo consulta
    $reg=mysqli_query( $link, "select * from docentes where cedula ='".$usuario."'" ) or
    die("Problemas  encontrar el usuario:".mysqli_error());


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

    // muestra el nombre del usuario en pantalla
    echo	"Usuario : ".$nombre." ".$apellido." codigo (".$_SESSION['code'].")<br>";
    ?>

  </div>

  <?php
  // trazo las condiciones iniciales para el formulario
  //  almaceno la fecha actual en la variable $hoy
  $hoy = Date("Y-m-d hh:mm");

  ?>

  <script type="text/javascript">

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
  function matricular(id){

    $("#nombre_estudiante").val(valor_incripcion(id,"nombre_estudiante"));
  }

  // fucion que recupera un valor de la tabla inscripciones
  function valor_incripcion(id, columna){
    // selector de encabezados
    var tabla = $("#tabla-inscritos tbody tr td");
    // select
    //a = tabla["nombre_estudiante"].text;
    return "carlos";

  }

  </script>

  <section id="inscricion" class="max-width">
    <h2>FORMULARIO DE INSCRIPCI&Oacute;N</h2>

    <table
  id="table"
  data-toggle="table"
  data-height="460"
  data-ajax="ajaxRequest"
  data-search="true"
  data-side-pagination="server"
  data-pagination="true">
  <thead>
    <tr>
      <th data-field="id">id</th>
      <th data-field="estudiante">Estudiante</th>
      <th data-field="edad">edad</th>
      <th data-field="genero">genero</th>
      <th data-field="grado">grado</th>
      <th data-field="fecha">fecha</th>
      <th data-field="vicecon">vice con</th>
    </tr>
  </thead>
</table>

<script>
// your custom ajax request here
function ajaxRequest(params) {

  // data you may need
  console.log(params.data);

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
      error: function (er) {
          params.error(er);
      }
  });
}
</script>

  </section>
  <section id="matriculas" class="max-width">
    <h2>MATRICULA</h2>
    <div id="datos_estudiantes" class="form-group">
      <!-- nombres -->
      <div class="form-group">
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

      <!-- nivel de escolaridad , preescolar, primaria  .. -->
      <div class="form-group">
        <label from="escolaridad">Escolaridad</label>
        <?php
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



    </div>
  </section>


</body>
</html>
