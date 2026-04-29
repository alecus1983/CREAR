<?php
session_start();
require_once('datos.php');

if (isset($_SESSION["id_personas"])) {
    $usuario = $_SESSION["id_personas"];
    $d = new personas();
    $d->get_persona_por_id($usuario);
    $id_persona = $d->id_persona;
    $admin = $d->is_admin($id_persona);
    //echo var_dump($d);
    // ano actual
    $ano = date('Y');
    if ($admin == 0) {
        header("Location:board.php");
    }
} else {
    header("Location:board.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>calificaciones</title>
    <link href="css/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="estilos.css" rel="stylesheet" />
    <script src="js/all.js"></script>
    <link href="../imagenes/escudo.gif" rel="shortcut icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <script src="./js/sweetalert.min.js"></script>
    <script src="./js/jquery-3.5.1.min.js"></script>
    <script src="./js/fc_admin.js"></script>
    <script src="./js/personas.js"></script>
    <script src="./js/grados.js"></script>
    <script src="./js/notas.js"></script>
    <script src="./js/semanas.js"></script>
    <script src="./js/ajax.js"></script>
    <script src="./js/escolaridad.js"></script>
    <script src="./js/jornada.js"></script>
    <script src="./js/materias.js"></script>
    <script src="./js/matricula.js"></script>
    <script src="js/areas.js"></script>
    <script src="js/cursos.js"></script>
    <script src="../boostrap/css/bootstrap.css" type="text/css"></script>
    <!-- <script src="../boostrap/css/bootstrap.min.css" type="text/css"></script>-->
    <link rel="stylesheet" href="estilos.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <style>
        .loader {
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            border: 30px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid blue;
            border-right: 16px solid green;
            border-bottom: 16px solid red;
            border-left: 16px solid orange;
            width: 10rem;
            height: 10rem;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }


        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>


    <!-- scrip -->
    <script>
        // CONFIGURACION AJAX
        jQuery.ajaxSetup({
            beforeSend: function () {
                $('#loader-overlay').show();
                $('#loader').show();
                $('#tabla').html("");
            },
            complete: function () {
                $('#loader-overlay').hide();
                $('#loader').hide();
            }
        });
        //////////////////////////////////////////////////////////////////////////////////////////
        // Este script contiene la funcion para generar las graficas                            //
        // Esta foncion no recive parametros                                                    //
        //////////////////////////////////////////////////////////////////////////////////////////


        function grafica() {
            // se invoca al metodo ajax para solicitar el los datos del grafico
            $.ajax({
                type: "POST",
                url: "grafica_boletin.php",
                data: {
                    year: $("#years").val(),
                    id_gs: $("#id_g").val(),
                    id_ms: $("#id_ms").val(),
                    id_jornada: $("#jornada").val(),
                    id_docente: $("#id_docentes").val(),
                    corte: $("#corte").val(),
                    periodo: $("#periodos").val(),
                    opcion: $("#opcion").val()

                },
                // si los datos son correctos entonces ...
                success: function (respuesta) {

                    $("#grafo").html(respuesta);

                },
                error: function (xhr, status) {
                    swal('Disculpe, existió un problema');
                    console.log(xhr);
                }
            });

        }

        // funcion para cargar datos en un selector
        function carga(a, b, c) {

            console.log("Valor a: %s", a); // variable que almacena el codigo del campo
            console.log("Valor b: %s", b); // variable que almacena el nombre del archivo PHP
            console.log(JSON.stringify(c)); // parametro que se transmite  mediante ajax
            // $.post(b, c,
            $.ajax({
                async: true,
                method: "POST",
                url: b,
                data: c,
                dataType: "json",
            }).done(function (dato) {
                $(a).empty();

                $(a).append("<option value = -1> Seleccione </option>");
                $.each(dato, function (index, materia) {
                    $(a).append("<option value =" + index + ">" + materia + "</option>");
                });
            });
        }
    </script>
</head>

<body>
    <div id="loader-overlay"></div>
    <div class="loader" style="display:none" id="loader"></div>


    <div id="content">

        <?php $hoy = Date("Y-m-d hh:mm"); ?>

        <!-- barra de navegacion -->
        <nav class="navbar navbar-expand-lg  navbar-dark  bg-dark">
            <div class="container-fluid">
                <!-- Navbar Brand-->


                <img src="assets/logo.png" alt="" width="30" height="30" class="d-inline-block align-text-top">


                <a class="navbar-brand" href="board.php">INICIO</a>x

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>

                </button>

                <div class="collapse navbar-collapse" id="navbarResponsive">

                    <!-- Navbar grados y cursos-->
                    <ul class="navbar-nav" id="nv_grupos">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" id="gradosDropdown">Grupos</a>

                            <div class="dropdown-menu" aria-labelledby="gradosDropdown">
                                <div class="row">
                                    <div class="col">
                                        <a href="#" onclick="gestionar_grados();">
                                            <div class="d-flex">
                                                <div class="icon px-3 bg-warning rounded-3 fs-1"><i
                                                        class="bi bi-award"></i></div>
                                                <div class="text"> Gestionar grado</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div><a class="dropdown-item" onclick="gestionar_escolaridad();" href="#">Gestionar
                                            escolaridad</a></div>
                                    <div><a class="dropdown-item" onclick="gestionar_jornada();" href="#">Gestionar
                                            jornada</a></div>
                                    <div><a class="dropdown-item" href="#" onclick="gestion_cursos();">Gestionar
                                            curso</a></div>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <!-- Nvar de calificaciones -->

                    <ul class="navbar-nav" id="nv_calificaciones">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="calificacionesDropdown" data-bs-toggle="dropdown"
                                href="#" aria-expanded="false">Calificaciones</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="calificacionesDropdown">
                                <li><a class="dropdown-item" href="#" onclick="gestion_semanas()">Gestion semanas</a>
                                </li>
                                <li><a class="dropdown-item" href="#">Gestion periodos</a></li>
                            </ul>
                        </li>
                    </ul>

                    <!-- estructura académica -->

                    <ul class="navbar-nav" id="nv_estructura_academica">
                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" id="estructuraDropdown"
                                data-bs-toggle="dropdown" href="#" aria-expanded="false">Estructura académica</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="estructuraDropdown">
                                <li><a class="dropdown-item" href="#" onclick="gestion_materia_area();">Gestionar
                                        materia</a></li>
                                <li><a class="dropdown-item" href="#" onclick="gestion_areas();">Gestionar area</a></li>
                                <li><a class="dropdown-item" href="#" onclick="gestion_taller();">Gestionar taller</a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <!-- personas  -->
                    <ul class="navbar-nav" id="nv_roles_personas">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="personasDropdown" data-bs-toggle="dropdown" href="#"
                                aria-expanded="false">Personas y roles</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="personasDropdown">
                                <li><a class="dropdown-item" href="#" onclick="gestion_personas();">Gestionar
                                        personas</a>
                                </li>
                                <li><a class="dropdown-item" href="#" onclick="matricula_docente();">Asignar Clases</a>
                                </li>
                                <li><a class="dropdown-item" href="#" onclick="gestion_matriculas(1);">Matricular
                                        Alumno</a>
                                </li>
                                <li><a class="dropdown-item" href="#"
                                        onclick="listado_estudiantes_matriculados();">Editar
                                        matricula alumno</a></li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Gestion academica  -->
                    <ul class="navbar-nav" id="nv_roles_personas">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="personasDropdown" data-bs-toggle="dropdown" href="#"
                                aria-expanded="false">Gestion Académica</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="personasDropdown">
                                <li><a class="dropdown-item" href="#" onclick="listado_notas_estudiantes();">Listado
                                        notas por estudiantes</a> </li>
                                <li><a class="dropdown-item" href="#" onclick="avance_semanal();">Avance de notas</a>
                                </li>
                                <li><a class="dropdown-item" href="#" onclick="boletin();">Boletin</a></li>
                                <li><a class="dropdown-item" href="#" onclick="crear_pdf();">Certificado</a></li>
                                <li><a class="dropdown-item" href="#" onclick="cuadro();">Cuadro de notas</a></li>
                                <li><a class="dropdown-item" href="#" onclick="notas_faltantes();">Notas faltantes</a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Gestion docentes  -->
                    <ul class="navbar-nav" id="nv_gestion_docentes">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="docentesDropdown" data-bs-toggle="dropdown" href="#"
                                aria-expanded="false">Gestion Docentes</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="personasDropdown">
                                <li><a class="dropdown-item" href="#" onclick="listado_dcentes();">Listado docentes</a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto me-3 me-lg-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i>
                                <?php echo ucwords(strtolower($d->nombres)) . " " . ucwords(strtolower($d->apellidos)); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="logout.php">Salir</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

        </nav>




        <!-- barra de navegacion -->
        <div id="barrabotones">
            <div class="row w-100">
                <div class="col-12 col-md-4 mb-2 d-flex align-items-center">
                    <label for="years" class="text-white small me-2 mb-0">Año</label>
                    <input type="number" value="<?php echo date('Y'); ?>" id="years" name="years" min="2015" max="2100"
                        step="1"
                        style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 2px 5px; width: 100%;"
                        <?php if ($admin < 1) { ?> readonly="readonly" <?php
                        } ?> class="form-control-sm flex-grow-1">
                </div>

                <input type="hidden" value="<?php echo $id_persona; ?>" id="id_d">


                <div class="col-12 col-md-4 mb-2 d-flex align-items-center">
                    <label for="periodos" class="text-white small me-2 mb-0">Periodo</label>
                    <select id="periodos"
                        style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 2px 5px; width: 100%;"
                        name="periodos" class="form-control-sm flex-grow-1" required="" onchange="load_semanas();">
                        <option value="-1" style="color: black;" selected>seleccione</option>
                        <option value="1" style="color: black;">1</option>
                        <option value="2" style="color: black;">2</option>
                        <option value="3" style="color: black;">3</option>
                        <option value="4" style="color: black;">4</option>
                        <option value="5" style="color: black;">Recuperacion</option>
                    </select>
                </div>

                <div class="col-12 col-md-4 mb-2 d-flex align-items-center">
                    <label for="semana" class="text-white small me-2 mb-0">Semana</label>
                    <select id="semana" class="form-control-sm flex-grow-1"
                        style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 2px 5px; width: 100%;"
                        onchange="$('#semana').css('background-color', 'transparent');">
                        <?php
                        if ($admin) {
                            echo "<option style='color: black;' value='-1' selected>seleccione </option>";
                        } else {
                            $s = new semana();
                            $sem = $s->get_semana_activa($ano);
                            echo "<option style='color: black;' value='$sem' selected>$sem </option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- barra de navegacion de botones academicos-->

        <div id="botonoesacademicos">
            <div class="row w-100">
                <div class="col-12 col-sm-6 col-md-4 col-lg mb-2 d-flex align-items-center">
                    <label for="jornada" class="text-white small me-2 mb-0">Jornada</label>
                    <select id="jornada"
                        style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 2px 5px; width: 100%;"
                        class="form-control-sm flex-grow-1">
                        <option value="1" style="color: black;">Mañana</option>
                        <option value="2" style="color: black;">Tarde</option>
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-4 col-lg mb-2 d-flex align-items-center">
                    <label for="escolaridad" class="text-white small me-2 mb-0">Escolaridad</label>
                    <select id="escolaridad"
                        style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 2px 5px; width: 100%;"
                        class="form-control-sm flex-grow-1"
                        onchange="lista_grados($('#escolaridad').val(),'#id_g', $('#id_d').val());">
                        <option value="-1" style="color: black;">Seleccione</option>
                        <option value="1" style="color: black;">Preescolar</option>
                        <option value="2" style="color: black;">Básica Primaria</option>
                        <option value="3" style="color: black;">Básica Secundaria</option>
                        <option value="4" style="color: black;">Tecnico</option>
                        <option value="5" style="color: black;">Cursos</option>
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-4 col-lg mb-2 d-flex align-items-center">
                    <label class="text-white small me-2 mb-0">Grado</label>
                    <select id="id_g" name="id_gs" class="form-control-sm flex-grow-1"
                        style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 2px 5px; width: 100%;"
                        onchange="actualizar();$('#id_g').css('background-color', 'transparent');">
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-4 col-lg mb-2 d-flex align-items-center">
                    <label class="text-white small me-2 mb-0">Curso</label>
                    <select id="id_c"
                        style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 2px 5px; width: 100%;"
                        class="form-control-sm flex-grow-1">
                        <option value="0" style="color: black;">A</option>
                        <option value="1" style="color: black;">B</option>
                        <option value="2" style="color: black;">C</option>
                        <option value="3" style="color: black;">D</option>
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-4 col-lg mb-2 d-flex align-items-center">
                    <label for="id_ms" class="text-white small me-2 mb-0">Materia</label>
                    <select id="id_ms"
                        style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; padding: 2px 5px; width: 100%;"
                        name="id_ms" onchange="$('#id_ms').css('background-color', 'transparent')"
                        class="form-control-sm flex-grow-1">
                    </select>
                </div>
            </div>
        </div>

        <div>

            <div id="contenido">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">FORMULARIO <span id="ano">
                                <?php echo date('Y'); ?>
                            </span></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Para la gestistión de la plataforma CREAR</li>
                        </ol>

                        <!--  contenedores dinamicos -->
                        <div id="avance" class="row"></div>
                        <div id="grafica" class="row"></div>
                        <div id="tabla" class="row"></div>

                    </div>
                </main>
            </div>
        </div>
        <!-- fin de datos -->



    </div>
    <!-- fin de elementos -->

    <div id="collapseLayouts3" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">


    </div>
    </div><!-- fin del div del menu de botones -->

    <div class="sb-sidenav-footer">

        </nav>



    </div><!-- fin del contenido -->

    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Mundo Creativo 2026</div>
                <div>
                    <a href="#">Politica privacidad</a>
                    &middot;
                    <a href="#">Terminos &amp; Condiciones</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- -<script src="./js/bootstrap.bundle.min.js"></script> -->
    <script src="./js/scripts.js"></script>
    <script src="./js/Chart.min.js"></script>
    <script src="./assets/demo/chart-area-demo.js"></script>
    <script src="./assets/demo/chart-bar-demo.js"></script>
    <script src="./js/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="./js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"   integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script> - -->
</body>
</body>

</html>