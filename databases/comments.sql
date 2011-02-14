-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 13, 2010 at 09:15 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `records`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE IF NOT EXISTS `blog_comments` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `entry` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `comment` longtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `blog_comments`
--

INSERT INTO `blog_comments` (`id`, `entry`, `name`, `email`, `url`, `comment`, `timestamp`) VALUES
(1, 0, 'Sue', 'suebriquet@gmail.com', '', 'comment', '0000-00-00 00:00:00'),
(2, 0, 'Sue', 'suebriquet@gmail.com', '', 'comment2', '0000-00-00 00:00:00'),
(3, 0, 'Sue', 'suebriquet@gmail.com', '', 'comment2', '0000-00-00 00:00:00'),
(4, 0, 'Sue', 'suebriquet@gmail.com', '', 'another comment', '0000-00-00 00:00:00'),
(5, 0, 'Sue', 'suebriquet@gmail.com', '', 'another comment', '0000-00-00 00:00:00'),
(6, 0, 'Sue', 'suebriquet@gmail.com', '', 'another comment', '0000-00-00 00:00:00'),
(7, 0, 'Sue', 'suebriquet@gmail.com', '', 'comment', '0000-00-00 00:00:00'),
(8, 0, 'Sue', 'suebriquet@gmail.com', '', 'comment', '0000-00-00 00:00:00'),
(9, 0, 'david', 'sumingfei@gmail.com', '', 'my comment', '0000-00-00 00:00:00'),
(10, 0, 'david', 'sumingfei@gmail.com', '', 'my comment', '0000-00-00 00:00:00'),
(11, 0, 'David', 'sumingfei@gmail.com', '', 'comment11', '2010-10-30 16:07:32'),
(12, 1, 'David', 'sumingfei@gmail.com', '', 'comment11', '2010-10-30 16:07:52'),
(13, 0, 'david', 'sumingfei@gmail.com', '', 'my comment', '0000-00-00 00:00:00'),
(14, 0, 'david', 'sumingfei@gmail.com', '', 'my comment', '2010-10-30 16:09:27'),
(15, 0, 'David SU', 'sumingfei@gmail.com', '', 'new comment here', '2010-10-30 16:10:19'),
(16, 0, 'David SU', 'sumingfei@gmail.com', '', 'new comment here', '2010-10-30 16:10:29'),
(17, 0, 'Sue', 'suebriquet@gmail.com', '', 'something cool must see!!!', '2010-10-30 16:13:30'),
(18, 0, 'Sue', 'suebriquet@gmail.com', '', 'something cool must see!!!', '2010-10-30 16:13:42');
