-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2013 at 08:14 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `club`
--
CREATE DATABASE IF NOT EXISTS `club` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `club`;

-- --------------------------------------------------------

--
-- Table structure for table `intervals`
--

CREATE TABLE IF NOT EXISTS `intervals` (
  `session_id` int(8) NOT NULL,
  `description` varchar(100) NOT NULL,
  `level` int(3) NOT NULL,
  `duration` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `distance` double NOT NULL,
  `duration` varchar(20) NOT NULL,
  `by` varchar(20) NOT NULL,
  `allcompleted` tinyint(1) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `takesessions`
--

CREATE TABLE IF NOT EXISTS `takesessions` (
  `user_id` int(3) NOT NULL,
  `session_id` int(8) NOT NULL,
  `completed` tinyint(1) NOT NULL,
  `whenis` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `age` int(2) NOT NULL,
  `coach` int(1) NOT NULL,
  `trained_by` varchar(20) NOT NULL,
  `email` varchar(25) NOT NULL,
  `picture` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstName`, `lastName`, `age`, `coach`, `trained_by`, `email`, `picture`) VALUES
(1, 'administrator', 'thisclubadmin365', 'Vladimir', 'Penev', 1985, 0, 'nobody', 'admin@abv.bg', 'default_user.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
