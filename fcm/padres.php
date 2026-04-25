<?php

class padres extends imcrea {


    // Constructor: establece la conexión a la base de datos
    public function __construct() {
        //   constructor de la clase padre
        parent::__construct();
    }

    // Método para insertar un nuevo registro
    public function add($id_personas, $id_hijo, $fecha) {
        try {
            $sql = "INSERT INTO padres (id_personas, id_hijo, fecha) VALUES ($id_personas, $id_hijo, '$fecha')";
            $stmt = $this->_db->query($sql);
            $lastId = $this->_db->insert_id;
            return $lastId;

        } catch (Exception $e) {
            die("Error al insertar: " . $e->getMessage());
        }
    }

    // Método para actualizar un registro
    public function update($id_padres, $id_personas, $id_hijo, $fecha) {
        try {
            $sql = "UPDATE padres SET id_personas = $id_personas, id_hijo = $id_hijo, fecha = $fecha WHERE id_padres = $id_padres";
            $stmt = $this->_db->query($sql);
            $lastId = $this->_db->insert_id;
            return $lastId;
      
        } catch (Exception $e) {
            die("Error al actualizar: " . $e->getMessage());
        }
    }

    // Método para eliminar un registro
    public function del($id_padres) {
        try {
            $sql = "DELETE FROM padres WHERE id_padres = $id_padres";
            $stmt = $this->_db->query($sql);
            return $this->_db->affected_rows; // Retorna el número de filas eliminadas
        } catch (Exception $e) {
            die("Error al eliminar: " . $e->getMessage());
        }
    }

    // Método para obtener todos los registros
    public function get_all() {
        try {
            $sql = "SELECT * FROM padres";
            $stmt = $this->_db->query($sql);
            return $stmt->fetch_all(MYSQLI_ASSOC); // Retorna todos los registros como un arreglo asociativo
        } catch (Exception $e) {
            die("Error al obtener los registros: " . $e->getMessage());
        }
    }
    
}

?>