-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mar 18, 2019 alle 15:19
-- Versione del server: 5.7.17
-- Versione PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `geekchat`
--
CREATE DATABASE IF NOT EXISTS `geekchat` DEFAULT CHARACTER SET utf8;
USE `geekchat`;

-- --------------------------------------------------------

--
-- Struttura della tabella `audio`
--

CREATE TABLE `audio` (
  `id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `documenti`
--

CREATE TABLE `documenti` (
  `id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `immagini`
--

CREATE TABLE `immagini` (
  `id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `messaggi`
--

CREATE TABLE `messaggi` (
  `id` int(11) NOT NULL,
  `testo` varchar(2000) NOT NULL,
  `dataOraInvio` datetime NOT NULL,
  `idReply` int(11) DEFAULT NULL,
  `idUtente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO messaggi (testo, dataOraInvio, idUtente) VALUES
("Benvenuto nella nostra chat", "2019-06-06 10:00:00", 1)

-- --------------------------------------------------------

--
-- Struttura della tabella `posizioni`
--

CREATE TABLE `posizioni` (
  `id` int(11) NOT NULL,
  `lat` float NOT NULL,
  `lon` float NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `risposte`
--

CREATE TABLE `risposte` (
  `id` int(11) NOT NULL,
  `testo` varchar(50) NOT NULL,
  `idSondaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `sondaggi`
--

CREATE TABLE `sondaggi` (
  `id` int(11) NOT NULL,
  `quesito` varchar(50) NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `bio` varchar(200) NOT NULL,
  `immagine` varchar(150) DEFAULT NULL,
  `password` varchar(30) NOT NULL,
  `lastAccess` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO utenti(username, isAdmin, , bio, immagine, password, lastAccess) VALUES
("Zexal0807", true, "I am Zexal", null, "1234", "2019-06-06 10:00:00"),
("ElterSilence", true, "I am ElterSilence", null, "1234", "2019-06-06 10:00:00"),
("Canippa69Player", true, "I am Canippa69Player", null, "1234", "2019-06-06 10:00:00"),
("AlexMarchi2000", true, "I am AlexMarchi2000", null, "1234", "2019-06-06 10:00:00"),
("Levico69Player", true, "I am Levico69Player", null, "1234", "2019-06-06 10:00:00"),
("Lorenz1999", true, "I am Lorenz1999", null, "1234", "2019-06-06 10:00:00"),
("Skil69", true, "I am Skil69", null, "1234", "2019-06-06 10:00:00")

-- --------------------------------------------------------

--
-- Struttura della tabella `votazioni`
--

CREATE TABLE `votazioni` (
  `id` int(11) NOT NULL,
  `dataOra` datetime NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idRisposta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `audio`
--
ALTER TABLE `audio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`);

--
-- Indici per le tabelle `documenti`
--
ALTER TABLE `documenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`);

--
-- Indici per le tabelle `immagini`
--
ALTER TABLE `immagini`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`);

--
-- Indici per le tabelle `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`);

--
-- Indici per le tabelle `messaggi`
--
ALTER TABLE `messaggi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUtente` (`idUtente`),
  ADD KEY `idReply` (`idReply`);

--
-- Indici per le tabelle `posizioni`
--
ALTER TABLE `posizioni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`);

--
-- Indici per le tabelle `risposte`
--
ALTER TABLE `risposte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idSondaggio` (`idSondaggio`);

--
-- Indici per le tabelle `sondaggi`
--
ALTER TABLE `sondaggi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `votazioni`
--
ALTER TABLE `votazioni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUtente` (`idUtente`),
  ADD KEY `idRisposta` (`idRisposta`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `audio`
--
ALTER TABLE `audio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `documenti`
--
ALTER TABLE `documenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `immagini`
--
ALTER TABLE `immagini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `messaggi`
--
ALTER TABLE `messaggi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `posizioni`
--
ALTER TABLE `posizioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `risposte`
--
ALTER TABLE `risposte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `sondaggi`
--
ALTER TABLE `sondaggi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `votazioni`
--
ALTER TABLE `votazioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `audio`
--
ALTER TABLE `audio`
  ADD CONSTRAINT `audio_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggi` (`id`);

--
-- Limiti per la tabella `documenti`
--
ALTER TABLE `documenti`
  ADD CONSTRAINT `documenti_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggi` (`id`);

--
-- Limiti per la tabella `immagini`
--
ALTER TABLE `immagini`
  ADD CONSTRAINT `immagini_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggi` (`id`);

--
-- Limiti per la tabella `links`
--
ALTER TABLE `links`
  ADD CONSTRAINT `links_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggi` (`id`);

--
-- Limiti per la tabella `messaggi`
--
ALTER TABLE `messaggi`
  ADD CONSTRAINT `messaggi_ibfk_1` FOREIGN KEY (`idUtente`) REFERENCES `utenti` (`id`),
  ADD CONSTRAINT `messaggi_ibfk_2` FOREIGN KEY (`idReply`) REFERENCES `messaggi` (`id`);

--
-- Limiti per la tabella `posizioni`
--
ALTER TABLE `posizioni`
  ADD CONSTRAINT `posizioni_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggi` (`id`);

--
-- Limiti per la tabella `risposte`
--
ALTER TABLE `risposte`
  ADD CONSTRAINT `risposte_ibfk_1` FOREIGN KEY (`idSondaggio`) REFERENCES `sondaggi` (`id`);

--
-- Limiti per la tabella `sondaggi`
--
ALTER TABLE `sondaggi`
  ADD CONSTRAINT `sondaggi_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggi` (`id`);

--
-- Limiti per la tabella `votazioni`
--
ALTER TABLE `votazioni`
  ADD CONSTRAINT `votazioni_ibfk_1` FOREIGN KEY (`idUtente`) REFERENCES `utenti` (`id`),
  ADD CONSTRAINT `votazioni_ibfk_2` FOREIGN KEY (`idRisposta`) REFERENCES `risposte` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
