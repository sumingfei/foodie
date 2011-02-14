-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 31, 2011 at 03:07 PM

-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `temp`

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
(1, 1),
(5, 2),
(6, 2),
(7, 2);


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;


--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'admin', 'highest user right'),
(2, 'user', 'normal user'),
(3, 'restaurant_owner', 'owner of restaurant'),
(4, 'gym_owner', 'owner of a gym');


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
('$1$BZ5.0k2.$r/lbdxA.9QBEujCUuwCRb/', 1, '2010-11-12 18:11:51'),
('$1$HY0.ER5.$dv4xkTTvh6gYrVfiEUJSX/', 1, '2010-11-12 18:16:35'),
('$1$A14.Jw..$Zgp5njtxBdKi2pprq574D0', 1, '2010-11-13 13:28:32'),
('$1$Vr5.4Q3.$MPXu9vWRs2IGEDCRGbK.21', 1, '2011-01-31 08:58:18');


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
('Admin Email', 'sumingfei@gmail.com', 'The email address of site admin', 'Application Settings'),
('Application Name', 'Foodie', 'The name of the application', 'Application Settings'),

('Default Paging Size', '20', 'The default number of records to show per page', 'Application Settings'),
('Default User Role', 'user', 'The role that is automatically assigned to users when they register', 'Application Settings'),

('Expire Session After', '7200', 'Value must be in seconds', 'Application Settings'),
('Minimum Password Length', '6', 'Specifies the minimum password length for accounts', 'Application Settings'),
('Require Email Activation', 'yes', 'When set to yes, registration will require users to confirm their email address (yes|no)', 'Application Settings'),
('SMTP Host', 'smtp.gmail.com', 'The url for the SMTP server used to send emails (eg smtp.domainname.com)', 'Email Settings'),
('SMTP Password', 'sumingfei@gmail.com', 'The password for the SMTP account used for sending emails', 'Email Settings'),
('SMTP Port', '465', 'The port number of the SMTP server used for sending emails', 'Email Settings'),
('SMTP Username', '831221113', 'The username for SMTP account used for sending emails', 'Email Settings');


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;


--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `email`, `confirmed_email`, `registered_on`, `disabled`, `admin_disabled`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'john', 'smith', '', 0, '2010-02-05 01:49:59', 0, 0),
(5, 'testuser', '5d9c68c6c50ed3d02a2fcf54f63993b6', 'david', 'su', 'sumingfei@gmail.com', 0, '2010-10-30 15:31:24', 0, 0),
(6, 'testuser2', '58dd024d49e1d1b83a5d307f09f32734', 'david', 'su', 'sumingfei@gmail.com', 0, '2010-10-30 15:33:40', 1, 0),
(7, 'testuser3', '1e4332f65a7a921075fbfb92c7c60cce', 'dfs', 'fads', 'sumingfei@gmail.com', 0, '2010-10-30 15:36:42', 1, 0);