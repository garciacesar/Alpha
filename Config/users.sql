-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 05, 2017 at 01:47 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "-03:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twohills`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'auto incrementing id, unique index',
  `username` varchar(64) DEFAULT NULL COMMENT 'user username, unique',
  `firstname` varchar(64) DEFAULT NULL COMMENT 'user firstname',
  `surname` varchar(64) DEFAULT NULL COMMENT 'user surname',
  `sex` varchar(1) DEFAULT NULL COMMENT 'user sex',
  `birthday` date DEFAULT NULL COMMENT 'user birthday',
  `password_hash` varchar(255) NOT NULL COMMENT 'user''s password in salted and hashed format',
  `email` varchar(64) NOT NULL COMMENT 'user''s email, unique',
  `active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s activation status',
  `level` tinyint(1) NOT NULL DEFAULT '0',
  `activation_hash` varchar(40) DEFAULT NULL COMMENT 'user''s email verification hash string',
  `password_reset_hash` char(40) DEFAULT NULL COMMENT 'user''s password reset code',
  `password_reset_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the password reset request',
  `rememberme_token` varchar(64) DEFAULT NULL COMMENT 'user''s remember-me cookie token',
  `failed_logins` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s failed login attemps',
  `last_failed_login` int(10) DEFAULT NULL COMMENT 'unix timestamp of last failed login attempt',
  `registration_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `registration_ip` varchar(39) NOT NULL DEFAULT '0.0.0.0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='user data';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id, unique index';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
