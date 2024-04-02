-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2024 at 11:33 AM
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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(12) NOT NULL,
  `job_name` varchar(255) NOT NULL,
  `number_required` int(12) NOT NULL,
  `job_type` varchar(255) NOT NULL,
  `shift_and_schedule` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `job_description` text NOT NULL,
  `qualification` text NOT NULL,
  `priority` varchar(255) NOT NULL,
  `industry` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `job_name`, `number_required`, `job_type`, `shift_and_schedule`, `location`, `job_description`, `qualification`, `priority`, `industry`, `created_at`) VALUES
(1, 'Tech Support', 20, 'Full-time', '8 hours shift', 'Makati City', 'Ready to join  team of empowered people? We’re looking for candidates with the following skills and experience for this role. Do you fit the profile? If you do, we’d love to hear from you!\r\n\r\nOn Wednesdays we wear Purple at Accenture! Join us celebrate women\'s boundless potential for Purple Wednesdays on March 6, 13, 20 & 27!\r\n\r\nPurple is Women. Purple is Accenture.\r\n\r\n#AccentureWomen #InternationalWomensMonth\r\n\r\nWhat you’ll do:\r\n\r\nAs a S/4HANA Finance Lead Consultant, you will be the part of our team of experts responsible for creating a detailed blueprint for the development requirements of S/4HANA, and for providing business and functional support around SAP modules, particularly for ECC Migration or conversion from legacy SAP systems to SAP S/4HANA. You will also be in charge of the configuration and functions for any of the following areas:\r\n\r\nGeneral Accounting\r\nControlling\r\nProduct Costing\r\nAsset Accounting & Project Systems\r\nFinancial Supply Chain Management\r\nTreasury & Banking\r\nBusiness Planning & Consolidation\r\nKey Responsibilities\r\n\r\nProvide business and functional support on SAP modules, particularly for conversions from legacy SAP systems to SAP S/4HANA.\r\nAssess impact and gaps in the current business processes and configuration for the SAP module vs. the equivalent in SAP S/4HANA, and provide alternatives and recommendations on the delta design.\r\nProvide technology consulting expertise and develop functional and technical specifications for the delta design, and for tools to support the SAP S/4HANA conversion.\r\nExecute the necessary system configuration to enable to SAP S/4HANA conversion.\r\nLead testing and defect resolution in the context of SAP S/4HANA conversions.\r\nHere’s what you’ll need:\r\n\r\nMinimum Requirements:\r\n\r\nMust possess at least a Bachelor\'s/College Degree\r\n2+ Years of Experience in SAP ERP as Finance functional consultant is an advantage\r\nAbility to demonstrate understanding of end-to-end business process of record to report\r\nMust demonstrate the dependencies and integration with other SAP modules (e.g. FI, CO, etc.).\r\nTechnology consulting expertise, and ability to drive workshops and training sessions\r\nECC Practitioners will be given upskilling training, to be job ready for S/4HANA implementations\r\nWilling to travel for possible onshore requirements\r\nKey Skills\r\n\r\nGood interpersonal skills, including strong verbal and written communication.\r\nAble to work under pressure without any supervision, and a good team player.', 'Free lunch', 'Urgent Hiring', 'Legal', '2024-03-19 08:48:52'),
(2, 'Human Resource', 50, 'Full-time', '8 hours shift', 'Makati City', 'Ready to join Accenture’s team of empowered people? We’re looking for candidates with the following skills and experience for this role. Do you fit the profile? If you do, we’d love to hear from you!\r\n\r\nOn Wednesdays we wear Purple at Accenture! Join us celebrate women\'s boundless potential for Purple Wednesdays on March 6, 13, 20 & 27!\r\n\r\nPurple is Women. Purple is Accenture.\r\n\r\n#AccentureWomen #InternationalWomensMonth\r\n\r\nWhat you’ll do:\r\n\r\nAs a S/4HANA Finance Lead Consultant, you will be the part of our team of experts responsible for creating a detailed blueprint for the development requirements of S/4HANA, and for providing business and functional support around SAP modules, particularly for ECC Migration or conversion from legacy SAP systems to SAP S/4HANA. You will also be in charge of the configuration and functions for any of the following areas:\r\n\r\nGeneral Accounting\r\nControlling\r\nProduct Costing\r\nAsset Accounting & Project Systems\r\nFinancial Supply Chain Management\r\nTreasury & Banking\r\nBusiness Planning & Consolidation\r\nKey Responsibilities\r\n\r\nProvide business and functional support on SAP modules, particularly for conversions from legacy SAP systems to SAP S/4HANA.\r\nAssess impact and gaps in the current business processes and configuration for the SAP module vs. the equivalent in SAP S/4HANA, and provide alternatives and recommendations on the delta design.\r\nProvide technology consulting expertise and develop functional and technical specifications for the delta design, and for tools to support the SAP S/4HANA conversion.\r\nExecute the necessary system configuration to enable to SAP S/4HANA conversion.\r\nLead testing and defect resolution in the context of SAP S/4HANA conversions.\r\nHere’s what you’ll need:\r\n\r\nMinimum Requirements:\r\n\r\nMust possess at least a Bachelor\'s/College Degree\r\n2+ Years of Experience in SAP ERP as Finance functional consultant is an advantage\r\nAbility to demonstrate understanding of end-to-end business process of record to report\r\nMust demonstrate the dependencies and integration with other SAP modules (e.g. FI, CO, etc.).\r\nTechnology consulting expertise, and ability to drive workshops and training sessions\r\nECC Practitioners will be given upskilling training, to be job ready for S/4HANA implementations\r\nWilling to travel for possible onshore requirements\r\nKey Skills\r\n\r\nGood interpersonal skills, including strong verbal and written communication.\r\nAble to work under pressure without any supervision, and a good team player.', 'Wala', 'Non-urgent Hiring', 'Operations', '2024-03-19 09:03:20'),
(3, 'IT Specialist', 900, 'Intern', '8 hours shift', 'Makati City', '<p>Sheesh</p><p>sd</p><ul><li>dasda</li><li>asd</li><li>a</li></ul>', '<p>Wala</p><p>sd</p>', 'Urgent Hiring', 'IT', '2024-03-20 02:37:32'),
(7, 'Waiter', 10000, 'Full-time', '8 hours shift', 'Manila', '<ul><li>SSSSSSHHHHHHHHHEEEEEEEEEESSSSSSHHHHHHH</li></ul>', '<ul><li>WLAA</li></ul>', 'Urgent Hiring', 'IT', '2024-03-13 02:50:52'),
(9, 'SAP', 10000, 'Part-time', '8 hours shift', 'Parañaque', '<ul><li>asdads</li></ul>', '<ul><li>asdaaa</li></ul>', 'Non-urgent Hiring', 'IT', '2024-03-15 08:28:20'),
(10, 'Finance', 10000, 'Full-time', '8 hours shift', 'Makati', '<ul><li>das</li></ul>', '<ol><li>2313</li></ol>', 'Non-urgent Hiring', 'Operations', '2024-03-13 02:50:52'),
(11, 'SHESSH', 1000, 'Full-time', '9 hours shift', 'Makati', '<p>asda</p>', '<p>asda</p><p>asdsd</p>', 'Non-urgent Hiring', 'IT', '2024-03-13 02:51:41'),
(12, '', 0, 'Full-time', '', '', '<span style=\"background-color: rgb(247, 173, 107);\">sdsada</span>', '', 'Non-urgent Hiring', 'IT', '2024-03-15 02:08:42'),
(13, 'Tech Support', 100, 'Full-time', '8 hours shift', 'Makati City', '<ul><li>sda</li></ul>', '<ul><li>aksjdhakj</li></ul>', 'Non-urgent Hiring', 'IT', '2024-03-18 03:15:12'),
(14, 'Developer', 20, 'Full-time', '8 hours shift', 'Makati', '<ul><li>asd</li></ul>', '<ul><li>asd</li></ul>', 'Non-urgent Hiring', 'IT', '2024-03-18 03:16:57'),
(15, 'kjk', 0, 'Full-time', 'jdsalk', 'ojas', '<ol><li>ds</li><li>asd</li><li>sad</li></ol>', '<ul><li>adads</li><li><b>ada</b></li></ul>', 'Non-urgent Hiring', 'IT', '2024-03-18 07:12:22'),
(16, 'Test test', 20000, 'Full-time', '8 hours shift', 'Makati', '<ul><li>asdsada</li><li>asd</li></ul><p>as</p><p><br></p>', '<p><b>sdjaajdalkla</b></p>', 'Urgent Hiring', 'IT', '2024-03-19 05:27:16');

-- --------------------------------------------------------

--
-- Table structure for table `job_applicants`
--

CREATE TABLE `job_applicants` (
  `id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `job_id` int(12) NOT NULL,
  `application_status` varchar(255) NOT NULL,
  `interview_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_applicants`
--

INSERT INTO `job_applicants` (`id`, `user_id`, `job_id`, `application_status`, `interview_date`) VALUES
(1, 9, 1, 'Selected', '2024-03-20 12:40:00'),
(2, 9, 3, 'Onboarding', '2024-03-19 09:31:00'),
(3, 9, 2, 'Placed', '2024-03-20 15:13:00'),
(6, 19, 1, 'Interview', '2024-03-20 18:20:00'),
(8, 9, 7, 'Selected', '2024-03-19 17:26:00'),
(10, 9, 11, 'Waiting for Start Date', NULL),
(12, 9, 14, 'Onboarding', NULL),
(13, 9, 1, 'Reviewed', '2024-03-28 05:32:00'),
(14, 9, 7, 'Ongoing Requirements', NULL),
(15, 9, 13, 'Waiting for Feedback', NULL),
(16, 9, 9, 'For Initial Interview', NULL),
(17, 9, 16, 'Waiting for Feedback', '2024-03-21 08:00:00'),
(18, 9, 14, 'Waiting for Start Date', NULL),
(19, 9, 15, 'Placed', NULL),
(20, 9, 13, 'Waiting for Start Date', NULL),
(21, 9, 3, 'Waiting for Start Date', NULL),
(23, 9, 10, 'Pending', NULL),
(25, 20, 3, 'Ongoing Requirements', NULL),
(26, 20, 1, 'Pooling', NULL),
(27, 20, 10, 'Pooled', NULL),
(28, 20, 1, 'Pending', NULL);

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
(31, 'test', 'super', 'super@gmail.com', '$2y$10$K38Delw1Nktpm3PxyLeEnOQspPqO8hOe3tCQOBVerL7w3Zb1ccvx6', 'Super Admin', '', 'Makati');

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
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
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
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `job_applicants`
--
ALTER TABLE `job_applicants`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `lectures_and_seminars_attended`
--
ALTER TABLE `lectures_and_seminars_attended`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_resumes`
--
ALTER TABLE `user_resumes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
