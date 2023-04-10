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

-- cuantas calificaciones debe realizar un docente matricualado en un año y en un a semana 

select * from matricula_docente where year = 2023


-- cantidad de esudiantes matriculados por grado
select cantidad, grado, id_escolaridad from grados g  inner join 
( select count(*) as cantidad , id_grado  from matricula where year = 2023
group by id_grado  ) c on c.id_grado = g.id_grado order by id_escolaridad, grado

select id_escolaridad from grados

CREATE TABLE semanas (
id_semana int(3) PRIMARY KEY NOT NULL AUTO_INCREMENT,
semana  int(2) NOT NULL,
inicio double,
fin double,
year varchar(4),
notas_por_alumuno int(2)
);

insert into semanas (semana, year , notas_por_alumuno)
values (1, '2023',7) , (2, '2023',7), (3, '2023',7),(4, '2023',8),  (5, '2023',7), (6, '2023',7), (7, '2023',7),  (8, '2023',5);
insert into semanas (semana, year , notas_por_alumuno)
values (9, '2023',7) , (10, '2023',7), (11, '2023',7),(12, '2023',8),  (13, '2023',7), (14, '2023',7), (15, '2023',7),  (16, '2023',5);
insert into semanas (semana, year , notas_por_alumuno)
values (17, '2023',7) , (18, '2023',7), (19, '2023',7),(20, '2023',8),  (21, '2023',7), (22, '2023',7), (23, '2023',7),  (24, '2023',5);
insert into semanas (semana, year , notas_por_alumuno)
values (25, '2023',7) , (26, '2023',7), (27, '2023',7),(28, '2023',8),  (29, '2023',7), (30, '2023',7), (31, '2023',7),  (32, '2023',5);

-- select * from semanas

-- drop table semanas





