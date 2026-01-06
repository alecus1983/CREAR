<?php


// clase que define los cursos los cuales son grupos de estudiantes que
// se encuentran en el mismo grado y jornada
class curso extends grados{
    // codigo del curso tipo int()
    public $id_curso;
    // nombre del curso tipo varchar()
    public $curso;
    // indica si el curso esta activo tipo int()
    public $activo;

    //cosntructor de la clase
    // crea una calificacion vacia
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    public function get_curso_por_id($id_curso){
        $q = "select * from  curso  where id_curso =$id_curso ";
        //echo $q;
        // ejecuto la consulta
        $c = $this->_db->query($q);
        $a = $c->fetch_array(MYSQLI_ASSOC);
        //echo var_dump($a);
        // retorno los atributos del curso
        $this->id_curso = $a['id_curso'];
        $this->curso = $a['curso'];
        $this->activo = $a['activo'];        
    }
}


?>