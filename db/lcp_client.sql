-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 29, 2014 at 08:25 PM
-- Server version: 5.6.21-70.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lcp_client`
--

-- --------------------------------------------------------

--
-- Table structure for table `lcpc_clients`
--

CREATE TABLE IF NOT EXISTS `lcpc_clients` (
  `user_id` int(9) NOT NULL AUTO_INCREMENT,
  `username` varchar(55) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` text COLLATE utf8_bin NOT NULL,
  `server_ip` varchar(15) COLLATE utf8_bin NOT NULL,
  `server_port` int(6) NOT NULL DEFAULT '22',
  `server_username` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'root',
  `server_password` text COLLATE utf8_bin NOT NULL,
  `is_installed` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lcpc_clients`
--

INSERT INTO `lcpc_clients` (`user_id`, `username`, `email`, `password`, `server_ip`, `server_port`, `server_username`, `server_password`, `is_installed`) VALUES
(1, 'admtest', 'admtest@lusioncp.me', '*F9851358885D1F3A54BB4C64311D8489DF12BCA1', '185.36.253.190', 22, 'root', 'hud32f', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
