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
-- Table structure for table `shop_master`
--

CREATE TABLE `shop_master` (
  `id` int(11) NOT NULL,
  `shop_name` varchar(400) NOT NULL,
  `mall_id` int(10) NOT NULL,
  `floor_id` int(10) NOT NULL,
  `logo` varchar(300) NOT NULL,
  `banner` varchar(400) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `owner_id` int(10) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` int(2) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `usergroup` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop_master`
--

INSERT INTO `shop_master` (`id`, `shop_name`, `mall_id`, `floor_id`, `logo`, `banner`, `created_by`, `owner_id`, `created_date`, `is_deleted`, `username`, `password`, `usergroup`) VALUES
(1, 'shop11', 2, 2, '', '', '2', 0, '2019-09-05 20:53:12', 0, 'shop', 'shop', ''),
(2, 'ss', 2, 2, '1568474750image.jpg', '1568474754image.jpg', 'shop', 0, '2019-09-15 16:23:49', 0, 'asa', 'asa', ''),
(3, 'new shop1', 2, 2, '1568474750image.jpg', '1568474754image.jpg', '2', 2, '2019-09-14 15:26:07', 0, 'dhana1', 'dhana1', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `shop_master`
--
ALTER TABLE `shop_master`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `shop_master`
--
ALTER TABLE `shop_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
