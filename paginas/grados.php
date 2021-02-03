<?php

// Contiente los modelo de clase  que apunta a la base de datos
// involucra  el archivo imcrea.php

require_once('imcrea.php');

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
      $qx = $this->_db->query("SELECT name_g FROM  grados where  id_grado = ".$id_grado );

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
    } // fin de la cuncion

  } // fin de la clase



?>
