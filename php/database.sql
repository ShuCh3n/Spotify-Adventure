-- phpMyAdmin SQL Dump
-- version 4.0.9deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 01, 2014 at 06:20 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `prj3_heroes`
--

INSERT INTO `prj3_heroes` (`id`, `user_id`, `name`, `gender`, `level`, `exp`, `gold`, `last_played`) VALUES
(1, 1, 'ShuCh3n', 0, 13, 6892, 3, '2014-04-01 11:39:54'),
(2, 2, 'Bombo', 0, 7, 1651, 0, '2014-03-21 10:17:14'),
(3, 3, 'Grannykin', 0, 0, 95, 0, '2014-03-21 12:29:12');

-- --------------------------------------------------------

--
-- Table structure for table `prj3_heroes_quest`
--

CREATE TABLE IF NOT EXISTS `prj3_heroes_quest` (
  `hero_id` int(11) NOT NULL,
  `quest_id` int(64) NOT NULL,
  `finished` int(1) NOT NULL,
  `completed` int(1) NOT NULL,
  `started` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prj3_heroes_quest`
--

INSERT INTO `prj3_heroes_quest` (`hero_id`, `quest_id`, `finished`, `completed`, `started`) VALUES
(1, 1, 1, 1, '2014-04-01 16:14:59'),
(1, 2, 1, 1, '2014-04-01 16:15:01');

-- --------------------------------------------------------

--
-- Table structure for table `prj3_quests`
--

CREATE TABLE IF NOT EXISTS `prj3_quests` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `level_req` int(64) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `reward_type` int(64) NOT NULL,
  `amount` int(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `prj3_quests`
--

INSERT INTO `prj3_quests` (`id`, `level_req`, `title`, `description`, `reward_type`, `amount`) VALUES
(1, 0, 'First adventure', 'Dear music adventurer, you will go through a great journey by yourself or with friends. But you seem not that fit! Try to reach your first level, I will give you a reward for that. With this reward you can go to market and get you gear up! ', 2, 1),
(2, 1, 'Get RickRolled', 'We are bunch of old wizard and we love to laugh a lot, dont take this personally but get yourself rickrolled HAHAHA. Listen to the song with the following lyrics "Never Gonna Give You Up"', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `prj3_rewards`
--

CREATE TABLE IF NOT EXISTS `prj3_rewards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `prj3_rewards`
--

INSERT INTO `prj3_rewards` (`id`, `name`) VALUES
(1, 'Experience'),
(2, 'Gold'),
(3, 'Item');

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
