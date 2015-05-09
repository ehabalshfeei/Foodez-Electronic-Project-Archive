-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2015 at 08:47 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `foodezwo_employees`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` char(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `password`) VALUES
(1, 'waiter1', 'cc03e747a6afbbcbf8be7668acfebee5'),
(2, 'waiter2', 'cc03e747a6afbbcbf8be7668acfebee5'),
(3, 'chef1', 'cc03e747a6afbbcbf8be7668acfebee5'),
(4, 'chef2', 'cc03e747a6afbbcbf8be7668acfebee5'),
(5, 'busboy1', 'cc03e747a6afbbcbf8be7668acfebee5'),
(6, 'busboy2', 'cc03e747a6afbbcbf8be7668acfebee5'),
(7, 'manager', 'cc03e747a6afbbcbf8be7668acfebee5'),
(8, 'waiter3', 'cc03e747a6afbbcbf8be7668acfebee5'),
(9, 'waiter4', 'cc03e747a6afbbcbf8be7668acfebee5'),
(10, 'chef3', 'cc03e747a6afbbcbf8be7668acfebee5'),
(11, 'chef4', 'cc03e747a6afbbcbf8be7668acfebee5'),
(12, 'busboy3', 'cc03e747a6afbbcbf8be7668acfebee5'),
(13, 'busboy4', 'cc03e747a6afbbcbf8be7668acfebee5');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
