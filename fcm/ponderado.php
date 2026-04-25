<?php

////////////////////////////////////////////////////////////
//                                                        //
//          clase que define los poderados                //
//                                                        //
///////////////////////////////////////////////////////////

class ponderado  extends imcrea{

    // atributo de la clase ponderado 
    public $id_ponderado;
    public $ponderado;
    public $valor;
    public $tipo;
    public $por_periodo;

    //cosntructor de la clase
    // crea una calificacion vacia
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    //obtengo los parametros de un ponderado basado
    // en un tipo
    public function get_ponderado_por_tipo($tipo){
        $q = "select * from ponderado where tipo = '$tipo'";
        //echo $q;
        $c = $this->_db->query($q);
        $r = $c->fetch_array(MYSQLI_ASSOC);
        $this->id_ponderado = $r['id_ponderado'];
        $this->ponderado = $r['ponderado'];
        $this->valor = $r['valor'];
        $this->tipo = $r['tipo'];
        $this->por_periodo = $r['por_periodo'];
    }
}

?>