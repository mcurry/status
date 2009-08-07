CREATE TABLE IF NOT EXISTS `status_consoles` (
  `id` int(11) NOT NULL auto_increment,
  `shell` varchar(50) NOT NULL,
  `args` text NOT NULL,
  `params` text NOT NULL,
  `success` tinyint(1) NOT NULL,
  `output` text NOT NULL,
  `runtime` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`)
);