<?php

// clase personas que extiende de
// imcrea representa a las personas
// que intervienen en la organizacion

class personas extends imcrea {

    // atributos

    // codigo de la persona 
    public $id_persona;
    // nombres de las personas 
    public $nombres;
    // apellidos de las personas
    public $apellidos;
    // numro de identificacion 
    public $identificacion;
    // tipo de identificacion
    public $tipo_identificacion;
    // fecha de nacimiento
    public $nacimiento;
    // correo de la persona 
    public $correo;
    // correo institucional de la persona 
    public $i_correo;
    // celular de la persona, varchar(10) 
    public $celular;
    // telefono de la persona, varchar(10)
    public $telefono;
    // clave foranea de la pesona cuando es alumno , int(11)                       
    private $u_alumnos;
    // clave foranea de la persna cuando es docente, int(11) 
    private $u_docentes;
    // direccion de residencia varchar(100)
    private $direccion_residencia;
    // barrio varchar(50)
    private $barrio;
    // estrato int(1)
    public $estrato;
    // sisben bit (1)
    public $sisben;
    // familia en accion bit(1)
    public $familias_accion;
    // regimen en salud 1 contributivo, 2 subsidiado int(1)
    public $regimen_salud;
    // eps varchar(100)
    public $eps;
    // persona con la que vive varchar (30)
    public $vive_con ;
    // victima de conflicto , bit(1)
    public $victima_conflicto;
    // tipo de victima de conflicto , varchar (100)
    public $tipo_victima_conflicto;
    // municipio expulsor, varchar (100)
    public $municipio_expulsor;
    // discapacitado , bit(1)
    public $discapacitado;
    // tipo discapacidad , varchar(50)
    public $tipo_discapacidad;
    // capacidad excepcional, varchar(100)
    public $capacidad_excepcional;
    // etnia, bit(1)
    public $etnia;
    // tipo de etnia,  varchar (50)
    public $tipo_etnia;
    // resguardo o consejo, varchar(100) 
    public $resguardo_consejo;
    // ips, varchar(100)
    public $ips;
    // tipos de sangre, varchar(2)
    public $tipo_sangre;
    // rh,  varchar(3)
    public $rh;
    // capacidad excepcional , varchar(100)
    public $capacidad_exepcional;

    // datos de antecedentes patologicos, varchar(100)
    public $antecedentes_patologicos_medicos;
    public $antecedentes_patologicos_quirurgicos;
    public $antecedentes_patologicos_toxicos;
    public $antecedentes_patologicos_psiquiatricos;
    public $antecedentes_patologicos_psicologicos;
    public $antecedentes_patologicos_morbilidad;

    
    //cosntructor de la clase
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    
    // funcion que permite buscar personas en funcion del
    // nombre apellido y/o la cedula
    public function buscar_persona($nombres, $apellidos, $cedula) {

        $q = "select nombres,  apellidos , identificacion, id_personas  from personas where".
                 " ( nombres like '%$nombres%' and ".
                " apellidos like '%$apellidos%' ) and  ".
                " identificacion like '%$cedula%' ";

        // ejecuto la consulta
        $c = $this->_db->query($q);
        // se ejecuta la consulta
        //$a = $c->fetch_array(MYSQLI_ASSOC);

        // guardo el resoltado en un array inicialmente vacio
        $aa = array();
        // exploro el resultado 
        while($resultado = $c->fetch_array(MYSQLI_NUM)){
            // agrego elementos al array $aa
            array_push($aa,array($resultado[0], $resultado[1],  $resultado[2] ,$resultado[3]));
        }

        // var_dump($aa);
        // doy valores a los atributos del objeto
        return   $aa;
        
    }

    // obtengo los datos de la persona
    // en base a su numero de identificacion
    public function get_persona_por_id($id){
        // texto de consulta
        $q = "select * from  personas where id_personas =$id ";
        // ejecuto la consulta
        $c = $this->_db->query($q);
        // recupero un registro
        $a = $c->fetch_array(MYSQLI_ASSOC);

        $this->id_persona = $a['id_personas'];
        $this->nombres = $a['nombres'];
        $this->apellidos = $a['apellidos'];
        $this->identificacion = $a['identificacion'];
        $this->tipo_identificacion = $a['tipo_identificacion'];
        $this->nacimiento = $a['nacimiento'];
        $this->correo = $a['correo'];
        $this->i_correo = $a['i_correo'];
        $this->celular = $a['celular'];
        $this->telefono = $a['telefono'];
        $this->u_alumnos = $a['u_alumnos'];
        $this->u_docentes = $a['u_docentes'];
        $this->direccion_residencia = $a['direccion_residencia'];
        $this->id_persona = $a['id_persona'];
        $this->nombres = $a['nombres'];
        $this->apellidos = $a['apellidos'];
        $this->identificacion = $a['identificacion'];
        $this->tipo_identificacion = $a['tipo_identificacion'];
        $this->nacimiento = $a['nacimiento'];
        $this->correo = $a['correo'];
        $this->i_correo = $a['i_correo'];
        $this->celular = $a['celular'];
        $this->telefono = $a['telefono'];
        $this->u_alumnos = $a['u_alumnos'];
        $this->u_docentes = $a['u_docentes'];
        $this->direccion_residencia = $a['direccion_residencia'];
        $this->barrio = $a['barrio'];
        $this->estrato = $a['estrato'];
        $this->sisben = $a['sisben'];
        $this->familias_accion = $a['familias_accion'];
        $this->regimen_salud = $a['regimen_salud'];
        $this->eps = $a['eps'];
        $this->vive_con = $a['vive_con'];
        $this->victima_conflicto = $a['victima_conflicto'];
        $this->tipo_victima_conflicto = $a['tipo_victima_conflicto'];
        $this->municipio_expulsor = $a['municipio_expulsor'];
        $this->discapacitado = $a['discapacitado'];
        $this->tipo_discapacidad = $a['tipo_discapacidad'];
        $this->capacidad_excepcional = $a['capacidad_excepcional'];
        $this->etnia = $a['etnia'];
        $this->tipo_etnia = $a['tipo_etnia'];
        $this->resguardo_consejo = $a['resguardo_consejo'];
        $this->ips = $a['ips'];
        $this->tipo_sangre = $a['tipo_sangre'];
        $this->rh = $a['rh'];
        $this->capacidad_exepcional = $a['capacidad_exepcional'];
        $this->antecedentes_patologicos_medicos = $a['antecedentes_patologicos_medicos'];
        $this->antecedentes_patologicos_quirurgicos = $a['antecedentes_patologicos_quirurgicos'];
        $this->antecedentes_patologicos_toxicos = $a['antecedentes_patologicos_toxicos'];
        $this->antecedentes_patologicos_psiquiatricos = $a['antecedentes_patologicos_psiquiatricos'];
        $this->antecedentes_patologicos_psicologicos = $a['antecedentes_patologicos_psicologicos'];
        $this->antecedentes_patologicos_morbilidad = $a['antecedentes_patologicos_morbilidad'];
        

        // retorna todos los atributos de la persona
        return $a;
    }

    // funcion que actualiza uno o varios datos de la persona
    // como dato de entrada se debe suministrar dentro de los atributos
    // del objeto los parametros que se desean actualizar
    
    public function actualizar_nombres_persona(){
        $texto = "UPDATE personas SET  nombres ='$this->nombres',
                          apellidos='$this->apellidos' where id_personas = $this->id_persona";
        // ejecuto la consulta
        $dato = $this->_db->query($texto);

        // si se ejecuto la consulta
        if (!$dato){
            //echo "Fallo al actualizar alumno";
        } else {
            // retorno  el valor 0 del array
            //$this -> _db -> close();
        }
        
    }

    // actualizar apellidos de  la  persona
    public function actualizar_nacimiento_persona(){
        $texto = "UPDATE personas SET
                          nacimiento ='$this->nacimiento'
                          where id_personas = $this->id_persona";

        //echo $texto;
        // ejecuto la consulta
        $dato = $this->_db->query($texto);

        // si se ejecuto la consulta
        if (!$dato){
            echo "Fallo al actualizar fecha de nacimiento";
        } else {
            // retorno  el valor 0 del array
            //$this ->_db ->close();
            //echo "se cambio la fecha con exito";
        }   
    }

      // actualizar identificacion de  la  persona
    public function actualizar_identificacion_persona(){
        $texto = "UPDATE personas SET
                          identificacion ='$this->identificacion' ,
                          tipo_identificacion =   '$this->tipo_identificacion'
                           where id_personas = $this->id_persona";
        
        // ejecuto la consulta
        $dato = $this->_db->query($texto);

        // si se ejecuto la consulta
        if (!$dato){
            //echo "Fallo al actualizar alumno";
        } else {
            // retorno  el valor 0 del array
            //$dato -> close();
            //$this ->_db ->close();
        }   
    }

    // actualizar identificacion de  la  persona
    public function actualizar_correo_persona(){
        $texto = "UPDATE personas SET correo ='$this->correo'";
        //echo $texto;
        // ejecuto la consulta
        $this->_db->query($texto);
    }

    // actualizar identificacion de  la  persona
    public function actualizar_i_correo_persona(){
        $texto = "UPDATE personas SET
                          i_correo =   '$this->i_correo'
                           where id_personas = $this->id_persona";
        //echo $texto;
        // ejecuto la consulta
        $this->_db->query($texto);
    }

    // actualizar telefono persona
    public function actualizar_telefono_persona(){
        $texto = "UPDATE personas SET telefono ='$this->telefono'
                          where id_personas = $this->id_persona";
        // ejecuto la consulta
        $this->_db->query($texto);
    }

     // actualizar telefono persona
    public function actualizar_celular_persona(){
        $texto = "UPDATE personas SET celular ='$this->celular'
                         where id_personas = $this->id_persona";
        // ejecuto la consulta
        $this->_db->query($texto);
    }


    // actualiza la direccion de residencia
    public function actualizar_direccion_residencia(){

        
        $texto = "UPDATE personas SET direccion_residencia ='".
            $this->direccion_residencia."', estrato = '".
            $this->estrato."', barrio = '".
            $this->barrio."' where id_personas = ".
            $this->id_persona;
        
        // ejecuto la consulta
        $c = $this->_db->query($texto);
        // retorno   es estado de la consulta
        return $c;

    }

    // actualiza las afiliaciones de la persona
    public function actualizar_afiliacion( ){

        try {
        $texto = "UPDATE personas SET 
        sisben = '$this->sisben',
        vive_con = '$this->vive_con',
        etnia = $this->etnia,
        tipo_etnia = '$this->tipo_etnia',
        resguardo_consejo = '$this->resguardo_consejo',
        familias_accion = $this->familias_accion,
        tipo_victima_conflicto = $this->tipo_victima_conflicto,
        municipio_expulsor = '$this->municipio_expulsor',
        discapacitado = $this->discapacitado,
        tipo_discapacidad = '$this->tipo_discapacidad',
        capacidad_excepcional = '$this->capacidad_excepcional',
        regimen_salud = $this->regimen_salud,
        eps ='$this->eps',
        ips = '$this->ips',
        tipo_sangre = '$this->tipo_sangre',
        rh = '$this->rh'
         where id_personas = $this->id_persona";
        
        // ejecuto la consulta
        $c = $this->_db->query($texto);
        // retorno   es estado de la consulta

        return $c;
}   catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
  }
    }


// actualiza las afiliaciones de la persona
public function actualizar_antecedentes( ){

    try {
    $texto = "UPDATE personas SET 
    antecedents_patologicos_medicos = '$this->antecedentes_patologicos_medicos',
    antecedentes_patologicos_quirurgicos = '$this->antecedentes_patologicos_quirurgicos',
    antecedentes_patologicos_psiquiatricos = '$this->antecedentes_patologicos_psiquiatricos',
    antecedentes_patologicos_psicologicos = '$this->antecedentes_patologicos_psicologicos',
    antecedentes_patologicos_toxicos = '$this->antecedentes_patologicos_toxicos',
    antecendentes_patologicos_morbilidad = '$this->antecedentes_patologicos_morbilidad'
     where id_personas = $this->id_persona";
    
    // ejecuto la consulta
    $c = $this->_db->query($texto);
    // retorno   es estado de la consulta

    return $c;
}   catch(Exception $e) {
echo 'Message: ' .$e->getMessage();
}
}

    // agregar persona
    // se agrega una nueva instancia del objeto
    // en la tabla persona
    // no requiere atributos 
    public function add(){

        try{ 
        // consulta
        $texto  = "INSERT INTO personas
                            (nombres, apellidos,
                             identificacion ,tipo_identificacion,
                             nacimiento, correo, i_correo,
                             celular, telefono)

                            VALUES
                            ('$this->nombres','$this->apellidos',
                             $this->identificacion,$this->tipo_identificacion,
                             '$this->nacimiento','$this->correo', '$this->i_correo',
                             '$this->celular', '$this->telefono')";

        
        // ejecuto la consulta
        $c = $this->_db->query($texto);

        if($c === true){
            // recupero el id de la persona insertada
            $this->id_persona = $this->_db->insert_id;
            // retorno la confirmacion
            return true;
        }else
        {return false;}
    }
    catch(Exception $e) {
        echo 'Message: ' .$e->getMessage();
      }
        
    }


    // funcion que elimina la persona dado un id de la persona
    public function del($id_personas){
        $q= "delete from  personas where id_personas = $id_personas";

        $c = $this->_db->query($q);
        if($c === true){
            return true;
        }else
            return false;   
    }

    // funcion para obtener la persona
    public function get_direccion($id_persona){


        $q = "SELECT direccion_residencia, estrato, barrio from personas where id_personas = $id_persona";

        // ejecuto la consulta
        $c = $this->_db->query($q);
        // recupero un registro
        $a = $c->fetch_array(MYSQLI_ASSOC);
        //  retorno el valor obtenido
        return $a;

    }

    // obtengo los datos de las afiliaciones de un estudiante
    public function get_afiliacion($id_persona) {
        // Verificar que el ID sea un valor entero para evitar inyecciones de tipo SQL
        if (!is_numeric($id_persona)) {
            throw new Exception("El ID de la persona no es válido.");
        }
    
        // Consulta SQL con parámetros
        $q = "SELECT sisben, familias_accion, regimen_salud, eps, vive_con, tipo_victima_conflicto, municipio_expulsor, discapacitado, tipo_discapacidad, capacidad_excepcional, etnia, tipo_etnia, resguardo_consejo, ips, tipo_sangre, rh FROM personas WHERE id_personas = ?";
    
        // Preparar la consulta
        if ($stmt = $this->_db->prepare($q)) {
            // Enlazar el parámetro
            $stmt->bind_param("i", $id_persona); // 'i' significa que el parámetro es un entero
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Obtener el resultado
            $result = $stmt->get_result();
    
            // Verificar si se encontró la persona
            if ($result->num_rows > 0) {
                // Recuperar los datos
                $a = $result->fetch_array(MYSQLI_ASSOC);
            } else {
                // Si no se encuentra la persona
                $a = null;
            }
    
            // Cerrar la declaración
            $stmt->close();
        } else {
            // Si la preparación de la consulta falla
            throw new Exception("Error al preparar la consulta.");
        }
    
        // Retornar el resultado
        return $a;
    }


    // obtengo los datos de los antecedentes de un estudiante

    public function get_antecedentes($id_persona) {
        // Verificar que el ID sea un valor entero para evitar inyecciones de tipo SQL
        if (!is_numeric($id_persona)) {
            throw new Exception("El ID de la persona no es válido.");
        }
    
        // Consulta SQL con parámetros
        $q = "SELECT antecedents_patologicos_medicos,
                antecedentes_patologicos_quirurgicos,
                antecedentes_patologicos_toxicos,
                antecedentes_patologicos_psiquiatricos,
                antecedentes_patologicos_psicologicos,
                antecendentes_patologicos_morbilidad FROM personas WHERE id_personas = ?";
    
        // Preparar la consulta
        if ($stmt = $this->_db->prepare($q)) {
            // Enlazar el parámetro
            $stmt->bind_param("i", $id_persona); // 'i' significa que el parámetro es un entero
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Obtener el resultado
            $result = $stmt->get_result();
    
            // Verificar si se encontró la persona
            if ($result->num_rows > 0) {
                // Recuperar los datos
                $a = $result->fetch_array(MYSQLI_ASSOC);
            } else {
                // Si no se encuentra la persona
                $a = null;
            }
    
            // Cerrar la declaración
            $stmt->close();
        } else {
            // Si la preparación de la consulta falla
            throw new Exception("Error al preparar la consulta.");
        }
    
        // Retornar el resultado
        return $a;
    }


}

?>
