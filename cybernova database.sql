-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 08:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cybernova`
--

-- --------------------------------------------------------

--
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `EOInumber` int(11) NOT NULL,
  `Job_Reference_number` varchar(50) NOT NULL,
  `First_name` varchar(50) NOT NULL,
  `Last_name` varchar(50) NOT NULL,
  `dob` varchar(100) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `Street_address` varchar(100) NOT NULL,
  `Suburb` varchar(50) NOT NULL,
  `State` varchar(3) NOT NULL,
  `Postcode` varchar(4) NOT NULL,
  `Email_address` varchar(100) NOT NULL,
  `Phone_number` varchar(15) NOT NULL,
  `technical_skills` varchar(100) NOT NULL,
  `other_skills` text NOT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'New'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `Title` varchar(100) NOT NULL,
  `Reference_Number` varchar(100) NOT NULL,
  `Salary_Range` varchar(100) NOT NULL,
  `Job_Description` varchar(100) NOT NULL,
  `Key_Responsibilities1` varchar(100) NOT NULL,
  `Key_Responsibilities2` varchar(100) NOT NULL,
  `Key_Responsibilities3` varchar(100) NOT NULL,
  `Qualifications_Skills` varchar(100) NOT NULL,
  `Essential` varchar(100) NOT NULL,
  `Preferable` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOInumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOInumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

