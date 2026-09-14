-- borra el contenido de los datos
DROP TABLE  imcreati_datam.c_2026;
/*
 * Consulta para agrupar las notas en  una nueva estructura
 * Cada fila representa un periodo de un estudiante
 */ 

create table imcreati_datam.c_2026 as
-- consulta
SELECT id_alumno, id_materia,
    max(id_docente) as docente,
    max(modificado) as modificado, 
    -- SEMANA 1 (id_semana = 1)
    MAX(CASE WHEN id_semana = 1 AND id_ponderado = 1 THEN nota END) AS `1A`,
    MAX(CASE WHEN id_semana = 1 AND id_ponderado = 2 THEN nota END) AS `1B`,
    MAX(CASE WHEN id_semana = 1 AND id_ponderado = 3 THEN nota END) AS `1C`,
    MAX(CASE WHEN id_semana = 1 AND id_ponderado = 4 THEN nota END) AS `1D`,
    MAX(CASE WHEN id_semana = 1 AND id_ponderado = 5 THEN nota END) AS `1E`,
    MAX(CASE WHEN id_semana = 1 AND id_ponderado = 6 THEN nota END) AS `1F`,
    MAX(CASE WHEN id_semana = 1 AND id_ponderado = 7 THEN nota END) AS `1G`,
    MAX(CASE WHEN id_semana = 1 AND id_ponderado = 20 THEN nota END) AS `D1`,

    -- SEMANA 2 (id_semana = 2)
    MAX(CASE WHEN id_semana = 2 AND id_ponderado = 1 THEN nota END) AS `2A`,
    MAX(CASE WHEN id_semana = 2 AND id_ponderado = 2 THEN nota END) AS `2B`,
    MAX(CASE WHEN id_semana = 2 AND id_ponderado = 3 THEN nota END) AS `2C`,
    MAX(CASE WHEN id_semana = 2 AND id_ponderado = 4 THEN nota END) AS `2D`,
    MAX(CASE WHEN id_semana = 2 AND id_ponderado = 5 THEN nota END) AS `2E`,
    MAX(CASE WHEN id_semana = 2 AND id_ponderado = 6 THEN nota END) AS `2F`,
    MAX(CASE WHEN id_semana = 2 AND id_ponderado = 7 THEN nota END) AS `2G`,
    MAX(CASE WHEN id_semana = 2 AND id_ponderado = 20 THEN nota END) AS `D2`,

    -- SEMANA 3 (id_semana = 3)
    MAX(CASE WHEN id_semana = 3 AND id_ponderado = 1 THEN nota END) AS `3A`,
    MAX(CASE WHEN id_semana = 3 AND id_ponderado = 2 THEN nota END) AS `3B`,
    MAX(CASE WHEN id_semana = 3 AND id_ponderado = 3 THEN nota END) AS `3C`,
    MAX(CASE WHEN id_semana = 3 AND id_ponderado = 4 THEN nota END) AS `3D`,
    MAX(CASE WHEN id_semana = 3 AND id_ponderado = 5 THEN nota END) AS `3E`,
    MAX(CASE WHEN id_semana = 3 AND id_ponderado = 6 THEN nota END) AS `3F`,
    MAX(CASE WHEN id_semana = 3 AND id_ponderado = 7 THEN nota END) AS `3G`,
    MAX(CASE WHEN id_semana = 3 AND id_ponderado = 20 THEN nota END) AS `D3`,

    -- SEMANA 4 (id_semana = 4)
    MAX(CASE WHEN id_semana = 4 AND id_ponderado = 1 THEN nota END) AS `4A`,
    MAX(CASE WHEN id_semana = 4 AND id_ponderado = 2 THEN nota END) AS `4B`,
    MAX(CASE WHEN id_semana = 4 AND id_ponderado = 3 THEN nota END) AS `4C`,
    MAX(CASE WHEN id_semana = 4 AND id_ponderado = 4 THEN nota END) AS `4D`,
    MAX(CASE WHEN id_semana = 4 AND id_ponderado = 5 THEN nota END) AS `4E`,
    MAX(CASE WHEN id_semana = 4 AND id_ponderado = 6 THEN nota END) AS `4F`,
    MAX(CASE WHEN id_semana = 4 AND id_ponderado = 7 THEN nota END) AS `4G`,
    MAX(CASE WHEN id_semana = 4 AND id_ponderado = 8 THEN nota END) AS `4H`,
    MAX(CASE WHEN id_semana = 4 AND id_ponderado = 20 THEN nota END) AS `D4`,

    -- SEMANA 5 (id_semana = 5)
    MAX(CASE WHEN id_semana = 5 AND id_ponderado = 1 THEN nota END) AS `5A`,
    MAX(CASE WHEN id_semana = 5 AND id_ponderado = 2 THEN nota END) AS `5B`,
    MAX(CASE WHEN id_semana = 5 AND id_ponderado = 3 THEN nota END) AS `5C`,
    MAX(CASE WHEN id_semana = 5 AND id_ponderado = 4 THEN nota END) AS `5D`,
    MAX(CASE WHEN id_semana = 5 AND id_ponderado = 5 THEN nota END) AS `5E`,
    MAX(CASE WHEN id_semana = 5 AND id_ponderado = 6 THEN nota END) AS `5F`,
    MAX(CASE WHEN id_semana = 5 AND id_ponderado = 7 THEN nota END) AS `5G`,
    MAX(CASE WHEN id_semana = 5 AND id_ponderado = 20 THEN nota END) AS `D5`, 

    -- SEMANA 6 (id_semana = 6)
    MAX(CASE WHEN id_semana = 6 AND id_ponderado = 1 THEN nota END) AS `6A`,
    MAX(CASE WHEN id_semana = 6 AND id_ponderado = 2 THEN nota END) AS `6B`,
    MAX(CASE WHEN id_semana = 6 AND id_ponderado = 3 THEN nota END) AS `6C`,
    MAX(CASE WHEN id_semana = 6 AND id_ponderado = 4 THEN nota END) AS `6D`,
    MAX(CASE WHEN id_semana = 6 AND id_ponderado = 5 THEN nota END) AS `6E`,
    MAX(CASE WHEN id_semana = 6 AND id_ponderado = 6 THEN nota END) AS `6F`,
    MAX(CASE WHEN id_semana = 6 AND id_ponderado = 7 THEN nota END) AS `6G`,
    MAX(CASE WHEN id_semana = 6 AND id_ponderado = 20 THEN nota END) AS `D6`,

    -- SEMANA 7 (id_semana = 7)
    MAX(CASE WHEN id_semana = 7 AND id_ponderado = 1 THEN nota END) AS `7A`,
    MAX(CASE WHEN id_semana = 7 AND id_ponderado = 2 THEN nota END) AS `7B`,
    MAX(CASE WHEN id_semana = 7 AND id_ponderado = 3 THEN nota END) AS `7C`,
    MAX(CASE WHEN id_semana = 7 AND id_ponderado = 4 THEN nota END) AS `7D`,
    MAX(CASE WHEN id_semana = 7 AND id_ponderado = 5 THEN nota END) AS `7E`,
    MAX(CASE WHEN id_semana = 7 AND id_ponderado = 6 THEN nota END) AS `7F`,
    MAX(CASE WHEN id_semana = 7 AND id_ponderado = 7 THEN nota END) AS `7G`,
    MAX(CASE WHEN id_semana = 7 AND id_ponderado = 20 THEN nota END) AS `D7`,

    -- SEMANA 8 (id_semana = 8)
    -- Nota: Siguiendo tu ALTER TABLE, la semana 8 solo tiene de la E (5) a la J (10)
    MAX(CASE WHEN id_semana = 8 AND id_ponderado = 5 THEN nota END) AS `8E`,
    MAX(CASE WHEN id_semana = 8 AND id_ponderado = 6 THEN nota END) AS `8F`,
    MAX(CASE WHEN id_semana = 8 AND id_ponderado = 7 THEN nota END) AS `8G`,
    MAX(CASE WHEN id_semana = 8 AND id_ponderado = 9 THEN nota END) AS `8I`,
    MAX(CASE WHEN id_semana = 8 AND id_ponderado = 10 THEN nota END) AS `8J`,
    null as 'R1',
    MAX(CASE WHEN id_semana = 8 AND id_ponderado = 20 THEN nota END) AS `D8`,
    MAX(CASE WHEN id_materia = 20 AND periodo = 1 THEN nota END) AS 'D_p1',
    max(id_logro) AS `l1_p1`,
    null  AS `l2_p1`,
    null AS `l3_p1`,
	
    -- SEGUNDO PERIODO
    
    -- SEMANA 9 (id_semana = 9)
    MAX(CASE WHEN id_semana = 9 AND id_ponderado = 1 THEN nota END) AS `9A`,
    MAX(CASE WHEN id_semana = 9 AND id_ponderado = 2 THEN nota END) AS `9B`,
    MAX(CASE WHEN id_semana = 9 AND id_ponderado = 3 THEN nota END) AS `9C`,
    MAX(CASE WHEN id_semana = 9 AND id_ponderado = 4 THEN nota END) AS `9D`,
    MAX(CASE WHEN id_semana = 9 AND id_ponderado = 5 THEN nota END) AS `9E`,
    MAX(CASE WHEN id_semana = 9 AND id_ponderado = 6 THEN nota END) AS `9F`,
    MAX(CASE WHEN id_semana = 9 AND id_ponderado = 7 THEN nota END) AS `9G`,
    MAX(CASE WHEN id_semana = 9 AND id_ponderado = 20 THEN nota END) AS `D9`,

  
    -- SEMANA 10 (id_semana = 10)
    MAX(CASE WHEN id_semana = 10 AND id_ponderado = 1 THEN nota END) AS `10A`,
    MAX(CASE WHEN id_semana = 10 AND id_ponderado = 2 THEN nota END) AS `10B`,
    MAX(CASE WHEN id_semana = 10 AND id_ponderado = 3 THEN nota END) AS `10C`,
    MAX(CASE WHEN id_semana = 10 AND id_ponderado = 4 THEN nota END) AS `10D`,
    MAX(CASE WHEN id_semana = 10 AND id_ponderado = 5 THEN nota END) AS `10E`,
    MAX(CASE WHEN id_semana = 10 AND id_ponderado = 6 THEN nota END) AS `10F`,
    MAX(CASE WHEN id_semana = 10 AND id_ponderado = 7 THEN nota END) AS `10G`,
    MAX(CASE WHEN id_semana = 10 AND id_ponderado = 20 THEN nota END) AS `D10`,

    -- SEMANA 11 (id_semana = 11)
    MAX(CASE WHEN id_semana = 11 AND id_ponderado = 1 THEN nota END) AS `11A`,
    MAX(CASE WHEN id_semana = 11 AND id_ponderado = 2 THEN nota END) AS `11B`,
    MAX(CASE WHEN id_semana = 11 AND id_ponderado = 3 THEN nota END) AS `11C`,
    MAX(CASE WHEN id_semana = 11 AND id_ponderado = 4 THEN nota END) AS `11D`,
    MAX(CASE WHEN id_semana = 11 AND id_ponderado = 5 THEN nota END) AS `11E`,
    MAX(CASE WHEN id_semana = 11 AND id_ponderado = 6 THEN nota END) AS `11F`,
    MAX(CASE WHEN id_semana = 11 AND id_ponderado = 7 THEN nota END) AS `11G`,
    MAX(CASE WHEN id_semana = 11 AND id_ponderado = 20 THEN nota END) AS `D11`,

    -- SEMANA 12 (id_semana = 12)
    MAX(CASE WHEN id_semana = 12 AND id_ponderado = 1 THEN nota END) AS `12A`,
    MAX(CASE WHEN id_semana = 12 AND id_ponderado = 2 THEN nota END) AS `12B`,
    MAX(CASE WHEN id_semana = 12 AND id_ponderado = 3 THEN nota END) AS `12C`,
    MAX(CASE WHEN id_semana = 12 AND id_ponderado = 4 THEN nota END) AS `12D`,
    MAX(CASE WHEN id_semana = 12 AND id_ponderado = 5 THEN nota END) AS `12E`,
    MAX(CASE WHEN id_semana = 12 AND id_ponderado = 6 THEN nota END) AS `12F`,
    MAX(CASE WHEN id_semana = 12 AND id_ponderado = 7 THEN nota END) AS `12G`,
    MAX(CASE WHEN id_semana = 12 AND id_ponderado = 8 THEN nota END) AS `12H`,
    MAX(CASE WHEN id_semana = 12 AND id_ponderado = 20 THEN nota END) AS `D12`,

    -- SEMANA 13 (id_semana = 13)
    MAX(CASE WHEN id_semana = 13 AND id_ponderado = 1 THEN nota END) AS `13A`,
    MAX(CASE WHEN id_semana = 13 AND id_ponderado = 2 THEN nota END) AS `13B`,
    MAX(CASE WHEN id_semana = 13 AND id_ponderado = 3 THEN nota END) AS `13C`,
    MAX(CASE WHEN id_semana = 13 AND id_ponderado = 4 THEN nota END) AS `13D`,
    MAX(CASE WHEN id_semana = 13 AND id_ponderado = 5 THEN nota END) AS `13E`,
    MAX(CASE WHEN id_semana = 13 AND id_ponderado = 6 THEN nota END) AS `13F`,
    MAX(CASE WHEN id_semana = 13 AND id_ponderado = 7 THEN nota END) AS `13G`,
    MAX(CASE WHEN id_semana = 13 AND id_ponderado = 20 THEN nota END) AS `D13`, 

    -- SEMANA 14 (id_semana = 14)
    MAX(CASE WHEN id_semana = 14 AND id_ponderado = 1 THEN nota END) AS `14A`,
    MAX(CASE WHEN id_semana = 14 AND id_ponderado = 2 THEN nota END) AS `14B`,
    MAX(CASE WHEN id_semana = 14 AND id_ponderado = 3 THEN nota END) AS `14C`,
    MAX(CASE WHEN id_semana = 14 AND id_ponderado = 4 THEN nota END) AS `14D`,
    MAX(CASE WHEN id_semana = 14 AND id_ponderado = 5 THEN nota END) AS `14E`,
    MAX(CASE WHEN id_semana = 14 AND id_ponderado = 6 THEN nota END) AS `14F`,
    MAX(CASE WHEN id_semana = 14 AND id_ponderado = 7 THEN nota END) AS `14G`,
    MAX(CASE WHEN id_semana = 14 AND id_ponderado = 20 THEN nota END) AS `D14`,

    -- SEMANA 15 (id_semana = 15)
    MAX(CASE WHEN id_semana = 15 AND id_ponderado = 1 THEN nota END) AS `15A`,
    MAX(CASE WHEN id_semana = 15 AND id_ponderado = 2 THEN nota END) AS `15B`,
    MAX(CASE WHEN id_semana = 15 AND id_ponderado = 3 THEN nota END) AS `15C`,
    MAX(CASE WHEN id_semana = 15 AND id_ponderado = 4 THEN nota END) AS `15D`,
    MAX(CASE WHEN id_semana = 15 AND id_ponderado = 5 THEN nota END) AS `15E`,
    MAX(CASE WHEN id_semana = 15 AND id_ponderado = 6 THEN nota END) AS `15F`,
    MAX(CASE WHEN id_semana = 15 AND id_ponderado = 7 THEN nota END) AS `15G`,
    MAX(CASE WHEN id_semana = 15 AND id_ponderado = 20 THEN nota END) AS `D15`,

    -- SEMANA 16 (id_semana = 16)
    -- Nota: Siguiendo tu ALTER TABLE, la semana 8 solo tiene de la E (5) a la J (10)
    MAX(CASE WHEN id_semana = 16 AND id_ponderado = 5 THEN nota END) AS `16E`,
    MAX(CASE WHEN id_semana = 16 AND id_ponderado = 6 THEN nota END) AS `16F`,
    MAX(CASE WHEN id_semana = 16 AND id_ponderado = 7 THEN nota END) AS `16G`,
    MAX(CASE WHEN id_semana = 16 AND id_ponderado = 9 THEN nota END) AS `16I`,
    MAX(CASE WHEN id_semana = 16 AND id_ponderado = 10 THEN nota END) AS `16J`,
    null as 'R2',
    MAX(CASE WHEN id_semana = 16 AND id_ponderado = 20 THEN nota END) AS `D16`,
    MAX(CASE WHEN id_materia = 20 AND periodo = 2 THEN nota END) AS 'D_p2',
    MAX(CASE WHEN id_logro > 0 THEN id_logro END) AS `l1_p2`,
    null AS `l2_p2`,
    null AS `l3_p2`,

    -- TERCER PERIODO
    
     -- SEMANA 17 (id_semana = 17)
    MAX(CASE WHEN id_semana = 17 AND id_ponderado = 1 THEN nota END) AS `17A`,
    MAX(CASE WHEN id_semana = 17 AND id_ponderado = 2 THEN nota END) AS `17B`,
    MAX(CASE WHEN id_semana = 17 AND id_ponderado = 3 THEN nota END) AS `17C`,
    MAX(CASE WHEN id_semana = 17 AND id_ponderado = 4 THEN nota END) AS `17D`,
    MAX(CASE WHEN id_semana = 17 AND id_ponderado = 5 THEN nota END) AS `17E`,
    MAX(CASE WHEN id_semana = 17 AND id_ponderado = 6 THEN nota END) AS `17F`,
    MAX(CASE WHEN id_semana = 17 AND id_ponderado = 7 THEN nota END) AS `17G`,
    MAX(CASE WHEN id_semana = 17 AND id_ponderado = 20 THEN nota END) AS `D17`,
    
 -- SEMANA 18 (id_semana = 18)
    MAX(CASE WHEN id_semana = 18 AND id_ponderado = 1 THEN nota END) AS `18A`,
    MAX(CASE WHEN id_semana = 18 AND id_ponderado = 2 THEN nota END) AS `18B`,
    MAX(CASE WHEN id_semana = 18 AND id_ponderado = 3 THEN nota END) AS `18C`,
    MAX(CASE WHEN id_semana = 18 AND id_ponderado = 4 THEN nota END) AS `18D`,
    MAX(CASE WHEN id_semana = 18 AND id_ponderado = 5 THEN nota END) AS `18E`,
    MAX(CASE WHEN id_semana = 18 AND id_ponderado = 6 THEN nota END) AS `18F`,
    MAX(CASE WHEN id_semana = 18 AND id_ponderado = 7 THEN nota END) AS `18G`,
    MAX(CASE WHEN id_semana = 18 AND id_ponderado = 20 THEN nota END) AS `D18`,

    -- SEMANA 19 (id_semana = 19)
    MAX(CASE WHEN id_semana = 19 AND id_ponderado = 1 THEN nota END) AS `19A`,
    MAX(CASE WHEN id_semana = 19 AND id_ponderado = 2 THEN nota END) AS `19B`,
    MAX(CASE WHEN id_semana = 19 AND id_ponderado = 3 THEN nota END) AS `19C`,
    MAX(CASE WHEN id_semana = 19 AND id_ponderado = 4 THEN nota END) AS `19D`,
    MAX(CASE WHEN id_semana = 19 AND id_ponderado = 5 THEN nota END) AS `19E`,
    MAX(CASE WHEN id_semana = 19 AND id_ponderado = 6 THEN nota END) AS `19F`,
    MAX(CASE WHEN id_semana = 19 AND id_ponderado = 7 THEN nota END) AS `19G`,
    MAX(CASE WHEN id_semana = 19 AND id_ponderado = 20 THEN nota END) AS `D19`,

    -- SEMANA 20 (id_semana = 20)
    MAX(CASE WHEN id_semana = 20 AND id_ponderado = 1 THEN nota END) AS `20A`,
    MAX(CASE WHEN id_semana = 20 AND id_ponderado = 2 THEN nota END) AS `20B`,
    MAX(CASE WHEN id_semana = 20 AND id_ponderado = 3 THEN nota END) AS `20C`,
    MAX(CASE WHEN id_semana = 20 AND id_ponderado = 4 THEN nota END) AS `20D`,
    MAX(CASE WHEN id_semana = 20 AND id_ponderado = 5 THEN nota END) AS `20E`,
    MAX(CASE WHEN id_semana = 20 AND id_ponderado = 6 THEN nota END) AS `20F`,
    MAX(CASE WHEN id_semana = 20 AND id_ponderado = 7 THEN nota END) AS `20G`,
    MAX(CASE WHEN id_semana = 20 AND id_ponderado = 8 THEN nota END) AS `20H`,
    MAX(CASE WHEN id_semana = 20 AND id_ponderado = 20 THEN nota END) AS `D20`,

    -- SEMANA 21 (id_semana = 21)
    MAX(CASE WHEN id_semana = 21 AND id_ponderado = 1 THEN nota END) AS `21A`,
    MAX(CASE WHEN id_semana = 21 AND id_ponderado = 2 THEN nota END) AS `21B`,
    MAX(CASE WHEN id_semana = 21 AND id_ponderado = 3 THEN nota END) AS `21C`,
    MAX(CASE WHEN id_semana = 21 AND id_ponderado = 4 THEN nota END) AS `21D`,
    MAX(CASE WHEN id_semana = 21 AND id_ponderado = 5 THEN nota END) AS `21E`,
    MAX(CASE WHEN id_semana = 21 AND id_ponderado = 6 THEN nota END) AS `21F`,
    MAX(CASE WHEN id_semana = 21 AND id_ponderado = 7 THEN nota END) AS `21G`,
    MAX(CASE WHEN id_semana = 21 AND id_ponderado = 20 THEN nota END) AS `D21`, 

    -- SEMANA 22 (id_semana = 22)
    MAX(CASE WHEN id_semana = 22 AND id_ponderado = 1 THEN nota END) AS `22A`,
    MAX(CASE WHEN id_semana = 22 AND id_ponderado = 2 THEN nota END) AS `22B`,
    MAX(CASE WHEN id_semana = 22 AND id_ponderado = 3 THEN nota END) AS `22C`,
    MAX(CASE WHEN id_semana = 22 AND id_ponderado = 4 THEN nota END) AS `22D`,
    MAX(CASE WHEN id_semana = 22 AND id_ponderado = 5 THEN nota END) AS `22E`,
    MAX(CASE WHEN id_semana = 22 AND id_ponderado = 6 THEN nota END) AS `22F`,
    MAX(CASE WHEN id_semana = 22 AND id_ponderado = 7 THEN nota END) AS `22G`,
    MAX(CASE WHEN id_semana = 22 AND id_ponderado = 20 THEN nota END) AS `D22`,

    -- SEMANA 23 (id_semana = 23)
    MAX(CASE WHEN id_semana = 23 AND id_ponderado = 1 THEN nota END) AS `23A`,
    MAX(CASE WHEN id_semana = 23 AND id_ponderado = 2 THEN nota END) AS `23B`,
    MAX(CASE WHEN id_semana = 23 AND id_ponderado = 3 THEN nota END) AS `23C`,
    MAX(CASE WHEN id_semana = 23 AND id_ponderado = 4 THEN nota END) AS `23D`,
    MAX(CASE WHEN id_semana = 23 AND id_ponderado = 5 THEN nota END) AS `23E`,
    MAX(CASE WHEN id_semana = 23 AND id_ponderado = 6 THEN nota END) AS `23F`,
    MAX(CASE WHEN id_semana = 23 AND id_ponderado = 7 THEN nota END) AS `23G`,
    MAX(CASE WHEN id_semana = 23 AND id_ponderado = 20 THEN nota END) AS `D23`,

    -- SEMANA 24 (id_semana = 24)
    -- Nota: Siguiendo tu ALTER TABLE, la semana 8 solo tiene de la E (5) a la J (10)
    MAX(CASE WHEN id_semana = 24 AND id_ponderado = 5 THEN nota END) AS `24E`,
    MAX(CASE WHEN id_semana = 24 AND id_ponderado = 6 THEN nota END) AS `24F`,
    MAX(CASE WHEN id_semana = 24 AND id_ponderado = 7 THEN nota END) AS `24G`,
    MAX(CASE WHEN id_semana = 24 AND id_ponderado = 9 THEN nota END) AS `24I`,
    MAX(CASE WHEN id_semana = 24 AND id_ponderado = 10 THEN nota END) AS `24J`,
    null as 'R3',
    MAX(CASE WHEN id_semana = 24 AND id_ponderado = 20 THEN nota END) AS `D24`,
    MAX(CASE WHEN id_materia = 20 AND periodo = 3 THEN nota END) AS 'D_p3',
    MAX(CASE WHEN id_logro > 0 THEN id_logro END) AS `l1_p3`,
    null AS `l2_p3`,
    null AS `l3_p3`,

    -- CUARTO PERIODO
    
    -- SEMANA 25 (id_semana = 25)
    null AS `25A`,
    null AS `25B`,
    null AS `25C`,
    null AS `25D`,
    null AS `25E`,
    null AS `25F`,
    null AS `25G`,
    null AS `D25`,
  
    -- SEMANA 26 (id_semana = 26)
    null AS `26A`,
    null AS `26B`,
    null AS `26C`,
    null AS `26D`,
    null AS `26E`,
    null AS `26F`,
    null AS `26G`,
    null AS `D26`,

    -- SEMANA 27 (id_semana = 27)
    null AS `27A`,
    null AS `27B`,
    null AS `27C`,
    null AS `27D`,
    null AS `27E`,
    null AS `27F`,
    null AS `27G`,
    null AS `D27`,

    -- SEMANA 28 (id_semana = 28)
    null AS `28A`,
    null AS `28B`,
    null AS `28C`,
    null AS `28D`,
    null AS `28E`,
    null AS `28F`,
    null AS `28G`,
    null AS `28H`,
    null AS `D28`,

    -- SEMANA 29 (id_semana = 29)
    null AS `29A`,
    null AS `29B`,
    null AS `29C`,
    null AS `29D`,
    null AS `29E`,
    null AS `29F`,
    null AS `29G`,
    null AS `D29`, 

    -- SEMANA 30 (id_semana = 30)
    null AS `30A`,
    null AS `30B`,
    null AS `30C`,
    null AS `30D`,
    null AS `30E`,
    null AS `30F`,
    null AS `30G`,
    null AS `D30`,

    -- SEMANA 31 (id_semana = 31)
    null AS `31A`,
    null AS `31B`,
    null AS `31C`,
    null AS `31D`,
    null AS `31E`,
    null AS `31F`,
    null AS `31G`,
    null AS `D31`,

    -- SEMANA 32 (id_semana = 32)
    null AS `32E`,
    null AS `32F`,
    null AS `32G`,
    null AS `32I`,
    null AS `32J`,
    null as 'R4',
    null AS `D32`,
    null AS `l1_p4`,
    null AS `l2_p4`,
    null AS `l3_p4`
    
FROM imcreati_datao.calificaciones_2026
where id_alumno > 0
GROUP BY id_alumno, id_materia
order by  id_materia, id_alumno;