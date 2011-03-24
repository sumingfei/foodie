

CREATE TABLE IF NOT EXISTS `user_profile` (
  `prof_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `prof_bdate` date NOT NULL,
  `prof_sex` varchar(255) NOT NULL,
  `prof_bio` longtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`prof_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`prof_id`, `user_id`, `prof_bdate`, `prof_sex`, `prof_bio`, `timestamp`) VALUES
(19, 1, '1987-12-18', 'male', 'Hi I am a college student studying accounting. I like running and cooking.', '2011-02-26 15:22:28'),
(20, 2, '1992-05-21', 'female', 'Hey everyone, I am a college student studying animal science. My hobbies include watching Glee, and playing basketball. I like eating gandolas', '2011-02-26 15:22:28');
