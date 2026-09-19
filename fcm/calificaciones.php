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

(obsoleto) set_calificacion_semanal()	$id_a, $id_m, $nota, $id_d, $p, $y, $id_p, $id_s	Inserta una nota semanal. Recalcula el período $p automáticamente según el número de semana (1–8 → P1, 9–16 → P2, etc.) usando un switch.
(obsoleto) set_recuperacion()	$id_a, $id_m, $nota, $id_d, $p, $y	Inserta un registro de recuperación con corte = 'R'.
(obsoleto) set_logro()	$id_a, $id_m, $logro, $id_d, $p, $y	Inserta un logro con nota = 0.


METODOS UPDATE

(obsoleto) update_calificacion_semanal()	$id, $nota, $year	Actualiza la nota de una calificación semanal por su id.
(obsoleto) update_recuperacion()	$id, $nota, $year	Actualiza la nota de una recuperación por su id.
(obsoleto) update_logro()	$id, $logro, $year	Actualiza el id_logro de un registro de calificación.


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
     * @brief Funcion que retorna un array con los id de los alumnos que tienen
     * o no una nota consignada en la tabla c_{año}
     * @param string $codigos Codigos del alumno
     * @param int $id_materia Código de la materia
     * 
     */

    public function if_alumno_materia($codigos, $id_materia, $year)
    {

        // consulta para verificar si existe
        $q = "select * from c_{$year} where id_materia = $id_materia and id_alumno in $codigos ";
    }


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
    public function get_calificacion_semanal_bulk($id_grado, $id_curso, $id_jornada, $id_materia, $y)
    {

        $q = "select id_alumno , id_materia ,  9A,9B
                from c_$y where id_alumno in 
                ( select id_alumno from matricula
                  where id_grado = $id_grado and id_curso = $id_curso and
                  id_jornada = $id_jornada and year = $y) and id_materia = $id_materia";


        try {
            $c = $this->_db->query($q);
            $r = $c->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo 'Excepción capturada en get_calificacion_semanal_bulk: ', $e->getMessage(), "\n";
        }
        if (is_null($r)) {
            $this->calificado = false;
        } else {
            $this->calificado = true;
            return $r;
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
            echo 'Excepción capturada en get_recuperacion_periodo: ', $e->getMessage(), "\n";
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
            echo 'Excepción capturada en get_nota_periodo: ', $e->getMessage(), "\n";
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
        $q = "SELECT COUNT(*) AS cantidad FROM c_" . $ano . " WHERE id_docente = $id_docente AND year = $ano AND id_semana = " . $semana;

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
            echo 'Excepción capturada get_calificacion_alumno_materia: ', $e->getMessage(), "\n";
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
              WHERE id_materia = {$id_m} AND id_alumno IN ({$in_alumnos})";

        // objeto para almacenar los logros
        $resultado_logros = [];
        // objeto para almacenar las notas
        $resultado_notas = [];

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
                    $resultado_notas[$row['id_alumno']] = $row;
                }
            }
        } catch (Exception $e) {
            echo 'Excepción capturada en el metodo get_notas_semana_final: ', $e->getMessage(), "\n";
        }

        return ['logros' => $resultado_logros, 'notas' => $resultado_notas];
    }


    // funcion para obtener la disciplina de la semana final
    public function get_disciplina_semana_final($ano, $id_m, $periodo, $in_alumnos)
    {



        // consulta para obtener los logros y las notas de la semana final de periodo
        $q = "SELECT id_alumno, l1_p{$periodo}, D_p" . strval($periodo) . " nota
              FROM c_{$ano}
              WHERE id_materia = {$id_m} AND id_alumno IN ({$in_alumnos})";

        // objeto para almacenar los logros
        $resultado_logros = [];
        // objeto para almacenar las notas
        $resultado_notas = [];

        try {
            // ejecuto la consulta
            $c = $this->_db->query($q);
            if ($c) {

                // recorro el resultado
                while ($row = $c->fetch_assoc()) {
                    // preparo la consulta de logro 1 del periodo
                    $resultado_logros[$row['id_alumno']][0] = $row["l1_p{$periodo}"];
                    // preparo la consulta de logro 3 del periodo
                    $resultado_notas[$row['id_alumno']][0] = $row["nota"];
                }
            }
        } catch (Exception $e) {
            echo 'Excepción capturada en el metodo get_disciplina_semana_final: ', $e->getMessage(), "\n";
        }

        return ['logros' => $resultado_logros, 'notas' => $resultado_notas];
    }
    // ---

    // funcion para obtener la disciplina de la semana final
    public function get_disciplina_semana($ano, $id_m, $semana, $in_alumnos)
    {



        // consulta para obtener los logros y las notas de la semana final de periodo
        $q = "SELECT id_alumno,  D" . strval($semana) . " nota
              FROM c_{$ano}
              WHERE id_materia = {$id_m} AND id_alumno IN ({$in_alumnos})";

        // objeto para almacenar los logros
        $resultado_logros = [];
        // objeto para almacenar las notas
        $resultado_notas = [];

        try {
            // ejecuto la consulta
            $c = $this->_db->query($q);
            if ($c) {

                // recorro el resultado
                while ($row = $c->fetch_assoc()) {
                    // preparo la consulta de logro 1 del periodo
                    //$resultado_logros[$row['id_alumno']][0] = $row["l1_p{$periodo}"];
                    // preparo la consulta de logro 3 del periodo
                    $resultado_notas[$row['id_alumno']][0] = $row["nota"];
                }
            }
        } catch (Exception $e) {
            echo 'Excepción capturada en el metodo get_disciplina_semana_final: ', $e->getMessage(), "\n";
        }

        return ['notas' => $resultado_notas];
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
              WHERE id_materia = {$id_m} 
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
            echo 'Excepción capturada en get_notas_semana_intermedia: ', $e->getMessage(), "\n";
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
            echo 'Excepción capturada en get_notas_semana_normal: ', $e->getMessage(), "\n";
        }

        return $resultado;
    }



    /**
     * @brief Obtiene las notas de una semana normal (bulk).
     *
     * @param int    $ano         Año lectivo (sufijo de la tabla c_{$ano}).
     * @param int    $id_m        Código de la materia.
     * @param int    $periodo      Número de periodo.
     * @param array  $arr_pond    Array de ponderados de semana normal, ej. [1=>'A', ..., 7=>'G'].
     * @param string $in_alumnos  Cadena con los IDs de alumnos para cláusula IN, ej. "1,2,3".
     * @return array Array asociativo indexado por id_alumno con las notas de la semana.
     *
     * Consulta la tabla c_{$ano} para obtener de una sola vez las notas de una semana
     * ordinaria para todos los alumnos indicados (sin filtro de período).
     */
    public function get_notas_preescolar($ano, $id_m, $periodo, $arr_pond, $in_alumnos)
    {
        // construir campos de notas dinámicos: 1A, 1B, 1C, ...
        $campos_notas = "";
        foreach ($arr_pond as $v) {
            $campos_notas =  $v . $periodo . " ," . $campos_notas;
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
            echo 'Excepción capturada en get_notas_semana_normal: ', $e->getMessage(), "\n";
        }

        return $resultado;
    }

    // metodo para actualizar las notas semanales
    // en la tabla c_year
    public function actualizar_notas_semanales($valoresArray, $year)
    {

        // si el valor ingresado es falso
        if (empty($valoresArray))
            return false;
        //valores iniciales de las 
        $ids = [];
        $casesNota = [];
        $casesLogro = [];

        // por cada alumno preparo los array de entrada
        foreach ($valoresArray as $val) {
        }
        // convierto en un string
        $idsString = implode(',', $ids);
        $casesNotaString = implode(' ', $casesNota);
        $casesLogroString = implode(' ', $casesLogro);

        $sql = "UPDATE calificaciones_{$year} 
                SET nota = CASE id 
                    {$casesNotaString} 
                    ELSE nota 
                END,
                id_logro = CASE id 
                    {$casesLogroString} 
                    ELSE id_logro 
                END,
            
                modificado = NOW()
                WHERE id IN ({$idsString})";
    }

    // se actualizan masivamente las notas
    function actualizarNotasMasivas($arr_actualizar, $ano)
    {
        // si el valor ingresado es falso
        if (empty($arr_actualizar)) {
            return false;
        }
        $ids = [];
        $cases = [];
        $id_materia = (int) $arr_actualizar[0]['id_materia'];
        // Identificar las columnas a actualizar dinámicamente
        $columnas = [];
        foreach ($arr_actualizar[0] as $key => $val) {
            // Ignoramos las llaves predefinidas
            if (!in_array($key, ['id_alumno', 'id_materia', 'docente'])) {
                // Removemos las comillas simples que vienen en la llave desde notas_semanales_x.php
                $clean_key = str_replace("'", "", $key);
                $columnas[$key] = $clean_key;
                $cases[$clean_key] = [];
            }
        }
        // por cada alumno preparo los array de entrada
        foreach ($arr_actualizar as $val) {
            $id = (int) $val['id_alumno'];
            $ids[] = $id;
            // preparamos los cases para cada columna
            foreach ($columnas as $orig_key => $clean_col) {
                // Validar si es numérico, de lo contrario dejar NULL
                $nota = (isset($val[$orig_key]) && is_numeric($val[$orig_key])) ? (float) $val[$orig_key] : 'NULL';
                $cases[$clean_col][] = "WHEN {$id} THEN {$nota}";
            }
        }
        // convierto en un string
        $idsString = implode(',', $ids);
        // construimos la parte SET del UPDATE
        $setStatements = [];
        foreach ($cases as $col => $caseList) {
            $casesString = implode(' ', $caseList);
            // Usamos backticks (`) porque los nombres de las columnas pueden empezar por números (ej. 24E)
            $setStatements[] = "`{$col}` = CASE id_alumno {$casesString} ELSE `{$col}` END";
        }
        $setString = implode(', ', $setStatements);
        $sql = "UPDATE c_{$ano} 
                SET {$setString} , modificado ='" . date('Y-m-d H:i:s') . "'
                WHERE id_materia = {$id_materia} AND id_alumno IN ({$idsString})";

        //echo $sql;
        return $this->_db->query($sql);
    }

    function insertarNotasMasivas($arr_insertar, $ano)
    {

        try {
            if (empty($arr_insertar)) {
                return false;
            }

            // Obtener las columnas desde el primer elemento del array
            $columnas = [];
            $original_keys = [];

            foreach ($arr_insertar[0] as $key => $val) {
                // Removemos comillas simples si existen en la llave (ej. '24E')
                $clean_key = str_replace("'", "", $key);
                $columnas[] = "`{$clean_key}`";
                $original_keys[] = $key;
            }
            $colString = implode(', ', $columnas);

            $valuesList = [];
            foreach ($arr_insertar as $val) {
                $rowValues = [];
                foreach ($original_keys as $key) {
                    $v = isset($val[$key]) ? $val[$key] : null;

                    if (is_null($v) || $v === '') {
                        $rowValues[] = 'NULL';
                    } elseif (is_numeric($v)) {
                        // Mantenemos int o float
                        $rowValues[] = $v;
                    } else {
                        // Escapamos strings por seguridad
                        $rowValues[] = "'" . $this->_db->real_escape_string($v) . "'";
                    }
                }
                $valuesList[] = "(" . implode(', ', $rowValues) . ")";
            }

            $valString = implode(', ', $valuesList);

            $sql = "INSERT INTO c_{$ano} ({$colString}) VALUES {$valString}";

            return $this->_db->query($sql);
        } catch (Exception $e) {
            echo 'Excepción capturada en insertarNotasMasivas: ', $e->getMessage(), "\n";
        }
    }

    // Funcion de actualizar notas masivas

    // function actualizarNotasMasivas($arr_actualizar, $ano)
    // {

    //     // si el valor ingresado es falso
    //     if (empty($arr_actualizar))
    //         return false;
    //     //valores iniciales de las 
    //     $ids = [];
    //     $casesNota = [];
    //     $casesLogro = [];

    //     // por cada alumno preparo los array de entrada
    //     foreach ($arr_actualizar as $val) {
    //         $id = (int) $val['id'];
    //         $nota = $val['nota'] > 0 ? (float) $val['nota'] : 0;
    //         // Usar NULL cuando no hay logro para evitar que MySQL convierta '' en 0
    //         // y colisione con la clave única
    //         $logro = $val['id_logro'] > 0 ? (int) $val['id_logro'] : 'NULL';

    //         $ids[] = $id;
    //         $casesNota[] = "WHEN {$id} THEN {$nota}";
    //         $casesLogro[] = "WHEN {$id} THEN {$logro}";

    //     }
    //     // convierto en un string
    //     $idsString = implode(',', $ids);
    //     $casesNotaString = implode(' ', $casesNota);
    //     $casesLogroString = implode(' ', $casesLogro);

    //     $sql = "UPDATE calificaciones_{$ano} 
    //             SET nota = CASE id 
    //                 {$casesNotaString} 
    //                 ELSE nota 
    //             END,
    //             id_logro = CASE id 
    //                 {$casesLogroString} 
    //                 ELSE id_logro 
    //             END,

    //             modificado = NOW()
    //             WHERE id IN ({$idsString})";
    // }


    // Funcion que valida masivamente cuales estudiantes tienen
    // y cuales no tienen registros

    function validacion_masiva($codigos, $id_materia, $year)
    {

        // si el valor ingresado es falso
        if (empty($codigos))
            return false;
        //valores iniciales de las 
        $ids = [];

        // por cada valor en los codigos
        foreach ($codigos as $c) {
            // recupero el valor del id
            $id = (int) $c['value'];
            if ($id > 0) {
                // lo almaceno en ids
                $ids[] = $id;
            }
        }

        if (empty($ids))
            return [];

        // acumulo el string en una cadena separado por comas
        $c_string = implode(',', $ids);

        // cadena de busqueda 
        $q = "select * from c_$year where id_materia = $id_materia and id_alumno in ($c_string)";



        try {
            $c = $this->_db->query($q);
            $r = (array) $c->fetch_all(MYSQLI_ASSOC);
            // retorno el array de salida
            return $r;
        } catch (Exception $e) {
            echo 'Excepción capturada en validacion_masiva: ', $e->getMessage(), "\n";
            return [];
        }
    }


    // 
    public function get_notas_bulk(array $ids_alumno, array $materias_con_area, int $year)
    {

        $spot = [];
        if (empty($ids_alumno) || empty($materias_con_area))
            return $spot;

        $ids_str = implode(',', array_map('intval', $ids_alumno));
        $materias_ids = array_keys($materias_con_area);
        $mat_str = implode(',', array_map('intval', $materias_ids));

        $q = "select * from c_$year WHERE id_alumno IN ({$ids_str})
                AND id_materia IN ({$mat_str})";

        $res = $this->_db->query($q);
        if ($res) {

            return $res->fetch_all(MYSQLI_ASSOC);
            /*while ($r = $res->fetch_array(MYSQLI_ASSOC)) {
                $al = intval($r['id_alumno']);
                $mat = intval($r['id_materia']);
                $id_area = $materias_con_area[$mat] ?? 0;
                $spot[$al][$id_area][$mat] = floatval($r['nota'] ?? 0);
            }*/
        }

        // Disciplina (id=20): promedio simple
        if (in_array(20, $materias_ids)) {

            $id_area_disc = $materias_con_area[20] ?? 0;
            /*$q2 = "SELECT id_alumno, periodo, AVG(nota) AS nota
                   FROM c_{$year}
                   WHERE year = {$year}
                     AND id_alumno IN ({$ids_str})
                     AND id_materia = 20
                   GROUP BY id_alumno, periodo";
            $res2 = $this->_db->query($q2);
            if ($res2) {
                while ($r = $res2->fetch_array(MYSQLI_ASSOC)) {
                    $al = intval($r['id_alumno']);
                    $per = intval($r['periodo']);
                    $spot[$al][$id_area_disc][20][$per] = floatval($r['nota'] ?? 0);
                }
            }*/

            return $spot;
        }
    }

    // ---
    //  AVANCE DE CALIFICACIONES POR PERIODO  (modelo c_{year})
    // ---

    /**
     * @brief Columnas existentes en la tabla c_{year}.
     *
     * @param int $ano Año lectivo (sufijo de la tabla).
     * @return array Array con los nombres de columna como llaves (nombre => true).
     *               Vacío si la tabla del año no existe.
     *
     * El modelo c_{year} tiene una columna por nota, por eso antes de armar una
     * consulta hay que saber cuales columnas existen realmente en el año
     * consultado (ej. D_p4 no existe, mientras D_p1 si).
     */
    public function get_columnas_c($ano)
    {
        // cache por año para no repetir el SHOW COLUMNS
        static $cache = array();

        $ano = (int) $ano;

        if (isset($cache[$ano])) {
            return $cache[$ano];
        }

        $arr = array();

        // si la tabla del año no existe se retorna vacio. mysqli lanza una
        // excepcion en ese caso, por eso la consulta va dentro del try
        try {
            $c = $this->_db->query("SHOW COLUMNS FROM c_" . $ano);
            if ($c) {
                while ($r = $c->fetch_array(MYSQLI_ASSOC)) {
                    $arr[$r['Field']] = true;
                }
            }
        } catch (Throwable $e) {
            error_log("No se pudo leer la estructura de c_$ano: " . $e->getMessage());
        }

        $cache[$ano] = $arr;
        return $arr;
    }

    // ---

    /**
     * @brief Letras de los ponderados que se califican en una semana.
     *
     * @param int $semana Numero de la semana (1 a 32).
     * @return array Letras del ponderado. Unidas al numero de semana forman el
     *               nombre de la columna en c_{year} (ej. 1A, 4H, 8I).
     *
     * Las semanas finales de periodo (8, 16, 24, 32) solo evaluan presentacion,
     * actitud, asistencia, evaluacion final y auto evaluacion. Las semanas
     * intermedias (4, 12, 20, 28) agregan el quiz (H).
     */
    public function get_ponderados_semana($semana)
    {
        $semana = (int) $semana;

        if (in_array($semana, array(8, 16, 24, 32))) {
            return array('E', 'F', 'G', 'I', 'J');
        }

        if (in_array($semana, array(4, 12, 20, 28))) {
            return array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
        }

        return array('A', 'B', 'C', 'D', 'E', 'F', 'G');
    }

    // ---

    /**
     * @brief Columnas de c_{year} donde se consignan las notas de una clase
     *        en una semana determinada.
     *
     * @param int $ano      Año lectivo.
     * @param int $semana   Numero de la semana (1 a 32).
     * @param int $periodo  Periodo academico (1 a 4).
     * @param string $tipo  Tipo de clase: 'notas', 'disciplina' o 'preescolar'.
     * @return array Nombres de columna existentes en la tabla del año.
     *
     * - notas:      una columna por ponderado de la semana (5, 7 u 8 notas).
     * - disciplina: una sola nota semanal en D{semana}, que en la semana final
     *               del periodo se consigna en D_p{periodo}.
     * - preescolar: se valora por periodo (l1_p{periodo} / R{periodo}), por eso
     *               solo retorna columnas en la semana final del periodo.
     */
    public function get_columnas_clase_semana($ano, $semana, $periodo, $tipo)
    {
        $semana = (int) $semana;
        $periodo = (int) $periodo;

        // columnas existentes en la tabla del año
        $existentes = $this->get_columnas_c($ano);

        // candidatas segun el tipo de clase
        switch ($tipo) {

            case 'disciplina':
                // en la semana final del periodo la nota queda en D_p{periodo}
                if (in_array($semana, array(8, 16, 24, 32))) {
                    $candidatas = array('D_p' . $periodo, 'D' . $semana);
                } else {
                    $candidatas = array('D' . $semana);
                }
                break;

            case 'preescolar':
                // solo se evalua en la semana final del periodo
                if ($semana === ($periodo * 8)) {
                    $candidatas = array('l1_p' . $periodo, 'R' . $periodo);
                } else {
                    $candidatas = array();
                }
                break;

            default:
                $candidatas = array();
                foreach ($this->get_ponderados_semana($semana) as $letra) {
                    $candidatas[] = $semana . $letra;
                }
                break;
        }

        // dejo unicamente las columnas que existen en la tabla
        $arr = array();
        foreach ($candidatas as $col) {
            if (isset($existentes[$col])) {
                $arr[] = $col;
            }
        }

        // disciplina es una sola nota semanal: basta la primera disponible
        if ($tipo === 'disciplina' && count($arr) > 1) {
            $arr = array($arr[0]);
        }

        return $arr;
    }

    // ---

    /**
     * @brief Avance de las calificaciones de un periodo, semana a semana,
     *        para cada clase asignada en matricula_docente.
     *
     * @param int $ano          Año lectivo (sufijo de la tabla c_{year}).
     * @param int $periodo      Periodo academico (1 a 4).
     * @param int $id_docente   Docente a filtrar; 0 retorna todos los docentes.
     * @return array Un elemento por clase con las llaves:
     *               id_clase, id_docente, docente, id_grado, grado, curso,
     *               jornada, id_materia, materia, tipo, alumnos,
     *               semanas[$semana]          => notas consignadas,
     *               esperado_alumno[$semana]  => notas esperadas por alumno.
     *
     * El primer periodo va de la semana 1 a la 8, el segundo de la 9 a la 16,
     * el tercero de la 17 a la 24 y el cuarto de la 25 a la 32.
     *
     * Las clases se clasifican en tres grupos disjuntos, porque cada uno se
     * califica en columnas distintas de c_{year}: preescolar (grados con
     * formato de boletin 1), disciplina (materia 20) y materias ordinarias.
     */
    public function get_avance_periodo($ano, $periodo, $id_docente = 0)
    {
        $ano = (int) $ano;
        $periodo = (int) $periodo;
        $id_docente = (int) $id_docente;

        // semanas que componen el periodo
        $semana_inicial = (($periodo - 1) * 8) + 1;
        $semanas = range($semana_inicial, $semana_inicial + 7);

        // condicion que identifica cada grupo de clases
        $filtros = array(
            'preescolar' => "g.formato_boletin = 1",
            'disciplina' => "g.formato_boletin <> 1 AND md.id_materia = 20",
            'notas' => "g.formato_boletin <> 1 AND md.id_materia <> 20",
        );

        $clases = array();

        foreach ($filtros as $tipo => $filtro) {

            // columnas y notas esperadas por alumno en cada semana
            $cols = array();
            $esperado_alumno = array();

            foreach ($semanas as $s) {
                $cols[$s] = $this->get_columnas_clase_semana($ano, $s, $periodo, $tipo);
                // en preescolar la valoracion del periodo cuenta como una sola
                // nota, aunque se pueda consignar en mas de una columna
                $esperado_alumno[$s] = ($tipo === 'preescolar')
                    ? (empty($cols[$s]) ? 0 : 1)
                    : count($cols[$s]);
            }

            // campos_ag -> expresiones que cuentan, dentro de la subconsulta
            // agrupada, las notas consignadas en cada semana
            // campos    -> lectura de esos conteos en la consulta externa
            $campos_ag = array();
            $campos = array();
            foreach ($semanas as $s) {
                $campos_ag[] = $this->_expresion_avance($cols[$s], $tipo) . " AS s" . $s;
                $campos[] = "IFNULL(ag.s" . $s . ", 0) AS s" . $s;
            }

            // filtro opcional por docente
            $filtro_docente = $id_docente > 0 ? " AND md.id_docente = " . $id_docente : "";

            // la tabla c_{year} no tiene indices, por eso los conteos se
            // resuelven en una sola pasada agrupando por materia y grupo
            // (grado, curso, jornada) en lugar de cruzarla contra cada clase.
            // ag -> notas consignadas por materia y grupo
            // al -> cantidad de alumnos matriculados en cada grupo
            // los nombres se resuelven con IFNULL porque las clases pueden
            // apuntar a materias, cursos, jornadas o docentes ya eliminados
            $q = "SELECT md.id AS id_clase, md.id_docente, md.id_materia, md.id_grado,
                         IFNULL(g.grado, md.id_grado) AS grado,
                         IFNULL(cu.curso, md.id_curso) AS curso,
                         IFNULL(j.jornada, md.id_jornada) AS jornada,
                         IFNULL(ms.materia, CONCAT('materia ', md.id_materia)) AS materia,
                         IFNULL(CONCAT(p.nombres, ' ', p.apellidos), CONCAT('docente ', md.id_docente)) AS docente,
                         IFNULL(al.alumnos, 0) AS alumnos,
                         " . implode(", ", $campos) . "
                  FROM matricula_docente AS md
                  INNER JOIN grados AS g ON g.id_grado = md.id_grado
                  LEFT JOIN materia AS ms ON ms.id_materia = md.id_materia
                  LEFT JOIN curso AS cu ON cu.id_curso = md.id_curso
                  LEFT JOIN jornada AS j ON j.id_jornada = md.id_jornada
                  LEFT JOIN u_docentes AS ud ON ud.id_docente = md.id_docente
                  LEFT JOIN personas AS p ON p.id_personas = ud.id_personas
                  LEFT JOIN (SELECT id_grado, id_curso, id_jornada,
                                    COUNT(DISTINCT id_alumno) AS alumnos
                             FROM matricula WHERE year = '" . $ano . "'
                             GROUP BY id_grado, id_curso, id_jornada) AS al
                         ON al.id_grado = md.id_grado
                        AND al.id_curso = md.id_curso
                        AND al.id_jornada = md.id_jornada
                  LEFT JOIN (SELECT c.id_materia, m.id_grado, m.id_curso, m.id_jornada,
                                    " . implode(", ", $campos_ag) . "
                             FROM c_" . $ano . " AS c
                             INNER JOIN (SELECT DISTINCT id_alumno, id_grado, id_curso, id_jornada
                                         FROM matricula WHERE year = '" . $ano . "') AS m
                                     ON m.id_alumno = c.id_alumno
                             GROUP BY c.id_materia, m.id_grado, m.id_curso, m.id_jornada) AS ag
                         ON ag.id_materia = md.id_materia
                        AND ag.id_grado = md.id_grado
                        AND ag.id_curso = md.id_curso
                        AND ag.id_jornada = md.id_jornada
                  WHERE md.year = " . $ano . " AND " . $filtro . $filtro_docente;

            try {
                $c = $this->_db->query($q);
                if ($c) {
                    while ($r = $c->fetch_array(MYSQLI_ASSOC)) {

                        // notas consignadas en cada semana del periodo
                        $r['semanas'] = array();
                        foreach ($semanas as $s) {
                            $r['semanas'][$s] = (int) $r['s' . $s];
                            unset($r['s' . $s]);
                        }

                        $r['tipo'] = $tipo;
                        $r['esperado_alumno'] = $esperado_alumno;
                        $r['alumnos'] = (int) $r['alumnos'];

                        $clases[] = $r;
                    }
                }
            } catch (Throwable $e) {
                // el error se registra en el log y no se imprime, porque la
                // salida de este metodo se consume como json
                error_log("Error en get_avance_periodo ($tipo): " . $e->getMessage());
            }
        }

        return $clases;
    }

    // ---

    /**
     * @brief Expresion agregada que cuenta las notas consignadas de una semana.
     *
     * @param array  $cols Columnas de c_{year} de la semana.
     * @param string $tipo Tipo de clase ('notas', 'disciplina' o 'preescolar').
     * @return string Expresion SQL.
     *
     * En preescolar la valoracion del periodo se cuenta una sola vez, asi este
     * diligenciada en varias columnas. En los demas casos se cuenta cada nota.
     */
    private function _expresion_avance($cols, $tipo)
    {
        // sin columnas no hay nada que contar en esa semana
        if (empty($cols)) {
            return "0";
        }

        $condiciones = array();
        foreach ($cols as $col) {
            $condiciones[] = "c.`" . $col . "` IS NOT NULL";
        }

        // el registro del periodo cuenta como una sola nota
        if ($tipo === 'preescolar') {
            return "SUM(CASE WHEN " . implode(" OR ", $condiciones) . " THEN 1 ELSE 0 END)";
        }

        // cada columna diligenciada es una nota
        $sumas = array();
        foreach ($condiciones as $cond) {
            $sumas[] = "SUM(CASE WHEN " . $cond . " THEN 1 ELSE 0 END)";
        }

        return "(" . implode(" + ", $sumas) . ")";
    }

    // ---

    /**
     * Carga todos los logros de un periodo para un conjunto de alumnos.
     * Retorna: $logros_cache[$id_alumno][$id_materia] = texto_logro (string)
     */
    public function get_logros_bulk(array $ids_alumno, array $materias_ids, int $year, int $periodo): array
    {
        $cache = [];
        if (empty($ids_alumno) || empty($materias_ids))
            return $cache;

        $ids_str = implode(',', array_map('intval', $ids_alumno));
        $mat_str = implode(',', array_map('intval', $materias_ids));

        $q = "SELECT c.id_alumno, c.id_materia, l.logro
              FROM c_{$year} c
              INNER JOIN logros l ON l.id_logro = c.l1_p" . $periodo . "
              WHERE c.id_alumno IN ({$ids_str})
                AND c.id_materia IN ({$mat_str})
                AND c.l1_p" . $periodo;

        $res = $this->_db->query($q);
        if ($res) {
            while ($r = $res->fetch_array(MYSQLI_ASSOC)) {
                $cache[intval($r['id_alumno'])][intval($r['id_materia'])] = $r['logro'];
            }
        }
        return $cache;
    }
}
