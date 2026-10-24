<?php

/**
 * @class matricula
 * @brief Clase que describe las matrículas realizadas en un colegio.
 *
 * Esta clase gestiona la información de las matrículas de los estudiantes,
 * incluyendo sus datos de inscripción, año lectivo, grado, jornada y curso.
 * Hereda de la clase `imcrea` para la conexión y manipulación de la base de datos.
 */
class matricula extends curso
{
    /**
     * @var int $id_alumno
     * @brief Clave foránea que referencia al alumno.
     */
    public $id_alumno;

    /**
     * @var int $id
     * @brief Clave primaria de la tabla de matrículas.
     */
    public $id;

    /**
     * @var int $mes
     * @brief Mes en el que se realizó la matrícula.
     */
    public $mes;

    /**
     * @var int $retiro
     * @brief Mes en el que se retiró el alumno, si aplica.
     */
    public $retiro;

    public $year;

    /**
     * @var string $fecha
     * @brief Fecha en que se realizó/imprimió la matrícula (YYYY-MM-DD).
     */
    public $fecha;

    public $id_curso;

    /**
     * Datos de la institucion de procedencia del alumno.
     * proviene_otra_institucion: 1 si el alumno viene de otra institucion, 0 si no.
     * tipo_institucion: Publico, Privado o ICBF.
     * situacion_academica: Aprobó, Reprobó, Desertó o Se trasladó.
     */
    public $proviene_otra_institucion = 0;
    public $institucion_anterior;
    public $tipo_institucion;
    public $situacion_academica;
    public $municipio_institucion;
    public $fecha_retiro;
    public $motivo_retiro;

    /**
     * @brief Constructor de la clase `matricula`.
     *
     * Inicializa la clase `imcrea` padre para establecer la conexión a la base de datos.
     */
    public function __construct()
    {
        parent::__construct();
    }

    // ---

    /**
     * @brief Obtiene una matrícula específica por su ID.
     * @param int $i El ID de la matrícula.
     *
     * Realiza una consulta a la base de datos para buscar una matrícula por su clave primaria
     * y, si la encuentra, asigna los valores a los atributos del objeto.
     */
    public function get_matricula_id($i)
    {
        // Prepara y ejecuta la consulta SQL para obtener la matrícula.
        $r = $this->_db->query("SELECT * FROM matricula WHERE id = " . $i);
        $dato = $r->fetch_array(MYSQLI_ASSOC);

        // Si se encontraron datos, se asignan a los atributos del objeto.
        if ($dato) {
            $this->id = $dato["id"];
            $this->id_alumno = $dato["id_alumno"];
            $this->id_grado = $dato["id_grado"];
            $this->id_jornada = $dato["id_jornada"];
            $this->year = $dato["year"];
            $this->mes = $dato["mes"];
            $this->retiro = $dato["retiro"];
            $this->id_curso = $dato["id_curso"];
            $this->fecha = $dato["fecha"] ?? null;

            // datos de la institucion de procedencia
            $this->proviene_otra_institucion = $dato["proviene_otra_institucion"] ?? 0;
            $this->institucion_anterior = $dato["institucion_anterior"] ?? null;
            $this->tipo_institucion = $dato["tipo_institucion"] ?? null;
            $this->situacion_academica = $dato["situacion_academica"] ?? null;
            $this->municipio_institucion = $dato["municipio_institucion"] ?? null;
            $this->fecha_retiro = $dato["fecha_retiro"] ?? null;
            $this->motivo_retiro = $dato["motivo_retiro"] ?? null;

            // Obtengo los datos adicionales del grado (escolaridad, etc.)
            $this->get_grado_id($this->id_grado);
        }
    }

    // ---

    /**
     * @brief Inserta una nueva matrícula en la base de datos.
     * @return bool `true` si la consulta se ejecutó con éxito, `false` en caso contrario.
     *
     * Utiliza los atributos del objeto para construir y ejecutar una consulta `INSERT`
     * en la tabla `matricula`.
     */
    public function set_matricula()
    {
        // Graba la fecha actual en la columna `fecha` de la tabla `matricula`.
        // La columna es DATE, por eso no se guarda la hora (formato 2026-08-31).
        $this->fecha = date('Y-m-d');
        // consulta SQL con prepared statement
        $sql = "INSERT INTO matricula (id_alumno, id_grado, id_jornada, id_curso, mes, retiro, year, fecha,
                    proviene_otra_institucion, institucion_anterior, tipo_institucion,
                    situacion_academica, municipio_institucion, fecha_retiro, motivo_retiro)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepara el statement 
        $stmt = $this->_db->prepare($sql);
        // Si no se puede preparar el statement, devuelve false
        if (!$stmt) {
            return false;
        }
        // Vincula los parámetros a la consulta preparada
        $stmt->bind_param(
            'iiiiiiisissssss',
            $this->id_alumno,
            $this->id_grado,
            $this->id_jornada,
            $this->id_curso,
            $this->mes,
            $this->retiro,
            $this->year,
            $this->fecha,
            $this->proviene_otra_institucion,
            $this->institucion_anterior,
            $this->tipo_institucion,
            $this->situacion_academica,
            $this->municipio_institucion,
            $this->fecha_retiro,
            $this->motivo_retiro
        );

        // Ejecuta el statement
        $resultado = $stmt->execute();
        if ($resultado) {
            // Guardar el ID generado en la propiedad pública $id
            $this->id = $this->_db->insert_id;
        }
        // Cierra el statement
        $stmt->close();
        // Devuelve el resultado de la ejecución
        return $resultado;
    }

    // ---

    /**
     * @brief Graba la fecha actual en la columna `fecha` de la tabla `matricula`.
     *
     * Se invoca al momento de imprimir el comprobante, para registrar la fecha
     * exacta en que se generó/imprimió la matrícula.
     *
     * @return bool `true` si la actualización fue exitosa, `false` en caso contrario.
     */
    public function set_fecha(): bool
    {
        if (!$this->id) {
            return false;
        }

        $sql = "UPDATE matricula SET fecha = CURDATE() WHERE id = ?";
        $stmt = $this->_db->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('i', $this->id);
        $resultado = $stmt->execute();
        if ($resultado) {
            $this->fecha = date('Y-m-d');
        }
        $stmt->close();
        return $resultado;
    }

    // ---

    /**
     * @brief Actualiza una matrícula existente en la base de datos.
     * @return bool `true` si la consulta se ejecutó con éxito, `false` en caso contrario.
     */
    public function update_matricula()
    {
        $sql = "UPDATE matricula SET
                  id_alumno = ?,
                  id_grado = ?,
                  id_jornada = ?,
                  id_curso = ?,
                  mes = ?,
                  retiro = ?,
                  year = ?,
                  proviene_otra_institucion = ?,
                  institucion_anterior = ?,
                  tipo_institucion = ?,
                  situacion_academica = ?,
                  municipio_institucion = ?,
                  fecha_retiro = ?,
                  motivo_retiro = ?
                  WHERE id = ?";

        $stmt = $this->_db->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param(
            'iiiiiiiissssssi',
            $this->id_alumno,
            $this->id_grado,
            $this->id_jornada,
            $this->id_curso,
            $this->mes,
            $this->retiro,
            $this->year,
            $this->proviene_otra_institucion,
            $this->institucion_anterior,
            $this->tipo_institucion,
            $this->situacion_academica,
            $this->municipio_institucion,
            $this->fecha_retiro,
            $this->motivo_retiro,
            $this->id
        );
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    /**
     * @brief Asigna los datos de la institucion de procedencia recibidos por POST.
     * @param array $post Los datos recibidos (normalmente $_POST).
     *
     * Si el alumno no proviene de otra institucion los campos quedan en NULL.
     * El tipo y la situacion academica solo se aceptan si son valores del selector,
     * y la fecha de retiro solo si es una fecha valida (YYYY-MM-DD).
     */
    public function set_institucion_anterior(array $post)
    {
        $proviene = intval($post['proviene_otra_institucion'] ?? 0) === 1 ? 1 : 0;
        $tipos_validos       = ['Publico', 'Privado', 'ICBF'];
        $situaciones_validas = ['Aprobó', 'Reprobó', 'Desertó', 'Se trasladó'];
        $tipo_institucion    = trim($post['tipo_institucion'] ?? '');
        $situacion_academica = trim($post['situacion_academica'] ?? '');
        $fecha_retiro        = trim($post['fecha_retiro'] ?? '');
        $fecha_retiro_obj    = DateTime::createFromFormat('Y-m-d', $fecha_retiro);

        $this->proviene_otra_institucion = $proviene;
        $this->institucion_anterior  = $proviene ? (mb_substr(trim($post['institucion_anterior'] ?? ''), 0, 150) ?: null) : null;
        $this->tipo_institucion      = ($proviene && in_array($tipo_institucion, $tipos_validos, true)) ? $tipo_institucion : null;
        $this->situacion_academica   = ($proviene && in_array($situacion_academica, $situaciones_validas, true)) ? $situacion_academica : null;
        $this->municipio_institucion = $proviene ? (mb_substr(trim($post['municipio_institucion'] ?? ''), 0, 100) ?: null) : null;
        $this->fecha_retiro          = ($proviene && $fecha_retiro_obj && $fecha_retiro_obj->format('Y-m-d') === $fecha_retiro) ? $fecha_retiro : null;
        $this->motivo_retiro         = $proviene ? (mb_substr(trim($post['motivo_retiro'] ?? ''), 0, 255) ?: null) : null;
    }

    // ---

    /**
     * @brief Obtiene una lista de matrículas para un grado y jornada específicos en un año determinado.
     * @param int $year El año lectivo.
     * @param int $id_grado El ID del grado.
     * @param int $id_jornada El ID de la jornada.
     * @return array Un array de arrays asociativos con los datos de las matrículas.
     *
     * Realiza una consulta para obtener todas las matrículas que coincidan con los
     * parámetros de año, grado y jornada.
     */
    public function get_matriculas_grado_jornada()
    {
        $q = "SELECT * FROM matricula m WHERE year = $this->year AND m.id_jornada = $this->id_jornada AND id_grado = $this->id_grado AND  id_curso = $this->id_curso";
        //echo $q;
        $c = $this->_db->query($q);

        $arr = array();
        while ($r = $c->fetch_array(MYSQLI_ASSOC)) {
            array_push($arr, $r);
        }

        return $arr;
    }


    /**
     * @brief Obtiene una lista de matrículas para un grado y jornada específicos en un año determinado.
     * @param int $year El año lectivo.
     * @param int $id_grado El ID del grado.
     * @param int $id_jornada El ID de la jornada.
     * @return array Un array de arrays asociativos con los datos de las matrículas.
     *
     * Realiza una consulta para obtener todas las matrículas que coincidan con los
     * parámetros de año, grado y jornada.
     */
    public function get_matriculas_jornada()
    {
        $q = "SELECT * FROM matricula m WHERE year = $this->year AND m.id_jornada = $this->id_jornada ";
        $c = $this->_db->query($q);

        $arr = array();
        while ($r = $c->fetch_array(MYSQLI_ASSOC)) {
            array_push($arr, $r);
        }

        return $arr;
    }

    // ---

    /**
     * @brief Obtiene un listado de alumnos matriculados en un curso, grado y jornada específicos.
     * @param int $id_jornada El ID de la jornada.
     * @param int $id_grado El ID del grado.
     * @param int $id_curso El ID del curso.
     * @param int $year El año lectivo.
     * @return array Un array de arrays asociativos con los ID de los alumnos, nombres y apellidos.
     *
     * Esta función realiza una consulta `JOIN` entre las tablas `personas`, `u_alumnos` y `matricula`
     * para obtener la información completa de los estudiantes matriculados que cumplan con los
     * parámetros proporcionados.
     */
    public function get_matricula_grado($id_jornada, $id_grado, $id_curso, $year)
    {
        $texto = "SELECT id_alumno, nombres, apellidos FROM personas AS p INNER JOIN 
                  (SELECT * FROM u_alumnos AS ua INNER JOIN
                  (SELECT * FROM matricula 
                  WHERE year = $year AND id_grado = $id_grado AND id_jornada = $id_jornada AND id_curso = $id_curso) AS m
                  ON ua.id_alumnos = m.id_alumno) AS c
                  ON c.id_personas = p.id_personas";

        $q2 = $this->_db->query($texto);

        $aa = array();
        while ($resultado = $q2->fetch_array(MYSQLI_ASSOC)) {
            array_push($aa, $resultado);
        }

        return $aa;
    }

    // ---

    /**
     * @brief Obtiene una lista de todas las matrículas realizadas en un año lectivo.
     * @param int $year El año lectivo.
     * @return array Un array de arrays asociativos con los datos de las matrículas.
     * @throws InvalidArgumentException Si el año no es proporcionado.
     * @throws Exception Si hay un error en la preparación de la consulta.
     *
     * Utiliza consultas preparadas para mayor seguridad. Captura excepciones si no se
     * proporciona un año o si la preparación de la consulta falla.
     */
    public function get_matricula_ano($year)
    {
        try {
            if (empty($year)) {
                throw new InvalidArgumentException("No se ha seleccionado ningún año para la matrícula");
            }

            $q = "SELECT id, id_alumno, id_grado, id_jornada, id_curso FROM matricula WHERE year = ?";

            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta para buscar alumno en matrículas: " . $this->_db->error);
            }

            $stmt->bind_param("s", $year);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Error en obtener los alumnos matriculados: " . $e->getMessage());
            // Dependiendo del contexto, puedes decidir cómo manejar el error.
            return [];
        }
    }

    // ---

    /**
     * @brief Busca si el alumno ya tiene una matrícula con el mismo grado, curso y año.
     *
     * @param int    $id_alumno    El ID del alumno.
     * @param int    $id_grado     El ID del grado.
     * @param string $id_curso     El ID del curso.
     * @param string $year         El año lectivo.
     * @param int    $id_excluir   ID de matrícula a ignorar (la que se está editando), 0 para ninguna.
     * @return int El ID de la matrícula encontrada, o 0 si no existe.
     */
    public function existe_matricula_alumno($id_alumno,  $year)
    {
        try {
            $q = "SELECT id FROM matricula WHERE id_alumno = ? AND year = ? LIMIT 1";
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta existe_matricula_alumno: " . $this->_db->error);
            }

            $id_encontrado = 0;
            $stmt->bind_param("is", $id_alumno, $year);
            $stmt->execute();
            $stmt->bind_result($id_encontrado);
            $stmt->fetch();
            $stmt->close();

            return (int) $id_encontrado;
        } catch (Exception $e) {
            error_log("Error en existe_matricula_alumno: " . $e->getMessage());
            return 0;
        }
    }

    // ---

    /**
     * @brief Retorna el ID de la matrícula más reciente de un alumno.
     *
     * @param int $id_alumno El ID del alumno (u_alumnos.id_alumnos).
     * @return int El ID de la matrícula encontrada, o 0 si no existe.
     */
    public function get_ultima_matricula_alumno($id_alumno)
    {
        try {
            $q = "SELECT id FROM matricula WHERE id_alumno = ? ORDER BY year DESC, id DESC LIMIT 1";
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta get_ultima_matricula_alumno: " . $this->_db->error);
            }

            $id_encontrado = 0;
            $stmt->bind_param("i", $id_alumno);
            $stmt->execute();
            $stmt->bind_result($id_encontrado);
            $stmt->fetch();
            $stmt->close();

            return (int) $id_encontrado;
        } catch (Exception $e) {
            error_log("Error en get_ultima_matricula_alumno: " . $e->getMessage());
            return 0;
        }
    }

    // ---

    /**
     * @brief Obtiene todos los alumnos matriculados en un año, en cualquier
     *        grado y jornada, ordenados por grado, jornada y nombre.
     *
     * @param int $year El año lectivo.
     * @return array Arreglo de filas con id_alumno, id_grado, grado,
     *               id_jornada, jornada, nombres y apellidos.
     */
    public function get_matriculas_ano_ordenadas($year)
    {
        $q = "SELECT m.id_alumno, m.id_grado, g.grado, m.id_jornada, j.jornada,
                     p.nombres, p.apellidos
              FROM matricula m
              INNER JOIN personas p ON p.u_alumnos = m.id_alumno
              LEFT JOIN grados g ON g.id_grado = m.id_grado
              LEFT JOIN jornada j ON j.id_jornada = m.id_jornada
              WHERE m.year = ?
              ORDER BY m.id_grado, m.id_jornada, p.apellidos, p.nombres";

        try {
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta get_matriculas_ano_ordenadas: " . $this->_db->error);
            }

            $stmt->bind_param("i", $year);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Error en get_matriculas_ano_ordenadas: " . $e->getMessage());
            return [];
        }
    }

    // ---

    /**
     * @brief Retorna los IDs de los alumnos de un grado, curso, año y jornada.
     *
     * @param int $id_grado  El ID del grado.
     * @param int $id_curso  El ID del curso.
     * @param int $year      El año lectivo.
     * @param int $id_jornada El ID de la jornada.
     * @return array Un array numérico con los IDs de los alumnos.
     */

    public function getAlumnosPorGrupo($id_grado, $id_curso, $year, $id_jornada)
    {
        // Usa consultas preparadas para prevenir inyección SQL.
        $query = "SELECT id_alumno FROM matricula WHERE id_grado = ? AND id_curso = ? AND year = ? AND id_jornada = ?";

        $stmt = $this->_db->prepare($query);

        // Verifica si la preparación de la consulta falló.
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $this->_db->error);
        }

        // Enlaza los parámetros a la consulta. 'isii' significa:
        // 'i' para id_grado (integer)
        // 'i' para id_curso (integer)
        // 's' para year (string)
        // 'i' para id_jornada (integer)
        $stmt->bind_param("iisi", $id_grado, $id_curso, $year, $id_jornada);

        // Ejecuta la consulta.
        $stmt->execute();

        // Obtiene el resultado de la consulta.
        $result = $stmt->get_result();

        // Almacena los IDs de los alumnos en un array.
        $alumnos_ids = [];
        while ($row = $result->fetch_assoc()) {
            $alumnos_ids[] = (int) $row['id_alumno'];
        }

        // Cierra la declaración.
        $stmt->close();

        return $alumnos_ids;
    }
}
