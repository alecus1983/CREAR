-- tabla que registra las constancias de matricula emitidas
CREATE TABLE IF NOT EXISTS imcreati_datam.constancias (
  `id_constancia` int(11) NOT NULL AUTO_INCREMENT, -- numero de la constancia
  `id_alumno` int(11) NOT NULL,                    -- codigo del alumno (u_alumnos.id_alumnos)
  `year` varchar(4) NOT NULL,                      -- año de la matricula
  `fecha` date NOT NULL,                           -- fecha en que se expide la constancia
  PRIMARY KEY (`id_constancia`),
  KEY `id_alumno` (`id_alumno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
