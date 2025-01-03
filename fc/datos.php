<?php

require_once("conectar.php");
require_once("padres.php");
require_once("acudientes.php");
require_once("personas.php");
require_once("u_alumnos.php");
require_once("u_docentes.php");
require_once("matricula_docente.php");
require_once("calificaciones.php");
require_once("inscripciones.php");
require_once("listado_estudiantes.php");
require_once("cuadro.php");
require_once("logros.php");
require_once("matricula.php");
require_once("semanas.php");
require_once("materias.php");
require_once("alumno.php");
require_once("ponderado.php");
require_once("requisitos.php");
require_once("grados.php");
require_once("area.php");
require_once("curso.php");


//session_start();

//
//  CLASES
//
// imcrea
//      |_____inscripcion : inscripciones a programas
//      |_____matricula_docente : docente asignados a cursos
//      |_____matricula :  matricula en un curso,grado,jornada
//      |_____matriculas_year: matriculas realizadas en un año

// Clases asociadas a los roles de las personas
//      |_____personas: clase personas
//            |______u_alumnos: personas en el rol de alumnos
//            |______u_docentes: personas en el rol de docentes
//            |______padres: personas que desempeñan el rol de padres de los alumnos
//            |______acudiente : persona responsable del estudiante cuando es menor de edad

// Clases asociadas a las definiciones de los grupos a los 
// que se le imparte el servicio educativo 

//       |____grados:  grados del educacion o titulacion
//            |______requisitos : materias requeridas para un grado o titulacion
//            |______curso: sub divicion en grupos del mismo grado
//                   |____jornada: jornadas academicas de acuerdo a los tiempos de asistencia precencial   

//       |____area: grupo de materias relacionadas
//            |_____materia: catedras dictadas para obtener un grado o titulacion
//                        
//       |____semana : semana academica


// Clases enfocadas en la gention administrativa

//       listado_estudiantes: listado de estudiantes

//       ponderado: ponderados de las calificaciones en una materia
//       calificaciones: calificaciones insertadas para una materia
//       logro : logros cualitativo para la valoracion academica
//       cuadro: cuadro de notas

// Clases estipuladas en el enfoque visual
//
//       grafica: graficas para mostrar estadisticas
//       pagos : pagos efectuados por alumnos
//



// clase que determina la conexion con la base de datos
class imcrea {
    // atributo de la base de datos
    protected $_db;
    // constructor de la clase
    public function __construct(){

        // se realiza la consulta usando el metodo mysqli
        $this->_db=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        if ($this->_db->connect_errno) {
            echo "fallo al conectar bd".$this->_db->connect_errno;
            return;
        }

        $this->_db->set_charset(DB_CHARSET);
    } // fin del constructor de la clase

} // fin de la clase


// Clase de escolaridad

class escolaridad extends imcrea{
    public function __construct()
    {
        // heredo el constructor de la clase
        parent::__construct();
    }
}

// clase que indica las graficas a crear
class grafica extends imcrea {

    // atributos


    public function __construct()
    {
        // heredo el constructor de la clase
        parent::__construct();


    }

}

class pagos extends imcrea {
    // variable para almacenar el codigo del pago
    public $id_pago;
    // variable para almacenar el mes del pago (int)
    public $mes;
    // variable para almacenar el mes de pago
    public $year;
    // codigo de la matricula sobre la cual se va a cancelar el pago
    public $id_matricula;
    // variable que almacena los pagos (bool)
    public $estado;

    // funcion que se activa cuando se crea un nuevo objeto
    public function __construct($id_m, $m, $y){

        parent::__construct();
        // se realiza la consulta
        $q1 = $this->_db->query("select count(*) from pagos where id_matricula = $id_m and mes = $m and year = $y");
        $a = $q1->fetch_array(MYSQLI_NUM);
    
        if($a[0] == 0){
            $resultado = $this->_db->query("insert into pagos (id_matricula,mes,year,estado) values($id_m,$m,$y,0)" );
            // si se ejecuto la consulta
            if ($resultado){
                // completo los atributos en funcion de la consulta
                // echo "<br>se inserto un nuevo pago";
            }
        }
        else {
            //echo "<br>ya existia una matricula para ese periodo";
        }
    
    } // fin de constructor de la clase

  
}

// recupera todos las matriculas realizadas en un año
class matriculas_year extends imcrea {
    // los atributos de la clase
    // el año de publicacion
    public $year;
    // array que guarda las matriculas
    public $matriculas;
  

    // constructor de la clase  recibe como parametro
    // el año en curso
    public function __construct($a) {
        // invoco al constructor de la clase padre (imcrea)
        parent::__construct();
        // genero una consulta a la base de datos
        // con el sistado de id de matriculas en un
        // año ordenados por nombre de estudiantes
        $q2 = $this->_db->query("select id ,a.nombres from  alumnos as a
                                                      inner join matricula as m on a.id_alumno = m.id_alumno
                                                      where m.year = $a
                                                      order by a.nombres");
        // guardo el resoltado en un array inicialmente vacio
        $aa = array();
        // exploro el resultado 
        while($resultado = $q2->fetch_array(MYSQLI_NUM)){
            // agrego elementos al array $aa
            array_push($aa,$resultado[0]);
        }
    
        // doy valores a los atributos del objeto
        $this->year = $a;
        $this->matriculas =  $aa;
    }

     // funcion que obtiene el listado de alumnos matriculados en un año
    // public function listado_matriculados_ano($year) {
    //     // query
    //     $q = "SELECT id_alumno FROM `alumnos`
    //               WHERE id_alumno in
    //               (select id_alumno from matricula WHERE year = $year) 
    //               order by nombres, apellidos";
    //     $c = $this->_db->query($q);
    //     // obtengo el primer dato de de la consulta
    //     $a = $c->fetch_array(MYSQLI_ASSOC);
    //     return $a;
    // }
    
}


?>
