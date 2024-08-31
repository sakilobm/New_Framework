-- Adminer 4.8.1 MySQL 8.3.0 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `auth`;
CREATE TABLE `auth` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `score` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `email` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `blocked` int NOT NULL DEFAULT '0',
  `active` tinyint NOT NULL DEFAULT '0',
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user',
  `request` enum('pending','accepted','default') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'default',
  `payment_type` enum('default','gpay','paytm','phonepe','bhim') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'default',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `auth` (`id`, `username`, `score`, `phone`, `email`, `password`, `blocked`, `active`, `role`, `request`, `payment_type`) VALUES
(28,	'janusakil',	'3',	'9933338774',	'janusakil@gmail.com',	'$2y$09$njMk0LtdrczolVmWoZYrweWwBKMPWZ3g0LxpdS5MoX4I2xz9xII.2',	0,	1,	'admin',	'pending',	'gpay'),
(30,	'sakiljanani',	'',	'',	'sakiljanani@gmail.com',	'$2y$09$EfDEARYPEh4nURlFLjwQI.rdZuxhHDmkLzfkeeSnIHN0MlupqRj72',	0,	1,	'admin',	'default',	'default'),
(31,	'Sowbharathsb',	'',	'',	'sowbharathsb@gmail.com',	'$2y$09$qyTkX8Qlei4xMI4dZ50UuuoXvwFpjw6UJJW9btmoyqyPkG5D8vsJi',	0,	1,	'admin',	'default',	'default'),
(32,	'thusheecopy@gmail.com',	'',	'',	'thusheecopy@gmail.com',	'$2y$09$5r.Mpru0RB7jPBYa9NxMN.JdtoQkKoa5Bf2BS.RA3DjvghorX4qkm',	0,	1,	'admin',	'default',	'default'),
(34,	'rithik',	'0',	'9933338774',	'rithik@gmail.com',	'$2y$09$lHiPYALFyUW8OP.2H3vSTesCp/62oRsVeKRcO6R5d.VT7FJqyeJ7.',	0,	1,	'user',	'default',	'gpay');

DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` int NOT NULL,
  `token` varchar(32) NOT NULL,
  `login_time` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(23) NOT NULL,
  `user_agent` varchar(256) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `fingerprint` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  CONSTRAINT `session_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `auth` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;