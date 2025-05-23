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

    //constructor de la clase
    public function __construct()
    {
        // se construye a partir de la clase imcrea
        parent::__construct();
    }

    // funcion que agrega un grado
    public function registro(
        $grado,
        $nombre_g,
        $escolaridad,
        $promovido,
        $id_escolaridad
    ) {

        // String  para realizar la consulta
        $q2 = "INSERT INTO grados
      (
        grado,
        nombre_g,
        escolaridad,
        promovido,
        id_escolaridad
      )
      VALUES ('" . $grado .
            "',  '" . $nombre_g .
            "', '" . $escolaridad .
            "', '" . $promovido .
            "', '" . $id_escolaridad .
            "' )";

        // se realiza la consulta
        $qx = $this->_db->query($q2);
        // si se ejecuto la consulta
        if (!$qx) {
            echo "Fallo en incertar grado";
        } else {
            // retorno  el array
            return $qx;

        }
    } // fin de la funcion

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
        // echo "consulsta: "."SELECT nombre_g FROM  grados where  id_grado = ".$id_grado;
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
            $this->_db->close();
        }
    }


    // funcion que lista  de los gradsos de acuerdo a una escolaridad dada
    public function lista_escolaridad($id_escolaridad)
    {
        // texto de la consulta
        $c = $this->_db->query("select * from grados where id_escolaridad = $id_escolaridad order by grado");

        // array que almacena el dato de salida
        $aa = [];

        // si el resulatado de la consulta dio mas
        // de cero registros

        if ($c->num_rows > 0) {

            // esplora iterativamente los registros
            // consultados

            while ($a = $c->fetch_array(MYSQLI_ASSOC)) {

                array_push($aa, array($a["id_grado"], $a["grado"]));

            }

        }
        // retorno un array con la cantidad
        // de filas 
        return $aa;
    }
}
// fin de la clase
?>
