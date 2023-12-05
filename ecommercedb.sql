-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 05, 2023 alle 12:05
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.0.10

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
-- Struttura della tabella `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `UnitPrice` decimal(10,2) NOT NULL,
  `ImageLink` varchar(255) DEFAULT NULL,
  `UserSellerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `products`
--

INSERT INTO `products` (`ProductID`, `Name`, `Description`, `UnitPrice`, `ImageLink`, `UserSellerID`) VALUES
(3, 'mela', 'una mela', '1.00', NULL, 6),
(4, 'Mela', 'Una mela rossa', '1.50', NULL, 6),
(5, 'Banana', 'Una banana gialla', '0.80', NULL, 6),
(6, 'Ananas', 'Un\'ottima ananas tropicale', '2.20', NULL, 6),
(7, 'Pera', 'Una gustosa pera', '1.20', NULL, 6),
(8, 'Arancia', 'Un arancia succosa', '1.30', NULL, 6),
(9, 'Kiwi', 'Un kiwi fresco', '1.10', NULL, 6),
(10, 'Fragola', 'Una fragola dolce', '1.60', NULL, 6),
(11, 'Limone', 'Un limone acido', '1.00', NULL, 6),
(12, 'Ciliegia', 'Una ciliegia matura', '1.80', NULL, 6),
(13, 'Pesca', 'Una pesca dolce e succosa', '1.70', NULL, 6),
(14, 'Uva', 'Un grappolo d\'uva', '2.00', NULL, 6),
(15, 'Melograno', 'Un melograno ricco di semi', '2.50', NULL, 6),
(16, 'Anguria', 'Un\'anguria rinfrescante', '3.00', NULL, 6),
(17, 'Mandarino', 'Un mandarino gustoso', '1.40', NULL, 6),
(18, 'Cocco', 'Un cocco tropicale', '2.80', NULL, 6),
(19, 'Melone', 'Un melone maturo', '1.90', NULL, 6),
(20, 'Mango', 'Un mango succoso', '2.30', NULL, 6),
(21, 'Pompelmo', 'Un pompelmo rosa', '1.70', NULL, 6),
(22, 'Clementina', 'Una clementina arancione', '1.20', NULL, 6),
(23, 'Mirtillo', 'Un mirtillo dolce', '2.20', NULL, 6),
(24, 'Ribes', 'Un ribes rosso', '1.80', NULL, 6),
(25, 'Passiflora', 'Un frutto della passione', '2.50', NULL, 6);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Mail`, `Password`, `Usertypeid`) VALUES
(6, 'seller', 'seller@seller.it', '$2y$10$RSVMnRowN7Gvk3SGaZ5cqeMteTFvZ2O2tx.OSy8UdwF3Ia31PG.ky', 2),
(7, 'buyer', 'buyer@buyer.it', '$2y$10$Bnx8Se271Kyt/RMWeUr8wOAnoQXqDGxmN2x1siXukk7GosiO8XE.C', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `usertypes`
--

CREATE TABLE `usertypes` (
  `Usertypeid` int(11) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indici per le tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `UserSellerID` (`UserSellerID`);

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
-- AUTO_INCREMENT per la tabella `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `usertypes`
--
ALTER TABLE `usertypes`
  MODIFY `Usertypeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`UserSellerID`) REFERENCES `users` (`UserID`);

--
-- Limiti per la tabella `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`Usertypeid`) REFERENCES `usertypes` (`Usertypeid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
