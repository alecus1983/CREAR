-- nuevos campos de la tabla personas
-- expedido_en          : municipio donde fue expedido el documento de identidad
-- municipio_nacimiento : municipio de nacimiento de la persona
-- sexo                 : 1 = femenino, 2 = masculino
ALTER TABLE imcreati_datam.personas
  ADD COLUMN `expedido_en` varchar(100) DEFAULT NULL AFTER `tipo_identificacion`,
  ADD COLUMN `municipio_nacimiento` varchar(100) DEFAULT NULL AFTER `nacimiento`,
  ADD COLUMN `sexo` tinyint(1) DEFAULT NULL AFTER `municipio_nacimiento`;
