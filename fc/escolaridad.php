<?php

/**
 * Clase escolaridad
 * * Gestiona los datos de los niveles de escolaridad desde la base de datos.
 * Interactúa con la tabla 'escolaridad'.
 * * @version 1.1 (Corregida y Mejorada)
 */
class escolaridad extends imcrea
{

    /**
     * @var int|null El ID del nivel de escolaridad.
     */
    public $id_escolaridad;

    /**
     * @var string|null El nombre del nivel de escolaridad.
     */
    public $escolaridad;


    /**
     * Constructor de la clase.
     * Hereda la conexión a la base de datos de la clase padre 'imcrea'.
     */
    public function __construct()
    {
        // Heredo el constructor de la clase padre para establecer la conexión a la BD.
        parent::__construct();
    }

    /**
     * Obtiene un nivel de escolaridad por su ID de forma segura.
     * Los datos recuperados se cargan en las propiedades del objeto.
     * * @param int $id_escolaridad El ID del nivel de escolaridad a buscar.
     * @return void
     */
    public function get_escolaridad_por_id($id_escolaridad)
    {
        // Consulta SQL con un marcador de posición (?) para prevenir inyección SQL.
        $q = "SELECT * FROM escolaridad WHERE id_escolaridad = ?";

        // Preparamos la consulta.
        $stmt = $this->_db->prepare($q);

        // Si la preparación fue exitosa, continuamos.
        if ($stmt) {
            // Vinculamos el parámetro. 'i' significa que la variable es de tipo entero.
            $stmt->bind_param("i", $id_escolaridad);

            // Ejecutamos la consulta.
            $stmt->execute();

            // Obtenemos el resultado.
            $resultado = $stmt->get_result();

            // Obtenemos la fila como un array asociativo.
            $a = $resultado->fetch_assoc();

            // Si se encontró una fila, asignamos los valores a las propiedades.
            if ($a) {
                $this->id_escolaridad = $a["id_escolaridad"];
                $this->escolaridad    = $a["escolaridad"];
            } else {
                // Si no se encuentra, dejamos las propiedades como nulas.
                $this->id_escolaridad = null;
                $this->escolaridad    = null;
            }

            // Cerramos el statement para liberar recursos.
            $stmt->close();
        }
    }

    /**
     * Devuelve una lista de todos los niveles de escolaridad.
     * * @return array Un array de arrays asociativos con todos los niveles de escolaridad.
     * Ejemplo: [['id_escolaridad' => 1, 'escolaridad' => 'Primaria'], ...]
     */
    public function lista()
    {
        // Consulta que obtiene todas las escolaridades.
        $q = "SELECT * FROM escolaridad ORDER BY id_escolaridad ASC";

        // Ejecutamos la consulta.
        $c = $this->_db->query($q);

        // Array que almacenará los datos de salida.
        $aa = [];

        // Si el resultado de la consulta tiene filas.
        if ($c && $c->num_rows > 0) {
            // Iteramos sobre cada fila del resultado.
            while ($a = $c->fetch_assoc()) {
                // Añadimos el array asociativo completo al resultado.
                // Esto es más descriptivo que un array numérico.
                array_push($aa, $a);
            }
        }
        
        return $aa;
    }
}
?>
