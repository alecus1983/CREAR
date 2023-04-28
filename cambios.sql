-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 24, 2023 at 10:31 PM
-- Server version: 5.7.41
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imcreati_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(20) NOT NULL,
  `mes` int(2) NOT NULL,
  `year` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `id_matricula` int(20) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE pagos CHANGE id_pago id_pago INT(20)AUTO_INCREMENT ;


select count(*) from pagos where id_matricula = 2 and mes = 4 and year = 2022

select id from matricula where year = 2022

-- cambios en la tabla matricula docente
ALTER TABLE matricula_docente ADD id_curso INT(11) NOT NULL AFTER id_grado;
-- cambio id_curso
ALTER TABLE curso ADD PRIMARY KEY (id_curso)
-- cambios en la tabla de matricula

ALTER TABLE matricula  ADD id_curso INT(11) NOT NULL AFTER id_grado;

describe curso


select * from matricula_docente

select * from alumnos

show tables

describe matricula_docente

select * from matricula



ALTER TABLE calificaciones ADD id_semana int(11) NOT NULL AFTER serie;

ALTER TABLE calificaciones ADD id_ponderado int(11) NOT NULL AFTER serie;

describe calificaciones

CREATE TABLE ponderado
(id_ponderado int(11) PRIMARY KEY NOT NULL,
ponderado varchar(2) NOT NULL,
valor double
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

describe ponderado;

CREATE TABLE semana
(id_semana int(11) PRIMARY KEY NOT NULL,
year varchar(4) NOT NULL,
semana int(2) NOT NULL,
inicio date,
limite date
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

describe semana;

ALTER TABLE matricula ADD id_curso int(11) DEFAULT 1;

SELECT * FROM matricula;
-- consulta en la tabla de semanas
select * from semana;

describe semana;

show tables;

ALTER TABLE semana ADD inicio date AFTER semana;

describe  matricula;
-- consulta para extraer el listado de estudiantes
select * from matricula where year = '2022' and id_grado = 1 and id_curso = 0
-- actualizar el curso en la tabla matriculas ,  0 por defecto
update matricula set id_curso = 0

commit
-- consulta para revisar los cursos activos
select * from curso
-- crear los valores iniciales de la tabla cursos
insert into curso (id_curso, curso, activo) values (0,'A',1);
insert into curso (id_curso, curso, activo) values (1,'B',1);

select * from matricula where year = 2022 and id_grado= 10

--and id_curso =0

describe matricula_docente

select * from  matricula_docente where year = '2022'; --and id_docente = 26

select * from docentes;

describe docentes;


SELECT DISTINCT G.id_grado, G.grado, D.id_materia FROM grados G INNER JOIN matricula_docente D ON G.id_grado = D.id_grado  WHERE D.year = '2022' AND  D.id_docente = 67

SELECT DISTINCT G.id_grado, G.grado FROM grados G INNER JOIN matricula_docente D ON G.id_grado = D.id_grado  WHERE D.year = '2022' AND  D.id_docente = 26



select * from calificaciones where year = 2023 and id_alumno = 2 and id_materia = 1 and id_semana and id_periodo

describe calificaciones

describe ponderado

alter table ponderado modify ponderado varchar(50)

insert into ponderado (id_ponderado, ponderado, valor) values (1, 'evaluación de proceso',2.5);
insert into ponderado (id_ponderado, ponderado, valor) values (2, 'actividad',1.7);
insert into ponderado (id_ponderado, ponderado, valor) values (3, 'taller',1.7);
insert into ponderado (id_ponderado, ponderado, valor) values (4, 'tarea',1.7);
insert into ponderado (id_ponderado, ponderado, valor) values (5, 'presentacion personal',1.0);
insert into ponderado (id_ponderado, ponderado, valor) values (6, 'actitud',1.0);
insert into ponderado (id_ponderado, ponderado, valor) values (7, 'asistencia',1.0);
insert into ponderado (id_ponderado, ponderado, valor) values (8, 'quiz',8);
insert into ponderado (id_ponderado, ponderado, valor) values (9, 'evaluación final',9.5);
insert into ponderado (id_ponderado, ponderado, valor) values (10, 'auto evaluación',5.3);

select * from ponderado

alter table ponderado add tipo varchar(2) not null

update ponderado set tipo = "A" where id_ponderado = 1;
update ponderado set tipo = "B" where id_ponderado = 2;
update ponderado set tipo = "C" where id_ponderado = 3;
update ponderado set tipo = "D" where id_ponderado = 4;
update ponderado set tipo = "E" where id_ponderado = 5;
update ponderado set tipo = "F" where id_ponderado = 6;
update ponderado set tipo = "G" where id_ponderado = 7;
update ponderado set tipo = "H" where id_ponderado = 8;
update ponderado set tipo = "I" where id_ponderado = 9;
update ponderado set tipo = "J" where id_ponderado = 10;

select id_curso from calificaciones where year = 2023

--and id_alumno = 440 -- and id_materia = 1 -- and id_ponderado = 1 and id_semana = 1

alter table calificaciones modify modificado datetime;

insert into calificaciones (id_alumno,id_materia, nota,id_docente,periodo,year,modificado,id_ponderado,id_semana) values(1,1,5,1,1,2050,NOW(),1,1)

alter table calificaciones change id  id int(18) unsigned  not null auto_increment primary key;


alter table calificaciones modify id_logro int(11)  default null;

alter table calificaciones modify faltas int(11)  default null;
alter table calificaciones modify corte varchar(1)  default null;
alter table calificaciones modify limite date  default null;
alter table calificaciones modify own int(11)  default null;
alter table calificaciones modify serie int(11)  default null;
alter table calificaciones modify id_ponderado int(11)  default null;
alter table calificaciones modify id_semana int(11)  default null;

select id_alumno, id_materia from calificaciones where year = 2023;



select c1.id_alumno, nota, id_materia, id_ponderado, g.id_grado,g.grado from grados g inner join
(select c.id_alumno, nota, id_materia, id_ponderado, id_grado from  matricula m inner join 
(select id_alumno, nota, id_materia, id_ponderado from calificaciones where year = 2023) c
on m.id_alumno = c.id_alumno) c1 on g.id_grado = c1.id_grado
order by id_grado, id_materia, c1.id_alumno;


select id_alumno, nota, id_materia, id_ponderado from calificaciones where  year = 2023
order  by id_alumno, id_ponderado;


select * from matricula where id_alumno = 984 and year = 2023;

delete  from calificaciones where  year = 2023;


--- consulta que interroga la cantidad de notas calificadas por un  docenten en 
-- Una semana
-- un año
-- docente 
-- notas mayores a cero

SELECT  COUNT(*) as   cantidad  from calificaciones WHERE id_alumno in
(SELECT id_alumno from matricula WHERE year = 2023 ) and year = 2023  
 and id_materia in 
 ( SELECT id_materia FROM matricula_docente  WHERE id_docente = 86  and year = 2023) 
 and nota > 0
 
  ma.id_materia, md.id_grado, md.id_jornada, md.id_docente, ma.id_alumno
 
 SELECT  ma.id_materia, md.id_grado, md.id_jornada, md.id_docente, ma.id_alumno
 from matricula_docente md inner join 
 (select c.id_alumno, c.id_materia, id_ponderado, id_semana, nota  id_grado,m.id_curso , m.id_jornada  from calificaciones c inner join matricula m 
 on c.id_alumno = m.id_alumno and c.year = m.year) ma
 on md.id_grado = ma.id_grado and md.id_curso = ma.id_curso and md.id_jornada = ma.id_jornada
 where md.id_docente = 86 and md.`year` = 2023
 order by id_grado, id_jornada , id_materia, id_alumno
 

truncate TABLE calificaciones;

SELECT * from calificaciones c ;

-- cantidad de calificaciones que deberia haber realizado en 
-- Una semana
-- un año
-- de un total de 55 por alumno

-- alumnos por clase atendidos por el docente
select md.id_grado , md.id_materia, md.id_curso, md.id_jornada, id_docente , mt.id_alumno from matricula_docente md 
inner join 
-- cantida de estudiantes por grado curso en un año
(SELECT id_grado , id_curso, id_jornada, id_alumno from matricula m WHERE  `year` = 2023) mt
on md.id_grado  = mt.id_grado and md.id_curso = mt.id_curso and md.id_jornada = mt.id_jornada
WHERE id_docente = 86  and md.year = 2023
order by md.id_grado , md.id_curso, md.id_jornada, id_alumno  

-- cantidad de notas por un docente 
select count(*) *55 from matricula_docente md 
inner join 
-- cantida de estudiantes por grado curso en un año
(SELECT id_grado , id_curso, id_jornada, id_alumno from matricula m WHERE  `year` = 2023) mt
on md.id_grado  = mt.id_grado and md.id_curso = mt.id_curso and md.id_jornada = mt.id_jornada
WHERE id_docente = 86  and md.year = 2023
order by md.id_grado , md.id_curso, md.id_jornada, id_alumno
=======
-- cuantas calificaciones debe realizar un docente matricualado en un año y en un a semana 

select * from matricula_docente where year = 2023


-- cantidad de esudiantes matriculados por grado
select cantidad, grado, id_escolaridad, g.id_grado, id_jornada, id_curso from grados g  inner join 
( select count(*) as cantidad , id_grado, id_jornada, id_curso  from matricula where year = 2023
group by id_jornada, id_grado, id_curso  ) c on c.id_grado = g.id_grado
order by  id_escolaridad, grado

-- cantidad de notas que debe ingresar un docente en una semana
select md.id_docente, md.id_grado,  md.id_jornada, md.id_curso, id_materia, cantidad from matricula_docente as  md
inner join
( select cantidad, grado, id_escolaridad, g.id_grado, id_jornada, id_curso from grados g  inner join 
( select count(*) as cantidad , id_grado, id_jornada, id_curso  from matricula where year = 2023
group by id_jornada, id_grado, id_curso  ) c on c.id_grado = g.id_grado order by id_escolaridad, grado
  ) as na on na.id_grado = md.id_grado and  na.id_curso = md.id_curso and na.id_jornada = md.id_jornada
where md.year = 2023
order by md.id_docente, md.id_materia, id_escolaridad, md.id_grado

-- cantidad de notas que debe ingresar un docente en una semana
select sum(cantidad) cantidad, id_docente from (
select md.id_docente, md.id_grado,  md.id_jornada, md.id_curso, id_materia, cantidad from matricula_docente as  md
inner join

( select count(*) as cantidad , id_grado, id_jornada, id_curso  from matricula where year = 2023
group by id_jornada, id_grado, id_curso )


order by md.id_docente, md.id_materia, id_escolaridad, md.id_grado) as cd
group by id_docente order by id_docente

-- cuanto ha calificado el docente por semana

select count(*) cantidad from calificaciones where id_docente = 86 and year = 2023 and id_semana = 1

drop table semanas

CREATE TABLE semanas (
id_semana int(3) PRIMARY KEY NOT NULL AUTO_INCREMENT,
semana  int(2) NOT NULL,
inicio double,
fin double,
year varchar(4),
notas_por_alumno int(2)
);



insert into semanas (semana, year , notas_por_alumno)
values (1, '2023',7) , (2, '2023',7), (3, '2023',7),(4, '2023',8),  (5, '2023',7), (6, '2023',7), (7, '2023',7),  (8, '2023',5);
insert into semanas (semana, year , notas_por_alumno)
values (9, '2023',7) , (10, '2023',7), (11, '2023',7),(12, '2023',8),  (13, '2023',7), (14, '2023',7), (15, '2023',7),  (16, '2023',5);
insert into semanas (semana, year , notas_por_alumno)
values (17, '2023',7) , (18, '2023',7), (19, '2023',7),(20, '2023',8),  (21, '2023',7), (22, '2023',7), (23, '2023',7),  (24, '2023',5);
insert into semanas (semana, year , notas_por_alumno)
values (25, '2023',7) , (26, '2023',7), (27, '2023',7),(28, '2023',8),  (29, '2023',7), (30, '2023',7), (31, '2023',7),  (32, '2023',5);


 select * from semanas


-- drop table semanas

delete from calificaciones where year = 2023

-- cantidad de registros por docente  en el 2023
SELECT  id_docente, COUNT(*) from calificaciones WHERE year = 2023 
GROUP by id_docente order by id_docente



select * from logros

describe logros

show tables

describe semanas

select * from  semana

select * from  semanas

alter table semanas modify inicio date;
alter table semanas modify fin date;

update semanas set inicio = '2023-04-17' where year = 2023 and semana = 10;
update semanas set fin = '2023-04-24' where year = 2023 and semana = 10;


update semanas set inicio = '2023-04-24' where year = 2023 and semana = 11;
update semanas set fin = '2023-05-01' where year = 2023 and semana = 11;
alter table semanas add id_periodo int(1) not null;
update semanas set  id_periodo = 1 where semana < 9;
update semanas set  id_periodo = 2 where semana < 17 and semana > 8 ;
update semanas set  id_periodo = 3 where semana < 25 and semana > 16 ;
update semanas set  id_periodo = 4 where semana > 24 ;


-- consulta que obtiene la semana actual a calificar
select semana from semanas where year = 2023 and inicio < NOW() and fin > NOW() order by semana asc;

select id_periodo from semanas where year = 2023 and inicio < NOW() and fin > NOW() order by semana asc;

select * from semanas;

select * from ponderado;

alter table ponderado add por_periodo int(2);

update ponderado set por_periodo = 7 where id_ponderado = 1;
update ponderado set por_periodo = 7 where id_ponderado = 2;
update ponderado set por_periodo = 7 where id_ponderado = 3;
update ponderado set por_periodo = 7 where id_ponderado = 4;
update ponderado set por_periodo = 8  where id_ponderado = 5;
update ponderado set por_periodo = 8  where id_ponderado = 6;
update ponderado set por_periodo = 8 where id_ponderado = 7;
update ponderado set por_periodo = 1  where id_ponderado = 8;
update ponderado set por_periodo = 1 where id_ponderado = 9;
update ponderado set por_periodo = 1 where id_ponderado = 10;


select id, id_alumno, id_materia, nota, id_semana, id_ponderado, periodo from calificaciones where id_alumno = 1128 and id_materia = 4 and year = 2023 and periodo = 1;


-- ponderados 
select p.id_ponderado, ponderado, por_periodo, cantidad from ponderado as p inner join
(select id_ponderado, count(*)  as cantidad from calificaciones where id_alumno = 947 and id_materia = 4 and year = 2023 and periodo = 1
group by id_ponderado order by id_ponderado) as c on p.id_ponderado = c.id_ponderado
order by id_ponderado



select *  from alumnos where  id_alumno = 1088

select id,  id_ponderado from calificaciones where year = 2023 and id_materia = 20 and corte = 'H';

delete from calificaciones where corte = 'H';

select * from materia where id_materia = 20;

describe calificaciones;

-- iserto las calificacioes resumidas
insert into calificaciones (id_alumno,id_materia,nota,id_docente, id_semana,year, periodo, corte, id_ponderado)
select id_alumno, id_materia,avg(nota) nota, id_docente, id_semana, year,periodo, 'H',0
from calificaciones where year = 2023 and id_materia = 20
group by id_alumno,id_materia,id_docente,id_semana, periodo
order by id_alumno, id_semana;


-- dividir la nota mayores a 5 por 10
update calificaciones set nota = nota /10 where id in
(select id  from calificaciones where  id_materia = 20 and year = 2023 and nota > 5);

-- actualizar errores en el periodo
UPDATE calificaciones SET periodo = 1 where id_semana <9 and id_semana > 0 and periodo = 2 and year = 2023; 

select id_alumno, id, nota, id_ponderado, id_materia, id_semana, year from calificaciones where year = 2023 and id_materia = 20 and id_ponderado = 0 and id_semana = 1 and nota > 0

select * from matricula  where id_alumno = 1138 and year = 2023;
select * from grados where id_grado = 6;

select id_semana, nota,id_ponderado from  calificaciones where id_alumno = 1091 and year = 2023 and id_materia = 20;

delete from  calificaciones where id_alumno = 1091 and year = 2023 and id_materia = 20;

select id_alumno, id, nota, id_ponderado, id_materia, id_semana, year from calificaciones where year = 2023 and id_alumno = 1091 and id_materia = 20 and id_ponderado = 0 and id_semana = 1;


 SELECT id from calificaciones where year = 2023 and periodo = 1 and nota > 5 and nota <51 and id_ponderado = 2