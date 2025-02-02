-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 02, 2025 at 11:24 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baby`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `childId` varchar(100) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `description` text NOT NULL,
  `comment` text NOT NULL,
  `eventId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

CREATE TABLE `children` (
  `id` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `parentId` varchar(50) NOT NULL,
  `babysitterId` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`id`, `name`, `age`, `parentId`, `babysitterId`) VALUES
('child_679b550f7d835', 'Kaloyan', 7, 'parent_679b544b37973', 'babysitter_679b558f4fefb'),
('child_679de678e2ce6', 'Valeriq', 3, 'parent_679b544b37973', 'babysitter_679b558f4fefb'),
('child_679de69923800', 'Gabriela', 10, 'parent_679b544b37973', 'babysitter_679b558f4fefb'),
('child_679dedcaa2ee2', 'Valeri', 2, 'parent_679de60125fff', 'babysitter_679ce81b1e3e4'),
('child_679dedd3b15b4', 'Simona', 5, 'parent_679de60125fff', 'babysitter_679ce81b1e3e4'),
('child_679e3855ad05f', 'Anji', 1, 'parent_679b544b37973', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `parent_id` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `babysitter_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(50) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('parent','babysitter') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `address`, `phone`, `name`, `email`, `password`, `user_type`, `created_at`) VALUES
('babysitter_679b558f4fefb', 'Vanya', 'Sofia, Bulgaria', '0888269093', 'vanya1', 'vanya@gmail.com', '1d7af611dfd8a878cc89e9cbccf5ecf7', 'babysitter', '2025-01-30 10:33:51'),
('babysitter_679ce81b1e3e4', 'Maya Krumova', 'Plovdiv', '0888269090', 'maya123', 'maycheto@gmail.com', '590977db994d963adf27159282478f39', 'babysitter', '2025-01-31 15:11:23'),
('babysitter_679f872db6d04', 'Stefan Manolov', 'Ruse', '0888223311', 'stefanmanolov', 'stefanman@gmail.com', '1a4825cb2528c4e08986cd398132c3de', 'babysitter', '2025-02-02 14:54:37'),
('parent_679b544b37973', 'Nikol Kirova', 'Sofia, Bulgaria', '0888269094', 'nikolkirova1', 'nikolkirova@gmail.com', '6848d756da66e55b42f79c0728e351ad', 'parent', '2025-01-30 10:28:27'),
('parent_679de60125fff', 'Yoana Koleva', 'Sofia', '0888269092', 'yoana12', 'yoana9@gmail.com', 'c8fb8e853285d4825fe81c1447b151d3', 'parent', '2025-02-01 09:14:41'),
('parent_679e5f84e4cc1', 'Mihail Stoev', 'Varna', '0888269098', 'mihailstoev', 'mihail@gmail.com', 'ef60bdbe27807a01c1babfeaf8d2ec63', 'parent', '2025-02-01 17:53:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD KEY `eventId` (`eventId`);

--
-- Indexes for table `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parentId` (`parentId`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calendar`
--
ALTER TABLE `calendar`
  ADD CONSTRAINT `calendar_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `events` (`event_id`);

--
-- Constraints for table `children`
--
ALTER TABLE `children`
  ADD CONSTRAINT `children_ibfk_1` FOREIGN KEY (`parentId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
