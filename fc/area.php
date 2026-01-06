<?php
// clase areas   las cuales son un conjunto de
// materias inter relaccionadas

class area extends imcrea {
    public $id_area;
    public $area;

    //cosntructor de la clase
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
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
   
}


?>