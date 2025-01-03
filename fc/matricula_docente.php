<?php

// clase matricula docente
// la cual describe las materias que dicta cada docente
// en un año lectivo

class matricula_docente extends imcrea {
    protected $id;
    public $id_grado;
    public $id_curso;
    public $id_materia;
    public $id_docente;
    public $year;
    protected $id_jornada;
    protected $mes;
    protected $fecha;
    public $listado;
    public $listado_docentes;
    // constructor de la clase
    public function __construct(){
        //   constructor de la clase padre
        parent::__construct();

    }

    public function get_docente($id_materia, $id_grado, $id_jornada, $id_curso, $year){
        $q = "select * from matricula_docente where year = $year and id_grado =$id_grado and id_curso =$id_curso and id_jornada = $id_jornada and id_materia = $id_materia;";
        $resultado = $this->_db->query($q);
        $r = $resultado->fetch_array(MYSQLI_ASSOC);
        if(isset($r["id_docente"])){
            return $r["id_docente"];}
        else
        {return null;}
    } 

    // se obtiene un listado de los grados matriculados por un docente
    // en $this year y $this id_docente
    
    public function get_matricula($formato){
        // consulta que interroga si es un administrador
        $r = $this->_db->query("select admin from docentes where id_docente = ".$this->id_docente);
        // consulta que devuelve un array numérico
        $admin = $r->fetch_array(MYSQLI_NUM);
        // array para almacenar el listado de grados
        $data = array();
        // si es  un administrativo
        if ($admin[0] == 1){
            $q = "SELECT * FROM grados  where formato_boletin = $formato ORDER BY grado";
            // obtengo el query resultado
            $resultado = $this->_db->query($q);
             // convierto la consulta en un array
             while($g = $resultado->fetch_array(MYSQLI_ASSOC)){
                 $data[$g["id_grado"]] = $g["grado"];
             }
         } 
        // // si no es un administrativo
         else{
            $q1 = "SELECT DISTINCT G.id_grado, G.grado FROM grados G INNER JOIN matricula_docente D ON G.id_grado = D.id_grado  WHERE D.year = '".$this->year."' AND  D.id_docente = ".$this->id_docente;
            $resultado = $this->_db->query($q1);
            while($g = $resultado->fetch_array(MYSQLI_ASSOC)){
                $data[$g["id_grado"]] = $g["grado"];
            }
         }
        $this->listado = $data;
    }

    //obtiene un listado de docentes matriculados en un año
    
    public function listado_docentes ($year){
        $arr = array();
        $q = "select id_docente,cedula, login, nombres, apellidos from docentes where id_docente in (
                select distinct id_docente from matricula_docente where year = $year) and admin= 0";
        $c = $this->_db->query($q);
        while($a = $c->fetch_array(MYSQLI_ASSOC)){
            // agrego el codigo de un docente matriculado en el año
            array_push($arr, $a['id_docente']);
        }
        // cargo el listado de docentes
        $this->listado_docentes = $arr;

    }

    // listado de matriculas (id) docentes por grado
    public function get_lista_por_grado ($id_grado,$id_jornada, $id_curso, $year){
        $arr = array();
        $q = "select id from matricula_docente where id_grado = $id_grado and ".
            " id_jornada = $id_jornada and id_curso = $id_curso and year = $year order by id_docente";
        
        $c = $this->_db->query($q);
        while($a = $c->fetch_array(MYSQLI_ASSOC)){
            // agregar elementos al array
            array_push($arr, $a['id']);
            
        }
        // listado de matriculas
        return $arr;

    }

    public function get_matricula_por_id($id){
        $q = "select * from  matricula_docente where id =$id ";
        // ejecuto la consulta
        $c = $this->_db->query($q);
        $a = $c->fetch_array(MYSQLI_ASSOC);

        $this->id = $a['id'];
        $this->id_grado = $a['id_grado'];
        $this->id_curso = $a['id_curso'];
        $this->id_materia = $a['id_materia'];
        $this->id_docente = $a['id_docente'];
        $this->year = $a['year'];
        $this->id_jornada = $a['id_jornada'];
        $this->mes = $a['mes'];
        $this->fecha = $a['fecha'];
    }

    public function  add($id_grado,$id_curso,$id_materia,$id_docente,$ano,$id_jornada){
        $q = "insert into matricula_docente (id_grado, id_curso,id_materia,id_docente,year,id_jornada,mes,fecha)".
            " values($id_grado,$id_curso,$id_materia,$id_docente,$ano,$id_jornada,4,NOW())";
        //echo $q;
        $c = $this->_db->query($q);
        if($c === true){
            return true;
        }else
        {return false;}
        
    }

    public function del($id){
        $q= "delete from  matricula_docente where id = $id";
        //echo $q;
        $c = $this->_db->query($q);
        if($c === true){
            return true;
        }else
            return false;   
    }
}
?>