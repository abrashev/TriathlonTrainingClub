-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2013 at 05:24 PM
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

--
-- Dumping data for table `intervals`
--

INSERT INTO `intervals` (`session_id`, `description`, `level`, `duration`) VALUES
(1, 'Turbo,rollers or spin class', 7, 40),
(3, 'Easy swim drills done perfectly', 4, 30),
(3, 'Aqua jog steady', 6, 30),
(6, 'Rest 20 seconds between each 75m', 8, 18),
(2, 'Warm-up', 4, 10),
(2, 'Run while nose breathing', 6, 30),
(5, 'Focus on increased pedal downstroke effort for 5 rpm on alternate legs', 5, 50),
(4, 'with shorter stride and quiet footfall', 6, 25);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `description`, `type`, `distance`, `duration`, `by`, `allcompleted`, `time_added`) VALUES
(1, 'Stay within your endurance zone', 'cycling', 16, '40', 'john', 0, '2013-08-20 16:47:15'),
(2, 'Note time and heart rate', 'running', 14, '40', 'bolt', 0, '2013-08-21 22:53:40'),
(3, 'Swim', 'swimming', 2.2, '60', 'bolt', 1, '2013-08-20 21:09:18'),
(4, 'Basic run', 'running', 10, '25', 'john', 0, '2013-08-22 13:42:34'),
(5, 'Turbo or rollers', 'cycling', 20, '50', 'smith', 0, '2013-08-22 08:17:04'),
(6, 'Focus on 75m intervals of smooth, fast and stroke counting length', 'swimming', 2, '15', 'smith', 1, '2013-08-21 21:50:28');

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

--
-- Dumping data for table `takesessions`
--

INSERT INTO `takesessions` (`user_id`, `session_id`, `completed`, `whenis`) VALUES
(2, 6, 1, '2013-08-22 13:24:24'),
(3, 1, 0, '2013-08-20 16:47:17'),
(6, 2, 0, '2013-08-21 22:53:50'),
(6, 3, 1, '2013-08-21 09:02:07'),
(9, 5, 0, '2013-08-22 08:17:05'),
(15, 4, 0, '2013-08-22 13:42:35');

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
  `age` int(4) NOT NULL,
  `coach` tinyint(1) NOT NULL,
  `trained_by` varchar(20) NOT NULL,
  `email` varchar(25) NOT NULL,
  `picture` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstName`, `lastName`, `age`, `coach`, `trained_by`, `email`, `picture`) VALUES
(1, 'administrator', 'thisclubadmin365', 'Vladimir', 'Penev', 1984, 0, 'nobody', 'club@someaddress.uk', 'default_user.jpg'),
(2, 'girl', 'good', 'Mariana', 'Trifonova', 1988, 0, 'smith', 'mary@abv.bg', '2.jpg'),
(3, 'mike', 'runners', 'Michael', 'Scofield', 1974, 0, 'john', 'scoop@abv.bg', 'default_user.jpg'),
(4, 'bolt', 'some', 'Doncho', 'Raev', 1969, 1, 'nobody', 'fast@abv.bg', 'default_user.jpg'),
(5, 'john', 'joe', 'John', 'Doe', 1974, 1, 'nobody', 'johnywalker@abv.bg', 'default_user.jpg'),
(6, 'ssa', 'pound', 'Kevin', 'Doyle', 1983, 0, 'bolt', 'slon@abv.bg', '6.jpg'),
(7, 'smith', 'super', 'Stoyan', 'Paunov', 1990, 1, 'nobody', 'agent@abv.bg', '7.jpg'),
(8, 'vanko', 'ludak', 'Petar', 'Petrov', 1982, 0, 'john', 'petar123@abv.bg', 'default_user.jpg'),
(9, 'sweet', 'kiss', 'Tereza', 'Dimova', 1993, 0, 'smith', 'kiss@abv.bg', 'default_user.jpg'),
(10, 'ivcho', 'ivcho', 'Ivan', 'Petrov', 1987, 0, 'bolt', 'ivak@abv.bg', 'default_user.jpg'),
(11, 'ilia', 'iliikata', 'Ilian', 'Nedkov', 1980, 0, 'john', 'iliancho@abv.bg', 'default_user.jpg'),
(12, 'xmen', 'blood', 'Richie', 'Ryan', 1986, 0, 'bolt', 'rich@abv.bg', 'default_user.jpg'),
(13, 'lord', 'ludak', 'Mark', 'Drew', 1981, 0, 'smith', 'some@abv.bg', 'default_user.jpg'),
(14, 'paul', 'sleep', 'Paul', 'Shaw', 1983, 0, 'bolt', 'some@abv.bg', 'default_user.jpg'),
(15, 'mcloud', 'mac', 'Duncan', 'McLoud', 1974, 0, 'john', 'dunkan@abv.bg', 'default_user.jpg'),
(16, 'misha', 'kiss', 'Misha', 'Burton', 1974, 0, 'john', 'misha@abv.bg', 'default_user.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
