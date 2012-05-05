-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 05, 2012 at 10:49 AM
-- Server version: 5.5.22
-- PHP Version: 5.3.10-1ubuntu3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `schnippets`
--

-- --------------------------------------------------------

--
-- Table structure for table `schnippets`
--

CREATE TABLE IF NOT EXISTS `schnippets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(128) NOT NULL,
  `lang` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `code` text NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `protected` varchar(3) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE IF NOT EXISTS `search` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `term` varchar(255) NOT NULL,
  `counter` int(10) unsigned NOT NULL,
  `last_search` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `fname` varchar(65) NOT NULL,
  `lname` varchar(65) NOT NULL,
  `password` varchar(255) NOT NULL,
  `temp_pwd` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `user_type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `fname`, `lname`, `password`, `temp_pwd`, `user_type`) VALUES
(1, 'admin@example.com', 'Admin', 'User', 'c934eb2406bb7660cdd153d0eb2e190c', 0, 30);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
