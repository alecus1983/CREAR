<?php 

class matricula extends imcrea {
    // clave foranea del alumno
    public $id_alumno;
    // clave primaria
    public $id;
    // clave primaria del grado
    public $id_grado;
    // clave de jornada
    public $id_jornada;
    // clave primaria del año
    public $year;
    // mes de ingreso
    public $mes;
    // mes de retiro
    public $retiro;
    // codigo del curso
    public $id_curso;
    

    //constructor de la clase
    public function __construct(){
        // se construye a partir de la clase imcrea
        parent::__construct();
    }

    //constructor de la clase
    public function get_matricula_id($i){
        
        // se realiza la consulta
        $r = $this->_db->query("SELECT * FROM  matricula WHERE  id = ".$i );
        $dato = $r->fetch_array(MYSQLI_ASSOC);

        // si se ejecuto la consulta
        if ($dato){
            // completo los atributos en funcion de la consulta
            $this->id_alumno = $dato["id_alumno"];
            $this->id_grado = $dato["id_grado"];
            $this->id_jornada = $dato["id_jornada"];
            $this->year = $dato["year"];
            $this->mes = $dato["mes"];
            $this->retiro = $dato["retiro"];
            $this->id_curso = $dato["id_curso"];
        }
    }

    // metodo para matricular_colegio
    public function set_matricula()  {

        // // esta funcion actualiza el codigo de inscripcion de un estudiante
        // // dentro de la tabla alumnos
        $texto = "INSERT INTO matricula (id_alumno,id_grado,id_jornada,id_curso,mes,retiro,year)
              VALUES ($this->id_alumno,$this->id_grado,$this->id_jornada,$this->id_curso,$this->mes,$this->retiro,$this->year)";
        // echo $texto;
        // ejecuto la consulta
        $consulta = $this->_db->query($texto);
        // retorno el estado de la consulta
        return $consulta;
    } // fin de set matricula
} // fin de la clase
?>
