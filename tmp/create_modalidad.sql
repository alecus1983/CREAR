-- tabla modalidad: modalidades de estudio de una matricula
CREATE TABLE imcreati_datam.modalidad (
  `id_modalidad` int(11) NOT NULL AUTO_INCREMENT,
  `modalidad` varchar(20) NOT NULL,
  PRIMARY KEY (`id_modalidad`),
  UNIQUE KEY `modalidad` (`modalidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci COMMENT='Modalidades de estudio de la matricula';

INSERT INTO imcreati_datam.modalidad (`id_modalidad`, `modalidad`) VALUES
  (1, 'Presencial'),
  (2, 'Virtual'),
  (3, 'Por ciclos'),
  (4, 'Híbrida');

-- la matricula guarda la llave foranea a la tabla modalidad
-- (reemplaza la columna de texto modalidad de alter_matricula_modalidad.sql)
ALTER TABLE imcreati_datam.matricula
  DROP COLUMN `modalidad`,
  ADD COLUMN `id_modalidad` int(11) DEFAULT NULL AFTER `id_curso`,
  ADD KEY `id_modalidad` (`id_modalidad`),
  ADD CONSTRAINT `fk_matricula_modalidad` FOREIGN KEY (`id_modalidad`)
    REFERENCES `modalidad` (`id_modalidad`) ON UPDATE CASCADE ON DELETE RESTRICT;
