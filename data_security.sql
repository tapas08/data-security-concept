-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 28, 2015 at 09:38 PM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `data_security`
--
CREATE DATABASE IF NOT EXISTS `data_security` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `data_security`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(10) COLLATE utf8_bin NOT NULL,
  `full_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(64) COLLATE utf8_bin NOT NULL,
  `unique_id` varchar(32) COLLATE utf8_bin NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `email`, `password`, `unique_id`, `date`) VALUES
(1, 'tapas', 'chiranjeev tapas', 'tapas@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '553fdb18c36ea', '0000-00-00'),
(2, 'kaka', 'Ricardo Kaka', 'kaka@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '553fdf54b2c9c', '0000-00-00'),
(3, 'abcd', 'abcd xyz', 'abcd@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '553fdf810fb12', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `_table`
--

CREATE TABLE IF NOT EXISTS `_table` (
`id` int(11) NOT NULL,
  `_column_1` varchar(64) COLLATE utf8_bin NOT NULL,
  `_column_2` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `_table`
--

INSERT INTO `_table` (`id`, `_column_1`, `_column_2`) VALUES
(1, 'c708a161c2fd4be9eaf82075f0253608e73efb8eea651845964ec8debb658f52', '78eb355f8ea0ed02ea644c0cd0168c0078be23cd6d04a71a51d99f008843f187'),
(2, '3a38f42cfb8f4ad7419c4c4a5bdbbf2f447ebf05d6dce5de5daa670469dc0e56', '78eb355f8ea0ed02ea644c0cd0168c0078be23cd6d04a71a51d99f008843f187'),
(3, '88d4266fd4e6338d13b845fcf289579d209c897823b9217da3e161936f031589', '78eb355f8ea0ed02ea644c0cd0168c0078be23cd6d04a71a51d99f008843f187'),
(4, '01a427f3b4b8a6770c85373c65320e4b5aa9eeddd591d84859574024175c85e0', 'f4ce002f3d2e3f692ace1a69a74d1fadc018d891e3b690795fa11f5c5fb589af');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `_table`
--
ALTER TABLE `_table`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `_table`
--
ALTER TABLE `_table`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
