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

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <script src="../JS/jquery-3.5.1.min.js"></script>

  <script src="../JS/ajax.js"></script>
  <script src="../JS/bootstrap.min.js"></script>
  <!-- <script src="../JS/propper.min.js"  type="text/javascript"></script>
  <script src="../JS/datatables.min.js" type="text/javascript"></script> -->
  <script src="../JS/bootstrap-table.min.js" type="text/javascript"></script>

  <link href="../CSS/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/template.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/fa-v4-shims.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/default.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/datatables.min.js" rel="stylesheet" type="text/css"/>
  <link href="../CSS/jquery-3.3.1.slim.min.js" rel="stylesheet" type="text/css"/>
  <link href="../CSS/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/all.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="../CSS/style.css" type="text/css">
  <link rel="stylesheet" href="../CSS/estilos.css" type="text/css">


  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>
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
    error: function (er) {
      params.error(er);
    }
  });
}
</script>
<!-- <script src="js/sweetalert.min.js"></script> -->

<!-- este scrip adicciona el cÃ³digo para crear el objeto XMLHTTPRequest de AJAX -->
</head>

<body >

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

    if (!$admin){
      // si no es un administrador
      header('Location:login_matriculas.php');
    }
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
  function valor_incripcion(id){
    // selector de encabezados
    var tabla = $("#tabla-inscritos tbody tr");
    // select
    //a = tabla["nombre_estudiante"].text;
    return "carlos";

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

  <section id="inscricion" class="max-width" style="margin-top:20px">
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
        <th data-field="genero" data-search-highlight-formatter="customSearchFormatter" data-sortable="true">genero</th>
        <th data-field="grado" data-search-highlight-formatter="customSearchFormatter" data-sortable="true" data-title-tooltip="grado al que se inscribió el estuadiante">grado</th>
        <th data-field="fecha" data-search-highlight-formatter="customSearchFormatter" data-sortable="true" data-title-tooltip="fecha de inscripcion">fecha</th>
        <th data-field="vicecon">vice con</th>
        <!-- <th data-field="estado">estado</th> -->
      </tr>
    </thead>
  </table>
</section>

<section id="matriculas" class="max-width">


</section>
<script>
  window.customSearchFormatter = function(value, searchText) {
    return value.toString().replace(new RegExp('(' + searchText + ')', 'gim'), '<span style="background-color: pink;border: 1px solid red;border-radius:90px;padding:4px">$1</span>')
  }
</script>

</body>
</html>
