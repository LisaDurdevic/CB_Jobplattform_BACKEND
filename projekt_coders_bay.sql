-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 15. Mrz 2022 um 13:37
-- Server-Version: 10.1.39-MariaDB
-- PHP-Version: 7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `projekt_coders.bay`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `languages`
--

CREATE TABLE `languages` (
  `lang_id` varchar(2) NOT NULL,
  `definition` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `languages`
--

INSERT INTO `languages` (`lang_id`, `definition`) VALUES
('BS', 'BOSNISCH'),
('EN', 'ENGLISH'),
('ES', 'SPANISCH'),
('GE', 'GERMAN'),
('HR', 'KROATISCH'),
('HU', 'UNGARISCH'),
('IT', 'ITALIENISCH'),
('JA', 'JAPANISCH'),
('PL', 'POLNISCH'),
('PT', 'PORTUGIESISCH'),
('RO', 'RUMÄNISCH'),
('RU', 'RUSSISCH'),
('SQ', 'ALBANISCH'),
('SR', 'SERBISCH'),
('TR', 'TÜRKISCH'),
('UK', 'UKRAINISCH');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `skills`
--

CREATE TABLE `skills` (
  `skill_id` int(4) NOT NULL,
  `definition` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `skills`
--

INSERT INTO `skills` (`skill_id`, `definition`) VALUES
(1, 'JAVA'),
(2, 'NoSQL'),
(3, 'PHP'),
(4, 'JAVASCRIPT'),
(5, 'SAP HANA'),
(6, 'NETZWERKADMIN'),
(7, 'CSS'),
(8, 'jQUERY'),
(9, 'BOOTSTRAP'),
(10, 'PL/SQL'),
(11, 'MySQL'),
(12, 'HTML5'),
(13, 'VIRTUAL SERVER'),
(14, 'ACTIVE DIR.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `userName` varchar(30) NOT NULL,
  `pw` varchar(60) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `mail` varchar(30) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `urlLinkedin` varchar(60) DEFAULT NULL,
  `urlXing` varchar(60) DEFAULT NULL,
  `urlGithub` varchar(60) DEFAULT NULL,
  `urlCustom` varchar(60) DEFAULT NULL,
  `leaveDate` date NOT NULL,
  `fullTime` tinyint(1) DEFAULT '1',
  `regionOne` varchar(10) DEFAULT NULL,
  `regionTwo` varchar(10) DEFAULT NULL,
  `preference` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`userName`, `pw`, `firstName`, `lastName`, `mail`, `phone`, `urlLinkedin`, `urlXing`, `urlGithub`, `urlCustom`, `leaveDate`, `fullTime`, `regionOne`, `regionTwo`, `preference`) VALUES
('eifrigerSpecht28', '$2y$10$SuyPjW.XyoCn4nCxihUv2eS8TzHE2KLn5Nhf5f.io1zyA.kc3jMHW', 'Randall', 'Boggs', 'evil@mail.com', '+43 650 666', 'https://linkedin.com/evilboogs', 'https://xing.at/profile/evilboogs', 'https://github.com/evilboogs', '', '2022-08-14', 1, 'LINZ', 'LINZ-LAND', 'FULL-STACK'),
('faehigerHund94', '$2y$10$EpTToVFtHIyRgeXub4Ktu.TN6ecn79AD7IjkMp4MEIGfdxrhVDyCW', 'Mike', 'Glotzkofski', 'mike.glotzkofski@mail.com', '', 'https://linkedin.com/mikeglotzkofski', 'https://xing.at/profile/mikeglotzkofski', 'https://github.com/mikeglotzkofski', '', '2022-08-14', 1, 'HOMEOFFICE', 'LINZ', 'FRONTEND'),
('sympathischerFisch6', '$2y$10$huK91WtK5jrP6un/Xe8nO.FjrdB.SuHCTS9c8FZa9lsYSvHc7KcYO', 'James P.', 'Sullivan', 'james.sullivan@mail.com', '+49 7152 5555 333 2', 'https://linkedin.com/sulley', '', 'https://github.com/sulley', 'https://myDomain.com/sulley', '2022-08-14', 0, 'EVERYWHERE', '', 'NETWORK'),
('wunderbarerSpatz59', '$2y$10$J4l.PAH19rsQflbMxQRZzOAhi0m./W/IIXJjPTwzUYOh/Yl0jjYdC', 'Celia', 'Mae', 'celia.mae@mail.com', '', '', '', '', '', '2022-08-14', 0, 'STEYR-LAND', '', 'SAP');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `userlang`
--

CREATE TABLE `userlang` (
  `userName` varchar(20) NOT NULL,
  `lang_id` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `userlang`
--

INSERT INTO `userlang` (`userName`, `lang_id`) VALUES
('eifrigerSpecht28', 'EN'),
('eifrigerSpecht28', 'GE'),
('faehigerHund94', 'EN'),
('faehigerHund94', 'GE'),
('faehigerHund94', 'SR'),
('sympathischerFisch6', 'EN'),
('sympathischerFisch6', 'GE'),
('wunderbarerSpatz59', 'EN'),
('wunderbarerSpatz59', 'GE');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `userskills`
--

CREATE TABLE `userskills` (
  `userName` varchar(20) NOT NULL,
  `skill_id` int(4) NOT NULL,
  `topSkill` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `userskills`
--

INSERT INTO `userskills` (`userName`, `skill_id`, `topSkill`) VALUES
('eifrigerSpecht28', 4, 1),
('eifrigerSpecht28', 7, 0),
('eifrigerSpecht28', 10, 0),
('faehigerHund94', 3, 0),
('faehigerHund94', 4, 1),
('faehigerHund94', 7, 1),
('sympathischerFisch6', 6, 1),
('sympathischerFisch6', 7, 0),
('sympathischerFisch6', 10, 0),
('wunderbarerSpatz59', 1, 0),
('wunderbarerSpatz59', 2, 1),
('wunderbarerSpatz59', 5, 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`lang_id`);

--
-- Indizes für die Tabelle `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skill_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userName`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Indizes für die Tabelle `userlang`
--
ALTER TABLE `userlang`
  ADD PRIMARY KEY (`userName`,`lang_id`),
  ADD KEY `lang_id` (`lang_id`);

--
-- Indizes für die Tabelle `userskills`
--
ALTER TABLE `userskills`
  ADD PRIMARY KEY (`userName`,`skill_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `skills`
--
ALTER TABLE `skills`
  MODIFY `skill_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `userlang`
--
ALTER TABLE `userlang`
  ADD CONSTRAINT `userLang_ibfk_1` FOREIGN KEY (`userName`) REFERENCES `user` (`userName`) ON DELETE CASCADE,
  ADD CONSTRAINT `userLang_ibfk_2` FOREIGN KEY (`lang_id`) REFERENCES `languages` (`lang_id`) ON DELETE NO ACTION;

--
-- Constraints der Tabelle `userskills`
--
ALTER TABLE `userskills`
  ADD CONSTRAINT `userName` FOREIGN KEY (`userName`) REFERENCES `user` (`userName`) ON DELETE CASCADE,
  ADD CONSTRAINT `userSkills_ibfk_1` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`skill_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;