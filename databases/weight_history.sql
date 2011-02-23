-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 21, 2011 at 11:28 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `records`
--

-- --------------------------------------------------------

--
-- Table structure for table `weight_history`
--

CREATE TABLE IF NOT EXISTS `weight_history` (
  `weight_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(10) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`weight_id`),
  UNIQUE KEY `date` (`date`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `weight_history`
--

INSERT INTO `weight_history` (`weight_id`, `date`, `weight`) VALUES
(1, '02/16/2011', 365),
(2, '02/12/2011', 232);
