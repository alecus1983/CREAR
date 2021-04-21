<?php session_start();
//validamos si se ha hecho o no el inicio de sesion correctamente
//si no se ha hecho la sesion nos regresarÃ¡ a login.php

include_once 'conexion.php';

if (!isset($_SESSION['usuario'])) {
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
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>NOTAS</title>
  <!-- en este codigo se definen los archivos de javascrip que se adjuntaran -->
  <script type="text/javascript" src="../JS/popper.min.js"></script>
  <script type="text/javascript" src="../JS/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="../JS/bootstrap.bundle.js"></script>
  <!-- <script type="text/javascript" src="lib/jquery.js"></script> -->
  <!-- <script type="text/javascript" src="ajax.js"></script> -->
  <script type="text/javascript" src="../JS/mostrar.js"></script>
  <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
  
  <script src="../JS/jquery-3.5.1.min.js"></script>
  <script src="../JS/sweetalert.min.js"></script>
  <script src="../JS/bootstrap.min.js"></script>
  <script src="../JS/ajax.js"></script>
  <script src="../JS/bootstrap-table.min.js" type="text/javascript"></script>
  <link href="../CSS/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/template.css" rel="stylesheet" type="text/css" />
  <!-- <link href="../CSS/fa-v4-shims.css" rel="stylesheet" type="text/css" /> -->
  <link href="../CSS/default.css" rel="stylesheet" type="text/css" />
  <link href="../JS/datatables.min.js" rel="stylesheet" type="text/css" />
  <link href="../CSS/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="../CSS/all.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="../CSS/style.css" type="text/css">
  <link rel="stylesheet" href="../CSS/estilos.css" type="text/css">
  <link href="../imagenes/escudo.gif" rel="shortcut icon"/>
  <script>
    //////////////////////////////////////////////////////////////////////////////////////////
    // Este script contiene la funcion para generar las graficas                            //
    // Esta foncion no recive parametros                                                    //
    //////////////////////////////////////////////////////////////////////////////////////////


    function grafica() {

      // se invoca al metodo ajax para solicitar el los datos del grafico
      $.ajax({
        type: "POST",
        url: "grafica_boletin.php",
        data: {
          year: $("#years").val(),
          id_gs: $("#id_g").val(),
          id_ms: $("#id_ms").val(),
          id_jornada: $("#jornada").val(),
          id_docente: $("#id_docentes").val(),
          corte: $("#corte").val(),
          periodo: $("#periodos").val(),
          opcion: $("#opcion").val()

        },
        // si los datos son correctos entonces ...
        success: function(respuesta) {

          $("#grafo").html(respuesta);

        },
        error: function(xhr, status) {
          swal('Disculpe, existió un problema');
          console.log(xhr);
        }
      });





    }
  </script>

  <!-- se definen los estilos para el contenido del formulario -->
  <!-- este scrip adicciona el cÃ³digo para crear el objeto XMLHTTPRequest de AJAX -->
</head>

<!-- a partir de aqui se establece el cuerpo del documento que se va ha mostrar en la pÃ¡gina -->

<body onload="ocultar_todo();">
  <div class="max-width">

    <div class="blog-header" style="display:felx">
      <!-- se establece la conexiÃ³n con la base de datos -->
      <div id="=usuario" class="encabezado_formulario">
        <?php
        //conexion con la base de datos
        $link = conectar();
        //var_dump($_SESSION);
        $usuario = $_SESSION['usuario'];
        // se almacena una variable tipo consulta
        $reg = mysqli_query($link, "select * from docentes where cedula ='" . $usuario . "'") or
          die("Problemas  encontrar el usuario:" . mysqli_error($link));


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
        echo  "Usuario : " . $nombre . " " . $apellido . " codigo (" . $_SESSION['code'] . ")<br>";
        ?>

      </div>

      <?php
      // trazo las condiciones iniciales para el formulario
      //  almaceno la fecha actual en la variable $hoy
      $hoy = Date("Y-m-d hh:mm");
      // realizo la consulta del preriodo actual cargado
      $reg = mysqli_query($link, "select * from limite") or
        die("Problemas  encontrar el usuario:" . mysqli_error($link));
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
          type: 'post',
          async: 'false',
          dataType: "json",
          error: function(jqXHR, textStatus, errorThrown) {
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
          beforeSend: function() {
            $("#resultado").html("Actualizando fecha, espere por favor...");
          },
          success: function(response) {
            //swal("Se actualizo con exito la fecha");
            var cadena = response;

            $("#fecha_entrega").html(
              "Periodo : " + cadena.periodo +
              "  Corte : " + cadena.corte +
              "  " + cadena.texto
            );
          }
        });

        actualizar_docente(<?php echo $_SESSION['code']; ?>);
      </script>

      <!-- Div que se encarga de mostrar la fecha de enrtrega de notas -->
      <div id="fecha_entrega" class="encabezado_formulario">

      </div>

      <div id="cerrar" class="cerrar">
        <?php
        // muestra  un enlace que permite cerrar la secciÃ³n
        echo "<a href='logout.php'>Cerrar Secci&oacute;n</a>";
        desconectar($link);
        ?>
      </div>

    </div>

    <!-- Div donde se ubica el boton de cierre de seccion -->
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

      function formulario_calificar() {
        // primeramente se validan los campos de texto y se muestran en el resultado
        var add = $("#add").val(); //  selector de para las funciones de adiccionar en el formulario
        var ano = $("#years").val(); // variable año en el formulario
        var jornada = $("select#jornada").val(); // variable jormana en el formulario
        var periodo = $("select#periodos").val(); // variable periodo en el formulario
        var corte = $("select#corte").val(); // variable corte en el formulario
        var grado = $("select#id_g").val(); // variable grado en el formulario
        var materia = $("select#id_ms").val(); //

        // Defino las condiciones iniciales del formulario, las cuales son:
        // borro el contenido de el div resultado
        $("#resultado").html("");
        // comienzo a validar las variables
        if (periodo == -1) {
          $("#resultado").append("<p style='color:red;'>Favor seleccione una periodo <p>");
        } else if (grado == -1) {
          $("#resultado").append("<p style='color:red;'>Favor seleccione un grado <p>");
        } else if (materia == -1) {
          $("#resultado").append("<p style='color:red;'>Favor seleccione una materia <p>");
        } else {
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

      function ocultar_todo() {

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
        carga("#id_g", "grados.php", {
          id: $("#id_docentes").val()
        });
        // coloca la lista de materias en el campo  #id_ms_con
        carga("#id_ms_con", "materias.php", {
          id: $("#id_docentes").val()
        });
        // coloca la lista de materias  en el campo #id_ms
        carga("#id_ms", "materias.php", {
          id: $("#id_docentes").val()
        });
        // coloca la lista de docentes en el campo docentes
        carga("#docentes", "lista_docentes.php");

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

      function ocultar_add() {

        // coloco el combo de seleccion  en la posicion -1
        $('select#opcion').val('-1');
        // coloco el combo de aderir en la posicion -1
        $('select#add').val('-1');
        // coloco el combo editar en la posicion -1
        $('select#edi').val('-1');

        // configuro los elementos a mostrar de acuerdo a su
        // id utilizando los metodos de javascript
        document.getElementById("estudiante").style.display = 'none';
        document.getElementById("fecha_fin").style.display = 'none';
        document.getElementById("docente").style.display = 'none';
        document.getElementById("ingresar").style.display = 'none';
        document.getElementById("nombre").style.display = 'none';
        document.getElementById("apellido").style.display = 'none';
        document.getElementById("telefono").style.display = 'none';
        document.getElementById("fecha").style.display = 'none';
        document.getElementById("cedula").style.display = 'none';
        document.getElementById("area").style.display = 'none';
        document.getElementById("correo").style.display = 'none';
        document.getElementById("i_correo").style.display = 'none';
        document.getElementById("Logro").style.display = 'none';
        document.getElementById("id_m").style.display = 'none';
        document.getElementById("id_a").style.display = 'none';
        document.getElementById("generar").style.display = 'none';

        // utilizando los metodos de jquery
        $("#id_e").css("display", "none");
        $("#id_d").css("display", "none");
        $("#logro_1").css("display", "none");
        $("#logro_2").css("display", "none");
        $("#logro_3").css("display", "none");
        $("#id_l").css("display", "none");
        $("#graficar").css("display", "none");
        actualizar_docente(<?php echo $_SESSION['code']; ?>);
      }

      ////////////////////////////////////////////////////////////////////////////
      //                                                                        //
      // Esta funcion se encarga de ocultar los elementos del menu consultar    //
      //                                                                        //
      ////////////////////////////////////////////////////////////////////////////

      function ocultar_consultar() {

        document.getElementById("estudiante_con").style.display = 'none';
        document.getElementById("nombre_con").style.display = 'none';
        document.getElementById("apellido_con").style.display = 'none';
        document.getElementById("Logro_con").style.display = 'none';
        document.getElementById("id_m_con").style.display = 'none';
        document.getElementById("id_a_con").style.display = 'none';
        document.getElementById("generar").style.display = 'none';
        $("#graficar").css("display", "none");
        $("#cargar").css("display", "none");


      }

      //////////////////////////////////////////////////////////////
      //                                                          //
      //
      //                                                          //
      //////////////////////////////////////////////////////////////

      function ocultar_display() {

        //$('select#opcion').val('-1');
        $('select#add').val('-1');
        $('select#edi').val('-1');
        document.getElementById("estudiante").style.display = 'none';
        document.getElementById("fecha_fin").style.display = 'none';
        document.getElementById("docente").style.display = 'none';
        document.getElementById("ingresar").style.display = 'none';
        document.getElementById("nombre").style.display = 'none';
        document.getElementById("apellido").style.display = 'none';
        document.getElementById("telefono").style.display = 'none';
        document.getElementById("fecha").style.display = 'none';
        document.getElementById("cedula").style.display = 'none';
        document.getElementById("area").style.display = 'none';
        document.getElementById("correo").style.display = 'none';
        document.getElementById("i_correo").style.display = 'none';
        document.getElementById("Logro").style.display = 'none';
        document.getElementById("id_m").style.display = 'none';
        document.getElementById("id_a").style.display = 'none';
        document.getElementById("generar").style.display = 'none';
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

      function add_display() {

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
        document.getElementById("ingresar").style.display = 'block';
        // oculto el boton de actualizar
        document.getElementById("actualizar").style.display = 'none';


        // De acuerdo al valor seleccionado
        // Selecciono la opcion de preferencia

        switch (y) {


          case "1": // adiccionar estudiantes

            document.getElementById("estudiante").style.display = 'none';
            document.getElementById("fecha_fin").style.display = 'none';
            document.getElementById("docente").style.display = 'none';
            document.getElementById("nombre").style.display = 'block';
            document.getElementById("apellido").style.display = 'block';
            document.getElementById("telefono").style.display = 'block';
            document.getElementById("fecha").style.display = 'block';
            document.getElementById("cedula").style.display = 'block';
            document.getElementById("area").style.display = 'none';
            document.getElementById("correo").style.display = 'block';
            document.getElementById("i_correo").style.display = 'block';
            document.getElementById("Logro").style.display = 'none';
            document.getElementById("id_m").style.display = 'none';
            document.getElementById("id_a").style.display = 'none';
            document.getElementById("generar").style.display = 'none';
            $("#id_e").css("display", "none");
            $("#id_d").css("display", "none");
            $("#logro_1").css("display", "none");
            $("#logro_2").css("display", "none");
            $("#logro_3").css("display", "none");
            $("#id_l").css("display", "none");
            $("#graficar").css("display", "none");
            break;

          case "2": // Aderir Docentes

            document.getElementById("estudiante").style.display = 'none';
            document.getElementById("fecha_fin").style.display = 'none';
            document.getElementById("docente").style.display = 'none';
            document.getElementById("ingresar").style.display = 'block';
            document.getElementById("nombre").style.display = 'block';
            document.getElementById("apellido").style.display = 'block';
            document.getElementById("telefono").style.display = 'block';
            document.getElementById("fecha").style.display = 'block';
            document.getElementById("cedula").style.display = 'block';
            document.getElementById("area").style.display = 'block';
            document.getElementById("correo").style.display = 'block';
            document.getElementById("i_correo").style.display = 'block';
            document.getElementById("Logro").style.display = 'none';
            document.getElementById("id_m").style.display = 'none';
            document.getElementById("id_a").style.display = 'none';
            document.getElementById("generar").style.display = 'none';
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

            document.getElementById("estudiante").style.display = 'none';
            document.getElementById("fecha_fin").style.display = 'none';
            document.getElementById("docente").style.display = 'none';
            document.getElementById("ingresar").style.display = 'none';
            document.getElementById("cedula").style.display = 'none';
            document.getElementById("area").style.display = 'none';
            document.getElementById("correo").style.display = 'none';
            document.getElementById("i_correo").style.display = 'none';
            document.getElementById("nombre").style.display = 'none';
            document.getElementById("apellido").style.display = 'none';
            document.getElementById("telefono").style.display = 'none';
            document.getElementById("fecha").style.display = 'none';
            document.getElementById("Logro").style.display = 'none';
            document.getElementById("id_m").style.display = 'none';
            document.getElementById("id_a").style.display = 'none';
            document.getElementById("generar").style.display = 'none';

            document.getElementById("cargar").style.display = 'none';
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

            document.getElementById("estudiante").style.display = 'none';
            document.getElementById("fecha_fin").style.display = 'none';
            document.getElementById("docente").style.display = 'none';
            document.getElementById("ingresar").style.display = 'none';
            document.getElementById("cedula").style.display = 'none';
            document.getElementById("area").style.display = 'none';
            document.getElementById("correo").style.display = 'none';
            document.getElementById("i_correo").style.display = 'none';
            document.getElementById("nombre").style.display = 'none';
            document.getElementById("apellido").style.display = 'none';
            document.getElementById("telefono").style.display = 'none';
            document.getElementById("fecha").style.display = 'none';
            document.getElementById("Logro").style.display = 'none';
            document.getElementById("id_m").style.display = 'none';
            document.getElementById("id_a").style.display = 'none';
            document.getElementById("generar").style.display = 'none';
            document.getElementById("cargar").style.display = 'none';
            $("#id_e").css("display", "none");
            $("#id_d").css("display", "none");
            $("#logro_1").css("display", "none");
            $("#logro_2").css("display", "none");
            $("#logro_3").css("display", "none");
            $("#id_l").css("display", "none");
            $("#graficar").css("display", "none");
            break;

          case "5": // adiccionar logros

            document.getElementById("estudiante").style.display = 'none';
            document.getElementById("fecha_fin").style.display = 'none';
            document.getElementById("docente").style.display = 'none';
            document.getElementById("ingresar").style.display = 'block';
            document.getElementById("nombre").style.display = 'none';
            document.getElementById("apellido").style.display = 'none';
            document.getElementById("telefono").style.display = 'none';
            document.getElementById("fecha").style.display = 'none';
            document.getElementById("cedula").style.display = 'none';
            document.getElementById("area").style.display = 'none';
            document.getElementById("correo").style.display = 'none';
            document.getElementById("i_correo").style.display = 'none';
            document.getElementById("Logro").style.display = 'block';
            document.getElementById("id_m").style.display = 'block';
            document.getElementById("id_a").style.display = 'none';
            document.getElementById("generar").style.display = 'none';
            document.getElementById("cargar").style.display = 'none';
            $("#id_e").css("display", "none");
            $("#id_d").css("display", "none");
            $("#logro_1").css("display", "none");
            $("#logro_2").css("display", "none");
            $("#logro_3").css("display", "none");
            $("#id_l").css("display", "none");
            $("#graficar").css("display", "none");
            break;

          // case "6": // en este caso se editan los boletines

          //   document.getElementById("estudiante").style.display = 'none';
          //   document.getElementById("fecha_fin").style.display = 'none';
          //   document.getElementById("docente").style.display = 'none';
          //   document.getElementById("ingresar").style.display = 'none';
          //   document.getElementById("cedula").style.display = 'none';
          //   document.getElementById("area").style.display = 'none';
          //   document.getElementById("correo").style.display = 'none';
          //   document.getElementById("i_correo").style.display = 'none';
          //   document.getElementById("nombre").style.display = 'none';
          //   document.getElementById("apellido").style.display = 'none';
          //   document.getElementById("telefono").style.display = 'none';
          //   document.getElementById("fecha").style.display = 'none';
          //   document.getElementById("Logro").style.display = 'none';
          //   document.getElementById("id_m").style.display = 'none';
          //   document.getElementById("id_a").style.display = 'none';
          //   document.getElementById("generar").style.display = 'block';
          //   $("#id_e").css("display", "none");
          //   $("#id_d").css("display", "none");
          //   $("#logro_1").css("display", "none");
          //   $("#logro_2").css("display", "none");
          //   $("#logro_3").css("display", "none");
          //   $("#id_l").css("display", "none");
          //   $("#graficar").css("display", "none");
          //   break;

          case "7": // en este caso se editan los boletines

            document.getElementById("estudiante").style.display = 'none';
            document.getElementById("fecha_fin").style.display = 'none';
            document.getElementById("docente").style.display = 'none';
            document.getElementById("ingresar").style.display = 'block';
            document.getElementById("cedula").style.display = 'none';
            document.getElementById("area").style.display = 'none';
            document.getElementById("correo").style.display = 'none';
            document.getElementById("i_correo").style.display = 'none';
            document.getElementById("nombre").style.display = 'block';
            document.getElementById("apellido").style.display = 'block';
            document.getElementById("telefono").style.display = 'none';
            document.getElementById("fecha").style.display = 'none';
            document.getElementById("Logro").style.display = 'none';
            document.getElementById("id_m").style.display = 'none';
            document.getElementById("id_a").style.display = 'none';
            document.getElementById("generar").style.display = 'none';
            document.getElementById("cargar").style.display = 'none';
            $("#id_e").css("display", "block");
            $("#id_d").css("display", "none");
            $("#logro_1").css("display", "none");
            $("#logro_2").css("display", "none");
            $("#logro_3").css("display", "none");
            $("#id_l").css("display", "none");
            $("#graficar").css("display", "none");
            break;


          case "8": // Elementos a mostrar para la matricula del docente

            document.getElementById("estudiante").style.display = 'none';
            document.getElementById("fecha_fin").style.display = 'block';
            document.getElementById("docente").style.display = 'block';
            document.getElementById("ingresar").style.display = 'block';
            document.getElementById("cedula").style.display = 'none';
            document.getElementById("area").style.display = 'none';
            document.getElementById("correo").style.display = 'none';
            document.getElementById("i_correo").style.display = 'none';
            document.getElementById("nombre").style.display = 'none';
            document.getElementById("apellido").style.display = 'none';
            document.getElementById("telefono").style.display = 'none';
            document.getElementById("fecha").style.display = 'none';
            document.getElementById("Logro").style.display = 'none';
            document.getElementById("id_m").style.display = 'block';
            document.getElementById("id_a").style.display = 'none';
            document.getElementById("generar").style.display = 'none';
            document.getElementById("cargar").style.display = 'none';
            $("#id_e").css("display", "none");
            $("#id_d").css("display", "none");
            $("#logro_1").css("display", "none");
            $("#logro_2").css("display", "none");
            $("#logro_3").css("display", "none");

            $("#id_l").css("display", "none");
            $("#graficar").css("display", "none");
            break;

          case "9": // Elementos a mostrar para los requisitos de materia

            document.getElementById("estudiante").style.display = 'none';
            document.getElementById("fecha_fin").style.display = 'none';
            document.getElementById("docente").style.display = 'none';
            document.getElementById("ingresar").style.display = 'block';
            document.getElementById("nombre").style.display = 'none';
            document.getElementById("apellido").style.display = 'none';
            document.getElementById("telefono").style.display = 'none';
            document.getElementById("fecha").style.display = 'none';
            document.getElementById("cedula").style.display = 'none';
            document.getElementById("area").style.display = 'none';
            document.getElementById("correo").style.display = 'none';
            document.getElementById("i_correo").style.display = 'none';
            document.getElementById("Logro").style.display = 'none';
            document.getElementById("id_m").style.display = 'none';
            document.getElementById("id_a").style.display = 'none';
            document.getElementById("generar").style.display = 'none';
            document.getElementById("cargar").style.display = 'none';
            $("#id_e").css("display", "none");
            $("#id_d").css("display", "none");
            $("#logro_1").css("display", "none");
            $("#logro_2").css("display", "none");
            $("#logro_3").css("display", "none");

            $("#id_l").css("display", "none");
            $("#graficar").css("display", "none");
            break;



          case "11": // Elementos a mostrar para adiccionar notas

            document.getElementById("estudiante").style.display = 'none';
            document.getElementById("fecha_fin").style.display = 'none';
            document.getElementById("docente").style.display = 'none';
            document.getElementById("ingresar").style.display = 'block';
            document.getElementById("cedula").style.display = 'none';
            document.getElementById("area").style.display = 'none';
            document.getElementById("correo").style.display = 'none';
            document.getElementById("i_correo").style.display = 'none';
            document.getElementById("nombre").style.display = 'none';
            document.getElementById("apellido").style.display = 'none';
            document.getElementById("telefono").style.display = 'none';
            document.getElementById("fecha").style.display = 'none';
            document.getElementById("Logro").style.display = 'none';
            document.getElementById("id_m").style.display = 'block';
            document.getElementById("id_a").style.display = 'none';
            document.getElementById("generar").style.display = 'none';
            document.getElementById("cargar").style.display = 'none';
            $("#id_e").css("display", "none");
            $("#id_d").css("display", "none");
            $("#logro_1").css("display", "none");
            $("#logro_2").css("display", "none");
            $("#logro_3").css("display", "none");

            $("#id_l").css("display", "none");
            $("#graficar").css("display", "none");
            formulario_calificar(); // Ejecuta el formulario de calificaciones
            break;


          case "12": // Elementos a mostra para  completar los registros

            document.getElementById("estudiante").style.display = 'none';
            document.getElementById("fecha_fin").style.display = 'none';
            document.getElementById("docente").style.display = 'none';
            document.getElementById("ingresar").style.display = 'block';
            document.getElementById("cedula").style.display = 'none';
            document.getElementById("area").style.display = 'none';
            document.getElementById("correo").style.display = 'none';
            document.getElementById("i_correo").style.display = 'none';
            document.getElementById("nombre").style.display = 'none';
            document.getElementById("apellido").style.display = 'none';
            document.getElementById("telefono").style.display = 'none';
            document.getElementById("fecha").style.display = 'none';
            document.getElementById("Logro").style.display = 'none';
            document.getElementById("id_m").style.display = 'none';
            document.getElementById("id_a").style.display = 'none';
            document.getElementById("generar").style.display = 'none';
            document.getElementById("cargar").style.display = 'none';
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

          switch (add) {
            case "11":
              formulario_calificar();
              break;
          }
        });





        $("#periodos").change(function() {

          add = $('select#add').val(); // tomo el valor del cambio aderir

          switch (add) {

            case "11":
              formulario_calificar();

              break;
          }
        });

        $("#corte").change(function() {

          add = $('select#add').val(); // tomo el valor del cambio aderir

          switch (add) {
            case "11":
              formulario_calificar();
              break;
          }
        });



        $("#id_ms").change(function() {

          add = $('select#add').val(); // tomo el valor del cambio aderir

          switch (add) {
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
          switch (add) {
            case "11":
              carga("#id_ms", "materias_grado.php", {
                id: $("#id_docentes").val(),
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

          add_display(); // funcion que oculta los campos segun la opcion


          add = $('select#add').val(); // tomo el valor del cambio aderir

          switch (add) {
            case "1":
              $("#i_nombres").attr("readonly", false);
              $("#apellidos").attr("readonly", false);
              break;

            case "2":
              $("#i_nombres").attr("readonly", false);
              $("#apellidos").attr("readonly", false);
              break;
              // en el caso de los logros
            case "5":

              break;
              // caso de matricula alumnos
            case "7":
              carga("#id_gs", "grados.php", {
                id: $("#id").val()
              });
              //consultar();
              break;

            case '8':
              carga("#id_ms", "materias.php", {
                id: $("#id").val()
              });
              break;

            case "11":
              carga("#id_ms", "materias_grado.php", {
                id: $("#id_docentes").val(),
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

      function edit_display() {

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

        switch (y) {


          case "1": // caso editar estudiantes

            document.getElementById("estudiante").style.display = 'none';
            document.getElementById("fecha_fin").style.display = 'none';
            document.getElementById("docente").style.display = 'none';
            document.getElementById("nombre").style.display = 'block';
            document.getElementById("apellido").style.display = 'block';
            document.getElementById("telefono").style.display = 'block';
            document.getElementById("fecha").style.display = 'block';
            document.getElementById("cedula").style.display = 'block';
            document.getElementById("area").style.display = 'none';
            document.getElementById("correo").style.display = 'block';
            document.getElementById("i_correo").style.display = 'block';
            document.getElementById("Logro").style.display = 'none';
            document.getElementById("id_m").style.display = 'none';
            document.getElementById("id_a").style.display = 'none';
            document.getElementById("generar").style.display = 'none';
            $("#id_e").css("display", "block");
            $("#id_d").css("display", "none");
            $("#logro_1").css("display", "none");
            $("#logro_2").css("display", "none");
            $("#logro_3").css("display", "none");
            $("#id_l").css("display", "none");
            $("#graficar").css("display", "none");
            break;

          case "2": // caso editar docentes

            document.getElementById("estudiante").style.display = 'none';
            document.getElementById("fecha_fin").style.display = 'none';
            document.getElementById("docente").style.display = 'none';
            document.getElementById("nombre").style.display = 'block';
            document.getElementById("apellido").style.display = 'block';
            document.getElementById("telefono").style.display = 'block';
            document.getElementById("fecha").style.display = 'block';
            document.getElementById("cedula").style.display = 'block';
            document.getElementById("area").style.display = 'block';
            document.getElementById("correo").style.display = 'block';
            document.getElementById("i_correo").style.display = 'block';
            document.getElementById("Logro").style.display = 'none';
            document.getElementById("id_m").style.display = 'none';
            document.getElementById("id_a").style.display = 'none';
            document.getElementById("generar").style.display = 'none';

            $("#id_e").css("display", "none");
            $("#id_d").css("display", "block");
            $("#logro_1").css("display", "none");
            $("#logro_2").css("display", "none");
            $("#logro_3").css("display", "none");
            $("#id_l").css("display", "none");
            $("#graficar").css("display", "none");
            break;




          case "5": // caso editar logros

            document.getElementById("estudiante").style.display = 'none';
            document.getElementById("fecha_fin").style.display = 'none';
            document.getElementById("docente").style.display = 'none';
            document.getElementById("nombre").style.display = 'none';
            document.getElementById("apellido").style.display = 'none';
            document.getElementById("telefono").style.display = 'none';
            document.getElementById("fecha").style.display = 'none';
            document.getElementById("cedula").style.display = 'none';
            document.getElementById("area").style.display = 'none';
            document.getElementById("correo").style.display = 'none';
            document.getElementById("i_correo").style.display = 'none';
            document.getElementById("Logro").style.display = 'block';
            document.getElementById("id_m").style.display = 'none';
            document.getElementById("id_a").style.display = 'none';
            document.getElementById("generar").style.display = 'none';

            $("#id_e").css("display", "none");
            $("#id_d").css("display", "none");
            $("#logro_1").css("display", "none");
            $("#logro_2").css("display", "none");
            $("#logro_3").css("display", "none");
            $("#id_l").css("display", "block");
            $("#graficar").css("display", "none");
            break;



          case "12": // caso editar plazo de nota

            document.getElementById("estudiante").style.display = 'none';
            document.getElementById("fecha_fin").style.display = 'block';
            document.getElementById("docente").style.display = 'none';
            document.getElementById("cedula").style.display = 'none';
            document.getElementById("area").style.display = 'none';
            document.getElementById("correo").style.display = 'none';
            document.getElementById("i_correo").style.display = 'none';
            document.getElementById("nombre").style.display = 'none';
            document.getElementById("apellido").style.display = 'none';
            document.getElementById("telefono").style.display = 'none';
            document.getElementById("fecha").style.display = 'none';
            document.getElementById("Logro").style.display = 'none';
            document.getElementById("id_m").style.display = 'none';
            document.getElementById("id_a").style.display = 'none';
            document.getElementById("generar").style.display = 'none';

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


      function consultar_display() {

        // la variable x el valor de la caja desplegable actuar como insumo para indexar las acciones que correspondan a dicho item -->
        // cargo en la variable y la  el selector de consultar
        // es decir la opcion que selecciona el usuario
        var y = $("#opcion").val();

        // de acuerdo a la funcion que selecciona el  usuario
        //  se escogen que campos ocultar  y cuales mostrar
        // ocultar_display();
        ocultar_consultar();

        switch (y) {

          case "1": // consultar estudiantes
            document.getElementById("nombre_con").style.display = 'block'; // muestra este campo -->
            document.getElementById("apellido_con").style.display = 'block'; // muestra este campo -->
            document.getElementById("cargar").style.display = 'none'; // muestra este campo -->
            $("#cargar").css("display", "none"); // muestro el boton de consultar
            document.getElementById("grafo").style.display = 'none'; // espacio donde colocar la grafica
            break;

          case "2":
            document.getElementById("nombre_con").style.display = 'block';
            document.getElementById("apellido_con").style.display = 'block';
            document.getElementById("cargar").style.display = 'none';
            $("#cargar").css("display", "none"); // muestro el boton de consultar
            document.getElementById("grafo").style.display = 'none'; // espacio donde colocar la grafica
            break;

            // caso en donde consultar las materias existentes -->

          case "3":


            break;

            // caso  de consultar areas -->

          case "4":


            break;

            // en caso de los logros
          case "5":
            document.getElementById("id_m_con").style.display = 'block';
            document.getElementById("Logro_con").style.display = 'block';
            consultar();
            document.getElementById("grafo").style.display = 'none'; // espacio donde colocar la grafica
            //$("#cargar").css("display", "none"); // muestro el boton de consultar
            break;

          case "6": // en este caso se editan los boletines

            document.getElementById("generar").style.display = 'block';
            document.getElementById("grafo").style.display = 'none'; // espacio donde colocar la grafica

            break;

          case "7": // en este caso se editan la matricula de los alumnos



            break;


          case "8": // en caso de la matricula de los docentes



            break;


          case "9": // en caso de los requisitos de materia



            break;

          case "11": // corresponde a la nota vista por los docentes

            document.getElementById("id_m").style.display = 'block';

            $("#id_e").css("display", "none");
            $("#cargar").css("display", "none"); // muestro el boton de consultar
            document.getElementById("grafo").style.display = 'none'; // espacio donde colocar la grafica
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

            document.getElementById("generar").style.display = 'block';


            break;

        } // final del esxplorador de columnas

      } // final de consultar display

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
          console.log("Ha cambiado la opcion del selector a %s", op);
          // de acuerdo a la opcion seleccionada  procedo  a realizar el caso

          switch (op) {
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
              carga("#id_ms_con", "materias.php", {
                id: $("#id_docentes").val()
              });
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
              carga("#id_gs", "grados.php", {
                id: $("#id").val()
              });
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
        if (menu == "add") {
          $('#edi').css("display", "none");
          $('#add').css("display", "block");
          //$('#adiccionar').css("background-color", "blue");
          $('select#add').val('-1');
          ocultar_add();
          //add_display();
        } else {

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

      function carga(a, b, c) {

        console.log("Valor a: %s", a); // variable que almacena el codigo del campo
        console.log("Valor b: %s", b); // variable que almacena el nombre del archivo PHP
        console.log(JSON.stringify(c)); // parametro que se transmite  mediante ajax

        $.post("campos/" + b, c,
          function(dato) {
            $(a).empty();

            $(a).append("<option value = -1> Seleccione </option>");
            $.each(dato, function(index, materia) {
              $(a).append("<option value =" + index + ">" + materia + "</option>");

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

        if ($("#opcion option:selected").val() == "13") {
          // en caso de que la opcion se generar
          // un grafico de tendencias
          $("#resultado_con").html();
          grafica();
          
          // muestro en pantalla
          console.log("graficando");

        }
        // en caso de que no se consulte un grafico
        else {
          
          
          // borro el contenido del div grafo
          $("#grafo").html();
          // actualiza la tabla con los valrores
          // se llama al archivo seleccion.php el cual retorna
          // una tabla en formato html
          
          

          $('#resultado_con').load("seleccion.php", {

              opcion: $("#opcion option:selected").val(),
              i_nombres: $("#i_nombres_con").val(),
              apellidos: $("#apellidos_con").val(),
              Logros: $("#Logros_con").val(),
              years: $("#years").val().toString(),
              id_g: $("#id_g option:selected").val(),
              estudiantes: $("#estudiantes").val(),
              periodos: $("#periodos option:selected").val(),
              id_ms: $("#id_ms_con").val(),
              jornada: $("#jornada option:selected").val(),
              corte: $("#corte option:selected").val()

            },
            function() {

            });
        }

      }

      // funcion que actualiza el listado de los nombres de los estudiantes
      // o de los docentes

      function campo_nombre() {

        // se carga  en el combo  resultado_con la lista de los estudiantes
        // coincidentes con los criterios de busqueda.

        $('#resultado_con').load("seleccion.php", {
            opcion: $("#opcion option:selected").val(),
            i_nombres: $("#i_nombres_con").val(),
            apellidos: $("#apellidos_con").val(),
            Logros: $("#Logros_con").val(),
            years: $("#years").val().toString(),
            id_g: $("#id_g option:selected").val(),
            estudiantes: $("#estudiantes").val(),
            periodos: $("#periodos option:selected").val(),
            id_ms: $("#id_ms_con").val(),
            jornada: $("#jornada option:selected").val(),
            corte: $("#corte option:selected").val()

          },
          function() {

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
        var jornada = $("select#jornada").val(); // variable jormana en el formulario
        var periodo = $("select#periodos").val(); // variable periodo en el formulario
        var corte = $("select#corte").val(); // variable corte en el formulario
        var grado = $("select#id_g").val(); // variable gradp en el formulario
        var docente = $("select#docentes").val(); //
        var materia = $("select#id_ms").val(); //

        var validar = true;
        $("#resultado").html("");

        if (add == 1 || add == 2) {
          // validando nombre
          if (nombre == "") {
            $("#i_nombres").css("border-color", "red");
            validar = false;
          }
          //en otro caso, el mensaje no se muestra
          else {
            $("#i_nombres").css("border-color", "grey");
          }
          // validando apellido
          if (apellido == "") {
            $("#apellidos").css("border-color", "red");
            validar = false;
          }
          //en otro caso, el mensaje no se muestra
          else {
            $("#apellidos").css("border-color", "grey");
          }
          // validar fecha
          if (fecha == "") {
            $("#fechas").css("border-color", "red");
            validar = false;
          }
          //en otro caso, el mensaje no se muestra
          else {
            $("#fechas").css("border-color", "grey");
          }
          // telefono
          if (telefono == "" || isNaN(telefono)) {
            $("#telefonos").css("border-color", "red");
            validar = false;
          }
          //en otro caso, el mensaje no se muestra
          else {
            $("#telefonos").css("border-color", "grey");
          }
          // validar correo
          if (correo == "") {
            $("#correos").css("border-color", "red");
            validar = false;
          }
          //en otro caso, el mensaje no se muestra
          else {
            $("#correos").css("border-color", "grey");
          }

          // validar cedula
          if (cedula == "" || isNaN(cedula)) {
            $("#cedulas").css("border-color", "red");
            validar = false;
          }
          //en otro caso, el mensaje no se muestra
          else {
            $("#cedulas").css("border-color", "grey");
          }
        }
        // en caso de que las opciones sean
        else if (add == 7 || add == 9) {
          // datos de la jornada
          if (jornada == -1) {
            $("#resultado").append("<p style='color:red;'>Favor seleccione una jornada <p>");
            validar = false;
          }
          // datos del periodo
          if (periodo == -1) {
            $("#resultado").append("<p style='color:red;'>Favor seleccione un periodo <p>");
            validar = false;
          }
          // datos de corte
          if (corte == -1) {
            $("#resultado").append("<p style='color:red;'>Favor seleccione un corte <p>");
            validar = false;
          }
          // datos de grado
          if (grado == -1) {
            $("#resultado").append("<p style='color:red;'>Favor seleccione un grado <p>");
            validar = false;
          }
        } else if (add == 8) {
          // datos de la jornada
          if (jornada == -1) {
            $("#resultado").append("<p style='color:red;'>Favor seleccione una jornada <p>");
            validar = false;
          }

          // datos de grado
          if (grado == -1) {
            $("#resultado").append("<p style='color:red;'>Favor seleccione un grado <p>");
            validar = false;
          }
          // datos de grado
          if (materia == -1) {
            $("#resultado").append("<p style='color:red;'>Favor seleccione una materia <p>");
            validar = false;
          }

          // datos de grado
          if (docente == -1) {
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

        if (j == 7 || j == 8 || j == 9) {
          k = 2; // asigna tres logros
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
            if (this.checked == true) {

              // almaceno el id en la variable id_c el cual es el codigo del logro
              id_c = this.id;
              //
              if (k >= i) {

                switch (i) { // estructura para seleccionar los logros

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

                console.log("El valor de k es: " + k + ", el valor de i es :" + i + " y el id: " + id_c);

              }
            }

          });

          //  se muestra en consola los valores insertados en los campos logro 1, logro 2 y logro3
          console.log("Logro 1 : %s", $("#logro_1").val());
          console.log("Logro 2 : %s", $("#logro_2").val());
          console.log("Logro 3 : %s", $("#logro_3").val());

        }



        /// variable que representa cada item del menu aderir

        var datos = validar_add();
        if (datos) {


          // en esta seccion se incertan los registros
          // dentro de la base de datos , enviados a traves de
          // ajax

          console.log(" add = %i", $("#add").val());
          switch ($("#add").val()) {
            // caso de agregar notras
            case '11':

              swal({
                title: 'INSERTAR NOTAS',
                text: "Esta seguro que quiere insertar las notas!",
                icon: 'warning',
                buttons: true,
                buttons: ["cancelar", "insertar"],
              }).then((value) => {
                  if (value) {

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
                        id_ms: $("#id_ms").val(),
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
                      error: function(xhr, status) {
                        swal('Disculpe, existió un problema');
                        console.log(xhr);
                      }
                    });

                  } else {
                    swal({
                      title: 'Accion cancelada',
                      icon: 'error',
                    });
                  }
                } // si se retorna el boton insertar
              );

              break;

            case '12':

              if (validar_grado()) {
                // mensaje de aceptacion
                swal({
                  title: 'Agregar Registros',
                  text: "se van a agregar registros para el grado " + $("#id_g option:selected").text(),
                  icon: 'warning',
                  buttons: true,
                  buttons: ["cancelar", "insertar"],
                }).then((value) => {
                  if (value) {
                    // carga los registros  el la ventana de resultados
                    $('#resultado').load("registros.php", {
                        id_gs: $("#id_g").val(),
                        n_grado: $("#id_g option:selected").text()
                      }

                    );
                  }
                });
              }

              break;

            default:

              swal({
                title: 'CONFIRMAR',
                text: "Para confirmar la accion presione aceptar, de lo contrario presione cancelar",
                icon: 'warning',
                buttons: true,
                buttons: ["cancelar", "insertar"],
              }).then((value) => {
                if (value) {

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
                      correos: $("#correos").val(),
                      telefonos: $("#telefonos").val(),
                      areas: $("#areas").val(),
                      fecha_fins: $("#fecha_fins").val(),
                      id_es: $("#id_es").val(),
                      logro_1: $("#logro_1").val(),
                      logro_2: $("#logro_2").val(),
                      logro_3: $("#logro_3").val(),
                      faltas: $("#faltas").val(),
                      estudiantes: $("#estudiantes").val(),
                      periodos: $("#periodos").val(),
                      id_ms: $("#id_ms").val(),
                      id_jornada: $("#jornada").val(),
                      docentes: $("#docentes").val()
                    },
                    beforeSend: function() {
                      console.log("enviando datos .. para adiccionar");
                    },

                    success: function(result) {
                      // en caso de que la funcion tenga exito
                      $('#resultado').html(result);
                      // ejecuto la funcion para la cual  actualiza el formato de seleccion
                      //consultar();
                    },
                    error: function(xhr, status) {
                      swal('Disculpe, existió un problema');
                    },
                    complete: function(xhr, status) {
                      swal('Petición realizada');
                    }
                  });

                }
              });
              break;
          }
        } /// fin de la confirmacion de los datos
        else {
          $("#resultado").append("Los datos ingresados son incorrectos, verifique el formulario");
        }


        // fin de funcion

      } // fin de la funsion deposit

      // funcion para llamar boletines
      function boletin() {
        // almaceno el valor del grado
        grado = $("#id_g").val();

        if (grado == -1) {
          swal("Datos", "Por favor seleccione un grado", "info");
        } else if (grado < 7 || grado > 9) {
          // llama a la funcion generar para generar el boletin
          // que corresponde al modelo de primaria
          crear_pdf();
        } else {
          // llama a la funcion generarx la cual genera el boletin tipo preescolar
          obtener_pdf();
        }
      }

      // funcion que permite validar el campo grado retorna true si tiene
      // un valor valido
      function validar_grado() {
        var grado = $("#id_g").val();
        // si el grado es -1 es porque no se ha seleccionado
        if (grado == "-1") {
          swal("Datos", "Por favor seleccione un grado", "error");
          return false;
        } else {
          return true;
        }
      }

      // funcion que permite validar el campo grado retorna true si tiene
      // un valor valido
      function validar_periodo() {
        var grado = $("#periodos").val();
        // si el grado es -1 es porque no se ha seleccionado
        if (grado == "-1") {
          swal("Datos", "Por favor seleccione un periodo", "error");
          return false;
        } else {
          return true;
        }
      }

      function borrar(id, tabla) {

        swal({
          title: 'CONFIRMAR',
          text: "Va a eliminar un registro de la tabla " + tabla + " con codigo " + id,
          icon: 'warning',
          buttons: true,
          buttons: ["cancelar", "insertar"],
        }).then((value) => {
          if (value) {

            $.getJSON("delete.php", {
                "id": id,
                "tabla": tabla
              },
              function() {
                swal("se eliminaron  los datos correctamente");
              });
            consultar();
          }
        });
      }
    </script>

    <div id="formulario" style=" margin: auto;max-width: 1200px;">

      <!-- esta es la primera fila de la tabla -->
      <div id="encabezado"  style="display: grid; grid-template-columns: 15vw auto auto;">
        <!-- primera columna de la fila -->
        <div class="content_logo">
          <span id="imagen_logo" style="width: 60px; height: 60px;background-size: contain;"></span>

        </div>

        <div>
          <h1> <b>FORMULARIO</b> </h1>
          <h2>Para la Gesti&oacute;n de Calificaciones</h2>
        </div>
        
        <div></div>

        <?php if ($admin == 1) { ?>
          <!--<a href="manual-plataforma.pdf" target="blank">tutorial </a>--><br>
        <?php } else { ?>
          <a href="manual-plataforma-docentes.pdf" target="blank">tutorial </a><br>
        <?php } ?>
        <?php
        // se crea un campo input oculto que almacena el cÃ³digo del docente
        echo "<input type= 'hidden' id= 'id_docentes' name= 'id_docentes' value= '" . $id_docente . "' >"
        ?>


        <div class="container">
          <div class="row">
            <div class="col-md-3 col-sm-2">
              <div class="form-group">
                <label class="control-label"> A&ntilde;o </label>
                <!-- Este campo muestra la variable ano la cual contiene por defecto el aÃ±o reciente -->
                <!-- se conecta a la base de datos y recupera los  valores introduccidos en la tabla de calificaciones -->
                <?php if ($admin == 1) { ?>
                  <input type="number" value="<?php echo date('Y'); ?>" id="years" name="years" min="2015" max="2100" step="1" required="required" class="form-control form-control-sm tag_formulario">

                <?php } else { ?>
                  <input type="number" value="<?php echo date('Y'); ?>" id="years" name="years" min="2015" max="2100" step="1" required="required" readonly="readonly" class="form-control form-control-sm tag_formulario">
                <?php } ?>
              </div>

            </div>


            <div class="col-md-3 col-sm-2">
              <!-- en este campo se ubica  el periodo a tratar -->
              <label class="control-label"> Periodo </label>
              <select id='periodos' name="periodos" placeholder="seleccione el periodo" class="form-control form-control-sm tag_formulario" required>

                <?php if ($admin) { ?>
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
                <?php } else {  ?>
                  <option value="<?php echo $periodo_act ?>">
                    <? echo $periodo_act ?>
                  </option>
                  <?php if ($periodo_act == 4) { ?>
                    <option value=5>Recuperacion
                    </option>
                  <?php } ?>

                <?php }   ?>
              </select>
            </div>

            <div class="col-md-3 col-sm-2">
              <label class="control-label"> Corte </label>
              <select id="corte" class="form-control form-control-sm tag_formulario">
                <option value=A>A</option>
                <option value=F>F</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <br>

      <div class="container">
        <p>Seleccione el <span class="text-success">grado</span> y la <span class="text-success">jornada</span>:</p>

        <div class="row" style="margin-bottom: 20px;">
          <div class="col-md-2" style="margin-bottom: 20px;">
            <div class="form-group">
              <label class=""> Grado </label>
              <!-- cuadro de dialogo -->
              <select id="id_g" name="id_gs" class="form-control" required>
                <option value="-1">Seleccione ...</option>
              </select>
            </div>
          </div>

          <div class="col-md-2" style="margin-bottom: 20px;">
            <div class="form-group">
              <label class="control-label">Jornada </label>
              <select id="jornada" placeholder="Seleccione la jornada" class="form-control" required>
                <option value=1>Ma&ntilde;ana</option>
                <option value=2>Tarde</option>
              </select>
            </div>
          </div>
        </div>



        <div class="row ">
          <div class="card col-sm-12 col-md-6 col-lg-6  border border-primary rounded" style="padding:0px">
            <div id="consultar" class="card-body" style="padding: 0px;">
              <div class="card-header">
                <h5 class="card-title">Consultas</h5>
              </div>

              <div name="datos" id="datos" targer="_blanck" style="padding:10px;">
                <small class="text-muted">Para ejecutar una consulta de estudiantes,
                  docentes, materias, etc, favor seleccione una opcion en la
                  siguiente lista.</small>
                <br><br>

                <select name="opcion" id="opcion" class="form-select form-select-lg mb-3" onchange="consultar_display();">
                  <option value="-1" activate>Seleccione ...</a>
                  <option value="1">Estudiantes</a>
                  <option value="2">Docentes</a>
                  <option value="3">Materias</a>
                  <option value="4">Áreas</a>
                  <option value="5">Logros</a>
                    <?php if ($admin) { ?>
                  <option value="6">Boletin</a>
                  <option value="16">Certificado</a>
                  <?php } ?>
                  <option value="7">Matricula Alumnos</a>
                    <?php if ($admin) { ?>
                  <option value="8">Matricula Docentes</a>
                  <option value="9">Requisitos Materia</a>
                  <option value="10">Evalucion</a>
                  <?php } ?>
                  <option value="12">Nota</a>
                  <option value="13">Registros por grado</a>
                  <option value="14">Registros por docente</a>
                  <option value="15">Registros por alumno</a>
                </select>
                <hr>

                <div id="nombre_con" class="form-floating" style="display: none;" placeholder="digite el nombre o parte del nombre">
                  <!--  etiqueta para colocar la caja de texto donde se ubica el nombre -->
                  <input id="i_nombres_con" class="form-control" name="i_nombres" type="text" onkeydown="campo_nombre();">
                  <label from="id_nombres_con">Nombre</label>
                </div>

                <div id="apellido_con" class="form-floating" style="display: none;" onkeydown="campo_nombre();">
                  <!-- se genera un campo insertar el apellido -->
                  <input id="apellidos_con" class="form-control" name="apellidos" type="text">
                  <label from="apellidos_con">Apellido</label>
                </div>
                <div id="estudiante_con" class="form-floating" style="display: none;">
                  <!-- Se ingresa  un campo para seleccionar  un estudiante --> Estudiante :
                  <select class="form-select" id="estudiantes_con" name="estudiantes" style="width: 50px;background-color: transparent;border: none;">
                    <option value="-1">Seleccione
                    </option>
                  </select>
                  <label for="estudiantes_con">Codigo del estudiante</label>
                </div>

                <div id="id_a_con" class="form-floating" style="display: none;">
                  <input id="id_as_con" class="form-control" name="id_as" type="text">
                  <label form="id_as_con">Aarea</label>
                </div>

                <div id="id_m_con" class="form-floating" style="display: none;">

                  <select id="id_ms_con" name="id_ms" placeholder "seleccion de materias" class="form-control" onchange="consultar();">
                    <option value="-1">Seleccione
                    </option>
                  </select>
                  <label for="id_ms_con">Materia</label>
                </div>

                <!-- contien los campos para  editar los contenidos de los logros -->
                <div id="Logro_con" class="form-floating" style="margin-top:20px;">
                  <textarea id="Logros_con" class="form-control" name="Logros" onkeyup="consultar();">
                                                </textarea>
                  <label form="logros_con">Logro</label>
                </div>


                <!-- boton para cargar datos -->
                <button type='button' style="margin: auto;" value='CARGAR' class="btn btn-outline-primary" id="cargar" onclick="consultar();">
                  CARGAR
                </button>
                <!-- boton creado para crear el pdf -->
                <button type="button" style="margin: auto;" class="btn btn-outline-success" value='CREAR' id="generar" onclick="boletin();">
                  CREAR
                </button>



                <!-- genera voletines con el modelo de preescolar -->
                <button type='button' style="margin: auto;" class="btn btn-outline-info" value='GRAFICAR' id="graficar" onclick="grafica();">
                  GRAFICAR
                </button>

              </div>


              <div id="resultado_con" style="width: 99%;margin-top: 20px;margin-left: auto; padding-top:20x;">

              </div>
              <!-- aqui aparece el grafico a mostrar -->
              <div id="grafo" style="width: 100%; 
                        box-sizing: content-box;
                        height: 100%;">
              </div>

            </div>
          </div><!-- Fin de columna  -->


          <!--------------------------------------------------------->
          <!--------------- div ADICIONAR -------------------------->
          <!--  estos son los campos que constituyen el  segundo menu
                                        principal que es el menu adiccionar el cual se usa
                                        en la ediccion de nuevas notas de los estudiantes -->

          <div class="card col-lg-6 col-md-6 col-sm-12 border border-secondary rounded" style="padding:0px">
            <div class="card-header">
              <h5 class="card-title">Tareas</h5>
            </div>
            <div id="menu_adiccionar" class="card-body menu_add" colspan="1">

              <!-- Formulario que contiene los campos del menu adicionar -->
              <form id="adiccionar">

                <small class="text-muted">
                  En este men&uacute; aparecen las tareas a realizar, puede elegir entre
                  adiccionar y editar y luego la tarea a realizar en el men&uacute; tarea.
                </small>
                <br><br>
                <!-- boton que interactua  entre las funciones
                                              adiccionar y editar -->
                <div class="form-check">

                  <input type="radio" name="menu" id="add_radio" class="form-check-input" value="add" onclick="menu_adicionar();">

                  <label for="add_radio" style="font-size: large;" class="form-check-label">Adiccionar</label>
                </div>
                <div class="form-check">
                  <input type="radio" name="menu" id="edi_radio" class="form-check-input" value="edi" onclick="menu_adicionar();">

                  <label id="edi_label" style="font-size: large;" class="form-check-label">Editar</label>

                </div><br>

                <small class="text-muted">Tarea (adiccionar/editar)</small><br>

                <!-- selector que permite selecionar la funcion a adiccionar -->
                <select name='add' id="add" class="form-select">
                  <option value='-1'>Seleccione
                  </option>
                  <?php if ($admin) { ?>
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
                  <?php if ($admin) { ?>

                    <option value='12'>Registos
                    </option>
                  <?php } ?>
                  <!-- Esta es la opcion permite configurar las notas realizadas -->
                </select>


                <!-- Selector que permite seleccionar las distintas
                                              opciones a editar-->
                <select class="form-select" name="ed" id="edi" onchange="edit_display();">
                  <option value='-1'>Seleccione
                  </option>
                  <?php if ($admin) { ?>
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
                <!-- <div id="mensaje_error"
                                              class="alert alert-danger"
                                              style="background-color:transparent"
                                              role="alert">
                                            </div> -->
                <hr>
                <div id="id_l" class="form-floating">

                  <!-- Fila en la que se ingresan los docentes -->
                  <input type="text" class="form-control" name="id_ls" id="id_ls" onblur="actualizar_logro();">
                  <label for="id_ls">C&oacute;digo:</label>
                </div>

                <div id="id_e" class="form-floating mb-3">

                  <!-- Fila en la que se ingresan los docentes -->
                  <input type="text" name="id_es" class="form-control" id="id_es" onblur="actualizar_nombre()">
                  <label for="id_es">C&oacute;digo:</label>
                </div>

                <div id="id_d" class="form-floating">
                  <!-- Fila en la que se ingresan los docentes -->
                  <input type="text" name="id_ds" class="form-control" id="id_ds">
                  <label for="id_ds">C&oacute;digo:</label>
                </div>

                <div id="docente" class="form-floating">
                  <!-- Fila en la que se ingresan los docentes -->
                  <select id="docentes" name="docentes" class="form-select" aria-label="Floating label select example">
                    <option value='-1'>Seleccione
                    </option>
                  </select>
                  <label for="docentes">Docente</label>
                </div>

                <div id="nombre" class="form-floating">
                  <!--  etiqueta para colocar la caja de texto donde se ubica el nombre -->

                  <input type="text" id='i_nombres' name="i_nombres" class="form-control">
                  <label from="id_nombres">Nombre</label>
                </div>

                <div id="apellido" class="form-floating">
                  <!-- se genera un campo insertar el apellido -->
                  <input type='text' id='apellidos' name="apellidos" class="form-control">
                  <label from="apellidos">Apellidos</label>
                </div>

                <div id="estudiante" class="form-floating">
                  <!-- Se ingresa  un campo para seleccionar  un estudiante --> Estudiante :
                  <select id="estudiantes" name="estudiantes" class="form-control">
                    <option value='-1'>Seleccione
                    </option>
                    <label for="estudiantes">Estudiante</label>
                  </select>
                </div>

                <div id="fecha" class="form-floating">
                  <!-- campo donde se ingresa la fecha  de nacimiento del estudiante -->
                  <input type="date" min="1950-01-01" max="2050-01-01" id="fechas" name="fechas" class="form-control">

                  <label for="fechas">Nacimiento:(yyyy/mm/dd)</label>
                </div>

                <div id="telefono" class="form-floating">
                  <!-- En este campo se ingresa  el  numero telefonico -->
                  <input type='tel' id='telefonos' name="telefonos" class="form-control">
                  <label for="telefonos">Telefono</label>
                </div>

                <div id="correo" class="form-floating">
                  <!-- en este campo se ingresa el telefono del estudiante -->
                  <input type='email' id='correos' name="correos" class="form-control">
                  <label for="correos">Correo</label>
                </div>

                <div id="i_correo" class="form-floating">
                  <!-- en este campo se ingresa el telefono del estudiante -->
                  <input type='email' id='i_correos' name="i_correos" class="form-control">
                  <label for="i_correos">Correo institucional</label>
                </div>

                <div id="cedula" class="form-floating">
                  <input type='text' id='cedulas' name="cedulas" class="form-control">
                  <label for="cedulas">Cedula</label>
                </div>


                <div id="area" class="form-floating">
                  <!-- se genera un campo   para la creacion
                                              de las materias atendidas por docente -->
                  <input type="text" id='areas' name="areas" style="width: 100%;" class="form-control">
                  <label for="areas">Materias</label>
                </div>

                <br>

                <div id="id_m" class="form-floating">
                  <select id="id_ms" class="form-select" placeholder="seleccion de materias" name="id_ms">
                    <option value='-1'>Seleccione </option>
                  </select>
                  <label for="id_ms">Materia</label>
                </div>

                <div id="id_a" class="form-floating">
                  <input type='text' id='id_as' name="id_as" class="form-control">
                  <label>Id Area</label>
                </div>

                <div id="Logro" class="form-floating">
                  <textarea rows="2" cols="90" id="Logros" name="logros" style="width: 80%;" class="form-control">
                                              </textarea>
                  <label for="Logros">Logro</logro>

                </div>

                <div id="fecha_fin" class="form-floating">
                  <!-- En este campo se ingresa la fecha de fin del curso -->
                  <input type='date' min="1950-01-01" max="2050-01-01" id='fecha_fins' name="fecha_fins" class="form-control">
                  <label>Finalizacion(mm/dd/yyyy)
                  </label>
                </div>

                <div id="logro_1" class="form-floating">
                  <!--  etiqueta para colocar la caja de texto donde se ubica el nombre -->
                  Logro 1:
                  <input type="text" id='logro_1' name="logro_1" required="required" class="campo">
                  <select name="logro_1x" id="logro_1x">
                    <option value='-1'>Seleccione
                    </option>
                  </select>
                </div>

                <div id="logro_2" class="form-floating">
                  <!--  etiqueta para colocar la caja de texto donde se ubica el nombre -->
                  Logro 2:
                  <input type="text" id='logro_2' name="logro_2" class="campo">
                  <select name="logro_2x" id="logro_2x">
                    <option value='-1'>Seleccione
                    </option>
                  </select>
                </div>

                <div id="logro_3" class="form-floating">
                  <!--  etiqueta para colocar la caja de texto donde se ubica el nombre -->
                  Logro 3:
                  <input type="text" id='logro_3' name="logro_3" class="campo">
                  <select name="logro_3x" id="logro_3x">
                    <option value='-1'>Seleccione
                    </option>
                  </select>
                </div>

                <button type='button' style="margin: auto;margin-top: 20px;" class="btn btn-outline-success" value='INGRESAR' id="ingresar" onclick="deposit();">
                  Ingresar
                </button>

                <button type='button' style="margin: auto;" class="btn btn-outline-warning" value='ACTUALIZAR' id="actualizar" onclick="upgrade();">
                  Actualizar
                </button>

              </form>
              <div class="callout callout-info" id="resultado">
              </div>
              <div id="calificador">
              </div>
            </div>
          </div>

        </div>

      </div><!-- fin del container -->

    </div> <!-- fin del formulario -->

  </div>
  <!--fin de max-width -->

  <script src="../amcharts4/core.js"></script>
  <script src="../amcharts4/charts.js"></script>
  <script src="../amcharts4/themes/animated.js"></script>
  <script src="../amcharts4/plugins/timeline.js"></script>
  <script src="../amcharts4/plugins/bullets.js"></script>
</body>

</html>