<?php 
///////////////////////////////////////////
//                                       //
//   Clase que define los docentes       //
//   Deriva de la clase personas         //
//   Implementa mejoras de seguridad y   //
//   manejo de errores.                  //
//                                       //
//////////////////////////////////////////

class docentes extends personas {
  
    // Atributos de la clase
    public $id;
    public $admin;
    // Los atributos nombres, apellidos, cedula (identificacion),
    // celular, correo, i_correo ya están definidos en la clase padre 'personas'.
    // Se mantienen aquí por compatibilidad, pero se recomienda usar los de la clase padre.
    public $login;
    public $fecha;
    public $materias; // Lista de materias asignadas
    public $listado; // Propósito no claro, revisar si es necesario

    /**
     * Resumen de los métodos de la clase docentes:
     *
     * - __construct(): Constructor de la clase. Inicializa los atributos y hereda del padre.
     * - get_docente_id(int $id): Obtiene los datos de un docente a partir de su ID.
     * - get_docente_cc(int $id): Obtiene los datos de un docente a partir de su número de identificación (cédula).
     * - get_docente_email(string $email): Obtiene los datos de un docente a partir de su correo institucional.
     * - get_materias_por_grado(int $g, int $y): Retorna las materias que se dictan en un año para un grado específico.
     * - get_total_docentes(): Retorna un listado de todos los IDs de los docentes.
     */

    /**
     * Constructor de la clase.
     * Hereda parámetros de la clase padre.
     */
    public function __construct(){
        parent::__construct();
        // Inicializar atributos específicos de docente
        $this->id = null;
        $this->admin = null;
        $this->login = '';
        $this->fecha = '';
        $this->materias = [];
        $this->listado = []; // O null, dependiendo de su uso
    }

    /**
     * Obtiene los datos del docente a partir de su ID.
     * Utiliza sentencias preparadas para mayor seguridad.
     *
     * @param int $id El ID del docente.
     * @return array|null Un array asociativo con los datos del docente o null si no se encuentra.
     */
    public function get_docente_id($id) {
        try {
            if (!is_numeric($id)) {
                throw new InvalidArgumentException("El ID del docente debe ser un valor numérico.");
            }
           
            $q = "SELECT ud.id_docente, ud.admin, p.nombres, p.apellidos, p.identificacion, ud.login, ud.fecha, p.celular, p.correo, p.i_correo, ud.materias 
                  FROM u_docentes ud
                  INNER JOIN personas p ON ud.id_personas = p.id_personas
                  WHERE ud.id_docente = ?";
            
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta get_docente_id: " . $this->_db->error);
            }

            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $a = $result->fetch_array(MYSQLI_ASSOC);

            if ($a) {
                // Asignar los valores a los atributos del objeto
                $this->id = $a['id_docente'];
                $this->admin = $a['admin']; 
                $this->nombres = $a['nombres'];
                $this->apellidos = $a['apellidos'];
                $this->cedula = $a['identificacion']; // Usar propiedad de la clase padre
                $this->login = $a['login'];
                $this->fecha = $a['fecha'];
                $this->celular = $a['celular']; // Usar propiedad de la clase padre
                $this->correo = $a['correo'];   // Usar propiedad de la clase padre
                $this->i_correo = $a['i_correo']; // Usar propiedad de la clase padre
                $this->materias = $a['materias'];
            }
            $stmt->close();
            return $a; // Retorna el array asociativo con los datos
        } catch (Exception $e) {
            error_log("Error en get_docente_id: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtiene los datos del docente a partir de su número de identificación (cédula).
     * Utiliza sentencias preparadas para mayor seguridad.
     *
     * @param int $id El número de identificación del docente.
     * @return array|null Un array asociativo con los datos del docente o null si no se encuentra.
     */
    public function get_docente_cc($id){
        try {
            if (!is_numeric($id)) {
                throw new InvalidArgumentException("El número de identificación debe ser un valor numérico.");
            }

            $q = "SELECT ud.id_docente, ud.admin, p.nombres, p.apellidos, p.identificacion, ud.login, ud.fecha, p.celular, p.correo, p.i_correo, ud.materias 
                  FROM u_docentes ud 
                  INNER JOIN personas p ON ud.id_personas = p.id_personas 
                  WHERE p.identificacion = ?";
            
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta get_docente_cc: " . $this->_db->error);
            }

            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $a = $result->fetch_array(MYSQLI_ASSOC);

            if ($a) {
                // Asignar los valores a los atributos del objeto
                $this->id = $a['id_docente'];
                $this->admin = $a['admin']; 
                $this->nombres = $a['nombres'];
                $this->apellidos = $a['apellidos'];
                $this->cedula = $a['identificacion'];
                $this->login = $a['login'];
                $this->fecha = $a['fecha'];
                $this->celular = $a['celular'];
                $this->correo = $a['correo'];
                $this->i_correo = $a['i_correo'];
                $this->materias = $a['materias'];
            }
            $stmt->close();
            return $a;
        } catch (Exception $e) {
            error_log("Error en get_docente_cc: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtiene los datos del docente a partir de su correo institucional.
     * Utiliza sentencias preparadas para mayor seguridad.
     *
     * @param string $email El correo institucional del docente.
     * @return array|null Un array asociativo con los datos del docente o null si no se encuentra.
     */
    public function get_docente_email($email) {
        try {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException("El formato del correo electrónico no es válido.");
            }

            $q = "SELECT ud.id_docente, ud.admin, p.nombres, p.apellidos, p.identificacion, ud.login, ud.fecha, p.celular, p.correo, p.i_correo, ud.materias 
                  FROM u_docentes ud 
                  INNER JOIN personas p ON ud.id_personas = p.id_personas 
                  WHERE p.i_correo = ?";

            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta get_docente_email: " . $this->_db->error);
            }

            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $a = $result->fetch_array(MYSQLI_ASSOC);

            if ($a) {
                // Asignar los valores a los atributos del objeto
                $this->id = $a['id_docente'];
                $this->admin = $a['admin']; 
                $this->nombres = $a['nombres'];
                $this->apellidos = $a['apellidos'];
                $this->identificacion = $a['identificacion']; // Corregido: usar 'identificacion' de la tabla personas
                $this->login = $a['login'];
                $this->fecha = $a['fecha'];
                $this->celular = $a['celular'];
                $this->correo = $a['correo'];
                $this->i_correo = $a['i_correo'];
                $this->materias = $a['materias'];
            }
            $stmt->close();
            return $a;
        } catch (Exception $e) {
            error_log("Error en get_docente_email: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Retorna las materias que se dictan en un año para un grado específico.
     *
     * @param int $g Grado.
     * @param int $y Año.
     * @return array Un array asociativo con el ID de la materia como clave y el nombre como valor.
     */
    public function get_materias_por_grado($g, $y) {
        $arr = array();
        try {
            if (!is_numeric($g) || !is_numeric($y)) {
                throw new InvalidArgumentException("El grado y el año deben ser valores numéricos.");
            }

            $q = "";
            $stmt = null;

            // Si es administrativo
            if ($this->admin == 1) {
                $q = "SELECT M.id_materia, M.materia FROM requisitos R
                      INNER JOIN materia M ON M.id_materia = R.id_materia
                      WHERE R.id_grado = ?";
                $stmt = $this->_db->prepare($q);
                if ($stmt === false) {
                    throw new Exception("Error al preparar la consulta de materias (admin): " . $this->_db->error);
                }
                $stmt->bind_param("i", $g);
            } else {
                // Si no es administrativo, solo lista las materias en las que está asignado
                if (!$this->id) {
                    throw new Exception("ID de docente no establecido para obtener materias no administrativas.");
                }
                $q = "SELECT DISTINCT M.id_materia, M.materia FROM materia M
                      INNER JOIN matricula_docente D ON M.id_materia = D.id_materia
                      WHERE D.year = ? AND D.id_docente = ? AND D.id_grado = ?";
                $stmt = $this->_db->prepare($q);
                if ($stmt === false) {
                    throw new Exception("Error al preparar la consulta de materias (no admin): " . $this->_db->error);
                }
                $stmt->bind_param("sii", $y, $this->id, $g);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            
            while($a = $result->fetch_array(MYSQLI_ASSOC)){
                $id_m = $a['id_materia'];
                $m = $a['materia'];
                $arr[$id_m] = $m; 
            }
            $stmt->close();
            $this->materias = $arr; // Asignar al atributo del objeto
            return $arr;
        } catch (Exception $e) {
            error_log("Error en get_materias_por_grado: " . $e->getMessage());
            return []; // Retorna un array vacío en caso de error
        }
    }

    /**
     * Retorna un listado de los docentes con su ID.
     *
     * @return array Un array de IDs de docentes.
     */
    public function get_total_docentes(){
        $arr = array();
        try {
            $q ="SELECT id_docente FROM 
                (SELECT id_docente, lower(CONCAT(nombres, apellidos)) completo 
                FROM (SELECT p.id_personas, p.nombres, p.apellidos, ud.id_docente FROM u_docentes ud 
                INNER JOIN personas p ON ud.id_personas = p.id_personas) AS a ) AS c
                ORDER BY completo ASC";
            
            $c = $this->_db->query($q);

            if ($c === false) {
                throw new Exception("Error al ejecutar la consulta get_total_docentes: " . $this->_db->error);
            }
            
            while($a = $c->fetch_array(MYSQLI_ASSOC)){
                if ( !empty( $a['id_docente'] )){
                    array_push($arr, $a['id_docente']);  
                }
            }
            return $arr;
        } catch (Exception $e) {
            error_log("Error en get_total_docentes: " . $e->getMessage());
            return []; // Retorna un array vacío en caso de error
        }
    }
}
?>
