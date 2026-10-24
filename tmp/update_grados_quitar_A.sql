-- quita el sufijo "-A" del nombre de los grados (ej. "11-A" -> "11")
-- grados afectados: id_grado 1 al 6 y 10 al 14 (1-A ... 11-A)
UPDATE imcreati_datam.grados
   SET grado = LEFT(grado, CHAR_LENGTH(grado) - 2)
 WHERE grado LIKE '%-A';

-- para revertir:
-- UPDATE imcreati_datam.grados SET grado = CONCAT(grado, '-A') WHERE id_grado IN (1,2,3,4,5,6,10,11,12,13,14);
