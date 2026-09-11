
select id_alumno, id_materia,id_logro, periodo, corte, id_ponderado, id_semana
from calificaciones where  year = 2023 and periodo = 1
and id_alumno = 1124 and id_materia = 4  order by id_semana, id_ponderado;

describe calificaciones;

describe matricula;

select * from matricula where year = 2023;

select * from ponderado;

show tables;

describe personas;

CREATE TABLE imcreati_data.cuadro_notas (
	id_alumno INT NOT NULL,
	id_grado INT NOT NULL,
	`year` VARCHAR(100) NOT NULL,
	id_area INT NOT NULL,
	id_materia INT NOT NULL,
	p1 FLOAT NULL,
	p2 FLOAT NULL,
	p3 FLOAT NULL,
	p4 FLOAT NULL,
	ac FLOAT NULL
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci
COMMENT='tiene las notas calculadas';

CREATE TABLE imcreati_data.alumnos_puesto (
	id_alumno INT NOT NULL,
	id_grado INT NOT NULL,
	id_curso INT NOT NULL,
	id_jornada INT NOT NULL,
	puesto INT NOT NULL,
	id_puesto BIGINT auto_increment NULL
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

insert into cuadro (id_alumno, id_materia, id_area, year, periodo, p1,p2,p3,p4,r1,r2,r3,r4,promedio) 
values (1059, 7, 4, 2024, 1, 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 0,0)

DELETE  from cuadro 
insert into cuadro (id_alumno, id_materia, id_area, year, periodo, p1,p2,p3,p4,r1,r2,r3,r4,promedio) values (1059, 7, 4, 2024, 1, 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 0,0)


SELECT id_cuadro from cuadro WHERE id_alumno = 861 and id_materia = 7 and year = 2024 and periodo = 1

DESCRIBE cuadro ;

DELETE FROM cuadro;


ALTER TABLE cuadro ADD id_cuadro INT auto_increment NOT NULL;
ALTER TABLE imcreati_data.cuadro ADD CONSTRAINT cuadro_pk PRIMARY KEY (id_cuadro);

SELECT count(*) cantidad from cuadro WHERE id_alumno = 861 and id_materia = 7 and year = 2024 and periodo = 1


select sum(valor*nota)/100 as nota from ponderado as p inner join 
(select id_alumno ,id_ponderado, nota from calificaciones_2024 
where id_alumno = 886   order by id_ponderado) as cal 
on cal.id_ponderado = p.id_ponderado order by p.id_ponderado


describe cuadro 

SELECT count(*) cantidad from cuadro 
WHERE id_alumno = 183 
and id_materia = 8 and year = 2024 
and periodo = 1  


select id_alumno,id_materia,id_logro,nota,id_docente,faltas,periodo,corte,`year`,limite,modificado,own,serie,id_ponderado,id_semana from calificaciones_2024
 where id_alumno = 681 and year = 2024 and periodo = 2;



 INTO OUTFILE 'alumno692.csv';

describe docentes;

describe personas;

CREATE TABLE personas (
id_personas int (13) PRIMARY KEY AUTO_INCREMENT,
nombres varchar (30) not null ,
apellidos varchar (30) not null ,
identificacion varchar (20) not null ,
tipo_idendificacion varchar (3) not null ,
nacimiento date default null ,
correo varchar (50) default null ,
i_correo varchar (50) default null comment 'correo institucional',
celular varchar (10) default null ,
telefono varchar (10) default null ,
u_alumnos int (11) default null ,
u_docentes int (11) default null 
)

select id_personas, nombres, apellidos, tipo_identificacion , identificacion from personas
where tipo_identificacion = 1;


select id_personas, tipo_identificacion  from personas -- where tipo_identificacion = '2';

update personas set tipo_identificacion = 1  where tipo_identificacion = 'TI';

alter table personas alter column tipo_identificacion  INT 


drop table personas;

describe alumnos;

alter table personas modify id_personas INT(12) UNSIGNED AUTO_INCREMENT PRIMARY KEY;

ALTER TABLE personas drop primary key;

-- PROCESO PARA ACTUALIZAR PERSONAS 

DELETE FROM u_alumnos ;
DELETE FROM u_docentes ;
DELETE FROM padres ;
DELETE FROM acudientes ;

DELETE from personas;

alter table personas auto_increment = 1; 

commit;


insert into personas
( nombres, apellidos, identificacion, tipo_identificacion,
nacimiento, correo, i_correo, celular, u_docentes )
select  nombres  , apellidos, cedula,  2,
fecha, correo, i_correo, celular, id_docente FROM  docentes;


insert into personas
( nombres, apellidos, identificacion, tipo_identificacion,
nacimiento, correo, i_correo, celular, u_alumnos )
select  nombres  , apellidos, cedula,  1,
fecha, correo, correo, telefono, id_alumno FROM  alumnos;

INSERT into u_alumnos (id_personas, id_alumnos, fecha)
select id_personas, u_alumnos, '2026-01-01' 
from personas where u_alumnos is not null;

INSERT into u_docentes (id_personas, id_docente, fecha)
select id_personas, u_docentes , '2026-01-01' 
from personas where u_docentes is not null;

--- FIN DEL PROCESO

select nombres,  apellidos  from personas where nombres like '%ana%' -- or apellidos like '%%'

describe personas

select nombres, apellidos from personas where nombres like '%alejandr%' and apellidos like '%%' or identificacion like '%%' 

SELECT (100*COUNT(*))/1368832 FROM  calificaciones_2024 c 

UPDATE personas SET nacimiento ='1980-12-12' where id_personas = 1

delete from personas;

UPDATE personas SET nacimiento ='1987-07-16' where id_personas = 1391

select * from personas where id_personas = 1391


INSERT INTO personas (nombres, apellidos, identificacion ,tipo_identificacion, nacimiento, correo, i_correo, celular, telefono) 
VALUES ('perico','peres', 1111111,1, '2011-11-11','alek@gmail.com', 'asdkf@gmail.com', 565656565, 1212121212)

INSERT INTO personas (nombres, apellidos, identificacion ,tipo_identificacion, nacimiento, correo, i_correo, celular, telefono) VALUES ('perico','peres', 454545454,1, '2011-11-11','asdjfkalsdf@gmail.com', 'jaksfjkls@imcreativo.edu.co', 45454545, 5656565)


CREATE TABLE padres (
	id_padres INT AUTO_INCREMENT,
    id_personas INT NOT NULL,
    id_hijo INT NOT NULL,
	fecha DATE NOT NULL,
    PRIMARY KEY (id_padres),
    FOREIGN KEY (id_personas) REFERENCES personas(id_personas),
    FOREIGN KEY (id_hijo) REFERENCES personas(id_personas)
	
);

CREATE TABLE acudientes (
	id_acudientes INT AUTO_INCREMENT,
    id_personas INT NOT NULL,
    id_hijo INT NOT NULL,
	fecha DATE NOT NULL,
    PRIMARY KEY (id_acudientes),
    FOREIGN KEY (id_personas) REFERENCES personas(id_personas),
    FOREIGN KEY (id_hijo) REFERENCES personas(id_personas)
	
);

CREATE TABLE u_alumnos (
    id_alumnos INT AUTO_INCREMENT,
    id_personas INT NOT NULL,
    fecha DATE NOT NULL,
    PRIMARY KEY (id_alumnos),
    FOREIGN KEY (id_personas) REFERENCES personas(id_personas)
);


CREATE TABLE u_docentes (
    id_docentes INT AUTO_INCREMENT,
    id_personas INT NOT NULL,
    fecha DATE NOT NULL,
    PRIMARY KEY (id_docentes),
    FOREIGN KEY (id_personas) REFERENCES personas(id_personas)
);



DESCRIBE personas


DESCRIBE padres;

describe acudientes;

alter table padres drop Foreign Key id_acudiente;

drop table padres;

SELECT * from padres

INSERT INTO padres (id_personas, id_hijo, fecha) VALUES (1391, 1392, '2020-01-01')

DESCRIBE alumnos;

select * from personas;

select * from alumnos;

commit;



insert into  personas 
(u_alumnos, nombres, apellidos, telefono, identificacion)
 select id_alumno, nombres,  apellidos, telefono, cedula
 from alumnos 
 
 SELECT COUNT(*) from personas where tipo_identificacion = 1;


 
 delete from personas where tipo_identificacion IS NULL 
 
 SELECT id_personas, u_alumnos from personas where personas.u_alumnos is not null
 
mysqldump -u imcreati_admin -p --no-data imcreati_data > estructura_imcrea.sql 

 
UPDATE personas SET 
        sisben = 'N',
        vive_con = ' ',
        etnia = false,
        tipo_etnia = 'otro',
        resguardo_consejo = '',
        familias_accion = false,
        tipo_victima_conflicto = false,
        municipio_expulsor = '',
        discapacitado = false,
        tipo_discapacidad = '',
        capacidad_excepcional = '',
        regimen_salud = false,
        eps =' '
         where id_personas = 51
         
 SELECT 
 antecedents_patologicos_medicos ,
 antecedentes_patologicos_quirurgicos ,
 antecedentes_patologicos_toxicos ,
 antecedentes_patologicos_psiquiatricos ,
 antecedentes_patologicos_psicologicos ,
 antecendentes_patologicos_morbilidad 
 from personas p WHERE id_personas = 7
 
 describe personas ;

SELECT * from jornada j 

INSERT INTO jornada (id_jornada ,jornada) values(4, "Sábado");

commit;

select * from grados ;

select * from u_docentes;

select * from u_alumnos;

select * from jornada;

select * from materias;

describe matricula;
 

select * from matricula---  where year = 2025 -- and id_grado= 1 and id_jornada= 1  and id_curso =1;


select * from matricula m where year = 2025  and m.id_jornada = 1
and id_grado in (select id_grado from grados where id_escolaridad = 2)

select nombre_g from grados where id_grado = 2;

-- consulta para obtener el nombre de los alumnos
select nombres from personas where id_personas in (
select id_personas from u_alumnos where id_alumnos = 14);

-- seleccione

select * from personas as p inner join u_alumnos as a  on p.id_personas = a.id_personas where a.id_alumnos = 4;

select id_docente, completo from 
            (
            select id_docente,  nombres, apellidos, lower(concat(nombres, apellidos)) completo 
            from (select p.id_personas, p.nombres, p.apellidos, ud.id_docente from u_docentes ud 
            inner join personas p on ud.id_personas = p.id_personas) as a ) as c
            order by completo asc

select * from u_docentes ud inner join personas p on ud.id_personas = p.id_personas where identificacion = $id




select * from u_docentes ud
              inner join personas p
              on ud.id_personas = p.id_personas
              where id_docente = 1
              
              
              
 select sum(cantidad) cantidad, id_docente from 
 ( select md.id_docente, md.id_grado,  md.id_jornada, md.id_curso, id_materia, cantidad  from matricula_docente as  md inner join  
 ( select count(*) as cantidad , id_grado, id_jornada, id_curso  from matricula where year = 2025 group by id_jornada, id_grado, id_curso ) as  ca 
 on ca.id_grado = md.id_grado and ca.id_curso = md.id_curso and ca.id_jornada = md.id_jornada  where md.year = 2025 and md.id_docente = 28
 order by md.id_docente, md.id_materia, md.id_grado ) 
 as cd group by id_docente
 

 
 select id_docente as codigo , UPPER(nombres), UPPER(apellidos), p.identificacion   
 from u_docentes ud  inner join personas p where ud.id_personas  = p.id_personas
 order by p.nombres 
 
 
 select admin from u_docentes ud  where id_docente = 2;
 
 select id_docente,identificacion, login, nombres, apellidos from u_docentes ud inner join personas p on ud.id_personas  = p.id_personas
 where id_docente in (
                select distinct id_docente from matricula_docente where year = 2025) and admin= 0
                
                
 select * from u_docentes ud
              inner join personas p
              on ud.id_personas = p.id_personas
              where id_docente = 1
 
 
 
 
 select id_docente, admin, nombres, apellidos, identificacion, login, fecha, celular, correo, i_correo, materias  from u_docentes ud
              inner join personas p
              on ud.id_personas = p.id_personas
              where id_docente = 2;
 
 
 
 select * from matricula_docente where id_grado = 1 and id_jornada = 1 and id_curso = 0 and year = 2025 order by id_docente
 
 -- total docentes
 select id_docente, completo from 
            ( select id_docente,  nombres, apellidos, lower(concat(nombres, apellidos)) completo 
            from (select p.id_personas, p.nombres, p.apellidos, ud.id_docente from u_docentes ud 
            inner join personas p on ud.id_personas = p.id_personas) as a ) as c
            order by completo asc
 
 
 insert into personas (nombres, apellidos, identificacion, tipo_identificacion) 
 values ('ALEX ALBERTO', 'MOSQUERA LOBOA', 10623330121, 2) 
 
 	
 SELECT id_personas , nombres, apellidos from personas where identificacion = 1062318890
 
 select * from u_docentes ud 
 
 ALTER TABLE imcreati_data.u_docentes MODIFY COLUMN id_docente int(11) NOT NULL AUTO_INCREMEN
 
 
 insert into u_docentes (id_docente, id_personas,login, fecha) 
 values (105,1445,1062318890, '2025-01-01' )
 
 
 
 select * from materia inner join grados g 
 where g.id_grado in (1,2,3,4,5,6) and (id_materia < 26 or id_materia >90)  
 
 select * from grados
 
 insert into login ( 
 select  p.id_personas , p.identificacion , p2.login /* p.u_docentes */ 
 from personas p inner join pass p2 on p.u_docentes = p2.id_docente 
 where p.tipo_identificacion = 2
 order by identificacion
 )
 
 select * from personas  where  tipo_identificacion = 2  and id_personas = 73
 
 and identificacion = '34611647' and id_personas = 73
 
update  personas set identificacion = '9999' where  tipo_identificacion = 1 and identificacion = '34611647'

update  personas set identificacion = '9999' where  tipo_identificacion = 2  and id_personas = 73

delete from personas where id_personas = 98

SET FOREIGN_KEY_CHECKS = 1;

select * from pass where id_docente = 80
 
commit 
 
select * from personas WHERE  id_personas in (73)


select * from calificaciones_2025 where id_docente in  (106,105)

select * from imcreati_data.docentes  where id_docente in  (105)

select * from matricula_docente md where id_docente in  (98)

select * from u_docentes ud where ud.id_docente = 105

SELECT * from personas p where p.u_docentes = 105

UPDATE  personas set u_docentes = 106 WHERE id_personas = 1444

DROP TABLE IF EXISTS `u_alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `u_alumnos` (
  `id_alumnos` int(11) NOT NULL AUTO_INCREMENT,
  `id_personas` int(11) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id_alumnos`),
  KEY `id_personas` (`id_personas`),
  CONSTRAINT `u_alumnos_ibfk_1` FOREIGN KEY (`id_personas`) REFERENCES `personas` (`id_personas`)
) ENGINE=InnoDB AUTO_INCREMENT=1467 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;



CREATE TABLE `u_docentes` (
  `id_docentes` int(11) NOT NULL AUTO_INCREMENT,
  `id_personas` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `materias` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_docentes`),
  KEY `id_personas` (`id_personas`),
  CONSTRAINT `u_docentes_ibfk_1` FOREIGN KEY (`id_personas`) REFERENCES `personas` (`id_personas`)
) ENGINE=InnoDB AUTO_INCREMENT=196 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


describe u_docentes;

describe u_alumnos;

insert into u_docentes 
SELECT u_docentes, id_personas, now(), null, null, null, null from personas where u_docentes > 0;

insert into u_alumnos 
SELECT u_alumnos, id_personas, now() from personas p where p.u_alumnos > 0

 ALTER TABLE u_alumnos  AUTO_INCREMENT = 1568;
 
 
 CREATE TABLE IF NOT EXISTS login (
    id_personas INT NOT NULL,
    identificacion BIGINT NOT NULL,
    pass VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_personas),
    UNIQUE KEY (identificacion),
    FOREIGN KEY (id_personas) REFERENCES personas(id_personas) ON DELETE CASCADE
);



select admin from u_docentes where id_personas = 2

SELECT ud.id_docente, ud.admin, p.nombres, p.apellidos, p.identificacion, ud.login, ud.fecha, p.celular, p.correo, p.i_correo, ud.materias FROM u_docentes ud INNER JOIN personas p ON ud.id_personas = p.id_personas  WHERE ud.id_docente = 2;


SELECT * FROM u_docentes ud INNER JOIN personas p ON ud.id_personas = p.id_personas  WHERE ud.id_docentes = 2;


select id_docente,identificacion, login, nombres, apellidos from u_docentes ud 
inner join personas p on ud.id_personas  = p.id_personas
where id_docente in (   select distinct id_docente from matricula_docente where year = 2026)   and admin= null



ALTER TABLE imcreati_data.calificaciones_2026
ADD UNIQUE KEY unique_nota (id_alumno, id_materia, id_semana, year, id_logro);



select count(*) from calificaciones_2026 where year = 2026 and id_semana = 1 and id_materia = 1 and id_alumno in 
(SELECT id_alumno from matricula WHERE id_grado = 14)


select * from calificaciones_2026_original co  where id not in ( select id from calificaciones_2026) and periodo = 1 and id > 0 and id_semana in (3,4)

select * from calificaciones_2026 where 
id_alumno = 1128
-- id_alumno in (select id_alumno  from matricula m WHERE m.id_grado = 3) 
and id_materia  = 1
and id_semana = 4


SELECT * from calificaciones_2026 where id_alumno in (
SELECT id_alumno FROM matricula where id_grado in (7,8,9) and year = 2026)


describe calificaciones_2026;

-- crear tabla para lojar las notas de una materia en una sola fila

-- se debe agregar una columna por cada ponderado en cada semana del curso
-- existen diez ponderados de acuerdo a tal tabla
-- ponderado

describe ponderado;


select * from ponderado;

-+-------------+
| id_ponderado | ponderado              | valor | tipo | por_periodo |
+--------------+------------------------+-------+------+-------------+
|            1 | evaluación de proceso  |   2.5 | A    |           7 |
|            2 | actividad              |   1.7 | B    |           7 |
|            3 | taller                 |   1.7 | C    |           7 |
|            4 | tarea                  |   1.7 | D    |           7 |
|            5 | presentacion personal  |     1 | E    |           8 |
|            6 | actitud                |     1 | F    |           8 |
|            7 | asistencia             |     1 | G    |           8 |
|            8 | quiz                   |     8 | H    |           1 |
|            9 | evaluación final       |   9.5 | I    |           1 |
|           10 | auto evaluación        |   5.3 | J    |           1 |
+--------------+------------------------+-------+------+-------------+


ALTER TABLE calificaciones_2026
drop COLUMN 1C


ALTER TABLE calificaciones_2026
ADD COLUMN 1A double default null,
ADD COLUMN 1B double default null,
ADD COLUMN 1C double default null,
ADD COLUMN 1D double default null,
ADD COLUMN 1E double default null,
ADD COLUMN 1F double default null,
ADD COLUMN 1G double default null,

ADD COLUMN 2A double default null,
ADD COLUMN 2B double default null,
ADD COLUMN 2C double default null,
ADD COLUMN 2D double default null,
ADD COLUMN 2E double default null,
ADD COLUMN 2F double default null,
ADD COLUMN 2G double default null,

ADD COLUMN 3A double default null,
ADD COLUMN 3B double default null,
ADD COLUMN 3C double default null,
ADD COLUMN 3D double default null,
ADD COLUMN 3E double default null,
ADD COLUMN 3F double default null,
ADD COLUMN 3G double default null,

ADD COLUMN 4A double default null,
ADD COLUMN 4B double default null,
ADD COLUMN 4C double default null,
ADD COLUMN 4D double default null,
ADD COLUMN 4E double default null,
ADD COLUMN 4F double default null,
ADD COLUMN 4G double default null,
ADD COLUMN 4H double default null,


ADD COLUMN 5A double default null,
ADD COLUMN 5B double default null,
ADD COLUMN 5C double default null,
ADD COLUMN 5D double default null,
ADD COLUMN 5E double default null,
ADD COLUMN 5F double default null,
ADD COLUMN 5G double default null,


ADD COLUMN 6A double default null,
ADD COLUMN 6B double default null,
ADD COLUMN 6C double default null,
ADD COLUMN 6D double default null,
ADD COLUMN 6E double default null,
ADD COLUMN 6F double default null,
ADD COLUMN 6G double default null,

ADD COLUMN 7A double default null,
ADD COLUMN 7B double default null,
ADD COLUMN 7C double default null,
ADD COLUMN 7D double default null,
ADD COLUMN 7E double default null,
ADD COLUMN 7F double default null,
ADD COLUMN 7G double default null,


ADD COLUMN 8E double default null,
ADD COLUMN 8F double default null,
ADD COLUMN 8G double default null,
ADD COLUMN 8H double default null,
ADD COLUMN 8I double default null,
ADD COLUMN 8J double default null;


describe calificaciones_2026;

DELETE from c

select * from c

-- nueva tabla de calificaciones
describe c;


select 
CASE when c.id_ponderado = 1 and c.id_semana = 1 then max(c.nota)  END as 1A, 
CASE when c.id_ponderado = 2 and c.id_semana = 1 then max(c.nota)  END as 1B,
CASE when c.id_ponderado = 3 and c.id_semana = 1 then max(c.nota)  END as 1C,
CASE when c.id_ponderado = 4 and c.id_semana = 1 then max(c.nota)  END as 1D,
CASE when c.id_ponderado = 5 and c.id_semana = 1 then max(c.nota)  END AS 1E,
CASE when c.id_ponderado = 6 and c.id_semana = 1 then max(c.nota)  END as 1F,
CASE when c.id_ponderado = 7 and c.id_semana = 1 then max(c.nota)  END as 1G,
c.id_alumno, c.id_materia, c.periodo  -- , c.id_ponderado , c.id_semana   
from calificaciones_2026 c 
group by c.id_alumno , c.id_materia , c.periodo 
-- where c.periodo  = 1
order by c.periodo , c.id_alumno , c.id_materia  



select max(CASE WHEN id_semana = 1 AND id_ponderado = 20 THEN nota END) AS `D1`, id_alumno , id_materia , periodo
from calificaciones_2026 c 
-- where c.id_semana = 1 and   c.id_ponderado = 20  -- and c.id_alumno = 255
-- and id_alumno > 0
GROUP BY id_alumno, id_materia, periodo
order by id_alumno, periodo, id_materia ;



UPDATE  calificaciones_2026 set id_ponderado = 20 
where id_materia = 20

-- Seleccionar los datos de la tabla 


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
    MAX(CASE WHEN id_logro > 0 THEN id_logro END) AS `l1_p1`,
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
    
FROM imcreati_data.calificaciones_2026
where id_alumno > 0
GROUP BY id_alumno, id_materia
order by  id_materia, id_alumno;


-------------------------------------------------------------------------------

commit;

--------------------------------------------------------------------------
delete from calificaciones_2026a where id in ( 
select id from calificaciones_2026b)

select COUNT (*) from calificaciones_2026a ca

select COUNT (*) from calificaciones_2026b cb 

create table calificaciones_2026   ( 
SELECT * from calificaciones_2026a
union all 
SELECT * from calificaciones_2026b 
)

---------------------------------------------------------------------------

-- obtiene las calificaciones de un alumno en una materia
select * from imcreati_datam.c_2026 
where id_alumno = 1472 and id_materia = 24;



select * from calificaciones_2026 c 
where c.id_alumno = 1128 and year = 2026 
and c.id_ponderado = 20 and c.id_materia < 20 -- and c.id_materia > 20


update calificaciones_2026 c set id_ponderado = 1
where c.id_ponderado = 20 and c.id_materia > 20

-- borra todo de la tabla alumnos
delete from imcreati_datam.u_alumnos ;

delete from c_2026 ;
-- borro todos los registros de personas
delete from imcreati_datam.personas ;
-- listado de personas
select * from imcreati_datam.personas p ORDER by id_personas  desc


-- eliminar nombre y apellidos duplicados de personas
DELETE p1 
FROM personas p1
INNER JOIN personas p2 
WHERE p1.id_personas > p2.id_personas 
  AND p1.nombres = p2.nombres 
  AND p1.apellidos = p2.apellidos;

select * from personas where u_docentes  = (select max(u_docentes ) from personas)  ;



-- actualizar login 

UPDATE u_docentes ud
JOIN docentes d ON ud.id_docente = d.id_docente
SET ud.login = d.login;


-- borrar tabla login
delete from login ;

-- cargar los password
INSERT  into login 
select p.id_personas , p.identificacion , tp.pass  
from personas p inner join tmp_pass tp  
on p.u_docentes = tp.id_docente ;

select u_doce
SELECT id_personas, identificacion, pass FROM login WHERE identificacion = 10498784

SELECT ud.id_docente, ud.admin, p.nombres, p.apellidos, p.identificacion, ud.login, ud.fecha, p.celular, p.correo, p.i_correo, ud.materias 
                  FROM u_docentes ud 
                  INNER JOIN personas p ON ud.id_personas = p.id_personas 
WHERE p.identificacion = 10498784

ALTER TABLE matricula ADD COLUMN fecha DATE;



ALTER TABLE imcreati_datam.personas  AUTO_INCREMENT = 1432;

CREATE TABLE `madres` (
  `id_padres` int(11) NOT NULL AUTO_INCREMENT,
  `id_personas` int(11) DEFAULT NULL,
  `id_hijo` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id_padres`),
  KEY `padres_id_padres_IDX` (`id_padres`) USING BTREE
) ENGINE=InnoDB


select * from imcreati_datam.personas p where id_personas = 1142 -- nombres like '%pepita%'

select * from padres p 

select id_personas  from padres where id_hijo in (select id_personas  from personas where u_alumnos = 1604)



SELECT p.id_personas FROM padres p
                      INNER JOIN u_alumnos ua ON p.id_hijo = ua.id_personas
                      WHERE ua.id_alumnos = 1604

                      
                      -- verficar matricula                      
select * from matricula mt inner join u_alumnos ua  
on mt.id_alumno = ua.id_alumnos inner join personas p on p.id_personas  = ua.id_personas 
WHERE  mt.id = 3574

-- obtener el listado de estudiantes
-- de un grado


select * from imcreati_datam.matricula m where id_grado = 1 and m.`year` = 2026 and m.id_curso = 0 and m.id_jornada =1


SELECT u_alumnos, nombres, apellidos
              FROM personas
              WHERE u_alumnos IN (1295,1003,1291,1470,1300,1302,1513,1514,1515,1516,1329,1517,1567,1599,1601,1605,1599,1599,1599,1599)


SELECT c.id_alumno, c.id_materia, l.logro
              FROM c_2026 c
              INNER JOIN logros l ON l.id_logro = c.l1_p3
              WHERE c.id_alumno IN (1194,1364,1365,1366,851,1167,1368,852,1369,853,854,855,857,1058,1050,1051,1188,671,1501,1502,1053,1184,1503,1600,1599,1599,1599)
                AND c.id_materia IN (7,8,9,10,11,12,20,18,16,19,17,4,6,1,2,3,14)
                AND c.l1_p3








