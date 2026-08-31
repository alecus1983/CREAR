<?php

class padres extends imcrea {


    // Constructor: establece la conexión a la base de datos
    public function __construct() {
        //   constructor de la clase padre
        parent::__construct();
    }

    /**
     * Verifica si ya existe un registro en la tabla padres para el id_hijo dado.
     *
     * @param int $id_hijo  El id_persona del alumno (hijo).
     * @return bool  True si ya existe el vínculo, false si no.
     */
    public function existe_hijo(int $id_hijo): bool {
        try {
            $sql  = "SELECT COUNT(*) FROM padres WHERE id_hijo = ?";
            $stmt = $this->_db->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error al preparar existe_hijo: " . $this->_db->error);
            }
            $stmt->bind_param("i", $id_hijo);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            return $count > 0;
        } catch (Exception $e) {
            error_log("Error en existe_hijo: " . $e->getMessage());
            return false;
        }
    }

    // Método para insertar un nuevo registro
    public function add($id_personas, $id_hijo, $fecha) {
        try {
            $sql  = "INSERT INTO padres (id_personas, id_hijo, fecha) VALUES (?, ?, ?)";
            $stmt = $this->_db->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error al preparar add padres: " . $this->_db->error);
            }
            $stmt->bind_param("iis", $id_personas, $id_hijo, $fecha);
            $stmt->execute();
            $lastId = $this->_db->insert_id;
            $stmt->close();
            return $lastId;
        } catch (Exception $e) {
            error_log("Error al insertar en padres: " . $e->getMessage());
            return false;
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