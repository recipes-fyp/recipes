-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 13, 2018 at 09:41 PM
-- Server version: 5.6.34-log
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipes`
--

-- --------------------------------------------------------

--
-- Table structure for table `coll`
--

DROP TABLE IF EXISTS `coll`;
CREATE TABLE `coll` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_shared` tinyint(1) DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coll`
--

INSERT INTO `coll` (`id`, `user_id`, `title`, `is_shared`, `is_public`, `created`) VALUES
(4, 1, 'A simple collection', 0, 1, NULL),
(5, 1, 'Another simple collection', 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `comment` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `recipe_id`, `user_id`, `created`, `comment`) VALUES
(1, 6, 2, '2018-05-13 13:55:57', 'this is a comment as well'),
(2, 6, 2, '2018-05-13 13:56:58', 'this is a comment'),
(3, 6, 2, '2018-05-13 13:57:48', 'this is a comment'),
(4, 6, 2, '2018-05-13 13:59:26', 'this is a comment'),
(5, 3, 2, '2018-05-13 15:12:13', 'THis is a new comment...more'),
(6, 3, 2, '2018-05-13 15:16:25', 'another comment'),
(7, 5, 1, '2018-05-13 19:51:52', 'This is a conment');

-- --------------------------------------------------------

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20180508154046'),
('20180511135820'),
('20180513103036'),
('20180513152202'),
('20180513153047'),
('20180513153827'),
('20180513161028'),
('20180513175718');

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

DROP TABLE IF EXISTS `recipe`;
CREATE TABLE `recipe` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `steps` text COLLATE utf8mb4_unicode_ci,
  `ingredients` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `is_public` tinyint(1) DEFAULT NULL,
  `is_shared` tinyint(1) DEFAULT NULL,
  `coll_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`id`, `title`, `summary`, `created`, `steps`, `ingredients`, `user_id`, `is_public`, `is_shared`, `coll_id`) VALUES
(1, 'Scrambled Eggs', 'The old breakfast classic - Scrambled Eggs', '2018-05-13 08:21:45', 'Break half dozen eggs into a bowl\r\nAdd 1/4 pint of cream\r\nAdd a pinch of salt and pepper to season\r\nWhisk gently until frothy\r\nAdd a knob of butter to a gently heated pot\r\nAdd whisked eggs to pot\r\nStir gently using a wooden spoon/spatula ensuring eggs do not stick to bottom of pot\r\nRemove eggs onto plate when golden yellow and still slightly moist\r\nServe', '6 eggs\r\n1/4 (100ml) pint cream\r\nsalt and pepper\r\nknob (2g) butter', 1, 1, 1, NULL),
(3, 'Scrambled Eggs', 'The old breakfast classic - Scrambled Eggs', '2018-05-13 08:22:06', '1. Break half dozen eggs into a bowl\r\n				2. Add 1/4 pint of cream\r\n				3. Add a pinch of salt and pepper to season\r\n				4. Whisk gently until frothy\r\n				5. Add a knob of butter to a gently heated pot\r\n				6. Add whisked eggs to pot\r\n				7. Stir gently using a wooden spoon/spatula ensuring eggs do not stick to bottom of pot\r\n				8. Remove eggs onto plate when golden yellow and still slightly moist\r\n				9. Serve', '6 eggs\r\n				1/4 (100ml) pint cream\r\n				salt and pepper\r\n				knob (2g) botter', 1, 0, 1, 5),
(4, 'New Recipe', 'This is a new Recipe', '2018-05-13 08:22:27', 'No idea', 'Nothing but love', 1, 0, 0, 4),
(5, 'Another Recipe', 'Yet another receipe', '2018-05-13 18:19:21', 'bugger all', 'bugger all', 1, 0, 0, 4),
(6, 'New Admin', 'New admin recipe', '2018-05-13 08:19:18', 'none', 'none', 2, 1, 1, NULL),
(7, 'Yet another recipe', 'Something delicate', '2018-05-13 08:05:07', 'add water', 'water', 2, 1, 1, NULL),
(8, 'This is the recipe', 'Mofre details', '2018-05-13 21:03:22', 'more steps', 'more ingredients', 1, 0, 0, 4),
(9, 'This is the recipe', 'Mofre details', '2018-05-13 21:06:40', 'more steps', 'more ingredients', 1, 0, 0, 4),
(10, 'This is the recipe', 'Mofre details', '2018-05-13 21:08:26', 'more steps', 'more ingredients', 1, 0, 0, 4),
(11, 'This is the recipe', 'Mofre details', '2018-05-13 21:08:35', 'more steps', 'more ingredients', 1, 0, 0, 4),
(12, 'Simple recipe', 'This is part pof simple collection', '2018-05-13 21:09:57', 'steps', 'things', 1, 0, 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `is_admin`) VALUES
(1, 'Eamole', 'eamole', 'eamole@hotmail.com', 'eamole@hotmail.com', 1, NULL, '$2y$13$8Sl8iceCRcuZ2XjLwGniu.gxCbUyzQDd.F9vseoHXi8nrD50m5yUS', '2018-05-13 20:39:23', 'EirPHM370oinkLltgIfkC6uO71uioe0HE5cz6698S1o', '2018-05-12 19:00:16', 'a:0:{}', 0),
(2, 'admin', 'admin', 'another@here.com', 'another@here.com', 1, NULL, '$2y$13$NDii6b24DMVLxwdE1wFP..5vyUltXnLbBt4Ark7TTYOT4gDF.scMW', '2018-05-13 13:55:16', NULL, NULL, 'a:0:{}', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coll`
--
ALTER TABLE `coll`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FC4D6532A76ED395` (`user_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526C59D8A214` (`recipe_id`),
  ADD KEY `IDX_9474526CA76ED395` (`user_id`);

--
-- Indexes for table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DA88B137A76ED395` (`user_id`),
  ADD KEY `IDX_DA88B1376AA2FA5C` (`coll_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_8D93D649C05FB297` (`confirmation_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coll`
--
ALTER TABLE `coll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `coll`
--
ALTER TABLE `coll`
  ADD CONSTRAINT `FK_FC4D6532A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C59D8A214` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`),
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `FK_DA88B1376AA2FA5C` FOREIGN KEY (`coll_id`) REFERENCES `coll` (`id`),
  ADD CONSTRAINT `FK_DA88B137A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
