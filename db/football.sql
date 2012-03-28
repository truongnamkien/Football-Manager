-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 28, 2012 at 09:03 PM
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
  `username` varchar(80) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `role` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`),
  KEY `display_name` (`display_name`),
  KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `display_name`, `role`) VALUES
(3, 'TanSolo', 'a738d2b3d6f668972c9b468801114f4f', 'Trương Nam Kiên', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `building_type`
--

CREATE TABLE IF NOT EXISTS `building_type` (
  `building_type_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `beginning_fee` int(11) DEFAULT NULL,
  `fee_rate` tinyint(4) DEFAULT NULL,
  `effect` int(11) DEFAULT NULL,
  `effect_rate` tinyint(4) DEFAULT NULL,
  `street_cell` tinyint(4) DEFAULT NULL,
  `type` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`building_type_id`),
  UNIQUE KEY `name` (`name`,`street_cell`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `building_type`
--

INSERT INTO `building_type` (`building_type_id`, `name`, `description`, `beginning_fee`, `fee_rate`, `effect`, `effect_rate`, `street_cell`, `type`) VALUES
(1, 'Phòng quản lý', 'Quản lý các chức năng game và cấp độ tối đa của các công trình khác.', 1000, 2, 0, 1, 1, 'quản lý'),
(2, 'Mặt sân', 'Tăng ưu thế của đội bóng khi thi đấu trên sân nhà trong các giải đấu và cup.', 200, 2, 1, 1, 2, 'hỗ trợ'),
(3, 'Khán đài Đông', 'Sức chứa khán giả ở khán đài bên phải', 200, 2, 200, 1, 3, 'sức chứa');

-- --------------------------------------------------------

--
-- Table structure for table `cooldown`
--

CREATE TABLE IF NOT EXISTS `cooldown` (
  `cooldown_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cooldown_type` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `street_id` bigint(20) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`cooldown_id`),
  KEY `street_id` (`street_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `formation`
--

CREATE TABLE IF NOT EXISTS `formation` (
  `formation_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `for_swing` tinyint(4) DEFAULT NULL,
  `for_center` tinyint(4) DEFAULT NULL,
  `mid_swing` tinyint(4) DEFAULT NULL,
  `mid_center` tinyint(4) DEFAULT NULL,
  `def_swing` tinyint(4) DEFAULT NULL,
  `def_center` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`formation_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `formation`
--

INSERT INTO `formation` (`formation_id`, `name`, `for_swing`, `for_center`, `mid_swing`, `mid_center`, `def_swing`, `def_center`) VALUES
(1, '4 - 3 - 3 A', 0, 10, 0, 12, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `name`
--

CREATE TABLE IF NOT EXISTS `name` (
  `name_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `category` varchar(10) NOT NULL,
  PRIMARY KEY (`name_id`),
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=142 ;

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
(42, 'Đường', 'Họ'),
(43, 'Văn', 'Tên lót'),
(44, 'Bá', 'Tên lót'),
(45, 'Mạnh', 'Tên lót'),
(46, 'Đức', 'Tên lót'),
(47, 'Mậu', 'Tên lót'),
(48, 'Gia', 'Tên lót'),
(49, 'Trọng', 'Tên lót'),
(50, 'Bạch', 'Tên lót'),
(51, 'Kim', 'Tên lót'),
(52, 'Hoàng', 'Tên lót'),
(53, 'Quốc', 'Tên lót'),
(54, 'Tuấn', 'Tên lót'),
(55, 'Ngọc', 'Tên lót'),
(56, 'Cương', 'Tên'),
(57, 'Hùng', 'Tên'),
(58, 'Tráng', 'Tên'),
(59, 'Dũng', 'Tên'),
(60, 'Thông', 'Tên'),
(61, 'Minh', 'Tên'),
(62, 'Trí', 'Tên'),
(63, 'Tuệ', 'Tên'),
(64, 'Sáng', 'Tên'),
(65, 'Hoài', 'Tên'),
(66, 'Nhân', 'Tên'),
(67, 'Trung', 'Tên'),
(68, 'Tín', 'Tên'),
(69, 'Lễ', 'Tên'),
(70, 'Nghĩa', 'Tên'),
(71, 'Công', 'Tên'),
(72, 'Hiệp', 'Tên'),
(73, 'Phú', 'Tên'),
(74, 'Quý', 'Tên'),
(75, 'Kim', 'Tên'),
(76, 'Tài', 'Tên'),
(77, 'Danh', 'Tên'),
(78, 'Sơn', 'Tên'),
(79, 'Giang', 'Tên'),
(80, 'Lâm', 'Tên'),
(81, 'Hải', 'Tên'),
(82, 'Dương', 'Tên'),
(83, 'Phúc', 'Tên'),
(84, 'Lộc', 'Tên'),
(85, 'Thọ', 'Tên'),
(86, 'Sĩ', 'Tên'),
(87, 'Nông', 'Tên'),
(88, 'Thương', 'Tên'),
(89, 'Bảo', 'Tên'),
(90, 'Trọng', 'Tên'),
(91, 'Châu', 'Tên'),
(92, 'Kiểm', 'Tên'),
(93, 'Tùng', 'Tên'),
(94, 'Tạc', 'Tên'),
(95, 'Căn', 'Tên'),
(96, 'Doanh', 'Tên'),
(97, 'Sâm', 'Tên'),
(98, 'Khải', 'Tên'),
(99, 'Hoàng', 'Tên'),
(100, 'Nguyên', 'Tên'),
(101, 'Tần', 'Tên'),
(102, 'Trăn', 'Tên'),
(103, 'Chu', 'Tên'),
(104, 'Trú', 'Tên'),
(105, 'Anh', 'Tên'),
(106, 'Cát', 'Tên'),
(107, 'Trường', 'Tên'),
(108, 'Hà', 'Tên'),
(109, 'Hòa', 'Tên'),
(110, 'Khiết', 'Tên'),
(111, 'Khánh', 'Tên'),
(112, 'Khang', 'Tên'),
(113, 'Khương', 'Tên'),
(114, 'Việt', 'Tên'),
(115, 'Ân', 'Tên'),
(116, 'Khoa', 'Tên'),
(117, 'Kiên', 'Tên'),
(118, 'Tuấn', 'Tên'),
(119, 'Bình', 'Tên'),
(120, 'Khôi', 'Tên'),
(121, 'Đăng', 'Tên'),
(122, 'Đạt', 'Tên'),
(123, 'Điền', 'Tên'),
(124, 'Đức', 'Tên'),
(125, 'Kiệt', 'Tên'),
(126, 'Liêm', 'Tên'),
(127, 'Nhật', 'Tên'),
(128, 'Nhiên', 'Tên'),
(129, 'Phi', 'Tên'),
(130, 'Phong', 'Tên'),
(131, 'Phước', 'Tên'),
(132, 'Quân', 'Tên'),
(133, 'Tâm', 'Tên'),
(134, 'Tường', 'Tên'),
(135, 'Thái', 'Tên'),
(136, 'Chiến', 'Tên'),
(137, 'Thắng', 'Tên'),
(138, 'Triết', 'Tên'),
(139, 'Văn', 'Tên'),
(140, 'Vinh', 'Tên'),
(141, 'Vũ', 'Tên');

-- --------------------------------------------------------

--
-- Table structure for table `npc`
--

CREATE TABLE IF NOT EXISTS `npc` (
  `npc_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `street_id` bigint(20) DEFAULT NULL,
  `level` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`npc_id`),
  UNIQUE KEY `street_id` (`street_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  `position` varchar(10) NOT NULL COMMENT 'vị trí',
  `condition` int(11) NOT NULL COMMENT 'thể trạng',
  `manner` int(11) NOT NULL COMMENT 'phong độ',
  `physical` int(11) NOT NULL COMMENT 'thể lực',
  `flexibility` int(11) NOT NULL COMMENT 'dẻo dai',
  `goalkeeper` int(11) NOT NULL COMMENT 'bắt bóng',
  `defence` int(11) NOT NULL COMMENT 'phòng thủ',
  `shooting` int(11) NOT NULL COMMENT 'dứt điểm',
  `passing` int(11) NOT NULL COMMENT 'chuyền bóng',
  `thwart` int(11) NOT NULL COMMENT 'cản phá',
  `speed` int(11) NOT NULL,
  PRIMARY KEY (`player_id`),
  KEY `team_id` (`team_id`),
  KEY `position` (`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `streets`
--

CREATE TABLE IF NOT EXISTS `streets` (
  `street_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `x_coor` int(11) DEFAULT NULL,
  `y_coor` int(11) DEFAULT NULL,
  `street_type` varchar(32) DEFAULT NULL,
  `team_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`street_id`),
  KEY `street_type` (`street_type`),
  KEY `team_id` (`team_id`),
  KEY `coordinate` (`x_coor`,`y_coor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `street_building`
--

CREATE TABLE IF NOT EXISTS `street_building` (
  `street_building_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `street_id` bigint(20) DEFAULT NULL,
  `building_type_id` tinyint(4) DEFAULT NULL,
  `level` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`street_building_id`),
  KEY `street_id` (`street_id`,`building_type_id`),
  KEY `building_type_id` (`building_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `team_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`team_id`),
  UNIQUE KEY `team_name` (`team_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(80) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `user_status` varchar(32) DEFAULT NULL,
  `street_id` bigint(20) DEFAULT NULL,
  `balance` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `street_id` (`street_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
