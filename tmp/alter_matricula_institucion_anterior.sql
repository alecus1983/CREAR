-- nuevos campos de la tabla matricula: datos de la institucion de procedencia
-- proviene_otra_institucion : 1 = el alumno proviene de otra institucion, 0 = no
-- institucion_anterior      : nombre de la institucion de procedencia
-- tipo_institucion          : Publico, Privado, ICBF
-- situacion_academica       : Aprobo, Reprobo, Deserto, Se traslado
-- municipio_institucion     : municipio de la institucion de procedencia
-- fecha_retiro              : fecha de retiro de la institucion de procedencia
-- motivo_retiro             : motivo de retiro de la institucion de procedencia
ALTER TABLE imcreati_datam.matricula
  ADD COLUMN `proviene_otra_institucion` tinyint(1) NOT NULL DEFAULT 0 AFTER `fecha`,
  ADD COLUMN `institucion_anterior` varchar(150) DEFAULT NULL AFTER `proviene_otra_institucion`,
  ADD COLUMN `tipo_institucion` varchar(20) DEFAULT NULL AFTER `institucion_anterior`,
  ADD COLUMN `situacion_academica` varchar(20) DEFAULT NULL AFTER `tipo_institucion`,
  ADD COLUMN `municipio_institucion` varchar(100) DEFAULT NULL AFTER `situacion_academica`,
  ADD COLUMN `fecha_retiro` date DEFAULT NULL AFTER `municipio_institucion`,
  ADD COLUMN `motivo_retiro` varchar(255) DEFAULT NULL AFTER `fecha_retiro`;
