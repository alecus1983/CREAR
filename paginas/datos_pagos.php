<?php

session_start();

// if(!isset($_SESSION['usuario']))
// {
//   session_destroy();
//   //Sila secciÃ³n no esta iniciada entonces retorna a la pagina principal
//   header('Location:login_boletines.php');

//   //termina el programa php
//   exit();
// }

// Contiente los modelo de clase  que apunta a la base de datos
// involucra  el archivo imcrea.php
// require_once('imcrea.php');

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
        echo "Fallo en incertar fila";
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



  // Clase que define la inscripcion
  class grados extends imcrea {

    // variable de la tabla grados
    protected $id_grado;
    protected $grado;
    protected $nombre_g;
    protected $escolaridad;
    protected $promovido;
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
          echo "Fallo en incertar fila";
        } else {
          // retorno  el array
          return $dato;
          $dato -> close();
          $this -> _db -> close();
        }
      } // fin de la cuncion

      // Obtener nombre

      public function get_nombre($id_grado){
        // se realiza la consulta
        // echo "consulsta: "."SELECT nombre_g FROM  grados where  id_grado = ".$id_grado;
        $resultado = $this->_db->query("SELECT nombre_g FROM  grados where  id_grado = ".$id_grado );
        $dato = $resultado->fetch_array(MYSQLI_NUM);

        // si se ejecuto la consulta
        if (!$dato){
          echo "Fallo en incertar fila";
        } else {
          // retorno  el array
          return $dato[0];
          $dato -> close();
          $this -> _db -> close();
        }
      } // fin de la cuncion

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
  public function set_matricula(){


    // // esta funcion actualiza el codigo de inscripcion de un estudiante
    // // dentro de la tabla alumnos
    $texto = "INSERT INTO matricula (id_alumno,id_grado,id_jornada,mes,retiro,year)
              VALUES ($this->id_alumno,$this->id_grado,$this->id_jornada,$this->mes,$this->retiro,$this->year)";
              echo $texto;
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
    $resultado = $this->_db->query("SELECT * FROM  alumnos where  id_alumno = ".$codigo );
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

    echo "<br>".$q;

    // ejecuto la consulta
    $dato = $this->_db->query($q);

    // si se ejecuto la consulta
    if (!$dato){
      echo "Fallo en incertar fila";
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
       echo "Fallo al actualizar alumno";
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
      echo "Fallo en incertar fila";
    } else {
      // retorno  el valor 0 del array
      return $dato[0];
      $dato -> close();
      $this -> _db -> close();
    }
  } // fin de la funcion

  // Funcion que permite tener un apellido de un alumno a partir del id
  public function get_id_apellido($id_alumno){
    // se realiza la consulta
    $resultado = $this->_db->query("SELECT apellidos FROM  alumnos where  id_alumno = ".$id_alumno );
    $dato = $resultado->fetch_array(MYSQLI_NUM);

    // si se ejecuto la consulta
    if (!$dato){
      echo "Fallo en incertar fila";
    } else {
      // retorno  el valor 0 del array
      return $dato[0];
      $dato -> close();
      $this -> _db -> close();
    }
  } // fin de la funcion

  // obtengo el ultimo alumno ingresado
  function maximo(){
    // se realiza la consulta
    $qx = $this->_db->query("SELECT max(id_alumno) as cantidad FROM  alumnos");
    $dato = $qx->fetch_array(MYSQLI_NUM);

    // si se ejecuto la consulta
    if (!$dato){
      echo "Fallo en incertar fila";
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
        echo "<br>se inserto un nuevo pago";
      }
    }
    else {
      echo "<br>ya existia una matricula para ese periodo";
    }
    
  } // fin de constructor de la clase

  
}

class matriculas_year extends imcrea {
  // los atributos de la clase
  public $year;
  public $matriculas;
  

  // constructor de la clase  
  public function __construct($a){
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

?>