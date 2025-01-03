<?php
// Clase que define la inscripcion la cual es un proceso
// que recoge un proseso 
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

?>