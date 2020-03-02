-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2020 at 06:45 PM
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
-- Database: `roodadae_mlm_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `manage_section`
--

CREATE TABLE `manage_section` (
  `id` int(15) NOT NULL,
  `website` varchar(255) NOT NULL,
  `section_name` varchar(155) NOT NULL,
  `long_desc` varchar(255) NOT NULL,
  `Issection_show` int(15) NOT NULL DEFAULT 0 COMMENT '0=show;1=hide',
  `is_deleted` int(15) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(15) NOT NULL,
  `Isdefault` int(15) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manage_section`
--

INSERT INTO `manage_section` (`id`, `website`, `section_name`, `long_desc`, `Issection_show`, `is_deleted`, `created_at`, `created_by`, `Isdefault`) VALUES
(1, 'default', 'MyProducts', 'My Products', 1, 0, '2020-02-28 02:26:28', 0, 1),
(2, 'default', 'My Advertisement', 'My Advertisement', 1, 0, '2020-02-28 02:26:28', 0, 1),
(3, 'default', 'Myservice', 'Myservice', 0, 0, '2020-02-28 02:27:21', 0, 1),
(4, 'default', 'Myalbum', 'Myalbum', 0, 0, '2020-02-28 02:27:21', 0, 1),
(5, 'default', 'Myvideos', 'Myvideos', 0, 0, '2020-02-28 02:27:35', 0, 1),
(6, 'skillersglobalservice', 'my section', 'dfsf', 0, 0, '2020-02-28 19:51:48', 769, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `manage_section`
--
ALTER TABLE `manage_section`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manage_section`
--
ALTER TABLE `manage_section`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
