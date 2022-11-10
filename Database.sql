-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2022 at 04:40 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anytionc_package`
--

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `id` int(11) NOT NULL,
  `atk` varchar(50) NOT NULL,
  `def` varchar(50) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `logined` (
  `id` int(11) NOT NULL,
  `token1` varchar(40) NOT NULL,
  `token2` varchar(40) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `package` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `descript` text NOT NULL,
  `github` varchar(120) NOT NULL,
  `installer` varchar(120) NOT NULL,
  `dev` varchar(50) NOT NULL,
  `date` varchar(20) NOT NULL,
  `modif` varchar(20) NOT NULL,
  `type` int(1) NOT NULL,
  `download` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `descript` text NOT NULL,
  `question` varchar(50) NOT NULL,
  `answer` varchar(50) NOT NULL,
  `date` varchar(20) NOT NULL,
  `follow` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `vertion` (
  `id` int(11) NOT NULL,
  `package_name` varchar(50) NOT NULL,
  `version` varchar(50) NOT NULL,
  `descript` text NOT NULL,
  `github` varchar(120) NOT NULL,
  `installer` varchar(120) NOT NULL,
  `date` varchar(20) NOT NULL,
  `modif` varchar(20) NOT NULL,
  `type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `follow`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `logined`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `package`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `vertion`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

ALTER TABLE `logined`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

ALTER TABLE `package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `vertion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;