<?php

// se requiere el archivo datos.php que contiene la definicion de las clases
require('datos.php');
include_once('conexion.php');

$link = conectar();

// carga la opcion seleccionada
$opcion = $_POST["opcion"];

// si esta definida la variable año
if (isset($_POST["year"])) {

  $ano = $_POST["year"];
  if ($ano > 0) {
    $respuesta["error"] = "";
    $respuesta["codigo"] = 0;
  } else {
    $respuesta["error"] = "año no valido";
    $respuesta["codigo"] = 1;
    exit;
  }
} else {
  $respuesta["error"] = "falta variable año";
  $respuesta["codigo"] = 1;
  echo json_encode($respuesta);
  exit;
}

// valido los datos del periodo
if (isset($_POST["periodo"])) {
  $periodo = $_POST["periodo"];
  if ($periodo == "-1") {

    echo "<div class=' container px-4 alert alert-danger' role='alert'>Por favor seleccione un periodo</div>";
    exit;
  }
} else {
  echo "<div class='container px-4 alert alert-danger' role='alert'>Por favor seleccione un periodo</div>";
  exit;
}


// muestra el contenido de acuerdo a la opcion
switch ($opcion) {

    // grafica por grado
  case 13:
    // si se encuentran cargados los campos
    if (isset($ano) and isset($periodo)) {
      // nuevo objeto de conexion a la base de datos
      // se realiza la consulta
      $consulta = $link->query(
        "select CONCAT( CONCAT( CONCAT( nombre_g, '_'),   CONCAT( jornada, '_')), corte) as categoria, COUNT(*) cantidad, SUM(calificados) calificados from  (
          select nombre_g, if(j.id_jornada = 1, 'M', 'T') jornada, if(id_docente =0,0,1) calificados, corte from jornada j inner join (
            select nombre_g, id_jornada, id_docente, a1.corte from grados g2 inner join (
              select id_grado,  c.id_docente, m2.id_jornada, c.corte from calificaciones c
              inner join matricula m2
              on c.id_alumno = m2.id_alumno
              where c.year = $ano and c.periodo = $periodo) as a1
              on g2.id_grado = a1.id_grado ) as a2
              on j.id_jornada = a2.id_jornada ) as a3
              GROUP by nombre_g, jornada, corte
              order by jornada, nombre_g, corte "
      );

      // valores iniciales
      $data = array();
      $i = 0;
      $texto = "";

      echo "<p style='padding: 10px;' class='text-muted'>La siguiente lista muestra el porsentaje de calificaciones
                    realizadas en el a&ntilde;o <b>$ano</b>, en el periodo <b>$periodo</b>. M representa la jornanda ma&ntilde;ana, T la jornada tarde,  A el corte A y F el corte F  : </p>";

      // obtengo un array asociativo de la consulta
      while ($dato = $consulta->fetch_array(MYSQLI_ASSOC)) {
        // ingreso la categoria a mostrar contiene el nombre del grado
        // la jornada  y el corte

        // ingreso la cantidad de registros
        $cantidad = intval($dato["cantidad"]);
        $calificados = intval($dato["calificados"]);
        // portentaje
        $porcentaje = intval(100 * $calificados / $cantidad);

        if ($cantidad >= 0) {
          // ingreso la  cantidad de calificados
          echo "<div class='clearfix'
                              style='display: grid;grid-template-columns: auto 70%; padding-left: 10px; padding-right: 10px;'><div><p class='text-muted text-capitalize fst-italic'>" . $dato["categoria"] . "</p></div>";
          echo "<div class='progress'>
                        <div  class='progress-bar'
                              role='progressbar'
                              style='width: $porcentaje%;'
                              aria-valuenow='$porcentaje'
                              aria-valuemin='0'
                              aria-valuemax='100'>$porcentaje %
                              </div></div></div>";
        } else {

          echo "<div class='alert alert-danger' role='alert'>
                        No hay registros creados para este grado,
                        contanctese con un administrador.
                        </div>";
        }
        $i++;
        // $texto = $texto."{'categoria':'".$dato["categoria"]."', 'cantidad':".$dato["cantidad"].", 'clasificados':".$dato["calificados"]."} ,\n";
      }
    }


    break;

    // grafica por docente
  case 14:

    // si se encuentran cargados los campos
    if (isset($ano) and isset($periodo)) {
      // nuevo objeto de conexion a la base de datos
      // se realiza la consulta
      $texto = "select id_docente, docente, count(*) cantidad , sum(corte) corte ,
                100* sum(corte)/COUNT(*) porcentaje from (
                select dc.id_docente, concat(concat(dc.nombres, ' '),dc.apellidos) docente,
                id_grado, id_alumno, id_materia, nota, corte, periodo
                from docentes dc inner join
                (
                SELECT md.id_docente,  ag.id_grado, ag.id_alumno, ag.id_materia,
                periodo, nota, if(nota = 0, 0,1) corte, md.year
                from ( select * from matricula_docente where year = $ano) as  md
                inner join (
                SELECT bl.id_alumno, bl.id_grado, cl.id_materia, periodo, nota, corte, cl.year
                from calificaciones cl
                INNER join ( select * from matricula  where year = $ano ) as bl
                on cl.id_alumno = bl.id_alumno and cl.year = bl.year) as ag
                on ag.id_materia = md.id_materia and md.id_grado = ag.id_grado
                where md.year = $ano
                order by ag.id_alumno
                ) as data
                on dc.id_docente  = data.id_docente
                ) as datax
                where periodo = $periodo
                GROUP by id_docente , docente
                order by docente asc";


      $consulta = $link->query($texto);

      // valores iniciales
      $data = array();
      $i = 0;
      $texto = "";

      echo "<p style='padding: 10px;' class='text-muted'>La siguiente lista muestra el porsentaje de calificaciones
                    realizadas en el a&ntilde;o <b>$ano</b>, en el periodo <b>$periodo</b>. Cada fila corresponde al porcentaje esperado de cada docente en de los estudiantes matriculados: </p>";

      // obtengo un array asociativo de la consulta
      while ($dato = $consulta->fetch_array(MYSQLI_ASSOC)) {
        // // ingreso la cantidad de registros
        $cantidad = intval($dato["cantidad"]);
        // $calificados = intval($dato["calificados"]);
        // portentaje
        $porcentaje = intval($dato["porcentaje"]);


        // ingreso la  cantidad de calificados
        echo "<div class='clearfix'
                              style='display: grid;grid-template-columns: auto 70%; padding-left: 10px; padding-right: 10px;'><div><p class='text-muted text-capitalize fst-italic'>" . $dato["docente"] . "</p></div>";
        echo "<div class='progress'>
                        <div  class='progress-bar'
                              role='progressbar'
                              style='width: $porcentaje%;'
                              aria-valuenow='$porcentaje'
                              aria-valuemin='0'
                              aria-valuemax='100'>$porcentaje %
                              </div></div></div>";

        $i++;
        // $texto = $texto."{'categoria':'".$dato["categoria"]."', 'cantidad':".$dato["cantidad"].", 'clasificados':".$dato["calificados"]."} ,\n";
      }
    }



    break;


    // grafica por alumno
  case 15:

    break;
}
