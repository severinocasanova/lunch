-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 29, 2018 at 03:27 PM
-- Server version: 5.6.40
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `lunch_winners`
--

CREATE TABLE `lunch_winners` (
  `lunch_winner_id` int(255) NOT NULL,
  `lunch_winner_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lunch_winner_location` varchar(255) NOT NULL,
  `lunch_winner_display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lunch_winners`
--
ALTER TABLE `lunch_winners`
  ADD PRIMARY KEY (`lunch_winner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lunch_winners`
--
ALTER TABLE `lunch_winners`
  MODIFY `lunch_winner_id` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;
