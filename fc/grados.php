<?php

// Clase que define el objeto tipo grado
class grados extends jornada
{

    // variable de la tabla grados
    protected $id_grado;
    // codigo del grado
    public $grado;
    // nombre del grado
    public $nombre_g;
    // nombre de la escolaridad del grado
    public $escolaridad;
    // valor al que se esta siendo promovido
    public $promovido;
    // codigo de la escolaridad a la que pertenece el grado
    public $id_escolaridad;
    // formato del boletin de calificaciones
    public $formato_boletin;

    //constructor de la clase
    public function __construct()
    {
        // se construye a partir de la clase imcrea
        parent::__construct();
    }

    // Método actualizado para insertar un grado (incluye formato_boletin)
    public function registro($grado, $nombre_g, $escolaridad, $promovido, $id_escolaridad, $formato_boletin) {
        
        // Sentencia preparada para mayor seguridad y manejo de tipos
        $q = "INSERT INTO grados (grado, nombre_g, escolaridad, promovido, id_escolaridad, formato_boletin) 
              VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->_db->prepare($q);
        
        if ($stmt === false) {
            // Manejo de error en la preparación
            return false;
        }

        // 'ssssii' corresponde a: string, string, string, string, int, int
        $stmt->bind_param("ssssii", $grado, $nombre_g, $escolaridad, $promovido, $id_escolaridad, $formato_boletin);
        
        $resultado = $stmt->execute();
        $stmt->close();

        return $resultado;
    }
    //***************************
    // calcula el valor maximo      *
    //***************************

    public function maximo()
    {
        // se realiza la consulta
        $qx = $this->_db->query("SELECT max(id_grado) as cantidad FROM  grados");
        $dato = $qx->fetch_array();

        // si se ejecuto la consulta
        if (!$dato) {
            //echo "Fallo en incertar fila";
        } else {
            // retorno  el array
            return $dato;
        }
    } // fin de la cuncion

    // Obtener nombre del grado
    public function get_nombre($id_grado)
    {
        // se realiza la consulta
        // echo "consulsta: "."SELECT nombre_g FROM  grados where  id_grado = ".$id_grado;
        $resultado = $this->_db->query("SELECT nombre_g FROM  grados where  id_grado = " . $id_grado);
        $dato = $resultado->fetch_array(MYSQLI_NUM);

        // si se ejecuto la consulta
        if (!$dato) {
            //echo "Fallo en incertar fila";
        } else {
            // retorno  el array
            $this->nombre_g = $dato[0];
            $this->_db->close();
        }
    } // fin de la funcion

    // Obtener nombre del grado
    public function get_grado_id($id_grado)
    {
        // se realiza la consulta
        $resultado = $this->_db->query("SELECT * FROM  grados where  id_grado = " . $id_grado);
        $dato = $resultado->fetch_array(MYSQLI_ASSOC);

        // si se ejecuto la consulta
        if (!$dato) {
            //echo "Fallo en incertar fila";
        } else {
            // retorno  el array
            $this->nombre_g = $dato["nombre_g"];
            $this->promovido = $dato["promovido"];
            $this->grado = $dato["grado"];
	        $this->escolaridad =$dato["escolaridad"];
            $this->formato_boletin = $dato["formato_boletin"];
            
        }
    }

    // funcion para obtener  en un array
    // la lista de grados que pertenecen a una escolaridad

    public function lista_escolaridad($id_escolaridad){

	$q = "select id_grado from grados where id_escolaridad = ?";

	$stmt = $this->_db->prepare($q);

	if ($stmt === false) {
                throw new Exception("Error al preparar la consulta para buscar alumno: " . $this->_db->error);
        }

	$stmt->bind_param("i", $id_escolaridad);
        $stmt->execute();
        $result = $stmt->get_result();
	$alumno_data = $result->fetch_all();
	return $alumno_data;
    }

    
    // recupera el listado de grados pertenecientes a una escolaridad
    public function get_lista_grado_escolaridad($id_escolaridad) {
        $q = "select * from  grados where id_escolaridad = $id_escolaridad";
        $c = $this->_db->query($q);
	// defino un array vacio
        $arr = array();
        // recorro el array
        while($r = $c->fetch_array(MYSQLI_ASSOC)) {
            // añade elementos al array
            array_push($arr, $r['id_grado']);
        }
        //retorno listado
        return $arr;
    }

    // Función para actualizar un grado existente
    public function actualizar_grado($id_grado, $grado, $nombre_g)
    {
        // Preparamos la consulta para evitar inyecciones SQL
        $q = "UPDATE grados SET grado = ?, nombre_g = ? WHERE id_grado = ?";
        
        $stmt = $this->_db->prepare($q);

        if ($stmt === false) {
            return false;
        }

        // 'ssi' significa string, string, integer
        $stmt->bind_param("ssi", $grado, $nombre_g, $id_grado);
        
        $resultado = $stmt->execute();
        
        $stmt->close();

        return $resultado;
    }

    
}


// fin de la clase
?>


