-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 09, 2013 at 11:17 PM
-- Server version: 5.5.32-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `messages`
--
CREATE DATABASE `messages` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `messages`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `picture` varchar(70) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `picture`) VALUES
(1, 'Спорт', 'glyphicons_329_soccer_ball.png'),
(2, 'Мода', 'glyphicons_381_coat_hanger.png'),
(3, 'Животни', 'glyphicons_002_dog.png'),
(4, 'Книги', 'glyphicons_351_book_open.png'),
(5, 'Забавления', 'glyphicons_000_glass.png'),
(6, 'Музика', 'glyphicons_017_music.png');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `date_when_added` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `body` varchar(250) NOT NULL,
  `user` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `date_when_added`, `title`, `body`, `user`, `category`) VALUES
(1, 1381301052, 'Среща между Левски и ЦСКА', 'На 20.10.2013 г. ще се проведе контролна среща между Левски и ЦСКА.', 'admin', '1'),
(2, 1381301123, 'Модерни панталони', 'В магазин Претенция ще има намаление на панталони.', 'admin', '2'),
(3, 1381301284, 'Състезание по художествена гимнастика', 'Очаквайте на 30.11.2013 г. Международния турнир по художествена гимнастика &quot;Руми и Албена.&quot;', 'Johnny', '1'),
(4, 1381301362, 'Подарявам куче', 'Подарявам немска овчарка на 3 месеца.', 'Johnny', '3'),
(5, 1381301524, 'Търся книга', 'Търся книгата &quot;Клетниците&quot; на Виктор Юго. Моля, ако някой я има, да се свърже с мен.', 'Sarah', '4'),
(6, 1381301742, 'Организираме дискотека', 'На 15.11.2013 г. организираме събиране  - от 22:00 часа.', 'Benny', '5'),
(7, 1381301796, 'Волейболен мач', 'Всеки, който обича волейбола, да заповяда утре от 17:00 ч. в НСА - ще се проведе интересен мач.', 'Benny', '1'),
(8, 1381302117, 'Предлагам уроци по пиано', 'Предлагам изгодни уроци по пиано. За контакт - телефон 0888 888 888.', 'Katherin', '6');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(50) NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `gender`, `role`) VALUES
(3, 'Johnny', 'johnny@john.com', 'qwerty', 0, 1),
(2, 'admin', 'admin@admin.com', 'admin', 0, 2),
(4, 'Sarah', 'sara@sara.com', 'qwerty', 1, 1),
(5, 'Benny', 'benny@benny.com', 'qwerty', 0, 0),
(6, 'Katherin', 'katherin@kathy.com', 'qwerty', 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
