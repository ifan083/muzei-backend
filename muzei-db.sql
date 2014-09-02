-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2014 at 01:19 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `muzei-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE IF NOT EXISTS `achievements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `criteria` int(11) NOT NULL,
  `continuous` tinyint(1) NOT NULL,
  `category` int(11) DEFAULT NULL,
  `difficulty` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id`, `name`, `description`, `criteria`, `continuous`, `category`, `difficulty`) VALUES
(1, 'first completed mission', 'complete any mission', 3, 0, 0, 0),
(2, 'completed partizan mission dificulty 1', 'number of completed partizan missions with difficulty 1', 2, 1, 5, 1),
(3, 'unlocked all difficulty 1 artifacts', 'find all difficulty 1 artifacts', 1, 0, 0, 0),
(4, 'unlocked all difficulty 2 artifacts', 'find all difficulty 2 artifacts', 1, 0, 0, 0),
(5, 'unlocked all difficulty 3 artifacts', 'find all difficulty 3 artifacts', 1, 0, 0, 0),
(7, 'unlocked all difficulty 1 partizan artifacts', 'find all difficulty 1 partizan artifacts', 1, 0, 5, 1),
(8, 'completed partizan mission difficulty 2', 'number of completed partizan missions with difficulty 2', 2, 1, 5, 2),
(9, 'unlocked all difficulty 2 partizan artifacts', 'find all difficulty 2 partizan artifacts', 1, 0, 5, 2),
(10, 'completed partizan mission difficulty 3', 'number of completed partizan missions with difficulty 3', 2, 1, 5, 3),
(11, 'unlocked all difficulty 3 partizan artifacts', 'find all difficulty 3 partizan missions', 1, 0, 5, 3),
(12, 'unlocked all difficulty 4 artifacts', 'find all difficulty 4 artifacts', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `artifacts`
--

CREATE TABLE IF NOT EXISTS `artifacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1500) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `difficulty` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `location` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `artifacts`
--

INSERT INTO `artifacts` (`id`, `name`, `description`, `picture`, `difficulty`, `category`, `location`) VALUES
(3, 'pitu guli', 'toj so karpata', 'images/images.jpg', 1, 7, 9),
(5, 'leonidas', 'caro negotinski', 'images/300_spartans_by_lukarley-d5rcq7r.jpg', 4, 8, 18),
(8, 'kristofer', 'aka kolumbo', 'images/christopher-columbus.jpg', 4, 9, NULL),
(14, 'mirko2', 'chetnik srpski', 'images/serbian_chetnik_soldier.jpg', 2, 5, 16),
(15, 'partizan artifact 1', 'participant in ilinden', 'images/mirko-i-slavko.jpg', 1, 5, 10),
(16, 'partizan artifact 2', 'participant in ilinden', 'images/mirko-i-slavko.jpg', 1, 5, 17),
(17, 'partizan artifact 3', 'participant in ilinden', 'images/mirko-i-slavko.jpg', 1, 5, NULL),
(20, 'partizan artifact 6', 'participant in ilinden', 'images/serbian_chetnik_soldier.jpg', 2, 5, NULL),
(21, 'partizan artifact 4', 'participant in ilinden', 'images/serbian_chetnik_soldier.jpg', 1, 5, 14);

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE IF NOT EXISTS `characters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `picture_filename` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `mapper` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`id`, `name`, `category`, `picture_filename`, `mapper`) VALUES
(5, 'mirko', 'partizani', 'images/images.jpg', 0),
(7, 'slavko', 'komiti', 'images/komita1.jpg', 0),
(8, 'alekso', 'spartanci', 'images/Image-ready-CS-2-icon.png', 0),
(9, 'vespuci', 'mappers', 'images/artifact-aztec.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `criterias`
--

CREATE TABLE IF NOT EXISTS `criterias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `criterias`
--

INSERT INTO `criterias` (`id`, `name`) VALUES
(1, 'check artifacts'),
(2, 'completed mission by category and difficulty'),
(3, 'first mission ever');

-- --------------------------------------------------------

--
-- Table structure for table `floors`
--

CREATE TABLE IF NOT EXISTS `floors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `picture` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `isdefault` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `floors`
--

INSERT INTO `floors` (`id`, `name`, `level`, `picture`, `isdefault`) VALUES
(2, 'first floor', 1, 'images/scm_first.png', 1),
(3, 'second floor', 2, 'images/scm_second.png', 0),
(4, 'third floor', 3, 'images/scm_third.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floor` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `xpercent` float NOT NULL,
  `ypercent` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `floor`, `xpercent`, `ypercent`) VALUES
(9, '2', 0.781034, 0.758182),
(10, '2', 0.781034, 0.758182),
(14, '2', 0.367241, 0.794545),
(16, '2', 0.324138, 0.645455),
(17, '2', 0.110345, 0.307273),
(18, '2', 0.0948276, 0.609091);

-- --------------------------------------------------------

--
-- Table structure for table `update`
--

CREATE TABLE IF NOT EXISTS `update` (
  `version` int(11) NOT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `update`
--

INSERT INTO `update` (`version`, `status`, `date`) VALUES
(2, '\n				  status ok				 \n					', '2014-08-26 13:07:25');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
