<?php

class madres extends imcrea {

    // Constructor: establece la conexión a la base de datos
    public function __construct() {
        parent::__construct();
    }

    /**
     * Verifica si ya existe un registro en la tabla madres para el id_hijo dado.
     *
     * @param int $id_hijo  El id_persona del alumno (hijo).
     * @return bool  True si ya existe el vínculo, false si no.
     */
    public function existe_hijo(int $id_hijo): bool {
        try {
            $sql  = "SELECT COUNT(*) FROM madres WHERE id_hijo = ?";
            $stmt = $this->_db->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error al preparar existe_hijo (madres): " . $this->_db->error);
            }
            $stmt->bind_param("i", $id_hijo);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            return $count > 0;
        } catch (Exception $e) {
            error_log("Error en existe_hijo (madres): " . $e->getMessage());
            return false;
        }
    }

    // Método para insertar un nuevo registro
    public function add($id_personas, $id_hijo, $fecha) {
        try {
            $sql  = "INSERT INTO madres (id_personas, id_hijo, fecha) VALUES (?, ?, ?)";
            $stmt = $this->_db->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error al preparar add madres: " . $this->_db->error);
            }
            $stmt->bind_param("iis", $id_personas, $id_hijo, $fecha);
            $stmt->execute();
            $lastId = $this->_db->insert_id;
            $stmt->close();
            return $lastId;
        } catch (Exception $e) {
            error_log("Error al insertar en madres: " . $e->getMessage());
            return false;
        }
    }

    // Método para actualizar un registro
    public function update($id_madres, $id_personas, $id_hijo, $fecha) {
        try {
            $sql  = "UPDATE madres SET id_personas = ?, id_hijo = ?, fecha = ? WHERE id_madres = ?";
            $stmt = $this->_db->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error al preparar update madres: " . $this->_db->error);
            }
            $stmt->bind_param("iisi", $id_personas, $id_hijo, $fecha, $id_madres);
            $stmt->execute();
            $lastId = $this->_db->insert_id;
            $stmt->close();
            return $lastId;
        } catch (Exception $e) {
            error_log("Error al actualizar en madres: " . $e->getMessage());
            return false;
        }
    }

    // Método para eliminar un registro
    public function del($id_madres) {
        try {
            $sql  = "DELETE FROM madres WHERE id_madres = ?";
            $stmt = $this->_db->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error al preparar del madres: " . $this->_db->error);
            }
            $stmt->bind_param("i", $id_madres);
            $stmt->execute();
            $rows = $this->_db->affected_rows;
            $stmt->close();
            return $rows;
        } catch (Exception $e) {
            error_log("Error al eliminar en madres: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina el vínculo madre-hijo filtrando por id_hijo (id_persona del alumno).
     *
     * @param int $id_hijo  El id_persona del alumno.
     * @return int|false    Número de filas afectadas o false en caso de error.
     */
    public function del_por_hijo(int $id_hijo) {
        try {
            $sql  = "DELETE FROM madres WHERE id_hijo = ?";
            $stmt = $this->_db->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error al preparar del_por_hijo (madres): " . $this->_db->error);
            }
            $stmt->bind_param("i", $id_hijo);
            $stmt->execute();
            $rows = $this->_db->affected_rows;
            $stmt->close();
            return $rows;
        } catch (Exception $e) {
            error_log("Error en del_por_hijo (madres): " . $e->getMessage());
            return false;
        }
    }

    // Método para obtener todos los registros
    public function get_all() {
        try {
            $sql  = "SELECT * FROM madres";
            $stmt = $this->_db->query($sql);
            return $stmt->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Error en get_all madres: " . $e->getMessage());
            return [];
        }
    }
}

?>
