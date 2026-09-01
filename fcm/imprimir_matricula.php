<?php

/**
 * imprimir_matricula.php
 * Genera un comprobante de matrícula en PDF usando la librería tFPDF.
 *
 * Parámetros GET esperados:
 *   id_alumno    – código del alumno (u_alumnos.id_alumnos)
 *   id_padre     – código de la persona padre  (personas.id_personas)
 *   id_madre     – código de la persona madre  (personas.id_personas)
 *   id_matricula – ID de la matrícula recién generada (matricula.id)
 *   fecha        – Fecha de matrícula (YYYY-MM-DD)
 */

// Capturar todo output previo (errores, warnings, espacios de archivos incluidos)
// para que tFPDF pueda enviar los headers del PDF sin problemas.
ob_start();

// Evitar que errores/warnings se impriman en el buffer de salida
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

require_once('../tfpdf/tfpdf.php');
require_once('datos.php');

// ──────────────────────────────────────────────────────────────────────────────
// Parámetros
// ──────────────────────────────────────────────────────────────────────────────
//$id_alumno    = intval($_GET['id_alumno']    ?? 0);
//$id_padre     = intval($_GET['id_padre']     ?? 0);
//$id_madre     = intval($_GET['id_madre']     ?? 0);
$id_matricula = intval($_GET['id_matricula'] ?? 0);
$fecha_raw    = $_GET['fecha'] ?? date('Y-m-d');


$mt = new matricula();
$mt->get_matricula_id($id_matricula);

$id_alumno = $mt->id_alumno;
$fecha_raw = $mt->fecha;

// Formateamos la fecha al estilo dd/mm/YYYY
$fecha_obj = DateTime::createFromFormat('Y-m-d', $fecha_raw);
$fecha     = $fecha_obj ? $fecha_obj->format('d/m/Y') : $fecha_raw;

//obtengo los atributos de la clase padre
$alumno = new alumnos();
// obtego 
$id_padre = $alumno->get_padre_alumno($id_alumno);
$id_madre = $alumno->get_madre_alumno($id_alumno);

$padre_per = new personas();
$padre_per->get_persona_por_id($id_padre);

$madre_per = new personas();
$madre_per->get_persona_por_id($id_madre);
// ──────────────────────────────────────────────────────────────────────────────
// Helper: UTF-8 → ISO-8859-1  (necesario para FPDF/tFPDF en modo no-unicode)
// ──────────────────────────────────────────────────────────────────────────────
function enc(string $s): string
{
    return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $s) ?: $s;
}

// ──────────────────────────────────────────────────────────────────────────────
// Helper: convierte el código numérico de tipo_identificacion al nombre
// ──────────────────────────────────────────────────────────────────────────────
function tipo_id_nombre($codigo): string
{
    $mapa = [
        1 => 'Tarjeta de identidad',
        2 => 'Cedula de ciudadania',
        3 => 'Cedula de extranjeria',
        4 => 'Visa',
        5 => 'Permiso de proteccion temporal',
        6 => 'Permiso especial de permanencia',
    ];
    return $mapa[(int)$codigo] ?? (string)$codigo;
}

// ──────────────────────────────────────────────────────────────────────────────
// Obtener datos del alumno (persona + matrícula académica)
// ──────────────────────────────────────────────────────────────────────────────
$al_obj = new alumnos();
$al_obj->get_alumno_codigo($id_alumno);   // carga id_persona + todos los atributos de personas

// Datos académicos de la matrícula
$mt_obj = new matricula();
$mt_obj->get_matricula_id($id_matricula); // carga id_grado, id_jornada, id_curso, year

// Graba la fecha actual en la columna `fecha` de la tabla matricula
if ($id_matricula > 0) {
    $mt_obj->set_fecha();
}

// Grado
$gr_obj = new grados();
$gr_obj->get_grado_id($mt_obj->id_grado ?? 0);

// Jornada
$jo_obj = new jornada();
$jo_obj->get_jornada_por_id($mt_obj->id_jornada ?? 0);

// Curso
$cu_obj = new curso();
$cu_obj->get_curso_por_id($mt_obj->id_curso ?? 0);

// ──────────────────────────────────────────────────────────────────────────────
// Obtener datos del padre
// ──────────────────────────────────────────────────────────────────────────────

// ──────────────────────────────────────────────────────────────────────────────
// Obtener datos de la madre
// ──────────────────────────────────────────────────────────────────────────────


// ──────────────────────────────────────────────────────────────────────────────
// Clase PDF personalizada
// ──────────────────────────────────────────────────────────────────────────────
class PDF extends tFPDF
{
    public $numero_matricula = '';
    public $fecha_matricula  = '';

    function Header()
    {
        // Logo institucional
        if (file_exists('../imagenes/logo_boletin.png')) {
            $this->Image('../imagenes/logo_boletin.png', 10, 8, 60, 18);
        }

        $this->SetFont('Arial', 'B', 15);
        $this->SetXY(55, 10);
        $this->Cell(145, 8, enc('COMPROBANTE DE MATRÍCULA'), 0, 1, 'C');

        $this->SetFont('Arial', '', 10);
        $this->SetX(55);
        $this->Cell(
            145,
            6,
            enc('No. Matrícula: ' . $this->numero_matricula .
                '    Fecha: ' . $this->fecha_matricula),
            0,
            1,
            'C'
        );

        $this->Ln(4);
        $this->SetDrawColor(60, 60, 60);
        $this->SetLineWidth(0.5);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(4);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 7);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(
            0,
            5,
            enc('Este documento es un comprobante oficial de matrícula. Consérvelo para sus registros.'),
            0,
            0,
            'C'
        );
        $this->Ln(4);
        $this->Cell(
            0,
            5,
            enc('Tel: 829 602 8443640 | Cel: 3166288374 | administrativo@imcreativo.edu.co | www.imcreativo.edu.co'),
            0,
            0,
            'C'
        );
    }

    /**
     * Dibuja la barra de título de una sección usando Cell.
     *
     * @param string $titulo  Texto del encabezado de sección
     */
    function titulo_seccion(string $titulo): void
    {
        $this->SetFillColor(40, 40, 40);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(190, 6, enc(' ' . strtoupper($titulo)), 1, 1, 'L', true);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 9);
    }

    /**
     * Dibuja una fila de datos en dos columnas usando Cell.
     * Cada columna ocupa 95 mm: label con fondo gris, valor sin fondo.
     *
     * @param string $label1  Etiqueta de la columna izquierda
     * @param string $valor1  Valor de la columna izquierda
     * @param string $label2  Etiqueta de la columna derecha (vacío = celda en blanco)
     * @param string $valor2  Valor de la columna derecha
     */
    function fila(string $label1, string $valor1, string $label2 = '', string $valor2 = ''): void
    {
        // Anchos fijos: etiqueta 38 mm, valor 57 mm (total 95 mm por columna)
        $wl = 32;
        $wv = 63;

        // Columna izquierda
        $this->SetFillColor(220, 220, 220);
        $this->Cell($wl, 6, enc($label1 !== '' ? $label1 . ':' : ''), 1, 0, 'L', true);
        $this->SetFillColor(255, 255, 255);
        $this->Cell($wv, 6, enc($valor1), 1, 0, 'L');

        // Columna derecha
        if ($label2 !== '') {
            $this->SetFillColor(220, 220, 220);
            $this->Cell($wl, 6, enc($label2 . ':'), 1, 0, 'L', true);
            $this->SetFillColor(255, 255, 255);
            $this->Cell($wv, 6, enc($valor2), 1, 0, 'L');
        } else {
            // Celda vacía para completar la fila
            $this->Cell($wl + $wv, 6, '', 1, 0);
        }

        $this->Ln();
    }
}

// ──────────────────────────────────────────────────────────────────────────────
// Construir el PDF
// ──────────────────────────────────────────────────────────────────────────────
$pdf = new PDF();
// Número de matrícula con ceros a la izquierda, máximo 6 dígitos
$pdf->numero_matricula = sprintf('%06d', min($id_matricula, 999999));
$pdf->fecha_matricula  = $fecha;

$pdf->SetMargins(10, 35, 10);
$pdf->SetAutoPageBreak(true, 22);
$pdf->AddPage();

// Helper: convierte campo bit/bool a Sí / No / ''
$yn = static function ($v): string {
    if ($v === null || $v === '') return '';
    return ($v == 1 || $v === "\x01" || $v === true) ? 'Sí' : 'No';
};

// ── Datos de la matrícula ────────────────────────────────────────────────────
$pdf->titulo_seccion('Datos de la Matrícula');
// $pdf->fila('No. Matrícula', (string)$id_matricula,  'Fecha',   $fecha);
// $pdf->fila('Año lectivo',   (string)($mt_obj->year ?? ''), 'Grado', $gr_obj->grado ?? '');
// $pdf->fila('Jornada',       $jo_obj->jornada ?? '',  'Curso',   $cu_obj->curso ?? '');
// $pdf->Ln(3);

// Columna izquierda
$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(22, 6, enc('No. Matrícula' !== '' ? 'No. Matrícula' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(18, 6, enc((string)$id_matricula), 1, 0, 'L');

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(12, 6, enc('Fecha' !== '' ? 'Fecha' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(20, 6, enc($fecha), 1, 0, 'L');

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(34, 6, enc('Nombres y apellidos' !== '' ? 'Nombres y apellidos' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(56, 6, enc(trim(($al_obj->nombres ?? '') . ' ' . ($al_obj->apellidos ?? '')) !== '' ? trim(($al_obj->nombres ?? '') . ' ' . ($al_obj->apellidos ?? '')) : ''), 1, 0, 'L', true);


$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(20, 6, enc('Estrato' !== '' ? 'Estrato' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(8, 6, enc($al_obj->estrato ?? ''), 1, 0, 'L', true);

$pdf->Ln();

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(30, 6, enc('Tipo identificacion' !== '' ? 'Tipo identificacion' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(35, 6, enc(tipo_id_nombre($al_obj->tipo_identificacion ?? '')), 1, 0, 'L', true);


$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(22, 6, enc('Identificacion' !== '' ? 'Identificacion' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(45, 6, enc($al_obj->identificacion ?? ''), 1, 0, 'L', true);

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(35, 6, enc('Fecha de nacimiento' !== '' ? 'Fecha de nacimiento' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(23, 6, enc($al_obj->fecha_nacimiento ?? ''), 1, 0, 'L', true);


$pdf->Ln();

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(25, 6, enc('Correo' !== '' ? 'Correo' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(65, 6, enc($al_obj->correo ?? ''), 1, 0, 'L', true);

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(30, 6, enc('Correo institucional' !== '' ? 'Correo institucional' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(70, 6, enc($al_obj->i_correo ?? ''), 1, 0, 'L', true);

$pdf->Ln();

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(15, 6, enc('Celular' !== '' ? 'Celular' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(20, 6, enc($al_obj->celular ?? ''), 1, 0, 'L', true);

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(15, 6, enc('Telefono' !== '' ? 'Telefono' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(20, 6, enc($al_obj->telefono ?? ''), 1, 0, 'L', true);


$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(20, 6, enc('Dirección' !== '' ? 'Dirección' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(50, 6, enc($al_obj->direccion_residencia ?? ''), 1, 0, 'L', true);

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(20, 6, enc('Barrio' !== '' ? 'Barrio' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(30, 6, enc($al_obj->barrio ?? ''), 1, 0, 'L', true);

$pdf->Ln();


// ── Información socioeconómica ───────────────────────────────────────────────
$pdf->titulo_seccion('Informacion Socioeconomica');
$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(15, 6, enc('Sisben' !== '' ? 'Sisben' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(10, 6, enc($al_obj->sisben ?? ''), 1, 0, 'L', true);

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(30, 6, enc('Renta ciudadana' !== '' ? 'Renta ciudadana' . ':' : ''), 1, 0, 'L', true);

if ($al_obj->familias_accion == 1) {
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(10, 6, enc('Si'), 1, 0, 'L', true);
} else {
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(10, 6, enc('No'), 1, 0, 'L', true);
}


$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(30, 6, enc('Regimen de salud' !== '' ? 'Regimen de salud' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);

if ($al_obj->regimen_salud == 1) {
    $pdf->Cell(9, 6, enc('Si'), 1, 0, 'L', true);
} else {
    $pdf->Cell(9, 6, enc('No'), 1, 0, 'L', true);
}

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(10, 6, enc('EPS' !== '' ? 'EPS' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(37, 6, enc($al_obj->eps ?? ''), 1, 0, 'L', true);

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(9, 6, enc('IPS' !== '' ? 'IPS' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(30, 6, enc($al_obj->ips ?? ''), 1, 0, 'L', true);

$pdf->Ln();

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(25, 6, enc('Tipo de sangre' !== '' ? 'Tipo de sangre' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(10, 6, enc($al_obj->tipo_sangre ?? ''), 1, 0, 'L', true);

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(9, 6, enc('RH' !== '' ? 'RH' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(10, 6, enc($al_obj->rh ?? ''), 1, 0, 'L', true);


//$pdf->SetFillColor(220, 220, 220);
//$pdf->Cell(25, 6, enc('Victima conflicto' !== '' ? 'Victima conflicto' . ':' : ''), 1, 0, 'L', true);
//$pdf->SetFillColor(255, 255, 255);
//$pdf->Cell(10, 6, enc($al_obj->victima_conflicto ?? ''), 1, 0, 'L', true);

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(30, 6, enc('Victima del conflicto armado' !== '' ? 'Victima del conflicto armado' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
if ($al_obj->victima_conflicto) {
    $pdf->Cell(20, 6, enc('Si'), 1, 0, 'L', true);
} else {
    $pdf->Cell(20, 6, enc('No'), 1, 0, 'L', true);
}

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(30, 6, enc('Municipio expulsor' !== '' ? 'Municipio expulsor' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(30, 6, enc($al_obj->municipio_expulsor ?? ''), 1, 0, 'L', true);


$pdf->Ln();

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(25, 6, enc('Discapacitado' !== '' ? 'Discapacitado' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);

if ($al_obj->discapacitado) {
    $pdf->Cell(10, 6, enc('Si'), 1, 0, 'L', true);
} else {
    $pdf->Cell(10, 6, enc('No'), 1, 0, 'L', true);
}

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(35, 6, enc('Tipo de discapacidad' !== '' ? 'Tipo de discapacidad' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(41, 6, enc($al_obj->tipo_discapacidad ?? ''), 1, 0, 'L', true);

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(39, 6, enc('Capacidad excepcional' !== '' ? 'Capacidad excepcional' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(40, 6, enc($al_obj->capacidad_excepcional ?? ''), 1, 0, 'L', true);


$pdf->Ln();

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(32, 6, enc('Etnia' !== '' ? 'Etnia' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);

if ($al_obj->etnia) {
    $pdf->Cell(10, 6, enc('Si'), 1, 0, 'L', true);
} else {
    $pdf->Cell(10, 6, enc('No'), 1, 0, 'L', true);
}

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(23, 6, enc('Tipo de etnia' !== '' ? 'Tipo de etnia' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(30, 6, enc($al_obj->tipo_etnia ?? ''), 1, 0, 'L', true);

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(20, 6, enc('Resguardo' !== '' ? 'Resguardo' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(30, 6, enc($al_obj->resguardo ?? ''), 1, 0, 'L', true);

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(15, 6, enc('Consejo' !== '' ? 'Consejo' . ':' : ''), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(24, 6, enc($al_obj->consejo ?? ''), 1, 0, 'L', true);

$pdf->Ln();



// ── Antecedentes patológicos ─────────────────────────────────────────────────
//$pdf->titulo_seccion('Antecedentes Patologicos');
$pdf->fila('Medicos',       $al_obj->antecedentes_patologicos_medicos      ?? '', 'Quirurgicos',  $al_obj->antecedentes_patologicos_quirurgicos  ?? '');
$pdf->fila('Toxicos',       $al_obj->antecedentes_patologicos_toxicos      ?? '', 'Psiquiatricos', $al_obj->antecedentes_patologicos_psiquiatricos ?? '');
$pdf->fila('Psicologicos',  $al_obj->antecedentes_patologicos_psicologicos ?? '', 'Morbilidad',   $al_obj->antecedentes_patologicos_morbilidad   ?? '');


// ── Datos del padre ──────────────────────────────────────────────────────────
if ($id_padre > 0) {
    $pdf->titulo_seccion('Datos del Padre');
    $pdf->SetFillColor(220, 220, 220);
    $pdf->cell(32, 6, 'Nombre completo', 1, 0, 'L', true);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->cell(158, 6, trim(($padre_per->nombres ?? '') . ' ' . ($padre_per->apellidos ?? '')), 1, 0, 'L', true);
    $pdf->Ln();
    $pdf->fila('Tipo identificacion', tipo_id_nombre($padre_per->tipo_identificacion ?? ''), 'Identificacion', $padre_per->identificacion ?? '');
    $pdf->fila('Fecha de nacimiento', $padre_per->nacimiento          ?? '', 'Correo',         $padre_per->correo         ?? '');
    $pdf->fila('Celular',             $padre_per->celular             ?? '', 'Telefono',        $padre_per->telefono       ?? '');
}

// ── Datos de la madre ────────────────────────────────────────────────────────
if ($id_madre > 0) {
    $pdf->titulo_seccion('Datos de la Madre');
    $pdf->SetFillColor(220, 220, 220);
    $pdf->cell(32, 6, 'Nombre completo', 1, 0, 'L', true);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->cell(158, 6, trim(($madre_per->nombres ?? '') . ' ' . ($madre_per->apellidos ?? '')), 1, 0, 'L', true);
    $pdf->Ln();
    $pdf->fila('Tipo identificacion', tipo_id_nombre($madre_per->tipo_identificacion ?? ''), 'Identificacion', $madre_per->identificacion ?? '');
    $pdf->fila('Fecha de nacimiento', $madre_per->nacimiento          ?? '', 'Correo',         $madre_per->correo         ?? '');
    $pdf->fila('Celular',             $madre_per->celular             ?? '', 'Telefono',        $madre_per->telefono       ?? '');
    $pdf->Ln();
}

// ── Área de firmas ───────────────────────────────────────────────────────────
$pdf->Ln(25);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(95, 5, '_______________________________', 0, 0, 'C');
$pdf->Cell(95, 5, '_______________________________', 0, 1, 'C');
$pdf->Cell(95, 5, enc('Firma del Rector / Director'),  0, 0, 'C');
$pdf->Cell(95, 5, enc('Firma del Padre / Madre / Acudiente'), 0, 1, 'C');

// ── Salida al navegador ──────────────────────────────────────────────────────
// Limpiar TODOS los niveles de output buffer activos (pueden ser varios si
// datos.php u otros archivos iniciaron sus propios buffers) para que tFPDF
// pueda enviar sus propios headers HTTP sin conflicto.
while (ob_get_level() > 0) {
    ob_end_clean();
}
$pdf->Output('I', 'matricula_' . $id_matricula . '.pdf');
