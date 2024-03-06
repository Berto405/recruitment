-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2024 at 09:25 AM
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
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'test', 'test@gmail.com', 'test', 'user'),
(2, 'berto', 'berto@gmail.com', '$2y$10$lMvqJWsXFRrbmf8eoOgWP.RsBDTQ4PRt8914ZQzWGN2yWAbX/LUXO', 'admin'),
(3, '', 'test1@gmail.com', '$2y$10$xxYtRbI2UDMI9P4FWvZOt.rYfjYWhg2RKeMG4rP5rxrso7X8jJO1u', 'user'),
(4, '', 'test2@gmail.com', '$2y$10$1w.r0Hnb0ww.ofF8xxmkn.AiSUpNfbCYSvcjVMCJUJNbN5uiLZ2DG', 'user'),
(5, '', 'bertoo@gmail.com', '$2y$10$9U7MbmXBij8FgEPf/unLyu/pL2JVLeQDPWQmfOozlW6mQLJyK8NgW', 'user'),
(6, '', 'bertoooo@gmail.com', '$2y$10$l2qeNYeL0u4xULEep90do.h55jVfwn3RylzHBPfWFfSusKKjPgmZa', 'user'),
(7, '', 'testest@gmail.com', '$2y$10$IfNf6p4FVhcOyElVRo6br.jLztSxW27dSFKeZmCat07xCBmkqi.jS', 'user'),
(8, '', 'new@gmail.com', '$2y$10$WBhYWti36XVTRT951.i6I.ttxlcDwRemwZI7RnsH7HpC0b90DGxpS', 'user'),
(9, '', 'nm@gmail.com', '$2y$10$6dagzluc30XKlbhU7ox5Wu.ORQ4OgMopFKCKsaWfClr5OzV0.kt62', 'user'),
(10, 'Roberto Advincula', 'bertw@gmail.com', '$2y$10$HK/OprvVQsTEj/TrbO8aCONil78/LDgClFMvEmPIbxD18hpRiUtui', 'user'),
(11, 'shesh sheesh', 'shes@gmail.com', '$2y$10$cNCoPKIdMxh0X8J4uQKf6uFytN3/JInhNynq0K.e/QS2IEzXHXaUC', 'user'),
(12, 'jj hh', 'h@gmail.com', '$2y$10$xOS/MUG00N9VSxhgbbRZlO7pAZfk8zDAFa.AhU7.9vlS7bscs7GWa', 'user'),
(13, 'asd asd', 'as@gmail.com', '$2y$10$TchRc7BVw8YrTtLbsbJ7QeNhuePr7r.qnZEY.I8fwHrQqX6N.5OTi', 'user'),
(14, 'berto berto', 'berto1@gmail.com', '$2y$10$he1Vtqu2XIRlMv6N.TjJcOaDlrYJ5seZ1jUio/yErCZKAtK1ixmH6', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
