-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2019 at 05:08 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentManagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `calificativ`
--

CREATE TABLE `calificativ` (
  `id_calificativ` int(4) NOT NULL,
  `id_student` int(4) NOT NULL,
  `id_disciplina` int(4) NOT NULL,
  `calificativ` varchar(50) COLLATE utf8_romanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discipline`
--

CREATE TABLE `discipline` (
  `id_disciplina` int(4) NOT NULL,
  `nume_disciplina` varchar(50) COLLATE utf8_romanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `studenti`
--

CREATE TABLE `studenti` (
  `id_student` int(4) NOT NULL,
  `nume` varchar(50) COLLATE utf8_romanian_ci NOT NULL,
  `prenume` varchar(50) COLLATE utf8_romanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calificativ`
--
ALTER TABLE `calificativ`
  ADD PRIMARY KEY (`id_calificativ`),
  ADD UNIQUE KEY `id_calificativ` (`id_calificativ`),
  ADD KEY `CalificativStudentForeign` (`id_student`),
  ADD KEY `CalificativDisciplinaForeign` (`id_disciplina`);

--
-- Indexes for table `discipline`
--
ALTER TABLE `discipline`
  ADD PRIMARY KEY (`id_disciplina`),
  ADD UNIQUE KEY `id_disciplina` (`id_disciplina`);

--
-- Indexes for table `studenti`
--
ALTER TABLE `studenti`
  ADD PRIMARY KEY (`id_student`),
  ADD UNIQUE KEY `id_student` (`id_student`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calificativ`
--
ALTER TABLE `calificativ`
  ADD CONSTRAINT `CalificativDisciplinaForeign` FOREIGN KEY (`id_disciplina`) REFERENCES `discipline` (`id_disciplina`),
  ADD CONSTRAINT `CalificativStudentForeign` FOREIGN KEY (`id_student`) REFERENCES `studenti` (`id_student`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
