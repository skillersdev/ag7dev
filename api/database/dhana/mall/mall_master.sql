-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2019 at 08:41 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.2.20

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
-- Table structure for table `mall_master`
--

CREATE TABLE `mall_master` (
  `id` int(11) NOT NULL,
  `mall_name` varchar(400) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `owner_id` int(10) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` int(2) NOT NULL,
  `code` varchar(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `usergroup` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mall_master`
--

INSERT INTO `mall_master` (`id`, `mall_name`, `created_by`, `owner_id`, `created_date`, `is_deleted`, `code`, `username`, `password`, `usergroup`) VALUES
(1, 'dfdsfds', '1', 0, '2019-08-26 18:56:38', 1, '', '123', '123', ''),
(2, 'mall12', '2', 0, '2019-08-26 18:56:47', 0, '', '456', '456', ''),
(3, 'mall2', '2', 0, '2019-08-26 18:57:00', 0, '', 'dhana', 'dhana', ''),
(4, 'new mall', '2', 0, '2019-09-10 18:28:51', 0, '', 'new', 'new', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mall_master`
--
ALTER TABLE `mall_master`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mall_master`
--
ALTER TABLE `mall_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
