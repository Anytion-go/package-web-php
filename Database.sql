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

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`id`, `atk`, `def`, `date`) VALUES
(32, 'mina', 'nawasan', '2022/07/31 12:59:21'),
(45, 'nawasan', 'mina', '2022/08/21 05:29:49');

-- --------------------------------------------------------

--
-- Table structure for table `logined`
--

CREATE TABLE `logined` (
  `id` int(11) NOT NULL,
  `token1` varchar(40) NOT NULL,
  `token2` varchar(40) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logined`
--

INSERT INTO `logined` (`id`, `token1`, `token2`, `user_id`, `date`) VALUES
(73, 'bb283d6efcea493fd4cbb1038b2f7c4d29c69827', 'e4f45aacc5707930b8e9068fe9c5e690463556b5', 4, '2022/08/31 15:58:21');

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

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

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`id`, `name`, `descript`, `github`, `installer`, `dev`, `date`, `modif`, `type`, `download`) VALUES
(3, 'php-spa', 'template single page for php', 'https://github.com/Arikato111/PHP_SPA', 'https://github.com/Arikato111/PHP_SPA/tree/Release3.0', 'nawasan', '2022/07/29 16:36:23', '2022/08/21 04:20:49', 2, 33),
(10, 'wisios', 'การส่งคำขอ api ด้วย php', 'https://github.com/Arikato111/wisios', 'https://github.com/Arikato111/wisios/tree/master', 'nawasan', '2022/07/30 17:43:52', '2022/08/01 15:27:38', 1, 45),
(11, 'wisit-express', 'module ที่ช่วยในการเขียน api', 'https://github.com/Arikato111/wisit-express', 'https://github.com/Arikato111/wisit-express/tree/Release1.0', 'nawasan', '2022/07/30 17:45:03', '2022/08/01 15:35:54', 1, 11),
(12, 'nexit', 'module nexit from nexit-app @template', 'https://github.com/Arikato111/NEXIT/tree/module', 'https://github.com/Arikato111/NEXIT/tree/module', 'nawasan', '2022/07/30 17:59:28', '2022/08/01 15:39:56', 1, 2),
(13, 'nexit-app', 'template for php. multi-page and dynamic route', 'https://github.com/Arikato111/NEXIT', 'https://github.com/Arikato111/NEXIT/tree/Release2.0', 'nawasan', '2022/07/30 18:00:19', '2022/08/01 15:39:04', 2, 15),
(14, 'use-import', 'for php , เพื่อใช้ import  แทน require ', 'https://github.com/Arikato111/use-import', 'https://github.com/Arikato111/use-import/tree/master', 'nawasan', '2022/07/30 18:04:47', '2022/08/01 15:38:45', 1, 29),
(15, 'wisit-router', 'สามารถทำ dynamic route แล้วก็ อื่น ๆ \r\nmodule from php-spa @template', 'https://github.com/Arikato111/wisit-router', 'https://github.com/Arikato111/wisit-router/tree/master', 'nawasan', '2022/07/30 18:08:10', '2022/08/01 15:38:26', 1, 14),
(16, 'preact-app', 'template for php', 'https://github.com/Arikato111/preact', 'https://github.com/Arikato111/preact/tree/master', 'nawasan', '2022/07/30 18:16:28', '2022/08/01 15:35:23', 2, 41),
(17, 'control', 'สำหรับใช้ในการจัดการ module & template  \r\n**ดูวิธีใช้งานและติดตั้งที่ github ', 'https://github.com/Arikato111/control', 'https://github.com/Arikato111/control/tree/master', 'nawasan', '2022/07/30 18:51:10', '2022/08/01 15:26:56', 1, 557555);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

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

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `descript`, `question`, `answer`, `date`, `follow`) VALUES
(4, 'nawasan', 'nawasan', '43eb0bd4cfe225234b9db19f428f8a13', 'just register', 'just register', '587e953993f49790e15d8481d22a6338', '2022/07/28 17:32:18', 1),
(8, 'mina', 'mina', '429083caf67c361a5aa1643369bd710d', 'test register', 'mina', '3ae4c7af29d2a62a8c58aca5dba47488', '2022/07/30 12:38:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vertion`
--

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

--
-- Dumping data for table `vertion`
--

INSERT INTO `vertion` (`id`, `package_name`, `version`, `descript`, `github`, `installer`, `date`, `modif`, `type`) VALUES
(8, 'php-spa', '2-1', 'template single page for php', 'https://github.com/Arikato111/PHP_SPA/tree/Release2.1', 'https://github.com/Arikato111/PHP_SPA/tree/Release2.1', '2022/07/30 17:07:52', '2022/08/01 15:29:23', 2),
(10, 'nexit-app', '1-0', 'template for php. multi-page and dynamic route', 'https://github.com/Arikato111/NEXIT/tree/Release1.0', 'https://github.com/Arikato111/NEXIT/tree/Release1.0', '2022/07/30 18:07:03', '2022/08/01 15:39:24', 2),
(11, 'wisit-express', 'type', 'เขียนในรูปแบบ class สำหรับการทำ api', 'https://github.com/Arikato111/wisit-express/tree/type', 'https://github.com/Arikato111/wisit-express/tree/type', '2022/08/01 15:08:30', '2022/08/01 15:08:30', 1),
(14, 'php-spa', 'simple', 'เวอร์ชั่นที่เน้นการใช้ง่ายเป็นหลัก', 'https://github.com/Arikato111/PHP_SPA/tree/simple', 'https://github.com/Arikato111/PHP_SPA/tree/simple', '2022/08/09 13:08:59', '2022/08/09 13:08:59', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logined`
--
ALTER TABLE `logined`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vertion`
--
ALTER TABLE `vertion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `logined`
--
ALTER TABLE `logined`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vertion`
--
ALTER TABLE `vertion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;