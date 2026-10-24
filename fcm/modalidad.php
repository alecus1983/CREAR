<?php


//clase que identifica las modalidades de estudio
//de una matricula: Presencial, Virtual, Por ciclos, Híbrida
class modalidad extends imcrea
{
    // codigo de la modalidad
    public $id_modalidad;
    // nombre de la modalidad
    public $modalidad;

    // constructor de la clase
    public function __construct()
    {
        // hereda parametros de la clase padre
        parent::__construct();
    }

    // obtiene una modalidad por su id
    public function get_modalidad_por_id($id_modalidad)
    {
        $this->id_modalidad = 0;
        $this->modalidad = "";

        $id_modalidad = intval($id_modalidad);
        if ($id_modalidad > 0) {
            $stmt = $this->_db->prepare("SELECT id_modalidad, modalidad FROM modalidad WHERE id_modalidad = ?");
            $stmt->bind_param("i", $id_modalidad);
            $stmt->execute();
            $a = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
            $stmt->close();

            if ($a) {
                $this->id_modalidad = $a['id_modalidad'];
                $this->modalidad = $a['modalidad'];
            }
        }
    }

    // lista el total de las modalidades
    public function lista()
    {
        // texto de consulta
        $texto = "SELECT id_modalidad, modalidad FROM modalidad ORDER BY id_modalidad";
        $c = $this->_db->query($texto);

        // array vacio
        $aa = array();
        //mientras hayan registros
        while ($a = $c->fetch_array(MYSQLI_ASSOC)) {
            // agrego elementos al array $aa
            array_push($aa, array($a["id_modalidad"], $a["modalidad"]));
        }
        return $aa;
    }
}
