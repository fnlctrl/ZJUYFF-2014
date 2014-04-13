-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014-04-13 08:25:57
-- 服务器版本: 5.5.35-1ubuntu1
-- PHP 版本: 5.5.9-1ubuntu4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- 数据库: `film`
--

-- --------------------------------------------------------

--
-- 表的结构 `dub_team`
--

CREATE TABLE IF NOT EXISTS `dub_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(255) NOT NULL,
  `slogan` varchar(255) NOT NULL,
  `method` varchar(16) NOT NULL,
  `members` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`team_name`),
  KEY `signature` (`slogan`),
  KEY `type` (`method`),
  KEY `members` (`members`),
  KEY `time` (`time`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- 表的结构 `dub_teammate`
--

CREATE TABLE IF NOT EXISTS `dub_teammate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `leader` tinyint(1) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`),
  KEY `name` (`name`),
  KEY `leader` (`leader`),
  KEY `phone` (`phone`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

