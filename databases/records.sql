-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 31, 2011 at 02:53 PM
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
`article_id` int(11) NOT NULL DEFAULT '0',
`id` int(11) NOT NULL AUTO_INCREMENT,
`page` varchar(255) NOT NULL DEFAULT '',
`username` varchar(255) NOT NULL DEFAULT 'Guest',
`subject` varchar(255) NOT NULL DEFAULT '',
`contact` varchar(255) NOT NULL DEFAULT '',
`comment` text NOT NULL,
`ip` varchar(15) NOT NULL DEFAULT '0',
`date` varchar(255) NOT NULL DEFAULT '',
`time` varchar(11) NOT NULL DEFAULT '',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE IF NOT EXISTS `memberships` (
`userid` int(11) NOT NULL,
`roleid` int(11) NOT NULL,
PRIMARY KEY (`userid`,`roleid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`userid`, `roleid`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `nutrition_history`
--

CREATE TABLE IF NOT EXISTS `nutrition_history` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`food_id` int(11) NOT NULL,
`calorie` int(11) NOT NULL,
`fat` int(11) NOT NULL,
`carb` int(11) NOT NULL,
`protein` int(11) NOT NULL,
`inserttime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `nutrition_history`
--

INSERT INTO `nutrition_history` (`id`, `food_id`, `calorie`, `fat`, `carb`, `protein`, `inserttime`) VALUES
(1, 10000, 32, 24, 55, 67, '2010-10-22 22:13:39'),
(2, 10001, 54, 43, 33, 6, '2010-10-22 22:13:39'),
(3, 10002, 88, 48, 93, 67, '2010-10-22 22:13:39');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE IF NOT EXISTS `restaurant` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(32) NOT NULL,
`street` varchar(40) NOT NULL,
`city` varchar(20) NOT NULL,
`state` varchar(10) NOT NULL,
`phone` varchar(22) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`id`, `name`, `street`, `city`, `state`, `phone`) VALUES
(1, 'My Rest aurant', '45 W University Ave', 'Urbana', 'Illinois', '(425)342-5987');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL,
`description` char(255) DEFAULT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'admin', 'highest user right');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
`id` varchar(255) NOT NULL,
`userid` int(11) NOT NULL,
`started_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `userid`, `started_on`) VALUES
('$1$VD4.4I2.$Pjpzfpqyeix7Bn6R0StTf/', 1, '2010-10-30 13:47:01');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
`name` varchar(40) NOT NULL,
`value` varchar(255) NOT NULL,
`description` varchar(255) DEFAULT NULL,
`category` varchar(40) NOT NULL,
PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`name`, `value`, `description`, `category`) VALUES
('Admin Email', 'arman.mirkazemi@gmail.com', 'The email address of site admin', 'Application Settings'),
('Application Name', 'Sharp User Management', 'The name of the application', 'Application Settings'),
('Default Paging Size', '20', 'The default number of records to show per page', 'Application Settings'),
('Default User Role', '', 'The role that is automatically assigned to users when they register', 'Application Settings'),
('Expire Session After', '7200', 'Value must be in seconds', 'Application Settings'),
('Minimum Password Length', '6', 'Specifies the minimum password length for accounts', 'Application Settings'),
('Require Email Activation', 'yes', 'When set to yes, registration will require users to confirm their email address (yes|no)', 'Application Settings'),
('SMTP Host', '', 'The url for the SMTP server used to send emails (eg smtp.domainname.com)', 'Email Settings'),
('SMTP Password', '', 'The password for the SMTP account used for sending emails', 'Email Settings'),
('SMTP Port', '', 'The port number of the SMTP server used for sending emails', 'Email Settings'),
('SMTP Username', '', 'The username for SMTP account used for sending emails', 'Email Settings');

-- --------------------------------------------------------

--
-- Table structure for table `uiucdorm`
--

CREATE TABLE IF NOT EXISTS `uiucdorm` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(32) NOT NULL,
`calorie` int(11) NOT NULL,
`fat` int(11) NOT NULL,
`carb` int(11) NOT NULL,
`protein` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `uiucdorm`
--

INSERT INTO `uiucdorm` (`id`, `name`, `calorie`, `fat`, `carb`, `protein`) VALUES
(1, 'bbbbbb', 23, 32, 98, 42),
(2, 'aaaaaaaa', 949, 9499, 8773, 41328),
(3, 'aaaa', 32, 24, 55, 67),
(4, 'fwhat', 41324, 34214, 365536, 4325);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`username` varchar(80) NOT NULL,
`password` varchar(255) NOT NULL,
`firstname` varchar(80) NOT NULL,
`lastname` varchar(80) NOT NULL,
`email` varchar(255) NOT NULL,
`confirmed_email` int(1) DEFAULT '0',
`registered_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`disabled` int(1) NOT NULL DEFAULT '1',
`admin_disabled` int(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`),
UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `email`, `confirmed_email`, `registered_on`, `disabled`, `admin_disabled`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Mingfei', 'Su', 'sumingfei@gmail.com', 0, '2010-02-05 01:49:59', 0, 0);