-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 29, 2012 at 03:48 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `football`
--

-- --------------------------------------------------------

--
-- Table structure for table `formation`
--

CREATE TABLE IF NOT EXISTS `formation` (
  `formation_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `for_wing` tinyint(4) DEFAULT NULL,
  `for_center` tinyint(4) DEFAULT NULL,
  `mid_wing` tinyint(4) DEFAULT NULL,
  `mid_center` tinyint(4) DEFAULT NULL,
  `def_wing` tinyint(4) DEFAULT NULL,
  `def_center` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`formation_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `formation`
--

INSERT INTO `formation` (`formation_id`, `name`, `for_wing`, `for_center`, `mid_wing`, `mid_center`, `def_wing`, `def_center`) VALUES
(1, '4 - 3 - 3 A', 0, 10, 0, 12, 2, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
