-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2023 at 11:32 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbphilsca`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(20) NOT NULL,
  `class_code` text NOT NULL,
  `institute_id` int(20) DEFAULT NULL,
  `program_id` int(20) NOT NULL,
  `level` int(11) NOT NULL,
  `period_id` int(11) NOT NULL,
  `slot` int(22) DEFAULT NULL,
  `isSet` int(11) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `class_code`, `institute_id`, `program_id`, `level`, `period_id`, `slot`, `isSet`, `updated_on`, `created_on`) VALUES
(5, 'AIS11', NULL, 13, 1, 11, NULL, 0, '2023-10-26 10:13:18', '2023-10-25 17:24:38');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(20) NOT NULL,
  `subject_code` text NOT NULL,
  `description` text NOT NULL,
  `program_id` int(22) NOT NULL,
  `level` int(22) NOT NULL,
  `term` int(22) NOT NULL,
  `lab_unit` int(11) NOT NULL,
  `lec_unit` int(11) NOT NULL,
  `unit` text NOT NULL,
  `hours` int(11) NOT NULL,
  `prerequisite` int(11) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `subject_code`, `description`, `program_id`, `level`, `term`, `lab_unit`, `lec_unit`, `unit`, `hours`, `prerequisite`, `updated_on`, `created_on`) VALUES
(2, 'GEC 4', 'Purposive Communication', 13, 1, 1, 0, 3, '3', 3, 0, NULL, '2023-07-24 00:38:16'),
(3, 'GEC 10', 'The Entrepreneurial Mind', 13, 1, 1, 0, 3, '3', 3, 0, '2023-07-24 09:20:09', '2023-07-24 01:15:26'),
(4, 'GEC 1', 'Art Appreciation', 13, 1, 1, 0, 3, '3', 3, 0, NULL, '2023-07-24 09:18:39'),
(5, 'GEI 1', 'Character Building', 13, 1, 1, 0, 3, '3', 3, 0, NULL, '2023-07-24 09:20:54'),
(6, 'IS 111', 'Introduction to Computing (HTML/CSS)', 13, 1, 1, 1, 2, '3', 5, 0, NULL, '2023-07-24 09:21:44'),
(7, 'IS 112', 'Airline Operating Procedures', 13, 1, 1, 1, 2, '3', 5, 0, NULL, '2023-07-24 09:22:22'),
(8, 'AIS 111', 'Aviation Fundamentals', 13, 1, 1, 0, 2, '2', 2, 0, NULL, '2023-07-24 09:22:54'),
(9, 'AIS 112', 'Airline Operating Procedures', 13, 1, 1, 0, 3, '3', 3, 0, NULL, '2023-07-24 09:23:27'),
(10, 'PE 1', 'Physical Education 1', 13, 1, 1, 0, 2, '2', 2, 0, NULL, '2023-07-24 09:24:41'),
(11, 'NSTP 1101', 'CWTS/ROTC 1', 13, 1, 1, 0, 0, '10', 0, 0, '2023-07-24 09:53:17', '2023-07-24 09:29:02'),
(12, 'GEC 2', 'Reading in the Philippine History', 13, 2, 1, 0, 3, '3', 3, 0, '2023-07-24 09:44:44', '2023-07-24 09:39:44'),
(13, 'GEC 7', 'Contemporary World', 13, 2, 1, 0, 3, '3', 3, 0, '2023-07-24 09:44:05', '2023-07-24 09:40:10'),
(14, 'IS 211', 'Data Structure and Algorithm', 13, 2, 1, 1, 2, '3', 5, 7, '2023-07-24 09:44:57', '2023-07-24 09:40:43'),
(15, 'IS 212', 'Object Oriented Programming (VB.Net)', 13, 2, 1, 1, 2, '3', 5, 7, '2023-07-24 09:45:07', '2023-07-24 09:41:43'),
(16, 'GEC 5', 'Understanding the Self', 13, 1, 2, 0, 3, '3', 3, 0, NULL, '2023-07-24 09:45:40'),
(17, 'GEC 6', 'Mathematics In the Modern World', 13, 1, 2, 0, 3, '3', 3, 0, NULL, '2023-07-24 09:46:22'),
(18, 'GEC 11', 'Philippine Popular Culture', 13, 1, 2, 0, 3, '3', 3, 0, NULL, '2023-07-24 09:46:51'),
(19, 'IS 121', 'Fundamentals of Information System', 13, 1, 2, 1, 2, '3', 5, 0, NULL, '2023-07-24 09:47:47'),
(20, 'GEC 12', 'Environmental Science', 13, 1, 2, 0, 3, '3', 3, 0, NULL, '2023-07-24 09:48:25'),
(21, 'IS 122', 'Programming 2 (Advance Java)', 13, 1, 2, 1, 2, '3', 5, 7, NULL, '2023-07-24 09:49:09'),
(22, 'AIS 121', 'Aviation Business Process (Airline Reservation)', 13, 1, 2, 0, 3, '3', 3, 0, NULL, '2023-07-24 09:49:32'),
(23, 'AIS 122', 'Passenger Handling', 13, 1, 2, 0, 3, '3', 3, 0, NULL, '2023-07-24 09:50:00'),
(24, 'NSTP 2', 'CWTS 2/ROTC 2', 13, 1, 2, 0, 0, '10', 0, 11, NULL, '2023-07-24 09:52:59'),
(25, 'IS 213', 'IT Infrastructure and Network TEchnologies', 13, 2, 1, 1, 2, '3', 5, 6, NULL, '2023-07-24 09:55:58'),
(26, 'IS 214', 'Professional Issues in Information Systems', 13, 2, 1, 0, 3, '3', 3, 6, NULL, '2023-07-24 09:56:39'),
(27, 'AIS 211', 'General Aviation', 13, 2, 1, 0, 3, '3', 3, 8, NULL, '2023-07-24 09:57:14'),
(28, 'AIS 212', 'Basic Airline Ticketing', 13, 2, 1, 0, 3, '3', 3, 0, NULL, '2023-07-24 09:57:51'),
(29, 'PE 3', 'Physical Education 3', 13, 2, 1, 0, 2, '2', 2, 0, NULL, '2023-07-24 09:58:47'),
(30, 'PE 2', 'Physical Education 2', 13, 1, 2, 0, 2, '2', 2, 0, NULL, '2023-07-24 09:59:14'),
(31, 'GEC 3', 'Science Technology and Society', 13, 2, 2, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:00:06'),
(32, 'IS 221', 'Web Design Development', 13, 2, 2, 1, 2, '3', 3, 6, NULL, '2023-07-24 10:05:28'),
(33, 'IS 222', 'System Analysis and Design', 13, 2, 2, 0, 3, '3', 3, 15, NULL, '2023-07-24 10:06:20'),
(34, 'IS 223', 'Network Admin and Security', 13, 2, 2, 1, 2, '3', 5, 25, NULL, '2023-07-24 10:06:53'),
(35, 'AIS 221', 'Air Laws and Civil Air Regulation', 13, 2, 2, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:12:33'),
(36, 'AIS 222', 'Airport Administration and Supervision', 13, 2, 2, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:13:44'),
(37, 'AIS 224', 'Aviation Economics (Financial and Accounting)', 13, 2, 2, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:14:28'),
(38, 'PE 4', 'Physical Education 4', 13, 2, 2, 0, 2, '2', 2, 0, NULL, '2023-07-24 10:14:53'),
(39, 'AIS 223', 'Advance Airline Ticketing', 13, 2, 2, 0, 3, '3', 3, 28, NULL, '2023-07-24 10:16:06'),
(40, 'GEC 8', 'Ethics', 13, 3, 1, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:17:20'),
(41, 'IS 311', 'Information Management (DB/SQL)', 13, 3, 1, 1, 2, '3', 5, 14, NULL, '2023-07-24 10:18:16'),
(42, 'IS 312', 'Methods of Research in Computing', 13, 3, 1, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:18:58'),
(43, 'IS 313', 'Application Development and Emerging Technologies (Android)', 13, 3, 1, 1, 2, '3', 5, 15, NULL, '2023-07-24 10:21:33'),
(44, 'IS 314', 'Quantitative Method', 13, 3, 1, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:25:37'),
(45, 'AIS 311', 'Aviation Safety and Management', 13, 3, 2, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:26:22'),
(46, 'AIS Elec 1', 'Professional Elective 1', 13, 3, 1, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:27:11'),
(47, 'AIS 313', 'Basic Air Cargo Handling', 13, 3, 1, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:27:40'),
(48, 'AIS 314', 'In-Flight Servicing Procedure', 13, 3, 1, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:28:06'),
(49, 'GEC 9', 'Life and Works of Rizal', 13, 3, 2, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:28:33'),
(50, 'IS 321', 'Capstone Project 1', 13, 3, 2, 0, 3, '3', 3, 43, NULL, '2023-07-24 10:29:14'),
(51, 'IS 322', 'Project Management and Quality System', 13, 3, 2, 0, 3, '3', 3, 33, NULL, '2023-07-24 10:29:53'),
(52, 'IS 323', 'Evaluation of Business Performance', 13, 3, 2, 0, 3, '3', 3, 33, NULL, '2023-07-24 10:30:38'),
(53, 'AIS Elec 2', 'Professional Elective 2', 13, 3, 2, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:31:03'),
(54, 'AIS Elec 3', 'Professional Elective 3', 13, 3, 2, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:31:31'),
(55, 'AIS 322', 'Advance Air Cargo Handling', 13, 3, 2, 0, 3, '3', 3, 45, NULL, '2023-07-24 10:32:06'),
(56, 'AIS 323', 'Airport and Ramp Handling Procedures', 13, 3, 2, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:32:35'),
(57, 'AIS 324', 'Airline Office Management & Practices', 13, 3, 2, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:33:03'),
(58, 'IS 411', 'Capstone Project 2', 13, 4, 1, 0, 3, '3', 3, 50, NULL, '2023-07-24 10:33:48'),
(59, 'IS 412', 'System Infrastructure and Integration', 13, 4, 1, 0, 3, '3', 3, 50, NULL, '2023-07-24 10:34:24'),
(60, 'IS 413', 'Advance Computer  System', 13, 4, 1, 1, 2, '3', 5, 19, NULL, '2023-07-24 10:35:13'),
(61, 'IS 414', 'Management Information System', 13, 4, 1, 0, 3, '3', 3, 41, NULL, '2023-07-24 10:36:22'),
(62, 'AIS Elec 4', 'Professional Elective 4', 13, 4, 1, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:36:54'),
(63, 'AIS Elec 5', 'Professional Elective 5', 13, 4, 1, 0, 3, '3', 3, 0, NULL, '2023-07-24 10:38:29'),
(64, 'IS 421', 'Internship/On-the-Job Training/Practicum', 13, 4, 2, 6, 0, '6', 18, 0, NULL, '2023-07-24 10:40:06');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `title` text NOT NULL,
  `color` text NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `user_id`, `title`, `color`, `start`, `end`, `created_on`) VALUES
(5, 2, 'Opening Day', '#2dce89', '2023-05-03', '2023-05-04', '2023-05-04 19:47:37'),
(6, 20, 'hello', '#11cdef', '2023-05-03', '2023-05-04', '2023-05-06 03:30:01'),
(8, 68, 'Accepting Day', '#2dce89', '2023-05-02', '2023-05-03', '2023-05-09 10:19:27'),
(10, 68, 'Oral Defense', '#f5365c', '2023-05-10', '2023-05-11', '2023-05-09 12:05:06'),
(11, 2, 'k', '#172b4d', '2023-06-27', '2023-06-28', '2023-07-21 17:23:30');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(20) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `id` int(11) NOT NULL,
  `student_id` text NOT NULL,
  `schedule_id` int(22) NOT NULL,
  `prelim` text DEFAULT NULL,
  `midterm` text DEFAULT NULL,
  `final` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`id`, `student_id`, `schedule_id`, `prelim`, `midterm`, `final`, `note`, `updated_on`, `created_on`) VALUES
(120, '30', 40, '77', NULL, NULL, '', NULL, '2023-10-25 19:55:15'),
(121, '28', 40, '77', NULL, NULL, '', NULL, '2023-10-25 19:55:15'),
(122, '24', 40, '77', NULL, NULL, '', NULL, '2023-10-25 19:55:15'),
(123, '30', 42, '90', NULL, NULL, '', NULL, '2023-10-26 06:33:29'),
(124, '28', 42, '99', NULL, NULL, '', NULL, '2023-10-26 06:33:29'),
(125, '24', 42, '98', NULL, NULL, '', NULL, '2023-10-26 06:33:29'),
(126, '30', 41, '55', NULL, NULL, '', NULL, '2023-10-26 06:37:17'),
(127, '28', 41, '77', NULL, NULL, '', NULL, '2023-10-26 06:37:17'),
(128, '30', 41, '88', NULL, NULL, '', NULL, '2023-10-26 06:37:38'),
(129, '28', 41, '89', NULL, NULL, '', NULL, '2023-10-26 06:37:38'),
(130, '24', 41, '88', NULL, NULL, '', NULL, '2023-10-26 06:37:38'),
(131, '30', 43, '78', NULL, NULL, '', NULL, '2023-10-26 06:38:47'),
(132, '28', 43, '78', NULL, NULL, '', NULL, '2023-10-26 06:38:47'),
(133, '24', 43, '78', NULL, NULL, '', NULL, '2023-10-26 06:38:47'),
(134, '30', 44, '90', NULL, NULL, '', NULL, '2023-10-26 06:40:18'),
(135, '28', 44, '99', NULL, NULL, '', NULL, '2023-10-26 06:40:18'),
(136, '24', 44, '88', NULL, NULL, '', NULL, '2023-10-26 06:40:18'),
(137, '30', 45, '90', NULL, NULL, '', NULL, '2023-10-26 06:41:17'),
(138, '28', 45, '89', NULL, NULL, '', NULL, '2023-10-26 06:41:17'),
(139, '24', 45, '78', NULL, NULL, '', NULL, '2023-10-26 06:41:17'),
(140, '30', 46, '77', NULL, NULL, '', NULL, '2023-10-26 06:42:33'),
(141, '28', 46, '89', NULL, NULL, '', NULL, '2023-10-26 06:42:33'),
(142, '24', 46, '88', NULL, NULL, '', NULL, '2023-10-26 06:42:33'),
(143, '30', 47, '90', NULL, NULL, '', NULL, '2023-10-26 06:43:30'),
(144, '28', 47, '89', NULL, NULL, '', NULL, '2023-10-26 06:43:30'),
(145, '24', 47, '98', NULL, NULL, '', NULL, '2023-10-26 06:43:30'),
(146, '30', 48, '90', NULL, NULL, '', NULL, '2023-10-26 06:44:29'),
(147, '28', 48, '99', NULL, NULL, '', NULL, '2023-10-26 06:44:29'),
(148, '24', 48, '77', NULL, NULL, '', NULL, '2023-10-26 06:44:29'),
(149, '30', 49, '77', NULL, NULL, '', NULL, '2023-10-26 06:45:59'),
(150, '28', 49, '89', NULL, NULL, '', NULL, '2023-10-26 06:45:59'),
(151, '24', 49, '88', NULL, NULL, '', NULL, '2023-10-26 06:45:59'),
(152, '30', 49, '90', NULL, NULL, '', NULL, '2023-10-26 10:28:04'),
(153, '28', 49, '99', NULL, NULL, '', NULL, '2023-10-26 10:28:04'),
(154, '24', 49, '78', NULL, NULL, '', NULL, '2023-10-26 10:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `institute`
--

CREATE TABLE `institute` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `updated_on` datetime NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `institute`
--

INSERT INTO `institute` (`id`, `name`, `description`, `updated_on`, `created_on`) VALUES
(1, 'IET', 'Institute of Engineering and Technology', '0000-00-00 00:00:00', '2023-07-21 15:48:16'),
(2, 'ICS', 'Institute of Computer Studies', '0000-00-00 00:00:00', '2023-07-21 15:48:43'),
(3, 'ILAS', 'Institute of Liberal And Sciences', '0000-00-00 00:00:00', '2023-07-21 15:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `isgraded`
--

CREATE TABLE `isgraded` (
  `id` int(11) NOT NULL,
  `class_id` int(22) NOT NULL,
  `course_id` int(22) NOT NULL,
  `isPrelim` int(22) NOT NULL,
  `isMidterm` int(22) DEFAULT NULL,
  `isFinal` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `isgraded`
--

INSERT INTO `isgraded` (`id`, `class_id`, `course_id`, `isPrelim`, `isMidterm`, `isFinal`, `updated_on`, `created_on`) VALUES
(38, 5, 40, 1, NULL, NULL, NULL, '2023-10-25 19:55:15'),
(39, 5, 42, 1, NULL, NULL, NULL, '2023-10-26 06:33:29'),
(40, 5, 41, 1, NULL, NULL, NULL, '2023-10-26 06:37:38'),
(41, 5, 43, 1, NULL, NULL, NULL, '2023-10-26 06:38:47'),
(42, 5, 44, 1, NULL, NULL, NULL, '2023-10-26 06:40:18'),
(43, 5, 45, 1, NULL, NULL, NULL, '2023-10-26 06:41:17'),
(44, 5, 46, 1, NULL, NULL, NULL, '2023-10-26 06:42:33'),
(45, 5, 47, 1, NULL, NULL, NULL, '2023-10-26 06:43:30'),
(46, 5, 48, 1, NULL, NULL, NULL, '2023-10-26 06:44:29'),
(48, 5, 49, 1, NULL, NULL, NULL, '2023-10-26 10:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `recepient_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `recepient_id`, `sender_id`, `content`, `status`, `created_on`) VALUES
(7, 2, 37, 'Note that the second argument of htmlspecialchars() is the ENT_QUOTES flag, which ensures that both single and double quotes are encoded. Also, make sure to pass the output of the short_text() function to htmlspecialchars(), not the other way around as it is currently being done in the $details line.\n\n\n\n\n\n\n', 1, '2023-05-08 01:01:42'),
(20, 68, 97, 'Hello \n            \nYou are receiving this email to notify you that there is a new application.\n            \n\n            \n\n            \n\n            \n\n            \nThis is an automatically generated message. Please do not reply.', 0, '2023-05-17 02:19:11'),
(21, 78, 97, 'Hello \n            \nYou are receiving this email to notify you that there is a new application.\n            \n\n            \n\n            \n\n            \n\n            \nThis is an automatically generated message. Please do not reply.', 0, '2023-05-17 02:19:11'),
(22, 82, 97, 'Hello \n            \nYou are receiving this email to notify you that there is a new application.\n            \n\n            \n\n            \n\n            \n\n            \nThis is an automatically generated message. Please do not reply.', 0, '2023-05-17 02:19:11'),
(23, 83, 97, 'Hello \n            \nYou are receiving this email to notify you that there is a new application.\n            \n\n            \n\n            \n\n            \n\n            \nThis is an automatically generated message. Please do not reply.', 0, '2023-05-17 02:19:11'),
(24, 84, 97, 'Hello \n            \nYou are receiving this email to notify you that there is a new application.\n            \n\n            \n\n            \n\n            \n\n            \nThis is an automatically generated message. Please do not reply.', 0, '2023-05-17 02:19:11'),
(26, 97, 78, 'Hello MINA\n        \nYou are receiving this email to notify your application has been Disapproved.\n        \n\n        \n\n        \n\n        \n\n        \nThis is an automatically generated message. Please do not reply.', 0, '2023-05-17 04:34:39'),
(27, 97, 78, '<br>Hello MINA\n        <br>You are receiving this email to notify you that your application in  (CCCSP) has been Accepted.\n        <br>\n        <br>\n        <br>\n        <br>This is an automatically generated message. Please do not reply.', 0, '2023-05-17 05:07:09'),
(28, 97, 78, '<br>Hello MINA\n        <br>You are receiving this email to notify you that your application in  (CCCSP) has been Denied for grant award.\n        <br>\n        <br>\n        <br>\n        <br>This is an automatically generated message. Please do not reply.', 0, '2023-05-17 05:08:16'),
(29, 97, 78, 'Hello MINA\n        \nYou are receiving this email to notify you that your application has been granted.\n        \n\n        \n\n        \n\n        \n\n        \nThis is an automatically generated message. Please do not reply.', 0, '2023-05-17 05:09:53');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` int(22) NOT NULL,
  `class_id` int(22) NOT NULL,
  `student_id` int(22) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`id`, `class_id`, `student_id`, `created_on`) VALUES
(94, 2, 30, '2023-07-28 23:02:57'),
(95, 2, 28, '2023-07-28 23:02:59'),
(96, 2, 24, '2023-07-28 23:03:01'),
(97, 3, 24, '2023-10-25 16:50:02'),
(98, 3, 28, '2023-10-25 16:50:06'),
(99, 3, 30, '2023-10-25 16:50:08'),
(108, 5, 30, '2023-10-25 17:39:41'),
(109, 5, 28, '2023-10-25 17:45:41'),
(110, 5, 24, '2023-10-25 17:47:47');

-- --------------------------------------------------------

--
-- Table structure for table `period`
--

CREATE TABLE `period` (
  `id` int(22) NOT NULL,
  `year` text NOT NULL,
  `term` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `period`
--

INSERT INTO `period` (`id`, `year`, `term`, `status`, `updated_on`, `created_on`) VALUES
(2, '2020-2021', 1, 0, NULL, '2023-07-21 15:52:18'),
(3, '2020-2021', 2, 0, NULL, '2023-07-21 15:52:26'),
(4, '2020-2021', 3, 0, NULL, '2023-07-21 15:52:33'),
(5, '2021-2022', 1, 0, NULL, '2023-07-21 15:52:50'),
(6, '2021-2022', 2, 0, NULL, '2023-07-21 15:52:56'),
(7, '2021-2022', 3, 0, NULL, '2023-07-21 15:53:02'),
(8, '2022-2023', 1, 0, NULL, '2023-07-21 15:53:20'),
(9, '2022-2023', 2, 0, NULL, '2023-07-21 15:53:26'),
(10, '2022-2023', 3, 0, NULL, '2023-07-21 15:53:31'),
(11, '2023-2024', 1, 1, NULL, '2023-07-21 15:53:44'),
(12, '2023-2024', 2, 0, NULL, '2023-07-21 15:53:52'),
(13, '2023-2024', 3, 0, NULL, '2023-07-21 15:53:57');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `position_name` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `position_name`, `description`) VALUES
(1, 'admin', 'Course Supervisor'),
(2, 'faculty', 'Course Coordinator'),
(3, 'faculty', 'Teacher/Instructor'),
(4, 'registrar', 'Registrar');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sp_id` int(20) NOT NULL,
  `title` text NOT NULL,
  `context` text NOT NULL,
  `status` int(11) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `user_id`, `sp_id`, `title`, `context`, `status`, `updated_on`, `created_on`) VALUES
(28, 68, 1, 'Test Announcement', '<p>test&nbsp;</p>', 1, NULL, '2023-05-09 13:37:55'),
(31, 78, 1, 'test', '<p>announcement</p>', 1, '2023-05-16 19:05:03', '2023-05-16 19:04:26'),
(32, 2, 0, 'Testing', '<p>Hello Everyone</p>', 1, NULL, '2023-07-21 15:55:51'),
(33, 99, 0, 'Lacking Requirements', '<p>Attention to all graduating students,</p><p>We kindly request you to visit the Registrar&#39;s Office to ensure that all necessary requirements, such as Form 137 and Good Moral Certificate, have been fulfilled. Your cooperation in this matter is greatly appreciated as it will facilitate a smooth and timely processing of your graduation. Please take prompt action and make the necessary arrangements at the earliest convenience.</p><p>Thank you for your attention to this important matter.</p><p>Best regards,<br />Gherardini<br /><strong>Registrar</strong></p>', 1, '2023-07-31 06:06:59', '2023-07-24 16:18:43'),
(37, 100, 0, 'Now Showing', '<p>The Flash 2023</p>', 1, NULL, '2023-07-31 06:09:53');

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `id` int(20) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `institute_id` int(20) NOT NULL,
  `updated_on` datetime NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`id`, `name`, `description`, `institute_id`, `updated_on`, `created_on`) VALUES
(2, 'BSAE', 'Bachelor of Science in Aeronautical Engineering', 1, '0000-00-00 00:00:00', '2023-07-23 22:07:36'),
(4, 'BSAT Advance Flying', 'Bachelor of Science in Air Transportation major in Advance Flying', 1, '2023-07-23 22:14:12', '2023-07-23 22:09:28'),
(5, 'BSAMT', 'Bachelor of Science in Aircraft Maintenance Technology', 1, '0000-00-00 00:00:00', '2023-07-23 22:11:14'),
(6, 'AAMT', 'Associate in Aircraft Maintenance Technology', 1, '0000-00-00 00:00:00', '2023-07-23 22:12:53'),
(7, 'BSAET', 'Bachelor of Science in Aviation Electronics Technology', 1, '0000-00-00 00:00:00', '2023-07-23 22:15:08'),
(8, 'AAET', 'Associate in Aviation Electronics Technology', 1, '0000-00-00 00:00:00', '2023-07-23 22:15:37'),
(9, 'BSAC Flight Operations', 'Associate in Aviation Electronics Technology', 3, '0000-00-00 00:00:00', '2023-07-23 22:16:14'),
(10, 'BSASSM', 'Bachelor of Science in Aviation Satety and Security Management', 3, '0000-00-00 00:00:00', '2023-07-23 22:16:49'),
(11, 'BSAL', 'Bachelor of Science in Aviation Logistics', 3, '0000-00-00 00:00:00', '2023-07-23 22:17:03'),
(12, 'BSAT Travel Management', 'Bachelor of Science in Aviation Tourism major in Travel Management', 3, '0000-00-00 00:00:00', '2023-07-23 22:17:29'),
(13, 'BSAIS', 'Bachelor of Science in Aviation Information System', 2, '0000-00-00 00:00:00', '2023-07-23 22:18:50'),
(14, 'BSAIT', 'Bachelor of Science in Aviation Information Technology', 2, '0000-00-00 00:00:00', '2023-07-23 22:19:15');

-- --------------------------------------------------------

--
-- Table structure for table `prospectus`
--

CREATE TABLE `prospectus` (
  `id` int(11) NOT NULL,
  `institute_id` int(20) NOT NULL,
  `program_id` int(20) NOT NULL,
  `level` int(20) NOT NULL,
  `term` int(11) NOT NULL,
  `subject_code` int(11) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `days` text NOT NULL,
  `time` text NOT NULL,
  `room` text NOT NULL,
  `faculty_id` int(22) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `class_id`, `course_id`, `days`, `time`, `room`, `faculty_id`, `updated_on`, `created_on`) VALUES
(40, 5, 8, 'MWF', '1-2', '503', 82, NULL, '2023-10-25 17:26:04'),
(41, 5, 9, 'MWF', '1-2', '503', 82, NULL, '2023-10-25 17:26:10'),
(42, 5, 4, 'MWF', '1-2', '503', 82, NULL, '2023-10-25 17:26:17'),
(43, 5, 3, 'MWF', '1-2', '503', 82, NULL, '2023-10-25 17:26:24'),
(44, 5, 2, 'MWF', '1-2', '503', 82, NULL, '2023-10-25 17:26:30'),
(45, 5, 5, 'MWF', '1-2', '503', 82, NULL, '2023-10-25 17:26:37'),
(46, 5, 6, 'MWF', '1-2', '503', 82, NULL, '2023-10-25 17:26:44'),
(47, 5, 7, 'MWF', '1-2', '503', 82, NULL, '2023-10-25 17:26:50'),
(48, 5, 11, 'MWF', '1-2', '503', 82, NULL, '2023-10-25 17:26:58'),
(49, 5, 10, 'MWF', '1-2', '503', 82, NULL, '2023-10-25 17:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` text NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `position_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `user_id`, `username`, `institute_id`, `position_id`, `created_on`) VALUES
(80, NULL, 'registrar@gmail.com', 0, 4, '2023-07-21 15:39:42'),
(81, NULL, 'faculty1@gmail.com', 2, 2, '2023-07-21 15:49:49'),
(82, NULL, 'faculty2@gmail.com', 2, 3, '2023-07-21 15:51:47'),
(83, NULL, 'faculty3@gmail.com', 2, 3, '2023-07-29 12:47:00');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(20) NOT NULL,
  `username` text NOT NULL,
  `program_id` int(20) NOT NULL,
  `level` int(20) NOT NULL,
  `idno` int(20) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` text NOT NULL,
  `contact_no` text DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `birthplace` text DEFAULT NULL,
  `gender` text DEFAULT NULL,
  `civil_status` text DEFAULT NULL,
  `citizenship` text DEFAULT NULL,
  `permanent_address` text DEFAULT NULL,
  `zipcode` int(4) DEFAULT NULL,
  `school_name` text DEFAULT NULL,
  `school_address` text DEFAULT NULL,
  `school_type` text DEFAULT NULL,
  `educational_attainement` text DEFAULT NULL,
  `disability` text DEFAULT NULL,
  `father_vital_status` text DEFAULT NULL,
  `father_name` text DEFAULT NULL,
  `father_occupation` text DEFAULT NULL,
  `father_address` text DEFAULT NULL,
  `father_educationalAtt` text DEFAULT NULL,
  `mother_vital_status` text DEFAULT NULL,
  `mother_name` text DEFAULT NULL,
  `mother_occupation` text DEFAULT NULL,
  `mother_address` text DEFAULT NULL,
  `mother_educationalAtt` text DEFAULT NULL,
  `gross_income` text DEFAULT NULL,
  `siblings` int(11) DEFAULT NULL,
  `guardian_name` text DEFAULT NULL,
  `guardian_email` text DEFAULT NULL,
  `picture` text DEFAULT NULL,
  `signature` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `username`, `program_id`, `level`, `idno`, `firstname`, `middlename`, `lastname`, `contact_no`, `birthdate`, `birthplace`, `gender`, `civil_status`, `citizenship`, `permanent_address`, `zipcode`, `school_name`, `school_address`, `school_type`, `educational_attainement`, `disability`, `father_vital_status`, `father_name`, `father_occupation`, `father_address`, `father_educationalAtt`, `mother_vital_status`, `mother_name`, `mother_occupation`, `mother_address`, `mother_educationalAtt`, `gross_income`, `siblings`, `guardian_name`, `guardian_email`, `picture`, `signature`, `status`, `updated_on`, `created_on`) VALUES
(24, 'ryanmarkmj@gmail.com', 13, 1, 19935682, 'Jeric', 'Boric', 'Leyson', '9147483647', '2000-02-09', 'Cebu City', 'male', 'single', 'Filipino', 'cebu city', 6000, 'basak high national school', 'basak cebu city', 'public', 'college', 'NONE', 'deceased', 'na', 'na', 'na', 'none', 'deceased', 'na', 'na', 'na', 'none', 'poor', 3, 'teodoro', 'teodoro_leyson@mgail.com', '8bf3695bb29d333ac97680b2c459e66664bea876bf88c.jpg', 'f32b3c525f4b5969d8019f9da3d9759464c200a9e2bd7.png', 1, '2023-07-27 13:31:31', '2023-07-24 23:56:35'),
(28, 'johnwil04@gmail.com', 13, 1, 19913245, 'John Wilson', 'Dimagiba', 'Nadela', '9532288400', '2000-05-05', 'cebu city', 'other', 'married', 'Filipino', 'buhisan cebu city', 6000, 'uc pri', 'colon street', 'private', 'college', 'gwapo', 'living', 'Wilson Nadela Sr', 'Software Engineer', 'buhisan cebu city', 'college', 'living', 'Wilsan Nadela', 'housewife', 'buhisan cebu city', 'high school', 'rich', 7, 'berlin nadela', 'berlin_nadela@mgail.com', '4b4c96860af22e54dad9f2df85bcb11064c38261e1139.jpg', '4b4c96860af22e54dad9f2df85bcb11064c38261e1307.jpg', 1, NULL, '2023-07-28 16:54:57'),
(30, 'nathanieltiempo@gmail.com', 13, 1, 19822548, 'Nathaniel', '', 'Tiempo', '9532288400', '2000-05-02', 'cebu city', 'male', 'single', 'Filipino', 'lahug, cebu city', 6000, 'UC Pri', 'Sanciangko St, Cebu City', 'private', 'college', 'none', 'deceased', 'na', 'na', 'na', 'none', 'deceased', 'na', 'na', 'na', 'none', 'low income', 3, 'melinda tiempo', 'melinda_tiempo@mgail.com', '8bf3695bb29d333ac97680b2c459e66664c3b45f05401.jpg', '8bf3695bb29d333ac97680b2c459e66664c3b45f05570.jpg', 1, NULL, '2023-07-28 20:28:15');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` text NOT NULL,
  `gender` text DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone_no` text DEFAULT NULL,
  `profileImage` text DEFAULT NULL,
  `isPasswordChanged` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `type`, `username`, `password`, `firstname`, `middlename`, `lastname`, `gender`, `birthdate`, `address`, `phone_no`, `profileImage`, `isPasswordChanged`, `status`, `updated_on`, `created_on`) VALUES
(2, 'admin', 'admin@gmail.com', '$2y$10$fJf94KPvdTVvpnrpy1DwseJZKUa9d7x1Yq9r8owfHa7AAeICWp4YS', 'Mark', '', 'Dinglasa', 'male', '1906-08-10', 'Basak San Nicolas Cebu City', '2147483647', '8bf3695bb29d333ac97680b2c459e66664ba3417ae42d.jpg', 4, 1, '2023-05-07 08:29:46', '2023-03-11 18:03:30'),
(99, 'registrar', 'registrar@gmail.com', '$2y$10$v1pnBRV5S7Q0xVx/SjhFu.4NgBMJ2T3.bV0KfTDSlRqnG6Xg/ntem', 'Lisa', '', 'Gherardini', 'female', '1991-06-18', 'france, florence', '9532288400', '605735c7a3d7fad8b0dc51cbbcf5449d64be38a201eb1.jpg', 1, 1, '2023-07-24 14:32:34', '2023-07-21 15:39:42'),
(100, 'faculty', 'faculty1@gmail.com', '$2y$10$00LXJR373yNWxV9fJH9O9OWy0GtqoJEGRNQfUcOgjbzImSO14Rjem', 'Ben', '', 'Aflek', 'male', '1992-08-05', 'Berkeley, California', '9532288400', '143fa05221d77b085b2fad9ccd43865564c33effd4a49.jpg', 1, 1, '2023-07-28 12:07:41', '2023-07-21 15:49:49'),
(101, 'faculty', 'faculty2@gmail.com', '$2y$10$TJXo0jGuvZIa9s9wfHMH6OPmqIGaH.9LhWSh1Rh2kmH7Ahb3CrsfW', 'Barry', NULL, 'Allen', NULL, NULL, NULL, NULL, '45e048828bd0e66312464b4d52b2bc8d64c49d0469637.jpg', 1, 1, '2023-07-29 13:01:30', '2023-07-21 15:51:47'),
(102, 'student', 'ryanmarkmj@gmail.com', '$2y$10$fJf94KPvdTVvpnrpy1DwseJZKUa9d7x1Yq9r8owfHa7AAeICWp4YS', 'Jeric', 'Boric', 'Leyson', 'male', '2000-02-09', 'cebu city', '9147483647', NULL, 0, 1, '2023-07-27 13:31:31', '2023-07-24 23:56:35'),
(106, 'student', 'johnwil04@gmail.com', '$2y$10$fJf94KPvdTVvpnrpy1DwseJZKUa9d7x1Yq9r8owfHa7AAeICWp4YS', 'John Wilson', 'Dimagiba', 'Nadela', 'other', '2000-05-05', 'buhisan cebu city', '9532288400', NULL, 0, 1, NULL, '2023-07-28 16:54:57'),
(108, 'student', 'nathanieltiempo@gmail.com', '$2y$10$fJf94KPvdTVvpnrpy1DwseJZKUa9d7x1Yq9r8owfHa7AAeICWp4YS', 'Nathaniel', '', 'Tiempo', 'male', '2000-05-02', 'lahug, cebu city', '9532288400', NULL, 0, 1, NULL, '2023-07-28 20:28:15'),
(109, 'faculty', 'faculty3@gmail.com', '$2y$10$FvcgKd053r8HfMujXjxL1unQnW46v8jhYnwpDuMyFfM45gzttCth2', 'Wanda', '', 'Maximoffty', 'female', '1989-02-16', 'Sherman Oaks, California', '9532288400', '7fdc1a630c238af0815181f9faa190f564c49c605684d.jpg', 1, 1, '2023-07-29 12:52:28', '2023-07-29 12:47:00'),
(120, 'admin', 'admin2@gmail.com', '$2y$10$txJR/0v//y9UlPG.EKqNaOYq2LyYlUFV/0wP3TqTG14pYO.MvtSZa', 'New', NULL, 'Admin', NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2023-10-26 10:18:19');

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `delete_staff` AFTER DELETE ON `user` FOR EACH ROW BEGIN
  IF OLD.type = 'faculty' OR OLD.type = 'registrar' THEN
    DELETE FROM staff WHERE username = OLD.username;
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_student` AFTER DELETE ON `user` FOR EACH ROW BEGIN 
    IF OLD.type = 'student' THEN 
        DELETE FROM student WHERE username = OLD.username; 
    END IF; 
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `on_insert_staff` AFTER INSERT ON `user` FOR EACH ROW BEGIN
    IF NEW.type = 'staff' THEN
        INSERT INTO staff (user_id) VALUES (NEW.id);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_staff_username` AFTER UPDATE ON `user` FOR EACH ROW BEGIN
    IF NEW.username != OLD.username AND OLD.type = 'scholarship-provider' THEN
        UPDATE staff SET username = NEW.username WHERE username = OLD.username;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_student_username` AFTER UPDATE ON `user` FOR EACH ROW BEGIN
    IF NEW.type = 'student' AND NEW.username != OLD.username THEN
        UPDATE student SET username = NEW.username WHERE username = OLD.username;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id` int(30) NOT NULL,
  `username` text NOT NULL,
  `type` text NOT NULL,
  `sign_in` datetime NOT NULL,
  `sign_out` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`id`, `username`, `type`, `sign_in`, `sign_out`) VALUES
(103, 'admin@gmail.com', 'admin', '2023-05-13 15:33:10', '2023-05-13 15:33:31'),
(104, 'ryanmark.dinglasa@gmail.com', 'scholarship-provider', '2023-05-13 15:33:42', '2023-05-13 15:33:52'),
(105, 'admin@gmail.com', 'admin', '2023-05-13 15:34:27', '2023-05-13 16:58:38'),
(106, 'kerryann@gmail.com', 'student', '2023-05-13 16:58:46', '2023-05-13 16:58:54'),
(107, 'dennisdurano@gmail.com', 'scholarship-provider', '2023-05-13 16:59:55', '0000-00-00 00:00:00'),
(108, 'admin@gmail.com', 'admin', '2023-05-13 17:01:20', '2023-05-14 21:44:39'),
(109, 'kerryann@gmail.com', 'student', '2023-05-13 19:04:49', '0000-00-00 00:00:00'),
(110, 'ryanmark.dinglasa@gmail.com', 'scholarship-provider', '2023-05-14 22:57:15', '0000-00-00 00:00:00'),
(111, 'ryanmark.dinglasa@gmail.com', 'scholarship-provider', '2023-05-14 22:57:15', '2023-05-14 22:57:26'),
(112, 'dennisdurano@gmail.com', 'scholarship-provider', '2023-05-14 22:57:43', '0000-00-00 00:00:00'),
(113, 'roliemaegetubig@gmail.com', 'scholarship-provider', '2023-05-15 13:05:51', '2023-05-15 13:06:21'),
(114, 'jaylordcampo@gmail.com', 'scholarship-provider', '2023-05-15 13:06:29', '2023-05-15 13:07:01'),
(115, 'jebieharville@gmail.com', 'scholarship-provider', '2023-05-15 13:07:51', '2023-05-15 13:08:09'),
(116, 'dennisdurano@gmail.com', 'scholarship-provider', '2023-05-15 13:09:52', '2023-05-15 13:12:43'),
(117, 'admin@gmail.com', 'admin', '2023-05-15 13:12:51', '0000-00-00 00:00:00'),
(118, 'kerryann.mdaroy@gmail.com', 'scholarship-provider', '2023-05-15 13:14:29', '2023-05-15 13:21:23'),
(119, 'heroshi@example.com', 'student', '2023-05-15 13:30:27', '2023-05-15 13:41:53'),
(120, 'hilarysh@example.com', 'student', '2023-05-15 13:46:36', '2023-05-15 13:49:25'),
(121, 'dhanielagrace@example.com', 'student', '2023-05-15 13:52:39', '2023-05-15 13:52:55'),
(122, 'jericleyson@gmail.com', 'student', '2023-05-15 13:58:35', '2023-05-15 13:59:09'),
(123, 'nathanieltiempo@example.com', 'student', '2023-05-15 14:04:07', '2023-05-15 14:09:37'),
(124, 'admin@gmail.com', 'admin', '2023-05-15 14:08:27', '0000-00-00 00:00:00'),
(125, 'jethrodereal@example.com', 'student', '2023-05-15 14:13:06', '2023-05-15 14:13:38'),
(126, 'jendarlindale@example.com', 'student', '2023-05-15 14:17:11', '2023-05-15 14:17:57'),
(127, 'margaritamelencion@example.com', 'student', '2023-05-15 14:21:11', '2023-05-15 14:21:52'),
(128, 'cherryfae@example.com', 'student', '2023-05-15 14:24:28', '2023-05-15 14:25:32'),
(129, 'cherryfae@example.com', 'student', '2023-05-15 14:27:43', '2023-05-15 14:31:49'),
(130, 'margaritamelencion@example.com', 'student', '2023-05-15 14:40:02', '2023-05-15 14:41:21'),
(131, 'jendarlindale@example.com', 'student', '2023-05-15 14:41:38', '2023-05-15 14:44:54'),
(132, 'hilarysh@example.com', 'student', '2023-05-15 14:45:18', '2023-05-15 15:58:34'),
(133, 'ryanmark.dinglasa@gmail.com', 'scholarship-provider', '2023-05-15 15:58:41', '0000-00-00 00:00:00'),
(134, 'dennisdurano@gmail.com', 'scholarship-provider', '2023-05-16 04:39:58', '0000-00-00 00:00:00'),
(135, 'dennisdurano@gmail.com', 'scholarship-provider', '2023-05-16 17:43:57', '2023-05-17 00:19:01'),
(136, 'sanaminatozake@jyp.com', 'student', '2023-05-17 00:23:41', '2023-05-17 00:24:37'),
(137, 'sonchaeyoung@jyp.com', 'student', '2023-05-17 00:28:10', '2023-05-17 00:28:59'),
(138, 'minamyoi@jyp.com', 'student', '2023-05-17 00:35:14', '2023-05-17 00:36:27'),
(139, 'dennisdurano@gmail.com', 'scholarship-provider', '2023-05-17 00:39:09', '2023-05-17 01:03:34'),
(140, 'minamyoi@jyp.com', 'student', '2023-05-17 01:03:38', '2023-05-17 04:43:48'),
(141, 'dennisdurano@gmail.com', 'scholarship-provider', '2023-05-17 01:05:11', '0000-00-00 00:00:00'),
(142, 'admin@gmail.com', 'admin', '2023-05-17 04:43:54', '2023-07-21 15:57:00'),
(143, 'minamyoi@jyp.com', 'student', '2023-05-17 04:48:26', '0000-00-00 00:00:00'),
(144, 'registrar@gmail.com', '', '2023-07-21 15:57:26', '2023-07-21 16:58:37'),
(145, 'admin@gmail.com', '', '2023-07-21 16:58:45', '0000-00-00 00:00:00'),
(146, 'admin@gmail.com', '', '2023-07-23 20:21:47', '2023-07-24 10:44:35'),
(147, 'registrar@gmail.com', '', '2023-07-24 10:45:20', '2023-07-24 14:10:45'),
(148, 'admin@gmail.com', '', '2023-07-24 14:10:53', '2023-07-24 14:32:03'),
(149, 'registrar@gmail.com', '', '2023-07-24 14:32:20', '2023-07-24 14:32:34'),
(150, 'registrar@gmail.com', '', '2023-07-24 14:32:46', '2023-07-24 16:39:05'),
(151, 'admin@gmail.com', '', '2023-07-24 16:39:11', '2023-07-24 23:33:07'),
(152, 'registrar@gmail.com', '', '2023-07-24 23:33:17', '2023-07-25 00:42:58'),
(153, 'admin@gmail.com', '', '2023-07-25 00:43:29', '2023-07-25 00:45:04'),
(154, 'registrar@gmail.com', '', '2023-07-25 00:45:14', '0000-00-00 00:00:00'),
(155, 'admin@gmail.com', '', '2023-07-26 16:06:52', '0000-00-00 00:00:00'),
(156, 'registrar@gmail.com', '', '2023-07-27 00:31:20', '2023-07-28 11:03:29'),
(157, 'faculty1@gmail.com', '', '2023-07-28 11:06:14', '2023-07-28 12:07:41'),
(158, 'faculty1@gmail.com', '', '2023-07-28 12:07:51', '2023-07-28 16:50:17'),
(159, 'registrar@gmail.com', '', '2023-07-28 16:50:26', '2023-07-28 16:55:14'),
(160, 'faculty1@gmail.com', '', '2023-07-28 16:55:25', '0000-00-00 00:00:00'),
(161, 'faculty1@gmail.com', '', '2023-07-28 17:15:25', '2023-07-28 20:19:56'),
(162, 'registrar@gmail.com', '', '2023-07-28 20:20:21', '2023-07-28 20:28:30'),
(163, 'faculty1@gmail.com', '', '2023-07-28 20:28:45', '0000-00-00 00:00:00'),
(164, 'faculty1@gmail.com', '', '2023-07-28 21:10:00', '0000-00-00 00:00:00'),
(165, 'faculty1@gmail.com', '', '2023-07-28 22:32:00', '2023-07-29 11:23:55'),
(166, 'admin@gmail.com', '', '2023-07-29 11:24:02', '2023-07-29 12:47:22'),
(167, 'admin@gmail.com', '', '2023-07-29 12:47:59', '2023-07-29 12:48:02'),
(168, 'faculty3@gmail.com', '', '2023-07-29 12:49:44', '2023-07-29 12:52:28'),
(169, 'admin@gmail.com', '', '2023-07-29 12:56:12', '2023-07-29 12:56:27'),
(170, 'faculty3@gmail.com', '', '2023-07-29 12:56:53', '2023-07-29 12:59:50'),
(171, 'faculty2@gmail.com', '', '2023-07-29 13:00:01', '2023-07-29 13:00:55'),
(172, 'faculty1@gmail.com', '', '2023-07-29 13:01:08', '2023-07-29 13:01:10'),
(173, 'faculty2@gmail.com', '', '2023-07-29 13:01:17', '2023-07-29 13:01:31'),
(174, 'faculty2@gmail.com', '', '2023-07-29 13:01:40', '2023-07-29 13:01:42'),
(175, 'faculty1@gmail.com', '', '2023-07-29 13:01:50', '2023-07-29 13:46:00'),
(176, 'admin@gmail.com', '', '2023-07-29 13:46:09', '2023-07-29 13:55:10'),
(177, 'faculty1@gmail.com', '', '2023-07-29 13:58:43', '2023-07-29 14:02:28'),
(178, 'admin@gmail.com', '', '2023-07-29 13:59:20', '0000-00-00 00:00:00'),
(179, 'registrar@gmail.com', '', '2023-07-29 14:02:49', '2023-07-29 14:21:20'),
(180, 'faculty1@gmail.com', '', '2023-07-29 14:21:32', '2023-07-29 15:30:20'),
(181, 'faculty2@gmail.com', '', '2023-07-29 15:30:31', '2023-07-29 16:12:24'),
(182, 'faculty1@gmail.com', '', '2023-07-29 16:12:34', '2023-07-29 16:12:43'),
(183, 'faculty2@gmail.com', '', '2023-07-29 16:12:51', '2023-07-30 11:49:49'),
(184, 'faculty1@gmail.com', '', '2023-07-30 11:49:57', '2023-07-30 12:25:22'),
(185, 'faculty2@gmail.com', '', '2023-07-30 12:25:36', '0000-00-00 00:00:00'),
(186, 'faculty2@gmail.com', '', '2023-07-30 12:26:34', '0000-00-00 00:00:00'),
(187, 'faculty2@gmail.com', '', '2023-07-30 12:32:46', '2023-07-30 12:56:03'),
(188, 'faculty1@gmail.com', '', '2023-07-30 12:56:10', '2023-07-30 14:49:02'),
(189, 'faculty3@gmail.com', '', '2023-07-30 14:49:11', '2023-07-30 14:52:18'),
(190, 'faculty2@gmail.com', '', '2023-07-30 14:52:30', '2023-07-30 15:03:44'),
(191, 'admin@gmail.com', '', '2023-07-30 14:53:35', '0000-00-00 00:00:00'),
(192, 'faculty1@gmail.com', '', '2023-07-30 15:03:59', '2023-07-30 15:41:24'),
(193, 'faculty2@gmail.com', '', '2023-07-30 15:41:35', '2023-07-30 16:05:59'),
(194, 'faculty1@gmail.com', '', '2023-07-30 16:16:54', '2023-07-30 16:21:28'),
(195, 'faculty2@gmail.com', '', '2023-07-30 16:21:36', '2023-07-30 18:42:27'),
(196, 'faculty1@gmail.com', '', '2023-07-30 18:42:44', '2023-07-30 21:19:29'),
(197, 'faculty2@gmail.com', '', '2023-07-30 19:52:09', '2023-07-31 00:35:21'),
(198, 'registrar@gmail.com', '', '2023-07-30 21:19:38', '2023-07-31 00:35:38'),
(199, 'faculty1@gmail.com', '', '2023-07-31 00:35:49', '2023-07-31 01:11:32'),
(200, 'faculty2@gmail.com', '', '2023-07-31 00:41:05', '2023-07-31 00:44:28'),
(201, 'registrar@gmail.com', '', '2023-07-31 00:44:43', '0000-00-00 00:00:00'),
(202, 'faculty2@gmail.com', '', '2023-07-31 01:11:47', '2023-07-31 01:13:11'),
(203, 'registrar@gmail.com', '', '2023-07-31 01:13:27', '2023-07-31 02:59:34'),
(204, 'faculty1@gmail.com', '', '2023-07-31 02:57:04', '2023-07-31 03:00:41'),
(205, 'faculty2@gmail.com', '', '2023-07-31 02:59:43', '0000-00-00 00:00:00'),
(206, 'registrar@gmail.com', '', '2023-07-31 03:00:50', '2023-07-31 03:27:00'),
(207, 'faculty2@gmail.com', '', '2023-07-31 03:27:13', '2023-07-31 04:17:07'),
(208, 'registrar@gmail.com', '', '2023-07-31 03:33:43', '0000-00-00 00:00:00'),
(209, 'registrar@gmail.com', '', '2023-07-31 04:17:22', '2023-07-31 04:55:51'),
(210, 'johnwil04@gmail.com', '', '2023-07-31 04:41:30', '0000-00-00 00:00:00'),
(211, 'johnwil04@gmail.com', '', '2023-07-31 04:56:09', '2023-07-31 06:03:11'),
(212, 'faculty1@gmail.com', '', '2023-07-31 05:17:43', '0000-00-00 00:00:00'),
(213, 'registrar@gmail.com', '', '2023-07-31 06:03:20', '2023-07-31 06:08:03'),
(214, 'faculty2@gmail.com', '', '2023-07-31 06:08:20', '2023-07-31 06:08:24'),
(215, 'faculty1@gmail.com', '', '2023-07-31 06:08:33', '2023-10-25 23:48:34'),
(216, 'faculty2@gmail.com', '', '2023-10-25 23:48:40', '2023-10-26 12:52:38'),
(217, 'faculty2@gmail.com', '', '2023-10-26 12:53:04', '2023-10-26 12:53:26'),
(218, 'faculty1@gmail.com', '', '2023-10-26 12:53:38', '2023-10-26 13:19:53'),
(219, 'registrar@gmail.com', '', '2023-10-26 13:20:16', '2023-10-26 15:39:00'),
(220, 'faculty1@gmail.com', '', '2023-10-26 15:39:15', '2023-10-26 15:47:08'),
(221, 'admin@gmail.com', '', '2023-10-26 15:47:15', '2023-10-26 16:10:36'),
(222, 'admin@gmail.com', '', '2023-10-26 16:10:43', '2023-10-26 16:12:08'),
(223, 'faculty1@gmail.com', '', '2023-10-26 16:12:18', '2023-10-26 16:13:29'),
(224, 'faculty2@gmail.com', '', '2023-10-26 16:13:37', '0000-00-00 00:00:00'),
(225, 'admin@gmail.com', '', '2023-10-26 16:18:02', '2023-10-26 16:26:34'),
(226, 'admin@gmail.com', '', '2023-10-26 16:26:45', '2023-10-26 16:27:14'),
(227, 'faculty2@gmail.com', '', '2023-10-26 16:27:23', '2023-10-26 16:28:28'),
(228, 'faculty1@gmail.com', '', '2023-10-26 16:28:37', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `institute`
--
ALTER TABLE `institute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `isgraded`
--
ALTER TABLE `isgraded`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `period`
--
ALTER TABLE `period`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prospectus`
--
ALTER TABLE `prospectus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`username`(768));

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `institute`
--
ALTER TABLE `institute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `isgraded`
--
ALTER TABLE `isgraded`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `period`
--
ALTER TABLE `period`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `prospectus`
--
ALTER TABLE `prospectus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
