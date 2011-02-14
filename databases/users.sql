-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 10, 2010 at 05:51 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `records`
--
CREATE DATABASE IF NOT EXISTS records;
USE records;
CREATE TABLE IF NOT EXISTS `uiucdorm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `calorie` int NOT NULL,
  `fat` int NOT NULL,
  `carb` int NOT NULL,
  `protein` int NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `uiucdorm` (`name`, `calorie`, `fat`, `carb`, `protein`) VALUES
('aaaa', 32, 24, 55, 67);


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `temp_pass` varchar(32) DEFAULT NULL,
  `temp_pass_active` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `level_access` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Username` (`username`),
  UNIQUE KEY `Email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `temp_pass`, `temp_pass_active`, `email`, `active`, `level_access`) VALUES
(1, 'admin', 'admin', NULL, 0, '', 1, 1);
