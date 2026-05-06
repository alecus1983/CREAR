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
    $year = $_POST["years"];
} else {
    $valido = false;
    $respuesta['status'] = 22;
    //$err = $err."<p class='text-danger'>Porfavor seleccione un año</p>";
}


// si los datos son validos
if ($valido) {
    // creo un nuevo objeto matricula para el año actual
    $mt = new matriculas_year($year);
    // creo un objeto jornada vacio
    $jornada = new jornada();
    // creo un objeto grado vacio
    $grado = new grados();


    // muestra el contenido html
    $html = "<p>Listado de estudiantes  matricuados en el año <b>" . $year . "</b>  </p>";

    // div que crea un afila bootrap
    $html = $html . "<div class='row'>";
    // fila de todo el ancho 
    $html = $html . " <div class='col-md-12 '>";
    //  apertura de fila y columna de ancho de cinco
    $html = $html . "<div class='row'>";
    $html = $html . "<div class='col-5'>";
    $html = $html . "</div>";
    $html = $html . "</div>";

    $html = $html . "<label> <i>introduzca el texto parte del texto a buscar :</i> </label><input type='txt' id='in_certificado' class='form-control' placeholder='introduzca el texto aqui'></input>";
    // inicio la creacion de la tabla
    $html = $html . "<table class='table' id='tabla-certificados' data-url='json/data1.json'  data-filter-control='true'  data-show-search-clear-button='true'>";
    $html = $html . "<thead>";
    // emcabezado de la tabla
    $html = $html . "<th scope='col'>Codigo</th>";
    $html = $html . "<th scope='col'>Nombres</th>";
    $html = $html . "<th scope='col'>D. de identidad</th>";
    $html = $html . "<th scope='col'>Jornada</th>";
    $html = $html . "<th scope='col'>Grado</th>";
    $html = $html . "<th scope='col'>Actualizar</th>";
    $html = $html . "<th scope='col'>Eliminar</th>";
    $html = $html . "</thead>";
    $html = $html . "<tbody>";

    // por cada estudiante matriculado
    foreach ($mt->matriculas as $id) {
        $gr = "";
        //creo y obtengo una matricula por su id
        $matricula = new matricula();
        $matricula->get_matricula_id($id);
        // creo y obtengo un alumno por su id
        // creo un nuevo alumno
        $alumno = new alumnos();
        $alumno->get_alumno_codigo($matricula->id_alumno);
        // obtengo los atributos de la jornada para esta matricula
        $jornada->get_jornada_por_id($matricula->id_jornada);

        $id_matricula = $matricula->id;


        if (isset($matricula->id_grado)) {
            // obtengo el nombre del grado para esta matricula
            $grado->get_grado_id($matricula->id_grado);
            $gr = $grado->grado;
            //echo  "el grado es ".$gr;

        } else {
            //echo "matricula $id sin grado";
        }

        $html = $html . "<tr>";
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
        $html = $html . $jornada->jornada;
        $html = $html . "</td>";
        $html = $html . "<td>";
        $html = $html . $grado->grado;
        $html = $html . "</td>";
        $html = $html . "<td>";
        $html = $html . "<button type='button' class='btn btn-info' onclick='crear_certificado($id_matricula);'>Certificado</button>";
        $html = $html . "</td>";
        $html = $html . "<td>";
        $html = $html . "<button type='button' class='btn btn-warning' onclick='eliminar();'>constancia</button>";
        $html = $html . "</td>";
        $html = $html . "</tr>";

    }

    $html = $html . "</tbody>";
    $html = $html . "</div>";
    $html = $html . "</div>";
    $html = $html . "</div>";
    $html = $html . " <script>
$(document).ready(function(){
  $('#in_certificado').on('keyup', function() {
    var value = $(this).val().toLowerCase();
    $('#tabla-certificados tr').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script> ";

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

//$lista = new $matriculas();
?>