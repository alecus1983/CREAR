<?php
//////////////////////////////////////////////////////////////
// crear_tabla_ano.php                                      //
//                                                          //
// Genera la tabla de calificaciones c_{año} de un año       //
// lectivo nuevo, con la misma estructura de columnas que    //
// usan el resto de los formularios.                        //
//                                                          //
// Uso (solo por consola):                                   //
//   php crear_tabla_ano.php 2027          -> muestra el DDL //
//   php crear_tabla_ano.php 2027 --crear  -> lo ejecuta     //
//////////////////////////////////////////////////////////////

// este script modifica el esquema, no debe quedar expuesto por la web
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Este script solo se ejecuta por consola.\n");
}

require_once('conectar.php');

// ---------------------------------------------------------
// ESTRUCTURA DE LA TABLA
// ---------------------------------------------------------
//
// El año lectivo tiene 4 periodos de 8 semanas (32 semanas).
// Por cada semana hay una columna por cada corte de nota y una
// columna D{semana} con la nota de disciplina:
//
//   semanas 1-7 del periodo -> A,B,C,D,E,F,G  + D{semana}
//   la 4a semana del periodo lleva ademas una H (4H, 12H, 20H, 28H)
//   la 8a semana del periodo (8,16,24,32) es la semana final:
//        E,F,G,I,J + R{periodo} + D{semana}
//
// Al cerrar cada periodo se agregan:
//
//   D_p{periodo}  -> valoracion de disciplina del periodo
//   l1_p{periodo} -> codigo del logro (apunta a logros.id_logro)
//   l2_p{periodo}, l3_p{periodo}
//
// OJO: D_p4 no existe a proposito. generarx.php y
// generar_preescolar.php cuentan con esa ausencia y en el periodo 4
// caen a R4 / D32; get_columnas_c() en calificaciones.php consulta
// las columnas reales antes de armar el SQL. No la agregues sin
// revisar esos tres archivos.

/**
 * @brief Arma la lista de columnas de la tabla c_{año}.
 *
 * @return array Lista de definiciones "`columna` tipo" en orden.
 */
function columnas_c()
{
    // la tabla arranca por las llaves y la marca de tiempo
    $cols = array(
        "`id_alumno` int(11) NOT NULL",
        "`id_materia` int(11) NOT NULL",
        "`docente` int(11) DEFAULT NULL",
        "`modificado` datetime DEFAULT NULL"
    );

    // por cada uno de los 4 periodos
    for ($periodo = 1; $periodo <= 4; $periodo++) {

        // las 8 semanas que componen el periodo
        for ($i = 1; $i <= 8; $i++) {

            // numero de semana dentro del año (1..32)
            $semana = ($periodo - 1) * 8 + $i;

            if ($i === 8) {
                // semana final del periodo: cortes reducidos
                $letras = array('E', 'F', 'G', 'I', 'J');
            } elseif ($i === 4) {
                // la cuarta semana lleva un corte extra
                $letras = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
            } else {
                $letras = array('A', 'B', 'C', 'D', 'E', 'F', 'G');
            }

            // una columna por corte de nota
            foreach ($letras as $l) {
                $cols[] = "`" . $semana . $l . "` double DEFAULT NULL";
            }

            // en la semana final va la nota de recuperacion del periodo.
            // es double porque las notas llevan decimales (3.5, 4.2 ...)
            if ($i === 8) {
                $cols[] = "`R" . $periodo . "` double DEFAULT NULL";
            }

            // nota de disciplina de la semana
            $cols[] = "`D" . $semana . "` double DEFAULT NULL";
        }

        // cierre del periodo: disciplina del periodo y logros.
        // el periodo 4 no lleva D_p4 (ver nota de arriba)
        if ($periodo < 4) {
            $cols[] = "`D_p" . $periodo . "` double DEFAULT NULL";
        }

        // los logros guardan el codigo de la tabla logros
        for ($n = 1; $n <= 3; $n++) {
            $cols[] = "`l" . $n . "_p" . $periodo . "` int(10) unsigned DEFAULT NULL";
        }
    }

    return $cols;
}

/**
 * @brief Arma la sentencia CREATE TABLE del año indicado.
 *
 * @param int $ano Año lectivo.
 * @return string Sentencia SQL.
 */
function ddl_tabla_ano($ano)
{
    $ano = (int) $ano;

    $sql = "CREATE TABLE IF NOT EXISTS `c_" . $ano . "` (\n";
    $sql .= "  " . implode(",\n  ", columnas_c()) . ",\n";
    // una sola fila por alumno y materia; ademas acelera las consultas
    // que filtran por id_alumno + id_materia, que son casi todas
    $sql .= "  PRIMARY KEY (`id_alumno`,`id_materia`),\n";
    $sql .= "  KEY `idx_materia` (`id_materia`)\n";
    $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci";

    return $sql;
}

// ---------------------------------------------------------
// EJECUCION
// ---------------------------------------------------------

// año recibido por argumento
$ano = isset($argv[1]) ? (int) $argv[1] : 0;

// valido que sea un año razonable y no un valor corrupto
if ($ano < 2000 || $ano > 2100) {
    exit("Uso: php crear_tabla_ano.php <año> [--crear]\n");
}

$sql = ddl_tabla_ano($ano);

// sin --crear solo se muestra el DDL para revisarlo
if (!isset($argv[2]) || $argv[2] !== '--crear') {
    echo $sql . ";\n\n";
    echo "-- Revise el DDL y vuelva a ejecutar con --crear para aplicarlo.\n";
    exit(0);
}

$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($db->connect_errno) {
    exit("Fallo al conectar a MySQL: " . $db->connect_error . "\n");
}

$db->set_charset(DB_CHARSET);

// si la tabla ya existe no se toca
$existe = $db->query("SHOW TABLES LIKE 'c_" . $ano . "'");

if ($existe && $existe->num_rows > 0) {
    exit("La tabla c_" . $ano . " ya existe, no se hizo ningun cambio.\n");
}

if ($db->query($sql)) {
    echo "Tabla c_" . $ano . " creada.\n";
} else {
    echo "Error al crear la tabla: " . $db->error . "\n";
}

$db->close();
?>
