<?php 
// clase que representa los logros
class logro extends imcrea{
    public $id_logro;
    public $logro;
    public $id_materia;
    
    //cosntructor de la clase
    // crea una calificacion vacia
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    // obtengo los atributos de un logro dado 
    // el numero de la semana y el año y la semana
    public function get_logros($id_materia) {

        $q = "select * from  logros where id_materia = $id_materia";
        $c = $this->_db->query($q);

        // defino  el array 
        $arr = array();
        
        // recorre el array 
        while($r = $c->fetch_array(MYSQLI_ASSOC)) {
            // agrego un elemento al array
            $arr[$r['id_logro']] = $r['logro'] ;
            
        }
        
        // retorno un array con los id de los logros de la materia
        return $arr;
    }


    // public function get_logro() { 
    //     $q = "select * from  logros where id_logro= $id_logro";
    //     $c = $this->_db->query($q);
       
    //     // recorre el array 
    //     $r = $c->fetch_array(MYSQLI_ASSOC);
    //     // agrego un elemento al array
    //     $this->logro = $r['logro'] ;
    //     $this->id_logro = $r['id_logro'] ;            
    // }


    public function get_logro_id($id_logro) {

        $q = "select * from  logros where id_logro= $id_logro";
        $c = $this->_db->query($q);
       
        // recorre el array 
        $r = $c->fetch_array(MYSQLI_ASSOC);
        // agrego un elemento al array
        if (isset($r['id_logro'])) { 
            $this->logro = $r['logro'] ;
            $this->id_logro = $r['id_logro'] ;
        }
    }

}

?>