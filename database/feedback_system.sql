-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2020 at 04:10 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `feedback_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`id`, `question_id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Answer 1', 1, '2020-08-21 14:55:59', '2020-08-21 14:55:59', NULL),
(2, 1, 'Answer 2', 1, '2020-08-21 14:55:59', '2020-08-21 14:55:59', NULL),
(3, 1, 'Answer 3', 1, '2020-08-21 14:55:59', '2020-08-21 14:55:59', NULL),
(4, 2, 'q2 Answer 1', 1, '2020-08-21 14:55:59', '2020-08-21 14:55:59', NULL),
(5, 2, 'q2 Answer 2', 1, '2020-08-21 14:55:59', '2020-08-21 14:55:59', NULL),
(6, 2, 'q2 Answer 3', 1, '2020-08-21 14:55:59', '2020-08-21 14:55:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'This is the question 1', 1, '2020-08-21 14:54:49', '0000-00-00 00:00:00', NULL),
(2, 'This is the question 2', 1, '2020-08-21 14:54:49', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test@gmail.com', 1, '2020-08-22 12:53:08', '2020-08-22 12:53:08', NULL),
(2, 'test2@gmail.com', 1, '2020-08-22 12:55:10', '2020-08-22 12:55:10', NULL),
(3, 'test3@gmail.com', 1, '2020-08-22 13:27:59', '2020-08-22 13:27:59', NULL),
(4, 'test4@gmail.com', 1, '2020-08-22 13:29:16', '2020-08-22 13:29:16', NULL),
(5, 'test5@gmail.com', 1, '2020-08-22 13:47:03', '2020-08-22 13:47:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_answer`
--

CREATE TABLE `user_answer` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_answer`
--

INSERT INTO `user_answer` (`id`, `user_id`, `question_id`, `answer_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, 1, '2020-08-22 12:53:12', '2020-08-22 12:53:12', NULL),
(2, 1, 2, 4, 1, '2020-08-22 12:53:13', '2020-08-22 12:53:13', NULL),
(3, 2, 1, 1, 1, '2020-08-22 12:55:21', '2020-08-22 12:55:21', NULL),
(4, 2, 2, 5, 1, '2020-08-22 12:55:21', '2020-08-22 12:55:21', NULL),
(5, 3, 1, 3, 1, '2020-08-22 13:28:04', '2020-08-22 13:28:04', NULL),
(6, 3, 2, 5, 1, '2020-08-22 13:28:05', '2020-08-22 13:28:05', NULL),
(7, 4, 1, 3, 1, '2020-08-22 13:29:37', '2020-08-22 13:29:37', NULL),
(8, 4, 2, 6, 1, '2020-08-22 13:29:37', '2020-08-22 13:29:37', NULL),
(9, 5, 1, 1, 1, '2020-08-22 13:47:38', '2020-08-22 13:47:38', NULL),
(10, 5, 2, 5, 1, '2020-08-22 13:47:39', '2020-08-22 13:47:39', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_answer`
--
ALTER TABLE `user_answer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_answer`
--
ALTER TABLE `user_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
