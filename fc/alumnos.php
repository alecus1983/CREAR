<?php 


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
    public $celular;

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
            $this->correo = $dato["correo"];
            
        }
    }

    // crear alumnos
    public function set_alumno(){
        $q ="INSERT INTO alumnos (nombres,
                                                             apellidos,
                                                             cedula,
                                                             fecha, correo,
                                                             telefono, login,
                                                             inscripcion)
          values ('".$this->nombres."' ,'"
            .$this->apellidos."' ,'"
            .$this->cedula."' ,'"
            .$this->fecha."' ,'"
            .$this->correo."' ,'"
            .$this->telefono."' ,"
            ."'creativo'"." ,"
            .$this->inscripcion.")";

        // ejecuto la consulta
        $dato = $this->_db->query($q);

        // si se ejecuto la consulta
        if (!$dato){
            //echo "Fallo en incertar fila";
        } else {
         
            $this -> _db -> close();
        }
    }

    // método para actualizar alumnos
    public function update_alumno() {
        
        // actualizacion de los datos del alumno
        $texto = "UPDATE alumnos SET  nombres ='$this->nombres',
                                  apellidos='$this->apellidos' ,
                                  cedula = '$this->cedula' ,
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

    // obtengo los atributos de un estudiante en funcion
    // de su id
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
            $this -> _db -> close();
        }
    }
  
}
?>