<?php

/**
 * @class matricula
 * @brief Clase que describe las matrículas realizadas en un colegio.
 *
 * Esta clase gestiona la información de las matrículas de los estudiantes,
 * incluyendo sus datos de inscripción, año lectivo, grado, jornada y curso.
 * Hereda de la clase `imcrea` para la conexión y manipulación de la base de datos.
 */
class matricula extends curso {
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
     * @brief Constructor de la clase `matricula`.
     *
     * Inicializa la clase `imcrea` padre para establecer la conexión a la base de datos.
     */
    public function __construct(){
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
    public function get_matricula_id($i){
        // Prepara y ejecuta la consulta SQL para obtener la matrícula.
        $r = $this->_db->query("SELECT * FROM matricula WHERE id = " . $i);
        $dato = $r->fetch_array(MYSQLI_ASSOC);

        // Si se encontraron datos, se asignan a los atributos del objeto.
        if ($dato){
            $this->id = $dato["id"];
            $this->id_alumno = $dato["id_alumno"];
            $this->id_grado = $dato["id_grado"];
            $this->id_jornada = $dato["id_jornada"];
            $this->year = $dato["year"];
            $this->mes = $dato["mes"];
            $this->retiro = $dato["retiro"];
            $this->id_curso = $dato["id_curso"];
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
    public function set_matricula(){
        $texto = "INSERT INTO matricula (id_alumno, id_grado, id_jornada, id_curso, mes, retiro, year)
                  VALUES ($this->id_alumno, $this->id_grado, $this->id_jornada, $this->id_curso, $this->mes, $this->retiro, $this->year)";
        
        $consulta = $this->_db->query($texto);
        return $consulta;
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
    public function get_matriculas_grado_jornada($year, $id_grado, $id_jornada){
        $q = "SELECT * FROM matricula m WHERE year = $year AND m.id_jornada = $id_jornada AND id_grado = $id_grado";
        $c = $this->_db->query($q);
        
        $arr = array();
        while($r = $c->fetch_array(MYSQLI_ASSOC)) {
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
    public function get_matricula_grado($id_jornada, $id_grado, $id_curso, $year){
        $texto = "SELECT id_alumno, nombres, apellidos FROM personas AS p INNER JOIN 
                  (SELECT * FROM u_alumnos AS ua INNER JOIN
                  (SELECT * FROM matricula 
                  WHERE year = $year AND id_grado = $id_grado AND id_jornada = $id_jornada AND id_curso = $id_curso) AS m
                  ON ua.id_alumnos = m.id_alumno) AS c
                  ON c.id_personas = p.id_personas";
        
        $q2 = $this->_db->query($texto);
        
        $aa = array();
        while($resultado = $q2->fetch_array(MYSQLI_ASSOC)){
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
    public function get_matricula_ano($year){
        try {
            if(empty($year)){
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

    public function getAlumnosPorGrupo($id_grado, $id_curso, $year, $id_jornada) {
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
            $alumnos_ids[] = (int)$row['id_alumno'];
        }

        // Cierra la declaración.
        $stmt->close();

        return $alumnos_ids;
    }
}
