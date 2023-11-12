-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2023 at 03:27 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `submit_report`
--

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `incident_type` varchar(40) NOT NULL,
  `image_path` varchar(40) NOT NULL,
  `location` varchar(40) NOT NULL,
  `reported_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `incident_type`, `image_path`, `location`, `reported_date`) VALUES
(11, 'Bushfiring', 'upload/IMG_20230905_132145.jpg', 'ARISA', '2023-09-06 09:29:15.958942'),
(12, 'Other Incident', 'upload/IMG_20230905_132145.jpg', 'SACEM-ARDHI UNIVERSITY', '2023-09-06 09:29:15.958942'),
(13, 'kata mti', 'upload/c68cf480-1635-4a42-8e88-441b96cb7', 'ARISA', '2023-09-06 09:29:15.958942'),
(14, 'choma mti', 'upload/f6045b54-828b-4c29-bb0d-3836f4684', 'mbezi', '2023-09-06 09:29:15.958942'),
(15, 'chafu', 'upload/6db90c0a-2d7d-441f-a353-434f138b3', 'makongo', '2023-09-06 09:29:15.958942'),
(16, 'TAKATAK', 'upload/87215348-6ce4-45f9-8416-cbf001dba', 'PANDE', '2023-09-06 09:29:15.958942'),
(17, 'Logging', 'upload/195dab6f-80c2-44d4-a8e2-1db8f0bb8', 'ARDHI GETI DOGO CAFETERIA', '2023-09-06 10:04:06.123480'),
(18, 'hyhhtggg', 'upload/845911a6-f6b7-4d66-943c-9bcbc79b8', 'mmmm', '2023-09-06 11:34:02.093521');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`) VALUES
(1, 'hosiana', 'hosiana@gmail.com', '4844f0e034ab3fa91d2e704c7bcec925'),
(2, 'nyelu', 'nyelu@gmail.com', '3aca1d7f97ee28be3ddaae8404249395');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
