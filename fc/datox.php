<?php

// Contiente los modelo de clase  que apunta a la base de datos
// Configuración de constantes
define('DB_HOST', 'localhost');
define('DB_USER', 'imcreati_admin');
define('DB_PASS','conezioncrear21');
define('DB_NAME','imcreati_data');
define('DB_CHARSET','utf8');

// clase que determina la conexion con la base de datos
class imcrea {

    protected $_db;

    public function __construct(){

        //$this->_db= new mysqli('localhost','imcreati_admin','conezioncrear21','imcreati_data');
        $this->_db=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        if ($this->_db->connect_errno) {
            echo "fallo al conectar bd".$this->_db->connect_errno;
            return;
        }

        $this->_db->set_charset(DB_CHARSET);
    } // fin del constructor de la clase

} // fin de la clase

// Clase que define la inscripcion
class inscripcion extends imcrea {
    // consecutivo inscripciones
    public $id;
    // estado de la inscripcion "i" para inscritos
    // "m" para matriculados
    public $estado;
    // nombres de los estudiantes
    public $nombre_estudiante;
    // apellidos del iscrito
    public $apellido_estudiante;
    // correo del estudiante
    public $correo_estudiante;
    // apellidos del inscrito
    public $nacimiento;
    // ciudad de nacimiento del estudiante
    public $ciudad_nacimiento;
    // codigo de escolaridad
    public $escolaridad;
    // grado
    public $id_grado;
    // nombre del grado
    public $id_jornada;
    // antiguedad
    public $antiguedad;
    // // tipo_institucion privada = 0  publica = 1
    public $tipo_institucion;
    // modalidad 1 = virtual 0 presencial
    public $modalidad;
    // tipo de institucion
    public $nombre_institucion;
    // motivo de retiro
    public $motivo;
    // Telefono del inscrito
    public $telefono;
    // Telefono del inscrito
    public $celular;
    //tipo de indentificaion
    public $tipo_identificacion;
    // documento de estudiante
    public $documento_estudiante;
    // lugar de expecidicion del documento del estudiante
    public $lugar_exp_estudiante;
    // genero del estudiante ( femenino, masculino )
    public $genero;
    // grupo sanguineo del estudiante
    public $gruporh;
    // EPS del estudiante
    public $EPS;
    // sisben al que pertenece el estudiante
    public $nivelsisben;
    // direccion de residencia del estudiante
    public $direccion_estudiante;
    // barrio donde vive el estudiante
    public $barrio;
    // estrato del estudiante
    public $estrato;
    // personas con las que vive el estudiante
    public $vivecon;
    // nombre del padre
    public $nombre_padre;
    // apellodo del padre
    public $apellido_padre;
    // correo electronico del padre
    public $correo_padre;
    // telefono del padre
    public $telefono_padre;
    // tipo de documento del padre
    public $tipo_identificacion_padre;
    // numero de documento del padre
    public $documento_padre;
    // lugrar de expedicion
    public $lugar_exp_padre;
    // direccion del padre
    public $direccion_padre;
    // barrio del padre
    public $barrio_padre;

    // nombre de la madre
    public $nombre_madre;
    // apellido del padre
    public $apellido_madre;
    // correo de la madre debe llevar @
    public $correo_madre;
    // telefono de la madre máximo diez dijitos
    public $telefono_madre;
    // tipo de documnto CC, CE, RC
    public $tipo_identificacion_madre;
    // documento de la madre
    public $documento_madre;
    // lugar de expedicin del documento de la madre
    public $lugar_exp_madre;
    // direccion de recidencia de la madre
    public $direccion_madre;
    // barrio de la madre
    public $barrio_madre;
    // victima del conflicto
    public $victima_conflicto;

    //constructor de la clase
    public function __construct($codigo) {
        // se construye a partir de la clase imcrea
        parent::__construct();

        $resultado = $this->_db->query("SELECT * FROM  inscritos WHERE id  = ".$codigo );
        $dato = $resultado->fetch_array(MYSQLI_ASSOC);

        if ($dato){
            // retorno el dato como un array
            $this->id = $dato["id"];
            $this->antiguedad = $dato["antiguedad"];
            $this->apellido_estudiante = $dato["apellido_estudiante"];
            $this->apellido_madre = $dato["apellido_madre"];
            $this->apellido_padre = $dato["apellido_padre"];
            $this->barrio = $dato["barrio"];
            $this->barrio_madre = $dato["barrio_madre"];
            $this->barrio_padre = $dato["barrio_padre"];
            $this->celular = $dato["celular"];
            $this->correo_madre = $dato["correo_madre"];
            $this->correo_padre = $dato["correo_padre"];
            $this->correo_estudiante = $dato["correo_estudiante"];
            $this->ciudad_nacimiento = $dato["ciudad_nacimiento"];
            $this->direccion_estudiante = $dato["direccion_estudiante"];
            $this->direccion_madre = $dato["direccion_madre"];
            $this->direccion_padre = $dato["direccion_padre"];
            $this->documento_madre = $dato["documento_madre"];
            $this->documento_padre = $dato["documento_padre"];
            $this->documento_estudiante = $dato["documento_estudiante"];
            $this->estrato = $dato["estrato"];
            $this->escolaridad = $dato["id_escolaridad"];
            $this->EPS = $dato["EPS"];
            $this->estado = $dato["estado"];
            $this->genero = $dato["genero"];
            $this->gruporh = $dato["gruporh"];
            $this->id_grado = $dato["id_grado"];
            $this->id_jornada = $dato["id_jornada"];
            $this->lugar_exp_madre = $dato["lugar_exp_madre"];
            $this->lugar_exp_padre = $dato["lugar_exp_padre"];
            $this->lugar_exp_estudiante = $dato["lugar_exp_estudiante"];
            $this->motivo = $dato["motivo"];
            $this->modalidad = $dato["modalidad"];
            $this->nacimiento = $dato["nacimiento"];
            $this->nivelsisben = $dato["nivelsisben"];
            $this->nombre_madre = $dato["nombre_madre"];
            $this->nombre_padre = $dato["nombre_padre"];
            $this->nombre_estudiante = $dato["nombre_estudiante"];
            $this->nombre_institucion = $dato["nombre_institucion"];
            $this->telefono = $dato["telefono"];
            $this->telefono_madre = $dato["telefono_madre"];
            $this->telefono_padre = $dato["telefono_padre"];
            $this->tipo_identificacion = $dato["tipo_identificacion"];
            $this->tipo_identificacion_madre = $dato["tipo_identificacion_madre"];
            $this->tipo_identificacion_padre = $dato["tipo_identificacion_padre"];
            $this->tipo_institucion = $dato["tipo_institucion"];
            $this->vivecon = $dato["vivecon"];
            $this->victima_conflicto = $dato["victima_conflicto"];
        }

    }

    // metodo para cambiar el estado de la matricula
    // "i" para inscritos
    // "m" para matriculados

    public function update_estado(){
        // consulta para la actualizacion
        $texto = "UPDATE inscritos  SET estado ='$this->estado' WHERE id = $this->id";
        $consulta = $this->_db->query($texto);

    }
    // Registros
    public function registro() {
        // crea un string con la fecha
        $now = date("Y-m-d g:i");
        // scrip sql
        // String  para realizar la consulta
        $q2 = "INSERT INTO inscritos
    (
      nombre_estudiante,
      apellido_estudiante,
      correo_estudiante,
      nacimiento,
      ciudad_nacimiento,
      id_escolaridad,
      id_grado,
      id_jornada,
      antiguedad,
      tipo_institucion,
      nombre_institucion,
      motivo,
      modalidad,
      telefono,
      celular,
      tipo_identificacion,
      documento_estudiante,
      lugar_exp_estudiante,
      genero,
      gruporh,
      EPS,
      nivelsisben,
      direccion_estudiante,
      barrio,
      estrato,
      vivecon,

      nombre_padre,
      apellido_padre,
      correo_padre,
      telefono_padre,
      tipo_identificacion_padre,
      documento_padre,
      lugar_exp_padre,
      direccion_padre,
      barrio_padre,

      nombre_madre,
      apellido_madre,
      correo_madre,
      telefono_madre,
      tipo_identificacion_madre,
      documento_madre,
      lugar_exp_madre,
      direccion_madre,
      barrio_madre,
      fecha,
      estado
    )

    VALUES ('".$this->nombre_estudiante.
            "',  '".$this->apellido_estudiante.
            "',  '".$this->correo_estudiante.
            "', '".$this->nacimiento.
            "', '".$this->ciudad_nacimiento.
            "', '".$this->escolaridad.
            "', '".$this->id_grado.
            "', '".$this->id_jornada.
            "', '".$this->antiguedad.
            "', '".$this->tipo_institucion.
            "', '".$this->nombre_institucion.
            "', '".$this->motivo.
            "', '".$this->modalidad.
            "', '".$this->telefono.
            "', '".$this->celular.
            "', '".$this->tipo_identificacion.
            "', '".$this->documento_estudiante.
            "', '".$this->lugar_exp_estudiante.
            "', '".$this->genero.
            "', '".$this->gruporh.
            "', '".$this->EPS.
            "', '".$this->nivelsisben.
            "', '".$this->direccion_estudiante.
            "', '".$this->barrio.
            "', '".$this->estrato.
            "', '".$this->vivecon.

            "', '".$this->nombre_padre.
            "', '".$this->apellido_padre.
            "', '".$this->correo_padre.
            "', '".$this->telefono_padre.
            "', '".$this->tipo_identificacion_padre.
            "', '".$this->documento_padre.
            "', '".$this->lugar_exp_padre.
            "', '".$this->direccion_padre.
            "', '".$this->barrio_padre.

            "', '".$this->nombre_madre.
            "', '".$this->apellido_madre.
            "', '".$this->correo_madre.
            "', '".$this->telefono_madre.
            "', '".$this->tipo_identificacion_madre.
            "', '".$this->documento_madre.
            "', '".$this->lugar_exp_madre.
            "', '".$this->direccion_madre.
            "', '".$this->barrio_madre.
            "', '".$now.
            "', 'i".
            "' )";

        // se realiza la consulta
        $qx = $this->_db->query($q2);
        //echo "<br><br>Consulata : <br>".$q2;

        // si se ejecuto la consulta
        if (!$qx){
            echo "Fallo en incertar fila";
        } else {
            // retorno  el array
            return $qx;
            $qx -> close();
            $this -> _db -> close();
        }
    } // fin de la funcion

    //////////////////////////////
    // calcula el valor maximo  //
    /////////////////////////////

    function maximo(){
        // se realiza la consulta
        $qx = $this->_db->query("SELECT max(id) as cantidad FROM  inscritos");
        $dato = $qx->fetch_array();

        // si se ejecuto la consulta
        if (!$dato){
            //echo "Fallo en incertar fila";
        } else {
            // retorno  el array
            return $dato;
            $dato -> close();
            $this -> _db -> close();
        }
    }

    // metodo para obtener todos los datos de una inscripcion dado un codigo
    // de insgripcion
    public function get_all($codigo){

        $resultado = $this->_db->query("SELECT * FROM  inscritos WHERE id  = ".$codigo );
        $dato = $resultado->fetch_array(MYSQLI_ASSOC);
        // retorno el dato como un array
        return $dato;
    }

    //

} // fin de la clase

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
    
    public function get_matricula(){
        // consulta que interroga si es un administrador
        $resultado = $this->_db->query("select admin from docentes where id_docente = ".$this->id_docente);
        // consulta que devuelve un array numérico
        $admin = $resultado->fetch_array(MYSQLI_NUM);
        // array para almacenar el listado de grados
        $data = array();
        // si es  un administrativo
        if ($admin[0] == 1){
            // obtengo el query resultado
            $resultado = $this->_db->query("SELECT * FROM grados ORDER BY grado");
            // convierto la consulta en un array
            while($g = $resultado->fetch_array(MYSQLI_ASSOC)){
                //      $id = $g["id_grado"];
                //$grado = $g["grado"];
                $data[$g["id_grado"]] = $g["grado"];
            }
        } 
        // si no es un administrativo
        else{
            $q1 = "SELECT DISTINCT G.id_grado, G.grado FROM grados G INNER JOIN matricula_docente D ON G.id_grado = D.id_grado  WHERE D.year = '".$this->year."' AND  D.id_docente = ".$this->id_docente;
            $resultado = $this->_db->query($q1);
            while($g = $resultado->fetch_array(MYSQLI_ASSOC)){
                //      $id = $g["id_grado"];
                //$grado = $g["grado"];
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

// Clase que define la inscripcion
class grados extends imcrea {

    // variable de la tabla grados
    protected $id_grado;
    public $grado;
    public $nombre_g;
    protected $escolaridad;
    public $promovido;
    protected $id_escolaridad;


    //constructor de la clase
    public function __construct(){
        // se construye a partir de la clase imcrea
        parent::__construct();
    }

    // Registros
    public function registro(
        $grado,
        $nombre_g,
        $escolaridad,
        $promovido,
        $id_escolaridad
    ) {

        // scrip sql
        // String  para realizar la consulta
        $q2 = "INSERT INTO grados
      (
        grado,
        nombre_g,
        escolaridad,
        promovido,
        id_escolaridad
      )
      VALUES ('".$grado.
            "',  '".$nombre_g.
            "', '".$escolaridad.
            "', '".$promovido.
            "', '".$id_escolaridad.
            "' )";

        // se realiza la consulta
        $qx = $this->_db->query($q2);
        // $dato = $qx->fetch_array();

        // si se ejecuto la consulta
        if (!$qx){
            echo "Fallo en incertar grado";
        } else {
            // retorno  el array
            return $qx;
            $qx -> close();
            $this -> _db -> close();
        }
    } // fin de la funcion

    //////////////////////////////
    // calcula el valor maximo  //
    /////////////////////////////

    public function maximo(){
        // se realiza la consulta
        $qx = $this->_db->query("SELECT max(id_grado) as cantidad FROM  grados");
        $dato = $qx->fetch_array();

        // si se ejecuto la consulta
        if (!$dato){
            //echo "Fallo en incertar fila";
        } else {
            // retorno  el array
            return $dato;
            $dato -> close();
            $this -> _db -> close();
        }
    } // fin de la cuncion

    // Obtener nombre del grado
    public function get_nombre($id_grado){
        // se realiza la consulta
        // echo "consulsta: "."SELECT nombre_g FROM  grados where  id_grado = ".$id_grado;
        $resultado = $this->_db->query("SELECT nombre_g FROM  grados where  id_grado = ".$id_grado );
        $dato = $resultado->fetch_array(MYSQLI_NUM);

        // si se ejecuto la consulta
        if (!$dato){
            //echo "Fallo en incertar fila";
        } else {
            // retorno  el array
            $this->nombre_g = $dato[0];
            $this -> _db -> close();
        }
    } // fin de la funcion

    // Obtener nombre del grado
    public function get_grado_id($id_grado){
        // se realiza la consulta
        // echo "consulsta: "."SELECT nombre_g FROM  grados where  id_grado = ".$id_grado;
        $resultado = $this->_db->query("SELECT * FROM  grados where  id_grado = ".$id_grado );
        $dato = $resultado->fetch_array(MYSQLI_ASSOC);

        // si se ejecuto la consulta
        if (!$dato){
            //echo "Fallo en incertar fila";
        } else {
            // retorno  el array
            $this->nombre_g = $dato["nombre_g"];
            $this->promovido = $dato["promovido"];
            $this->grado = $dato["grado"];
            $this -> _db -> close();
        }
    }

}
// fin de la clase

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

    //constructor de la clase
    public function __construct($i){
        // se construye a partir de la clase imcrea
        parent::__construct();

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
            // return $dato[0];
            // $dato -> close();
        }
    }

    // metodo para matricular_colegio
    public function set_matricula()  {


        // // esta funcion actualiza el codigo de inscripcion de un estudiante
        // // dentro de la tabla alumnos
        $texto = "INSERT INTO matricula (id_alumno,id_grado,id_jornada,mes,retiro,year)
              VALUES ($this->id_alumno,$this->id_grado,$this->id_jornada,$this->mes,$this->retiro,$this->year)";
        //echo $texto;
        // ejecuto la consulta
        $consulta = $this->_db->query($texto);

    } // fin de set matricula
} // fin de la clase

// clase que define a los alumnos
class alumnos extends imcrea {

    public $id_alumno;
    public $nombres;
    public $apellidos;
    public $cedula;
    public $login;
    public $fecha;
    public $telefono;
    public $inscripcion;
    public $correo;

    public function __construct($codigo){

        parent::__construct();
        // se realiza la consulta
        $resultado = $this->_db->query("SELECT * FROM  alumnos where  id_alumno = ".$codigo." order by nombres" );
        $dato = $resultado->fetch_array(MYSQLI_ASSOC);

        // si se ejecuto la consulta
        if ($dato){
            // completo los atributos en funcion de la consulta
            $this->id_alumno = $dato["id_alumno"];
            $this->nombres = $dato["nombres"];
            $this->apellidos = $dato["apellidos"];
            $this->cedula = $dato["cedula"];
            $this->login = $dato["login"];
            $this->fecha = $dato["fecha"];
            $this->telefono = $dato["telefono"];
            $this->inscripcion = $dato["inscripcion"];
            //return $dato[0];
            //$resultado -> close();
        }
        // $this -> _db -> close();
    }

    // crear alumnos
    public function set_alumno(){
        $q ="INSERT INTO alumnos (nombres, apellidos, cedula, fecha, correo, telefono, login, inscripcion)
          values ('".$this->nombres."' ,'"
           .$this->apellidos."' ,'"
           .$this->cedula."' ,'"
           .$this->fecha."' ,'"
           .$this->correo."' ,'"
           .$this->telefono."' ,"
           ."'creativo'"." ,"
           .$this->inscripcion.")";

        //echo "<br>".$q;

        // ejecuto la consulta
        $dato = $this->_db->query($q);

        // si se ejecuto la consulta
        if (!$dato){
            //echo "Fallo en incertar fila";
        } else {
            // retorno  el valor 0 del array
            //return $dato[0];
            //$dato -> close();
            $this -> _db -> close();
        }
    }

    // método para actualizar alumnos
    public function update_alumno(){
        // actualizacion de los datos del alumno
        $texto = "UPDATE alumnos SET  nombres ='$this->nombre_estudiante',
                                  apellidos='$this->apellido_estudiante' ,
                                  cedula = '$this->documento_estudiante' ,
                                  telefono = '$this->celular',
                                  fecha = '$this->fecha' ,
                                  correo = '$this->correo'
                                   ";

        // ejecuto la consulta
        $dato = $this->_db->query($texto);

        // si se ejecuto la consulta
        if (!$dato){
            //echo "Fallo al actualizar alumno";
        } else {
            // retorno  el valor 0 del array
            $dato -> close();
            $this -> _db -> close();

        }
    }


    // metodo para buscar estudiante dado el nombre y apellido
    public function buscar_estudiante ($nombre, $apellido){

        //Filtro anti-XSS
        $caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
        $caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");
        $nombre = str_replace($caracteres_malos, $caracteres_buenos, $nombre);
        $apellido = str_replace($caracteres_malos, $caracteres_buenos, $apellido);

        //Variable vacía (para evitar los E_NOTICE)
        $mensaje = "";

        //Comprueba si $consultaBusqueda está seteado
        if (isset($nombre)) {

            // convierte el nombre en un array
            $nombres = explode(" ",$nombre);
            // iniciale del nombre
            $i_nombre = substr($nombre,0,1);
            $i_apellido = substr($apellido,0,1);

            // comvierte el apellido en un array
            $apellidos = explode(" ",$apellido);
            // texto de la consulta para la busqueda del estudiante
            $texto = "select * from (
    	select LEFT (nombres,1) i_nombres, nombres,LEFT(apellidos,1)
    	i_apellidos, apellidos, id_alumno from alumnos a
    	) as f_nombres where (nombres like '%".$nombres[0]."%' or apellidos like '%".$apellidos[0]."%')
      and i_nombres = '".$i_nombre."' and i_apellidos = '".$i_apellido."' order by nombres , apellidos";

            // ejecucion de la consulta
            $consulta = $this->_db->query($texto);
            // metodo iterativo para la busqueda de nombres
            while($dato = $consulta->fetch_array(MYSQLI_ASSOC)){

                echo "<br><font style='color:blue'>".$dato["id_alumno"]."</font>";
                echo " ".ucwords(strtolower($dato["nombres"]))."";
                echo " ".ucwords(strtolower($dato["apellidos"]))."<br>";
            }

        };

    }

    public function get_id_nombre($id_alumno){
        // se realiza la consulta
        $resultado = $this->_db->query("SELECT nombres FROM  alumnos where  id_alumno = ".$id_alumno );
        $dato = $resultado->fetch_array(MYSQLI_NUM);

        // si se ejecuto la consulta
        if (!$dato){
            //echo "Fallo en incertar fila";
        } else {
            // retorno  el valor 0 del array
            return $dato[0];
            $dato -> close();
            $this -> _db -> close();
        }
    } // fin de la funcion

    // Funcion que permite tener un apellido de un alumno a partir del id
    public function get_id_apellido($id_alumno) {
        // se realiza la consulta
        $resultado = $this->_db->query("SELECT apellidos FROM  alumnos where  id_alumno = ".$id_alumno );
        $dato = $resultado->fetch_array(MYSQLI_NUM);

        // si se ejecuto la consulta
        if (!$dato) {
            //echo "Fallo en incertar fila";
        } else {
            // retorno  el valor 0 del array
            return $dato[0];
            $dato -> close();
            $this -> _db -> close();
        }
    } // fin de la funcion

    // obtengo el ultimo alumno ingresado
    function maximo() {
        // se realiza la consulta
        $qx = $this->_db->query("SELECT max(id_alumno) as cantidad FROM  alumnos");
        $dato = $qx->fetch_array(MYSQLI_NUM);

        // si se ejecuto la consulta
        if (!$dato){
            //echo "Fallo en incertar fila";
        } else {
            // retorno  el array
            return $dato[0];
            $dato -> close();
            $this -> _db -> close();
        }
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
    public $year;
    public $matriculas;
  

    // constructor de la clase  
    public function __construct($a) {
        // invoco al constructor de la clase padre (imcrea)
        parent::__construct();
        // genero una consulta a la base de datos
        $q2 = $this->_db->query("select id from matricula where year = $a");
        // guardo el resoltado en un array inicialmente vacio
        $aa = array();
        while($resultado = $q2->fetch_array(MYSQLI_NUM)){
            // agrego elementos al array $aa
            array_push($aa,$resultado[0]);
        }
    
        // doy valores a los atributos del objeto
        $this->year = $a;
        $this->matriculas =  $aa;
    }
}

// clase de listado de estudiantes
// requiere el año, el grado y el curso
class listado_estudiantes extends imcrea {
 
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
    //el año, el  grado y el curso
    public function __construct($y, $g,$j , $c) {
        // invoco al constructor de la clase padre (imcrea)
        parent::__construct();
        // genero una consulta a la base de datos
        $query = "select * from matricula where year = $y and id_grado= $g and id_jornada= $j and id_curso =$c ";
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
    }

}


////////////////////////////////////// 
// clase que define los docentes    //
//                                  //
//////////////////////////////////////

 
class docentes extends imcrea {
  
    //  atributos
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
    
    //cosntructor de la clase
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    // funcion para obtener los datos del docente
    // a partir del codigo id del docente

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

    // funcion que retorna las materias que se dictan en un año
    // en forma de array,  requiere:
    // grado --> $g
    // año   --> $y
    
    public function get_materias_por_grado($g,$y) {
        $arr = array();
        $q = "";
        if($this->admin == 1){
            // consulta para obtener las materias
            $q ="SELECT M.id_materia, M.materia  FROM requisitos R
	    INNER JOIN materia M ON M.id_materia = R.id_materia
		WHERE R.id_grado = ".$g;
        } else
        {
            $q = "SELECT DISTINCT M.id_materia, M.materia FROM materia M
	      INNER JOIN matricula_docente D ON M.id_materia = D.id_materia  WHERE D.year = '".$y."'
		AND  D.id_docente = ".$this->id." AND D.id_grado =".$g;
        }

        // realizo la consulta
        $c = $this->_db->query($q);
        while($a = $c->fetch_array(MYSQLI_ASSOC)){
            $id_m = $a['id_materia'];
            $m = $a['materia'];
            $arr[$id_m] = $m; 
        }
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

// clase que define los poderados
class ponderado  extends imcrea{

    public $id_ponderado;
    public $ponderado;
    public $valor;
    public $tipo;
    public $por_periodo;

    //cosntructor de la clase
    // crea una calificacion vacia
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    //obtengo los parametros de un ponderado basado
    // en un tipo
    public function get_ponderado_por_tipo($tipo){
        $q = "select * from ponderado where tipo = '$tipo'";
        //echo $q;
          $c = $this->_db->query($q);
          $r = $c->fetch_array(MYSQLI_ASSOC);
          $this->id_ponderado = $r['id_ponderado'];
          $this->ponderado = $r['ponderado'];
          $this->valor = $r['valor'];
          $this->tipo = $r['tipo'];
          $this->por_periodo = $r['por_periodo'];
        }
    }
    
    
//////////////////////////////////////////////////
//  Clase que identifica las calificaciones     //
//////////////////////////////////////////////////

class calificaciones extends  imcrea {
    // si esta calificado 1 si no 0
    public $calificado;
    // codigo del alumno
    public $id_alumno;
    // codigo de la materia
    public $id_materia;
    // codigo de la semana
    public $id_semana;
    // codigo del año
    public $year;
    // codigo del ponderado
    public $id_ponderado;
    // nota asignada
    public $nota;
    // id
    public $id;
    // logro
    public  $logro;
    
    
    //cosntructor de la clase
    // crea una calificacion vacia
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();

      
    }

    // Metodo que obtiene la calificación semanal
    // 
    public function get_calificacion_semanal($id_a,$id_m,$id_s , $y, $id_p) {

        $q = "select id_alumno, id, nota, id_ponderado, id_materia, id_semana, year  from calificaciones where year = $y and  id_alumno = $id_a and    id_materia = $id_m and       id_ponderado = $id_p and   id_semana = $id_s";
        // ejecuto la consulta
        // echo $q;
        
        try { 
        $c = $this->_db->query($q);
        $r = $c->fetch_array(MYSQLI_ASSOC); }
        catch (Exeption $e) {
            //echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
        // consulto si el resultado es vacio
        if(is_null($r)){
            // si es falso entonces no ha sido calificado
            $this->calificado = false;
            $this->nota = 0;
           
        }else{
            // si es verdadero asigno la notag
            $this->calificado = true;
            $this->id_alumno = $r['id_alumno'];
            $this->id_materia = $r['id_materia'];
            $this->id_semana =$r['id_semana'];
            $this->year = $r['year'];
            $this->id_ponderado = $r['id_ponderado'];
            $this->id = $r['id'];
             $this->nota = $r['nota'];
            
         }
    }

    
    //////////////////////////////////////////////////////////////////////////////
    // obtiene la nota del periodo                                              //
    //                                                                          //
    // Función que obtiene las recuperaciones enviadas a un determinado periodo,//
    // para ello recibe las variables:                                          //
    // $id_a --> código del alumno                                              //
    // $id_m --> código de la materia                                           //
    // $y    --> año de consulta                                                //
    // $periodo --> identificación del periodo                                  //
    //                                                                          //
    //////////////////////////////////////////////////////////////////////////////
    
    public function get_recuperacion_periodo($id_a,$id_m,$y, $periodo) {

      // Consulta que obtiene mediante SQL la cantidad de recuperaciones
        $q = "select id_alumno, id, nota, id_materia, year, corte  from calificaciones
	where year = $y
	and  id_alumno = $id_a
	and  id_materia = $id_m
	and corte = 'R'
	and periodo = $periodo";
        // ejecuto la consulta
        // echo $q;
        
        try { 
        $c = $this->_db->query($q);
        $r = $c->fetch_array(MYSQLI_ASSOC); }
        catch (Exeption $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
        // consulto si el resultado es vacio
        if(is_null($r)) {
            // si es falso entonces no ha sido calificado
            $this->calificado = false;
            $this->nota = 0;
           
        }else {
            // si es verdadero asigno la notag
            $this->calificado = true;
            $this->id_alumno = $r['id_alumno'];
            $this->id_materia = $r['id_materia'];
            $this->year = $r['year'];
            $this->id = $r['id'];
             $this->nota = $r['nota'];
         }
    }


    // obtiene la nota del periodo
    public function get_nota_periodo($id_a, $id_m, $periodo, $year){
      // si la materia es disciplina se calcula como un promedio
      if($id_m == 20){
	$q = "select avg( nota) nota from calificaciones
                  where id_alumno = $id_a and id_materia = $id_m and
                  periodo = $periodo and year = $year and  id_semana > 0";
      }
      // para el resto de las asignatuas se calcula de acuerdo al ponderado
      else {
        $q = "select  sum(valor*nota)/100 as nota from
              ponderado as p inner join 
              (select id_ponderado, nota from calificaciones
               where id_alumno = $id_a and id_materia = $id_m and
               periodo = $periodo and year = $year and id_ponderado > 0
               order by id_ponderado) as  cal on cal.id_ponderado = p.id_ponderado
               order by p.id_ponderado";}
      
      try {
	// realizo la consulta
	$c = $this->_db->query($q);
	//extraigo un dato
             $r = $c->fetch_array(MYSQLI_ASSOC); }
      catch (Exeption $e) {
	//echo 'Excepción capturada: ',  $e->getMessage(), "\n";
      }
      // guardo la nota en el objeto
         $this->nota = $r['nota'];
        
      }

      // funcion que recupera los datos de rendimiento de un alumno
      // en una materia especifica
    public function get_rendimiento_alummno_periodo($id_a, $id_m, $ano, $id_periodo){
      // consulta para recuperar alumnos
        $q = "select p.id_ponderado, ponderado, por_periodo, cantidad from ponderado as p inner join
(select id_ponderado, count(*)  as cantidad from calificaciones where id_alumno = $id_a and id_materia = $id_m and year = $ano and periodo = $id_periodo
group by id_ponderado order by id_ponderado) as c on p.id_ponderado = c.id_ponderado
order by id_ponderado";

         $c = $this->_db->query($q);

        $arr = array();
        // recorro el array
        while($r = $c->fetch_array(MYSQLI_ASSOC)) {
            // añade elementos al array
            array_push($arr, $r);
        }
        //retorno listado
        return $arr;
    }

     public function get_logro_id($id_logro) {

        $q = "select * from  logros where id_logro= $id_logro";
        $c = $this->_db->query($q);
       
        // recorre el array 
        $r = $c->fetch_array(MYSQLI_ASSOC);
            // agrego un elemento al array
        $this->logro = $r['logro'] ;
        $this->id_logro = $r['id_logro'] ;            
    }

    // verifica la calificacion semanal
    // requiere 
    public function get_logro($id_a,$id_m, $y, $id_periodo) {
        $q = "select * from calificaciones where year = $y
                                        and id_alumno = $id_a
                                       and id_materia = $id_m
                                          and periodo = $id_periodo
                                            and id_logro > 0";
        // ejecuto la consulta
        $c = $this->_db->query($q);
        // lo convierto en array
        $r = $c->fetch_array(MYSQLI_ASSOC);
        // consulto si el resultado es vacio
        if(is_null($r)){
            // si es falso entonces no ha sido calificado
            $this->calificado = false;
            $this->logro = "";
           
        }else{
            // si es verdadero asigno la nota
            $this->calificado = true;
            $this->id_alumno = $r['id_alumno'];
            $this->id_materia = $r['id_materia'];
            $this->id_semana =$r['id_semana'];
            $this->year = $r['year'];
            $this->id = $r['id'];
            $this->logro = $r['id_logro'];
            
        }
    }

    // Método que establece  la calificación semanal
    public function set_calificacion_semanal($id_a,$id_m,$nota,$id_d,$p, $y,$id_p, $id_s){

        // filtro el periodo en base a la semana 
        switch ($id_s)  {
            //  si son las semans del primer periodo 
        case 1|2|3|4|5|6|7|8 :
            $p = 1;
            // si son las semanas del segundo periodo
        case 9|10|11|12|13|14|15|16 :
            $p = 2;
            // si son las semanas del tercer periodo 
        case 17|18|19|20|21|22|23|24 :
            $p = 3;
            // son las semans del  cuarto periodo
        case 25|26|27|28|29|30|31|32 :
                $p = 4;
         
        }
        // creo la consulta
        $q= "insert into calificaciones
            ( id_alumno,id_materia, nota,id_docente,periodo,year,modificado,id_ponderado,id_semana )
            values($id_a,$id_m,$nota,$id_d,$p,$y,NOW(),$id_p,$id_s)";
        // ejecuto la consulta
        if( $this->_db->query($q) === True) {
            $this->calificado = true;
        } else {
            $this->calificado = false; }
    }

    // Método que establece  la recuperación del periodo
    // para lo cual se emplean las variables
    //
    // $id_a --> código del alumno
    // $id_m --> código de la materia
    // $nota --> nota asignada (número decimal)
    // $id_d --> código del docente
    // $y    --> año lectivo
    
    public function set_recuperacion($id_a,$id_m,$nota,$id_d,$p,$y){
        // creo la consulta
        $q= "insert into calificaciones
	  ( id_alumno,id_materia, nota,id_docente,periodo,year,modificado,corte )
	  values($id_a,$id_m,$nota,$id_d,$p,$y,NOW(),'R' )";
        // ejecuto la consulta
        if( $this->_db->query($q) === True){
            $this->calificado = true;
        } else{
            $this->calificado = false; }
    }

    
    // Método que establese el logro del periodo
    
    public function set_logro($id_a,$id_m,$logro, $id_d , $p, $y){
        // creo la consulta
        $q= "insert into calificaciones
            (id_alumno, id_materia, id_logro, nota , id_docente, periodo, year, modificado)
            values($id_a, $id_m, $logro, 0 ,  $id_d, $p, $y,NOW())";
        // ejecuto la consulta
        if( $this->_db->query($q) === True){
            $this->calificado = true;
        } else{
            $this->calificado = false; }
    }

    

    // Método que actualiza la recuperación
    // para lo cual utiliza el id de la recuperación

    public function update_recuperacion($id,$nota){

        $q = "update calificaciones set nota = $nota where id = $id";

        
        if( $this->_db->query($q) === True){
            $this->calificado = true;
        } else{
            $this->calificado = false; }
    }

    // Método que actualiza la calificación semanal    
    // para lo cual utiliza el id de la recuperación

    public function update_calificacion_semanal($id,$nota){

        $q = "update calificaciones set nota = $nota where id = $id";

        
        if( $this->_db->query($q) === True){
            $this->calificado = true;
        } else{
            $this->calificado = false; }
    }

    // Método para actualizar los logros
    public function update_logro($id,$logro){

        $q = "update calificaciones set id_logro = $logro where id = $id";

        
        if( $this->_db->query($q) === True){
            $this->calificado = true;
        } else{
            $this->calificado = false; }
    }

    // retorno  la cantidad de calificaciones que un docente debe generar en una semana
    // si semanalmente se generara una nota por alumno y materia
    // se de debe  multiplicar por la cantidad de calificaciones por alumnos
    // de acuerdo al tipo de semana
    public function max_calificaciones($id_docente, $year){
        $q= "select sum(cantidad) cantidad, id_docente from ".
          " ( select md.id_docente, md.id_grado,  md.id_jornada, md.id_curso, id_materia, cantidad ".
          " from matricula_docente as  md inner join ".
          " ( select count(*) as cantidad , id_grado, id_jornada, id_curso  from matricula where year = ".$year.
          " group by id_jornada, id_grado, id_curso ) as  ca ".
          " on ca.id_grado = md.id_grado and ca.id_curso = md.id_curso and ca.id_jornada = md.id_jornada ".
          " where md.year = ".$year." and md.id_docente = ".$id_docente.
          " order by md.id_docente, md.id_materia, md.id_grado ) as cd group by id_docente";

        
        // ejecuto la consulta 
        $c = $this->_db->query($q);
        $r = $c->fetch_array(MYSQLI_ASSOC);
        return  $r['cantidad'];
    }

    public function get_docente_semana($id_docente, $ano, $semana) {

        $q = "select count(*) cantidad from calificaciones where id_docente = $id_docente and year = $ano  and id_semana = ".$semana;
        $c = $this->_db->query($q);
        $r = $c->fetch_array(MYSQLI_ASSOC);
        return $r['cantidad'];

    }

    public function get_criterio_faltantes($id_e, $id_m, $id_s, $p, $year){

        // Consulta fallida
        $q = "select v.criterio, tipo, id_semana from 
(select concat(validar,$id_m) as criterio, tipo, id_semana from validar where id_semana < $id_s) as v left join
(select  concat (tipo,id_semana, id_materia) as  criterio , c.id_ponderado from ponderado as p inner join ( 
select id_alumno, id_semana, id_ponderado, id_materia from calificaciones where year = $year and periodo = $p and id_materia = $id_m  and   id_semana < $id_s and  id_alumno in ($id_e)) as c on c.id_ponderado = p.id_ponderado) as n on n.criterio = v.criterio where n.criterio is null";

        //echo $q;
        
        // realizo la consulta
        $c = $this->_db->query($q);
        //$arr = array(array());
        // recorro el array
        while($a = $c->fetch_array(MYSQLI_ASSOC)){
            
             $criterio = $a['criterio'];
             $tipo = $a['tipo'];
             $semana = $a['id_semana'];
             $arr[$criterio][0] = $tipo;
             $arr[$criterio][1] = $semana;
            
        }
        // retorna un array con el conjunto de areas
        return $arr;
        
    }


}

// clase areas   las cuales son un conjunto de
// materias inter relaccionadas

class area extends imcrea {
    public $id_area;
    public $area;

    //cosntructor de la clase
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    // retorna el listado de areas por grado usando un array
    public function get_areas_grado($id_g) {

        $arr = array();
        // texto de consulta
        //$q = "select id_area, area from area where id_area in (
        //      select id_area from materia where id_materia in (
        //      select id_materia from requisitos where id_grado =$id_g )) order by area";
        $q  = "select area.id_area id_area, area, cantidad from area inner join ( 
               select id_area, count(*) cantidad from materia where id_materia in (
               select id_materia from requisitos where id_grado =$id_g )  GROUP by id_area
               ) as ca on ca.id_area = area.id_area 
               order by area";
        
        // realizo la consulta
        $c = $this->_db->query($q);
        // recorro el array
        while($a = $c->fetch_array(MYSQLI_ASSOC)){
            
             $id_m = $a['id_area'];
             $m = $a['area'];
             $can = $a['cantidad'];
             $arr[$id_m][0] = $m;
             $arr[$id_m][1] = intval($can);
            
        }
        // retorna un array con el conjunto de areas
        return $arr;
    }
   
}


// clase que define los docentes
class materia extends imcrea {
    //  atributos
    public $id_materia;
    public $materia;
    public $area;
    private $id_area;
    public $ih;
    public $logo;
    
    
    //cosntructor de la clase
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    //funcion para obtener los datos del docente
    // a partir de la base de datos
    public function get_materia($id){
        //consulta para recuperar el docente
        $q = "select * from materia  where  id_materia = $id";
        // se obtiene la variable resultado de consulta
        $c = $this->_db->query($q);
        // obtengo el primer dato de de la consulta
        $a = $c->fetch_array(MYSQLI_ASSOC);

        // asigno el valor devuelto a los atributos del ob jeto

        $this->id_materia = $a['id_materia'];;
        $this->materia = $a['materia'];
        $this->area = $a['area'];
        $this->id_area = $a['id_area'];
        $this->ih = $a['ih'];;
        $this->logo = $a['logo'];
    }

    //funcion que retorna las materias que se dictan en un año
    //en forma de array,  requiere el grado $g y el año $y
    public function get_materias_por_grado($g,$y){
        $arr = array();
        $q = "";
        if($this->admin == 1){
            // consulta para obtener las materias
            $q ="SELECT M.id_materia, M.materia  FROM requisitos R INNER JOIN materia M ON M.id_materia = R.id_materia
		WHERE R.id_grado = ".$g;
        } else
        {
            $q = "SELECT DISTINCT M.id_materia, M.materia FROM materia M INNER JOIN matricula_docente D ON M.id_materia = D.id_materia  WHERE D.year = '".$y."'
		AND  D.id_docente = ".$this->id." AND D.id_grado =".$g;
        }

        // realizo la consulta
        $c = $this->_db->query($q);
        while($a = $c->fetch_array(MYSQLI_ASSOC)){
            $id_m = $a['id_materia'];
            $m = $a['materia'];
            $arr[$id_m] = $m; 

        }
        $this->materias = $arr;

    }

    // retorna un conjunto de materias que pertenecen a un grado en un area
    // parametros $g ->  grado
    //            $a ->  area
    public function get_materias_por_grado_area($g,$a){
        $arr = array();
        $q = "";
        // if($this->admin == 1){
        //     // consulta para obtener las materias
        //     $q ="SELECT M.id_materia, M.materia
        //           OM requisitos R INNER JOIN materia M ON M.id_materia = R.id_materia
		// WHERE R.id_grado = ".$g;
        // } else
        // {
        $q = "select id_materia, materia from materia where id_materia in (
              select id_materia from requisitos where id_grado =$g ) and  
              id_area  = $a order by id_materia";
            //}
        // realizo la consulta
        $c = $this->_db->query($q);
        while($a = $c->fetch_array(MYSQLI_ASSOC)){
            $id_m = $a['id_materia'];
            $m = $a['materia'];
            $arr[$id_m] = $m; 
        }
        return $arr;
    }
    // obtengo un array con todas las materas
    public function get_all(){
        $arr = array();
        $q =" select id_materia from materia order by materia";
        $c = $this->_db->query($q);
        while($a = $c->fetch_array(MYSQLI_NUM)){
            array_push($arr, $a[0]);
        }
        return $arr;
        
    }
}

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

    public function get_semana_activa($ano) {
        $q = "select semana from semanas where year = $ano and inicio < NOW() and fin > NOW() order by semana asc;";
        $c = $this->_db->query($q);
        $r = $c->fetch_array(MYSQLI_ASSOC);
        return $r["semana"];

    }

    public function get_periodo_activo($ano) {
        $q = "select id_periodo from semanas where year = $ano and inicio < NOW() and fin > NOW() order by semana asc;";
        $c = $this->_db->query($q);
        $r = $c->fetch_array(MYSQLI_ASSOC);
        return $r["id_periodo"];

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

// clase que representa los logros
class logro extends imcrea{
    public $id_logro;
    public $logro;
    public $id_materia;
    
    //cosntructor de la clase
    // crea una calificacion vacia
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    // obtengo los atributos de un logro dado 
    // el numero de la semana y el año y la semana
    public function get_logros($id_materia) {

        $q = "select * from  logros where id_materia = $id_materia";
        $c = $this->_db->query($q);

        // defino  el array 
        $arr = array();
        
        // recorre el array 
        while($r = $c->fetch_array(MYSQLI_ASSOC)) {
            // agrego un elemento al array
            $arr[$r['id_logro']] = $r['logro'] ;
            
        }

        
        // retorno un array con los id de los logros de la materia
        return $arr;
    }


    public function get_logro() { 
        $q = "select * from  logros where id_logro= $id_logro";
        $c = $this->_db->query($q);
       
        // recorre el array 
        $r = $c->fetch_array(MYSQLI_ASSOC);
            // agrego un elemento al array
        $this->logro = $r['logro'] ;
        $this->id_logro = $r['id_logro'] ;            
    }


    public function get_logro_id($id_logro) {

        $q = "select * from  logros where id_logro= $id_logro";
        $c = $this->_db->query($q);
       
        // recorre el array 
        $r = $c->fetch_array(MYSQLI_ASSOC);
            // agrego un elemento al array
        $this->logro = $r['logro'] ;
        $this->id_logro = $r['id_logro'] ;            
    }

}


//clase que indentifica las jornadas
//hace referencia a los horarios en que
//se dictan la clases
class jornada extends imcrea{
    // codigo de la jornada
    public $id_materia;
    // nombre de la jornada
    public $jornada;

    // cosntructor de la clase
    // crea una calificacion vacia
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }
    

    public function get_jornada_por_id($id_jornada){
        $q = "select * from  jornada where id_jornada =$id_jornada ";
        // ejecuto la consulta
        $c = $this->_db->query($q);
        $a = $c->fetch_array(MYSQLI_ASSOC);

        $this->id_jornada = $a['id_jornada'];
        $this->jornada = $a['jornada'];
        
    }
        
    
}

// clase que define los cursos los cuales son grupos de estudiantes que
// se encuentran en el mismo grado y jornada
class curso extends imcrea{
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

// clase que define las materias requeridas
// para un grado o un programa tecnico
class requisitos extends imcrea{
    // codigo del requisito
    public $id;
    // nombre  del grado/programa tecnico
    public $id_grado;
    // codigo de la materia
    public $id_materia;

    //cosntructor de la clase
    // crea una calificacion vacia
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    public function get_requisitos_grado($id_grado){
        // array que contiene los reguisitos
        $arr = array();
        // consulta
        $q = "select id from  requisitos  where id_grado =$id_grado ";
        //echo $q;
        // ejecuto la consulta
        $c = $this->_db->query($q);
        while($a = $c->fetch_array(MYSQLI_NUM)){
            array_push($arr, $a[0]);
            // agrego array
            // $id = $a['id'];
            // $id_grado = $a['id_grado'];
            // $id_materia = $a['id_materia'];
            // $arr[$id][0] = $id_grado;
            // $arr[$id][1] = $id_materia;
        }
        //echo var_dump($arr);
        return $arr;
    }

    public function get_requisitos_id($id){
        $q = "select * from requisitos where id = $id";
        //echo $q;
        // ejecuto la consulta
        $c = $this->_db->query($q);
        $a = $c->fetch_array(MYSQLI_ASSOC);
        $this->id = $a['id'];
        $this->id_grado = $a['id_grado'];
        $this->id_materia = $a['id_materia'];
        
    }

    public function add($id_materia,$id_grado){
        $q= "insert into requisitos (id_materia,id_grado) values($id_materia, $id_grado)";
        //echo $q;
        $c = $this->_db->query($q);
        if($c === true){
            return true;
        }else
        {return false;}
        
    }


     public function del($id_materia,$id_grado){
         $q= "delete from  requisitos where id_materia = $id_materia and id_grado = $id_grado";
         //echo $q;
        $c = $this->_db->query($q);
        if($c === true){
            return true;
        }else
            return false;
        
    }
}

?>