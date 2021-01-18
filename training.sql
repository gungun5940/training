-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2020 at 05:11 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `training`
--

-- --------------------------------------------------------

--
-- Table structure for table `authencode_log`
--

CREATE TABLE `authencode_log` (
  `lev_id` int(1) NOT NULL,
  `lev_name` varchar(10) NOT NULL,
  `lev_decript` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` varchar(10) NOT NULL,
  `course_name_th` varchar(100) NOT NULL,
  `course_name_en` varchar(100) NOT NULL,
  `course_object` text NOT NULL,
  `course_goal` text NOT NULL,
  `course_property` text NOT NULL,
  `course_hours` float NOT NULL,
  `course_link` varchar(150) NOT NULL,
  `course_status` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `course_open`
--

CREATE TABLE `course_open` (
  `open_no` int(10) NOT NULL,
  `open_course` varchar(3) NOT NULL,
  `open_startyear` varchar(4) NOT NULL,
  `open_endyear` varchar(4) NOT NULL,
  `open_date` date NOT NULL,
  `open_startdate` date NOT NULL,
  `open_enddate` date NOT NULL,
  `open_status` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `mem_no` int(10) NOT NULL,
  `mem_prename` varchar(5) NOT NULL,
  `mem_firstname` varchar(30) NOT NULL,
  `mem_lastname` varchar(30) NOT NULL,
  `mem_gender` varchar(1) NOT NULL,
  `mem_birth` date NOT NULL,
  `mem_code` varchar(13) NOT NULL,
  `mem_add1` varchar(30) NOT NULL,
  `mem_add2` varchar(50) NOT NULL,
  `mem_add3` varchar(6) NOT NULL,
  `mem_contact` varchar(50) NOT NULL,
  `mem_startdate` date NOT NULL,
  `mem_username` varchar(15) NOT NULL,
  `mem_password` varchar(15) NOT NULL,
  `mem_status` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `member_register`
--

CREATE TABLE `member_register` (
  `mem_no` int(10) NOT NULL,
  `reg_course_no` varchar(10) NOT NULL,
  `reg_date` date NOT NULL,
  `reg_status` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Indexes for table `authencode_log`
--
ALTER TABLE `authencode_log`
  ADD PRIMARY KEY (`lev_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_open`
--
ALTER TABLE `course_open`
  ADD PRIMARY KEY (`open_no`),
  ADD KEY `open_course` (`open_course`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`mem_no`),
  ADD KEY `mem_prename` (`mem_prename`),
  ADD KEY `mem_add3` (`mem_add3`);

--
-- Indexes for table `member_register`
--
ALTER TABLE `member_register`
  ADD KEY `mem_no` (`mem_no`),
  ADD KEY `reg_course_no` (`reg_course_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authencode_log`
--
ALTER TABLE `authencode_log`
  MODIFY `lev_id` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_open`
--
ALTER TABLE `course_open`
  MODIFY `open_no` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `mem_no` int(10) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
