-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 07 月 22 日 11:15
-- 服务器版本: 5.1.63
-- PHP 版本: 5.2.17p1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `fanxin`
--

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `hxid` bigint(20) NOT NULL AUTO_INCREMENT,
  `fxid` text NOT NULL,
  `avatar` text NOT NULL,
  `nick` text NOT NULL,
  `sex` text NOT NULL,
  `region` text NOT NULL,
  `sign` text NOT NULL,
  `time` datetime NOT NULL,
  `tel` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`hxid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11230942 ;
