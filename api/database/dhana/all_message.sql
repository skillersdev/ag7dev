-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2019 at 09:46 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `roodadae_mlm`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_message`
--

CREATE TABLE `all_message` (
  `id` int(11) NOT NULL,
  `group_id` int(10) NOT NULL,
  `message` varchar(4000) NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `all_message`
--

INSERT INTO `all_message` (`id`, `group_id`, `message`, `created_by`, `created_date`, `is_deleted`) VALUES
(1, 11, 'tetetett bfdfj', 10, '2019-05-23 18:56:49', 0),
(2, 11, 'aaa sdsad', 2, '2019-05-23 18:57:15', 0),
(3, 11, 'test msg', 7, '2019-05-23 19:36:38', 0),
(4, 12, 'dfgdfgdfgfd', 7, '2019-05-23 19:36:56', 0),
(5, 11, 'sample', 7, '2019-05-23 19:39:55', 0),
(6, 11, 'dsfbsdfsd fsdfdsbfdsnf sdfhdsfnjsdkfndjksfnkjdnsfjnjdsfdfdsf dfsdf', 7, '2019-05-23 19:40:42', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_message`
--
ALTER TABLE `all_message`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_message`
--
ALTER TABLE `all_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
