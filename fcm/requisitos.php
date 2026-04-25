<?php

// clase que define las materias requeridas
// para un grado o un programa tecnico
class requisitos extends imcrea {
    // codigo del requisito
    public $id;
    // nombre  del grado/programa tecnico
    public $id_grado;
    // codigo de la materia
    public $id_materia;

    //cosntructor de la clase
    // crea una calificacion vacia
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    public function get_requisitos_grado($id_grado){
        // array que contiene los reguisitos
        $arr = array();
        // consulta
        $q = "select id from  requisitos  where id_grado =$id_grado ";
        //echo $q;
        // ejecuto la consulta
        $c = $this->_db->query($q);
        while($a = $c->fetch_array(MYSQLI_NUM)){
            array_push($arr, $a[0]);
            // agrego array
            // $id = $a['id'];
            // $id_grado = $a['id_grado'];
            // $id_materia = $a['id_materia'];
            // $arr[$id][0] = $id_grado;
            // $arr[$id][1] = $id_materia;
        }
        //echo var_dump($arr);
        return $arr;
    }

    public function get_requisitos_id($id){
        $q = "select * from requisitos where id = $id";
        //echo $q;
        // ejecuto la consulta
        $c = $this->_db->query($q);
        $a = $c->fetch_array(MYSQLI_ASSOC);
        $this->id = $a['id'];
        $this->id_grado = $a['id_grado'];
        $this->id_materia = $a['id_materia'];
        
    }

    public function add($id_materia,$id_grado){
        $q= "insert into requisitos (id_materia,id_grado) values($id_materia, $id_grado)";
        //echo $q;
        $c = $this->_db->query($q);
        if($c === true){
            return true;
        }else
        {return false;}
        
    }
    public function del($id_materia,$id_grado){
        $q= "delete from  requisitos where id_materia = $id_materia and id_grado = $id_grado";
        //echo $q;
        $c = $this->_db->query($q);
        if($c === true){
            return true;
        }else
            return false;
        
    }
}

?>