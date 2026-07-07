<?php

/**
 * @class calificaciones
 * @brief Clase que gestiona las calificaciones de los estudiantes en el colegio.
 *
 * Esta clase se encarga de las operaciones relacionadas con las notas,
 * recuperaciones y logros de los alumnos. Hereda de la clase `imcrea`,
 * asumiendo que esta clase maneja la conexión a la base de datos.
 */


/*
METODOS GET

Método	Parámetros	Descripción
get_calificacion_semanal_bulk()	$id_a, $id_m, $id_s, $y, $id_p	Busca la nota semanal de un alumno por materia, semana y ponderado. Asigna los datos al objeto o marca $calificado = false.
get_recuperacion_periodo()	$id_a, $id_m, $y, $periodo	Busca si el alumno tiene nota de recuperación (corte = 'R') en un período.
get_nota_periodo()	$id_a, $id_m, $periodo, $year	Calcula la nota final de un período. Usa AVG() para "Disciplina" (id=20) y fórmula ponderada para el resto.
get_rendimiento_alummno_periodo()	$id_a, $id_m, $ano, $id_periodo	Retorna un array con la cantidad de calificaciones por tipo de ponderado.
get_logro_id()	$id_logro	Busca en la tabla logros y asigna la descripción del logro al objeto.
get_logro()	$id_a, $id_m, $y, $id_periodo	Obtiene el logro asignado a un alumno en una materia y período.
get_docente_semana()	$id_docente, $ano, $semana	Cuenta cuántas calificaciones ha ingresado un docente en una semana. Retorna int.
get_criterio_faltantes()	$id_e, $id_m, $id_s, $p, $year	Retorna un array con los criterios de evaluación que faltan para el alumno en semanas anteriores a $id_s.


METODOS SET

set_calificacion_semanal()	$id_a, $id_m, $nota, $id_d, $p, $y, $id_p, $id_s	Inserta una nota semanal. Recalcula el período $p automáticamente según el número de semana (1–8 → P1, 9–16 → P2, etc.) usando un switch.
set_recuperacion()	$id_a, $id_m, $nota, $id_d, $p, $y	Inserta un registro de recuperación con corte = 'R'.
set_logro()	$id_a, $id_m, $logro, $id_d, $p, $y	Inserta un logro con nota = 0.


METODOS UPDATE

update_calificacion_semanal()	$id, $nota, $year	Actualiza la nota de una calificación semanal por su id.
update_recuperacion()	$id, $nota, $year	Actualiza la nota de una recuperación por su id.
update_logro()	$id, $logro, $year	Actualiza el id_logro de un registro de calificación.


max_calificaciones()	$id_docente, $year	Calcula el total máximo de calificaciones esperadas de un docente, cruzando matricula_docente con matricula. Retorna int.

*/


class calificaciones extends imcrea
{
    /**
     * @var bool $calificado
     * @brief Indica si una calificación existe (1) o no (0).
     */
    public $calificado;

    /**
     * @var int $id_alumno
     * @brief Código del alumno.
     */
    public $id_alumno;

    /**
     * @var int $id_materia
     * @brief Código de la materia.
     */
    public $id_materia;

    /**
     * @var int $id_semana
     * @brief Código de la semana.
     */
    public $id_semana;

    /**
     * @var int $year
     * @brief Año lectivo.
     */
    public $year;

    /**
     * @var int $id_ponderado
     * @brief Código del ponderado (ej. Examen, Taller, Tarea).
     */
    public $id_ponderado;

    /**
     * @var float $nota
     * @brief Nota asignada.
     */
    public $nota;

    /**
     * @var int $id
     * @brief Clave primaria de la tabla de calificaciones.
     */
    public $id;

    /**
     * @var string $logro
     * @brief Descripción del logro.
     */
    public $logro;

    /**
     * @var int $id_logro
     * @brief Código de identificación del logro.
     */
    public $id_logro;

    // ---

    /**
     * @brief Constructor de la clase `calificaciones`.
     *
     * Crea una instancia de calificación vacía y hereda la conexión a la base de datos
     * de la clase padre `imcrea`.
     */
    public function __construct()
    {
        parent::__construct();
    }

    // ---

    /**
     * @brief Obtiene la calificación semanal de un alumno.
     *
     * @param int $id_a     Código del alumno.
     * @param int $id_m     Código de la materia.
     * @param int $id_s     Código de la semana.
     * @param int $y        Año lectivo.
     * @param int $id_p     Código del ponderado.
     *
     * Este método consulta la base de datos para buscar una calificación específica
     * y, si la encuentra, la asigna a los atributos del objeto.
     */
    public function get_calificacion_semanal_bulk($id_a, $id_m, $y)
    {
        $q = "SELECT id_alumno, id, id_materia FROM c_" . $y . " WHERE id_alumno = $id_a AND id_materia = $id_m";

        try {
            $c = $this->_db->query($q);
            $r = $c->fetch_array(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }

        if (is_null($r)) {
            $this->calificado = false;
            $this->nota = 0;
        } else {
            $this->calificado = true;
            $this->id_alumno = $r['id_alumno'];
            $this->id_materia = $r['id_materia'];
            $this->id_semana = $r['id_semana'];
            $this->year = $r['year'];
            $this->id_ponderado = $r['id_ponderado'];
            $this->id = $r['id'];
            $this->nota = $r['nota'];
        }
    }

    // ---

    /**
     * @brief Obtiene las recuperaciones de un alumno en un período.
     *
     * @param int $id_a     Código del alumno.
     * @param int $id_m     Código de la materia.
     * @param int $y        Año de la consulta.
     * @param int $periodo  Identificación del período.
     *
     * Este método busca en la base de datos si un alumno tiene una nota de recuperación ('R')
     * en una materia y período específicos.
     */
    public function get_recuperacion_periodo($id_a, $id_m, $y, $periodo)
    {
        $q = "SELECT id_alumno, id, nota, id_materia, year, corte FROM calificaciones_" . $y . "
              WHERE year = $y AND id_alumno = $id_a AND id_materia = $id_m AND corte = 'R' AND periodo = $periodo";

        try {
            $c = $this->_db->query($q);
            $r = $c->fetch_array(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }

        if (is_null($r)) {
            $this->calificado = false;
            $this->nota = 0;
        } else {
            $this->calificado = true;
            $this->id_alumno = $r['id_alumno'];
            $this->id_materia = $r['id_materia'];
            $this->year = $r['year'];
            $this->id = $r['id'];
            $this->nota = $r['nota'];
        }
    }

    // ---

    /**
     * @brief Calcula la nota de un alumno en un período.
     *
     * @param int $id_a     Código del alumno.
     * @param int $id_m     Código de la materia.
     * @param int $periodo  Período de la evaluación.
     * @param int $year     Año lectivo.
     *
     * Calcula la nota final del período. Si la materia es "Disciplina" (id_materia = 20),
     * calcula el promedio. Para otras materias, usa una fórmula ponderada.
     */
    public function get_nota_periodo($id_a, $id_m, $periodo, $year)
    {
        if ($id_m == 20) {
            $q = "SELECT AVG(nota) AS nota FROM calificaciones_" . $year . "
                  WHERE id_alumno = $id_a AND id_materia = $id_m AND periodo = $periodo AND year = $year AND id_semana > 0";
        } else {
            $q = "SELECT SUM(valor * nota) / 100 AS nota FROM ponderado AS p INNER JOIN 
                  (SELECT id_ponderado, nota FROM calificaciones_" . $year . "
                  WHERE id_alumno = $id_a AND id_materia = $id_m AND periodo = $periodo AND year = $year AND id_ponderado > 0
                  ORDER BY id_ponderado) AS cal ON cal.id_ponderado = p.id_ponderado";
        }

        try {
            $c = $this->_db->query($q);
            $r = $c->fetch_array(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }

        $this->nota = $r['nota'];
    }

    // ---

    /**
     * @brief Obtiene el rendimiento de un alumno en una materia para un período.
     *
     * @param int $id_a         Código del alumno.
     * @param int $id_m         Código de la materia.
     * @param int $ano          Año lectivo.
     * @param int $id_periodo   ID del período.
     * @return array Un array con los datos del rendimiento.
     *
     * Consulta el número de calificaciones por tipo de ponderado para un alumno, materia, año y período.
     */
    public function get_rendimiento_alummno_periodo($id_a, $id_m, $ano, $id_periodo)
    {
        $q = "SELECT p.id_ponderado, ponderado, por_periodo, cantidad FROM ponderado AS p INNER JOIN
              (SELECT id_ponderado, COUNT(*) AS cantidad FROM calificaciones_" . $ano . " WHERE id_alumno = $id_a AND id_materia = $id_m AND year = $ano AND periodo = $id_periodo
              GROUP BY id_ponderado ORDER BY id_ponderado) AS c ON p.id_ponderado = c.id_ponderado
              ORDER BY id_ponderado";

        $c = $this->_db->query($q);
        $arr = array();

        while ($r = $c->fetch_array(MYSQLI_ASSOC)) {
            array_push($arr, $r);
        }

        return $arr;
    }

    // ---

    /**
     * @brief Obtiene la descripción de un logro a partir de su ID.
     *
     * @param int $id_logro ID del logro.
     *
     * Consulta la tabla de `logros` y asigna la descripción del logro (`logro`)
     * y su ID a los atributos del objeto.
     */
    public function get_logro_id($id_logro)
    {
        $q = "SELECT * FROM logros WHERE id_logro = $id_logro";
        $c = $this->_db->query($q);
        $r = $c->fetch_array(MYSQLI_ASSOC);

        $this->logro = $r['logro'];
        $this->id_logro = $r['id_logro'];
    }

    // ---

    /**
     * @brief Obtiene el logro de un alumno para un período.
     *
     * @param int $id_a         Código del alumno.
     * @param int $id_m         Código de la materia.
     * @param int $y            Año lectivo.
     * @param int $id_periodo   ID del período.
     *
     * Busca el logro asignado a un alumno en una materia y período.
     */
    public function get_logro($id_a, $id_m, $y, $id_periodo)
    {
        $q = "SELECT * FROM calificaciones_" . $y . " WHERE year = $y AND id_alumno = $id_a AND id_materia = $id_m AND periodo = $id_periodo AND id_logro > 0";
        $c = $this->_db->query($q);
        $r = $c->fetch_array(MYSQLI_ASSOC);

        if (is_null($r)) {
            $this->calificado = false;
            $this->logro = "";
        } else {
            $this->calificado = true;
            $this->id_alumno = $r['id_alumno'];
            $this->id_materia = $r['id_materia'];
            $this->id_semana = $r['id_semana'];
            $this->year = $r['year'];
            $this->id = $r['id'];
            $this->logro = $r['id_logro'];
        }
    }

    // ---

    /**
     * @brief Establece una calificación semanal.
     *
     * @param int $id_a     Código del alumno.
     * @param int $id_m     Código de la materia.
     * @param float $nota   Nota asignada.
     * @param int $id_d     Código del docente.
     * @param int $p        Período (se recalcula en el switch).
     * @param int $y        Año lectivo.
     * @param int $id_p     Código del ponderado.
     * @param int $id_s     Código de la semana.
     *
     * Inserta una nueva calificación semanal en la tabla del año correspondiente.
     * Nota: La lógica del `switch` tiene un error y sobrescribe `$p` en cada `case`.
     */
    public function set_calificacion_semanal($id_a, $id_m, $nota, $id_d, $p, $y, $id_p, $id_s)
    {
        switch ($id_s) {
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
            case 8:
                $p = 1;
                break;
            case 9:
            case 10:
            case 11:
            case 12:
            case 13:
            case 14:
            case 15:
            case 16:
                $p = 2;
                break;
            case 17:
            case 18:
            case 19:
            case 20:
            case 21:
            case 22:
            case 23:
            case 24:
                $p = 3;
                break;
            case 25:
            case 26:
            case 27:
            case 28:
            case 29:
            case 30:
            case 31:
            case 32:
                $p = 4;
                break;
        }

        $q = "INSERT INTO calificaciones_" . $y . "
              (id_alumno, id_materia, nota, id_docente, periodo, year, modificado, id_ponderado, id_semana)
              VALUES ($id_a, $id_m, $nota, $id_d, $p, $y, NOW(), $id_p, $id_s)";

        if ($this->_db->query($q) === true) {
            $this->calificado = true;
        } else {
            $this->calificado = false;
        }
    }

    // ---

    /**
     * @brief Establece una calificación de recuperación.
     *
     * @param int $id_a     Código del alumno.
     * @param int $id_m     Código de la materia.
     * @param float $nota   Nota asignada.
     * @param int $id_d     Código del docente.
     * @param int $p        Período.
     * @param int $y        Año lectivo.
     *
     * Inserta un registro de recuperación ('R' en el campo `corte`) para un alumno en un período y materia.
     */
    public function set_recuperacion($id_a, $id_m, $nota, $id_d, $p, $y)
    {
        $q = "INSERT INTO calificaciones_" . $y . "
              (id_alumno, id_materia, nota, id_docente, periodo, year, modificado, corte)
              VALUES ($id_a, $id_m, $nota, $id_d, $p, $y, NOW(), 'R')";

        if ($this->_db->query($q) === true) {
            $this->calificado = true;
        } else {
            $this->calificado = false;
        }
    }

    // ---

    /**
     * @brief Establece un logro para un alumno en un período.
     *
     * @param int $id_a     Código del alumno.
     * @param int $id_m     Código de la materia.
     * @param int $logro    ID del logro.
     * @param int $id_d     Código del docente.
     * @param int $p        Período.
     * @param int $y        Año lectivo.
     *
     * Inserta un registro con el ID del logro en la tabla de calificaciones, con la nota en 0.
     */
    public function set_logro($id_a, $id_m, $logro, $id_d, $p, $y)
    {
        $q = "INSERT INTO calificaciones_" . $y . "
              (id_alumno, id_materia, id_logro, nota, id_docente, periodo, year, modificado)
              VALUES ($id_a, $id_m, $logro, 0, $id_d, $p, $y, NOW())";

        if ($this->_db->query($q) === true) {
            $this->calificado = true;
        } else {
            $this->calificado = false;
        }
    }

    // ---

    /**
     * @brief Actualiza la nota de una recuperación existente.
     *
     * @param int $id       ID de la calificación (recuperación).
     * @param float $nota   Nueva nota.
     * @param int $year     Año lectivo.
     *
     * Actualiza el campo `nota` de un registro de calificación específico.
     */
    public function update_recuperacion($id, $nota, $year)
    {
        $q = "UPDATE calificaciones_" . $year . " SET nota = $nota WHERE id = $id";

        if ($this->_db->query($q) === true) {
            $this->calificado = true;
        } else {
            $this->calificado = false;
        }
    }

    // ---

    /**
     * @brief Actualiza una calificación semanal existente.
     *
     * @param int $id       ID de la calificación semanal.
     * @param float $nota   Nueva nota.
     * @param int $year     Año lectivo.
     *
     * Actualiza el campo `nota` de un registro de calificación semanal.
     */
    public function update_calificacion_semanal($id, $nota, $year)
    {
        $q = "UPDATE calificaciones_" . $year . " SET nota = $nota WHERE id = $id";

        if ($this->_db->query($q) === true) {
            $this->calificado = true;
        } else {
            $this->calificado = false;
        }
    }

    // ---

    /**
     * @brief Actualiza un logro existente.
     *
     * @param int $id       ID de la calificación (logro).
     * @param int $logro    Nuevo ID del logro.
     * @param int $year     Año lectivo.
     *
     * Actualiza el campo `id_logro` de un registro de calificación.
     */
    public function update_logro($id, $logro, $year)
    {
        $q = "UPDATE calificaciones_" . $year . " SET id_logro = $logro WHERE id = $id";

        if ($this->_db->query($q) === true) {
            $this->calificado = true;
        } else {
            $this->calificado = false;
        }
    }

    // ---

    /**
     * @brief Obtiene la cantidad máxima de calificaciones que un docente debe generar.
     *
     * @param int $id_docente   ID del docente.
     * @param int $year         Año lectivo.
     * @return int La cantidad total de calificaciones esperadas.
     *
     * Calcula la suma de alumnos por grado, curso y jornada asignados a un docente.
     * La lógica del `JOIN` es bastante compleja y propensa a errores.
     */
    public function max_calificaciones($id_docente, $year)
    {
        $q = "SELECT SUM(cantidad) AS cantidad FROM
              (SELECT md.id_docente, md.id_grado, md.id_jornada, md.id_curso, id_materia, cantidad
              FROM matricula_docente AS md INNER JOIN
              (SELECT COUNT(*) AS cantidad, id_grado, id_jornada, id_curso FROM matricula WHERE year = " . $year . "
              GROUP BY id_jornada, id_grado, id_curso) AS ca
              ON ca.id_grado = md.id_grado AND ca.id_curso = md.id_curso AND ca.id_jornada = md.id_jornada
              WHERE md.year = " . $year . " AND md.id_docente = " . $id_docente . "
              ORDER BY md.id_docente, md.id_materia, md.id_grado) AS cd GROUP BY id_docente";

        $c = $this->_db->query($q);
        if ($c) {
            $r = $c->fetch_array(MYSQLI_ASSOC);
            return $r ? $r['cantidad'] : 0;
        }
        return 0;
    }

    // ---

    /**
     * @brief Obtiene la cantidad de calificaciones que un docente ha ingresado en una semana.
     *
     * @param int $id_docente   ID del docente.
     * @param int $ano          Año lectivo.
     * @param int $semana       Número de la semana.
     * @return int La cantidad de calificaciones.
     *
     * Cuenta los registros de calificación para un docente en una semana específica.
     */
    public function get_docente_semana($id_docente, $ano, $semana)
    {
        $q = "SELECT COUNT(*) AS cantidad FROM calificaciones_" . $ano . " WHERE id_docente = $id_docente AND year = $ano AND id_semana = " . $semana;

        $c = $this->_db->query($q);
        $r = $c->fetch_array(MYSQLI_ASSOC);

        return $r['cantidad'];
    }

    // ---

    /**
     * @brief Obtiene los criterios de evaluación faltantes para un estudiante.
     *
     * @param int $id_e     ID del estudiante.
     * @param int $id_m     ID de la materia.
     * @param int $id_s     ID de la semana.
     * @param int $p        Período.
     * @param int $year     Año lectivo.
     * @return array Un array de arrays asociativos con los criterios faltantes.
     *
     * Esta consulta busca qué calificaciones (según el tipo y semana) faltan para un estudiante
     * en una materia y período dados. La lógica de la consulta es compleja y podría
     * ser simplificada.
     */
    public function get_criterio_faltantes($id_e, $id_m, $id_s, $p, $year)
    {
        $q = "SELECT v.criterio, tipo, id_semana FROM 
              (SELECT CONCAT(validar, $id_m) AS criterio, tipo, id_semana FROM validar WHERE id_semana < $id_s) AS v LEFT JOIN
              (SELECT CONCAT(tipo, id_semana, id_materia) AS criterio, c.id_ponderado FROM ponderado AS p INNER JOIN 
              (SELECT id_alumno, id_semana, id_ponderado, id_materia FROM calificaciones_" . $year . " WHERE year = $year AND periodo = $p AND id_materia = $id_m AND id_semana < $id_s AND id_alumno IN ($id_e)) AS c ON c.id_ponderado = p.id_ponderado) AS n ON n.criterio = v.criterio WHERE n.criterio IS NULL";

        $c = $this->_db->query($q);
        $arr = array();

        while ($a = $c->fetch_array(MYSQLI_ASSOC)) {
            $criterio = $a['criterio'];
            $tipo = $a['tipo'];
            $semana = $a['id_semana'];
            $arr[$criterio][0] = $tipo;
            $arr[$criterio][1] = $semana;
        }

        return $arr;
    }

    // ---

    /**
     * @brief Obtiene los criterios de evaluación de una semana.
     *
     * @param int $semana Número de la semana.
     * @return array Un array numérico con los tipos de criterios.
     *
     * Consulta la tabla `validar` para obtener los tipos de criterios de evaluación
     * que se aplican en una semana determinada.
     */
    public function get_validar_periodo($semana)
    {
        $q = "SELECT tipo FROM `validar` WHERE id_semana = $semana ORDER BY tipo";
        $c = $this->_db->query($q);
        $arr = array();

        while ($a = $c->fetch_array(MYSQLI_ASSOC)) {
            $criterio = $a['tipo'];
            array_push($arr, $criterio);
        }

        return $arr;
    }

    // --- 

    /**
     * @brief Verifica si un estudiante tiene calificaciones en una materia.
     *
     * @param int $id_a     Código del alumno.
     * @param int $id_m     Código de la materia.
     * @param int $year     Año lectivo.
     * @return bool True si el estudiante tiene calificaciones, false en caso contrario.
     *
     * Consulta la tabla de calificaciones para determinar si un estudiante específico
     * tiene alguna calificación registrada en una materia durante el año lectivo.
     */
    public function get_calificacion_alumno_materia($id_a, $id_m, $year)
    {
        $q = "SELECT id_alumno, id_materia FROM c_" . $year . "
              WHERE id_alumno = $id_a AND id_materia = $id_m";

        try {
            $c = $this->_db->query($q);
            $r = $c->fetch_array(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }

        if (is_null($r)) {
            return false;
        } else {
            return true;
        }
    }

    // ---

    /**
     * @brief Obtiene las notas y logros de la semana final de un período (bulk).
     *
     * @param int    $ano         Año lectivo (sufijo de la tabla c_{$ano}).
     * @param int    $id_m        Código de la materia.
     * @param int    $periodo     Período (1-4).
     * @param int    $semana      Número de semana final (8, 16, 24 o 32).
     * @param array  $arr_pond    Array de ponderados de semana final, ej. [1=>'F', 2=>'G', ...].
     * @param string $in_alumnos  Cadena con los IDs de alumnos para cláusula IN, ej. "1,2,3".
     * @return array Array asociativo indexado por id_alumno con logros (l1, l2, l3) y notas.
     *
     * Consulta la tabla c_{$ano} para obtener de una sola vez los logros del período
     * y las notas de la semana final para todos los alumnos indicados.
     */
    public function get_notas_semana_final($ano, $id_m, $periodo, $semana, $arr_pond, $in_alumnos)
    {
        // construir campos de notas dinámicos: 8F, 8G, 8I, 8J, ...
        $campos_notas = "";

        // para obtener los campos de notas de la semana final
        foreach ($arr_pond as $v) {
            $campos_notas = $semana . $v . "," . $campos_notas;
        }

        // quito la ultima coma
        $campos_notas = substr($campos_notas, 0, -1);

        // consulta para obtener los logros y las notas de la semana final de periodo
        $q = "SELECT id_alumno, l1_p{$periodo}, l2_p{$periodo}, l3_p{$periodo}, {$campos_notas}
              FROM c_{$ano}
              WHERE id_materia = {$id_m} AND periodo = {$periodo} AND id_alumno IN ({$in_alumnos})";

        // objeto para almacenar los logros
        $resultado_logros  = [];
        // objeto para almacenar las notas
        $resultado_notas   = [];

        try {
            // ejecuto la consulta
            $c = $this->_db->query($q);
            if ($c) {

                // recorro el resultado
                while ($row = $c->fetch_assoc()) {
                    // preparo la consulta de logro 1 del periodo
                    $resultado_logros[$row['id_alumno']][0] = $row["l1_p{$periodo}"];
                    // preparo la consulta de logro 2 del periodo
                    $resultado_logros[$row['id_alumno']][1] = $row["l2_p{$periodo}"];
                    // preparo la consulta de logro 3 del periodo
                    $resultado_logros[$row['id_alumno']][2] = $row["l3_p{$periodo}"];
                    // guardo las notas
                    $resultado_notas[$row['id_alumno']]     = $row;
                }
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }

        return ['logros' => $resultado_logros, 'notas' => $resultado_notas];
    }

    // ---

    /**
     * @brief Obtiene las notas de la semana intermedia de un período (bulk).
     *
     * @param int    $ano         Año lectivo (sufijo de la tabla c_{$ano}).
     * @param int    $id_m        Código de la materia.
     * @param int    $periodo     Período (1-4).
     * @param int    $semana      Número de semana intermedia (4, 12, 20 o 28).
     * @param array  $arr_pond    Array de ponderados de semana intermedia, ej. [1=>'A', ..., 8=>'H'].
     * @param string $in_alumnos  Cadena con los IDs de alumnos para cláusula IN, ej. "1,2,3".
     * @return array Array asociativo indexado por id_alumno con las notas de la semana.
     *
     * Consulta la tabla c_{$ano} para obtener de una sola vez las notas de la semana
     * intermedia para todos los alumnos indicados en un período específico.
     */
    public function get_notas_semana_intermedia($ano, $id_m, $periodo, $semana, $arr_pond, $in_alumnos)
    {
        // construir campos de notas dinámicos: 4A, 4B, 4C, ...
        $campos_notas = "";
        foreach ($arr_pond as $v) {
            $campos_notas = $semana . $v . "," . $campos_notas;
        }
        $campos_notas = substr($campos_notas, 0, -1);

        $q = "SELECT id_alumno, {$campos_notas}
              FROM c_{$ano}
              WHERE id_materia = {$id_m} AND periodo = {$periodo}
              AND id_alumno IN ({$in_alumnos})";

        $resultado = [];

        try {
            $c = $this->_db->query($q);
            if ($c) {
                while ($row = $c->fetch_assoc()) {
                    $resultado[$row['id_alumno']] = $row;
                }
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }

        return $resultado;
    }

    // ---

    /**
     * @brief Obtiene las notas de una semana normal (bulk).
     *
     * @param int    $ano         Año lectivo (sufijo de la tabla c_{$ano}).
     * @param int    $id_m        Código de la materia.
     * @param int    $semana      Número de semana.
     * @param array  $arr_pond    Array de ponderados de semana normal, ej. [1=>'A', ..., 7=>'G'].
     * @param string $in_alumnos  Cadena con los IDs de alumnos para cláusula IN, ej. "1,2,3".
     * @return array Array asociativo indexado por id_alumno con las notas de la semana.
     *
     * Consulta la tabla c_{$ano} para obtener de una sola vez las notas de una semana
     * ordinaria para todos los alumnos indicados (sin filtro de período).
     */
    public function get_notas_semana_normal($ano, $id_m, $semana, $arr_pond, $in_alumnos)
    {
        // construir campos de notas dinámicos: 1A, 1B, 1C, ...
        $campos_notas = "";
        foreach ($arr_pond as $v) {
            $campos_notas = $semana . $v . "," . $campos_notas;
        }
        $campos_notas = substr($campos_notas, 0, -1);

        $q = "SELECT id_alumno, {$campos_notas}
              FROM c_{$ano}
              WHERE id_materia = {$id_m} AND id_alumno IN ({$in_alumnos})";

        $resultado = [];

        try {
            $c = $this->_db->query($q);
            if ($c) {
                while ($row = $c->fetch_assoc()) {
                    $resultado[$row['id_alumno']] = $row;
                }
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }

        return $resultado;
    }
}
