<?php

// Contiente los modelo de clase  que apunta a la base de datos
// involucra  el archivo imcrea.php

// require_once('imcrea.php');

// Configuración de constantes
define('DB_HOST', 'localhost');
define('DB_USER', 'imcrea_admin');
define('DB_PASS','conezioncrear21');
define('DB_NAME','imcrea_data');
define('DB_CHARSET','utf8');

// requiere_once('config.php');

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
  // nombres de los estudiantes
  public $nombre_estudiante;
  // apellidos del iscrito
  public $apellido_estudiante;
  // apellidos del iscrito
  public $nacimiento;
  // ciudad de nacimiento del estudiante
  public $ciudad_nacimiento;
  // codigo de escolaridad
  public $escolaridad;
  // grado
  public $id_grado;
  // nombre del grado
  public $id_jornada;
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

  //constructor de la clase
  public function __construct(){
    // se construye a partir de la clase imcrea
    parent::__construct();
  }

  // Registros
  public function registro() {

    $now = date("Y-m-d g:i");
    // scrip sql
    // String  para realizar la consulta
    $q2 = "INSERT INTO inscritos
    (
      nombre_estudiante,
      apellido_estudiante,
      nacimiento,
      ciudad_nacimiento,
      id_escolaridad,
      id_grado,
      id_jornada,
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
      fecha
    )

    VALUES ('".$this->nombre_estudiante.
      "',  '".$this->apellido_estudiante.
      "', '".$this->nacimiento.
      "', '".$this->ciudad_nacimiento.
      "', '".$this->escolaridad.
      "', '".$this->id_grado.
      "', '".$this->id_jornada.
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
      "' )";




      //
      // se realiza la consulta
      $qx = $this->_db->query($q2);
      echo "<br><br>Consulata : <br>".$q2;

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

    //

  } // fin de la clase



?>
