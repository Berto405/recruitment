-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2024 at 11:19 AM
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
-- Database: `recruitment`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicant_logs`
--

CREATE TABLE `applicant_logs` (
  `id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `log` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicant_logs`
--

INSERT INTO `applicant_logs` (`id`, `applicant_id`, `log`, `created_at`) VALUES
(79, 37, 'Berto Berto assigned MRF: Waiter', '2024-04-12 03:28:15'),
(80, 37, 'Berto Berto changed status to  Failed', '2024-04-12 03:28:37'),
(81, 36, 'Berto Berto assigned MRF: Waiter', '2024-04-12 03:30:44'),
(82, 36, 'Berto Berto changed status to  Failed', '2024-04-12 03:32:23'),
(83, 37, 'Berto Berto changed status to  Failed', '2024-04-12 03:32:23'),
(84, 36, 'Berto Berto changed status to  Failed', '2024-04-12 03:34:20'),
(85, 37, 'Berto Berto changed status to  Failed', '2024-04-12 03:34:20'),
(86, 37, 'Berto Berto changed status to Passed', '2024-04-12 03:36:08'),
(87, 36, 'Berto Berto changed status to Passed', '2024-04-12 03:36:56'),
(88, 36, 'Berto Berto changed status to  Failed', '2024-04-12 03:40:18'),
(89, 37, 'Berto Berto changed status to Passed', '2024-04-12 05:17:38'),
(90, 36, 'Berto Berto changed status to Pooling', '2024-04-12 05:17:44'),
(91, 36, 'Berto Berto assigned MRF: Waiter', '2024-04-12 05:17:52'),
(92, 36, 'Berto Berto changed status to  Passed', '2024-04-12 05:17:55'),
(93, 37, 'Berto Berto changed status to Failed', '2024-04-12 05:19:22'),
(94, 37, 'Berto Berto changed status to Failed', '2024-04-12 05:20:00'),
(95, 36, 'Berto Berto changed status to  Failed', '2024-04-12 05:20:48'),
(96, 37, 'Berto Berto changed status to  Failed', '2024-04-12 05:20:48'),
(97, 37, 'Berto Berto changed status to Back to Pooling', '2024-04-12 05:24:25'),
(98, 37, 'Berto Berto changed status to Back to Pooling', '2024-04-12 05:25:06'),
(99, 36, 'Berto Berto changed status to  Waiting for Feedback', '2024-04-12 05:25:43'),
(100, 37, 'Berto Berto changed status to  Waiting for Feedback', '2024-04-12 05:25:43'),
(101, 36, 'Berto Berto changed status to  Failed', '2024-04-12 05:25:52'),
(102, 37, 'Berto Berto changed status to  Failed', '2024-04-12 05:25:52'),
(103, 36, 'Berto Berto changed status to  Back to Pooling', '2024-04-12 05:26:24'),
(104, 37, 'Berto Berto changed status to  Back to Pooling', '2024-04-12 05:26:24'),
(105, 36, 'Berto Berto changed status to  Back to Pooling', '2024-04-12 05:27:16'),
(106, 37, 'Berto Berto changed status to  Back to Pooling', '2024-04-12 05:27:16'),
(107, 36, 'Berto Berto changed status to  Passed', '2024-04-12 05:27:24'),
(108, 37, 'Berto Berto changed status to  Passed', '2024-04-12 05:27:24'),
(109, 36, 'Berto Berto scheduled an interview on 01:32PM Apr 16, 2024', '2024-04-12 05:32:44'),
(110, 37, 'Berto Berto scheduled an interview on 01:32PM Apr 28, 2024', '2024-04-12 05:32:56'),
(111, 36, 'Berto Berto scheduled an interview on 01:34PM Apr 19, 2024', '2024-04-12 05:34:55'),
(112, 37, 'Berto Berto scheduled an interview on 05:35PM Apr 19, 2024', '2024-04-12 05:35:12'),
(113, 36, 'Berto Berto scheduled an interview on 01:40PM Apr 16, 2024', '2024-04-12 05:40:06'),
(114, 37, 'Berto Berto changed status to Back to Pooling', '2024-04-12 05:40:29'),
(115, 36, 'Berto Berto changed status to Back to Pooling', '2024-04-12 05:44:05'),
(116, 36, 'Berto Berto changed status to Passed', '2024-04-12 05:44:37'),
(117, 39, 'Berto Berto changed status to Passed', '2024-04-12 05:46:19'),
(118, 39, 'Berto Berto changed status to Passed', '2024-04-12 05:49:38'),
(119, 39, 'Berto Berto changed status to Back to Pooling', '2024-04-12 05:49:51'),
(120, 39, 'Berto Berto changed status to Pooling', '2024-04-12 06:02:25'),
(121, 39, 'Berto Berto assigned MRF: Waiter', '2024-04-12 06:02:32'),
(122, 39, 'Berto Berto changed status to Passed', '2024-04-12 06:02:37'),
(123, 39, 'Berto Berto changed status to Passed', '2024-04-12 06:03:40'),
(124, 39, 'Berto Berto scheduled an interview on 02:05PM Apr 18, 2024', '2024-04-12 06:05:54'),
(125, 39, 'Berto Berto scheduled an interview on 02:06PM Apr 25, 2024', '2024-04-12 06:06:03'),
(126, 39, 'Berto Berto changed status to  Waiting for Feedback', '2024-04-12 06:07:21'),
(127, 39, 'Berto Berto changed status to Waiting for Feedback', '2024-04-12 06:12:51'),
(128, 39, 'Berto Berto changed status to Hired', '2024-04-12 06:12:54'),
(129, 39, 'Berto Berto changed status to  Ongoing Requirements', '2024-04-12 06:13:21'),
(130, 39, 'Berto Berto changed status to Onboarding', '2024-04-12 06:13:29'),
(131, 39, 'Berto Berto changed status to Ongoing Requirements', '2024-04-12 06:13:31'),
(132, 39, 'Berto Berto changed status to Waiting for Start Date', '2024-04-12 06:13:34'),
(133, 39, 'Berto Berto changed status to Placed', '2024-04-12 06:13:36'),
(134, 39, 'Berto Berto changed status to Placed with Ongoing Req.', '2024-04-12 06:13:51'),
(135, 39, 'Berto Berto changed status to Placed with Onboarding', '2024-04-12 06:13:53'),
(136, 39, 'Berto Berto changed status to Backout', '2024-04-12 06:13:57'),
(137, 36, 'Berto Berto changed status to  Passed', '2024-04-15 02:46:41'),
(138, 39, 'Berto Berto changed status to  Passed', '2024-04-15 02:46:41'),
(139, 36, 'Berto Berto changed status to  Passed', '2024-04-15 03:15:37'),
(140, 39, 'Berto Berto changed status to Back to Pooling', '2024-04-15 03:15:49'),
(141, 39, 'Berto Berto changed status to Passed', '2024-04-15 03:15:54'),
(142, 36, 'Berto Berto changed status to Back to Pooling', '2024-04-15 03:18:02'),
(143, 36, 'Berto Berto changed status to Passed', '2024-04-15 03:18:10'),
(144, 39, 'Berto Berto changed status to Back to Pooling', '2024-04-15 03:18:21'),
(145, 36, 'Berto Berto changed status to Back to Pooling', '2024-04-15 03:18:25'),
(146, 36, 'Berto Berto changed status to  Passed', '2024-04-15 03:18:43'),
(147, 39, 'Berto Berto changed status to  Passed', '2024-04-15 03:18:43'),
(148, 36, 'Berto Berto changed status to Passed', '2024-04-15 03:27:44'),
(149, 39, 'Berto Berto changed status to Failed', '2024-04-15 03:32:16'),
(150, 39, 'Berto Berto changed status to  Pooling', '2024-04-15 03:34:07'),
(151, 39, 'Berto Berto changed status to  Passed', '2024-04-15 03:35:25'),
(152, 39, 'Berto Berto changed status to  Passed', '2024-04-15 03:39:47'),
(153, 39, 'Berto Berto changed status to Back to Pooling', '2024-04-15 03:39:56'),
(154, 39, 'Berto Berto changed status to Passed', '2024-04-15 03:40:39'),
(155, 36, 'Berto Berto changed status to Back to Pooling', '2024-04-15 03:40:45'),
(156, 36, 'Berto Berto changed status to Pooling', '2024-04-15 03:44:51'),
(157, 36, 'Berto Berto changed status to Pooling', '2024-04-15 03:49:44'),
(158, 36, 'Berto Berto changed status to Pooling', '2024-04-15 03:50:44'),
(159, 36, 'Berto Berto changed status to Passed', '2024-04-15 03:50:47'),
(160, 36, 'Berto Berto changed status to Pooling', '2024-04-15 03:51:50'),
(161, 36, 'Berto Berto changed status to Failed', '2024-04-15 03:51:54'),
(162, 36, 'Berto Berto changed status to Passed', '2024-04-15 03:53:29'),
(163, 36, 'Berto Berto changed status to Passed', '2024-04-15 06:34:27'),
(164, 36, 'Berto Berto changed status to Pooling', '2024-04-15 06:35:27'),
(165, 36, 'Berto Berto changed status to Passed', '2024-04-15 06:35:30'),
(166, 36, 'Berto Berto assigned MRF: Waiter', '2024-04-15 06:37:10'),
(167, 36, 'Berto Berto changed status to Passed', '2024-04-15 06:37:15'),
(168, 39, 'Berto Berto changed status to Back to Pooling', '2024-04-15 06:37:28'),
(169, 39, 'Berto Berto changed status to Passed', '2024-04-15 06:37:39'),
(170, 39, 'Berto Berto scheduled an interview on 02:37PM Apr 17, 2024', '2024-04-15 06:37:51'),
(171, 39, 'Berto Berto scheduled an interview on 02:37PM Apr 18, 2024', '2024-04-15 06:38:00'),
(172, 39, 'Berto Berto changed status to Waiting for Feedback', '2024-04-15 06:38:03'),
(173, 39, 'Berto Berto changed status to Hired', '2024-04-15 06:38:10'),
(174, 39, 'Berto Berto changed status to Ongoing Requirements', '2024-04-15 06:38:17'),
(175, 39, 'Berto Berto changed status to Onboarding', '2024-04-15 06:38:19'),
(176, 39, 'Berto Berto changed status to Waiting for Start Date', '2024-04-15 06:38:21'),
(177, 39, 'Berto Berto changed status to Placed with Ongoing Req.', '2024-04-15 06:38:29'),
(178, 39, 'Berto Berto changed status to Placed with Onboarding', '2024-04-15 06:38:34'),
(179, 39, 'Berto Berto changed status to Backout', '2024-04-15 06:38:43'),
(180, 39, 'Berto Berto changed status to  Passed', '2024-04-15 06:38:49'),
(181, 39, 'Berto Berto changed status to Waiting for Feedback', '2024-04-15 06:39:48'),
(182, 39, 'Berto Berto changed status to Hired', '2024-04-15 06:39:51'),
(183, 36, 'Berto Berto changed status to Back to Pooling', '2024-04-15 06:42:30'),
(184, 36, 'Berto Berto changed status to  Passed', '2024-04-15 07:02:00'),
(185, 39, 'Berto Berto changed status to  Passed', '2024-04-15 07:02:04'),
(186, 39, 'Berto Berto changed status to Back to Pooling', '2024-04-15 07:02:30'),
(187, 39, 'test admin changed status to Passed', '2024-04-15 07:03:03'),
(188, 36, 'Berto Berto changed status to Hired', '2024-04-15 07:07:02'),
(189, 36, 'Berto Berto changed status to Placed', '2024-04-15 07:14:19'),
(190, 36, 'Berto Berto changed status to  Failed', '2024-04-15 07:19:08'),
(191, 39, 'test admin changed status to Hired', '2024-04-15 07:22:44'),
(192, 39, 'test admin changed status to Backout', '2024-04-15 07:22:48'),
(193, 36, 'Berto Berto changed status to  Failed', '2024-04-15 07:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `character_references`
--

CREATE TABLE `character_references` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name_one` varchar(255) NOT NULL,
  `name_one_position` varchar(255) NOT NULL,
  `name_one_company` varchar(255) NOT NULL,
  `name_one_contact_number` int(12) NOT NULL,
  `name_two` varchar(255) NOT NULL,
  `name_two_position` varchar(255) NOT NULL,
  `name_two_company` varchar(255) NOT NULL,
  `name_two_contact_number` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `character_references`
--

INSERT INTO `character_references` (`id`, `user_id`, `name_one`, `name_one_position`, `name_one_company`, `name_one_contact_number`, `name_two`, `name_two_position`, `name_two_company`, `name_two_contact_number`) VALUES
(1, 2, 's', '', '', 0, '', '', '', 0),
(2, 2, '', '', '', 0, '', '', '', 0),
(3, 2, 's', '', '', 0, '', '', '', 0),
(4, 2, 's', '', '', 0, '', '', '', 0),
(5, 2, 's', '', '', 0, '', '', '', 0),
(6, 2, 's', '', '', 0, '', '', '', 0),
(7, 2, 's', '', '', 0, '', '', '', 0),
(8, 2, 's', '', '', 0, '', '', '', 0),
(9, 2, '', '', '', 0, '', '', '', 0),
(10, 2, 's', '', '', 0, '', '', '', 0),
(11, 2, 's', '', '', 0, '', '', '', 0),
(12, 2, 's', '', '', 0, '', '', '', 0),
(13, 2, 's', '', '', 0, '', '', '', 0),
(14, 2, 's', '', '', 0, '', '', '', 0),
(15, 2, 's', '', '', 0, '', '', '', 0),
(16, 2, 's', '', '', 0, '', '', '', 0),
(17, 2, 's', '', '', 0, '', '', '', 0),
(18, 2, 's', '', '', 0, '', '', '', 0),
(19, 2, 's', '', '', 0, '', '', '', 0),
(20, 2, '', '', '', 0, '', '', '', 0),
(21, 2, '', '', '', 0, '', '', '', 0),
(22, 9, 'das', 'asd', 'asd', 42, 'asd', 'ae', 'ewq', 0),
(23, 9, 'das', 'asd', 'asd', 42, 'asd', 'ae', 'ewq', 0),
(24, 9, 'das', 'asd', 'asd', 42, 'asd', 'ae', 'ewq', 0),
(25, 9, 'das', 'asd', 'asd', 42, 'asd', 'ae', 'ewq', 0),
(26, 9, 'das', 'asd', 'asd', 42, 'asd', 'ae', 'ewq', 0),
(27, 9, 'das', 'asd', 'asd', 42, 'asd', 'ae', 'ewq', 0),
(28, 9, 'das', 'asd', 'asd', 42, 'asd', 'ae', 'ewq', 0),
(29, 9, 'das', 'asd', 'asd', 42, 'asd', 'ae', 'ewq', 0),
(30, 9, 'das', 'asd', 'asd', 42, 'asd', 'ae', 'ewq', 0),
(31, 9, 'das', 'asd', 'asd', 42, 'asd', 'ae', 'ewq', 0),
(32, 9, 'das', 'asd', 'asd', 42, 'asd', 'ae', 'ewq', 0),
(33, 9, 'das', 'asd', 'asd', 42, 'asd', 'ae', 'ewq', 0),
(34, 20, 'asda', 'asda', 'dasd', 312, '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `educational_attainment`
--

CREATE TABLE `educational_attainment` (
  `id` int(11) NOT NULL,
  `user_id` int(12) NOT NULL,
  `college` varchar(255) NOT NULL,
  `college_from` date NOT NULL,
  `college_to` date NOT NULL,
  `college_degree` varchar(255) NOT NULL,
  `vocational` varchar(255) NOT NULL,
  `vocational_from` date NOT NULL,
  `vocational_to` date NOT NULL,
  `vocational_diploma` varchar(255) NOT NULL,
  `high_school` varchar(255) NOT NULL,
  `high_school_from` date NOT NULL,
  `high_school_to` date NOT NULL,
  `high_school_level` varchar(255) NOT NULL,
  `elementary` varchar(255) NOT NULL,
  `elementary_from` date NOT NULL,
  `elementary_to` date NOT NULL,
  `elementary_level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `educational_attainment`
--

INSERT INTO `educational_attainment` (`id`, `user_id`, `college`, `college_from`, `college_to`, `college_degree`, `vocational`, `vocational_from`, `vocational_to`, `vocational_diploma`, `high_school`, `high_school_from`, `high_school_to`, `high_school_level`, `elementary`, `elementary_from`, `elementary_to`, `elementary_level`) VALUES
(33, 9, 'dasd', '2024-03-14', '0000-00-00', 'asd', 'da', '0000-00-00', '0000-00-00', 'a', 'asd', '0000-00-00', '0000-00-00', 'adad', 'asd', '2024-04-09', '0000-00-00', 'asd'),
(34, 20, 'asd', '2024-04-01', '2024-04-16', 'asd', 'das', '2024-04-26', '2024-04-15', 'ad', 'asd', '2024-04-26', '2024-04-15', 'asd', 'asd', '2024-04-24', '2024-04-23', 'asd');

-- --------------------------------------------------------

--
-- Table structure for table `employment_background`
--

CREATE TABLE `employment_background` (
  `id` int(11) NOT NULL,
  `user_id` int(12) NOT NULL,
  `company_one` varchar(255) NOT NULL,
  `company_one_position` varchar(255) NOT NULL,
  `company_one_from` year(4) NOT NULL,
  `company_one_to` year(4) NOT NULL,
  `company_one_status` varchar(255) NOT NULL,
  `company_one_responsibilities` text NOT NULL,
  `company_one_reason_for_leaving` text NOT NULL,
  `company_one_last_salary` int(12) NOT NULL,
  `company_two` varchar(255) NOT NULL,
  `company_two_position` varchar(255) NOT NULL,
  `company_two_from` year(4) NOT NULL,
  `company_two_to` year(4) NOT NULL,
  `company_two_status` varchar(255) NOT NULL,
  `company_two_responsibilities` text NOT NULL,
  `company_two_reason_for_leaving` text NOT NULL,
  `company_two_last_salary` int(12) NOT NULL,
  `company_three` varchar(255) NOT NULL,
  `company_three_position` varchar(255) NOT NULL,
  `company_three_from` year(4) NOT NULL,
  `company_three_to` year(4) NOT NULL,
  `company_three_status` varchar(255) NOT NULL,
  `company_three_responsibilities` text NOT NULL,
  `company_three_reason_for_leaving` text NOT NULL,
  `company_three_last_salary` int(12) NOT NULL,
  `recent_employment_contact_person` varchar(255) NOT NULL,
  `recent_employment_position` varchar(255) NOT NULL,
  `recent_employment_contact_number` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employment_background`
--

INSERT INTO `employment_background` (`id`, `user_id`, `company_one`, `company_one_position`, `company_one_from`, `company_one_to`, `company_one_status`, `company_one_responsibilities`, `company_one_reason_for_leaving`, `company_one_last_salary`, `company_two`, `company_two_position`, `company_two_from`, `company_two_to`, `company_two_status`, `company_two_responsibilities`, `company_two_reason_for_leaving`, `company_two_last_salary`, `company_three`, `company_three_position`, `company_three_from`, `company_three_to`, `company_three_status`, `company_three_responsibilities`, `company_three_reason_for_leaving`, `company_three_last_salary`, `recent_employment_contact_person`, `recent_employment_position`, `recent_employment_contact_number`) VALUES
(34, 9, 'das', 'asd', '0000', '0000', '', 'asd', 'asd', 0, 'asd', 'asd', '0000', '0000', '', 'asd', 'asd', 0, 'asd', 'w3eq', '0000', '0000', '', 'ewq', 'trtr', 0, 'das', 'asd', 321),
(35, 20, 'asd', 'asd', '2024', '2024', 'asd', 'asda', 'asda', 231, '', '', '0000', '0000', '', '', '', 0, '', '', '0000', '0000', '', '', '', 0, 'asd', 'asda', 213);

-- --------------------------------------------------------

--
-- Table structure for table `job_applicants`
--

CREATE TABLE `job_applicants` (
  `id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `job_id` int(12) NOT NULL,
  `application_status` varchar(255) NOT NULL,
  `interview_date` datetime DEFAULT NULL,
  `remark` text NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_applicants`
--

INSERT INTO `job_applicants` (`id`, `user_id`, `job_id`, `application_status`, `interview_date`, `remark`, `employee_id`) VALUES
(36, 9, 2, 'Passed', '2024-04-16 13:40:00', 'dasdasd5767576.  <br> Remark by: Berto Berto, jjjjjjjjjjjj.  <br> Remark by: Berto Berto, lllllllllllllllllllllllllllll.  <br> Remark by: Berto Berto, lllllllllllllll123.  <br> Remark by: Berto Berto, dsa.  <br> Remark by: Berto Berto, dsa.  <br> Remark by: Berto Berto, DDSA.  <br> Remark by: Berto Berto, dsa.  <br> Remark by: Berto Berto, asd.  <br> Remark by: Berto Berto, .  <br> Remark by: Berto Berto, dasdadadasdasdasd.  <br> Remark by: Berto Berto', 2),
(39, 20, 2, 'Backout', '2024-04-18 14:37:00', 'sad.  <br> Remark by: Berto Berto, .  <br> Remark by: Berto Berto, .  <br> Remark by: Berto Berto, dsa.  <br> Remark by: Berto Berto, das.  <br> Remark by: Berto Berto, sad.  <br> Remark by: Berto Berto, dasda.  <br> Remark by: Berto Berto, das123.  <br> Remark by: Berto Berto, das.  <br> Remark by: Berto Berto', 29);

-- --------------------------------------------------------

--
-- Table structure for table `lectures_and_seminars_attended`
--

CREATE TABLE `lectures_and_seminars_attended` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title_one` varchar(255) NOT NULL,
  `title_one_from` date NOT NULL,
  `title_one_to` date NOT NULL,
  `title_one_venue` varchar(255) NOT NULL,
  `title_two` varchar(255) NOT NULL,
  `title_two_from` date NOT NULL,
  `title_two_to` date NOT NULL,
  `title_two_venue` varchar(255) NOT NULL,
  `title_three` varchar(255) NOT NULL,
  `title_three_from` date NOT NULL,
  `title_three_to` date NOT NULL,
  `title_three_venue` varchar(255) NOT NULL,
  `title_four` varchar(255) NOT NULL,
  `title_four_from` date NOT NULL,
  `title_four_to` date NOT NULL,
  `title_four_venue` varchar(255) NOT NULL,
  `title_five` varchar(255) NOT NULL,
  `title_five_from` date NOT NULL,
  `title_five_to` date NOT NULL,
  `title_five_venue` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lectures_and_seminars_attended`
--

INSERT INTO `lectures_and_seminars_attended` (`id`, `user_id`, `title_one`, `title_one_from`, `title_one_to`, `title_one_venue`, `title_two`, `title_two_from`, `title_two_to`, `title_two_venue`, `title_three`, `title_three_from`, `title_three_to`, `title_three_venue`, `title_four`, `title_four_from`, `title_four_to`, `title_four_venue`, `title_five`, `title_five_from`, `title_five_to`, `title_five_venue`) VALUES
(31, 9, 'das', '2024-03-26', '2024-03-26', '2024-03-26', 'asd', '2024-03-26', '2024-03-26', '2024-03-26', 'da', '2024-03-26', '2024-03-26', '2024-03-26', '', '2024-04-10', '0000-00-00', '', '', '2024-04-15', '0000-00-00', ''),
(32, 20, 'asas', '0000-00-00', '2024-04-09', '2024-04-24', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `mrfs`
--

CREATE TABLE `mrfs` (
  `id` int(11) NOT NULL,
  `industry` varchar(255) NOT NULL,
  `mrf_status` varchar(255) NOT NULL,
  `closed_date` date NOT NULL,
  `request_date` date NOT NULL DEFAULT current_timestamp(),
  `client` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `aging_days` varchar(255) NOT NULL,
  `mrf_number` varchar(255) NOT NULL,
  `new_request` varchar(255) NOT NULL,
  `head_count` int(11) NOT NULL,
  `job_position` varchar(255) NOT NULL,
  `contract_type` varchar(255) NOT NULL,
  `classification` varchar(255) NOT NULL,
  `placed` int(11) NOT NULL,
  `variance` int(11) NOT NULL,
  `cancel` int(11) NOT NULL,
  `job_description` text NOT NULL,
  `qualification` text NOT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mrfs`
--

INSERT INTO `mrfs` (`id`, `industry`, `mrf_status`, `closed_date`, `request_date`, `client`, `location`, `aging_days`, `mrf_number`, `new_request`, `head_count`, `job_position`, `contract_type`, `classification`, `placed`, `variance`, `cancel`, `job_description`, `qualification`, `remarks`) VALUES
(1, 'Maintenance', 'Post', '0000-00-00', '2024-04-04', 'McDoasd', 'Logistics', '1', '0', 'Replacement', 103, 'Waitersa', 'Project-based', 'Skilled', 0, 0, 0, '                                                                                                                                                                        <ul><li>dsasdasdasd</li></ul>                                                                                                                                                                ', '                                                                                    0asdasdsadsa', ''),
(2, 'Retail', 'Post', '0000-00-00', '2024-04-03', 'McDo', 'Makati', '2', '0', 'Additional', 10, 'Waiter', 'Probationary', 'Non-skilled', 0, 0, 0, '                                                                                    <ol><li>asdasdsa</li></ol>                                                                                ', '                                                                                    <ul><li>asdasdasda</li></ul>                                                                                ', ''),
(3, 'Retail', 'Post', '0000-00-00', '2024-04-04', 'asda', 'Makati', '1', '0', 'Additional', 23, 'asdas', 'Fixed Term', 'Skilled', 0, 0, 0, '<ol><li>asdsa</li></ol>', '<ol><li>asdasd</li></ol>', ''),
(4, 'Retail', 'Post', '0000-00-00', '2024-04-04', 'KFC', 'Makati', '1', '0', 'Additional', 10, 'Crew', 'Probationary', 'Skilled', 0, 0, 0, '<ol><li>32</li></ol>', '<ol><li>3asdasdas</li></ol>', ''),
(5, 'Retail', 'Close', '2024-04-04', '2024-04-01', 'Accenture', 'Makati', '2', '0', 'Additional', 12, 'Tech Support', 'Probationary', 'Non-skilled', 0, 0, 0, '<ol><li>asdasda</li></ol>', '<ul><li>asdasdasd</li></ul>', ''),
(6, 'Retail', 'Close', '2024-04-04', '2024-04-04', 'McDo', 'Makati', '0', 're_6', 'Additional', 10, 'Waiter', 'Probationary', 'Non-skilled', 0, 0, 0, '<ul><li>asdsadsa</li></ul>', '<ul><li>asdasdasdas</li></ul>', ''),
(8, 'Retail', 'Hold', '0000-00-00', '2024-04-04', 'iuo', 'Makati', '1', 're_8', 'Replacement', 67, 'jyh', 'Probationary', 'Non-skilled', 0, 0, 0, '<p>kjhk</p>', '<p>hgjh</p>', ''),
(10, 'Retail', 'Hold', '0000-00-00', '2024-04-04', 'asda', 'Makati', '1', 're_10', 'Replacement', 32, 'asd', 'Probationary', 'Non-skilled', 0, 0, 0, '<p>asdasd</p>', '<p><br></p>aasdasd', ''),
(11, 'Retail', 'Close', '2024-04-05', '2024-04-04', 'asdasd', 'Logistics', '1', 're_11', 'Replacement', 2, 'asd', 'Project-based', 'Skilled', 0, 0, 0, '<p>sadda</p>', '<p>sadasdasdfgds</p>', ''),
(12, 'Retail', 'Hold', '0000-00-00', '2024-04-04', 'asdasda', 'Logistics', '1', 're_12', 'Additional', 2, 'asda', 'Project-based', 'Non-skilled', 0, 0, 0, '<p>asdasdas</p>', '<p>asdasda</p>', ''),
(13, 'Maintenance', 'Hold', '0000-00-00', '2024-04-04', 'asda', 'Makati', '1', 'main_13', 'Replacement', 23, 'asd', 'Probationary', 'Non-skilled', 0, 0, 0, '<p>asdas</p>', '<p>asdas</p>', ''),
(14, 'Logistics', 'Hold', '0000-00-00', '2024-04-04', 'sdsada', 'Food Services', '1', 'log_14', 'Replacement', 2, 'sada', 'Probationary', 'Non-skilled', 0, 0, 0, '<p>hvcbcvb</p>', '<p>asdasdas</p>', ''),
(15, 'Logistics', 'Hold', '0000-00-00', '2024-04-05', 'Popeyes', 'Makati', '0', 'log_15', 'Additional', 5, 'Seller', 'Probationary', 'Skilled', 0, 0, 0, '<p>asdassdadsaa</p>', '<p>dsatretertreterter</p>', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `resume` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `role`, `resume`, `branch`) VALUES
(2, 'Berto', 'Berto', 'berto@gmail.com', '$2y$10$cHP0Rr5QD2L8..KYYw3ao.z/01SHqzGVhnKhbSbM06ofWssF4Yqzu', 'Super Admin', '65f3ac7f2912c_01_Handout_1.pdf', 'Manila'),
(9, 'Roberto', 'Advincula', 'nm@gmail.com', '$2y$10$lxK4sVaAKJD6Ve0LQ/HuZuhqClGEtjHImwwI3i4wvLMXm9/6C2ZrW', 'user', '65f7de46cd506_01_Handout_1.pdf', ''),
(18, '', '', 'sad@gmail.com', '$2y$10$OPaAG1EdUfy6U0lr8ZH.yO5J/wpvYa3nEhBVKyse1WxPmQV1TLq22', 'user', '', ''),
(19, 'aa', 'bb', 'b@gmail.com', '$2y$10$jpqXcvqygRo4ZkH6FqHsGeIvCI3nkynDVEWpq7Y6azYLx2yLvTVyW', 'user', '65f107749a2a8_01_Handout_1.pdf', ''),
(20, 'd', 'd', 'd@gmail.com', '$2y$10$tYhqLWhl6uLjp1xxOXYLAOtb3/ArLYweILH.V79T2Tq7K0Nx2fORm', 'user', '', ''),
(26, 'Henard', 'Cueto', 'henard@gmail.com', '$2y$10$hyUOGhYAlB/2YOUnpMhn7eq.1PqdReVHnrt0.z31msIcRtyNbEPQS', 'user', '', ''),
(27, 'test', 'ops', 'ops@gmail.com', '$2y$10$BqCbeZ2vlVjZylEdwfJjseiYEsvhzIyc9MxnIo6xS9UlfIqYJzXeC', 'Operations', '', 'Makati'),
(28, 'test', 'emp', 'emp@gmail.com', '$2y$10$RPnzrLQRrFJmJMJ2stNs0.Jdcr7Pkidf8hzdVVG6RRUiNdtJloLAK', 'Employee', '', 'Makati'),
(29, 'test', 'admin', 'admiN@gmail.com', '$2y$10$g6QPzL3LoqMmcwZsisOPB.0YFVAndZGPZCaba8h3Fkc/78ywax5/W', 'Admin', '', 'Makati'),
(31, 'test', 'super', 'super@gmail.com', '$2y$10$K38Delw1Nktpm3PxyLeEnOQspPqO8hOe3tCQOBVerL7w3Zb1ccvx6', 'Super Admin', '', 'Makati'),
(32, 'djhab', 'sfbdj', 'gagokka@gmail.com', '$2y$10$xhhOxk.YHAcyw8C2pKy5o.Um.Q8XrejX36tLXz0kgiX0FDXij8/8K', 'user', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_resumes`
--

CREATE TABLE `user_resumes` (
  `id` int(11) NOT NULL,
  `user_id` int(12) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `present_address` text NOT NULL,
  `permanent_address` text NOT NULL,
  `birthdate` date NOT NULL,
  `gender` varchar(255) NOT NULL,
  `height` int(12) NOT NULL,
  `weight` int(12) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `religion` varchar(255) NOT NULL,
  `civil_status` varchar(255) NOT NULL,
  `sss_number` int(12) NOT NULL,
  `pagibig_number` int(12) NOT NULL,
  `philhealth_number` int(12) NOT NULL,
  `tin_number` int(12) NOT NULL,
  `contact_number` int(12) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `additional_info_q1` varchar(255) NOT NULL,
  `additional_info_q2` varchar(255) NOT NULL,
  `declaration` varchar(255) NOT NULL,
  `authorization` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_resumes`
--

INSERT INTO `user_resumes` (`id`, `user_id`, `picture`, `email`, `last_name`, `first_name`, `middle_name`, `present_address`, `permanent_address`, `birthdate`, `gender`, `height`, `weight`, `nationality`, `religion`, `civil_status`, `sss_number`, `pagibig_number`, `philhealth_number`, `tin_number`, `contact_number`, `reference`, `additional_info_q1`, `additional_info_q2`, `declaration`, `authorization`) VALUES
(5, 9, '6602359b0104b_default-profile-picture1.jpg', 'eq@gmail.com', 'ds', 'wq', 'eqw', 'asdqwe', 'sad', '2024-03-26', 'Male', 32, 32, 'hui', 'iu', 'Single', 765, 43, 53, 312, 231, 'Online Advertisement, Brochures / Flyers, Walk-in: ', 'ada', 'asd', 'agreed', ''),
(6, 20, '660a232e498ef_default-profile-picture1.jpg', 'askdj@gmail.com', 'Seesshh', 'asdhh', 'aksjdh', 'askduhg', 'sadhgkjg', '2024-04-24', 'Male', 231, 312, 'dkjashf', 'asd', 'Single', 321, 31232, 13123, 312, 132, 'Job Fair, Newspaper / Magazines, Walk-in: ', 'adas', 'asd', 'agreed', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicant_logs`
--
ALTER TABLE `applicant_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `character_references`
--
ALTER TABLE `character_references`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `educational_attainment`
--
ALTER TABLE `educational_attainment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employment_background`
--
ALTER TABLE `employment_background`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_applicants`
--
ALTER TABLE `job_applicants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lectures_and_seminars_attended`
--
ALTER TABLE `lectures_and_seminars_attended`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mrfs`
--
ALTER TABLE `mrfs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_resumes`
--
ALTER TABLE `user_resumes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicant_logs`
--
ALTER TABLE `applicant_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `character_references`
--
ALTER TABLE `character_references`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `educational_attainment`
--
ALTER TABLE `educational_attainment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `employment_background`
--
ALTER TABLE `employment_background`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `job_applicants`
--
ALTER TABLE `job_applicants`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `lectures_and_seminars_attended`
--
ALTER TABLE `lectures_and_seminars_attended`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `mrfs`
--
ALTER TABLE `mrfs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user_resumes`
--
ALTER TABLE `user_resumes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
