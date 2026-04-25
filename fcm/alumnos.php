<?php 

// Clase que define a los alumnos
// Deriva de la clase personas
// Implementa mejoras de seguridad, manejo de errores y refactorización.

class alumnos extends personas {

    public $id_alumno;// codigo del alumno
    public $login; // login del alumno
    public $fecha; // fecha de caducidad de la matricula
    
        /**
     * Resumen de los métodos de la clase alumnos:
     *
     * - __construct(int $codigo): Constructor de la clase. Inicializa los atributos del alumno a partir de su ID.
     * - set_alumno(): Crea un nuevo registro de alumno en la base de datos.
     * - update_alumno(): Actualiza los datos de un alumno existente.
     * - buscar_estudiante(string $nombre, string $apellido): Busca estudiantes por nombre y apellido.
     * - get_id_nombre(int $id_alumno): Obtiene el nombre de un alumno dado su ID.
     * - get_id_apellido(int $id_alumno): Obtiene el apellido de un alumno dado su ID.
     * - maximo(): Obtiene el ID del último alumno ingresado.
     */

    /**
     * Constructor de la clase.
     * Requiere el ID del estudiante para cargar sus datos.
     *
     * @param int $codigo El ID del alumno.
     */

    //  constructor de la clase


    public function __construct() {
    // Heredar del constructor padre
    parent::__construct();

    }

    // funcion que obtiene los parametros de un
    // alumno nuevo o existente a partir del codigo
    // de la persona $id_persona
    
    public function get_alumno_persona($id_persona){

    try {
        // 1. Validar que el ID sea numérico
        if (!is_numeric($id_persona)) {
            throw new InvalidArgumentException("El código de la persona debe ser un valor numérico.");
        }

        // 2. Cargar los datos de la persona desde la clase padre
        parent::get_persona_por_id($id_persona);

        //echo $this->id_persona;

        // 3. Verificar si la persona fue encontrada
        if (!empty($this->id_persona)) {
            
            // 4. Buscar el ID del alumno asociado a la persona
            $q = "SELECT id_alumnos FROM u_alumnos WHERE id_personas = ? LIMIT 1";
            //echo $q;
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta para buscar alumno: " . $this->_db->error);
            }

           
            $stmt->bind_param("i", $this->id_persona);
            $stmt->execute();
            $result = $stmt->get_result();
            $alumno_data = $result->fetch_assoc(); // Usar fetch_assoc es común

            // 5. Asignar ID si el alumno existe, o crearlo si no
            if ($alumno_data) {
                $this->id_alumno = $alumno_data['id_alumnos'];
                
            } else {
                // Lógica para insertar un nuevo alumno (ejemplo)
                // echo "Lógica para insertar un nuevo alumno aquí.";
                
                $insert_q = "INSERT INTO u_alumnos
                            (id_personas, fecha) VALUES (?, NOW())";

                // echo $insert_q;
                $insert_stmt = $this->_db->prepare($insert_q);
                $insert_stmt->bind_param("i", $this->id_persona);
                $insert_stmt->execute();
                $this->id_alumno = $this->_db->insert_id; // Obtener el ID del nuevo alumno insertado
                
            }
        } else {
            throw new Exception("No se encontró una persona con el ID proporcionado: " . $id_persona);
        }

    } catch (Exception $e) {
        error_log("Error en el constructor de Alumnos: " . $e->getMessage());
        // Dependiendo de la aplicación, podrías querer relanzar la excepción
        // throw $e;
    }
    }

    // obtengo los parametros de la persona
    // a partir del codigo del alumno
    public function get_alumno_codigo($id_alumno){

        try {
            
        if (!empty($id_alumno)) {
            
            // 1. Buscar el ID de la persona  asociado al alumno
            $q = "SELECT id_personas FROM u_alumnos WHERE id_alumnos = ? LIMIT 1";
            // prepara la consulta
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta para buscar persona: " . $this->_db->error);
            }

           
            $stmt->bind_param("i", $id_alumno);
            $stmt->execute();
            $result = $stmt->get_result();
            $alumno_data = $result->fetch_assoc(); // Usar fetch_assoc es común
            $this->id_persona = $alumno_data['id_personas'];
            $this->id_alumno = $id_alumno;
            parent::get_persona_por_id($this->id_persona);
            //$stmt->close();  
        }

        } catch (Exception $e) {
        error_log("Error en optener los datos de la persona a partir del codigo del alumno: " . $e->getMessage());
        // Dependiendo de la aplicación, podrías querer relanzar la excepción
        // throw $e;

        }
        
    }
    
    /**
     * Crea un nuevo registro de alumno en la base de datos.
     * Requiere que los atributos públicos nombres, apellidos, identificacion,
     * fecha, correo, telefono, inscripcion estén previamente seteados en el objeto.
     *
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function set_alumno(){
        try {
            // Validación básica de entrada
            if (empty($this->nombres) || empty($this->apellidos) || empty($this->identificacion) || empty($this->correo)) {
                throw new InvalidArgumentException("Nombres, apellidos, identificación y correo son campos obligatorios.");
            }
            if (!is_numeric($this->identificacion)) {
                throw new InvalidArgumentException("La identificación debe ser un valor numérico.");
            }
            if (!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException("El formato del correo electrónico no es válido.");
            }
            // Asumiendo que 'inscripcion' es un valor numérico o booleano
            if (!is_numeric($this->inscripcion)) {
                 throw new InvalidArgumentException("El valor de inscripción no es válido.");
            }

            // Primero, insertar en la tabla 'personas' (heredado de la clase padre)
            // Asegúrate de que la clase personas tenga un método 'add' adecuado
            // o que los atributos necesarios para 'personas' estén mapeados correctamente.
            // Para este ejemplo, asumimos que los atributos de 'personas' ya están en $this.
            
            // Si la tabla 'alumnos' es una tabla separada de 'personas'
            // y duplica información, se recomienda revisar el diseño de la base de datos.
            // Si 'alumnos' solo tiene id_alumno y id_personas, entonces solo se inserta en u_alumnos.

            // Ejemplo asumiendo que 'set_alumno' inserta en 'u_alumnos' y 'personas' ya fue manejado
            // o que 'alumnos' es una tabla con datos duplicados de personas.
            // Si 'alumnos' es una tabla con información de personas, deberías usar el método add de la clase padre.
            
            // Si la tabla 'alumnos' es una tabla de unión o tiene datos específicos del alumno:
            $q = "INSERT INTO alumnos (nombres, apellidos, cedula, fecha, correo, telefono, login, inscripcion)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta set_alumno: " . $this->_db->error);
            }

            // Nota: 'creativo' como valor fijo para login puede no ser lo ideal.
            $login_value = "creativo"; 

            $stmt->bind_param("sssssssi", 
                               $this->nombres, 
                               $this->apellidos, 
                               $this->cedula, // Usar identificacion de la clase padre
                               $this->fecha, 
                               $this->correo, // Usar correo de la clase padre
                               $this->telefono, // Usar telefono de la clase padre
                               $login_value, 
                               $this->inscripcion);

            $dato = $stmt->execute();

            if ($dato === false) {
                throw new Exception("Fallo al insertar fila en alumnos: " . $stmt->error);
            }
            $stmt->close();
            return true;
        } catch (Exception $e) {
            error_log("Error en set_alumno: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza los datos de un alumno existente.
     *
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function update_alumno() {
        try {
            if (!$this->id_alumno) {
                throw new InvalidArgumentException("ID de alumno no establecido para la actualización.");
            }
            // Validación básica de entrada
            if (empty($this->nombres) || empty($this->apellidos) || empty($this->identificacion) || empty($this->correo)) {
                throw new InvalidArgumentException("Nombres, apellidos, identificación y correo son campos obligatorios para la actualización.");
            }
            if (!is_numeric($this->identificacion)) {
                throw new InvalidArgumentException("La identificación debe ser un valor numérico.");
            }
            if (!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException("El formato del correo electrónico no es válido.");
            }

            // Actualización de los datos del alumno
            // Considera usar el método update_persona de la clase padre para los atributos de personas.
            // Si 'alumnos' es una tabla separada, actualiza solo los campos específicos de 'alumnos'.
            $q = "UPDATE alumnos SET  nombres = ?,
                                  apellidos = ?,
                                  cedula = ?,
                                  telefono = ?,
                                  fecha = ?,
                                  correo = ?
                                  WHERE id_alumno = ?"; // Asumiendo que se actualiza por id_alumno

            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta update_alumno: " . $this->_db->error);
            }

            $stmt->bind_param("ssssssi", 
                               $this->nombres, 
                               $this->apellidos, 
                               $this->identificacion, // Usar identificacion de la clase padre
                               $this->celular, // Usar celular de la clase padre para telefono
                               $this->fecha, 
                               $this->correo, // Usar correo de la clase padre
                               $this->id_alumno);

            $dato = $stmt->execute();

            if ($dato === false) {
                throw new Exception("Fallo al actualizar alumno: " . $stmt->error);
            }
            $stmt->close();
            return true;
        } catch (Exception $e) {
            error_log("Error en update_alumno: " . $e->getMessage());
            return false;
        }
    }


    /**
     * Busca estudiantes dado el nombre y apellido.
     * Utiliza sentencias preparadas y retorna un array de resultados.
     *
     * @param string $nombre Nombre del estudiante.
     * @param string $apellido Apellido del estudiante.
     * @return array Un array de arrays con los datos de los estudiantes encontrados.
     */
    public function buscar_estudiante ($nombre, $apellido){
        $resultados = [];
        try {
            // Filtro anti-XSS (aunque las sentencias preparadas ya lo manejan para la DB)
            $caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
            $caracteres_buenos = array("&lt;", "&gt;", "&quot;", "&#x27;", "&#x2F;", "&#060;", "&#062;", "&#039;", "&#047;");
            $nombre = str_replace($caracteres_malos, $caracteres_buenos, $nombre);
            $apellido = str_replace($caracteres_malos, $caracteres_buenos, $apellido);

            // Convertir a minúsculas para la búsqueda LIKE
            $nombre_like = "%" . strtolower($nombre) . "%";
            $apellido_like = "%" . strtolower($apellido) . "%";

            // Consulta con JOIN a la tabla personas para obtener nombres/apellidos
            $q = "SELECT a.id_alumnos, p.nombres, p.apellidos 
                  FROM u_alumnos AS a
                  INNER JOIN personas AS p ON a.id_personas = p.id_personas
                  WHERE (LOWER(p.nombres) LIKE ? OR LOWER(p.apellidos) LIKE ?)
                  ORDER BY p.nombres, p.apellidos";

            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta buscar_estudiante: " . $this->_db->error);
            }

            $stmt->bind_param("ss", $nombre_like, $apellido_like);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while($dato = $result->fetch_array(MYSQLI_ASSOC)){
                $resultados[] = [
                    'id_alumno' => $dato["id_alumnos"],
                    'nombres' => ucwords(strtolower($dato["nombres"])),
                    'apellidos' => ucwords(strtolower($dato["apellidos"]))
                ];
            }
            $stmt->close();
            return $resultados;
        } catch (Exception $e) {
            error_log("Error en buscar_estudiante: " . $e->getMessage());
            return []; // Retorna un array vacío en caso de error
        }
    }

    /**
     * Obtiene el nombre de un alumno dado su ID.
     *
     * @param int $id_alumno El ID del alumno.
     * @return string|null El nombre del alumno o null si no se encuentra.
     */
    public function get_id_nombre($id_alumno){
        try {
            if (!is_numeric($id_alumno)) {
                throw new InvalidArgumentException("El ID del alumno debe ser un valor numérico.");
            }

            $q = "SELECT p.nombres FROM personas AS p 
                  INNER JOIN u_alumnos AS a ON p.id_personas = a.id_personas 
                  WHERE a.id_alumnos = ?";
            
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta get_id_nombre: " . $this->_db->error);
            }

            $stmt->bind_param("i", $id_alumno);
            $stmt->execute();
            $result = $stmt->get_result();
            $dato = $result->fetch_array(MYSQLI_NUM);

            $stmt->close();
            return $dato ? $dato[0] : null;
        } catch (Exception $e) {
            error_log("Error en get_id_nombre: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtiene el apellido de un alumno a partir de su ID.
     *
     * @param int $id_alumno El ID del alumno.
     * @return string|null El apellido del alumno o null si no se encuentra.
     */
    public function get_id_apellido($id_alumno) {
        try {
            if (!is_numeric($id_alumno)) {
                throw new InvalidArgumentException("El ID del alumno debe ser un valor numérico.");
            }

            $q = "SELECT p.apellidos FROM personas AS p 
                  INNER JOIN u_alumnos AS a ON p.id_personas = a.id_personas 
                  WHERE a.id_alumnos = ?";
            
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta get_id_apellido: " . $this->_db->error);
            }

            $stmt->bind_param("i", $id_alumno);
            $stmt->execute();
            $result = $stmt->get_result();
            $dato = $result->fetch_array(MYSQLI_NUM);

            $stmt->close();
            return $dato ? $dato[0] : null;
        } catch (Exception $e) {
            error_log("Error en get_id_apellido: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtiene el ID del último alumno ingresado.
     *
     * @return int|null El ID máximo de alumno o null si no hay alumnos.
     */
    public function maximo() {
        try {
            $q = "SELECT MAX(id_alumnos) AS cantidad FROM u_alumnos"; // Corregido a id_alumnos
            $result = $this->_db->query($q);
            if ($result === false) {
                throw new Exception("Error al ejecutar la consulta maximo: " . $this->_db->error);
            }
            
            $dato = $result->fetch_array(MYSQLI_NUM);
            $result->close(); // Cerrar el resultado de la consulta
            return $dato ? $dato[0] : null;
        } catch (Exception $e) {
            error_log("Error en maximo: " . $e->getMessage());
            return null;
        }
    }
}
?>
