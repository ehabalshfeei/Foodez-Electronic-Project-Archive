-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2015 at 08:48 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `foodezwo_shifts_busboy`
--

-- --------------------------------------------------------

--
-- Table structure for table `friday`
--

CREATE TABLE IF NOT EXISTS `friday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `shift0` tinyint(1) DEFAULT NULL,
  `user0` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift1` tinyint(1) DEFAULT NULL,
  `user1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift2` tinyint(1) DEFAULT NULL,
  `user2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift3` tinyint(1) DEFAULT NULL,
  `user3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `friday`
--

INSERT INTO `friday` (`id`, `date`, `shift0`, `user0`, `shift1`, `user1`, `shift2`, `user2`, `shift3`, `user3`) VALUES
(1, '5/1/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(2, '5/8/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(3, '5/15/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(4, '5/22/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(5, '5/29/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(6, '6/5/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(7, '6/12/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(8, '6/19/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(9, '6/26/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(10, '7/3/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `monday`
--

CREATE TABLE IF NOT EXISTS `monday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `shift0` tinyint(1) DEFAULT NULL,
  `user0` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift1` tinyint(1) DEFAULT NULL,
  `user1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift2` tinyint(1) DEFAULT NULL,
  `user2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift3` tinyint(1) DEFAULT NULL,
  `user3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `monday`
--

INSERT INTO `monday` (`id`, `date`, `shift0`, `user0`, `shift1`, `user1`, `shift2`, `user2`, `shift3`, `user3`) VALUES
(1, '4/27/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(2, '5/4/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(3, '5/11/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(4, '5/18/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(5, '5/25/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(6, '6/1/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(7, '6/8/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(8, '6/15/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(9, '6/22/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(10, '6/29/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `saturday`
--

CREATE TABLE IF NOT EXISTS `saturday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `shift0` tinyint(1) DEFAULT NULL,
  `user0` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift1` tinyint(1) DEFAULT NULL,
  `user1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift2` tinyint(1) DEFAULT NULL,
  `user2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift3` tinyint(1) DEFAULT NULL,
  `user3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `saturday`
--

INSERT INTO `saturday` (`id`, `date`, `shift0`, `user0`, `shift1`, `user1`, `shift2`, `user2`, `shift3`, `user3`) VALUES
(1, '5/2/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(2, '5/9/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(3, '5/16/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(4, '5/23/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(5, '5/30/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(6, '6/6/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(7, '6/13/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(8, '6/20/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(9, '6/27/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(10, '7/4/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sunday`
--

CREATE TABLE IF NOT EXISTS `sunday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `shift0` tinyint(1) DEFAULT NULL,
  `user0` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift1` tinyint(1) DEFAULT NULL,
  `user1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift2` tinyint(1) DEFAULT NULL,
  `user2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift3` tinyint(1) DEFAULT NULL,
  `user3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `sunday`
--

INSERT INTO `sunday` (`id`, `date`, `shift0`, `user0`, `shift1`, `user1`, `shift2`, `user2`, `shift3`, `user3`) VALUES
(1, '4/26/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(2, '5/3/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(3, '5/10/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(4, '5/17/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(5, '5/24/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(6, '5/31/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(7, '6/7/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(8, '6/14/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(9, '6/21/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(10, '6/28/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `thursday`
--

CREATE TABLE IF NOT EXISTS `thursday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `shift0` tinyint(1) DEFAULT NULL,
  `user0` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift1` tinyint(1) DEFAULT NULL,
  `user1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift2` tinyint(1) DEFAULT NULL,
  `user2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift3` tinyint(1) DEFAULT NULL,
  `user3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `thursday`
--

INSERT INTO `thursday` (`id`, `date`, `shift0`, `user0`, `shift1`, `user1`, `shift2`, `user2`, `shift3`, `user3`) VALUES
(1, '4/30/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(2, '5/7/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(3, '5/14/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(4, '5/21/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(5, '5/28/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(6, '6/4/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(7, '6/11/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(8, '6/18/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(9, '6/25/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(10, '7/2/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tuesday`
--

CREATE TABLE IF NOT EXISTS `tuesday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `shift0` tinyint(1) DEFAULT NULL,
  `user0` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift1` tinyint(1) DEFAULT NULL,
  `user1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift2` tinyint(1) DEFAULT NULL,
  `user2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift3` tinyint(1) DEFAULT NULL,
  `user3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tuesday`
--

INSERT INTO `tuesday` (`id`, `date`, `shift0`, `user0`, `shift1`, `user1`, `shift2`, `user2`, `shift3`, `user3`) VALUES
(1, '4/28/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(2, '5/5/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(3, '5/12/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(4, '5/19/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(5, '5/26/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(6, '6/2/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(7, '6/9/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(8, '6/16/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(9, '6/23/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(10, '6/30/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wednesday`
--

CREATE TABLE IF NOT EXISTS `wednesday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `shift0` tinyint(1) DEFAULT NULL,
  `user0` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift1` tinyint(1) DEFAULT NULL,
  `user1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift2` tinyint(1) DEFAULT NULL,
  `user2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shift3` tinyint(1) DEFAULT NULL,
  `user3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `wednesday`
--

INSERT INTO `wednesday` (`id`, `date`, `shift0`, `user0`, `shift1`, `user1`, `shift2`, `user2`, `shift3`, `user3`) VALUES
(1, '4/29/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(2, '5/6/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(3, '5/13/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(4, '5/20/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(5, '5/27/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(6, '6/3/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(7, '6/10/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(8, '6/17/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(9, '6/24/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL),
(10, '7/1/15', 0, NULL, 0, NULL, 0, NULL, 0, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
