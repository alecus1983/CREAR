<?php 

// clase que define los docentes
class materia extends area {
    //  atributos
    public $id_materia;
    public $materia;
    public $area;
    //private $id_area;
    public $ih;
    public $logo;
    
    
    //cosntructor de la clase
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    //funcion para obtener los datos del docente
    // a partir de la base de datos
    public function get_materia($id){
        //consulta para recuperar el docente
        $q = "select * from materia  where  id_materia = $id";
        // se obtiene la variable resultado de consulta
        $c = $this->_db->query($q);
        // obtengo el primer dato de de la consulta
        $a = $c->fetch_array(MYSQLI_ASSOC);

        // asigno el valor devuelto a los atributos del ob jeto

        $this->id_materia = $a['id_materia'];;
        $this->materia = $a['materia'];
        $this->area = $a['area'];
        $this->id_area = $a['id_area'];
        $this->ih = $a['ih'];;
        $this->logo = $a['logo'];
    }

  
    public function get_materias_por_grado_area($g,$a){
        $arr = array();
        $q = "";
        // if($this->admin == 1){
        //     // consulta para obtener las materias
        //     $q ="SELECT M.id_materia, M.materia
        //           OM requisitos R INNER JOIN materia M ON M.id_materia = R.id_materia
		// WHERE R.id_grado = ".$g;
        // } else
        // {
        $q = "select id_materia, materia from materia where id_materia in (
              select id_materia from requisitos where id_grado =$g ) and  
              id_area  = $a order by id_materia";
        //}
        // realizo la consulta
        $c = $this->_db->query($q);
        while($a = $c->fetch_array(MYSQLI_ASSOC)){
            $id_m = $a['id_materia'];
            $m = $a['materia'];
            $arr[$id_m] = $m; 
        }
        return $arr;
    }
    
    // obtengo un array con todas las materas
    public function get_all(){
        $arr = array();
        $q =" select id_materia from materia order by materia";
        $c = $this->_db->query($q);
        while($a = $c->fetch_array(MYSQLI_NUM)){
            array_push($arr, $a[0]);
        }
        return $arr;
        
    }

   

    // Método para insertar una nueva materia
    public function insertar_materia($nombre, $id_area, $ih) {
        // Escapar datos para prevenir inyeccion SQL básica
        $nombre = $this->_db->real_escape_string($nombre);
    
        $q = "INSERT INTO materia (materia, id_area, ih) 
          VALUES ('$nombre', $id_area, $ih)";
          
        if ($this->_db->query($q)) {
            return true;
        }
        return false;
    }

    // Método para actualizar una materia existente
    public function actualizar_materia($id, $nombre, $id_area, $ih) {
        $nombre = $this->_db->real_escape_string($nombre);
    
        $q = "UPDATE materia SET 
          materia = '$nombre', 
          id_area = $id_area, 
          ih = $ih 
          WHERE id_materia = $id";
          
        if ($this->_db->query($q)) {
            return true;
        }
        return false;
    }

    // Método para eliminar una materia
    public function eliminar_materia($id) {
        $q = "DELETE FROM materia WHERE id_materia = $id";
    
        if ($this->_db->query($q)) {
            return true;
        }
        return false;
    }
}

?>
