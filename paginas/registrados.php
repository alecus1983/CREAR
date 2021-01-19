<?php

session_start();
// se requiere el archivo para la conexion
require_once 'conexion.php';

// se crea una conexion
$link = conectar();

echo    "<!DOCTYPE html> <html>". 
"<head>
<meta name='viewport' content='width=device-width, initial-scale=1.0'  charset='UTF-8'>

<title>Lista de inscritos</title>
<style type='text/css'>
table,td {
    border: 1px solid black;
}
@import url('estilos.css');

</style>
</head>
<body>"
;

    echo "<div id= 'contenido' class='contenido'>"."<h2>LISTADO DE INSCRITOS</h2>";
    echo "<p>A continuación se muestran el listado de inscritos a los distintos programas". 
    " y cursos que oferta la institución</p>";


    $q = "select i.nombre, i.apellido, i.cedula, i.correo, i.telefono, m.materia,
    FORMAT(DATEDIFF(CURRENT_DATE, i.nacimiento)/365,0) edad, i.fecha , e.escolaridad, 
    g.nombre_g 
    from ((( 
    inscritos i INNER JOIN escolaridad e 
    ON i.id_escolaridad = e.id_escolaridad )
    INNER JOIN 
    grados g on g.id_grado = i.id_programa )
    
    LEFT JOIN
    materia m ON i.id_materia = m.id_materia )
        
   order by fecha";


   $qx = mysqli_query( $link, $q) or die('Consulta inscritos fallida : ' . mysqli_error());


    echo "<table cellspacing='0' cellpadding='0' border='1' align='center'
    style ='background-color: lightcyan; font-size: 0.8rem;'><tr style='color: white; 
    background-color: brown; '>"
    ."<th>fecha</th>"
    ."<th>Nombre</th>"
    ."<th>Apellido</th>"
    ."<th>Cedula</th>"
    ."<th>correo</th>"
    ."<th>telefono</th>"
    ."<th>edad</th>"
    ."<th>escolaridad</th>"
    ."<th>programa</th></th>"
    ."<th>curso</th></tr>"
    ;


   // ciclo de repeticion que recupera el codigo de las materas asignadas a cada grado
   while($datos = mysqli_fetch_array($qx)) {

   	  		
           echo "<tr ><td>"
           ."<b>".$datos["fecha"]."</b>"."</td><td>"
           .$datos["nombre"]." </td><td>"
           .$datos["apellido"]."</td><td>"
           .$datos["cedula"]."</td><td>"
           .$datos["correo"]."</td><td>"
           .$datos["telefono"]."</td><td>"
           .$datos["edad"]."</td><td>"
           .utf8_encode($datos["escolaridad"])."</td><td>"
           .utf8_encode($datos["nombre_g"])."</td><td>"
           .utf8_encode($datos["materia"])
           ."</td></tr>"
           
           ;
   		

	}
	
    echo "</table></div></body></html>";

desconectar($link);
?>
