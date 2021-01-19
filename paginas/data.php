<?php
// Connect to MySQL
require 'conexion.php';
$con = conectar();



// se  recupera el nombre por el método POST

        $year = '2019';//$_GET["year"];//'PST';//'THDV';//
        $periodo = 1;//$_GET["periodo"];//'2014-01-01';//
        //$fin = $_GET["fin"];//'2015-01-01';//
        //$circuito = $_GET["circuito"];//'1719';//'06CAB1138';//






// se crea el texto de la consulta
$query = 'SELECT sum( IF( C.nota =0, 0, 1 ) ) nota, '
        . 'sum( IF( C.nota =0, 1, 0 ) ) cero, '
        . 'C.year year, periodo, G.grado grado '
        . 'FROM (calificaciones C INNER JOIN matricula M '
        . 'ON  M.id_alumno = C.id_alumno) '
        . 'INNER JOIN grados G ON G.id = M.grado '
        . 'WHERE C.year ='.$year.
        ' AND  periodo = '.$periodo.
        ' GROUP BY C.year, periodo, grado';
//echo "Consulta : ".$query."<br>";
$result = mysqli_query( $con, $query) ;//or die('no se encuentra el nombre: ' . mysql_error());

// All good?
if ( !$result ) {
  // Nope
  $message  = 'Invalid query: ' . mysqli_error() . "\n";
  $message .= 'Whole query: ' . $query;
  die( $message );
}



// Print out rows
$prefix = '';
echo "[\n";
while ( $row = mysql_fetch_assoc( $result ) ) {
  echo $prefix . " {\n";
  echo '  "category": "' . $row['grado'] . '",' . "\n";

  echo '  "nota": ' . $row['nota'] . ',' . "\n";
  echo '  "cero": ' . $row['cero'] . ',' . "\n";

  echo " }";
  $prefix = ",\n";
}
echo "\n]";

// Close the connection
desconectar($con);
?>
