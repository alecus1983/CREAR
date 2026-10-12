<?php

/**
 * @class constancias
 * @brief Clase que registra las constancias de matrícula emitidas.
 *
 * Cada constancia queda registrada en la tabla `constancias` con un número
 * consecutivo (id_constancia), el alumno, el año de la matrícula y la fecha
 * en que se expide.
 */
class constancias extends imcrea
{
    /**
     * @var int $id_constancia
     * @brief Clave primaria, número consecutivo de la constancia.
     */
    public $id_constancia;

    /**
     * @var int $id_alumno
     * @brief Código del alumno (u_alumnos.id_alumnos).
     */
    public $id_alumno;

    /**
     * @var string $year
     * @brief Año de la matrícula sobre la que se expide la constancia.
     */
    public $year;

    /**
     * @var string $fecha
     * @brief Fecha en que se expide la constancia (YYYY-MM-DD).
     */
    public $fecha;

    public function __construct()
    {
        parent::__construct();
    }

    // ---

    /**
     * @brief Registra la emisión de una constancia y carga su número en el objeto.
     *
     * Si ya se expidió hoy una constancia para el mismo alumno y año se reutiliza
     * ese registro, para no consumir un número nuevo cada vez que se recarga el PDF.
     *
     * @param int    $id_alumno El ID del alumno.
     * @param string $year      El año de la matrícula.
     * @return int El número de la constancia, o 0 si no se pudo registrar.
     */
    public function registrar($id_alumno, $year)
    {
        try {
            $fecha = date('Y-m-d');

            // busco si ya se expidio hoy una constancia para el alumno y el año
            $q = "SELECT id_constancia FROM constancias
                  WHERE id_alumno = ? AND year = ? AND fecha = ?
                  ORDER BY id_constancia DESC LIMIT 1";
            $stmt = $this->_db->prepare($q);

            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta de constancias: " . $this->_db->error);
            }

            $id_encontrado = 0;
            $stmt->bind_param("iss", $id_alumno, $year, $fecha);
            $stmt->execute();
            $stmt->bind_result($id_encontrado);
            $stmt->fetch();
            $stmt->close();

            // si no existe se inserta un nuevo registro
            if (!$id_encontrado) {
                $q = "INSERT INTO constancias (id_alumno, year, fecha) VALUES (?, ?, ?)";
                $stmt = $this->_db->prepare($q);

                if ($stmt === false) {
                    throw new Exception("Error al preparar la inserción de la constancia: " . $this->_db->error);
                }

                $stmt->bind_param("iss", $id_alumno, $year, $fecha);
                if (!$stmt->execute()) {
                    throw new Exception("Error al registrar la constancia: " . $stmt->error);
                }
                $id_encontrado = $this->_db->insert_id;
                $stmt->close();
            }

            $this->id_constancia = (int) $id_encontrado;
            $this->id_alumno = $id_alumno;
            $this->year = $year;
            $this->fecha = $fecha;

            return $this->id_constancia;
        } catch (Exception $e) {
            error_log("Error en registrar constancia: " . $e->getMessage());
            return 0;
        }
    }
}
