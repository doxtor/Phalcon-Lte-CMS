CREATE TABLE IF NOT EXISTS `logger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table for log';

CREATE TABLE `acl` (
  `id` int(11) NOT NULL,
  `controller` char(15) NOT NULL,
  `action` char(15) NOT NULL,
  PRIMARY KEY (`id`,`controller`,`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table for ACL';
