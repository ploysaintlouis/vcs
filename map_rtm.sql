-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2019 at 06:34 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `map_rtm`
--

CREATE TABLE `map_rtm` (
  `id` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  `changeRequestNo` varchar(10) DEFAULT NULL,
  `functionId` int(10) NOT NULL,
  `functionVersion` int(10) NOT NULL,
  `testcaseId` int(10) NOT NULL,
  `testcaseVersion` int(10) NOT NULL,
  `activeflag` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `map_rtm`
--

INSERT INTO `map_rtm` (`id`, `projectId`, `changeRequestNo`, `functionId`, `functionVersion`, `testcaseId`, `testcaseVersion`, `activeflag`) VALUES
(1, 1, 'CH02', 6, 1, 6, 1, 0),
(2, 1, 'CH02', 7, 1, 7, 1, 0),
(3, 1, 'CH02', 8, 1, 8, 1, 0),
(4, 1, 'CH02', 9, 1, 9, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `map_rtm`
--
ALTER TABLE `map_rtm`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `map_rtm`
--
ALTER TABLE `map_rtm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
