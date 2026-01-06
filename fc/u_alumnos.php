<?php

// clase de alumnos a partir de la clase de personas
class u_alumnos extends personas
{

    // Constructor: establece la conexión a la base de datos
    public function __construct()
    {
        //   constructor de la clase padre
        parent::__construct();
    }

    // Método para agregar un registro
    public function add_alumno($id_personas)
    {

        // actualizo la fecha actual
        $fecha = date("Y-m-d");

        $sql = "INSERT INTO u_alumnos (id_personas, fecha) VALUES (?, ?)";
        $stmt = $this->_db->prepare($sql);
        if (!$stmt) {
            return "Error en la preparación de la consulta: " . $this->_db->error;
        }
        $stmt->bind_param("is", $id_personas, $fecha);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            return  $this->_db->insert_id;
        }
        $stmt->close();
        return "";
    }

    // Método para eliminar un registro
    public function delete_alumno($id_alumnos)
    {
        $sql = "DELETE FROM u_alumnos WHERE id_alumnos = ?";
        $stmt = $this->_db->prepare($sql);
        if (!$stmt) {
            return "Error en la preparación de la consulta: " . $this->_db->error;
        }
        $stmt->bind_param("i", $id_alumnos);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            return "Registro eliminado correctamente.";
        }
        $stmt->close();
        return "No se encontró el registro a eliminar.";
    }

    // Método para actualizar un registro
    public function update_alumno($id_alumnos, $id_personas, $fecha)
    {
        $sql = "UPDATE u_alumnos SET id_personas = ?, fecha = ? WHERE id_alumnos = ?";
        $stmt = $this->_db->prepare($sql);
        if (!$stmt) {
            return "Error en la preparación de la consulta: " . $this->_db->error;
        }
        $stmt->bind_param("isi", $id_personas, $fecha, $id_alumnos);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            return "Registro actualizado correctamente.";
        }
        $stmt->close();
        return "No se encontraron cambios o el registro no existe.";
    }

    // Método para obtener registros
    public function get_alumno($id_alumnos = null)
    {
        if ($id_alumnos) {
            // Obtener un solo registro
            $sql = "SELECT * FROM u_alumnos WHERE id_alumnos = ?";
            $stmt = $this->_db->prepare($sql);
            if (!$stmt) {
                return "Error en la preparación de la consulta get alumno: " . $this->_db->error;
            }
            $stmt->bind_param("i", $id_alumnos);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            $stmt->close();
            return $data ?: "No se encontró el registro.";
        } else {
            // Obtener todos los registros
            $sql = "SELECT * FROM u_alumnos";
            $result = $this->_db->query($sql);
            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            }
            return "No hay registros.";
        }
    }

    // funcion que permite tener los datos de  un alumno
    // en funcion de su identificacion de persona
    // $id_presona  --> condigo de la persona (generarmente la cedula o targeta de identidad)

    public function get_alumno_persona($id_personas = null)
    {
        if ($id_personas) {
            // Obtener un solo registro
            $sql = "SELECT * FROM u_alumnos WHERE id_personas = ?";
            $stmt = $this->_db->prepare($sql);
            if (!$stmt) {
                return "Error en la preparación de la consulta get alumno: " . $this->_db->error;
            }
            $stmt->bind_param("i", $id_personas);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            $stmt->close();
            return $data ;
        } else {
            
            return "";
        }
    }

    // Destructor: Cerrar conexión
    public function __destruct()
    {
        $this->_db->close();
    }
}
