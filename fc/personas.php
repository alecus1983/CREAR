<?php

// Clase personas que extiende de imcrea
// Representa a las personas que intervienen en la organización
// Se han implementado mejoras de seguridad, manejo de errores y refactorización.

class personas extends imcrea {

    // Atributos
    public $id_persona;
    public $nombres;
    public $apellidos;
    public $identificacion;
    public $tipo_identificacion;
    public $nacimiento;
    public $correo;
    public $i_correo;
    public $celular;
    public $telefono;
    private $u_alumnos; // Clave foránea de la persona cuando es alumno
    private $u_docentes; // Clave foránea de la persona cuando es docente
    private $direccion_residencia;
    private $barrio;
    public $estrato;
    public $sisben;
    public $familias_accion;
    public $regimen_salud;
    public $eps;
    public $vive_con;
    public $victima_conflicto;
    public $tipo_victima_conflicto;
    public $municipio_expulsor;
    public $discapacitado;
    public $tipo_discapacidad;
    public $capacidad_excepcional;
    public $etnia;
    public $tipo_etnia;
    public $resguardo_consejo;
    public $ips;
    public $tipo_sangre;
    public $rh;
    public $capacidad_exepcional; // Nota: revisar si es un duplicado de capacidad_excepcional

    // Atributos para antecedentes patológicos
    public $antecedentes_patologicos_medicos;
    public $antecedentes_patologicos_quirurgicos;
    public $antecedentes_patologicos_toxicos;
    public $antecedentes_patologicos_psiquiatricos;
    public $antecedentes_patologicos_psicologicos;
    public $antecedentes_patologicos_morbilidad;

    /**
     * Constructor de la clase.
     * Hereda parámetros de la clase padre y inicializa los atributos.
     */
    public function __construct(){
        parent::__construct();

        // Inicializar atributos a valores por defecto para un estado consistente
        $this->id_persona = null;
        $this->nombres = '';
        $this->apellidos = '';
        $this->identificacion = '';
        $this->tipo_identificacion = '';
        $this->nacimiento = '';
        $this->correo = '';
        $this->i_correo = '';
        $this->celular = '';
        $this->telefono = '';
        $this->u_alumnos = null;
        $this->u_docentes = null;
        $this->direccion_residencia = '';
        $this->barrio = '';
        $this->estrato = null;
        $this->sisben = null;
        $this->familias_accion = null;
        $this->regimen_salud = null;
        $this->eps = '';
        $this->vive_con = '';
        $this->victima_conflicto = null;
        $this->tipo_victima_conflicto = '';
        $this->municipio_expulsor = '';
        $this->discapacitado = null;
        $this->tipo_discapacidad = '';
        $this->capacidad_excepcional = '';
        $this->etnia = null;
        $this->tipo_etnia = '';
        $this->resguardo_consejo = '';
        $this->ips = '';
        $this->tipo_sangre = '';
        $this->rh = '';
        $this->capacidad_exepcional = '';
        $this->antecedentes_patologicos_medicos = '';
        $this->antecedentes_patologicos_quirurgicos = '';
        $this->antecedentes_patologicos_toxicos = '';
        $this->antecedentes_patologicos_psiquiatricos = '';
        $this->antecedentes_patologicos_psicologicos = '';
        $this->antecedentes_patologicos_morbilidad = '';
    }

    /**
     * Busca personas en función del nombre, apellido y/o número de identificación.
     * Utiliza sentencias preparadas para mayor seguridad.
     *
     * @return array Un array de arrays con nombres, apellidos, identificación e id_personas.
     */
    public function buscar_persona() {
        try {
            $q = "SELECT nombres, apellidos, identificacion, id_personas FROM personas WHERE (nombres LIKE ? AND apellidos LIKE ?) AND identificacion LIKE ? LIMIT 25";
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta de búsqueda de persona: " . $this->_db->error);
            }

            $nombres_param = "%".$this->nombres."%";
            $apellidos_param = "%".$this->apellidos."%";
            $identificacion_param = "%".$this->identificacion."%";
            
            $stmt->bind_param("sss", $nombres_param, $apellidos_param, $identificacion_param);
            $stmt->execute();
            $result = $stmt->get_result();

            $aa = array();
            while($resultado = $result->fetch_array(MYSQLI_NUM)){
                array_push($aa, array($resultado[0], $resultado[1], $resultado[2], $resultado[3]));
            }

            $stmt->close();
            return $aa;
        } catch (Exception $e) {
            error_log("Error en buscar_persona: " . $e->getMessage());
            return []; // Retorna un array vacío en caso de error
        }
    }

    /**
     * Obtiene los datos de una persona en base a su ID.
     *
     * @param int $id El ID de la persona.
     * @return array|null Un array asociativo con los datos de la persona o null si no se encuentra.
     */
    public function get_persona_por_id($id){
        try {
            if (!is_numeric($id)) {
                throw new InvalidArgumentException("El ID de la persona debe ser un valor numérico.");
            }

            $q = "SELECT * FROM personas WHERE id_personas = ?";
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta get_persona_por_id: " . $this->_db->error);
            }

            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $a = $result->fetch_array(MYSQLI_ASSOC);

            if ($a) {

                // Asignar los valores a las propiedades del objeto
                $this->id_persona = $a['id_personas'];
                $this->nombres = $a['nombres'];
                $this->apellidos = $a['apellidos'];
                $this->identificacion = $a['identificacion'];
                $this->tipo_identificacion = $a['tipo_identificacion'];
                $this->nacimiento = $a['nacimiento'];
                $this->correo = $a['correo'];
                $this->i_correo = $a['i_correo'];
                $this->celular = $a['celular'];
                $this->telefono = $a['telefono'];
                $this->u_alumnos = $a['u_alumnos'];
                $this->u_docentes = $a['u_docentes'];
                $this->direccion_residencia = $a['direccion_residencia'];
                $this->barrio = $a['barrio'];
                $this->estrato = $a['estrato'];
                $this->sisben = $a['sisben'];
                $this->familias_accion = $a['familias_accion'];
                $this->regimen_salud = $a['regimen_salud'];
                $this->eps = $a['eps'];
                $this->vive_con = $a['vive_con'];
                $this->victima_conflicto = $a['victima_conflicto'];
                $this->tipo_victima_conflicto = $a['tipo_victima_conflicto'];
                $this->municipio_expulsor = $a['municipio_expulsor'];
                $this->discapacitado = $a['discapacitado'];
                $this->tipo_discapacidad = $a['tipo_discapacidad'];
                $this->capacidad_excepcional = $a['capacidad_excepcional'];
                $this->etnia = $a['etnia'];
                $this->tipo_etnia = $a['tipo_etnia'];
                $this->resguardo_consejo = $a['resguardo_consejo'];
                $this->ips = $a['ips'];
                $this->tipo_sangre = $a['tipo_sangre'];
                $this->rh = $a['rh'];
                $this->capacidad_exepcional = $a['capacidad_excepcional'];
                $this->antecedentes_patologicos_medicos = $a['antecedentes_patologicos_medicos'];
                $this->antecedentes_patologicos_quirurgicos = $a['antecedentes_patologicos_quirurgicos'];
                $this->antecedentes_patologicos_toxicos = $a['antecedentes_patologicos_toxicos'];
                $this->antecedentes_patologicos_psiquiatricos = $a['antecedentes_patologicos_psiquiatricos'];
                $this->antecedentes_patologicos_psicologicos = $a['antecedentes_patologicos_psicologicos'];
                $this->antecedentes_patologicos_morbilidad = $a['antecedentes_patologicos_morbilidad'];
            }
            
            $stmt->close();
            return $a; // Retorna el array asociativo con los datos
        } catch (Exception $e) {
            error_log("Error en get_persona_por_id: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Actualiza uno o varios datos de la persona.
     * Los datos a actualizar se deben suministrar en un array asociativo.
     *
     * @param array $data Un array asociativo de campos y sus nuevos valores.
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function update_persona(array $data){
        try {
            if (!$this->id_persona) {
                throw new InvalidArgumentException("ID de persona no establecido para la actualización.");
            }
            if (empty($data)) {
                return false; // No hay datos para actualizar
            }

            $setClauses = [];
            $params = [];
            $types = '';

            foreach ($data as $key => $value) {
                // Solo actualizar atributos que existen en la clase
                if (property_exists($this, $key)) {
                    $setClauses[] = "$key = ?";
                    $params[] = $value;

                    // Determinar el tipo para bind_param (simplificado, ajustar según necesidades)
                    if (is_int($value)) {
                        $types .= 'i';
                    } elseif (is_float($value)) {
                        $types .= 'd';
                    } else {
                        $types .= 's';
                    }
                }
            }

            if (empty($setClauses)) {
                return false; // No hay campos válidos para actualizar
            }

            $q = "UPDATE personas SET " . implode(', ', $setClauses) . " WHERE id_personas = ?";

            echo $q;
            
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta de actualización de persona: " . $this->_db->error);
            }

            // Añadir el ID de la persona al final de los parámetros
            $params[] = $this->id_persona;
            $types .= 'i'; // Tipo para el ID

            // Usar call_user_func_array para bind_param ya que el número de parámetros es dinámico
            $bind_names = array_merge([$types], $params);
            call_user_func_array([$stmt, 'bind_param'], $this->refValues($bind_names));

            $success = $stmt->execute();
            if ($success === false) {
                throw new Exception("Error al ejecutar la actualización de persona: " . $stmt->error);
            }

            $stmt->close();
            return true;
        } catch (Exception $e) {
            error_log("Error en update_persona: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Función auxiliar para bind_param con arrays dinámicos.
     *
     * @param array $arr El array de valores a enlazar.
     * @return array El array con referencias a los valores.
     */
    private function refValues($arr){
        if (strnatcmp(phpversion(),'5.3') >= 0) { // Referencias son obligatorias en PHP 5.3+
            $refs = array();
            foreach($arr as $key => $value)
                $refs[$key] = &$arr[$key];
            return $refs;
        }
        return $arr;
    }


    /**
     * Agrega una nueva persona a la base de datos.
     * Requiere que los atributos públicos nombres, apellidos, identificacion, tipo_identificacion,
     * nacimiento, correo, i_correo, celular, telefono estén previamente seteados en el objeto.
     *
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function add(){
        try { 
            // Validación básica de entrada
            if (empty($this->nombres) || empty($this->apellidos) || empty($this->identificacion)) {
                throw new InvalidArgumentException("Nombres, apellidos e identificación son campos obligatorios.");
            }
            if (!is_numeric($this->identificacion)) {
                throw new InvalidArgumentException("La identificación debe ser un valor numérico.");
            }
            // Agrega más validaciones según sea necesario para otros campos

            $q = "INSERT INTO personas
                            (nombres, apellidos, identificacion, tipo_identificacion,
                             nacimiento, correo, i_correo, celular, telefono)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

                        
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta de adición de persona: " . $this->_db->error);
            }

            $stmt->bind_param("ssissssss", $this->nombres, $this->apellidos,
                                        $this->identificacion, $this->tipo_identificacion,
                                        $this->nacimiento, $this->correo, $this->i_correo,
                                        $this->celular, $this->telefono);
            
            $c = $stmt->execute();

            if ($c === true) {
                $this->id_persona = $this->_db->insert_id;
                $stmt->close();
                return true;
            } else {
                // Esto podría ocurrir si execute() falla por alguna razón no capturada por prepare()
                throw new Exception("Error al insertar nueva persona: " . $stmt->error);
            }
        } catch (Exception $e) {
            error_log('Error en add: ' . $e->getMessage());
            return false;
        }
    }


    /**
     * Elimina una persona de la base de datos dado su ID.
     *
     * @param int $id_personas El ID de la persona a eliminar.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function del($id_personas){
        try {
            if (!is_numeric($id_personas)) {
                throw new InvalidArgumentException("El ID de la persona debe ser un valor numérico.");
            }

	    

            $q = "DELETE FROM personas WHERE id_personas = ?";
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta de eliminación de persona: " . $this->_db->error);
            }

            $stmt->bind_param("i", $id_personas);
            $c = $stmt->execute();

	     

            if ($c === true) {
                $stmt->close();
		echo "eliminada";
                return true;
            } else {
		echo "no eliminada";
                throw new Exception("Error al eliminar la persona con ID " . $id_personas . ": " . $stmt->error);
            }
        } catch (Exception $e) {
            error_log("Error en del: " . $e->getMessage());
            return false;
        }
    }


    /**
 * Elimina una persona de la base de datos por su ID.
 *
 * @param int $personId El ID de la persona a eliminar.
 * @return bool Devuelve true si la eliminación fue exitosa, de lo contrario false.
 */
public function deleteById($personId)
{
    $stmt = null; // Inicializar la variable fuera del bloque try
    try {
        // 1. Validar que el ID sea un entero válido
        if (!filter_var($personId, FILTER_VALIDATE_INT) || $personId <= 0) {
            throw new InvalidArgumentException("El ID proporcionado no es válido.");
        }

        // 2. Preparar la consulta
        $query = "DELETE FROM personas WHERE id_personas = ?";
        $stmt = $this->_db->prepare($query);

        if ($stmt === false) {
            // Usamos RuntimeException para errores que ocurren durante la ejecución
            throw new RuntimeException("Error al preparar la consulta de eliminación: " . $this->_db->error);
        }

        // 3. Vincular el parámetro y ejecutar
        $stmt->bind_param("i", $personId);

        if (!$stmt->execute()) {
            throw new RuntimeException("Error al ejecutar la eliminación para el ID " . $personId . ": " . $stmt->error);
        }
        
        // 4. Verificar si alguna fila fue afectada
        if ($stmt->affected_rows === 0) {
            // Opcional: Considerar esto un error si se esperaba que el ID existiera
            // throw new Exception("No se encontró ninguna persona con el ID " . $personId . " para eliminar.");
            return false; // O simplemente retornar false si el ID no existía
        }

        return true; // Éxito

    } catch (Exception $e) {
        // Registrar el error detallado para el desarrollador
        error_log("Error en deleteById: " . $e->getMessage());
        // Devolver un simple false a quien llamó la función
        return false;
    } finally {
        // 5. Garantizar que el statement se cierre siempre
        if ($stmt) {
            $stmt->close();
        }
    }
}

    /**
     * Obtiene la dirección de residencia, estrato y barrio de una persona.
     *
     * @param int $id_persona El ID de la persona.
     * @return array|null Un array asociativo con los datos de la dirección o null si no se encuentra.
     */
    public function get_direccion($id_persona){
        try {
            if (!is_numeric($id_persona)) {
                throw new InvalidArgumentException("El ID de la persona debe ser un valor numérico.");
            }

            $q = "SELECT direccion_residencia, estrato, barrio FROM personas WHERE id_personas = ?";
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta get_direccion: " . $this->_db->error);
            }

            $stmt->bind_param("i", $id_persona);
            $stmt->execute();
            $result = $stmt->get_result();
            $a = $result->fetch_array(MYSQLI_ASSOC);
            
            $stmt->close();
            return $a;
        } catch (Exception $e) {
            error_log("Error en get_direccion: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtiene los datos de afiliaciones de una persona.
     *
     * @param int $id_persona El ID de la persona.
     * @return array|null Un array asociativo con los datos de afiliación o null si no se encuentra.
     */
    public function get_afiliacion($id_persona) {
        try {
            if (!is_numeric($id_persona)) {
                throw new InvalidArgumentException("El ID de la persona no es válido.");
            }
        
            $q = "SELECT sisben, familias_accion, regimen_salud, eps, vive_con, tipo_victima_conflicto, municipio_expulsor, discapacitado, tipo_discapacidad, capacidad_excepcional, etnia, tipo_etnia, resguardo_consejo, ips, tipo_sangre, rh FROM personas WHERE id_personas = ?";
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta de afiliación: " . $this->_db->error);
            }
        
            $stmt->bind_param("i", $id_persona);
            $stmt->execute();
            $result = $stmt->get_result();
            $a = $result->fetch_array(MYSQLI_ASSOC);
            
            $stmt->close();
            return $a;
        } catch (Exception $e) {
            error_log("Error en get_afiliacion: " . $e->getMessage());
            return null;
        }
    }


    /**
     * Obtiene los datos de los antecedentes patológicos de una persona.
     *
     * @param int $id_persona El ID de la persona.
     * @return array|null Un array asociativo con los datos de antecedentes o null si no se encuentra.
     */
    public function get_antecedentes($id_persona) {
        try {
            if (!is_numeric($id_persona)) {
                throw new InvalidArgumentException("El ID de la persona no es válido.");
            }
        
            $q = "SELECT antecedentes_patologicos_medicos,
                antecedentes_patologicos_quirurgicos,
                antecedentes_patologicos_toxicos,
                antecedentes_patologicos_psiquiatricos,
                antecedentes_patologicos_psicologicos,
                antecedentes_patologicos_morbilidad FROM personas WHERE id_personas = ?";
        
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta de antecedentes: " . $this->_db->error);
            }
        
            $stmt->bind_param("i", $id_persona);
            $stmt->execute();
            $result = $stmt->get_result();
            $a = $result->fetch_array(MYSQLI_ASSOC);
            
            $stmt->close();
            return $a;
        } catch (Exception $e) {
            error_log("Error en get_antecedentes: " . $e->getMessage());
            return null;
        }
    }


    /**
     * Actualiza el correo personal de una persona.
     */
    public function actualizar_correo_persona() {
        $query = "UPDATE personas SET correo = ? WHERE id_personas = ?";
	//echo $query;
        $stmt = $this->_db->prepare($query);

        // Limpiar datos
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        

        // Vincular parámetros
        $stmt->bind_param("si", $this->correo, $this->id_persona);

        // Ejecutar consulta
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Actualiza el correo institucional de una persona.
     */
    public function actualizar_i_correo_persona() {
        $query = "UPDATE personas SET i_correo = ? WHERE id_personas = ?";
        $stmt = $this->_db->prepare($query);

        $this->i_correo = htmlspecialchars(strip_tags($this->i_correo));
       
        $stmt->bind_param("si", $this->i_correo, $this->id_persona);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Actualiza el teléfono de una persona.
     */
    public function actualizar_telefono_persona() {
        $query = "UPDATE personas SET telefono = ? WHERE id_personas = ?";
        $stmt = $this->_db->prepare($query);
        
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
       

        $stmt->bind_param("si", $this->telefono, $this->id_persona);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Actualiza el celular de una persona.
     */
    public function actualizar_celular_persona() {
        $query = "UPDATE personas SET celular = ? WHERE id_personas = ?";
        $stmt = $this->_db->prepare($query);
        
        $this->celular = htmlspecialchars(strip_tags($this->celular));
        

        $stmt->bind_param("si", $this->celular, $this->id_persona);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Actualiza la fecha de nacimiento de una persona.
     */
    public function actualizar_nacimiento_persona() {
        $query = "UPDATE personas SET nacimiento = ?  WHERE id_personas = ?";
        $stmt = $this->_db->prepare($query);
        
        $this->nacimiento = htmlspecialchars(strip_tags($this->nacimiento));


        $stmt->bind_param("si", $this->nacimiento , $this->id_persona);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Actualiza los nombres y apellidos de una persona.
     */
    public function actualizar_nombres_persona() {
        $query = "UPDATE personas SET nombres = ?, apellidos = ? WHERE id_personas = ?";
        $stmt = $this->_db->prepare($query);
        
        $this->nombres = htmlspecialchars(strip_tags($this->nombres));
        $this->apellidos = htmlspecialchars(strip_tags($this->apellidos));


        $stmt->bind_param("ssi", $this->nombres, $this->apellidos, $this->id_persona);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Actualiza el tipo de identificación y el número de identificación de una persona.
     */
    public function actualizar_identificacion_persona() {
        $query = "UPDATE personas SET tipo_identificacion = ?, identificacion = ? WHERE id_personas = ?";
        $stmt = $this->_db->prepare($query);
        
        $this->tipo_identificacion = htmlspecialchars(strip_tags($this->tipo_identificacion));
        $this->identificacion = htmlspecialchars(strip_tags($this->identificacion));
      

        $stmt->bind_param("ssi", $this->tipo_identificacion , $this->identificacion, $this->id_persona);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}

?>
