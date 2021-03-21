<?php

// Rutina que permite obtener los datos de un estudiante inscrito
// en modo de resumen

include_once 'conexion.php';

// se genera cuna conexion
$link = conectar();


// datos para el formulario
$r = $link->query("select   id,
                estado,
                nombre_estudiante,
                apellido_estudiante,
                genero,
                gruporh,
                tipo_identificacion,
                documento_estudiante,
                lugar_exp_estudiante,
                telefono,
                direccion_estudiante,
                i.id_escolaridad,
                fecha,
                nacimiento,
                ciudad_nacimiento,
                nivelsisben,
                barrio,
                estrato,
                vivecon,
                nombre_padre,
                apellido_padre,
                correo_padre,
                telefono_padre,
                tipo_identificacion_padre,
                documento_padre,
                lugar_exp_padre,
                direccion_padre,
                barrio_padre,
                nombre_madre,
                apellido_madre,
                correo_madre,
                telefono_madre,
                tipo_identificacion_madre,
                documento_madre,
                lugar_exp_madre,
                direccion_madre,
                barrio_madre,
                g.nombre_g,
                FORMAT( DATEDIFF(CURDATE(), nacimiento )/365.25 ,0) as edad
 from inscritos i inner join grados g
 on i.id_grado = g.id_grado");
// echo "cargando ...";
// array vacio que contiene los datos a retornar
// estos datos estan asociados a las columnas de la tabla
// que resulta de la consulta.
$data = array();
// contador inicia en cero
$ii = 0;
$cantidad = $r->num_rows;
$salida = "";

echo '{"total":'.$cantidad.',"totalNotFiltered":'.$cantidad.',"rows":[{';

// ciclo de repeticion para mostrar los datos
while($dato = $r->fetch_array(MYSQLI_ASSOC)) {
  // echo var_dump($dato);

// datos a exportar en el modelo json
// que recupero de la consulta

// estado de la matricula i -> si esta inscrito y m si ya esta matriculado
$data[$ii]["estado"] = $dato["estado"];



if($dato["estado"] == "i"){
  // id de la inscripcion y enlace para llamar al proceso de matricula
  $data[$ii]["id"] = "<button type='button' style='width: 100%;border: 1px solid; background-color:gold; border-radius: 3px;' onclick='valor("
                    .$dato["id"].")'>".$dato["id"]."</button>";

}else if($dato["estado"] == "m"){
  // id de la inscripcion y enlace para llamar al proceso de matricula
  $data[$ii]["id"] = "<button type='button' style='width: 100%;background-color:lawngreen; border: 1px solid;border-radius: 3px;' onclick='valor("
                    .$dato["id"].")'>".$dato["id"]."</button>";

}

// nombre completo del estudiante
$data[$ii]["estudiante"] = $dato["nombre_estudiante"]." ".$dato["apellido_estudiante"];
// edad del estudiante
$data[$ii]["edad"] = $dato["edad"];
// documeto estudiane
$data[$ii]["documento"] = $dato["documento_estudiante"];
// genero del estudiante
$data[$ii]["genero"] = $dato["genero"];
// grado del estudiante
$data[$ii]["grado"] = $dato["nombre_g"];
// fecha de la inscripcion
$data[$ii]["fecha"] = $dato["fecha"];
$data[$ii]["vivecon"] = $dato["vivecon"];

// se acumula la cadena de caracteres
$salida = $salida.'"estado":"'.$dato["estado"].'","estudiante":"'.$data[$ii]["estudiante"]
.'","edad":"'.$dato["edad"].'","documento":"'.$dato["documento_estudiante"]
.'","genero":"'.$dato["genero"].'","grado":"'.$dato["nombre_g"]
.'","fecha":"'.$dato["fecha"].'","vivecon":"'.$dato["vivecon"]
.'","id":"'.$data[$ii]["id"].'"},{';

$ii ++;

}

// se retira los dos ultimos caracteres de la cadena
$salida = substr($salida,0,strlen($salida) -2);

echo $salida."]}";

$exportado = array('total' => $cantidad , 'totalNotFiltered' => $cantidad, 'rows' => $data );

//echo var_dump($exportado);
// exporto los datos
 // echo json_encode($exportado , JSON_UNESCAPED_UNICODE);




 ?>
