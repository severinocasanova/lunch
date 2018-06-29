-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 29, 2018 at 03:22 PM
-- Server version: 5.6.40
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `lunch_locations`
--

CREATE TABLE `lunch_locations` (
  `lunch_location_id` int(255) NOT NULL,
  `lunch_location_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lunch_location_name` varchar(255) NOT NULL,
  `lunch_location_display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lunch_locations`
--
ALTER TABLE `lunch_locations`
  ADD PRIMARY KEY (`lunch_location_id`),
  ADD UNIQUE KEY `location name` (`lunch_location_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lunch_locations`
--
ALTER TABLE `lunch_locations`
  MODIFY `lunch_location_id` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;
