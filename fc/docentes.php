<?php 
///////////////////////////////////////////
//                                       //
//   clase que define los docentes       //
//                                       //
//////////////////////////////////////////

 
class docentes extends imcrea {
  
    //  atributos de la clase
    public $id;
    public $admin;
    public $nombres;
    public $apellidos;
    public $cedula;
    public $login;
    public $fecha;
    public $celular;
    public $correo;
    public $i_correo;
    public $materias;
    public $listado;

    //  METODOS DE LA CLASE             
    //
    // constructor
    // +get_docente($id):
    // +get_docente_cc($id):
    // +get_materias_por_grado($g,$y):
    // +get_total_docentes():
    
    //cosntructor de la clase
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    //      funcion para obtener los datos del docente
    //      a partir del codigo id del docente
    public function get_docente_id($id) {
        //consulta para recuperar el docente
        $q = "select * from docentes where  id_docente = $id";
        // se obtiene la variable resultado de consulta
        $c = $this->_db->query($q);
        // obtengo el primer dato de de la consulta
        $a = $c->fetch_array(MYSQLI_ASSOC);

        // asigno el valor devuelto a los atributos del ob jeto
        $this->id = $a['id_docente'];
        $this->admin =  $a['admin']; 
        $this->nombres = $a['nombres'];
        $this->apellidos = $a['apellidos'];
        $this->cedula = $a['cedula'];
        $this->login = $a['login'];
        $this->fecha = $a['fecha'];
        $this->celular = $a['celular'];
        $this->correo = $a['correo'];
        $this->i_correo = $a['i_correo'];
        $this->materias = $a['materias'];
    }

    // obtengo el docente por cedula
    public function get_docente_cc($id){
        //consulta para recuperar el docente
        $q = "select * from docentes where  cedula = $id";
        // se obtiene la variable resultado de consulta
        $c = $this->_db->query($q);
        // obtengo el primer dato de de la consulta
        $a = $c->fetch_array(MYSQLI_ASSOC);

        // asigno el valor devuelto a los atributos del ob jeto
        $this->id = $a['id_docente'];
        $this->admin =  $a['admin']; 
        $this->nombres = $a['nombres'];
        $this->apellidos = $a['apellidos'];
        $this->cedula = $a['cedula'];
        $this->login = $a['login'];
        $this->fecha = $a['fecha'];
        $this->celular = $a['celular'];
        $this->correo = $a['correo'];
        $this->i_correo = $a['i_correo'];
        $this->materias = $a['materias'];
    }


    //      funcion para obtener los datos del docente
    //      a partir del codigo id del docente
    public function get_docente_email($email) {
        //consulta para recuperar el docente
        $q = "select * from docentes where  i_correo = '$email'";

        //echo $q;
        // se obtiene la variable resultado de consulta
        $c = $this->_db->query($q);
        // obtengo el primer dato de de la consulta
        $a = $c->fetch_array(MYSQLI_ASSOC);

        // asigno el valor devuelto a los atributos del ob jeto
        $this->id = $a['id_docente'];
        $this->admin =  $a['admin']; 
        $this->nombres = $a['nombres'];
        $this->apellidos = $a['apellidos'];
        $this->cedula = $a['cedula'];
        $this->login = $a['login'];
        $this->fecha = $a['fecha'];
        $this->celular = $a['celular'];
        $this->correo = $a['correo'];
        $this->i_correo = $a['i_correo'];
        $this->materias = $a['materias'];
    }

    // funcion que retorna las materias que se dictan en un año
    // en forma de array,  requiere:
    // grado --> $g
    // año   --> $y
 
    public function get_materias_por_grado($g,$y) {

        // array de retorno donde se va a
        // de volvel la lista de materias
        // de acuerdo a su codigo de materia
        // y el nombre de la misma
        $arr = array();
        $q = "";

        // si es administrativo
        if($this->admin == 1){
            // consulta para obtener las materias
            $q ="SELECT M.id_materia, M.materia  FROM requisitos R
	    INNER JOIN materia M ON M.id_materia = R.id_materia
		WHERE R.id_grado = ".$g;
        } else
        {
            // si no es administrativo solo lista las materias
            // en el cual esta asignano
            $q = "SELECT DISTINCT M.id_materia, M.materia FROM materia M
	      INNER JOIN matricula_docente D ON M.id_materia = D.id_materia  WHERE D.year = '".$y."'
		AND  D.id_docente = ".$this->id." AND D.id_grado =".$g;
        }

        // realizo la consulta
        $c = $this->_db->query($q);
        
        // exploro el valor retornado
        while($a = $c->fetch_array(MYSQLI_ASSOC)){
            // codigo de la materia
            $id_m = $a['id_materia'];
            // nombre de la matera
            $m = $a['materia'];
            $arr[$id_m] = $m; 
        }
        // retorno como un atributo del objeto
        $this->materias = $arr;
    }

    // total de docentes
    // Retorna  un listado de los docentenes con
    // codigo    
    // nombres   
    // apellidos 
    // nombre completo
  
    public function get_total_docentes(){
        // array
        $arr = array();
        // consulta
        $q ="select id_docente, completo from 
            (select id_docente,  nombres, apellidos, lower(concat(nombres, apellidos)) completo from docentes) as c
            order by completo asc";
        // realizar consulta
        $c = $this->_db->query($q);
        // recorro el array 
        while($a = $c->fetch_array(MYSQLI_ASSOC)){
            // el arrray
            array_push($arr, $a['id_docente']);
        }
        return $arr;
    }
}
    

?>