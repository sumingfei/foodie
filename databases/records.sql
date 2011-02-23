-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 19, 2011 at 10:47 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `records`
--

-- --------------------------------------------------------

--
-- Table structure for table `bb_forums`
--

CREATE TABLE IF NOT EXISTS `bb_forums` (
  `forum_id` int(10) NOT NULL AUTO_INCREMENT,
  `forum_name` varchar(150) NOT NULL DEFAULT '',
  `forum_slug` varchar(255) NOT NULL DEFAULT '',
  `forum_desc` text NOT NULL,
  `forum_parent` int(10) NOT NULL DEFAULT '0',
  `forum_order` int(10) NOT NULL DEFAULT '0',
  `topics` bigint(20) NOT NULL DEFAULT '0',
  `posts` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`forum_id`),
  KEY `forum_slug` (`forum_slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bb_forums`
--

INSERT INTO `bb_forums` (`forum_id`, `forum_name`, `forum_slug`, `forum_desc`, `forum_parent`, `forum_order`, `topics`, `posts`) VALUES
(1, 'General', 'general', '', 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bb_meta`
--

CREATE TABLE IF NOT EXISTS `bb_meta` (
  `meta_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `object_type` varchar(16) NOT NULL DEFAULT 'bb_option',
  `object_id` bigint(20) NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `object_type__meta_key` (`object_type`,`meta_key`),
  KEY `object_type__object_id__meta_key` (`object_type`,`object_id`,`meta_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `bb_meta`
--

INSERT INTO `bb_meta` (`meta_id`, `object_type`, `object_id`, `meta_key`, `meta_value`) VALUES
(1, 'bb_option', 0, 'bb_db_version', '2078'),
(2, 'bb_option', 0, 'name', 'Foodie'),
(3, 'bb_option', 0, 'uri', 'http://localhost/forums/'),
(4, 'bb_option', 0, 'from_email', 'suefeng2@gmail.com'),
(5, 'bb_option', 0, '_transient_bp_bbpress_random_seed', '4fc439364fc74f45e2e1160f4cd285e4'),
(6, 'bb_option', 0, 'description', 'Food and Fitness Awareness'),
(7, 'bb_topic', 1, 'voices_count', '1'),
(8, 'bb_option', 0, 'bb_auth_salt', 'Wpu)IZQ5@6z#'),
(9, 'bb_option', 0, 'bb_logged_in_salt', 'BSSm@%UZkrS4'),
(10, 'bb_option', 0, 'bb_nonce_salt', 'E%#CCjxwpuI0'),
(11, 'bb_option', 0, 'bb_active_theme', 'user#foodie'),
(12, 'bb_option', 0, 'timezone_string', 'America/Chicago'),
(13, 'bb_option', 0, 'datetime_format', 'F j, Y - h:i A'),
(14, 'bb_option', 0, 'date_format', 'F j, Y'),
(15, 'bb_option', 0, 'mod_rewrite', 'slugs'),
(16, 'bb_option', 0, 'mod_rewrite_writable', '1'),
(17, 'bb_option', 0, 'avatars_show', '1'),
(18, 'bb_option', 0, 'avatars_rating', 'g'),
(19, 'bb_option', 0, 'avatars_default', 'wavatar');

-- --------------------------------------------------------

--
-- Table structure for table `bb_posts`
--

CREATE TABLE IF NOT EXISTS `bb_posts` (
  `post_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `forum_id` int(10) NOT NULL DEFAULT '1',
  `topic_id` bigint(20) NOT NULL DEFAULT '1',
  `poster_id` int(10) NOT NULL DEFAULT '0',
  `post_text` text NOT NULL,
  `post_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `poster_ip` varchar(15) NOT NULL DEFAULT '',
  `post_status` tinyint(1) NOT NULL DEFAULT '0',
  `post_position` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`),
  KEY `topic_time` (`topic_id`,`post_time`),
  KEY `poster_time` (`poster_id`,`post_time`),
  KEY `post_time` (`post_time`),
  FULLTEXT KEY `post_text` (`post_text`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bb_posts`
--

INSERT INTO `bb_posts` (`post_id`, `forum_id`, `topic_id`, `poster_id`, `post_text`, `post_time`, `poster_ip`, `post_status`, `post_position`) VALUES
(1, 1, 1, 1, '<p>First Post!  w00t.\n</p>\n', '2011-02-19 19:31:54', '127.0.0.1', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bb_terms`
--

CREATE TABLE IF NOT EXISTS `bb_terms` (
  `term_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bb_terms`
--

INSERT INTO `bb_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'bbPress', 'bbpress', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bb_term_relationships`
--

CREATE TABLE IF NOT EXISTS `bb_term_relationships` (
  `object_id` bigint(20) NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) NOT NULL DEFAULT '0',
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bb_term_relationships`
--

INSERT INTO `bb_term_relationships` (`object_id`, `term_taxonomy_id`, `user_id`, `term_order`) VALUES
(1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bb_term_taxonomy`
--

CREATE TABLE IF NOT EXISTS `bb_term_taxonomy` (
  `term_taxonomy_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bb_term_taxonomy`
--

INSERT INTO `bb_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'bb_topic_tag', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bb_topics`
--

CREATE TABLE IF NOT EXISTS `bb_topics` (
  `topic_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `topic_title` varchar(100) NOT NULL DEFAULT '',
  `topic_slug` varchar(255) NOT NULL DEFAULT '',
  `topic_poster` bigint(20) NOT NULL DEFAULT '0',
  `topic_poster_name` varchar(40) NOT NULL DEFAULT 'Anonymous',
  `topic_last_poster` bigint(20) NOT NULL DEFAULT '0',
  `topic_last_poster_name` varchar(40) NOT NULL DEFAULT '',
  `topic_start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `topic_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `forum_id` int(10) NOT NULL DEFAULT '1',
  `topic_status` tinyint(1) NOT NULL DEFAULT '0',
  `topic_open` tinyint(1) NOT NULL DEFAULT '1',
  `topic_last_post_id` bigint(20) NOT NULL DEFAULT '1',
  `topic_sticky` tinyint(1) NOT NULL DEFAULT '0',
  `topic_posts` bigint(20) NOT NULL DEFAULT '0',
  `tag_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`topic_id`),
  KEY `topic_slug` (`topic_slug`),
  KEY `forum_time` (`forum_id`,`topic_time`),
  KEY `user_start_time` (`topic_poster`,`topic_start_time`),
  KEY `stickies` (`topic_status`,`topic_sticky`,`topic_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bb_topics`
--

INSERT INTO `bb_topics` (`topic_id`, `topic_title`, `topic_slug`, `topic_poster`, `topic_poster_name`, `topic_last_poster`, `topic_last_poster_name`, `topic_start_time`, `topic_time`, `forum_id`, `topic_status`, `topic_open`, `topic_last_post_id`, `topic_sticky`, `topic_posts`, `tag_count`) VALUES
(1, 'Your first topic', 'your-first-topic', 1, 'admin', 1, 'admin', '2011-02-19 19:31:54', '2011-02-19 19:31:54', 1, 0, 1, 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bb_usermeta`
--

CREATE TABLE IF NOT EXISTS `bb_usermeta` (
  `umeta_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bb_usermeta`
--

INSERT INTO `bb_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'bb_capabilities', 'a:1:{s:9:"keymaster";b:1;}'),
(2, 1, 'bb_topics_replied', '1');

-- --------------------------------------------------------

--
-- Table structure for table `bb_users`
--

CREATE TABLE IF NOT EXISTS `bb_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `user_login` (`user_login`),
  UNIQUE KEY `user_nicename` (`user_nicename`),
  KEY `user_registered` (`user_registered`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bb_users`
--

INSERT INTO `bb_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_status`, `display_name`) VALUES
(1, 'admin', '$P$BqmXw0DGdRcLNUC/lrdWd8D9Qy/5qT.', 'admin', 'suefeng2@gmail.com', '', '2011-02-19 19:31:54', 0, 'admin');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `nutrition_history`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `uiucdorm`
--

INSERT INTO `uiucdorm` (`id`, `name`, `calorie`, `fat`, `carb`, `protein`) VALUES
(1, 'aaaa', 32, 24, 55, 67);

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
