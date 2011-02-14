CREATE DATABASE IF NOT EXISTS login;

USE login;

CREATE TABLE IF NOT EXISTS `login` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `login` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');