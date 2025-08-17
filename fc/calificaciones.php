<?php
    
////////////////////////////////////////////////////
//                                                //
//  Clase que identifica las calificaciones       //
//                                                //
////////////////////////////////////////////////////

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
    //  codigo de identificacion del logro
    public $id_logro;
    
    
    //cosntructor de la clase
    // crea una calificacion vacia
    public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }

    // Metodo que obtiene la calificación semanal
    // 
    public function get_calificacion_semanal($id_a,$id_m,$id_s , $y, $id_p) {

        $q = "select id_alumno, id, nota, id_ponderado, id_materia, id_semana, year  from calificaciones_".$y." where year = $y and  id_alumno = $id_a and    id_materia = $id_m and       id_ponderado = $id_p and   id_semana = $id_s";
        // ejecuto la consulta
         //echo $q;
        
        try { 
            $c = $this->_db->query($q);
            $r = $c->fetch_array(MYSQLI_ASSOC); }
        catch ( Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
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
    // obtiene la nota del periodo                                                                 //
    //                                                                                                                     //
    // Función que obtiene las recuperaciones enviadas a un               //
    // determinado periodo                                                                            //
    // para ello recibe las variables:                                                             //
    // $id_a --> código del alumno                                                                // 
    // $id_m --> código de la materia                                                          //
    // $y    --> año de consulta                                                                       //
    // $periodo --> identificación del periodo                                          //
    //                                                                                                                   //
    ////////////////////////////////////////////////////////////////////////////
    
    public function get_recuperacion_periodo($id_a,$id_m,$y, $periodo) {

        // Consulta que obtiene mediante SQL la cantidad de recuperaciones
        $q = "select id_alumno, id, nota, id_materia, year, corte  from calificaciones_".$y."
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
        catch (Exception $e) {
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
            $q = "select avg( nota) nota from calificaciones_".$year."
                  where id_alumno = $id_a and id_materia = $id_m and
                  periodo = $periodo and year = $year and  id_semana > 0";
        }
        // para el resto de las asignatuas se calcula de acuerdo al ponderado
        else {
            $q = "select  sum(valor*nota)/100 as nota from
              ponderado as p inner join 
              (select id_ponderado, nota from calificaciones_".$year."
               where id_alumno = $id_a and id_materia = $id_m and
               periodo = $periodo and year = $year and id_ponderado > 0
               order by id_ponderado) as  cal on cal.id_ponderado = p.id_ponderado
               order by p.id_ponderado";}
      
        try {

            //echo $q."<br><br>";
          
            // realizo la consulta
            $c = $this->_db->query($q);
            //extraigo un dato
            $r = $c->fetch_array(MYSQLI_ASSOC); }
        catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
        // guardo la nota en el objeto
        $this->nota = $r['nota'];
        
    }

    // funcion que recupera los datos de rendimiento de un alumno
    // en una materia especifica
    public function get_rendimiento_alummno_periodo($id_a, $id_m, $ano, $id_periodo){
        // consulta para recuperar alumnos
        $q = "select p.id_ponderado, ponderado, por_periodo, cantidad from ponderado as p inner join
                (select id_ponderado, count(*)  as cantidad from calificaciones_".$ano." where id_alumno = $id_a and id_materia = $id_m and year = $ano and periodo = $id_periodo
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
        $q = "select * from calificaciones_".$y." where year = $y
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
        $q= "insert into calificaciones_".$y."
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
        $q= "insert into calificaciones_".$y."
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
        $q= "insert into calificaciones_".$y."
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

    public function update_recuperacion($id, $nota, $year){

        $q = "update calificaciones_".$year." set nota = $nota where id = $id";
        
        if( $this->_db->query($q) === True){
            $this->calificado = true;
        } else{
            $this->calificado = false; }
    }

    // Método que actualiza la calificación semanal    
    // para lo cual utiliza el id de la recuperación

    public function update_calificacion_semanal($id,$nota, $year){

        $q = "update calificaciones_".$year." set nota = $nota where id = $id";
        
        if( $this->_db->query($q) === True){
            $this->calificado = true;
        } else{
            $this->calificado = false; }
    }

    // Método para actualizar los logros
    public function update_logro($id,$logro, $year){

        $q = "update calificaciones_".$year." set id_logro = $logro where id = $id";
        
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

        $q = "select count(*) cantidad from calificaciones_".$ano." where id_docente = $id_docente and year = $ano  and id_semana = ".$semana;
        $c = $this->_db->query($q);
        $r = $c->fetch_array(MYSQLI_ASSOC);
        return $r['cantidad'];

    }

    // 
    public function get_criterio_faltantes($id_e, $id_m, $id_s, $p, $year){

        // Consulta fallida
        $q = "select v.criterio, tipo, id_semana from 
                (select concat(validar,$id_m) as criterio, tipo, id_semana from validar where id_semana < $id_s) as v left join
                (select  concat (tipo,id_semana, id_materia) as  criterio , c.id_ponderado from ponderado as p inner join ( 
                select id_alumno, id_semana, id_ponderado, id_materia from calificaciones_".$year." where year = $year and periodo = $p and id_materia = $id_m  and   id_semana < $id_s and  id_alumno in ($id_e)) as c on c.id_ponderado = p.id_ponderado) as n on n.criterio = v.criterio where n.criterio is null";
        
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
    
    // funcion que me permite obtener los criterios
    // de evaluacion
    public function get_validar_periodo($semana) {

        // consulta
        $q = "SELECT tipo FROM `validar` WHERE id_semana = $semana order by tipo";

        // realizo la consulta
        $c = $this->_db->query($q);
        //$arr = array(array());
        $arr = array();
        // recorro el array
        while($a = $c->fetch_array(MYSQLI_ASSOC)){
            
            $criterio = $a['tipo'];
            array_push($arr,$criterio) ;
        }
        // retorna un array con el conjunto de areas
        return $arr;   
    }

   
}


?>
