-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2020 at 06:44 PM
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
-- Table structure for table `manage_section_item`
--

CREATE TABLE `manage_section_item` (
  `id` int(15) NOT NULL,
  `website` varchar(155) NOT NULL,
  `media_type` int(15) NOT NULL,
  `title` varchar(155) NOT NULL,
  `description` varchar(155) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `attachment_desc` varchar(255) NOT NULL,
  `created_by` int(15) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `is_deleted` int(15) NOT NULL,
  `section` int(15) NOT NULL,
  `preview_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manage_section_item`
--

INSERT INTO `manage_section_item` (`id`, `website`, `media_type`, `title`, `description`, `file_name`, `attachment_desc`, `created_by`, `created_date`, `is_deleted`, `section`, `preview_file`) VALUES
(1, 'skillersglobalservice', 1, 'wher', 'dfgdgdg', 'section_uploads/5e581320c534f.png', '', 0, '2020-02-28 00:36:08', 0, 1, ''),
(2, 'skillersglobalservice', 3, 'asdadd', 'asdada', 'sectionitemvideos/eafea8ac1b9fb86f5a4444d16b2f8adb.pdf', 'asdada', 769, '2020-02-28 01:41:56', 0, 6, 'section_uploads/5e59c0e03a0e6.png'),
(3, 'skillersglobalservice', 2, 'asdadd', 'asdada', 'Error While upload on image', 'asdada', 769, '2020-02-28 01:42:19', 0, 1, 'section_uploads/5e59c1295abde.png'),
(4, 'skillersglobalservice', 2, 'dsfsfsf', 'sdfsf', 'sectionitemvideos/88fa253f69a210bcdbd9d4174ebd2692.mp4', '', 769, '2020-02-28 01:44:33', 0, 1, 'section_uploads/5e5823296325f.png'),
(5, 'skillersglobalservice', 5, 'soind', 'sdf', 'sectionitemvideos/f096b571ca32af0451e09bc449b0b493.mp3', '', 769, '2020-02-28 01:54:28', 0, 1, 'section_uploads/5e58257c67d17.png'),
(6, 'skillersglobalservice', 3, 'pdftest', 'sdfsfsf', 'sectionitemvideos/8330613f6f30d757c98ec1419daa3687.pdf', '', 769, '2020-02-28 01:57:14', 0, 1, 'section_uploads/5e5826225ad62.png'),
(7, 'skillersglobalservice', 4, 'doc tes', 'sdf', 'sectionitemvideos/3836b89cbc7293807003141f5082f711.doc', '', 769, '2020-02-28 01:58:44', 1, 1, 'section_uploads/5e58267c441f4.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `manage_section_item`
--
ALTER TABLE `manage_section_item`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manage_section_item`
--
ALTER TABLE `manage_section_item`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
