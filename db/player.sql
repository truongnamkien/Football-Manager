-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 26, 2012 at 04:03 AM
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
-- Table structure for table `player`
--

CREATE TABLE IF NOT EXISTS `player` (
  `player_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) DEFAULT NULL,
  `first_name` varchar(30) NOT NULL,
  `middle_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `position` varchar(10) CHARACTER SET latin1 NOT NULL COMMENT 'vị trí',
  `condition` int(10) NOT NULL COMMENT 'thể trạng',
  `manner` int(10) NOT NULL COMMENT 'phong độ',
  `physical` int(10) NOT NULL COMMENT 'thể lực',
  `flexibility` int(10) NOT NULL COMMENT 'dẻo dai',
  `goalkeeper` int(10) NOT NULL COMMENT 'bắt bóng',
  `defence` int(10) NOT NULL COMMENT 'phòng thủ',
  `shooting` int(10) NOT NULL COMMENT 'dứt điểm',
  `passing` int(10) NOT NULL COMMENT 'chuyền bóng',
  `thwart` int(10) NOT NULL COMMENT 'cản phá',
  `speed` int(10) NOT NULL,
  PRIMARY KEY (`player_id`),
  KEY `team_id` (`team_id`),
  KEY `position` (`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
