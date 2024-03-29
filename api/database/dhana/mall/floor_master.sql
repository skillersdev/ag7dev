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
-- Table structure for table `floor_master`
--

CREATE TABLE `floor_master` (
  `id` int(11) NOT NULL,
  `floor_name` varchar(400) NOT NULL,
  `mall_id` int(10) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `owner_id` int(10) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` int(2) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `usergroup` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `floor_master`
--

INSERT INTO `floor_master` (`id`, `floor_name`, `mall_id`, `created_by`, `owner_id`, `created_date`, `is_deleted`, `username`, `password`, `usergroup`) VALUES
(1, 'floor12', 3, '2', 0, '2019-08-10 09:34:25', 1, '', '', ''),
(2, 'floor2', 2, '2', 0, '2019-09-05 20:11:19', 0, 'floor', 'floor', ''),
(3, 'floor test1', 2, 'floor', 0, '2019-09-05 20:43:33', 0, 'ff1', 'ff1', ''),
(4, 'floor test', 2, '2', 0, '2019-09-10 18:37:24', 0, 'aaaa', 'aaaa', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `floor_master`
--
ALTER TABLE `floor_master`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `floor_master`
--
ALTER TABLE `floor_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
