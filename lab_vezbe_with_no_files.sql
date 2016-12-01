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
(1, 'admin', '3a63b18fbcc415f5f7afd258919195d6', 'admin@mejl.rs', NULL);

-- ----------------------------

CREATE TABLE `fajlovi` (
  `fajl_id` int(11) NOT NULL,
  `materijal_id` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL,
  `tip` varchar(50) NOT NULL,
  `velicina` bigint(20) NOT NULL,
  `sadrzaj` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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
(1, 1, 1, 105),
(2, 2, 1, 105),
(3, 3, 1, 107),
(4, 4, 1, 501),
(5, 5, 2, 401),
(6, 6, 1, 407),
(7, 7, 1, 203),
(9, 9, 2, 102),
(11, 11, 2, 108);

-- --------------------------------------------------------

--
-- Table structure for table `lab_vezba`
--

CREATE TABLE `lab_vezba` (
  `lab_vezba_id` int(11) NOT NULL,
  `saradnik_id` int(11) NOT NULL,
  `predmet_id` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL,
  `opis` varchar(255) DEFAULT NULL,
  `datum_odrzavanja` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lab_vezba`
--

INSERT INTO `lab_vezba` (`lab_vezba_id`, `saradnik_id`, `predmet_id`, `naziv`, `opis`, `datum_odrzavanja`) VALUES
(1, 1, 2, 'Вежба 1', 'Прва вежба из ПВА', '2012-12-12 12:12:00'),
(2, 1, 2, 'Вежба 2', 'проба', '2016-09-02 15:30:00'),
(3, 1, 1, 'Вежба 1 ', 'проба', '2016-09-04 12:30:00'),
(4, 1, 2, 'Вежба 3', 'проба', '2016-09-06 16:00:00'),
(5, 2, 1, 'Вежба 2', '2. из Мате 1', '2016-09-03 12:12:00'),
(6, 1, 1, 'Вежба 3', 'Трећа вежба из Математике 1', '2016-09-09 15:45:00'),
(7, 1, 2, 'Вежба 4', 'Четврта вежба из ПВА', '2016-09-12 12:00:00'),
(9, 2, 1, 'Вежба 4', 'Четврта вежба из Мате ', '2016-09-14 12:00:00'),
(11, 2, 3, 'Додао админ', 'додао админ', '2016-09-16 12:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `materijal`
--

CREATE TABLE `materijal` (
  `materijal_id` int(11) NOT NULL,
  `lab_vezba_id` int(11) NOT NULL,
  `opis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `materijal`
--

INSERT INTO `materijal` (`materijal_id`, `lab_vezba_id`, `opis`) VALUES
(1, 1, 'Прва вежба из ПВА'),
(2, 2, 'проба'),
(3, 3, 'проба'),
(4, 4, 'проба'),
(5, 5, '2. из Мате 1'),
(7, 2, NULL),
(9, 3, NULL),
(11, 6, 'Трећа вежба из '),
(12, 7, 'Четврта вежба из'),
(14, 9, 'Четврта вежба из Мате '),
(18, 9, 'Четврта вежба из Мате '),
(20, 9, NULL),
(23, 11, 'додао админ');

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
(1, 'Математика 1', 'Предмет прве године'),
(2, 'Програмирање Веб \r\n\r\nапликација', 'Опис пр. ПВА'),
(3, 'Објектно орјентисано пројектовање', 'Опис предмета ООП'),
(4, 'Комуникациони системи', 'Предмет Комуникациони системи(Телекомуникације)');

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
(1, 1),
(1, 2),
(2, 1),
(2, 3),
(2, 4);

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
  `slika_url` varchar(255) DEFAULT 'https://cdn1.iconfinder.com/data/icons/flat-business-icons/128/user-128.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `saradnik`
--

INSERT INTO `saradnik` (`saradnik_id`, `ime_prezime`, `kor_ime`, `lozinka`, `e_mail`, `opis`, `status`, `slika_url`) VALUES
(1, 'Петар Петровић', 'petarp123', '4e949f2693a613ad66809402729ed1a0', 'petarp@mejl.rs', 'Први сарадник!', 'aktiviran', 'https://cdn1.iconfinder.com/data/icons/user-pictures/101/malecostume-512.png'),
(2, 'Радоје Богдановић', 'radoje', '5a5484a862076fb231309a4827de375a', 'radoje@mejl.rs', '-', 'aktiviran', 'https://cdn1.iconfinder.com/data/icons/flat-business-icons/128/user-128.png'),
(3, '', '', '', '', '', 'deaktiviran', '');

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
-- Indexes for table `fajlovi`
--
ALTER TABLE `fajlovi`
  ADD PRIMARY KEY (`fajl_id`,`materijal_id`);

--
-- Indexes for table `laboratorija`
--
ALTER TABLE `laboratorija`
  ADD PRIMARY KEY (`lab_id`,`lab_vezba_id`);

--
-- Indexes for table `lab_vezba`
--
ALTER TABLE `lab_vezba`
  ADD PRIMARY KEY (`lab_vezba_id`,`saradnik_id`,`predmet_id`),
  ADD UNIQUE KEY `lab_vezba_id_UNIQUE` (`lab_vezba_id`);

--
-- Indexes for table `materijal`
--
ALTER TABLE `materijal`
  ADD PRIMARY KEY (`materijal_id`);

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
  ADD PRIMARY KEY (`saradnik_id`,`predmet_id`);

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
-- AUTO_INCREMENT for table `fajlovi`
--
ALTER TABLE `fajlovi`
  MODIFY `fajl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `laboratorija`
--
ALTER TABLE `laboratorija`
  MODIFY `lab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `lab_vezba`
--
ALTER TABLE `lab_vezba`
  MODIFY `lab_vezba_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `materijal`
--
ALTER TABLE `materijal`
  MODIFY `materijal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `predmet`
--
ALTER TABLE `predmet`
  MODIFY `predmet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `saradnik`
--
ALTER TABLE `saradnik`
  MODIFY `saradnik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
