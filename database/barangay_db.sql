-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2024 at 12:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barangay_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(2) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`, `type`) VALUES
(1, 'barangay', 'barangay', 'Administrator'),
(2, 'admin', '12345', 'Administrator'),
(3, 'captain', 'captain', 'Captain'),
(4, 'kagawad', 'kagawad', 'Kagawad');

-- --------------------------------------------------------

--
-- Table structure for table `avail_cert`
--

CREATE TABLE `avail_cert` (
  `availID` int(5) NOT NULL,
  `Document_Type` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `amount` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `avail_cert`
--

INSERT INTO `avail_cert` (`availID`, `Document_Type`, `status`, `amount`) VALUES
(1, 'Residency', 'Available', 50),
(2, 'Indigency', 'Available', 50),
(3, 'Low Income', 'Available', 80),
(4, 'Clearance', 'Available', 50),
(5, 'CEDULA', 'Available', 50);

-- --------------------------------------------------------

--
-- Table structure for table `certificate_tb`
--

CREATE TABLE `certificate_tb` (
  `certID` int(11) NOT NULL,
  `Res_ID` int(11) NOT NULL,
  `Staff_ID` int(11) NOT NULL,
  `Docs_ID` int(5) NOT NULL,
  `Document_Type` varchar(50) NOT NULL,
  `ORNo` int(6) NOT NULL,
  `Purpose` varchar(80) NOT NULL,
  `Remarks` varchar(150) NOT NULL,
  `Issue_Date` date NOT NULL,
  `Cease_Date` date NOT NULL,
  `RecordedBy` varchar(30) NOT NULL,
  `Issuance_Status` varchar(50) NOT NULL,
  `Amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificate_tb`
--

INSERT INTO `certificate_tb` (`certID`, `Res_ID`, `Staff_ID`, `Docs_ID`, `Document_Type`, `ORNo`, `Purpose`, `Remarks`, `Issue_Date`, `Cease_Date`, `RecordedBy`, `Issuance_Status`, `Amount`) VALUES
(19, 48, 16, 3, 'Low Income', 0, 'Scholarship', 'Unknown', '2024-05-07', '2024-05-14', 'Cadagat, Einna Joy', 'Approved', 80.00),
(21, 52, 16, 4, 'Clearance', 0, 'Refresh', 'Unknown', '2024-05-14', '2024-05-21', 'Cadagat, Einna Joy', 'Approved', 50.00),
(22, 37, 16, 4, 'Clearance', 0, 'asdada', 'Unknown', '2024-05-18', '2024-05-25', 'Cadagat, Einna Joy', 'Approved', 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `events_tb`
--

CREATE TABLE `events_tb` (
  `eventID` int(5) NOT NULL,
  `Off_ID` int(5) NOT NULL,
  `Event_Name` varchar(50) NOT NULL,
  `Event_Date` date NOT NULL,
  `Event_Location` varchar(50) NOT NULL,
  `Event_Description` varchar(200) NOT NULL,
  `Event_Status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `families_tb`
--

CREATE TABLE `families_tb` (
  `id` int(5) NOT NULL,
  `Res_ID` int(8) NOT NULL,
  `Fam_LName` varchar(100) NOT NULL,
  `Fam_Address` varchar(80) NOT NULL,
  `Fam_Income` int(9) NOT NULL,
  `Fam_Contact` varchar(20) NOT NULL,
  `Fam_MCount` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `families_tb`
--

INSERT INTO `families_tb` (`id`, `Res_ID`, `Fam_LName`, `Fam_Address`, `Fam_Income`, `Fam_Contact`, `Fam_MCount`) VALUES
(22, 37, 'Cadagat, Einna Joy', 'Davao City', 100000, '09124598660', 5),
(23, 42, 'Andrade, Melquiades III Caballero', 'Davao City', 111111, '091291313131', 11),
(24, 47, 'Cajegas, John Laurence Atejano', 'Cat Grande', 12, '09066743493', 4),
(25, 52, '2eqwqw, qweqweqw qweqweqw', 'Davao City', 1, '09124598660', 1);

-- --------------------------------------------------------

--
-- Table structure for table `household_tb`
--

CREATE TABLE `household_tb` (
  `id` int(5) NOT NULL,
  `Fam_ID` int(5) NOT NULL,
  `Household_Ownership` varchar(50) NOT NULL,
  `Household_Type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `household_tb`
--

INSERT INTO `household_tb` (`id`, `Fam_ID`, `Household_Ownership`, `Household_Type`) VALUES
(11, 24, 'Joints Ownership', 'Condominium'),
(12, 24, 'Tenants in Common', 'Mobile Home'),
(13, 22, 'Sole Ownership', 'Apartment');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `logdate` datetime NOT NULL,
  `action` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user`, `logdate`, `action`) VALUES
(80, 'Administrator', '2024-05-05 22:28:39', 'Cancelled Event with ID #15'),
(81, 'Administrator', '2024-05-05 22:33:32', 'Deleted official(s): Cadagat, Einna Joy'),
(82, 'Captain', '2024-05-05 16:34:20', 'Captain logged in'),
(83, 'Administrator', '2024-05-05 14:38:07', 'Administrator logged in'),
(84, 'Administrator', '2024-05-05 14:39:40', 'Administrator logged in'),
(85, 'Kagawad', '2024-05-05 14:54:07', 'Kagawad logged in'),
(86, 'Captain', '2024-05-05 21:32:34', 'Captain logged in'),
(87, 'Owis', '2024-05-05 21:33:19', 'Staff logged in'),
(88, 'Administrator', '2024-05-05 21:38:29', 'Administrator logged in'),
(89, 'Administrator', '2024-05-05 21:55:35', 'Administrator logged in'),
(90, 'Cadagat, Einna Joy', '2024-05-05 21:56:33', 'Staff logged in'),
(91, 'Administrator', '2024-05-05 21:57:54', 'Administrator logged in'),
(92, 'Owis', '2024-05-05 21:58:52', 'Staff logged in'),
(93, 'Administrator', '2024-05-05 22:09:18', 'Administrator logged in'),
(94, 'Captain', '2024-05-05 22:15:02', 'Captain logged in'),
(95, 'Administrator', '2024-05-06 02:25:16', 'Administrator logged in'),
(96, 'Captain', '2024-05-06 02:28:22', 'Captain logged in'),
(97, 'Cadagat, Einna Joy', '2024-05-06 02:31:27', 'Staff logged in'),
(98, 'Administrator', '2024-05-06 02:32:23', 'Administrator logged in'),
(99, 'Cadagat, Einna Joy', '2024-05-06 02:37:58', 'Staff logged in'),
(100, 'Administrator', '2024-05-06 02:43:24', 'Administrator logged in'),
(101, 'Administrator', '2024-05-06 10:45:08', 'Added Resident named Ipsum, Lorem Lorem'),
(102, 'Captain', '2024-05-06 02:47:26', 'Captain logged in'),
(103, 'Captain', '2024-05-06 02:53:40', 'Captain logged in'),
(104, 'Administrator', '2024-05-06 02:54:01', 'Administrator logged in'),
(105, 'Administrator', '2024-05-06 10:55:24', 'Added Staff named Cadagat, Einna Joy, with On Going Term'),
(106, 'Cadagat, Einna Joy', '2024-05-06 02:55:40', 'Staff logged in'),
(107, 'Kagawad', '2024-05-06 02:56:26', 'Kagawad logged in'),
(108, 'Cadagat, Einna Joy', '2024-05-06 02:57:02', 'Staff logged in'),
(109, 'Kagawad', '2024-05-06 02:59:15', 'Kagawad logged in'),
(110, 'Cadagat, Einna Joy', '2024-05-06 03:00:03', 'Staff logged in'),
(111, 'Administrator', '2024-05-06 03:05:15', 'Administrator logged in'),
(112, 'Administrator', '2024-05-06 11:06:39', 'Updated Resident named Cadagat, Einna Joy Cadagat'),
(113, 'Administrator', '2024-05-06 11:07:07', 'Updated Resident named Cadagat, Einna Joy Cadagat'),
(114, 'Administrator', '2024-05-06 03:13:39', 'Administrator logged in'),
(115, 'Administrator', '2024-05-06 03:22:22', 'Administrator logged in'),
(116, 'Administrator', '2024-05-06 11:23:47', 'Added Event with Name FunRun! in this date 2024-05-06'),
(117, 'Cadagat, Einna Joy', '2024-05-06 03:31:43', 'Staff logged in'),
(118, 'Kagawad', '2024-05-06 03:32:51', 'Kagawad logged in'),
(119, 'Cadagat, Einna Joy', '2024-05-06 03:36:52', 'Staff logged in'),
(120, 'Administrator', '2024-05-06 11:11:24', 'Administrator logged in'),
(121, 'Captain', '2024-05-06 11:12:00', 'Captain logged in'),
(122, 'Cadagat, Einna Joy', '2024-05-06 11:12:21', 'Staff logged in'),
(123, 'Captain', '2024-05-06 11:14:04', 'Captain logged in'),
(124, 'Cadagat, Einna Joy', '2024-05-07 14:59:20', 'Staff logged in'),
(125, 'Captain', '2024-05-07 15:05:03', 'Captain logged in'),
(126, 'Administrator', '2024-05-07 15:05:18', 'Administrator logged in'),
(127, 'Cadagat, Einna Joy', '2024-05-07 15:06:05', 'Staff logged in'),
(128, 'Captain', '2024-05-07 15:08:14', 'Captain logged in'),
(129, 'Cadagat, Einna Joy', '2024-05-07 15:10:36', 'Staff logged in'),
(130, 'Cadagat, Einna Joy', '2024-05-07 15:11:20', 'Staff logged in'),
(131, 'Captain', '2024-05-07 15:11:34', 'Captain logged in'),
(132, 'Cadagat, Einna Joy', '2024-05-07 15:12:11', 'Staff logged in'),
(133, 'Staff', '2024-05-07 23:20:58', 'Added Resident named ,  '),
(134, 'Staff', '2024-05-07 23:34:16', 'Added Resident named ,  '),
(135, 'Staff', '2024-05-07 23:36:15', 'Updated Resident named Cadagat, Einna Joy Cadagat'),
(136, 'Administrator', '2024-05-09 03:14:20', 'Administrator logged in'),
(137, 'Administrator', '2024-05-09 03:14:46', 'Updated Resident named Cadagat, Einna Joy Cadagat'),
(138, 'Administrator', '2024-05-09 03:15:50', 'Updated Resident named Andrade, Melquiades III Caballero'),
(139, 'Administrator', '2024-05-09 03:16:07', 'Updated Resident named Andrade, Melquiades III Caballero'),
(140, 'Administrator', '2024-05-09 03:16:16', 'Updated Resident named Cadagat, Einna Joy Cadagat'),
(141, 'Administrator', '2024-05-09 03:16:31', 'Updated Resident named Andrade, Melquiades III Caballero'),
(142, 'Administrator', '2024-05-09 03:16:54', 'Updated Resident named Cadagat, Einna Joy Cadagat'),
(143, 'Administrator', '2024-05-09 20:40:45', 'Administrator logged in'),
(144, 'Administrator', '2024-05-09 20:41:05', 'Updated Resident named Cadagat, Einna Joy Cadagat'),
(145, 'Administrator', '2024-05-09 20:41:19', 'Updated Resident named Andrade, Melquiades III Caballero'),
(146, 'Administrator', '2024-05-09 21:06:30', 'Administrator logged in'),
(147, 'Administrator', '2024-05-09 22:14:16', 'Added Family Head with Lastname '),
(148, 'Administrator', '2024-05-09 22:18:37', 'Updated Family Head with Lastname Andrade'),
(149, 'Administrator', '2024-05-09 22:21:38', 'Added Household with Familiy ID #17'),
(150, 'Administrator', '2024-05-09 22:48:00', 'Updated Resident named Andrade, Melquiades III Caballero'),
(151, 'Administrator', '2024-05-09 22:48:36', 'Updated Resident named Andrade, Melquiades III Caballero'),
(152, 'Administrator', '2024-05-09 22:48:59', 'Updated Resident named Andrade, Melquiades III Caballero'),
(153, 'Cadagat, Einna Joy', '2024-05-10 00:35:54', 'Staff logged in'),
(154, 'Cadagat, Einna Joy', '2024-05-10 01:42:58', 'Staff logged in'),
(155, 'Staff', '2024-05-10 02:01:35', 'Updated Resident named Cadagat, Einna Joy Cadagat'),
(156, 'Staff', '2024-05-10 02:01:50', 'Updated Resident named Andrade, Melquiades III Caballero'),
(157, 'Staff', '2024-05-10 02:02:18', 'Updated Resident named Cajegas, John Laurence Atejano'),
(158, 'Staff', '2024-05-10 02:02:30', 'Updated Resident named Ipsum, Lorem Lorem'),
(159, 'Administrator', '2024-05-10 02:02:44', 'Administrator logged in'),
(160, 'Captain', '2024-05-10 02:11:33', 'Captain logged in'),
(161, 'Cadagat, Einna Joy', '2024-05-10 07:55:57', 'Logged in as Staff Cadagat, Einna Joy'),
(162, 'Administrator', '2024-05-10 07:56:34', 'Administrator logged in'),
(163, 'Administrator', '2024-05-10 08:29:39', 'Cancelled Event with ID #16'),
(164, 'Administrator', '2024-05-10 08:32:05', 'Updated Family Head with Lastname Andrade, Melquiades III C.'),
(165, 'Administrator', '2024-05-10 08:33:46', 'Deleted request(s): Indigency'),
(166, 'Administrator', '2024-05-10 09:28:51', 'Updated Resident named Ipsum, Lorem Lorem'),
(167, 'Administrator', '2024-05-10 09:29:05', 'Updated Resident named Ipsum, Lorem Lorem'),
(168, 'Administrator', '2024-05-10 09:33:53', 'Updated Resident named Ipsum, Lorem Lorem'),
(169, 'Administrator', '2024-05-10 09:34:17', 'Updated Resident named Ipsum, Lorem Lorem'),
(170, 'Administrator', '2024-05-10 09:37:16', 'Added Resident named Doe, John J.'),
(171, 'Administrator', '2024-05-10 09:42:04', 'Updated Resident named Doe, John J.'),
(172, 'Administrator', '2024-05-10 09:44:20', 'Updated Resident named Doe, John J.'),
(173, 'Administrator', '2024-05-10 09:46:33', 'Updated Resident named Doe, John J.'),
(174, 'Administrator', '2024-05-10 10:37:03', 'Updated Resident named Doe, John J.'),
(175, 'Administrator', '2024-05-10 10:42:18', 'Added Resident named 2eqwqw, qweqweqw qweqweqw'),
(176, 'Cadagat, Einna Joy', '2024-05-11 06:42:06', 'Logged in as Staff Cadagat, Einna Joy'),
(177, 'Administrator', '2024-05-11 06:42:59', 'Administrator logged in'),
(178, 'Administrator', '2024-05-11 06:53:53', 'Added Event with Name Dli ko in this date 2024-05-25'),
(179, 'Administrator', '2024-05-11 15:16:45', 'Administrator logged in'),
(180, 'Cadagat, Einna Joy', '2024-05-11 15:30:40', 'Logged in as Staff Cadagat, Einna Joy'),
(181, 'Cadagat, Einna Joy', '2024-05-11 15:30:40', 'Logged in as Staff Cadagat, Einna Joy'),
(182, 'Staff', '2024-05-11 15:36:39', 'Updated Resident named Cajegas, John Laurence Atejano'),
(183, 'Staff', '2024-05-11 15:36:52', 'Updated Resident named Cajegas, John Laurence Atejano'),
(184, 'Staff', '2024-05-11 15:39:06', 'Updated Resident named Cajegas, John Laurence Atejano'),
(185, 'Administrator', '2024-05-11 15:42:40', 'Administrator logged in'),
(186, 'Administrator', '2024-05-11 16:14:01', 'Updated Event with Name FunRun! in this date 2024-05-06'),
(187, 'Administrator', '2024-05-11 16:15:44', 'Updated Resident named Cajegas, John Laurence Atejano'),
(188, 'Administrator', '2024-05-11 16:16:40', 'Updated Resident named Cajegas, John Laurence Atejano'),
(189, 'Cadagat, Einna Joy', '2024-05-11 16:51:24', 'Logged in as Staff Cadagat, Einna Joy'),
(190, 'Administrator', '2024-05-11 16:59:40', 'Administrator logged in'),
(191, 'Administrator', '2024-05-11 17:04:03', 'Updated Family Head with Lastname Andrade, Melquiades III C.'),
(192, 'Administrator', '2024-05-11 17:04:25', 'Added Family Head with Lastname Ipsum, Lorem '),
(193, 'Administrator', '2024-05-11 17:10:25', 'Administrator logged in'),
(194, 'Administrator', '2024-05-11 17:10:39', 'Updated Family Head with Lastname Ipsum, Lorem '),
(195, 'Administrator', '2024-05-11 17:10:58', 'Added Family Head with Lastname qwewqeqw'),
(196, 'Administrator', '2024-05-11 17:19:53', 'Added Household with Familiy ID #17'),
(197, 'Administrator', '2024-05-11 17:20:20', 'Added Staff named Cajegas, John Laurence, with On Going Term'),
(198, 'Cajegas, John Laurence', '2024-05-11 17:22:08', 'Logged in as Staff Cajegas, John Laurence'),
(199, 'Staff', '2024-05-11 17:29:13', 'Added Event with Name asd in this date 2024-05-11'),
(200, 'Staff', '2024-05-11 17:30:42', 'Updated Event with Name FunRun! in this date 2024-05-06'),
(201, 'Staff', '2024-05-11 17:34:25', 'Updated Event with Name asd in this date 2024-05-11'),
(202, 'Staff', '2024-05-11 17:51:38', 'Updated Household with Familiy ID #17'),
(203, 'Staff', '2024-05-11 17:55:58', 'Updated Household with Familiy ID #17'),
(204, 'Staff', '2024-05-11 17:57:35', 'Updated Household with Familiy ID #17'),
(205, 'Cajegas, John Laurence', '2024-05-11 17:58:53', 'Logged in as Staff Cajegas, John Laurence'),
(206, 'Staff', '2024-05-11 17:59:33', 'Updated Event with Name asd in this date 2024-05-11'),
(207, 'Administrator', '2024-05-11 19:07:14', 'Updated Official with ID 9'),
(208, 'Administrator', '2024-05-11 19:07:31', 'Updated Official with ID 9'),
(209, 'Administrator', '2024-05-11 19:09:20', 'Updated Official with ID 12'),
(210, 'Administrator', '2024-05-11 19:11:00', 'Updated Official with ID 9'),
(211, 'Administrator', '2024-05-11 19:12:21', 'Updated Official with ID 9'),
(212, 'Administrator', '2024-05-11 19:13:36', 'Updated Official with ID 9'),
(213, 'Administrator', '2024-05-11 19:19:04', 'Updated Official with ID 9'),
(214, 'Administrator', '2024-05-11 19:20:44', 'Updated Official with ID 9'),
(215, 'Administrator', '2024-05-11 19:24:12', 'Updated Official with ID 9'),
(216, 'Administrator', '2024-05-11 19:24:30', 'Updated Official with ID 10'),
(217, 'Administrator', '2024-05-11 19:24:40', 'Updated Official with ID 11'),
(218, 'Administrator', '2024-05-11 19:24:52', 'Updated Official with ID 12'),
(219, 'Administrator', '2024-05-11 19:50:13', 'Updated Official with ID 9'),
(220, 'Administrator', '2024-05-11 19:53:33', 'Updated Official with ID 13'),
(221, 'Administrator', '2024-05-11 19:54:53', 'Updated Official with ID 9'),
(222, 'Administrator', '2024-05-11 19:55:05', 'Updated Official with ID 9'),
(223, 'Administrator', '2024-05-11 20:08:21', 'Deleted official(s): Cadagat, Einna Joy'),
(224, 'Administrator', '2024-05-11 20:23:03', 'Deleted official(s): Andrade, Melquiades III C.'),
(225, 'Administrator', '2024-05-11 20:53:43', 'Updated Official with ID 24'),
(226, 'Administrator', '2024-05-11 20:53:54', 'Updated Official with ID 25'),
(227, 'Administrator', '2024-05-11 20:55:37', 'Updated Official with ID 25'),
(228, 'Administrator', '2024-05-11 20:55:57', 'Updated Official with ID 24'),
(229, 'Administrator', '2024-05-11 20:56:46', 'Deleted official(s): Lorem, Ipsumz'),
(230, 'Administrator', '2024-05-11 21:34:51', 'Administrator logged in'),
(231, 'Administrator', '2024-05-11 21:42:02', 'Updated Official with ID 23'),
(232, 'Administrator', '2024-05-11 21:42:26', 'Updated Official with ID 20'),
(233, 'Administrator', '2024-05-11 21:42:41', 'Updated Official with ID 22'),
(234, 'Administrator', '2024-05-11 21:43:07', 'Updated Official with ID 29'),
(235, 'Administrator', '2024-05-11 21:43:39', 'Updated Official with ID 28'),
(236, 'Administrator', '2024-05-11 21:44:04', 'Updated Official with ID 20'),
(237, 'Administrator', '2024-05-11 21:44:16', 'Updated Official with ID 22'),
(238, 'Administrator', '2024-05-11 21:44:25', 'Updated Official with ID 23'),
(239, 'Administrator', '2024-05-11 21:44:35', 'Updated Official with ID 29'),
(240, 'Administrator', '2024-05-11 21:55:25', 'Administrator logged in'),
(241, 'Administrator', '2024-05-12 00:36:23', 'Administrator logged in'),
(242, 'Administrator', '2024-05-12 07:27:02', 'Administrator logged in'),
(243, 'Cadagat, Einna Joy', '2024-05-12 07:29:52', 'Logged in as Staff Cadagat, Einna Joy'),
(244, 'Administrator', '2024-05-12 07:40:40', 'Administrator logged in'),
(245, 'Captain', '2024-05-12 13:23:28', 'Captain logged in'),
(246, 'Cadagat, Einna Joy', '2024-05-12 13:23:49', 'Logged in as Staff Cadagat, Einna Joy'),
(247, 'Administrator', '2024-05-13 10:20:33', 'Administrator logged in'),
(248, 'Administrator', '2024-05-14 00:27:30', 'Administrator logged in'),
(249, 'Administrator', '2024-05-14 00:29:19', 'Administrator logged in'),
(250, 'Administrator', '2024-05-14 00:45:55', 'Administrator logged in'),
(251, 'Administrator', '2024-05-14 00:51:14', 'Administrator logged in'),
(252, 'Administrator', '2024-05-14 00:51:40', 'Administrator logged in'),
(253, 'Administrator', '2024-05-14 00:52:00', 'Administrator logged in'),
(254, 'Administrator', '2024-05-14 09:47:47', 'Administrator logged in'),
(255, 'Cadagat, Einna Joy', '2024-05-14 09:58:24', 'Logged in as Staff Cadagat, Einna Joy'),
(256, 'Captain', '2024-05-14 09:59:25', 'Captain logged in'),
(257, 'Captain', '2024-05-14 09:59:44', 'Approved certificate with ID: 21'),
(258, 'Administrator', '2024-05-14 10:01:28', 'Administrator logged in'),
(259, 'Administrator', '2024-05-14 10:45:51', 'Administrator logged in'),
(260, 'Captain', '2024-05-14 10:46:17', 'Captain logged in'),
(261, 'Captain', '2024-05-14 10:46:38', 'Disapproved certificate with ID: 20'),
(262, 'Administrator', '2024-05-14 10:47:00', 'Administrator logged in'),
(263, 'Administrator', '2024-05-14 15:39:22', 'Administrator logged in'),
(264, 'Administrator', '2024-05-14 16:10:14', 'Deleted request(s): Low Income'),
(265, 'Administrator', '2024-05-16 07:37:20', 'Administrator logged in'),
(266, 'Administrator', '2024-05-16 22:45:45', 'Administrator logged in'),
(267, 'Administrator', '2024-05-18 11:57:49', 'Administrator logged in'),
(268, 'Administrator', '2024-05-18 12:28:53', 'Administrator logged in'),
(269, 'Administrator', '2024-05-18 17:52:57', 'Administrator logged in'),
(270, 'Cadagat, Einna Joy', '2024-05-18 18:17:25', 'Logged in as Staff Cadagat, Einna Joy'),
(271, 'Captain', '2024-05-18 18:18:03', 'Captain logged in'),
(272, 'Captain', '2024-05-18 18:18:11', 'Approved certificate with ID: 22'),
(273, 'Cadagat, Einna Joy', '2024-05-18 18:18:24', 'Logged in as Staff Cadagat, Einna Joy'),
(274, 'Administrator', '2024-05-18 20:09:46', 'Administrator logged in'),
(275, 'Administrator', '2024-05-18 20:19:12', 'Administrator logged in'),
(276, 'Administrator', '2024-05-18 20:37:24', 'Administrator logged in'),
(277, 'Cadagat, Einna Joy', '2024-05-18 21:45:40', 'Logged in as Staff Cadagat, Einna Joy'),
(278, 'Administrator', '2024-05-18 22:06:43', 'Administrator logged in'),
(279, 'Administrator', '2024-05-18 22:22:45', 'Administrator logged in'),
(280, 'Administrator', '2024-05-18 22:24:44', 'Updated Staff named Cadagat, Einna Joy, with On Going Term'),
(281, 'Administrator', '2024-05-18 22:24:59', 'Updated Staff named Cajegas, John Laurence, with On Going Term'),
(282, 'Cadagat, Einna Joy', '2024-05-18 22:27:00', 'Logged in as Staff Cadagat, Einna Joy'),
(283, 'Captain', '2024-05-18 22:36:27', 'Captain logged in'),
(284, 'Administrator', '2024-05-18 22:37:24', 'Administrator logged in'),
(285, 'Cadagat, Einna Joy', '2024-05-19 00:32:22', 'Logged in as Staff Cadagat, Einna Joy'),
(286, 'Staff', '2024-05-19 11:00:29', 'Added Family Head with Lastname '),
(287, 'Administrator', '2024-05-19 11:05:23', 'Administrator logged in'),
(288, 'Administrator', '2024-05-19 11:50:39', 'Added Family Head with Lastname Cadagat, Einna Joy Cadagat'),
(289, 'Administrator', '2024-05-19 11:58:30', 'Added Family Head with Lastname Cadagat, Einna Joy Cadagat'),
(290, 'Administrator', '2024-05-19 12:10:44', 'Added Family Head with Lastname Andrade, Melquiades III Caballero'),
(291, 'Administrator', '2024-05-19 12:21:48', 'Added Family Head with Lastname Cajegas, John Laurence Atejano'),
(292, 'Administrator', '2024-05-19 12:25:39', 'Added Household with Family ID #22Cadagat, Einna Joy Cadagat'),
(293, 'Administrator', '2024-05-19 12:41:41', 'Added Family Head with Lastname 2eqwqw, qweqweqw qweqweqw'),
(294, 'Administrator', '2024-05-19 15:55:55', 'Updated Family Head with Lastname Cadagat, Einna Joy Cadagat'),
(295, 'Administrator', '2024-05-19 16:02:26', 'Updated Family Head with Lastname Cadagat, Einna Joy'),
(296, 'Administrator', '2024-05-19 16:12:04', 'Updated Family Head with Lastname Cajegas, John Laurence Atejano'),
(297, 'Administrator', '2024-05-19 16:21:27', 'Added Household with Family ID #22'),
(298, 'Administrator', '2024-05-19 16:45:10', 'Added Household with Family ID #22 - Cadagat, Einna Joy'),
(299, 'Administrator', '2024-05-19 16:51:26', 'Added Household with Family ID #24 - Cajegas, John Laurence Atejano'),
(300, 'Administrator', '2024-05-19 16:55:34', 'Updated Household with Familiy ID #22 - Cadagat, Einna Joy'),
(301, 'Administrator', '2024-05-19 16:56:49', 'Updated Household with Familiy ID #22 - Cadagat, Einna Joy'),
(302, 'Administrator', '2024-05-19 17:01:34', 'Updated Household with Familiy ID #22 - Cadagat, Einna Joy'),
(303, 'Administrator', '2024-05-19 17:04:51', 'Administrator logged in'),
(304, 'Administrator', '2024-05-19 17:05:10', 'Updated Staff named Cadagat, Einna Joy, with On Going Term'),
(305, 'Cadagat, Einna Joy', '2024-05-19 17:05:20', 'Logged in as Staff Cadagat, Einna Joy'),
(306, 'Staff', '2024-05-19 17:07:24', 'Updated Household with Familiy ID #24 - Cajegas, John Laurence Atejano'),
(307, 'Administrator', '2024-05-19 17:19:01', 'Administrator logged in'),
(308, 'Administrator', '2024-05-19 17:41:19', 'Updated Staff named Cadagat, Einna Joy, with Not Active'),
(309, 'Administrator', '2024-05-19 17:41:30', 'Updated Staff named Cadagat, Einna Joy, with On Going Term'),
(310, 'Administrator', '2024-05-19 17:50:22', 'Added Staff named Cajegas, John Laurence Atejano, with On Going Term'),
(311, 'Administrator', '2024-05-19 17:51:32', 'Added Staff named Ipsum, Lorem Lorem, with On Going Term'),
(312, 'Cadagat, Einna Joy', '2024-05-19 18:30:57', 'Logged in as Staff Cadagat, Einna Joy'),
(313, 'Staff', '2024-05-19 18:41:27', 'Added Household with Familiy ID #22 - Cadagat, Einna Joy');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_05_13_031807_create_admin_table', 0),
(2, '2024_05_13_031807_create_avail_cert_table', 0),
(3, '2024_05_13_031807_create_certificate_tb_table', 0),
(4, '2024_05_13_031807_create_events_tb_table', 0),
(5, '2024_05_13_031807_create_families_tb_table', 0),
(6, '2024_05_13_031807_create_household_tb_table', 0),
(7, '2024_05_13_031807_create_logs_table', 0),
(8, '2024_05_13_031807_create_officials_tb_table', 0),
(9, '2024_05_13_031807_create_residents_tb_table', 0),
(10, '2024_05_13_031807_create_staff_tb_table', 0),
(11, '2024_05_13_031810_add_foreign_keys_to_certificate_tb_table', 0),
(12, '2024_05_13_031810_add_foreign_keys_to_events_tb_table', 0),
(13, '2024_05_13_031810_add_foreign_keys_to_families_tb_table', 0),
(14, '2024_05_13_031810_add_foreign_keys_to_household_tb_table', 0),
(15, '2024_05_13_031810_add_foreign_keys_to_officials_tb_table', 0),
(16, '2024_05_13_031810_add_foreign_keys_to_staff_tb_table', 0);

-- --------------------------------------------------------

--
-- Table structure for table `officials_tb`
--

CREATE TABLE `officials_tb` (
  `offID` int(5) NOT NULL,
  `Res_ID` int(7) NOT NULL,
  `Off_Pos` varchar(50) NOT NULL,
  `Off_CName` varchar(50) NOT NULL,
  `Off_Contact` varchar(12) NOT NULL,
  `Off_Address` text NOT NULL,
  `Off_TermStart` date NOT NULL,
  `Off_TermEnd` date NOT NULL,
  `Off_Status` varchar(100) NOT NULL,
  `Off_Img` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `officials_tb`
--

INSERT INTO `officials_tb` (`offID`, `Res_ID`, `Off_Pos`, `Off_CName`, `Off_Contact`, `Off_Address`, `Off_TermStart`, `Off_TermEnd`, `Off_Status`, `Off_Img`) VALUES
(17, 37, 'Barangay Captain', 'Cadagat, Einna Joy', '091234567890', 'Catalunan Grande', '2024-05-11', '2024-05-31', 'Ongoing Term', 0x313731353432393332343438325f3433363838383834395f3437363132323838343735333936355f3236363336383737353731393435343537315f6e2e6a7067),
(19, 42, 'Kagawad (Ordinance)', 'Andrade, Melquiades III C.', '091234567890', 'Catalunan Grande', '2024-05-11', '2024-05-31', 'Ongoing Term', 0x313731353433303234343832305f63686169722e6a7067),
(20, 42, 'Kagawad (Public Safety)', 'Andrade, Thirdy C.', '091234567890', 'Catalunan Grande', '2024-05-11', '2024-05-31', 'Ongoing Term', 0x313731353433353034343636315f63686169722e6a7067),
(21, 47, 'Kagawad (Tourism)', 'Cajegas, John Laurence', '091234567890', 'Catalunan Grande', '2024-05-11', '2024-05-31', 'Ongoing Term', 0x313731353433303333383530315f63686169722e6a7067),
(22, 47, 'Kagawad (Budget & Finance)', 'Owissimo, Killbot', '091234567890', 'Catalunan Grande', '2024-05-11', '2024-05-31', 'Ongoing Term', 0x313731353433353035363030385f63686169722e6a7067),
(23, 47, 'Kagawad (Agriculture)', 'Owis, Is Gwapo', '091234567890', 'Catalunan Grande', '2024-05-11', '2024-05-31', 'Ongoing Term', 0x313731353433353036353538315f63686169722e6a7067),
(24, 48, 'Kagawad (Education)', 'Ipsum, Lorem', '091234567890', 'Catalunan Grande', '2024-05-11', '2024-05-31', 'Ongoing Term', 0x313731353433323135373135315f63686169722e6a7067),
(26, 51, 'Barangay Secretary', 'Doe, John', '091234567890', 'Catalunan Grande', '2024-05-11', '2024-05-31', 'Ongoing Term', 0x313731353433303438353132345f6e69672e6a7067),
(27, 51, 'Barangay Treasurer', 'John, Doe', '091234567890', 'Catalunan Grande', '2024-05-11', '2024-05-31', 'Ongoing Term', 0x313731353433303530393734395f6e69672e6a7067),
(28, 52, 'SK Chairman', 'Sheesh, Sheesh', '091234567890', 'Catalunan Grande', '2024-05-11', '2024-05-30', 'Ongoing Term', 0x313731353433353031393434355f34666437653061632d323835322d346431642d393130352d3835393930663233623332652e6a7067),
(29, 52, 'Kagawad (Infrastructure)', 'Qwertyuiop, Asdfghjkl', '091234567890', 'Catalunan Grande', '2024-05-11', '2024-05-31', 'Ongoing Term', 0x313731353433353037353131305f63686169722e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `residents_tb`
--

CREATE TABLE `residents_tb` (
  `id` int(5) NOT NULL,
  `Res_Fname` varchar(50) NOT NULL,
  `Res_Mname` varchar(50) NOT NULL,
  `Res_Lname` varchar(50) NOT NULL,
  `Res_Age` int(3) NOT NULL,
  `Res_Birth` date NOT NULL,
  `Res_BPlace` varchar(100) NOT NULL,
  `Res_MarStatus` varchar(50) NOT NULL,
  `Res_Sex` varchar(10) NOT NULL,
  `Res_Contacts` varchar(20) NOT NULL,
  `Res_Address` varchar(50) NOT NULL,
  `Res_Years` varchar(10) NOT NULL,
  `Res_Education` varchar(50) NOT NULL,
  `Res_Religion` varchar(30) NOT NULL,
  `Res_Nationality` varchar(20) NOT NULL,
  `Res_VitalStatus` varchar(10) NOT NULL,
  `Res_Img` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `residents_tb`
--

INSERT INTO `residents_tb` (`id`, `Res_Fname`, `Res_Mname`, `Res_Lname`, `Res_Age`, `Res_Birth`, `Res_BPlace`, `Res_MarStatus`, `Res_Sex`, `Res_Contacts`, `Res_Address`, `Res_Years`, `Res_Education`, `Res_Religion`, `Res_Nationality`, `Res_VitalStatus`, `Res_Img`, `email`, `password_hash`) VALUES
(37, 'Einna Joy', 'Cadagat', 'Cadagat', 21, '2002-07-03', '', 'Single', 'Female', '09066743493', 'Polomolok', '21', 'College, undergraduate', 'Christian', 'Filipino', 'Alive', '66ab10127ed3582b3008302e9afe35be.jpg', 'ejj@gmail.com', 'andrade123'),
(42, 'Melquiades III', 'Caballero', 'Andrade', 20, '2004-04-16', '', 'Single', 'Male', '09066743493', 'Catalunan Grande', '12', 'College, undergraduate', 'Roman Catholic', 'Filipino', 'Alive', '1715277710966_processing-logo.png', 'sample@sample.com', 'andrade123'),
(47, 'John Laurence', 'Atejano', 'Cajegas', 20, '2004-03-07', '', 'Married', 'Male', '09066743493', 'Catalunan Grande', '20', 'College, undergraduate', 'Roman Catholic', 'Filipino', 'Alive', '1715415400119_nig.jpg', 'owissimo@mail.com', '$2y$10$YtlUNmYgIjCBB6g/qNK8QO6K//JsPC65ovuOEz1RDrTqEmlFh1wry'),
(48, 'Lorem', 'Lorem', 'Ipsum', 24, '1999-06-08', '', 'Single', 'Male', '09066743493', 'Catalunan Grande', '20', 'Doctorate degree', 'Roman Catholic', 'Filipino', 'Alive', '1715304857864_4fd7e0ac-2852-4d1d-9105-85990f23b32e.jpg', 'lorem@mail.com', 'andrade123'),
(51, 'John', 'J.', 'Doe', 20, '2003-10-20', '', 'Single', 'Male', '09066743493', 'Catalunan Grande', '10', 'Bachelors degree', 'Roman Catholic', 'Filipino', 'Alive', '1715305593611_436888849_476122884753965_266368775719454571_n.jpg', 'jd@mail.com', '$2y$10$gUFenN1FpcErwKhFCSd7De8upZH3myuU/sE5YQ5SCV4MztCQFyVpi'),
(52, 'qweqweqw', 'qweqweqw', '2eqwqw', 16, '2007-07-10', '', 'Single', 'Male', '09066743493', 'Catalunan Grande', '10', 'High School, undergraduate', 'Roman Catholic', 'Filipino', 'Alive', '1715308938524_436888849_476122884753965_266368775719454571_n.jpg', 'qwe@mail.com', '$2y$10$oMOXN66ItEc6Iw1XtC21Ru3Jli1U4EeyCQY4j9BU.aJ8UMUqQJOa.');

-- --------------------------------------------------------

--
-- Table structure for table `staff_tb`
--

CREATE TABLE `staff_tb` (
  `staffID` int(5) NOT NULL,
  `Res_ID` int(5) NOT NULL,
  `Staff_Name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_tb`
--

INSERT INTO `staff_tb` (`staffID`, `Res_ID`, `Staff_Name`, `email`, `password_hash`, `status`, `type`) VALUES
(16, 37, 'Cadagat, Einna Joy', 'ejj@gmail.com', '$2y$10$z/dycjuh5qD7riX3rL.sW.9dg/Zjf3.O1004Ij94tox.SPTW/xpN6', 'On Going Term', 'Staff'),
(17, 47, 'Cajegas, John Laurence', 'owissimo@mail.com', '$2y$10$wociC2h1yuHpF1XzYhiE0uDd/WzgA.3YbTFb.xrDRF.1lxm6nC0x6', 'On Going Term', 'Staff'),
(25, 48, 'Ipsum, Lorem Lorem', 'lorem@mail.com', '$2y$10$Z3bdEQrhqC811nzktDjSUuKj/n6hcxRyVqy0DmyZu8.e.ZrkfzhAS', 'On Going Term', 'Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `avail_cert`
--
ALTER TABLE `avail_cert`
  ADD PRIMARY KEY (`availID`);

--
-- Indexes for table `certificate_tb`
--
ALTER TABLE `certificate_tb`
  ADD PRIMARY KEY (`certID`),
  ADD KEY `issuance_history_tb_ibfk1` (`Res_ID`),
  ADD KEY `issuance_history_tb_ibfk2` (`Staff_ID`);

--
-- Indexes for table `events_tb`
--
ALTER TABLE `events_tb`
  ADD PRIMARY KEY (`eventID`),
  ADD KEY `events_tb_ibfk1` (`Off_ID`);

--
-- Indexes for table `families_tb`
--
ALTER TABLE `families_tb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `families_tb_ibfk1` (`Res_ID`);

--
-- Indexes for table `household_tb`
--
ALTER TABLE `household_tb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homes_tb_ibfk1` (`Fam_ID`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `officials_tb`
--
ALTER TABLE `officials_tb`
  ADD PRIMARY KEY (`offID`),
  ADD KEY `officials_tb_ibfk1` (`Res_ID`);

--
-- Indexes for table `residents_tb`
--
ALTER TABLE `residents_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_tb`
--
ALTER TABLE `staff_tb`
  ADD PRIMARY KEY (`staffID`),
  ADD KEY `staff_tb_ibfk1` (`Res_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `avail_cert`
--
ALTER TABLE `avail_cert`
  MODIFY `availID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `certificate_tb`
--
ALTER TABLE `certificate_tb`
  MODIFY `certID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `events_tb`
--
ALTER TABLE `events_tb`
  MODIFY `eventID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `families_tb`
--
ALTER TABLE `families_tb`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `household_tb`
--
ALTER TABLE `household_tb`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=314;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `officials_tb`
--
ALTER TABLE `officials_tb`
  MODIFY `offID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `residents_tb`
--
ALTER TABLE `residents_tb`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `staff_tb`
--
ALTER TABLE `staff_tb`
  MODIFY `staffID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `certificate_tb`
--
ALTER TABLE `certificate_tb`
  ADD CONSTRAINT `issuance_history_tb_ibfk1` FOREIGN KEY (`Res_ID`) REFERENCES `residents_tb` (`id`),
  ADD CONSTRAINT `issuance_history_tb_ibfk2` FOREIGN KEY (`Staff_ID`) REFERENCES `staff_tb` (`staffID`);

--
-- Constraints for table `events_tb`
--
ALTER TABLE `events_tb`
  ADD CONSTRAINT `events_tb_ibfk1` FOREIGN KEY (`Off_ID`) REFERENCES `officials_tb` (`offID`);

--
-- Constraints for table `families_tb`
--
ALTER TABLE `families_tb`
  ADD CONSTRAINT `families_tb_ibfk1` FOREIGN KEY (`Res_ID`) REFERENCES `residents_tb` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `household_tb`
--
ALTER TABLE `household_tb`
  ADD CONSTRAINT `homes_tb_ibfk1` FOREIGN KEY (`Fam_ID`) REFERENCES `families_tb` (`id`);

--
-- Constraints for table `officials_tb`
--
ALTER TABLE `officials_tb`
  ADD CONSTRAINT `officials_tb_ibfk1` FOREIGN KEY (`Res_ID`) REFERENCES `residents_tb` (`id`);

--
-- Constraints for table `staff_tb`
--
ALTER TABLE `staff_tb`
  ADD CONSTRAINT `staff_tb_ibfk1` FOREIGN KEY (`Res_ID`) REFERENCES `residents_tb` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
