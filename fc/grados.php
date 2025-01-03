<?php

// Clase que define la inscripcion
class grados extends jornada {

    // variable de la tabla grados
    protected $id_grado;
    public $grado;
    public $nombre_g;
    protected $escolaridad;
    public $promovido;
    protected $id_escolaridad;


    //constructor de la clase
    public function __construct(){
        // se construye a partir de la clase imcrea
        parent::__construct();
    }

    // Registros
    public function registro(
        $grado,
        $nombre_g,
        $escolaridad,
        $promovido,
        $id_escolaridad
    ) {

        // scrip sql
        // String  para realizar la consulta
        $q2 = "INSERT INTO grados
      (
        grado,
        nombre_g,
        escolaridad,
        promovido,
        id_escolaridad
      )
      VALUES ('".$grado.
            "',  '".$nombre_g.
            "', '".$escolaridad.
            "', '".$promovido.
            "', '".$id_escolaridad.
            "' )";

        // se realiza la consulta
        $qx = $this->_db->query($q2);
        // $dato = $qx->fetch_array();

        // si se ejecuto la consulta
        if (!$qx){
            echo "Fallo en incertar grado";
        } else {
            // retorno  el array
            return $qx;
            $qx -> close();
            $this -> _db -> close();
        }
    } // fin de la funcion

    //***************************
    // calcula el valor maximo      *
    //***************************

    public function maximo(){
        // se realiza la consulta
        $qx = $this->_db->query("SELECT max(id_grado) as cantidad FROM  grados");
        $dato = $qx->fetch_array();

        // si se ejecuto la consulta
        if (!$dato){
            //echo "Fallo en incertar fila";
        } else {
            // retorno  el array
            return $dato;
            $this -> _db -> close();
        }
    } // fin de la cuncion

    // Obtener nombre del grado
    public function get_nombre($id_grado){
        // se realiza la consulta
        // echo "consulsta: "."SELECT nombre_g FROM  grados where  id_grado = ".$id_grado;
        $resultado = $this->_db->query("SELECT nombre_g FROM  grados where  id_grado = ".$id_grado );
        $dato = $resultado->fetch_array(MYSQLI_NUM);

        // si se ejecuto la consulta
        if (!$dato){
            //echo "Fallo en incertar fila";
        } else {
            // retorno  el array
            $this->nombre_g = $dato[0];
            $this -> _db -> close();
        }
    } // fin de la funcion

    // Obtener nombre del grado
    public function get_grado_id($id_grado){
        // se realiza la consulta
        // echo "consulsta: "."SELECT nombre_g FROM  grados where  id_grado = ".$id_grado;
        $resultado = $this->_db->query("SELECT * FROM  grados where  id_grado = ".$id_grado );
        $dato = $resultado->fetch_array(MYSQLI_ASSOC);

        // si se ejecuto la consulta
        if (!$dato){
            //echo "Fallo en incertar fila";
        } else {
            // retorno  el array
            $this->nombre_g = $dato["nombre_g"];
            $this->promovido = $dato["promovido"];
            $this->grado = $dato["grado"];
            $this -> _db -> close();
        }
    }

}
// fin de la clase
?>