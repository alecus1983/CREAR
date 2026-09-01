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

    /**
     * Obtiene el siguiente id_alumnos disponible (MAX + 1).
     * Necesario porque la columna no tiene AUTO_INCREMENT.
     *
     * @return int
     */
    private function get_next_id(): int
    {
        $res = $this->_db->query("SELECT COALESCE(MAX(id_alumnos), 0) + 1 AS next_id FROM u_alumnos");
        $row = $res->fetch_assoc();
        return (int) ($row['next_id'] ?? 1);
    }

    /**
     * Agrega un alumno a la tabla u_alumnos con un id_alumnos calculado
     * (MAX + 1) y actualiza la columna u_alumnos en personas.
     *
     * @param  int        $id_personas  ID de la persona a registrar como alumno.
     * @return int|string               ID del nuevo alumno o mensaje de error.
     */
    public function add_alumno($id_personas)
    {
        // 1. Verificar si ya existe un registro para esta persona
        $existe = $this->get_alumno_persona($id_personas);
        if ($existe && isset($existe['id_alumnos'])) {
            // Ya existe — devolvemos el id_alumnos existente
            return (int) $existe['id_alumnos'];
        }

        // 2. Calcular el siguiente id_alumnos disponible
        $nuevo_id = $this->get_next_id();
        $fecha    = date('Y-m-d');

        // 3. Insertar en u_alumnos con id_alumnos explícito
        $sql  = "INSERT INTO u_alumnos (id_alumnos, id_personas, fecha) VALUES (?, ?, ?)";
        $stmt = $this->_db->prepare($sql);
        if (!$stmt) {
            return 'Error preparando INSERT en u_alumnos: ' . $this->_db->error;
        }
        $stmt->bind_param('iis', $nuevo_id, $id_personas, $fecha);
        if (!$stmt->execute()) {
            $err = $stmt->error;
            $stmt->close();
            return 'Error ejecutando INSERT en u_alumnos: ' . $err;
        }
        $stmt->close();

        // 4. Actualizar la columna u_alumnos en la tabla personas
        $sql2  = "UPDATE personas SET u_alumnos = ? WHERE id_personas = ?";
        $stmt2 = $this->_db->prepare($sql2);
        if ($stmt2) {
            $stmt2->bind_param('ii', $nuevo_id, $id_personas);
            $stmt2->execute();
            $stmt2->close();
        }

        return $nuevo_id;
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
        }
        else {
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
            return $data;
        }
        else {

            return "";
        }
    }

}