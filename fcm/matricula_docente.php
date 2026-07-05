<?php

// cada objeto de esta clase representa una clase impartida en el
// instituto por un docente y se desarrolla en la siguiente jerarquia de objetos
//
// Escolaridad -> jornada -> grado -> curso -> MATRICULA DOCENTE

class matricula_docente extends curso
{
    protected $id;

    public $id_alumno;
    public $id_materia;
    public $id_docente;
    public $year;
    protected $mes;
    protected $fecha;

    // constructor de la clase
    public function __construct()
    {
        //   constructor de la clase padre
        parent::__construct();
    }

    // funcion para obtener un docente
    public function get_docente($id_materia, $id_grado, $id_jornada, $id_curso, $year)
    {
        $q = "select * from matricula_docente where year = $year and id_grado =$id_grado and id_curso =$id_curso and id_jornada = $id_jornada and id_materia = $id_materia;";
        $resultado = $this->_db->query($q);
        $r = $resultado->fetch_array(MYSQLI_ASSOC);

        // si el docente existe retorna lo siguiente
        if (isset($r["id_docente"])) {
            return $r["id_docente"];
        } else {
            return null;
        }
    }

    // funcion que obtiene el listado de grados de acuerdo a un formato
    // de boletines
    public function get_matricula($formato)
    {
        // consulta que interroga si es un administrador
        // el que consulta la clase
        $r = $this->_db->query("select admin from u_docentes where id_docente = " . $this->id_docente);
        // consulta que devuelve un array numérico
        $admin = $r->fetch_array(MYSQLI_NUM);
        // array para almacenar el listado de grados
        $data = array();
        // si es  un administrativo        
        // obtengo todos los grados
        if ($admin[0] == 1) {
            $q = "SELECT * FROM grados  where formato_boletin = $formato ORDER BY grado";
            // obtengo el query resultado
            $resultado = $this->_db->query($q);
            // convierto la consulta en un array
            while ($g = $resultado->fetch_array(MYSQLI_ASSOC)) {
                $data[$g["id_grado"]] = $g["grado"];
            }
        }
        // // si no es un administrativo
        else {
            $q1 = "SELECT DISTINCT G.id_grado, G.grado FROM grados G INNER JOIN matricula_docente D ON G.id_grado = D.id_grado  WHERE D.year = '" . $this->year . "' AND  D.id_docente = " . $this->id_docente;
            $resultado = $this->_db->query($q1);
            while ($g = $resultado->fetch_array(MYSQLI_ASSOC)) {
                $data[$g["id_grado"]] = $g["grado"];
            }
        }
        return $data;
    }

    //obtiene un listado de docentes matriculados en un año

    public function listado_docentes($year)
    {
        $arr = array();
        $q = "select id_docente,identificacion, login, nombres, apellidos from u_docentes ud inner join personas p on ud.id_personas  = p.id_personas
where id_docente in (   select distinct id_docente from matricula_docente where year = $year) ";

        $c = $this->_db->query($q);
        while ($a = $c->fetch_array(MYSQLI_ASSOC)) {
            // agrego el codigo de un docente matriculado en el año
            array_push($arr, $a['id_docente']);
        }
        // cargo el listado de docentes
        return $arr;

    }

    // listado de matriculas (id) docentes por grado
    public function get_lista_por_grado($id_grado, $id_jornada, $id_curso, $year)
    {
        $arr = array();
        $q = "select id from matricula_docente where id_grado = $id_grado and " .
            " id_jornada = $id_jornada and id_curso = $id_curso and year = $year order by id_docente";

        //echo $q;

        $c = $this->_db->query($q);
        while ($a = $c->fetch_array(MYSQLI_ASSOC)) {
            // agregar elementos al array
            array_push($arr, $a['id']);

        }
        // listado de matriculas
        return $arr;

    }

    // funcion constructor de objeto requiere
    //el año, el  grado y el curso
    public function listado_estudiantes($y, $g, $j, $c)
    {
        // invoco al constructor de la clase padre (imcrea)
        //parent::__construct();
        // genero una consulta a la base de datos
        $query = "select * from matricula where year = $y and id_grado= $g and id_jornada= $j and id_curso =$c and id_alumno > 0";
        //echo $query;
        $q2 = $this->_db->query($query);
        // guardo el resoltado en un array inicialmente vacio
        $a_grado = array();
        $a_alumno = array();
        $a_curso = array();

        while ($resultado = $q2->fetch_array(MYSQLI_ASSOC)) {
            // agrego elementos al array $aa
            array_push($a_grado, $resultado['id_grado']);
            array_push($a_alumno, $resultado['id_alumno']);
        }

        // asignacion de parametros
        // $this->year = $y;
        // $this->id_grado = $a_grado;
        // $this->id_alumno = $a_alumno;
        // $this->id_curso = $c;
        return $a_alumno;
    }

    // funcion que lista  de los gradsos de acuerdo
    // a una escolaridad dada $id_escolaridad ,
    // para un docente $id_docente y un año $year
    public function lista_escolaridad($id_escolaridad, $id_docente = null, $year = null)
    {


        try {

            // // determinar si el docente es administrativo
            // $q = "SELECT admin from u_docentes u where id_docente = ? limit 1";
            // // preparao la consulta en la variable $stmt
            // $stmt = $this->_db->prepare($q);

            // if ($stmt === false) {
            //         throw new Exception("Error al preparar la consulta : " . $this->_db->error);
            //     }


            // // agrego los parametros a la consulta
            // $stmt->bind_param("i", $id_docente);
            // // ejecuto la consulta
            // $stmt->execute();
            // $result = $stmt->get_result();
            // //obtengo el primer registro
            //     $a = $result->fetch_array();

            // echo $id_docente." -----";

            $doc = new docentes();
            $aa = $doc->get_docente_id($id_docente);
            //echo var_dump($aa);

            // si es un administrativo aplico estas politicas
            if ($doc->is_admin($aa['id_personas'])) {

                // texto de la consulta
                // selecciono todos los grados de una escolaridad
                $c = $this->_db->query("select * from grados where id_escolaridad = $id_escolaridad order by grado");

                // array que almacena el dato de salida
                $aa = [];

                // si el resulatado de la consulta dio mas
                // de cero registros

                if ($c->num_rows > 0) {

                    // esplora iterativamente los registros
                    // consultados

                    while ($a = $c->fetch_array(MYSQLI_ASSOC)) {

                        array_push($aa, array($a["id_grado"], $a["grado"]));

                    }

                }
                // retorno un array con la cantidad
                // de filas 
                return $aa;

            }
            // si es otro docente aplico estas
            else {
                // variable de consultas
                $q = "select gd.id_grado, gr.grado from grados as gr inner join ( select distinct m.id_grado  from matricula_docente m where m.`year` = ? and m.id_docente =?) as gd
on gr.id_grado = gd.id_grado
where gr.id_escolaridad = ?";

                // preparo la consulta
                $stmt = $this->_db->prepare($q);

                // valido la consulta
                if ($stmt === false) {
                    throw new Exception("Error al preparar la consulta escolaridades: " . $this->_db->error);
                }

                // agrego parametros
                $stmt->bind_param("sii", $year, $id_docente, $id_escolaridad);

                // ejecuto la consulta
                $stmt->execute();
                $result = $stmt->get_result();

                // retorno los datos
                return $result->fetch_all();

            }

        } catch (Exception $e) {
            error_log("Error en listado de escolaridades: " . $e->getMessage());
        }


    }


    public function get_matricula_por_id($id)
    {
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

    public function add($id_grado, $id_curso, $id_materia, $id_docente, $ano, $id_jornada)
    {
        $q = "insert into matricula_docente (id_grado, id_curso,id_materia,id_docente,year,id_jornada,mes,fecha)" .
            " values($id_grado,$id_curso,$id_materia,$id_docente,$ano,$id_jornada,4,NOW())";
        //echo $q;
        $c = $this->_db->query($q);
        if ($c === true) {
            return true;
        } else {
            return false;
        }

    }

    public function del($id)
    {
        $q = "delete from  matricula_docente where id = $id";
        //echo $q;
        $c = $this->_db->query($q);
        if ($c === true) {
            return true;
        } else
            return false;
    }
}
?>