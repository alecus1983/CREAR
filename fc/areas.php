<?php

// clase que define las areas
class area extends imcrea {
    //  atributos
    public $id_area;
    public $area;
        
    //cosntructor de la clase
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    //funcion para obtener los datos del docente
    // a partir de la base de datos
    public function get_area($id){
        //consulta para recuperar el docente
        $q = "select * from area  where  id_area = $id";
        // se obtiene la variable resultado de consulta
        $c = $this->_db->query($q);
        // obtengo el primer dato de de la consulta
        $a = $c->fetch_array(MYSQLI_ASSOC);

        // asigno el valor devuelto a los atributos del ob jeto

        $this->id_area = $a['id_area'];;
        $this->area = $a['area'];
        
    }

  
     
    // obtengo un array con todas las materas
    public function get_all(){
        $arr = array();
        $q =" select id_area from area order by area";
        $c = $this->_db->query($q);
        while($a = $c->fetch_array(MYSQLI_NUM)){
            array_push($arr, $a[0]);
        }
        return $arr;
        
    }

    // Método para insertar una nueva materia
    public function insertar_area($nombre) {
        // Al ser auto_increment, solo insertamos la columna 'area'
        $q = "INSERT INTO area (area) VALUES ('$nombre')";
        if ($this->_db->query($q)) {
            return true;
        }
        return false;
    }

    // Método para actualizar el nombre de un área
    public function actualizar_area($id, $nombre) {
        // Escapar datos para evitar inyecciones si no usas sentencias preparadas
        $nombre = $this->_db->real_escape_string($nombre);
        
        $q = "UPDATE area SET area = '$nombre' WHERE id_area = $id";
        
        if ($this->_db->query($q)) {
            return true;
        }
        return false;
    }
    
    // Método para eliminar una materia
    public function eliminar_area($id) {
        $q = "DELETE FROM area WHERE id_area = $id";
    
        if ($this->_db->query($q)) {
            return true;
        }
        return false;
    }


    // retorna el listado de areas por grado usando un array
    public function get_areas_grado($id_g) {

        $arr = array();
        // texto de consulta
        //$q = "select id_area, area from area where id_area in (
        //      select id_area from materia where id_materia in (
        //      select id_materia from requisitos where id_grado =$id_g )) order by area";
        $q  = "select area.id_area id_area, area, cantidad from area inner join ( 
               select id_area, count(*) cantidad from materia where id_materia in (
               select id_materia from requisitos where id_grado =$id_g )  GROUP by id_area
               ) as ca on ca.id_area = area.id_area 
               order by area";
        
        // realizo la consulta
        $c = $this->_db->query($q);
        // recorro el array
        while($a = $c->fetch_array(MYSQLI_ASSOC)){
            
            $id_m = $a['id_area'];
            $m = $a['area'];
            $can = $a['cantidad'];
            $arr[$id_m][0] = $m;
            $arr[$id_m][1] = intval($can);
            
        }
        // retorna un array con el conjunto de areas
        return $arr;
    }

    public function tiene_materias($id) {
    $q = "SELECT COUNT(*) as total FROM materia WHERE id_area = $id";
    $c = $this->_db->query($q);
    $res = $c->fetch_array(MYSQLI_ASSOC);
    return ($res['total'] > 0); // Retorna true si hay materias vinculadas
}


}

?>
