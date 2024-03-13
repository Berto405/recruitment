-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2024 at 03:57 AM
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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(12) NOT NULL,
  `job_name` varchar(255) NOT NULL,
  `salary` int(12) NOT NULL,
  `job_type` varchar(255) NOT NULL,
  `shift_and_schedule` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `job_description` text NOT NULL,
  `benefits` text NOT NULL,
  `priority` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `job_name`, `salary`, `job_type`, `shift_and_schedule`, `location`, `job_description`, `benefits`, `priority`, `department`, `created_at`) VALUES
(1, 'Tech Support', 20, 'Part time', '8 hours shift', 'Makati City', 'Ready to join Accenture’s team of empowered people? We’re looking for candidates with the following skills and experience for this role. Do you fit the profile? If you do, we’d love to hear from you!\n\nOn Wednesdays we wear Purple at Accenture! Join us celebrate women\'s boundless potential for Purple Wednesdays on March 6, 13, 20 & 27!\n\nPurple is Women. Purple is Accenture.\n\n#AccentureWomen #InternationalWomensMonth\n\nWhat you’ll do:\n\nAs a S/4HANA Finance Lead Consultant, you will be the part of our team of experts responsible for creating a detailed blueprint for the development requirements of S/4HANA, and for providing business and functional support around SAP modules, particularly for ECC Migration or conversion from legacy SAP systems to SAP S/4HANA. You will also be in charge of the configuration and functions for any of the following areas:\n\nGeneral Accounting\nControlling\nProduct Costing\nAsset Accounting & Project Systems\nFinancial Supply Chain Management\nTreasury & Banking\nBusiness Planning & Consolidation\nKey Responsibilities\n\nProvide business and functional support on SAP modules, particularly for conversions from legacy SAP systems to SAP S/4HANA.\nAssess impact and gaps in the current business processes and configuration for the SAP module vs. the equivalent in SAP S/4HANA, and provide alternatives and recommendations on the delta design.\nProvide technology consulting expertise and develop functional and technical specifications for the delta design, and for tools to support the SAP S/4HANA conversion.\nExecute the necessary system configuration to enable to SAP S/4HANA conversion.\nLead testing and defect resolution in the context of SAP S/4HANA conversions.\nHere’s what you’ll need:\n\nMinimum Requirements:\n\nMust possess at least a Bachelor\'s/College Degree\n2+ Years of Experience in SAP ERP as Finance functional consultant is an advantage\nAbility to demonstrate understanding of end-to-end business process of record to report\nMust demonstrate the dependencies and integration with other SAP modules (e.g. FI, CO, etc.).\nTechnology consulting expertise, and ability to drive workshops and training sessions\nECC Practitioners will be given upskilling training, to be job ready for S/4HANA implementations\nWilling to travel for possible onshore requirements\nKey Skills\n\nGood interpersonal skills, including strong verbal and written communication.\nAble to work under pressure without any supervision, and a good team player.', 'Free lunch', 'Urgent Hiring', '', '2024-03-13 02:50:52'),
(2, 'Human Resource', 50, 'Full time', '8 hours shift', 'Makati City', 'Ready to join Accenture’s team of empowered people? We’re looking for candidates with the following skills and experience for this role. Do you fit the profile? If you do, we’d love to hear from you!\r\n\r\nOn Wednesdays we wear Purple at Accenture! Join us celebrate women\'s boundless potential for Purple Wednesdays on March 6, 13, 20 & 27!\r\n\r\nPurple is Women. Purple is Accenture.\r\n\r\n#AccentureWomen #InternationalWomensMonth\r\n\r\nWhat you’ll do:\r\n\r\nAs a S/4HANA Finance Lead Consultant, you will be the part of our team of experts responsible for creating a detailed blueprint for the development requirements of S/4HANA, and for providing business and functional support around SAP modules, particularly for ECC Migration or conversion from legacy SAP systems to SAP S/4HANA. You will also be in charge of the configuration and functions for any of the following areas:\r\n\r\nGeneral Accounting\r\nControlling\r\nProduct Costing\r\nAsset Accounting & Project Systems\r\nFinancial Supply Chain Management\r\nTreasury & Banking\r\nBusiness Planning & Consolidation\r\nKey Responsibilities\r\n\r\nProvide business and functional support on SAP modules, particularly for conversions from legacy SAP systems to SAP S/4HANA.\r\nAssess impact and gaps in the current business processes and configuration for the SAP module vs. the equivalent in SAP S/4HANA, and provide alternatives and recommendations on the delta design.\r\nProvide technology consulting expertise and develop functional and technical specifications for the delta design, and for tools to support the SAP S/4HANA conversion.\r\nExecute the necessary system configuration to enable to SAP S/4HANA conversion.\r\nLead testing and defect resolution in the context of SAP S/4HANA conversions.\r\nHere’s what you’ll need:\r\n\r\nMinimum Requirements:\r\n\r\nMust possess at least a Bachelor\'s/College Degree\r\n2+ Years of Experience in SAP ERP as Finance functional consultant is an advantage\r\nAbility to demonstrate understanding of end-to-end business process of record to report\r\nMust demonstrate the dependencies and integration with other SAP modules (e.g. FI, CO, etc.).\r\nTechnology consulting expertise, and ability to drive workshops and training sessions\r\nECC Practitioners will be given upskilling training, to be job ready for S/4HANA implementations\r\nWilling to travel for possible onshore requirements\r\nKey Skills\r\n\r\nGood interpersonal skills, including strong verbal and written communication.\r\nAble to work under pressure without any supervision, and a good team player.', 'Wala', '', '', '2024-03-13 02:50:52'),
(3, 'IT Specialist', 90, 'Full time', '10 hours shift', 'Makati City', 'Sheesh', 'Wala', '', '', '2024-03-13 02:50:52'),
(4, 'Accountant', 23, 'Full time', '12 hours shift', 'Pasay City', 'SHEEESSSSHHHHHHH', 'Wala', '', '', '2024-03-13 02:50:52'),
(7, 'Waiter', 10000, 'Full-time', '8 hours shift', 'Manila', '<ul><li>SSSSSSHHHHHHHHHEEEEEEEEEESSSSSSHHHHHHH</li></ul>', '<ul><li>WLAA</li></ul>', 'Urgent Hiring', 'IT', '2024-03-13 02:50:52'),
(8, 'Pilot', 10, 'Part-time', '8 hours shift', 'Cavite', '<ul><li><b>SHH</b></li></ul>', '<ul><li>WaLA</li></ul>', 'Non-urgent Hiring', 'IT', '2024-03-13 02:50:52'),
(9, 'SAP', 10000, 'Full-time', '8 hours shift', 'Makati City', '<ul><li>asdads</li></ul>', '<ul><li>asdaaa</li></ul>', 'Non-urgent Hiring', 'IT', '2024-03-13 02:50:52'),
(10, 'Finance', 10000, 'Full-time', '8 hours shift', 'Makati', '<ul><li>das</li></ul>', '<ol><li>2313</li></ol>', 'Non-urgent Hiring', 'Operations', '2024-03-13 02:50:52'),
(11, 'SHESSH', 1000, 'Full-time', '9 hours shift', 'Makati', '<p>asda</p>', '<p>asda</p><p>asdsd</p>', 'Non-urgent Hiring', 'IT', '2024-03-13 02:51:41');

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
(1, 9, 1, 'Selected', NULL),
(2, 9, 3, 'Not Selected', NULL),
(3, 9, 2, 'Interview', '2024-03-15 11:49:00'),
(5, 9, 4, 'Pending', NULL),
(6, 19, 1, 'Pending', NULL);

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
  `resume` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `role`, `resume`) VALUES
(2, 'Berto', 'Berto', 'berto@gmail.com', '$2y$10$lMvqJWsXFRrbmf8eoOgWP.RsBDTQ4PRt8914ZQzWGN2yWAbX/LUXO', 'admin', ''),
(9, 'Roberto', 'Wews', 'nm@gmail.com', '$2y$10$.Vcfb7anIIoorTOqUceLrebcgdbd8OImp19nZvI64wvIFem/wSAWW', 'user', '65efcda1239af_01_Handout_1.pdf'),
(18, '', '', 'sad@gmail.com', '$2y$10$OPaAG1EdUfy6U0lr8ZH.yO5J/wpvYa3nEhBVKyse1WxPmQV1TLq22', 'user', ''),
(19, 'aa', 'bb', 'b@gmail.com', '$2y$10$jpqXcvqygRo4ZkH6FqHsGeIvCI3nkynDVEWpq7Y6azYLx2yLvTVyW', 'user', '65f107749a2a8_01_Handout_1.pdf');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `job_applicants`
--
ALTER TABLE `job_applicants`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
