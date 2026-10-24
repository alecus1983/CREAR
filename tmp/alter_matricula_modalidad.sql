-- nuevo campo de la tabla matricula
-- modalidad : modalidad de estudio del alumno: Presencial, Virtual, Por ciclos, Híbrida
ALTER TABLE imcreati_datam.matricula
  ADD COLUMN `modalidad` varchar(20) DEFAULT NULL AFTER `id_curso`;
