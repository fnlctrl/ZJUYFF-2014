-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014-05-04 17:52:39
-- 服务器版本: 5.5.37-0ubuntu0.14.04.1
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `poster_member`
--

CREATE TABLE IF NOT EXISTS `poster_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `leader` tinyint(1) NOT NULL,
  `stuid` varchar(32) NOT NULL,
  `contact` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`),
  KEY `name` (`name`),
  KEY `leader` (`leader`),
  KEY `stuid` (`stuid`),
  KEY `contact` (`contact`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- 表的结构 `poster_signup`
--

CREATE TABLE IF NOT EXISTS `poster_signup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `members` int(11) NOT NULL,
  `pictype1` int(11) NOT NULL COMMENT '图片格式',
  `suffix1` varchar(8) NOT NULL,
  `pictype2` int(11) NOT NULL,
  `suffix2` varchar(8) NOT NULL,
  `introduction` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `members` (`members`),
  KEY `time` (`time`),
  KEY `ip` (`ip`),
  KEY `introduction` (`introduction`),
  KEY `hash` (`hash`),
  KEY `hash_2` (`hash`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- 表的结构 `poster_vote`
--

CREATE TABLE IF NOT EXISTS `poster_vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `slug` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `votes` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`,`name`,`votes`,`score`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=131 ;

-- --------------------------------------------------------

--
-- 表的结构 `poster_vote_log`
--

CREATE TABLE IF NOT EXISTS `poster_vote_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `stuid` varchar(32) NOT NULL,
  `act` mediumtext NOT NULL,
  `ip` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`),
  KEY `username` (`username`),
  KEY `pid` (`pid`),
  KEY `ip` (`ip`),
  KEY `username_2` (`username`),
  KEY `stuid` (`stuid`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

