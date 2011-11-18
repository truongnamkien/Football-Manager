-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 18, 2011 at 07:42 AM
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
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `display_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `role` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `display_name`, `role`) VALUES
(1, 'TanSolo', 'a738d2b3d6f668972c9b468801114f4f', 'Trương Nam Kiên', 0);

-- --------------------------------------------------------

--
-- Table structure for table `building_type`
--

CREATE TABLE IF NOT EXISTS `building_type` (
  `building_type_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `beginning_fee` int(12) DEFAULT NULL,
  `fee_rate` int(8) DEFAULT NULL,
  `effect` int(12) DEFAULT NULL,
  `effect_rate` int(8) DEFAULT NULL,
  `street_cell` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`building_type_id`),
  UNIQUE KEY `name` (`name`,`street_cell`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `building_type`
--

INSERT INTO `building_type` (`building_type_id`, `name`, `description`, `beginning_fee`, `fee_rate`, `effect`, `effect_rate`, `street_cell`) VALUES
(1, 'Phòng quản lý', 'Quản lý các chức năng game và cấp độ tối đa của các công trình khác.', 1000, 2, 0, 1, 1),
(2, 'Mặt sân', 'Tăng ưu thế của đội bóng khi thi đấu trên sân nhà trong các giải đấu và cup.', 200, 2, 1, 1, 2),
(3, 'Khán đài Đông', 'Sức chứa khán giả ở khán đài bên phải', 200, 2, 200, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `cooldown`
--

CREATE TABLE IF NOT EXISTS `cooldown` (
  `cooldown_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cooldown_type` tinyint(4) DEFAULT NULL,
  `street_id` bigint(14) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`cooldown_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `streets`
--

CREATE TABLE IF NOT EXISTS `streets` (
  `street_id` bigint(14) NOT NULL AUTO_INCREMENT,
  `x_coor` int(8) DEFAULT NULL,
  `y_coor` int(8) DEFAULT NULL,
  `street_type` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`street_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `street_building`
--

CREATE TABLE IF NOT EXISTS `street_building` (
  `street_building_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `street_id` bigint(14) DEFAULT NULL,
  `building_type_id` tinyint(4) DEFAULT NULL,
  `level` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`street_building_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `display_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `user_status` tinyint(4) NOT NULL DEFAULT '0',
  `street_id` bigint(14) DEFAULT NULL,
  `balance` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `street_id` (`street_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
