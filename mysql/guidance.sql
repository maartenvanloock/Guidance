-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 02, 2014 at 04:17 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `guidance`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categorie_informatieblok`
--

CREATE TABLE IF NOT EXISTS `tbl_categorie_informatieblok` (
  `categorie_id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`categorie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ervaringen`
--

CREATE TABLE IF NOT EXISTS `tbl_ervaringen` (
  `ervaring_id` int(11) NOT NULL AUTO_INCREMENT,
  `ervaring_title` varchar(150) NOT NULL,
  `ervaring_description` varchar(500) NOT NULL,
  `ervaring_date` date NOT NULL,
  `ervaring_likes` int(11) NOT NULL,
  `ervaring_solved` int(11) NOT NULL,
  `fk_reactie_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_user_name` varchar(50) NOT NULL,
  PRIMARY KEY (`ervaring_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_evenementen`
--

CREATE TABLE IF NOT EXISTS `tbl_evenementen` (
  `evenement_id` int(11) NOT NULL AUTO_INCREMENT,
  `evenement_title` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `evenement_description` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `evenement_name` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `evenement_address` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `evenement_people_going` int(11) NOT NULL,
  `evenement_start` time NOT NULL,
  `evenement_stop` time NOT NULL,
  `evenement_user_going` int(11) NOT NULL,
  PRIMARY KEY (`evenement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_informatieblok`
--

CREATE TABLE IF NOT EXISTS `tbl_informatieblok` (
  `informatieblok_id` int(11) NOT NULL AUTO_INCREMENT,
  `informatieblok_title` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `informatieblok_description` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fk_category_id` int(11) NOT NULL,
  PRIMARY KEY (`informatieblok_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reacties`
--

CREATE TABLE IF NOT EXISTS `tbl_reacties` (
  `reactie_id` int(11) NOT NULL AUTO_INCREMENT,
  `reactie_description` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `reactie_date` date NOT NULL,
  `fk_ervaring_id` int(11) NOT NULL,
  `fk_evenement_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_user_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`reactie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tags`
--

CREATE TABLE IF NOT EXISTS `tbl_tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tags_ervaringen`
--

CREATE TABLE IF NOT EXISTS `tbl_tags_ervaringen` (
  `tags_ervaring_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_ervaring_id` int(11) NOT NULL,
  `fk_tag_id` int(11) NOT NULL,
  PRIMARY KEY (`tags_ervaring_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_profile` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_adm_only` varchar(17) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_privilege` int(1) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
