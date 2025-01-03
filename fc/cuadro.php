<?php 
// clase cuadro que actualiza el cuadro de notas

class cuadro extends imcrea {
    // codigo del alumno
    public $id_alumno;
    // codigo de la materia
    public $id_materia;
    // codigo del area
    public $id_area;
    // valor de nota  del periodo
    public $p1;
    // valor de la nota  del periodo
    public $p2;
    // valor de la nota  del periodo
    public $p3;
    // valor nota  del periodo
    public $p4;
    // valor de la recuperacion del  periodo 1
    public $r1;
    // valor de la recuperacion del periodo 2
    public $r2;
    // valor de la recuperacion del periodo 3
    public $r3;
    // valor de la recuperacion del peridodo4
    public $r4;
    // año del cuadro de notas
    public $year;
    //periodo del cuadro de notas
    public $periodo;
        public function __construct(){
        // hereda parametros de la clase padre
        parent::__construct();
    }


    

    // metodo que cosulta  hay elementos para el cuador de notas
    //para un estudiante en el año y periodo correspondiente

    public function consultar_cuado_por_alumno_ano_periodo($id_alumno, $id_materia,  $year, $periodo,){
        
        // consulta
        $q = "SELECT id_cuadro  from cuadro   WHERE id_alumno = $id_alumno  and id_materia = $id_materia  and year = $year and periodo = $periodo ";
        //echo $q;
        // ejecuto la consulta
        $c = $this->_db->query($q);
        // se ejecuta la consulta
        $a = $c->fetch_array(MYSQLI_ASSOC);

        //  si hay notas en el cuadro de notas
        if ( is_null($a['id_cuadro'])){
            // retorno verdadero
            return false;
        }
        else
        {
            // de lo contrario retorno falso
            return $a['id_cuadro'];
        }
    }
    // insrto una instancia con la nota del periodo uno para el alumno en el año dado
    public function set_cuadro($id_alumno , $id_materia, $id_area, $id_grado, $year, $periodo,$p1,$p2,$p3,$p4,$r1,$r2,$r3,$r4,$promedio){
        // texto de consulta
        $q = "insert into cuadro (id_alumno, id_materia, id_area, id_grado, year, periodo, p1,p2,p3,p4,r1,r2,r3,r4,promedio) ".
            " values ($id_alumno, $id_materia, $id_area, $id_grado,$year,  $periodo, $p1, $p2, $p3, $p4, $r1, $r2, $r3, $r4,$promedio)";
        //muestro el texto
        //echo $q;
        $c = $this->_db->query($q);
        // si la consulta se ejecuta entonces
        if($c === true){
            return true;
        }else
        {return false;}
            
    }

    // acutaliza noas del cuadro
    public function update_cuadro ($id_cuadro, $p1,$p2,$p3,$p4,$r1,$r2,$r3,$r4,$promedio) {
        
        //texto de consulta
        $q = "update cuadro set  p1 = $p1, p2 =$p2, p3 =$p3, p4 = $p4, r1 = $r1, r2 = $r2, r3 = $r3, r4 = $r4, promedio = $promedio where id_cuadro = $id_cuadro";
        //ejecuto la consulta
         $c = $this->_db->query($q);
        // si la consulta se ejecuta entonces
        if($c === true){
            return true;
        }else
        {return false;}
    }
}


?>