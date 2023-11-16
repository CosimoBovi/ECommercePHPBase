-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Nov 16, 2023 alle 12:17
-- Versione del server: 10.4.27-MariaDB
-- Versione PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommercedb`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Mail` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Usertypeid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Mail`, `Password`, `Usertypeid`) VALUES
(3, 'test', 'test@test.it', '$2y$10$M.J0ckWN92Ak5B23zc.YteKd0G6Oky.sBgkWMkpCUH.IfaNtjDnLS', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `usertypes`
--

CREATE TABLE `usertypes` (
  `Usertypeid` int(11) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `usertypes`
--

INSERT INTO `usertypes` (`Usertypeid`, `Type`, `Description`) VALUES
(1, 'Administrator', 'Ruolo dell\'amministratore con pieni privilegi di gestione del sistema.'),
(2, 'Seller', 'Ruolo del venditore che gestisce i prodotti e le vendite.'),
(3, 'Buyer', 'Ruolo dell\'acquirente che effettua acquisti e visualizza prodotti disponibili.');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Mail` (`Mail`),
  ADD KEY `Usertypeid` (`Usertypeid`);

--
-- Indici per le tabelle `usertypes`
--
ALTER TABLE `usertypes`
  ADD PRIMARY KEY (`Usertypeid`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `usertypes`
--
ALTER TABLE `usertypes`
  MODIFY `Usertypeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`Usertypeid`) REFERENCES `usertypes` (`Usertypeid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
