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
CREATE DATABASE IF NOT EXISTS `geekchat` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `geekchat`;

-- --------------------------------------------------------

--
-- Struttura della tabella `audio`
--

CREATE TABLE `audio` (
  `id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `documento`
--

CREATE TABLE `documento` (
  `id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `immagine`
--

CREATE TABLE `immagine` (
  `id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `link`
--

CREATE TABLE `link` (
  `id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `messaggio`
--

CREATE TABLE `messaggio` (
  `id` int(11) NOT NULL,
  `testo` varchar(2000) NOT NULL,
  `dataOraInvio` datetime NOT NULL,
  `idReply` int(11) DEFAULT NULL,
  `idUtente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `posizione`
--

CREATE TABLE `posizione` (
  `id` int(11) NOT NULL,
  `lat` float NOT NULL,
  `lon` float NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `risposta`
--

CREATE TABLE `risposta` (
  `id` int(11) NOT NULL,
  `testo` varchar(50) NOT NULL,
  `idSondaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `sondaggio`
--

CREATE TABLE `sondaggio` (
  `id` int(11) NOT NULL,
  `quesito` varchar(50) NOT NULL,
  `idMessaggio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `bio` varchar(50) NOT NULL,
  `immagine` varchar(150) DEFAULT NULL,
  `password` varchar(30) NOT NULL,
  `lastAccess` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `votazione`
--

CREATE TABLE `votazione` (
  `id` int(11) NOT NULL,
  `dataOra` datetime NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idRisposta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indici per le tabelle `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`),
  ADD KEY `idMessaggio_2` (`idMessaggio`);

--
-- Indici per le tabelle `immagine`
--
ALTER TABLE `immagine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`);

--
-- Indici per le tabelle `link`
--
ALTER TABLE `link`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`);

--
-- Indici per le tabelle `messaggio`
--
ALTER TABLE `messaggio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUtente` (`idUtente`),
  ADD KEY `idReply` (`idReply`);

--
-- Indici per le tabelle `posizione`
--
ALTER TABLE `posizione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`);

--
-- Indici per le tabelle `risposta`
--
ALTER TABLE `risposta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idSondaggio` (`idSondaggio`);

--
-- Indici per le tabelle `sondaggio`
--
ALTER TABLE `sondaggio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMessaggio` (`idMessaggio`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `votazione`
--
ALTER TABLE `votazione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUtente` (`idUtente`,`idRisposta`),
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
-- AUTO_INCREMENT per la tabella `documento`
--
ALTER TABLE `documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `immagine`
--
ALTER TABLE `immagine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `link`
--
ALTER TABLE `link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `messaggio`
--
ALTER TABLE `messaggio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `posizione`
--
ALTER TABLE `posizione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `risposta`
--
ALTER TABLE `risposta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `sondaggio`
--
ALTER TABLE `sondaggio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `votazione`
--
ALTER TABLE `votazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `audio`
--
ALTER TABLE `audio`
  ADD CONSTRAINT `audio_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggio` (`id`);

--
-- Limiti per la tabella `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggio` (`id`);

--
-- Limiti per la tabella `immagine`
--
ALTER TABLE `immagine`
  ADD CONSTRAINT `immagine_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggio` (`id`);

--
-- Limiti per la tabella `link`
--
ALTER TABLE `link`
  ADD CONSTRAINT `link_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggio` (`id`);

--
-- Limiti per la tabella `messaggio`
--
ALTER TABLE `messaggio`
  ADD CONSTRAINT `messaggio_ibfk_1` FOREIGN KEY (`idUtente`) REFERENCES `utente` (`id`),
  ADD CONSTRAINT `messaggio_ibfk_2` FOREIGN KEY (`idReply`) REFERENCES `messaggio` (`id`);

--
-- Limiti per la tabella `posizione`
--
ALTER TABLE `posizione`
  ADD CONSTRAINT `posizione_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggio` (`id`);

--
-- Limiti per la tabella `risposta`
--
ALTER TABLE `risposta`
  ADD CONSTRAINT `risposta_ibfk_1` FOREIGN KEY (`idSondaggio`) REFERENCES `sondaggio` (`id`);

--
-- Limiti per la tabella `sondaggio`
--
ALTER TABLE `sondaggio`
  ADD CONSTRAINT `sondaggio_ibfk_1` FOREIGN KEY (`idMessaggio`) REFERENCES `messaggio` (`id`);

--
-- Limiti per la tabella `votazione`
--
ALTER TABLE `votazione`
  ADD CONSTRAINT `votazione_ibfk_1` FOREIGN KEY (`idUtente`) REFERENCES `utente` (`id`),
  ADD CONSTRAINT `votazione_ibfk_2` FOREIGN KEY (`idRisposta`) REFERENCES `risposta` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
