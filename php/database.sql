-- phpMyAdmin SQL Dump
-- version 4.0.9deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 30, 2014 at 02:25 PM
-- Server version: 5.5.33-1
-- PHP Version: 5.4.4-14+deb7u5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `0876292`
--

-- --------------------------------------------------------

--
-- Table structure for table `prj3_heroes`
--

CREATE TABLE IF NOT EXISTS `prj3_heroes` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(64) NOT NULL,
  `name` varchar(128) NOT NULL,
  `gender` int(1) NOT NULL,
  `level` int(64) NOT NULL,
  `exp` int(64) NOT NULL,
  `gold` bigint(64) NOT NULL,
  `last_played` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `prj3_heroes`
--

INSERT INTO `prj3_heroes` (`id`, `user_id`, `name`, `gender`, `level`, `exp`, `gold`, `last_played`) VALUES
(1, 1, 'ShuCh3n', 0, 8, 2329, 0, '2014-03-27 23:37:41'),
(2, 2, 'Bombo', 0, 7, 1651, 0, '2014-03-21 10:17:14'),
(4, 3, 'Grannykin', 0, 0, 95, 0, '2014-03-21 12:29:12'),
(6, 2, 'shu', 0, 0, 2, 0, '2014-03-28 12:15:21');

-- --------------------------------------------------------

--
-- Table structure for table `prj3_heroes_quest`
--

CREATE TABLE IF NOT EXISTS `prj3_heroes_quest` (
  `hero_id` int(11) NOT NULL,
  `quest_id` int(64) NOT NULL,
  `completed` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prj3_heroes_quest`
--

INSERT INTO `prj3_heroes_quest` (`hero_id`, `quest_id`, `completed`) VALUES
(1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `prj3_quests`
--

CREATE TABLE IF NOT EXISTS `prj3_quests` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `level_req` int(64) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `prj3_quests`
--

INSERT INTO `prj3_quests` (`id`, `level_req`, `title`, `description`) VALUES
(1, 0, '', 'Enter mordor...'),
(2, 90, '', 'Listen to the song with the following lyrics "Never Gonna Give You Up"');

-- --------------------------------------------------------

--
-- Table structure for table `prj3_spotify_users`
--

CREATE TABLE IF NOT EXISTS `prj3_spotify_users` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `spotify_user` varchar(128) NOT NULL,
  `date_joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `prj3_spotify_users`
--

INSERT INTO `prj3_spotify_users` (`id`, `spotify_user`, `date_joined`) VALUES
(1, 'Shu Chen', '2014-03-21 10:15:33'),
(2, 'ziryf', '2014-03-21 10:17:14'),
(3, 'ninetydrops', '2014-03-21 12:29:12');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
