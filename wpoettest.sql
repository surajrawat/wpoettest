-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2021 at 08:55 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wpoettest`
--

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` int(11) NOT NULL,
  `tab_id` int(10) NOT NULL,
  `heading` text NOT NULL,
  `subheading` text NOT NULL,
  `image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `tab_id`, `heading`, `subheading`, `image`) VALUES
(1, 2, 'Digital Learning Infrastructure', 'Generate Lorem Ipsum placeholder text. Select the number', '20210406084033123302DL-Technology.jpg'),
(2, 2, 'Lorem Ipsum Generator 1', 'Generate Lorem Ipsum placeholder text select the number.', '20210406081116811646DL-Learning-1.jpg'),
(3, 2, 'Lorem Ipsum Generator 2', 'Generate Lorem Ipsum placeholder text select the number.', '20210406081132651714DL-Communication.jpg'),
(4, 3, 'Technology Ipsum Generator 1', 'Generate Lorem Ipsum placeholder text select the number.', '20210406081210743088DL-Communication.jpg'),
(5, 3, 'Technology Ipsum Generator 2', 'Generate Lorem Ipsum placeholder text select the number.', '20210406081221710414DL-Learning-1.jpg'),
(6, 3, 'Technology Ipsum Generator 3', 'Generate Lorem Ipsum placeholder text select the number.', '20210406081233108398DL-Technology.jpg'),
(7, 4, 'Communication Ipsum Generator 1', 'Generate Lorem Ipsum placeholder text select the number.', '20210406081251572381DL-Communication.jpg'),
(8, 4, 'Communication Ipsum Generator 2', 'Generate Lorem Ipsum placeholder text select the number.', '20210406081305072791DL-Learning-1.jpg'),
(10, 4, 'Communication Ipsum Generator 3', 'Generate Lorem Ipsum placeholder text. Select the number', '20210406084346269701DL-Technology.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tab`
--

CREATE TABLE `tab` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `icon_image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab`
--

INSERT INTO `tab` (`id`, `name`, `icon_image`) VALUES
(2, 'Learning', '20210405160009250883classroom.png'),
(3, 'Technology', '20210405152513549185computer.png'),
(4, 'Communication', '20210405152525388930talking.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tab`
--
ALTER TABLE `tab`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tab`
--
ALTER TABLE `tab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
