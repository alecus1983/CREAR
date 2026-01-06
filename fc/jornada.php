<?php


//clase que indentifica las jornadas
//hace referencia a los horarios en que
//se dictan la clases
class jornada extends escolaridad
{
    // codigo de la jornada
    public $id_jornada;
    // nombre de la jornada
    public $jornada;

    // cosntructor de la clase
    // crea una calificacion vacia
    public function __construct()
    {
        // hereda parametros de la clase padre
        parent::__construct();
    }


    public function get_jornada_por_id($id_jornada)
    {
        $q = "select * from  jornada where id_jornada =$id_jornada ";
        // ejecuto la consulta
        $c = $this->_db->query($q);
        $a = $c->fetch_array(MYSQLI_ASSOC);

        $this->id_jornada = $a['id_jornada'];
        $this->jornada = $a['jornada'];
    }

    // lista el total de las jornadas
    public function lista()
    {

        // texto de consulta
        $texto = "select * from jornada";
        $c = $this->_db->query($texto);

        // array vacio
        $aa = array();
        //
        if ($c->num_rows > 0) {

            //mientras hayan registros
            while ($a = $c->fetch_array(MYSQLI_ASSOC)) {
                // agrego elementos al array $aa
                array_push($aa, array($a["id_jornada"], $a["jornada"]));
            }
        }
        return $aa;
    }
}
