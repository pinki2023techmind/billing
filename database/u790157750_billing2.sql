-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 27, 2023 at 09:44 AM
-- Server version: 10.5.19-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u790157750_billing`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_credentials`
--

CREATE TABLE `admin_credentials` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `PHARMACY_NAME` varchar(50) DEFAULT NULL,
  `ADDRESS` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `CONTACT_NUMBER` varchar(11) DEFAULT NULL,
  `IS_LOGGED_IN` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

--
-- Dumping data for table `admin_credentials`
--

INSERT INTO `admin_credentials` (`ID`, `USERNAME`, `PASSWORD`, `PHARMACY_NAME`, `ADDRESS`, `EMAIL`, `CONTACT_NUMBER`, `IS_LOGGED_IN`) VALUES
(1, 'embossed', 'admin@938', 'Embossed', 'Chintamani', 'embossedw@gmail.com', '7022748789', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `CONTACT_NUMBER` varchar(10) NOT NULL,
  `ADDRESS` varchar(100) NOT NULL,
  `VEHICLE_NUMBER` varchar(20) DEFAULT NULL,
  `GST_NUMBER` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`ID`, `NAME`, `CONTACT_NUMBER`, `ADDRESS`, `VEHICLE_NUMBER`, `GST_NUMBER`) VALUES
(12, 'Nataraj', '9449365032', 'No.8 Ashwini Extortion Near KSRTC Depo Chintamani', '', ''),
(13, 'Zameerulla Sharif', '9739472697', 'No. 308, Chinnasandra, 2nd Block, Chinnsandra Village, Chintamani-563128', '', ''),
(14, 'Ramesh Babu', '9449203199', 'No 42 Kaanapali West Bangalore Chintamani 563125', '', ''),
(15, 'Shankar', '9666979280', 'Near Bharath Dental Clinic, Bangalore Circle Chintamani 563125.', '', ''),
(16, 'Adil', '9632620083', 'No 20 Annar Bag Chelur Road Chintamani 563125', '', ''),
(17, 'Sudershan Kumar', '6360595767', 'No.00 Excellent Jerry Tea Opp KSRTC Depo Bangalore Road 563125', '', ''),
(18, 'Vani', '9986686764', 'Royal Circular Parallel Road Behind Police Station Chintamani 563125.', '', ''),
(19, 'Nagesh', '9611174907', 'NNT Road Chintamani 563125.', '', ''),
(20, 'Usha', '6362155164', 'Ambedkar Colony Tavarekery Narasapura 563133.', '', ''),
(21, 'Krishnareddy', '9901418569', 'Prabhakar Layout Near Amazon Office 563125.', '', ''),
(22, 'Yusuf Khan', '9663911736', 'Ashraya Badavane Ward No 2 Behind Venkatadri Pu College 563125', '', ''),
(23, 'Nikthita Sakhi', '9902021348', 'Bangalore Road Chitamani 563125.', '', ''),
(24, 'Ashwini Sriram', '9591877889', 'Next To Decan Hospital Near KSRTC Depo Chintamani 563125', '', ''),
(25, 'Gangadhar', '7993912451', 'Nayanahalli Chintamani (tq) Chikkabalapura (dt) 563125', '', ''),
(26, 'Subhareddy', '7353949733', 'Prabhakar Layout Vivekandha International Public School Chintamani 563125.', '', ''),
(27, 'Anil ', '8151912331', ' Oolavadi (vlg) Chintamani (tq) Chikkabalapura (dt) 563125', '', ''),
(28, 'Adil Pasha', '7349399692', 'Near Jamiya Masjeed MKT Murugamalla Chintamani Taluk Chintamani 563146', '', ''),
(29, 'Jairaj', '8553996772', '9th Wared Geetha Mandeer Road Mallapali 563125', '', ''),
(30, 'Naveen', '8618484749', 'Gajanana Circule Chintamani 563125', '', ''),
(31, 'Prashanth', '9900153155', 'Ward No 24 Narsingapete Chintamani 563125.', '', ''),
(32, 'Ravi', '9141620684', 'Prabhakar Layout Arch Inside Bangalore Road Chintamani 563125', '', ''),
(33, 'Venkat', '7019347732', 'Upon Appolo Medical Near Kishore School Bangalore Road Chintamani 563125', '', ''),
(34, 'Dr Shankara', '9686623578', 'Opp Old Court Kalikambba Temple Street NR Extinction Chintamani 563125', '', ''),
(35, 'Ajay', '9902553646', 'Kanampali Bangalore Road ', '', ''),
(36, 'Fairoz', '8904347615', 'Near Sultan Masjid Venkatgirikota Chintamani 563125', '', ''),
(37, 'NVR Venkataramana Re', '9880621511', 'KSRTC Bus Stand Road Sai Complex Upon National Auto Mobiles 563125', '', ''),
(38, 'Rahmath', '8050529179', 'Teachers Colony Tankbond Road Chintamani 563125', '', ''),
(39, 'Suresh ', '8970808021', 'NNT Road Chintamani 563125', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `INVOICE_ID` int(11) NOT NULL,
  `NET_TOTAL` double DEFAULT NULL,
  `INVOICE_DATE` date NOT NULL,
  `CUSTOMER_ID` int(11) NOT NULL,
  `TOTAL_AMOUNT` double NOT NULL,
  `TOTAL_DISCOUNT` double NOT NULL,
  `TOTAL_TAX` int(200) NOT NULL DEFAULT 18,
  `STAX` varchar(11) DEFAULT NULL,
  `CTAX` varchar(11) DEFAULT NULL,
  `REFFERED` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`INVOICE_ID`, `NET_TOTAL`, `INVOICE_DATE`, `CUSTOMER_ID`, `TOTAL_AMOUNT`, `TOTAL_DISCOUNT`, `TOTAL_TAX`, `STAX`, `CTAX`, `REFFERED`) VALUES
(1, 5310, '2023-07-31', 12, 9000, 4500, 810, '405', '405', 'Waffa'),
(2, 10620, '2023-07-31', 13, 18000, 9000, 1620, '810', '810', 'Waffa'),
(3, 11925.08, '2023-08-14', 14, 20212, 10106, 1819, '909.54', '909.54', 'Varshitha'),
(4, 1214.22, '2023-08-19', 14, 2058, 1029, 185, '92.61', '92.61', 'Varshitha'),
(5, 6560.8, '2023-08-21', 15, 11120, 5560, 1001, '500.4', '500.4', 'Varshitha'),
(6, 867.3, '2023-08-24', 16, 1470, 735, 132, '66.15', '66.15', 'Ruheed'),
(7, 9794, '2023-08-26', 17, 16600, 8300, 1494, '747', '747', 'Ruheed'),
(8, 2448.5, '2023-09-04', 18, 4150, 2075, 374, '186.75', '186.75', 'Varshitha'),
(9, 81.42, '2023-09-10', 19, 138, 69, 12, '6.21', '6.21', 'Varsha'),
(10, 14337, '2023-09-11', 20, 24300, 12150, 2187, '1093.5', '1093.5', 'Swathi y k'),
(11, 21778.08, '2023-09-15', 21, 36912, 18456, 3322, '1661.04', '1661.04', 'Fariha Waffa'),
(12, 4115.84, '2023-09-21', 22, 6976, 3488, 628, '313.92', '313.92', 'Kalyan Kumar'),
(13, 7259.36, '2023-09-24', 23, 12304, 6152, 1107, '553.68', '553.68', 'Fariha waffa'),
(14, 3322.88, '2023-09-26', 25, 5632, 2816, 507, '253.44', '253.44', 'Shekarappa'),
(15, 4012, '2023-10-04', 27, 6800, 3400, 612, '306', '306', 'Kalyan kumar G'),
(16, 19540.8, '2023-10-07', 28, 33120, 16560, 2981, '1490.4', '1490.4', 'Fariha Waffa'),
(17, 4720, '2023-10-13', 29, 8000, 4000, 720, '360', '360', 'waffa suresh corptr'),
(18, 3280.4, '2023-10-17', 30, 5560, 2780, 500, '250.2', '250.2', 'waffa'),
(19, 1685.04, '2023-10-17', 31, 2856, 1428, 257, '128.52', '128.52', 'Waffa suresh cur'),
(20, 25334.6, '2023-10-20', 32, 42940, 21470, 3865, '1932.3', '1932.3', 'Ruheed'),
(21, 9841.2, '2023-10-20', 33, 16680, 8340, 1501, '750.6', '750.6', 'Fariha waffa'),
(22, 4720, '2023-10-22', 34, 8000, 4000, 720, '360', '360', 'Fariha Waffa '),
(23, 4720, '2023-10-22', 35, 8000, 4000, 720, '360', '360', 'Fariha Waffa'),
(24, 3280.4, '2023-10-23', 30, 5560, 2780, 500, '250.2', '250.2', 'Fariha Waffa rf suresh'),
(25, 3127, '2023-10-23', 32, 5300, 2650, 477, '238.5', '238.5', 'Ruheed'),
(26, 6560.8, '2023-10-23', 33, 11120, 5560, 1001, '500.4', '500.4', 'Fariha Waffa'),
(27, 31871.8, '2023-10-28', 37, 54020, 27010, 4862, '2430.9', '2430.9', 'ruheed'),
(28, 30503, '2023-10-29', 37, 51700, 25850, 4653, '2326.5', '2326.5', 'Ruheed'),
(29, 6513.6, '2023-10-31', 37, 11040, 5520, 994, '496.8', '496.8', 'ruheed'),
(30, 7259.36, '2023-10-31', 38, 12304, 6152, 1107, '553.68', '553.68', 'Fariha Waffa'),
(31, 2006, '2023-11-01', 39, 3400, 1700, 306, '153', '153', 'Fariha Waffa'),
(32, 6018, '2023-11-07', 39, 10200, 5100, 918, '459', '459', 'Fariha waffa'),
(33, 4141.8, '2023-11-07', 39, 7020, 3510, 632, '315.9', '315.9', 'Fariha Waffa'),
(34, 2725.8, '2023-11-15', 12, 4620, 2310, 416, '207.9', '207.9', 'test'),
(35, 2725.8, '2023-11-15', 13, 4620, 2310, 416, '207.9', '207.9', 'tfgy');

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `PACKING` varchar(20) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `GENERIC_NAME` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `SUPPLIER_NAME` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`ID`, `NAME`, `PACKING`, `GENERIC_NAME`, `SUPPLIER_NAME`) VALUES
(1, 'Jubilant 12', 'ROLL', '', 'Bangalore Stock'),
(3, 'Sure', 'ROLL', '', 'Bangalore Stock'),
(4, '3D Gloss', 'ROLL', '', 'Bangalore Stock'),
(5, 'Fauna', 'ROLL', '', 'Bangalore Stock'),
(6, 'Maverick', 'ROLL', '', 'Bangalore Stock'),
(7, 'Colour Plus New', 'ROLL', '', 'Bangalore Stock'),
(8, 'Fiesta', 'ROLL', '', '24'),
(9, 'Beta (Big)', 'ROLL', '', 'Bangalore Stock'),
(10, 'Jaipur', 'ROLL', '', 'Bangalore Stock'),
(13, 'Young Beats', 'ROLL', '', '24'),
(14, 'Style New', 'ROLL', '', 'Bangalore Stock'),
(15, 'Angle', 'ROLL', '', 'Bangalore Stock'),
(16, 'Jaisalmer', 'ROLL', '', 'Bangalore Stock'),
(17, 'Silk Road New', 'ROLL', '', '24'),
(18, 'Moderna New', 'ROLL', '', 'Bangalore Stock'),
(19, 'Reyana', 'ROLL', '', '24'),
(20, 'B-Spoke', 'ROLL', '', 'Bangalore Stock'),
(21, 'Indoor/outdoor9049E', 'TAIL', '', 'Bangalore Stock'),
(22, 'Indoor/outdoor9055E', 'TILE', '', 'Bangalore Stock'),
(23, 'Indoor/outdoor9077E', 'TILE', '', 'Bangalore Stock'),
(24, 'Indoor/outdoor99002E', 'TILE', '', 'Bangalore Stock'),
(25, 'Indoor/outdoor9021E', 'TILE', '', 'Bangalore Stock'),
(26, 'Indoor/outdoor9081E', 'TILE', '', 'Bangalore Stock'),
(27, 'Indoor/outdoor99038E', 'TILE', '', 'Bangalore Stock'),
(28, 'Indoor/outdoor99084E', 'TILE', '', 'Bangalore Stock'),
(29, 'Indoor/outdoor99075E', 'TILE', '', 'Bangalore Stock'),
(30, 'Indoor/outdoor9025E', 'TILE', '', 'Bangalore Stock'),
(31, 'Indoor/outdoor99032E', 'TILE', '', 'Bangalore Stock'),
(32, 'Indoor/outdoor99078E', 'TILE', '', 'Bangalore Stock '),
(33, 'Indoor/outdoor9024E', 'TILE', '', 'Bangalore Stock'),
(34, 'Indoor/outdoor9026E', 'TILE', '', 'Bangalore Stock'),
(35, 'Embossed Art Series 001(munshi) Flane ', 'SQFT', '', 'Bangalore stock'),
(36, 'Paper A 002(MUNSHI ) FLAN', 'SQFT', '', 'Bangalore stock'),
(37, 'Paper B 003(MUNSHI) PLAN', 'SQFT', '', 'Bangalore stock'),
(38, 'Paper C 004(MUNSHI) PLAN', 'SQUT', '', 'Bangalore stock'),
(39, 'Paper D 005(MUNSHI)PLAN', 'SQFT', '', 'Bangalore stock'),
(40, 'Nonwoven Matt006 (munshi) Plan', 'SQFT', '', 'Bangalore stock'),
(41, 'Canvas Paper 011(munshi) Plan', 'SQFT', '', 'Bangalore stock'),
(42, 'Rollerblack Out012(munshi) Plan', 'SQFT', '', 'Bangalore stock'),
(43, 'PAPER HD 013(MUNSHI)PLAN', 'SQFT', '', 'bangalore stock'),
(44, 'Paper Pvc014 (munshi)plan', 'SQFT', '', 'bangalore stock'),
(45, 'Paper Vinyl 015(munshi)plan', 'SQFT', '', 'bangalore stock'),
(46, 'Film Frosted 016(munshi) Plan  ', 'SQFT', '', 'Bangalore stock'),
(47, 'Paper A 002 (Munshi)Plan', 'SQFT', '', 'Bangalore Stock'),
(48, 'Paper A 002(Munshi) Emboss', 'SPFT', '', 'Bangalore stock'),
(49, 'Paper B 003(munshi) Emboss', 'SQFT', '', 'Bangalore Stock'),
(50, 'Paper C 004 (Munshi) Emboss', 'SQFT', '', 'Bangalore Stock'),
(51, 'Paper D 005(Munshi) Emboss', 'SQFT', '', 'Bangalore Stock'),
(52, 'Nonwoven Matt 006(Munshi) Emboss', 'SQFT', '', 'Bangalore Stock'),
(53, 'Canvas Paper 011(Munshi) Emboss', 'SQFT', '', 'bangalore Stock'),
(54, 'Roller Black Out 012(Munshi) Emboss', 'SQFT', '', 'Bangalore Stock'),
(55, 'Paper HD 013 (Munshi) Emboss', 'SQFT', '', 'Bangalore Stock'),
(56, 'Paper PVC 014(Munshi) Emboss', 'SQFT', '', 'Bangalore Stock'),
(58, 'Film Frosted 016 (Munshi) Emboss', 'SQFT', '', 'Bangalore Stock'),
(59, 'Paper Vinyl 015 (Munshi) Emboss', 'SQFT', '', 'Bangalore Stock'),
(60, '10mm FG Grass Regular ', 'SQFT', '', 'Bangalore Stock'),
(61, '25mm Natural Grass Regular ', 'SQFT', '', 'Bangalore Stock'),
(62, '25mm FG Grass Regular ', 'SQFT', '', 'Bangalore Stock'),
(63, '35mm FG Grass Regular ', 'SQFT', '', 'Bangalore Stock'),
(64, '35mm Natural Grass Regular  ', '138', '', 'Bangalore Stock'),
(65, '35mm Natural Bloom Grass Premium HD', 'SQFT', '', 'Bangalore Stock'),
(66, '40mm FG Grass Premium HD', 'SQFT', '', 'Bangalore Stock'),
(67, '50mm Natural Grass Premium HD', 'SQFT', '', 'Bangalore Stock'),
(68, '50mm FG Grass Premium HD', 'SQFT', '', 'Bangalore Stock'),
(69, '60mm Natural-Black Backing Grass Premium HD', 'SQFT', '', 'Bangalore Stock'),
(70, '15002 T1 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(71, '15004 T1 Regular WFCP AC-4 (8mm) ', 'BOX', '', 'Bangalore Stock'),
(72, '15008 T7 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(73, '15017 T1 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(74, '15021 T1 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(75, '15022 T1 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(76, '15025 T1 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(77, '15030 T1 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(78, '15027 T1 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(79, '15031 T7 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(80, '15032 T7 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(81, '15049 T1 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(82, '15050 T1 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(83, '15051 T7 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(84, '15054 T1 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(85, '15057 T7Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(86, '15058 T7 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(87, '15059 T1 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(88, '15060 T1 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(89, '15063 T7 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(90, '15064 T1 Regular WFCP AC-4 (8mm)', 'BOX', '', 'Bangalore Stock'),
(91, '15006 T1 Regular WFCP AC-3 (8mm)', 'BOX', '', 'Bangalore Stock'),
(92, '15013 T1  Regular WFCP AC-3 (8mm)', 'BOX', '', 'Bangalore Stock'),
(93, '15014 T1  Regular WFCP AC-3 (8mm)', 'BOX', '', 'Bangalore Stock'),
(94, '15016 T7  Regular WFCP AC-3 (8mm)', 'BOX', '', 'Bangalore Stock'),
(95, '15024 T7  Regular WFCP AC-3 (8mm)', 'BOX', '', 'Bangalore Stock'),
(96, '15026 T7  Regular WFCP AC-3 (8mm)', 'BOX', '', 'Bangalore Stock'),
(97, '15028 T7  Regular WFCP AC-3 (8mm)', 'BOX', '', 'Bangalore Stock'),
(98, '15052 T1  Regular WFCP AC-3 (8mm)', 'BOX', '', 'Bangalore Stock'),
(99, '15053 T7  Regular WFCP AC-3 (8mm)', 'BOX', '', 'Bangalore Stock'),
(100, '15055 T1  Regular WFCP AC-3 (8mm)', 'BOX', '', 'Bangalore Stock'),
(101, '15056 T7  Regular WFCP AC-3 (8mm)', 'BOX', '', 'Bangalore Stock'),
(102, '15061 T7  Regular WFCP AC-3 (8mm)', 'BOX', '', 'Bangalore Stock'),
(103, '15062 T1  Regular WFCP AC-3 (8mm)', 'BOX', '', 'Bangalore Stock'),
(104, '15065 T7  Regular WFCP AC-3 (8mm)', 'BOX', '', 'Bangalore Stock'),
(105, '15035 T7 Premium WFCP AC-4 (12mm)', 'BOX', '', 'Bangalore Stock'),
(106, '15036 T7 Premium WFCP AC-4 (12mm)', 'BOX', '', 'Bangalore Stock'),
(107, '15037 T7 Premium WFCP AC-4 (12mm)', 'BOX', '', 'Bangalore Stock'),
(108, '15038 T7 Premium WFCP AC-4 (12mm)', 'BOX', '', 'Bangalore Stock'),
(109, '15039 T7 Premium WFCP AC-4 (12mm)', 'BOX', '', '39189090'),
(110, '15040 T3 Premium WFCP AC-4 (12mm)', 'BOX', '', 'Bangalore Stock'),
(111, '15041 T3 Premium WFCP AC-4 (12mm)', 'BOX', '', 'Bangalore Stock'),
(112, '15042 T3 Premium WFCP AC-4 (12mm)', 'BOX', '', 'Bangalore Stock'),
(113, '15043 T7 Premium WFCP AC-4 (12mm)', 'BOX', '', 'Bangalore Stock'),
(114, '15044 T3 Premium WFCP AC-4 (12mm)', 'BOX', '', 'Bangalore Stock'),
(115, '15045 T3 Premium WFCP AC-4 (12mm)', 'BOX', '', 'Bangalore Stock'),
(116, '15046 T3 Premium WFCP AC-4 (12mm)', 'BOX', '', 'Bangalore Stock'),
(117, '15047 T7 Premium WFCP AC-4 (12mm)', 'BOX', '', 'Bangalore Stock'),
(118, '15048 T7 Premium WFCP AC-4 (12mm)', 'BOX', '', 'Bangalore Stock'),
(119, '15066 T3 Canvas WFCP AC-4 (8mm-12mm)', 'BOX', '', 'Bangalore Stock'),
(120, '15067 T2  Canvas WFCP AC-4 (8mm-12mm)', 'BOX', '', 'Bangalore Stock'),
(121, '15068 T3  Canvas WFCP AC-4 (8mm-12mm)', 'BOX', '', 'Bangalore Stock'),
(122, '15069 T2  Canvas WFCP AC-4 (8mm-12mm)', 'BOX', '', 'Bangalore Stock'),
(123, '15070 T2  Canvas WFCP AC-4 (8mm-12mm)', 'BOX', '', 'Bangalore Stock'),
(124, '15071 T3  Canvas WFCP AC-4 (8mm-12mm)', 'BOX', '', 'Bangalore Stock'),
(125, '15072 T3  Canvas WFCP AC-4 (8mm-12mm)', 'BOX', '', 'Bangalore Stock'),
(126, '15073 T2  Canvas WFCP AC-4 (8mm-12mm)', 'BOX', '', 'Bangalore Stock'),
(127, '15074 T2  Canvas WFCP AC-4 (8mm-12mm)', 'BOX', '', 'Bangalore Stock'),
(128, '15075 T3  Canvas WFCP AC-4 (8mm-12mm)', 'BOX', '', 'Bangalore Stock'),
(129, '15076 T2  Canvas WFCP AC-4 (8mm-12mm)', 'BOX', '', 'Bangalore Stock'),
(130, '15077 T3  Canvas WFCP AC-4 (8mm-12mm)', 'BOX', '', 'Bangalore Stock'),
(131, 'DF1501 Vinyl Floor Plank (1.5mm)', 'BOX', '', 'Bangalore Stock '),
(132, 'DF1502 Vinyl Floor Plank (1.5mm)', 'BOX', '', 'Bangalore Stock '),
(133, 'DF1503 Vinyl Floor Plank (1.5mm)', 'BOX', '', 'Bangalore Stock '),
(134, 'DF1504 Vinyl Floor Plank (1.5mm)', 'BOX', '', 'Bangalore Stock '),
(135, 'DF1505 Vinyl Floor Plank (1.5mm)', '1000', '', 'Bangalore Stock '),
(136, 'DF1506 Vinyl Floor Plank (1.5mm)', 'BOX', '', 'Bangalore Stock '),
(137, 'DF1507 Vinyl Floor Plank (1.5mm)', 'BOX', '', 'Bangalore Stock '),
(138, 'DF1508 Vinyl Floor Plank (1.5mm)', 'BOX', '', 'Bangalore Stock '),
(139, 'DF1509 Vinyl Floor Plank (1.5mm)', 'BOX', '', 'Bangalore Stock '),
(140, 'DF1510 Vinyl Floor Plank (1.5mm)', 'BOX', '', 'Bangalore Stock '),
(141, 'DF1511 Vinyl Floor Plank (1.5mm)', 'BOX', '', 'Bangalore Stock '),
(142, 'DF1512 Vinyl Floor Plank (1.5mm)', 'BOX', '', 'Bangalore Stock '),
(143, 'DF2001 Vinyl Floor Plank (2mm)', 'BOX', '', 'Bangalore Stock '),
(144, 'DF2002 Vinyl Floor Plank (2mm)', 'XOB', '', 'Bangalore Stock '),
(145, 'DF2003 Vinyl Floor Plank (2mm)', 'BOX', '', 'Bangalore Stock '),
(146, 'DF2004 Vinyl Floor Plank (2mm)', 'BOX', '', 'Bangalore Stock '),
(147, 'DF2005 Vinyl Floor Plank (2mm)', 'BOX', '', 'Bangalore Stock '),
(148, 'DF2006 Vinyl Floor Plank (2mm)', 'BOX', '', 'Bangalore Stock '),
(149, 'DF2007 Vinyl Floor Plank (2mm)', 'BOX', '', 'Bangalore Stock '),
(150, 'DF2008 Vinyl Floor Plank (2mm)', 'BOX', '', 'Bangalore Stock '),
(151, 'FP01 Vintage Shine Natural Stone', 'BOX', '', 'Bangalore Stock'),
(152, 'FP02 S-White Natural Stone', 'BOX', '', 'Bangalore Stock'),
(153, 'FP03 Autumn Rustic Natural Stone', 'BOX', '', 'Bangalore Stock'),
(154, 'FP04 Silver Grey Natural Stone', 'BOX', '', 'Bangalore Stock'),
(155, 'FP05 Copper Natural Stone', 'BOX', '', 'Bangalore Stock'),
(156, 'FP06 Burning Forest Natural Stone', 'BOX', '', 'Bangalore Stock'),
(157, 'FP07 Golden Mix Natural Stone', 'BOX', '', 'Bangalore Stock'),
(158, 'FP08 Decan Green Natural Stone', 'BOX', '', 'Bangalore Stock'),
(160, 'Indoor/outdoor9002E', 'TILE', '', 'Bangalore Stock'),
(161, 'Indoor/outdoor9004E', 'TILE', '', 'Bangalore Stock'),
(162, 'Indoor/outdoor9007E', 'TILE', '', 'Bangalore Stock'),
(163, 'Indoor/outdoor9010E', 'TILE', '', 'Bangalore Stock'),
(164, 'Indoor/outdoor9013E', 'TILE', '', 'Bangalore Stock'),
(165, 'Indoor/outdoor9014E', 'TILE', '', 'Bangalore Stock'),
(166, 'Indoor/outdoor9023E', 'TILE', '', 'Bangalore Stock'),
(167, 'Indoor/outdoor9030E', 'TILE', '', 'Bangalore Stock'),
(168, 'Indoor/outdoor9032E', 'TILE', '', 'Bangalore Stock'),
(169, 'Indoor/outdoor9038E', 'TILE', '', 'Bangalore Stock'),
(170, 'Indoor/outdoor9048E', 'TILE', '', 'Bangalore Stock'),
(171, 'Indoor/outdoor 9052E', 'TILE', '', 'Bangalore Stock'),
(172, 'Indoor/outdoor9069E', 'TILE', '', 'Bangalore Stock'),
(173, 'Indoor/outdoor9070E', 'TILE', '', 'Bangalore Stock'),
(174, 'Indoor/outdoor9072E', 'TILE', '', 'Bangalore Stock'),
(175, 'Indoor/outdoor9076E', 'TILE', '', 'Bangalore Stock'),
(176, 'Indoor/outdoor9078E', 'TILE', '', 'Bangalore Stock'),
(177, 'Indoor/outdoor9082E', 'TILE', '', 'Bangalore Stock'),
(178, 'Self Border Golden Tap', 'PCS', '', 'Bangalore Stock'),
(180, 'Sabya Ex', 'ROLL', '', 'Bangalore Stock'),
(181, '60mm Natural Grass Black Backing', 'SQFT', '', 'Bangalore Stock'),
(182, 'Sara', 'ROLL', '', 'Bangalore Stock'),
(183, 'Alfassa', 'ROLL', '', 'pankajmangalam'),
(184, 'Jubilant-cat', 'CATLOUGE', '', 'Tattva'),
(185, 'Roller Black Out Blind With Pelmet', 'SET', '', 'Tattva Blr'),
(186, 'Test Iteam', '453', '', 'Tattva');

-- --------------------------------------------------------

--
-- Table structure for table `medicines_stock`
--

CREATE TABLE `medicines_stock` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `BATCH_ID` varchar(20) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `PER` varchar(11) DEFAULT NULL,
  `AVAIL_QTY` varchar(10) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `QUANTITY` int(11) DEFAULT NULL,
  `MRP` double NOT NULL,
  `RATE` double DEFAULT NULL,
  `DISCOUNT` varchar(11) DEFAULT NULL,
  `TAX` int(22) NOT NULL,
  `INVOICE_NUMBER` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `medicines_stock`
--

INSERT INTO `medicines_stock` (`ID`, `NAME`, `BATCH_ID`, `PER`, `AVAIL_QTY`, `QUANTITY`, `MRP`, `RATE`, `DISCOUNT`, `TAX`, `INVOICE_NUMBER`) VALUES
(1, 'Jubilant 12', '49111090', NULL, '', 297, 3400, NULL, NULL, 0, NULL),
(3, 'Sure', '49111090 ', NULL, '', 367, 4000, NULL, NULL, 0, NULL),
(4, '3D Gloss', '49111090', NULL, '', 386, 4620, NULL, NULL, 0, NULL),
(5, 'Fauna', '49111090', NULL, '', 387, 5560, NULL, NULL, 0, NULL),
(6, 'Maverick', '49111090', NULL, '', 393, 4980, NULL, NULL, 0, NULL),
(7, 'Colour Plus New', '49111090', NULL, '', 396, 5300, NULL, NULL, 0, NULL),
(8, 'Fiesta', '49111090', NULL, '', 990, 6138, NULL, NULL, 0, NULL),
(9, 'Beta (Big)', '49111090', NULL, '', 398, 6050, NULL, NULL, 0, NULL),
(10, 'Jaipur', '49111090', NULL, '', 399, 5632, NULL, NULL, 0, NULL),
(13, 'Young Beats', '49111090', NULL, '', 1000, 6300, NULL, NULL, 0, NULL),
(14, 'Style New', '49111090', NULL, '', 400, 4900, NULL, NULL, 0, NULL),
(15, 'Angle', '49111090', NULL, '', 8, 4540, NULL, NULL, 0, NULL),
(16, 'Jaisalmer', '49111090', NULL, '', 400, 5400, NULL, NULL, 0, NULL),
(17, 'Silk Road New', '49111090', NULL, '', 990, 6152, NULL, NULL, 0, NULL),
(18, 'Moderna New', '49111090', NULL, '', 400, 5760, NULL, NULL, 0, NULL),
(19, 'Reyana', '49111090', NULL, '', 1000, 5200, NULL, NULL, 0, NULL),
(20, 'B-Spoke', '49111090', NULL, '', 400, 5000, NULL, NULL, 0, NULL),
(21, 'Indoor/outdoor9049E', '67021090', NULL, '', 1000, 1442, NULL, NULL, 0, NULL),
(22, 'Indoor/outdoor9055E', '67021090', NULL, '', 996, 1678, NULL, NULL, 0, NULL),
(23, 'Indoor/outdoor9077E', '67021090', NULL, '', 1000, 1412, NULL, NULL, 0, NULL),
(24, 'Indoor/outdoor99002E', '67021090', NULL, '', 1000, 1412, NULL, NULL, 0, NULL),
(25, 'Indoor/outdoor9021E', '67021090', NULL, '', 1000, 1412, NULL, NULL, 0, NULL),
(26, 'Indoor/outdoor9081E', '67021090', NULL, '', 1000, 2480, NULL, NULL, 0, NULL),
(27, 'Indoor/outdoor99038E', '67021090', NULL, '', 1000, 1734, NULL, NULL, 0, NULL),
(28, 'Indoor/outdoor99084E', '67021090', NULL, '', 1000, 1614, NULL, NULL, 0, NULL),
(29, 'Indoor/outdoor99075E', '67021090', NULL, '', 1000, 1412, NULL, NULL, 0, NULL),
(30, 'Indoor/outdoor9025E', '67021090', NULL, '', 1000, 1554, NULL, NULL, 0, NULL),
(31, 'Indoor/outdoor99032E', '67021090', NULL, '', 1000, 1734, NULL, NULL, 0, NULL),
(32, 'Indoor/outdoor99078E', '67021090', NULL, '', 1000, 1570, NULL, NULL, 0, NULL),
(33, 'Indoor/outdoor9024E', '67021090', NULL, '', 1000, 1554, NULL, NULL, 0, NULL),
(34, 'Indoor/outdoor9026E', '67021090', NULL, '', 1000, 1444, NULL, NULL, 0, NULL),
(35, 'Embossed Art Series 001(munshi) Flane ', '48142000', NULL, '', 10000, 260, NULL, NULL, 0, NULL),
(36, 'Paper B 003(MUNSHI) PLAN', '48142000', NULL, '', 9910, 200, NULL, NULL, 0, NULL),
(37, 'Paper C 004(MUNSHI) PLAN', '48142000', NULL, '', 10000, 200, NULL, NULL, 0, NULL),
(38, 'Paper D 005(MUNSHI)PLAN', '48142000', NULL, '', 10000, 160, NULL, NULL, 0, NULL),
(39, 'Nonwoven Matt006 (munshi) Plan', '48142000', NULL, '', 10000, 140, NULL, NULL, 0, NULL),
(40, 'Canvas Paper 011(munshi) Plan', '48142000', NULL, '', 10000, 260, NULL, NULL, 0, NULL),
(41, 'Rollerblack Out012(munshi) Plan', '48142000', NULL, '', 10000, 280, NULL, NULL, 0, NULL),
(42, 'PAPER HD 013(MUNSHI)PLAN', '48142000', NULL, '', 10000, 160, NULL, NULL, 0, NULL),
(43, 'Paper Pvc014 (munshi)plan', '48142000', NULL, '', 10000, 160, NULL, NULL, 0, NULL),
(44, 'Paper Vinyl 015(munshi)plan', '48142000', NULL, '', 10000, 160, NULL, NULL, 0, NULL),
(45, 'Film Frosted 016(munshi) Plan  ', '48142000', NULL, '', 10000, 160, NULL, NULL, 0, NULL),
(46, 'Paper A 002 (Munshi)Plan', '48142000', NULL, '', 10000, 180, NULL, NULL, 0, NULL),
(47, 'Paper A 002(Munshi) Emboss', '48142000', NULL, '', 10000, 260, NULL, NULL, 0, NULL),
(48, 'Paper B 003(munshi) Emboss', '48142000', NULL, '', 10000, 280, NULL, NULL, 0, NULL),
(49, 'Paper C 004 (Munshi) Emboss', '48142000', NULL, '', 10000, 280, NULL, NULL, 0, NULL),
(50, 'Paper D 005(Munshi) Emboss', '48142000', NULL, '', 10000, 240, NULL, NULL, 0, NULL),
(51, 'Nonwoven Matt 006(Munshi) Emboss', '48142000', NULL, '', 10000, 220, NULL, NULL, 0, NULL),
(52, 'Canvas Paper 011(Munshi) Emboss', '48142000', NULL, '', 10000, 380, NULL, NULL, 0, NULL),
(53, 'Roller Black Out 012(Munshi) Emboss', '48142000', NULL, '', 10000, 280, NULL, NULL, 0, NULL),
(54, 'Paper HD 013 (Munshi) Emboss', '48142000', NULL, '', 10000, 240, NULL, NULL, 0, NULL),
(55, 'Paper PVC 014(Munshi) Emboss', '48142000', NULL, '', 10000, 240, NULL, NULL, 0, NULL),
(56, 'Paper Vinyl', '48142000', NULL, '', 10000, 240, NULL, NULL, 0, NULL),
(58, 'Paper Vinyl 015 (Munshi) Emboss', '48142000', NULL, '', 10000, 240, NULL, NULL, 0, NULL),
(59, '10mm FG Grass Regular ', '57033090', NULL, '', 9964, 98, NULL, NULL, 0, NULL),
(60, '25mm Natural Grass Regular ', '57033090', NULL, '', 10000, 128, NULL, NULL, 0, NULL),
(61, '25mm FG Grass Regular ', '57033090', NULL, '', 10000, 128, NULL, NULL, 0, NULL),
(62, '35mm FG Grass Regular ', '57033090', NULL, '', 10000, 138, NULL, NULL, 0, NULL),
(63, '35mm Natural Grass Regular  ', '57033090', NULL, '', 9999, 138, NULL, NULL, 0, NULL),
(64, '35mm Natural Bloom Grass Premium HD', '57033090', NULL, '', 10000, 158, NULL, NULL, 0, NULL),
(65, '40mm FG Grass Premium HD', '57033090', NULL, '', 10000, 172, NULL, NULL, 0, NULL),
(66, '50mm Natural Grass Premium HD', '57033090', NULL, '', 9986, 204, NULL, NULL, 0, NULL),
(67, '50mm FG Grass Premium HD', '57033090', NULL, '', 10000, 220, NULL, NULL, 0, NULL),
(68, '50mm FG Grass Premium HD', '57033090', NULL, '', 10000, 258, NULL, NULL, 0, NULL),
(69, '15002 T1 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(70, '15004 T1 Regular WFCP AC-4 (8mm) ', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(71, '15008 T7 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(72, '15017 T1 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(73, '15021 T1 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(74, '15022 T1 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(75, '15025 T1 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(76, '15030 T1 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(77, '15027 T1 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(78, '15031 T7 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(79, '15032 T7 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(80, '15049 T1 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(81, '15050 T1 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(82, '15051 T7 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(83, '15054 T1 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(84, '15057 T7Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(85, '15058 T7 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(86, '15059 T1 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(87, '15060 T1 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(88, '15063 T7 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(89, '15064 T1 Regular WFCP AC-4 (8mm)', '39189090', NULL, '', 1000, 4426, NULL, NULL, 0, NULL),
(90, '15006 T1 Regular WFCP AC-3 (8mm)', '39189090', NULL, '', 1000, 4352, NULL, NULL, 0, NULL),
(91, '15013 T1  Regular WFCP AC-3 (8mm)', '39189090', NULL, '', 1000, 4352, NULL, NULL, 0, NULL),
(92, '15014 T1  Regular WFCP AC-3 (8mm)', '39189090', NULL, '', 1000, 4352, NULL, NULL, 0, NULL),
(93, '15016 T7  Regular WFCP AC-3 (8mm)', '39189090', NULL, '', 1000, 4352, NULL, NULL, 0, NULL),
(94, '15024 T7  Regular WFCP AC-3 (8mm)', '39189090', NULL, '', 1000, 4352, NULL, NULL, 0, NULL),
(95, '15026 T7  Regular WFCP AC-3 (8mm)', '39189090', NULL, '', 1000, 4352, NULL, NULL, 0, NULL),
(96, '15028 T7  Regular WFCP AC-3 (8mm)', '39189090', NULL, '', 1000, 4352, NULL, NULL, 0, NULL),
(97, '15052 T1  Regular WFCP AC-3 (8mm)', '39189090', NULL, '', 1000, 4352, NULL, NULL, 0, NULL),
(98, '15053 T7  Regular WFCP AC-3 (8mm)', '39189090', NULL, '', 1000, 4352, NULL, NULL, 0, NULL),
(99, '15055 T1  Regular WFCP AC-3 (8mm)', '39189090', NULL, '', 1000, 4352, NULL, NULL, 0, NULL),
(100, '15056 T7  Regular WFCP AC-3 (8mm)', '39189090', NULL, '', 1000, 4352, NULL, NULL, 0, NULL),
(101, '15056 T7  Regular WFCP AC-3 (8mm)', '39189090', NULL, '', 1000, 4352, NULL, NULL, 0, NULL),
(102, '15062 T1  Regular WFCP AC-3 (8mm)', '39189090', NULL, '', 1000, 4352, NULL, NULL, 0, NULL),
(103, '15065 T7  Regular WFCP AC-3 (8mm)', '39189090', NULL, '', 1000, 4352, NULL, NULL, 0, NULL),
(104, '15035 T7 Premium WFCP AC-4 (12mm)', '39189090', NULL, '', 1000, 4540, NULL, NULL, 0, NULL),
(105, '15036 T7 Premium WFCP AC-4 (12mm)', '39189090', NULL, '', 1000, 4540, NULL, NULL, 0, NULL),
(106, '15037 T7 Premium WFCP AC-4 (12mm)', '39189090', NULL, '', 1000, 4540, NULL, NULL, 0, NULL),
(107, '15038 T7 Premium WFCP AC-4 (12mm)', '39189090', NULL, '', 1000, 4540, NULL, NULL, 0, NULL),
(108, '15039 T7 Premium WFCP AC-4 (12mm)', '39189090', NULL, '', 1000, 4540, NULL, NULL, 0, NULL),
(109, '15040 T3 Premium WFCP AC-4 (12mm)', '39189090', NULL, '', 1000, 4540, NULL, NULL, 0, NULL),
(110, '15041 T3 Premium WFCP AC-4 (12mm)', '39189090', NULL, '', 1000, 4540, NULL, NULL, 0, NULL),
(111, '15042 T3 Premium WFCP AC-4 (12mm)', '39189090', NULL, '', 1000, 4540, NULL, NULL, 0, NULL),
(112, '15043 T7 Premium WFCP AC-4 (12mm)', '39189090', NULL, '', 1000, 4540, NULL, NULL, 0, NULL),
(113, '15044 T3 Premium WFCP AC-4 (12mm)', 'Premium WFCP AC-4 (1', NULL, '', 1000, 4540, NULL, NULL, 0, NULL),
(114, '15045 T3 Premium WFCP AC-4 (12mm)', '39189090', NULL, '', 1000, 4540, NULL, NULL, 0, NULL),
(115, '15046 T3 Premium WFCP AC-4 (12mm)', '39189090', NULL, '', 1000, 4540, NULL, NULL, 0, NULL),
(116, '15047 T7 Premium WFCP AC-4 (12mm)', '39189090', NULL, '', 1000, 4540, NULL, NULL, 0, NULL),
(117, '15048 T7 Premium WFCP AC-4 (12mm)', '39189090', NULL, '', 1000, 4540, NULL, NULL, 0, NULL),
(118, '15066 T3 Canvas WFCP AC-4 (8mm-12mm)', '39189090', NULL, '', 1000, 7080, NULL, NULL, 0, NULL),
(119, '15067 T2  Canvas WFCP AC-4 (8mm-12mm)', '39189090', NULL, '', 1000, 7080, NULL, NULL, 0, NULL),
(120, '15068 T3  Canvas WFCP AC-4 (8mm-12mm)', '39189090', NULL, '', 1000, 7080, NULL, NULL, 0, NULL),
(121, '15069 T2  Canvas WFCP AC-4 (8mm-12mm)', '39189090', NULL, '', 1000, 7080, NULL, NULL, 0, NULL),
(122, '15070 T2  Canvas WFCP AC-4 (8mm-12mm)', '39189090', NULL, '', 1000, 7080, NULL, NULL, 0, NULL),
(123, '15071 T3  Canvas WFCP AC-4 (8mm-12mm)', '39189090', NULL, '', 1000, 7080, NULL, NULL, 0, NULL),
(124, '15072 T3  Canvas WFCP AC-4 (8mm-12mm)', '39189090', NULL, '', 1000, 7080, NULL, NULL, 0, NULL),
(125, '15073 T2  Canvas WFCP AC-4 (8mm-12mm)', '39189090', NULL, '', 1000, 7080, NULL, NULL, 0, NULL),
(126, '15074 T2  Canvas WFCP AC-4 (8mm-12mm)', '39189090', NULL, '', 1000, 7080, NULL, NULL, 0, NULL),
(127, '15075 T3  Canvas WFCP AC-4 (8mm-12mm)', '39189090', NULL, '', 1000, 7080, NULL, NULL, 0, NULL),
(128, '15076 T2  Canvas WFCP AC-4 (8mm-12mm)', '39189090', NULL, '', 1000, 7080, NULL, NULL, 0, NULL),
(129, '15077 T3  Canvas WFCP AC-4 (8mm-12mm)', '39189090', NULL, '', 1000, 7080, NULL, NULL, 0, NULL),
(130, 'DF1501 Vinyl Floor Plank (1.5mm)', '49111090', NULL, '', 1000, 7020, NULL, NULL, 0, NULL),
(131, 'DF1502 Vinyl Floor Plank (1.5mm)', '49111090', NULL, '', 1000, 7020, NULL, NULL, 0, NULL),
(132, 'DF1503 Vinyl Floor Plank (1.5mm)', '49111090', NULL, '', 1000, 7020, NULL, NULL, 0, NULL),
(133, 'DF1504 Vinyl Floor Plank (1.5mm)', '49111090', NULL, '', 1000, 7020, NULL, NULL, 0, NULL),
(134, 'DF1505 Vinyl Floor Plank (1.5mm)', '49111090', NULL, '', 999, 7020, NULL, NULL, 0, NULL),
(135, 'DF1506 Vinyl Floor Plank (1.5mm)', '49111090', NULL, '', 1000, 7020, NULL, NULL, 0, NULL),
(136, 'DF1507 Vinyl Floor Plank (1.5mm)', '49111090', NULL, '', 1000, 7020, NULL, NULL, 0, NULL),
(137, 'DF1508 Vinyl Floor Plank (1.5mm)', '49111090', NULL, '', 1000, 7020, NULL, NULL, 0, NULL),
(138, 'DF1509 Vinyl Floor Plank (1.5mm)', '49111090', NULL, '', 1000, 7020, NULL, NULL, 0, NULL),
(139, 'DF1510 Vinyl Floor Plank (1.5mm)', '49111090', NULL, '', 1000, 7020, NULL, NULL, 0, NULL),
(140, 'DF1511 Vinyl Floor Plank (1.5mm)', '49111090', NULL, '', 1000, 7020, NULL, NULL, 0, NULL),
(141, 'DF1512 Vinyl Floor Plank (1.5mm)', '49111090', NULL, '', 1000, 7020, NULL, NULL, 0, NULL),
(142, 'DF2001 Vinyl Floor Plank (2mm)', '49111090', NULL, '', 1000, 8100, NULL, NULL, 0, NULL),
(143, 'DF2002 Vinyl Floor Plank (2mm)', '49111090', NULL, '', 1000, 8100, NULL, NULL, 0, NULL),
(144, 'DF2003 Vinyl Floor Plank (2mm)', '49111090', NULL, '', 1000, 8100, NULL, NULL, 0, NULL),
(145, 'DF2004 Vinyl Floor Plank (2mm)', '49111090', NULL, '', 1000, 8100, NULL, NULL, 0, NULL),
(146, 'DF2005 Vinyl Floor Plank (2mm)', '49111090', NULL, '', 1000, 8100, NULL, NULL, 0, NULL),
(147, 'DF2006 Vinyl Floor Plank (2mm)', '49111090', NULL, '', 1000, 8100, NULL, NULL, 0, NULL),
(148, 'DF2007 Vinyl Floor Plank (2mm)', '49111090', NULL, '', 1000, 8100, NULL, NULL, 0, NULL),
(149, 'DF2008 Vinyl Floor Plank (2mm)', '49111090', NULL, '', 997, 8100, NULL, NULL, 0, NULL),
(150, 'FP01 Vintage Shine Natural Stone', '68030000', NULL, '', 1000, 7348, NULL, NULL, 0, NULL),
(151, 'FP02 S-White Natural Stone', '68030000', NULL, '', 1000, 7348, NULL, NULL, 0, NULL),
(152, 'FP03 Autumn Rustic Natural Stone', '68030000', NULL, '', 1000, 7348, NULL, NULL, 0, NULL),
(153, 'FP04 Silver Grey Natural Stone', '68030000', NULL, '', 1000, 7348, NULL, NULL, 0, NULL),
(154, 'FP05 Copper Natural Stone', '68030000', NULL, '', 1000, 7348, NULL, NULL, 0, NULL),
(155, 'FP06 Burning Forest Natural Stone', '68030000', NULL, '', 1000, 7348, NULL, NULL, 0, NULL),
(156, 'FP07 Golden Mix Natural Stone', '68030000', NULL, '', 1000, 7348, NULL, NULL, 0, NULL),
(157, 'FP08 Decan Green Natural Stone', '68030000', NULL, '', 1000, 7348, NULL, NULL, 0, NULL),
(158, 'Indoor/outdoor9002E', '67021090', NULL, '', 0, 0, NULL, NULL, 0, NULL),
(159, 'Indoor/outdoor9002E', '67021090', NULL, '', 1000, 2058, NULL, NULL, 0, NULL),
(160, 'Indoor/outdoor9004E', '67021090', NULL, '', 1000, 2058, NULL, NULL, 0, NULL),
(161, 'Indoor/outdoor9007E', '67021090', NULL, '', 1000, 2166, NULL, NULL, 0, NULL),
(162, 'Indoor/outdoor9010E', '67021090', NULL, '', 1000, 2094, NULL, NULL, 0, NULL),
(163, 'Indoor/outdoor9013E', '67021090', NULL, '', 1000, 2058, NULL, NULL, 0, NULL),
(164, 'Indoor/outdoor9014E', '67021090', NULL, '', 1000, 2166, NULL, NULL, 0, NULL),
(165, 'Indoor/outdoor9023E', '67021090', NULL, '', 1000, 2288, NULL, NULL, 0, NULL),
(166, 'Indoor/outdoor9030E', '67021090', NULL, '', 1000, 2290, NULL, NULL, 0, NULL),
(167, 'Indoor/outdoor9032E', '67021090', NULL, '', 1000, 2510, NULL, NULL, 0, NULL),
(168, 'Indoor/outdoor9038E', '67021090', NULL, '', 1000, 2510, NULL, NULL, 0, NULL),
(169, 'Indoor/outdoor9048E', '67021090', NULL, '', 1000, 2202, NULL, NULL, 0, NULL),
(170, 'Indoor/outdoor 9052E', '67021090', NULL, '', 1000, 2290, NULL, NULL, 0, NULL),
(171, 'Indoor/outdoor9069E', '67021090', NULL, '', 1000, 2058, NULL, NULL, 0, NULL),
(172, 'Indoor/outdoor9070E', '67021090', NULL, '', 1000, 2766, NULL, NULL, 0, NULL),
(173, 'Indoor/outdoor9072E', '67021090', NULL, '', 1000, 2412, NULL, NULL, 0, NULL),
(174, 'Indoor/outdoor9076E', '67021090', NULL, '', 1000, 2412, NULL, NULL, 0, NULL),
(175, 'Indoor/outdoor9078E', '67021090', NULL, '', 1000, 2308, NULL, NULL, 0, NULL),
(176, 'Indoor/outdoor9082E', '67021090', NULL, '', 1000, 2236, NULL, NULL, 0, NULL),
(177, 'Self Border Golden Tap', '76169990', NULL, '', 100, 335, NULL, NULL, 0, NULL),
(178, 'Sabya', '48142000', NULL, '', 10, 2000, NULL, NULL, 0, NULL),
(179, 'Sabya Ex', '48142000', NULL, '', 9, 4000, NULL, NULL, 0, NULL),
(180, '60mm Natural Grass Black Backing', '57033090', NULL, '', 9988, 258, NULL, NULL, 0, NULL),
(181, 'Sara', '49111090', NULL, '', 1000, 5508, NULL, NULL, 0, NULL),
(182, 'Alfassa', '49111090', NULL, '', 400, 4300, NULL, NULL, 0, NULL),
(183, 'Jubilant-cat', '49111090', '1500', '1', 1, 1500, 1500, '18', 1770, '132'),
(184, 'Roller Black Out Blind With Pelmet', '63039990', NULL, '', 977, 480, NULL, NULL, 0, NULL),
(185, 'Test Iteam', 'Quis expedita molest', NULL, '', 207, 8555, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `ID` int(11) NOT NULL,
  `SUPPLIER_NAME` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `INVOICE_NUMBER` int(11) NOT NULL,
  `VOUCHER_NUMBER` int(11) NOT NULL,
  `PURCHASE_DATE` varchar(10) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `TOTAL_AMOUNT` double NOT NULL,
  `GRAND_TOTAL` double NOT NULL,
  `PAYMENT_STATUS` varchar(20) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `STAX` varchar(11) DEFAULT NULL,
  `CTAX` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`ID`, `SUPPLIER_NAME`, `INVOICE_NUMBER`, `VOUCHER_NUMBER`, `PURCHASE_DATE`, `TOTAL_AMOUNT`, `GRAND_TOTAL`, `PAYMENT_STATUS`, `STAX`, `CTAX`) VALUES
(1, 'Tattva', 132, 0, '2023-05-27', 1500, 1770, 'PAID', '135', '135');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `ID` int(11) NOT NULL,
  `CUSTOMER_ID` int(11) NOT NULL,
  `INVOICE_NUMBER` varchar(13) NOT NULL,
  `MEDICINE_NAME` varchar(255) NOT NULL,
  `BATCH_ID` varchar(255) NOT NULL,
  `QUANTITY` varchar(255) NOT NULL,
  `MRP` varchar(11) NOT NULL,
  `DISCOUNT` varchar(11) NOT NULL,
  `TOTAL` bigint(11) NOT NULL,
  `EXPIRY_DATE` varchar(10) NOT NULL,
  `REFFERED` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`ID`, `CUSTOMER_ID`, `INVOICE_NUMBER`, `MEDICINE_NAME`, `BATCH_ID`, `QUANTITY`, `MRP`, `DISCOUNT`, `TOTAL`, `EXPIRY_DATE`, `REFFERED`) VALUES
(14, 12, '1', 'Paper B 003(MUNSHI) PLAN', '48142000', '45', '200', '50', 18, '', 'Waffa'),
(15, 13, '2', 'Sure', '49111090 ', '4', '4500', '50', 18, '', 'Waffa'),
(16, 14, '3', 'Sure', '49111090 ', '3', '4500', '50', 18, '', 'Varshitha'),
(17, 14, '3', 'Indoor/outdoor9055E', '67021090', '4', '1678', '50', 18, '', 'Varshitha'),
(18, 14, '4', '10mm FG Grass Regular ', '57033090', '21', '98', '50', 18, '', 'Varshitha'),
(19, 15, '5', 'Fauna', '49111090', '2', '5560', '50', 18, '', 'Varshitha'),
(20, 16, '6', '10mm FG Grass Regular ', '57033090', '15', '98', '50', 18, '', 'Ruheed'),
(21, 17, '7', 'Jubilant 12', '49111090', '4', '4150', '50', 18, '', 'Ruheed'),
(22, 18, '8', 'Jubilant 12', '49111090', '1', '4150', '50', 18, '', 'Varshitha'),
(23, 19, '9', '35mm Natural Grass Regular  ', '57033090', '1', '138', '50', 18, '', 'Varsha'),
(24, 20, '10', 'DF2008 Vinyl Floor Plank (2mm)', '49111090', '3', '8100', '50', 18, '', 'Swathi y k'),
(25, 21, '11', 'Silk Road New', '49111090', '6', '6152', '50', 18, '', 'Fariha Waffa'),
(26, 22, '12', 'Sabya Ex', '48142000', '1', '4000', '50', 18, '', 'Kalyan Kumar'),
(27, 22, '12', '60mm Natural Grass Black Backing', '57033090', '12', '248', '50', 18, '', 'Kalyan Kumar'),
(28, 23, '13', 'Silk Road New', '49111090', '2', '6152', '50', 18, '', 'Fariha waffa'),
(29, 25, '14', 'Jaipur', '49111090', '1', '5632', '50', 18, '', 'Shekarappa'),
(30, 27, '15', 'Jubilant 12', '49111090', '2', '3400', '50', 18, '', 'Kalyan kumar G'),
(31, 28, '16', 'Sure', '49111090 ', '2', '4000', '50', 18, '', 'Fariha Waffa'),
(32, 28, '16', 'Angle', '49111090', '2', '4540', '50', 18, '', 'Fariha Waffa'),
(33, 28, '16', 'Jubilant 12', '49111090', '2', '3400', '50', 18, '', 'Fariha Waffa'),
(34, 28, '16', '3D Gloss', '49111090', '2', '4620', '50', 18, '', 'Fariha Waffa'),
(35, 29, '17', 'Sure', '49111090 ', '2', '4000', '50', 18, '', 'waffa suresh corptr'),
(36, 30, '18', 'Fauna', '49111090', '1', '5560', '50', 18, '', 'waffa'),
(37, 31, '19', '50mm Natural Grass Premium HD', '57033090', '14', '204', '50', 18, '', 'Waffa suresh cur'),
(38, 32, '20', 'Maverick', '49111090', '3', '4980', '50', 18, '', 'Ruheed'),
(39, 32, '20', 'Colour Plus New', '49111090', '3', '5300', '50', 18, '', 'Ruheed'),
(40, 32, '20', 'Beta (Big)', '49111090', '2', '6050', '50', 18, '', 'Ruheed'),
(41, 33, '21', 'Fauna', '49111090', '3', '5560', '50', 18, '', 'Fariha waffa'),
(42, 34, '22', 'sure', '49111090 ', '2', '4000', '50', 18, '', 'Fariha Waffa'),
(43, 35, '23', 'Sure', '49111090 ', '2', '4000', '50', 18, '', 'Fariha Waffa'),
(44, 30, '24', 'Fauna', '49111090', '1', '5560', '50', 18, '', 'Fariha Waffa rf sure'),
(45, 32, '25', 'Colour Plus New', '49111090', '1', '5300', '50', 18, '', 'Ruheed'),
(46, 33, '26', 'Fauna', '49111090', '2', '5560', '50', 18, '', 'Fariha Waffa'),
(47, 37, '27', 'Angle', '49111090', '7', '4540', '50', 18, '', 'ruheed'),
(48, 37, '27', 'Fauna', '49111090', '4', '5560', '50', 18, '', 'ruheed'),
(49, 37, '28', 'Angle', '49111090', '7', '4540', '50', 18, '15890', 'Ruheed'),
(50, 37, '28', 'Maverick', '49111090', '4', '4980', '50', 18, '9960', 'Ruheed'),
(51, 37, '29', 'Roller Black Out Blind With Pelmet', '63039990', '23', '480', '50', 18, '', 'ruheed'),
(52, 38, '30', 'Silk Road New', '49111090', '2', '6152', '50', 18, '', 'Fariha Waffa'),
(53, 39, '31', 'Jubilant 12', '49111090', '1', '3400', '50', 18, '', 'Fariha Waffa'),
(54, 39, '32', 'Jubilant 12', '49111090', '3', '3400', '50', 18, '', 'Fariha waffa'),
(55, 39, '33', 'DF1505 Vinyl Floor Plank (1.5mm)', '49111090', '1', '7020', '50', 18, '', 'Fariha Waffa'),
(56, 12, '34', '3D Gloss', '49111090', '1', '4620', '50', 18, '1', 'test'),
(57, 13, '35', '3D Gloss', '49111090', '1', '4620', '50', 18, '', 'tfgy');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `EMAIL` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `CONTACT_NUMBER` varchar(10) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `ADDRESS` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `VEHICLE_NUMBER` varchar(20) DEFAULT NULL,
  `GST_NUMBER` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`ID`, `NAME`, `EMAIL`, `CONTACT_NUMBER`, `ADDRESS`, `VEHICLE_NUMBER`, `GST_NUMBER`) VALUES
(2, 'Tattva', 'tattvabangalore1@gmail.com', '9342411919', 'Embassy Complex Bangalore 560027', '', '29AEEPB1993F1ZK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_credentials`
--
ALTER TABLE `admin_credentials`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`INVOICE_ID`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `medicines_stock`
--
ALTER TABLE `medicines_stock`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_credentials`
--
ALTER TABLE `admin_credentials`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `INVOICE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `medicines_stock`
--
ALTER TABLE `medicines_stock`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
