-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 28, 2012 at 09:04 PM
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
-- Table structure for table `team_formation`
--

CREATE TABLE IF NOT EXISTS `team_formation` (
  `team_formation_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) NOT NULL,
  `formation_id` int(11) NOT NULL,
  `goal_keeper` bigint(20) DEFAULT NULL,
  `player_1` bigint(20) DEFAULT NULL,
  `player_2` bigint(20) DEFAULT NULL,
  `player_3` bigint(20) DEFAULT NULL,
  `player_4` bigint(20) DEFAULT NULL,
  `player_5` bigint(20) DEFAULT NULL,
  `player_6` bigint(20) DEFAULT NULL,
  `player_7` bigint(20) DEFAULT NULL,
  `player_8` bigint(20) DEFAULT NULL,
  `player_9` bigint(20) DEFAULT NULL,
  `player_10` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`team_formation_id`),
  UNIQUE KEY `team_id` (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
