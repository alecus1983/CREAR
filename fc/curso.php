<?php

// clase que define los cursos los cuales son grupos de estudiantes que
// se encuentran en el mismo grado y jornada
class curso extends grados {
    // codigo del curso tipo int()
    public $id_curso;
    // nombre del curso tipo varchar()
    public $curso;
    // indica si el curso esta activo tipo int()
    public $activo;

    //constructor de la clase
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    // Obtener los datos de un curso específico por su ID
    public function get_curso_por_id($id_curso){
        $q = "select * from  curso  where id_curso =$id_curso ";
        $c = $this->_db->query($q);
        if ($a = $c->fetch_array(MYSQLI_ASSOC)) {
            $this->id_curso = $a['id_curso'];
            $this->curso = $a['curso'];
            $this->activo = $a['activo'];        
        }
    }

    // RETORNA UN ARRAY CON TODOS LOS IDs DE LOS CURSOS (Para el listado)
    public function get_all(){
        $arr = array();
        $q = "SELECT id_curso FROM curso ORDER BY curso ASC";
        $c = $this->_db->query($q);
        while($a = $c->fetch_array(MYSQLI_NUM)){
            array_push($arr, $a[0]);
        }
        return $arr;
    }

    // MÉTODO PARA INSERTAR UN NUEVO CURSO
    public function insertar_curso($nombre, $activo) {
        // Escapamos el nombre para evitar errores con comillas
        $nombre = $this->_db->real_escape_string($nombre);
        // id_curso es auto_increment, no se envía en el INSERT
        $q = "INSERT INTO curso (curso, activo) VALUES ('$nombre', $activo)";
        
        if ($this->_db->query($q)) {
            return true;
        }
        return false;
    }

    // MÉTODO PARA ACTUALIZAR UN CURSO EXISTENTE
    public function actualizar_curso($id, $nombre, $activo) {
        $nombre = $this->_db->real_escape_string($nombre);
        $q = "UPDATE curso SET curso = '$nombre', activo = $activo WHERE id_curso = $id";
        
        if ($this->_db->query($q)) {
            return true;
        }
        return false;
    }

    // MÉTODO PARA ELIMINAR UN CURSO
    public function eliminar_curso($id) {
        $q = "DELETE FROM curso WHERE id_curso = $id";
        
        if ($this->_db->query($q)) {
            return true;
        }
        return false;
    }

    public function tiene_matriculas($id) {
    // Consultamos si existe al menos un alumno en ese curso
    $q = "SELECT COUNT(*) as total FROM matricula WHERE id_curso = $id";
    $c = $this->_db->query($q);
    $res = $c->fetch_array(MYSQLI_ASSOC);
    
    // Si el conteo es mayor a 0, devuelve verdadero (no se puede borrar)
    return ($res['total'] > 0);
}
}

?>
