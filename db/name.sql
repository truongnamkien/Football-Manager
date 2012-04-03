-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 03, 2012 at 12:28 PM
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
