<?php session_start();
//validamos si se ha hecho o no el inicio de sesion correctamente
//si no se ha hecho la sesion nos regresarÃ¡ a login.php

include_once 'conexion.php';

if(!isset($_SESSION['usuario']))
{
  //Sila secciÃ³n no esta iniciada entonces retorna a la pagina principal
  header('Location:login_boletines.php');

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
  <title>Formulario
  </title>
  <!-- en este codigo se definen los archivos de javascrip que se adjuntaran -->

  	<script type="text/javascript" src="lib/jquery.js"></script>
  	<script type="text/javascript" src="ajax.js"></script>
  	<script type="text/javascript" src="mostrar.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  	<!-- amCharts javascript sources -->
  	<script src="../amcharts/amcharts.js" type="text/javascript"></script>
  	<script src="../amcharts/serial.js" type="text/javascript"></script>
  	<script>
  	AmCharts.loadJSON = function(url) {
    // create the request
    if (window.XMLHttpRequest) {
      // IE7+, Firefox, Chrome, Opera, Safari
      var request = new XMLHttpRequest();
    }
    else
    {
      // code for IE6, IE5
      var request = new ActiveXObject('Microsoft.XMLHTTP');
    }

    // load it
    // the last "false" parameter ensures that our code will wait before the
    // data is loaded
    request.open('GET', url, false);
    request.send();

    // parse adn return the output
    return eval(request.responseText);
  } ;
  </script>




  <script>

  //////////////////////////////////////////////////////////////////////////////////////////
  // Este script contiene la funcion para generar las graficas                            //
  // Esta foncion no recive parametros                                                    //
  //////////////////////////////////////////////////////////////////////////////////////////


  function grafica(){
    // se crean como primera instacia la variable que contiene el objeto grafico
    var chart;
    // Luego se cargan los  parametros de entrada que son el contenido de los campos
    // years que contiene el aÃ±o

    var year = $("#years").val().toString();
    // y periodo que contiene el periodo
    var periodo = $("#periodos").val();
    //cargo el estado del menu actual
    var menu = $("#opcion").val();
    // Se declara la variable chartData la cual recibe el dato tipo JSON proveniente de
    // el archivo data.php ( el cual requiere los parametros  aÃ±o y periodo)
    var chartData = AmCharts.loadJSON('data.php?year='+year+'&periodo='+periodo+'&menu='+menu);

    // muestro por consola el JSON que entrega chartData
    console.debug(chartData);

    // SERIAL CHART
    chart = new AmCharts.AmSerialChart(); // se crea un grafico tipo serial
    chart.dataProvider = chartData;       // se declara la fuente de datos
    chart.categoryField = "category"; // Se declara el campo dentro del JSON el cual idesntifica el eje
    // De las categorias ( eje de las x)
    chart.startDuration = 1;          // inicio de las categorias
    chart.labelRotation = 90;         // Indica la rotacion de los nombres en el eje de categorias
    //chart.rotate = true;

    // AXES
    // category
    var categoryAxis = chart.categoryAxis; // se crea un objeto eje de categorias

    categoryAxis.gridPosition = "start"; // posicion de inicio de la grilla
    categoryAxis.axisColor = "#DADADA";  // color de la grilla
    categoryAxis.labelRotation = 90; // Rotacion de las etiquetas de eje
    //categoryAxis.dashLength = 3;

    // value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.stackType = "regular";
    //valueAxis.dashLength = 3;
    valueAxis.axisAlpha = 0.2;
    //valueAxis.position = "top";
    valueAxis.title = "registros";
    valueAxis.minorGridEnabled = true;
    valueAxis.minorGridAlpha = 0.08;
    valueAxis.gridAlpha = 0.15;
    chart.addValueAxis(valueAxis);

    // GRAPHS
    // Se insertan los principales parametros del grafico tipo columna
    var graph = new AmCharts.AmGraph();
    graph.type = "column"; // tipo de grafico
    graph.title = "Calificados"; // titulo del grafico
    graph.valueField = "nota"; // etiqueta dentro del JSON
    graph.lineAlpha = 0; // ocultar (0) o mostrar linea
    graph.fillColors = "#ADD981"; // color del grafico
    graph.fillAlphas = 0.8; // ocultar (0) o mostrar (1) rrelleno
    graph.balloonText = "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>";
    chart.addGraph(graph); // se agrega el grafico

    // se agrega el segundo grafico.
    graph = new AmCharts.AmGraph();
    graph.type = "column";
    graph.title = "Sin calificar";
    graph.valueField = "cero";
    graph.lineAlpha = 0;
    graph.fillColors = "#00D981";
    graph.fillAlphas = 0.8;
    graph.balloonText = "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>";
    chart.addGraph(graph);


    // LEGEND
    var legend = new AmCharts.AmLegend();
    legend.useGraphSettings = true;
    chart.addLegend(legend);

    chart.creditsPosition = "top-right";

    // WRITE
    chart.write("grafo");
  }


  </script>
  <!-- se definen los estilos para el contenido del formulario -->


  <style type="text/css">

  @import url("../estilos.css");
  </style>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <!-- <script src="js/sweetalert.min.js"></script> -->

  <!-- este scrip adicciona el cÃ³digo para crear el objeto XMLHTTPRequest de AJAX -->
</head>

<!-- a partir de aqui se establece el cuerpo del documento que se va ha mostrar en la pÃ¡gina -->
<body onload="ocultar_todo();">

  <!-- -->
  <!-- amCharts javascript code -->


  <!-- en caso que no se admitan scrips dentro de la pÃ¡gina -->
  <noscript>
    <!-- se muestra la etiqueta de parrafo con el siguiente contenido -->
    <p>Bienvenido a Mi Sitio
    </p>
  </noscript>

  <!-- se establece la conexiÃ³n con la base de datos -->
  <div id="=usuario" class="encabezado_formulario">
    <?php

    //print_r($_SESSION);
    //conexion con la base de datos
    $link = conectar();
    //var_dump($_SESSION);
    $usuario = $_SESSION['usuario'];
    // se almacena una variable tipo consulta
    $reg=mysqli_query( $link, "select * from docentes where cedula ='".$usuario."'" ) or
    die("Problemas  encontrar el usuario:".mysql_error());


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
  // realizo la consulta del preriodo actual cargado
  $reg=mysqli_query($link, "select * from limite" ) or
  die("Problemas  encontrar el usuario:".mysql_error());
  // convierto la consulta en un arreglo
  $row = mysqli_fetch_array($reg);
  // almacena el periodo acual
  $periodo_act = $row['periodo'];
  // almacena el corte actual
  $corte_act = $row['corte'];
  // fecha limite de entrega
  $entrega = $row['fecha'];
  // muestro el periodo actual
  //echo "Periodo : ".$periodo_act." corte : ".$corte_act;

  ?>

  <script>

  // actualizo la fecha actual  y sus parametros asociados
  $.ajax({
    url: 'plazo.php',
    type:  'post',
    async: 'false',
    dataType: "json",
    error: function( jqXHR, textStatus, errorThrown ) {
      if (jqXHR.status === 0) {

        swal('No se encuentra conectado: verifique su conexion a la red.');

      } else if (jqXHR.status == 404) {

        swal('Pagina no encontrada [404]');

      } else if (jqXHR.status == 500) {

        swal('Error interno del servidor [500].');

      } else if (textStatus === 'parsererror') {

        swal('JSON requerido ha fallado.');

      } else if (textStatus === 'timeout') {

        swal('Esta operacion tardo demasiado tiempo.');

      } else if (textStatus === 'abort') {

        swal('Requesición abordada.');

      } else {

        swal('Error desconocido: ' + jqXHR.responseText);

      }
      // Otro manejador error
    },
    beforeSend: function () {
      $("#resultado").html("Actualizando fecha, espere por favor...");
    },
    success:  function (response) {
      //swal("Se actualizo con exito la fecha");
      var cadena = response;

      $("#fecha_entrega").html(
        "Periodo : "+cadena.periodo+
        "  Corte : "+cadena.corte+
        "  "+cadena.texto
      );
    }
  });

  actualizar_docente(<?php echo $_SESSION['code'];?>);

  </script>

  <!-- Div que se encarga de mostrar la fecha de enrtrega de notas -->
  <div id="fecha_entrega" class="encabezado_formulario">

  </div>

  <!-- Div donde se ubica el boton de cierre de seccion -->
  <div id="cerrar">
    <?php
    // muestra  un enlace que permite cerrar la secciÃ³n
    echo "<br><a href='logout.php'>Cerrar Secci&oacute;n</a>";

    //echo "<br> Desde".$hoy." Hasta: ".$entrega;
    desconectar($link);
    ?>
  </div>


  <script type="text/javascript">


  ///////////////////////////////////////////////////////////////////////////////////////////
  //                                                                                       //
  // DICCIONARIO DE FUNCIONES                                                              //
  //                                                                                       //
  // El siguiente es el diccionario de las funciones empleadas para el desarrollo de       //
  // la aplicacion, estas son las siguientes:                                              //
  //                                                                                       //
  // formulario_calificar : Desplega el formulario de calificaciones, para el ingreso      //
  //                        de notas, para ejecutarse emplea como parametros de entrada    //
  //                        add, año, jornada, periodo, corte, grado, materia, e indexa el //
  //                        archivo calificar.php de mediante ajax para la creacion del    //
  //                        formulario.                                                    //
  //                                                                                       //
  // edit_display : Muestra los campos correspondientes a la ediccion  de atributos        //
  //                de los estudiantes, docentes, entre otros                              //
  //                                                                                       //
  // ocultar_todo : Se encarga de ocultar los diferentes elementos que constituyen el      //
  //                formulario principal.                                                  //
  //                                                                                       //
  // ocultar_add : Se encarga de ocultar los diferentes elementos que constituyen el       //
  //               formulario de adiccionar las notas, estudiantes, docentes ...           //
  //                                                                                       //
  // ocultar_consultar : Se encarga de ocultar los diferentes elementos que constituyen    //
  //                     la seccion de consultar                                           //
  //
  // ocultar_display :
  //
  // igual_notas : Funcion que copia  el contenido del campo maestro en el resto de los
  //               campos hijos, a todos dos que tienen el atributo name
  //
  // add_display:
  //
  //
  ///////////////////////////////////////////////////////////////////////////////////////////


  ///////////////////////////////////////////////////////////////////////////////////////////
  // este metodo tiene como funcion validar y generar el formato de  calificaciones       //
  // este es el que permite a los docentes ingresar las notas de los alumnos, visualizar  //
  // los listados de alumnos, entre otros.                                                //
  //////////////////////////////////////////////////////////////////////////////////////////

  function	formulario_calificar(){
    // primeramente se validan los campos de texto y se muestran en el resultado
    var add = $("#add").val(); //  selector de para las funciones de adiccionar en el formulario
    var ano = $("#years").val(); // variable año en el formulario
    var jornada = $("select#jornada").val() ; // variable jormana en el formulario
    var periodo = $("select#periodos").val(); // variable periodo en el formulario
    var corte =  $("select#corte").val();// variable corte en el formulario
    var grado =  $("select#id_g").val();// variable grado en el formulario
    var materia = $("select#id_ms").val(); //

    // Defino las condiciones iniciales del formulario, las cuales son:
    // borro el contenido de el div resultado
    $("#resultado").html("");
    // comienzo a validar las variables
    if (periodo == -1) {
      $("#resultado").append("<p style='color:red;'>Favor seleccione una periodo <p>");
    }
    else if (grado == -1) {
      $("#resultado").append("<p style='color:red;'>Favor seleccione un grado <p>");
    }
    else if (materia == -1) {
      $("#resultado").append("<p style='color:red;'>Favor seleccione una materia <p>");
    }
    else{
      // muestro  un mensaje de espera
      $("#resultado").html("<p style='color:black;'>Cargando ... <p>");
      // cargo el el div calificar  el formulario de notas
      // para que el docente las califique, se envia por POST los parametros
      // que aparecen en la parte superior del formulario
      $("#calificador").load("calificar.php", {
        "id_ms": $("#id_ms").val(),
        "id_gs": $("#id_g").val(),
        "corte": $("#corte").val(),
        "periodo": $("#periodos").val(),
        "id_jornada": $("#jornada").val(),
        "years": $("#years").val()
      });
      // borro el contenido mostrado en el resultado
      $("#resultado").html("");
    }
  } // fin de funcion calificar


  //////////////////////////////////////////////////////////////////////////
  //                                                                      //
  // Esta funcion tiene la tarea de establecer la vista                   //
  // inicial del formulario dinamico                                      //
  // y es disparada al iniciar  la carga de la pagina                     //
  // por la el metodo onload del objeto body                              //
  //                                                                      //
  //////////////////////////////////////////////////////////////////////////

  function ocultar_todo()
  {

    // coloca el selector #add_de opcion en chequeado
    $("#add_radio").attr('checked', 'checked');
    // oculto el elemento selector edi el cual selecciona
    // las opciones para editar
    $('#edi').css("display", "none");
    // muestro el elemento selector add la cual selecciona las
    // opciones para adiccionar
    $('#add').css("display", "block");

    // oculta los elementos del menu add
    ocultar_add();

    // menu para ocultar los elementos del menu add
    ocultar_consultar();
    // oculta la seccion actualizar
    $("#actualizar").css("display", "none");
    // coloca la lista de grados actuales en el campo #id_g
    carga("#id_g","grados.php",{ id :  $("#id_docentes").val()});
    // coloca la lista de materias en el campo  #id_ms_con
    carga("#id_ms_con","materias.php",{ id : $("#id_docentes").val() });
    // coloca la lista de materias  en el campo #id_ms
    carga("#id_ms","materias.php",{ id : $("#id_docentes").val()});
    // coloca la lista de docentes en el campo docentes
    carga("#docentes","lista_docentes.php");

    // cargo en el div de la fecha de entrega
    // el plazo que resta para la entrega de boletines
    //$("#fecha_entrega").load("plazo.php");
    //$("#fecha_entrega").html("<br>Fecha de entrega");
    ocultar_add()
  }

  /////////////////////////////////////////////////////////////////////
  //                                                                 //
  // Esta funcion se encaraga de configurar el formulario            //
  // de acuerdo a los parametros necesarios para el                  //
  // funcionamietno del  menu adiccionar                             //
  //                                                                 //
  /////////////////////////////////////////////////////////////////////

  function ocultar_add(){

    // coloco el combo de seleccion  en la posicion -1
    $('select#opcion').val('-1');
    // coloco el combo de aderir en la posicion -1
    $('select#add').val('-1');
    // coloco el combo editar en la posicion -1
    $('select#edi').val('-1');

    // configuro los elementos a mostrar de acuerdo a su
    // id utilizando los metodos de javascript
    document.getElementById("estudiante").style.display='none';
    document.getElementById("fecha_fin").style.display='none';
    document.getElementById("docente").style.display='none';
    document.getElementById("ingresar").style.display='none';
    document.getElementById("nombre").style.display='none';
    document.getElementById("apellido").style.display='none';
    document.getElementById("telefono").style.display='none';
    document.getElementById("fecha").style.display='none';
    document.getElementById("cedula").style.display='none';
    document.getElementById("area").style.display='none';
    document.getElementById("correo").style.display='none';
    document.getElementById("Logro").style.display='none';
    document.getElementById("id_m").style.display='none';
    document.getElementById("id_a").style.display='none';
    document.getElementById("generar").style.display='none';
    document.getElementById("generarx").style.display='none';
    // utilizando los metodos de jquery
    $("#id_e").css("display", "none");
    $("#id_d").css("display", "none");
    $("#logro_1").css("display", "none");
    $("#logro_2").css("display", "none");
    $("#logro_3").css("display", "none");
    $("#id_l").css("display", "none");
    $("#graficar").css("display", "none");
    actualizar_docente(<?php echo $_SESSION['code'];?>);
  }

  ////////////////////////////////////////////////////////////////////////////
  //                                                                        //
  // Esta funcion se encarga de ocultar los elementos del menu consultar    //
  //                                                                        //
  ////////////////////////////////////////////////////////////////////////////

  function ocultar_consultar()
  {

    document.getElementById("estudiante_con").style.display='none';
    document.getElementById("nombre_con").style.display='none';
    document.getElementById("apellido_con").style.display='none';
    document.getElementById("Logro_con").style.display='none';
    document.getElementById("id_m_con").style.display='none';
    document.getElementById("id_a_con").style.display='none';
    document.getElementById("generar").style.display='none';
    document.getElementById("generarx").style.display='none';
    $("#graficar").css("display", "none");
    $("#cargar").css("display", "none");


  }

  //////////////////////////////////////////////////////////////
  //                                                          //
  //
  //                                                          //
  //////////////////////////////////////////////////////////////

  function ocultar_display()
  {

    //$('select#opcion').val('-1');
    $('select#add').val('-1');
    $('select#edi').val('-1');
    document.getElementById("estudiante").style.display='none';
    document.getElementById("fecha_fin").style.display='none';
    document.getElementById("docente").style.display='none';
    document.getElementById("ingresar").style.display='none';
    document.getElementById("nombre").style.display='none';
    document.getElementById("apellido").style.display='none';
    document.getElementById("telefono").style.display='none';
    document.getElementById("fecha").style.display='none';
    document.getElementById("cedula").style.display='none';
    document.getElementById("area").style.display='none';
    document.getElementById("correo").style.display='none';
    document.getElementById("Logro").style.display='none';
    document.getElementById("id_m").style.display='none';
    document.getElementById("id_a").style.display='none';
    document.getElementById("generar").style.display='none';
    document.getElementById("generarx").style.display='none';
    $("#id_e").css("display", "none");
    $("#id_d").css("display", "none");
    $("#logro_1").css("display", "none");
    $("#logro_2").css("display", "none");
    $("#logro_3").css("display", "none");
    $("#id_l").css("display", "none");
    $("#graficar").css("display", "none");
  }

  /////////////////////////////////////////////////////////////////////////////
  //                                                                         //
  // Esta funcion se encarga de addicionar estudiantes, docentes, etc ..     //
  // para lo cual tiene en cuenta el estado del combo de seleccion #add      //
  //                                                                         //
  // Las opciones que muestra dicho combo son :                              //
  //                                                                         //
  // 1 - Estudiantes                                                         //
  // 2 - Docentes                                                            //
  // 3 - Materias                                                            //
  // 4 - Areas                                                               //
  // 5 - Logros                                                              //
  // 6 - Matricula Alumnos                                                   //
  // 7 - Matricula Doncente                                                  //
  // 9 - Requisistos de Materia                                              //
  //                                                                         //
  /////////////////////////////////////////////////////////////////////////////

  function add_display () {

    // la variable x el valor de la caja desplegable
    // actuar como insumo para indexar las acciones que
    // correspondan a dicho

    // Coloca el selector del menu #edi en valor de -1
    $('select#edi').val('-1');
    // coloca en blanco la seccion del calificador
    $('#calificador').html("");
    // recupero en y el valor del selector #add
    var y = document.getElementById('add').value;
    //  muestro el boton de ingresar
    document.getElementById("ingresar").style.display='block';
    // oculto el boton de actualizar
    document.getElementById("actualizar").style.display='none';


    // De acuerdo al valor seleccionado
    // Selecciono la opcion de preferencia

    switch(y) {


      case "1":	// adiccionar estudiantes

      document.getElementById("estudiante").style.display='none';
      document.getElementById("fecha_fin").style.display='none';
      document.getElementById("docente").style.display='none';
      document.getElementById("nombre").style.display='block';
      document.getElementById("apellido").style.display='block';
      document.getElementById("telefono").style.display='block';
      document.getElementById("fecha").style.display='block';
      document.getElementById("cedula").style.display='block';
      document.getElementById("area").style.display='none';
      document.getElementById("correo").style.display='block';
      document.getElementById("Logro").style.display='none';
      document.getElementById("id_m").style.display='none';
      document.getElementById("id_a").style.display='none';
      document.getElementById("generar").style.display='none';
      document.getElementById("generarx").style.display='none';
      $("#id_e").css("display", "none");
      $("#id_d").css("display", "none");
      $("#logro_1").css("display", "none");
      $("#logro_2").css("display", "none");
      $("#logro_3").css("display", "none");
      $("#id_l").css("display", "none");
      $("#graficar").css("display", "none");
      break;

      case "2": // Aderir Docentes

      document.getElementById("estudiante").style.display='none';
      document.getElementById("fecha_fin").style.display='none';
      document.getElementById("docente").style.display='none';
      document.getElementById("ingresar").style.display='block';
      document.getElementById("nombre").style.display='block';
      document.getElementById("apellido").style.display='block';
      document.getElementById("telefono").style.display='block';
      document.getElementById("fecha").style.display='block';
      document.getElementById("cedula").style.display='block';
      document.getElementById("area").style.display='block';
      document.getElementById("correo").style.display='block';
      document.getElementById("Logro").style.display='none';
      document.getElementById("id_m").style.display='none';
      document.getElementById("id_a").style.display='none';
      document.getElementById("generar").style.display='none';
      document.getElementById("generarx").style.display='none';
      $("#id_e").css("display", "none");
      $("#id_d").css("display", "none");
      $("#logro_1").css("display", "none");
      $("#logro_2").css("display", "none");
      $("#logro_3").css("display", "none");
      $("#id_l").css("display", "none");
      $("#graficar").css("display", "none");
      break;

      // Para aderir materias se muestran los siguientes  combos

      case "3":

      document.getElementById("estudiante").style.display='none';
      document.getElementById("fecha_fin").style.display='none';
      document.getElementById("docente").style.display='none';
      document.getElementById("ingresar").style.display='none';
      document.getElementById("cedula").style.display='none';
      document.getElementById("area").style.display='none';
      document.getElementById("correo").style.display='none';
      document.getElementById("nombre").style.display='none';
      document.getElementById("apellido").style.display='none';
      document.getElementById("telefono").style.display='none';
      document.getElementById("fecha").style.display='none';
      document.getElementById("Logro").style.display='none';
      document.getElementById("id_m").style.display='none';
      document.getElementById("id_a").style.display='none';
      document.getElementById("generar").style.display='none';
      document.getElementById("generarx").style.display='none';
      document.getElementById("cargar").style.display='block';
      $("#id_e").css("display", "none");
      $("#id_d").css("display", "none");
      $("#logro_1").css("display", "none");
      $("#logro_2").css("display", "none");
      $("#logro_3").css("display", "none");
      $("#id_l").css("display", "none");
      $("#graficar").css("display", "none");
      break;

      // caso  de  consultar  areas -->

      case "4":

      document.getElementById("estudiante").style.display='none';
      document.getElementById("fecha_fin").style.display='none';
      document.getElementById("docente").style.display='none';
      document.getElementById("ingresar").style.display='none';
      document.getElementById("cedula").style.display='none';
      document.getElementById("area").style.display='none';
      document.getElementById("correo").style.display='none';
      document.getElementById("nombre").style.display='none';
      document.getElementById("apellido").style.display='none';
      document.getElementById("telefono").style.display='none';
      document.getElementById("fecha").style.display='none';
      document.getElementById("Logro").style.display='none';
      document.getElementById("id_m").style.display='none';
      document.getElementById("id_a").style.display='none';
      document.getElementById("generar").style.display='none';
      document.getElementById("generarx").style.display='none';
      document.getElementById("cargar").style.display='block';
      $("#id_e").css("display", "none");
      $("#id_d").css("display", "none");
      $("#logro_1").css("display", "none");
      $("#logro_2").css("display", "none");
      $("#logro_3").css("display", "none");
      $("#id_l").css("display", "none");
      $("#graficar").css("display", "none");
      break;

      case "5":	// adiccionar logros

      document.getElementById("estudiante").style.display='none';
      document.getElementById("fecha_fin").style.display='none';
      document.getElementById("docente").style.display='none';
      document.getElementById("ingresar").style.display='block';
      document.getElementById("nombre").style.display='none';
      document.getElementById("apellido").style.display='none';
      document.getElementById("telefono").style.display='none';
      document.getElementById("fecha").style.display='none';
      document.getElementById("cedula").style.display='none';
      document.getElementById("area").style.display='none';
      document.getElementById("correo").style.display='none';
      document.getElementById("Logro").style.display='block';
      document.getElementById("id_m").style.display='block';
      document.getElementById("id_a").style.display='none';
      document.getElementById("generar").style.display='none';
      document.getElementById("generarx").style.display='none';
      $("#id_e").css("display", "none");
      $("#id_d").css("display", "none");
      $("#logro_1").css("display", "none");
      $("#logro_2").css("display", "none");
      $("#logro_3").css("display", "none");
      $("#id_l").css("display", "none");
      $("#graficar").css("display", "none");
      break;

      case "6":	// en este caso se editan los boletines

      document.getElementById("estudiante").style.display='none';
      document.getElementById("fecha_fin").style.display='none';
      document.getElementById("docente").style.display='none';
      document.getElementById("ingresar").style.display='none';
      document.getElementById("cedula").style.display='none';
      document.getElementById("area").style.display='none';
      document.getElementById("correo").style.display='none';
      document.getElementById("nombre").style.display='none';
      document.getElementById("apellido").style.display='none';
      document.getElementById("telefono").style.display='none';
      document.getElementById("fecha").style.display='none';
      document.getElementById("Logro").style.display='none';
      document.getElementById("id_m").style.display='none';
      document.getElementById("id_a").style.display='none';
      document.getElementById("generar").style.display='block';
      document.getElementById("generarx").style.display='block';
      $("#id_e").css("display", "none");
      $("#id_d").css("display", "none");
      $("#logro_1").css("display", "none");
      $("#logro_2").css("display", "none");
      $("#logro_3").css("display", "none");
      $("#id_l").css("display", "none");
      $("#graficar").css("display", "none");
      break;

      case "7":	// en este caso se editan los boletines

      document.getElementById("estudiante").style.display='none';
      document.getElementById("fecha_fin").style.display='none';
      document.getElementById("docente").style.display='none';
      document.getElementById("ingresar").style.display='block';
      document.getElementById("cedula").style.display='none';
      document.getElementById("area").style.display='none';
      document.getElementById("correo").style.display='none';
      document.getElementById("nombre").style.display='block';
      document.getElementById("apellido").style.display='block';
      document.getElementById("telefono").style.display='none';
      document.getElementById("fecha").style.display='none';
      document.getElementById("Logro").style.display='none';
      document.getElementById("id_m").style.display='none';
      document.getElementById("id_a").style.display='none';
      document.getElementById("generar").style.display='none';
      document.getElementById("generarx").style.display='none';
      $("#id_e").css("display", "block");
      $("#id_d").css("display", "none");
      $("#logro_1").css("display", "none");
      $("#logro_2").css("display", "none");
      $("#logro_3").css("display", "none");
      $("#id_l").css("display", "none");
      $("#graficar").css("display", "none");
      break;


      case "8": // Elementos a mostrar para la matricula del docente

      document.getElementById("estudiante").style.display='none';
      document.getElementById("fecha_fin").style.display='block';
      document.getElementById("docente").style.display='block';
      document.getElementById("ingresar").style.display='block';
      document.getElementById("cedula").style.display='none';
      document.getElementById("area").style.display='none';
      document.getElementById("correo").style.display='none';
      document.getElementById("nombre").style.display='none';
      document.getElementById("apellido").style.display='none';
      document.getElementById("telefono").style.display='none';
      document.getElementById("fecha").style.display='none';
      document.getElementById("Logro").style.display='none';
      document.getElementById("id_m").style.display='block';
      document.getElementById("id_a").style.display='none';
      document.getElementById("generar").style.display='none';
      document.getElementById("generarx").style.display='none';
      $("#id_e").css("display", "none");
      $("#id_d").css("display", "none");
      $("#logro_1").css("display", "none");
      $("#logro_2").css("display", "none");
      $("#logro_3").css("display", "none");

      $("#id_l").css("display", "none");
      $("#graficar").css("display", "none");
      break;

      case "9":  // Elementos a mostrar para los requisitos de materia

      document.getElementById("estudiante").style.display='none';
      document.getElementById("fecha_fin").style.display='none';
      document.getElementById("docente").style.display='none';
      document.getElementById("ingresar").style.display='block';
      document.getElementById("nombre").style.display='none';
      document.getElementById("apellido").style.display='none';
      document.getElementById("telefono").style.display='none';
      document.getElementById("fecha").style.display='none';
      document.getElementById("cedula").style.display='none';
      document.getElementById("area").style.display='none';
      document.getElementById("correo").style.display='none';
      document.getElementById("Logro").style.display='none';
      document.getElementById("id_m").style.display='none';
      document.getElementById("id_a").style.display='none';
      document.getElementById("generar").style.display='none';
      document.getElementById("generarx").style.display='none';
      $("#id_e").css("display", "none");
      $("#id_d").css("display", "none");
      $("#logro_1").css("display", "none");
      $("#logro_2").css("display", "none");
      $("#logro_3").css("display", "none");

      $("#id_l").css("display", "none");
      $("#graficar").css("display", "none");
      break;



      case "11": // Elementos a mostrar para adiccionar notas

      document.getElementById("estudiante").style.display='none';
      document.getElementById("fecha_fin").style.display='none';
      document.getElementById("docente").style.display='none';
      document.getElementById("ingresar").style.display='block';
      document.getElementById("cedula").style.display='none';
      document.getElementById("area").style.display='none';
      document.getElementById("correo").style.display='none';
      document.getElementById("nombre").style.display='none';
      document.getElementById("apellido").style.display='none';
      document.getElementById("telefono").style.display='none';
      document.getElementById("fecha").style.display='none';
      document.getElementById("Logro").style.display='none';
      document.getElementById("id_m").style.display='block';
      document.getElementById("id_a").style.display='none';
      document.getElementById("generar").style.display='none';
      document.getElementById("generarx").style.display='none';
      $("#id_e").css("display", "none");
      $("#id_d").css("display", "none");
      $("#logro_1").css("display", "none");
      $("#logro_2").css("display", "none");
      $("#logro_3").css("display", "none");

      $("#id_l").css("display", "none");
      $("#graficar").css("display", "none");
      formulario_calificar(); // Ejecuta el formulario de calificaciones
      break;


      case "12":	// Elementos a mostra para  completar los registros

      document.getElementById("estudiante").style.display='none';
      document.getElementById("fecha_fin").style.display='none';
      document.getElementById("docente").style.display='none';
      document.getElementById("ingresar").style.display='block';
      document.getElementById("cedula").style.display='none';
      document.getElementById("area").style.display='none';
      document.getElementById("correo").style.display='none';
      document.getElementById("nombre").style.display='none';
      document.getElementById("apellido").style.display='none';
      document.getElementById("telefono").style.display='none';
      document.getElementById("fecha").style.display='none';
      document.getElementById("Logro").style.display='none';
      document.getElementById("id_m").style.display='none';
      document.getElementById("id_a").style.display='none';
      document.getElementById("generar").style.display='none';
      document.getElementById("generarx").style.display='none';
      $("#id_e").css("display", "none");
      $("#id_d").css("display", "none");
      $("#logro_1").css("display", "none");
      $("#logro_2").css("display", "none");
      $("#logro_3").css("display", "none");
      $("#id_l").css("display", "none");
      $("#graficar").css("display", "none");
      break;

    }


  }

  /////////////////////////////////////////////////////////////////////////////////
  //                                                                             //
  // Esta funcion toma el campo de la nota maestra  y la replica en los          //
  // campos restantes
  //                                                                             //
  /////////////////////////////////////////////////////////////////////////////////

  function igual_notas() {

    var nota = $('#master_nota').val(); // tomo el valor del cambio aderir
    var color = document.getElementById('master_nota').style.color;
    // asignar las notas
    $(".notas").val(nota);

    var lo = document.getElementsByClassName('notas');
    var i;
    for (i = 0; i < lo.length; i++) {
    lo[i].style.color = color;
  }
  }


  /////////////////////////////////////////////////////////////////////////////////
  //                                                                             //
  // esta funcion permite rellenar los campos de los logros                      //
  //                                                                             //
  /////////////////////////////////////////////////////////////////////////////////

  function igual_logro1() {
    // tomo la nota del logro principal, el de la primera fila
    var logro1 = $('#master_logro1').val(); // tomo el valor del cambio aderir
    var color = document.getElementById('master_logro1').style.color;
    // asignar las notas
    $(".logros1").val(logro1);

    var lo = document.getElementsByClassName('logros1');
    var i;
    for (i = 0; i < lo.length; i++) {
    lo[i].style.color = color;
  }

  }

  // esta funcion permite rellenar los campos de los logros
  function igual_logro2() {

    // tomo la nota del logro principal, el de la primera fila
    var logro2 = $('#master_logro2').val(); // tomo el valor del cambio aderir
    var color = document.getElementById('master_logro2').style.color;
    // asignar las notas
    $(".logros2").val(logro2);

    var lo = document.getElementsByClassName('logros2');
    var i;
    for (i = 0; i < lo.length; i++) {
    lo[i].style.color = color;
  }
  }

  // esta funcion permite rellenar los campos de los logros
  function igual_logro3() {
    // tomo la nota del logro principal, el de la primera fila
    var logro3 = $('#master_logro3').val(); // tomo el valor del cambio aderir
    var color = document.getElementById('master_logro3').style.color;
    // asignar las notas
    $(".logros3").val(logro3);

    var lo = document.getElementsByClassName('logros3');
    var i;
    for (i = 0; i < lo.length; i++) {
    lo[i].style.color = color;
  }
}

  // cuando el documento este listo entonces
  $(document).ready(function() {

    // cuando el campo de jornada cambie  se ejecuta la siguiente  fucion
    $("#jornada").change(function() {

      add = $('select#add').val(); // tomo el valor del cambio aderir
      consultar();

      switch(add) {
        case "11":
        formulario_calificar();
        break;
      }
    });





    $("#periodos").change(function() {

      add = $('select#add').val(); // tomo el valor del cambio aderir

      switch(add) {

        case "11":
        formulario_calificar();

        break;
      }
    });

    $("#corte").change(function() {

      add = $('select#add').val(); // tomo el valor del cambio aderir

      switch(add) {
        case "11":
        formulario_calificar();
        break;
      }
    });



    $("#id_ms").change(function() {

      add = $('select#add').val(); // tomo el valor del cambio aderir

      switch(add) {
        case "11":
        formulario_calificar();
        break;
      }
    });


    // cuando el campo de materias cambia se ejecuta la consulta
    $("#id_ms_con").change(function() {

      // var op = $('select#option').val(); // tomo el valor del cambio aderir
      consultar();
      // switch(op) {
      //   case "5":
      //   consultar();
      //   break;
      // }
    });

    // cuando el grado cambia se ejecuta la siguiente funcion

    $("#id_g").change(function() {

      consultar(); // actualza el menu de de consultar
      add = $('select#add').val(); // tomo el valor del cambio aderir
      switch(add) {
        case "11":
        carga("#id_ms","materias_grado.php",{
          id : $("#id_docentes").val(),
          year: $("#years").val().toString(),
          grados: $("#id_g").val()
        });
        $('select#id_ms').val('-1');
        formulario_calificar();
        break;
      }
    });

    // cada vez que se cambia el valor del combo adiccionar  se realizan las siguientes acciones
    // para cargar los combos
    $("#add").change(function() {

      add_display();	// funcion que oculta los campos segun la opcion


      add = $('select#add').val(); // tomo el valor del cambio aderir

      switch(add) {
        case "1":
        $("#i_nombres").attr("readonly",false);
        $("#apellidos").attr("readonly",false);
        break;

        case "2":
        $("#i_nombres").attr("readonly",false);
        $("#apellidos").attr("readonly",false);
        break;
        // en el caso de los logros
        case "5":

        break;
        // caso de matricula alumnos
        case "7":
        carga("#id_gs","grados.php",{ id : $("#id").val()});
        //consultar();
        break;

        case '8':
        carga("#id_ms","materias.php",{ id : $("#id").val()});
        break;

        case "11":
        carga("#id_ms","materias_grado.php",{
          id : $("#id_docentes").val(),
          year: $("#years").val().toString(),
          grados: $("#id_g").val()
        });
        $('select#id_ms').val('-1');
        break;

        // en caso de
        case "8":

        break;

        case "9":


        break;


        case "11":


        break;

        case "12":

        break;



        default:
        //consultar();

        break;


      }


    });
  });

  // funcion que cambia el color del texto de un campo  en funcion de su
  // id
  function color_celda(id) {

    document.getElementById(id).style.color = 'red';
  }

  // Esta funcion tiene como objeto ocultar o desocultar
  // los elementos del formulario  del menu editar

  function edit_display(){

    // la variable x el valor de la caja desplegable
    // actuar como insumo para indexar las acciones que correspondan a dicho item -->

    // coloco el combo add en esta desceleccionado
    // es decir -1
    $('select#add').val('-1');
    // coloco en blanco el espacio  en el cual se muestran los
    // resultados
    $('#calificador').html("");
    // muestro el boton actualizar
    $("#actualizar").css("display", "block");
    // oculto en boton ingresar
    $("#ingresar").css("display", "none");

    // tomo como variable el valor  del combo edi
    // el cual contiene las opciones a editar
    var y = $('#edi').val();

    // de acuerdo a la funcion seleccionada
    // se establece la configuracion del formulario

    switch(y) {


      case "1":	// caso editar estudiantes

      document.getElementById("estudiante").style.display='none';
      document.getElementById("fecha_fin").style.display='none';
      document.getElementById("docente").style.display='none';
      document.getElementById("nombre").style.display='block';
      document.getElementById("apellido").style.display='block';
      document.getElementById("telefono").style.display='block';
      document.getElementById("fecha").style.display='block';
      document.getElementById("cedula").style.display='block';
      document.getElementById("area").style.display='none';
      document.getElementById("correo").style.display='block';
      document.getElementById("Logro").style.display='none';
      document.getElementById("id_m").style.display='none';
      document.getElementById("id_a").style.display='none';
      document.getElementById("generar").style.display='none';
      document.getElementById("generarx").style.display='none';
      $("#id_e").css("display", "block");
      $("#id_d").css("display", "none");
      $("#logro_1").css("display", "none");
      $("#logro_2").css("display", "none");
      $("#logro_3").css("display", "none");
      $("#id_l").css("display", "none");
      $("#graficar").css("display", "none");
      break;

      case "2":       // caso editar docentes

      document.getElementById("estudiante").style.display='none';
      document.getElementById("fecha_fin").style.display='none';
      document.getElementById("docente").style.display='none';
      document.getElementById("nombre").style.display='block';
      document.getElementById("apellido").style.display='block';
      document.getElementById("telefono").style.display='block';
      document.getElementById("fecha").style.display='block';
      document.getElementById("cedula").style.display='block';
      document.getElementById("area").style.display='block';
      document.getElementById("correo").style.display='block';
      document.getElementById("Logro").style.display='none';
      document.getElementById("id_m").style.display='none';
      document.getElementById("id_a").style.display='none';
      document.getElementById("generar").style.display='none';
      document.getElementById("generarx").style.display='none';
      $("#id_e").css("display", "none");
      $("#id_d").css("display", "block");
      $("#logro_1").css("display", "none");
      $("#logro_2").css("display", "none");
      $("#logro_3").css("display", "none");
      $("#id_l").css("display", "none");
      $("#graficar").css("display", "none");
      break;




      case "5":	// caso editar logros

      document.getElementById("estudiante").style.display='none';
      document.getElementById("fecha_fin").style.display='none';
      document.getElementById("docente").style.display='none';
      document.getElementById("nombre").style.display='none';
      document.getElementById("apellido").style.display='none';
      document.getElementById("telefono").style.display='none';
      document.getElementById("fecha").style.display='none';
      document.getElementById("cedula").style.display='none';
      document.getElementById("area").style.display='none';
      document.getElementById("correo").style.display='none';
      document.getElementById("Logro").style.display='block';
      document.getElementById("id_m").style.display='none';
      document.getElementById("id_a").style.display='none';
      document.getElementById("generar").style.display='none';
      document.getElementById("generarx").style.display='none';
      $("#id_e").css("display", "none");
      $("#id_d").css("display", "none");
      $("#logro_1").css("display", "none");
      $("#logro_2").css("display", "none");
      $("#logro_3").css("display", "none");
      $("#id_l").css("display", "block");
      $("#graficar").css("display", "none");
      break;



      case "12":   // caso editar plazo de nota

      document.getElementById("estudiante").style.display='none';
      document.getElementById("fecha_fin").style.display='block';
      document.getElementById("docente").style.display='none';
      document.getElementById("cedula").style.display='none';
      document.getElementById("area").style.display='none';
      document.getElementById("correo").style.display='none';
      document.getElementById("nombre").style.display='none';
      document.getElementById("apellido").style.display='none';
      document.getElementById("telefono").style.display='none';
      document.getElementById("fecha").style.display='none';
      document.getElementById("Logro").style.display='none';
      document.getElementById("id_m").style.display='none';
      document.getElementById("id_a").style.display='none';
      document.getElementById("generar").style.display='none';
      document.getElementById("generarx").style.display='none';
      $("#id_e").css("display", "none");
      $("#id_d").css("display", "none");
      $("#logro_1").css("display", "none");
      $("#logro_2").css("display", "none");
      $("#logro_3").css("display", "none");
      $("#id_l").css("display", "none");
      $("#graficar").css("display", "none");
      break;

    }

  }


  function consultar_display () {

    // la variable x el valor de la caja desplegable actuar como insumo para indexar las acciones que correspondan a dicho item -->
    // cargo en la variable y la  el selector de consultar
    // es decir la opcion que selecciona el usuario
    var y = $("#opcion").val();

    // de acuerdo a la funcion que selecciona el  usuario
    //  se escogen que campos ocultar  y cuales mostrar
    // ocultar_display();
    ocultar_consultar();

    switch(y) {

      case "1":	// consultar estudiantes
      document.getElementById("nombre_con").style.display='block'; 	// muestra este campo -->
      document.getElementById("apellido_con").style.display='block'; 	// muestra este campo -->
      document.getElementById("cargar").style.display='none'; 	// muestra este campo -->
      $("#cargar").css("display", "none"); // muestro el boton de consultar
      break;

      case "2":
      document.getElementById("nombre_con").style.display='block';
      document.getElementById("apellido_con").style.display='block';
      document.getElementById("cargar").style.display='none';
      $("#cargar").css("display", "none"); // muestro el boton de consultar
      break;

      // caso en donde consultar las materias existentes -->

      case "3":


      break;

      // caso  de consultar areas -->

      case "4":


      break;

      // en caso de los logros
      case "5":
      document.getElementById("id_m_con").style.display='block';
      document.getElementById("Logro_con").style.display='block';
      consultar();
      //$("#cargar").css("display", "none"); // muestro el boton de consultar
      break;

      case "6":	// en este caso se editan los boletines

      document.getElementById("generar").style.display='block';
      document.getElementById("generarx").style.display='block';
      break;

      case "7":	// en este caso se editan la matricula de los alumnos



      break;


      case "8": // en caso de la matricula de los docentes



      break;


      case "9": // en caso de los requisitos de materia



      break;

      case "11": // corresponde a la nota vista por los docentes

      document.getElementById("id_m").style.display='block';

      $("#id_e").css("display", "none");
      $("#cargar").css("display", "none"); // muestro el boton de consultar
      break;


      case "12": // corresponde a la nota ingresada por el administrador de la página



      break;

      case "13": // corresponde a la nota ingresada por el administrador de la página

      $("#graficar").css("display", "block");
      $("#cargar").css("display", "none"); // muestro el boton de consultar
      break;

      case "14":
      $("#graficar").css("display", "block");
      $("#cargar").css("display", "none"); // muestro el boton de consultar
      break;

      case "15":
      $("#graficar").css("display", "block");
      $("#cargar").css("display", "none"); // muestro el boton de consultar

      break;


      case "16":
      // en caso de seleccionar un certificado

      document.getElementById("generar").style.display='block';
      document.getElementById("generarx").style.display='block';

      break;

    } // final del esxplorador de columnas

  } 	// final de consultar display

  $(document).ready(function() {

    // cada vez que se cambia el valor del combo   de consulta
    $("#opcion").change(function() {
      // llamo a la funcion que  oculta los campos
      consultar_display();
      // borro los resultados  mostrados de las anteriores consultas
      $("#resultado_con").html("");
      // almaceno en una variable  la opcion seleccionada
      op = $('select#opcion').val();
      // muestro en consola la opcion seleccionada
      console.log("Ha cambiado la opcion del selector a %s",op);
      // de acuerdo a la opcion seleccionada  procedo  a realizar el caso

      switch(op) {
        // en caso de que se seleccionan los estudiantes
        case "1":
        // realizo la consulta de los estudioantes
        // de acuerdo al combo nombre y/o apellido
        consultar();
        break;
        // em casp de que seleccionen los docentes

        case "2":
        // realizo la consulta de la tabla docentes
        // de acierdo al nombre o apellido
        consultar();
        break;
        // en caso de que la opcion sea  los logros
        case "5":
        // carogo el combo cursos con todas las materias
        // que se encuentran habilitadas para un docente
        carga("#id_ms_con","materias.php",{ id : $("#id_docentes").val()});
        // realizo la consulta de los logros
        consultar();
        break;
        // en caso de que sean el boletin
        case "6":
        //
        //carga("#id_gs","grados.php",0);
        consultar();
        break;
        // en  caso de  matricula alumnos
        case "7":

        //carga("#id_gs","grados.php",0);
        consultar();
        break;
        // en  caso de matricula docenten
        case "8":
        //carga("#id_gs","grados.php",0);
        consultar();
        break;
        // en caso de consultar requisistos de materia
        case "9":
        //carga("#id_gs","grados.php",{ id : $("#id").val()});
        consultar();
        break;

        // en caso de las notas
        case "12":
        //carga("#grados","grados.php",{ id : $("#id").val()});
        //$("#grados").val("-1");
        //$("#estudiantes").val("-1");
        break;
        // en el caso de registros por grado
        case "13":

        break;
        // en caso de registros por docenete
        case "14":

        break;
        // en caso de registros por alumno
        case "15":

        break;
        case "16":
        carga("#id_gs","grados.php",{ id : $("#id").val()});
        consultar();
        break;

        // si no corresponde a  ninguna de las opciones
        default:
        consultar();

        break;

      }

    });
  });


  /////////////////////////////////////////////////////////////////////////
  //                                                                     //
  // Esta funcion permite conmutar entre las opciones                    //
  // de adiccionar y editar                                              //
  //                                                                     //
  /////////////////////////////////////////////////////////////////////////

  function menu_adicionar() {

    // capturo es estado del elemento que tiene por name = menu
    var menu = $('input[name=menu]:checked').val();
    //swal(menu);

    // Si he seleccionado el menu adiccionar entonces
    // realizo la siguiente configuracion
    if (menu == "add"){
      $('#edi').css("display", "none");
      $('#add').css("display", "block");
      //$('#adiccionar').css("background-color", "blue");
      $('select#add').val('-1');
      ocultar_add();
      //add_display();
    }
    else{

      // estas son las instrucciones
      $('#add').css("display", "none");
      $('#edi').css("display", "block");
      //$('#adiccionar').css("background-color", "gold");
      $('select#edi').val('-1');
      ocultar_add();
    }
  }

  </script>

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

  </script>

  <script type="text/javascript">

  /////////////////////////////////////////////////////////////////////////////////////////////////////////
  //                                                                                                     //
  // esta funcion interroga a la base de datos para visualizar el contenido de sus tablas                //
  // para lo cual toma el contenido de los selectores "consultar" (opcion) y  "adiccionar" (add)         //
  // como criterios para  selecionar que consulta se va a ejecutar  en la base de datos                  //
  // a travez del archivo seleccion.php                                                                  //
  // los demás campos se envian  como información para desarrollar las consultas.                        //
  //                                                                                                     //
  /////////////////////////////////////////////////////////////////////////////////////////////////////////

  function consultar() {

    // En caso que la opcion selecionada mediante el combo #option sea la 13, que corresponde
    // a los registros por grado entoncies

    if ($("#opcion option:selected").val() == 13) {
      // en caso de que la opcion se generar
      // un grafico de tendencias
      grafica();
      // muestro en pantalla
      console.log("graficando");

    }
    // en caso de que no se consulte un grafico
    else
    {
      // actualiza la tabla con los valrores
      // se llama al archivo seleccion.php el cual retorna
      // una tabla en formato html

      $('#resultado_con').load("seleccion.php",
      {

        opcion: $("#opcion option:selected").val(),
        i_nombres: $("#i_nombres_con").val(),
        apellidos: $("#apellidos_con").val(),
        Logros: $("#Logros_con").val(),
        years: $("#years").val().toString(),
        id_g: $("#id_g option:selected").val(),
        estudiantes: $("#estudiantes").val(),
        periodos: $("#periodos option:selected").val(),
        id_ms : $("#id_ms_con").val(),
        jornada: $("#jornada option:selected").val(),
        corte: $("#corte option:selected").val()

      },
      function(){

      });}

    }

    // funcion que actualiza el listado de los nombres de los estudiantes
    // o de los docentes

    function campo_nombre(){

      // se carga  en el combo  resultado_con la lista de los estudiantes
      // coincidentes con los criterios de busqueda.

      $('#resultado_con').load("seleccion.php",
      {
        opcion: $("#opcion option:selected").val(),
        i_nombres: $("#i_nombres_con").val(),
        apellidos: $("#apellidos_con").val(),
        Logros: $("#Logros_con").val(),
        years: $("#years").val().toString(),
        id_g: $("#id_g option:selected").val(),
        estudiantes: $("#estudiantes").val(),
        periodos: $("#periodos option:selected").val(),
        id_ms : $("#id_ms_con").val(),
        jornada: $("#jornada option:selected").val(),
        corte: $("#corte option:selected").val()

      },
      function(){

      });
    }

    // funcion encargada de validar los campos a ingresar a la base de datos
    // esta relacionada con el formulario de  adiccionar

    function validar_add() {
      // se toman las variables del formulario
      var nombre = $("#i_nombres").val(); // variable nombre en el formulario
      var apellido = $("#apellidos").val(); // variable apellidos en el formulario
      var fecha = $("#fechas").val(); // variable fechas en el formulario
      var telefono = $("#telefonos").val(); // variable telefonos en el formulario
      var correo = $("#correos").val(); // variable correos en el formulario
      var cedula = $("#cedulas").val(); // variable cedula en el formulario
      var add = $("#add").val(); //  selector de adiccionar en el formulario
      var ano = $("#years").val(); // variable año en el formulario
      var jornada = $("select#jornada").val() ; // variable jormana en el formulario
      var periodo = $("select#periodos").val(); // variable periodo en el formulario
      var corte =  $("select#corte").val();// variable corte en el formulario
      var grado =  $("select#id_g").val();// variable gradp en el formulario
      var docente = $("select#docentes").val(); //
      var materia = $("select#id_ms").val(); //

      var validar = true;
      $("#resultado").html("");

      if( add == 1 || add == 2 ){
        // validando nombre
        if(nombre == ""  ){
          $("#i_nombres").css("border-color", "red");
          validar = false;
        }
        //en otro caso, el mensaje no se muestra
        else{
          $("#i_nombres").css("border-color", "grey");
        }
        // validando apellido
        if(apellido == ""){
          $("#apellidos").css("border-color", "red");
          validar = false;
        }
        //en otro caso, el mensaje no se muestra
        else{
          $("#apellidos").css("border-color", "grey");
        }
        // validar fecha
        if(fecha == ""){
          $("#fechas").css("border-color", "red");
          validar = false;
        }
        //en otro caso, el mensaje no se muestra
        else{
          $("#fechas").css("border-color", "grey");
        }
        // telefono
        if(telefono == "" || isNaN(telefono)){
          $("#telefonos").css("border-color", "red");
          validar = false;
        }
        //en otro caso, el mensaje no se muestra
        else{
          $("#telefonos").css("border-color", "grey");
        }
        // validar correo
        if(correo == ""){
          $("#correos").css("border-color", "red");
          validar = false;
        }
        //en otro caso, el mensaje no se muestra
        else{
          $("#correos").css("border-color", "grey");
        }

        // validar cedula
        if(cedula == "" || isNaN(cedula)){
          $("#cedulas").css("border-color", "red");
          validar = false;
        }
        //en otro caso, el mensaje no se muestra
        else{
          $("#cedulas").css("border-color", "grey");
        }
      }
      // en caso de que las opciones sean
      else if ( add == 7 ||  add == 9){
        // datos de la jornada
        if (jornada == -1){
          $("#resultado").append("<p style='color:red;'>Favor seleccione una jornada <p>");
          validar = false;
        }
        // datos del periodo
        if (periodo == -1){
          $("#resultado").append("<p style='color:red;'>Favor seleccione un periodo <p>");
          validar = false;
        }
        // datos de corte
        if (corte  == -1){
          $("#resultado").append("<p style='color:red;'>Favor seleccione un corte <p>");
          validar = false;
        }
        // datos de grado
        if (grado == -1){
          $("#resultado").append("<p style='color:red;'>Favor seleccione un grado <p>");
          validar = false;
        }
      } else if ( add == 8){
        // datos de la jornada
        if (jornada == -1){
          $("#resultado").append("<p style='color:red;'>Favor seleccione una jornada <p>");
          validar = false;
        }

        // datos de grado
        if (grado == -1){
          $("#resultado").append("<p style='color:red;'>Favor seleccione un grado <p>");
          validar = false;
        }
        // datos de grado
        if (materia == -1){
          $("#resultado").append("<p style='color:red;'>Favor seleccione una materia <p>");
          validar = false;
        }

        // datos de grado
        if (docente == -1){
          $("#resultado").append("<p style='color:red;'>Favor seleccione un docente <p>");
          validar = false;
        }
      }
      return validar;
    }

    // Funcion en java scrip para ingresar valores en la base de datos
    // para todas las opciones del menu adiccionar
    // permite agregar estudiantes, docentes, notas etc ...

    function deposit() {

      // para ello comienza
      // almacenando el codigo del grado en la variable j
      var j = $("#id_g").val();

      // se crea un algoritmo para computar los logors
      // la variable  k que cuenta el limite de logros (interaciones)
      // asi :
      // k = 0 --> corresponde a un logro
      // k = 1 --> corresponde a dos logros
      // k = 2 --> corresponde a tres logros

      var k = 0;

      // comienza con un algoritmo de validación
      // los grados con codigos 7, 8 y 9 tienen tres logros (k = 2) estos corresponden a pre escolar

      if (j == 7 || j == 8 || j == 9 ) {
        k= 2; // asigna tres logros
        console.log("Se cambio k a : %i", k);
      }

      // Si voy ha adiccionar una nota ...
      // si lo que adicciono no es una nota salto este procedimiento
      if ($("#add").val() == 11) {
        // variable que cuenta las iteraciones
        var i = 0;

        /// por cada checkbox ejecuta esta funcion
        $('input[type=checkbox]').each(function() {
          // si el checkbox esta seteado
          if(this.checked == true){

            // almaceno el id en la variable id_c el cual es el codigo del logro
            id_c = this.id;
            //
            if (k >= i) {

              switch(i) { // estructura para seleccionar los logros

                case 0:
                $("#logro_1").val(id_c);
                $("#logro_2").val("");
                $("#logro_3").val("");
                break

                case 1:
                $("#logro_2").val(id_c);
                $("#logro_3").val("");
                break

                case 2:
                $("#logro_3").val(id_c);
                break
              }

              i++;

              console.log("El valor de k es: "+k+", el valor de i es :"+i+" y el id: "+id_c);

            }
          }

        });

        //  se muestra en consola los valores insertados en los campos logro 1, logro 2 y logro3
        console.log("Logro 1 : %s",$("#logro_1").val());
        console.log("Logro 2 : %s",$("#logro_2").val());
        console.log("Logro 3 : %s",$("#logro_3").val());
      }





      swal({
        title: 'INSERTAR NOTAS',
        text: "Esta seguro que quiere insertar las notas!",
        icon: 'warning',
        buttons: true,
        buttons: ["cancelar", "insertar"],
        }).then((value) => {
          if(value){
          //swal('The returned value is: true');
          // +++++++

          /////////
          var datos  = validar_add();
          if (datos) {

            // if (confirm("ALERTA!! va a proceder a ingresar" +
            // "un  registro, para confirmar de"+
            // " click en ACEPTAR\n de lo contrario"+
            // " de click en CANCELAR.") )
            // {
              // en esta seccion se incertan los registros
              // dentro de la base de datos , enviados a traves de
              // ajax

              console.log(" add = %i",$("#add").val());
              switch($("#add").val()){

                case '11':

                // creo tes array a partir de una secuencia
                // de campos identificados cada uno por una clase
                var notas = $('.notas').serializeArray();
                // serializo los campos clase  logro 1
                var logros1 = $('.logros1').serializeArray();
                // serializo los campos clase logro 2
                var logros2 = $('.logros2').serializeArray();
                // serializo los campos clase logro 3
                var logros3 = $('.logros3').serializeArray();
                // serializo los codigos
                var codigos = $('.codigos').serializeArray();
                // serializo las  faltas
                var faltas = $('.faltas').serializeArray();

                $.ajax({
                  type: "POST",
                  url: "notas.php",
                  data: {
                    year: $("#years").val(),
                    id_gs: $("#id_g").val(),
                    id_ms : $("#id_ms").val(),
                    id_jornada: $("#jornada").val(),
                    id_docente: $("#id_docentes").val(),
                    corte: $("#corte").val(),
                    periodo: $("#periodos").val(),
                    nota: JSON.stringify(notas),
                    logro1: JSON.stringify(logros1),
                    logro2: JSON.stringify(logros2),
                    logro3: JSON.stringify(logros3),
                    codigo: JSON.stringify(codigos),
                    faltas: JSON.stringify(faltas)
                  },

                  success: function(data) {
                    //$("#resultado").html("Se ingresaron las notas con exito");
                    $("#resultado").html(data);
                  },
                  error : function(xhr, status) {
                    swal('Disculpe, existió un problema');
                    console.log(xhr);
                  }
                });

                break;

                case '12':

                swal("Se van a regenerar las tablas");
                $('#resultado').load("registros.php",
                {
                  id_gs : $("#id_g").val()
                });


                break;

                default:

                $.ajax({
                  url: 'adiccion.php',
                  type: 'POST',
                  dataType: 'html',
                  data: {
                    add: $("#add option:selected").val(),
                    i_nombres: $("#i_nombres").val(),
                    apellidos: $("#apellidos").val(),
                    Logros: $("#Logros").val(),
                    years: $("#years").val().toString(),
                    id_g: $("#id_g").val(),
                    fechas: $("#fechas").val(),
                    cedulas: $("#cedulas").val(),
                    correos : $("#correos").val(),
                    telefonos : $("#telefonos").val(),
                    areas : $("#areas").val(),
                    fecha_fins : $("#fecha_fins").val(),
                    id_es:$("#id_es").val(),
                    logro_1:$("#logro_1").val(),
                    logro_2:$("#logro_2").val(),
                    logro_3:$("#logro_3").val(),
                    faltas : $("#faltas").val(),
                    estudiantes: $("#estudiantes").val(),
                    periodos: $("#periodos").val(),
                    id_ms : $("#id_ms").val(),
                    id_jornada: $("#jornada").val(),
                    docentes: $("#docentes").val()
                  },
                  beforeSend: function(){
                    console.log("enviando datos .. para adiccionar");
                  },

                  success : function(result) {
                    // en caso de que la funcion tenga exito
                    $('#resultado').html(result);
                  },
                  error : function(xhr, status) {
                    swal('Disculpe, existió un problema');
                  },
                  complete : function(xhr, status) {
                    swal('Petición realizada');
                  }
                });


                break;
              }


            } /// fin de la confirmacion de los datos

            else {
              $("#resultado").append("Los datos ingresados son incorrectos, verifique el formulario");
            }


          // +++++++


        } // si se retorna el boton insertar

        else {
          swal({ title:'Accion cancelada', icon: 'error',});
        }

        }); // fin de funcion

              // ++++
    } // fin de la funsion deposit





    </script>


    <div id="formulario" style=" margin: auto;max-width: 1200px;position: relative;">

      <!-- esta es la primera fila de la tabla -->


      <!-- esta es la primera fila de la tabla -->
      <div id=" encabezado" style="width: 100%" >
        <!-- primera columna de la fila -->

        <h1 class="texto_formulario"> FORMULARIO PARA LA GESTION DE CALIFICACIONES</h1>
        <br>

          <?php if($admin == 1) { ?>
            <a href="manual-plataforma.pdf" target="blank">tutorial </a><br>

          <?php } else { ?>
              <a href="manual-plataforma-docentes.pdf" target="blank">tutorial </a><br>
          <?php }?>

        <?php
        // se crea un campo input oculto que almacena el cÃ³digo del docente
        echo "<input type= 'hidden' id= 'id_docentes' name= 'id_docentes' value= '".$id_docente."' >"
        ?>
      </div>
      <p>Introduzca la acci&oacute;n requerida  del siguiente men&uacute;</p>

      <div class="parametros">


          <label class="etiqueta_formulario"> A&ntilde;o </label>
          <!-- Este campo muestra la variable ano la cual contiene por defecto el aÃ±o reciente -->
          <!-- se conecta a la base de datos y recupera los  valores introduccidos en la tabla de calificaciones -->
          <?php if($admin == 1) { ?>
            <input type="number" value="<?php echo date('Y');?>" id="years" name="years"
            min="2015" max="2100" step="1" required="required" class="campo_formulario" >

          <?php } else { ?>
            <input type="number" value="<?php echo date('Y');?>" id="years"
            name="years" min="2015" max="2100" step="1"
            required="required" readonly="readonly" class="campo_formulario">
          <?php } ?>

          <label class="etiqueta_formulario"> Jornada </label>
          <select id="jornada" placeholder="Seleccione la jornada" class="campo_formulario">
            <option value=1>Ma&ntilde;ana</option>
            <option value=2>Tarde</option>
          </select>

          <!-- en este campo se ubica  el periodo a tratar -->
          <label class="etiqueta_formulario"> Periodo </label>
          <select id='periodos' name="periodos" placeholder="seleccione el periodo" class="campo_formulario">
            <?php	if($admin) { ?>
              <option value=-1>Seleccione
              </option>
              <option value=1>1
              </option>
              <option value=2>2
              </option>
              <option value=3>3
              </option>
              <option value=4>4
              </option>
              <option value=5>Recuperacion
              </option>
            <?php } else {	?>
              <option value= "<?php echo $periodo_act ?>" > <? echo $periodo_act ?>
              </option>
              <?php if ($periodo_act == 4) {?>
                <option value=5>Recuperacion
                </option>
              <?php } ?>

            <?php } 	?>
          </select>

          <label class="etiqueta_formulario"> Corte </label>
          <select id="corte" class="campo_formulario">
            <option value=A>A</option>
            <option value=F>F</option>
          </select>


          <label class="etiqueta_formulario"> Grado </label>
          <!-- cuadro de dialogo -->

          <select id="id_g" name="id_gs"
          class="campo_formulario">
          <option value="-1">Seleccione</option>
          </select>

        <br><br>

      </div>

		<div class="estructura">
      <div id="consultar" class="menu_consultar" colspan="1">
        <!-- // se incerta un formulario para  adiccionar eliminar o editar  datos -->
        <form name="datos" id="datos" targer="_blanck"
        style="background-color: white;padding: 21px;">

        <label style="margin-left: 20px;">Consultar</label><br><br>
        <!-- este es un select esta asociado al proceso de de adiccionar-->
        <select style=" width: auto; margin-left: 20px;"
        name="opcion" id="opcion" class="caja"
        onchange="consultar_display();">

        <option value="-1">Seleccione
        </option>
        <option value="1">Estudiantes
        </option>
        <option value="2">Docentes
        </option>
        <option value="3">Materias
        </option>
        <option value="4">Áreas
        </option>
        <option value="5">Logros
        </option>
        <?php	if($admin) { ?>
          <option value="6">Boletin
          </option>
          <option value="16">Certificado
          </option>
        <?php } ?>
        <option value="7">Matricula Alumnos
        </option>
        <?php	if($admin) { ?>
          <option value="8">Matricula Docentes
          </option>
          <option value="9">Requisitos Materia
          </option>
          <option value="10">Evalucion
          </option>
        <?php } ?>
        <option value="12">Nota
        </option>
        <option value="13">Registros por grado
        </option>
        <option value="14">Registros por docente
        </option>
        <option value="15">Registros por alumno
        </option>
        <!-- Esta es la opcion permite configurar las notas realizadas -->
      </select>
      <br><br>

      <fieldset id="nombre_con" class="filas_formulario"
      style="display: none;" placeholder="digite el nombre o parte del nombre">
      <!--  etiqueta para colocar la caja de texto donde se ubica el nombre -->
      Nombre:
      <input id="i_nombres_con" name="i_nombres" type="text" onkeydown="campo_nombre();">
    </fieldset>

    <fieldset id="apellido_con" class="filas_formulario" style="display: none;" onkeydown="campo_nombre();">
      <!-- se genera un campo insertar el apellido -->
      Apellido:
      <input id="apellidos_con" name="apellidos" type="text">
    </fieldset>
    <fieldset id="estudiante_con" class="filas_formulario" style="display: none;">
      <!-- Se ingresa  un campo para seleccionar  un estudiante --> Estudiante :
      <select id="estudiantes_con" name="estudiantes"
      style="width: 50px;background-color: transparent;border: none;">
      <option value="-1">Seleccione
      </option>
    </select>
  </fieldset>

  <fieldset id="id_a_con" class="filas_formulario" style="display: none;">Id Area:
    <input id="id_as_con" name="id_as" type="text">
  </fieldset>

  <fieldset id="id_m_con" class="filas_formulario" style="display: none;">
    Materia:
    <select id="id_ms_con" name="id_ms"
    style="background-color: transparent;border: none;"
    onchange="consultar();">
    <option value="-1">Seleccione
    </option>
    </select>
  </fieldset>

  <!-- contien los campos para  editar los contenidos de los logros -->
  <fieldset id="Logro_con" class="filas_formulario" style="display: block;">
    Logro:
    <textarea rows="4" cols="90" id="Logros_con"
    name="Logros" style="width: 80%;"
    onkeyup="consultar();">
    </textarea>
  </fieldset>



<!-- boton para cargar datos -->
<input style="background-color: darkgray; width:100%;
height: 50px; border: #000 1px solid; margin-top: 20px;"
type='button' value='CARGAR' id="cargar" onclick="consultar();">

<!-- boton creado para crear el pdf -->
<input  style="background-color: #1E80FF; width:100%;
height: 50px; border: #000 1px solid"
type='button' value='TIPO PRIMARIA' id="generar" onclick="crear_pdf();">

<!-- genera boletin  de primaria  -->
<input style="background-color: #1E40FF; width:100%;
height: 50px; border: #000 1px solid"
type='button' value='TIPO PREESCOLAR' id="generarx"
onclick="obtener_pdf();">

<!-- genera voletines con el modelo de preescolar -->
<input style="background-color: #21FFA0; width:100%;
height: 50px; border: #000 1px solid; margin-top: 20px;"
type='button' value='GRAFICAR' id="graficar" onclick="grafica();">

</form>


<div   id="resultado_con" style="width: 99%;margin-top: 20px;margin-left: auto;">

</div>

<div   id="grafo" style="width: 800px; height: 400px">
</div>

</div>

		<!--------------------------------------------------------->
		<!--------------- div ADICIONAR -------------------------->
		<!--  estos son los campos que constituyen el  segundo menu
		principal que es el menu adiccionar el cual se usa
		en la ediccion de nuevas notas de los estudiantes -->

		<div id="menu_adiccionar" class="menu_add" colspan="1">

  <!-- Formulario que contiene los campos del menu adicionar -->
  <form id="adiccionar" >

    <!-- boton que interactua  entre las funciones
    adiccionar y editar -->

    <input type="radio" name="menu"  id="add_radio"
    value="add" onclick="menu_adicionar();" >

    <label style="font-size: large;">Adiccionar</label>

    <input type="radio" name="menu"  id="edi_radio"
    style=" margin-left: 20px;" value="edi" onclick="menu_adicionar();" >

    <label id="edi_label" style="font-size: large;">Editar</label><br><br>

    <!-- selector que permite selecionar la funcion a adiccionar -->
    <select   style=" width:auto;" name='add' id="add" class="caja">
      <option value='-1'>Seleccione
      </option>
      <?php	if($admin) { ?>
        <option value='1'>Estudiantes
        </option>
        <option value='2'>Docentes
        </option>
        <option value='3'>Materias
        </option>
        <option value='4'>&Aacute;reas
        </option>
        <option value='5'>Logros
        </option>
        <option value='7'>Matricula Alumnos
        </option>
        <option value='8'>Matricula Docentes
        </option>
        <option value='9'>Requisitos Materia
        </option>
      <?php } ?>

      <option value='11'>Nota
      </option>
      <?php	if($admin) { ?>

        <option value='12'>Registos
        </option>
      <?php } ?>
      <!-- Esta es la opcion permite configurar las notas realizadas -->
    </select>

    <br>

    <!-- Selector que permite seleccionar las distintas
    opciones a editar-->
    <select style="width: 260px" name="ed" id="edi" onchange="edit_display();">
      <option value='-1'>Seleccione
      </option>
      <?php	if($admin) { ?>
        <option value='1'>Estudiantes
        </option>
        <option value='2'>Docentes
        </option>
        <option value='5'>Logros
        </option>
        <option value='12'>Periodos
        </option>
      <?php } ?>
      <!-- Esta es la opcion permite configurar las notas realizadas -->
    </select>
    <br>
    <div id="mensaje_error" class="errores"> </div>
    <fieldset id="id_l" class="filas_formulario">
      C&oacute;digo:
      <!-- Fila en la que se ingresan los docentes -->
      <input type="text" name="id_ls" id="id_ls" onblur="actualizar_logro();">
    </fieldset>

    <fieldset id="id_e" class="filas_formulario">
      C&oacute;digo:
      <!-- Fila en la que se ingresan los docentes -->
      <input type="text" name="id_es" id="id_es" onblur="actualizar_nombre()">
    </fieldset>

    <fieldset id="id_d" class="filas_formulario">
      C&oacute;digo:
      <!-- Fila en la que se ingresan los docentes -->
      <input type="text" name="id_ds" id="id_ds" >
    </fieldset>

    <fieldset id="docente"  class="filas_formulario">
      Docente:
      <!-- Fila en la que se ingresan los docentes -->
      <select id="docentes" name="docentes" >
        <option value='-1'>Seleccione
        </option>
      </select>
    </fieldset>

    <fieldset id="nombre" class="filas_formulario">
      <!--  etiqueta para colocar la caja de texto donde se ubica el nombre -->
      Nombre:
      <input type="text"  id ='i_nombres' name="i_nombres" class="campo">

    </fieldset>

    <fieldset id="apellido" class="filas_formulario" >
      <!-- se genera un campo insertar el apellido -->
      Apellido:
      <input type='text' id ='apellidos' name="apellidos" class="campo">

    </fieldset>

    <fieldset  id="estudiante" class="filas_formulario">
      <!-- Se ingresa  un campo para seleccionar  un estudiante --> Estudiante :
      <select id="estudiantes" name="estudiantes"  >
        <option value='-1'>Seleccione
        </option>
      </select>
    </fieldset>

    <fieldset id="fecha" class="filas_formulario">
      <!-- campo donde se ingresa la fecha  de nacimiento del estudiante -->
      Nacimiento:
      <input type="date" min="1950-01-01"
      max="2050-01-01" id="fechas" name ="fechas" class="campo" >
      (yyyy/mm/dd)
    </fieldset>

    <fieldset id="telefono" class="filas_formulario">
      <!-- En este campo se ingresa  el  numero telefonico -->	Telefono:
      <input type='tel'  id ='telefonos' name="telefonos" class="campo">
    </fieldset>

    <fieldset id="correo" class="filas_formulario">
      <!-- en este campo se ingresa el telefono del estudiante --> Correo:
      <input type='email'   id ='correos' name="correos" class="campo">
    </fieldset>

    <fieldset id="cedula" class="filas_formulario"> Cedula:
      <input type='text'  id ='cedulas' name="cedulas" class="campo">
    </fieldset>


    <fieldset id="area" class="filas_formulario">
      <!-- se genera un campo   para la creacion
      de las materias atendidas por docente -->
      Materias:
      <input  type="text" size="50" id ='areas' name="areas"
      style="width: 60%;" class="campo">
    </fieldset>

    <fieldset id="id_m" class="filas_formulario">
      Materia:
      <select id="id_ms" name="id_ms" >
        <option value='-1'>Seleccione
        </option>
      </select>
    </fieldset>

    <fieldset id="id_a" class="filas_formulario">Id Area:
      <input type='text'  id ='id_as' name="id_as" class="campo">
    </fieldset>

    <fieldset id="Logro" class="filas_formulario">
      Logro:
      <textarea rows="2" cols="90" id="Logros" name="logros"
      style="width: 80%;" class="campo">
    </textarea>

  </fieldset>


  <fieldset id="fecha_fin" class="filas_formulario">
    <!-- En este campo se ingresa la fecha de fin del curso -->
    Finalizacion :
    <input type='date' min="1950-01-01" max="2050-01-01"
    id='fecha_fins' name="fecha_fins" class="campo" >
    <label>(mm/dd/yyyy)
    </label>
  </fieldset>

  <fieldset id="logro_1" class="filas_formulario">
    <!--  etiqueta para colocar la caja de texto donde se ubica el nombre -->
    Logro 1:
    <input type="text"  id ='logro_1' name="logro_1"
    required="required"  class="campo">
    <select name="logro_1x" id="logro_1x">
      <option value='-1'>Seleccione
      </option>
    </select>
  </fieldset>

  <fieldset id="logro_2" class="filas_formulario">
    <!--  etiqueta para colocar la caja de texto donde se ubica el nombre -->
    Logro 2:
    <input type="text"  id ='logro_2' name="logro_2" class="campo">
    <select name="logro_2x" id="logro_2x">
      <option value='-1'>Seleccione
      </option>
    </select>
  </fieldset>

  <fieldset id="logro_3" class="filas_formulario">
    <!--  etiqueta para colocar la caja de texto donde se ubica el nombre -->
    Logro 3:
    <input type="text"  id ='logro_3' name="logro_3" class="campo">
    <select name="logro_3x" id="logro_3x">
      <option value='-1'>Seleccione
      </option>
    </select>
  </fieldset>



  <input style="background-color: darkgray; width:100%;
  height: 50px;  border: #000 1px solid; margin-top: 20px;"
  type='button' value='INGRESAR' id="ingresar"  onclick="deposit();">

  <input style="background-color: #FF8000; width:100%;
  height: 50px;  border: #000 1px solid; margin-top: 20px;"
  type='button' value='ACTUALIZAR' id="actualizar"  onclick="upgrade();">

</form>
<div   id="resultado">
</div>
<div   id="calificador">
</div>
</div>
		</div>
</div>


</body>
</html>
