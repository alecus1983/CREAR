<?php

include_once 'conexion.php';
$link = conectar();
//rutina para actualizar los niveles de escolridad
// en este caso los correspondientes a
// preescolar , primaria  y Bachillerato
// conexion con la base de datos

// datos para el formulario
$r = $link->query("select   id,
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
// array vacio
$data = array();
// contador inicia en cero
$ii = 0;

// ciclo de repeticion para mostrar los datos
while($dato = $r->fetch_array(MYSQLI_ASSOC)){
  
$data[$ii]["id"] = $dato["id"];
$data[$ii]["estudiante"] = $dato["nombre_estudiante"]." ".$dato["apellido_estudiante"];
$data[$ii]["edad"] = $dato["edad"];
$data[$ii]["genero"] = $dato["genero"];
$data[$ii]["grado"] = $dato["nombre_g"];
$data[$ii]["fecha"] = $dato["fecha"];
$data[$ii]["vicecon"] = $dato["vivecon"];

$ii ++;


}
// exporto los datos
echo json_encode($data);

 ?>
