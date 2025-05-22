-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2025 at 04:43 AM
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

--
-- Dumping data for table `eoi`
--

INSERT INTO `eoi` (`EOInumber`, `Job_Reference_number`, `First_name`, `Last_name`, `dob`, `gender`, `Street_address`, `Suburb`, `State`, `Postcode`, `Email_address`, `Phone_number`, `technical_skills`, `other_skills`, `Status`) VALUES
(3, 'SE123', 'Shriyans', 'Simhadri', '15/04/2007', 'm', '1 Julep St, Manor Lakes, 3024', 'Manor Lakes', 'VIC', '3024', 'shriyans_simhadri@yahoo.com', '0450141504', 'NWS, EPS, APS', 'Etc', 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `ref_number` varchar(50) NOT NULL,
  `salary_range` varchar(100) NOT NULL,
  `reports_to` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `responsibilities` text NOT NULL,
  `qualifications_essential` text NOT NULL,
  `qualifications_preferable` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `ref_number`, `salary_range`, `reports_to`, `description`, `responsibilities`, `qualifications_essential`, `qualifications_preferable`) VALUES
(1, 'Software Engineer', 'SE123', '$80,000 - $120,000 per annum', 'Lead Software Developer', 'We are looking for a skilled Software Engineer to develop high-quality applications.', '<ul>\r\n     <li>Develop, test, and maintain web applications</li>\r\n     <li>Collaborate with cross-functional teams</li>\r\n     <li>Ensure software security and performance optimization</li>\r\n   </ul>', '<ul>\r\n     <li>Bachelor’s degree in Computer Science or related field</li>\r\n     <li>3+ years of experience in software development</li>\r\n     <li>Proficiency in JavaScript, Python, or Java</li>\r\n   </ul>', '<ul>\r\n     <li>Experience with cloud computing</li>\r\n     <li>Knowledge of DevOps practices</li>\r\n   </ul>'),
(2, 'Cybersecurity Specialist', 'CS789', '$95,000 - $140,000 per annum', 'Chief Security Officer', 'We are looking for a Cybersecurity Specialist to protect our IT infrastructure and sensitive data from cyber threats.', '<ol>\r\n     <li>Develop and implement security policies and procedures</li>\r\n     <li>Monitor networks for security breaches</li>\r\n     <li>Conduct security audits and risk assessments</li>\r\n     <li>Respond to cybersecurity incidents and provide solutions</li>\r\n     <li>Ensure compliance with security regulations</li>\r\n   </ol>', '<ul>\r\n     <li>Bachelor’s degree in Cybersecurity, Computer Science, or related field</li>\r\n     <li>3+ years of experience in cybersecurity roles</li>\r\n     <li>Expertise in firewall management, intrusion detection, and encryption technologies</li>\r\n   </ul>', '<ul>\r\n     <li>Certifications such as CISSP, CISM, or CEH</li>\r\n     <li>Experience with cloud security</li>\r\n   </ul>');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOInumber`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOInumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
