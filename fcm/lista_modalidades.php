<?php
// archivo que obtiene la lista de modalidades de estudio
// para cargarlas en los formularios de matricula

require_once("datos.php");

// creo un nuevo objeto modalidad
$m = new modalidad();
// selecciono una lista de modalidades
$lista = $m->lista();

// encapsulo  la respuesta en modo json
echo json_encode($lista);
