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
-- Table structure for table `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `team_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`team_id`),
  UNIQUE KEY `team_name` (`team_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1401 ;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`team_id`, `team_name`) VALUES
(1, 'Đội bóng 1'),
(10, 'Đội bóng 10'),
(100, 'Đội bóng 100'),
(1000, 'Đội bóng 1000'),
(1001, 'Đội bóng 1001'),
(1002, 'Đội bóng 1002'),
(1003, 'Đội bóng 1003'),
(1004, 'Đội bóng 1004'),
(1005, 'Đội bóng 1005'),
(1006, 'Đội bóng 1006'),
(1007, 'Đội bóng 1007'),
(1008, 'Đội bóng 1008'),
(1009, 'Đội bóng 1009'),
(101, 'Đội bóng 101'),
(1010, 'Đội bóng 1010'),
(1011, 'Đội bóng 1011'),
(1012, 'Đội bóng 1012'),
(1013, 'Đội bóng 1013'),
(1014, 'Đội bóng 1014'),
(1015, 'Đội bóng 1015'),
(1016, 'Đội bóng 1016'),
(1017, 'Đội bóng 1017'),
(1018, 'Đội bóng 1018'),
(1019, 'Đội bóng 1019'),
(102, 'Đội bóng 102'),
(1020, 'Đội bóng 1020'),
(1021, 'Đội bóng 1021'),
(1022, 'Đội bóng 1022'),
(1023, 'Đội bóng 1023'),
(1024, 'Đội bóng 1024'),
(1025, 'Đội bóng 1025'),
(1026, 'Đội bóng 1026'),
(1027, 'Đội bóng 1027'),
(1028, 'Đội bóng 1028'),
(1029, 'Đội bóng 1029'),
(103, 'Đội bóng 103'),
(1030, 'Đội bóng 1030'),
(1031, 'Đội bóng 1031'),
(1032, 'Đội bóng 1032'),
(1033, 'Đội bóng 1033'),
(1034, 'Đội bóng 1034'),
(1035, 'Đội bóng 1035'),
(1036, 'Đội bóng 1036'),
(1037, 'Đội bóng 1037'),
(1038, 'Đội bóng 1038'),
(1039, 'Đội bóng 1039'),
(104, 'Đội bóng 104'),
(1040, 'Đội bóng 1040'),
(1041, 'Đội bóng 1041'),
(1042, 'Đội bóng 1042'),
(1043, 'Đội bóng 1043'),
(1044, 'Đội bóng 1044'),
(1045, 'Đội bóng 1045'),
(1046, 'Đội bóng 1046'),
(1047, 'Đội bóng 1047'),
(1048, 'Đội bóng 1048'),
(1049, 'Đội bóng 1049'),
(105, 'Đội bóng 105'),
(1050, 'Đội bóng 1050'),
(1051, 'Đội bóng 1051'),
(1052, 'Đội bóng 1052'),
(1053, 'Đội bóng 1053'),
(1054, 'Đội bóng 1054'),
(1055, 'Đội bóng 1055'),
(1056, 'Đội bóng 1056'),
(1057, 'Đội bóng 1057'),
(1058, 'Đội bóng 1058'),
(1059, 'Đội bóng 1059'),
(106, 'Đội bóng 106'),
(1060, 'Đội bóng 1060'),
(1061, 'Đội bóng 1061'),
(1062, 'Đội bóng 1062'),
(1063, 'Đội bóng 1063'),
(1064, 'Đội bóng 1064'),
(1065, 'Đội bóng 1065'),
(1066, 'Đội bóng 1066'),
(1067, 'Đội bóng 1067'),
(1068, 'Đội bóng 1068'),
(1069, 'Đội bóng 1069'),
(107, 'Đội bóng 107'),
(1070, 'Đội bóng 1070'),
(1071, 'Đội bóng 1071'),
(1072, 'Đội bóng 1072'),
(1073, 'Đội bóng 1073'),
(1074, 'Đội bóng 1074'),
(1075, 'Đội bóng 1075'),
(1076, 'Đội bóng 1076'),
(1077, 'Đội bóng 1077'),
(1078, 'Đội bóng 1078'),
(1079, 'Đội bóng 1079'),
(108, 'Đội bóng 108'),
(1080, 'Đội bóng 1080'),
(1081, 'Đội bóng 1081'),
(1082, 'Đội bóng 1082'),
(1083, 'Đội bóng 1083'),
(1084, 'Đội bóng 1084'),
(1085, 'Đội bóng 1085'),
(1086, 'Đội bóng 1086'),
(1087, 'Đội bóng 1087'),
(1088, 'Đội bóng 1088'),
(1089, 'Đội bóng 1089'),
(109, 'Đội bóng 109'),
(1090, 'Đội bóng 1090'),
(1091, 'Đội bóng 1091'),
(1092, 'Đội bóng 1092'),
(1093, 'Đội bóng 1093'),
(1094, 'Đội bóng 1094'),
(1095, 'Đội bóng 1095'),
(1096, 'Đội bóng 1096'),
(1097, 'Đội bóng 1097'),
(1098, 'Đội bóng 1098'),
(1099, 'Đội bóng 1099'),
(11, 'Đội bóng 11'),
(110, 'Đội bóng 110'),
(1100, 'Đội bóng 1100'),
(1101, 'Đội bóng 1101'),
(1102, 'Đội bóng 1102'),
(1103, 'Đội bóng 1103'),
(1104, 'Đội bóng 1104'),
(1105, 'Đội bóng 1105'),
(1106, 'Đội bóng 1106'),
(1107, 'Đội bóng 1107'),
(1108, 'Đội bóng 1108'),
(1109, 'Đội bóng 1109'),
(111, 'Đội bóng 111'),
(1110, 'Đội bóng 1110'),
(1111, 'Đội bóng 1111'),
(1112, 'Đội bóng 1112'),
(1113, 'Đội bóng 1113'),
(1114, 'Đội bóng 1114'),
(1115, 'Đội bóng 1115'),
(1116, 'Đội bóng 1116'),
(1117, 'Đội bóng 1117'),
(1118, 'Đội bóng 1118'),
(1119, 'Đội bóng 1119'),
(112, 'Đội bóng 112'),
(1120, 'Đội bóng 1120'),
(1121, 'Đội bóng 1121'),
(1122, 'Đội bóng 1122'),
(1123, 'Đội bóng 1123'),
(1124, 'Đội bóng 1124'),
(1125, 'Đội bóng 1125'),
(1126, 'Đội bóng 1126'),
(1127, 'Đội bóng 1127'),
(1128, 'Đội bóng 1128'),
(1129, 'Đội bóng 1129'),
(113, 'Đội bóng 113'),
(1130, 'Đội bóng 1130'),
(1131, 'Đội bóng 1131'),
(1132, 'Đội bóng 1132'),
(1133, 'Đội bóng 1133'),
(1134, 'Đội bóng 1134'),
(1135, 'Đội bóng 1135'),
(1136, 'Đội bóng 1136'),
(1137, 'Đội bóng 1137'),
(1138, 'Đội bóng 1138'),
(1139, 'Đội bóng 1139'),
(114, 'Đội bóng 114'),
(1140, 'Đội bóng 1140'),
(1141, 'Đội bóng 1141'),
(1142, 'Đội bóng 1142'),
(1143, 'Đội bóng 1143'),
(1144, 'Đội bóng 1144'),
(1145, 'Đội bóng 1145'),
(1146, 'Đội bóng 1146'),
(1147, 'Đội bóng 1147'),
(1148, 'Đội bóng 1148'),
(1149, 'Đội bóng 1149'),
(115, 'Đội bóng 115'),
(1150, 'Đội bóng 1150'),
(1151, 'Đội bóng 1151'),
(1152, 'Đội bóng 1152'),
(1153, 'Đội bóng 1153'),
(1154, 'Đội bóng 1154'),
(1155, 'Đội bóng 1155'),
(1156, 'Đội bóng 1156'),
(1157, 'Đội bóng 1157'),
(1158, 'Đội bóng 1158'),
(1159, 'Đội bóng 1159'),
(116, 'Đội bóng 116'),
(1160, 'Đội bóng 1160'),
(1161, 'Đội bóng 1161'),
(1162, 'Đội bóng 1162'),
(1163, 'Đội bóng 1163'),
(1164, 'Đội bóng 1164'),
(1165, 'Đội bóng 1165'),
(1166, 'Đội bóng 1166'),
(1167, 'Đội bóng 1167'),
(1168, 'Đội bóng 1168'),
(1169, 'Đội bóng 1169'),
(117, 'Đội bóng 117'),
(1170, 'Đội bóng 1170'),
(1171, 'Đội bóng 1171'),
(1172, 'Đội bóng 1172'),
(1173, 'Đội bóng 1173'),
(1174, 'Đội bóng 1174'),
(1175, 'Đội bóng 1175'),
(1176, 'Đội bóng 1176'),
(1177, 'Đội bóng 1177'),
(1178, 'Đội bóng 1178'),
(1179, 'Đội bóng 1179'),
(118, 'Đội bóng 118'),
(1180, 'Đội bóng 1180'),
(1181, 'Đội bóng 1181'),
(1182, 'Đội bóng 1182'),
(1183, 'Đội bóng 1183'),
(1184, 'Đội bóng 1184'),
(1185, 'Đội bóng 1185'),
(1186, 'Đội bóng 1186'),
(1187, 'Đội bóng 1187'),
(1188, 'Đội bóng 1188'),
(1189, 'Đội bóng 1189'),
(119, 'Đội bóng 119'),
(1190, 'Đội bóng 1190'),
(1191, 'Đội bóng 1191'),
(1192, 'Đội bóng 1192'),
(1193, 'Đội bóng 1193'),
(1194, 'Đội bóng 1194'),
(1195, 'Đội bóng 1195'),
(1196, 'Đội bóng 1196'),
(1197, 'Đội bóng 1197'),
(1198, 'Đội bóng 1198'),
(1199, 'Đội bóng 1199'),
(12, 'Đội bóng 12'),
(120, 'Đội bóng 120'),
(1200, 'Đội bóng 1200'),
(1201, 'Đội bóng 1201'),
(1202, 'Đội bóng 1202'),
(1203, 'Đội bóng 1203'),
(1204, 'Đội bóng 1204'),
(1205, 'Đội bóng 1205'),
(1206, 'Đội bóng 1206'),
(1207, 'Đội bóng 1207'),
(1208, 'Đội bóng 1208'),
(1209, 'Đội bóng 1209'),
(121, 'Đội bóng 121'),
(1210, 'Đội bóng 1210'),
(1211, 'Đội bóng 1211'),
(1212, 'Đội bóng 1212'),
(1213, 'Đội bóng 1213'),
(1214, 'Đội bóng 1214'),
(1215, 'Đội bóng 1215'),
(1216, 'Đội bóng 1216'),
(1217, 'Đội bóng 1217'),
(1218, 'Đội bóng 1218'),
(1219, 'Đội bóng 1219'),
(122, 'Đội bóng 122'),
(1220, 'Đội bóng 1220'),
(1221, 'Đội bóng 1221'),
(1222, 'Đội bóng 1222'),
(1223, 'Đội bóng 1223'),
(1224, 'Đội bóng 1224'),
(1225, 'Đội bóng 1225'),
(1226, 'Đội bóng 1226'),
(1227, 'Đội bóng 1227'),
(1228, 'Đội bóng 1228'),
(1229, 'Đội bóng 1229'),
(123, 'Đội bóng 123'),
(1230, 'Đội bóng 1230'),
(1231, 'Đội bóng 1231'),
(1232, 'Đội bóng 1232'),
(1233, 'Đội bóng 1233'),
(1234, 'Đội bóng 1234'),
(1235, 'Đội bóng 1235'),
(1236, 'Đội bóng 1236'),
(1237, 'Đội bóng 1237'),
(1238, 'Đội bóng 1238'),
(1239, 'Đội bóng 1239'),
(124, 'Đội bóng 124'),
(1240, 'Đội bóng 1240'),
(1241, 'Đội bóng 1241'),
(1242, 'Đội bóng 1242'),
(1243, 'Đội bóng 1243'),
(1244, 'Đội bóng 1244'),
(1245, 'Đội bóng 1245'),
(1246, 'Đội bóng 1246'),
(1247, 'Đội bóng 1247'),
(1248, 'Đội bóng 1248'),
(1249, 'Đội bóng 1249'),
(125, 'Đội bóng 125'),
(1250, 'Đội bóng 1250'),
(1251, 'Đội bóng 1251'),
(1252, 'Đội bóng 1252'),
(1253, 'Đội bóng 1253'),
(1254, 'Đội bóng 1254'),
(1255, 'Đội bóng 1255'),
(1256, 'Đội bóng 1256'),
(1257, 'Đội bóng 1257'),
(1258, 'Đội bóng 1258'),
(1259, 'Đội bóng 1259'),
(126, 'Đội bóng 126'),
(1260, 'Đội bóng 1260'),
(1261, 'Đội bóng 1261'),
(1262, 'Đội bóng 1262'),
(1263, 'Đội bóng 1263'),
(1264, 'Đội bóng 1264'),
(1265, 'Đội bóng 1265'),
(1266, 'Đội bóng 1266'),
(1267, 'Đội bóng 1267'),
(1268, 'Đội bóng 1268'),
(1269, 'Đội bóng 1269'),
(127, 'Đội bóng 127'),
(1270, 'Đội bóng 1270'),
(1271, 'Đội bóng 1271'),
(1272, 'Đội bóng 1272'),
(1273, 'Đội bóng 1273'),
(1274, 'Đội bóng 1274'),
(1275, 'Đội bóng 1275'),
(1276, 'Đội bóng 1276'),
(1277, 'Đội bóng 1277'),
(1278, 'Đội bóng 1278'),
(1279, 'Đội bóng 1279'),
(128, 'Đội bóng 128'),
(1280, 'Đội bóng 1280'),
(1281, 'Đội bóng 1281'),
(1282, 'Đội bóng 1282'),
(1283, 'Đội bóng 1283'),
(1284, 'Đội bóng 1284'),
(1285, 'Đội bóng 1285'),
(1286, 'Đội bóng 1286'),
(1287, 'Đội bóng 1287'),
(1288, 'Đội bóng 1288'),
(1289, 'Đội bóng 1289'),
(129, 'Đội bóng 129'),
(1290, 'Đội bóng 1290'),
(1291, 'Đội bóng 1291'),
(1292, 'Đội bóng 1292'),
(1293, 'Đội bóng 1293'),
(1294, 'Đội bóng 1294'),
(1295, 'Đội bóng 1295'),
(1296, 'Đội bóng 1296'),
(1297, 'Đội bóng 1297'),
(1298, 'Đội bóng 1298'),
(1299, 'Đội bóng 1299'),
(13, 'Đội bóng 13'),
(130, 'Đội bóng 130'),
(1300, 'Đội bóng 1300'),
(1301, 'Đội bóng 1301'),
(1302, 'Đội bóng 1302'),
(1303, 'Đội bóng 1303'),
(1304, 'Đội bóng 1304'),
(1305, 'Đội bóng 1305'),
(1306, 'Đội bóng 1306'),
(1307, 'Đội bóng 1307'),
(1308, 'Đội bóng 1308'),
(1309, 'Đội bóng 1309'),
(131, 'Đội bóng 131'),
(1310, 'Đội bóng 1310'),
(1311, 'Đội bóng 1311'),
(1312, 'Đội bóng 1312'),
(1313, 'Đội bóng 1313'),
(1314, 'Đội bóng 1314'),
(1315, 'Đội bóng 1315'),
(1316, 'Đội bóng 1316'),
(1317, 'Đội bóng 1317'),
(1318, 'Đội bóng 1318'),
(1319, 'Đội bóng 1319'),
(132, 'Đội bóng 132'),
(1320, 'Đội bóng 1320'),
(1321, 'Đội bóng 1321'),
(1322, 'Đội bóng 1322'),
(1323, 'Đội bóng 1323'),
(1324, 'Đội bóng 1324'),
(1325, 'Đội bóng 1325'),
(1326, 'Đội bóng 1326'),
(1327, 'Đội bóng 1327'),
(1328, 'Đội bóng 1328'),
(1329, 'Đội bóng 1329'),
(133, 'Đội bóng 133'),
(1330, 'Đội bóng 1330'),
(1331, 'Đội bóng 1331'),
(1332, 'Đội bóng 1332'),
(1333, 'Đội bóng 1333'),
(1334, 'Đội bóng 1334'),
(1335, 'Đội bóng 1335'),
(1336, 'Đội bóng 1336'),
(1337, 'Đội bóng 1337'),
(1338, 'Đội bóng 1338'),
(1339, 'Đội bóng 1339'),
(134, 'Đội bóng 134'),
(1340, 'Đội bóng 1340'),
(1341, 'Đội bóng 1341'),
(1342, 'Đội bóng 1342'),
(1343, 'Đội bóng 1343'),
(1344, 'Đội bóng 1344'),
(1345, 'Đội bóng 1345'),
(1346, 'Đội bóng 1346'),
(1347, 'Đội bóng 1347'),
(1348, 'Đội bóng 1348'),
(1349, 'Đội bóng 1349'),
(135, 'Đội bóng 135'),
(1350, 'Đội bóng 1350'),
(1351, 'Đội bóng 1351'),
(1352, 'Đội bóng 1352'),
(1353, 'Đội bóng 1353'),
(1354, 'Đội bóng 1354'),
(1355, 'Đội bóng 1355'),
(1356, 'Đội bóng 1356'),
(1357, 'Đội bóng 1357'),
(1358, 'Đội bóng 1358'),
(1359, 'Đội bóng 1359'),
(136, 'Đội bóng 136'),
(1360, 'Đội bóng 1360'),
(1361, 'Đội bóng 1361'),
(1362, 'Đội bóng 1362'),
(1363, 'Đội bóng 1363'),
(1364, 'Đội bóng 1364'),
(1365, 'Đội bóng 1365'),
(1366, 'Đội bóng 1366'),
(1367, 'Đội bóng 1367'),
(1368, 'Đội bóng 1368'),
(1369, 'Đội bóng 1369'),
(137, 'Đội bóng 137'),
(1370, 'Đội bóng 1370'),
(1371, 'Đội bóng 1371'),
(1372, 'Đội bóng 1372'),
(1373, 'Đội bóng 1373'),
(1374, 'Đội bóng 1374'),
(1375, 'Đội bóng 1375'),
(1376, 'Đội bóng 1376'),
(1377, 'Đội bóng 1377'),
(1378, 'Đội bóng 1378'),
(1379, 'Đội bóng 1379'),
(138, 'Đội bóng 138'),
(1380, 'Đội bóng 1380'),
(1381, 'Đội bóng 1381'),
(1382, 'Đội bóng 1382'),
(1383, 'Đội bóng 1383'),
(1384, 'Đội bóng 1384'),
(1385, 'Đội bóng 1385'),
(1386, 'Đội bóng 1386'),
(1387, 'Đội bóng 1387'),
(1388, 'Đội bóng 1388'),
(1389, 'Đội bóng 1389'),
(139, 'Đội bóng 139'),
(1390, 'Đội bóng 1390'),
(1391, 'Đội bóng 1391'),
(1392, 'Đội bóng 1392'),
(1393, 'Đội bóng 1393'),
(1394, 'Đội bóng 1394'),
(1395, 'Đội bóng 1395'),
(1396, 'Đội bóng 1396'),
(1397, 'Đội bóng 1397'),
(1398, 'Đội bóng 1398'),
(1399, 'Đội bóng 1399'),
(14, 'Đội bóng 14'),
(140, 'Đội bóng 140'),
(1400, 'Đội bóng 1400'),
(141, 'Đội bóng 141'),
(142, 'Đội bóng 142'),
(143, 'Đội bóng 143'),
(144, 'Đội bóng 144'),
(145, 'Đội bóng 145'),
(146, 'Đội bóng 146'),
(147, 'Đội bóng 147'),
(148, 'Đội bóng 148'),
(149, 'Đội bóng 149'),
(15, 'Đội bóng 15'),
(150, 'Đội bóng 150'),
(151, 'Đội bóng 151'),
(152, 'Đội bóng 152'),
(153, 'Đội bóng 153'),
(154, 'Đội bóng 154'),
(155, 'Đội bóng 155'),
(156, 'Đội bóng 156'),
(157, 'Đội bóng 157'),
(158, 'Đội bóng 158'),
(159, 'Đội bóng 159'),
(16, 'Đội bóng 16'),
(160, 'Đội bóng 160'),
(161, 'Đội bóng 161'),
(162, 'Đội bóng 162'),
(163, 'Đội bóng 163'),
(164, 'Đội bóng 164'),
(165, 'Đội bóng 165'),
(166, 'Đội bóng 166'),
(167, 'Đội bóng 167'),
(168, 'Đội bóng 168'),
(169, 'Đội bóng 169'),
(17, 'Đội bóng 17'),
(170, 'Đội bóng 170'),
(171, 'Đội bóng 171'),
(172, 'Đội bóng 172'),
(173, 'Đội bóng 173'),
(174, 'Đội bóng 174'),
(175, 'Đội bóng 175'),
(176, 'Đội bóng 176'),
(177, 'Đội bóng 177'),
(178, 'Đội bóng 178'),
(179, 'Đội bóng 179'),
(18, 'Đội bóng 18'),
(180, 'Đội bóng 180'),
(181, 'Đội bóng 181'),
(182, 'Đội bóng 182'),
(183, 'Đội bóng 183'),
(184, 'Đội bóng 184'),
(185, 'Đội bóng 185'),
(186, 'Đội bóng 186'),
(187, 'Đội bóng 187'),
(188, 'Đội bóng 188'),
(189, 'Đội bóng 189'),
(19, 'Đội bóng 19'),
(190, 'Đội bóng 190'),
(191, 'Đội bóng 191'),
(192, 'Đội bóng 192'),
(193, 'Đội bóng 193'),
(194, 'Đội bóng 194'),
(195, 'Đội bóng 195'),
(196, 'Đội bóng 196'),
(197, 'Đội bóng 197'),
(198, 'Đội bóng 198'),
(199, 'Đội bóng 199'),
(2, 'Đội bóng 2'),
(20, 'Đội bóng 20'),
(200, 'Đội bóng 200'),
(201, 'Đội bóng 201'),
(202, 'Đội bóng 202'),
(203, 'Đội bóng 203'),
(204, 'Đội bóng 204'),
(205, 'Đội bóng 205'),
(206, 'Đội bóng 206'),
(207, 'Đội bóng 207'),
(208, 'Đội bóng 208'),
(209, 'Đội bóng 209'),
(21, 'Đội bóng 21'),
(210, 'Đội bóng 210'),
(211, 'Đội bóng 211'),
(212, 'Đội bóng 212'),
(213, 'Đội bóng 213'),
(214, 'Đội bóng 214'),
(215, 'Đội bóng 215'),
(216, 'Đội bóng 216'),
(217, 'Đội bóng 217'),
(218, 'Đội bóng 218'),
(219, 'Đội bóng 219'),
(22, 'Đội bóng 22'),
(220, 'Đội bóng 220'),
(221, 'Đội bóng 221'),
(222, 'Đội bóng 222'),
(223, 'Đội bóng 223'),
(224, 'Đội bóng 224'),
(225, 'Đội bóng 225'),
(226, 'Đội bóng 226'),
(227, 'Đội bóng 227'),
(228, 'Đội bóng 228'),
(229, 'Đội bóng 229'),
(23, 'Đội bóng 23'),
(230, 'Đội bóng 230'),
(231, 'Đội bóng 231'),
(232, 'Đội bóng 232'),
(233, 'Đội bóng 233'),
(234, 'Đội bóng 234'),
(235, 'Đội bóng 235'),
(236, 'Đội bóng 236'),
(237, 'Đội bóng 237'),
(238, 'Đội bóng 238'),
(239, 'Đội bóng 239'),
(24, 'Đội bóng 24'),
(240, 'Đội bóng 240'),
(241, 'Đội bóng 241'),
(242, 'Đội bóng 242'),
(243, 'Đội bóng 243'),
(244, 'Đội bóng 244'),
(245, 'Đội bóng 245'),
(246, 'Đội bóng 246'),
(247, 'Đội bóng 247'),
(248, 'Đội bóng 248'),
(249, 'Đội bóng 249'),
(25, 'Đội bóng 25'),
(250, 'Đội bóng 250'),
(251, 'Đội bóng 251'),
(252, 'Đội bóng 252'),
(253, 'Đội bóng 253'),
(254, 'Đội bóng 254'),
(255, 'Đội bóng 255'),
(256, 'Đội bóng 256'),
(257, 'Đội bóng 257'),
(258, 'Đội bóng 258'),
(259, 'Đội bóng 259'),
(26, 'Đội bóng 26'),
(260, 'Đội bóng 260'),
(261, 'Đội bóng 261'),
(262, 'Đội bóng 262'),
(263, 'Đội bóng 263'),
(264, 'Đội bóng 264'),
(265, 'Đội bóng 265'),
(266, 'Đội bóng 266'),
(267, 'Đội bóng 267'),
(268, 'Đội bóng 268'),
(269, 'Đội bóng 269'),
(27, 'Đội bóng 27'),
(270, 'Đội bóng 270'),
(271, 'Đội bóng 271'),
(272, 'Đội bóng 272'),
(273, 'Đội bóng 273'),
(274, 'Đội bóng 274'),
(275, 'Đội bóng 275'),
(276, 'Đội bóng 276'),
(277, 'Đội bóng 277'),
(278, 'Đội bóng 278'),
(279, 'Đội bóng 279'),
(28, 'Đội bóng 28'),
(280, 'Đội bóng 280'),
(281, 'Đội bóng 281'),
(282, 'Đội bóng 282'),
(283, 'Đội bóng 283'),
(284, 'Đội bóng 284'),
(285, 'Đội bóng 285'),
(286, 'Đội bóng 286'),
(287, 'Đội bóng 287'),
(288, 'Đội bóng 288'),
(289, 'Đội bóng 289'),
(29, 'Đội bóng 29'),
(290, 'Đội bóng 290'),
(291, 'Đội bóng 291'),
(292, 'Đội bóng 292'),
(293, 'Đội bóng 293'),
(294, 'Đội bóng 294'),
(295, 'Đội bóng 295'),
(296, 'Đội bóng 296'),
(297, 'Đội bóng 297'),
(298, 'Đội bóng 298'),
(299, 'Đội bóng 299'),
(3, 'Đội bóng 3'),
(30, 'Đội bóng 30'),
(300, 'Đội bóng 300'),
(301, 'Đội bóng 301'),
(302, 'Đội bóng 302'),
(303, 'Đội bóng 303'),
(304, 'Đội bóng 304'),
(305, 'Đội bóng 305'),
(306, 'Đội bóng 306'),
(307, 'Đội bóng 307'),
(308, 'Đội bóng 308'),
(309, 'Đội bóng 309'),
(31, 'Đội bóng 31'),
(310, 'Đội bóng 310'),
(311, 'Đội bóng 311'),
(312, 'Đội bóng 312'),
(313, 'Đội bóng 313'),
(314, 'Đội bóng 314'),
(315, 'Đội bóng 315'),
(316, 'Đội bóng 316'),
(317, 'Đội bóng 317'),
(318, 'Đội bóng 318'),
(319, 'Đội bóng 319'),
(32, 'Đội bóng 32'),
(320, 'Đội bóng 320'),
(321, 'Đội bóng 321'),
(322, 'Đội bóng 322'),
(323, 'Đội bóng 323'),
(324, 'Đội bóng 324'),
(325, 'Đội bóng 325'),
(326, 'Đội bóng 326'),
(327, 'Đội bóng 327'),
(328, 'Đội bóng 328'),
(329, 'Đội bóng 329'),
(33, 'Đội bóng 33'),
(330, 'Đội bóng 330'),
(331, 'Đội bóng 331'),
(332, 'Đội bóng 332'),
(333, 'Đội bóng 333'),
(334, 'Đội bóng 334'),
(335, 'Đội bóng 335'),
(336, 'Đội bóng 336'),
(337, 'Đội bóng 337'),
(338, 'Đội bóng 338'),
(339, 'Đội bóng 339'),
(34, 'Đội bóng 34'),
(340, 'Đội bóng 340'),
(341, 'Đội bóng 341'),
(342, 'Đội bóng 342'),
(343, 'Đội bóng 343'),
(344, 'Đội bóng 344'),
(345, 'Đội bóng 345'),
(346, 'Đội bóng 346'),
(347, 'Đội bóng 347'),
(348, 'Đội bóng 348'),
(349, 'Đội bóng 349'),
(35, 'Đội bóng 35'),
(350, 'Đội bóng 350'),
(351, 'Đội bóng 351'),
(352, 'Đội bóng 352'),
(353, 'Đội bóng 353'),
(354, 'Đội bóng 354'),
(355, 'Đội bóng 355'),
(356, 'Đội bóng 356'),
(357, 'Đội bóng 357'),
(358, 'Đội bóng 358'),
(359, 'Đội bóng 359'),
(36, 'Đội bóng 36'),
(360, 'Đội bóng 360'),
(361, 'Đội bóng 361'),
(362, 'Đội bóng 362'),
(363, 'Đội bóng 363'),
(364, 'Đội bóng 364'),
(365, 'Đội bóng 365'),
(366, 'Đội bóng 366'),
(367, 'Đội bóng 367'),
(368, 'Đội bóng 368'),
(369, 'Đội bóng 369'),
(37, 'Đội bóng 37'),
(370, 'Đội bóng 370'),
(371, 'Đội bóng 371'),
(372, 'Đội bóng 372'),
(373, 'Đội bóng 373'),
(374, 'Đội bóng 374'),
(375, 'Đội bóng 375'),
(376, 'Đội bóng 376'),
(377, 'Đội bóng 377'),
(378, 'Đội bóng 378'),
(379, 'Đội bóng 379'),
(38, 'Đội bóng 38'),
(380, 'Đội bóng 380'),
(381, 'Đội bóng 381'),
(382, 'Đội bóng 382'),
(383, 'Đội bóng 383'),
(384, 'Đội bóng 384'),
(385, 'Đội bóng 385'),
(386, 'Đội bóng 386'),
(387, 'Đội bóng 387'),
(388, 'Đội bóng 388'),
(389, 'Đội bóng 389'),
(39, 'Đội bóng 39'),
(390, 'Đội bóng 390'),
(391, 'Đội bóng 391'),
(392, 'Đội bóng 392'),
(393, 'Đội bóng 393'),
(394, 'Đội bóng 394'),
(395, 'Đội bóng 395'),
(396, 'Đội bóng 396'),
(397, 'Đội bóng 397'),
(398, 'Đội bóng 398'),
(399, 'Đội bóng 399'),
(4, 'Đội bóng 4'),
(40, 'Đội bóng 40'),
(400, 'Đội bóng 400'),
(401, 'Đội bóng 401'),
(402, 'Đội bóng 402'),
(403, 'Đội bóng 403'),
(404, 'Đội bóng 404'),
(405, 'Đội bóng 405'),
(406, 'Đội bóng 406'),
(407, 'Đội bóng 407'),
(408, 'Đội bóng 408'),
(409, 'Đội bóng 409'),
(41, 'Đội bóng 41'),
(410, 'Đội bóng 410'),
(411, 'Đội bóng 411'),
(412, 'Đội bóng 412'),
(413, 'Đội bóng 413'),
(414, 'Đội bóng 414'),
(415, 'Đội bóng 415'),
(416, 'Đội bóng 416'),
(417, 'Đội bóng 417'),
(418, 'Đội bóng 418'),
(419, 'Đội bóng 419'),
(42, 'Đội bóng 42'),
(420, 'Đội bóng 420'),
(421, 'Đội bóng 421'),
(422, 'Đội bóng 422'),
(423, 'Đội bóng 423'),
(424, 'Đội bóng 424'),
(425, 'Đội bóng 425'),
(426, 'Đội bóng 426'),
(427, 'Đội bóng 427'),
(428, 'Đội bóng 428'),
(429, 'Đội bóng 429'),
(43, 'Đội bóng 43'),
(430, 'Đội bóng 430'),
(431, 'Đội bóng 431'),
(432, 'Đội bóng 432'),
(433, 'Đội bóng 433'),
(434, 'Đội bóng 434'),
(435, 'Đội bóng 435'),
(436, 'Đội bóng 436'),
(437, 'Đội bóng 437'),
(438, 'Đội bóng 438'),
(439, 'Đội bóng 439'),
(44, 'Đội bóng 44'),
(440, 'Đội bóng 440'),
(441, 'Đội bóng 441'),
(442, 'Đội bóng 442'),
(443, 'Đội bóng 443'),
(444, 'Đội bóng 444'),
(445, 'Đội bóng 445'),
(446, 'Đội bóng 446'),
(447, 'Đội bóng 447'),
(448, 'Đội bóng 448'),
(449, 'Đội bóng 449'),
(45, 'Đội bóng 45'),
(450, 'Đội bóng 450'),
(451, 'Đội bóng 451'),
(452, 'Đội bóng 452'),
(453, 'Đội bóng 453'),
(454, 'Đội bóng 454'),
(455, 'Đội bóng 455'),
(456, 'Đội bóng 456'),
(457, 'Đội bóng 457'),
(458, 'Đội bóng 458'),
(459, 'Đội bóng 459'),
(46, 'Đội bóng 46'),
(460, 'Đội bóng 460'),
(461, 'Đội bóng 461'),
(462, 'Đội bóng 462'),
(463, 'Đội bóng 463'),
(464, 'Đội bóng 464'),
(465, 'Đội bóng 465'),
(466, 'Đội bóng 466'),
(467, 'Đội bóng 467'),
(468, 'Đội bóng 468'),
(469, 'Đội bóng 469'),
(47, 'Đội bóng 47'),
(470, 'Đội bóng 470'),
(471, 'Đội bóng 471'),
(472, 'Đội bóng 472'),
(473, 'Đội bóng 473'),
(474, 'Đội bóng 474'),
(475, 'Đội bóng 475'),
(476, 'Đội bóng 476'),
(477, 'Đội bóng 477'),
(478, 'Đội bóng 478'),
(479, 'Đội bóng 479'),
(48, 'Đội bóng 48'),
(480, 'Đội bóng 480'),
(481, 'Đội bóng 481'),
(482, 'Đội bóng 482'),
(483, 'Đội bóng 483'),
(484, 'Đội bóng 484'),
(485, 'Đội bóng 485'),
(486, 'Đội bóng 486'),
(487, 'Đội bóng 487'),
(488, 'Đội bóng 488'),
(489, 'Đội bóng 489'),
(49, 'Đội bóng 49'),
(490, 'Đội bóng 490'),
(491, 'Đội bóng 491'),
(492, 'Đội bóng 492'),
(493, 'Đội bóng 493'),
(494, 'Đội bóng 494'),
(495, 'Đội bóng 495'),
(496, 'Đội bóng 496'),
(497, 'Đội bóng 497'),
(498, 'Đội bóng 498'),
(499, 'Đội bóng 499'),
(5, 'Đội bóng 5'),
(50, 'Đội bóng 50'),
(500, 'Đội bóng 500'),
(501, 'Đội bóng 501'),
(502, 'Đội bóng 502'),
(503, 'Đội bóng 503'),
(504, 'Đội bóng 504'),
(505, 'Đội bóng 505'),
(506, 'Đội bóng 506'),
(507, 'Đội bóng 507'),
(508, 'Đội bóng 508'),
(509, 'Đội bóng 509'),
(51, 'Đội bóng 51'),
(510, 'Đội bóng 510'),
(511, 'Đội bóng 511'),
(512, 'Đội bóng 512'),
(513, 'Đội bóng 513'),
(514, 'Đội bóng 514'),
(515, 'Đội bóng 515'),
(516, 'Đội bóng 516'),
(517, 'Đội bóng 517'),
(518, 'Đội bóng 518'),
(519, 'Đội bóng 519'),
(52, 'Đội bóng 52'),
(520, 'Đội bóng 520'),
(521, 'Đội bóng 521'),
(522, 'Đội bóng 522'),
(523, 'Đội bóng 523'),
(524, 'Đội bóng 524'),
(525, 'Đội bóng 525'),
(526, 'Đội bóng 526'),
(527, 'Đội bóng 527'),
(528, 'Đội bóng 528'),
(529, 'Đội bóng 529'),
(53, 'Đội bóng 53'),
(530, 'Đội bóng 530'),
(531, 'Đội bóng 531'),
(532, 'Đội bóng 532'),
(533, 'Đội bóng 533'),
(534, 'Đội bóng 534'),
(535, 'Đội bóng 535'),
(536, 'Đội bóng 536'),
(537, 'Đội bóng 537'),
(538, 'Đội bóng 538'),
(539, 'Đội bóng 539'),
(54, 'Đội bóng 54'),
(540, 'Đội bóng 540'),
(541, 'Đội bóng 541'),
(542, 'Đội bóng 542'),
(543, 'Đội bóng 543'),
(544, 'Đội bóng 544'),
(545, 'Đội bóng 545'),
(546, 'Đội bóng 546'),
(547, 'Đội bóng 547'),
(548, 'Đội bóng 548'),
(549, 'Đội bóng 549'),
(55, 'Đội bóng 55'),
(550, 'Đội bóng 550'),
(551, 'Đội bóng 551'),
(552, 'Đội bóng 552'),
(553, 'Đội bóng 553'),
(554, 'Đội bóng 554'),
(555, 'Đội bóng 555'),
(556, 'Đội bóng 556'),
(557, 'Đội bóng 557'),
(558, 'Đội bóng 558'),
(559, 'Đội bóng 559'),
(56, 'Đội bóng 56'),
(560, 'Đội bóng 560'),
(561, 'Đội bóng 561'),
(562, 'Đội bóng 562'),
(563, 'Đội bóng 563'),
(564, 'Đội bóng 564'),
(565, 'Đội bóng 565'),
(566, 'Đội bóng 566'),
(567, 'Đội bóng 567'),
(568, 'Đội bóng 568'),
(569, 'Đội bóng 569'),
(57, 'Đội bóng 57'),
(570, 'Đội bóng 570'),
(571, 'Đội bóng 571'),
(572, 'Đội bóng 572'),
(573, 'Đội bóng 573'),
(574, 'Đội bóng 574'),
(575, 'Đội bóng 575'),
(576, 'Đội bóng 576'),
(577, 'Đội bóng 577'),
(578, 'Đội bóng 578'),
(579, 'Đội bóng 579'),
(58, 'Đội bóng 58'),
(580, 'Đội bóng 580'),
(581, 'Đội bóng 581'),
(582, 'Đội bóng 582'),
(583, 'Đội bóng 583'),
(584, 'Đội bóng 584'),
(585, 'Đội bóng 585'),
(586, 'Đội bóng 586'),
(587, 'Đội bóng 587'),
(588, 'Đội bóng 588'),
(589, 'Đội bóng 589'),
(59, 'Đội bóng 59'),
(590, 'Đội bóng 590'),
(591, 'Đội bóng 591'),
(592, 'Đội bóng 592'),
(593, 'Đội bóng 593'),
(594, 'Đội bóng 594'),
(595, 'Đội bóng 595'),
(596, 'Đội bóng 596'),
(597, 'Đội bóng 597'),
(598, 'Đội bóng 598'),
(599, 'Đội bóng 599'),
(6, 'Đội bóng 6'),
(60, 'Đội bóng 60'),
(600, 'Đội bóng 600'),
(601, 'Đội bóng 601'),
(602, 'Đội bóng 602'),
(603, 'Đội bóng 603'),
(604, 'Đội bóng 604'),
(605, 'Đội bóng 605'),
(606, 'Đội bóng 606'),
(607, 'Đội bóng 607'),
(608, 'Đội bóng 608'),
(609, 'Đội bóng 609'),
(61, 'Đội bóng 61'),
(610, 'Đội bóng 610'),
(611, 'Đội bóng 611'),
(612, 'Đội bóng 612'),
(613, 'Đội bóng 613'),
(614, 'Đội bóng 614'),
(615, 'Đội bóng 615'),
(616, 'Đội bóng 616'),
(617, 'Đội bóng 617'),
(618, 'Đội bóng 618'),
(619, 'Đội bóng 619'),
(62, 'Đội bóng 62'),
(620, 'Đội bóng 620'),
(621, 'Đội bóng 621'),
(622, 'Đội bóng 622'),
(623, 'Đội bóng 623'),
(624, 'Đội bóng 624'),
(625, 'Đội bóng 625'),
(626, 'Đội bóng 626'),
(627, 'Đội bóng 627'),
(628, 'Đội bóng 628'),
(629, 'Đội bóng 629'),
(63, 'Đội bóng 63'),
(630, 'Đội bóng 630'),
(631, 'Đội bóng 631'),
(632, 'Đội bóng 632'),
(633, 'Đội bóng 633'),
(634, 'Đội bóng 634'),
(635, 'Đội bóng 635'),
(636, 'Đội bóng 636'),
(637, 'Đội bóng 637'),
(638, 'Đội bóng 638'),
(639, 'Đội bóng 639'),
(64, 'Đội bóng 64'),
(640, 'Đội bóng 640'),
(641, 'Đội bóng 641'),
(642, 'Đội bóng 642'),
(643, 'Đội bóng 643'),
(644, 'Đội bóng 644'),
(645, 'Đội bóng 645'),
(646, 'Đội bóng 646'),
(647, 'Đội bóng 647'),
(648, 'Đội bóng 648'),
(649, 'Đội bóng 649'),
(65, 'Đội bóng 65'),
(650, 'Đội bóng 650'),
(651, 'Đội bóng 651'),
(652, 'Đội bóng 652'),
(653, 'Đội bóng 653'),
(654, 'Đội bóng 654'),
(655, 'Đội bóng 655'),
(656, 'Đội bóng 656'),
(657, 'Đội bóng 657'),
(658, 'Đội bóng 658'),
(659, 'Đội bóng 659'),
(66, 'Đội bóng 66'),
(660, 'Đội bóng 660'),
(661, 'Đội bóng 661'),
(662, 'Đội bóng 662'),
(663, 'Đội bóng 663'),
(664, 'Đội bóng 664'),
(665, 'Đội bóng 665'),
(666, 'Đội bóng 666'),
(667, 'Đội bóng 667'),
(668, 'Đội bóng 668'),
(669, 'Đội bóng 669'),
(67, 'Đội bóng 67'),
(670, 'Đội bóng 670'),
(671, 'Đội bóng 671'),
(672, 'Đội bóng 672'),
(673, 'Đội bóng 673'),
(674, 'Đội bóng 674'),
(675, 'Đội bóng 675'),
(676, 'Đội bóng 676'),
(677, 'Đội bóng 677'),
(678, 'Đội bóng 678'),
(679, 'Đội bóng 679'),
(68, 'Đội bóng 68'),
(680, 'Đội bóng 680'),
(681, 'Đội bóng 681'),
(682, 'Đội bóng 682'),
(683, 'Đội bóng 683'),
(684, 'Đội bóng 684'),
(685, 'Đội bóng 685'),
(686, 'Đội bóng 686'),
(687, 'Đội bóng 687'),
(688, 'Đội bóng 688'),
(689, 'Đội bóng 689'),
(69, 'Đội bóng 69'),
(690, 'Đội bóng 690'),
(691, 'Đội bóng 691'),
(692, 'Đội bóng 692'),
(693, 'Đội bóng 693'),
(694, 'Đội bóng 694'),
(695, 'Đội bóng 695'),
(696, 'Đội bóng 696'),
(697, 'Đội bóng 697'),
(698, 'Đội bóng 698'),
(699, 'Đội bóng 699'),
(7, 'Đội bóng 7'),
(70, 'Đội bóng 70'),
(700, 'Đội bóng 700'),
(701, 'Đội bóng 701'),
(702, 'Đội bóng 702'),
(703, 'Đội bóng 703'),
(704, 'Đội bóng 704'),
(705, 'Đội bóng 705'),
(706, 'Đội bóng 706'),
(707, 'Đội bóng 707'),
(708, 'Đội bóng 708'),
(709, 'Đội bóng 709'),
(71, 'Đội bóng 71'),
(710, 'Đội bóng 710'),
(711, 'Đội bóng 711'),
(712, 'Đội bóng 712'),
(713, 'Đội bóng 713'),
(714, 'Đội bóng 714'),
(715, 'Đội bóng 715'),
(716, 'Đội bóng 716'),
(717, 'Đội bóng 717'),
(718, 'Đội bóng 718'),
(719, 'Đội bóng 719'),
(72, 'Đội bóng 72'),
(720, 'Đội bóng 720'),
(721, 'Đội bóng 721'),
(722, 'Đội bóng 722'),
(723, 'Đội bóng 723'),
(724, 'Đội bóng 724'),
(725, 'Đội bóng 725'),
(726, 'Đội bóng 726'),
(727, 'Đội bóng 727'),
(728, 'Đội bóng 728'),
(729, 'Đội bóng 729'),
(73, 'Đội bóng 73'),
(730, 'Đội bóng 730'),
(731, 'Đội bóng 731'),
(732, 'Đội bóng 732'),
(733, 'Đội bóng 733'),
(734, 'Đội bóng 734'),
(735, 'Đội bóng 735'),
(736, 'Đội bóng 736'),
(737, 'Đội bóng 737'),
(738, 'Đội bóng 738'),
(739, 'Đội bóng 739'),
(74, 'Đội bóng 74'),
(740, 'Đội bóng 740'),
(741, 'Đội bóng 741'),
(742, 'Đội bóng 742'),
(743, 'Đội bóng 743'),
(744, 'Đội bóng 744'),
(745, 'Đội bóng 745'),
(746, 'Đội bóng 746'),
(747, 'Đội bóng 747'),
(748, 'Đội bóng 748'),
(749, 'Đội bóng 749'),
(75, 'Đội bóng 75'),
(750, 'Đội bóng 750'),
(751, 'Đội bóng 751'),
(752, 'Đội bóng 752'),
(753, 'Đội bóng 753'),
(754, 'Đội bóng 754'),
(755, 'Đội bóng 755'),
(756, 'Đội bóng 756'),
(757, 'Đội bóng 757'),
(758, 'Đội bóng 758'),
(759, 'Đội bóng 759'),
(76, 'Đội bóng 76'),
(760, 'Đội bóng 760'),
(761, 'Đội bóng 761'),
(762, 'Đội bóng 762'),
(763, 'Đội bóng 763'),
(764, 'Đội bóng 764'),
(765, 'Đội bóng 765'),
(766, 'Đội bóng 766'),
(767, 'Đội bóng 767'),
(768, 'Đội bóng 768'),
(769, 'Đội bóng 769'),
(77, 'Đội bóng 77'),
(770, 'Đội bóng 770'),
(771, 'Đội bóng 771'),
(772, 'Đội bóng 772'),
(773, 'Đội bóng 773'),
(774, 'Đội bóng 774'),
(775, 'Đội bóng 775'),
(776, 'Đội bóng 776'),
(777, 'Đội bóng 777'),
(778, 'Đội bóng 778'),
(779, 'Đội bóng 779'),
(78, 'Đội bóng 78'),
(780, 'Đội bóng 780'),
(781, 'Đội bóng 781'),
(782, 'Đội bóng 782'),
(783, 'Đội bóng 783'),
(784, 'Đội bóng 784'),
(785, 'Đội bóng 785'),
(786, 'Đội bóng 786'),
(787, 'Đội bóng 787'),
(788, 'Đội bóng 788'),
(789, 'Đội bóng 789'),
(79, 'Đội bóng 79'),
(790, 'Đội bóng 790'),
(791, 'Đội bóng 791'),
(792, 'Đội bóng 792'),
(793, 'Đội bóng 793'),
(794, 'Đội bóng 794'),
(795, 'Đội bóng 795'),
(796, 'Đội bóng 796'),
(797, 'Đội bóng 797'),
(798, 'Đội bóng 798'),
(799, 'Đội bóng 799'),
(8, 'Đội bóng 8'),
(80, 'Đội bóng 80'),
(800, 'Đội bóng 800'),
(801, 'Đội bóng 801'),
(802, 'Đội bóng 802'),
(803, 'Đội bóng 803'),
(804, 'Đội bóng 804'),
(805, 'Đội bóng 805'),
(806, 'Đội bóng 806'),
(807, 'Đội bóng 807'),
(808, 'Đội bóng 808'),
(809, 'Đội bóng 809'),
(81, 'Đội bóng 81'),
(810, 'Đội bóng 810'),
(811, 'Đội bóng 811'),
(812, 'Đội bóng 812'),
(813, 'Đội bóng 813'),
(814, 'Đội bóng 814'),
(815, 'Đội bóng 815'),
(816, 'Đội bóng 816'),
(817, 'Đội bóng 817'),
(818, 'Đội bóng 818'),
(819, 'Đội bóng 819'),
(82, 'Đội bóng 82'),
(820, 'Đội bóng 820'),
(821, 'Đội bóng 821'),
(822, 'Đội bóng 822'),
(823, 'Đội bóng 823'),
(824, 'Đội bóng 824'),
(825, 'Đội bóng 825'),
(826, 'Đội bóng 826'),
(827, 'Đội bóng 827'),
(828, 'Đội bóng 828'),
(829, 'Đội bóng 829'),
(83, 'Đội bóng 83'),
(830, 'Đội bóng 830'),
(831, 'Đội bóng 831'),
(832, 'Đội bóng 832'),
(833, 'Đội bóng 833'),
(834, 'Đội bóng 834'),
(835, 'Đội bóng 835'),
(836, 'Đội bóng 836'),
(837, 'Đội bóng 837'),
(838, 'Đội bóng 838'),
(839, 'Đội bóng 839'),
(84, 'Đội bóng 84'),
(840, 'Đội bóng 840'),
(841, 'Đội bóng 841'),
(842, 'Đội bóng 842'),
(843, 'Đội bóng 843'),
(844, 'Đội bóng 844'),
(845, 'Đội bóng 845'),
(846, 'Đội bóng 846'),
(847, 'Đội bóng 847'),
(848, 'Đội bóng 848'),
(849, 'Đội bóng 849'),
(85, 'Đội bóng 85'),
(850, 'Đội bóng 850'),
(851, 'Đội bóng 851'),
(852, 'Đội bóng 852'),
(853, 'Đội bóng 853'),
(854, 'Đội bóng 854'),
(855, 'Đội bóng 855'),
(856, 'Đội bóng 856'),
(857, 'Đội bóng 857'),
(858, 'Đội bóng 858'),
(859, 'Đội bóng 859'),
(86, 'Đội bóng 86'),
(860, 'Đội bóng 860'),
(861, 'Đội bóng 861'),
(862, 'Đội bóng 862'),
(863, 'Đội bóng 863'),
(864, 'Đội bóng 864'),
(865, 'Đội bóng 865'),
(866, 'Đội bóng 866'),
(867, 'Đội bóng 867'),
(868, 'Đội bóng 868'),
(869, 'Đội bóng 869'),
(87, 'Đội bóng 87'),
(870, 'Đội bóng 870'),
(871, 'Đội bóng 871'),
(872, 'Đội bóng 872'),
(873, 'Đội bóng 873'),
(874, 'Đội bóng 874'),
(875, 'Đội bóng 875'),
(876, 'Đội bóng 876'),
(877, 'Đội bóng 877'),
(878, 'Đội bóng 878'),
(879, 'Đội bóng 879'),
(88, 'Đội bóng 88'),
(880, 'Đội bóng 880'),
(881, 'Đội bóng 881'),
(882, 'Đội bóng 882'),
(883, 'Đội bóng 883'),
(884, 'Đội bóng 884'),
(885, 'Đội bóng 885'),
(886, 'Đội bóng 886'),
(887, 'Đội bóng 887'),
(888, 'Đội bóng 888'),
(889, 'Đội bóng 889'),
(89, 'Đội bóng 89'),
(890, 'Đội bóng 890'),
(891, 'Đội bóng 891'),
(892, 'Đội bóng 892'),
(893, 'Đội bóng 893'),
(894, 'Đội bóng 894'),
(895, 'Đội bóng 895'),
(896, 'Đội bóng 896'),
(897, 'Đội bóng 897'),
(898, 'Đội bóng 898'),
(899, 'Đội bóng 899'),
(9, 'Đội bóng 9'),
(90, 'Đội bóng 90'),
(900, 'Đội bóng 900'),
(901, 'Đội bóng 901'),
(902, 'Đội bóng 902'),
(903, 'Đội bóng 903'),
(904, 'Đội bóng 904'),
(905, 'Đội bóng 905'),
(906, 'Đội bóng 906'),
(907, 'Đội bóng 907'),
(908, 'Đội bóng 908'),
(909, 'Đội bóng 909'),
(91, 'Đội bóng 91'),
(910, 'Đội bóng 910'),
(911, 'Đội bóng 911'),
(912, 'Đội bóng 912'),
(913, 'Đội bóng 913'),
(914, 'Đội bóng 914'),
(915, 'Đội bóng 915'),
(916, 'Đội bóng 916'),
(917, 'Đội bóng 917'),
(918, 'Đội bóng 918'),
(919, 'Đội bóng 919'),
(92, 'Đội bóng 92'),
(920, 'Đội bóng 920'),
(921, 'Đội bóng 921'),
(922, 'Đội bóng 922'),
(923, 'Đội bóng 923'),
(924, 'Đội bóng 924'),
(925, 'Đội bóng 925'),
(926, 'Đội bóng 926'),
(927, 'Đội bóng 927'),
(928, 'Đội bóng 928'),
(929, 'Đội bóng 929'),
(93, 'Đội bóng 93'),
(930, 'Đội bóng 930'),
(931, 'Đội bóng 931'),
(932, 'Đội bóng 932'),
(933, 'Đội bóng 933'),
(934, 'Đội bóng 934'),
(935, 'Đội bóng 935'),
(936, 'Đội bóng 936'),
(937, 'Đội bóng 937'),
(938, 'Đội bóng 938'),
(939, 'Đội bóng 939'),
(94, 'Đội bóng 94'),
(940, 'Đội bóng 940'),
(941, 'Đội bóng 941'),
(942, 'Đội bóng 942'),
(943, 'Đội bóng 943'),
(944, 'Đội bóng 944'),
(945, 'Đội bóng 945'),
(946, 'Đội bóng 946'),
(947, 'Đội bóng 947'),
(948, 'Đội bóng 948'),
(949, 'Đội bóng 949'),
(95, 'Đội bóng 95'),
(950, 'Đội bóng 950'),
(951, 'Đội bóng 951'),
(952, 'Đội bóng 952'),
(953, 'Đội bóng 953'),
(954, 'Đội bóng 954'),
(955, 'Đội bóng 955'),
(956, 'Đội bóng 956'),
(957, 'Đội bóng 957'),
(958, 'Đội bóng 958'),
(959, 'Đội bóng 959'),
(96, 'Đội bóng 96'),
(960, 'Đội bóng 960'),
(961, 'Đội bóng 961'),
(962, 'Đội bóng 962'),
(963, 'Đội bóng 963'),
(964, 'Đội bóng 964'),
(965, 'Đội bóng 965'),
(966, 'Đội bóng 966'),
(967, 'Đội bóng 967'),
(968, 'Đội bóng 968'),
(969, 'Đội bóng 969'),
(97, 'Đội bóng 97'),
(970, 'Đội bóng 970'),
(971, 'Đội bóng 971'),
(972, 'Đội bóng 972'),
(973, 'Đội bóng 973'),
(974, 'Đội bóng 974'),
(975, 'Đội bóng 975'),
(976, 'Đội bóng 976'),
(977, 'Đội bóng 977'),
(978, 'Đội bóng 978'),
(979, 'Đội bóng 979'),
(98, 'Đội bóng 98'),
(980, 'Đội bóng 980'),
(981, 'Đội bóng 981'),
(982, 'Đội bóng 982'),
(983, 'Đội bóng 983'),
(984, 'Đội bóng 984'),
(985, 'Đội bóng 985'),
(986, 'Đội bóng 986'),
(987, 'Đội bóng 987'),
(988, 'Đội bóng 988'),
(989, 'Đội bóng 989'),
(99, 'Đội bóng 99'),
(990, 'Đội bóng 990'),
(991, 'Đội bóng 991'),
(992, 'Đội bóng 992'),
(993, 'Đội bóng 993'),
(994, 'Đội bóng 994'),
(995, 'Đội bóng 995'),
(996, 'Đội bóng 996'),
(997, 'Đội bóng 997'),
(998, 'Đội bóng 998'),
(999, 'Đội bóng 999');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
