-- phpMyAdmin SQL Dump
-- version 2.11.11.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 11-01-2011 a las 23:58:47
-- Versión del servidor: 5.0.84
-- Versión de PHP: 5.2.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `layarizar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Action`
--

DROP TABLE IF EXISTS `Action`;
CREATE TABLE IF NOT EXISTS `Action` (
  `id` int(11) NOT NULL auto_increment,
  `uri` varchar(1024) default NULL,
  `label` varchar(255) default NULL,
  `poiId` int(11) default NULL,
  `contentType` varchar(255) default NULL,
  `method` varchar(50) default NULL,
  `activityType` int(11) default NULL,
  `params` varchar(1024) default NULL,
  `closeBiw` tinyint(1) default '0',
  `showActivity` tinyint(1) default '1',
  `activityMessage` varchar(255) default NULL,
  `autoTriggerRange` int(11) default NULL,
  `autoTriggerOnly` tinyint(1) default '0',
  PRIMARY KEY  (`id`),
  KEY `poiId` (`poiId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Layer`
--

DROP TABLE IF EXISTS `Layer`;
CREATE TABLE IF NOT EXISTS `Layer` (
  `layer` varchar(255) default NULL,
  `refreshInterval` int(11) default '300',
  `refreshDistance` int(11) default '100',
  `fullRefresh` tinyint(1) default '1',
  `showMessage` varchar(1024) default NULL,
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Object`
--

DROP TABLE IF EXISTS `Object`;
CREATE TABLE IF NOT EXISTS `Object` (
  `poiID` int(11) NOT NULL,
  `baseURL` varchar(1000) default NULL,
  `full` varchar(255) default NULL,
  `reduced` varchar(255) default NULL,
  `icon` varchar(255) default NULL,
  `size` int(11) default NULL,
  PRIMARY KEY  (`poiID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `POI`
--

DROP TABLE IF EXISTS `POI`;
CREATE TABLE IF NOT EXISTS `POI` (
  `id` int(11) NOT NULL auto_increment,
  `attribution` varchar(255) default NULL,
  `imageURL` varchar(1024) default NULL,
  `lat` double default NULL,
  `lon` double default NULL,
  `line2` varchar(255) default NULL,
  `line3` varchar(255) default NULL,
  `line4` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `type` varchar(255) default NULL,
  `doNotIndex` tinyint(1) default '0',
  `showSmallBiw` tinyint(1) default '1',
  `showBiwOnClick` tinyint(1) default '1',
  `layerID` int(11) default NULL,
  `dimension` int(11) default NULL,
  `alt` int(11) default NULL,
  `relativeAlt` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=971471 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Transform`
--

DROP TABLE IF EXISTS `Transform`;
CREATE TABLE IF NOT EXISTS `Transform` (
  `angle` int(11) default NULL,
  `rel` tinyint(1) default NULL,
  `scale` float default NULL,
  `poiID` int(11) NOT NULL,
  PRIMARY KEY  (`poiID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `User`
--

DROP TABLE IF EXISTS `User`;
CREATE TABLE IF NOT EXISTS `User` (
  `id` varchar(64) collate utf8_unicode_ci NOT NULL default '' COMMENT 'value of auth cookie for Layar app',
  `layar_uid` varchar(64) collate utf8_unicode_ci default NULL COMMENT 'Unique phone ID, optional',
  `app_uid` int(10) unsigned default NULL COMMENT 'Native app user ID',
  `app_user_name` varchar(64) collate utf8_unicode_ci default NULL COMMENT 'Native app user name',
  `oauth_token` varchar(64) collate utf8_unicode_ci default NULL,
  `oauth_token_secret` varchar(64) collate utf8_unicode_ci default NULL,
  `updated` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `app_uid` (`app_uid`),
  KEY `layar_uid` (`layar_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores oAuth tokens and basic user data';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `group_id` int(11) NOT NULL,
  `email` varchar(40) default NULL,
  `created` datetime default NULL,
  `loginProvider` varchar(64) NOT NULL,
  `gigya_uid` varchar(950) NOT NULL,
  `photo` varchar(400) default NULL,
  `profile` varchar(300) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `Action`
--
ALTER TABLE `Action`
  ADD CONSTRAINT `Action_ibfk_1` FOREIGN KEY (`poiId`) REFERENCES `POI` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
