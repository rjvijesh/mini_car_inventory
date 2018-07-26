-- Adminer 4.2.6-dev MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `manufacturer_master_details`;
CREATE TABLE `manufacturer_master_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '1-active, 2-deactive,4-deleted',
  `created_on` datetime NOT NULL,
  `modified_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `model_master_details`;
CREATE TABLE `model_master_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(800) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `color_code` varchar(800) NOT NULL,
  `year` int(11) NOT NULL,
  `files` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1-active,2-deactive,4-delete',
  `created_on` datetime NOT NULL,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2018-07-24 15:58:06
