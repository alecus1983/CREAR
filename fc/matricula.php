<?php 
// clase que describe las matriculas realizadas
// en el colegio
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

    // obtengo la matricula en funcion de su id
    // retorna los valores en los atributos del
    // objeto.
    
    public function get_matricula_id($i){
        
        // se realiza la consulta
        $r = $this->_db->query("SELECT * FROM  matricula WHERE  id = ".$i );
        $dato = $r->fetch_array(MYSQLI_ASSOC);

        // si se ejecuto la consulta
        if ($dato){
            // completo los atributos en funcion de la consulta
            $this->id = $dato["id"];
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

    // funcion que permite obtener una  conjunto de matriculas a partir 
    public function get_matriculas_grado_jornada ($year, $id_grado, $id_jornada){
        // introdusco el texto de la consulta
        $q = "select * from matricula m where year = $year
                  and m.id_jornada = $id_jornada and id_grado  = $id_grado";
        //echo $q;
        // ejecuto la consulta
        $c = $this->_db->query($q);
        // creo un array inicial
        $arr = array();
        // recorro el array
        while($r = $c->fetch_array(MYSQLI_ASSOC)) {
            // añade elementos al array
            array_push($arr, $r);
        }
        //retorno listado de matriculas
        return $arr;
        
    }


    // fucncion que retorna un array con los
    // codigos de los alumnos matriculados en
    // grado.
    public function get_matricula_grado($id_jornada,$id_grado,$id_curso,$year){

        // texto de la consulta
        $texto = "select id_alumno, nombres, apellidos from personas as p inner join 
                         (select * from u_alumnos as  ua inner join
                         (select * from matricula 
                          where
                          year = $year
                          and id_grado = $id_grado
                          and id_jornada = $id_jornada
                          and id_curso = $id_curso) as  m
                          on ua.id_alumnos = m.id_alumno) as c
                          on c.id_personas = p.id_personas";
        //preparao la consulta
        $q2 = $this->_db->query($texto);
        // guardo el resoltado en un array inicialmente vacio
        $aa = array();
        // exploro el resultado 
        while($resultado = $q2->fetch_array(MYSQLI_ASSOC)){
            // agrego elementos al array $aa
            array_push($aa,$resultado);
        }
        // devuelvo el array con el listado de estudiantes
        return  $aa;
    }

    // funcion que devuelve las matriculas realizadas
    // durante el año lectivo
    
    public function get_matricula_ano($year){
	// funcion de prueba
	try{
	    // si el argumento $year es nulo
	    if(empty($year)){
		throw new InvalidArgumentException("No se ha seleccionando ningun año para la matricula");
	    }

    
	}
	
	
    }
} // fin de la clase



?>
