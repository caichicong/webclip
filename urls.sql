CREATE DATABASE webhtml;
USE webhtml;

CREATE TABLE IF NOT EXISTS `urls` (
  `url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE USER 'webhtml'@'localhost' IDENTIFIED BY '123456';

GRANT USAGE ON * . * TO 'webhtml'@'localhost' IDENTIFIED BY '123456' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;

GRANT ALL PRIVILEGES ON `webhtml` . * TO 'webhtml'@'localhost';