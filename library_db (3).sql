-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 01, 2025 at 04:18 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(150) DEFAULT NULL,
  `publisher` varchar(150) DEFAULT NULL,
  `year` int DEFAULT NULL,
  `copies` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `year`, `copies`) VALUES
(1, 'Democracy and Education', 'John Dewey', 'Columbia University Press', 1916, 0),
(2, 'Brave New World', 'Aldous Huxley', 'Harper &Brothers', 1932, 0),
(3, 'Madolduwa', 'Martin Wickramasindga', 'ABC', 2005, 1),
(4, 'Gamperaliya', 'Martin Wickramasindga', 'Sarasa Publishers', 1944, 30),
(5, 'Kaluyugaya', 'Martin Wickramasindga', 'Sarasa Publishers', 1957, 20),
(6, 'Ape gama', 'Martin Wickramasindga', 'Sarasa Publishers', 1940, 15),
(7, 'Harry Potter and the Philosopher\'s Stone', 'J. K. Rowling', 'Bloomsbury Publishing', 1999, 12),
(8, 'Harry Potter and the Sorcerer\'s Stone', 'J. K. Rowling', 'Bloomsbury Publishing', 1997, 8),
(9, 'Harry Potter and the Chamber of Secrets', 'J. K. Rowling', 'Bloomsbury Publishing', 1998, 8),
(10, 'Harry Potter and the Goblet of Fire', 'J. K. Rowling', 'Bloomsbury Publishing', 2000, 15),
(11, 'Harry Potter and the Order of the Phoenix', 'J. K. Rowling', 'Bloomsbury Publishing', 2003, 18),
(12, 'Harry Potter and the Half-Blood Prince', 'J. K. Rowling', 'Bloomsbury Publishing', 2005, 16);

-- --------------------------------------------------------

--
-- Table structure for table `borrow_history`
--

DROP TABLE IF EXISTS `borrow_history`;
CREATE TABLE IF NOT EXISTS `borrow_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `borrow_date` datetime NOT NULL,
  `return_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `borrow_history`
--

INSERT INTO `borrow_history` (`id`, `user_id`, `book_id`, `borrow_date`, `return_date`) VALUES
(1, 5, 3, '2025-08-14 12:33:33', '2025-08-25 19:17:20'),
(2, 0, 3, '2025-08-17 19:25:01', '0000-00-00 00:00:00'),
(3, 0, 3, '2025-08-17 19:26:47', '0000-00-00 00:00:00'),
(4, 0, 3, '2025-08-17 19:28:47', '0000-00-00 00:00:00'),
(5, 5, 3, '2025-08-17 19:29:20', '2025-08-17 19:43:26'),
(6, 3, 3, '2025-08-18 00:53:16', '0000-00-00 00:00:00'),
(7, 3, 9, '2025-08-26 01:56:35', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Rashini Dilmini', 'rashini2006@gmail.com', 'hii', '2025-08-17 19:06:57'),
(2, 'Kaveesha', 'kaveesh2000@gmail.com', 'welcome', '2025-08-17 19:07:21'),
(3, 'Rashini Dilmini', 'rashini2006@gmail.com', 'Hii', '2025-08-17 19:31:37');

-- --------------------------------------------------------

--
-- Table structure for table `fines`
--

DROP TABLE IF EXISTS `fines`;
CREATE TABLE IF NOT EXISTS `fines` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text,
  `paid` tinyint(1) DEFAULT '0',
  `date_assessed` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fines`
--

INSERT INTO `fines` (`id`, `user_id`, `amount`, `description`, `paid`, `date_assessed`) VALUES
(1, 5, 100.00, 'fine', 0, '2025-08-14 12:23:18'),
(2, 3, 150.00, 'fine', 0, '2025-08-25 17:11:02');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('pending','paid','failed') DEFAULT 'paid',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `amount`, `payment_date`, `description`, `status`) VALUES
(1, 3, 500.00, '2025-08-12 20:04:47', 'book', 'paid'),
(2, 3, 500.00, '2025-08-12 22:43:09', 'Book', 'paid'),
(4, 5, 100.00, '2025-08-14 12:24:56', 'fine', 'paid'),
(5, 5, 100.00, '2025-08-18 00:56:26', 'fine', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `issue_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('issued','returned','overdue') DEFAULT 'issued',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `book_id`, `issue_date`, `return_date`, `status`, `created_at`) VALUES
(1, 5, 3, '2025-08-17', '2025-08-24', 'returned', '2025-08-24 06:22:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'member',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`) VALUES
(1, 'Admin User', 'admin@example.com', 'adminpassword', 'admin', 'active'),
(2, 'Librarian User', 'librarian@example.com', 'librarianpassword', 'librarian', 'active'),
(3, 'Kaveesha Sewmini', 'kaveesh2000@gmail.com', 'kaveesha2000', 'member', 'active'),
(5, 'Rashini Dilmini', 'rashini2006@gmail.com', 'rashini2006', 'member', 'active'),
(6, 'Dileka Nethmini', 'dileka2003@gmail.com', '$2y$10$qLwSgapBDt0G.U5RMIFnCOYAnjWSTjc3W5n2bIA.7U4uROxxE6The', 'member', 'active'),
(7, 'Pawani Shehara', 'pawani2005@gmail.com', '$2y$10$U/ujbfir8kLVMXJM4anMxO8sJPcU3pQIExfL6PPHABCtYa3OPfz3i', 'user', 'active');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
