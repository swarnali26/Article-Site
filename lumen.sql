-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2020 at 05:12 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lumen`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `description` varchar(60) NOT NULL,
  `userid` varchar(50) DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `description`, `userid`, `created_at`, `updated_at`) VALUES
(1, 'a', 'hhhhh', '3', '2020-03-19', '2020-03-19'),
(2, 'a', 'hhhhh', '2', '2020-03-19', '2020-03-19'),
(3, 'bbb', 'hhhhjjjjjh', '1', '2020-03-19', '2020-03-19'),
(4, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '3', '2020-03-20', '2020-03-20'),
(5, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '2', '2020-03-20', '2020-03-20'),
(6, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '1', '2020-03-20', '2020-03-20'),
(9, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '1', '2020-03-20', '2020-03-20'),
(10, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '1', '2020-03-21', '2020-03-21'),
(11, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '1', '2020-03-21', '2020-03-21'),
(12, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '1', '2020-03-21', '2020-03-21'),
(13, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '1', '2020-03-21', '2020-03-21'),
(14, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '1', '2020-03-21', '2020-03-21'),
(15, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '1', '2020-03-21', '2020-03-21'),
(16, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '1', '2020-03-21', '2020-03-21'),
(17, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '1', '2020-03-21', '2020-03-21'),
(18, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '1', '2020-03-21', '2020-03-21'),
(19, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '1', '2020-03-21', '2020-03-21'),
(20, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '1', '2020-03-21', '2020-03-21'),
(21, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '1', '2020-03-21', '2020-03-21'),
(22, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '1', '2020-03-21', '2020-03-21'),
(23, 'dsjjjadkhlkasklf', 'hhhdskhsdlsa', '1', '2020-03-21', '2020-03-21');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `comment` varchar(50) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `follow` varchar(10) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`id`, `userid`, `follow`, `created_at`, `updated_at`) VALUES
(1, 2, '', '0000-00-00', '0000-00-00'),
(5, 1, '2', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `roleid` int(11) NOT NULL,
  `name` varchar(10) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `userid` int(11) NOT NULL,
  `token` varchar(20) NOT NULL,
  `roleid` int(11) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`userid`, `token`, `roleid`, `created_at`, `updated_at`) VALUES
(1, 'cW7NSVrCNN', 2, NULL, NULL),
(1, 'ieMiX2cTkn', 2, NULL, NULL),
(1, 'ZWwxDo2eaS', 2, NULL, NULL),
(5, 'BpTU3rzCWj', 2, '2020-03-31', '2020-03-31'),
(5, 'Q192FusA8n', 2, '2020-03-31', '2020-03-31'),
(4, 'jicpdaHUe3', 2, '2020-03-31', '2020-03-31'),
(4, 'NWGM9HLlcW', 2, '2020-03-31', '2020-03-31'),
(4, '50acKfkNwk', 2, '2020-03-31', '2020-03-31'),
(4, 'Wb5EwJdfJH', 2, '2020-03-31', '2020-03-31'),
(4, 'c8vB4bff05', 2, '2020-03-31', '2020-03-31'),
(4, 'DgMqvN9yyh', 2, '2020-03-31', '2020-03-31'),
(4, 'KfVI23g4j5', 2, '2020-03-31', '2020-03-31'),
(4, '2ubpPO9B3T', 2, '2020-03-31', '2020-03-31'),
(4, '1SMaEwIso7', 2, '2020-03-31', '2020-03-31'),
(4, 'fpcDUT9qWt', 2, '2020-03-31', '2020-03-31'),
(4, '1NSOoTLTb5', 2, '2020-03-31', '2020-03-31'),
(4, 'DAyXDXx5mu', 2, '2020-03-31', '2020-03-31'),
(4, '75Nv880hM4', 2, '2020-03-31', '2020-03-31'),
(4, 'uXQkAJtxnj', 2, '2020-03-31', '2020-03-31'),
(4, '0I9YkCaURV', 2, '2020-03-31', '2020-03-31'),
(4, 'S1qLw4GB4J', 2, '2020-03-31', '2020-03-31'),
(4, '4KwaKPCLpJ', 2, '2020-03-31', '2020-03-31'),
(4, 'kAFJeuXqNr', 2, '2020-03-31', '2020-03-31'),
(4, 'tk1OotTRyF', 2, '2020-03-31', '2020-03-31'),
(4, 'TVtNXSsQOj', 2, '2020-03-31', '2020-03-31'),
(4, 'idkWiWA2rZ', 2, '2020-03-31', '2020-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(40) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `roleid` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `firstname`, `lastname`, `email`, `password`, `phone`, `roleid`, `created_at`, `updated_at`) VALUES
(1, 'swarnali', 'marik', 'swarnali.marik5@gmail.com', '123', '7984561237', 2, '2020-03-16', '2020-03-16'),
(2, 'anibhab', 'koley', 'anubhab.koley@gmail.com', '123', '7777777777', 2, '0000-00-00', '0000-00-00'),
(3, 'bipasha', 'sur', 'bipasha.sur@gmail.com', '123', '5555555555', 2, '0000-00-00', '0000-00-00'),
(4, 'rima', 'malik', 'rima.malik@gmail.com', '202cb962ac59075b964b07152d234b70', '7894561237', 2, '2020-03-27', '2020-03-27'),
(5, 'swarnali', 'marik', 'abc.d@gmail.com', '202cb962ac59075b964b07152d234b70', '7894561237', 2, '2020-03-31', '2020-03-31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roleid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `roleid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
