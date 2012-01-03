-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 03, 2012 at 08:28 AM
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
-- Table structure for table `name`
--

CREATE TABLE IF NOT EXISTS `name` (
  `name_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `category` varchar(10) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`name_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `name`
--

INSERT INTO `name` (`name_id`, `name`, `category`) VALUES
(1, 'An', 'Họ'),
(2, 'Bạch', 'Họ'),
(3, 'Bàng', 'Họ'),
(4, 'Bùi', 'Họ'),
(5, 'Cao', 'Họ'),
(6, 'Chu', 'Họ'),
(7, 'Cự', 'Họ'),
(8, 'Dương', 'Họ'),
(9, 'Hà', 'Họ'),
(10, 'Hồ', 'Họ'),
(11, 'Hoàng', 'Họ'),
(12, 'Hứa', 'Họ'),
(13, 'Huỳnh', 'Họ'),
(14, 'Kim', 'Họ'),
(15, 'Lâm', 'Họ'),
(16, 'Lê', 'Họ'),
(17, 'Lục', 'Họ'),
(18, 'Lương', 'Họ'),
(19, 'Lưu', 'Họ'),
(20, 'Lý', 'Họ'),
(21, 'Mai', 'Họ'),
(22, 'Ngô', 'Họ'),
(23, 'Nguyễn', 'Họ'),
(24, 'Phạm', 'Họ'),
(25, 'Phan', 'Họ'),
(26, 'Phùng', 'Họ'),
(27, 'Quách', 'Họ'),
(28, 'Tăng', 'Họ'),
(29, 'Tào', 'Họ'),
(30, 'Trần', 'Họ'),
(31, 'Trịnh', 'Họ'),
(32, 'Trương', 'Họ'),
(33, 'Võ', 'Họ'),
(34, 'Vũ', 'Họ'),
(35, 'Đàm', 'Họ'),
(36, 'Đan', 'Họ'),
(37, 'Đặng', 'Họ'),
(38, 'Đào', 'Họ'),
(39, 'Đinh', 'Họ'),
(40, 'Đỗ', 'Họ'),
(41, 'Đoàn', 'Họ'),
(42, 'Đường', 'Họ');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
