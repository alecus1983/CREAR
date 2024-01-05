<?php 
//requiere los objetos
require('datos_pagos.php');

<<<<<<< HEAD
$nino = new matricula(2);
echo "prueba<br>";
echo "Codigo del alumno".$nino->id_alumno;
echo "<br>El codigo del grado es  :".$nino->id_grado
=======
generar_pagos_colegio_year(2020);
//$nino = new matricula(2);
echo "prueba<br>";
echo "Codigo del alumno".$nino->id_alumno;
echo "<br>El codigo del grado es  :".$nino->id_grado;
// $pago_1 = new pagos(2,5,2022);

// genera los pagos para todas las matricuas 
// realizadas en un año
function generar_pagos_colegio_year($y){
    // creo un nuevo conjunto de matriculas por año
    $m = new matriculas_year($y);
    // por cada elemento del array matriculas ...
    foreach ($m->matriculas as $mx) {
      // genero los pagos para esa matricula
      generar_pagos_colegio($mx,2,11,$y);

    }
    
}

// generar_pagos_colegio(2,2,11,2022);
// funcion que genera los pagos del colegio 
function generar_pagos_colegio($id_m, $mes_i, $mes_f,$y){

    // ciclo for para generar los pagos
    for ($i =$mes_i; $i <= $mes_f; $i ++){
      $a = new pagos($id_m,$i,$y);
    }

}
>>>>>>> refs/remotes/origin/main

?>
