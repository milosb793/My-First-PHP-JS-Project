-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 06, 2016 at 09:35 PM
-- Server version: 5.7.13-0ubuntu0.16.04.2
-- PHP Version: 7.0.8-0ubuntu0.16.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lab_vezbe`
--
CREATE DATABASE IF NOT EXISTS `lab_vezbe` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `lab_vezbe`;

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `admin_id` int(11) NOT NULL,
  `kor_ime` varchar(255) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `e_mail` varchar(255) NOT NULL,
  `kreator_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`admin_id`, `kor_ime`, `lozinka`, `e_mail`, `kreator_id`) VALUES
(1, 'admin', 'password', 'admin@mejl.rs', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `laboratorija`
--

CREATE TABLE `laboratorija` (
  `lab_id` int(11) NOT NULL,
  `lab_vezba_id` int(11) NOT NULL,
  `saradnik_id` int(11) NOT NULL,
  `broj_lab` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `laboratorija`
--

INSERT INTO `laboratorija` (`lab_id`, `lab_vezba_id`, `saradnik_id`, `broj_lab`) VALUES
(0, 1, 1, 409);

-- --------------------------------------------------------

--
-- Table structure for table `lab_vezba`
--

CREATE TABLE `lab_vezba` (
  `lab_vezba_id` int(11) NOT NULL,
  `saradnik_id` int(11) NOT NULL,
  `opis` varchar(255) DEFAULT NULL,
  `datum_odrzavanja` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lab_vezba`
--

INSERT INTO `lab_vezba` (`lab_vezba_id`, `saradnik_id`, `opis`, `datum_odrzavanja`) VALUES
(1, 1, 'Прва лаб. вежба из Мат. 1', '2016-06-29 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `materijal`
--

CREATE TABLE `materijal` (
  `materijal_id` int(11) NOT NULL,
  `lab_vezba_id` int(11) NOT NULL,
  `opis` varchar(255) DEFAULT NULL,
  `materijal` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `materijal`
--

INSERT INTO `materijal` (`materijal_id`, `lab_vezba_id`, `opis`, `materijal`) VALUES
(1, 1, 'Први пдф. за прву вежбу из Мат. 1', '//');

-- --------------------------------------------------------

--
-- Table structure for table `predmet`
--

CREATE TABLE `predmet` (
  `predmet_id` int(11) NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `opis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `predmet`
--

INSERT INTO `predmet` (`predmet_id`, `naziv`, `opis`) VALUES
(1, 'Математика 1', 'Предмет прве године');

-- --------------------------------------------------------

--
-- Table structure for table `predmet_saradnik`
--

CREATE TABLE `predmet_saradnik` (
  `saradnik_id` int(11) NOT NULL,
  `predmet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `predmet_saradnik`
--

INSERT INTO `predmet_saradnik` (`saradnik_id`, `predmet_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `predmet_vezba`
--

CREATE TABLE `predmet_vezba` (
  `lab_vezba_id` int(11) NOT NULL,
  `predmet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `predmet_vezba`
--

INSERT INTO `predmet_vezba` (`lab_vezba_id`, `predmet_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `saradnik`
--

CREATE TABLE `saradnik` (
  `saradnik_id` int(11) NOT NULL,
  `ime_prezime` varchar(255) NOT NULL,
  `kor_ime` varchar(255) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `e_mail` varchar(255) NOT NULL,
  `opis` varchar(255) DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'aktiviran',
  `slika_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `saradnik`
--

INSERT INTO `saradnik` (`saradnik_id`, `ime_prezime`, `kor_ime`, `lozinka`, `e_mail`, `opis`, `status`, `slika_url`) VALUES
(1, 'Петар Петровић', 'petarp123', 'petars', 'petarp@mejl.rs', 'Први сарадник, сарадник на предмету Математика 1', 'aktiviran', 'https://cdn1.iconfinder.com/data/icons/user-pictures/101/malecostume-512.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_id_UNIQUE` (`admin_id`),
  ADD UNIQUE KEY `e_mail_UNIQUE` (`e_mail`);

--
-- Indexes for table `laboratorija`
--
ALTER TABLE `laboratorija`
  ADD PRIMARY KEY (`lab_id`,`lab_vezba_id`,`saradnik_id`),
  ADD KEY `lab_vezba_id_idx` (`lab_vezba_id`),
  ADD KEY `saradnik_id_idx` (`saradnik_id`);

--
-- Indexes for table `lab_vezba`
--
ALTER TABLE `lab_vezba`
  ADD PRIMARY KEY (`lab_vezba_id`,`saradnik_id`),
  ADD UNIQUE KEY `lab_vezba_id_UNIQUE` (`lab_vezba_id`);

--
-- Indexes for table `materijal`
--
ALTER TABLE `materijal`
  ADD PRIMARY KEY (`materijal_id`,`lab_vezba_id`),
  ADD UNIQUE KEY `materijal_UNIQUE` (`materijal`),
  ADD KEY `lab_vezba_id_idx` (`lab_vezba_id`);

--
-- Indexes for table `predmet`
--
ALTER TABLE `predmet`
  ADD PRIMARY KEY (`predmet_id`),
  ADD UNIQUE KEY `predmet_id_UNIQUE` (`predmet_id`),
  ADD UNIQUE KEY `naziv_UNIQUE` (`naziv`);

--
-- Indexes for table `predmet_saradnik`
--
ALTER TABLE `predmet_saradnik`
  ADD PRIMARY KEY (`saradnik_id`,`predmet_id`),
  ADD KEY `predmet_id_idx` (`predmet_id`);

--
-- Indexes for table `predmet_vezba`
--
ALTER TABLE `predmet_vezba`
  ADD PRIMARY KEY (`lab_vezba_id`,`predmet_id`),
  ADD KEY `predmet_id_idx` (`predmet_id`);

--
-- Indexes for table `saradnik`
--
ALTER TABLE `saradnik`
  ADD PRIMARY KEY (`saradnik_id`),
  ADD UNIQUE KEY `saradnik_id_UNIQUE` (`saradnik_id`),
  ADD UNIQUE KEY `e_mail_UNIQUE` (`e_mail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `lab_vezba`
--
ALTER TABLE `lab_vezba`
  MODIFY `lab_vezba_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `materijal`
--
ALTER TABLE `materijal`
  MODIFY `materijal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `predmet`
--
ALTER TABLE `predmet`
  MODIFY `predmet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `saradnik`
--
ALTER TABLE `saradnik`
  MODIFY `saradnik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `kreator_id_sk` FOREIGN KEY (`admin_id`) REFERENCES `administrator` (`admin_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `laboratorija`
--
ALTER TABLE `laboratorija`
  ADD CONSTRAINT `lab_vezba_id_sk_l` FOREIGN KEY (`lab_vezba_id`) REFERENCES `lab_vezba` (`lab_vezba_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saradnik_id_sk_l` FOREIGN KEY (`saradnik_id`) REFERENCES `saradnik` (`saradnik_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `materijal`
--
ALTER TABLE `materijal`
  ADD CONSTRAINT `lab_vezba_id_sk_m` FOREIGN KEY (`lab_vezba_id`) REFERENCES `lab_vezba` (`lab_vezba_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `predmet_saradnik`
--
ALTER TABLE `predmet_saradnik`
  ADD CONSTRAINT `predmet_id_sk_ps` FOREIGN KEY (`predmet_id`) REFERENCES `predmet` (`predmet_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `saradnik_id_sk_ps` FOREIGN KEY (`saradnik_id`) REFERENCES `saradnik` (`saradnik_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `predmet_vezba`
--
ALTER TABLE `predmet_vezba`
  ADD CONSTRAINT `lab_vezba_id_sk_pv` FOREIGN KEY (`lab_vezba_id`) REFERENCES `lab_vezba` (`lab_vezba_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `predmet_id_sk_pv` FOREIGN KEY (`predmet_id`) REFERENCES `predmet` (`predmet_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
