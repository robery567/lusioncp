-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 29, 2014 at 08:24 PM
-- Server version: 5.6.21-70.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lcp_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `lcpa_clients`
--

CREATE TABLE IF NOT EXISTS `lcpa_clients` (
  `user_id` int(9) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) COLLATE utf8_bin NOT NULL,
  `password` text COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lcpa_license`
--

CREATE TABLE IF NOT EXISTS `lcpa_license` (
  `license_id` int(9) NOT NULL AUTO_INCREMENT,
  `company_id` int(9) NOT NULL,
  `license_ip` varchar(255) COLLATE utf8_bin NOT NULL,
  `license_startdate` datetime NOT NULL,
  `license_expiry` datetime NOT NULL,
  PRIMARY KEY (`license_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lcpa_logs`
--

CREATE TABLE IF NOT EXISTS `lcpa_logs` (
  `log_id` int(9) NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `log_desc` text COLLATE utf8_bin NOT NULL,
  `log_date` datetime NOT NULL,
  `log_from` int(9) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
