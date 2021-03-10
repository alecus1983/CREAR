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

// array vacio que contiene los datos a retornar
// estos datos estan asociados a las columnas de la tabla
// que resulta de la consulta.
$data = array();
// contador inicia en cero
$ii = 0;
$cantidad = $r->num_rows;

// ciclo de repeticion para mostrar los datos
while($dato = $r->fetch_array(MYSQLI_ASSOC)) {

// datos a exportar en el modelo json
// que recupero de la consulta

// estado de la matricula i -> si esta inscrito y m si ya esta matriculado
$data[$ii]["estado"] = $dato["estado"];

if($dato["estado"] == "i"){
  // id de la inscripcion y enlace para llamar al proceso de matricula
  $data[$ii]["id"] = "<button style='width: 100%;border: 1px solid; background-color:gold; border-radius: 3px;' onclick=valor_incripcion("
                    .$dato["id"].");>".$dato["id"]."</button>";

}else if($dato["estado"] == "m"){
  // id de la inscripcion y enlace para llamar al proceso de matricula
  $data[$ii]["id"] = "<button style='width: 100%;background-color:lawngreen; border: 1px solid;border-radius: 3px;' onclick=valor_incripcion("
                    .$dato["id"].");>".$dato["id"]."</button>";

}

// nombre completo del estudiante
$data[$ii]["estudiante"] = $dato["nombre_estudiante"]." ".$dato["apellido_estudiante"];
// edad del estudiante
$data[$ii]["edad"] = $dato["edad"];
// genero del estudiante
$data[$ii]["genero"] = $dato["genero"];
// grado del estudiante
$data[$ii]["grado"] = $dato["nombre_g"];
// fecha de la inscripcion
$data[$ii]["fecha"] = $dato["fecha"];
$data[$ii]["vicecon"] = $dato["vivecon"];

$ii ++;

}

$exportado = array('total' => $cantidad , 'totalNotFiltered' => $cantidad, 'rows' => $data );
// exporto los datos
echo json_encode($exportado);

 ?>
