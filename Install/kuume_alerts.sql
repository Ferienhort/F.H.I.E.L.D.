-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: dd29920
-- Erstellungszeit: 24. Feb 2017 um 13:09
-- Server Version: 5.5.52-nmm1-log
-- PHP-Version: 5.5.38-nmm2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `d0220110`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kuume_alerts`
--

CREATE TABLE IF NOT EXISTS `kuume_alerts` (
  `AlertID` int(11) NOT NULL AUTO_INCREMENT,
  `LEVEL` int(11) NOT NULL,
  `MESSAGE` varchar(500) NOT NULL,
  `DATETIME_IT_HAPPENED` datetime NOT NULL,
  `BY` varchar(50) NOT NULL,
  `OUTPUT` varchar(2000) NOT NULL,
  PRIMARY KEY (`AlertID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
