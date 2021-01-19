<?php
///////////////////////////////////////////////////////////////////////////////
//                                                                           //
// Este fichero contiene el condigo para leer el tiempo maximo               //
// de entrega de los formularios, lo cual implica que tenga como entrada     //
// la fecha actual y como  salida un string o texto  que incluya el          //
// tiempo restante o/y  la fecha de entrega a ser ubicada en la parte        //
// superior de la pagina.                                                    //
//                                                                           //
// Este fichero es absedido por la pagina formularo.php                      //
// la cual utiliza ajax  mediante en metodo load                             //
// asincrono                                                                 //
//                                                                           //
///////////////////////////////////////////////////////////////////////////////  

// requiere en archivo para establecer la conexion
require_once 'conexion.php';
// almacena la conexion con la base de datos en la variable $link
$link = conectar();

header("Content-Type: application/json", true);

// array que contiene los datos de salida
$data = array();
// en esta linea de codigo establesco
// el tiempo restante para que caduque la entrega
// de boletines.

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

if($entrega >= $hoy) {
    
    $segundos=strtotime($entrega) - strtotime('now');
    $diferencia_dias=intval($segundos/60/60/24);
    //$fecha = $hoy->diff($entrega);
    // almacena el string de salida para la respuesta
    $data["texto"]= "<font color='green'>, La fecha de entrega es : "
    .$entrega." , restan ".$diferencia_dias." dias </font></b>";
}

else {
    $data["texto"]= "<font color='red'> Entrega de notas cerrada </font>";
}
// almaceno la fecha de entrega
$data["entrega"]= $entrega;
// almaceno la fecha de hoy
$data["hoy"] = $hoy;
//almaceno el periodo actual
$data["periodo"] = $periodo_act;
// almaceno el corte actual
$data["corte"]= $corte_act;
echo json_encode($data);

//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
desconectar($link);

exit ();
   
?>
