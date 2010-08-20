CREATE TABLE IF NOT EXISTS `manialib_shouts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datePosted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `login` varchar(25) NOT NULL,
  `nickname` varchar(75) NOT NULL,
  `message` varchar(160) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;