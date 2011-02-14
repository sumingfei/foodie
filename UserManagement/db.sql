CREATE TABLE `memberships` (
   `userid` int(11) not null,
   `roleid` int(11) not null,
   PRIMARY KEY (`userid`,`roleid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `memberships` (`userid`, `roleid`) VALUES ('1', '1');

CREATE TABLE `roles` (
   `id` int(11) not null auto_increment,
   `name` varchar(50) not null,
   `description` char(255),
   PRIMARY KEY (`id`),
   UNIQUE KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=24;

INSERT INTO `roles` (`id`, `name`, `description`) VALUES ('1', 'admin', 'highest user right');

CREATE TABLE `sessions` (
   `id` varchar(255) not null,
   `userid` int(11) not null,
   `started_on` datetime not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `settings` (
   `name` varchar(40) not null,
   `value` varchar(255) not null,
   `description` varchar(255),
   `category` varchar(40) not null,
   PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `settings` (`name`, `value`, `description`, `category`) VALUES ('Application Name', 'Sharp User Management', 'The name of the application', 'Application Settings');
INSERT INTO `settings` (`name`, `value`, `description`, `category`) VALUES ('Expire Session After', '7200', 'Value must be in seconds', 'Application Settings');
INSERT INTO `settings` (`name`, `value`, `description`, `category`) VALUES ('Default User Role', '', 'The role that is automatically assigned to users when they register', 'Application Settings');
INSERT INTO `settings` (`name`, `value`, `description`, `category`) VALUES ('Minimum Password Length', '6', 'Specifies the minimum password length for accounts', 'Application Settings');
INSERT INTO `settings` (`name`, `value`, `description`, `category`) VALUES ('Require Email Activation', 'yes', 'When set to yes, registration will require users to confirm their email address (yes|no)', 'Application Settings');
INSERT INTO `settings` (`name`, `value`, `description`, `category`) VALUES ('Admin Email', 'arman.mirkazemi@gmail.com', 'The email address of site admin', 'Application Settings');
INSERT INTO `settings` (`name`, `value`, `description`, `category`) VALUES ('SMTP Port', '', 'The port number of the SMTP server used for sending emails', 'Email Settings');
INSERT INTO `settings` (`name`, `value`, `description`, `category`) VALUES ('SMTP Host', '', 'The url for the SMTP server used to send emails (eg smtp.domainname.com)', 'Email Settings');
INSERT INTO `settings` (`name`, `value`, `description`, `category`) VALUES ('SMTP Username', '', 'The username for SMTP account used for sending emails', 'Email Settings');
INSERT INTO `settings` (`name`, `value`, `description`, `category`) VALUES ('SMTP Password', '', 'The password for the SMTP account used for sending emails', 'Email Settings');
INSERT INTO `settings` (`name`, `value`, `description`, `category`) VALUES ('Default Paging Size', '20', 'The default number of records to show per page', 'Application Settings');

CREATE TABLE `users` (
   `id` int(11) not null auto_increment,
   `username` varchar(80) not null,
   `password` varchar(255) not null,
   `firstname` varchar(80) not null,
   `lastname` varchar(80) not null,
   `email` varchar(255) not null,
   `confirmed_email` int(1) default '0',
   `registered_on` timestamp not null default CURRENT_TIMESTAMP,
   `disabled` int(1) not null default '1',
   `admin_disabled` int(1) not null default '0',
   PRIMARY KEY (`id`),
   UNIQUE KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=72;

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `email`, `confirmed_email`, `registered_on`, `disabled`, `admin_disabled`) VALUES ('1', 'admin', md5('admin'), 'john', 'smith', '', '', '2010-02-05 01:49:59', '0', '0');