// funcion que reacciona al radio booton
// para elegir entre el menu adiccionar o
// editar
$(document).ready(function(){
$("input[@name='menu']").clik(function(){
    var menu = $('input[name=menu]:checked').val();
    alert(menu);
    // Do something interesting here
});
});
		  
function menu_addicionar(){

    /*var menu = $('input[name=menu]:checked').val();
    alert(menu);
    if (menu == "add"){
	$('#edi').css("display", "none");
	$('#add').css("display", "block");
	$('select#add').val('-1');
	ocultar_add();
    }
    else{
	$('#add').css("display", "none");
	$('#edi').css("display", "block");
	$('select#edi').val('-1');
	ocultar_add();
    }*/
}

// este fichero contiene las funciones de javascrip ( jquery
// que permiten mostrar un contenido dinámico en la hoja del formulario

// esta funcion filtra el contenido  cuando cambia el selct de consultar
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
	
	document.getElementById("materia_con").style.display='block';
	document.getElementById("cargar").style.display='block';
	break;
	
	// caso  de consultar areas -->
	
    case "4":
	
	document.getElementById("cargar").style.display='block';
	break;
				
    case "5":
	
	document.getElementById("Logro_con").style.display='block';
	document.getElementById("curso_con").style.display='block';
	document.getElementById("cargar").style.display='block';
	break;
	
    case "6":	// en este caso se editan los boletines
	
	document.getElementById("id_g_con").style.display='block';
	document.getElementById("generar").style.display='block';
	document.getElementById("generarx").style.display='block';
	break;
	
    case "7":	// en este caso se editan la matricula de los alumnos
	
	document.getElementById("id_g_con").style.display='block';
	document.getElementById("cargar").style.display='block';
	break;
	
	
    case "8":
	
	document.getElementById("id_g_con").style.display='block';
	document.getElementById("cargar").style.display='block';
	break;
	
	
    case "9":
					
	document.getElementById("id_g_con").style.display='block';
	document.getElementById("cargar").style.display='block';
	break;
	
    case "11": // corresponde a la nota vista por los docentes
	
	document.getElementById("estudiante_con").style.display='block';
	document.getElementById("id_m_con").style.display='block';
	document.getElementById("cargar").style.display='block';
	$("#id_e").css("display", "none");
	break;
        
        
    case "12": // corresponde a la nota ingresada por el administrador de la página
	
	document.getElementById("estudiante_con").style.display='block';
	document.getElementById("cargar").style.display='block';
	break;
        
    case "13": // corresponde a la nota ingresada por el administrador de la página
	
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
	document.getElementById("id_g_con").style.display='block';
	document.getElementById("generar").style.display='block';
	document.getElementById("generarx").style.display='block';
	
	break;

    } // final del esxplorador de columnas	
    
} // final de consultar display


// esta funcion oculta el contenido de la página cuando 
                                // se selecciona una funcion del combo adiccionar

function add_display () {
    
    // la variable x el valor de la caja desplegable actuar como insumo para indexar las acciones que correspondan a dicho item -->
    
    $('select#opcion').val('-1');
    $('select#edi').val('-1');
    $('#calificador').html("");
    var y = document.getElementById('add').value;
    
    switch(y) {
	
    case "1":	// adiccionar estudiantes
	
	document.getElementById("estudiante").style.display='none';
	document.getElementById("id_g").style.display='none';
	document.getElementById("fecha_fin").style.display='none';
	document.getElementById("curso").style.display='none';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='block';
	document.getElementById("nombre").style.display='block'; 
	document.getElementById("apellido").style.display='block';
	document.getElementById("telefono").style.display='block';
	document.getElementById("fecha").style.display='block';					
	document.getElementById("cedula").style.display='block'; 			
	document.getElementById("area").style.display='none';
	document.getElementById("correo").style.display='block';
	document.getElementById("materia").style.display='none';
	document.getElementById("Logro").style.display='none';
	document.getElementById("id_m").style.display='none';
	document.getElementById("id_a").style.display='none';
	document.getElementById("periodo").style.display='none';
	document.getElementById("grado").style.display='none';
	document.getElementById("generar").style.display='none';
	document.getElementById("generarx").style.display='none';
	document.getElementById("cargar").style.display='none';
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
	document.getElementById("id_g").style.display='none';
	document.getElementById("fecha_fin").style.display='none';
	document.getElementById("curso").style.display='none';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='block';
	document.getElementById("nombre").style.display='block'; 
	document.getElementById("apellido").style.display='block';
	document.getElementById("telefono").style.display='block';
	document.getElementById("fecha").style.display='block';					
	document.getElementById("cedula").style.display='block'; 			
	document.getElementById("area").style.display='block';
	document.getElementById("correo").style.display='block';
	document.getElementById("materia").style.display='none';
	document.getElementById("Logro").style.display='none';
	document.getElementById("id_m").style.display='none';
	document.getElementById("id_a").style.display='none';
	document.getElementById("periodo").style.display='none';
	document.getElementById("grado").style.display='none';
	document.getElementById("generar").style.display='none';
	document.getElementById("generarx").style.display='none';
	document.getElementById("cargar").style.display='none';
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
	document.getElementById("id_g").style.display='none';
	document.getElementById("fecha_fin").style.display='none';
	document.getElementById("curso").style.display='none';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='none';
	document.getElementById("cedula").style.display='none'; 			
	document.getElementById("area").style.display='none';
	document.getElementById("correo").style.display='none';
	document.getElementById("nombre").style.display='none'; 
	document.getElementById("apellido").style.display='none';
	document.getElementById("telefono").style.display='none';
	document.getElementById("fecha").style.display='none';					
	document.getElementById("materia").style.display='block';
	document.getElementById("Logro").style.display='none';
	document.getElementById("id_m").style.display='none';
	document.getElementById("id_a").style.display='none';
	document.getElementById("periodo").style.display='none';
	document.getElementById("grado").style.display='none';
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
	document.getElementById("id_g").style.display='none';
	document.getElementById("fecha_fin").style.display='none';
	document.getElementById("curso").style.display='none';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='none';
	document.getElementById("cedula").style.display='none'; 			
	document.getElementById("area").style.display='none';
	document.getElementById("correo").style.display='none';
	document.getElementById("nombre").style.display='none'; 
	document.getElementById("apellido").style.display='none';
	document.getElementById("telefono").style.display='none';
	document.getElementById("fecha").style.display='none';					
	document.getElementById("materia").style.display='none';
	document.getElementById("Logro").style.display='none';
	document.getElementById("id_m").style.display='none';
	document.getElementById("id_a").style.display='none';
	document.getElementById("periodo").style.display='none';
	document.getElementById("grado").style.display='none';
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
	document.getElementById("id_g").style.display='none';
	document.getElementById("fecha_fin").style.display='none';
	document.getElementById("curso").style.display='block';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='block';
	document.getElementById("nombre").style.display='none'; 
	document.getElementById("apellido").style.display='none';
	document.getElementById("telefono").style.display='none';
	document.getElementById("fecha").style.display='none';					
	document.getElementById("cedula").style.display='none'; 			
	document.getElementById("area").style.display='none';
	document.getElementById("correo").style.display='none';
	document.getElementById("materia").style.display='none';
	document.getElementById("Logro").style.display='block';
	document.getElementById("id_m").style.display='none';
	document.getElementById("id_a").style.display='none';
	document.getElementById("periodo").style.display='none';
	document.getElementById("grado").style.display='none';
	document.getElementById("generar").style.display='none';
	document.getElementById("generarx").style.display='none';
	document.getElementById("cargar").style.display='none';
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
	document.getElementById("id_g").style.display='block';
	document.getElementById("fecha_fin").style.display='none';
	document.getElementById("curso").style.display='none';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='none';
	document.getElementById("cedula").style.display='none'; 			
	document.getElementById("area").style.display='none';
	document.getElementById("correo").style.display='none';
	document.getElementById("nombre").style.display='none'; 
	document.getElementById("apellido").style.display='none';
	document.getElementById("telefono").style.display='none';
	document.getElementById("fecha").style.display='none';					
	document.getElementById("materia").style.display='none';
	document.getElementById("Logro").style.display='none';
	document.getElementById("id_m").style.display='none';
	document.getElementById("id_a").style.display='none';
	document.getElementById("periodo").style.display='block';
	document.getElementById("grado").style.display='none';
	document.getElementById("cargar").style.display='none';
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
	document.getElementById("id_g").style.display='block';
	document.getElementById("fecha_fin").style.display='none';
	document.getElementById("curso").style.display='none';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='block';
	document.getElementById("cedula").style.display='none'; 			
	document.getElementById("area").style.display='none';
	document.getElementById("correo").style.display='none';
	document.getElementById("nombre").style.display='block'; 
	document.getElementById("apellido").style.display='block';
	document.getElementById("telefono").style.display='none';
	document.getElementById("fecha").style.display='none';					
	document.getElementById("materia").style.display='none';
	document.getElementById("Logro").style.display='none';
	document.getElementById("id_m").style.display='none';
	document.getElementById("id_a").style.display='none';
	document.getElementById("periodo").style.display='none';
	document.getElementById("grado").style.display='none';
	document.getElementById("cargar").style.display='none';
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
	document.getElementById("id_g").style.display='block';
	document.getElementById("fecha_fin").style.display='block';
	document.getElementById("curso").style.display='block';
	document.getElementById("docente").style.display='block';
	document.getElementById("ingresar").style.display='block';
	document.getElementById("cedula").style.display='none'; 			
	document.getElementById("area").style.display='none';
	document.getElementById("correo").style.display='none';
	document.getElementById("nombre").style.display='none'; 
	document.getElementById("apellido").style.display='none';
	document.getElementById("telefono").style.display='none';
	document.getElementById("fecha").style.display='none';					
	document.getElementById("materia").style.display='none';
	document.getElementById("Logro").style.display='none';
	document.getElementById("id_m").style.display='none';
	document.getElementById("id_a").style.display='none';
	document.getElementById("periodo").style.display='none';
	document.getElementById("grado").style.display='none';
	document.getElementById("cargar").style.display='none';
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
	document.getElementById("id_g").style.display='block';
	document.getElementById("fecha_fin").style.display='none';
	document.getElementById("curso").style.display='block';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='block';
	document.getElementById("nombre").style.display='none'; 
	document.getElementById("apellido").style.display='none';
	document.getElementById("telefono").style.display='none';
	document.getElementById("fecha").style.display='none';					
	document.getElementById("cedula").style.display='none'; 			
	document.getElementById("area").style.display='none';
	document.getElementById("correo").style.display='none';
	document.getElementById("materia").style.display='none';
	document.getElementById("Logro").style.display='none';
	document.getElementById("id_m").style.display='none';
	document.getElementById("id_a").style.display='none';
	document.getElementById("periodo").style.display='none';
	document.getElementById("grado").style.display='none';
	document.getElementById("generar").style.display='none';
	document.getElementById("generarx").style.display='none';
	document.getElementById("cargar").style.display='none';				
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
	document.getElementById("id_g").style.display='none';
	document.getElementById("fecha_fin").style.display='none';
	document.getElementById("curso").style.display='none';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='block';
	document.getElementById("cedula").style.display='none'; 			
	document.getElementById("area").style.display='none';
	document.getElementById("correo").style.display='none';
	document.getElementById("nombre").style.display='none'; 
	document.getElementById("apellido").style.display='none';
	document.getElementById("telefono").style.display='none';
	document.getElementById("fecha").style.display='none';					
	document.getElementById("materia").style.display='none';
	document.getElementById("Logro").style.display='none';
	document.getElementById("id_m").style.display='block';
	document.getElementById("id_a").style.display='none';
	document.getElementById("periodo").style.display='block';
	document.getElementById("grado").style.display='block';
	document.getElementById("cargar").style.display='none';
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
	document.getElementById("id_g").style.display='block';
	document.getElementById("fecha_fin").style.display='none';
	document.getElementById("curso").style.display='none';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='block';
	document.getElementById("cedula").style.display='none'; 			
	document.getElementById("area").style.display='none';
	document.getElementById("correo").style.display='none';
	document.getElementById("nombre").style.display='none'; 
	document.getElementById("apellido").style.display='none';
	document.getElementById("telefono").style.display='none';
	document.getElementById("fecha").style.display='none';					
	document.getElementById("materia").style.display='none';
	document.getElementById("Logro").style.display='none';
	document.getElementById("id_m").style.display='none';
	document.getElementById("id_a").style.display='none';
	document.getElementById("periodo").style.display='none';
	document.getElementById("grado").style.display='none';
	document.getElementById("cargar").style.display='none';
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
    
    consultar();

}


function edit_display(){
				
    // la variable x el valor de la caja desplegable actuar como insumo para indexar las acciones que correspondan a dicho item -->
		
    $('select#opcion').val('-1');
    $('select#add').val('-1');
    $('#calificador').html("");

    var y = $('#edi').val();
    
    switch(y) {
	
    case "1":	// adiccionar estudiantes
					
	document.getElementById("estudiante").style.display='none';
	document.getElementById("id_g").style.display='none';
	document.getElementById("fecha_fin").style.display='none';
	document.getElementById("curso").style.display='none';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='none';
	document.getElementById("nombre").style.display='block'; 
	document.getElementById("apellido").style.display='block';
	document.getElementById("telefono").style.display='block';
	document.getElementById("fecha").style.display='block';					
	document.getElementById("cedula").style.display='block'; 			
	document.getElementById("area").style.display='none';
	document.getElementById("correo").style.display='block';
	document.getElementById("materia").style.display='none';
	document.getElementById("Logro").style.display='none';
	document.getElementById("id_m").style.display='none';
	document.getElementById("id_a").style.display='none';
	document.getElementById("periodo").style.display='none';
	document.getElementById("grado").style.display='none';
	document.getElementById("generar").style.display='none';
	document.getElementById("generarx").style.display='none';
	document.getElementById("cargar").style.display='none';
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
	document.getElementById("id_g").style.display='none';
	document.getElementById("fecha_fin").style.display='none';
	document.getElementById("curso").style.display='none';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='none';
	document.getElementById("nombre").style.display='block'; 
	document.getElementById("apellido").style.display='block';
	document.getElementById("telefono").style.display='block';
	document.getElementById("fecha").style.display='block';					
	document.getElementById("cedula").style.display='block'; 			
	document.getElementById("area").style.display='block';
	document.getElementById("correo").style.display='block';
	document.getElementById("materia").style.display='none';
	document.getElementById("Logro").style.display='none';
	document.getElementById("id_m").style.display='none';
	document.getElementById("id_a").style.display='none';
	document.getElementById("periodo").style.display='none';
	document.getElementById("grado").style.display='none';
	document.getElementById("generar").style.display='none';
	document.getElementById("generarx").style.display='none';
	document.getElementById("cargar").style.display='none';
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
	document.getElementById("id_g").style.display='none';
	document.getElementById("fecha_fin").style.display='none';
	document.getElementById("curso").style.display='none';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='none';
	document.getElementById("cedula").style.display='none'; 			
	document.getElementById("area").style.display='none';
	document.getElementById("correo").style.display='none';
	document.getElementById("nombre").style.display='none'; 
	document.getElementById("apellido").style.display='none';
	document.getElementById("telefono").style.display='none';
	document.getElementById("fecha").style.display='none';					
	document.getElementById("materia").style.display='block';
	document.getElementById("Logro").style.display='none';
	document.getElementById("id_m").style.display='none';
	document.getElementById("id_a").style.display='none';
	document.getElementById("periodo").style.display='none';
	document.getElementById("grado").style.display='none';
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
	document.getElementById("id_g").style.display='none';
	document.getElementById("fecha_fin").style.display='none';
	document.getElementById("curso").style.display='none';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='none';
	document.getElementById("cedula").style.display='none'; 			
	document.getElementById("area").style.display='none';
	document.getElementById("correo").style.display='none';
	document.getElementById("nombre").style.display='none'; 
	document.getElementById("apellido").style.display='none';
	document.getElementById("telefono").style.display='none';
	document.getElementById("fecha").style.display='none';					
	document.getElementById("materia").style.display='none';
	document.getElementById("Logro").style.display='none';
	document.getElementById("id_m").style.display='none';
	document.getElementById("id_a").style.display='none';

	document.getElementById("periodo").style.display='none';
	document.getElementById("grado").style.display='none';
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
	document.getElementById("id_g").style.display='none';
	document.getElementById("fecha_fin").style.display='none';
	document.getElementById("curso").style.display='none';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='none';
	document.getElementById("nombre").style.display='none'; 
	document.getElementById("apellido").style.display='none';
	document.getElementById("telefono").style.display='none';
	document.getElementById("fecha").style.display='none';					
	document.getElementById("cedula").style.display='none'; 			
	document.getElementById("area").style.display='none';
	document.getElementById("correo").style.display='none';
	document.getElementById("materia").style.display='none';
	document.getElementById("Logro").style.display='block';
	document.getElementById("id_m").style.display='none';
	document.getElementById("id_a").style.display='none';
	document.getElementById("periodo").style.display='none';
	document.getElementById("grado").style.display='none';
	document.getElementById("generar").style.display='none';
	document.getElementById("generarx").style.display='none';
	document.getElementById("cargar").style.display='none';
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
	document.getElementById("id_g").style.display='none';
	document.getElementById("fecha_fin").style.display='none';
	document.getElementById("curso").style.display='none';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='none';
	document.getElementById("cedula").style.display='none'; 			
	document.getElementById("area").style.display='none';
	document.getElementById("correo").style.display='none';
	document.getElementById("nombre").style.display='none'; 
	document.getElementById("apellido").style.display='none';
	document.getElementById("telefono").style.display='none';
	document.getElementById("fecha").style.display='none';					
	document.getElementById("materia").style.display='none';
	document.getElementById("Logro").style.display='none';
	document.getElementById("id_m").style.display='block';
	document.getElementById("id_a").style.display='none';
	
	document.getElementById("periodo").style.display='block';
	document.getElementById("grado").style.display='block';
	document.getElementById("cargar").style.display='none';
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
	document.getElementById("id_g").style.display='none';
	document.getElementById("fecha_fin").style.display='block';
	document.getElementById("curso").style.display='none';
	document.getElementById("docente").style.display='none';
	document.getElementById("ingresar").style.display='none';
	document.getElementById("cedula").style.display='none'; 			
	document.getElementById("area").style.display='none';
	document.getElementById("correo").style.display='none';
	document.getElementById("nombre").style.display='none'; 
	document.getElementById("apellido").style.display='none';
	document.getElementById("telefono").style.display='none';
	document.getElementById("fecha").style.display='none';					
	document.getElementById("materia").style.display='none';
	document.getElementById("Logro").style.display='none';
	document.getElementById("id_m").style.display='none';
	document.getElementById("id_a").style.display='none';
	document.getElementById("periodo").style.display='block';
	document.getElementById("grado").style.display='none';
	document.getElementById("cargar").style.display='none';
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

function ocultar_add(){

    $('select#opcion').val('-1');
    $('select#add').val('-1');
    $('select#edi').val('-1');
    document.getElementById("estudiante").style.display='none';
    document.getElementById("id_g").style.display='none';
    document.getElementById("fecha_fin").style.display='none';
    document.getElementById("curso").style.display='none';
    document.getElementById("docente").style.display='none';
    document.getElementById("ingresar").style.display='none';
    document.getElementById("nombre").style.display='none';
    document.getElementById("apellido").style.display='none';
    document.getElementById("telefono").style.display='none';
    document.getElementById("fecha").style.display='none';					
    document.getElementById("cedula").style.display='none'; 			
    document.getElementById("area").style.display='none';
    document.getElementById("correo").style.display='none';
    document.getElementById("materia").style.display='none';
    document.getElementById("Logro").style.display='none';
    document.getElementById("id_m").style.display='none';
    document.getElementById("id_a").style.display='none';

    document.getElementById("generar").style.display='none';
    document.getElementById("generarx").style.display='none';
    document.getElementById("cargar").style.display='none';
    $("#id_e").css("display", "none");
    $("#id_d").css("display", "none");
    $("#logro_1").css("display", "none");
    $("#logro_2").css("display", "none");
    $("#logro_3").css("display", "none");
    $("#nota").css("display", "none");	
    $("#id_l").css("display", "none");
    $("#graficar").css("display", "none");
}


// funcion que oculta todos los menus
function ocultar_todo()
{
    
	
    $("#add").attr('checked', 'checked');
    $('#edi').css("display", "none");
    $('#add').css("display", "block");
	
    ocultar_add();
    ocultar_consultar();
}

function ocultar_consultar()
{
    
    document.getElementById("estudiante_con").style.display='none';
    document.getElementById("id_g_con").style.display='none';
    document.getElementById("nombre_con").style.display='none'; 
    document.getElementById("apellido_con").style.display='none';
    document.getElementById("materia_con").style.display='none';
    document.getElementById("Logro_con").style.display='none';
    document.getElementById("id_m_con").style.display='none';
    document.getElementById("id_a_con").style.display='none';
    document.getElementById("generar").style.display='none';
    document.getElementById("generarx").style.display='none';
    document.getElementById("cargar").style.display='none';
    document.getElementById("curso_con").style.display='none';
    
    $("#graficar").css("display", "none");
    $("#materia_con").css("display", "none");
    
}


function ocultar_display()
{
    
    
    //$('select#opcion').val('-1');
    $('select#add').val('-1');
    $('select#edi').val('-1');
    document.getElementById("estudiante").style.display='none';
    document.getElementById("id_g").style.display='none';
    document.getElementById("fecha_fin").style.display='none';
    document.getElementById("curso").style.display='none';
    document.getElementById("docente").style.display='none';
    document.getElementById("ingresar").style.display='none';
    document.getElementById("nombre").style.display='none'; 
    document.getElementById("apellido").style.display='none';
    document.getElementById("telefono").style.display='none';
    document.getElementById("fecha").style.display='none';					
    document.getElementById("cedula").style.display='none'; 			
    document.getElementById("area").style.display='none';
    document.getElementById("correo").style.display='none';
    document.getElementById("materia").style.display='none';
    document.getElementById("Logro").style.display='none';
    document.getElementById("id_m").style.display='none';
    document.getElementById("id_a").style.display='none';
    document.getElementById("periodo").style.display='none';
    document.getElementById("grado").style.display='none';
    document.getElementById("generar").style.display='none';
    document.getElementById("generarx").style.display='none';
    document.getElementById("cargar").style.display='none';
    $("#id_e").css("display", "none");
    $("#id_d").css("display", "none");
    $("#logro_1").css("display", "none");
    $("#logro_2").css("display", "none");
    $("#logro_3").css("display", "none");
    $("#nota").css("display", "none");	
    $("#id_l").css("display", "none");
    $("#graficar").css("display", "none");
}

	/////////////////////////////////////////////////////////////////////
	
$(document).ready(function() {
    
    // cada vez que se cambia el valor del combo adiccionar  se realizan las siguientes acciones
    // para cargar los combos
    $("#add").change(function() {
   	
	add_display();	// funcion que oculta los campos segun la opcion
	
	
	add = $('select#add').val(); // tomo el valor del cambio aderir
	
	switch(add) {
	    
	case "5":
	    carga("#cursos","materias.php",{ id : $("#id").val()});
	    consultar();
	    break;
	    
	case "7":
	    carga("#id_gs","grados.php",{ id : $("#id").val()});
	    
	    break;
	    
	    
	case "8":
	    carga("#docentes","docentes.php",{ id : $("#id").val()});
	    carga("#id_gs","grados.php",{ id : $("#id").val()});
	    
	    break;		
	    
	case "9":
	    carga("#cursos","materias.php",{ id : $("#id").val()});
	    carga("#id_gs","grados.php",{ id : $("#id").val()});
	    
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
	    consultar();
	    
            break;
     	    
	    
	}
	
	
    });
});
//////////////////////////////////////////////////////////////////////////////


$(document).ready(function(){
    
    // cada vez que se cambia el valor del combo   de ediccion
    $("#edi").change(function() {
	
	edit_display(); // funcion que muestra los campos especificos
		
	
	carga("#cursos","materias.php",{ id : $("#id").val()});
	$('#resultado').html("");
        
    });
});




	
$(document).ready(function(){
    
    // cada vez que se cambia el valor del combo   de consulta
    $("#opcion").change(function() {
	
   	consultar_display();
	 	op = $('select#opcion').val();
	console.log("Ha cambiado la opcion del selector a %s",op);
	switch(op) {
	    
	case "1":
	    $("#i_nombres").attr("readonly",false);
	    $("#apellidos").attr("readonly",false);
	    consultar();
	    break;
	    
	case "2":
	    $("#i_nombres").attr("readonly",false);
	    $("#apellidos").attr("readonly",false);
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

	
/////////////////////////////////////////////////////////////////////////


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

//////////////////////////////////////////////////////////////////////

$(document).ready(function () {
    
    $("#grados").change(function () {
	
		
	var year = $("#years").val().toString();
	var grado = $("#grados").val();
	
	
	//console.log ("cambio grado");
	
	if ( grado > 0 ) {
		
	    //console.log ("grado %s",grado);
	    carga("#estudiantes","estudiantes.php", {'grados': grado, 'year': year  , id : $("#id").val()});
     	    
	    
		}
    });
});
/////////////////////////////////////////////////////////////////////////////
	

$(document).ready(function () {
    $("#estudiantes").change(function () {
	
	
	var year = $("#years").val().toString();
	var grado = $("#grados").val();
	
	
	//console.log ("cambio grado");
		
	if ( grado > 0 ) {
	    
	    carga("#id_ms","materias_grado.php", {'grados': grado, id : $("#id").val()});
		
	}
    });
});	


////////////////////////////////////////////////////////////////////
// Una vez el documento este listo ejecuto
// esta funcion la cual  al seleccionar la
// opcion (12) del selector #opcion


$(document).ready(function () {
    // cuando cambia el combo estuduantes ( en particualr cuando se cambia la nota
    $("#estudiantes").change(function () {	
        // deselecciona la materia
        // verifico si la nota es de un docente #opcion = 12 o de un adminstrador #opcion = 11
        
        // capturo el estado de los selectores ( combos)
        var year = $("#years").val();
        var periodo = $("#periodos").val();
        var grado = $("#grados").val();
        var estudiante = $("#estudiantes").val();
        
        if ($("#opcion").val() == 12)
        {
            // mustra estado por la consola
            console.log("seleccionando los dados del estudiante ...");
            $("#calificador").load("notas_por_estudiante.php", {
                    
                "year": year, 
                "periodo": periodo,
                "grado": grado,
                    "id_e": estudiante
            });
            
        }
        
        
	$('select#id_ms').val('-1');
    });
    
    $("#id_ms").change(function () {
	id_m = $("#id_ms").val();
	console.log("Se cambio la materia  ...%s",id_m);
	if ($("#add").val() == 11) {
	    $("#calificador").load("calificar.php", {"id_ms": id_m });
	}
	
	window.setTimeout("consultar()",500);
	
    });
    
    
});



/////////////////////////////////////////////////////////////////////

// esta funcion espera que  el documento este listo
// y adiere al evento cambio al selector #id_gs
// es decir cada vez que se cambia el grado  y se esta en
// algunos de los items a mensionar  se ejecuta la funcion
// consultar

$(document).ready(function () {
    $("#id_gs").change ( function () {

	// si la opcion para el selector
	// #opcion es:
	// 7 - Matricula alumnos
	// 8 - Matricula docente
	// 9 - Requisitos de materia

	// si la opcion para el selector
	// #add es:
	// 7 - Matricula alumnos
	// 8 - Matricula docente
	// 9 - Requisitos de materia

	if ($("#opcion").val() == 7 ||
	    $("#opcion").val() == 8 ||
	    $("#opcion").val() == 9 ||
	    $("#add").val() == 9 ||
	    $("#add").val() == 8 ||
	    $("#add").val() == 7 )
	{
	    consultar(); // se ejecuta la funcion consultar
	}
		
    });
});

//////////////////////////////////////////////////////////////////////	

$(document).ready(function () {
    $("#cursos").change(function () {
	
	console.log("Cambio de curso");
	
	if ($("#edi").val() == 5  ) {
	    cursos = $("#cursos").val();
	    
	    $("#calificador").load("modificar.php", {"cursos": cursos });
			}
		
		});
		});
		
	////////////////////////////////////////////////////////////////////////
	
	
	$(document).ready(function()
	{
		$("input[name=grupo]").click(function () { 
			alert("cambio");
			console.log("cambio el radio buton"); 
			});
        });
        
  ////////////////////////////////////////////////////////////////////////
  
  $(document).ready(function () {
  	
		$("#docentes").change(function () {
			
			console.log("Cambio de el docente");
		
			if ($("#add").val() == 8  ) {
				
				carga("#cursos","materias.php", { id : $("#id").val()});
			}
		
		});
		});
    
    
    /////////////////////////////////////////////////////////////////////
    
$(document).ready(function () {
	$("#cursos").change(function () {
			
	console.log("Cambio de la materia");
		
        if ($("#add").val() == 8 || $("#add").val() == 9) {
				
	  carga("#id_gs","grados.php",{ id : $("#id").val()});
	}
		
	});
});
    
    ///////////////////////////////////////////////////////////////////// 
    
$(document).ready(function () {
	$("#periodos").change(function () {
			
	console.log("Cambio de la periodo");
		
	if ($("#edi").val() == 12 || $("#opcion").val() == 11 || $("#add").val() == 11 ) {
				
		periodo = $("#periodos").val();
				
		$("#calificador").load("limite.php", {"periodos": periodo });
				
		}
		
        });
});
		
