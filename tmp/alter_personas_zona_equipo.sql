-- nuevos campos de la tabla personas
-- zona                : zona de residencia, 1 = urbana, 2 = rural
-- equipo_tecnologico  : equipo utilizado para la comunicacion virtual,
--                       1 = celular, 2 = tablet, 3 = computador
ALTER TABLE imcreati_datam.personas
  ADD COLUMN `zona` tinyint(1) DEFAULT NULL AFTER `estrato`,
  ADD COLUMN `equipo_tecnologico` tinyint(1) DEFAULT NULL AFTER `zona`;
