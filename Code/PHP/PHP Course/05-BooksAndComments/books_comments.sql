-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Време на генериране: 15:33
-- Версия на сървъра: 5.5.16
-- Версия на PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данни: `books_comments`
--
CREATE DATABASE `books_comments` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `books_comments`;

-- --------------------------------------------------------

--
-- Структура на таблица `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `author_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_name` varchar(250) NOT NULL,
  PRIMARY KEY (`author_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Схема на данните от таблица `authors`
--

INSERT INTO `authors` (`author_id`, `author_name`) VALUES
(8, 'Ангел Каралийчев'),
(7, 'Христо Ботев'),
(6, 'Иван Вазов'),
(9, 'Димитър Димов'),
(10, 'Елин Пелин');

-- --------------------------------------------------------

--
-- Структура на таблица `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_title` varchar(250) NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Схема на данните от таблица `books`
--

INSERT INTO `books` (`book_id`, `book_title`) VALUES
(16, 'Произведения от български автори'),
(14, 'Тютюн'),
(15, 'Ян Бибиян'),
(13, 'Ането и разкази'),
(12, 'Стихосбирка'),
(11, 'Под игото');

-- --------------------------------------------------------

--
-- Структура на таблица `books_authors`
--

CREATE TABLE IF NOT EXISTS `books_authors` (
  `book_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  KEY `book_id` (`book_id`),
  KEY `author_id` (`author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `books_authors`
--

INSERT INTO `books_authors` (`book_id`, `author_id`) VALUES
(16, 9),
(16, 6),
(16, 7),
(16, 8),
(15, 10),
(14, 9),
(13, 8),
(12, 6),
(12, 7),
(11, 6),
(16, 10);

-- --------------------------------------------------------

--
-- Структура на таблица `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `datetime` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Схема на данните от таблица `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `comment`, `datetime`, `book_id`) VALUES
(19, 3, 'Страхотна книга!', 1382368426, 11),
(20, 4, 'Много ми хареса! Четох я три пъти!', 1382358500, 15),
(21, 4, 'Всички публикувани произведения са  много хубави! Наистина чудесна книга, заслужава си всеки да я прочете.', 1382358553, 16),
(22, 3, 'Всеки българин трябва да я прочете поне веднъж!', 1382358629, 11),
(23, 3, 'И аз мисля така.', 1382358646, 16);

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(4, 'john', 'qwerty'),
(3, 'user', 'qwerty');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
