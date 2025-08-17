<?php
require_once("datos.php");
/////////////////////////////////////////////////////
//                                                 //
//       clase de listado de estudiantes           //
//       requiere el año, el grado y el curso      //
//                                                 //
/////////////////////////////////////////////////////


class lista_estudiantes extends imcrea{
 
    // variable del año
    public  $year;
    // variable  del grado
    public $grado;
    // variable del curso
    public $curso;
    public $id_alumno;
    public $id_grado;
    public $id_curso;

    
    // funcion constructor de objeto requiere
    // el año, el  grado y el curso
    public function __construct($y, $g,$j , $c) {

        // echo "cambios";
        // // invoco al constructor de la clase padre (imcrea)
        parent::__construct();
        // // genero una consulta a la base de datos
        $query = "select * from matricula where year = $y and id_grado= $g and id_jornada= $j and id_curso =$c ";

        // echo $query;
        
        $q2 = $this->_db->query($query);
        // guardo el resoltado en un array inicialmente vacio
        $a_grado = array();
        $a_alumno = array();
        $a_curso = array();

        while($resultado = $q2->fetch_array(MYSQLI_ASSOC)){
             // agrego elementos al array $aa
             array_push($a_grado,$resultado['id_grado']);
             array_push($a_alumno,$resultado['id_alumno']);
         }

        // asignacion de parametros
        $this->year = $y;
        $this->id_grado =$a_grado;
        $this->id_alumno = $a_alumno;
        $this->id_curso = $c; 

        // $this->year = 2025;
        // $this->id_grado = 1;
        // $this->id_alumno = 100;
        // $this->id_curso = 1; 
    }

}

?>
