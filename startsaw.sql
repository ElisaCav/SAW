-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 04, 2024 alle 00:11
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `startsaw`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `booking`
--

CREATE TABLE `booking` (
  `bookingid` int(11) NOT NULL,
  `locationid` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `starttime` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Date and start time of the booking',
  `endtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Date and start time of the booking',
  `requesttime` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Date and time the booking request was made ',
  `cancellation` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'True if the appointment has been cancelled',
  `duration` int(2) NOT NULL,
  `totalprice` decimal(8,2) NOT NULL COMMENT 'price * number of hours'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `location`
--

CREATE TABLE `location` (
  `locationid` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `availability` tinyint(1) NOT NULL COMMENT 'false if the seller wants to (temporarily) hide the location from the public',
  `capacity` int(10) DEFAULT NULL,
  `audio` tinyint(1) DEFAULT NULL,
  `catering` tinyint(1) DEFAULT NULL,
  `photo` text DEFAULT NULL COMMENT 'path of the image',
  `type` varchar(10) DEFAULT NULL COMMENT 'event category',
  `price` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'cost per hour'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE `user` (
  `userid` int(10) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(320) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `cookieid` varchar(16) DEFAULT NULL COMMENT 'remember me cookie indentifier',
  `cookieexpiration` timestamp NULL DEFAULT NULL COMMENT 'remember me cookie expiration',
  `cookieflag` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'true if remember me is selected at login time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingid`),
  ADD KEY `user` (`user`),
  ADD KEY `locationid` (`locationid`);

--
-- Indici per le tabelle `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`locationid`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `booking`
--
ALTER TABLE `booking`
  MODIFY `bookingid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `location`
--
ALTER TABLE `location`
  MODIFY `locationid` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(10) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`userid`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`locationid`) REFERENCES `location` (`locationid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
