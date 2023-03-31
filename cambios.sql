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
