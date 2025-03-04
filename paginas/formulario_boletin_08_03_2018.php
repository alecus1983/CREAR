<?php
session_start();
//validamos si se ha hecho o no el inicio de sesion correctamente
//si no se ha hecho la sesion nos regresará a login.php

include_once 'conexion.php';

if(!isset($_SESSION['usuario'])) 
{	
    //Sila sección no esta iniciada entonces retorna a la pagina principal 	
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
    
    <script src="lib/jquery.js"></script>   		
    <script src="lib/ajax.js"></script> 		
    <script src="lib/mostrar.js"></script> 
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
	// years que contiene el año
	
	var year = $("#years").val().toString();
	// y periodo que contiene el periodo
	var periodo = $("#periodos").val();
		      //cargo el estado del menu actual
	var menu = $("#opcion").val();
	// Se declara la variable chartData la cual recibe el dato tipo JSON proveniente de
	// el archivo data.php ( el cual requiere los parametros  año y periodo)
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
    
    <!-- este scrip adicciona el código para crear el objeto XMLHTTPRequest de AJAX -->					 	
  </head>	
  
  <!-- a partir de aqui se establece el cuerpo del documento que se va ha mostrar en la página -->
  <body onload="ocultar();">
    
    <!-- -->
    <!-- amCharts javascript code -->
    
    
    <!-- en caso que no se admitan scrips dentro de la página -->
    <noscript>  			
      <!-- se muestra la etiqueta de parrafo con el siguiente contenido -->
      <p>Bienvenido a Mi Sitio
      </p>  		
    </noscript>	 		 
    
    <!-- se establece la conexión con la base de datos -->
    
    
    <?php

       //conexion con la base de datos
       $link = conectar();
       $usuario = $_SESSION['usuario'];
       // se almacena una variable tipo consulta
       $reg=mysql_query("select * from docentes where cedula ='".$usuario."'" ,$link) or
       die("Problemas  encontrar el usuario:".mysql_error());
       
	
       //Validamos si el nombre del administrador existe en la base de datos o es correcto
       $row = mysql_fetch_array($reg);
       // se almacena el código del docente en la variable $id_docente
       $id_docente = $row['id_docente'];
       // se almacena el nombre del usuario 
       $nombre = $row['nombres'];
       // se almacena el apellido del usuario
       $apellido = $row['apellidos'];
       // se almacna en esta variable booleana que me indica si es administrador o no 
       $admin = $row['admin'];	
       // almacena el estado  de la variable $admin en la variable de sección
       $_SESSION['admin'] = $admin;
       // almacena el código del docente  en la variable de sección
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
       // muestra  un enlace que permite cerrar la sección
       echo "<br><a href='logout.php'>Cerrar Secci&oacute;n</a>";

       //echo "<br> Desde".$hoy." Hasta: ".$entrega;	
       desconectar($link);
    ?>   		 		
    
    <!-- se crea la tabla principal para alvergar la tabla -->
    
    <table align= 'center' width = '800' border="0">   		 		
      <!-- esta es la primera fila de la tabla --> 			
      <tr>
        <!-- primera columna de la fila -->			 				
        <td colspan='4'>
	  <h1> FORMULARIO PARA LA GESTION DE CALIFICACIONES</h1>						
      	  <?php
      	     // se crea un campo input oculto que almacena el código del docente
	     echo "<input type= 'hidden' id= 'id_docentes' name= 'id_docentes' value= '".$id_docente."' >"
      	     ?>
      	</td>
      </tr>		 			
      <tr>
      	<!-- -->				
        <td colspan='4'>Introduzca el  la acci&oacute;n requerida  del siguiente men&uacute; </td>			
      </tr>	 					 			
      <!-- // se incerta un formulario para  adiccionar eliminar o editar  datos --> 				 		 	
      <form name = 'datos' id= 'datos' targer="_blanck" >				
        <tr>				
        </tr>				
        <tr> <!-- esta fila contiene el contenido de los títulos de los menús -->					
          <td bgcolor="#1E90FF"  style="height:30px; width:266px  border: #000 1px solid"  colspan="1">						
            <strong>Consultar</strong> 
          </td>					 					
          <td bgcolor="#0040FF"  style="height:30px; width:268px  border: #000 1px solid" colspan="1">						
            <strong><font color="#FFFFFF">Adiccionar</font></strong>
          </td>					 					
          <td bgcolor="#00FFFF"  style="height:30px; width:266px  border: #000 1px solid" colspan="1">
            <strong>Editar</strong>					
          </td>				
        </tr>				 				 								 				 				
        <tr>				
          <td >
            <!-- este es un select esta asociado al proceso de de adiccionar-->					
            <select   style=" width:260px" name='opcion' id="opcion" class="caja">						
              <option value='-1'>Seleccione
              </option>						
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
              <? if($admin) { ?>						
              <option value='6'>Boletin
              </option>								
              <option value='16'>Certificado
              </option>						
              <? } ?>              
              <option value='7'>Matricula Alumnos
              </option>						
              <?	if($admin) { ?>						
              <option value='8'>Matricula Docentes
              </option>						
              <option value='9'>Requisitos Materia
              </option>						
              <option value='10'>Evalucion
              </option>						
              <? } ?>
              <?	if(!$admin && $entrega > $hoy) { ?>
              <!-- este es el formulario de notas para los docentes -->
              <option value='11'>Nota
              </option>	
	      <? } ?>
	      <?	if($admin ) { ?>						
              <option value='12'>Nota
              </option>
              <option value='13'>Registros por grado
              </option>
	      <option value='14'>Registros por docente
              </option>
	      <option value='15'>Registros por alumno
              </option>
	      <? } ?>
	      <!-- Esta es la opcion permite configurar las notas realizadas -->					
            </select>				
          </td>				 				
          <td >					
            <select   style=" width:260px" name='add' id="add" class="caja">						
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
          </td>	 				
          <td>					
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
          </td>				 				 				
        </tr>			
        <!-- botones para cargar formulario -->			 					 				
        <!-- CAMPOS PARA EL INGRESO DE DATOS --> 				 				
        <tr align="center" valign="middle" bgcolor="#FFFF00">				
          <td colspan="4"></td>				
        </tr>				 				
        <tr >				
          <td colspan="4" >
            
            <fieldset id="ano" class="filas_formulario" >A&ntilde;o: 					
              <!-- Este campo muestra la variable ano la cual contiene por defecto el año reciente --> 					
              <!-- se conecta a la base de datos y recupera los  valores introduccidos en la tabla de calificaciones --> 
              <? if($admin) { ?> 	 					
              <input type="number" value="<?php echo date('Y');?>" id="years" name="years"
		     min="2015" max="2100" step="1" required="required" >					
              <? } else { ?>					
              <input type="number" value="<?php echo date('Y');?>" id="years"
		     name="years" min="2015" max="2100" step="1"
		     required="required" readonly="readonly">					
              <? } ?>

	      <label style=" margin-left: 20px;"> Jornada </label>
	      <select id="jornada" >
		<option value=1>Ma&ntilde;ana</option>
		<option value=2>Tarde</option>
	      </select>
            </fieldset >
            <!-- en este campo se ubica  el periodo a tratar -->			
            <fieldset id="periodo" class="filas_formulario">	Peri&oacute;do: 					 					
              <select id='periodos' name="periodos"  >	
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
            </fieldset>	
            
            <fieldset id='grado' class="filas_formulario">Grado:  					
              <!-- cuadro de dialogo --> 						
              <select  id="grados" name="grados" >							
                <option value='-1'>Seleccione
                </option>						
              </select>					 					
            </fieldset>	
            
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
              <input type="text"  id ='i_nombres' name="i_nombres">					
            </fieldset>
            
            <fieldset id="apellido" class="filas_formulario" >
              <!-- se genera un campo insertar el apellido -->
	      Apellido:	
              <input type='text' id ='apellidos' name="apellidos">					
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
	      <input type="date" min="1950-01-01" max="2050-01-01" id="fechas" name ="fechas"  >
	      (yyyy/mm/dd) 					
            </fieldset>	
            
            <fieldset id="telefono" class="filas_formulario">  
              <!-- En este campo se ingresa  el  numero telefonico -->	Telefono: 
              <input type='tel'  id ='telefonos' name="telefonos">
	    </fieldset>	
            
            <fieldset id="correo" class="filas_formulario">  
              <!-- en este campo se ingresa el telefono del estudiante --> Correo: 
              <input type='email'   id ='correos' name="correos">					
            </fieldset>	
            
            <fieldset id="cedula" class="filas_formulario"> Cedula: 
              <input type='text'  id ='cedulas' name="cedulas">               
            </fieldset>	
            
            <fieldset id="curso" class="filas_formulario">  
              <!-- Se ingresa  un campo para seleccionar  el codigo de la materia --> Materia :	 						
              <select id="cursos" name="cursos" >							
                <option value='-1'>Seleccione
                </option>                  
              </select>					
            </fieldset>	
            
            <fieldset id="area" class="filas_formulario">  
              <!-- se genera un campo   para la creacion   de las materias atendidas por docente -->
	      Materias:
              <input  type="text" size="50" id ='areas' name="areas">					
            </fieldset>
            
            <fieldset id="materia" class="filas_formulario">
	      Materia: 						
              <input type='text'  id ='materias' name="materias">					 					
            </fieldset>	
            
            <fieldset id="id_a" class="filas_formulario">Id Area: 					
              <input type='text'  id ='id_as' name="id_as">					
            </fieldset>	
            
            <fieldset id="Logro" class="filas_formulario">
	      Logro: 					
              <textarea rows='2' cols='90' id ='Logros'
			name="Logros">
	      </textarea> 					
            </fieldset>
            
            <fieldset id="id_m" class="filas_formulario">
	      Materia:			 						
              <select id="id_ms" name="id_ms" >							
                <option value='-1'>Seleccione
                </option>                  
              </select>					
            </fieldset>	
	    
	    
            <fieldset id='id_g' class="filas_formulario">						 
              <!-- etiqueta que identifica el grado -->
	      Grado: 	 
              <!-- devuelve el codigo del grado -->   					
              <!-- cuadro de dialogo --> 						
              <select  id="id_gs" name="id_gs" >							
                <option value='-1'>Seleccione
                </option>							 						
              </select>					
            </fieldset>	
            
            <fieldset id="fecha_fin" class="filas_formulario">  
              <!-- En este campo se ingresa la fecha de fin del curso -->	Finalizacion : 					
              <input type='date' min="1950-01-01" max="2050-01-01"
		     id='fecha_fins' name="fecha_fins"  >					
              <label>(mm/dd/yyyy)
              </label>					
            </fieldset>
            
            <fieldset id="logro_1" class="filas_formulario"> 
              <!--  etiqueta para colocar la caja de texto donde se ubica el nombre --> Logro 1: 
              <input type="text"  id ='logro_1' name="logro_1" required="required">						
              <select name="logro_1x" id="logro_1x">							
                <option value='-1'>Seleccione
                </option>						
              </select>					
            </fieldset>
            
            <fieldset id="logro_2" class="filas_formulario"> 
              <!--  etiqueta para colocar la caja de texto donde se ubica el nombre --> Logro 2: 
              <input type="text"  id ='logro_2' name="logro_2" >						
              <select name="logro_2x" id="logro_2x">							
                <option value='-1'>Seleccione
                </option>						
              </select>					
            </fieldset>
            
            <fieldset id="logro_3" class="filas_formulario"> 
              <!--  etiqueta para colocar la caja de texto donde se ubica el nombre --> Logro 3: 
              <input type="text"  id ='logro_3' name="logro_3" >						
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
		     min="1" max="5" step="0.1" required="required" >  						
              <label> Faltas: 
              </label>						
              <input type="number" value="0.0" id="faltas" name="faltas"
		     min="1" max="100" step="1" required="required" >						 						 						 					
            </fieldset>
          </td>					
        </tr>				 					
        <tr>	 					
          <td colspan="4">					
            <!-- boton para cargar datos -->						
            <input style="background-color: #1E90FF; width:100%;  border: #000 1px solid"
		   type='button' value='CARGAR' id="cargar" onclick="consultar();">					
            <!-- boton creado para mostrar valores de busqueda -->					 						
            <input  style="background-color: #1E80FF; width:100%; border: #000 1px solid"
		    type='button' value='TIPO PRIMARIA' id="generar" onclick="crear_pdf();">					
            <!-- genera boletin  de primaria  -->					 						
            <input style="background-color: #1E40FF; width:100%; border: #000 1px solid"
		   type='button' value='TIPO PREESCOLAR' id="generarx" onclick="obtener_pdf();">					
            <!-- genera voletines con el modelo de preescolar -->					 						
            <input style="background-color: #FF8000; width:100%; height: 50px;  border: #000 1px solid"
		   type='button' value='INGRESAR' id="ingresar"  onclick="deposit();">						 						
            <input style="background-color: #00FF00; width:100%; height: 50px; border: #000 1px solid"
		   type='button' value='ACTUALIZAR' id="actualizar" onclick="upgrade();">
            <input style="background-color: #21FFA0; width:100%; height: 50px; border: #000 1px solid"
		   type='button' value='GRAFICAR' id="graficar" onclick="grafica();">
          </td>
              <!-- se genera el formulario de ingreso -->						 				
        </tr>						 									 		
        <tr>
          <td colspan="4"> 	 						
            <div   id="resultado" style="width: 800px">  		 				 					
            </div>							
	    <div   id="calificador">
	    </div>
	    <div   id="grafo" style="width: 800px; height: 400px"> 
	    </div>    
	  </td>			 				
	</tr>			
    </table>		 		 		 		
    <!-- tabla para docente --> 		 		 		 			 		 	 	
  </body>
</html>     
