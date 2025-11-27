<?php 
// clase que representa las semanas
class semana extends imcrea{
    public $id_semana;
    public $semana;
    public $year;
    public $inicio;
    public $fin;
    public $notas_por_alumno;
    
    //cosntructor de la clase
    // crea una calificacion vacia
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    // obtengo los atributos de una semana particular dado 
    // el numero de la semana y el año y la semana
    public function get_semana_ano($semana, $ano) {

        // obtengo las caracteristicas de una semana
        $q = "select * from  semanas where year = $ano and semana = $semana";
        $c = $this->_db->query($q);
        $r = $c->fetch_array(MYSQLI_ASSOC);
        $this->notas_por_alumno =  $r['notas_por_alumno'];
        $this->semana =  $r['semana'];
        $this->year =  $r['year'];
        $this->inicio =  $r['inicio'];
        $this->fin =  $r['fin'];
    }

    // recupera el listado de semanas para un año
    public function get_lista_semanas($ano) {
        $q = "select semana from  semanas where year = $ano";
        $c = $this->_db->query($q);

        $arr = array();
        // recorro el array
        while($r = $c->fetch_array(MYSQLI_ASSOC)) {
            // añade elementos al array
            array_push($arr, $r['semana']);
        }
        //retorno listado
        return $arr;
    }

    // recupera el listado de semanas para un año
    public function get_lista_semanas_periodo($ano,$periodo) {
        $q = "select semana from  semanas where year = $ano and id_periodo = $periodo";
        $c = $this->_db->query($q);

        $arr = array();
        // recorro el array
        while($r = $c->fetch_array(MYSQLI_ASSOC)) {
            // añade elementos al array
            $sem =$r['semana'];
            $arr[ $sem] = $sem; 
        }
        //retorno listado
        // echo var_dump($arr);
        return $arr;
    }

    public function get_semana_activa($ano) {
        $q = "select semana from semanas where year = $ano and inicio < NOW() and fin > NOW() order by semana asc;";
        $c = $this->_db->query($q);
        $r = $c->fetch_array(MYSQLI_ASSOC);
        return $r["semana"];

    }

    // funcion que busca el periodo activo en
    // la tabla semans
    public function get_periodo_activo($ano) {
        // string de consulta
        $q = "select id_periodo from semanas
                  where year = $ano and inicio < NOW() and fin > NOW()
                  order by semana asc;";
        // se ejecuta la consulta
        $c = $this->_db->query($q);
        // se recupera los registros 
        $r = $c->fetch_array(MYSQLI_ASSOC);

        // si obtiene  algun periodo
        if (is_null($r["id_periodo"]) ){
            // en caso de que ninguno retorna 0
            return 0;
        }
        // de lo contrado retorna  el periodo
        else {   return $r["id_periodo"];}

    }

    // funcion que actuliza los datos de  la semana
    public function set_semana($semana,$year,$inicio,$fin){
        $q="update semanas set inicio = '$inicio' , fin = '$fin', year = $year where id_semana = $semana";
        //echo $q;
        $c = $this->_db->query($q);
        if($c === true){
            return true;
        }else
        {return false;}
        
    }

    // funcion que actuliza los datos de  la semana
    public function reset_semana($semana){
        $q="update semanas set inicio = null , fin = null, year = null where id_semana = $semana";
        //echo $q;
        $c = $this->_db->query($q);
        if($c === true){
            return true;
        }else
        {return false;}
        
    }

}



?>
