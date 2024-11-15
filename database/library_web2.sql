-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 15, 2024 at 05:11 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_web2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', 'admin'),
(2, 'super@gmail.com', 'super');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `publication_year` year DEFAULT NULL,
  `available_copies` int DEFAULT '0',
  `genre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `publication_year`, `available_copies`, `genre`) VALUES
(1, 'csci', 'ahmad', '2003', 4, 'ahmad'),
(2, 'math', 'nour', '0000', 11, 'nour');

-- --------------------------------------------------------

--
-- Table structure for table `issued_books`
--

DROP TABLE IF EXISTS `issued_books`;
CREATE TABLE IF NOT EXISTS `issued_books` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `book_id` int NOT NULL,
  `issue_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `return_date` date DEFAULT NULL,
  `returned` tinyint(1) DEFAULT '0',
  `returned_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `book_id` (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `issued_books`
--

INSERT INTO `issued_books` (`id`, `member_id`, `book_id`, `issue_date`, `return_date`, `returned`, `returned_date`) VALUES
(1, 1, 1, '2024-11-15 14:57:15', NULL, 1, '2024-11-15'),
(2, 1, 1, '2024-11-15 14:59:10', '2024-11-22', 1, '2024-11-15'),
(3, 1, 1, '2024-11-15 15:04:08', '2024-11-22', 1, '2024-11-15'),
(4, 1, 1, '2024-11-15 15:05:23', '2024-11-22', 1, '2024-11-15'),
(5, 1, 1, '2024-11-15 15:40:56', '2024-11-22', 1, '2024-11-15'),
(6, 2, 1, '2024-11-15 15:46:14', '2024-11-22', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `magazines`
--

DROP TABLE IF EXISTS `magazines`;
CREATE TABLE IF NOT EXISTS `magazines` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `issue_number` int NOT NULL,
  `publication_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `magazines`
--

INSERT INTO `magazines` (`id`, `title`, `issue_number`, `publication_date`) VALUES
(1, 'maaa', 123, '2024-11-16'),
(2, 'aaa', 111, '2024-11-07');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `join_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `email`, `phone`, `address`, `join_date`) VALUES
(1, 'Ahmad ', 'ahmad@gmail.com', '76976048', 'lebanon', '2024-11-15 14:57:00'),
(2, 'nour', 'nour@gmail.com', 'ra345', 'lebaon', '2024-11-15 15:45:34'),
(3, '', 'superadmin@gmail.com', '', '', '2024-11-15 16:53:17');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
