-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2020 at 02:11 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `traininglevel`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `inv_id` int(11) NOT NULL,
  `inv_mem_id` int(11) NOT NULL,
  `inv_course_id` int(11) NOT NULL,
  `inv_open_id` int(11) NOT NULL,
  `inv_name` varchar(128) NOT NULL,
  `inv_code` varchar(13) NOT NULL,
  `inv_add_num` varchar(10) NOT NULL,
  `inv_add_street` varchar(32) NOT NULL,
  `inv_add_province_id` int(2) NOT NULL,
  `inv_add_amphure_id` int(4) NOT NULL,
  `inv_add_district_id` int(4) NOT NULL,
  `inv_add_zipcode` int(5) NOT NULL,
  `inv_status` varchar(10) NOT NULL,
  `inv_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `inv_updated` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`inv_id`, `inv_mem_id`, `inv_course_id`, `inv_open_id`, `inv_name`, `inv_code`, `inv_add_num`, `inv_add_street`, `inv_add_province_id`, `inv_add_amphure_id`, `inv_add_district_id`, `inv_add_zipcode`, `inv_status`, `inv_created`, `inv_updated`) VALUES
(1, 1, 7, 12, 'มหาวิทยาลัยราชภัฏลำปาง', '99352101542', '119 หมู่ 9', 'ลำปาง - แม่ทะ', 40, 603, 520106, 52100, 'waiting', '2020-12-02 12:14:36', '2020-12-02 13:11:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`inv_id`),
  ADD KEY `inv_mem_id` (`inv_mem_id`),
  ADD KEY `inv_course_id` (`inv_course_id`),
  ADD KEY `inv_open_id` (`inv_open_id`),
  ADD KEY `inv_add_province_id` (`inv_add_province_id`),
  ADD KEY `inv_add_amphure_id` (`inv_add_amphure_id`),
  ADD KEY `inv_add_district_id` (`inv_add_district_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
