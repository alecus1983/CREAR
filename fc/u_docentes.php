<?php

// clase de docentes a partir de la clase de personas
class u_docentes extends personas
{

    // Constructor: establece la conexión a la base de datos
    public function __construct()
    {
        //   constructor de la clase padre
        parent::__construct();
    }

    // Método para agregar un registro
    public function add_docente($id_personas)
    {

        // actualizo la fecha actual
        $fecha = date("Y-m-d");

        $sql = "INSERT INTO u_docentes (id_personas, fecha) VALUES (?, ?)";
        $stmt = $this->_db->prepare($sql);
        if (!$stmt) {
            return "Error en la preparación de la consulta docentes: " . $this->_db->error;
        }
        $stmt->bind_param("is", $id_personas, $fecha);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            return "Registro agregado con ID: " . $this->_db->insert_id;
        }
        $stmt->close();
        return "Error al agregar el registro.";
    }

    // Método para eliminar un registro
    public function delete_docente($id_docentes)
    {
        $sql = "DELETE FROM u_docentes WHERE id_docentes = ?";
        $stmt = $this->_db->prepare($sql);
        if (!$stmt) {
            return "Error en la preparación de la consulta: " . $this->_db->error;
        }
        $stmt->bind_param("i", $id_docentes);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            return "Registro eliminado correctamente.";
        }
        $stmt->close();
        return "No se encontró el registro a eliminar.";
    }

    // Método para actualizar un registro
    public function update_docente($id_docentes, $id_personas, $fecha)
    {
        $sql = "UPDATE u_docentes SET id_personas = ?, fecha = ? WHERE id_docentes = ?";
        $stmt = $this->_db->prepare($sql);
        if (!$stmt) {
            return "Error en la preparación de la consulta actulizar docente: " . $this->_db->error;
        }
        $stmt->bind_param("isi", $id_personas, $fecha, $id_docentes);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            return "Registro actualizado correctamente.";
        }
        $stmt->close();
        return "No se encontraron cambios o el registro no existe.";
    }

    // Método para obtener registros
    public function get_docente($id_docentes = null)
    {
        if ($id_docentes) {
            // Obtener un solo registro
            $sql = "SELECT * FROM u_docentes WHERE id_docentes = ?";
            $stmt = $this->_db->prepare($sql);
            if (!$stmt) {
                return "Error en la preparación de la consulta get alumno: " . $this->_db->error;
            }
            $stmt->bind_param("i", $id_docentes);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            $stmt->close();
            return $data ?: "No se encontró el registro.";
        } else {
            // Obtener todos los registros
            $sql = "SELECT * FROM u_docentes";
            $result = $this->_db->query($sql);
            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            }
            return "No hay registros.";
        }
    }

    // Destructor: Cerrar conexión
    public function __destruct()
    {
        $this->_db->close();
    }
}
