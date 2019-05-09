-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2019 at 08:27 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `geekchat`
--

-- --------------------------------------------------------

--
-- Table structure for table `audio`
--

CREATE TABLE `audio` (
  `id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `documenti`
--

CREATE TABLE `documenti` (
  `id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `immagini`
--

CREATE TABLE `immagini` (
  `id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messaggi`
--

CREATE TABLE `messaggi` (
  `id` int(11) NOT NULL,
  `testo` varchar(2000) NOT NULL,
  `dataOraInvio` datetime NOT NULL,
  `idReply` int(11) DEFAULT NULL,
  `idUtente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messaggi`
--

INSERT INTO `messaggi` (`id`, `testo`, `dataOraInvio`, `idReply`, `idUtente`) VALUES
(1, 'ciao', '2019-03-25 06:15:15', NULL, 1),
(2, 'bella', '2019-03-25 06:25:25', NULL, 1),
(3, 'li', '2019-04-04 08:00:00', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `posizioni`
--

CREATE TABLE `posizioni` (
  `id` int(11) NOT NULL,
  `lat` float NOT NULL,
  `lon` float NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `risposte`
--

CREATE TABLE `risposte` (
  `id` int(11) NOT NULL,
  `testo` varchar(50) NOT NULL,
  `idSondaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sondaggi`
--

CREATE TABLE `sondaggi` (
  `id` int(11) NOT NULL,
  `quesito` varchar(50) NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `bio` varchar(200) NOT NULL,
  `immagine` varchar(150) DEFAULT NULL,
  `password` varchar(30) NOT NULL,
  `lastAccess` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`id`, `username`, `isAdmin`, `bio`, `immagine`, `password`, `lastAccess`) VALUES
(1, 'pippo', 0, 'nope', 'nope', 'nope', '0000-00-00 00:00:00'),
(2, 'pegaso', 0, 'wiiiiiii', NULL, 'wipegasowi', '2019-04-11 11:11:11'),
(6, 'ottobell', 1, 'mi piacciono i pesci rossi', NULL, 'supaidaman', '2019-04-10 09:13:48'),
(9, 'MarchiINE', 0, 'IANE u know?', NULL, 'alexander', '2019-04-15 08:00:00'),
(10, 'pescaca', 1, 'nope', NULL, 'nope', '0000-00-00 00:00:00'),
(11, 'polastro', 1, 'pololoco polastro', NULL, 'peopeo', '2019-04-04 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `votazioni`
--

CREATE TABLE `votazioni` (
  `id` int(11) NOT NULL,
  `dataOra` datetime NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idRisposta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audio`
--
ALTER TABLE `audio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`);

--
-- Indexes for table `documenti`
--
ALTER TABLE `documenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`);

--
-- Indexes for table `immagini`
--
ALTER TABLE `immagini`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`);

--
-- Indexes for table `messaggi`
--
ALTER TABLE `messaggi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUtente` (`idUtente`),
  ADD KEY `idReply` (`idReply`);

--
-- Indexes for table `posizioni`
--
ALTER TABLE `posizioni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`);

--
-- Indexes for table `risposte`
--
ALTER TABLE `risposte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idSondaggio` (`idSondaggio`);

--
-- Indexes for table `sondaggi`
--
ALTER TABLE `sondaggi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votazioni`
--
ALTER TABLE `votazioni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUtente` (`idUtente`),
  ADD KEY `idRisposta` (`idRisposta`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audio`
--
ALTER TABLE `audio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `documenti`
--
ALTER TABLE `documenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `immagini`
--
ALTER TABLE `immagini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `messaggi`
--
ALTER TABLE `messaggi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `posizioni`
--
ALTER TABLE `posizioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `risposte`
--
ALTER TABLE `risposte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sondaggi`
--
ALTER TABLE `sondaggi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `votazioni`
--
ALTER TABLE `votazioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `audio`
--
ALTER TABLE `audio`
  ADD CONSTRAINT `audio_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggi` (`id`);

--
-- Constraints for table `documenti`
--
ALTER TABLE `documenti`
  ADD CONSTRAINT `documenti_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggi` (`id`);

--
-- Constraints for table `immagini`
--
ALTER TABLE `immagini`
  ADD CONSTRAINT `immagini_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggi` (`id`);

--
-- Constraints for table `links`
--
ALTER TABLE `links`
  ADD CONSTRAINT `links_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggi` (`id`);

--
-- Constraints for table `messaggi`
--
ALTER TABLE `messaggi`
  ADD CONSTRAINT `messaggi_ibfk_1` FOREIGN KEY (`idUtente`) REFERENCES `utenti` (`id`),
  ADD CONSTRAINT `messaggi_ibfk_2` FOREIGN KEY (`idReply`) REFERENCES `messaggi` (`id`);

--
-- Constraints for table `posizioni`
--
ALTER TABLE `posizioni`
  ADD CONSTRAINT `posizioni_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggi` (`id`);

--
-- Constraints for table `risposte`
--
ALTER TABLE `risposte`
  ADD CONSTRAINT `risposte_ibfk_1` FOREIGN KEY (`idSondaggio`) REFERENCES `sondaggi` (`id`);

--
-- Constraints for table `sondaggi`
--
ALTER TABLE `sondaggi`
  ADD CONSTRAINT `sondaggi_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggi` (`id`);

--
-- Constraints for table `votazioni`
--
ALTER TABLE `votazioni`
  ADD CONSTRAINT `votazioni_ibfk_1` FOREIGN KEY (`idUtente`) REFERENCES `utenti` (`id`),
  ADD CONSTRAINT `votazioni_ibfk_2` FOREIGN KEY (`idRisposta`) REFERENCES `risposte` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
