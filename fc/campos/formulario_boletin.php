<?php
session_start();
//validamos si se ha hecho o no el inicio de sesion correctamente
//si no se ha hecho la sesion nos regresar谩 a login.php

include_once 'conexion.php';

if(!isset($_SESSION['usuario'])) 
{	
    //Sila secci贸n no esta iniciada entonces retorna a la pagina principal 	
    header('Location:login_boletines.php'); 
    //termina el programa php
    exit();
}
?>   

<!-- se define el tipo de documento html como HTML 5 -->        
    <!-- esta pagina consulta la base de datos con los diferentes elementos que la componen -->
    
<!DOCTYPE html>   
<!-- se establece la cabecera del documento --> 
    
<html  >	
  <!-- se definen las etiquetas del encabezado --> 	
  <head>	 		
    <title>Formulario
    </title>		 		
    <!-- en este codigo se definen los archivos de javascrip que se adjuntaran -->
    
    <script type="text/javascript" src="lib/jquery.js"></script>   		
    <script type="text/javascript" src="ajax.js"></script> 		
    <script type="text/javascript" src="mostrar.js"></script> 
    
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
    // Este script contiene la funcion para generar las graficas
      // Esta foncion no recive parametros
      function grafica(){
	  // se crean como primera instacia la variable que contiene el objeto grafico
	  var chart;
	  // Luego se cargan los  parametros de entrada que son el contenido de los campos
	  // years que contiene el a帽o
	  
	  var year = $("#years").val().toString();
	  // y periodo que contiene el periodo
	  var periodo = $("#periodos").val();
	  //cargo el estado del menu actual
	  var menu = $("#opcion").val();
	  // Se declara la variable chartData la cual recibe el dato tipo JSON proveniente de
	  // el archivo data.php ( el cual requiere los parametros  a帽o y periodo)
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
    
    <!-- este scrip adicciona el c贸digo para crear el objeto XMLHTTPRequest de AJAX -->					 	
  </head>	
  
  <!-- a partir de aqui se establece el cuerpo del documento que se va ha mostrar en la p谩gina -->
  <body onload="ocultar_todo();">
    
    <!-- -->
    <!-- amCharts javascript code -->
    
    
    <!-- en caso que no se admitan scrips dentro de la p谩gina -->
    <noscript>  			
      <!-- se muestra la etiqueta de parrafo con el siguiente contenido -->
      <p>Bienvenido a Mi Sitio
      </p>  		
    </noscript>	 		 
    
    <!-- se establece la conexi贸n con la base de datos -->
    
    
    <?php
      
      //conexion con la base de datos
      $link = conectar();
      $usuario = $_SESSION['usuario'];
      // se almacena una variable tipo consulta
      $reg=mysql_query("select * from docentes where cedula ='".$usuario."'" ,$link) or
          die("Problemas  encontrar el usuario:".mysql_error());
       
	
      //Validamos si el nombre del administrador existe en la base de datos o es correcto
       $row = mysql_fetch_array($reg);
      // se almacena el c贸digo del docente en la variable $id_docente
       $id_docente = $row['id_docente'];
      // se almacena el nombre del usuario 
      $nombre = $row['nombres'];
      // se almacena el apellido del usuario
      $apellido = $row['apellidos'];
      // se almacna en esta variable booleana que me indica si es administrador o no 
      $admin = $row['admin'];	
      // almacena el estado  de la variable $admin en la variable de secci贸n
      $_SESSION['admin'] = $admin;
      // almacena el c贸digo del docente  en la variable de secci贸n
      $_SESSION['code'] = $id_docente;		
      
      // muestra el nombre del usuario en pantalla
      echo	"Usuario : ".$nombre." ".$apellido." codigo (".$_SESSION['code'].")<br>";
      
      
      $hoy = Date("Y-m-d hh:mm");
      // realizo la consulta del preriodo actual cargado
      $reg=mysql_query("select * from limite" ,$link) or
          die("Problemas  encontrar el usuario:".mysql_error());
      // convierto la consulta en un arreglo
      $row = mysql_fetch_array($reg);		
      // almacena el periodo acual
       $periodo_act = $row['periodo'];
      // almacena el corte actual
      $corte_act = $row['corte'];
      // fecha limite de entrega
      $entrega = $row['fecha'];
      // muestro el periodo actual
      echo "Periodo : ".$periodo_act." corte : ".$corte_act;
       
      if($entrega >= $hoy) {  			
          $segundos=strtotime($entrega) - strtotime('now');
          $diferencia_dias=intval($segundos/60/60/24);
          //$fecha = $hoy->diff($entrega);
          echo "<font color='green'>, La fecha de entrega es:".$entrega." , restan ".$diferencia_dias." </font></b>";
      }  			
      else {
          echo "<font color='red'> Entrega de notas cerrada </font>";   			
      }
       // muestra  un enlace que permite cerrar la secci贸n
      echo "<br><a href='logout.php'>Cerrar Secci&oacute;n</a>";
      
      //echo "<br> Desde".$hoy." Hasta: ".$entrega;	
      desconectar($link);
    ?>   		 		
    
    <!-- se crea la tabla principal para alvergar la tabla -->
    
    <script type="text/javascript">
    function ocultar_todo()
      {
	  
	  // coloca el selector de opcion en chequeado
	  $("#add_radio").attr('checked', 'checked');
	  // oculto el elemento selector edi el cual selecciona
	  // las opciones para editar   
	  $('#edi').css("display", "none");
	  // muestro el elemento selector add la cual selecciona las 
	  // opciones para adiccionar
	  $('#add').css("display", "block");
	  
	  ocultar_add();
	  ocultar_consultar();
	  carga("#id_g","grados.php",{ id : $("#id").val()});
	  carga("#id_ms_con","materias.php",{ id : $("#id").val()});
	  carga("#docentes","docentes.php",{ id : $("#id").val()});
      }
      
      function ocultar_add(){
	  
	  $('select#opcion').val('-1');
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
	  $("#nota").css("display", "none");	
	  $("#id_l").css("display", "none");
	  $("#graficar").css("display", "none");
      }

      // esta funcion se encarga de ocultar los elementos del menu consultar

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
	  
	  
      }
      
      
      
      
      
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
	  $("#nota").css("display", "none");	
	  $("#id_l").css("display", "none");
	  $("#graficar").css("display", "none");
      }
      
      
      function add_display () {
	  
	  // la variable x el valor de la caja desplegable actuar como insumo para indexar las acciones que correspondan a dicho item -->
	  
	  $('select#edi').val('-1');
	  $('#calificador').html("");
	  var y = document.getElementById('add').value;
	  
	  switch(y) {
	      
	  case "1":	// adiccionar estudiantes
	      
	      document.getElementById("estudiante").style.display='none';
	      document.getElementById("fecha_fin").style.display='none';
	      document.getElementById("docente").style.display='none';
	      document.getElementById("ingresar").style.display='block';
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
	      $("#nota").css("display", "none");
	      $("#id_l").css("display", "none");
	      $("#graficar").css("display", "none");
	      break;
	      
	  case "2":
	      
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
	      $("#nota").css("display", "none");
	      $("#id_l").css("display", "none");
	      $("#graficar").css("display", "none");
	      break;
	      
	      // caso en donde consultar las materias existentes -->
	      
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
	      $("#nota").css("display", "none");
	      $("#id_l").css("display", "none");
	      $("#graficar").css("display", "none");
	      break;
	      
	      // caso  de consultar areas -->
	      
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
	      $("#nota").css("display", "none");
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
	      $("#nota").css("display", "none");
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
	      $("#nota").css("display", "none");
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
	      $("#nota").css("display", "none");
	      $("#id_l").css("display", "none");
	      $("#graficar").css("display", "none");
	      break;
	      
	
	  case "8":
	
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
	      document.getElementById("id_m").style.display='none';
	      document.getElementById("id_a").style.display='none';
	      
	      
	      
	      document.getElementById("generar").style.display='none';
	      document.getElementById("generarx").style.display='none';
	      $("#id_e").css("display", "none");
	      $("#id_d").css("display", "none");
	      $("#logro_1").css("display", "none");
	      $("#logro_2").css("display", "none");
	      $("#logro_3").css("display", "none");
	      $("#nota").css("display", "none");
	      $("#id_l").css("display", "none");
	      $("#graficar").css("display", "none");
	      break;
				
	  case "9":
	
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
	      $("#nota").css("display", "none");
	      $("#id_l").css("display", "none");
	      $("#graficar").css("display", "none");
	      break;
	      
	      
	      
	  case "11":
	      
	      document.getElementById("estudiante").style.display='block';
	      
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
	      $("#nota").css("display", "block");
	      $("#id_l").css("display", "none");
	      $("#graficar").css("display", "none");
	      break;
        
        
	  case "12":	// en este caso se editan los boletines
	      
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
	      $("#nota").css("display", "none");
	      $("#id_l").css("display", "none");
	      $("#graficar").css("display", "none");
	      break;
	      
	
	  }
    
	  
	  
      }
      
      $(document).ready(function() {
	  
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
		  // en el caso de los logros
	      case "5":
		  carga("#id_ms","materias.php",{ id : $("#id").val()});
		  //consultar();
		  break;
		  // caso de matricula alumnos
		case "7":
		  carga("#id_gs","grados.php",{ id : $("#id").val()});
	    	//consultar();
		  break;
		  
		  // en caso de
	      case "8":
		 
		 
		  
		  break;		
		  
	      case "9":
		 
		  
		  break;
	    
		  
	      case "11":
		  carga("#grados","grados.php",{ id : $("#id").val()});
		  $("#grados").val("-1");
		  $("#estudiantes").val("-1");
		  $("#id_ms").val("-1");
		  
		  break;
		  
	      case "12":
		  carga("#id_gs","grados.php",0);
		  $("#id_gs").val("-1");
		  $("#estudiantes").val("-1");
		  break;
     	    
		  
		  
	      default:
		  //consultar();
		  
		  break;
		  
		  
	      }
	      
	      
	  });
      });
      
      
      function edit_display(){
	  
	  // la variable x el valor de la caja desplegable actuar como insumo para indexar las acciones que correspondan a dicho item -->
	  
	  
	  $('select#add').val('-1');
	  $('#calificador').html("");
	  
	  var y = $('#edi').val();
	  
	  switch(y) {
	      
	  case "1":	// adiccionar estudiantes
	      
	      document.getElementById("estudiante").style.display='none';
	      
	      document.getElementById("fecha_fin").style.display='none';
	      document.getElementById("docente").style.display='none';
	      document.getElementById("ingresar").style.display='none';
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
	      $("#nota").css("display", "none");
	      $("#id_l").css("display", "none");
	      $("#graficar").css("display", "none");
	      break;
	      
	  case "2":
	
	      document.getElementById("estudiante").style.display='none';
	
	      document.getElementById("fecha_fin").style.display='none';
	      document.getElementById("docente").style.display='none';
	      document.getElementById("ingresar").style.display='none';
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
	      $("#nota").css("display", "none");
	      $("#id_l").css("display", "none");
	      $("#graficar").css("display", "none");
	      break;
				
	      // caso en donde consultar las materias existentes -->
	      
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
	      $("#nota").css("display", "none");
	      $("#id_l").css("display", "none");
	      $("#graficar").css("display", "none");
	      break;
	      
	      // caso  de consultar areas -->
	      
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
	      $("#nota").css("display", "none");
	      $("#id_l").css("display", "none");
	      $("#graficar").css("display", "none");
	      break;
	      
	  case "5":	// adiccionar logros
	      
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
	      $("#nota").css("display", "none");
	      $("#id_l").css("display", "block");
	      $("#graficar").css("display", "none");
	      break;
	      
	  case "11":
	      
	      document.getElementById("estudiante").style.display='block';
	      
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
	      document.getElementById("id_m").style.display='block';
	      document.getElementById("id_a").style.display='none';
	      
	      
	      
	      document.getElementById("generar").style.display='none';
	      document.getElementById("generarx").style.display='none';
	      $("#id_e").css("display", "none");
	      $("#id_d").css("display", "none");
	      $("#logro_1").css("display", "none");
	      $("#logro_2").css("display", "none");
	      $("#logro_3").css("display", "none");
	      $("#nota").css("display", "block");
	      $("#id_l").css("display", "none");
	      $("#graficar").css("display", "none");
	      break;
	      
	      
	  case "12":
	      
	      document.getElementById("estudiante").style.display='none';
	      
	      document.getElementById("fecha_fin").style.display='block';
	      
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
	      $("#id_e").css("display", "none");
	      $("#id_d").css("display", "none");
	      $("#logro_1").css("display", "none");
	      $("#logro_2").css("display", "none");
	      $("#logro_3").css("display", "none");
	      $("#nota").css("display", "none");
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
	      document.getElementById("cargar").style.display='block'; 	// muestra este campo -->
	      break;
	      
	  case "2":
	      document.getElementById("nombre_con").style.display='block'; 
	      document.getElementById("apellido_con").style.display='block';
	      document.getElementById("cargar").style.display='block';
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
	      break;
	      
	      
	  case "12": // corresponde a la nota ingresada por el administrador de la p醙ina
	      
	      
	
	      break;
	      
	  case "13": // corresponde a la nota ingresada por el administrador de la p醙ina
	      
	      $("#graficar").css("display", "block");
	      break;
	      
	  case "14":
	      $("#graficar").css("display", "block");
	      
	      break;
	      
	  case "15":
	      $("#graficar").css("display", "block");
	      
	      break;
	      
	      
	  case "16":
	      // en caso de seleccionar un certificado
	      
	      document.getElementById("generar").style.display='block';
	      document.getElementById("generarx").style.display='block';
	      
	      break;

	  } // final del esxplorador de columnas	
    
      } 	// final de consultar display    
      
      $(document).ready(function(){
    
	  // cada vez que se cambia el valor del combo   de consulta
	  $("#opcion").change(function() {
	      
	      consultar_display();
	      op = $('select#opcion').val();
	      console.log("Ha cambiado la opcion del selector a %s",op);
	      switch(op) {
		  // en caso de que se seleccionan los estudiantes
	      case "1":
		  
		  consultar();
		  break;
		  // em casp de que seleccionen los docentes
	      case "2":
		  
	    		consultar();
		  break;
		  
	      case "5":
		  carga("#cursos","materias.php",{ id : $("#id").val()});
		  consultar();
		  break;			
		  
	      case "6":
		  carga("#id_gs","grados.php",0);
		  consultar();
		  break;
		  
	      case "7":
		  carga("#id_gs","grados.php",0);
		  consultar();
		  break;
		  
	      case "8":
		  carga("#id_gs","grados.php",0);
		  consultar();
		  break;
		  
	      case "9":
		  carga("#id_gs","grados.php",{ id : $("#id").val()});
		  consultar();
		  break;
		  
		  
	      case "11":
		  carga("#grados","grados.php",{ id : $("#id").val()});
		  $("#grados").val("-1");
		  $("#estudiantes").val("-1");
		  $("#id_ms").val("-1");			
		  
		  break;
		  
		  
	      case "12":
		  carga("#grados","grados.php",{ id : $("#id").val()});
		  $("#grados").val("-1");
		  $("#estudiantes").val("-1");
		  $("#id_ms").val("-1");			
		
		  break;
	    
	      case "16":
		  carga("#id_gs","grados.php",{ id : $("#id").val()});
		  consultar();
		  break;
            
	      default:
		  consultar();
		  break;
	      }
	      
	  });
      }); 
    
      function menu_adicionar(){
	  
	  var menu = $('input[name=menu]:checked').val();
	  alert(menu);
	  if (menu == "add"){
	      $('#edi').css("display", "none");
	      $('#add').css("display", "block");
	      $('select#add').val('-1');
	      ocultar_add();
				add_display();
	  }
	  else{
	      $('#add').css("display", "none");
	      $('#edi').css("display", "block");
	      $('select#edi').val('-1');
	      ocultar_add();
	  }
      }
      
    </script>

<script type="text/javascript">
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
    
    // esta funcion interroga a la base de datos para visualizar el contenido de sus tablas
// para lo cual toma el contenido de los selectores "consultar" (opcion) y  "adiccionar" (add)
// como criterios para  selecionar que consulta se va a ejecutar  en la base de datos
// a travez del archivo seleccion.php
// los dem醩 campos se envian  como informaci髇 para desarrollar las consultas.
 
function consultar(){
    
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
				 add: $("#add option:selected").val(), 
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
    var ano = $("#years").val(); // variable a駉 en el formulario
    var jornada = $("select#jornada").val() ; // variable jormana en el formulario
    var periodo = $("select#periodos").val(); // variable periodo en el formulario
    var corte =  $("select#corte").val();// variable corte en el formulario
    var grado =  $("select#id_g").val();// variable gradp en el formulario
    
    
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
    else if ( add == 7 || add == 8 || add == 9){
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
 	
 	// comienza con un algoritmo de validaci髇
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
	
	
	
    /////////
    var datos  = validar_add();
    if (datos) {
		
		if (confirm("ALERTA!! va a proceder a ingresar un  registro, para confirmar de  click en ACEPTAR\n de lo contrario de click en CANCELAR.") ) 
	{
  	/*
  	// funcion para validar los estudiantes
            var validar;
		if ($("#opcion").val() > 0 ) {
  	
  			validar =  check_estudiante ();
  	
  		}
  		else 
  			{ validar = true;}
  	
  	
  		if (validar) {*/
                // en esta seccion se incertan los registros
                // dentro de la base de datos , enviados a traves de
                // ajax
                console.log(" add = %i",$("#add").val());
                switch($("#add").val()){
                    
                    case '11':
                       $('#resultado').load("adiccion.php",
                       {
                         logro_1:$("#logro_1").val(),
                         logro_2:$("#logro_2").val(),
                         logro_3:$("#logro_3").val(),
                         nota:$("#notas").val(),
                         id_ds:$("#id_ds").val(),
                         faltas : $("#faltas").val(),
                         years: $("#years").val().toString(),
                         periodos: $("#periodos").val(),
                         grados: $("#grados").val(),
                         id_ms : $("#id_ms").val(),
                         add : $('select#add').val(),
                         estudiantes: $("#estudiantes").val(),
                         id_docentes :$("#id_docentes").val() 
                       },
                        function(){
                            console.log("Se ingresa la nota del alumno : %i", $("#estudiantes").val());
                            console.log("Nota : %i", $("#nota").val());
                            console.log("Faltas : %i", $("#faltas").val());
                         }
                               
                        );
                
                       $("#calificador").load("calificar.php", {"id_ms": id_m });
                       
                    break;
                    
                    case '12':
                        
                    alert("Se van a regenerar las tablas");
                    $('#resultado').load("registros.php",
                       {
                         id_gs : $("#id_g").val()
                       },
                        function(){
                            console.log("Se solicitan notas del grado : %i", $("#id_gs").val());
                        }
                    );
                    break;
                
                    default:
                    $('#resultado').load("adiccion.php",
                    { 
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
                        nota:$("#notas").val(),
                        faltas : $("#faltas").val(),
                        estudiantes: $("#estudiantes").val(),
                        periodos: $("#periodos").val(),
                        id_ms : $("#id_ms").val(),
                        id_jornada: $("#jornada").val()
                    },
                        function(){
                            console.log("Se ingresaron valores varios %s", $("#add").val());
                            //console.log("Faltas : %i", $("#faltas").val());
                        });
                        break;
                    }
                    
                    
  		}
        // Ingresa si se van a matricular un alumno
        // 
        // 7 -- Matricula alumno 
        // 9 -- Requisito de materia
        
      } 
		else {
		$("#resultado").append("Los datos ingresados son incorrectos, verifique el formulario");
	}
        
}
</script>
    

<div id="formulario" style=" /*! width: 900px; */margin: auto;max-width: 1200px;position: relative;">
  
  <!-- esta es la primera fila de la tabla --> 			
  
  
  <!-- esta es la primera fila de la tabla --> 			
  <div id=" encabezado" style="width: 100%" >
    <!-- primera columna de la fila -->			 				
    
    <h1> FORMULARIO PARA LA GESTION DE CALIFICACIONES</h1>						
    <?php
          // se crea un campo input oculto que almacena el c贸digo del docente
          echo "<input type= 'hidden' id= 'id_docentes' name= 'id_docentes' value= '".$id_docente."' >"
    ?>
    </div>
      		 			
  <div>
    <!-- -->				
    <p>Introduzca el  la acci&oacute;n requerida  del siguiente men&uacute;<p> <br><br>
    
    <label style=" margin-left: 0px;"> A&ntilde;o </label>
    <!-- Este campo muestra la variable ano la cual contiene por defecto el a帽o reciente --> 					
    <!-- se conecta a la base de datos y recupera los  valores introduccidos en la tabla de calificaciones --> 
    <? if($admin) { ?> 	 					
    <input type="number" value="<?php echo date('Y');?>" id="years" name="years"
	   min="2015" max="2100" step="1" required="required" style="width: 50px;" >
    
    <? } else { ?>					
    <input type="number" value="<?php echo date('Y');?>" id="years"
	   name="years" min="2015" max="2100" step="1"
	   required="required" readonly="readonly">					
    <? } ?>
    
    <label style="margin-left: 20px;"> Jornada </label>
    <select id="jornada" placeholder="Seleccione la jornada">
      <option value=1>Ma&ntilde;ana</option>
      <option value=2>Tarde</option>
    </select>
		
    <!-- en este campo se ubica  el periodo a tratar -->			
    <label style=" margin-left: 20px;"> Periodo </label>
    <select id='periodos' name="periodos" placeholder="seleccione el periodo" >	
      <?	if($admin) { ?> 			 							
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
      <? } else {	?>	
      <option value= "<? echo $periodo_act ?>" > <? echo $periodo_act ?>
      </option>
      <? if ($periodo_act == 4) {?>
      <option value=5>Recuperacion
      </option>
      <? } ?>
      
      <? } 	?>											 				
    </select>
		
    <label style=" margin-left: 20px;"> Corte </label>
    <select id="corte" >
      <option value=A>A</option>
      <option value=F>F</option>
    </select>
    
		
    <label style=" margin-left: 0px;"> Grado </label>
    <!-- cuadro de dialogo --> 						
    
    <select id="id_g" name="id_gs" style="display: inline;">							
      <option value="-1">Seleccione
      </option>							 						
    </select>					
    
    <br><br>
    
  </div>
  
  
  
  
  <div id="consultar" class="menu_consultar" colspan="1">						
    <!-- // se incerta un formulario para  adiccionar eliminar o editar  datos --> 				 		 	
    <form name="datos" id="datos" targer="_blanck" style="background-color: white;padding: 21px;">
      <br>
      <label style="margin-left: 20px;">Consultar</label><br><br>
      <!-- este es un select esta asociado al proceso de de adiccionar-->					
      <select style=" width: auto; margin-left: 20px;" name="opcion" id="opcion" class="caja" onchange="consultar_display();">						
	<option value="-1">Seleccione
	</option>						
	<option value="1">Estudiantes
	</option>						
	<option value="2">Docentes
	</option>						
	<option value="3">Materias
	</option>						
	<option value="4">羠eas
	</option>						
	<option value="5">Logros
	</option>						
	
        <option value="6">Boletin
        </option>								
	<option value="16">Certificado
        </option>						
	
	<option value="7">Matricula Alumnos
	</option>						
	
	<option value="8">Matricula Docentes
	</option>						
	<option value="9">Requisitos Materia
	</option>						
	<option value="10">Evalucion
	</option>						
	
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
	  
      <fieldset id="nombre_con" class="filas_formulario" style="display: none;" placeholder="digite el nombre o parte del nombre"> 
	<!--  etiqueta para colocar la caja de texto donde se ubica el nombre -->
	Nombre: 
	<input id="i_nombres_con" name="i_nombres" type="text">					
      </fieldset>
      
      <fieldset id="apellido_con" class="filas_formulario" style="display: none;">          
	<!-- se genera un campo insertar el apellido -->
	Apellido:	
	<input id="apellidos_con" name="apellidos" type="text">					
      </fieldset>		  
      <fieldset id="estudiante_con" class="filas_formulario" style="display: none;">  
	<!-- Se ingresa  un campo para seleccionar  un estudiante --> Estudiante :  						
	<select id="estudiantes_con" name="estudiantes">							
          <option value="-1">Seleccione
          </option>							 							                  	
	</select>					
      </fieldset>
      
      <fieldset id="id_a_con" class="filas_formulario" style="display: none;">Id Area: 					
	<input id="id_as_con" name="id_as" type="text">					
      </fieldset>	
      
      <fieldset id="id_m_con" class="filas_formulario" style="display: none;">
	Materia:			 						
	<select id="id_ms_con" name="id_ms">							
	  <option value="-1">Seleccione
	  </option>                  
	</select>					
      </fieldset>
      
      <fieldset id="Logro_con" class="filas_formulario" style="display: block;">
	Logro: 					
	<textarea rows="4" cols="90" id="Logros_con" name="Logros" style="width: 80%;">	    
	</textarea> 					
      </fieldset>
      
      
      
      <!-- boton para cargar datos -->						
      <input style="background-color: #1E90FF; width:100%;   height: 50px; border: #000 1px solid; margin-top: 20px;" 
	     type='button' value='CARGAR' id="cargar" onclick="consultar();">					
      <!-- boton creado para mostrar valores de busqueda -->					 						
      <input  style="background-color: #1E80FF; width:100%;  height: 50px; border: #000 1px solid"
	      type='button' value='TIPO PRIMARIA' id="generar" onclick="crear_pdf();">					
      <!-- genera boletin  de primaria  -->					 						
      <input style="background-color: #1E40FF; width:100%;  height: 50px; border: #000 1px solid"
	     type='button' value='TIPO PREESCOLAR' id="generarx" onclick="obtener_pdf();">					
      <!-- genera voletines con el modelo de preescolar -->
      <input style="background-color: #21FFA0; width:100%; height: 50px; border: #000 1px solid; margin-top: 20px;"
	     type='button' value='GRAFICAR' id="graficar" onclick="grafica();">
    </form>    
    
    
    <div   id="resultado_con" style="width: 99%;margin-top: 20px;margin-left: auto;">
	  
    </div>							
    
    <div   id="grafo" style="width: 800px; height: 400px"> 
    </div>
    
  </div>
  
  <!--------------------------------------------------------->
      <!--------------- div ADICIONAR -------------------------->
      
   	<div id="menu_adiccionar" class="menu_add" colspan="1">					
		<form id="adiccionar" >
			   	
	  
	  		<input type="radio" name="menu"  id="add_radio" value="add" onclick="menu_adicionar();" >
	   
	  		<label style="font-size: large;color: white;">Adiccionar</label>
	  
	  		<input type="radio" name="menu"  id="edi_radio" style=" margin-left: 20px;" value="edi" onclick="menu_adicionar();" >
	  		<label id="edi_label" style="font-size: large;">Editar</label><br><br>
	  
	  		<select   style=" width:auto;" name='add' id="add" class="caja">						
            <option value='-1'>Seleccione
            </option>						
            <?	if($admin) { ?>						
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
            <? } ?>	
	    		<? if(!$admin && $entrega > $hoy) { ?>					
            	<option	 value='11'>Nota
            	</option>
	    		<? } ?>	
            <?	if($admin) { ?>						
            	<option value='11'>Nota
            	</option>	
            	<option value='12'>Registos
            	</option>
	    		<? } ?>
          	<!-- Esta es la opcion permite configurar las notas realizadas -->					
			</select>
	 
	 		<br>
	 		
			<select style="width: 260px" name="ed" id="edi" onchange="edit_display();">						
   		<option value='-1'>Seleccione
      	</option>						
      	<?	if($admin) { ?>						
      		<option value='1'>Estudiantes
         	</option>						
         	<option value='2'>Docentes
         	</option>						
         	<option value='5'>Logros
         	</option>
         	<option value='12'>Periodos
         	</option>						
     		<? } ?>						
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
       		<input type="text" name="id_ds" id="id_ds" onblur="actualizar_docente()">  					
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
	    		<input type="date" min="1950-01-01" max="2050-01-01" id="fechas" name ="fechas" class="campo" >
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
   			<!-- se genera un campo   para la creacion   de las materias atendidas por docente -->
	  			Materias:
      		<input  type="text" size="50" id ='areas' name="areas" style="width: 60%;" class="campo">					
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
	    		<textarea rows="2" cols="90" id="Logros" name="logros" style="width: 80%;" class="campo">
	    		</textarea>
	    
	  		</fieldset>
            
	  		
	  
	   
    		<fieldset id="fecha_fin" class="filas_formulario">  
         	<!-- En este campo se ingresa la fecha de fin del curso -->	Finalizacion : 					
            <input type='date' min="1950-01-01" max="2050-01-01"
		   id='fecha_fins' name="fecha_fins" class="campo" >					
            <label>(mm/dd/yyyy)
            </label>					
          </fieldset>
          
          <fieldset id="logro_1" class="filas_formulario"> 
            <!--  etiqueta para colocar la caja de texto donde se ubica el nombre --> Logro 1: 
            <input type="text"  id ='logro_1' name="logro_1" required="required"  class="campo">						
            <select name="logro_1x" id="logro_1x">							
              <option value='-1'>Seleccione
              </option>						
            </select>					
          </fieldset>
          
      <fieldset id="logro_2" class="filas_formulario"> 
            <!--  etiqueta para colocar la caja de texto donde se ubica el nombre --> Logro 2: 
      	<input type="text"  id ='logro_2' name="logro_2" class="campo">						
         <select name="logro_2x" id="logro_2x">							
              <option value='-1'>Seleccione
              </option>						
      	</select>					
      </fieldset>
          
      <fieldset id="logro_3" class="filas_formulario"> 
      	<!--  etiqueta para colocar la caja de texto donde se ubica el nombre --> Logro 3: 
         <input type="text"  id ='logro_3' name="logro_3" class="campo">						
         <select name="logro_3x" id="logro_3x">							
         	<option value='-1'>Seleccione
            </option>						
         </select>					
      </fieldset>
          
      <fieldset id="nota" class="filas_formulario"> 
            <!--  etiqueta para colocar la caja de texto donde se ubica el nombre -->						
      	<label> Nota: 
         </label>  						
         <input type="number" value="3.0" id="notas" name="notas"
		     min="1" max="5" step="0.1" required="required" class="campo">  						
         <label> Faltas: 
         </label>						
         <input type="number" value="0.0" id="faltas" name="faltas"
		     min="1" max="100" step="1" required="required" class="campo">						 						 						 					
      </fieldset>
  
		<input style="background-color: #FF8000; width:100%; height: 50px;  border: #000 1px solid; margin-top: 20px;"
		 		type='button' value='INGRESAR' id="ingresar"  onclick="deposit();">  
          
	</form>	
	<div   id="resultado">
	</div>   
	<div   id="calificador">
	</div>
   	</div>				
      
    </div>						 						
                 
	 		 		 		 			 		 	 	
  </body>
</html>     
