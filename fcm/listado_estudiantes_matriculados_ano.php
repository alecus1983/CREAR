<?php
// archivo que obtiene los docentes matriculados
// en una materia para un grado/curso/jornada

require_once("datos.php");

//variables de validacion
$valido = true;
$err = "";
//array de respuestals
$respuesta = array();

// valida si recibe la informacion del año
if ($_POST["years"] !== "") {
    $ano = $_POST["years"];
} else {
    $valido = false;
    $respuesta['status'] = 22;
}

// si los datos son validos
if ($valido) {
    // creo un nuevo objeto matricula para el año actual
    $mt = new matricula();
    // muestra el contenido html
    $html = "<p>Listado de estudiantes  matricuados en el a&oacute;o <b>" . $ano . "</b>  </p>";

    // div que crea un afila bootrap
    $html = $html . "<div class='row'>";
    // fila de todo el ancho 
    $html = $html . " <div class='col-md-12 '>";
    //  apertura de fila y columna de ancho de cinco
    $html = $html . "<div class='row'>";
    $html = $html . "<div class='col-md-5 mb-3'>";
    // filtro de busqueda: filtra las filas de la tabla por cualquier columna
    $html = $html . "<div class='input-group'>";
    $html = $html . "<span class='input-group-text'><i class='bi bi-search'></i></span>";
    $html = $html . "<input type='search' id='filtro_matriculados' class='form-control' placeholder='Buscar por matr&iacute;cula, c&oacute;digo, nombre, documento, grado o jornada'>";
    $html = $html . "</div>";
    $html = $html . "<small id='total_matriculados' class='text-muted'></small>";
    $html = $html . "</div>";
    $html = $html . "</div>";


    // inicio la creacion de la tabla
    $html = $html . "<table class='table table-hover'>";
    $html = $html . "<thead>";
    // emcabezado de la tabla
    $html = $html . "<th scope='col'>Matr&iacute;cula</th>";
    $html = $html . "<th scope='col'>Codigo</th>";
    $html = $html . "<th scope='col'>Nombres</th>";
    $html = $html . "<th scope='col'>D. de identidad</th>";
    $html = $html . "<th scope='col'>Correo</th>";
    $html = $html . "<th scope='col'>Grado</th>";
    $html = $html . "<th scope='col'>Jornada</th>";
    $html = $html . "<th scope='col'>Editar</th>";
    $html = $html . "<th scope='col'>Ver</th>";
    $html = $html . "<th scope='col'>Eliminar</th>";
    $html = $html . "</thead>";
    $html = $html . "<tbody id='tabla_matriculados'>";


    // nombres de grados y jornadas ya consultados (para no repetir la consulta por cada alumno)
    $nombres_grado = array();
    $nombres_jornada = array();

    // por cada estudiante matriculado
    foreach ($mt->get_matricula_ano($ano) as $id) {
        //creo una matricula
        $alumno = new alumnos();


        // obtengo los atrbutos de una matricula
        $alumno->get_alumno_codigo($id["id_alumno"]);

        // nombre del grado de la matricula
        if (!isset($nombres_grado[$id["id_grado"]])) {
            $gr = new grados();
            $gr->get_grado_id($id["id_grado"]);
            $nombres_grado[$id["id_grado"]] = $gr->grado ?? "";
        }

        // nombre de la jornada de la matricula
        if (!isset($nombres_jornada[$id["id_jornada"]])) {
            $jo = new jornada();
            $jo->get_jornada_por_id($id["id_jornada"]);
            $nombres_jornada[$id["id_jornada"]] = $jo->jornada ?? "";
        }

        $html = $html . "<tr>";
        $html = $html . "<td>";
        $html = $html . $id["id"];
        $html = $html . "</td>";
        $html = $html . "<td>";
        $html = $html . $alumno->id_alumno;
        $html = $html . "</td>";
        $html = $html . "<td>";
        $html = $html . $alumno->nombres . " " . $alumno->apellidos;
        $html = $html . "</td>";
        $html = $html . "<td>";
        $html = $html . $alumno->identificacion;
        $html = $html . "</td>";
        $html = $html . "<td>";
        $html = $html . $alumno->correo;
        $html = $html . "</td>";
        $html = $html . "<td>";
        $html = $html . $nombres_grado[$id["id_grado"]];
        $html = $html . "</td>";
        $html = $html . "<td>";
        $html = $html . $nombres_jornada[$id["id_jornada"]];
        $html = $html . "</td>";
        $html = $html . "<td>";
        $html = $html . '<button type="button" class="btn btn-warning" onclick="flujo_editar_matricula(' . $id["id"] . ', 31, true);">Editar</button>';
        $html = $html . "</td>";
        $html = $html . "<td>";
        $html = $html . '<button type="button" class="btn btn-outline-secondary" onclick="imprimir_matricula(' . $id["id"] . ');">Ver</button>';
        $html = $html . "</td>";
        $html = $html . "<td>";
        $html = $html . "</td>";
        $html = $html . "</tr>";
    }

    $html = $html . "</tbody>";
    $html = $html . "</div>";
    $html = $html . "</div>";
    $html = $html . "</div>";

    // parte de la respuesta HTML
    $respuesta['html'] = $html;
    $respuesta['status'] = 1;
} else {
    // no se emite respuesta
    $respuesta['html'] = "";
}
// encapsulo  la respuesta en modo json
$respuesta_json = json_encode($respuesta);
// emito la respuesta
echo $respuesta_json;
