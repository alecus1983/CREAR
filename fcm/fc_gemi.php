<?php
// ... (PHP code for session, database, and user data remains here)

$d = new docentes();
$d->get_docente_cc($usuario);
$id = $d->id;
$admin = $d->admin ;
$ano = date('Y');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <script src="./js/fc.js"></script>
</head>
<body class="sb-nav-fixed">
    <div><p>El usuario es <?php echo htmlspecialchars($usuario); ?></p></div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">FORMULARIO <?php echo date('Y'); ?></h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Para la gestión de calificaciones</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-filter me-1"></i>
                        Selección de Curso y Materia
                    </div>
                    <div class="card-body">
                        <form id="course-selection-form">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="years" class="form-label">Año</label>
                                    <input type="number" class="form-control" value="<?php echo date('Y'); ?>" id="years" name="years" min="2015" max="2100" step="1" <?php if ($admin == 0) echo 'readonly'; ?>>
                                </div>
                                <div class="col-md-4">
                                    <label for="periodos" class="form-label">Periodo</label>
                                    <select id="periodos" name="periodos" class="form-control" required>
                                        </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="semana" class="form-label">Semana</label>
                                    <select id="semana" class="form-control">
                                        </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="jornada" class="form-label">Jornada</label>
                                    <select id="jornada" class="form-control">
                                        <option value="1">Mañana</option>
                                        <option value="2">Tarde</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="id_g" class="form-label">Grado</label>
                                    <select id="id_g" name="id_gs" class="form-control">
                                        </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="id_ms" class="form-label">Materia</label>
                                    <select id="id_ms" name="id_ms" class="form-control">
                                        <option value="-1">Seleccione</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" id="load-students-btn">Cargar Estudiantes</button>
                        </form>
                    </div>
                </div>

                <div id="grade-entry-section" style="display: none;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Notas por Estudiante
                                </div>
                                <div class="card-body">
                                    <div id="calificador" class="table-responsive">
                                        </div>
                                    <button type="button" class="btn btn-success mt-3" id="save-grades-btn">Guardar Notas</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    </body>
</html>
