-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 20, 2011 at 06:13 PM
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
  `type` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`building_type_id`),
  UNIQUE KEY `name` (`name`,`street_cell`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `building_type`
--

INSERT INTO `building_type` (`building_type_id`, `name`, `description`, `beginning_fee`, `fee_rate`, `effect`, `effect_rate`, `street_cell`, `type`) VALUES
(1, 'Phòng quản lý', 'Quản lý các chức năng game và cấp độ tối đa của các công trình khác.', 1000, 2, 0, 1, 1, 'quản lý'),
(2, 'Mặt sân', 'Tăng ưu thế của đội bóng khi thi đấu trên sân nhà trong các giải đấu và cup.', 200, 2, 1, 1, 2, 'hỗ trợ'),
(3, 'Khán đài Đông', 'Sức chứa khán giả ở khán đài bên phải', 200, 2, 200, 1, 3, 'sức chứa');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
