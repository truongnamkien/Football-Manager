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
-- Table structure for table `building_type`
--

CREATE TABLE IF NOT EXISTS `building_type` (
  `building_type_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `beginning_fee` int(11) DEFAULT NULL,
  `fee_rate` int(11) DEFAULT NULL,
  `effect` int(11) DEFAULT NULL,
  `effect_rate` int(11) DEFAULT NULL,
  `street_cell` tinyint(4) DEFAULT NULL,
  `type` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`building_type_id`),
  UNIQUE KEY `name` (`name`,`street_cell`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `building_type`
--

INSERT INTO `building_type` (`building_type_id`, `name`, `description`, `beginning_fee`, `fee_rate`, `effect`, `effect_rate`, `street_cell`, `type`) VALUES
(1, 'Phòng quản lý', 'Quản lý các chức năng game và cấp độ tối đa của các công trình khác.', 1000, 100, 0, 0, 1, 'quản lý'),
(2, 'Mặt sân', 'Tăng ưu thế của đội bóng khi thi đấu trên sân nhà trong các giải đấu và cup.', 200, 50, 1, 1, 2, 'hỗ trợ'),
(3, 'Khán đài Đông', 'Sức chứa khán giả ở khán đài bên phải.', 200, 50, 200, 20, 3, 'sức chứa'),
(4, 'Khán đài Tây', 'Sức chứa khán giả ở khán đài bên trái.', 200, 50, 200, 20, 4, 'sức chứa'),
(5, 'Khán đài Bắc', 'Sức chứa khán giả ở khán đài bên trên.', 500, 50, 500, 20, 5, 'sức chứa'),
(6, 'Khán đài Nam', 'Sức chứa khán giả ở khán đài bên dưới.', 500, 50, 500, 20, 6, 'sức chứa'),
(7, 'Khán đài Đông Bắc', 'Sức chứa khán giả ở khán đài góc trên bên phải.', 100, 50, 100, 20, 7, 'sức chứa'),
(8, 'Khán đài Đông Nam', 'Sức chứa khán giả ở khán đài góc dưới bên phải.', 100, 50, 100, 20, 8, 'sức chứa'),
(9, 'Khán đài Tây Bắc', 'Sức chứa khán giả ở khán đài góc trên bên trái.', 100, 50, 100, 20, 9, 'sức chứa'),
(10, 'Khán đài Tây Nam', 'Sức chứa khán giả ở khán đài góc dưới bên trái.', 100, 50, 100, 20, 10, 'sức chứa'),
(11, 'Bãi đậu xe', 'Ngoại trừ sức chứa của sân, bãi đậu xe cũng là yếu tố quyết định số lượng khán giả tối đa đến sân. Số lượng khán giả tối đa đến sân sẽ bằng giá trị thấp hơn của tổng số sức chứa của sân và sức chứa của bãi đậu xe.', 600, 40, 80, 40, 11, 'giao thông'),
(12, 'Quán ăn', 'Số lượng khách sẽ được phục vụ dịch vụ ăn uống khi đến sân xem những trận giải đấu và cup trên sân nhà. Số tiền thu được từ khán giả được phục vụ sẽ là nguồn thu bổ sung của đội bóng.', 1000, 60, 300, 30, 12, 'dịch vụ'),
(13, 'Quầy cá cược', 'Trước mỗi trận đấu giải trên sân nhà, sẽ có một tỉ lệ cược cho kết quả thắng/hòa/thua và số lượng khán giả và tiền đặt cược cho mỗi tỉ lệ. Kết quả cược sẽ được tính dựa trên kết quả trận đấu. Người chơi có thể thắng hoặc thua một số tiền tương ứng với số tiền nhận cược.', 600, 60, 20, 50, 13, 'dịch vụ'),
(14, 'Khu trị liệu', 'Thực hiện chức năng phục hồi thể trạng cho cầu thủ. Mỗi lần phục hồi sẽ mất 1 khoảng thời gian cooldown trước khi có thể thực hiện lần phục hồi tiếp theo. Level càng cao, lượng thể trạng và thời gian cooldown càng nhiều.', 200, 40, 0, 0, 14, 'phục hồi'),
(15, 'Khu giải trí', 'Thực hiện chức năng tăng phong độ cho cầu thủ. Mỗi lần tăng sẽ mất 1 khoảng thời gian cooldown trước khi có thể thực hiện lần tăng tiếp theo. Level càng cao, lượng phong độ và thời gian cooldown càng nhiều.', 200, 40, 0, 0, 15, 'phục hồi'),
(16, 'Phòng tập thể lực', 'Đối với mỗi level của phòng tập thể lực, người chơi có thể tiến hành luyện tập (nghiên cứu) để tăng thêm hiệu quả của chỉ số thể lực vào dẻo dai của cầu thủ trong đội khi thi đấu.', 1000, 60, 0, 0, 16, 'nghiên cứu'),
(17, 'Khu tập luyện', 'Đối với mỗi level của khu tập luyện, người chơi có thể tiến hành luyện tập (nghiên cứu) để tăng thêm hiệu quả của chỉ số chính còn lại của cầu thủ trong đội khi thi đấu.', 1000, 100, 0, 0, 17, 'nghiên cứu'),
(18, 'Sân đấu tập', 'Người chơi có thể tiến hành nghiên cứu các chiến thuật (tình huống cố định, bắt việt vị, kèm người...) và đội hình. Nghiên cứu sẽ giúp tăng hiệu quả của các chỉ số tương ứng với các vị trí khi thi đấu. Hiệu quả của nghiên cứu sẽ có tác dụng ngẫu nhiên trong mỗi trận đấu.', 1000, 80, 0, 0, 18, 'nghiên cứu'),
(19, 'Ký túc xá', 'Level càng cao thì người chơi càng giữ được nhiều cầu thủ trong đội để có thể thực hiện những ý đồ khác nhau: Ghép cầu thủ, luyện tập để chuyển nhượng, luân chuyển đội hình...', 100, 100, 15, 2, 19, 'hỗ trợ'),
(20, 'Phòng môi giới chuyển nhượng', 'Nơi quyết định giá trị cầu thủ trước khi đem bán ra thị trường chuyển nhượng. Đồng thời là nơi người chơi có thể tiến hành tìm kiếm và đặt giá mua đối với những cầu thủ đang được đấu giá ngoài thị trường chuyển nhượng.', 500, 100, 0, 0, 20, 'chuyển nhượng'),
(21, 'Kho item', 'Là nơi chứa item khi người chơi mua từ chợ hay thu được khi du đấu với NPC. Level càng cao chứa càng nhiều item.', 400, 100, 0, 0, 21, 'hỗ trợ'),
(22, 'Chợ item', 'Là nơi người chơi rao bán và mua các item thu được khi du đấu với NPC. Người chơi có thể định giá tùy ý. Tuy nhiên, tùy theo từng mức giá đưa ra, người chơi sẽ bị thu một khoản thuế khi rao bán. Level càng cao thì càng rao bán được nhiều item cùng lúc.', 200, 100, 0, 0, 22, 'hỗ trợ');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
