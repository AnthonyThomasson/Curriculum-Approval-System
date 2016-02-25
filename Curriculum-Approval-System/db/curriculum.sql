-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 19, 2014 at 10:33 PM
-- Server version: 5.5.38
-- PHP Version: 5.6.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `curriculum`
--

-- --------------------------------------------------------

--
-- Table structure for table `approval`
--

CREATE TABLE `approval` (
  `requestId` int(45) NOT NULL,
  `userId` int(45) NOT NULL,
  `approved` enum('Approved','Denied','Unset') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `approval`
--

INSERT INTO `approval` (`requestId`, `userId`, `approved`) VALUES
(58, 2, 'Unset'),
(58, 3, 'Unset'),
(60, 1, 'Unset'),
(60, 2, 'Unset'),
(61, 1, 'Unset'),
(61, 2, 'Unset'),
(62, 1, 'Unset'),
(62, 2, 'Unset'),
(62, 3, 'Unset');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approval`
--
ALTER TABLE `approval`
 ADD PRIMARY KEY (`requestId`,`userId`);
